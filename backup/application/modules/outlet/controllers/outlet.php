<?php

/* * ***********************************************
  Created By: Akabir Abbasi
  Dated: 01-01-2014
 * *********************************************** */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Outlet extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('file');
        //Modules::run('site_security/is_login');
        //Modules::run('site_security/has_permission');
    }

    ///////////////////////////////////////////////////////////////////////

    function index() {
        $data['outlet'] = $this->_get_all_details_admin('id desc')->result_array();
        $data['view_file'] = 'outlet';
        $this->load->module('template');
        $this->template->admin($data);
    }

    ///////////////////////////////////////////////////////////////////////

    function load_listing() {
        $data['outlet'] = $this->_get_all_details_admin('id desc')->result_array();
        $this->load->view('outlet_listing', $data);
    }

    function _get_by_arr_id_post_code_delivery($arr_col, $order_by = 'id asc') {
        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->_get_by_arr_id_post_code_delivery($arr_col, $order_by);
    }

    ///////////////////////////////////////////////////////////////////////

    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['outlet'] = $this->_get_data_from_db($update_id);
                $data['new']=array();
            $outlet_id=$update_id;
            $data['new'] = Modules::run('seo/_get_data_from_db_seo','',$outlet_id,'Outlet');
            $data['arr_templates'] = $this->_list_templates();
            $where['outlet_id']=$update_id;
            $data['outlet_types']=$this->_get_outlet_catagories($where)->result_array();
        } else {
            $data['outlet'] = $this->_get_data_from_post();
            $data['new']=$this->get_data_from_post_seo();
            $data['arr_templates'] = $this->_list_templates();
        }
        $parent_id = 0;
        $service_data=array();
        $services = array();
        $data['restaurant_type'] = Modules::run('catagories/_get', $parent_id ,'id desc')->result_array();
         $dietary=array();
        $dietary_data=Modules::run('slider/_get_where_cols',array("dietary_status" =>'1'),'dietary_id desc','dietary','dietary_id,dietary_name');
        foreach ($dietary_data->result() as $row) {    $dietary[$row->dietary_id] = $row->dietary_name;    }
        $service_data=Modules::run('slider/_get_where_cols',array(),'id desc','outlet_features','outlet_features.*');
        foreach ($service_data->result() as $row) {    $services[$row->id] = $row->features;    }
        $query3= Modules::run('slider/_get_where_cols',array("c_status"=>"1"),'c_id desc','country','country_name');
        $country_data=array();
        foreach ($query3->result() as
                    $country) {
            $country_data[strtolower($country->country_name)] = strtolower($country->country_name);
        }
        $data['country_option']=$country_data;

        $data['dietary']=$dietary;
        $data['service_data']=$services;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'outletform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
        function get_data_from_post_seo()
        {
            $data['seo_link'] = $this->input->post('seo_link');
            $data['seo_meta_keyword'] = $this->input->post('seo_meta_keyword');
            $data['seo_meta_description'] = $this->input->post('seo_meta_description');
            $data['seo_meta_title'] = $this->input->post('seo_meta_title');
            $data['seo_function_name'] = $this->input->post('seo_function_name');
            return $data;
        }

    function _list_templates() {
        $temps = glob(TEMPLATES_BASE_URL . 'template_*');
        $data = array();
        foreach ($temps as $key => $value) {
            $value = basename($value);
            $data[$value] = $value;
        }
        return $data;
    }
    function country_cities(){
        $country_data=array();
        $data['check'] = 'city';
        $coutnry_id= $this->input->post('id');
        $data['selected']= $this->input->post('selected');
        $country= Modules::run('api/get_specific_table_data',array("country_name"=>strtolower($coutnry_id),"c_status"=>"1"),'c_id desc','c_id','country','1','1')->result_array();
        if(isset($country[0]['c_id']) && !empty($country[0]['c_id'])) {
            $city_data= Modules::run('api/get_specific_table_data',array("c_id"=>$country[0]['c_id'],"city_status"=>"1"),'city_id desc','city_name','city','1','0');
            $data['country_option'] = array();
            foreach ($city_data->result() as
                        $country) {
                $country_data[strtolower($country->city_name)] = strtolower($country->city_name);
            }
        }
        $data['country_option']=$country_data;
        $this->load->view('city_select',$data);
    }

    /////////////////////////// To Edit the CSS ///////////////////////////

    function edit_css() {
        $id = $this->uri->segment(4);
        $query = $this->_get_by_arr_id(array('id' => $id))->result_array()[0];
        $name = explode('.', $query['url'])[0];
        $file = $query['template_name'];
        $file = explode('_', $file)[1];
        $file_data = file_get_contents(THEMES_BASE_URL . $name . '/css/' . $file . '.css');
        $data['id'] = $id;
        $data['css_data'] = $file_data;
        $data['view_file'] = 'edit_css';
        $this->load->module('template');
        $this->template->admin_form($data);
    }

    function save_css() {
        $id = $this->uri->segment(4);
        $query = $this->_get_by_arr_id(array('id' => $id))->result_array()[0];
        $name = explode('.', $query['url'])[0];
        $file = $query['template_name'];
        $file = explode('_', $file)[1];
        $text = $this->input->post('text');
        write_file(THEMES_BASE_URL . $name . '/css/' . $file . '.css', $text);
        $this->session->set_flashdata('message', 'Stylesheet' . ' ' . DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'outlet/edit_css/' . $id);
    }

    ///////////////////////////////////////////////////////////////////////

    function submit() {
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtBuildingName', 'Bulding Name', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            $dataseo=$this->get_data_from_post_seo();
            if (is_numeric($update_id) && $update_id != 0) {
                $where['id'] = $update_id;
                $itemInfo = $this->_getItemById($update_id);

                // $this->_rename_theme_folder($update_id, $data['url']);
                $old_data = $this->_get_data_from_db($update_id);
                $outlet_cover_image = $old_data['outlet_cover_image'];
                unset($old_data['outlet_cover_image']);
                $this->_update($where, $data);
                    $dataseo['id']=" ";
                    $dataseo['outlet_id']=$update_id;
                    $dataseo['product_type']="Outlet";
                    Modules::run('seo/seo_insert_data', $dataseo);
               ///////////////////////////umar apis start/////////////////////////
                $where_outlet['outlet_id']= $update_id;
                $outlet_cat=$this->get_outlet_catagory_from_post($update_id);
                $this->_delete_outlet_catagories($where_outlet);
                if(!empty($outlet_cat))
                    $this->_insert_outlet_catagories($outlet_cat);
                /////////////////by asad outlet services function
                $this->delete_dietary(array("outlet_id"=>$update_id),'outlet_facilities');
                $this->insert_services($update_id);

                ////////////////////////
                $this->delete_dietary(array("od_outlet_id"=>$update_id),'outlet_dietary');
                $this->insert_dietary($update_id);
                if(isset($_FILES['outlet_cover_image']) && !empty($_FILES['outlet_cover_image'])) {
                    if(isset($old_data['outlet_cover_image']) && !empty($old_data['outlet_cover_image']))
                        Modules::run("api/delete_images_by_name",ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$old_data['outlet_cover_image']);
                    if($_FILES['outlet_cover_image']['size']>0) {
                        Modules::run("api/upload_dynamic_image",ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$update_id,"outlet_cover_image","outlet_cover_image","id","outlet");
                    }
                }
                ///////////////////////////end umar apis/////////////////////////
                unset($old_data['outlet_cover_image']);
                $this->_update_theme_data($update_id, $data, $old_data);

                //$res_logo = $this->_handle_logo($update_id, $itemInfo);
                $res_front_logo = $this->_handle_front_logo($update_id, $itemInfo);
                $res_fav_icon = $this->_handle_fav_icon($update_id, $itemInfo);
                $this->_handle_admin_logo($update_id, $itemInfo);

                $this->session->set_flashdata('message', 'Outlet' . ' ' . DATA_UPDATED);
                $this->session->set_flashdata('status', 'success');
            } else {
              $data = $this->_get_data_from_post();
                $id = $this->_insert($data);

                 $dataseo=$this->get_data_from_post_seo();
                    $dataseo['id']="";
                    $dataseo['outlet_id']=$id;
                    $dataseo['product_type']="Outlet";
                    Modules::run('seo/seo_insert_data', $dataseo);
                
                ///////////////////////////umar apis start/////////////////////////
                $outlet_cat=$this->get_outlet_catagory_from_post($id);
                if(!empty($outlet_cat))
                    $this->_insert_outlet_catagories($outlet_cat);
                $this->insert_dietary($id);
                //////////////asad
                $this->insert_services($id);

                /////////////asad//////
                if(isset($_FILES['outlet_cover_image']) && !empty($_FILES['outlet_cover_image'])) {
                    if($_FILES['outlet_cover_image']['size']>0) {
                        Modules::run("api/upload_dynamic_image",ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$id,"outlet_cover_image","outlet_cover_image","id","outlet");
                    }
                }
                ///////////////////////////end umar apis/////////////////////////

                $this->_initialize_theme_data($id, $data);

                $this->upload_front_logo($id);
                $this->upload_fav_icon($id);

                $hdn_image = $data['adminlogo'];
                $outlet_file = 'outlet_adminlogo';
                $db_colname = 'adminlogo';
                //print'this ===>>';exit;
                $this->upload_image_adminlogo($id, $hdn_image, $outlet_file, $db_colname);

                $hdn_image = $data['adminlogo_small'];
                $outlet_file = 'outlet_adminlogo_small';
                $db_colname = 'adminlogo_small';
                $this->upload_image_adminlogo($id, $hdn_image, $outlet_file, $db_colname);

                $data['outlet'] = $this->_get()->result_array();
                $this->session->set_flashdata('message', 'Outlet' . ' ' . DATA_SAVED);
                $this->session->set_flashdata('status', 'success');
                $this->load->model('mdl_outlet');
                $this->mdl_outlet->_create_tables($id);
            }
        }
        // exit;
        redirect(ADMIN_BASE_URL . 'outlet');
    }
     function get_outlet_catagory_from_post($id){
        $catagory=$this->input->post('restaurant_type');
        $i=0;
        $data=array();
        if(!empty($catagory)) {
            foreach ($catagory as $key => $value) {
               $data[$i]['outlet_id']=$id;
               $data[$i]['outlet_catagory']=$value;
                $i=$i+1;
            }
        }
        return $data;
    }

    function insert_dietary($id) {
        $dietary= $this->input->post('dietary');
        if(!empty($dietary)) {
            foreach ($dietary as $key => $value) {
                $this->insert_dietary_data(array("od_outlet_id"=>$id,"od_dietary_id" =>$value));
            }
        }
    }
    function insert_services($id) {
        $services= $this->input->post('services');
        if(!empty($services)) {
            foreach ($services as $key => $value) {
                $this->insert_services_data(array("outlet_id"=>$id,"feature_id" =>$value));
            }
        }
    }
    function _get_name_from_url_by_id($id){
        $id = array('id' => $id);
        $cols = array('url');
        $this->load->model('mdl_outlet');
        $data = $this->mdl_outlet->_get_cols_by_id($id, $cols)->result_array()[0];
        $name = explode('.', $data['url'])[0];
        return $name;
    }

    function _rename_theme_folder($id, $url){
        $old_name = $this->_get_name_from_url_by_id($id);
        $new_name = explode('.', $url)[0];

        echo THEMES_BASE_URL . $old_name." = ".strlen($old_name)."<br>";
        echo THEMES_BASE_URL . $new_name." = ".strlen($new_name);
        // rename(THEMES_BASE_URL . $old_name, THEMES_BASE_URL . $new_name);
        // shell_exec("mv ".THEMES_BASE_URL . $old_name." ".THEMES_BASE_URL . $new_name);
        // exit;
    }

    function _initialize_theme_data($id, $data) {

        $template_name = explode('_', $data['template_name'])[1];

        $name = explode('.', $data['url'])[0];
       
        mkdir(IMAGE_BASE_URL_ITEMS . "actual_images/" . $id);
        mkdir(IMAGE_BASE_URL_ITEMS . "actual_images/" . $id . "/images");
        mkdir(THEMES_BASE_URL . $name);
        mkdir(THEMES_BASE_URL . $name . '/css');
        copy(THEMES_BASE_URL . $template_name . "/css/" . $template_name . ".css", THEMES_BASE_URL . $name . '/css/' . $template_name . ".css");
        $this->_recurse_copy(THEMES_BASE_URL . $template_name . "/images", THEMES_BASE_URL . $name . "/images");
    }

    function _update_theme_data($id, $data, $old_data) {
        $old_name = $old_data['template_name'];
        $new_name = $data['template_name'];
        $is_confirm = $this->input->post('confirm_replace');

        $template_name = explode('_', $data['template_name'])[1];
        $name = explode('.', $data['url'])[0];

        if( ($is_confirm == 'yes')){
            if(file_exists(THEMES_BASE_URL . $name . '/css/' . $template_name . ".css")){
                $prefix = date('Y_m_d_H_i_s_');
                copy(THEMES_BASE_URL . $name . '/css/' . $template_name . ".css", THEMES_BASE_URL . $name . '/css/' . $prefix .$template_name . ".css");
            }
            copy(THEMES_BASE_URL . $template_name . "/css/" . $template_name . ".css", THEMES_BASE_URL . $name . '/css/' . $template_name . ".css");
            // $this->_recurse_copy(THEMES_BASE_URL . $template_name . "/images", THEMES_BASE_URL . $name . "/images");
        } else if($is_confirm == 'other' && !file_exists(THEMES_BASE_URL . $name . "/css/" . $template_name . ".css")){
            copy(THEMES_BASE_URL . $template_name . "/css/" . $template_name . ".css", THEMES_BASE_URL . $name . '/css/' . $template_name . ".css");
            $this->_recurse_copy(THEMES_BASE_URL . $template_name . "/images", THEMES_BASE_URL . $name . "/images");
        }
    }

    ///////////////////////////////////////////////////////////////////////

    function _handle_admin_logo($update_id, $itemInfo) {
        $hdn_image = $this->input->post('hdn_adminlogo');
        $outlet_file = 'outlet_adminlogo';
        $db_colname = 'adminlogo';
        $actual_img_old = FCPATH . ACTUAL_OUTLET_IMAGE_PATH . $itemInfo->adminlogo;
        if (isset($_FILES[$outlet_file]['name']) && $_FILES[$outlet_file]['name'] != '') {
            if (file_exists($actual_img_old))
                unlink($actual_img_old);
            $this->upload_image_adminlogo($update_id, $hdn_image, $outlet_file, $db_colname);
        }

        $hdn_image = $this->input->post('hdn_adminlogo_small');
        $outlet_file = 'outlet_adminlogo_small';
        $db_colname = 'adminlogo_small';
        $actual_img_old = FCPATH . ACTUAL_OUTLET_IMAGE_PATH . $itemInfo->adminlogo_small;
        if (isset($_FILES[$outlet_file]['name']) && $_FILES[$outlet_file]['name'] != '') {
            if (file_exists($actual_img_old))
                unlink($actual_img_old);
            $this->upload_image_adminlogo($update_id, $hdn_image, $outlet_file, $db_colname);
        }
    }

  /*  function _handle_logo($update_id, $itemInfo) {
        $actual_img_old = FCPATH . ACTUAL_OUTLET_IMAGE_PATH . $itemInfo->image;
        $small_img_old = FCPATH . SMALL_OUTLET_IMAGE_PATH . $itemInfo->image;
        $medium_img_old = FCPATH . MEDIUM_OUTLET_IMAGE_PATH . $itemInfo->image;
        $large_img_old = FCPATH . LARGE_OUTLET_IMAGE_PATH . $itemInfo->image;
        if (isset($_FILES['outlet_file']['name']) && $_FILES['outlet_file']['name'] != '') {
            if (file_exists($actual_img_old))
                unlink($actual_img_old);
            if (file_exists($small_img_old))
                unlink($small_img_old);
            if (file_exists($medium_img_old))
                unlink($medium_img_old);
            if (file_exists($large_img_old))
                unlink($large_img_old);
            $this->upload_image($update_id);
        }
    }*/

    function _handle_fav_icon($update_id, $itemInfo) {
        $actual_img_old = FCPATH . ACTUAL_OUTLET_IMAGE_PATH . $itemInfo->fav_icon;
        if (isset($_FILES['outlet_fav_icon']['name']) && $_FILES['outlet_fav_icon']['name'] != '') {
            if (file_exists($actual_img_old))
                unlink($actual_img_old);
            $this->upload_fav_icon($update_id);
        }
    }

    function _handle_front_logo($update_id, $itemInfo) {
        $actual_img_old = FCPATH . ACTUAL_OUTLET_IMAGE_PATH . $itemInfo->image;
        if (isset($_FILES['outlet_file']['name']) && $_FILES['outlet_file']['name'] != '') {
            if (file_exists($actual_img_old))
                unlink($actual_img_old);
            $this->upload_front_logo($update_id);
        }
    }

    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        // echo "<pre>";print_r($query->result());exit;
        foreach ($query->result() as $row) {
            $data['name'] = $row->name;
            $data['point_slogan'] =$row->point_slogan;
            $data['url'] = $row->url;
            $data['percentage'] = $row->percentage;

            $data['url_slug'] = $row->url_slug;
            $data['phone'] = $row->phone;
            $data['email'] = $row->email;
            $data['orgination_no'] = $row->orgination_no;
            $data['country'] = $row->country;
            $data['city'] = $row->city;
            $data['state'] = $row->state;
            $data['post_code'] = $row->post_code;
            $data['address'] = $row->address;
            $data['google_map'] = $row->google_map;
            $data['fax'] = $row->fax;
            $data['web_title'] = $row->web_title;
            $data['is_default'] = $row->is_default;
            $data['meta_description'] = $row->meta_description;
            $data['about_us'] = $row->about_us;
            $data['working_hours'] = $row->working_hours;
            $data['image'] = $row->image;
            $data['fav_icon'] = $row->fav_icon;
            $data['adminlogo'] = $row->adminlogo;
            $data['adminlogo_small'] = $row->adminlogo_small;
            $data['facebook_link'] = $row->facebook_link;
            $data['twitter_link'] = $row->twitter_link;
            $data['googleplus_link'] = $row->googleplus_link;
            $data['linkedin_link'] = $row->linkedin_link;
            $data['template_name'] = $row->template_name;
            $data['merchant_live'] = $row->merchant_live;
            $data['merchant_test'] = $row->merchant_test;
            $data['smtp_username'] = $row->smtp_username;
            $data['smtp_password'] = $row->smtp_password;
            $data['smtp_host'] = $row->smtp_host;
            $data['smtp_port'] = $row->smtp_port;
            $data['android_version_code'] = $row->android_version_code;
            $data['iPhone_version_code'] = $row->iPhone_version_code;
            $data['version_alert'] = $row->version_alert;
            $data['is_android_update'] = $row->is_android_update;
            $data['is_iPhone_update'] = $row->is_iPhone_update;
            $data['facebook_appId'] = $row->facebook_appId;
            $data['google_store'] = $row->google_store;
            $data['restaurant_type'] = $row->restarurant_type;
            $data['ios_store'] = $row->ios_store;

            $data['outlet_cover_image'] = $row->outlet_cover_image;
            

            

        }
        return $data;
    }

    ///////////////////////////////////////////////////////////////////////

    function detail() {
        $update_id = $this->input->post('id');
        $data['outlet'] = $this->_get_data_from_db($update_id);
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function get_delivery_postcodes() {
        $arrcols['outlet_id'] = $this->input->post('id');
        $data['arr_postcode'] = $this->_get_where_cols_post_code_delivery($arrcols, 'id asc')->result_array();
        $data['update_id'] = $arrcols['outlet_id'];
        $this->load->view('delivery_postcode', $data);
    }

    function add_postcode() {
        $data['outlet_id'] = $this->input->post('id');
        $data['post_code'] = $this->input->post('postcode');
        $data['delivery_charges'] = $this->input->post('DeliveryCost');

        $arrcols['outlet_id'] = $data['outlet_id'];
        $arrcols['post_code'] = $data['post_code'];
        $query = $this->_get_where_cols_post_code_delivery($arrcols, 'id asc')->num_rows();
        if ($query == 0)
            $this->_insert_post_code_delivery($data);
        else
            echo 'xxx';
    }

    function update_delivery_charges() {
        $id = $this->input->post('id');
        $data['delivery_charges'] = $this->input->post('cost');
        $this->_update_table_post_code_delivery($id, $data);
    }

    function delete_post_code() {
        $id = $this->input->post('id');
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_delete_table_post_code_delivery($id);
    }

    function post_code_listing() {
        $arrcols['outlet_id'] = $this->input->post('id');
        $data['arr_postcode'] = $this->_get_where_cols_post_code_delivery($arrcols, 'id asc')->result_array();
        $this->load->view('post_codelisting', $data);
    }

    ///////////////////////////////////////////////////////////////////////

    function _get_data_from_post() {
        $data['name'] =strtoupper($this->input->post('txtBuildingName'));
        $data['point_slogan'] =$this->input->post('point_slogan'); 
       
        $data['url'] = $this->input->post('txtUrl');
        $data['url_slug'] = $this->input->post('url_slug');
        $data['phone'] = $this->input->post('txtPhone');
        $data['email'] = $this->input->post('txtEmail');
        $data['orgination_no'] = $this->input->post('txtOrgination');
        $data['city'] = $this->input->post('city');
        $data['country'] = $this->input->post('country');
        $data['state'] = $this->input->post('txtState');
        $data['post_code'] = $this->input->post('txtPost_Code');
        $data['address'] = $this->input->post('txtAddress');
        $data['google_map'] = $this->input->post('txtGoogglemap');
        $data['fax'] = $this->input->post('fax');
        $data['web_title'] = $this->input->post('web_title');
        $data['is_default'] = $this->input->post('is_default');
        $data['bank_details'] = $this->input->post('bank_details');
        $data['about_us'] = $this->input->post('about_us');
        $data['working_hours'] = $this->input->post('txtPageCont');
        $data['image'] = $this->input->post('hdn_image');
        $data['fav_icon'] = $this->input->post('hdn_image_fav_icon');
        $data['adminlogo'] = $this->input->post('hdn_adminlogo');
        $data['adminlogo_small'] = $this->input->post('hdn_adminlogo_small');
        $data['facebook_link'] = $this->input->post('facebook_link');
        $data['twitter_link'] = $this->input->post('twitter_link');
        $data['googleplus_link'] = $this->input->post('googleplus_link');
        $data['linkedin_link'] = $this->input->post('linkedin_link');
        $data['template_name'] = $this->input->post('template_name');
        $data['merchant_live'] = $this->input->post('merchant_live');
        $data['merchant_test'] = $this->input->post('merchant_test');
        $data['smtp_username'] = $this->input->post('smtp_username');
        $data['smtp_password'] = $this->input->post('smtp_password');
        $data['smtp_host'] = $this->input->post('smtp_host');
        $data['smtp_port'] = $this->input->post('smtp_port');
        $data['android_version_code'] = $this->input->post('android_version_code');
        $data['iPhone_version_code'] = $this->input->post('iPhone_version_code');
        $data['version_alert'] = $this->input->post('version_alert');
        $data['is_android_update'] = $this->input->post('is_android_update');
        $data['is_iPhone_update'] = $this->input->post('is_iPhone_update');
        $data['meta_description'] = $this->input->post('meta_description');
        $data['google_store'] = $this->input->post('google_store');
        $data['ios_store'] = $this->input->post('ios_store');
        $data['facebook_appId'] = $this->input->post('facebook_appId');
        $data['percentage'] = $this->input->post('percentage');
        $types = $this->input->post('restaurant_type');
        if($types){
            $str = '';
            foreach ($types as $key => $value) {
                if($key < count($types) -1){
                    $str .= $value.', ';
                } else {
                    $str .= $value;
                }
            }
            $data['restarurant_type'] = $str;
        } else{
            $data['restarurant_type'] = '';
        }
       
        return $data;

    }

    ///////////////////////////////////////////////////////////////////////

    function upload_image_adminlogo($nId, $hdn_image, $outlet_file, $db_colname) {
        $upload_image_file = $hdn_image;
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'post_' . $nId . '_' . $upload_image_file;
        $config['upload_path'] = ACTUAL_OUTLET_IMAGE_PATH;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES[$outlet_file])) {
            $this->upload->do_upload($outlet_file);
        }
        $upload_data = $this->upload->data();

        $data[$db_colname] = $file_name;
        //$data = array($db_colname => $file_name);
        $where['id'] = $nId;
        $rsItem = $this->_update($where, $data);

        if ($rsItem)
            return true;
        else
            return false;
    }

    function upload_image($nId) {
        $upload_image_file = $this->input->post('hdn_image');
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'post_' . $nId . '_' . $upload_image_file;
        $config['upload_path'] = ACTUAL_OUTLET_IMAGE_PATH;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        // if (isset($_FILES['outlet_file'])) {
        //     $this->upload->do_upload('outlet_file');
        // }
        $upload_data = $this->upload->data();

        /////////////// Large Image ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 500;
        $config['height'] = 400;
        $config['new_image'] = LARGE_OUTLET_IMAGE_PATH;
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        /////////////  Medium Size ///////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 300;
        $config['height'] = 200;
        $config['new_image'] = MEDIUM_OUTLET_IMAGE_PATH;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        ////////////////////// Small Size ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 100;
        $config['height'] = 100;
        $config['new_image'] = SMALL_OUTLET_IMAGE_PATH;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        $data = array('image' => $file_name);
        $where['id'] = $nId;
        $rsItem = $this->_update($where, $data);
        if ($rsItem)
            return true;
        else
            return false;
    }

    ///////////////////////////////////////////////////////////////////////

    function upload_fav_icon($nId) {
        $upload_image_file = $this->input->post('hdn_image_fav_icon');
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'fav_' . $nId . '_' . $upload_image_file;
        $config['upload_path'] = ACTUAL_OUTLET_IMAGE_PATH;
        $config['allowed_types'] = '*';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES['outlet_fav_icon'])) {
            $this->upload->do_upload('outlet_fav_icon');
        }
        $upload_data = $this->upload->data();

        $data = array('fav_icon' => $file_name);
        $where['id'] = $nId;
        $rsItem = $this->_update($where, $data);
        if ($rsItem)
            return true;
        else
            return false;
    }

    function upload_front_logo($nId) {
        $upload_image_file = $this->input->post('hdn_image');
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'front_' . $nId . '_' . $upload_image_file;
        $config['upload_path'] = ACTUAL_OUTLET_IMAGE_PATH;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES['outlet_file'])) {
            $this->upload->do_upload('outlet_file');
        }
        $upload_data = $this->upload->data();

        $data = array('image' => $file_name);
        $where['id'] = $nId;
        $rsItem = $this->_update($where, $data);
        if ($rsItem)
            return true;
        else
            return false;
    }

    ///////////////////////////////////////////////////////////////////////

    function delete() {
        $id = $this->input->post('id');

        $outlet_id=DEFAULT_OUTLET;
            $product_type="Outlet";
            $whereseo = array('id' =>$id ,'outlet_id'=>$outlet_id, 'product_type'=>$product_type );
            Modules::run('seo/delete',$whereseo);   

        $query = $this->_get_by_arr_id(array('id' => $id));
        $name = $query->result_array()[0]['name'];
//        $this->_delete_dir(THEMES_BASE_URL . $name);
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_delete($id);
    }

    ///////////////////////////////////////////////////////////////////////

    function delete_images() {
        $file = $this->input->post('image');
        $nId = $this->input->post('id');
        $this->load->helper("file");
        unlink(SMALL_OUTLET_IMAGE_PATH . $file);
        unlink(MEDIUM_OUTLET_PATH . $file);
        unlink(LARGE_OUTLET_IMAGE_PATH . $file);
        unlink(ACTUAL_OUTLET_IMAGE_PATH . $file);
        $data = array('image' => "");
        $where['id'] = $nId;
        $this->_update($where, $data);
        return true;
    }

    ///////////////////////////////////////////////////////////////////////

    function get_outlets_array() {
        $arr_outlet = array();
        $res_outlet = $this->_get('id');
        foreach ($res_outlet->result() as $row) {
            $arr_outlet[$row->id] = $row->name;
        }
        return $arr_outlet;
    }

    ///////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////

    function get_sub_outlets_array($outlet_id) {
        $arr_outlet = array();
        $sql = 'Select id, name from outlet where id = '.$outlet_id.' or parent_id ='.$outlet_id;
        $res_outlet = $this->_custom_query($sql);
        foreach ($res_outlet->result() as $row) {
            $arr_outlet[$row->id] = $row->name;
        }
        return $arr_outlet;
    }

    ///////////////////////////////////////////////////////////////////////


    function set_outlet_session() {
        $data['outlet_id'] = $this->input->post('outlet_id');
        //print'this set_outlet_session===>>'.$data['outlet_id'];exit;
        $data['outlet_name'] = $this->input->post('outlet_name');
        $this->session->unset_userdata('outlet_data');
        $this->session->set_userdata('outlet_data', $data);
    }


    function get_resturant($arr_where){

        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->get_resturant($arr_where);
    }
     function get_outlet_by_post_code($arr_where){

        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->get_outlet_by_post_code($arr_where);
    }

    
    ///////////////////////////////////////////////////////////////////////

    function _get_enum($field) {
        $type = $this->db->query("SHOW COLUMNS FROM outlet WHERE Field = '{$field}'")->row(0)->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        $records = array();
        foreach ($enum as $value) {
            $records[$value] = $value;
        }
        return $records;
    }

    ///////////////////////////////////////////////////////////////////////

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        echo $status;
        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = array('status' => $status);
        $status = $this->_update($id, $data);
        echo $status;
        exit;
    }

    function change_live_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        echo $status;
        if ($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = array('is_live' => $status);
        $status = $this->_update($id, $data);
        echo $status;
        exit;
    }

    ///////////////////HELPER FUNCTIONS//////////////////////////////
    function _get_contact($outlet_id) {
        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->_get_contact($outlet_id);
    }

    function _get_all_details($order_by) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_all_details($order_by);
        return $query;
    }

    function _get_all_details_admin($order_by) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_all_details_admin($order_by);
        return $query;
    }

    function _getItemById($id) {
        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->_getItemById($id);
    }

    function _get($order_by = 'id asc') {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get($order_by);
        return $query;
    }
     function _get_name($outlet_id){

        $this->load->model('mdl_outlet');
        $row = $this->mdl_outlet->_get_name($outlet_id)->row();
        return $row->name;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->_get_by_arr_id($arr_col);
    }

    function _get_with_limit($limit, $offset, $order_by = 'id asc') {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function _get_where($id) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_where($id);
        return $query;
    }

    function _get_where_cols_post_code_delivery($arrcols, $order_by, $outlet_id) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_where_cols_post_code_delivery($arrcols, $order_by, $outlet_id);
        return $query;
    }

    function _get_where_cols($cols, $order_by = 'id asc') {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_where_cols($cols, $order_by);
        return $query;
    }

    function _get_where_custom($col, $value, $order_by = 'id asc') {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_where_custom($col, $value, $order_by);
        return $query;
    }

    function _insert_post_code_delivery($data) {
        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->_insert_post_code_delivery($data);
    }

    function _insert($data) {
        $this->load->model('mdl_outlet');
        return $this->mdl_outlet->_insert($data);
    }

    function _update_table_post_code_delivery($id, $data) {
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_update_table_post_code_delivery($id, $data);
    }

    function _update($id, $data) {
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_update($id, $data);
    }

    function _update_where_cols($cols, $data) {
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_update_where_cols($cols, $data);
    }

    function _delete($id) {
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_delete($id);
    }

    function _count_where($column, $value) {
        $this->load->model('mdl_outlet');
        $count = $this->mdl_outlet->_count_where($column, $value);
        return $count;
    }

    function _get_max() {
        $this->load->model('mdl_outlet');
        $max_id = $this->mdl_outlet->_get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_custom_query($mysql_query);
        return $query;
    }

    function _recurse_copy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        static $count = 0;
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    copy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    if (file_exists($dst . '/' . $file)) {
                        unlink($dst . '/' . $file);
                    }
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    function check_template() {
        $id = $this->input->post('id');
        $template = $this->input->post('template');
        $db_data = $this->_get_data_from_db($id);
        $data = array();
        // $query = $this->_get_by_arr_id(array('id' => $id))->result_array()[0];
        if($db_data['template_name'] != $template){
            $name = explode('.', $db_data['url'])[0];
            $template_name = explode('_', $template)[1];
            $path = THEMES_BASE_URL . $name . '/css/' . $template_name . ".css";
            $data['path'] = $path;
            $data['response'] = $this->_if_file_exists($path);
        } else{
            $data['response'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function _if_file_exists($path) {
        if(file_exists($path)){
            return true;
        } else {
            return false;
        }
    }


    function _delete_dir($dir) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                rrmdir($file);
            } else {
                unlink($file);
            }
        } rmdir($dir);
    }

 ///////////////////////////////////////////////////////////////////////

    function set_timing(){

      $outlet_name = urldecode($this->uri->segment(5));
      $outlet_id = urldecode($this->uri->segment(4));
      $data['outlet_id'] = $outlet_id;
      $data['view_file'] = 'timing';
      $days = $this->get_days();
      $arr_days = [];
      
      foreach ($days as $day) {
        $time_data = $this->db->query("SELECT * FROM `timing` where outlet_id = ".$outlet_id." and day ='".$day."'")->result_array();
        $arr_days[$day] = $time_data;
      }

      $data['days'] = $arr_days;
      $data['outlet_name'] = $outlet_name;
      $this->load->module('template');
      $this->template->admin($data);
    }

    function update_time(){
      $id = $this->input->post('id');
      $from = $this->input->post('from');
      $to = $this->input->post('to');
      $day_name = $this->input->post('day_name');
      $is_closed = $this->input->post('is_closed');
      $outlet_id = $this->input->post('outlet_id');

      $data = ['outlet_id' => $outlet_id, 'day' => $day_name, 'opening' => $from, 'closing' => $to, 'is_closed' => $is_closed];
      $this->load->model('mdl_outlet');

      if($id > 0){
        $query = $this->mdl_outlet->_update_time($id, $data);
        echo  1;
      }
      else {
        echo $query = $this->mdl_outlet->_insert_time($data);
      }
    }

    function _get_outlet_timeing($outlet_id){
          $arr_outlet = array();
          $sql = 'SELECT * FROM timing WHERE DAY = DAYOFWEEK( NOW( ) ) and  outlet_id = '.$outlet_id;
          $arr_timing = $this->_custom_query($sql)->row_array();
          if (isset($arr_timing)) {
            $arr_outlet['day'] =   $arr_timing['day'];
            $arr_outlet['is_closed'] =   $arr_timing['is_closed'];
            if ($arr_timing['is_closed'] != 1 )
            {
              $sql = 'SELECT * FROM timing WHERE DAY = DAYOFWEEK( NOW( ) - INTERVAL 1 DAY ) and  outlet_id = '.$outlet_id;
              $arr_timings = $this->_custom_query($sql)->row_array();
              if (isset($arr_timings)) {
                if ($arr_timings['is_closed'] != 1 && $arr_timings['closing'] < $arr_timings['opening']){
                  /* $arr_times = array('opening' => '00:00' , 'closing' => $arr_timings['closing']);
                   $arr_outlet['open_timing'][] =   $arr_times;*/
                }
              }
              $arr_time = array('opening' => $arr_timing['opening'] , 'closing' => $arr_timing['closing']);
              $arr_outlet['open_timing'][] =   $arr_time;
            }
          }
          return $arr_outlet;
    }


    function get_days() {
        $arr_days = $this->get_enum_values( 'timing', 'day' );
        return $arr_days;
    }
    
     function get_enum_values( $table, $field ){
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

        function _get_outlets_api($outlet_id){
        $arr_outlet = array();
        $sql = 'select * from outlet Where ( id = '.$outlet_id.' or parent_id = '.$outlet_id.' )';
        $res_outlet = $this->_custom_query($sql)->result_array();

            foreach ($res_outlet as $arr_values)
            {
                $sql = 'select take_in_vat, take_out_vat, delivery_charges, delivery_charges_vat, outlet_id from general_setting Where outlet_id = '.$arr_values['id'];
                $arr_vat = $this->_custom_query($sql)->row_array();
                $arr_outlet = array();
                $arr_outlet['id'] = $arr_values['id'];
                $arr_outlet['name'] = $arr_values['name'];
                $arr_outlet['url'] = $arr_values['url'];
                $arr_outlet['take_in_vat'] = $arr_vat['take_in_vat'];
                $arr_outlet['take_out_vat'] = $arr_vat['take_out_vat'];
                $arr_outlet['delivery_charges'] = $arr_vat['delivery_charges'];
                $arr_outlet['delivery_charges_vat'] = $arr_vat['delivery_charges_vat'];

          $outlet_id = $arr_values['id'];

          $sql = 'SELECT * FROM timing WHERE DAY = DAYOFWEEK( NOW( ) ) and  outlet_id = '.$outlet_id;
           //print 'this sql===>>>'.$sql;
          $arr_timing = $this->_custom_query($sql)->row_array();
          if (isset($arr_timing)) {
            $arr_outlet['day'] =   $arr_timing['day'];
            //print 'this outlet_id===>>>'.$outlet_id;
            $arr_outlet['is_closed'] =   $arr_timing['is_closed'];
            $arr_outlet['msg_timing'] =   $arr_timing['opening'].'-'. $arr_timing['closing'];

            if ($arr_timing['is_closed'] != 1 )
            {
              if ($arr_timing['closing'] < $arr_timing['opening'])
                $closing_time = '23:59';
              else
                $closing_time = $arr_timing['closing'];


              $arr_time = array('opening' => $arr_timing['opening'] , 'closing' => $closing_time);
              $arr_outlet['open_timing'][] =   $arr_time;
              $sql = 'SELECT * FROM timing WHERE DAY = DAYOFWEEK( NOW( ) - INTERVAL 1 DAY ) and  outlet_id = '.$outlet_id;
              $arr_timing = $this->_custom_query($sql)->row_array();
              if (isset($arr_timing)) {
                if ($arr_timing['is_closed'] != 1 && $arr_timing['closing'] < $arr_timing['opening']){
                   $arr_time = array('opening' => '00:00' , 'closing' => $arr_timing['closing']);
                   $arr_outlet['open_timing'][] =   $arr_time;
                }
              }
            }
          }
          $arr_outlet_all[] = $arr_outlet;
            }
            return $arr_outlet_all;
    } 
    
function _get_station($distance=10, $longitude, $latitude) {
$this->load->model('mdl_outlet');
$query = $this->mdl_outlet->_get_station($distance, $longitude, $latitude);
return $query;
}
///////////////////////////umar apis start/////////////////////////
    function _get_new_limited_outlets($where,$order_by,$select,$page_number,$limit) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_new_limited_outlets($where,$order_by,$select,$page_number,$limit);
        return $query;
    }
    function _get_last_delivery_limited_outlets($where,$order_by,$select,$page_number,$limit) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_last_delivery_limited_outlets($where,$order_by,$select,$page_number,$limit);
        return $query;
    }
    function _get_best_deals_outlets($where,$order_by,$select,$page_number,$limit) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_best_deals_outlets($where,$order_by,$select,$page_number,$limit);
        return $query;
    }
    function outlet_open_close($where,$select,$having) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->outlet_open_close($where,$select,$having);
        return $query;
    }
    function _delete_outlet_catagories($where) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_delete_outlet_catagories($where);
        return $query;
    }
    function _insert_outlet_catagories($data) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_insert_outlet_catagories($data);
        return $query;
    }
    function _get_outlet_catagories($where) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_outlet_catagories($where);
        return $query;
    }
    function insert_dietary_data($data) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->insert_dietary_data($data);
        return $query;
    }
    ///////////////////asad

    function insert_services_data($data) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->insert_services_data($data);
        return $query;
    }
    ////////////asad
    function delete_dietary($where,$table) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->delete_dietary($where,$table);
        return $query;
    }

    function _create_tables($id) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_create_tables($id);
        return $query;
    }
}
