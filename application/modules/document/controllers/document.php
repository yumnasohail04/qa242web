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
            if($value['assign_to']=="supplier")
            {
                $data['news'][$key]['type'] = Modules::run('document_file/get_doc_assigned_types',array('doc_supplier_types.doc_id'=>$value['id']),"doc_supplier_types","doc_supplier_types.id desc","supplier_type","supplier_type","id","supplier_type.name")->result_array();
            }else
            {
                $data['news'][$key]['type'] = Modules::run('document_file/get_doc_assigned_types',array('doc_ingredient_types.doc_id'=>$value['id']),"doc_ingredient_types","doc_ingredient_types.id desc","ingredient_types","ing_type","id","ingredient_types.name")->result_array();
            }
        } 
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $selected_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("doc_id" =>$update_id),'id desc','id','doc_supplier_types','id,supplier_type','1','0','','','')->result_array();
            if(!empty($selected_type)) {
                $temp= array();
                foreach ($selected_type as $key => $gp):
                    $temp[$gp['id']] = $gp['supplier_type'];
                endforeach;
                $selected_type = $temp;
            }
            $data['selected_type']=$selected_type;
            $data['selected_ing_type']=array();
            $selected_ing_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("doc_id" =>$update_id),'id desc','id','doc_ingredient_types','id,ing_type','1','0','','','')->result_array();
            if(!empty($selected_ing_type)) {
                $temp= array();
                foreach ($selected_ing_type as $key => $gp):
                    $temp[$gp['id']] = $gp['ing_type'];
                endforeach;
                $selected_ing_type = $temp;
            }
            $data['selected_ing_type']=$selected_ing_type;
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','ingredient_types','id,name','1','0','','','')->result_array();
        $data['type'] = $type;    
        $supplier_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','supplier_type','id,name','1','0','','','')->result_array();
        $data['supplier_type'] = $supplier_type;
        $data['level']=array("Mandatory"=>"Mandatory","Not Mandatory"=>"Not Mandatory");
        $data['assign']=array("supplier"=>"Supplier","ingredient"=>"Ingredient");
        $data['doc_type']=array("location specific"=>"Location Specific","ingredient specific"=>"Ingredient Specific");
        $data['type'] = $type;    
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
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
        $data['level'] = $this->input->post('level');
        $data['assign_to'] = $this->input->post('assign_to');
        $data['doc_type'] = $this->input->post('doc_type');
        if($data['assign_to']=="supplier")
        {
            $data['type_id'] = "0";
        }
        return $data;
    }

	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            Modules::run('api/delete_from_specific_table',array("doc_id"=>$update_id),'doc_supplier_types');
            $where_arr['doc_id'] = $update_id;
            $supplier_type = $this->input->post('supplier_type');
            if(!empty($supplier_type)) {
                foreach ($supplier_type as $key => $it):
                    Modules::run('api/insert_or_update',array("doc_id"=>$update_id,"supplier_type"=>$it),array("doc_id"=>$update_id,"supplier_type"=>$it),'doc_supplier_types');
                endforeach;
            }
            $type_id = $this->input->post('type_id');
            if(!empty($type_id)) {
                foreach ($type_id as $key => $it):
                    Modules::run('api/insert_or_update',array("doc_id"=>$update_id,"ing_type"=>$it),array("doc_id"=>$update_id,"ing_type"=>$it),'doc_ingredient_types');
                endforeach;
            }
            $this->session->set_flashdata('message', 'document Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $supplier_type = $this->input->post('supplier_type');
            if(!empty($supplier_type)) {
                foreach ($supplier_type as $key => $it):
                    Modules::run('api/insert_or_update',array("doc_id"=>$id,"supplier_type"=>$it),array("doc_id"=>$id,"supplier_type"=>$it),'doc_supplier_types');
                endforeach;
            }
            $this->session->set_flashdata('message', 'document'.' Saved');
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

    function check_atrribute_exists($arr_col,$table){
        $this->load->model('mdl_document');
        return $this->mdl_document->check_atrribute_exists($arr_col,$table);
    }
    function insert_attribute_data($data,$table){
        $this->load->model('mdl_document');
       return $this->mdl_document->insert_attribute_data($data,$table);
    }
    function update_attribute_data($where,$attribute_data,$table){
        $this->load->model('mdl_document');
       return $this->mdl_document->update_attribute_data($where,$attribute_data,$table);
    }
    function delete_from_table($where,$table)
    {
        $this->load->model('mdl_document');
        $this->mdl_document->delete_from_table($where,$table);
    }
     
}
