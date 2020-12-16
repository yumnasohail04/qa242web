<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier_doc extends MX_Controller
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
 
   
     function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['doc_name'] = $row->doc_name;
        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['doc_name'] = $this->input->post('doc_name');
        return $data;
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $this->session->set_flashdata('message', 'supplier_doc Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $this->session->set_flashdata('message', 'supplier_doc'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'supplier_doc');
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
        $data['post'] = $this->_get_data_from_db($update_id);
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_supplier_doc');
        return $this->mdl_supplier_doc->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_supplier_doc');
        $query = $this->mdl_supplier_doc->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_supplier_doc');
        return $this->mdl_supplier_doc->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_supplier_doc');
        return $this->mdl_supplier_doc->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_supplier_doc');
        $this->mdl_supplier_doc->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_supplier_doc');
        $this->mdl_supplier_doc->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_supplier_doc');
        $this->mdl_supplier_doc->_delete($arr_col);
    }
     
}
