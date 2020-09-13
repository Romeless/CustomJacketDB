<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Designs extends ResourceController
{
    protected $modelName = 'App\Models\DesignsModel';
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
        $validate = $this->validation->run($data, 'add_design');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $design = new \App\Entities\Designs();
        $design->fill($data);

        if($this->model->save($design))
        {
            return $this->respondCreated($design, 'Design Created');
        }
    }
}