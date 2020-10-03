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
        $data = $this->request->getRawInput();
        $data['id'] = $id;

        $validate = $this->validation->run($data, 'order_validation');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        if(!$this->model->findById($id))
        {
            return $this->fail('order id tidak ditemukan');
        }

        if($this->model->save($data))
        {
            return $this->respondUpdated($data, 'Order Updated');
        }

    }

    public function delete($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        if($this->model->delete($id)){
            return $this->respondDeleted('Order Id '.$id.' Deleted');
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
}