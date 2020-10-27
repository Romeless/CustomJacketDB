<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use Google\Client;

class Tokens extends ResourceController
{
  protected $modelName = 'App\Models\TokensModel';
  protected $format = 'json';

  public function __construct()
  {
      $this->validation = \Config\Services::validation();
  }

  public function verifyToken()
  {
    $data = $this->request->getPost();
    $validate = $this->validation->run($data, 'verify_token');
    $errors = $this->validation->getErrors();

    if($errors)
    {
      return $this->fail($errors);
    }

    $token = $data['token'];
    $email = $data['email'];

    if (isset($data['google']))
    {
      $google = $data['google'];
    } else {
      $google = 0;
    }

    if ($tokenData = $this->model->findByToken($token))
    {
      $tokenData = $tokenData[0];
    } else {
      return $this->failNotFound("Token tidak ditemukan");
    }

    $userModel = model('App\Models\UsersModel');

    if ($userData = $userModel->findByEmail($email, $google))
    {
      $userData = $userData[0];
    } else {
      return $this->failNotFound("User tidak ditemukan");
    }

    if ($tokenData['userID'] == $userData['id'])
    {
      return $this->respond($tokenData);
    } else {
      return $this->failUnauthorized("Token tidak cocok");
    }

    return $this->fail('Internal Error');

  }

  public function verifyGoogleToken()
  {
    $data = $this->request->getPost();
    $validate = $this->validation->run($data, 'verify_google_token');
    $errors = $this->validation->getErrors();

    if($errors)
    {
        return $this->fail($errors);
    }

    // Verify Token
    $id_token = $data['token'];

    $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
      $userid = $payload['sub'];

      return $this->respond($userid);
    } else {
      // Invalid ID token
    }
  }
}
