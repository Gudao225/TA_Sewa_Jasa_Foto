<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}