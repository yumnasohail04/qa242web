<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_test extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function insert_test_question_data($where,$data,$table) {
         $insert_id = 0;
        if(!empty($where))
            $this->db->where($where);
        $query=$this->db->get($table)->num_rows();
        if($query > 0 && !empty($where)) {
          if(!empty($where))
            $this->db->where($where);
        $this->db->update($table, $data);
        }
        else {
          $this->db->insert($table, $data);
          $insert_id = $this->db->insert_id();
        }
        if(isset($insert_id) && is_numeric($insert_id))
          return $insert_id; 
    }
    function delete_test_question_data($where) {       
        $table = DEFAULT_OUTLET.'_test_question_answers';
        if(!empty($where))
            $this->db->where($where);
        $this->db->delete($table);
    }
    function get_specific_table_data($where,$order,$select,$table_name,$page_number,$limit) {
        $offset = ($page_number-1) *$limit;
        $this->db->select($select);
        $this->db->from($table_name);
        if(isset($where) && !empty($where))
            $this->db->where($where);
        if(isset($limit) && !empty($limit))
            if($limit !=0)
                $this->db->limit($limit,$offset);
        if(isset($order) && !empty($order))
            $this->db->order_by($order);
        return $this->db->get();
    }
    function get_table() {
        $outlet_id=DEFAULT_OUTLET;
        $table = $outlet_id."_test";
        return $table;
    }
       function _get($order_by) {
         $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }
   function insert_ans($dataans)
   {
     $outlet_id=DEFAULT_OUTLET;
        $table =$outlet_id."_answers" ;
        $this->db->insert($table, $dataans);
        return $insert_id;
   }
    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
     function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
         function _update_id($id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }
    function _get_by_arr_id_answer($arr_col)
    {
        $outlet_id=DEFAULT_OUTLET;
        $table=$outlet_id."_answers";
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
     function _update($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }
     function _delete($arr_col) {       
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
    function insert_or_update_user_review($where,$data,$table) {
        if(!empty($where))
            $this->db->where($where);
        $this->db->update($table, $data);
            
    }
}