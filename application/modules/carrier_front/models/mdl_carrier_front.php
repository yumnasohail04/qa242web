<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_carrier_front extends CI_Model {

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

 
}
