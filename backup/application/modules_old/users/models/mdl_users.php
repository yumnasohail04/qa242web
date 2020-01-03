<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_users extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
$table = "users";
return $table;
}

function _get($order_by){
$table = $this->get_table();
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function _get_with_limit($limit, $offset, $order_by) {
$table = $this->get_table();
$this->db->limit($limit, $offset);
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}
function _get_where_login($username, $password){
$table = $this->get_table();
$this->db->where('user_name', $username);
$this->db->where('password', $password);
$query=$this->db->get($table);
return $query;
}
function _get_where($id){
$table = $this->get_table();
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}
function _get_where_user($id){
$table = $this->get_table();
$this->db->where('role_id', $id);
$query=$this->db->get($table);
return $query;
}
function _get_where_validate($id, $user_name){	
$table = $this->get_table();
/*$this->db->where('outlet_id', $id );*/
$this->db->where('user_name', $user_name);
$query=$this->db->get($table);
return $query;
}

function _getItemById($id) {
$table = $this->get_table();
$this->db->where("( id = '" . $id . "'  )");
$query = $this->db->get($table);
return $query->row();
}

function _get_by_arr_id($arr_col) {
$table = $this->get_table();
$this->db->join('outlet', 'outlet.id = users.outlet_id', 'INNER');
$this->db->select('users.*, outlet.image, outlet.name as outlet_name, outlet.email as outlet_email, outlet.phone as outlet_phone, outlet.city as outlet_city, outlet.state as outlet_state, outlet.post_code as outlet_post_code, outlet.address as outlet_address');
$this->db->where($arr_col);
return $this->db->get($table);
}


function _get_where_cols($cols, $order_by=''){
$table = $this->get_table();
$this->db->where($cols);
if ($order_by!='')
	$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function _get_where_custom($col, $value, $order_by) {
$table = $this->get_table();
$this->db->where($col, $value);
$query=$this->db->get($table);
return $query;
}

function _insert($data){
$table = $this->get_table();
$this->db->insert($table, $data);
return $this->db->insert_id();
}

function _delete($id) {
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->delete($table);
}

function _update($arr_col, $data) {
$table = $this->get_table();
$this->db->where($arr_col);
$this->db->update($table, $data);
}

function _update_where_cols($cols, $data){
$table = $this->get_table();
$this->db->where($cols);
$this->db->update($table, $data);
return $this->db->affected_rows();
}

function _update_id($id, $data){
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->update($table, $data);
}

function _count_where($column, $value) {
$table = $this->get_table();
$this->db->where($column, $value);
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function _count_all() {
$table = $this->get_table();
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function _get_max() {
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