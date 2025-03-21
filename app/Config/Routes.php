<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register', 'Auth::register');
$routes->post('register_process', 'Auth::register_process');
$routes->get('login', 'Auth::login');
$routes->post('login_process', 'Auth::login_process');
$routes->get('logout', 'Auth::logout');

// Tambahkan filter auth untuk route sewa
$routes->group('sewa', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Sewa::index');
    $routes->post('process', 'Sewa::process');
});

// Customer orders routes (with auth filter)
$routes->group('orders', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Orders::index');
    $routes->get('detail/(:num)', 'Orders::detail/$1');
    $routes->post('send_message', 'Orders::send_message');
});

// Admin routes (with admin filter)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('orders', 'Admin::orders');
    $routes->get('order/(:num)', 'Admin::order_detail/$1');
    $routes->post('update_status', 'Admin::update_status');
    $routes->post('send_message', 'Admin::send_message');
});