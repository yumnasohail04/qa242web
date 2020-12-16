<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier extends MX_Controller
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
        $sup_type = $this->_get_data_from_db_table(array("id"=>$update_id),"supplier","","","id,supplier_type","")->row_array();
        $data['doc']=$this->get_doc_by_supplier_type(array("assign_to"=>"supplier","status"=>"1"),"level asc","document","document.id,document.doc_name,document.level,doc_supplier_types.supplier_type","","",$sup_type['supplier_type'],"","")->result_array();
        
    	if(!empty($data['doc'])){
            foreach($data['doc'] as $key => $value)
            {
                $data['doc'][$key]['document']="";
                $uploaded = Modules::run('ingredients/_get_data_from_db_table',array("s_doc_id"=>$value['id'],"supplier_id"=>$update_id),"supplier_documents","","","id,doc_name,document,expiry_date","")->row_array();
                if(isset($uploaded['document']))
                $data['doc'][$key]['document']= $uploaded['document'];
                $data['doc'][$key]['expiry_date']= "";
                if(isset($uploaded['expiry_date']))
                $data['doc'][$key]['expiry_date']= date("m/d/Y", strtotime($uploaded['expiry_date']));

            } 
        }
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $data['uploaded_doc']=$this->_get_data_from_db_table(array("supplier_id"=>$update_id),"supplier_documents","","","id,doc_name,document,expiry_date","")->result_array();
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $data['supplier_types'] = Modules::run('ingredients/_get_data_from_db_table',array("status"=>"1"),'supplier_type',"","","id,name","")->result_array();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
 
    function get_supplier_documents()
    {
        $supplier_type=$this->input->post('supplier_type');
        $update_id=$this->input->post('update_id');
        $data['doc']=$this->get_doc_by_supplier_type(array("assign_to"=>"supplier","status"=>"1"),"level asc","document","document.id,document.doc_name,document.level,doc_supplier_types.supplier_type","","",$supplier_type,"","")->result_array();
    	if(!empty($data['doc'])){
            foreach($data['doc'] as $key => $value)
            {
                $data['doc'][$key]['document']="";
                $uploaded = Modules::run('ingredients/_get_data_from_db_table',array("s_doc_id"=>$value['id'],"supplier_id"=>$update_id),"supplier_documents","","","id,doc_name,document,expiry_date","")->row_array();
                if(isset($uploaded['document']))
                $data['doc'][$key]['document']= $uploaded['document'];
                $data['doc'][$key]['expiry_date']= "";
                if(isset($uploaded['expiry_date']))
                $data['doc'][$key]['expiry_date']= date("m/d/Y", strtotime($uploaded['expiry_date']));
            } 
        }
        $this->load->view('documents_view',$data);
    }
     function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['name'] = $row->name;
            $data['email'] = $row->email;
            $data['phone_no'] = $row->phone_no;
            $data['city'] = $row->city;
            $data['state'] = $row->state;
            $data['country'] = $row->country;
            $data['status'] = $row->status;
            $data['supplier_no'] = $row->supplier_no;
            $data['address'] = $row->address;
            $data['supplier_type'] = $row->supplier_type;
        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['name']=preg_replace('/[^a-zA-Z0-9\s]/', '', $data['name']);
        $data['email'] = $this->input->post('email');
        $data['phone_no'] = $this->input->post('phone_no');
        $data['city'] = $this->input->post('city');
        $data['state'] = $this->input->post('state');
        $data['country'] = $this->input->post('country');
        $data['supplier_no'] = $this->input->post('supplier_no');
        $data['address'] = $this->input->post('address');
        return $data;
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
    	$supplier_type=$this->input->post('supplier_type');
    	$doc=$this->get_doc_by_supplier_type(array("assign_to"=>"supplier","status"=>"1"),"level asc","document","document.id,document.doc_name,document.level,doc_supplier_types.supplier_type","","",$supplier_type,"","")->result_array();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
                if(!empty($doc)){
                    foreach($doc as $key => $value){
                     $exp_date=$this->input->post("expiry_date_$key");
                    if(isset($_FILES["news_main_page_file_$key"]['size']) )
                        if($_FILES["news_main_page_file_$key"]['size'] > 0) {
                            $itemInfo = $this->_get_by_arr_id($where)->row();
                            if(isset($itemInfo->document) && !empty($itemInfo->document)) 
                                $this->delete_images_by_name(SUPPLIER_DOCUMENTS_PATH,$itemInfo->document);
                                $this->delete_from_table(array("s_doc_id"=>$value['id'],"supplier_id"=>$update_id),"supplier_documents");
                            $this->upload_dynamic_image(SUPPLIER_DOCUMENTS_PATH,$update_id,"news_main_page_file_$key",'document','id','supplier_documents',$value['id'],$value['doc_name'],$exp_date);
                        }
                        if(!empty($exp_date)){
                            $exp_date=date("Y-m-d", strtotime($exp_date));
                            Modules::run('api/insert_or_update',array("supplier_id"=>$update_id,"s_doc_id"=>$value['id']),array("expiry_date"=>$exp_date),'supplier_documents');
                    }
                }
            }
            
            $this->session->set_flashdata('message', 'Supplier Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            if(!empty($doc)){
                foreach($doc as $key => $value){
                    $exp_date=$this->input->post("expiry_date_$key");
                    if(isset($_FILES["news_main_page_file_$key"]['size']) )
                        if($_FILES["news_main_page_file_$key"]['size'] > 0)
                        $this->upload_dynamic_image(SUPPLIER_DOCUMENTS_PATH,$id,"news_main_page_file_$key",'document','id','supplier_documents',$value['id'],$value['doc_name'],$exp_date);
                }
            }
            $this->send_email($id);
            $this->session->set_flashdata('message', 'Supplier'.'Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'supplier');
    }
    function send_supplier_email()
    {
        $id=$this->input->post('id');
        $type=$this->input->post('type');
        $where['id']=$id;
        $query = $this->_get_by_arr_id($where)->row_array();
        if(isset($query['email']) && !empty($query['email'])){
            if($type=="reminder")
                $message='<p>Dear ' . $query['name'].',<br><br>This is a reminder email. Please Open this Link "'.BASE_URL.'login/'.$query['id'].'" and Submit the Required Documents.</p> <br>With Best Regards,<br>  EQ Smart Team';
            else if($type=="credentials"){
                $password=$this->generateRandomString("8");
                $data['username']=$query['name'].$id;
                $data['password'] = md5($password);
                $data['supplier_id']=$id;
               // $this->insert_or_update_user_review($data,"supplier_account");
                Modules::run('api/insert_or_update',array("supplier_id"=>$id),$data,"supplier_account");
                $message='<p>Dear ' . $query['name'].',<br><br> Please Open this Link "'.BASE_URL.'login/'.$query['id'].'" and Submit the Required Documents.Your New Credentials for login to the website are Username: "'.$data['username'].'" and Password: "'.$password.'"</p> <br>With Best Regards,<br> EQ Smart Team';
            }else
            {}
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
            $this->email->initialize($config);
            $this->email->from($user, $mailtitle);
            $this->email->to($query['email']);
            $this->email->subject($mailtitle . ' - Supplier Profile Completion');
            $this->email->message($message);
            $this->email->send();
            $status=TRUE;
            $message="Email sent successfully";
        }
        else{
            $status=FALSE;
            $message="Please Provide Supplier Email first";
        }
        echo '<article><status>'.$status.'</status><message>'.$message.'</message><article>';
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
        $data['supplier_id']=$id;
        $this->insert_or_update_user_review($data,"supplier_account");
        $this->email->initialize($config);
        $this->email->from($user, $mailtitle);
        $this->email->to($query['email']);
        $this->email->subject($mailtitle . ' - Supplier Profile Completion');
        $this->email->message('<p>Dear ' . $query['name'].',<br><br>You have been Registered at EQ smart as a Supplier. Please Open this Link "'.BASE_URL.'login/'.$query['id'].'" and Submit the Required Documents.Your Credentials for login to the website are Username: "'.$data['username'].'" and Password: "'.$password.'"</p> <br>With Best Regards,<br>' . $mailtitle . 'Team');
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
    function upload_dynamic_image($actual,$nId,$input_name,$image_field,$image_id_fild,$table,$s_doc_id,$doc_name,$exp_date) {
        
        $upload_image_file = $_FILES[$input_name]['name'];
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = $nId . '_' . $upload_image_file;
        $config['upload_path'] = $actual;
        $config['allowed_types'] = 'pdf|xlsx|docx|PDF|XLSX|DOCX|txt|TXT';
        $config['max_size'] = '20000';
        $config['max_width'] = '2000000000';
        $config['max_height'] = '2000000000';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES[$input_name])) {
            $this->upload->do_upload($input_name);
        }
        if(!empty($exp_date))
        $exp_date=date("Y-m-d", strtotime($exp_date));
        $upload_data = $this->upload->data();
        $data = array($image_field => $file_name,"supplier_id"=>$nId,"s_doc_id"=>$s_doc_id,"doc_name"=>$doc_name,"expiry_date"=>$exp_date);
        $this->insert_or_update_user_review($data,$table);
    }
       function delete_images_by_name($actual_path,$name) {
        if (file_exists($actual_path.$name))
            unlink($actual_path.$name);
    }
    function submit_csv(){
      $this->load->library('PHPExcel');
      $ext = pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION);
        if($ext=="xls" || $ext=="xlsx"){
          $path = $_FILES['csvfile']['tmp_name'];
          $object = PHPExcel_IOFactory::load($path);
          foreach($object->getWorksheetIterator() as $worksheet):
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++) {
              $storing_check = true;
              $supplier_no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
              $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
              $pml_state = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
              $city = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
              $state = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
              $country = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
              $phone = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
              $name=preg_replace('/[^a-zA-Z0-9\s]/', '', $name);
              $arr_data['supplier_no']=$supplier_no;
              $arr_data['name']=$name;
              $arr_data['city']=$city;
              $arr_data['state']=$state;
              $arr_data['country']=$country;
              $arr_data['phone_no']=$phone;
              $arr_data['status']=1;
              $arr_where['supplier_no']=$supplier_no;
              $check_arr=$this->check_if_exists($arr_where)->result_array();
              if(isset($check_arr) && empty($check_arr)){
                $supplier_id=$this->_insert($arr_data);
            }
                $this->session->set_flashdata('message', 'Supplier File Uploaded ');                                        
                $this->session->set_flashdata('status', 'success');
            }
          endforeach;
        }
        else{
            $this->session->set_flashdata('message', "Invalid file format");                                        
            $this->session->set_flashdata('status', 'success');
            }
        redirect(ADMIN_BASE_URL . 'supplier');
    }
     function csvToArray($file, $delimiter) { 
        if (($handle = fopen($file, 'r')) !== FALSE) { 
            $i = 0; 
            while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
              for ($j = 0; $j < count($lineArray); $j++) { 
                $arr[$i][$j] = $lineArray[$j]; 
              } 
              $i++; 
            } 
            fclose($handle); 
          } 
          return $arr; 
        }

    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
    }
    function import_file(){
        
        $data['view_file'] = 'fileupload';
        $this->load->module('template');
        $this->template->admin($data);
    }
     function delete_doc()
    {
        $delete_id = $this->input->post('doc_id');  
        $doc = $this->_get_data_from_db_table(array("id"=>$delete_id),"supplier_documents","","","document","")->result_array();
        if (file_exists(SUPPLIER_DOCUMENTS_PATH.$doc[0]['document']))
            unlink(SUPPLIER_DOCUMENTS_PATH.$doc[0]['document']);
        $this->delete_from_table(array("id"=>$delete_id),"supplier_documents");
        
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
        $supplier_id=$update_id = $this->input->post('id');
        $data['post'] = $this->_get_data_from_db($update_id); 
        $data['doc'] = Modules::run('supplier/get_doc_by_supplier_type',array("assign_to"=>"supplier","status"=>"1"),"level asc","document","document.id,document.doc_name,document.level,doc_supplier_types.supplier_type","","",$data['post']['supplier_type'],"","")->result_array();
        if(!empty($data['doc'])){
            foreach($data['doc'] as $key => $value)
            {
                $data['doc'][$key]['document']="";
                $uploaded = Modules::run('ingredients/_get_data_from_db_table',array("s_doc_id"=>$value['id'],"supplier_id"=>$supplier_id,"submit"=>"1"),"supplier_documents","","","id,doc_name,document,expiry_date","")->row_array();
                if(isset($uploaded['document']))
                $data['doc'][$key]['document']= $uploaded['document'];
                $data['doc'][$key]['expiry_date']= "";
                if(isset($uploaded['expiry_date']))
                $data['doc'][$key]['expiry_date']= date("m/d/Y", strtotime($uploaded['expiry_date']));
                $data['doc'][$key]['supplier_type_name']="";
                if($value['supplier_type']!="0"){
                $type = Modules::run('ingredients/_get_data_from_db_table',array("id"=>$value['supplier_type']),"supplier_type","","","id,name","")->row_array();
                $data['doc'][$key]['supplier_type_name']=$type['name'];
                }
            } 
        } 
        // $data['doc'] = $this->_get_data_from_db_table(array("supplier_id"=>$update_id),"supplier_documents","","","doc_name,document,expiry_date","")->result_array();
        $data['ingredients'] = $this->ingredient_list_supplier($update_id)->result_array();
        $ing_doc=$temp=array();
			$ingredients = Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id),DEFAULT_OUTLET.'_ingredients_supplier',"","","ingredient_id,s_item_name","")->result_array();
			foreach($ingredients as $ingrdnt => $ing)
			{
				$type_selected=Modules::run('front/supplier_ingredients',$supplier_id,$ing['ingredient_id'])->result_array();
				foreach($type_selected as $key => $value)
				{
					$result =Modules::run('front/get_doc_by_ingredient_type',array("assign_to"=>"ingredient","status"=>"1"),"document.id asc","document","document.id,document.doc_name,document.doc_type","","",$value['type_id'],"","")->result_array();
					foreach($result as $keys => $values)
					{
						if($values['doc_type']=="location specific"){
							$ing_doc=array();
							$ingredient_locations = Modules::run('ingredients/_get_data_from_db_table',array("ingredient_id"=>$ing['ingredient_id'],"supplier_id"=>$supplier_id),'ingredient_location',"","","id as loc_id,location","")->result_array();
							if(!empty($ingredient_locations))
							foreach($ingredient_locations as $l => $va){
								$query=Modules::run('ingredients/_get_data_from_db_table',array("location_id"=>$va['loc_id'],"supplier_id"=>$supplier_id,"ingredient_id"=>$ing['ingredient_id'],"document_id"=>$values['id'],"submit"=>"1"),DEFAULT_OUTLET.'_ingredients_document',"","","document","")->row_array();
								$ing_doc['document']=null;
								if(!empty($query) && isset($query['document']))
								$ing_doc['document']=$query['document'];
								$ing_doc['doc_id']=$values['id'];
								$ing_doc['doc_name']=$values['doc_name'];
								$ing_doc['doc_type']=$values['doc_type'];
								$ing_doc['ing_id']=$ing['ingredient_id'];
								$ing_doc['ing_name']=$ing['s_item_name'];
								$ing_doc['location']=$va['location'];
								$ing_doc['loc_id']=$va['loc_id'];
								$temp[]=$ing_doc;
							}
						}
						else{
							$ing_doc=array();
							$query=Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id,"ingredient_id"=>$ing['ingredient_id'],"document_id"=>$values['id'],"submit"=>"1"),DEFAULT_OUTLET.'_ingredients_document',"","","document","")->row_array();
							$ing_doc['document']=null;
							if(!empty($query) && isset($query['document']))
							$ing_doc['document']=$query['document'];
							$ing_doc['doc_id']=$values['id'];
							$ing_doc['doc_name']=$values['doc_name'];
							$ing_doc['doc_type']=$values['doc_type'];
							$ing_doc['ing_id']=$ing['ingredient_id'];
							$ing_doc['ing_name']=$ing['s_item_name'];
							$temp[]=$ing_doc;
						}
					}
				}
				
			}
        $data['ingredients_doc']=$temp;
    	$data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_supplier');
        $query = $this->mdl_supplier->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->_delete($arr_col);
    }
     function insert_or_update_user_review($data,$table){
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->insert_or_update_user_review($data,$table);
    }
    function _get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit)
    {
        $this->load->model('mdl_supplier');
        return  $this->mdl_supplier->_get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit);
    }
    function delete_from_table($where,$table)
    {
        $this->load->model('mdl_supplier');
        $this->mdl_supplier->delete_from_table($where,$table);
    }
	function ingredient_list_supplier($id)
    {
    	$this->load->model('mdl_supplier');
       return $this->mdl_supplier->ingredient_list_supplier($id);
    }
    function check_if_exists($where)
    {
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->check_if_exists($where);
    }
    function get_doc_by_supplier_type($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where='',$having=''){
        $this->load->model('mdl_supplier');
        return $this->mdl_supplier->get_doc_by_supplier_type($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where='',$having='');
    }
}
