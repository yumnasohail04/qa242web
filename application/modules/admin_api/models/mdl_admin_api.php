<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_admin_api extends CI_Model {

  function __construct() {
      parent::__construct();
  }
  function get_chat_detail($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having){
      $offset=($page_number-1)*$limit;
      $this->db->select($select);
      $this->db->from($outlet_id."_chat_detail chat_detail");
      $this->db->join($outlet_id.'_messages messages' , 'chat_detail.message_id = messages.message_id' , 'left');
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
