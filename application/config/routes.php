<?php
defined('BASEPATH') or exit('No direct script access allowed');

# RESERVED ROUTES
$route['default_controller']   = 'CustomerController/index';
$route['404_override']         = 'My404';
$route['translate_uri_dashes'] = FALSE;

# AUTH
$route['user/register']     = 'AuthController/register';
$route['user/login']        = 'AuthController/index';
$route['user/logout']       = 'AuthController/logout';
$route['username_check_r']  = 'AuthController/unique_username';
$route['merchant_register'] = 'AuthController/register';
$route['register_merchant'] = 'AuthController/register_merchant';

# CUSTOMER
$route['my_account']           = 'CustomerController/my_account';
$route['get_kabupaten/(:any)'] = 'CustomerController/get_kabupaten/$1';
$route['get_kecamatan/(:any)'] = 'CustomerController/get_kecamatan/$1';
$route['get_kelurahan/(:any)'] = 'CustomerController/get_kelurahan/$1';
$route['save_address']         = 'CustomerController/save_address';

// $route['category'] = 'CustomerController/category';
// $route['category/(:any)'] = 'CustomerController/category/$1';
// $route['category/(:any)/(:any)'] = 'CustomerController/category/$1/$2';
$route['category=(:any)&page=(:any)']                      = 'CustomerController/category/$1//$2';
$route['category=(:any)&subcategory=(:any)&page=(:any)'] = 'CustomerController/category/$1/$2/$3';

// $route['search'] = 'CustomerController/search';
$route['search&keyword=(:any)&category=(:any)&subcategory=(:any)&page=(:any)'] = 'CustomerController/search/$1/$2/$3/$4';
$route['search&keyword=(:any)&category=(:any)&page=(:any)']                    = 'CustomerController/search/$1/$2//$3';
$route['search&keyword=(:any)&page=(:any)']                                    = 'CustomerController/search/$1///$2';

$route['product']         = 'CustomerController/product';
$route['product/(:any)']  = 'CustomerController/product/$1';
$route['checkout']        = 'CustomerController/checkout';
$route['my_order']        = 'CustomerController/my_order';
$route['my_recent_order'] = 'CustomerController/my_recent_order';

# MERCHANT
$route['merchant']                  = 'MerchantController/index';
$route['my_product']                = 'MerchantController/my_product';
$route['order/(:any)']              = 'MerchantController/order/$1';
$route['get_product_detail/(:any)'] = 'MerchantController/get_product_detail/$1';
$route['on_change_category/(:any)'] = 'MerchantController/on_change_category/$1';
$route['get_images_product/(:any)'] = 'MerchantController/get_images_product/$1';
$route['insert_update_product']     = 'MerchantController/insert_update_product';
$route['delete_produk/(:any)']      = 'MerchantController/delete_produk/$1';
$route['upload_image_product']      = 'MerchantController/upload_image_product';

# TRANSAKSI
$route['get_cart_detail']                   = 'TransactionController/get_cart_detail';
$route['add_to_cart/(:any)/(:any)']         = 'TransactionController/add_to_cart/$1/$2';
$route['update_product_cart/(:any)/(:any)'] = 'TransactionController/update_product_cart/$1/$2';
$route['checkout_transaction']              = 'TransactionController/checkout_transaction';
$route['process_order/(:any)']              = 'TransactionController/process_order/$1';
$route['send_order/(:any)']                 = 'TransactionController/send_order/$1';
$route['delivered_order/(:any)']            = 'TransactionController/delivered_order/$1';

#########################################################################
############################## ADMIN MODUL ##############################
#########################################################################
# DASHBOARD
$route['dashboard'] = 'DashboardController/index';

# AUTH
$route['login']  = 'LoginController/index';
$route['logout'] = 'LoginController/logout';

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
$route['kategori/show_sub']    = 'KategoriController/show_sub';
$route['kategori/store']       = 'KategoriController/store';
$route['kategori/update']      = 'KategoriController/update';
$route['kategori/update_sub']  = 'KategoriController/update_sub';
$route['kategori/destroy']     = 'KategoriController/destroy';
$route['kategori/destroy_sub'] = 'KategoriController/destroy_sub';
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

# USER
$route['user']            = 'UsersController/index';
$route['datatables/user'] = 'UsersController/datatables';
