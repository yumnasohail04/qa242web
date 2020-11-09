<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_document extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "document";
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

    function update_attribute_data($where,$attribute_data,$table){
        $this->db->where($where);
        $this->db->update($table, $attribute_data);
    }
    function insert_attribute_data($data,$table){
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function check_atrribute_exists($arr_col,$table){
        $this->db->where($arr_col);
       return $this->db->get($table);
    }
    function delete_from_table($where,$table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
   
}