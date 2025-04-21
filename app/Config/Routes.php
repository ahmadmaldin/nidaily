<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin      = ['filter' => 'role:admin'];
$user  = ['filter' => 'role:user'];
$allRole    = ['filter' => 'role:admin,user'];

// Login
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// Backup db
$routes->get('/backup', 'Backup::database');
$routes->get('/lay', 'Home::index1');

// Halaman utama
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);
$routes->get('about', 'Home::about', $allRole);

// tugas
$routes->get('tugas', 'tugas::index');
$routes->get('tugas/create', 'tugas::create');
$routes->post('tugas/store', 'tugas::store');
$routes->get('tugas/edit/(:num)', 'tugas::edit/$1');
$routes->post('tugas/update/(:num)', 'tugas::update/$1');
$routes->get('tugas/delete/(:num)', 'tugas::delete/$1');
$routes->get('tugas/detail/(:num)', 'tugas::detail/$1');
$routes->get('tugas/share/(:num)', 'Tugas::share/$1');
$routes->post('tugas/share/(:num)', 'Tugas::storeShare/$1');   
//user
$routes->get('user', 'user::index');
$routes->get('user/create', 'user::create');
$routes->post('user/store', 'user::store');
$routes->get('user/edit/(:num)', 'user::edit/$1');
$routes->post('user/update/(:num)', 'user::update/$1');
$routes->get('user/delete/(:num)', 'user::delete/$1');


// attachment
$routes->get('/attachment', 'Attachment::index');
$routes->get('/attachment/create', 'Attachment::create');
$routes->post('/attachment/store', 'Attachment::store');
$routes->get('/attachment/edit/(:num)', 'Attachment::edit/$1');
$routes->post('/attachment/update/(:num)', 'Attachment::update/$1');
$routes->delete('attachment/delete/(:num)', 'Attachment::delete/$1');

// members
$routes->get('/members', 'Members::index');
$routes->get('/members/create', 'Members::create');
$routes->post('/members/store', 'Members::store');
$routes->get('/members/edit/(:num)', 'Members::edit/$1');
$routes->post('/members/update/(:num)', 'Members::update/$1');
$routes->get('/members/delete/(:num)', 'Members::delete/$1');

// Group 
$routes->get('/groups', 'Groups::index'); 
$routes->get('/groups/create', 'Groups::create'); 
$routes->post('/groups/store', 'Groups::store'); 
$routes->get('/groups/edit/(:num)', 'Groups::edit/$1'); 
$routes->post('/groups/update/(:num)', 'Groups::update/$1');
$routes->get('/groups/delete/(:num)', 'Groups::delete/$1'); 
$routes->get('/groups/(:num)', 'Groups::detail/$1'); 
$routes->post('/groups/storeMember/(:num)', 'Groups::storeMember/$1');
$routes->get('groups/addMember/(:num)', 'Groups::addMember/$1');
$routes->get('groups/members/(:num)', 'Groups::members/$1');

//shared
$routes->get('/', 'Shared::index');
$routes->get('create', 'Shared::create');
$routes->post('store', 'Shared::store');
$routes->get('edit/(:num)', 'Shared::edit/$1');
$routes->post('update/(:num)', 'Shared::update/$1');
$routes->get('delete/(:num)', 'Shared::delete/$1');

