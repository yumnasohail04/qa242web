<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Groups extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
Modules::run('site_security/has_permission');
date_default_timezone_set("Asia/karachi");
}

    function index() {

     
        $this->manage();
    }
    function manage() {
        $arrWhere['outlet_id'] = DEFAULT_OUTLET;
        $arr_roles = Modules::run('roles/_get_by_arr_id',$arrWhere)->result_array();
        $roles = array();
        foreach($arr_roles as $row){
            $roles[$row['id']] = $row['role'];
        }
        $data['roles_title'] = $roles;
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
            $arrWhere['outlet_id'] = DEFAULT_OUTLET;
            $arr_roles = Modules::run('roles/_get_by_arr_id',$arrWhere)->result_array();
            $roles = array();
            foreach($arr_roles as $row){
                $roles[$row['id']] = $row['role'];
            }
            $data['roles_title'] = $roles;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function import_file(){
     
        $data['view_file'] = 'fileupload';
        $this->load->module('template');
        $this->template->admin($data);
    }
     function _get_data_from_db($update_id) {
        $where[DEFAULT_OUTLET.'_groups.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['group_title'] = $row->group_title;
            $data['group_desc'] = $row->group_desc;
            $data['role'] = $row->role;
            $data['outlet_id'] = $row->outlet_id;
            $data['status'] = $row->status;
           

        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['group_title'] = $this->input->post('group_title');
        $data['group_desc'] = $this->input->post('group_desc');
        $data['role'] = $this->input->post('role');
        $data['outlet_id'] = DEFAULT_OUTLET;
        $data['status'] = $this->input->post('hdnActive');
        return $data;
    }

    
    function submit() {
       
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            if (is_numeric($update_id) && $update_id != 0) {
                $where['id'] = $update_id;
                $this->_update($where, $data);
                $arrWhere['group']=$update_id;
                $role_data['role_id']=$data['role'];
                $arr_roles = Modules::run('users/_update',$arrWhere,$role_data);
                $this->session->set_flashdata('message', 'Group'.' '.DATA_UPDATED);										
		                $this->session->set_flashdata('status', 'success');
            }
            if (is_numeric($update_id) && $update_id == 0) {
                $data['status'] = '1';
                $id = $this->_insert($data);
                $this->session->set_flashdata('message', 'Group'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            }
            redirect(ADMIN_BASE_URL . 'groups');

    }
   function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
      
    }
    
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
    function detail() {
        $update_id = $this->input->post('id');
       // $lang_id = $this->input->post('lang_id');
        $data['post'] = $this->_get_data_from_db($update_id);
        //$data['product_attribute']=$this->get_attriutes_list($update_id)->result_array();
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_groups');
        return $this->mdl_groups->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_groups');
        $query = $this->mdl_groups->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_groups');
        return $this->mdl_groups->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_groups');
        return $this->mdl_groups->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_groups');
        $this->mdl_groups->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_groups');
        $this->mdl_groups->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_groups');
        $this->mdl_groups->_delete($arr_col);
    }
  
  
  
}
