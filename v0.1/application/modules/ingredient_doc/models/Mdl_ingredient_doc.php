<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_ingredient_doc extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "ing_form_questions";
        return $table;
    }
    
    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
     function _get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function get_doc_assigned_types($where,$table,$order_by,$join_table,$table_attr,$jointable_attr,$select)
    {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->join("$join_table","$table.$table_attr=$join_table.$jointable_attr","LEFT");
        if(!empty($where))
        $this->db->where($where);
        if(!empty($order_by))
        $this->db->order_by($order_by);
        return $this->db->get();
    }
    function _update($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }
       function _update_id($id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }

    function _delete($arr_col) {       
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
    function insert_or_update_user_review($data,$table) {
        $this->db->insert($table, $data);
            
    }
   
}