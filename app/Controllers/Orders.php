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
        
        $data['username'] = $userData['username'];
        $data['email'] = $userData['email'];
        $data['phoneNumber'] = $userData['phoneNumber'];

        if($this->model->save($data))
        {
            return $this->respondCreated($data, 'Order Created');
        }
    }
}