<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// Rute Autentikasi
$routes->post('login', 'LoginController::login');
$routes->get('login', 'LoginController::login');
$routes->options('login', 'Home::index');

$routes->post('registrasi', 'RegistrasiController::registrasi');
$routes->options('registrasi', 'Home::index');

// Rute OPTIONS untuk Produk
$routes->options('produk', 'Home::index');
$routes->options('produk/(:any)', 'Home::index');

// Rute Catatan Belanja (Menghapus slash di depan agar konsisten)
$routes->options('note/(:num)', 'Home::index');
$routes->post('note', 'NoteController::create');
$routes->get('note/(:num)', 'NoteController::list/$1');

// Rute Profil Saya (Memastikan rute OPTIONS mendukung parameter ID)
$routes->options('member/profil/(:num)', 'Home::index'); // 
$routes->get('member/profil/([0-9]+)', 'LoginController::getProfil/$1');

// Grup Rute Produk (CRUD)
$routes->group('produk', function ($routes) {
    $routes->post('/', 'ProdukController::create');
    $routes->get('/', 'ProdukController::list');
    $routes->get('(:segment)', 'ProdukController::detail/$1');
    $routes->put('(:segment)', 'ProdukController::ubah/$1');
    $routes->delete('(:segment)', 'ProdukController::hapus/$1');
});