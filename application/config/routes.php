<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = 'noftound';
$route['translate_uri_dashes'] = FALSE;

// ambigous untuk digunakan
// $route['barang'] = 'admin/tabel_barangmasuk2';
// $route['barang/form'] = 'admin/form_barangmasuk2';
// $route['barang/insert'] = 'admin/insert';
// $route['aset'] = 'admin/index_aset';
// end of ambigous untuk digunakan

// index admin
$route['admin'] = 'admin/index';
// form aset masuk dan keluar
$route['aset/masuk'] = 'aset_barang/masuk';
$route['aset/keluar'] = 'aset_barang/keluar';
// aset all masuk keluar routes
$route['aset/list_masuk'] = 'aset_barang/list_masuk';
$route['aset/list_keluar'] = 'aset_barang/list_keluar';
// firewall routes
$route['aset/masuk_firewall'] = 'aset_barang/list_masuk_firewall';
$route['aset/keluar_firewall'] = 'aset_barang/list_keluar_firewall';
// monitor routes
$route['aset/masuk_monitor'] = 'aset_barang/list_masuk_monitor';
$route['aset/keluar_monitor'] = 'aset_barang/list_keluar_monitor';
// laptop routes
$route['aset/masuk_laptop'] = 'aset_barang/list_masuk_laptop';
$route['aset/keluar_laptop'] = 'aset_barang/list_keluar_laptop';
// harddisk routes
$route['aset/masuk_harddisk'] = 'aset_barang/list_masuk_harddisk';
$route['aset/keluar_harddisk'] = 'aset_barang/list_keluar_harddisk';
// printer routes
$route['aset/masuk_printer'] = 'aset_barang/list_masuk_printer';
$route['aset/keluar_printer'] = 'aset_barang/list_keluar_printer';
// rack server routes
$route['aset/masuk_rack_server'] = 'aset_barang/list_masuk_rack_server';
$route['aset/keluar_rack_server'] = 'aset_barang/list_keluar_rack_server';
// server routes
$route['aset/masuk_server'] = 'aset_barang/list_masuk_server';
$route['aset/keluar_server'] = 'aset_barang/list_keluar_server';
// pc routes
$route['aset/masuk_pc'] = 'aset_barang/list_masuk_pc';
$route['aset/keluar_pc'] = 'aset_barang/list_keluar_pc';
// form tambah gudang
$route['gudang/tambah_gudang'] = 'gudang/tambah_gudang';
$route['gudang/list_gudang'] = 'gudang/list_gudang';

// riwayat aset dan mutasi routes
$route['aset/riwayat'] = 'gudang/riwayat_aset';
$route['aset/mutasi'] = 'gudang/mutasi_aset';

// form tambah aksesoris routes
$route['aksesoris/get_next_numbers'] = 'aksesoris/get_next_numbers';
$route['aksesoris/masuk_aksesoris'] = 'aksesoris/masuk';
$route['aksesoris/list_aksesoris'] = 'aksesoris/list_aksesoris';
$route['aksesoris/simpan'] = 'aksesoris/simpan';

// form master karyawan routes
$route['karyawan'] = 'karyawan/list_karyawan';
$route['karyawan/tambah'] = 'karyawan/tambah';
$route['karyawan/edit/(:any)'] = 'karyawan/edit/$1';
$route['karyawan/simpan'] = 'karyawan/simpan';

// log helpers routes


// laporan aset routes
$route['aset/keluar/(:any)'] = 'aset_barang/keluar/$1';
$route['aset/list_masuk'] = 'aset_barang/list_masuk';
$route['aset/list_keluar'] = 'aset_barang/list_keluar';
$route['aset/kembalikan/(:any)'] = 'aset_barang/kembalikan/$1';
