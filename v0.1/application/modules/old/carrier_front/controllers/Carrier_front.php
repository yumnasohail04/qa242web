<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Carrier_front extends MX_Controller {
	protected $data = '';
		function __construct() {
			parent::__construct();
			$this->load->library("pagination");
			$this->load->helper("url");
			$this->load->library('session');
		}

		function index() {
		    $carrier_id=$this->session->userdata['carrier']['carrier_id'];
			$data['carrier_id']=$carrier_id;
			$data['detail'] = Modules::run('ingredients/_get_data_from_db_table',array("id"=>$carrier_id),"carrier","","","*","")->row_array();
			$data['carrier_type'] = Modules::run('ingredients/_get_data_from_db_table',array(),"carrier_types","","","*","")->result_array();
			$query = Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("id"=>$carrier_id), "id asc","carrier","*","","","","","")->row();
			$data['uploaded_ans'] = Modules::run('carrier/get_doc_by_carrier_type',array("status"=>"1"),"question asc","document_file","document_file.*","","",$query->type,"","")->result_array();

			if(!empty($data['uploaded_ans'])){
				foreach($data['uploaded_ans'] as $key => $value):
					if($value['question']=="1"){
						$result=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id']), "id asc","document_question","*","","","","","")->row();
						$ans=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("question_id"=>$result->id,"carrier_id"=>$carrier_id), "id asc","document_answer","option,comment_box,reference_link","","","","","")->row();
						$doc_uploaded=Modules::run('carrier_front/_get_specific_table_with_pagination_and_where',array("doc_id"=>$value['id'],"carrier_id"=>$carrier_id), "id asc","document_uploaded","document","","","","","")->row();
						$data['doc'][$key]['sub_question']=$result;
						$data['doc'][$key]['sub_ans']=$ans;
						$data['doc'][$key]['doc_uploaded']=$doc_uploaded;
					} 
				endforeach;
			}
			$this->load->module('template');
		    $data['header_file'] = 'header_carrier';
		    $data['view_file'] = 'home_page';
		    $this->template->front($data);
		}
		function get_carrier_documents()
		{
			$carrier_type=$this->input->post('carrier_type');
			$carrier_id=$this->session->userdata['carrier']['carrier_id'];
			$data['doc'] = Modules::run('carrier/get_doc_by_carrier_type',array("status"=>"1"),"question asc","document_file","document_file.*","","",$carrier_type,"","")->result_array();
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
		    $this->load->view('documents_view',$data);
		}
		function submit_letter()
		{
			$id=$this->input->post('id');
			if(isset($_FILES["news_file"]['size']) )
				if($_FILES["news_file"]['size'] > 0) {
					$itemInfo = Modules::run('ingredients/_get_data_from_db_table',array("id"=>$id),"carrier","","","letter_of_conformance","")->row();
					if(isset($itemInfo->letter_of_conformance) && !empty($itemInfo->letter_of_conformance)) 
						Modules::run('supplier/delete_images_by_name',LETTER_OF_CONFORMANCE_PATH,$itemInfo->letter_of_conformance);
						Modules::run('carrier_front/upload_dynamic_image',LETTER_OF_CONFORMANCE_PATH,$id,"news_file",'letter_of_conformance','id','carrier');
						
				}
				$data['carrier_id']=$id;
				$data['detail'] = Modules::run('ingredients/_get_data_from_db_table',array("id"=>$id),"carrier","","","*","")->row_array();
				$this->session->set_flashdata('status', 'success');
				$this->session->set_flashdata('message', "Successfully document uploaded");
				redirect(BASE_URL.'carrier/index#letter');
		}


		function upload_dynamic_image($actual,$nId,$input_name,$image_field,$image_id_fild,$table) {
        
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
			$upload_data = $this->upload->data();
			unset($data);unset($where);
			$where['id']=$nId;
			$data = array($image_field => $file_name);
			Modules::run('api/insert_or_update_specific_image',$where,$data,$table,$table.$image_id_fild);
		}
		
		// function get_doc_name()
		// {
		// 	$doc=array();
		// 	$type_id=$this->input->post('type_id');
		// 	$supplier_id=$this->session->userdata['supplier']['supplier_id'];
		// 	$ingredients = Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id),DEFAULT_OUTLET.'_ingredients_supplier',"","","ingredient_id,s_item_name","")->result_array();
		// 	foreach($ingredients as $ingrdnt => $ing)
		// 	{
		// 		foreach($type_id as $key => $value)
		// 		{
		// 			$result = Modules::run('ingredients/_get_data_from_db_table',array("type_id"=>$value,"assign_to"=>"ingredient","status"=>"1"),'document',"","","doc_name,id","")->result_array();
		// 			foreach($result as $keys => $values){
		// 				$query=$this->get_ingredients_data($values['id'],$supplier_id)->row_array();
		// 				$doc['document']=null;
		// 				if(!empty($query) && isset($query['document']))
		// 				$doc['document']=$query['document'];
		// 				$doc['doc_name']=$values['doc_name'];
		// 				$doc['ing_id']=$ing['ingredient_id'];
		// 				$doc['ing_name']=$ing['s_item_name'];
		// 				$temp[]=$doc;
		// 			}
		// 		}
		// 	}
		// 	$doc=$temp;
		// 	header('Content-Type: application/json');
		// 	echo json_encode(array("doc"=>$doc));
		// }
		function update_password()
		{
			$old_password=$this->input->post('old_password');
			$password=$this->input->post('password');
			$c_password=$this->input->post('c_password');
			if(!empty($old_password) && !empty($password) && !empty($c_password)){
				$carrier_id=$this->session->userdata['carrier']['carrier_id'];
				$old_password=md5($old_password);
				$validate= Modules::run('api/_get_specific_table_with_pagination',array("password" =>$old_password,"carrier_id"=> $carrier_id),'id desc','carrier_account','id','1','1')->num_rows();
				if($validate > 0)
				{
					$password=md5($password);
					Modules::run('api/update_specific_table',array("carrier_id"=>$carrier_id),array("password"=>$password),'carrier_account');
					$status=TRUE;
					$message="Password Updated ";
				}
				else{
					$status=FALSE;
					$message="Wrong Password ";
				}
			}
			else
			{
				$status=FALSE;
				$message="Please Provide all required Information";
			}
			echo '<article><status>'.$status.'</status><message>'.$message.'</message><article>';
		}
		function profile_update()
		{
			$data['name']=$this->input->post('name');
			$data['email']=$this->input->post('email');
			$data['phone']=$this->input->post('phone');
			$data['city']=$this->input->post('city');
			$data['state']=$this->input->post('state');
			$data['zipcode']=$this->input->post('zipcode');
			$data['address']=$this->input->post('address');
			$data['contact']=$this->input->post('contact');
			$data['type']=$this->input->post('type');
			$data['fse_contactname']=$this->input->post('fse_contactname');
			$data['fse_number']=$this->input->post('fse_number');
			$data['fse_email']=$this->input->post('fse_email');
			
			if(!empty($data['name']) && !empty($data['email']) && !empty($data['phone']) && !empty($data['city']) && !empty($data['zipcode']) && !empty($data['state'])){
				$carrier_id=$this->session->userdata['carrier']['carrier_id'];
				Modules::run('api/update_specific_table',array("id"=>$carrier_id),$data,'carrier');
				$status=TRUE;
				$message="Profile Updated ";
			}
			else
			{
				$status=FALSE;
				$message="Please Provide all required Information";
			}
			echo '<article><status>'.$status.'</status><message>'.$message.'</message><article>';
		}

		function ingredient_location()
		{
			$supplier_id=$this->session->userdata['supplier']['supplier_id'];
			$ing_id=$this->input->post('ing_id');
			$loc=$this->input->post('loc');
			$total=count($ing_id);
			if(isset($ing_id) && !empty($ing_id)){
				for ($i=0; $i < $total; $i++) {
					$where_attr['supplier_id']=$supplier_id;
					$where_attr['ingredient_id']=$ing_id[$i];
					$data['ing_loc']=$loc[$i];
					Modules::run('api/update_specific_table',$where_attr,$data,DEFAULT_OUTLET.'_ingredients_supplier');
					}	
					$status=TRUE;
					$message="Location Saved";
				}
			else
			{
				$status=FALSE;
				$message="Please Provide all required Information";
			}
			echo '<article><status>'.$status.'</status><message>'.$message.'</message><article>';
		}
		function login() {
		    $this->load->module('template');
		    $data['header_file'] = 'header-login';
		    $data['view_file'] = 'login';
		    $this->template->front($data);
		}
		function logout(){
			$carrier_id=$this->session->userdata['carrier']['carrier_id'];
			$this->session->unset_userdata('carrier');
			redirect(BASE_URL.'carrier/login/'.$carrier_id);
		}
		function submit_login()
		{
		    $this->load->library('form_validation');
    		$this->form_validation->set_rules('txtUserName', 'Username', 'required|trim|xss_clean');
    		$this->form_validation->set_rules('txtPassword', 'Passwords', 'required|trim|xss_clean|callback_pword_check');
    		$username = $this->input->post('txtUserName', TRUE);
    		$id = $this->input->post('id', TRUE);
    		$password = md5($this->input->post('txtPassword', TRUE)); 
    		$row = Modules::run('ingredients/_get_data_from_db_table',array("username"=>$username,"password"=>$password,"carrier_id"=>$id),"carrier_account","","","*","")->row();
    		if (empty($row)) {
    			redirect(BASE_URL.'carrier/login/'.$id);
    			exit();
    		}
    		$data['user_id'] = $row->id;
    		$data['user'] = $row->username;
    		$data['carrier_id'] = $id;
    		$this->session->set_userdata('carrier', $data);
			$supplier = $this->session->userdata('carrier');
    		//Modules::run('api/update_specific_table',array("id"=>$row->id),array("login_status"=>'1'),'carrier_account');
    		redirect(BASE_URL.'carrier/index');
		}
		
		function thanks() {
			$count = $this->session->flashdata('count');
		    $supplier_id=$this->session->userdata['supplier']['supplier_id'];
			$detail= Modules::run('ingredients/_get_data_from_db_table',array("id"=>$supplier_id),"supplier","","","*","")->row_array();
			$submitted = Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id),"supplier_documents","","","*","")->num_rows();
			$submitted_ing = Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id),DEFAULT_OUTLET."_ingredients_document","","","*","")->num_rows();
			$total_doc = Modules::run('ingredients/_get_data_from_db_table',array("assign_to"=>"supplier","status"=>"1"),"document","","","*","")->num_rows();
			$submitted=$submitted+$submitted_ing;
			$total_doc=$total_doc+$count;
			if($submitted==$total_doc)
				$data['message']= $detail['name']." you have completed your profile by providing all your documents.";
			else
				$data['message']= $detail['name']." you have submitted ".$submitted." out of ".$total_doc." documents.";
			$data['supplier_id']=$supplier_id;
		    $this->session->unset_userdata('supplier');
		    $this->load->module('template');
		    $data['header_file'] = 'header-login';
		    $data['view_file'] = 'thanks';
		    $this->template->front($data);
		}
		function submit_doc(){
			$carrier_id=$this->session->userdata['carrier']['carrier_id'];
			$carrier_type=$this->input->post('carrier_type');
			$doc= Modules::run('carrier/get_doc_by_carrier_type',array("status"=>"1"),"question asc","document_file","document_file.*","","",$carrier_type,"","")->result_array();
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
								$this->delete_images_by_name(CARRIER_DOCUMENTS_PATH,$itemInfo->document);
								$this->upload_dynamic_image(CARRIER_DOCUMENTS_PATH,$update_id,"news_main_page_file_$key",'document','id','document_uploaded');
						}
					}
				endforeach;
				$message="Successfully Submitted Documents";
			}
			$this->session->set_flashdata('status', 'success');
			$this->session->set_flashdata('message', $message);
    	    redirect(BASE_URL . 'carrier/index#carrier_documents');
		}
		function delete_images_by_name($actual_path,$name) {
            if (file_exists($actual_path.$name))
                unlink($actual_path.$name);
        }
		function submit_ingredient_document($supplier_id)
		{
			$ing_doc=$temp=array();
			$ingredients = Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id),DEFAULT_OUTLET.'_ingredients_supplier',"","","ingredient_id,s_item_name","")->result_array();
			foreach($ingredients as $ingrdnt => $ing)
			{
				$type_selected=$this->supplier_ingredients($supplier_id,$ing['ingredient_id'])->result_array();
				foreach($type_selected as $key => $value)
				{
					$result = Modules::run('ingredients/_get_data_from_db_table',array("type_id"=>$value['type_id'],"assign_to"=>"ingredient","status"=>"1"),'document',"","","doc_name,id","")->result_array();
					foreach($result as $keys => $values){
						$query=Modules::run('ingredients/_get_data_from_db_table',array("supplier_id"=>$supplier_id,"ingredient_id"=>$ing['ingredient_id'],"document_id"=>$values['id']),DEFAULT_OUTLET.'_ingredients_document',"","","document","")->row_array();
						$ing_doc['ing_id']=$ing['ingredient_id'];
						$ing_doc['doc_id']=$values['id'];
						$temp[]=$ing_doc;
					}
					
				}
			}
			foreach($temp as $key => $value)
			{
				$where['ingredient_id']=$value['ing_id'];
				$where['document_id']=$value['doc_id'];
				$where['supplier_id']=$supplier_id;
				if(isset($_FILES["main_file_$key"]['size']) )
					if($_FILES["main_file_$key"]['size'] > 0) {
						$itemInfo = Modules::run('ingredients/_get_data_from_db_table',$where,DEFAULT_OUTLET.'_ingredients_document',"","","*","")->row();
						if(isset($itemInfo->document) && !empty($itemInfo->document)) 
							Modules::run('ingredients/delete_images_by_name',INGREDIENT_DOCUMENTS_PATH,$itemInfo->document);
							Modules::run('ingredients/delete_from_table',$where,DEFAULT_OUTLET.'_ingredients_document');
							Modules::run('ingredients/upload_dynamic_image',INGREDIENT_DOCUMENTS_PATH,$value['ing_id'],'main_file_'.$key,'document','id',DEFAULT_OUTLET.'_ingredients_document',$value['doc_id'],$supplier_id);
					}
			}
			$count=count($temp);
			return $count;
		}

		function supplier_ingredients($supplier_id,$ing_id)
		{
			$this->load->model('mdl_carrier_front');
			return  $this->mdl_carrier_front->supplier_ingredients($supplier_id,$ing_id);
		}
		function _get_specific_table_with_pagination_and_where($cols, $order_by,$table,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_carrier_front');
            $query = $this->mdl_carrier_front->_get_specific_table_with_pagination_and_where($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having);
            return $query;
        }
}