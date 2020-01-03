<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_assignments extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = DEFAULT_OUTLET."_assignments assignments";
        return $table;
    }
    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->select('assignments.* ,product_checks.checkname,product_checks.checktype');
        $this->db->join(DEFAULT_OUTLET.'_product_checks product_checks' , 'product_checks.id = assignments.checkid' , 'left');
        if(!empty($arr_col))
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
    function _get($order_by,$where) {
        $table = $this->get_table();
        $this->db->select('assignments.* ,product_checks.checkname,product_checks.checktype');
        $this->db->from($table);
        $this->db->join(DEFAULT_OUTLET.'_product_checks product_checks' , 'product_checks.id = assignments.checkid' , 'left');
        if(!empty($where))
        $this->db->where($where);
        $this->db->order_by('assignments.assign_id asc');
        return $this->db->get();
    }
    function get_checklisting_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having,$like){
            $table = $outlet_id."_assignments assignments";
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            $this->db->join($outlet_id.'_product_checks product_checks' , 'product_checks.id = assignments.checkid' , 'left');
            $this->db->join($outlet_id.'_plants plants' , 'assignments.plant_no = plants.plant_id' , 'left');
            if(!empty($group_by))
                $this->db->group_by($group_by);
            if(!empty($cols))
                $this->db->where($cols);
            if(!empty($or_where))
                $this->db->where($or_where);
            if(!empty($and_where))
                $this->db->where($and_where);
            if(!empty($having))
                $this->db->having($having);
            if(!empty($like))
                $this->db->like($like,'%');
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
    }
    function _update($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }
 function get_question_for_assignment($assign_id){
        $table = $this->get_table();
        $this->db->select('checks_questions.*');
        $this->db->from($table);
        $this->db->join(DEFAULT_OUTLET.'_checks_questions checks_questions' , 'assignments.checkid = checks_questions.checkid' , 'left');
        $this->db->where('assignments.assign_id',$assign_id);
        $this->db->order_by('assignments.assign_id asc');
        return $this->db->get();
    }
    function get_qa_checks_detail($assign_id){
        $table = $this->get_table();
        $this->db->select('assignments.* ,product_checks.checkname');
        $this->db->from($table);
        $this->db->join(DEFAULT_OUTLET.'_product_checks product_checks' , 'product_checks.id = assignments.checkid' , 'left');
        $this->db->where('assignments.assign_id',$assign_id);
        $this->db->order_by('assignments.assign_id asc');
        return $this->db->get();
    }
    function get_question_answer_detail($question_id,$assign_id){
        $table=DEFAULT_OUTLET."_checks_answers checks_answers";
        $this->db->select('checks_answers.*');
        $this->db->from($table);
       // $this->db->join(DEFAULT_OUTLET.'_checks_answers checks_answers' , 'checks_answers.answer_id = assignment_answer.answer_id' , 'left');
        //$this->db->where('assignment_answer.assignment_id',$assign_id);
        $this->db->where('checks_answers.question_id',$question_id);
        $this->db->order_by('checks_answers.question_id asc');
        
         $qery=$this->db->get();
       
        return $qery;
    }
     function update_assignment_status($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }
    function get_assignment_question_detail($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from(DEFAULT_OUTLET.'_assignment_answer assignment_answer');
        $this->db->join(DEFAULT_OUTLET.'_checks_questions checks_questions' , 'assignment_answer.question_id = checks_questions.question_id' , 'left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
}