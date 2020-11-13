<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ingredient_doc extends MX_Controller
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
        $data['new'] = $this->_get("id desc")->result_array();
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['new'] = $this->_get_data_from_db($update_id);
            $data['option_quest'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("quest_id"=>$update_id,"del_status"=>"0"),'id desc','id','ing_form_options','*','1','0','','','')->result_array();
        } else {
            $data['new'] = $this->_get_data_from_post();
        }
        $data['selection_type']=array("choice"=>"Yes/No","date"=>"Date","other"=>"Other");
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function delete_attribute()
    {
        $id=$this->input->post('id');
        $res=Modules::run('api/insert_or_update',array("id"=>$id),array("del_status"=>"1"),'ing_form_options');
    }
    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['title'] = $row->title;
            $data['type'] = $row->type;
            $data['comment_box'] = $row->comment_box;
            $data['comment_type'] = $row->comment_type;
            $data['expiry'] = $row->expiry;
            $data['attachment'] = $row->attachment;
        }
        return $data;
    }
 
    function _get_data_from_post()
    {
        $data['title'] = $this->input->post('title');
        $data['type'] = $this->input->post('type');
        $data['comment_box']=0;
        if(!empty($this->input->post('comment_box')))
            $data['comment_box'] = 1;
        $data['expiry']=0;
        if(!empty($this->input->post('expiry')))
            $data['expiry'] = 1;
        $data['attachment']=0;
        if(!empty($this->input->post('attachment')))
            $data['attachment'] = 1;
        $data['comment_type']=0;
        if(!empty($this->input->post('comment_type')))
            $data['comment_type'] = 1;
        return $data;
    }
    function submit_document_options($update_id)
    {
        
        $opions=$this->input->post('option');
        $total=count($opions);
        $query = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("quest_id"=>$update_id,"del_status"=>"0"),'id desc','id','ing_form_options','option,id,quest_id','1','0','','','')->result_array();
        foreach($query as $key => $value){
            $exist=0;
            if(isset($opions) && !empty($opions)){
                for ($i=0; $i <$total; $i++) {
                    if($value['option']==$opions[$i])
                        $exist=1;
                }
            }
            if($exist==0)
                Modules::run('api/insert_or_update',array("id"=>$value['id']),array("del_status"=>"1"),'ing_form_options');
        }
        if(isset($opions) && !empty($opions)){
            for ($i=0; $i <$total; $i++) {
                if(!empty($opions[$i])){
                    $arr_attribute['quest_id']=$update_id;
                    $arr_attribute['option']=$opions[$i];
                    $where['del_status']=0;
                    $where['quest_id']=$update_id;
                    $where['option']=$opions[$i];
                    $query = Modules::run('api/_get_specific_table_with_pagination_where_groupby',$where,'id desc','id','ing_form_options','id','1','0','','','')->num_rows();
                    if($query<=0)
                    {
                        Modules::run('api/insert_into_specific_table',$arr_attribute,'ing_form_options');
                    }
                }
            }
        }
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            if($data['type']=="other")
                $this->submit_document_options($update_id);
            else
                Modules::run('api/update_specific_table',array("quest_id"=>$update_id),array("del_status"=>"1"),'ing_form_options');
            $this->session->set_flashdata('message', 'document Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            if($data['type']=="other")
                $this->submit_document_options($id);
            $this->session->set_flashdata('message', 'document'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'ingredient_doc');
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
        $this->load->model('mdl_ingredient_doc');
        return $this->mdl_ingredient_doc->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_ingredient_doc');
        $query = $this->mdl_ingredient_doc->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_ingredient_doc');
        return $this->mdl_ingredient_doc->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_ingredient_doc');
        return $this->mdl_ingredient_doc->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_ingredient_doc');
        $this->mdl_ingredient_doc->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_ingredient_doc');
        $this->mdl_ingredient_doc->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_ingredient_doc');
        $this->mdl_ingredient_doc->_delete($arr_col);
    }

    function get_doc_assigned_types($where,$table,$order_by,$join_table,$table_attr,$jointable_attr,$select)
    {
        $this->load->model('mdl_ingredient_doc');
       return  $this->mdl_ingredient_doc->get_doc_assigned_types($where,$table,$order_by,$join_table,$table_attr,$jointable_attr,$select);
    }
     
}
