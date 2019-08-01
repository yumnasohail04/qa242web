<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/


// User Constants
////////////////// ADMIN ///////////////  http://punjabitikka.no/
define('CURRENT_DOMAIN', $_SERVER['HTTP_HOST']);

$strHost = $_SERVER['SERVER_NAME'];

$strHost = preg_replace('/www./', '', $strHost, 1);
$_SERVER['HTTP_HOST'] = preg_replace('/www./', '', $_SERVER['HTTP_HOST'], 1);
$folder =  substr($_SERVER['HTTP_HOST'], 0, (strpos($_SERVER['HTTP_HOST'], '.')));

if (empty($folder) )
	$folder = 'heyfood';

if (strpos($_SERVER['HTTP_HOST'], '.') > 0 && $_SERVER['HTTP_HOST'] != '192.168.2.50')
{
	$localname='';
}
else
	$localname='qa/';

$prefix = 'https';

define('BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname);
define('BASE_URL_FRONT', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname);
define('IMAGE_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'uploads/');
define('CAPTCHA_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'captcha/');
define('ADMIN_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'admin/');
define('STATIC_ADMIN_CSS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/css/');;
define('STATIC_ADMIN_JS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/js/');
define('STATIC_ADMIN_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/images/');
define('STATIC_FRONT_OUTLET_CSS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/'.$folder.'/css/');

define('STATIC_FRONT_CSS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/css/');
define('STATIC_FRONT_FONT', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/font/');
define('STATIC_FRONT_JS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/js/');
define('STATIC_FRONT_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/images/');
define('STATIC_FRONT_IMAGE_RESOURCES', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/images/resource/');
define('CSS_FILES', FCPATH.'static/front/theme1\css/');
define('IMAGE_BASE_URL_ITEMS', FCPATH.'uploads/items/');
define('THEMES_BASE_URL', FCPATH.'static/front/');
define('TEMPLATES_BASE_URL', FCPATH.'application/modules/');




define('STATIC_FRONT_CSS_QUICKFOOD', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/static/front/quickfood/css/');
	define('STATIC_FRONT_JS_QUICKFOOD', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/static/front/quickfood/js/');
	define('STATIC_FRONT_IMAGE_QUICKFOOD', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$folder.'/static/front/quickfood/images/');




define('FIRE_BASE_API_KEY', "AAAAcjF7XsU:APA91bGrxnBqSvAPC1fRyxgw28Ng8khfT9Io4GWz3d5xglN04IlFhxc0VJ7LklqS21DoBPSNjUbVr2RCp2WmqJMN3EkrJhyy0GEZRmIBanQVGdoXHtUcMzyArSYGDfFCUhI48lgkDD8K");

define('INSIGHTS_STATIC_IMAGE', 'Patteren Food.jpg');
//define('STATIC_FRONT_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/images/');


define('ANALYTIC_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'analytic/');
define('STATIC_ANALYTIC_CSS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/analytic/css/');
define('STATIC_ANALYTIC_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/analytic/images/');
define('STATIC_ANALYTIC_JS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/analytic/js/');



define('ACTUAL_ADS_OUTLET_IMAGE_PATH', 'uploads/ads_outlet/actual_images/');
define('LARGE_ADS_OUTLET_IMAGE_PATH',  'uploads/ads_outlet/large_images/');
define('MEDIUM_ADS_OUTLET_IMAGE_PATH', 'uploads/ads_outlet/medium_images/');
define('SMALL_ADS_OUTLET_IMAGE_PATH', 'uploads/ads_outlet/small_images/');

define('ACTUAL_OUTLET_USER_IMAGE_PATH', 'uploads/outlet-user/actual-images/');
define('LARGE_OUTLET_USER_IMAGE_PATH',  'uploads/outlet-user/large-images/');
define('MEDIUM_OUTLET_USER_IMAGE_PATH', 'uploads/outlet-user/medium-images/');
define('SMALL_OUTLET_USER_IMAGE_PATH', 'uploads/outlet-user/small-images/');


define('TEXT_BOX_RANGE', 100);



/******************************/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */

/* Location: ./application/config/constants.php */