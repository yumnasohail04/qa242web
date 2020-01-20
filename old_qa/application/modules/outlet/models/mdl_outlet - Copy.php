<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_outlet extends CI_Model {

function __construct() {
	parent::__construct();
}

function get_table() {
$table = "outlet";
return $table;
}




function get_table_post_code_delivery() {
$table = "post_code_delivery";
return $table;
}

function _get_all_details($order_by) {
$table = $this->get_table();
$this->db->where('is_default = 0');
$this->db->order_by($order_by);
$query = $this->db->get($table);
return $query;
}

function _get_all_details_admin($order_by) {
$table = $this->get_table();
$this->db->order_by($order_by);
$query = $this->db->get($table);
return $query;
}

function _get_contact($outlet_id=DEFAULT_OUTLET) {
$table = $this->get_table();
$this->db->where('id = '.$outlet_id);
return $this->db->get($table);
}

function _getItemById($id) {
$table = $this->get_table();
$this->db->where("( id = '" . $id . "'  )");
$query = $this->db->get($table);
return $query->row();
}
function _get($order_by){
$table = $this->get_table();
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}
function _get_by_arr_id($arr_col) {
$table = $this->get_table();
$this->db->where($arr_col);
return $this->db->get($table);
}

function _get_with_limit($limit, $offset, $order_by) {
$table = $this->get_table();
$this->db->limit($limit, $offset);
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function _get_where($id){
$table = $this->get_table();
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}

function _get_where_cols($cols,$order_by){
$table = $this->get_table();
$this->db->where($cols);
$query=$this->db->get($table);
return $query;
}


function _get_where_cols_post_code_delivery($arrcols,$order_by){
$table = $this->get_table_post_code_delivery();
$this->db->where($arrcols);
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


function _insert_post_code_delivery($data){
$table = $this->get_table_post_code_delivery();
$this->db->insert($table, $data);
return $this->db->insert_id();
}


function _insert($data){
$table = $this->get_table();
$this->db->insert($table, $data);
return $this->db->insert_id();
}



function _update_table_post_code_delivery($id, $data){
$table = $this->get_table_post_code_delivery();
$this->db->where('id', $id);
$this->db->update($table, $data);
}


function _update($id, $data){
//print_r($id);exit;
extract($id);
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->update($table, $data);
}

function _update_where_cols($cols, $data){
$table = $this->get_table();
$this->db->where($cols);
$this->db->update($table, $data);
}




function _delete_table_post_code_delivery($id){
$table = $this->get_table_post_code_delivery();
$this->db->where('id', $id);
$this->db->delete($table);
}

function _delete($id){
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->delete($table);
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

function _get_by_arr_id_post_code_delivery($arr_col='',$order_by){
$table = $this->get_table_post_code_delivery();

$this->db->select("post_code_delivery.*, outlet.name");

if (isset($arr_col) && $arr_col != '')
	$this->db->where($arr_col);

 $this->db->join("outlet", "outlet.id = post_code_delivery.outlet_id", "left");

$this->db->order_by($order_by);
return $this->db->get($table);
}

function _create_tables($id)
{
	//add_on
	$query = ' CREATE TABLE IF NOT EXISTS `'.$id.'._add_on` ( `id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(250) NOT NULL, `parent_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL, `status` int(11) NOT NULL DEFAULT '1', `is_free` tinyint(1) NOT NULL DEFAULT '0', PRIMARY KEY (`id`) ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';
	$this->_custom_query($query);

	//_add_on_products
	$query = ' CREATE TABLE IF NOT EXISTS `'.$id.'_add_on_products` ( `id` int(11) NOT NULL AUTO_INCREMENT, `add_on_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `stock_id` int(11) NOT NULL, `outlet_id` int(11) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';
	$this->_custom_query($query);

	//categories
	$query = ' CREATE TABLE IF NOT EXISTS `'.$id.'_catagories` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `cat_name` char(150) NOT NULL DEFAULT '',   `meta_description` varchar(255) NOT NULL, `cat_desc` text NOT NULL, `size_group` int(11) NOT NULL, `image` varchar(100) NOT NULL, `add_on_id` int(11) DEFAULT NULL, `rank` int(11) NOT NULL DEFAULT '0', `parent_id` int(11) NOT NULL, `is_active` tinyint(1) NOT NULL DEFAULT '0', `is_home` tinyint(1) NOT NULL DEFAULT '0',  `url_slug` varchar(150) DEFAULT NULL, `outlet_id` int(11) unsigned NOT NULL, `is_default` tinyint(1) NOT NULL DEFAULT '0', `is_blog` tinyint(1) NOT NULL DEFAULT '0',
  `show_in_footer` tinyint(1) NOT NULL,
  `show_in_homepage` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `outlet_id` (`outlet_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

';
	$this->_custom_query($query);



	//customers
	$query = ' CREATE TABLE IF NOT EXISTS `'.$id.'_customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address1` varchar(150) NOT NULL,
  `address2` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `postcode` varchar(50) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `invoiceable` tinyint(4) NOT NULL DEFAULT '0',
  `c_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `outlet_id` int(10) unsigned DEFAULT NULL,
  `is_subscribed` int(11) NOT NULL DEFAULT '0',
  `building_floor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';
	$this->_custom_query($query);



}


}