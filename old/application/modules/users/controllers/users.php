<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends MX_Controller
{

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');
}

        function index() {

            if (defined('DEFAULT_CHILD_OUTLET'))   $nOutlet_id = DEFAULT_CHILD_OUTLET;
            else  $nOutlet_id = DEFAULT_OUTLET;
    		$where_user['outlet_id'] = $nOutlet_id;
    		$data['users_rec'] = $this->_get_where_cols($where_user, 'id desc')->result_array();
    		$data['view_file'] = 'users_listing';
            $this->load->module('template');
            $this->template->admin($data);
        }

        function load_listing() {
            if (defined('DEFAULT_CHILD_OUTLET'))   $nOutlet_id = DEFAULT_CHILD_OUTLET;
            else  $nOutlet_id = DEFAULT_OUTLET;    
    		$where_user['outlet_id'] = $nOutlet_id;
    		$data['users_rec'] = $this->_get_where_cols($where_user, 'id desc')->result_array();
            $this->load->view('listing', $data);      
        }

        function print_test(){
            $columnHeader = '';  
            $columnHeader = "Sr NO" . "\t" . "User Name" . "\t" . "Password" . "\t";  
            $setData = '';  
            $result=$this->_get()->result_array();
                $rowData = '';  
                foreach ($result as $value) {  
                    $value = '"' . $value['user_name'] . '"' . "\t";  
                    $rowData .= $value;  
                }  
                $setData .= trim($rowData) . "\n";  
            header("Content-type: application/octet-stream");  
            header("Content-Disposition: attachment; filename=User_Detail_Reoprt.xls");  
            header("Pragma: no-cache");  
            header("Expires: 0");  
            echo ucwords($columnHeader) . "\n" . $setData . "\n";
            redirect(ADMIN_BASE_URL . 'users');

        }
        function create(){	
            $update_id = $this->uri->segment(4);
    		if($update_id && $update_id != 0) {
    			$data['users'] = $this->_get_data_from_db($update_id);
    		}else{
    			$data['users'] = $this->_get_data_from_post();
    		}
            $data['update_id'] = $update_id;
            $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
            if(!empty($groups)) {
                $temp= array();
                foreach ($groups as $key => $gp):
                    $temp[$gp['id']] = $gp['group_title'];
                endforeach;
                $groups = $temp;
            }
            $data['groups'] = $groups;
            if (defined('DEFAULT_CHILD_OUTLET'))   $nOutlet_id = DEFAULT_CHILD_OUTLET;
            else  $nOutlet_id = DEFAULT_OUTLET;
    		$arrWhere['outlet_id'] = $nOutlet_id;
            $arr_roles = Modules::run('roles/_get_by_arr_id',$arrWhere)->result_array();
    		$roles = array();
            foreach($arr_roles as $row){
                $roles[$row['id']] = $row['role'];
            }
    		$data['roles_title'] = $roles;
            $data['view_file'] = 'users_form';
            $this->load->module('template');
            $this->template->admin_form($data);
        }
        function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            
            if ($update_id && $update_id != 0) {
                    $where['id'] = $update_id;
                    $itemInfo = $this->_getItemById($update_id);
                    if(isset($_FILES['user_image']) && !empty($_FILES['user_image'])) {
                        if($_FILES['user_image']['size']>0) {
                            if(isset($itemInfo->user_image) && !empty($itemInfo->user_image))
                            Modules::run("api/delete_images_by_name",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$itemInfo->user_image);
                            Modules::run("api/upload_dynamic_image",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$update_id,"user_image","user_image","id","users");
                        }
                    }
                    $this->_update($where, $data);
						$this->session->set_flashdata('message', 'User'.'Data Update');										
		                $this->session->set_flashdata('status', 'success');
                    
                }
            else {
                
                $data = $this->_get_data_from_post();
                $id = $this->_insert($data);
                if(isset($_FILES['user_image']) && !empty($_FILES['user_image'])) {
                    if($_FILES['user_image']['size']>0) {
                        Modules::run("api/upload_dynamic_image",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$id,"user_image","user_image","id","users");
                    }
                }
				$this->session->set_flashdata('message', 'User'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
                $data['users'] = $this->_get()->result_array();
                $data['view_file'] = 'users_listing';
                $this->load->module('template');
                $this->template->admin($data);
            }
            redirect(ADMIN_BASE_URL . 'users');
    }

    function _get_data_from_db($update_id) {
        $where['users.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['user_name'] = $row->user_name;
            $data['first_name'] = $row->first_name;
            $data['last_name'] = $row->last_name;
            $data['phone'] = $row->phone;
            $data['office_phone'] = $row->office_phone;
            $data['email'] = $row->email;
            $data['password'] = $row->password;
			$data['role_id'] = $row->role_id;
			$data['user_image'] = $row->user_image;
			$data['gender'] = $row->gender;
            $data['group'] = $row->group;
        }
        return $data;
    }
    function change_password() {
        $update_id = $this->input->post('id');
        $data['users'] = $this->_get_data_from_db($update_id);
        $data['update_id'] = $update_id;
        $this->load->view('password_form', $data);
    }
