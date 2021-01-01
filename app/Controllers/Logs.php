<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Logs extends ResourceController
{
  protected $modelName = 'App\Models\LogsModel';
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
      $validate = $this->validation->run($data, 'log_action');
      $errors = $this->validation->getErrors();

      if ($errors) {
          return $this->fail($errors);
      }

      if ($this->model->save($data)) {
          return $this->respondCreated($data);
      }

      return $this->fail('Log gagal dibuat');
  }

  public function update($id = null)
  {
    if(!$this->model->findById($id))
    {
        return $this->failNotFound('Log id tidak ditemukan');
    }

    $data = $this->request->getRawInput();
    $data['id'] = $id;

    $validate = $this->validation->run($data, 'log_action');
    $errors = $this->validation->getErrors();

    if($this->model->save($data))
    {
        return $this->respondUpdated($data, 'Log Updated');
    }

    return $this->fail('Log gagal dirubah');
  }

  public function delete($id = null)
  {
    if($this->model->delete($id))
    {
        return $this->respondDeleted('Log Id '.$id.' Deleted');
    }

    return $this->fail('Log gagal dihapus');
  }

  public function remove($id = null)
  {
    if(!$this->model->findById($id))
    {
        return $this->fail('Log id tidak ditemukan');
    }

    $data['id'] = $id;
    $data['userID'] = null;

    if($this->model->save($data))
    {
        return $this->respondUpdated($data, 'Log Updated');
    }

    return $this->fail('Log gagal dirubah');
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
}
