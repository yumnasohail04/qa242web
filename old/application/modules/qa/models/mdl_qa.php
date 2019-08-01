<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_qa extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $outlet_id=DEFAULT_OUTLET;
        $table = $outlet_id."_questions";
        return $table;
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