<?php
defined('BASEPATH') or exit('No direct script access allowed');

# RESERVED ROUTES
$route['default_controller']   = 'LoginController/index';
$route['404_override']         = 'My404';
$route['translate_uri_dashes'] = FALSE;

# AUTH
$route['logout'] = 'LoginController/logout';

# DASHBOARD
$route['dashboard'] = 'DashboardController/index';

# ADMINS
$route['admins']            = 'AdminsController/index';
$route['admins/reset']      = 'AdminsController/reset';
$route['admins/destroy']    = 'AdminsController/destroy';
$route['datatables/admins'] = 'AdminsController/datatables';

# TOKO
$route['toko']                      = 'TokoController/index';
$route['toko/show']                 = 'TokoController/show';
$route['toko/change_status/(:any)'] = 'TokoController/change_status/$1';
$route['datatables/toko']           = 'TokoController/datatables';

# KATEGORI
$route['kategori']             = 'KategoriController/index';
$route['kategori/show']        = 'KategoriController/show';
$route['kategori/store']       = 'KategoriController/store';
$route['kategori/update']      = 'KategoriController/update';
$route['kategori/destroy']     = 'KategoriController/destroy';
$route['kategori/sub']         = 'KategoriController/sub';
$route['kategori/get_parent']  = 'KategoriController/get_parent';
$route['kategori/up_parent']   = 'KategoriController/up_parent';
$route['kategori/down_parent'] = 'KategoriController/down_parent';
$route['kategori/up_child']    = 'KategoriController/up_child';
$route['kategori/down_child']  = 'KategoriController/down_child';
$route['datatables/kategori']  = 'KategoriController/datatables';

# PRODUK
$route['produk']                = 'ProdukController/index';
$route['produk/show']           = 'ProdukController/show';
$route['produk/destroy']        = 'ProdukController/destroy';
$route['produk/destroy_gambar'] = 'ProdukController/destroy_gambar';
$route['produk/ban']            = 'ProdukController/ban';
$route['datatables/produk']     = 'ProdukController/datatables';

# BANNER
$route['banner']            = 'BannerController/index';
$route['banner/show']       = 'BannerController/show';
$route['banner/store']      = 'BannerController/store';
$route['banner/update']     = 'BannerController/update';
$route['banner/destroy']    = 'BannerController/destroy';
$route['banner/up']         = 'BannerController/up';
$route['banner/down']       = 'BannerController/down';
$route['datatables/banner'] = 'BannerController/datatables';
