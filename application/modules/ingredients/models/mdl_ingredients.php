<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_ingredients extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = DEFAULT_OUTLET."_ingredients";
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
    function check_if_exists($where,$table){
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
    function _insert_data($data,$table){
        $this->db->insert($table, $data);
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
    function delete_from_table($where,$table)
    {
        $this->db->where($where);
        $this->db->delete($table);
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
    function insert_or_update_user_review($data,$table) {
        $this->db->insert($table, $data);
            
    }
    function _get_data_from_db_table_wip($where)
    {
        $table=DEFAULT_OUTLET.'_ingredients';
        $this->db->select("navision_number,product_name");
        $this->db->from($table);
        $this->db->join("wip_attributes","$table.wip_id=wip_attributes.id","LEFT");
        $this->db->where($where);
        return $this->db->get();
    }
    function _get_data_from_db_table_supplier($where)
    {
        $table=DEFAULT_OUTLET.'_ingredients_supplier';
        $this->db->select("$table.*,supplier.name");
        $this->db->from($table);
        $this->db->join("supplier","$table.supplier_id=supplier.id","LEFT");
        $this->db->where($where);
        return $this->db->get();
    }
    function _get_data_from_db_table_document($where)
    {
        $table=DEFAULT_OUTLET.'_ingredients_document';
        $this->db->select("$table.*,document.doc_name");
        $this->db->from($table);
        $this->db->join("document","$table.document_id=document.id","LEFT");
        $this->db->where($where);
        return $this->db->get();
    }
    
    function _get_data_from_db_table_type($where)
    {
        $table=  DEFAULT_OUTLET.'_ingredients';
        $table1= DEFAULT_OUTLET.'_assigned_ingredient_types';
        $table2= "ingredient_types";
        $this->db->select("$table2.name");
        $this->db->from($table);
        $this->db->join("$table1","$table.id=$table1.ingredient_id","LEFT");
        $this->db->join("$table2","$table1.type_id=$table2.id","LEFT");
        $this->db->where($where);
        return $this->db->get();
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
}