<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Token extends ResourceController
{
    protected $modelName = 'App\Models\TokenModel';
    protected $format = 'json';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        echo($this->model->findByUserID(1));
    }

}