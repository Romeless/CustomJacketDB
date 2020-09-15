<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    protected $modelName = 'App\Models\LoginModel';
    protected $format = 'json';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function login($username)
    {
        $data = $this->model->findByUsername($username);

        if($data)
        {
            $credentials = [
                "username" => $data['username'],
                "password" => $data['password'],
                "salt" => $data['salt'],
            ];

            return $this->respond($credentials);
        }

        return $this->fail('errors');
    }

}