<?php

$config = array();
$ci = & get_instance();
$ci->load->library('session');
require_once( BASEPATH . 'database/DB' . EXT );

$db = & DB();
$user_data = $ci->session->userdata('user_data');
$outlet_data = $ci->session->userdata('outlet_data');
$f_station_id = $ci->session->userdata('f_station_id');
$strHost = CURRENT_DOMAIN;
$strHost = preg_replace('/www./', '', $strHost, 1);
$chack = false;
$is_station = 0;


if (isset($f_station_id) && $f_station_id > 0)
    $station_id = $f_station_id;
else
{
    $station = $ci->uri->segment(1);
    if ($station == 'meny')
        $station_id = $ci->uri->segment(2);
}

 ///define('DEFAULT_MODULE', 'modules');

if (isset($station_id) && !empty($station_id))
{

    $station_id = str_replace('aB-c121dd73d','', $station_id);
    $station_id = str_replace('d83','', $station_id);


    $row = $db->get_where('outlet', array('id' => $station_id))->row();
    
    if (isset($row) && !empty($row)) {
        $is_station = 1;
        $ci->session->set_userdata('f_station_id', $station_id);
        define('DEFAULT_OUTLET', $row->id);
        define('DEFAULT_OUTLET_NAME', $row->name);
        define('DEFAULT_OUTLET_PHONE', $row->phone);
        define('DEFAULT_OUTLET_FACEBOOK', $row->facebook_link);
        define('DEFAULT_ADDRESS', $row->address);
        define('DEFAULT_CITY', $row->city);
        if(!empty($row->city)) {
            $city_record = $db->get_where('city', array('city_name' => strtolower($row->city)))->result_array();
            if(isset($city_record[0]['city_id']) && !empty($city_record[0]['city_id'])) 
                define('DEFAULT_CITY_ID', $city_record[0]['city_id']);
            else
                define('DEFAULT_CITY_ID', "");
        }
        else
            define('DEFAULT_CITY_ID', "");
        define('DEFAULT_COUNTRY', $row->country);
        if(!empty($row->country)) {
            $country_record = $db->get_where('country', array('country_name' => strtolower($row->country)))->result_array();
            if(isset($country_record[0]['c_id']) && !empty($country_record[0]['c_id'])) 
                define('DEFAULT_COUNTRY_ID', $country_record[0]['c_id']);
            else
                define('DEFAULT_COUNTRY_ID', "");
        }
        else
            define('DEFAULT_COUNTRY_ID', "");
        define('DEFAULT_POST_CODE', $row->post_code);
        define('DEFAULT_OUTLET_EMAIL', $row->email);
        define('DEFAULT_LANG', $row->id);
        define('DEFAULT_URL', $row->url);
        define('DEFAULT_OUTLET_FRONT_LOGO', $row->image);
        define('DEFAULT_OUTLET_MOBILE_FRONT_LOGO', $row->adminlogo_small);
        define('DEFAULT_ORGINATION_NO', $row->orgination_no);
        define('DEFAULT_OUTLET_FRONT_FAVICON', $row->fav_icon);
        define('DEFAULT_OUTLET_ADMIN_LOGO', $row->adminlogo);
        define('DEFAULT_OUTLET_ADMIN_LOGO_SMALL', $row->adminlogo_small);
         define('DEFAULT_FACEBOOK_APP_ID', $row->facebook_appId);


    define('DEFAULT_SMTP_USER', $row->smtp_username);
    define('DEFAULT_SMTP_PASSWORD', $row->smtp_password);
    define('DEFAULT_SMTP_HOST', $row->smtp_host);
    define('DEFAULT_SMTP_PORT', $row->smtp_port);
    define('DEFAULT_SENDER_EMAIL', $row->sender_email);

    define('DEFAULT_FACKBOOK', $row->facebook_link);
    define('DEFAULT_TWITTER', $row->twitter_link);
    define('DEFAULT_GOOGLE', $row->googleplus_link);
    define('DEFAULT_LINKEDIN', $row->linkedin_link);
    define('DEFAULT_IOS', $row->ios_store);
    define('DEFAULT_GOOGLE_STORE', $row->google_store);


        define('DEFAULT_TEMPLATE', 'template_facebook');


        //define('DEFAULT_THEME_FRONT', 'light');
    $temp = $theme ="";
    /*list($temp, $theme) = explode('_', $row->template_name);*/
    define('DEFAULT_THEME_FRONT', $theme);
    define('DEFAULT_LIVE', $row->is_live);
        if ($row->is_live == 1)
            define('DEFAULT_MERCHANT', $row->merchant_live); 
        else
            define('DEFAULT_MERCHANT', $row->merchant_test);

/*print'this outlet ===>>'.DEFAULT_OUTLET;
print'<br>this outlet ===>>'.DEFAULT_OUTLET_NAME;*/


}

}


