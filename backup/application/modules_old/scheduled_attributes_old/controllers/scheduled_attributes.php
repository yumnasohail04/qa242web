<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
//include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Scheduled_attributes extends MX_Controller {

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
}

function index() {
$this->manage();
}





////////////////// 	HELPER FUNCTION /////////////////////////




////////////////////////
function _insert_attributes_data($data){
        $this->load->model('mdl_scheduled_attributes');
       return $this->mdl_scheduled_attributes->_insert_attributes_data($data);
    }
    function get_discounts_arr_from_db($update_id){
         $this->load->model('mdl_scheduled_attributes');
       return $this->mdl_scheduled_attributes->get_discounts_arr_from_db($update_id);
    }
    function delete_org_outlet_db($arr_col){
        $this->load->model('mdl_scheduled_attributes');
        $this->mdl_scheduled_attributes->delete_org_outlet_db($arr_col);
    }



    ///////////////////////////
    
function manage() {
$checkid=$this->uri->segment(4);
$data['ccheckid']=$checkid;
$where=array('wip_type'=>'herb_spice','checkid'=>$checkid);
$data['query'] = $this->_get_sub_catagories_attibutes($where,'wip_id asc');


$data['view_file'] = 'manage_sub_catagories_attributes';
$this->load->module('template');
$this->template->admin($data);
}
function create(){

$is_edit = 0;
$ccheckid=$this->uri->segment(4);
$data['ccheckid']=$ccheckid;
$update_id = $this->uri->segment(5);
///////////////////////For Language///////////////////////////
if ($update_id > 0) {
    
$data['catagories'] = $this->_get_data_from_db_attributes($update_id,$ccheckid);


} else {
$data['catagories'] = $this->_get_data_from_post_attributes($ccheckid);
}
$data['update_id'] = $update_id;


$data['view_file'] = 'create_sub_catagories_attributes';

$this->load->module('template');
$this->template->admin_form($data);
}
function submit_sub_catagories_attributes() {
$update_id = 0;
$ccheckid=$this->uri->segment(4);
$update_id = $this->uri->segment(5);

$data = $this->_get_data_from_post_attributes($ccheckid);
if ($update_id && $update_id != 0) {
$where['wip_id'] = $update_id;
$where['checkid']=$ccheckid;
$this->_update_catagories_attributes($where, $data);
              
$this->session->set_flashdata('message', 'attribute'.' '.DATA_UPDATED);                                      
$this->session->set_flashdata('status', 'success');

}
if (!is_numeric($update_id) || $update_id == 0 || empty($update_id)) {
$id = $this->_insert_attributes_data($data);
$this->session->set_flashdata('message', 'attribute'.' '.DATA_SAVED);
$this->session->set_flashdata('status', 'success');

}
redirect(ADMIN_BASE_URL . 'scheduled_attributes/manage/'.$ccheckid.'/');

}

function _get_sub_catagories_attibutes($where,$order_by){
      $this->load->model('mdl_scheduled_attributes');
       return $this->mdl_scheduled_attributes->_get_sub_catagories_attibutes($where,$order_by);
}
function _get_data_from_post_attributes($checkid){
    $data['attribute_name']=$this->input->post('attribute_name');
    $data['attribute_type']=$this->input->post('attribute_type');
    $data['possible_answers']=$this->input->post('possible_answer');

    $data['min']=$this->input->post('min_value');
    $data['wip_type']='herb_spice';
    $data['max']=$this->input->post('max_value');
    $data['target']=$this->input->post('target_value');
    $data['checkid']=$checkid;
   
   
    return $data;
}
function _get_data_from_db_attributes($attribute_id,$checkid){
    $where['wip_id']=$attribute_id;
    $where['checkid']=$checkid;
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
    $this->load->model('mdl_scheduled_attributes');
       return $this->mdl_scheduled_attributes->_update_catagories_attributes($where,$data);

}
function delete_sub_catagories_attributes(){
    $delete_id = $this->input->post('id');
    $where['wip_id']=$delete_id;
    $this->_delete_attributes($where);
}
function _delete_attributes($where){
    $this->load->model('mdl_scheduled_attributes');
       return $this->mdl_scheduled_attributes->_delete_attributes($where);

}
}
