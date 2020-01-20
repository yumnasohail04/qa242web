<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends MX_Controller
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
        $data['test_name'] = $this->input->post('test_name');
        return $data;
    }
    function _get_data_from_post_answer() {
        $data['answer'] = $this->input->post('answer');
        $data['valid'] = $this->input->post('valid');
        return $data;
    }
    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['test_name'] = $row->test_name;
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
            $data = $this->_get_data_from_post();
            if (is_numeric($update_id) && $update_id != 0) {
                $where['id'] = $update_id;
                $this->_update($where, $data);
                $this->delete_test_question_answers($update_id);
                $this->insert_test_question_answers($update_id);
                $this->session->set_flashdata('message', 'test'.' '.DATA_UPDATED);
                $this->session->set_flashdata('status', 'success');
            }
            if (is_numeric($update_id) && $update_id == 0) {
                $data['outlet_id']=DEFAULT_OUTLET;
                $id = $this->_insert($data);
                $this->delete_test_question_answers($id);
                $this->insert_test_question_answers($id);
                $this->session->set_flashdata('message', 'test'.' '.DATA_SAVED);
                $this->session->set_flashdata('status', 'success');
            }
            redirect(ADMIN_BASE_URL . 'test');  
    }

    function insert_test_question_answers($id) {
        $question= $this->input->post('question');
        $answer= $this->input->post('answer');
        $updated_value= $this->input->post('updated_value');
        if(!empty($question) && is_numeric($id)) {
            foreach ($question as $key => $value):
                $data['tqa_question'] = $value;
                $data['tqa_test_id'] = $id;
                $data['tqa_answer'] = "";
                if(isset($answer[$key]))
                    $data['tqa_answer'] = $answer[$key];
                $where=array();
                if(!empty($updated_value[$key]))
                    $where['tqa_test_id']=$updated_value[$key];
                print_r($data);
                $this->insert_test_question_data($where,$data,DEFAULT_OUTLET.'_test_question_answers');
                unset($data);
                unset($where);
            endforeach;
        }
    }
    function delete_test_question_answers($update_id) {
        $updated_value= $this->input->post('updated_value');
        $previous=$this->get_specific_table_data(array("tqa_test_id"=>$update_id),'tqa_id desc','tqa_id',DEFAULT_OUTLET.'_test_question_answers','1','0')->result_array();
            $data=array();
        if(!empty($previous)) {
            foreach ($previous as $key => $value) {
                if(is_numeric($value['tqa_id']) && $value['tqa_id']> 0) {
                    $check =in_array($value['tqa_id'], $updated_value);
                    if(empty($check)) {
                        $data[]=$value['tqa_id'];
                    }
                }
            }
            if(!empty($data)) {
                foreach ($data as $key => $value) {
                    $this->delete_test_question_data(array("tqa_id"=>$value));
                }
            }
        }
    }
    function insert_test_question_data($where,$data,$table) {
        $this->load->model('mdl_test');
        return $this->mdl_test->insert_test_question_data($where,$data,$table);
    }
    function delete_test_question_data($where) {
        $this->load->model('mdl_test');
        return $this->mdl_test->delete_test_question_data($where);
    }
    function get_specific_table_data($where,$order,$select,$table_name,$page_number,$limit) {
        $this->load->model('mdl_test');
        return $this->mdl_test->get_specific_table_data($where,$order,$select,$table_name,$page_number,$limit);
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
        $this->load->model('mdl_test');
        $query = $this->mdl_test->_get($order_by);
        return $query;
    }
       function _insert($data) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_insert($data);
    }
      function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_by_arr_id($arr_col);
    }
      function _get_by_arr_id_answer($arr_col) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_by_arr_id_answer($arr_col);
    }
     function _update_id($id, $data) {
        $this->load->model('mdl_test');
        $this->mdl_test->_update_id($id, $data);
    }
    function _update($arr_col, $data) {
        $this->load->model('mdl_test');
        $this->mdl_test->_update($arr_col, $data);
    }
    function _delete($arr_col) {       
        $this->load->model('mdl_test');
        $this->mdl_test->_delete($arr_col);
    }
     function insert_or_update_user_review($where,$data,$table){
        $this->load->model('mdl_test');
        return $this->mdl_test->insert_or_update_user_review($where,$data,$table);
    } 
    function insert_ans($dataans){
        $this->load->model('mdl_test');
        return $this->mdl_test->insert_ans($dataans);
    } 
}