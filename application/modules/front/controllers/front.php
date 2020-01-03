<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Front extends MX_Controller {
	protected $data = '';
		function __construct() {
		parent::__construct();
		$this->load->library("pagination");
		 $this->load->helper("url");
		 $this->load->library('session');
		}

		function index() {
		    $supplier_id=$this->session->userdata['supplier']['supplier_id'];
		    if (empty($supplier_id)) {
    			redirect(BASE_URL.'login');
    			exit();
    		}
		    $data['detail'] = Modules::run('ingredients/_get_data_from_db_table',array("id"=>$supplier_id),"supplier","","","*","")->result_array();
		    $data['doc'] = Modules::run('ingredients/_get_data_from_db_table',array("assign_to"=>"supplier","status"=>"1"),"document","","","id,doc_name","")->result_array();
		    $this->load->module('template');
		    $data['header_file'] = 'header';
		    $data['view_file'] = 'home_page';
		    $this->template->front($data);
		}
		
		function login() {
		    $this->load->module('template');
		    $data['header_file'] = 'header-login';
		    $data['view_file'] = 'login';
		    $this->template->front($data);
		}
		
		function submit_login()
		{
		    $this->load->library('form_validation');
    		$this->form_validation->set_rules('txtUserName', 'Username', 'required|trim|xss_clean');
    		$this->form_validation->set_rules('txtPassword', 'Passwords', 'required|trim|xss_clean|callback_pword_check');
    		$username = $this->input->post('txtUserName', TRUE);
    		$id = $this->input->post('id', TRUE);
    		$password = md5($this->input->post('txtPassword', TRUE)); 
    		$row = Modules::run('ingredients/_get_data_from_db_table',array("username"=>$username,"password"=>$password,"login_status"=>"0","supplier_id"=>$id),"supplier_account","","","*","")->row();
    		if (empty($row)) {
    			redirect(BASE_URL.'login/'.$id);
    			exit();
    		}
    		$data['user_id'] = $row->id;
    		$data['user'] = $row->username;
    		$data['supplier_id'] = $id;
    		$this->session->set_userdata('supplier', $data);
    		$supplier = $this->session->userdata('supplier');
    		Modules::run('api/update_specific_table',array("id"=>$row->id),array("login_status"=>'1'),'supplier_account');
    		redirect(BASE_URL.'index');
		}
		
		function thanks() {
		    $supplier_id=$this->session->userdata['supplier']['supplier_id'];
		    $data['detail'] = Modules::run('ingredients/_get_data_from_db_table',array("id"=>$supplier_id),"supplier","","","*","")->row_array();
		    $this->session->unset_userdata('supplier');
		    $this->load->module('template');
		    $data['header_file'] = 'header-login';
		    $data['view_file'] = 'thanks';
		    $this->template->front($data);
		}
		
		function submit_doc(){
		    $update_id=$this->input->post('id');
		    $doc = Modules::run('supplier/_get_data_from_db_table',array("assign_to"=>"supplier","status"=>"1"),"document","","","id,doc_name","")->result_array();
            if (is_numeric($update_id) && $update_id != 0) {
                    if(!empty($doc)){
                        $where['id'] = $update_id;
                        foreach($doc as $key => $value){
                        if(isset($_FILES["news_main_page_file_$key"]['size']) )
                            if($_FILES["news_main_page_file_$key"]['size'] > 0) {
                                $itemInfo = Modules::run('supplier/_get_by_arr_id',$where)->row();
                                if(isset($itemInfo->document) && !empty($itemInfo->document)) 
                                    Modules::run('supplier/delete_images_by_name',SUPPLIER_DOCUMENTS_PATH,$itemInfo->document);
                                    Modules::run('supplier/delete_from_table',array("s_doc_id"=>$value['id'],"supplier_id"=>$update_id),"supplier_documents");
                                    Modules::run('supplier/upload_dynamic_image',SUPPLIER_DOCUMENTS_PATH,$update_id,"news_main_page_file_$key",'document','id','supplier_documents',$value['id'],$value['doc_name']);
                            }
                        }
                    }
    	    	}
    	    redirect(BASE_URL . 'thanks');
        }
        
}