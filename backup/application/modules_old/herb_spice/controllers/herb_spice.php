<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Herb_spice extends MX_Controller
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
        $checkid = $this->uri->segment(4);
        if(empty($checkid))
        $checkid=0;
        $data['checkid']=$checkid;
        $data['news'] = $this->_get('id desc',array('checkid'=>$checkid));
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    
    function create() {
        
        $checkid = $this->uri->segment(4);
        $update_id = $this->uri->segment(5);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id,$checkid);
        } else {
            $data['news'] = $this->_get_data_from_post($checkid);
        }
        
        $data['update_id'] = $update_id;
        $data['checkid']=$checkid;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    
   

    function _get_data_from_db($update_id,$checkid) {
        $where['herb_spice.id'] = $update_id;
        $where['herb_spice.checkid'] = $checkid;
       
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['navision_number'] = $row->navision_number;
            $data['product_name'] = $row->product_name;
            $data['status'] = $row->status;
            $data['check_id']=$row->checkid;
        return $data;
        }
    }
    
    function _get_data_from_post($checkid) {
        $data['navision_number'] = $this->input->post('navision_number');
        $data['product_name'] = $this->input->post('product_name');
        $data['checkid'] = $checkid;
        $data['status'] = $this->input->post('hdnActive');
        return $data;
    }

    function submit() {
        
             
            $checkid = $this->uri->segment(4);
            $update_id = $this->uri->segment(5);
            $data = $this->_get_data_from_post($checkid);

            if (is_numeric($update_id) && $update_id != 0) {
               
                $where['id'] = $update_id;
              
                $this->_update($where, $data);
               
                $this->session->set_flashdata('message', 'Herb Spice'.' '.DATA_UPDATED);                                      
                        $this->session->set_flashdata('status', 'success');
            }
            if (is_numeric($update_id) && $update_id == 0) {
                $id = $this->_insert($data);
               
                $this->session->set_flashdata('message', 'Herb Spice'.' '.DATA_SAVED);                                        
                $this->session->set_flashdata('status', 'success');
            }
            redirect(ADMIN_BASE_URL . 'herb_spice/manage/'.$checkid);
        
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

    function _get($order_by,$where) {
        $this->load->model('mdl_herb_spice');
        $query = $this->mdl_herb_spice->_get($order_by,$where);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_herb_spice');
        return $this->mdl_herb_spice->_get_by_arr_id($arr_col);
    }

   
    function _insert($data) {
        $this->load->model('mdl_herb_spice');
        return $this->mdl_herb_spice->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_herb_spice');
        $this->mdl_herb_spice->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_herb_spice');
        $this->mdl_herb_spice->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_herb_spice');
        $this->mdl_herb_spice->_delete($arr_col);
    }
}