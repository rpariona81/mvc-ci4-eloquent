<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/hola', 'Home::hola');

$routes->get('/users', 'Home::listUsers');

$routes->get('/info','Home::infophp');

$routes->get('/excel','Home::generateExcel');