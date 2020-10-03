<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userID', 'designID', 'username', 'address', 'email', 'qty', "status", "price","phoneNumber","information","partnership","partnerAddress"
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
        $sql = "SELECT * FROM orders WHERE userID = ?";

        if ($result = $this->db->query($sql, [$userID])) {
            return $result->getResultArray();
        }
    }

    public function findByDesignID($designID)
    {
        $sql = "SELECT * FROM orders WHERE designID = ?";

        if ($result = $this->db->query($sql, [$designID])) {
            return $result->getResultArray();
        }
    }
}