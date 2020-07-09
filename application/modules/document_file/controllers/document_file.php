<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Document_file extends MX_Controller
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
            $result = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$value['carrier_type']),'id desc','id','carrier_types','type','1','0','','','')->row_array();
            $data['news'][$key]['carrier_type']="None";
            if(isset($result['type']) && !empty($result['type']))
                $data['news'][$key]['type_name']=$result['type'];
        } 
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $data['new'] = $this->_get_data_from_db_question($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
            $data['new'] = $this->_get_data_from_post_question();
        }
        $type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'id desc','id','carrier_types','id,type','1','0','','','')->result_array();
        if(!empty($type)) {
            $temp= array();
            foreach ($type as $key => $gp):
                $temp[$gp['id']] = $gp['type'];
            endforeach;
            $type = $temp;
        }
        $data['carrier_type'] = $type;
        $data['type']=array("Mandatory"=>"Mandatory","Optional"=>"Optional");
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
            $data['carrier_type'] = $row->carrier_type;
            $data['question'] = $row->question;
        }
        return $data;
    }
    function _get_data_from_db_question($update_id) {
        $data=array();
        $where['doc_id'] = $update_id;
        $query = Modules::run('api/_get_specific_table_with_pagination_where_groupby',$where,'id desc','id','document_question','*','1','0','','','');
        foreach ($query->result() as $row) {
            $data['title'] = $row->title;
            $data['type'] = $row->type;
            $data['comment_box'] = $row->comment_box;
            $data['reference_link'] = $row->reference_link;
        }
        return $data;
    }
    function _get_data_from_post() {
        $data['doc_name'] = $this->input->post('doc_name');
        $data['carrier_type'] = $this->input->post('carrier_type');
        $data['question'] = $this->input->post('question');
        return $data;
    }
    function _get_data_from_post_question()
    {
        
        $data['title'] = $this->input->post('title');
        $data['type'] = $this->input->post('type');
        $data['comment_box'] = $this->input->post('comment_box');
        $data['reference_link'] = $this->input->post('reference_link');
        return $data;
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        $data_quest = $this->_get_data_from_post_question();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $data_quest['doc_id']=$update_id;
            if($data['question']=="1")
                Modules::run('api/insert_or_update',array("doc_id"=> $update_id),$data_quest,'document_question');
            else
                Modules::run('api/delete_from_specific_table',array("doc_id"=>$update_id),'document_question');
            $this->session->set_flashdata('message', 'document Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $data_quest['doc_id']=$id;
            Modules::run('api/insert_or_update',array("doc_id"=> $id),$data_quest,'document_question');
            $this->session->set_flashdata('message', 'document'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'document_file');
    }
    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
        Modules::run('api/delete_from_specific_table',array("doc_id"=>$delete_id),'document_question');
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
        $this->load->model('mdl_document_file');
        return $this->mdl_document_file->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_document_file');
        $query = $this->mdl_document_file->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_document_file');
        return $this->mdl_document_file->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_document_file');
        return $this->mdl_document_file->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_document_file');
        $this->mdl_document_file->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_document_file');
        $this->mdl_document_file->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_document_file');
        $this->mdl_document_file->_delete($arr_col);
    }
     
}
