<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_catagories extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "catagories";
        return $table;
    }

    function get($where, $order_by) {
        $table = $this->get_table();
        $this->db->where('parent_id', $where);
        $this->db->where('is_active', 1);
        $this->db->where('is_blog', 0);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }
	
	function _get_cat_board_member($id=184) {
        $table = $this->get_table();
        $this->db->where('id = '.$id);
        return $this->db->get($table);
    }

    function _get_sub_cat($order_by) {
        $table = $this->get_table();
        $this->db->where('parent_id !=', 0);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_sub_cat_by_id($where) {
        $table = $this->get_table();
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_sub_cats_ajax($cat_id) {
        $this->db->select('catagories.id, catagories.cat_name');
        $this->db->from('catagories');
		$this->db->where('catagories.parent_id', $cat_id);
        $this->db->order_by("catagories.parent_id", "asc");
        return $this->db->get();
    }

    function _get_sub_cat_type_by_id($where) {
        $table = $this->get_table();
        $this->db->where('id', $where);
        $query = $this->db->get($table);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where($id) {
        $table = $this->get_table();
        $this->db->where('outlet_id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_sub_catagories($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }
function _get_sub_catagories_front($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->where('is_active','1');
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }
    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _update($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }

     function _update_id($id, $data){
      $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->update($table, $data);

      }
     

    function _set_active($where) {
        $table = $this->get_table();
        $set_active['is_active'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_active);
    }

    function _set_default($where) {
        $table = $this->get_table();
        $unset_default['is_default'] = 0;
        $this->db->update($table, $unset_default);
        $set_default['is_default'] = 1;
        $set_active['is_active'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_default);
        $this->db->where($where);
        $this->db->update($table, $set_active);
    }

    function _set_in_active($where) {
        $table = $this->get_table();
        $set_in_active['is_active'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_in_active);
    }

    function _search_catagory($strSearch, $limit, $segment, $where, $order) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit, $segment);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $this->db->order_by($order);
        return $this->db->get($table);
    }

    function _search_sub_cat($strSearch, $limit, $segment, $where, $order) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit, $segment);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $this->db->order_by($order);
        return $this->db->get($table);
    }

    function _delete($arr_col) {
        $arr_self_id['id'] = $arr_col['id'];
        $arr_parent_id['parent_id'] = $arr_col['parent_id'];
    /////////// TO delete all sub pages
        $table = $this->get_table();
        $this->db->where($arr_parent_id);
        $this->db->delete($table);
    /////////// TO delete parent page itself
        $this->db->where($arr_self_id);
        $this->db->delete($table);
    }


    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }

    function count_where($column, $order) {
        $table = $this->get_table();
        $this->db->where($column, $order);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_search($strSearch, $column) {
        $table = $this->get_table();
        $this->db->where($column);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_sub_cat_search($strSearch, $column) {
        $table = $this->get_table();
        $this->db->where($column);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_sub_cat($column, $order) {
        $table = $this->get_table();
        $this->db->where($column, $order);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_all() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max() {
        $table = $this->get_table();
        $this->db->select_max('id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

    function _set_home($where) {
        $table = $this->get_table();
        $set_home['is_home'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_home);
    }

    function _set_not_home($where) {
        $table = $this->get_table();
        $set_not_home['is_home'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_not_home);
    }

    function _get_front_home_cats($where, $limit) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit);
        return $this->db->get($table);
    }

    function _get_front_leftpanel_cats($where, $order_by) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_cat($show_footer) {
        $table = $this->get_table();
        $this->db->where('show_in_footer = '.$show_footer);
        return $this->db->get($table);
    }
    function _get_default_cat($where, $order_by) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_cat_details_by_id($where, $order_by) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }

    function _getItemById($id) {
        $table = $this->get_table();
        $this->db->where("( id = '" . $id . "'  )");
        $query = $this->db->get($table);
        return $query->row();
    }

    function _get_records($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _get_cat_sub_cats_items_count($order_by){
        $this->db->select('catagories.id, catagories.cat_name, catagories.image, catagories.url_slug, count(items.id) as total_items');
        $this->db->from('catagories');
        $this->db->join("items", "catagories.id = items.category_id", "inner");
		$this->db->group_by("catagories.id");
        $this->db->order_by($order_by);
        return $this->db->get();
    }

    function _get_sub_cats_with_items_count($cat_id, $order_by){
        $this->db->select('catagories.id, catagories.cat_name, catagories.url_slug, count(items.id) as total_items');
        $this->db->from('catagories');
        $this->db->join("items", "catagories.id = items.sub_category_id", "inner");
		$this->db->where('catagories.parent_id', $cat_id);
		$this->db->group_by("catagories.id");
        $this->db->order_by($order_by);
        return $this->db->get();
    }
     function _insert_attributes_data($data){
        $table="check_catagories_attributes";
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }
    function get_discounts_arr_from_db($update_id){
        $table="check_catagories_attributes";
        $this->db->select('check_catagories_attributes.*,catagories.name');
        $this->db->join('outlet','check_catagories_attributes.cat_id=catagories.id','left');
        $this->db->where('org_outlets.org_id',$update_id);
        $query = $this->db->get($table);
        return $query;
    }
    function delete_org_outlet_db($arr_col){
        $table = "check_catagories_attributes";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
////////////////////////////////

    function _get_sub_catagories_attibutes($where,$order_by){
        $table = "check_catagories_attributes";
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }
    function _update_catagories_attributes($where,$data){
         $table ="check_catagories_attributes";
        $this->db->where($where);
        $this->db->update($table, $data);
    }
    function _delete_attributes($arr_col){
         $table = "check_catagories_attributes";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
}