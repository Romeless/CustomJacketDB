<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username', 'fullName', 'email', 'address', 'phoneNumber', 'joinDate',
    ];
    protected $returnType = 'App\Entities\Users';
    protected $useTimestamps = false;
    

    public function getLoginCredentialsById($id)
    {
        $sql = "SELECT username, password, salt FROM users WHERE id = ?";
        
        if($result = $this->db->query($sql, [$id]))
        {
            return $result->getResult();
        } 
    }

    public function findById($id)
    {
        $data = $this->find($id);

        if($data)
        {
            return $data;
        }

        return false;
    }

    public function findByUserName($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        
        if($result = $this->db->query($sql, [$username]))
        {
            return $result->getResultArray();
        } 
    }
}