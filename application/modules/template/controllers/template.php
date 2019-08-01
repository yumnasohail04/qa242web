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
		
		$this->load->view('common/front', $data);
	}
	function footer($data)
	{
		$this->load->view('common/footer', $data);
	}
	

}
