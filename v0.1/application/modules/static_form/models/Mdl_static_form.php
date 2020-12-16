<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_static_form extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function _get_by_arr_id($arr_col) {
        $table = DEFAULT_OUTLET.'_static_form';
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
	function get_static_question_detail($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from(DEFAULT_OUTLET.'_static_assignment_answer saa');
        $this->db->join(DEFAULT_OUTLET.'_static_form_question static_form_question' , 'saa.question_id = static_form_question.sfq_id' , 'left');
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
    function get_static_checks_detail($assign_id){
        $table = DEFAULT_OUTLET.'_static_assignments static_assignments';
        $this->db->select('static_assignments.* ,static_form.sf_name');
        $this->db->from($table);
        $this->db->join(DEFAULT_OUTLET.'_static_form static_form' , 'static_assignments.check_id = static_form.sf_id' , 'left');
        $this->db->where('static_assignments.assign_id',$assign_id);
        $this->db->order_by('static_assignments.assign_id asc');
        return $this->db->get();
    }     
}