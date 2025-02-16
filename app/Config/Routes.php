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