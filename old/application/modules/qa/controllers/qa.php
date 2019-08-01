<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Qa extends MX_Controller
{

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');

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
            $data['news'] = $this->_get_data_from_db_question($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post_question();
        }
        
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }

    function _get_data_from_post_question() {
        $data['question'] = $this->input->post('question');
        return $data;
    }
    function _get_data_from_post_answer() {
        $data['answer'] = $this->input->post('answer');
        $data['valid'] = $this->input->post('valid');
        return $data;
    }
    function _get_data_from_db_question($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['question'] = $row->question;
        }
        return $data;
    }
     function _get_data_from_db_answer($update_id) {
        $where['question_id'] = $update_id;
        $query = $this->_get_by_arr_id_answer($where);
        foreach ($query->result() as
                $row) {
            $data['answer'] = $row->answer;
            $data['valid'] = $row->valid;
        }
        return $data;
    }
    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post_question();
            if (is_numeric($update_id) && $update_id != 0) {
                $where['id'] = $update_id;
                $this->_update($where, $data);
                $this->session->set_flashdata('message', 'qa'.' '.DATA_UPDATED);
                $this->session->set_flashdata('status', 'success');
            }
            if (is_numeric($update_id) && $update_id == 0) {
              $id = $this->_insert($data);
                $this->session->set_flashdata('message', 'qa'.' '.DATA_SAVED);
                $this->session->set_flashdata('status', 'success');
            }
            redirect(ADMIN_BASE_URL . 'qa');  
    }
  
  

    function detail() {
        $update_id = $this->input->post('id');
        $data['post'] = $this->_get_data_from_db_question($update_id);
        $this->load->view('detail', $data);
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
    function delete() {
        $delete_id = $this->input->post('id');
        $where['id'] = $delete_id;
        $this->_delete($where);
    }

    //////////////////////////////////////////////////////

     function _get($order_by) {
        $this->load->model('mdl_qa');
        $query = $this->mdl_qa->_get($order_by);
        return $query;
    }
       function _insert($data) {
        $this->load->model('mdl_qa');
        return $this->mdl_qa->_insert($data);
    }
      function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_qa');
        return $this->mdl_qa->_get_by_arr_id($arr_col);
    }
      function _get_by_arr_id_answer($arr_col) {
        $this->load->model('mdl_qa');
        return $this->mdl_qa->_get_by_arr_id_answer($arr_col);
    }
     function _update_id($id, $data) {
        $this->load->model('mdl_qa');
        $this->mdl_qa->_update_id($id, $data);
    }
    function _update($arr_col, $data) {
        $this->load->model('mdl_qa');
        $this->mdl_qa->_update($arr_col, $data);
    }
    function _delete($arr_col) {       
        $this->load->model('mdl_qa');
        $this->mdl_qa->_delete($arr_col);
    }
     function insert_or_update_user_review($where,$data,$table){
        $this->load->model('mdl_qa');
        return $this->mdl_qa->insert_or_update_user_review($where,$data,$table);
    }
}