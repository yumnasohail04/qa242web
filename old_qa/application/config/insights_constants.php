<?php

$config = array();
$ci = & get_instance();
$ci->load->library('session');
require_once( BASEPATH . 'database/DB' . EXT );

$db = & DB();
$user_data = $ci->session->userdata('insights_user');
$strHost = CURRENT_DOMAIN;
$strHost = preg_replace('/www./', '', $strHost, 1);
	if(isset($ci->session->userdata['insights_user']) && !empty($ci->session->userdata['insights_user'])) {
		if(isset($ci->session->userdata['insights_user']['outlet_id']) && !empty($ci->session->userdata['insights_user']['outlet_id']) && is_numeric($ci->session->userdata['insights_user']['outlet_id'])) 
			define('INSIGHTS_OUTLET', $ci->session->userdata['insights_user']['outlet_id']);
		else
			define('INSIGHTS_OUTLET', "");
		if(isset($ci->session->userdata['insights_user']['timezones']) && !empty($ci->session->userdata['insights_user']['timezones'])) 
			define('INSIGHTS_TIMEZONE', $ci->session->userdata['insights_user']['timezones']);
		else
			define('INSIGHTS_TIMEZONE', "Asia/Karachi");
		if(isset($ci->session->userdata['insights_user']['user_id']) && !empty($ci->session->userdata['insights_user']['user_id']) && is_numeric($ci->session->userdata['insights_user']['user_id']))
			define('INSIGHTS_USER', $ci->session->userdata['insights_user']['user_id']);
		else
			define('INSIGHTS_USER', "");
		if(isset($ci->session->userdata['insights_user']['role_id']) && !empty($ci->session->userdata['insights_user']['role_id']) && is_numeric($ci->session->userdata['insights_user']['role_id']))
			define('INSIGHTS_ROLE_ID', $ci->session->userdata['insights_user']['role_id']);
		else
			define('INSIGHTS_ROLE_ID', "");
		if(isset($ci->session->userdata['insights_user']['name']) && !empty($ci->session->userdata['insights_user']['name']) && is_numeric($ci->session->userdata['insights_user']['name']))
			define('INSIGHTS_NAME', $ci->session->userdata['insights_user']['name']);
		else
			define('INSIGHTS_NAME', "");
		if(isset($ci->session->userdata['insights_user']['role']) && !empty($ci->session->userdata['insights_user']['role']) && is_numeric($ci->session->userdata['insights_user']['role']))
			define('INSIGHTS_ROLE', $ci->session->userdata['insights_user']['role']);
		else
			define('INSIGHTS_ROLE', "");
		if(isset($ci->session->userdata['insights_user']['user_email']) && !empty($ci->session->userdata['insights_user']['user_email']) && is_numeric($ci->session->userdata['insights_user']['user_email']))
			define('INSIGHTS_USER_EMAIL', $ci->session->userdata['insights_user']['user_email']);
		else
			define('INSIGHTS_USER_EMAIL', "");
		if(isset($ci->session->userdata['insights_user']['user_name']) && !empty($ci->session->userdata['insights_user']['user_name']) && is_numeric($ci->session->userdata['insights_user']['user_name']))
			define('INSIGHTS_USER_NAME', $ci->session->userdata['insights_user']['user_name']);
		else
			define('INSIGHTS_USER_NAME', "");
		if(isset($ci->session->userdata['insights_user']['device']) && !empty($ci->session->userdata['insights_user']['device']) && is_numeric($ci->session->userdata['insights_user']['device']))
			define('INSIGHTS_DEVICE', $ci->session->userdata['insights_user']['device']);
		else
			define('INSIGHTS_DEVICE', "");
		if(isset($ci->session->userdata['insights_user']['last_login']) && !empty($ci->session->userdata['insights_user']['last_login']) && is_numeric($ci->session->userdata['insights_user']['last_login']))
			define('INSIGHTS_LAST_LOGIN', $ci->session->userdata['insights_user']['last_login']);
		else
			define('INSIGHTS_LAST_LOGIN', "");
	}
	else {
		define('INSIGHTS_TIMEZONE', "Asia/Karachi");
		define('INSIGHTS_OUTLET', "");
		define('INSIGHTS_USER', "");
		define('INSIGHTS_ROLE_ID', "");
		define('INSIGHTS_NAME', "");
		define('INSIGHTS_ROLE', "");
		define('INSIGHTS_USER_EMAIL', "");
		define('INSIGHTS_USER_NAME', "");
		define('INSIGHTS_DEVICE', "");
		define('INSIGHTS_LAST_LOGIN', "");
	}
?>