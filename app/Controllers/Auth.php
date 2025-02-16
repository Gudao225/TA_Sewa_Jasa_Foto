<?php

namespace App\Controllers;

use App\Models\UserModel;
use Config\Services;

class Auth extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url('register'));
    }

    public function register()
    {
        return view('Auth/register');
    }

    public function register_process()
    {
        $validation = Services::validation();
        $validation->setRules([
            'Username' => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->to(site_url('register'))->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $userData = [
            'name'     => $this->request->getPost('Username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'user'
        ];

        if (!$userModel->insert($userData)) {
            return redirect()->to(site_url('register'))->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->to(site_url('login'))->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function login()
    {
        return view('Auth/login');
    }

    public function login_process()
    {
        $validation = Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->to(site_url('login'))->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getPost('email'))->first();

        if (!$user) {
            return redirect()->to(site_url('login'))->withInput()->with('errors', ['email' => 'Email tidak ditemukan']);
        }

        if (!password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->to(site_url('login'))->withInput()->with('errors', ['password' => 'Password salah']);
        }

        $session = Services::session();
        $session->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            // 'user_role'  => $user['role'],
            'role' => $user['role'],
        ]);

        return redirect()->to(site_url('/'))->with('success', 'Login berhasil, selamat datang ' . $user['name']);
    }

    public function logout()
            {
                $session = session(); // Panggil session
                $session->set('logout_success', 'Anda telah logout.');
                $session->destroy(); // Hancurkan session (kecuali session flash)
                return redirect()->to(site_url('login'));
            }
    

}
