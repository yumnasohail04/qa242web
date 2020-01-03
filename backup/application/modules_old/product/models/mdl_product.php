<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_product extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = DEFAULT_OUTLET."_product product";
        return $table;
    }
    function get_table_attribute(){
        $table = DEFAULT_OUTLET."_product_attributes";
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
     function _get_wips_data($order_by,$product_id) {
        $table = 'wip_attributes';
        $this->db->order_by($order_by);
        $this->db->where('product_id',$product_id);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $table = DEFAULT_OUTLET.'_product';
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
        $table =  DEFAULT_OUTLET."_product";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
    function _delete_wips_db($arr_col) {       
        $table =  "wip_attributes";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
    function check_if_exists($arr_col){
        $table = $this->get_table();
        $this->db->where($arr_col);
       return $this->db->get($table);
    }
    function check_atrribute_exists($arr_col){
        $table = $this->get_table_attribute();
        $this->db->where($arr_col);
       return $this->db->get($table);
    }
    function insert_attribute_data($data){
         $table = $this->get_table_attribute();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
      function get_attriutes_list($product_id){
        $table = $this->get_table_attribute();
        $this->db->where('product_id',$product_id);
        $this->db->where('outlet_id',DEFAULT_OUTLET);
       return $this->db->get($table);
      }
      function   _delete_product_attributes($arr_col){
        $table =  $this->get_table_attribute();
        $this->db->where($arr_col);
        $this->db->delete($table);
      }
        function update_attribute_data($where,$attribute_data){
                 $table = $this->get_table_attribute();
                 $this->db->where($where);
                 $this->db->update($table, $attribute_data);
        }
}