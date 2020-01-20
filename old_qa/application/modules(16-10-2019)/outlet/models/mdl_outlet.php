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

function get_child($outlet_id=DEFAULT_OUTLET) {
$table = $this->get_table();
$this->db->select('id');
$this->db->where('parent_id = '.$outlet_id);
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

function _get_name($id){
$table = $this->get_table();
$this->db->select('name');
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


function _get_where_cols_post_code_delivery($arrcols,$order_by, $outlet_id=DEFAULT_OUTLET){
	
	if (!isset($arrcols['outlet_id']) || empty($arrcols['outlet_id'])){
		if (empty($outlet_id)) $outlet_id=DEFAULT_OUTLET;
		$arrcols['outlet_id']=$outlet_id;
	}
	

	if (defined('DEFAULT_CHILD')){
		unset($arrcols['outlet_id']);
		$outlets[] =  DEFAULT_OUTLET;
		$arr_outlet = $this->get_child(DEFAULT_OUTLET)->result_array();
		foreach ($arr_outlet as $key => $arr_value) {
			$outlets[] =  $arr_value['id'];
		}
		$this->db->where_in('outlet_id', $outlets);
	}   


	
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

function _insert_time($data){
$table = 'timing';
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

function _update_time($id, $data){
extract($id);
$table = 'timing';
$this->db->where('id', $id);
$this->db->update($table, $data);
}

function _update_where_cols($cols, $data){
$table = $this->get_table();
$this->db->where($cols);
$this->db->update($table, $data);
}

function get_resturant ($where = null) {
	$strWhere = '';
	$sql = 'Select outlet.id, outlet.name, outlet.url, outlet.url_slug, outlet.phone, outlet.email,  outlet.city, outlet.state, outlet.post_code, outlet.address, outlet.web_title, general_setting.take_out, general_setting.take_in, general_setting.delivery, outlet.image, timing.opening, timing.closing, timing.is_closed, general_setting.delivery_time , general_setting.delivery_charges , general_setting.delivery_charges_vat , general_setting.take_in_vat , general_setting.take_out_vat, general_setting.is_free_delivery,free_delivery_limit , general_setting.delivery_limit, outlet.restarurant_type, is_fixed_delivery from outlet Left Outer Join timing ON (outlet.id = timing.outlet_id) INNER Join general_setting ON (outlet.id = general_setting.outlet_id and timing.day = "'.date("l").'") Where outlet.status = 1 and outlet.is_default != 1 and  outlet.parent_id = 0';
	if ( count($where) > 0 )
	{
		if(isset($where['postcode']) && !empty($where['postcode']))
		{
			$less_post_code = $where['postcode'] - 20;
            $greater_post_code = $where['postcode'] + 20;
            
			$strWhere = ' outlet.post_code between '.$less_post_code.' AND '.$greater_post_code.'';
			$strTemp = '';
			if ($where['type']!=null) {
				$res_type = $where['type'];
				if (isset($res_type) && !empty($res_type)) {
		            $arr_type = explode(',', $res_type);
		            if (count($arr_type) > 1){
		            	foreach ($arr_type as $key => $value) {
		            		if (isset($value) && !empty($value))
		            		{
		            			if (!empty($strTemp)) $strTemp = $strTemp.' or ';
		            			$strTemp = $strTemp.' restarurant_type like "%'.$value.'%"';
		            		}	
		            	}

		            }
		            else $strTemp = ' restarurant_type like "%'.$res_type.'%"';
		            if (!empty($strTemp)) $strWhere = $strWhere.' AND ( '.$strTemp.' ) ';
       			 }
       		 }

   			 $arr_delivery = $where['delivery'];
   			 if (isset($arr_delivery) && !empty($arr_delivery)) {
	            $arr_delivery = explode(',', $arr_delivery);
	            if (count($arr_delivery) > 0){
	            	$strTemp = '';
	            	foreach ($arr_delivery as $key => $value) {

	            		if (!empty($strTemp)) $strTemp = $strTemp.' or ';

	            		if (isset($value) && !empty($value) && $value == '1' )
	            			$strTemp = $strTemp.' take_in=1';
	            		if (isset($value) && !empty($value) && $value == '2' )
	            			$strTemp = $strTemp.' take_out=1';
	            		if (isset($value) && !empty($value) && $value == '3' )
	            			$strTemp = $strTemp.' delivery=1';
	            	}
	            	if (!empty($strTemp)) $strWhere = $strWhere.' AND ( '.$strTemp.' ) ';
	            }
   			 }
			
		}
		if ($strWhere != '')
		{
			$sql = $sql.' AND '.$strWhere;
		}
	}
	else if ($where = null) $sql = $sql.' AND '.$where;
	$query = $this->db->query($sql);
	return $query;
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

	if (defined('DEFAULT_CHILD')){
		unset($arr_col['outlet_id']);
		$outlets[] =  DEFAULT_OUTLET;
		$arr_outlet = $this->get_child(DEFAULT_OUTLET)->result_array();
		foreach ($arr_outlet as $key => $arr_value) {
			$outlets[] =  $arr_value['id'];
		}
		$this->db->where_in('outlet_id', $outlets);
	} 
	else if (isset($arr_col) && $arr_col != '')
		$this->db->where($arr_col);
 
 $table = $this->get_table_post_code_delivery();
 $this->db->select("post_code_delivery.*, outlet.name");
 $this->db->join("outlet", "outlet.id = post_code_delivery.outlet_id", "left");

$this->db->order_by($order_by);
return $this->db->get($table);
}
function get_outlet_by_post_code($where){
$this->db->select("outlet.*");
$this->db->from('post_code_delivery');
$this->db->join("outlet", "outlet.id = post_code_delivery.outlet_id", "left");
$this->db->distinct();
$this->db->where($where);
return $this->db->get();
}


function _get_cols_by_id($id, $cols){
	$table = $this->get_table();
	$this->db->select($cols);
	$this->db->where($id);
	$query=$this->db->get($table);
	return $query;
}

function _create_tables($id)
{
	//Catagories
	$query = 'CREATE TABLE '.$id.'_catagories LIKE catagories; ';
	$this->_custom_query($query);
	//Catagories discounts
	$query = 'CREATE TABLE '.$id.'_category_discount LIKE category_discount; ';
	$this->_custom_query($query);
	//Products
	$query = " CREATE TABLE ".$id."_products LIKE products;";
	$this->_custom_query($query);
	//Stock
	$query = " CREATE TABLE ".$id."_stock LIKE stock;";
	$this->_custom_query($query);
	//add_on
	$query = 'CREATE TABLE '.$id.'_add_on LIKE add_on; ';
	$this->_custom_query($query);
	//Orders
	$query = "CREATE TABLE ".$id."_orders LIKE orders; ";
	$this->_custom_query($query);
	//orders detail
	$query = "CREATE TABLE ".$id."_orders_detail LIKE orders_detail;";
	$this->_custom_query($query);
	//order charges
	$query = "CREATE TABLE ".$id."_order_charges LIKE order_charges;";
	$this->_custom_query($query);
	//order discount
	$query = "CREATE TABLE ".$id."_order_discount LIKE order_discount;";
	$this->_custom_query($query);
	//order taxes
	$query = "CREATE TABLE ".$id."_order_taxes LIKE order_taxes;";
	$this->_custom_query($query);
	//product add ons
	$query = "CREATE TABLE ".$id."_product_add_ons LIKE product_add_ons;";
	$this->_custom_query($query);
	//product timing
	$query = "CREATE TABLE ".$id."_product_timing LIKE product_timing;";
	$this->_custom_query($query);

	$query = "CREATE TABLE ".$id."_add_on_products LIKE add_on_products;";
	$this->_custom_query($query);

	

	$query = " INSERT INTO `general_setting` ( `id` , `timezones` ,`date_format` ,`time_format` ,`outlet_id` ,`theme` ,`image` ,`take_in_vat` ,`take_out_vat` ,`delivery_charges` ,`delivery_charges_vat`, `is_fixed_delivery`) VALUES ('0', 'Europe/Copenhagen', '0', '0', ".$id.", NULL , NULL , '25', '15', '69', '25', '1');";
	$this->_custom_query($query);

}
function delete_table($id)
{
	//Catagories
	$query = 'DROP TABLE IF EXISTS '.$id.'_catagories;';
	$this->_custom_query($query);
	//Products
	$query = "DROP TABLE IF EXISTS ".$id."_products;";
	$this->_custom_query($query);
	//Stock
	$query = "DROP TABLE IF EXISTS ".$id."_stock";
	$this->_custom_query($query);
	//add_on
	$query = 'DROP TABLE IF EXISTS '.$id.'_add_on ; ';
	$this->_custom_query($query);
	//Orders
	$query = "DROP TABLE IF EXISTS ".$id."_orders ; ";
	$this->_custom_query($query);
	//orders detail
	$query = "DROP TABLE IF EXISTS ".$id."_orders_detail ;";
	$this->_custom_query($query);
	//order charges
	$query = "DROP TABLE IF EXISTS ".$id."_order_charges ;";
	$this->_custom_query($query);
	//order discount
	$query = "DROP TABLE IF EXISTS ".$id."_order_discount ;";
	$this->_custom_query($query);
	//order taxes
	$query = "DROP TABLE IF EXISTS ".$id."_order_taxes ;";
	$this->_custom_query($query);
	//product add ons
	$query = "DROP TABLE IF EXISTS ".$id."_product_add_ons;";
	$this->_custom_query($query);
	//product timing
	$query = "DROP TABLE IF EXISTS ".$id."_product_timing;";
	$this->_custom_query($query);

	

}

function _get_station($distance=10, $longitude, $latitude) {

	$query = 'Select z.*,
	 general_setting.take_in, general_setting.take_out, general_setting.delivery, general_setting.is_cash_on_delivery, general_setting.is_online_cash, general_setting.take_in_vat, general_setting.take_out_vat, general_setting.delivery_charges , general_setting.delivery_charges_vat , general_setting.is_fixed_delivery, general_setting.delivery_time , general_setting.is_coupon, general_setting.free_delivery_limit, general_setting.is_free_delivery, general_setting.delivery_limit,
	 	timing.day, timing.opening, timing.closing, timing.is_closed  
	 , p.distance_unit * DEGREES(ACOS(COS(RADIANS(p.latpoint)) * COS(RADIANS(z.latitude)) * COS(RADIANS(p.longpoint) - RADIANS(z.longitude))
    + SIN(RADIANS(p.latpoint)) * SIN(RADIANS(z.latitude)))) AS distance_in_miles
    FROM outlet AS z INNER JOIN general_setting ON (general_setting.outlet_id = z.id) INNER JOIN timing
 ON (timing.outlet_id = z.id and timing.day = DAYNAME(CURDATE()) ) JOIN ( SELECT  '.$latitude.'  AS latpoint,  '.$longitude.' AS longpoint, '.$distance.' AS radius, 69.0 AS distance_unit
   ) AS p ON 1=1  WHERE z.latitude BETWEEN p.latpoint  - (p.radius / p.distance_unit) AND p.latpoint  + (p.radius / p.distance_unit) AND z.longitude
   BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint)))) AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint)))) ORDER BY distance_in_miles
   LIMIT 15';
    $result = $this->_custom_query($query);
    return $result;
}
///////////////////////////umar apis start/////////////////////////
	function _get_new_limited_outlets($where,$order_by,$select,$page_number,$limit) {
		$table = $this->get_table();
		$offset=($page_number-1)*$limit;
		$this->db->select($select);
		$this->db->from($table);
		$this->db->group_by('outlet.id');
		$this->db->join('reviews','outlet.id=reviews.outlet_id','left'); 
		$this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
		if(isset($order_by) && !empty($order_by))
			$this->db->order_by($order_by);
		if(isset($where) && !empty($where))
			$this->db->where($where);
		if($limit != 0)
	        $this->db->limit($limit, $offset);
		return $this->db->get();

	}
	function _get_last_delivery_limited_outlets($where,$order_by,$select,$page_number,$limit) {
		$table = $this->get_table();
		$offset=($page_number-1)*$limit;
		$this->db->select($select);
		$this->db->from('orders');
		$this->db->group_by('orders.outlet_id,outlet.id');
		$this->db->join('outlet','orders.outlet_id=outlet.id','left');
		$this->db->join('reviews','outlet.id=reviews.outlet_id','left'); 
		$this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
		if(isset($order_by) && !empty($order_by))
			$this->db->order_by($order_by);
		if(isset($where) && !empty($where))
			$this->db->where($where);
		if(isset($order_by) && !empty($order_by)) 
			$this->db->order_by($order_by);
		if($limit != 0)
	        $this->db->limit($limit, $offset);
		return $this->db->get();

	}
	function _get_best_deals_outlets($where,$order_by,$select,$page_number,$limit) {
		$table = $this->get_table();
		$offset=($page_number-1)*$limit;
		$this->db->select($select);
		$this->db->from('deals');
		$this->db->group_by('deals.outlet_id,outlet.id');
		$this->db->join('outlet','deals.outlet_id=outlet.id','left');
		$this->db->join('reviews','outlet.id=reviews.outlet_id','left'); 
		$this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
		if(isset($where) && !empty($where))
			$this->db->where($where);
		if(isset($order_by) && !empty($order_by)) 
			$this->db->order_by($order_by);
		if($limit != 0)
	        $this->db->limit($limit, $offset);
		return $this->db->get();

	}
	function outlet_open_close($where) {
		$this->db->where($where);
		$query=$this->db->get('timing');
		return $query;

	}
	function _delete_outlet_catagories($where) {
		$this->db->where($where);
		$this->db->delete('outlet_catagories');
	}
	function _insert_outlet_catagories($data){
		for ($i=0; $i <sizeof($data) ; $i++) { 
			$table = "outlet_catagories";
			$this->db->insert($table, $data[$i]);
		}
	}
	function _get_outlet_catagories($where){
		$table = "outlet_catagories";
		$this->db->Select('outlet_catagory');
		$this->db->where($where);
		return $this->db->get($table);
	}
	function insert_dietary_data($data){
		$this->db->insert('outlet_dietary', $data);
	}
	function delete_dietary($where,$table){
		if(!empty($where))
		$this->db->where($where);
		$this->db->delete($table);
	}
	///////////////////////////end umar apis/////////////////////////

	/////////////asad api's/////////////////
	function insert_services_data($data){
		$this->db->insert('outlet_facilities', $data);
	}

}
