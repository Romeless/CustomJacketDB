<?php

namespace App\Models;

use CodeIgniter\Model;

class TokensModel extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'token', 'userID', 'device', 'createDate', 'expireDate'
    ];

    protected $returnType = 'App\Entities\Tokens';
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
            return $result->getResultArray();
        } 
    }

    public function findByUserIDAndDevice($userID, $device)
    {
        $sql = "SELECT * FROM tokens WHERE userID = ? and device = ?";

        if($result = $this->db->query($sql, [$userID, $device]))
        {
            return $result->getResultArray();
        } 
    }
}