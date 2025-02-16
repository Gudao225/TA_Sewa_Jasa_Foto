<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\OrderModel;

class Sewa extends BaseController
{
    protected $serviceModel;
    protected $orderModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $data = [
            'services' => $this->serviceModel->findAll(),
            'title' => 'Form Penyewaan'
        ];
        
        return view('sewa', $data);
    }

    public function process()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'service_id' => 'required|numeric',
            'event_time' => 'required',
            'custom_details' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $user_id = session()->get('user_id'); // Sesuaikan dengan key session yang benar
        
        // Debug session
        if (empty($user_id)) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'User ID tidak ditemukan dalam session. Silakan login ulang.');
        }

        $data = [
            'user_id' => $user_id,
            'service_id' => $this->request->getPost('service_id'),
            'event_time' => $this->request->getPost('event_time'),
            'custom_details' => $this->request->getPost('custom_details'),
            'status' => 'pending'
        ];

        try {
            // Debug data sebelum insert
            log_message('debug', 'Data yang akan disimpan: ' . print_r($data, true));
            
            $inserted = $this->orderModel->insert($data);
            
            if (!$inserted) {
                // Debug error database
                log_message('error', 'Database Error: ' . print_r($this->orderModel->errors(), true));
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal menyimpan data: ' . implode(', ', $this->orderModel->errors()));
            }
            
            return redirect()->to('sewa')
                           ->with('success', 'Permintaan sewa berhasil dikirim');
        } catch (\Exception $e) {
            // Debug exception
            log_message('error', 'Exception: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}