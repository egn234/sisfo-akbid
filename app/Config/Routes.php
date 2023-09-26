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

// Profil
$routes->get('profil', 'Login::Profil');

//GROUP ADMIN
$routes->group('admin', static function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    //Profil Admin
    $routes->group('profil', static function ($routes) {

        $routes->add('update-process', 'Admin\Profil::process_update', ['as' => 'update-profil-user']);
        $routes->add('update-pass', 'Admin\Profil::update_pass', ['as' => 'update-pass-user']);
        
    });

    //KELOLA MAHASISWA
    $routes->group('mahasiswa', static function ($routes) {
        $routes->get('/', 'Admin\Mahasiswa::index');
        $routes->get('list', 'Admin\Mahasiswa::index');
        $routes->get('add', 'Admin\Mahasiswa::index');

        // $routes->add('switch-mhs-confirm/(:num)', 'Admin\Mahasiswa::flag_switch/$1', ['as' => 'admin-switch-mhs']);
        $routes->add('switch-mhs', 'Admin\Mahasiswa::flag_switch');
        $routes->add('input-process', 'Admin\Mahasiswa::process_input');
        $routes->add('import-mhs', 'Admin\Mahasiswa::import_mhs');
        $routes->add('update-process/(:num)', 'Admin\Mahasiswa::process_update/$1', ['as' => 'update-mahasiswa-1']);
        $routes->add('update-password/(:num)', 'Admin\Mahasiswa::update_pass/$1', ['as' => 'update-pass-mahasiswa-1']);

        $routes->get('data_mhs', 'Admin\Mahasiswa::data_mhs');
        $routes->get('data_prodi', 'Admin\Mahasiswa::data_prodi');
        $routes->get('detail/(:num)', 'Admin\Mahasiswa::detail/$1', ['as' => 'detail-mahasiswa-1']);
        $routes->get('data_nilai/(:num)', 'Admin\Mahasiswa::data_nilai/$1');

    });

    // Kelola Dosen
    $routes->group('dosen', static function ($routes) {
        $routes->get('/', 'Admin\Dosen::index');
        $routes->get('data_dosen', 'Admin\Dosen::data_dosen');
        $routes->get('data_prodi', 'Admin\Dosen::data_prodi');
        $routes->get('data_history/(:num)', 'Admin\Dosen::data_historiWaldos/$1');
        $routes->get('detail/(:num)', 'Admin\Dosen::detail/$1', ['as' => 'detail-dosen-1']);

        $routes->add('import-dosen', 'Admin\Dosen::import_dosen');
        $routes->add('update-password/(:num)', 'Admin\Dosen::update_pass/$1', ['as' => 'update-pass-dosen-1']);
        $routes->add('switch-dosen', 'Admin\Dosen::flag_switch');
        $routes->add('update-process/(:num)', 'Admin\Dosen::process_update/$1', ['as' => 'update-dosen-1']);
        $routes->add('input-process', 'Admin\Dosen::process_input');
        
    });

    // Kelola Mata Kuliah
    $routes->group('matkul', static function ($routes) {
        $routes->get('/', 'Admin\Matakuliah::index');
        $routes->get('data_matkul', 'Admin\Matakuliah::data_matkul');
        
        $routes->add('import-matkul', 'Admin\Matakuliah::import_matkul');
        $routes->add('input-process', 'Admin\Matakuliah::process_input');
        $routes->add('update-process', 'Admin\Matakuliah::process_update');
        $routes->add('delete-process', 'Admin\Matakuliah::process_delete');
        $routes->add('switch-matkul', 'Admin\Matakuliah::flag_switch');

        // Contoh export xls dan pdf
        $routes->add('export', 'Admin\Matakuliah::export');
        $routes->add('generate', 'Admin\Matakuliah::generate');
    });

    // Kelola Ruangan
    $routes->group('ruangan', static function ($routes) {
        $routes->get('/', 'Admin\Ruangan::index');
        $routes->get('data_ruangan', 'Admin\Ruangan::data_ruangan');

        $routes->add('import-ruangan', 'Admin\Ruangan::import_ruangan');
        $routes->add('input-process', 'Admin\Ruangan::process_input');
        $routes->add('update-process', 'Admin\Ruangan::process_update');
        $routes->add('delete-process', 'Admin\Ruangan::process_delete');
        $routes->add('switch-ruangan', 'Admin\Ruangan::flag_switch');

    });

    // Kelola Tahun Ajaran
    $routes->group('tahun-ajaran', static function ($routes) {
        $routes->get('/', 'Admin\Tahunajaran::index');
        $routes->get('data_tahunajaran', 'Admin\Tahunajaran::data_tahunajaran');
        $routes->add('input-process', 'Admin\Tahunajaran::process_input');
        $routes->add('update-process', 'Admin\Tahunajaran::process_update');
        $routes->add('delete-process', 'Admin\Tahunajaran::process_delete');
        $routes->add('switch-periode', 'Admin\Tahunajaran::flag_switch');
    });

    // Kelola Prodi
    $routes->group('prodi', static function ($routes) {
        $routes->get('/', 'Admin\Prodi::index');
        $routes->get('data-prodi', 'Admin\Prodi::data_prodi');
        $routes->add('input-process', 'Admin\Prodi::process_input');
        $routes->add('update-process', 'Admin\Prodi::process_update');
        $routes->add('delete-process', 'Admin\Prodi::process_delete');
        $routes->add('switch-periode', 'Admin\Prodi::flag_switch');
    });

    // Kelola Kelas
    $routes->group('kelas', static function ($routes) {
        $routes->get('/', 'Admin\Kelas::index');
        $routes->get('data_kelas', 'Admin\Kelas::data_kelas');
        $routes->get('detail/(:any)', 'Admin\Kelas::detail_kelas/$1');

        $routes->add('input-process', 'Admin\Kelas::process_input');
        $routes->add('update-process', 'Admin\Kelas::process_update');
        $routes->add('delete-process', 'Admin\Kelas::process_delete');
        $routes->add('data-detail-kelas', 'Admin\Kelas::detail_data_kelas');

        $routes->add('switch-kelas', 'Admin\Kelas::flag_switch');
        $routes->get('data_mhs_flag', 'Admin\Kelas::data_mhs_flag');

        // Dosen wali Kelas

        $routes->add('add_dosen_wali', 'Admin\Kelas::add_dosen_wali');
        $routes->add('remove_dosen_wali', 'Admin\Kelas::remove_dosen_wali');

        // Kelas mahasiswa
        $routes->add('ploting_Kelas_Mhs', 'Admin\Kelas::ploting_Kelas_Mhs');
        $routes->add('remove_mhs', 'Admin\Kelas::remove_mhs');
    });

    // Kelola pertanyaan
    $routes->group('pertanyaan', static function ($routes) {
        $routes->get('/', 'Admin\Pertanyaan::index');
        $routes->get('data_pertanyaan', 'Admin\Pertanyaan::data_pertanyaan');
        $routes->add('input-process', 'Admin\Pertanyaan::process_input');
        $routes->add('update-process', 'Admin\Pertanyaan::process_update');
        $routes->add('delete-process', 'Admin\Pertanyaan::process_delete');
        $routes->add('switch', 'Admin\Pertanyaan::flag_switch');
    });

    // Kelola kuesioner
    $routes->group('kuesioner', static function ($routes) {
        $routes->get('/', 'Admin\Kuesioner::index');
        $routes->get('data_pertanyaan/(:num)', 'Admin\Kuesioner::data_pertanyaan/$1', ['as' => 'list-pertanyaan-1']);
        $routes->get('data_kuesioner', 'Admin\Kuesioner::data_kuesioner');
        $routes->get('detail/(:num)', 'Admin\Kuesioner::detail/$1', ['as' => 'detail-kuesioner-1']);
        
        $routes->add('input-process', 'Admin\Kuesioner::process_input');
        $routes->add('update-process', 'Admin\Kuesioner::process_update');
        $routes->add('delete-process', 'Admin\Kuesioner::process_delete');
        $routes->add('switch', 'Admin\Kuesioner::flag_switch');
    });

    // Kelola posting
    $routes->group('posting', static function ($routes) {
        $routes->get('/', 'Admin\Posting::index');
        $routes->get('data_posting', 'Admin\Posting::data_posting');
        $routes->get('detail/(:any)', 'Admin\Posting::detail_posting/$1');

        $routes->add('input-process', 'Admin\Posting::process_input');
        $routes->add('update-process', 'Admin\Posting::process_update');
        $routes->add('delete-process', 'Admin\Posting::process_delete');
    });

    // Kelola koordinator
    $routes->group('kordinator', static function ($routes) {
        $routes->get('/', 'Admin\Kordinator::index');
        $routes->get('data_kordinator', 'Admin\Kordinator::data_kordinator');
        $routes->get('data_dosen_flag', 'Admin\Kordinator::data_dosen_flag');
        $routes->get('data_matkul_flag', 'Admin\Kordinator::data_matkul_flag');

        $routes->add('input-process', 'Admin\Kordinator::process_input');

        $routes->add('update-process', 'Admin\Kordinator::process_update');

        $routes->add('delete-process', 'Admin\Kordinator::process_delete');
    });

    //Kelola Jadwal
    $routes->group('jadwal', static function ($routes) {
        $routes->get('/', 'Admin\Jadwal::index');
        
        $routes->add('detail/(:num)', 'Admin\Jadwal::detail_jadwal/$1');
        $routes->add('data-jadwal', 'Admin\Jadwal::data_jadwal');

        $routes->post('input-process', 'Admin\Jadwal::add_proc');
        $routes->post('edit-process', 'Admin\Jadwal::edit_proc');
        $routes->post('switch-jadwal', 'Admin\Jadwal::flag_switch');
    });

    //Kelola Registrasi
    $routes->group('registrasi', static function ($routes) {
        $routes->get('/', 'Admin\Registrasi::index');
        $routes->get('data_kelas', 'Admin\Registrasi::data_kelas');

        $routes->add('detail/(:num)', 'Admin\Registrasi::detail/$1', ['as' => 'detail-kelas-regis']);
        $routes->add('data-mhs/(:num)', 'Admin\Registrasi::data_mhs/$1', ['as' => 'data-mhs-admin']);
        $routes->add('data-jadwal/(:num)', 'Admin\Registrasi::data_jadwal/$1', ['as' => 'data-jadwal-admin']);
        $routes->add('acc-regis/(:num)', 'Admin\Registrasi::acc_regis/$1', ['as' => 'admin-acc-regis']);
        $routes->add('reset/(:num)', 'Admin\Registrasi::reset/$1', ['as' => 'admin-reset-regis']);
    });

    //Kelola Nilai
    $routes->group('nilai', static function ($routes) {
        $routes->get('/', 'Admin\Nilai::index');
        $routes->get('list-mhs/(:num)', 'Admin\Nilai::list_mhs/$1');
        $routes->get('detail-nilai/(:num)', 'Admin\Nilai::detail_nilai/$1');
        
        $routes->post('submit-nilai', 'Admin\Nilai::submit_nilai');

        $routes->add('edit-nilai', 'Admin\Nilai::edit_nilai');
        $routes->add('data-kelas', 'Admin\Nilai::data_kelas');
        $routes->add('data-mhs/(:num)', 'Admin\Nilai::data_mhs/$1');
        $routes->add('data-nilai/(:num)', 'Admin\Nilai::data_nilai/$1');
    });
});

