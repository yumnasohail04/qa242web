<?php
 /*************************************************
  Created By: Akabir Abbasi
  Dated: 01-01-2014
  version: 1.0
 *************************************************/

if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Roles_outlet extends MX_Controller {

    function __construct() {
		
        parent::__construct();
        $this->load->module('template');
    }

	function index(){ $this->create();}

    function create() {
		$emp_id = $this->uri->segment(4);
		$role_outlet_id = '';
		$role_outlet = $this->_get_where_custom('emp_id',$emp_id)->row();
		$query2 = Modules::run('users/_get','name asc');
        foreach ($query2->result() as  $emp) {
            $arr_emp[$emp->id] = $emp->name;
        }
		
		$arr_roles = array();
		$roles = Modules::run('roles/_get','id asc')->result();
		foreach($roles as $row){
			$arr_roles[$row->id] = $row->role;
		}
		if(isset($role_outlet->role_id) && $role_outlet->role_id != ''){
				$role_outlet_id = $role_outlet->role_id;
		}
		$data['role_outlet_id'] = $role_outlet_id;
		$data['emp_id'] = $emp_id;
        $data['employees'] = $arr_emp;
		$data['roles'] = $arr_roles;
        $data['view_file'] = 'roles-outlet-form';
        $this->template->admin($data);
    }

/////////////////////////////////////////////////////////////////////////////

    function _get_data_from_post() {
		$data['emp_id'] = $this->input->post('employee');
        $data['outlet_id'] = DEFAULT_OUTLET;
        $data['role_id'] = $this->input->post('lstRoles');
		return $data;
      
    }

    function _get_data_from_db($update_id) {
		$row = $this->_get_where($update_id)->row();
		$data['emp_id'] = $row->emp_id;
        $data['outlet_id'] = $row->outlet_id;
        $data['role_id'] = $row->role_id;
		return $data;
	}

    function submit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('value', 'Value', 'required|trim|xss_clean');
            $update_id = $this->input->post('hdn_roles_outlet_id');
            $data = $this->_get_data_from_post();
            if (is_numeric($update_id)) {
                $this->_update($update_id, $data);
				echo 'update';
            } else {
				$where['emp_id'] = $data['emp_id'];
				$where['outlet_id'] = $data['outlet_id'];
				$result = $this->_get_by_arr_id($where)->num_rows();
				if($result > 0){
					echo 'exist';
					exit;
				}

                $id = $this->_insert($data);
				echo $id;
            }
    }
	
	function get_roles_outlet(){
		$emp_id = $this->uri->segment(4);
		$roles_outlet = $this->_get_where_custom('emp_id',$emp_id)->result();
		$temp = array();
		foreach($roles_outlet as $key=>$row){
			$role = Modules::run('roles/_get_where',$row->role_id)->row();				
			$outlet = Modules::run('outlet/_get_where',$row->outlet_id)->row();
			$temp[$key]['id'] = $row->id;
			$temp[$key]['role'] = $role->role;
			$temp[$key]['outlet'] = $outlet->name;
		}
		
		$data['roles_outlet'] = $temp;
        $this->load->view('roles-outlet-details', $data);
	}
	
	function edit_roles_outlet() {
		$roles_outlet_id = $this->input->post('roles_outlet_id');
		$arr_roles_outlet = $this->_get_where($roles_outlet_id)->row();
		$query2 = Modules::run('employee/_get','name asc');
        foreach ($query2->result() as  $emp) {
            $arr_emp[$emp->id] = $emp->name;
        }
		
		$arr_roles = array();
		$roles = Modules::run('roles/_get_where_custom','outlet_id',$arr_roles_outlet->outlet_id)->result();
		foreach($roles as $row){
			$arr_roles[$row->id] = $row->role;
		}
		
		$arr_outlet = array();
		$outlets = Modules::run('outlet/_get','id asc')->result();
		foreach($outlets as $row){
			$arr_outlet[$row->id] = $row->name;
		}
		
		$data['roles_outlet'] = $arr_roles_outlet;
        $data['employees'] = $arr_emp;
		$data['outlets'] = $arr_outlet;
		$data['roles'] = $arr_roles;
		$data['roles_outlet_id'] = $roles_outlet_id;
		$this->load->view('edit-roles-outlet-details', $data);
    }
	
	
	function delete_roles_outlet(){
		$where['id'] = $this->input->post('roles_outlet_id');
		$this->_delete($where);
	}


////////////////////// GENERAL FUNCTIONS //////////////////////
    function _get($order_by) {
        $this->load->model('mdl_roles_outlet');
        $query = $this->mdl_roles_outlet->get($order_by);
        return $query;
    }

    function _get_with_limit($limit, $offset, $order_by) {
        $this->load->model('mdl_roles_outlet');
        $query = $this->mdl_roles_outlet->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function _get_where($id) {
        $this->load->model('mdl_roles_outlet');
        $query = $this->mdl_roles_outlet->get_where($id);
        return $query;
    }

    function _get_where_custom($col, $value) {
        $this->load->model('mdl_roles_outlet');
        $query = $this->mdl_roles_outlet->get_where_custom($col, $value);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_roles_outlet');
		
		
        return $this->mdl_roles_outlet->_get_by_arr_id($arr_col);
    }

    function _get_comments_by_arr_id($arr_col) {
        $this->load->model('mdl_roles_outlet');
        return $this->mdl_comments->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_roles_outlet');
        return $this->mdl_roles_outlet->_insert($data);
    }

    function comments_insert($data) {
        $this->load->model('mdl_roles_outlet');
        return $this->mdl_comments->_insert($data);
    }

    function _update($id, $data) {
        $this->load->model('mdl_roles_outlet');
        return $this->mdl_roles_outlet->_update($id, $data);
    }
	
    function _update_where($arr_col, $data) {
        $this->load->model('mdl_roles_outlet');
        return $this->mdl_roles_outlet->_update_where($arr_col, $data);
    }
	
    function _delete($arr_col) {
        $this->load->model('mdl_roles_outlet');
        $this->mdl_roles_outlet->_delete($arr_col);
    }

    function _get_max() {
        $this->load->model('mdl_roles_outlet');
        $max_id = $this->mdl_roles_outlet->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_roles_outlet');
        $query = $this->mdl_roles_outlet->_custom_query($mysql_query);
        return $query;
    }

    function _get_recordes() {
        $this->load->model('mdl_roles_outlet');
        return $this->mdl_roles_outlet->_get_recordes();
    }

}