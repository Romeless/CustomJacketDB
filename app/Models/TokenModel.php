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
        $sql = "SELECT $userID FROM userID";
        
        if($result = mysqli_query($this->db, $sql))
        {
            return $result;
        } else
        {
            return 0;
        }
    }
}