<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Document extends MX_Controller
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
        $data['news'] = $this->_get('id desc')->result_array();
        foreach($data['news'] as $key => $value){
            $result = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$value['type_id']),'id desc','id','ingredient_types','name','1','0','','','')->row_array();
            $data['news'][$key]['type_name']="None";
            if(isset($result['name']) && !empty($result['name']))
                $data['news'][$key]['type_name']=$result['name'];
        } 
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
        $type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','ingredient_types','id,name','1','0','','','')->result_array();
          if(!empty($type)) {
                $temp= array();
                foreach ($type as $key => $gp):
                    $temp[$gp['id']] = $gp['name'];
                endforeach;
                $type = $temp;
            }
        $supplier_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','supplier_type','id,name','1','0','','','')->result_array();
        if(!empty($supplier_type)) {
            $temp= array();
            foreach ($supplier_type as $key => $gp):
                $temp[$gp['id']] = $gp['name'];
            endforeach;
            $supplier_type = $temp;
        }
        $data['supplier_type'] = $supplier_type;
        $data['level']=array("Mandatory"=>"Mandatory","Not Mandatory"=>"Not Mandatory");
        $data['assign']=array("supplier"=>"Supplier","ingredient"=>"Ingredient");
        $data['doc_type']=array("location specific"=>"Location Specific","ingredient specific"=>"Ingredient Specific");
        $data['type'] = $type;    
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
            $data['type_id'] = $row->type_id;
            $data['level'] = $row->level;
            $data['assign_to'] = $row->assign_to;
            $data['doc_type'] = $row->doc_type;
            $data['supplier_type'] = $row->supplier_type;
            $result = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$data['type_id']),'id desc','id','ingredient_types','name','1','0','','','')->row_array();
            $data['type_name'] = "None";
            if(isset($result['name']) && !empty($result['name']))
            $data['type_name'] = $result['name'];
            $result = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$data['supplier_type']),'id desc','id','supplier_type','name','1','0','','','')->row_array();
            $data['supplier_type_name'] = "None";
            if(isset($result['name']) && !empty($result['name']))
            $data['supplier_type_name'] = $result['name'];
        }
        return $data;
    }
    function _get_data_from_post() {
        $data['doc_name'] = $this->input->post('doc_name');
        $data['type_id'] = $this->input->post('type_id');
        $data['level'] = $this->input->post('level');
        $data['assign_to'] = $this->input->post('assign_to');
        $data['supplier_type'] = $this->input->post('supplier_type');
        $data['doc_type'] = $this->input->post('doc_type');
        if($data['assign_to']=="supplier")
        {
            $data['type_id'] = " ";
        }
        return $data;
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $this->session->set_flashdata('message', 'document Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $this->session->set_flashdata('message', 'document'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'document');
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
        $this->load->model('mdl_document');
        return $this->mdl_document->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_document');
        $query = $this->mdl_document->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_document');
        return $this->mdl_document->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_document');
        return $this->mdl_document->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_document');
        $this->mdl_document->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_document');
        $this->mdl_document->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_document');
        $this->mdl_document->_delete($arr_col);
    }
     
}
