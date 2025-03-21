<?php
// File: app/Models/ChatModel.php
namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'sender_id', 'message', 'sent_at'];
    protected $useTimestamps = false;
    
    // Get all chats for an order with sender info
    public function getChatsByOrderId($order_id)
    {
        return $this->select('chat.*, users.name as sender_name, users.role as sender_role')
                   ->join('users', 'users.id = chat.sender_id')
                   ->where('order_id', $order_id)
                   ->orderBy('sent_at', 'ASC')
                   ->findAll();
    }
}