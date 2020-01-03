<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_bowl_fill extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "wip_profile";
        return $table;
    }

    

     function _insert_attributes_data($data){
        $table="wip_profile";
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
    function get_discounts_arr_from_db($update_id){
        $table="wip_profile";
        $this->db->select('wip_profile.*,catagories.name');
        $this->db->join('outlet','wip_profile.cat_id=catagories.id','left');
        $this->db->where('org_outlets.org_id',$update_id);
        $query = $this->db->get($table);
        return $query;
    }
    function delete_org_outlet_db($arr_col){
        $table = "wip_profile";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
////////////////////////////////

    function _get_sub_catagories_attibutes($where,$order_by){
        $table = "wip_profile";
        if(!empty($where))
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }
    function _update_catagories_attributes($where,$data){
         $table ="wip_profile";
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function _delete_attributes($arr_col){
         $table = "wip_profile";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
}