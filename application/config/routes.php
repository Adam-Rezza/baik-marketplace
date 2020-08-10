<?php
defined('BASEPATH') OR exit('No direct script access allowed');

# RESERVED ROUTES
$route['default_controller']   = 'LoginController/index';
$route['404_override']         = 'My404';
$route['translate_uri_dashes'] = FALSE;

# AUTH
$route['logout'] = 'LoginController/logout';

# DASHBOARD
$route['dashboard'] = 'DashboardController/index';