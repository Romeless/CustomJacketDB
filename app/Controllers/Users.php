<?php

namespace App\Controllers;

class Users extends BaseController
{
    protected $modelName = 'App\Models\UsersModel';
    protected $format = 'json';

    public function __construct()
    {
        $this->model = model('App\Models\UsersModel');
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

    public function login()
    {

        $login = $this->request->getPost();
        $validate = $this->validation->run($login, 'login');
        $errors = $this->validation->getErrors();
        
        $model = model('App\Models\LoginModel', false);

        $credentials = $model->findByUsername($login['username']);

        if($credentials)
        {
            if ($login['username'] != $credentials['username'])
            {
                return $this->fail('something went wrong');
            }

            if (!password_verify($login['password'], $credentials['password']))
            {
                return $this->fail('WrongPassword '.$login['password']);
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