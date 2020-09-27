<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignsModel extends Model
{
    protected $table = 'designs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userID', 'designName', 'designType', 'images', 'detail', 'createDate', 'updateDate',
    ];

    protected $returnType = 'App\Entities\Designs';
    protected $useTimestamps = false;

    public function findById($id)
    {
        $data = $this->find($id);

        if($data)
        {
            return $data;
        }

        return false;
    }
}