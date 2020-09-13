<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Designs extends ResourceController
{
    protected $modelName = 'App\Models\DesignsModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }
}