function validate (){
    $user_name = $this->input->post('user_name');
        if (defined('DEFAULT_CHILD_OUTLET'))   $nOutlet_id = DEFAULT_CHILD_OUTLET;
        else  $nOutlet_id = DEFAULT_OUTLET;    
    $id = $nOutlet_id;
  //  echo $user_name.$id; exit();
  $query = $this->_get_where_validate($id,$user_name);
 //print 'rows here '.$query->num_rows();exit;
 //echo  $query->num_rows();
 if ($query->num_rows() > 0) echo '1';
 else echo '0';

}
function _get_data_from_post() {
		$data['user_name'] = $this->input->post('user_name');
		$data['phone'] = $this->input->post('phone');
        $data['office_phone'] = $this->input->post('office_phone');
		$data['email'] = $this->input->post('email');
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['gender'] = $this->input->post('gender');
        $data['group'] = $this->input->post('group');
		$password = $this->input->post('password');
		if(isset($password) && !empty($password))
			$data['password'] =  $this->hashpassword($this->input->post('password'));
        $role = 0;
        if(isset($data['group']) && !empty($data['group'])) {
            $groups_role = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$data['group']), 'id desc',DEFAULT_OUTLET.'_groups','role','1','0')->result_array();
            if(isset($groups_role[0]['role']) && !empty($groups_role[0]['role']))
                $role = $groups_role[0]['role'];
        }
        $data['role_id'] =$role; 
        if (defined('DEFAULT_CHILD_OUTLET'))   $nOutlet_id = DEFAULT_CHILD_OUTLET;
        else  $nOutlet_id = DEFAULT_OUTLET;        
		$data['outlet_id'] = $nOutlet_id;
        $data['status'] = 1;
     
        return $data;
    }

    function delete(){
        $id = $this->input->post('id');
        $user_image = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$id), "id desc","users","user_image","1","1")->result_array();
        if(!empty($user_image)) {
            Modules::run("api/delete_images_by_name",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$user_image[0]['user_image']);
        }
        $this->load->model('mdl_users');
        $this->mdl_users->_delete($id);
    }

    function change_pass() {  
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post_password();
            
            if ($update_id && $update_id != 0) {
                    $where['id'] = $update_id;
                   
                    $this->_update($where, $data);
                        
                        $this->session->set_flashdata('message', 'Password'.' '.'updated successfully');                                     
                        $this->session->set_flashdata('status', 'success');
                    
                }
        
            redirect(ADMIN_BASE_URL . 'users');
    }

	function change_password_action(){
        $where['user_name'] = $this->input->post('user_name');
        $data['password'] = md5($this->input->post('password'));
		$this->_update($where, $data);
	}

    function hashpassword($password) {
        return md5($password);
    }

	function _get_data_from_post_password() {
        $data['user_name'] = $this->input->post('user_name');
        $data['password'] =  $this->hashpassword($this->input->post('password'));
        return $data;
    }
	
