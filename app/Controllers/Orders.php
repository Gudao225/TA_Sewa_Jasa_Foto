<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ChatModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $chatModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->chatModel = new ChatModel();
    }

    public function index()
    {
        $user_id = session()->get('user_id');
        
        $data = [
            'title' => 'Pesanan Saya',
            'orders' => $this->orderModel->getUserOrders($user_id)
        ];
        
        return view('orders/index', $data);
    }

    public function detail($id)
    {
        $user_id = session()->get('user_id');
        
        // Get order with security check (only own orders)
        $order = $this->orderModel->getOrderDetail($id, $user_id);
        
        if (!$order) {
            return redirect()->to('orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Get chat history
        $chats = $this->chatModel->getChatsByOrderId($id);
        
        $data = [
            'title' => 'Detail Pesanan #' . $id,
            'order' => $order,
            'chats' => $chats
        ];
        
        return view('orders/detail', $data);
    }

    public function send_message()
    {
        $order_id = $this->request->getPost('order_id');
        $message = $this->request->getPost('message');
        $user_id = session()->get('user_id');
        
        if (empty($message)) {
            return redirect()->back()->with('error', 'Pesan tidak boleh kosong');
        }
        
        // Security check - verify this order belongs to the user
        $order = $this->orderModel->getOrderDetail($order_id, $user_id);
        if (!$order) {
            return redirect()->to('orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        try {
            // Insert chat message
            $this->chatModel->insert([
                'order_id' => $order_id,
                'sender_id' => $user_id,
                'message' => $message
            ]);
            
            return redirect()->back()->with('success', 'Pesan berhasil dikirim');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }
}