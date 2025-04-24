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
$routes->get('tugas', 'Tugas::index'); // Halaman utama tugas
$routes->get('tugas/create', 'Tugas::create'); // Halaman untuk membuat tugas baru
$routes->post('tugas/store', 'Tugas::store'); // Proses penyimpanan tugas baru
$routes->get('tugas/edit/(:num)', 'Tugas::edit/$1'); // Halaman edit tugas dengan id
$routes->post('tugas/update/(:num)', 'Tugas::update/$1'); // Proses update tugas
$routes->get('tugas/delete/(:num)', 'Tugas::delete/$1'); // Menghapus tugas berdasarkan id
$routes->get('tugas/detail/(:num)', 'Tugas::detail/$1'); // Halaman detail tugas berdasarkan id
// Routes untuk berbagi tugas
$routes->get('tugas/sharedtome/(:num)', 'Tugas::sharedToMe/$1'); // Halaman tugas yang dibagikan ke pengguna
$routes->post('tugas/shareTaskToFriend/(:num)', 'Tugas::shareTaskToFriend/$1'); // Proses berbagi tugas ke teman
$routes->get('tugas/share/(:num)', 'Tugas::share/$1'); // Halaman untuk memilih teman/grup yang akan dibagikan tugas
$routes->post('tugas/processShare/(:num)', 'Tugas::processShare/$1');
$routes->get('/sharedtome', 'Tugas::sharedToMe');


//user
$routes->get('user', 'user::index');
$routes->get('user/create', 'user::create');
$routes->post('user/store', 'user::store');
$routes->post('user/update/(:num)', 'user::update/$1');
$routes->get('user/delete/(:num)', 'user::delete/$1');
$routes->get('/profile', 'User::profile');
$routes->get('user/edit/(:num)', 'User::edit/$1');

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
$routes->get('/groups/(:num)/detail', 'Groups::detail/$1');
$routes->match(['get', 'post'], 'groups/detail/(:num)', 'Groups::detail/$1');
$routes->get('groups/removeMember/(:num)/(:num)', 'Groups::removeMember/$1/$2');

// Friendship
$routes->get('friendship', 'Friendship::index');
$routes->post('friendship/add', 'Friendship::add');
$routes->get('friendship/accept/(:num)', 'Friendship::accept/$1');
$routes->get('friendship/decline/(:num)', 'Friendship::decline/$1');
$routes->post('friendship/remove/(:num)', 'Friendship::remove/$1'); 
