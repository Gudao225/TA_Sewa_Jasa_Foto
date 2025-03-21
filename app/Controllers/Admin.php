<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ServiceModel;
use App\Models\UserModel;
use App\Models\ChatModel;
use App\Models\OrderHistoryModel;

class Admin extends BaseController
{
    protected $orderModel;
    protected $serviceModel;
    protected $userModel;
    protected $chatModel;
    protected $orderHistoryModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->serviceModel = new ServiceModel();
        $this->userModel = new UserModel();
        $this->chatModel = new ChatModel();
        $this->orderHistoryModel = new OrderHistoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'orders_count' => $this->orderModel->countAll(),
            'pending_count' => $this->orderModel->where('status', 'pending')->countAllResults(),
            'negotiating_count' => $this->orderModel->where('status', 'negotiating')->countAllResults(),
            'accepted_count' => $this->orderModel->where('status', 'accepted')->countAllResults(),
        ];
        
        return view('admin/dashboard', $data);
    }

    public function orders()
    {
        // Join with users and services to get more details
        $this->orderModel->select('orders.*, users.name as customer_name, services.name as service_name');
        $this->orderModel->join('users', 'users.id = orders.user_id');
        $this->orderModel->join('services', 'services.id = orders.service_id', 'left');
        $orders = $this->orderModel->findAll();
        
        $data = [
            'title' => 'Daftar Pesanan',
            'orders' => $orders
        ];
        
        return view('admin/orders', $data);
    }

    public function order_detail($id)
    {
        // Get order details with joins
        $this->orderModel->select('orders.*, users.name as customer_name, users.email as customer_email, services.name as service_name, services.price as service_price');
        $this->orderModel->join('users', 'users.id = orders.user_id');
        $this->orderModel->join('services', 'services.id = orders.service_id', 'left');
        $order = $this->orderModel->find($id);
        
        if (!$order) {
            return redirect()->to('admin/orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        // Get chat history
        $chats = $this->chatModel->getChatsByOrderId($id);
        
        // Get order status history
        $history = $this->orderHistoryModel->where('order_id', $id)
                                         ->orderBy('changed_at', 'DESC')
                                         ->findAll();
        
        $data = [
            'title' => 'Detail Pesanan #' . $id,
            'order' => $order,
            'chats' => $chats,
            'history' => $history
        ];
        
        return view('admin/order_detail', $data);
    }

    public function update_status()
    {
        $order_id = $this->request->getPost('order_id');
        $status = $this->request->getPost('status');
        
        if (!in_array($status, ['pending', 'negotiating', 'accepted', 'rejected'])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }
        
        // Begin transaction
        $this->orderModel->db->transBegin();
        
        try {
            // Update order status
            $this->orderModel->update($order_id, ['status' => $status]);
            
            // Add to history
            $this->orderHistoryModel->insert([
                'order_id' => $order_id,
                'status' => $status
            ]);
            
            // If successful, commit
            $this->orderModel->db->transCommit();
            
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        } catch (\Exception $e) {
            // If error, rollback
            $this->orderModel->db->transRollback();
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function send_message()
    {
        $order_id = $this->request->getPost('order_id');
        $message = $this->request->getPost('message');
        $admin_id = session()->get('user_id');
        
        if (empty($message)) {
            return redirect()->back()->with('error', 'Pesan tidak boleh kosong');
        }
        
        try {
            // Insert chat message
            $this->chatModel->insert([
                'order_id' => $order_id,
                'sender_id' => $admin_id,
                'message' => $message
            ]);
            
            // If status is pending, change to negotiating
            $order = $this->orderModel->find($order_id);
            if ($order && $order['status'] == 'pending') {
                // Update status to negotiating
                $this->orderModel->update($order_id, ['status' => 'negotiating']);
                
                // Add to history
                $this->orderHistoryModel->insert([
                    'order_id' => $order_id,
                    'status' => 'negotiating'
                ]);
            }
            
            return redirect()->back()->with('success', 'Pesan berhasil dikirim');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $e->getMessage());
        }
    }

    // ===== CRUD Services =====

    // Menampilkan daftar layanan
    public function services()
    {
        $services = $this->serviceModel->findAll();
        
        $data = [
            'title' => 'Kelola Layanan',
            'services' => $services
        ];
        
        return view('admin/services', $data);
    }
    
    // Menampilkan form tambah layanan
    public function add_service()
    {
        $data = [
            'title' => 'Tambah Layanan Baru',
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/add_service', $data);
    }
    
    // Proses menyimpan layanan baru
    public function save_service()
    {
        // Validasi input
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[10]',
            'price' => 'required|numeric|greater_than[0]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
        
        // Siapkan data
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price')
        ];
        
        // Simpan data
        try {
            $this->serviceModel->insert($data);
            return redirect()->to('admin/services')->with('success', 'Layanan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan layanan: ' . $e->getMessage());
        }
    }
    
    // Menampilkan form edit layanan
    public function edit_service($id)
    {
        $service = $this->serviceModel->find($id);
        
        if (!$service) {
            return redirect()->to('admin/services')->with('error', 'Layanan tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Layanan',
            'service' => $service,
            'validation' => \Config\Services::validation()
        ];
        
        return view('admin/edit_service', $data);
    }
    
    // Proses update layanan
    public function update_service($id)
    {
        // Validasi input
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required|min_length[10]',
            'price' => 'required|numeric|greater_than[0]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
        
        // Siapkan data
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price')
        ];
        
        // Update data
        try {
            $this->serviceModel->update($id, $data);
            return redirect()->to('admin/services')->with('success', 'Layanan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui layanan: ' . $e->getMessage());
        }
    }
    
    // Proses delete layanan
    public function delete_service($id)
    {
        // Periksa apakah layanan digunakan dalam pesanan
        $usedInOrders = $this->orderModel->where('service_id', $id)->countAllResults();
        
        if ($usedInOrders > 0) {
            return redirect()->to('admin/services')->with('error', 'Layanan tidak dapat dihapus karena masih digunakan dalam pesanan');
        }
        
        try {
            $this->serviceModel->delete($id);
            return redirect()->to('admin/services')->with('success', 'Layanan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/services')->with('error', 'Gagal menghapus layanan: ' . $e->getMessage());
        }
    }
}