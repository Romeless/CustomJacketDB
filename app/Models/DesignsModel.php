<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignsModel extends Model
{
    protected $table = 'designs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userID', 'designName', 'detail', 'images', 'imagesPosition', 'information', "createDate", "updateDate"
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function findById($id)
    {
        $data = $this->find($id);

        if ($data) {
            return $data;
        }

        return false;
    }

    public function findByUserID($userID)
    {
        $sql = "SELECT * FROM designs WHERE userID = ?";

        if ($result = $this->db->query($sql, [$userID])) {
            return $result->getResultArray();
        }
    }

    function findByColumn($columns, $values, $result = null)
    {
        // $columns is an array of string specifiyng the column to search (ex. username, password)
        // $values is an array of string related to the column of same index (ex. 15, means WHERE username = 15)

        if (sizeof($columns) != sizeof($values)) {
            return 0;
        }

        if ($result == null) {
            $sql = "SELECT " . $result . " ";
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

        $sql = $sql . "FROM designs WHERE ";

        foreach ($columns as $column => $element) {
            $sql = $sql . $element . " = ?";

            if ($column != array_key_last($columns)) {
                $sql = $sql . " AND ";
            }
        }

        if ($result = $this->db->query($sql, $values)) {
            return $result->getResultArray();
        }
    }
}
