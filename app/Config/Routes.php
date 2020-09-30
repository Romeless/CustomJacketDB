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
$routes->add('/todo/api/0.1/users/update/(:num)', 'Users::update/$1');
$routes->add('/todo/api/0.1/users/show/(:num)', 'Users::show/$1');
$routes->add('/todo/api/0.1/users/login', 'Users::login');
$routes->add('/todo/api/0.1/users/username', 'Users::getByUsername');

$routes->add('/todo/api/0.1/designs', 'Designs::index');
$routes->add('/todo/api/0.1/designs/create', 'Designs::create');
$routes->add('/todo/api/0.1/designs/update', 'Designs::update');
$routes->add('/todo/api/0.1/designs/show/(:num)', 'Designs::show/$1');
$routes->add('/todo/api/0.1/designs/user/(:num)', 'Designs::showByUserID/$1');



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
