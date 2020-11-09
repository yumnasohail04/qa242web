<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Carrier extends MX_Controller
{

function __construct() {
parent::__construct();
 $this->load->library('csvimport');
//Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');
date_default_timezone_set("Asia/karachi");
$timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
    date_default_timezone_set($timezone[0]['timezones']);
}

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    
    function create() {
        $update_id = $this->uri->segment(4);
        $data['update_id'] = $update_id;
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $res= Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("id"=>$update_id), "id asc","carrier","type","","","","","")->row();
            $data['doc']=$this->get_doc_by_carrier_type(array("status"=>"1"),"question asc","document_file","document_file.*","","",$res->type,"","")->result_array();
            if(!empty($data['doc'])){
                foreach($data['doc'] as $key => $value):
                    $doc_uploaded=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id'],"carrier_id"=>$update_id), "id asc","document_uploaded","document","","","","","")->row();
                    $data['doc'][$key]['doc_uploaded']=$doc_uploaded;
                    if($value['question']=="1"){
                        $result=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id']), "id asc","document_question","*","","","","","")->row();
                        $ans=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("question_id"=>$result->id,"carrier_id"=>$update_id), "id asc","document_answer","option,comment_box,reference_link","","","","","")->row();
                        $data['doc'][$key]['sub_question']=$result;
                        $data['doc'][$key]['sub_ans']=$ans;
                    } 
                endforeach;
            }
        } else {
            $data['news'] = $this->_get_data_from_post();
            $data['doc'] = Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("carrier_type"=>"1","status"=>"1"), "question asc","document_file","*","","","","","")->result_array();
            if(!empty($data['doc'])){
                foreach($data['doc'] as $key => $value):
                    $data['doc'][$key]['doc_uploaded']=array();
                    if($value['question']=="1"){
                        $result=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id']), "id asc","document_question","*","","","","","")->row();
                        $data['doc'][$key]['sub_question']=$result;
                        $data['doc'][$key]['sub_ans']=array();
                    } 
                endforeach;
            }



        }
        $data['carrier_type'] = Modules::run('ingredients/_get_data_from_db_table',array(),"carrier_types","","","*","")->result_array();
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
     function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['name'] = $row->name;
            $data['email'] = $row->email;
            $data['contact'] = $row->contact;
            $data['phone'] = $row->phone;
            $data['state'] = $row->state;
            $data['city'] = $row->city;
            $data['zipcode'] = $row->zipcode;
            $data['address'] = $row->address;
            $data['type'] = $row->type;
            $data['status'] = $row->status;
        }
        return $data;
    }
    
    function get_carrier_documents()
    {
        $carrier_id = $this->input->post('update_id');
        $carrier_type = $this->input->post('carrier_type');
        $data['doc']=$this->get_doc_by_carrier_type(array("status"=>"1"),"question asc","document_file","document_file.*","","",$carrier_type,"","")->result_array();
        if(!empty($data['doc'])){
            foreach($data['doc'] as $key => $value):
                $doc_uploaded=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id'],"carrier_id"=>$carrier_id), "id asc","document_uploaded","document","","","","","")->row();
                $data['doc'][$key]['doc_uploaded']=$doc_uploaded;
                if($value['question']=="1"){
                    $result=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id']), "id asc","document_question","*","","","","","")->row();
                    $ans=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("question_id"=>$result->id,"carrier_id"=>$carrier_id), "id asc","document_answer","option,comment_box,reference_link","","","","","")->row();
                    $data['doc'][$key]['sub_question']=$result;
                    $data['doc'][$key]['sub_ans']=$ans;
                } 
            endforeach;
        }
        $this->load->view('document_view',$data);
    }
        
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['name']=preg_replace('/[^a-zA-Z0-9\s]/', '', $data['name']);
        $data['email'] = $this->input->post('email');
        $data['contact'] = $this->input->post('contact');
        $data['phone'] = $this->input->post('phone');
        $data['state'] = $this->input->post('state');
        $data['zipcode'] = $this->input->post('zipcode');
        $data['city'] = $this->input->post('city');
        $data['address'] = $this->input->post('address');
        $data['type'] = $this->input->post('type');
        return $data;
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $this->session->set_flashdata('message', 'Data Updated');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $update_id = $this->_insert($data);
            $this->send_email($update_id);
            $this->session->set_flashdata('message', 'Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }


        $carrier_id=$update_id;
        $carrier_type=$this->input->post('type');
        $doc=$this->get_doc_by_carrier_type(array("status"=>"1"),"question asc","document_file","document_file.*","","",$carrier_type,"","")->result_array();
        if(!empty($doc)){
            foreach($doc as $key => $value):
                if($value['question']=="1"){
                    $result=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id']), "id asc","document_question","*","","","","","")->row();
                    if(!empty($result))
                    {
                            $ans['option']=$this->input->post('answer_'.$key);
                            if(!empty($this->input->post('reference_link_'.$key)))
                            $ans['reference_link']=$this->input->post('reference_link_'.$key);
                            if(!empty($this->input->post('comment_'.$key)) )
                            $ans['comment_box']=$this->input->post('comment_'.$key);
                            $ans['doc_id']=$this->input->post('id_'.$key);
                            $ans['question_id']=$result->id;
                            $ans['carrier_id']=$carrier_id;
                            if(!empty($ans['doc_id']) && !empty($ans['question_id']) && !empty($ans['carrier_id']) )
                                Modules::run('api/insert_or_update',array("doc_id"=>$ans['doc_id'],"question_id"=>$ans['question_id'],"carrier_id"=>$ans['carrier_id']),$ans,'document_answer');
                    }
                }
                if(isset($_FILES["news_main_page_file_$key"]['size']) &&  $_FILES["news_main_page_file_$key"]['size'] >0){
                    $doc_data['doc_id']=$this->input->post('id_'.$key);
                    $doc_data['carrier_type']=$carrier_type;
                    $doc_data['carrier_id']=$carrier_id;
                    $update_id=Modules::run('api/insert_or_update',array("doc_id"=>$doc_data['doc_id'],"carrier_id"=>$doc_data['carrier_id']),$doc_data,'document_uploaded');
                    if($update_id=="0")
                    {
                        $itemInfo= Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',$doc_data, "id desc","document_uploaded","id","","","","","")->row();
                        $update_id=$itemInfo->id;
                    }
                        if($_FILES["news_main_page_file_$key"]['size'] > 0) {
                            $itemInfo= Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',$doc_data, "id desc","document_uploaded","*","","","","","")->row();
                            if(isset($itemInfo->document) && !empty($itemInfo->document)) 
                            Modules::run('carrier_front/delete_images_by_name',CARRIER_DOCUMENTS_PATH,$itemInfo->document);
                            Modules::run('carrier_front/upload_dynamic_image',CARRIER_DOCUMENTS_PATH,$update_id,"news_main_page_file_$key",'document','id','document_uploaded');
                        }
                }
            endforeach;
        }




        redirect(ADMIN_BASE_URL . 'carrier');
    }
    function send_email($id)
    {
        $this->load->library('email');
        $port = 465;
        $user = "info@qa.hwryk.com";
        $pass = "OV%YsZY[hfDI";
        $host = 'ssl://qa.hwryk.com';  
        $mailtitle="EQ Smart";
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => $host,
          'smtp_port' => $port,
          'smtp_user' =>  $user,
          'smtp_pass' =>  $pass,
          'mailtype'  => 'html', 
          'starttls'  => true,
          'newline'   => "\r\n"
        ); 
        $where['id']=$id;
        $query = $this->_get_by_arr_id($where)->row_array();
        $data['username']=$query['name'].$id;
        $password=$this->generateRandomString("8");
        $data['password'] = md5($password);
        $data['carrier_id']=$id;
        $this->insert_or_update_user_review($data,"carrier_account");
        $this->email->initialize($config);
        $this->email->from($user, $mailtitle);
        $this->email->to($query['email']);
        $this->email->subject($mailtitle . ' - Profile Completion');
        $this->email->message('<p>Dear ' . $query['name'].',<br><br>You have been Registered at EQ smart  by Valley Fine Foods. Please Open this Link "'.BASE_URL.'carrier/login/'.$query['id'].'" and Submit the Required Documents.Your Credentials for login to the website are Username: "'.$data['username'].'" and Password: "'.$password.'"</p> <br>With Best Regards,<br>' . $mailtitle . 'Team');
        $this->email->send();
    }
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    


    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
    }
   
    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }
    function detail() {
        $update_id = $this->input->post('id');
        $data['post'] = $this->_get_data_from_db($update_id);
    	$data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_carrier');
        return $this->mdl_carrier->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_carrier');
        $query = $this->mdl_carrier->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_carrier');
        return $this->mdl_carrier->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_carrier');
        return $this->mdl_carrier->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_carrier');
        $this->mdl_carrier->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_carrier');
        $this->mdl_carrier->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_carrier');
        $this->mdl_carrier->_delete($arr_col);
    }
     function insert_or_update_user_review($data,$table){
        $this->load->model('mdl_carrier');
        return $this->mdl_carrier->insert_or_update_user_review($data,$table);
    }
    function _get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit)
    {
        $this->load->model('mdl_carrier');
        return  $this->mdl_carrier->_get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit);
    }
    function delete_from_table($where,$table)
    {
        $this->load->model('mdl_carrier');
        $this->mdl_carrier->delete_from_table($where,$table);
    }
	function ingredient_list_supplier($id)
    {
    	$this->load->model('mdl_carrier');
       return $this->mdl_carrier->ingredient_list_supplier($id);
    }
    function check_if_exists($where)
    {
        $this->load->model('mdl_carrier');
        return $this->mdl_carrier->check_if_exists($where);
    }
    function get_doc_by_carrier_type($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where='',$having=''){
        $this->load->model('mdl_carrier');
        return $this->mdl_carrier->get_doc_by_carrier_type($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where='',$having='');
    }
}
