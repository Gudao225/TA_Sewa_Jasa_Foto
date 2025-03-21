<?php

namespace App\Controllers;
use App\Models\ServiceModel;

class Home extends BaseController
{
    public function index()
    {
        $serviceModel = new ServiceModel();
        $data = [
            'title' => 'Selamat Datang di Studio Foto Kami',
            'services' => $serviceModel->findAll()
        ];
        
        return view('home', $data);
    }
}