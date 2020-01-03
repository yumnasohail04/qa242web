<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_scheduled_attributes extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "herbspice_attributes";
        return $table;
    }

    

     function _insert_attributes_data($data){
        $table="herbspice_attributes";
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
    function get_discounts_arr_from_db($update_id){
        $table="herbspice_attributes";
        $this->db->select('herbspice_attributes.*,catagories.name');
        $this->db->join('outlet','herbspice_attributes.cat_id=catagories.id','left');
        $this->db->where('org_outlets.org_id',$update_id);
        $query = $this->db->get($table);
        return $query;
    }
    function delete_org_outlet_db($arr_col){
        $table = "herbspice_attributes";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
////////////////////////////////

    function _get_sub_catagories_attibutes($where,$order_by){
        $table = "herbspice_attributes";
        if(!empty($where))
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }
    function _update_catagories_attributes($where,$data){
         $table ="herbspice_attributes";
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function _delete_attributes($arr_col){
         $table = "herbspice_attributes";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
}