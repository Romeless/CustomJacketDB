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
        return $this->respond($this->model->findAllWithName());
    }

    public function indexShareable($id = null)
    {
        if (isset($id))
        {
            return $this->respond($this->model->findShareable($id));
        }
        
        return $this->respond($this->model->findAllShareable());
    }

    public function create()
    {
        $data = $this->request->getPost();
        
        $validate = $this->validation->run($data, 'design_validation');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $data['createDate'] = date(DATE_FORMAT);
        $data['updateDate'] = date(DATE_FORMAT);

        if($this->model->save($data))
        {
            return $this->respondCreated($data, 'Design Created');
        }
    }

    public function update($id = null)
    {

        if(!$this->model->findById($id))
        {
            return $this->failNotFound('Design id tidak ditemukan');
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;
        $data['updateDate'] = date(DATE_FORMAT);
        if (!isset($data['token']))
        {
            
            $data['token'] = "TOKENWHATSTHAT";
        }

        $validate = $this->validation->run($data, 'design_update');
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
                return $this->respondUpdated($data, 'Design Updated');
            }
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini". $tokenConfirmation . " - " . $roleConfirmation);
    }

    public function remove($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->fail('Design ID not Found');
        }

        $data = $this->request->getRawInput();;
        $data['id'] = $id;
        
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
                return $this->respondUpdated($data, 'Design Removed');
            }

            return $this->fail('Design gagal dirubah');
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini");
    }

    public function delete($id = null)
    {
        if(!$this->model->findById($id))
        {
            return $this->fail('Design id tidak ditemukan');
        }

        $data = $this->request->getRawInput();;
        $data['id'] = $id;

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

        if ($tokenConfirmation)
        {
            if($this->model->delete($id))
            {
                return $this->respondDeleted('Design Id '.$id.' Deleted');
            }

            return $this->fail("Design gagal dihapus");
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