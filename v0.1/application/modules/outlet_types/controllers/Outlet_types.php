<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Outlet_types extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
Modules::run('site_security/has_permission');

}

    function index() {
        $this->manage();
    }

    function manage() {


        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

   

    function create() {
        $update_id = $this->uri->segment(4);
       
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
        $data['update_id'] = $update_id;
      

        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    
  

    
    
    function _get_data_from_post() {
        $data['type'] = $this->input->post('type');
        
        $data['status'] = $this->input->post('hdnActive');
      
        return $data;
    }
    ///////////////////////////umar apis start/////////////////////////
    function _get_data_from_db($update_id) {
        $where['outlet_types.id'] = $update_id;
        //$where['post.lang_id'] = $lang_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['type'] = $row->type;
            $data['type_image'] = $row->type_image;
            $data['status'] = $row->status;
           
        }
        return $data;
    }
    function submit() {
        
      
            $update_id = $this->uri->segment(4);
         
            $data = $this->_get_data_from_post();
            
            if (is_numeric($update_id) && $update_id != 0) {
                    $itemInfo = $this->_getItemById($update_id);
                $where['id'] = $update_id;
                $this->_update($where, $data);
                if(isset($_FILES['news_file']))
                    if($_FILES['news_file']['size'] > 0 && !empty($_FILES['news_file']['name'])) {
                        $this->delete_images_by_name(ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$itemInfo->type_image);
                        $this->upload_dynamic_image(ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$update_id,'news_file','type_image','id');
                    }
                    
                $this->session->set_flashdata('message', 'Type'.' '.DATA_UPDATED);										
		                $this->session->set_flashdata('status', 'success');
            }
            if (is_numeric($update_id) && $update_id == 0) {
              
                $id = $this->_insert($data);
                $this->upload_dynamic_image(ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$id,'news_file','type_image','id');
                
                $this->session->set_flashdata('message', 'Type'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            }
            redirect(ADMIN_BASE_URL . 'outlet_types');
        
    }

    function delete() {
        $delete_id = $this->input->post('id');
        if(is_numeric($delete_id)) {
            $itemInfo = $this->_getItemById($delete_id);
            $this->delete_images_by_name(ACTUAL_OUTLET_TYPE_IMAGE_PATH,LARGE_OUTLET_TYPE_IMAGE_PATH,MEDIUM_OUTLET_TYPE_IMAGE_PATH,SMALL_OUTLET_TYPE_IMAGE_PATH,$itemInfo->type_image);
        }
        $where['id'] = $delete_id;
        $this->_delete($where);
    }

    function upload_dynamic_image($actual_path,$large_path,$medium_path,$small_path,$nId,$input_name,$image_field,$image_id_fild) {
        $upload_image_file = $_FILES[$input_name]['name'];
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'packages_map' . $nId . '_' . $upload_image_file;
        $config['upload_path'] = $actual_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES[$input_name])) {
            $this->upload->do_upload($input_name);
        }
        $upload_data = $this->upload->data();

        /////////////// Large Image ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 400;
        $config['height'] = 400;
        $config['new_image'] = $large_path;
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
        $config['new_image'] = $medium_path;
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
        $config['new_image'] = $small_path;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        $data = array($image_field => $file_name);
        $where[$image_id_fild] = $nId;
        $rsItem = $this->_update($where, $data);
        if ($rsItem)
            return true;
        else
            return false;
    }

    function delete_images_by_name($actual_path,$large_path,$medium_path,$small_pathm,$name) {
        if (file_exists($actual_path.$name))
            unlink($actual_path.$name);
        if (file_exists($large_path.$name))
            unlink($large_path.$name);
        if (file_exists($medium_path.$name))
            unlink($medium_path.$name);
        if (file_exists($small_pathm.$name))
            unlink($small_pathm.$name);
    }
    ///////////////////////////end umar apis/////////////////////////

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
       // $lang_id = $this->input->post('lang_id');
        $data['post'] = $this->_get_data_from_db($update_id);
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    ///////////////////////////     HELPER FUNCTIONS    ////////////////////

   
    function _getItemById($id) {
        $this->load->model('mdl_post');
        return $this->mdl_post->_getItemById($id);
    }



    function _search_news($strSearch, $limit, $segment, $where, $order) {
        $this->load->model('mdl_post');
        return $this->mdl_post->_search_news($strSearch, $limit, $segment, $where, $order);
    }

   

    function _get($order_by) {
        $this->load->model('mdl_post');
        $query = $this->mdl_post->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_post');
        return $this->mdl_post->_get_by_arr_id($arr_col);
    }

  
    function _get_where($id) {
        $this->load->model('mdl_post');
        $query = $this->mdl_post->_get_where($id);
        return $query;
    }

    function _get_where_custom($col, $value) {
        $this->load->model('mdl_post');
        $query = $this->mdl_post->_get_where_custom($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->load->model('mdl_post');
        return $this->mdl_post->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_post');
        $this->mdl_post->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_post');
        $this->mdl_post->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_post');
        $this->mdl_post->_delete($arr_col);
    }

    
    function _get_records($arr_col) {
        $this->load->model('mdl_post');
        return $this->mdl_post->_get_records($arr_col);
    }
}