//GROUP MAHASISWA
$routes->group('mahasiswa', static function ($routes) {
    $routes->get('dashboard', 'Mahasiswa\Dashboard::index');
    
    //Profil Mahasiswa
    $routes->group('profil', static function ($routes) {

        $routes->add('update-process', 'Mahasiswa\Profil::process_update', ['as' => 'update-profil-mhs']);
        $routes->add('update-pass', 'Mahasiswa\Profil::update_pass', ['as' => 'update-pass-mhs']);

    });

    // View posting
    $routes->group('posting', static function ($routes) {
        $routes->get('/', 'Mahasiswa\Posting::index');
        $routes->get('detail/(:any)', 'Mahasiswa\Posting::detail_posting/$1');
    });

    // View jadwal
    $routes->group('jadwal', static function ($routes) {
        $routes->get('/', 'Mahasiswa\Jadwal::index');
        
        $routes->add('data-jadwal', 'Mahasiswa\Jadwal::data_jadwal');
    });

    // View nilai
    $routes->group('nilai', static function ($routes) {
        
        $routes->get('/', 'Mahasiswa\Nilai::index');

        $routes->add('data-nilai', 'Mahasiswa\Nilai::data_nilai');
        $routes->add('print-khs/(:num)', 'Mahasiswa\Nilai::print_khs/$1');
        $routes->add('print-khs', 'Mahasiswa\Nilai::print_khs');
    });

    // View Kuesioner
    $routes->group('kuesioner', static function ($routes) {
        $routes->get('/', 'Mahasiswa\Kuesioner::index');
        $routes->get('pertanyaan_kuesioner/(:any)', 'Mahasiswa\Kuesioner::pertanyaan_kuesioner/$1');

        $routes->get('data_kuesioner', 'Mahasiswa\Kuesioner::data_kuesioner');
    });

    // View Registrasi
    $routes->group('registrasi', static function ($routes) {
        $routes->get('/', 'Mahasiswa\Registrasi::index');
        $routes->get('ksm', 'Mahasiswa\Registrasi::ksm');
        $routes->get('print-ksm', 'Mahasiswa\Registrasi::print_ksm');

        $routes->add('data-regis', 'Mahasiswa\Registrasi::data_matkul_periode');
        $routes->add('data-jadwal', 'Mahasiswa\Registrasi::data_jadwal');
        $routes->add('data-jadwal2', 'Mahasiswa\Registrasi::data_jadwal_selected');
        $routes->add('regis-proc', 'Mahasiswa\Registrasi::regis_proc');
    });
    
    // View Presensi
    $routes->group('presensi', static function ($routes) {
        $routes->get('/', 'Mahasiswa\Presensi::index');

        $routes->get('data-presensi/(:num)', 'Mahasiswa\Presensi::data_presensi/$1', ['as' => 'data-presensi-mhs']);
    });
});

