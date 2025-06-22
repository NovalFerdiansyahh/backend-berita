<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('api/berita', 'Home::getBerita');
$routes->get('api/artikel/(:num)', 'Artikel::show/$1');


$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->resource('user');   
    $routes->resource('artikel');
    $routes->resource('komentar'); 
    $routes->resource('favorit'); 
    $routes->resource('notifikasi'); 
    $routes->resource('kategori');     
});