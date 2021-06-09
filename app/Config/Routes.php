<?php

namespace Config;

use PHPUnit\Util\Filter;

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
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->add('/', 'Dashboard::index', ['filter' => 'role:Admin,Mahasiswa,Super Admin,Dosen,Akademik']);
$routes->add('login', 'Mahasiswa\Login::index');
$routes->add('pengurus/login', 'Admin\Login::index');
$routes->add('logout', 'Logout::index');
$routes->add('akun', 'Akun::editAkun', ['filter' => 'role:Admin,Mahasiswa,Super Admin,Dosen,Akademik']);
$routes->add('akun/pengurus', 'Akun::editAkunPengurus', ['filter' => 'role:Admin,Super Admin,Dosen,Akademik']);
$routes->add('akun/mahasiswa', 'Akun::editAkunMahasiswa', ['filter' => 'role:Mahasiswa']);


// $routes->add('/', 'Mahasiswa::index');
// $routes->add('/mahasiswa', 'Mahasiswa::index');
// $routes->add('/mahasiswa/index', 'Mahasiswa::index');
// $routes->add('/mahasiswa/profile', 'Mahasiswa::index');

$routes->group('admin',['filter' => 'role:Admin, Super Admin'], function($routes){
	$routes->add('profile', 'Admin\Profile::getAll');
	$routes->add('akun', 'Admin\Akun::getAll');
	$routes->add('akun/hapus', 'Admin\Akun::hapusAkun');
	$routes->add('komdisma', 'Admin\Komdisma::getAll');
	$routes->add('komdisma/role', 'Admin\Komdisma::ubahRole');
	$routes->add('komdisma/import', 'Admin\Komdisma::importExcel');
	$routes->add('akademik', 'Admin\Akademik::getAll');
	$routes->add('akademik/import', 'Admin\Akademik::importExcel');
	$routes->add('mahasiswa', 'Admin\Mahasiswa::getAll');
	$routes->add('mahasiswa/import', 'Admin\Mahasiswa::importExcel');
	$routes->add('dosen', 'Admin\Dosen::getAll');
	$routes->add('dosen/import', 'Admin\Dosen::importExcel');
	$routes->add('verifikasi', 'Admin\Pelanggaran::verifikasi');
	$routes->add('verifikasi/detail', 'Admin\Pelanggaran::detailVerifikasi');
	$routes->add('verifikasi/edit', 'Admin\Pelanggaran::edit');
	$routes->add('verifikasi/ubah', 'Admin\Pelanggaran::ubah');
	$routes->add('pelanggaran', 'Admin\Pelanggaran::getAll');
	$routes->add('pelanggaran/detail', 'Admin\Pelanggaran::detailPelanggaran');
	$routes->add('skorsing', 'Admin\Skorsing::getAll');
	$routes->add('skorsing/detail', 'Admin\Skorsing::getDetail');
	$routes->add('skorsing/penundaan', 'Admin\Skorsing::getAllPenundaan');
	$routes->add('skorsing/penundaan/terima', 'Admin\Skorsing::terimaPenundaan');
	$routes->add('skorsing/penundaan/tolak', 'Admin\Skorsing::tolakPenundaan');
	$routes->add('rekapan', 'Admin\Rekapan::getAll');
	$routes->add('pelanggaran/jenis', 'Admin\JenisPelanggaran::getAll');
	$routes->add('pelanggaran/jenis/simpan', 'Admin\JenisPelanggaran::simpan');
	$routes->add('pelanggaran/jenis/edit', 'Admin\JenisPelanggaran::edit');
	$routes->add('pelanggaran/jenis/hapus/(:num)', 'Admin\JenisPelanggaran::hapus/$1');
	$routes->add('pelanggaran/lokasi', 'Admin\Lokasi::getAll');
	$routes->add('pelanggaran/lokasi/simpan', 'Admin\Lokasi::simpan');
	$routes->add('pelanggaran/lokasi/edit', 'Admin\Lokasi::edit');
	$routes->add('pelanggaran/lokasi/hapus/(:num)', 'Admin\Lokasi::hapus/$1');
	$routes->add('pelanggaran/loloskan/(:num)', 'Admin\Pelanggaran::loloskan/$1');
	$routes->add('surat', 'Admin\Surat::getAll');
	$routes->add('surat/terima', 'Admin\Surat::terimaPengajuan');
	$routes->add('surat/tolak', 'Admin\Surat::tolakPengajuan');

});

$routes->group('mahasiswa',['filter' => 'role:Mahasiswa'], function($routes){
	$routes->add('pelanggaran', 'Mahasiswa\Pelanggaran::getAll');
	$routes->add('pelanggaran/detail', 'Mahasiswa\Pelanggaran::detailPelanggaran');
	$routes->add('pelanggaran/surat/unduh', 'Mahasiswa\Surat::unduhSuratBebas');
	$routes->add('surat', 'Mahasiswa\Surat::suratKelakuan');
	$routes->add('surat/pengajuan', 'Mahasiswa\Surat::insertPengajuan');
	$routes->add('surat/unduh', 'Mahasiswa\Surat::unduhSuratKelakuan');
	$routes->add('lapor', 'Mahasiswa\Lapor::tambah');
	$routes->add('jadwal/tambah', 'Mahasiswa\Jadwal::tambah');
	$routes->add('jadwal/simpan', 'Mahasiswa\Jadwal::simpan');
	$routes->add('jadwal/edit', 'Mahasiswa\Jadwal::edit');
	$routes->add('skorsing/penundaan', 'Mahasiswa\PenundaanSkorsing::ajukanPenundaan');

});

$routes->group('',['filter' => 'role:Admin, Dosen, Super Admin'], function($routes){
	$routes->add('pelanggaran/tambah', 'Pelanggaran::tambah');
	$routes->add('pelanggaran/simpan', 'Pelanggaran::simpan');
	$routes->add('laporan', 'Lapor::getLaporMahasiswa');
	$routes->add('laporan/terima', 'Lapor::terimaLapor');

});


$routes->group('',['filter' => 'role:Akademik'], function($routes){
	$routes->add('pelanggaran', 'Pelanggaran::akademikPelanggaran');

});

$routes->group('',['filter' => 'role:Admin, Akademik, Super Admin'], function($routes){
	$routes->add('skorsing', 'Pelanggaran::skorsing');
	$routes->add('rekapan', 'Rekapan::rekapan');
	$routes->add('grafik/sv', 'Grafik::grafikSv');
	$routes->add('grafik/prodi', 'Grafik::grafikProdi');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
