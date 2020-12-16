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
	$folder = 'lantix';

if (strpos($_SERVER['HTTP_HOST'], '.') > 0 && $_SERVER['HTTP_HOST'] != '192.168.2.50')
{
	$localname='';
}
else
	$localname='qa242web/';
	$prefix = 'https';
	if( strtolower($strHost) == 'localhost')
		$prefix = 'http';
	define('BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname);
	define('BASE_URL_FRONT', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname);
	define('IMAGE_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'uploads/');
	define('CAPTCHA_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'captcha/');
	define('ADMIN_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'admin/');
	define('STATIC_ADMIN_CSS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/css/');;
	define('STATIC_ADMIN_JS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/js/');
	define('STATIC_ADMIN_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/images/');
	define('STATIC_ADMIN_FONT', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/theme1/fonts/');
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
	
	
	
	
	define('FIRE_BASE_API_KEY', "AAAAZPpUz6U:APA91bHhJVWRU7T1UvKXeiJgC7fQJLqgMVZ1q7gJkVfecrdKSaxCcNdcCK8AzihdBvnq3SQFCZuwH5B1qBEUMTFP3Au1vqwFzutGBB_Ehdks6OcWs61vjmvHEJJkahNXXViAeOaYnb95");
	
	define('INSIGHTS_STATIC_IMAGE', 'Patteren Food.jpg');
	//define('STATIC_FRONT_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/front/theme1/images/');
	
	
	define('ANALYTIC_BASE_URL', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'analytic/');
	define('STATIC_ANALYTIC_CSS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/analytic/css/');
	define('STATIC_ANALYTIC_IMAGE', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/analytic/images/');
	define('STATIC_ANALYTIC_JS', $prefix.'://'.$_SERVER['HTTP_HOST'].'/'.$localname.'static/admin/analytic/js/');
	
	define('SUPPLIER_DOCUMENTS_PATH', 'uploads/supplier_documents/');
	define('INGREDIENT_DOCUMENTS_PATH', 'uploads/ingredient_documents/');
	
	
	define('ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH', 'uploads/assignment_files/actual_images/');
	define('LARGE_ASSIGNMENT_ANSWER_IMAGE_PATH',  'uploads/assignment_files/large_images/');
	define('MEDIUM_ASSIGNMENT_ANSWER_IMAGE_PATH', 'uploads/assignment_files/medium_images/');
	define('SMALL_ASSIGNMENT_ANSWER_IMAGE_PATH', 'uploads/assignment_files/small_images/');
	
	
	define('ACTUAL_STATIC_ASSIGNMENT_ANSWER_IMAGE_PATH', 'uploads/static_files/actual_images/');
	define('LARGE_STATIC_ASSIGNMENT_ANSWER_IMAGE_PATH',  'uploads/static_files/large_images/');
	define('MEDIUM_STATIC_ASSIGNMENT_ANSWER_IMAGE_PATH', 'uploads/static_files/medium_images/');
	define('SMALL_STATIC_ASSIGNMENT_ANSWER_IMAGE_PATH', 'uploads/static_files/small_images/');
	
	define('ACTUAL_OUTLET_USER_IMAGE_PATH', 'uploads/outlet-user/actual-images/');
	define('LARGE_OUTLET_USER_IMAGE_PATH',  'uploads/outlet-user/large-images/');
	define('MEDIUM_OUTLET_USER_IMAGE_PATH', 'uploads/outlet-user/medium-images/');
	define('SMALL_OUTLET_USER_IMAGE_PATH', 'uploads/outlet-user/small-images/');
	
	
	define('ACTUAL_SIGNATURE_IMAGE_PATH', 'uploads/signature/actual-images/');
	define('LARGE_SIGNATURE_IMAGE_PATH',  'uploads/signature/large-images/');
	define('MEDIUM_SIGNATURE_IMAGE_PATH', 'uploads/signature/medium-images/');
	define('SMALL_SIGNATURE_IMAGE_PATH', 'uploads/signature/small-images/');
	
	define('ACTUAL_ING_FORM_IMAGE_PATH', 'uploads/ingredient_form/actual_images/');
	define('LETTER_OF_CONFORMANCE_PATH', 'uploads/letter/');
	
	define('CARRIER_DOCUMENTS_PATH', 'uploads/carrier/');
	
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