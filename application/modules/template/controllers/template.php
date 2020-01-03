<?php 
/*************************************************
Created By: Tahir Mehmood
Dated: 28-09-2016
*************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template extends MX_Controller 
{

function __construct() {
parent::__construct();
}


	function admin($data){
    	$data['total_counter'] = $user_id = 0; 
		$outlet_id = DEFAULT_OUTLET;
		$left_panel = array();
		$primary_group = $secondry_group = 0;
        if(isset($this->session->userdata['user_data']['user_id']) && !empty($this->session->userdata['user_data']['user_id']))
            $user_id = $this->session->userdata['user_data']['user_id'];
        if(!isset($chat_only)) {
	        if(isset($this->session->userdata['user_data']['group']) && !empty($this->session->userdata['user_data']['group']))
	        	$primary_group = $this->session->userdata['user_data']['group'];
	        if(!empty($primary_group)) {
		        $temp =array();
		    	$temp['trackig_id'] = 'G_'.$primary_group;
		    	$group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$primary_group), 'chat_id desc','chat_id',$outlet_id,'message,chat_id','1','1','','','')->result_array();
		        $temp['last_chat'] = 0; if(isset($group_message[0]['chat_id']) && !empty($group_message[0]['chat_id'])) $temp['last_chat']=$group_message[0]['chat_id']; $temp['last_chat']=  Modules::run('api/string_length',$temp['last_chat'],'8000',0);
		        $data['total_counter'] = $data['total_counter'] + Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id"=>$primary_group,"message_to"=>$user_id,"message_status"=>"1"),'chat_id desc','chat_id',$outlet_id.'_chat_detail','chat_id','1','0','','','')->num_rows();
		        $left_panel[] = $temp;
	    	}
	        if(isset($this->session->userdata['user_data']['second_group']) && !empty($this->session->userdata['user_data']['second_group']))
	        	$secondry_group = $this->session->userdata['user_data']['second_group'];
	        if(!empty($second_group)) {
	        	$temp =array();
	        	$temp['trackig_id'] = 'G_'.$secondry_group;
	        	$group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$secondry_group), 'chat_id desc','chat_id',$outlet_id,'message,chat_id','1','1','','','')->result_array();
	            $temp['last_chat'] = 0; if(isset($group_message[0]['chat_id']) && !empty($group_message[0]['chat_id'])) $temp['last_chat']=$group_message[0]['chat_id']; $temp['last_chat']=  Modules::run('api/string_length',$temp['last_chat'],'8000',0);
	            $data['total_counter'] = $data['total_counter'] + Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id"=>$secondry_group,"message_to"=>$user_id,"message_status"=>"1"),'chat_id desc','chat_id',$outlet_id.'_chat_detail','chat_id','1','0','','','')->num_rows();
	            $left_panel[] = $temp;
	        }
	        if(!empty($secondry_group) || !empty($primary_group)) {
		        $group_chat = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id !="=>'0'), 'chat_id desc','group_id',$outlet_id.'_chat_detail','group_id','1','0','(`message_to` = "'.$user_id.'" OR `message_from` = "'.$user_id.'")','(`group_id` != "'.$primary_group.'" AND `group_id` != "'.$secondry_group.'")','')->result_array();
		        if(!empty($group_chat)) {
		            foreach ($group_chat as $key => $gc):
		            	$temp = array();
		                $temp['trackig_id'] = 'G_'.$gc['group_id'];
		                $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$gc['group_id']), 'chat_id desc','group_id',DEFAULT_OUTLET,'message,chat_id','1','1','','','')->result_array();
		                $temp['last_chat'] = "0";
		                if(isset($group_message[0]['chat_id']) && !empty($group_message[0]['chat_id'])) 
		                    $temp['last_chat']=$group_message[0]['chat_id'];
		                $data['total_counter'] = $data['total_counter'] + Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id"=>$gc['group_id'],"message_to"=>$user_id,"message_status"=>"1"),'chat_id desc','chat_id',$outlet_id.'_chat_detail','chat_id','1','0','','','')->num_rows();
		                $left_panel[] = $temp;
		                unset($temp);
		            endforeach;
		        }
		    }
	        $group_users= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id" =>$outlet_id,"status"=>"1",'id !='=>$user_id),'id desc','id','users','id,first_name,last_name,user_image,is_online','1','0','','','')->result_array();    
	        if(!empty($group_users)) {
	            foreach ($group_users as $key => $gc):
	                $pre_temp['user_id'] = $temp['id'] = $gc['id'];
	                if($user_id > $gc['id'])
	                    $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$user_id.'_'.$gc['id'];
	                else
	                    $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$gc['id'].'_'.$user_id;
	                $last_detail = Modules::run('admin_api/get_chat_detail',array("group_id"=>'0'), 'chat_id desc','chat_id',$outlet_id,'message,chat_id','1','1','((`message_to` = "'.$user_id.'" AND `message_from` = "'.$gc['id'].'") OR (`message_to` = "'.$gc['id'].'" AND `message_from` = "'.$user_id.'"))','','')->result_array();
	                $temp['last_chat'] = "0";
	                if(isset($last_detail[0]['chat_id']) && !empty($last_detail[0]['chat_id'])) 
	                    $temp['last_chat']=$last_detail[0]['chat_id'];
	                $data['total_counter'] = $data['total_counter'] + Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id"=>'0',"message_to"=>$user_id,"message_status"=>"1","message_from"=>$gc['id']),'chat_id desc','chat_id',$outlet_id.'_chat_detail','chat_id','1','0','','','')->num_rows();
	                $left_panel[] = $temp;
	                $previous_user[] = $pre_temp;
	                unset($temp);
	            endforeach;
	        }
        }
        $data['tracker_list'] = $left_panel;
		$data['outlets'] =	$this->get_outlets(); 
		$data['user_data'] = $user_data = $this->session->userdata('user_data');
		$role_id = 0;
		if (isset($user_data['role_id']) && !empty($user_data['role_id']))
			$role_id = $user_data['role_id'];
		$data['role_id'] = $role_id;
		$review_approval = false;
		//SELECT id,adminlogo,adminlogo_small FROM `outlet` WHERE `status`=1
		$notification = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET,"notification_status"=>"1",'user_id'=>$this->session->userdata['user_data']['user_id']),'notification_id desc','notification','notification_id,notification_message','1','0');
		$data['review_approval'] = Modules::run('api/check_reviewer_approver',DEFAULT_OUTLET,$this->session->userdata['user_data']['user_id']);
		$data['total_notification'] = $notification->num_rows();
		$data['notification'] = $notification->result_array();
		$this->load->view('admin/theme1/admin',$data);
	}

	function insights($data){
		$data['outlets'] =	$this->get_insights_outlets(); 
		$data['user_data'] = $user_data = $this->session->userdata('insights_user');
		$role_id = 0;
		if (isset($user_data['role_id']) && !empty($user_data['role_id']))
			$role_id = $user_data['role_id'];
		$data['role_id'] = $role_id;
		//SELECT id,adminlogo,adminlogo_small FROM `outlet` WHERE `status`=1
		$this->load->view('insights/admin',$data);
	}
	function insights_login($data){
		$this->load->view('insights/login',$data);
	}
	
	function admin_form($data){
		$data['outlets'] =	$this->get_outlets(); 
		$data['user_data'] = $user_data = $this->session->userdata('user_data');
		$role_id = 0;
		if (isset($user_data['role_id']) && !empty($user_data['role_id']))
			$role_id = $user_data['role_id'];
		$data['role_id'] = $role_id;
		$sixten_groups = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("role"=>'116'),'id desc','id',DEFAULT_OUTLET.'_groups','id','1','0','','','')->result_array();
		$seventen_groups = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("role"=>'117'),'id desc','id',DEFAULT_OUTLET.'_groups','id','1','0','','','');
		$seventen_count = $seventen_groups->num_rows();
		$seventen_groups = $seventen_groups->result_array();
		$review_approval = false;
		if(!empty($sixten_groups) && !empty($seventen_groups)){
			$counter= 0;$text="";
			foreach ($sixten_groups as $key => $sg):
				if(($counter+1) <= $seventen_count) {
					if(empty($text))
						$text = '(`group`="'.$sg['id'].'" AND `second_group`="'.$seventen_groups[$counter]['id'].'") OR (`second_group`="'.$sg['id'].'" AND `group`="'.$seventen_groups[$counter]['id'].'")';
					else
						$text = $text.' OR (`group`="'.$sg['id'].'" AND `second_group`="'.$seventen_groups[$counter]['id'].'") OR (`second_group`="'.$sg['id'].'" AND `group`="'.$seventen_groups[$counter]['id'].'")';
					$counter++;
				}
			endforeach;
			if(!empty($text)) {
				$text = '('.$text.')';
				$user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$this->session->userdata['user_data']['user_id']),'id desc','id,user_name','users','id','1','1',$text,'','')->result_array();
				if(!empty($user_detail))
					$review_approval = true;
			}
		}
		$data['review_approval'] = $review_approval;
		$this->load->view('admin/theme1/admin_form',$data);
	}
	
	function index(){
		$this->load->view('theme1');
	}
	function get_insights_outlets() {
		$outlets = array();
		$user_data = $this->session->userdata('insights_user');
		if($user_data['role_id'] == '5' || $user_data['role'] == 'portal admin'){
			$result = Modules::run('outlet/get_outlets_array');
		
			foreach($result as $key => $name){
				$outlets[$key]['id'] = $key;
				$outlets[$key]['name'] = $name;
			}
		}else{
			$result = Modules::run('roles_outlet/_get_where_custom', 'emp_id', $user_data['user_id']);
			foreach($result->result() as $key => $row){
				$outlet = Modules::run('outlet/_get_where',$row->outlet_id)->row();
				$outlets[$key]['id'] = $outlet->id;
				$outlets[$key]['name'] = $outlet->name;
			}
			
		}
		$data['all_outlet_id']=Modules::run('outlet/_get_all_details_admin','id asc')->result_array();
		$data['outlet_id'] = DEFAULT_OUTLET;
		$data['outlets'] = $outlets;
		return $data;
	}


	function get_outlets(){
		$outlets = array();
		$user_data = $this->session->userdata('user_data');
		if($user_data['role_id'] == '5' || $user_data['role'] == 'portal admin'){
			$result = Modules::run('outlet/get_outlets_array');
		
			foreach($result as $key => $name){
				$outlets[$key]['id'] = $key;
				$outlets[$key]['name'] = $name;
			}
		}else{
			$result = Modules::run('roles_outlet/_get_where_custom', 'emp_id', $user_data['user_id']);
			foreach($result->result() as $key => $row){
				$outlet = Modules::run('outlet/_get_where',$row->outlet_id)->row();
				$outlets[$key]['id'] = $outlet->id;
				$outlets[$key]['name'] = $outlet->name;
			}
			
		}
		$data['all_outlet_id']=Modules::run('outlet/_get_all_details_admin','id asc')->result_array();
		$data['outlet_id'] = DEFAULT_OUTLET;
		$data['outlets'] = $outlets;
		return $data;
	}
	
	function front_print($data){
		$this->load->view('front/theme1/front_print', $data);
	}
	function front($data) {
        $url=$this->uri->segment(1);
		if(isset($url) && !empty($url))
			$data['webpages'] =Modules::run('webpages/_get_by_arr_id',array('outlet_id'=> DEFAULT_OUTLET,'url_slug'=>$url))->result_array();
		$where_current_outlet['url'] = CURRENT_DOMAIN;
		$data['row_current_outlet'] = Modules::run('outlet/_get_by_arr_id', $where_current_outlet)->row();

		$arr_outlets = array();
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
       
        $data['footer_links'] = Modules::run('webpages/_get_footerpanel_pages');

		$where_outlet['is_default'] = 0;
		$where_outlet['status'] = 1;
		$res_outlets = Modules::run('outlet/_get_where_cols', $where_outlet, 'id asc, name asc');
		$data['res_outlets'] = $res_outlets;

        foreach($res_outlets->result() as $row_outlet){
			$arr_outlets[] = $row_outlet;
		}
		$data['arr_outlet_chunks'] = array_chunk($arr_outlets, 4);
		$data['count_outlet_chunks'] = count($data['arr_outlet_chunks']);

		////////////	ADDED BY AKABIR / COPIED FROM WASEEM CODE	/////////////////////////////////////////////////////
		$where_search_outlet_pakages['pakke.status'] = 1;
		$where_search_outlet_pakages['car_type.status'] = 1;	
		$res_search_outlet_pakages = Modules::run('pakke/_get_outlet_pakke_by_car_type', $where_search_outlet_pakages, 'car_type.page_rank, pakke.rank asc ');
		if (isset($res_search_outlet_pakages)) 
		foreach($res_search_outlet_pakages->result() as $row_search_outlet_pakage){
			$arr_outlet_pakages[$row_search_outlet_pakage->outlet_id] = 1;
		}
		if (isset($arr_outlet_pakage))
		$data['arr_outlet_pakages']=$arr_outlet_pakages;
		////////////	ADDED BY AKABIR / COPIED FROM WASEEM CODE	/////////////////////////////////////////////////////

		$where_default_outlet['is_default'] = 1;
		$data['res_default_outlet'] = Modules::run('outlet/_get_by_arr_id', $where_default_outlet)->row();

		$where_banner['outlet_id'] = DEFAULT_OUTLET;
		$where_banner['status'] = 1;
		$data['banner'] = Modules::run('banner_management/_get_by_arr_id', $where_banner);
		
		$this->load->view('front/theme1/front', $data);
	}
	function footer($data)
	{
		$this->load->view('front/theme1/footer', $data);
	}
	

}
