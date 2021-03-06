<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/Token', 'Token::index');

$routes->add('/todo/api/0.1/users', 'Users::index');
$routes->add('/todo/api/0.1/users/create', 'Users::create');
$routes->add('/todo/api/0.1/users/googleAuth', 'Users::google_auth');
$routes->add('/todo/api/0.1/users/googleAuthMobile', 'Users::google_auth_mobile');
$routes->add('/todo/api/0.1/users/update/(:num)', 'Users::update/$1');
$routes->add('/todo/api/0.1/users/delete/(:num)', 'Users::delete/$1');
$routes->add('/todo/api/0.1/users/show/(:num)', 'Users::show/$1');
$routes->add('/todo/api/0.1/users/login', 'Users::login');
$routes->add('/todo/api/0.1/users/user', 'Users::getByUsername');

$routes->add('/todo/api/0.1/designs', 'Designs::index');
$routes->add('/todo/api/0.1/designs/share', 'Designs::indexShareable');
$routes->add('/todo/api/0.1/designs/share/(:num)', 'Designs::indexShareable/$1');
$routes->add('/todo/api/0.1/designs/create', 'Designs::create');
$routes->add('/todo/api/0.1/designs/update/(:num)', 'Designs::update/$1');
$routes->add('/todo/api/0.1/designs/delete/(:num)', 'Designs::delete/$1');
$routes->add('/todo/api/0.1/designs/remove/(:num)', 'Designs::remove/$1');
$routes->add('/todo/api/0.1/designs/show/(:num)', 'Designs::show/$1');
$routes->add('/todo/api/0.1/designs/user/(:num)', 'Designs::showByUserID/$1');

$routes->add('/todo/api/0.1/orders', 'Orders::index');
$routes->add('/todo/api/0.1/orders/create', 'Orders::create');
$routes->add('/todo/api/0.1/orders/update/(:num)', 'Orders::update/$1');
$routes->add('/todo/api/0.1/orders/delete/(:num)', 'Orders::delete/$1');
$routes->add('/todo/api/0.1/orders/show/(:num)', 'Orders::show/$1');
$routes->add('/todo/api/0.1/orders/user/(:num)', 'Orders::showByUserID/$1');
$routes->add('/todo/api/0.1/orders/design/(:num)', 'Orders::showByDesignID/$1');
$routes->add('/todo/api/0.1/orders/confirm', 'Orders::showOrderDetails');

//$routes->add('/todo/api/0.1/tokens/verify', 'Tokens::verifyToken');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
