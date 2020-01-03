<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
//include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Bowl_fill extends MX_Controller {

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
}

function index() {
$this->manage_attributes();
}





////////////////// 	HELPER FUNCTION /////////////////////////




////////////////////////
function _insert_attributes_data($data){
        $this->load->model('mdl_bowl_fill');
       return $this->mdl_bowl_fill->_insert_attributes_data($data);
    }
    function get_discounts_arr_from_db($update_id){
         $this->load->model('mdl_bowl_fill');
       return $this->mdl_bowl_fill->get_discounts_arr_from_db($update_id);
    }
    function delete_org_outlet_db($arr_col){
        $this->load->model('mdl_bowl_fill');
        $this->mdl_bowl_fill->delete_org_outlet_db($arr_col);
    }



    ///////////////////////////
    
function manage_attributes() {

$where=array('wip_type'=>'bowl_filling');
$data['query'] = $this->_get_sub_catagories_attibutes($where,'wip_id asc');


$data['view_file'] = 'manage_sub_catagories_attributes';
$this->load->module('template');
$this->template->admin($data);
}
function create(){

$is_edit = 0;
$update_id = $this->uri->segment(4);
///////////////////////For Language///////////////////////////
if ($update_id > 0) {
    
$data['catagories'] = $this->_get_data_from_db_attributes($update_id);


} else {
$data['catagories'] = $this->_get_data_from_post_attributes();
}
$data['update_id'] = $update_id;


$data['view_file'] = 'create_sub_catagories_attributes';

$this->load->module('template');
$this->template->admin_form($data);
}
function submit_sub_catagories_attributes() {
$update_id = 0;

$update_id = $this->uri->segment(4);

$data = $this->_get_data_from_post_attributes($update_id);
if ($update_id && $update_id != 0) {
$where['wip_id'] = $update_id;
$this->_update_catagories_attributes($where, $data);
              
$this->session->set_flashdata('message', 'attribute'.' '.DATA_UPDATED);                                      
$this->session->set_flashdata('status', 'success');

}
if (!is_numeric($update_id) || $update_id == 0 || empty($update_id)) {
$id = $this->_insert_attributes_data($data);
$this->session->set_flashdata('message', 'attribute'.' '.DATA_SAVED);
$this->session->set_flashdata('status', 'success');

}
redirect(ADMIN_BASE_URL . 'bowl_fill/manage_attributes/');

}

function _get_sub_catagories_attibutes($where,$order_by){
      $this->load->model('mdl_bowl_fill');
       return $this->mdl_bowl_fill->_get_sub_catagories_attibutes($where,$order_by);
}
function _get_data_from_post_attributes(){
    $data['attribute_name']=$this->input->post('attribute_name');
    $data['attribute_type']=$this->input->post('attribute_type');
    $data['possible_answers']=$this->input->post('possible_answer');
    
    $data['min']=$this->input->post('min_value');
    $data['wip_type']='bowl_filling';
    $data['max']=$this->input->post('max_value');
    $data['target']=$this->input->post('target_value');
   
   
    return $data;
}
function _get_data_from_db_attributes($attribute_id){
    $where['wip_id']=$attribute_id;
    $result=$this->_get_sub_catagories_attibutes($where,'wip_id asc');
    foreach ($result->result() as $key => $value) {
       $data['attribute_name']= $value->attribute_name;
       $data['attribute_type']= $value->attribute_type;
       $data['possible_answers']=$value->possible_answers;
       $data['min']=$value->min;
       $data['max']=$value->max;
       $data['target']=$value->target;
       $data['status']=$value->status;
    }

    return $data;
}
function _update_catagories_attributes($where,$data){
    $this->load->model('mdl_bowl_fill');
       return $this->mdl_bowl_fill->_update_catagories_attributes($where,$data);

}
function delete_sub_catagories_attributes(){
    $delete_id = $this->input->post('id');
    $where['wip_id']=$delete_id;
    $this->_delete_attributes($where);
}
function _delete_attributes($where){
    $this->load->model('mdl_bowl_fill');
       return $this->mdl_bowl_fill->_delete_attributes($where);

}
}
