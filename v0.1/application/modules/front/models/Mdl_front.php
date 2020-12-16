<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_front extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_ingredients_data($doc_id,$supplier_id)
    {
       // $table=DEFAULT_OUTLET.'_ingredients_supplier';
        $table1=DEFAULT_OUTLET.'_ingredients_document';
        $this->db->select("$table1.document");
        $this->db->from($table1);
       // $this->db->join("$table1","$table.ingredient_id=$table1.ingredient_id","LEFT");
        $this->db->where(array("$table1.document_id"=>$doc_id,"$table1.supplier_id"=>$supplier_id));
        return $this->db->get();
    }
    

    function supplier_ingredients($supplier_id,$ing_id)
    {
        $table=DEFAULT_OUTLET.'_ingredients_supplier';
        $table1=DEFAULT_OUTLET.'_assigned_ingredient_types';
        $this->db->select("$table1.type_id");
        $this->db->from($table1);
        //$this->db->join("$table1","$table.insgredient_id=$table1.ingredient_id","LEFT");
        //$this->db->where("$table1.supplier_id",$supplier_id);
        $this->db->where("$table1.ingredient_id",$ing_id);
        return $this->db->get();
    }
    function _get_specific_table_with_pagination_and_where($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->or_where($or_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
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
    function get_doc_by_ingredient_type($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where='',$having='')
    {
        $this->db->from($table);
        $this->db->select($select);
        $this->db->join("doc_ingredient_types","$table.id=doc_ingredient_types.doc_id","LEFT");
        if(!empty($order_by))
        $this->db->order_by($order_by);
        if(!empty($group_by))
        $this->db->group_by($group_by);
        if(!empty($where))
        $this->db->where($where);
        if(!empty($or_where))
        $this->db->where("doc_ingredient_types.ing_type",$or_where);
        if(!empty($limit))
        $this->db->limit($limit);
        return $this->db->get();
    }
    function get_roles_group($where,$or_where,$table,$jtable)
    {
        $this->db->from($table);
        $this->db->select("$jtable.id");
        $this->db->join("$jtable","$table.id=$jtable.role","LEFT");
        if(!empty($where))
        $this->db->where($where);
        if(!empty($or_where))
        $this->db->or_where($or_where);
        return $this->db->get();
    }
}