function change_status_event() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    echo $status; 
    if ($status == 1)
      {  echo "one";
        $status = 0; }
    else
         {  echo "two";
        $status = 1; }
    $data = array('status' => $status);
    $status = $this->_update_status_event($id, $data);
    echo $status;
    exit;
}



 /////////////// for detail ////////////
function detail() {
    $update_id = $this->input->post('id');
    $data['users_res'] = $this->_get_data_from_db($update_id);
    $data['update_id'] = $update_id;
    $this->load->view('detail', $data);
}

////////////////////////////////////////////////
function _get($order_by='id desc'){
$this->load->model('mdl_users');
$query = $this->mdl_users->_get($order_by);
return $query;
}

function _get_with_limit($limit, $offset, $order_by='id asc') {
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_with_limit($limit, $offset, $order_by);
return $query;
}

function _getItemById($id) {
$this->load->model('mdl_users');
return $this->mdl_users->_getItemById($id);
}

function _get_by_arr_id($arr_col) {
$this->load->model('mdl_users');
return $this->mdl_users->_get_by_arr_id($arr_col);
}

function _get_zabiha($table , $distance, $longitude, $latitude) {
$this->load->model('mdl_users');
return $this->mdl_users->_get_zabiha($table , $distance, $longitude, $latitude);
}

function _get_where($id){
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_where($id);
return $query;
}

function _get_where_login($username , $password){
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_where_login($username,$password);
return $query;
}

function _get_where_user($id){
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_where_user($id);
return $query;
}
function _get_where_validate($id,$user_name){
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_where_validate($id,$user_name);
return $query;
}

function _get_where_cols($cols,$order_by){
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_where_cols($cols,$order_by);
return $query;
}

function _get_where_custom($col, $value,$order_by='id asc') {
   // print '<br>this =====controler ====>>';exit;
$this->load->model('mdl_users');
$query = $this->mdl_users->_get_where_custom($col, $value,$order_by);
return $query;
}
function _update_status_event($id, $data) {
    $this->load->model('mdl_users');
    $this->mdl_users->_update_id($id, $data);
}
function _insert($data){
$this->load->model('mdl_users');
return $this->mdl_users->_insert($data);
}

function _update_status_news($id, $data) {
    $this->load->model('mdl_users');
    $this->mdl_users->_update_id($id, $data);
}

function _update($arr_col, $data) {
$this->load->model('mdl_users');
$this->mdl_users->_update($arr_col, $data);
}

function _update_where_cols($cols, $data){
$this->load->model('mdl_users');
return $this->mdl_users->_update_where_cols($cols, $data);
}



function _count_where($column, $value) {
$this->load->model('mdl_users');
$count = $this->mdl_users->_count_where($column, $value);
return $count;
}

function _get_max() {
$this->load->model('mdl_users');
$max_id = $this->mdl_users->_get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_users');
$query = $this->mdl_users->_custom_query($mysql_query);
return $query;
}

function _get_tokens($outlet = DEFAULT_OUTLET)
{
    $arr_where = array('outlet_id' => $outlet);
    $arr_users = $this->_get_where_cols($arr_where)->result_array();
    $arr_token = array();
    if (count( $arr_users) > 0)
    {
        foreach ($arr_users as $key => $arr_value) {
            if(isset($arr_value['token']) && !empty($arr_value['token']))
                $arr_token[] = $arr_value['token'];
        }
        
    }
     /*print '<br>resul here ===>>><pre>';
       print_r($arr_token);
    exit;*/
    return $arr_token;
}

function _get_app_key($create_from, $id){
    $sql = 'Select app_key from app_details where create_from = "'.$create_from.'" and id = '.$id;
    $query = $this->_custom_query($sql)->row();
    return $query->app_key;

}


}