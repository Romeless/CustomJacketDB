<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Orders extends ResourceController
{
    protected $modelName = 'App\Models\OrdersModel';
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

        $validate = $this->validation->run($data, 'order_validation');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $userModel = model('App\Models\UsersModel');
        $userData = $userModel->findById($data['userID']);
        $userData = json_decode(json_encode($userData),true);

        if(!isset($data['address']))
        {
            $data['address'] = $userData['address'];
        }

        if(!isset($data['phoneNumber']))
        {
            $data['phoneNumber'] = $userData['phoneNumber'];
        }

        $data['username'] = $userData['username'];
        $data['email'] = $userData['email'];

        if($this->model->save($data))
        {
            return $this->respondCreated($data, 'Order Created');
        }
    }

    public function update($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->failNotFound('Order id tidak ditemukan');
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $design = $this->model->findById($id);
        $data['userID'] = $design['userID'];

        if (!isset($data['token']))
        {

            $data['token'] = "TOKENWHATSTHAT";
        }

        $validate = $this->validation->run($data, 'order_update');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $roleConfirmation = $this->confirmRole($data);

        if ($roleConfirmation)
        {
            $tokenConfirmation = true;
        } else {
            $tokenConfirmation = $this->confirmToken($data);
        }

        if ($tokenConfirmation)
        {
            if($this->model->save($data))
            {
                return $this->respondUpdated($data, 'Order Updated');
            }

            return $this->fail('Order gagal dirubah');
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini");
    }

    public function delete($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $design = $this->model->findById($id);
        $data['userID'] = $design['userID'];

        if (!isset($data['token']))
        {

            $data['token'] = "TOKENWHATSTHAT";
        }

        $roleConfirmation = $this->confirmRole($data);

        if ($roleConfirmation)
        {
            $tokenConfirmation = true;
        } else
        {
            $tokenConfirmation = $this->confirmToken($data);
        }

        if ($tokenConfirmation)
        {
            if($this->model->delete($id))
            {
                return $this->respondDeleted('Order Id '.$id.' Deleted');
            }

            return $this->fail('Order gagal dihapus');
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini");


    }

    public function remove($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->fail('Design ID not Found');
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $design = $this->model->findById($id);
        $data['userID'] = $design['userID'];

        if (!isset($data['token']))
        {

            $data['token'] = "TOKENWHATSTHAT";
        }

        $roleConfirmation = $this->confirmRole($data);

        if ($roleConfirmation)
        {
            $tokenConfirmation = true;
        } else {
            $tokenConfirmation = $this->confirmToken($data);
        }

        $data['userID'] = null;

        if ($tokenConfirmation)
        {
            if($this->model->save($data))
            {
                return $this->respondUpdated($data, 'Order Removed');
            }

            return $this->fail('Order gagal dibuang');
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini");
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

    public function showByUserID($userID)
    {
        $data = $this->model->findByUserID($userID);

        if($data)
        {
            return $this->respond($data);
        }

        return $this->fail('errors');
    }

    public function showByDesignID($designID)
    {
        $data = $this->model->findByDesignID($designID);

        if($data)
        {
            return $this->respond($data);
        }

        return $this->fail('errors');
    }

    public function showOrderDetails()
    {
        $post = $this->request->getPost();
        $userID = $post['userID'];
        $designID = $post['designID'];

        $data = $this->model->findOrderDetails($userID, $designID);

        if($data)
        {
            return $this->respond($data);
        }

        return $this->fail('errors');
    }

    private function confirmToken($data)
    {
        $tokenModel = model('App\Models\TokensModel');
        $userModel = model('App\Models\UsersModel');

        if($token_cred = $tokenModel->findByToken($data['token']))
        {

            $token_cred = $token_cred[0];

            if($token_cred['userID'] == $data['userID'])
            {
                return true;
            }

            $user = $userModel->find($token_cred['userID']);

            if($user['admin'] == 1)
            {
                return true;
            }
        }

        return false;
    }

    private function confirmRole($data)
    {

        $model = model('App\Models\UsersModel');

        if(!isset($data['editorID']))
        {

            return false;
        }

        if($cred = $model->find($data['editorID']))
        {

            if($cred['admin'] == 1)
            {
                return true;
            }
        }



        return false;
    }
}
