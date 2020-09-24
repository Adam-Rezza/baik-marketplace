<?php
defined('BASEPATH') OR exit('No direct script access allowed');

# RESERVED ROUTES
$route['default_controller']   = 'CustomerController/index';
$route['404_override']         = 'My404';
$route['translate_uri_dashes'] = FALSE;

# Auth
$route['register'] = 'AuthController/register';
$route['username_check_r'] = 'AuthController/unique_username';
$route['login'] = 'AuthController/index';
$route['logout'] = 'AuthController/logout';
$route['merchant_register'] = 'AuthController/register';
$route['register_merchant'] = 'AuthController/register_merchant';

# Customer
$route['my_account'] = 'CustomerController/my_account';
$route['get_kabupaten/(:any)'] = 'CustomerController/get_kabupaten/$1';
$route['get_kecamatan/(:any)'] = 'CustomerController/get_kecamatan/$1';
$route['get_kelurahan/(:any)'] = 'CustomerController/get_kelurahan/$1';
$route['save_address'] = 'CustomerController/save_address';

$route['category'] = 'CustomerController/category';
$route['category/(:any)'] = 'CustomerController/category/$1';
$route['category/(:any)/(:any)'] = 'CustomerController/category/$1/$2';

$route['search'] = 'CustomerController/search';
$route['search%26keyword=(:any)%26category=(:any)%26subcategory=(:any)'] = 'CustomerController/search/$1/$2/$3';
$route['search%26keyword=(:any)%26category=(:any)'] = 'CustomerController/search/$1/$2';
$route['search%26keyword=(:any)'] = 'CustomerController/search/$1';

$route['product'] = 'CustomerController/product';
$route['product/(:any)'] = 'CustomerController/product/$1';
$route['checkout'] = 'CustomerController/checkout';
$route['my_order'] = 'CustomerController/my_order';
$route['my_recent_order'] = 'CustomerController/my_recent_order';

# DASHBOARD
$route['dashboard'] = 'DashboardController/index';

#Merchant
$route['merchant'] = 'MerchantController/index';
$route['my_product'] = 'MerchantController/my_product';
$route['order/(:any)'] = 'MerchantController/order/$1';
$route['get_product_detail/(:any)'] = 'MerchantController/get_product_detail/$1';
$route['on_change_category/(:any)'] = 'MerchantController/on_change_category/$1';
$route['get_images_product/(:any)'] = 'MerchantController/get_images_product/$1';
$route['insert_produk'] = 'MerchantController/insert_product';
$route['delete_produk/(:any)'] = 'MerchantController/delete_produk/$1';
$route['upload_image_product'] = 'MerchantController/upload_image_product';

#Transaksi
$route['get_cart_detail'] = 'TransactionController/get_cart_detail';
$route['add_to_cart/(:any)/(:any)'] = 'TransactionController/add_to_cart/$1/$2';
$route['update_product_cart/(:any)/(:any)'] = 'TransactionController/update_product_cart/$1/$2';
$route['checkout_transaction'] = 'TransactionController/checkout_transaction';
$route['process_order/(:any)'] = 'TransactionController/process_order/$1';
$route['send_order/(:any)'] = 'TransactionController/send_order/$1';
$route['delivered_order/(:any)'] = 'TransactionController/delivered_order/$1';
