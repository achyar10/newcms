<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$uuid = '([0-9a-f]{8}[0-9a-f]{4}[0-9a-f]{4}[0-9a-f]{4}[0-9a-f]{12})';

// ADMIN
$route['manage/auth'] = 'auth/auth_manage/login';
$route['manage/([a-zA-Z_-]+)'] = '$1/$1_manage';
$route['manage/auth/(:any)'] = 'auth/auth_manage/$1';
$route['manage/([a-zA-Z_-]+)/(:any)'] = '$1/$1_manage/$2';
$route['manage/(:any)/edit/'.$uuid] = "$1/$1_manage/add/$2";
$route['manage/(:any)/(:any)/edit/'.$uuid] = "$1/$1_manage/add_$2/$3";
$route['manage/(:any)/(:any)/'.$uuid.'/'.$uuid] = "$1/$1_manage/$2/$3/$4";
$route['manage/(:any)/(:any)/'.$uuid.'/'.$uuid.'/'.$uuid] = "$1/$1_manage/$2/$3/$4/$5";
$route['manage/(:any)/(:any)/'.$uuid.'/'.$uuid.'/'.$uuid.'/'.$uuid] 
			= "$1/$1_manage/$2/$3/$4/$5/$6";
$route['manage/(:any)/(:any)/'.$uuid] = "$1/$1_manage/$2/$3";
$route['manage/(:any)/(:any)/(:any)'] = "$1/$1_manage/$3_$2";
$route['manage'] = "dashboard/Dashboard_manage";

// MERCHANT
$route['merchant/auth'] = 'auth/auth_merchant/login';
$route['merchant/([a-zA-Z_-]+)'] = '$1/$1_merchant';
$route['merchant/auth/(:any)'] = 'auth/auth_merchant/$1';
$route['merchant/([a-zA-Z_-]+)/(:any)'] = '$1/$1_merchant/$2';
$route['merchant/(:any)/edit/'.$uuid] = "$1/$1_merchant/add/$2";
$route['merchant/(:any)/(:any)/edit/'.$uuid] = "$1/$1_merchant/add_$2/$3";
$route['merchant/(:any)/(:any)/'.$uuid.'/'.$uuid] = "$1/$1_merchant/$2/$3/$4";
$route['merchant/(:any)/(:any)/'.$uuid.'/'.$uuid.'/'.$uuid] = "$1/$1_merchant/$2/$3/$4/$5";
$route['merchant/(:any)/(:any)/'.$uuid.'/'.$uuid.'/'.$uuid.'/'.$uuid] 
			= "$1/$1_merchant/$2/$3/$4/$5/$6";
$route['merchant/(:any)/(:any)/'.$uuid] = "$1/$1_merchant/$2/$3";
$route['merchant/(:any)/(:any)/(:any)'] = "$1/$1_merchant/$3_$2";
$route['merchant'] = "dashboard/Dashboard_merchant";




$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
