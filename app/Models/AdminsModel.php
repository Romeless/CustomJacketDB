<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminsModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'role', 'password', 'salt', 'avatar', 'email', "phoneNumber", "joinDate", "lastLogin", "ip"
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;
}
