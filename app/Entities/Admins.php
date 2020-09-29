<?php

namespace App\Entities;
use CodeIgniter\Entity;

class Admins extends Entity
{
    public function setPassword(string $pass)
    {
        $salt = uniqid('',true);
        $this->attributes['salt'] = $salt;
        $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT, [$salt]);

        return $this;
    }
}