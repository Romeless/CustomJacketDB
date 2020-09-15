<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'username';
    
    protected $allowedFields = [
        'username', 'password', 'salt',
    ];


    public function findByUsername($username)
    {
        $data = $this->find($username);

        if($data)
        {
            return $data;
        }

        return false;
    }
}