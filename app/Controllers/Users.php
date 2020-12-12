<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Google\Client;

class Users extends ResourceController
{
    protected $modelName = 'App\Models\UsersModel';
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
        $validate = $this->validation->run($data, 'register');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->fail($errors);
        }

        $user = new \App\Entities\Users();
        $user->fill($data);
        $user->joinDate = date(DATE_FORMAT);

        if ($this->model->save($user)) {
            return $this->respondCreated($user);
        }
    }

    public function login()
    {

        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'login');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->fail($errors);
        }

        if ($credentials = $this->model->findByColumn(['username'], [$data['username']])) {
            $credentials = $credentials[0];
        } else {
            return $this->failNotFound("Username tidak terdaftar");
        }

        if (!password_verify($data['password'], $credentials['password'])) {
            return $this->fail('Password salah');
        }

        if (isset($data['device'])) {
            $credentials['device'] = $data['device'];
        } else {
            $credentials['device'] = "n/a";
        }

        $token = $this->generateToken();
        $tokenStatus = $this->refreshToken($credentials, $token);

        return $this->respond($tokenStatus);
    }

    public function google_auth()
    {

        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $http_origin = $_SERVER['HTTP_ORIGIN'];
        } else {
            $http_origin = "localhost:8080";
        }


        if ($http_origin == "https://hudie-custom.herokuapp.com" || $http_origin == "https://hudiecustom.xyz" || $http_origin == "localhost:8080") {
            header("Access-Control-Allow-Origin: " . $http_origin);
        }

        header("Access-Control-Allow-Credentials: true");

        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'google_auth');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->fail($errors);
        }


        // Verify Token
        $id_token = $data['tokenID'];
        $client = new \Google_Client(['client_id' => CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($id_token);

        // ONLY FOR TESTING USE
        // $payload = [
        //     "sub" => $data['googleID'],
        // ];


        if ($payload) {


            $userid = $payload['sub'];

            if ($user = $this->model->findByColumn(["email"], [$data['email']])) {


                $user = $user[0];


                if ($user['google'] == 1) {


                    // LOGIN TO GOOGLE

                    if ($credentials = $this->model->findByColumn(['username'], [$user['username']])) {
                        $credentials = $credentials[0];
                    } else {
                        return $this->failNotFound("Username tidak terdaftar");
                    }

                    if (isset($data['device'])) {
                        $credentials['device'] = $data['device'];
                    } else {
                        $credentials['device'] = "n/a";
                    }


                    $token = array("token" => $id_token);
                    $tokenStatus = $this->refreshToken($credentials, $token);


                    return $this->respond(json_encode($tokenStatus));
                }
            }

            // REGISTER NEW ACCOUNT FROM GOOGLE

            $email_parts = explode('@', $data['email']);

            $data['username'] = $email_parts[0] . $userid;
            $data['joinDate'] = date(DATE_FORMAT);
            $data['google'] = 1;

            if (!isset($data['device'])) {
                $data['device'] = "n/a";
            }

            if ($this->model->save($data)) {

                $token = array("token" => $id_token);
                $tokenStatus = $this->refreshToken($data, $token);

                return $this->respondCreated(json_encode($tokenStatus), "Akun berhasil terbuat");
            }
            return $this->fail("Akun baru tidak berhasil dibuat");
        } else {

            return $this->fail("Akun google gagal di-verifikasi");
        }
    }

    public function google_auth_mobile()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'google_auth');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->fail($errors);
        }

        // Verify Token
        $id_token = $data['tokenID'];
        $client = new \Google_Client(['client_id' => CLIENT_ID_APP]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($id_token);
        // ONLY FOR TESTING USEa
        // $payload = [
        //     "sub" => $data['googleID'],
        // ];$aya

        if ($payload) {
            $userid = $payload['sub'];

            if ($user = $this->model->findByColumn(["email"], [$data['email']])) {
                $user = $user[0];
                if ($user['google'] == 1) {
                    // LOGIN TO GOOGLE

                    if ($credentials = $this->model->findByColumn(['username'], [$user['username']])) {
                        $credentials = $credentials[0];
                    } else {
                        return $this->failNotFound("Username tidak terdaftar");
                    }

                    if (isset($data['device'])) {
                        $credentials['device'] = $data['device'];
                    } else {
                        $credentials['device'] = "n/a";
                    }


                    $token = array("token" => $id_token);
                    $tokenStatus = $this->refreshToken($credentials, $token);

                    return $this->respond(json_encode($tokenStatus));
                }
            }


            // REGISTER NEW ACCOUNT FROM GOOGLE

            $email_parts = explode('@', $data['email']);

            $data['username'] = $email_parts[0] . $userid;
            $data['joinDate'] = date(DATE_FORMAT);
            $data['google'] = 1;
            $data['device'] = $device;

            if (!isset($data['device'])) {
                $data['device'] = "n/a";
            }

            if ($this->model->save($data)) {

                $data['id'] = $this->model->getInsertID();

                $token = array("token" => $id_token);
                $tokenStatus = $this->refreshToken($data, $token);

                return $this->respond(json_encode($tokenStatus));
            }
            return $this->fail("Akun baru tidak berhasil dibuat");
        } else {

            return $this->fail($id_token);
        }
    }

    public function update($id = null)
    {
        if (!$this->model->findById($id)) {
            return $this->failNotFound('Id tidak ditemukan');
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        if (!isset($data['token'])) {
            $data['token'] = "TOKENWHATSTHAT";
        }

        $token_validate = $this->validation->run($data, 'user_validation');
        $validate = $this->validation->run($data, 'update_user');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->fail($errors);
        }

        $roleConfirmation = $this->confirmRole($data);

        if ($roleConfirmation) {
            $tokenConfirmation = true;
        } else {
            $tokenConfirmation = $this->confirmToken($data);
        }

        if ($tokenConfirmation) {
            $user = new \App\Entities\Users();
            $user->fill($data);

            if ($this->model->save($user)) {
                return $this->respondUpdated($user, 'User profil update berhasil!');
            }
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini");
    }

    public function delete($id = null)
    {
        if (!$this->model->findById($id)) {
            return $this->failNotFound('Akun tidak ditemukan');
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        if (!isset($data['token'])) {
            $data['token'] = "TOKENWHATSTHAT";
        }

        $token_validate = $this->validation->run($data, 'user_validation');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->fail($errors);
        }

        $roleConfirmation = $this->confirmRole($data);

        if ($roleConfirmation) {
            $tokenConfirmation = true;
        } else {
            $tokenConfirmation = $this->confirmToken($data);
        }

        if ($tokenConfirmation) {
            if ($this->model->delete($id)) {
                return $this->respondDeleted('Id ' . $id . ' Terhapus');
            }
        }

        return $this->failUnauthorized("Tidak diperbolehkan melakukan operasi ini");
    }

    public function show($id = null)
    {
        $data = $this->model->findById($id);

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('User tidak ditemukan');
    }

    public function getByUsername($username = null)
    {
        if ($cred = $this->model->findByUserName($username)) {
            return $this->respond($cred);
        }

        return $this->failNotFound('User tidak ada');
    }

    private function refreshToken($credentials, $token)
    {
        $model = model('App\Models\TokensModel');

        $token_cred = [];

        if ($token_cred = $model->findByUserIdAndDevice($credentials['id'], $credentials['device'])) {
            $token_cred = $token_cred[0];
        }

        $token_cred['token'] = $token['token'];
        $token_cred['userID'] = $credentials['id'];
        $token_cred['username'] = $credentials['username'];
        $token_cred['admin'] = $credentials['admin'];
        $token_cred['device'] = $credentials['device'];
        $token_cred['createDate'] = date(DATE_FORMAT);
        $token_cred['expireDate'] = date(DATE_FORMAT);

        if ($model->save($token_cred)) {
            return $token_cred;
        }
    }

    private function generateToken($length = 60)
    {
        return ['token' => bin2hex(random_bytes($length))];
    }

    private function confirmToken($data)
    {
        $model = model('App\Models\TokensModel');

        if ($token_cred = $model->findByToken($data['token'])) {
            $token_cred = $token_cred[0];

            if ($token_cred['userID'] == $data['id']) {
                return true;
            }

            $user = $this->model->find($token_cred['userID']);

            if ($user['admin'] == 1) {
                return true;
            }
        }

        return false;
    }

    private function confirmRole($data)
    {
        if (!isset($data['editorID'])) {
            return false;
        }

        if ($cred = $this->model->find($data['editorID'])) {


            if ($cred['admin'] == 1) {
                return true;
            }
        }

        return false;
    }
}
