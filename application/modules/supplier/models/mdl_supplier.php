<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_supplier extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "supplier";
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
	function ingredient_list_supplier($id)
    {
     	$table = DEFAULT_OUTLET."_ingredients_supplier";
    	$table1= DEFAULT_OUTLET."_ingredients";
    	$this->db->select("$table1.item_name,$table1.item_no,$table1.plm_no,$table.role");
    	$this->db->from($table);
    	$this->db->join("$table1","$table.ingredient_id=$table1.id","LEFT");
    	$this->db->where("$table.supplier_id",$id);
        $query = $this->db->get();
        return $query;
    }
    function check_if_exists($where)
    {
        $table = $this->get_table();
        $this->db->where($where);
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
    
    function _get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit)
    {
        $this->db->from($table);
        $this->db->select($select);
        if(!empty($order_by))
        $this->db->order_by($order_by);
        if(!empty($group_by))
        $this->db->group_by($group_by);
        if(!empty($where))
        $this->db->where($where);
        if(!empty($limit))
        $this->db->limit($limit);
        return $this->db->get();
    }
    function delete_from_table($where,$table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }
   
}