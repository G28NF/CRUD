<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'UsuarioController::index');
$routes->get('home', 'UsuarioController::index');
$routes->post('home/create', 'UsuarioController::create');
$routes->post('home/read', 'UsuarioController::read');
$routes->post('home/update', 'UsuarioController::update');
$routes->post('home/delete', 'UsuarioController::delete');
$routes->post('home/buscarCep', 'UsuarioController::buscarCep');
$routes->get('home/buscar/(:num)', 'UsuarioController::buscar/$1');