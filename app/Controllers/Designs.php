<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
        error_log("design index");
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        error_log("design create");

        $data = $this->request->getPost();
        
        error_log("Data: ");
        file_put_contents("php://stderr", print_r($data, true));
        
        $validate = $this->validation->run($data, 'design_validation');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $data->createDate = date(DATE_FORMAT);
        $data->updateDate = date(DATE_FORMAT);

        file_put_contents("php://stderr", print_r($data, true));

        if($this->model->save($design))
        {
            return $this->respondCreated($design, 'Design Created');
        }
    }

    public function update($id = null)
    {

        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $validate = $this->validation->run($data, 'design_validation');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        if(!$this->model->findById($id))
        {
            return $this->fail('design id tidak ditemukan');
        }

        $design = new \App\Entities\Designs();
        $design->fill($data);

        if($this->model->save($design))
        {
            return $this->respondUpdated($design, 'Design Updated');
        }

    }

    public function delete($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        if($this->model->delete($id)){
            return $this->respondDeleted('Design Id '.$id.' Deleted');
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
}