<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->get('logout', 'Login::logout');
$routes->get('test-page', 'Login::testing');

$routes->post('auth-login', 'Login::login_proc');

//GROUP ADMIN
$routes->group('admin', static function ($routes)
{
    $routes->get('dashboard', 'Admin\Dashboard::index');

    //KELOLA MAHASISWA
    $routes->group('mahasiswa', static function ($routes)
    {
        $routes->get('/', 'Admin\Mahasiswa::index');
        $routes->get('list', 'Admin\Mahasiswa::index');
        $routes->get('add', 'Admin\Mahasiswa::index');

        $routes->add('switch-mhs-confirm/(:num)', 'Admin\Mahasiswa::flag_switch/$1', ['as' => 'admin-switch-mhs']);
        $routes->add('switch-mhs', 'Admin\Mahasiswa::konfirSwitch');
        $routes->add('input-process', 'Admin\Mahasiswa::process_input');

        $routes->get('data_mhs','Admin\Mahasiswa::data_mhs');
    });

    // Kelola Dosen
    $routes->group('dosen', static function ($routes)
    {
        $routes->get('/', 'Admin\Dosen::index');
        $routes->get('data_dosen','Admin\Dosen::data_dosen');
        $routes->add('input-process', 'Admin\Dosen::process_input');

        
    });

    // Kelola Mata Kuliah
    $routes->group('matkul', static function ($routes)
    {
        $routes->get('/', 'Admin\Matakuliah::index');
        $routes->get('data_matkul','Admin\Matakuliah::data_matkul');
        $routes->add('input-process', 'Admin\Matakuliah::process_input');
        $routes->add('delete-process', 'Admin\Matakuliah::process_delete');

    });

    // Kelola Ruangan
    $routes->group('ruangan', static function ($routes)
    {
        $routes->get('/', 'Admin\Ruangan::index');
        $routes->get('data_ruangan','Admin\Ruangan::data_ruangan');
        $routes->add('input-process', 'Admin\Ruangan::process_input');
        $routes->add('delete-process', 'Admin\Ruangan::process_delete');

    });

});

//GROUP MAHASISWA
$routes->group('mahasiswa', static function ($routes)
{
    $routes->get('dashboard', 'Mahasiswa\Dashboard::index');
});

//GROUP DOSEN
$routes->group('dosen', static function ($routes)
{
    $routes->get('dashboard', 'Dosen\Dashboard::index');
});


/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
