<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('api/berita', 'Home::getBerita');
$routes->get('api/artikel/(:num)', 'Artikel::show/$1');
$routes->get('api/artikel/search', 'Artikel::search');
$routes->post('api/artikel/tambahDilihat/(:num)', 'Artikel::tambahDilihat/$1');
$routes->post('api/user/register', 'User::register');
$routes->get('api/artikel/kategori/(:num)', 'Artikel::byKategori/$1');
$routes->get('/api/notifikasi/user/(:num)', 'Notifikasi::getByUser/$1');
$routes->put('/api/notifikasi/baca/(:num)', 'Notifikasi::tandaiSudahDibaca/$1');
$routes->delete('/api/notifikasi/hapus/(:num)', 'Notifikasi::hapusSemua/$1');
$routes->get('api/notifikasi/unread/(:num)', 'Notifikasi::jumlahBelumDibaca/$1');

$routes->post('api/favorit', 'Favorit::simpan');
$routes->post('api/komentar', 'Komentar::create');
$routes->get('api/komentar/artikel/(:num)', 'Komentar::getKomentarByArtikel/$1');

$routes->post('api/user/upload/(:num)', 'User::uploadFoto/$1');


$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->resource('user');   
    $routes->resource('artikel');
    $routes->resource('komentar'); 
    $routes->resource('favorit'); 
    $routes->resource('notifikasi'); 
    $routes->resource('kategori');     
});