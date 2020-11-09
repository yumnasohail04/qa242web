<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_carrier extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "carrier";
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

    function get_doc_by_carrier_type($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where='',$having='')
    {
        $this->db->from($table);
        $this->db->select($select);
        $this->db->join("doc_carrier_types","$table.id=doc_carrier_types.doc_id","LEFT");
        if(!empty($order_by))
        $this->db->order_by($order_by);
        if(!empty($group_by))
        $this->db->group_by($group_by);
        if(!empty($where))
        $this->db->where($where);
        if(!empty($or_where))
        $this->db->where("doc_carrier_types.carrier_type",$or_where);
        if(!empty($limit))
        $this->db->limit($limit);
        return $this->db->get();
    }
   
}