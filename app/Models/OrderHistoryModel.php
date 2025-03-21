<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class OrderHistoryModel extends Model
    {
        protected $table = 'order_history';
        protected $primaryKey = 'id';
        protected $allowedFields = ['order_id', 'status', 'changed_at'];
        protected $useTimestamps = false;
    }