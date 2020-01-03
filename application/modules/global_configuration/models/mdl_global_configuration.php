<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_global_configuration extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "notification_setting";
        return $table;
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

   

    function delete_table_data(){
         $table = $this->get_table();
        $this->db->empty_table($table);
    }
    function get_product_schedules_from_db($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($outlet_id.'_product_schedules as product_schedules');
        $this->db->join($outlet_id.'_product as product','product_schedules.ps_product=product.id','left');
        $this->db->join($outlet_id.'_plants as plants','product_schedules.ps_plant = plants.plant_id','left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($and_where))
            $this->db->where($and_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
	function get_lines_by_plant($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having) {
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($outlet_id.'_line_plants as line_plants');
        $this->db->join($outlet_id.'_plants as plant','line_plants.lp_plant = plant.plant_id','left');
        $this->db->join($outlet_id.'_lines as liness','line_plants.lp_line = liness.line_id','left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($and_where))
            $this->db->where($and_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
}