if (isset($outlet_data) && $outlet_data != NULL && $user_data['role'] == 'portal admin' && $is_station == 0) {
  
    $row = $db->get_where('outlet', array('id' => $outlet_data['outlet_id']))->row();
    if (isset($row->parent_id) && !empty($row->parent_id))
    {
        define('DEFAULT_CHILD_OUTLET', $outlet_data['outlet_id']);
        define('DEFAULT_CHILD_OUTLET_NAME', $row->name);
        $row = $db->get_where('outlet', array('id' => $row->parent_id))->row();
        define('DEFAULT_OUTLET', $row->id);
        define('DEFAULT_OUTLET_NAME',  $row->name);
        define('DEFAULT_CHILD', 1);
    }
    else
    {
        define('DEFAULT_OUTLET', $outlet_data['outlet_id']);
        if (isset($outlet_data['outlet_name']))
             define('DEFAULT_OUTLET_NAME', $outlet_data['outlet_name']);
         define('DEFAULT_CHILD', 0);
    }

    define('DEFAULT_OUTLET_EMAIL', $row->email);
    define('DEFAULT_OUTLET_FRONT_LOGO', $row->image);
    define('DEFAULT_OUTLET_MOBILE_FRONT_LOGO', $row->adminlogo_small);
    define('DEFAULT_OUTLET_PHONE', $row->phone);
    define('DEFAULT_OUTLET_FACEBOOK', $row->facebook_link);
    define('DEFAULT_ADDRESS', $row->address);
    define('DEFAULT_CITY', $row->city);
    if(!empty($row->city)) {
        $city_record = $db->get_where('city', array('city_name' => strtolower($row->city)))->result_array();
        if(isset($city_record[0]['city_id']) && !empty($city_record[0]['city_id'])) 
            define('DEFAULT_CITY_ID', $city_record[0]['city_id']);
        else
            define('DEFAULT_CITY_ID', "");
    }
    else
        define('DEFAULT_CITY_ID', "");
    define('DEFAULT_COUNTRY', $row->country);
    if(!empty($row->country)) {
        $country_record = $db->get_where('country', array('country_name' => strtolower($row->country)))->result_array();
        if(isset($country_record[0]['c_id']) && !empty($country_record[0]['c_id'])) 
            define('DEFAULT_COUNTRY_ID', $country_record[0]['c_id']);
        else
            define('DEFAULT_COUNTRY_ID', "");
    }
    else
        define('DEFAULT_COUNTRY_ID', "");

    define('DEFAULT_POST_CODE', $row->post_code);
    define('DEFAULT_OUTLET_FRONT_FAVICON', $row->fav_icon);


    define('DEFAULT_SMTP_USER', $row->smtp_username);
    
    define('DEFAULT_SMTP_PASSWORD', $row->smtp_password);
    define('DEFAULT_SMTP_HOST', $row->smtp_host);
    define('DEFAULT_SMTP_PORT', $row->smtp_port);
    define('DEFAULT_SENDER_EMAIL', $row->sender_email);


    define('DEFAULT_FACKBOOK', $row->facebook_link);
    define('DEFAULT_TWITTER', $row->twitter_link);
    define('DEFAULT_GOOGLE', $row->googleplus_link);
    define('DEFAULT_LINKEDIN', $row->linkedin_link);
    define('DEFAULT_IOS', $row->ios_store);
    define('DEFAULT_GOOGLE_STORE', $row->google_store);
   
    define('DEFAULT_ORGINATION_NO', $row->orgination_no);

    define('DEFAULT_LIVE', $row->is_live);
    if ($row->is_live == 1)
        define('DEFAULT_MERCHANT', $row->merchant_live); 
    else
        define('DEFAULT_MERCHANT', $row->merchant_test);

    


    define('DEFAULT_URL', $strHost);

    if ( $strHost == 'jimspizza.no' )
    	define('DEFAULT_TEMPLATE', 'template_light_v2');
    else
    	define('DEFAULT_TEMPLATE', $row->template_name);

    $temp = $theme ="";
    /*list($temp, $theme) = explode('_', $row->template_name);*/
    define('DEFAULT_THEME_FRONT', $theme);

    $chack = true;
} else if (isset($user_data) && $user_data != NULL  && $is_station == 0) {
    $row = $db->get_where('outlet', array('id' => $user_data['outlet_id']))->row();
    if (isset($row->parent_id) && !empty($row->parent_id))
    {
        define('DEFAULT_CHILD', 1);
        define('DEFAULT_CHILD_OUTLET', $user_data['outlet_id']);
        define('DEFAULT_CHILD_OUTLET_NAME', $row->name);
        $row = $db->get_where('outlet', array('id' => $row->parent_id))->row();
        define('DEFAULT_OUTLET', $row->id);
        define('DEFAULT_OUTLET_NAME',  $row->name);
    }
    else
    {
        define('DEFAULT_CHILD', 0);
        define('DEFAULT_OUTLET', $user_data['outlet_id']);
        if (isset($user_data['outlet_name']))
             define('DEFAULT_OUTLET_NAME', $user_data['outlet_name']);
        
    }
    define('DEFAULT_LANG', 1);
    define('DEFAULT_OUTLET_EMAIL', $row->email);
    define('DEFAULT_OUTLET_PHONE', $row->phone);
    define('DEFAULT_OUTLET_FACEBOOK', $row->facebook_link);
    define('DEFAULT_ADDRESS', $row->address);
    define('DEFAULT_CITY', $row->city);
    if(!empty($row->city)) {
        $city_record = $db->get_where('city', array('city_name' => strtolower($row->city)))->result_array();
        if(isset($city_record[0]['city_id']) && !empty($city_record[0]['city_id'])) 
            define('DEFAULT_CITY_ID', $city_record[0]['city_id']);
        else
            define('DEFAULT_CITY_ID', "");
    }
    else
        define('DEFAULT_CITY_ID', "");
    define('DEFAULT_COUNTRY', $row->country);
    if(!empty($row->country)) {
        $country_record = $db->get_where('country', array('country_name' => strtolower($row->country)))->result_array();
        if(isset($country_record[0]['c_id']) && !empty($country_record[0]['c_id'])) 
            define('DEFAULT_COUNTRY_ID', $country_record[0]['c_id']);
        else
            define('DEFAULT_COUNTRY_ID', "");
    }
    else
        define('DEFAULT_COUNTRY_ID', "");
    define('DEFAULT_POST_CODE', $row->post_code);
    define('DEFAULT_OUTLET_FRONT_LOGO', $row->image);
    define('DEFAULT_OUTLET_MOBILE_FRONT_LOGO', $row->adminlogo_small);

    define('DEFAULT_OUTLET_FRONT_FAVICON', $row->fav_icon);


    define('DEFAULT_SMTP_USER', $row->smtp_username);
    define('DEFAULT_SMTP_PASSWORD', $row->smtp_password);
    define('DEFAULT_SMTP_HOST', $row->smtp_host);
    define('DEFAULT_SMTP_PORT', $row->smtp_port);
    define('DEFAULT_SENDER_EMAIL', $row->sender_email);

    define('DEFAULT_FACKBOOK', $row->facebook_link);
    define('DEFAULT_TWITTER', $row->twitter_link);
    define('DEFAULT_GOOGLE', $row->googleplus_link);
    define('DEFAULT_LINKEDIN', $row->linkedin_link);
    define('DEFAULT_IOS', $row->ios_store);
    define('DEFAULT_GOOGLE_STORE', $row->google_store);
    define('DEFAULT_ORGINATION_NO', $row->orgination_no);
    define('DEFAULT_FACEBOOK_APP_ID', $row->facebook_appId);

    define('DEFAULT_URL', $strHost);
    
    if ( $strHost == 'jimspizza.no' )
    	define('DEFAULT_TEMPLATE', 'template_light_v2');
    else
    	define('DEFAULT_TEMPLATE', $row->template_name);


    $temp = $theme ="";
    /*list($temp, $theme) = explode('_', $row->template_name);*/
    define('DEFAULT_THEME_FRONT', $theme);
    define('DEFAULT_LIVE', $row->is_live);
    if ($row->is_live == 1)
        define('DEFAULT_MERCHANT', $row->merchant_live); 
    else
        define('DEFAULT_MERCHANT', $row->merchant_test);



    $chack = true;
}else if( $is_station == 0) {
    //echo 'here in 3'; //exit;
    $row = $db->get_where('outlet', array('url' => $strHost))->row();
    //echo '<pre>'; print_r($row); exit();
    if (isset($row) && !empty($row)) {

        $row_child = $db->get_where('outlet', array('parent_id' => $row->id, 'status' => '1'))->row();
        if (isset($row_child) && !empty($row_child)) define('DEFAULT_CHILD', '1');
        else define('DEFAULT_CHILD', '0');

        define('DEFAULT_OUTLET', $row->id);
        define('DEFAULT_OUTLET_NAME', $row->name);
        define('DEFAULT_OUTLET_PHONE', $row->phone);
        define('DEFAULT_OUTLET_FACEBOOK', $row->facebook_link);
        define('DEFAULT_ADDRESS', $row->address);
        define('DEFAULT_CITY', $row->city);
        if(!empty($row->city)) {
            $city_record = $db->get_where('city', array('city_name' => strtolower($row->city)))->result_array();
            if(isset($city_record[0]['city_id']) && !empty($city_record[0]['city_id'])) 
                define('DEFAULT_CITY_ID', $city_record[0]['city_id']);
            else
                define('DEFAULT_CITY_ID', "");
        }
        else
            define('DEFAULT_CITY_ID', "");
        define('DEFAULT_COUNTRY', $row->country);
        if(!empty($row->country)) {
            $country_record = $db->get_where('country', array('country_name' => strtolower($row->country)))->result_array();
            if(isset($country_record[0]['c_id']) && !empty($country_record[0]['c_id'])) 
                define('DEFAULT_COUNTRY_ID', $country_record[0]['c_id']);
            else
                define('DEFAULT_COUNTRY_ID', "");
        }
        else
            define('DEFAULT_COUNTRY_ID', "");
        define('DEFAULT_POST_CODE', $row->post_code);
        define('DEFAULT_OUTLET_EMAIL', $row->email);
        define('DEFAULT_LANG', $row->id);
        define('DEFAULT_URL', $strHost);
        define('DEFAULT_OUTLET_FRONT_LOGO', $row->image);
        define('DEFAULT_OUTLET_MOBILE_FRONT_LOGO', $row->adminlogo_small);

        define('DEFAULT_ORGINATION_NO', $row->orgination_no);
        
        define('DEFAULT_OUTLET_FRONT_FAVICON', $row->fav_icon);
        define('DEFAULT_OUTLET_ADMIN_LOGO', $row->adminlogo);
        define('DEFAULT_OUTLET_ADMIN_LOGO_SMALL', $row->adminlogo_small);

         define('DEFAULT_FACEBOOK_APP_ID', $row->facebook_appId);


    define('DEFAULT_SMTP_USER', $row->smtp_username);
    define('DEFAULT_SMTP_PASSWORD', $row->smtp_password);
    define('DEFAULT_SMTP_HOST', $row->smtp_host);
    define('DEFAULT_SMTP_PORT', $row->smtp_port);
    define('DEFAULT_SENDER_EMAIL', $row->sender_email);

    define('DEFAULT_FACKBOOK', $row->facebook_link);
    define('DEFAULT_TWITTER', $row->twitter_link);
    define('DEFAULT_GOOGLE', $row->googleplus_link);
    define('DEFAULT_LINKEDIN', $row->linkedin_link);
    define('DEFAULT_IOS', $row->ios_store);
    define('DEFAULT_GOOGLE_STORE', $row->google_store);

     define('DEFAULT_LIVE', $row->is_live);
     
     if ( $strHost == 'jimspizza.no' )
    	define('DEFAULT_TEMPLATE', 'template_light_v2');
     else
    	define('DEFAULT_TEMPLATE', $row->template_name);
       $temp = $theme ="";
       /*list($temp, $theme) = explode('_', $row->template_name);*/
       $theme= "";
        define('DEFAULT_THEME_FRONT', $theme);
        if ($row->is_live == 1)
            define('DEFAULT_MERCHANT', $row->merchant_live); 
        else
            define('DEFAULT_MERCHANT', $row->merchant_test);


        /*  $bglogo=" "; $bgloginfooter=" ";
          if( isset($row->admin_logologin_background) ) $bglogo="background-color:".$row->admin_logologin_background;
          define('DEFAULT_OUTLET_ADMIN_LOGO_BACKGROUND', $bglogo);
          if( isset($row->admin_loginfooter_background) ) $bgloginfooter="background-color:".$row->admin_loginfooter_background;
          define('DEFAULT_OUTLET_ADMIN_LOGIN_FOOTER_BACKGROUND', $row->admin_loginfooter_background);
         */
    } else {
      //  echo 'here in 3';exit;
        echo '<h2>Invalid URL! Contact to administrator.</h2>';
        exit;
    }
}

