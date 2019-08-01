<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_roles_outlet extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "roles_outlet";
        return $table;
    }

    function get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
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

    function _get_records($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function get_where($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_front_login($column) {
        $table = $this->get_table();
        $this->db->where($column);
        $query = $this->db->get($table);
        return $query;
    }

    function user_name_availabity($user_name) {
        $table = $this->get_table();
        $this->db->where('user_name', $user_name);
        $query = $this->db->get($table);
        return $query;
    }

    function email_availabity($email) {
        $table = $this->get_table();
        $this->db->where('email', $email);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function pword_check($user_name, $password) {
        $table = $this->get_table();
        $this->db->where('user_name', $user_name);
        $this->db->where('password', $password);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        if ($num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }

        return $num_rows;
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function front_insert($data) {

        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _set_publish($where) {
        $table = $this->get_table();
        $set_publish['status'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_publish);
    }

    function _set_unpublish($where) {
        $table = $this->get_table();
        $set_unpublish['status'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_unpublish);
    }

    function _update($id, $data) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function _update_where($column, $data) {
        $table = $this->get_table();
        $this->db->where($column);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }

    function _delete($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->delete($table);
    }

    function count_where() {
        $table = $this->get_table();
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

    function _get_front_videos($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_front_gallery($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }

    function _get_recordes() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _get_vendor() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        return $query;
    }

}
