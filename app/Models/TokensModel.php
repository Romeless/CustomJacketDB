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

    function findByColumn($columns, $values, $result = null)
    {
        // $columns is an array of string specifiyng the column to search (ex. username, password)
        // $values is an array of string related to the column of same index (ex. 15, means WHERE username = 15)

        if (sizeof($columns) != sizeof($values))
        {
            return 0;
        }

        if ($result == null)
        {
            $sql = "SELECT ".$result." ";
        } else {
            $sql = "SELECT ";
            foreach($result as $rescol => $element)
            {
                if ($rescol === array_key_last($result))
                {
                    $sql = $sql.$element." ";
                } else {
                    $sql = $sql.$element.",";
                }
            }
        }

        $sql = $sql."FROM tokens WHERE ";
        
        foreach($columns as $column => $element)
        {
            $sql = $sql.$element." = ?";

            if ($column != array_key_last($columns))
            {
                $sql = $sql." AND ";
            }
        }
        
        if($result = $this->db->query($sql, $values))
        {
            return $result->getResultArray();
        } 
    }
}