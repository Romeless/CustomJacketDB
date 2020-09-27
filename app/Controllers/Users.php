<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UsersModel';
    protected $format = 'json';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'register');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $user = new \App\Entities\Users();
        $user->fill($data);
        $user->joinDate = date(DATE_FORMAT);

        if($this->model->save($user))
        {
            return $this->respondCreated($user, 'User Created');
        }
    }

    public function update($id = null)
    {

        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $validate = $this->validation->run($data, 'update_user');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        $user = new \App\Entities\Users();
        $user->fill($data);

        if($this->model->save($user))
        {
            return $this->respondUpdated($user, 'User Updated');
        }

    }

    public function delete($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;
        
        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        if($this->model->delete($id)){
            return $this->respondDeleted('Id '.$id.' Deleted');
        }
    }

    public function show($id = null)
    {
        $data = $this->model->findById($id);

        if($data)
        {
            return $this->respond($data);
        }

        return $this->fail('errors');
    }

    public function getByUsername()
    {
        $data = $this->request->getPost();
        $username = $data['username'];

        if($cred = $this->model->findByUserName($username))
        {
            return $this->respond($cred);
        }
        
        return $this->fail('errors');
    }

    public function login()
    {

        $login = $this->request->getPost();
        $validate = $this->validation->run($login, 'login');
        $errors = $this->validation->getErrors();

        $credentials = $this->model->findByUsername($login['username']);
        $credentials = $credentials[0];

        if($credentials)
        {
            if ($login['username'] != $credentials['username'])
            {
                return $this->fail('Something went Wrong');
            }

            if (!password_verify($login['password'], $credentials['password']))
            {
                return $this->fail('Wrong Password '.$login['password']);
            }


            return json_encode($this->generateToken());

        }

        return $this->fail('errors');
    }

    public function generateToken($length = 60)
    {
        return ['token' => bin2hex(random_bytes($length))];
    }

}