$where4['outlet_id'] = DEFAULT_OUTLET;
$db->where($where4);
$row4 = $db->get('general_setting')->row();


define('ITEM_PRICE_VAT_INCLUDED_PERCENTAGE', 15);

if (count($row4) > 0) {
    define('DEFAULT_LANGUAGE', $row4->language);
    define('DEFAULT_CURRENCY_CODE', 'GBP');
    define('DEFAULT_THEME', $row4->theme);
    define('DEFAULT_LOGO', $row4->image);

    define('TAKE_IN_VAT', $row4->take_in_vat);
    define('TAKE_OUT_VAT', $row4->take_out_vat);
    define('DELIVERY_CHARGES', $row4->delivery_charges);
    define('DELIVERY_CHARGES_VAT', $row4->delivery_charges_vat);

    define('DELIVERY_FIXED', $row4->is_fixed_delivery);
    define('FREE_DELIVERY_LIMIT', $row4->free_delivery_limit);

    define('IS_FREE_DELIVERY', $row4->is_free_delivery);

    define('DELIVERY_TIME', $row4->delivery_time);

    define('ALLOW_COUPON', $row4->is_coupon);
    define('DELIVERY_LIMIT', $row4->delivery_limit);

    define('DEFAULT_TAKE_IN', $row4->take_in);
    define('DEFAULT_TAKE_OUT', $row4->take_out);
    define('DEFAULT_DELIVERY', $row4->delivery);
    define('DEFAULT_IS_CASH_ON_DELIVERY', $row4->is_cash_on_delivery);
    define('DEFAULT_IS_ONLINE_CASH', $row4->is_online_cash);
    
        

    if ($row4->date_format > 0)
        define('DEFAULT_DATE_FORMAT', $row4->date_format);
    else
        define('DEFAULT_DATE_FORMAT', 1);
    if ($row4->time_format > 0)
        define('DEFAULT_TIME_FORMAT', $row4->time_format);
    else
        define('DEFAULT_TIME_FORMAT', 1);
}else {
    define('DEFAULT_CURRENCY', 14);
    define('DEFAULT_LOGO', 'logo_1_logo.png');
    // define('DEFAULT_COUNTRY', 235);
    define('DEFAULT_THEME', 'a');
    define('DEFAULT_DATE_FORMAT', 1);
    define('DEFAULT_TIME_FORMAT', 1);
    define('TAKE_IN_VAT', 25);
    define('TAKE_OUT_VAT', 15);
    define('DELIVERY_CHARGES', 69);
    define('DELIVERY_CHARGES_VAT', 25);
    define('DELIVERY_FIXED', 1);
    //define('DELIVERY_TIME', '60-75 min');
}