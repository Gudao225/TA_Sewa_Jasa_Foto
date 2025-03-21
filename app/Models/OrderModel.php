<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'service_id', 'custom_details', 'event_time', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Get orders with joined data for a specific user
    public function getUserOrders($user_id) 
    {
        return $this->select('orders.*, services.name as service_name, services.price as service_price')
                  ->join('services', 'services.id = orders.service_id', 'left')
                  ->where('orders.user_id', $user_id)
                  ->orderBy('orders.created_at', 'DESC')
                  ->findAll();
    }
    
    // Get order detail with all joined data
    public function getOrderDetail($order_id, $user_id = null)
    {
        $query = $this->select('orders.*, services.name as service_name, services.price as service_price, 
                           users.name as customer_name, users.email as customer_email')
                    ->join('services', 'services.id = orders.service_id', 'left')
                    ->join('users', 'users.id = orders.user_id')
                    ->where('orders.id', $order_id);
        
        // If user_id is provided, only return their own orders (for security)
        if ($user_id !== null) {
            $query->where('orders.user_id', $user_id);
        }
        
        return $query->first();
    }
}