//GROUP DOSEN
$routes->group('dosen', static function ($routes) {
    $routes->get('dashboard', 'Dosen\Dashboard::index');
    
    //Profil Dosen
    $routes->group('profil', static function ($routes) {

        $routes->add('update-process', 'Dosen\Profil::process_update', ['as' => 'update-profil-dosen']);
        $routes->add('update-pass', 'Dosen\Profil::update_pass', ['as' => 'update-pass-dosen']);

    });

    //BAP
    $routes->group('bap', static function ($routes) {

        $routes->get('/', 'Dosen\Bap::index');
        $routes->get('list-bap/(:num)', 'Dosen\Bap::list_bap/$1', ['as' => 'bap-list-dosen']);
        $routes->get('detail-bap/(:num)', 'Dosen\Bap::detail_bap/$1', ['as' => 'bap-detail-dosen']);
        
        $routes->add('data-matkul', 'Dosen\Bap::data_matkul');
        $routes->get('status-hadir', 'Dosen\Bap::get_status_kehadiran');
        $routes->add('data-bap/(:num)', 'Dosen\Bap::data_bap/$1', ['as' => 'data-bap-dosen']);
        $routes->add('data-mhs/(:num)', 'Dosen\Bap::data_mhs/$1', ['as' => 'data-mhs-dosen']);

        $routes->post('create-bap', 'Dosen\Bap::add_bap');
        $routes->post('simpan-absensi', 'Dosen\Bap::save_absensi');
    });

    //Nilai
    $routes->group('nilai', static function($routes){

        $routes->get('/', 'Dosen\Nilai::index');

        $routes->add('data-matkul', 'Dosen\Nilai::data_matkul');
        $routes->add('list-mhs/(:num)', 'Dosen\Nilai::list_mhs/$1');
        $routes->add('data-mhs/(:num)', 'Dosen\Nilai::data_mhs/$1');

        $routes->post('edit-nilai', 'Dosen\Nilai::edit_nilai');
        $routes->post('submit-nilai', 'Dosen\Nilai::submit_nilai');

    });    

    //Koordinator
    $routes->group('koordinator', static function($routes){

        $routes->get('/', 'Dosen\Koordinator::index');
        $routes->add('koor_data', 'Dosen\Koordinator::koor_data');

        $routes->post('edit-param', 'Dosen\Koordinator::edit_param');
        $routes->post('edit-param-proc', 'Dosen\Koordinator::edit_param_proc');
    });

    //Perwalian
    $routes->group('perwalian', static function($routes){
        
        $routes->get('/', 'Dosen\Perwalian::index');

    });
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
