<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_catagories_discount extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
$table = "user_cat_discount1";
return $table;
}

function _add_user_cat_disc($data){
$table = $this->get_table();
$this->db->insert($table, $data);
$insert_id = $this->db->insert_id();
return $insert_id;
}

function _delete_user_cat_disc($arr_col){
$table = $this->get_table();
$this->db->where($arr_col);
$this->db->delete($table);
}

function get($arr_col){
$table = $this->get_table();
$this->db->where($arr_col);
$query=$this->db->get($table);
return $query;
}

function get_with_limit($limit, $offset, $order_by) {
$table = $this->get_table();
$this->db->limit($limit, $offset);
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function get_where($id){
$table = $this->get_table();
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}

function get_where_custom($col, $value) {
$table = $this->get_table();
$this->db->where($col, $value);
$query=$this->db->get($table);
return $query;
}

function _update($arr_col, $data){
$table = $this->get_table();
$this->db->where($arr_col);
$this->db->update($table, $data);
}

function _get_by_arr_id($arr_col){
$table = $this->get_table();
$this->db->where($arr_col);
return $this->db->get($table);
}

function count_where($column, $order) {
$table = $this->get_table();
$this->db->where($column, $order);
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function count_all() {
$table = $this->get_table();
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function get_max() {
$table = $this->get_table();
$this->db->select_max('id');
$query = $this->db->get($table);
$row=$query->row();
$id=$row->id;
return $id;
}

function _custom_query($mysql_query) {
$query = $this->db->query($mysql_query);
return $query;

}
}