<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_post extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "outlet_types";
        return $table;
    }
	
	
    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
       
        $this->db->where($arr_col);
        return $this->db->get($table);
    }

    function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get($order_by) {
        $table = $this->get_table();
        
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

  
    function _get_where($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    
    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
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

       function _getItemById($id) {
        $table = $this->get_table();
        $this->db->where("( id = '" . $id . "'  )");
        $query = $this->db->get($table);
        return $query->row();
    }

    function _get_records($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

}