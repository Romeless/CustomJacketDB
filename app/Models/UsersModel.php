<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'fullName', "tokenID", 'email', 'password', 'salt', "avatar", 'address', 'phoneNumber', "verified", 'joinDate', "lastLogin", "admin"
    ];
    protected $returnType = 'App\Entities\Users';
    protected $useTimestamps = false;

    public function findById($id)
    {
        $data = $this->find($id);

        if ($data) {
            return $data;
        }

        return false;
    }

    // Find by specified column
    function findByColumn($columns, $values, $result = null)
    {
        // $columns is an array of string specifiyng the column to search (ex. username, password)
        // $values is an array of string related to the column of same index (ex. 15, means WHERE username = 15)

        if (sizeof($columns) != sizeof($values)) {
            return 0;
        }

        if ($result == null) {
            $sql = "SELECT * ";
        } else {
            $sql = "SELECT ";
            foreach ($result as $rescol => $element) {
                if ($rescol === array_key_last($result)) {
                    $sql = $sql . $element . " ";
                } else {
                    $sql = $sql . $element . ",";
                }
            }
        }

        $sql = $sql . "FROM users WHERE ";

        foreach ($columns as $column => $element) {
            $sql = $sql . $element . " = ?";

            if ($column != array_key_last($columns)) {
                $sql = $sql . " AND ";
            }
        }

        // error_log(print_r($sql."\n"));
        
        try {
            if ($result = $this->db->query($sql, $values)) {
                return $result->getResultArray();
            }
        } catch (Exception $e)
        {
            error_log(print_r($sql));
            return($sql);
        }
    }

    public function findByUserName($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";

        if ($result = $this->db->query($sql, [$username])) {
            return $result->getResultArray();
        }
    }
}
