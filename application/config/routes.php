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
