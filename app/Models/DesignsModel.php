<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignsModel extends Model
{
    protected $table = 'designs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userID', 'designName', 'details', 'images', 'imagesPosition', 'information', "createDate", "updateDate", "price"
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function findAllWithName()
    {
        $sql = "SELECT designs.id,designs.userID,designs.designName,designs.details,designs.images,designs.imagesPosition,designs.information,designs.createDate,designs.updateDate,designs.price,users.username FROM designs inner join users ON designs.userID = users.id";

        if ($result = $this->db->query($sql)) {
            return $result->getResultArray();
        }
    }

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
        $sql = "SELECT designs.id,designs.designName,designs.details,designs.images,designs.imagesPosition,designs.information,designs.createDate,designs.updateDate,designs.price,users.username FROM designs inner join users ON designs.userID = users.id where userID = ?";

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
