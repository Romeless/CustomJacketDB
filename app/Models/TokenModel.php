<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'token';

    protected $allowedFields = [
        'userID', 'device', 'createDate', 'expireDate'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;
    
    public function findByToken($token)
    {
        $data = $this->find($token);

        if($data)
        {
            return $data;
        }

        return false;
    }

    public function findByUserID($userID)
    {
        $sql = "SELECT * FROM tokens WHERE userID = ?";

        if($result = $this->db->query($sql, [$userID]))
        {
            return $result->getResult();
        } 
    }
}