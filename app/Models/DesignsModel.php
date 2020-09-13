<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignsModel extends Model
{
    protected $table = 'designs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'userID', 'designName', 'designType', 'filePath', 'detail', 'createdDate', 'updateDate',
    ];
    protected $returnType = 'App\Entities\Designs';
}