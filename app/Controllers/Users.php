<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UsersModel';
    protected $format = 'json';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    // JANGAN LUPA UPDATE VALIDATION SESUAI GOOGLE JUGA

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'register');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        $user = new \App\Entities\Users();
        $user->fill($data);
        $user->joinDate = date(DATE_FORMAT);

        if($this->model->save($user))
        {
            return $this->respond($user);
        }
    }

    public function google_auth()
    {
        header("Access-Control-Allow-Origin: https://hudie-custom.herokuapp.com/");
        header("Access-Control-Allow-Credentials: true");

        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'google_auth');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        // require_once ROOTPATH . 'vendor/autoload.php';

        $id_token = $data['tokenID'];

        // $client = new Google_Client(['client_id' => "334821050843-7ibsrhu7b07inds7n1rvcaj6u2bkp2co.apps.googleusercontent.com"]);  // Specify the CLIENT_ID of the app that accesses the backend
        // $payload = $client->verifyIdToken($id_token);

        $payload = [];
        $payload['sub'] = $data['googleID'];
        
        if ($payload) {

            if($user = $this->model->findByColumn(["tokenID"], [$id_token]))
            {
                $user = $user[0];
                $response = $this->auth($user);

                return $this->respond($response);
            }

            $userid = $payload['sub'];
            
            $user = new \App\Entities\Users();
            $user->fill($data);

            $email_parts = explode('@', $data['email']);

            $user->username = $email_parts[0].$userid;
            $user->joinDate = date(DATE_FORMAT);

            if($this->model->save($user))
            {
                return $this->respond($user);
            }

        } else {
            error_log(print_r($payload));
            return $this->fail("Token ID Authentication Fails");
        }
    }

    public function update($id = null)
    {

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        error_log(print_r($data));
        $validate = $this->validation->run($data, 'update_user');
        $errors = $this->validation->getErrors();

        if($errors)
        {
            return $this->fail($errors);
        }

        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        $user = new \App\Entities\Users();
        $user->fill($data);

        if($this->model->save($user))
        {
            return $this->respondUpdated($user, 'User Updated');
        }

    }

    public function delete($id = null)
    {
        $data = $this->request->getRawInput();
        $data['id'] = $id;

        if(!$this->model->findById($id))
        {
            return $this->fail('id tidak ditemukan');
        }

        if($this->model->delete($id)){
            return $this->respondDeleted('Id '.$id.' Deleted');
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

    public function getByUsername()
    {
        $data = $this->request->getPost();
        $username = $data['username'];

        if($cred = $this->model->findByUserName($username))
        {
            return $this->respond($cred);
        }
        
        return $this->fail('errors');
    }

    public function login()
    {

        $login = $this->request->getPost();
        $validate = $this->validation->run($login, 'login');
        $errors = $this->validation->getErrors();

        if ($error)
        {
            return $this->fail($errors);
        }

        $response = $this->auth($login);

        return $this->respond($response);
    }

    private function auth($data)
    {
        // $data
        // -> id
        // -> username

        error_log(print_r($data));

        if($credentials = $this->model->findByColumn(['username'], [$data['username']]))
        {
            $credentials = $credentials[0];
        } else
        {
            error_log(print_r($this->model->findByColumn(['username'], [$data['username']])));
            return "ERROR USERNAME NOT FOUND";
        }
        

        if(isset($data['device']))
        {
            $device = $data['device'];
        } else
        {
            $device = "n/a";
        }

        if($credentials)
        {
            if ($data['username'] != $credentials['username'])
            {
                return $this->fail('Something went Wrong');
            }

            if (!password_verify($data['password'], $credentials['password']))
            {
                return $this->fail('Wrong Password '.$data['password']);
            }

            $token = $this->generateToken();
            $tokenStatus = $this->refreshToken($credentials, $token, $device);

            return $tokenStatus;
        }

        return "ERROR CREDENTIALS WRONG";
    }

    private function refreshToken($credentials, $token, $device)
    {
        $model = model('App\Models\TokensModel');
        
        $token_cred = [];
        
        if ($token_cred = $model->findByUserIdAndDevice($credentials['id'], $device))
        {
            $token_cred = $token_cred[0];
        }

        $token_cred['token'] = $token['token'];
        $token_cred['userID'] = $credentials['id'];
        $token_cred['device'] = $device;
        $token_cred['createDate'] = date(DATE_FORMAT);
        $token_cred['expireDate'] = date(DATE_FORMAT);

        if ($model->save($token_cred))
        {
            return $this->respondUpdated($token_cred, 'Token Updated');
        }
    }

    private function generateToken($length = 60)
    {
        return ['token' => bin2hex(random_bytes($length))];
    }

}