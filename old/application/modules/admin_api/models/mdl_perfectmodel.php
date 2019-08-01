<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_perfectmodel extends CI_Model {

        function __construct() {
            parent::__construct();
        }
        function get_outlet_order_list($where,$order,$outlet_id,$select,$where_status,$page_number,$limit) {
            $offset = ($page_number-1) *$limit;
            $this->db->select($select);
            $this->db->from('users_orders');
            $this->db->join($outlet_id.'_orders','users_orders.order_id='.$outlet_id.'_orders.id','left');
            if(isset($where) && !empty($where))
                $this->db->where($where);
            if(isset($where_status) && !empty($where_status))
                $this->db->where($where_status);
            if(isset($limit) && !empty($limit))
                if($limit !=0)
                    $this->db->limit($limit,$offset);
            if(isset($order) && !empty($order))
                $this->db->order_by($order);
            return $this->db->get();
        }
        function _get_outlet_order_income_reports($cols, $order_by,$table,$select,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            $this->db->join('users_orders',$table.".id=users_orders.order_id",'left');
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
}
