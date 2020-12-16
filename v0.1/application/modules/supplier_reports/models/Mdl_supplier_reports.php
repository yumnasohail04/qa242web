<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_supplier_reports extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function get_supplier_detail($where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1)
    {
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($where))
        $this->db->where($where);
        if(!empty($group_by))
        $this->db->group_by($group_by);
        if(!empty($order_by))
        $this->db->order_by($order_by);
        $this->db->join($join_table,"$table_attr=$join_attr","LEFT");
        $this->db->join($join_table1,"$table_attr1=$join_attr1","LEFT");
        return $this->db->get();
    }
    function get_supplier_detail_ingredients($where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1)
    {
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($where))
        $this->db->where($where);
        if(!empty($group_by))
        $this->db->group_by($group_by);
        if(!empty($order_by))
        $this->db->order_by($order_by);
        $this->db->join($join_table,"$table_attr=$join_attr","LEFT");
        $this->db->join($join_table1,"$table_attr1=$join_attr1","LEFT");
        $this->db->join("1_assigned_ingredient_types","$table_attr1=1_assigned_ingredient_types.ingredient_id","LEFT");
        $this->db->join("ingredient_types","1_assigned_ingredient_types.type_id=ingredient_types.id","LEFT");
        return $this->db->get();
    }
    function get_ingredient_form_detail($where,$or_where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1)
    {
        $this->db->select($select);
        $this->db->from($join_table1);
        if(!empty($where))
        $this->db->where($where);
        if(!empty($or_where))
        $this->db->where($or_where);
        if(!empty($group_by))
        $this->db->group_by($group_by);
        if(!empty($order_by))
        $this->db->order_by($order_by);
        $this->db->join("ing_form_ans","$join_attr1=ing_form_ans.ing_id","LEFT");
        $this->db->join("ing_form_options_ans","ing_form_ans.id=ing_form_options_ans.ans_id","LEFT");
        $this->db->join($table,"ing_form_ans.supplier_id=$table_attr","LEFT");
        return $this->db->get();
    }

}

