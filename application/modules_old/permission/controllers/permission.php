<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends MX_Controller
{

function __construct() {
	parent::__construct();
	Modules::run('site_security/is_login');
	Modules::run('site_security/has_permission');
}

function manage(){
	$rs_rights = '';
	$outlets = array();
	$role_id = intval($this->uri->segment(4));
	if (defined('DEFAULT_CHILD_OUTLET'))   $outlet_id = DEFAULT_CHILD_OUTLET;
    else  $outlet_id = DEFAULT_OUTLET;
	$user_data = $this->session->userdata('user_data');
	$where1['id !='] = $curr_role_id = $user_data['role_id'];
	$where1['outlet_id'] = $outlet_id;
	$qry = Modules::run('roles/_get_where',$curr_role_id);
	$rs_role = $qry->row();
	if($rs_role->role == 'admin'){
		$where1['role !='] = 'Admin';
	}
	$query = Modules::run('roles/_get_where_cols',$where1);
	foreach($query->result() as $role){
		if($role->role != 'Admin')
			$rs_roles[$role->id] = $role->role;
	}
	$query2 = Modules::run('outlet/_get','name asc');
	foreach($query2->result() as $outlet){
			$outlets[$outlet->id] = $outlet->name;
	}
   

	if($role_id > 0){
		if($user_data['role'] == 'Admin'){
			$admin_rights = NULL;
			$query1 = Modules::run('rights/_get_where_custom','parent_id',0);
		}else{
				$where2['parent_id'] = 0;
				$where2['role_id'] = $user_data['role_id'];
				$qry2 = $this->_get_where_cols($where2); 
				foreach($qry2->result_array() as $right){
					$arr_rights[] = $right['right_id'];
					$where3['parent_id'] = $right['right_id'];
					$where3['role_id'] = $user_data['role_id'];
					$qry3 = $this->_get_where_cols($where3); 
					$result1 = $qry3->result(); 
					foreach($result1  as $adm_right){
						$admin_rights[] = $adm_right->right_id;
					}
				}
				$query1 = Modules::run('rights/_get_where_in',$arr_rights);
				
			}

		foreach($query1->result_array() as $key=>$parent){
			$where4['right_id'] = $parent['id'];
			$where4['role_id'] = $role_id;
			$query2 = $this->_get_where_cols($where4);
			$result2= $query2->row_array();
			$checked = '';
			if(isset($result2['right_id']) && $result2['right_id'] != ''){$checked = 'checked';}
			$rs_rights[$key]['id'] = $parent['id'];
			$rs_rights[$key]['right'] = $parent['right'];
			$rs_rights[$key]['checked'] = $checked;
			$query3 = Modules::run('rights/_get_where_custom','parent_id',$parent['id']);
			foreach($query3->result_array() as $right){
				$where5['right_id'] = $right['id'];
				$where5['role_id'] = $role_id;
				$where5['outlet_id'] = $outlet_id;
				$query3 = $this->_get_where_cols($where5);
				$result3= $query3->row_array();	
				$checked = '';
				
				if(isset($result3['right_id']) && $result3['right_id'] != ''){$checked = 'checked';}
				
				if($admin_rights != NULL && in_array($right['id'],$admin_rights)){
					$rs_rights[$key]['methods'][] = array('id'=>$right['id'],'right'=>$right['right'],'parent_id'=>$right['parent_id'],'checked'=>$checked);
				}
				else if($user_data['role'] == 'Admin' ){
					$rs_rights[$key]['methods'][] = array('id'=>$right['id'],'right'=>$right['right'],'parent_id'=>$right['parent_id'],'checked'=>$checked);
				}
			}
	}
  }

	$data['roles'] = $rs_roles;
	$data['outlets'] = $outlets;
	$data['rights'] = $rs_rights;
	// echo '<pre><<<<<<<<<<<<===================';print_r($data['rights']);exit();
	$data['role_id'] = $role_id;
	$data['outlet_id'] = $outlet_id;
	
	$data['view_file'] = 'permission';
	$this->load->module('template');
	$this->template->admin($data);
}


function submit($arr_rights='',$role_id='',$outlet_id=''){
	
	if($this->input->post('btnSubmit') == 'Save'){
		
		$arr_rights = $this->input->post('chkRight');
		$role_id = $this->input->post('lstRoles');
		if (defined('DEFAULT_CHILD_OUTLET'))   $outlet_id = DEFAULT_CHILD_OUTLET;
	    else  $outlet_id = DEFAULT_OUTLET;		
	}
	$delete = array('role_id'=>$role_id,'outlet_id'=>$outlet_id);
	$this->_delete_where($delete);
	$new = 0;
	$old = 0;
	foreach($arr_rights as $rights){
	
		if($rights != ''){
			$right = explode('_',$rights);
			$id = $right[0];
			$new = $right[1];
			if ($new != $old)
			{
				$old = $new;
				$parent_id = 0;
				$data['role_id'] = $role_id;
				$data['right_id'] = $new;
				$data['parent_id'] = $parent_id;
				$data['outlet_id'] = $outlet_id;
				$this->_insert($data);

			}
			$parent_id = $right[1];
			$data['role_id'] = $role_id;
			$data['right_id'] = $id;
			$data['parent_id'] = $parent_id;
			$data['outlet_id'] = $outlet_id;
			$this->_insert($data);
		}
	}
	$this->set_permission($role_id,$outlet_id);
	$this->session->set_flashdata('message','successfully assigned.');
	redirect(ADMIN_BASE_URL.'roles');
}

function set_permission($role_id,$outlet_id){
  	 $where['role_id'] = $role_id;
	 $where['outlet_id'] = $outlet_id;
	 $result = $this->_get_where_cols($where); 
	 $arr_rights = '';
	 $controller = '';
	 $parent_id = '';
	 foreach($result->result() as $right){
		if($right->parent_id == 0 ){
			$query =  Modules::run('rights/_get_where',$right->right_id);
			$rs_parent = $query->row();
			$controller = $rs_parent->right;
			$parent_id = $right->right_id;
		}
		if($right->parent_id == $parent_id){
			$query =  Modules::run('rights/_get_where',$right->right_id);
			$rs_method = $query->row();
			$arr_rights[$controller][] = $rs_method->right;
		}
	 }
	 echo "user_".$role_id."_".$outlet_id."_rights";
	$rtflag= $this->cache->delete("user_".$role_id."_".$outlet_id."_rights");
	// echo 'fl-'.$rtflag;
	 $rtflag1= $this->cache->write($arr_rights, "user_".$role_id."_".$outlet_id."_rights");
	 //echo 'wasim-'.$rtflag1;
}

function has_permission($role_id,$outlet_id,$controller, $action){
	 $allowed_modules = array('login', 'rights');
	 $rights = $this->cache->get("user_".$role_id."_".$outlet_id."_rights");

	// print $action.'---<pre>';print_r($rights);print "this =====>> user_".$role_id."_".$outlet_id."_rights";//exit;
    ///////////////////////////////

	 
//$json = json_encode($rights);
$file = ACTUAL_BANNER_IMAGE_PATH."debug_text.txt";
//using the FILE_APPEND flag to append the content.
file_put_contents ($file, "\n\n***************5a----user_".$role_id."_".$outlet_id."_rights*********** \n\n", FILE_APPEND);
file_put_contents ($file, "\n\n***************5----Permission->HAS Permission*********** \n\n", FILE_APPEND);
//file_put_contents ($file, $json, FILE_APPEND);
file_put_contents ($file, "\n\n************6******************action-".$action, FILE_APPEND);

    /////////////////////////
 //  exit();
	 if(in_array($controller, $allowed_modules)){
          return true;
	 }
	 else{
	 	file_put_contents ($file, "\n\n-8-", FILE_APPEND);
		 foreach($rights as $ctrl=>$act){
			if(!in_array($action, $rights[$controller])){				
			 return false;
			}else{				
				return true;
			}
		}		
		return false;
	 }
	 file_put_contents ($file, "\n\n-12--end -", FILE_APPEND);
	}

function has_control_permission($role_id,$outlet_id=DEFAULT_OUTLET,$controller){
	 $allowed_modules = array('login', 'rights');
//		echo "===>>> user_".$role_id."_".$outlet_id."_rights";exit;
	 $rights = $this->cache->get("user_".$role_id."_".$outlet_id."_rights");

	 if(in_array($controller, $allowed_modules)){
		 return true;
	 }
	 else{
	 		
	 		 	
	 		 foreach($rights as $ctrl=>$act){
	 		 	/*if ($controller=='reports' && $ctrl === $controller)
		 		{
		 			print'<pre>';print_r($act);
		 			print'<br>this =act=====>>>'.$act;
		 			print'<br>this =ctrl=====>>>'.$ctrl;
		 			print'<br> this =controller====>>>'.$controller;
		 			exit;
		 		}*/
	 			if ($ctrl === $controller) {
	 				return true; 
	 			}
			 }
			 return false;  
	   }
}


function get_navigation($role_id,$outlet_id){
	return $this->cache->get("user_".$role_id."_".$outlet_id."_rights");
}


////////////////////// GENERAL FUNCTIONS //////////////////////////
function _get($order_by){
$this->load->model('mdl_permission');
$query = $this->mdl_permission->_get($order_by);
return $query;
}

function _get_with_limit($limit, $offset, $order_by) {
$this->load->model('mdl_permission');
$query = $this->mdl_permission->_get_with_limit($limit, $offset, $order_by);
return $query;
}

function _get_where($id){
$this->load->model('mdl_permission');
$query = $this->mdl_permission->_get_where($id);
return $query;
}

function _get_where_custom($col, $value) {
$this->load->model('mdl_permission');
$query = $this->mdl_permission->_get_where_custom($col, $value);
return $query;
}

function _get_where_cols($where) {
$this->load->model('mdl_permission');
$query = $this->mdl_permission->get_where_cols($where);
return $query;
}

function _insert($data){
$this->load->model('mdl_permission');
$this->mdl_permission->_insert($data);
}

function _update($id, $data){
$this->load->model('mdl_permission');
$this->mdl_permission->_update($id, $data);
}

function _delete($id){
$this->load->model('mdl_permission');
$this->mdl_permission->_delete($id);
}

function _delete_where($col){
$this->load->model('mdl_permission');
$this->mdl_permission->_delete_where($col);
}

function _count_where($column, $value) {
$this->load->model('mdl_permission');
$count = $this->mdl_permission->_count_where($column, $value);
return $count;
}

function _get_max() {
$this->load->model('mdl_permission');
$max_id = $this->mdl_permission->_get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_permission');
$query = $this->mdl_permission->_custom_query($mysql_query);
return $query;
}

}