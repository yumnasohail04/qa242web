<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assignments extends MX_Controller
{
	function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
        //Modules::run('site_security/has_permission');
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
    	if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
    }
    function index() {
        $this->active_checks();
    }

    function active_checks() {
    	$data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id !="=>"12"), 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
        $data['total_pages'] = 0; 
        $data['page_number'] = 1; 
        $data['limit'] = 20;
        $where['assign_status']="Open";
        $data['news'] = $this->get_checklisting_data(array("assign_status"=>'Open',"assignments.start_datetime >="=>date('Y-m-d ').'00:00:00',"assignments.end_datetime <="=>date('Y-m-d ').'23:59:59'), 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype',$data['page_number'],$data['limit'],'','','','');
        if(!empty($data['news']->result_array())) {
            $data['total_pages'] = $this->get_checklisting_data(array("assign_status"=>'Open',"assignments.start_datetime >="=>date('Y-m-d ').'00:00:00',"assignments.end_datetime <="=>date('Y-m-d ').'23:59:59'), 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype','1','0','','','','')->num_rows();
        }
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        $data['assign_status'] = 'active_checks';
        $data['view_file'] = 'check_listing';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function today_checks() {
    	$data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id !="=>"12"), 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
        $data['total_pages'] = 0; 
        $data['page_number'] = 1; 
        $data['limit'] = 20;
        $where['assign_status']="Open";
        $data['news'] = $this->get_checklisting_data(array("assignments.start_datetime >="=>date('Y-m-d ').'00:00:00',"assignments.end_datetime <="=>date('Y-m-d ').'23:59:59'), 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype',$data['page_number'],$data['limit'],'','','','');
        if(!empty($data['news']->result_array())) {
            $data['total_pages'] = $this->get_checklisting_data(array("assignments.start_datetime >="=>date('Y-m-d ').'00:00:00',"assignments.end_datetime <="=>date('Y-m-d ').'23:59:59'), 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype','1','0','','','','')->num_rows();
        }
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        $data['assign_status'] = 'today_checks';
        $data['view_file'] = 'check_listing';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function overdue_checks() {
    	$data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id !="=>"12"), 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
        $data['total_pages'] = 0; 
        $data['page_number'] = 1; 
        $data['limit'] = 20;
        $data['news'] = $this->get_checklisting_data(array("assign_status"=>'OverDue'), 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype',$data['page_number'],$data['limit'],'','','','');
        if(!empty($data['news']->result_array())) {
            $data['total_pages'] = $this->get_checklisting_data(array("assign_status"=>'OverDue'), 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype','1','0','','','','')->num_rows();
        }
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        $data['assign_status'] = 'overdue_checks';
        $data['view_file'] = 'check_listing';
        $this->load->module('template');
        $this->template->admin($data);
    }
     function delete_current_date_checks() {
        $outlet_id = '1';
        $start_time = date('Y-m-d H:i:s',strtotime('2019-01-01 00:00:00'));
        $end_time= date('Y-m-d H:i:s');
        $checks = Modules::run('admin_api/get_checks_for_delete',array("assignments.start_datetime >="=>$start_time),'assign_id desc','assign_id',$outlet_id,'checkid,assign_id,checktype,assign_status','1','0','(lower(assign_status)="overdue")','','')->result_array();
        
        if(isset($checks) && !empty($checks)) {
            foreach ($checks as $key => $ck):
                if(strtolower($ck['checktype']) == 'product attribute') {
                    $questions = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("checkid"=>$ck['checkid'],"assignment_id"=>$ck['assign_id']),'question_id desc','question_id',$outlet_id.'_checks_questions','question_id','1','0','','','')->result_array();
                    echo "<br><br><br>questions<br>";
                    print_r($questions);
                    echo "<br>";
                    if(!empty($questions)) {
                        foreach ($questions as $key => $qa):
                            echo "<br><br><br>delete specific questions<br>";
                            print_r($qa);
                            echo "<br>";
                            if(isset($qa['question_id']) && !empty($qa['question_id']))
                                Modules::run('api/delete_from_specific_table',array("question_id"=>$qa['question_id']),$outlet_id."_checks_answers");

                            Modules::run('api/delete_from_specific_table',array("question_id"=>$qa['question_id']),$outlet_id."_checks_questions");
                        endforeach;
                    }
                    else
                        echo "<br><br>no questions available of current check  ".$ck['checkid']."<br>";
                }
                Modules::run('api/delete_from_specific_table',array("assign_id"=>$ck['assign_id']),$outlet_id."_assignments");
            endforeach;
        }
        else
            echo "<br><br>no checks available during start datetime ".$start_time." and end datetime ".$end_time."<br>";
        redirect(ADMIN_BASE_URL.'assignments/overdue_checks');
    }
    function pending_review() {
        $where['assign_status']="Review";
        $where['reassign_id']=0;
        $data['news'] = $this->_get('id desc',$where);
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        $data['view_file'] = 'pending_review';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function pending_approval() {

        $where['assign_status']="Approval";
        $data['news'] = $this->_get('id desc',$where);
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        $data['view_file'] = 'pending_approval';
        $this->load->module('template');
        $this->template->admin($data);
    }
     function completed_checks() {
        $where['assign_status']="Completed";
        $data['news'] = $this->_get('id desc',$where);
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        $data['view_file'] = 'completed_checks';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function static_forms_pending() {
        $data['total_pages'] = 0; 
        $data['page_number'] = 1; 
        $data['limit'] = 20;
        $user_data = $this->session->userdata('user_data');
        $res = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>"Pending"), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team',$data['page_number'],$data['limit'],'(review_team ="'.$user_data['group'].'" OR  review_team ="'.$user_data['second_group'].'")','','')->result_array();
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        foreach($res as $key=>$value) {
            $r_user = Modules::run('api/_get_specific_table_with_pagination_and_where',array("sf_id"=>$value['check_id']), 'sf_id desc',DEFAULT_OUTLET.'_static_form','sf_name','','','','','')->result_array();
            $res[$key]['check_name']=$r_user[0]['sf_name'];
            $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['check_id'],'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_static_checks_inspection','sci_team_id','1','0')->result_array();
            $counter = 1;
            $text = '';
            if(!empty($get_inspection_team)) {
                foreach ($get_inspection_team as $keyy => $git):
                    if(!empty($git['sci_team_id'])) {
                        $keying = array_search($git['sci_team_id'], array_column($groups, 'id'));
                        if (is_numeric($keying)) {
                            if($counter >1)
                                $text= $text.",";
                            $text=$text.$groups[$keying]['group_title'];
                            $counter++;
                        }
                    }
                endforeach;
            }
            $res[$key]['group'] = $text;
        }
        $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>"Pending"), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team','1','0','(review_team ="'.$user_data['group'].'" OR  review_team ="'.$user_data['second_group'].'")','','')->num_rows();
        $data['result'] = $res;
        $data['assign_status'] = "Pending";
        $data['view_file'] = 'static_assignments_detail';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function static_forms_reviewed() {
        $data['total_pages'] = 0; 
        $data['page_number'] = 1; 
        $data['limit'] = 20;
    	$user_data = $this->session->userdata('user_data');
        $res = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>"Reviewed"), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team,review_user',$data['page_number'],$data['limit'],'(approval_team ="'.$user_data['group'].'" OR  approval_team ="'.$user_data['second_group'].'")','','')->result_array();
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        foreach($res as $key=>$value) {
            $r_user = Modules::run('api/_get_specific_table_with_pagination_and_where',array("sf_id"=>$value['check_id']), 'sf_id desc',DEFAULT_OUTLET.'_static_form','sf_name','','','','','')->result_array();
            $res[$key]['check_name']=$r_user[0]['sf_name'];
            $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['check_id'],'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_static_checks_inspection','sci_team_id','1','0')->result_array();
            $counter = 1;
            $text = '';
            if(!empty($get_inspection_team)) {
                foreach ($get_inspection_team as $keyy => $git):
                    if(!empty($git['sci_team_id'])) {
                        $keying = array_search($git['sci_team_id'], array_column($groups, 'id'));
                        if (is_numeric($keying)) {
                            if($counter >1)
                                $text= $text.",";
                            $text=$text.$groups[$keying]['group_title'];
                            $counter++;
                        }
                    }
                endforeach;
            }
            $res[$key]['group'] = $text;
        }
        $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>"Reviewed"), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team,review_user','1','0','(approval_team ="'.$user_data['group'].'" OR  approval_team ="'.$user_data['second_group'].'")','','')->num_rows();
        $data['result'] = $res;
        $data['assign_status'] = "Reviewed";
        $data['view_file'] = 'static_assignments_detail';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function static_forms_approved() {
        $data['total_pages'] = 0; 
        $data['page_number'] = 1; 
        $data['limit'] = 20;
        $res = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>"Approved"), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team,review_user,approval_user',$data['page_number'],$data['limit'],'','','')->result_array();
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        foreach($res as $key=>$value)
        {
            $r_user = Modules::run('api/_get_specific_table_with_pagination_and_where',array("sf_id"=>$value['check_id']), 'sf_id desc',DEFAULT_OUTLET.'_static_form','sf_name','','','','','')->result_array();
            $res[$key]['check_name']=$r_user[0]['sf_name'];
            $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['check_id'],'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_static_checks_inspection','sci_team_id','1','0')->result_array();
            $counter = 1;
            $text = '';
            if(!empty($get_inspection_team)) {
                foreach ($get_inspection_team as $keyy => $git):
                    if(!empty($git['sci_team_id'])) {
                        $keying = array_search($git['sci_team_id'], array_column($groups, 'id'));
                        if (is_numeric($keying)) {
                            if($counter >1)
                                $text= $text.",";
                            $text=$text.$groups[$keying]['group_title'];
                            $counter++;
                        }
                    }
                endforeach;
            }
            $res[$key]['group'] = $text;
        }
        $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>"Approved"), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team','1','0','','','')->num_rows();
        $data['assign_status'] = "Approved";
        $data['result'] = $res;
        $data['view_file'] = 'static_assignments_detail';
        $this->load->module('template');
        $this->template->admin($data);
    }
    
    function static_assignment_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $data['assign_status'] = $assign_status = $this->input->post('assign_status');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); 
        $data['total_pages'] = 0;
        $user_data = $this->session->userdata('user_data');
        if(strtolower($assign_status) == 'pending')
            $or_where = '(`complete_datetime` >= "'.$startdate.' 00:00:00" AND `complete_datetime` <="'.$enddate.' 23:59:59" AND (review_team ="'.$user_data['group'].'" OR  review_team ="'.$user_data['second_group'].'"))';
        elseif(strtolower($assign_status) == 'reviewed')
            $or_where = '(`review_datetime` >= "'.$startdate.' 00:00:00" AND `review_datetime` <="'.$enddate.' 23:59:59"  AND (approval_team ="'.$user_data['group'].'" OR  approval_team ="'.$user_data['second_group'].'"))';
        elseif(strtolower($assign_status) == 'approved')
            $or_where = '(`approval_datetime` >= "'.$startdate.' 00:00:00" AND `approval_datetime` <="'.$enddate.' 23:59:59")';
        else
            $or_where = "";
        $res = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>$assign_status), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team,review_user,approval_user',$data['page_number'],$data['limit'],$or_where,'','')->result_array();
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        foreach($res as $key=>$value)
        {
            $r_user = Modules::run('api/_get_specific_table_with_pagination_and_where',array("sf_id"=>$value['check_id']), 'sf_id desc',DEFAULT_OUTLET.'_static_form','sf_name','','','','','')->result_array();
            $res[$key]['check_name']=$r_user[0]['sf_name'];
            $res[$key]['group']='';
            $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['check_id'],'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_static_checks_inspection','sci_team_id','1','0')->result_array();
            $counter = 1;
            if(!empty($get_inspection_team)) {
                foreach ($get_inspection_team as $keyy => $git):
                    $text = '';
                    if(!empty($git['sci_team_id'])) {
                        $keying = array_search($git['sci_team_id'], array_column($groups, 'id'));
                        if (is_numeric($keying)) {
                            if($counter >1)
                                $text= $text.",";
                            $text=$text.$groups[$keying]['group_title'];
                            $counter++;
                        }
                    }
                    $res[$key]['group'] = $text;
                endforeach;
            }
        }
        $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_status"=>$assign_status), 'assign_id desc',DEFAULT_OUTLET.'_static_assignments','assign_id,complete_datetime,assign_status,check_id,inspection_team','1','0',$or_where,'','')->num_rows();
        $data['result'] = $res;
        echo $this->load->view('static_assignment_search',$data,TRUE);
    }
        function assignments_detail() {
        $id = $this->input->post('id');
        $check = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assign_id"=>$id), 'assign_id',DEFAULT_OUTLET.'_static_assignments','assign_id,assign_status','1','1','','','')->result_array();
        $data['detail'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("assignment_id"=>$check[0]['assign_id']), 'assign_ans_id',DEFAULT_OUTLET.'_static_assignment_answer','*','','','','','')->result_array();
        foreach($data['detail'] as $key => $value)
        {
            $question = Modules::run('api/_get_specific_table_with_pagination_and_where',array("sfq_id"=>$value['question_id']), 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_question','','','','','')->result_array();
            $data['detail'][$key]['question']=$question[0]['sfq_question'];
        }
        $status = "";
       
        if(isset($check[0]['assign_status']) && !empty($check[0]['assign_status'])) {
            if($check[0]['assign_status'] !='Approved') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '116') {
                    if($check[0]['assign_status'] == 'Pending')
                        $status = "Review & Approved";
                }/*
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($check[0]['assign_status'] == 'Reviewed')
                        $status = "Approve";
                }*/
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($check[0]['assign_status'] == 'Pending')
                        $status = "Review";
                }
                else
                    $status = "";
            }
        }
      
        $data['status'] = $status;
        $this->load->view('assignments_detail',$data);
    }
    function truck_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; $data['page_number'] = 1; $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array(), 'ti_id desc',DEFAULT_OUTLET.'_truck_inspection','ti_id,ti_monitor_name,ti_datetime,ti_invoice_no,ti_item_name,ti_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ti_datetime >="=> date("Y-m-d")." 00:00:00","ti_datetime <="=>date("Y-m-d")." 23:59:59"), 'ti_id desc',DEFAULT_OUTLET.'_truck_inspection','ti_id,ti_monitor_name,ti_datetime,ti_invoice_no,ti_item_name,ti_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'truck_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function shipping_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; 
        $data['page_number'] = 1;
        $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("si_checkin_time >="=> date("Y-m-d")." 00:00:00","si_checkin_time <="=>date("Y-m-d")." 23:59:59"), 'si_id desc',DEFAULT_OUTLET.'_shipping_inspection','si_id,si_monitor_name,si_checkin_time,si_sale_order_no,si_item_name,si_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("si_checkin_time >="=> date("Y-m-d")." 00:00:00","si_checkin_time <="=>date("Y-m-d")." 23:59:59"), 'si_id desc',DEFAULT_OUTLET.'_shipping_inspection','si_id,si_monitor_name,si_checkin_time,si_sale_order_no,si_item_name,si_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'shipping_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function palletizing_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; 
        $data['page_number'] = 1;
        $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("pi_time >="=> date("Y-m-d")." 00:00:00","pi_time <="=>date("Y-m-d")." 23:59:59"), 'pi_id desc',DEFAULT_OUTLET.'_palletizing_inspection','pi_id,pi_time,pi_item_number,pi_cases,pi_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("pi_time >="=> date("Y-m-d")." 00:00:00","pi_time <="=>date("Y-m-d")." 23:59:59"), 'pi_id desc',DEFAULT_OUTLET.'_palletizing_inspection','pi_id,pi_time,pi_item_number,pi_cases,pi_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'palletizing_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function cleaning_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; 
        $data['page_number'] = 1;
        $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ci_datetime >="=> date("Y-m-d")." 00:00:00","ci_datetime <="=>date("Y-m-d")." 23:59:59"), 'ci_id desc',DEFAULT_OUTLET.'_cleaning_inspection','ci_id,ci_datetime,ci_monitor_name,ci_circle,ci_last_product,ci_allergen_profile,ci_product_start,ci_allergen_second_profile,ci_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ci_datetime >="=> date("Y-m-d")." 00:00:00","ci_datetime <="=>date("Y-m-d")." 23:59:59"), 'ci_id desc',DEFAULT_OUTLET.'_cleaning_inspection','ci_id,ci_datetime,ci_monitor_name,ci_circle,ci_status',"1","0",'','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'cleaning_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function bulk_tub_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; 
        $data['page_number'] = 1;
        $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bi_datetime >="=> date("Y-m-d")." 00:00:00","bi_datetime <="=>date("Y-m-d")." 23:59:59"), 'bi_id desc',DEFAULT_OUTLET.'_bulk_tub_inspection','bi_id,bi_datetime,bi_initial,bi_packing_operator,bi_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bi_datetime >="=> date("Y-m-d")." 00:00:00","bi_datetime <="=>date("Y-m-d")." 23:59:59"), 'bi_id desc',DEFAULT_OUTLET.'_bulk_tub_inspection','bi_id,bi_datetime,bi_initial,bi_packing_operator,bi_status',"1","0",'','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'bulk_tub_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function bulk_form_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; 
        $data['page_number'] = 1;
        $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bfi_datetime >="=> date("Y-m-d")." 00:00:00","bfi_datetime <="=>date("Y-m-d")." 23:59:59"), 'bfi_id desc',DEFAULT_OUTLET.'_bulk_form_inspection','bfi_id,bfi_datetime,bfi_initial,bfi_item,bfi_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bfi_datetime >="=> date("Y-m-d")." 00:00:00","bfi_datetime <="=>date("Y-m-d")." 23:59:59"), 'bfi_id desc',DEFAULT_OUTLET.'_bulk_form_inspection','bfi_id,bfi_datetime,bfi_initial,bfi_item,bfi_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'bulk_form_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function recode_inspection() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data['total_pages'] = 0; 
        $data['page_number'] = 1;
        $data['limit'] = 20;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ri_datetime >="=> date("Y-m-d")." 00:00:00","ri_datetime <="=>date("Y-m-d")." 23:59:59"), 'ri_id desc',DEFAULT_OUTLET.'_recode_inspection','ri_id,ri_datetime,ri_initial,ri_source_item_no,ri_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ri_datetime >="=> date("Y-m-d")." 00:00:00","ri_datetime <="=>date("Y-m-d")." 23:59:59"), 'ri_id desc',DEFAULT_OUTLET.'_recode_inspection','ri_id,ri_datetime,ri_initial,ri_source_item_no,ri_status',"1","0",'','','')->num_rows();
        $data['inspection'] = $inspection;
        $data['view_file'] = 'recode_inspection';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function truck_inspection_detail() {
        $id = $this->input->post('id');
        $review_approval = $this->input->post('review_approval');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ti_id"=>$id), 'ti_id',DEFAULT_OUTLET.'_truck_inspection','ti_id,ti_monitor_name,ti_datetime,ti_invoice_no,ti_item_name,ti_suppler_name,ti_suppler_approve,ti_carrier_name,ti_truck_license,ti_trailer_license,ti_driver_license_info,ti_trailer_sealed,ti_trailer_locked,ti_signs_of_tampering,ti_truck_condition_acceptable,ti_product_condition,ti_product_temperature,ti_visual_verification,ti_allergen_verification,ti_contains_allergen,ti_expiration_date,ti_summery,ti_follow_up_action,ti_corrective_action,ti_status,ti_review,ti_review_datetime,ti_approve,ti_approve_datetime','1','1','','','')->result_array();
        $status = "";
        if(isset($data['inspection'][0]['ti_status']) && !empty($data['inspection'][0]['ti_status'])) {
            if($data['inspection'][0]['ti_status'] !='Complete') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '1') {
                    if($data['inspection'][0]['ti_status'] == 'Pending')
                        $status = "Review & Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($data['inspection'][0]['ti_status'] == 'Review')
                        $status = "Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($data['inspection'][0]['ti_status'] == 'Pending')
                        $status = "Reviewed";
                }
                else
                    $status = "";
            }
        }
        $data['status'] = $status;
        $this->load->view('truck_inspection_display',$data);
    }
    function shipping_inspection_detail() {
        $review_approval = $this->input->post('review_approval');
        $id = $this->input->post('id');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("si_id"=>$id), 'si_id',DEFAULT_OUTLET.'_shipping_inspection','si_id,si_monitor_name,si_checkin_time,si_sale_order_no,si_item_name,si_customer_name,si_carrier_name,si_truck_trailer_plate,si_driver_info,si_truck_set_temp,si_truck_reading_temp,si_truck_condition_acceptable,si_frozen_product_temp,si_refrigerated_product,si_first_product_surface_temp,si_last_product_surface_temp,si_product_condition_acceptable,si_sign_of_temparing,si_is_secured,si_seal_no,si_is_bol,si_inspection_summary,si_checkout_time,si_followup_action,si_corrective_action,si_status,si_review,si_review_datetime,si_approve,si_approve_datetime,si_line,si_shift,si_plant,si_lot_number_check,si_lot_number','1','1','','','')->result_array();
        $status = "";
        if(isset($data['inspection'][0]['si_status']) && !empty($data['inspection'][0]['si_status'])) {
            if($data['inspection'][0]['si_status'] !='Complete') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '1') {
                    if($data['inspection'][0]['si_status'] == 'Pending')
                        $status = "Review & Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($data['inspection'][0]['si_status'] == 'Review')
                        $status = "Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($data['inspection'][0]['si_status'] == 'Pending')
                        $status = "Reviewed";
                }
                else
                    $status = "";
            }
        }
        $data['status'] = $status;
        $this->load->view('shipping_inspection_detail',$data);
    }
    function palletizing_inspection_detail() {
        $id = $this->input->post('id');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("pi_id"=>$id), 'pi_id',DEFAULT_OUTLET.'_palletizing_inspection','pi_id,pi_time,pi_item_number,pi_cases,pi_used_by_date,pi_code_date,pi_initials,pi_status,pi_line,pi_shift,pi_plant,pi_pallet_number','1','1','','','')->result_array();
        $this->load->view('palletizing_inspection_detail',$data);
    }
    function cleaning_inspection_detail() {
        $review_approval = $this->input->post('review_approval');
        $id = $this->input->post('id');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ci_id"=>$id), 'ci_id',DEFAULT_OUTLET.'_cleaning_inspection','ci_id,ci_datetime,ci_monitor_name,ci_circle,ci_last_product,ci_allergen_profile,ci_product_start,ci_allergen_second_profile,ci_question1_answer,ci_question1_correct_answer,ci_question2_answer,ci_question2_correct_answer,ci_question3_answer,ci_question3_correct_answer,ci_question4_answer,ci_question4_correct_answer,ci_question5_answer,ci_question5_correct_answer,ci_question6_answer,ci_question6_correct_answer,ci_question7_answer,ci_question7_correct_answer,ci_question8_answer,ci_question8_correct_answer,ci_question9_answer,ci_question9_correct_answer,ci_question10_answer,ci_question10_correct_answer,ci_question11_answer,ci_question11_correct_answer,ci_question12_answer,ci_question12_correct_answer,ci_question13_answer,ci_question13_correct_answer,ci_question14_answer,ci_question14_correct_answer,ci_question15_answer,ci_question15_correct_answer,ci_question16_answer,ci_question16_correct_answer,ci_question17_answer,ci_question17_correct_answer,ci_question18_answer,ci_question18_correct_answer,ci_question19_answer,ci_question19_correct_answer,ci_question20_answer,ci_question20_correct_answer,ci_line,ci_shift,ci_plant,ci_status,ci_review,ci_review_datetime,ci_approve,ci_approve_datetime','1','1','','','')->result_array();
        $status = "";
        if(isset($data['inspection'][0]['ci_status']) && !empty($data['inspection'][0]['ci_status'])) {
            if($data['inspection'][0]['ci_status'] !='Complete') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '1') {
                    if($data['inspection'][0]['ci_status'] == 'Pending')
                        $status = "Review & Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($data['inspection'][0]['ci_status'] == 'Review')
                        $status = "Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($data['inspection'][0]['ci_status'] == 'Pending')
                        $status = "Reviewed";
                }
                else
                    $status = "";
            }
        }
        $data['status'] = $status;
        $this->load->view('cleaning_inspection_detail',$data);
    }
    function bulk_tub_inspection_detail() {
        $review_approval = $this->input->post('review_approval');
        $id = $this->input->post('id');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bi_id"=>$id), 'bi_id',DEFAULT_OUTLET.'_bulk_tub_inspection','bi_id,bi_datetime,bi_initial,bi_packing_operator,bi_product_name,bi_item_no,bi_pallet_no,bi_time_in_cooler,bi_time_out_cooler,bi_temperature,bi_corrective_action,bi_line,bi_shift,bi_plant,bi_status,bi_review,bi_review_datetime,bi_approve,bi_approve_datetime','1','1','','','')->result_array();
        $status = "";
        if(isset($data['inspection'][0]['bi_status']) && !empty($data['inspection'][0]['bi_status'])) {
            if($data['inspection'][0]['bi_status'] !='Complete') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '1') {
                    if($data['inspection'][0]['bi_status'] == 'Pending')
                        $status = "Review & Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($data['inspection'][0]['bi_status'] == 'Review')
                        $status = "Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($data['inspection'][0]['bi_status'] == 'Pending')
                        $status = "Reviewed";
                }
                else
                    $status = "";
            }
        }
        $data['status'] = $status;
        $this->load->view('bulk_tub_inspection_detail',$data);
    }
    function bulk_form_inspection_detail() {
        $review_approval = $this->input->post('review_approval');
        $id = $this->input->post('id');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bfi_id"=>$id), 'bfi_id',DEFAULT_OUTLET.'_bulk_form_inspection','bfi_id,bfi_datetime,bfi_initial,bfi_item,bfi_lotcode,bfi_expdate,bfi_time,bfi_allergen,bfi_quantity,bfi_pallet_no,bfi_line,bfi_shift,bfi_plant,bfi_review,bfi_review_datetime,bfi_approve,bfi_approve_datetime,bfi_status,bfi_date','1','1','','','')->result_array();
        $status = "";
        if(isset($data['inspection'][0]['bfi_status']) && !empty($data['inspection'][0]['bfi_status'])) {
            if($data['inspection'][0]['bfi_status'] !='Complete') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '1') {
                    if($data['inspection'][0]['bfi_status'] == 'Pending')
                        $status = "Review & Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($data['inspection'][0]['bfi_status'] == 'Review')
                        $status = "Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($data['inspection'][0]['bfi_status'] == 'Pending')
                        $status = "Reviewed";
                }
                else
                    $status = "";
            }
        }
        $data['status'] = $status;
        $this->load->view('bulk_form_inspection_detail',$data);
    }
    function Recode_inspection_detail() {
        $review_approval = $this->input->post('review_approval');
        $id = $this->input->post('id');
        $data['inspection'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ri_id"=>$id), 'ri_id',DEFAULT_OUTLET.'_recode_inspection','ri_id,ri_datetime,ri_initial,ri_source_item_no,ri_source_product_temperature,ri_source_brand_name,ri_source_product_name,ri_source_allergens,ri_source_case_used,ri_source_production_date,ri_source_nav_lot_code,ri_pack_item_no,ri_pack_brand_name,ri_pack_product_name,ri_pack_allergens,ri_pack_cases_made,ri_pack_exp_date,ri_comments,ri_line,ri_shift,ri_plant,ri_review,ri_review_datetime,ri_approve,ri_approve_datetime,ri_status,ri_selected_source','1','1','','','')->result_array();
        $status = "";
        if(isset($data['inspection'][0]['ri_status']) && !empty($data['inspection'][0]['ri_status'])) {
            if($data['inspection'][0]['ri_status'] !='Complete') {
                if($review_approval == '1' || $this->session->userdata['user_data']["role_id"] == '1') {
                    if($data['inspection'][0]['ri_status'] == 'Pending')
                        $status = "Review & Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '116') {
                    if($data['inspection'][0]['ri_status'] == 'Review')
                        $status = "Approved";
                }
                elseif($this->session->userdata['user_data']["role_id"] == '117') {
                    if($data['inspection'][0]['ri_status'] == 'Pending')
                        $status = "Reviewed";
                }
                else
                    $status = "";
            }
        }
        $data['status'] = $status;
        $this->load->view('recode_inspection_detail',$data);
    }
    function get_truck_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ti_datetime >="=> $startdate,"ti_datetime <="=>$enddate), 'ti_id',DEFAULT_OUTLET.'_truck_inspection','ti_id,ti_monitor_name,ti_datetime,ti_invoice_no,ti_item_name,ti_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ti_datetime >="=> $startdate,"ti_datetime <="=>$enddate), 'ti_id',DEFAULT_OUTLET.'_truck_inspection','ti_id,ti_monitor_name,ti_datetime,ti_invoice_no,ti_item_name,ti_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('truck_search',$data,TRUE);
    }
    function get_shipping_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("si_checkin_time >="=> $startdate,"si_checkin_time <="=>$enddate), 'si_id desc',DEFAULT_OUTLET.'_shipping_inspection','si_id,si_monitor_name,si_checkin_time,si_sale_order_no,si_item_name,si_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("si_checkin_time >="=>$startdate,"si_checkin_time <="=>$enddate), 'si_id desc',DEFAULT_OUTLET.'_shipping_inspection','si_id,si_monitor_name,si_checkin_time,si_sale_order_no,si_item_name,si_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('shipping_search',$data,TRUE);
    }
    function get_palletizing_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate = date('Y-m-d');
        $startdate = $startdate.' 00:00:00';
        if(empty($enddate))
            $enddate = date('Y-m-d');
        $enddate = $enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("pi_time >="=>$startdate,"pi_time <="=>$enddate), 'pi_id',DEFAULT_OUTLET.'_palletizing_inspection','pi_id,pi_time,pi_item_number,pi_cases,pi_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("pi_time >="=>$startdate,"pi_time <="=>$enddate), 'pi_id',DEFAULT_OUTLET.'_palletizing_inspection','pi_id,pi_time,pi_item_number,pi_cases,pi_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('palletizing_search',$data,TRUE);
    }
    function get_cleaning_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ci_datetime >="=>$startdate,"ci_datetime <="=>$enddate), 'ci_id desc',DEFAULT_OUTLET.'_cleaning_inspection','ci_id,ci_datetime,ci_monitor_name,ci_circle,ci_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ci_datetime >="=>$startdate,"ci_datetime <="=>$enddate), 'ci_id desc',DEFAULT_OUTLET.'_cleaning_inspection','ci_id,ci_datetime,ci_monitor_name,ci_circle,ci_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('cleaning_search',$data,TRUE);
    }
    function get_bulk_tub_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bi_datetime >="=> $startdate,"bi_datetime <="=>$enddate), 'bi_id desc',DEFAULT_OUTLET.'_bulk_tub_inspection','bi_id,bi_datetime,bi_initial,bi_packing_operator,bi_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bi_datetime >="=> $startdate,"bi_datetime <="=>$enddate), 'bi_id desc',DEFAULT_OUTLET.'_bulk_tub_inspection','bi_id,bi_datetime,bi_initial,bi_packing_operator,bi_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('bulk_tub_search',$data,TRUE);
    }
    function get_bulk_form_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bfi_datetime >="=> $startdate,"bfi_datetime <="=>$enddate), 'bfi_id desc',DEFAULT_OUTLET.'_bulk_form_inspection','bfi_id,bfi_datetime,bfi_initial,bfi_item,bfi_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("bfi_datetime >="=> $startdate,"bfi_datetime <="=>$enddate), 'bfi_id desc',DEFAULT_OUTLET.'_bulk_form_inspection','bfi_id,bfi_datetime,bfi_initial,bfi_item,bfi_status','1','0','','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('bulk_form_search',$data,TRUE);
    }
    function get_recode_search(){
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); $data['total_pages'] = 0;
        $inspection = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ri_datetime >="=> $startdate,"ri_datetime <="=>$enddate), 'ri_id desc',DEFAULT_OUTLET.'_recode_inspection','ri_id,ri_datetime,ri_initial,ri_source_item_no,ri_status',$data['page_number'],$data['limit'],'','','');
        if(!empty($inspection->result_array()))
            $data['total_pages'] = Modules::run('api/_get_specific_table_with_pagination_and_where',array("ri_datetime >="=> $startdate,"ri_datetime <="=>$enddate), 'ri_id desc',DEFAULT_OUTLET.'_recode_inspection','ri_id,ri_datetime,ri_initial,ri_source_item_no,ri_status',"1","0",'','','')->num_rows();
        $data['inspection'] = $inspection;
        echo $this->load->view('recode_search',$data,TRUE);
    }
    function shipping_inspection_status() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved") {
                Modules::run('api/update_specific_table',array("si_id"=>$id),array("si_review"=>$this->session->userdata['user_data']['user_id'],'si_review_datetime'=>date("Y-m-d H:i:s"),'si_approve'=>$this->session->userdata['user_data']['user_id'],'si_approve_datetime'=>date("Y-m-d H:i:s"),'si_status'=>'Complete'),DEFAULT_OUTLET.'_shipping_inspection');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("si_id"=>$id),array("si_review"=>$this->session->userdata['user_data']['user_id'],'si_review_datetime'=>date("Y-m-d H:i:s"),'si_status'=>'Review'),DEFAULT_OUTLET.'_shipping_inspection');
            }
            else{
                $status = "";
            }
        }
    }
    function truck_inspection_status() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved" ) {
                Modules::run('api/update_specific_table',array("ti_id"=>$id),array("ti_review"=>$this->session->userdata['user_data']['user_id'],'ti_review_datetime'=>date("Y-m-d H:i:s"),'ti_approve'=>$this->session->userdata['user_data']['user_id'],'ti_approve_datetime'=>date("Y-m-d H:i:s"),'ti_status'=>'Complete'),DEFAULT_OUTLET.'_truck_inspection');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("si_id"=>$id),array("ti_review"=>$this->session->userdata['user_data']['user_id'],'ti_review_datetime'=>date("Y-m-d H:i:s"),'ti_status'=>'Review'),DEFAULT_OUTLET.'_truck_inspection');
            }
            else{
                $status = "";
            }
        }
    }
    function cleaning_inspection_status() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved") {
                Modules::run('api/update_specific_table',array("ci_id"=>$id),array("ci_review"=>$this->session->userdata['user_data']['user_id'],'ci_review_datetime'=>date("Y-m-d H:i:s"),'ci_approve'=>$this->session->userdata['user_data']['user_id'],'ci_approve_datetime'=>date("Y-m-d H:i:s"),'ci_status'=>'Complete'),DEFAULT_OUTLET.'_cleaning_inspection');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("ci_id"=>$id),array("ci_review"=>$this->session->userdata['user_data']['user_id'],'ci_review_datetime'=>date("Y-m-d H:i:s"),'ci_status'=>'Review'),DEFAULT_OUTLET.'_cleaning_inspection');
            }
            else{
                $status = "";
            }
        }
    }
    function bulk_tub_inspection_status() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved") {
                Modules::run('api/update_specific_table',array("bi_id"=>$id),array("bi_review"=>$this->session->userdata['user_data']['user_id'],'bi_review_datetime'=>date("Y-m-d H:i:s"),'bi_approve'=>$this->session->userdata['user_data']['user_id'],'bi_approve_datetime'=>date("Y-m-d H:i:s"),'bi_status'=>'Complete'),DEFAULT_OUTLET.'_bulk_tub_inspection');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("bi_id"=>$id),array("bi_review"=>$this->session->userdata['user_data']['user_id'],'bi_review_datetime'=>date("Y-m-d H:i:s"),'bi_status'=>'Review'),DEFAULT_OUTLET.'_bulk_tub_inspection');
            }
            else{
                $status = "";
            }
        }
    }
	function bulk_form_inspection_status() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved") {
                Modules::run('api/update_specific_table',array("bfi_id"=>$id),array("bfi_review"=>$this->session->userdata['user_data']['user_id'],'bfi_review_datetime'=>date("Y-m-d H:i:s"),'bfi_approve'=>$this->session->userdata['user_data']['user_id'],'bfi_approve_datetime '=>date("Y-m-d H:i:s"),'bfi_status'=>'Complete'),DEFAULT_OUTLET.'_bulk_form_inspection');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("bfi_id"=>$id),array("bfi_review"=>$this->session->userdata['user_data']['user_id'],'bfi_review_datetime'=>date("Y-m-d H:i:s"),'bfi_status'=>'Review'),DEFAULT_OUTLET.'_bulk_form_inspection');
            }
            else{
                $status = "";
            }
        }
    }
    function recode_inspection_status() {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved") {
                Modules::run('api/update_specific_table',array("ri_id"=>$id),array("ri_review"=>$this->session->userdata['user_data']['user_id'],'ri_review_datetime'=>date("Y-m-d H:i:s"),'ri_approve'=>$this->session->userdata['user_data']['user_id'],'ri_approve_datetime'=>date("Y-m-d H:i:s"),'ri_status'=>'Complete'),DEFAULT_OUTLET.'_recode_inspection');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("ri_id"=>$id),array("ri_review"=>$this->session->userdata['user_data']['user_id'],'ri_review_datetime'=>date("Y-m-d H:i:s"),'ri_status'=>'Review'),DEFAULT_OUTLET.'_recode_inspection');
            }
            else{
                $status = "";
            }
        }
    }
    function get_filter_result(){
         $startdate = $this->input->post('startdate');
         $enddate = $this->input->post('enddate');
         $assign_type = $this->input->post('assign_type');
         $data['assign_type']=$assign_type;
         if($assign_type=='active_checks'){
             $where['assign_status']="Open";
         }elseif($assign_type=='overdue_checks'){
             $where['assign_status']="OverDue";
         }elseif($assign_type=='pending_review'){
             $where['assign_status']="Review";
         }
         elseif($assign_type=='pending_approval'){
             $where['assign_status']="Approval";
         }
         elseif($assign_type=='completed_checks'){
             $where['assign_status']="Completed";
         }
        if(isset($startdate) && !empty($startdate))
             $where['assignments.start_datetime >=']=date('Y-m-d 00:00',strtotime($startdate));
        if(isset($enddate) && !empty($enddate))
             $where['assignments.end_datetime <=']=date('Y-m-d 23:59',strtotime($enddate));
        $data['news'] = $this->_get('id desc',$where);
        
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
        echo $this->load->view('post_listing',$data,TRUE);
    }
    function get_check_listing_filter_data() {
        $startdate = $this->input->post('startdate');
        $searh = $this->input->post('like');
        $data['like_search'] = $like_search = '';
        if(!empty($searh))
            $data['like_search'] = $like_search['LOWER(product_checks.checkname)'] = $searh;
        $enddate = $this->input->post('enddate');
        $data['assign_status'] = $assign_status = $this->input->post('assign_status');
        $checking = false;
        if(empty($startdate) && empty($enddate) && $data['assign_status'] =='overdue_checks')
            $checking = true;
        if(empty($startdate))
            $startdate=date('Y-m-d');
        $startdate=$startdate.' 00:00:00';
        if(empty($enddate))
            $enddate=date('Y-m-d');
        $enddate=$enddate.' 23:59:59';
        $startdate = date('Y-m-d H:i:s', strtotime($startdate));
        $enddate = date('Y-m-d H:i:s', strtotime($enddate));
        $data['page_number'] = $this->input->post('page_number');
        if(empty($data['page_number']))
            $data['page_number'] = '1';
        $data['limit'] = $this->input->post('limit'); 
        $data['total_pages'] = 0;
        if($assign_status=='active_checks'){
             $where['assign_status']="Open";
        }
        elseif($assign_status=='overdue_checks'){
            $where['assign_status']="OverDue";
        }
        else
            $where = array();
        if($checking == false) {
            $where['assignments.start_datetime >=']= $startdate;
            $where['assignments.end_datetime <=']= $enddate;
        }
        $data['news'] = $this->get_checklisting_data($where, 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype',$data['page_number'],$data['limit'],'','','',$like_search);
        if(!empty($data['news']->result_array()))
            $data['total_pages'] = $this->get_checklisting_data($where, 'assign_id','assign_id',DEFAULT_OUTLET,'assignments.* ,product_checks.checkname,product_checks.checktype','1','0','','','',$like_search)->num_rows();
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups'] = $groups;
    	$data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id !="=>"12"), 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
        echo $this->load->view('checklist_ajax_load',$data,TRUE);
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
    function change_approval_status_for_assignment(){
        $assign_id = $this->input->post('assign_id');
        $review_comments=$this->input->post('review_comments');
        $both_permission=$this->input->post('both_permission');
        $where['assign_id']=$assign_id;
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        if($both_permission == true) {
            $data = array('assign_status' =>'Completed',"approval_user"=>$this->session->userdata['user_data']['user_id'],"approval_datetime"=>date("Y-m-d H:i:s"),"review_user"=>$this->session->userdata['user_data']['user_id'],"review_datetime"=>date("Y-m-d H:i:s"),"review_comments"=>$review_comments);
        }
        else {
            $data = array('assign_status' =>'Approval',"review_user"=>$this->session->userdata['user_data']['user_id'],"review_user"=>$this->session->userdata['user_data']['user_id'],"review_datetime"=>date("Y-m-d H:i:s"),"review_comments"=>$review_comments);
            /////////// notification code umar start///////////
            $assign_name = "Assignment Name";
            $assign_detail = Modules::run('api/_get_specific_table_with_pagination',array("assign_id"=>$assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','checkid','1','1')->result_array();
            if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid'])) {
                $product_checks_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_detail[0]['checkid']),'id desc',DEFAULT_OUTLET.'_product_checks','checkname','1','1')->result_array();
                if(isset($product_checks_detail[0]['checkname']) && !empty($product_checks_detail[0]['checkname']))
                    $assign_name = $product_checks_detail[0]['checkname'];
            }
            $review_group = Modules::run('api/_get_specific_table_with_pagination',array("assign_id" =>$assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','approval_team','1','1')->result_array();
            if(isset($review_group[0]['approval_team']) && !empty($review_group[0]['approval_team'])) {
                $fcm_token = Modules::run('api/_get_specific_table_with_pagination_and_where',array("fcm_token !="=>"",'status'=>'1'),'id desc','users','fcm_token','1','0','(`second_group`="'.$review_group[0]['approval_team'].'" or `group`="'.$review_group[0]['approval_team'].'")','','')->result_array();
                $user_name = "";
                $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$this->session->userdata['user_data']['user_id']),'id desc','users','user_name','1','1')->result_array();
                if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name']))
                    $user_name = $user_detail[0]['user_name'];
                if(!empty($fcm_token)) {
                    $token = array();
                    foreach ($fcm_token as $key => $value):
                        $token[] = $value['fcm_token'];
                    endforeach;
                    $fcm_token = $token;
                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,$assign_name." has been reviewed by ".$user_name.", please review and approve the provided information.",false,false,"");
                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                }
                $users_id = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','id','1','0','(`second_group`="'.$review_group[0]['approval_team'].'" or `group`="'.$review_group[0]['approval_team'].'")','','')->result_array();
                if(!empty($users_id)) {
                    foreach ($users_id as $key => $ui):
                        Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$ui['id'],"outlet_id"=>DEFAULT_OUTLET,"notification_message"=>$assign_name." has been reviewed by ".$user_name.", please review and approve the provided information.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                    endforeach;
                }
            }
            /////////// notification code umar end///////////
        }
        $status = $this->update_assignment_status($where, $data);
        redirect(ADMIN_BASE_URL.'assignments/pending_review');
    }
     function change_completed_status_for_assignment(){
        $assign_id = $this->input->post('assign_id');
        $appoval_comments = $this->input->post('appoval_comments');
        $where['assign_id']=$assign_id;
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
        $data = array('assign_status' =>'Completed',"approval_user"=>$this->session->userdata['user_data']['user_id'],"approval_datetime"=>date("Y-m-d H:i:s"));
        /////////// notification code umar start///////////
        /*$assign_name = "Assignment Name";
        $assign_detail = Modules::run('api/_get_specific_table_with_pagination',array("assign_id"=>$assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','checkid','1','1')->result_array();
        if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid'])) {
            $product_checks_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_detail[0]['checkid']),'id desc',DEFAULT_OUTLET.'_product_checks','checkname','1','1')->result_array();
            if(isset($product_checks_detail[0]['checkname']) && !empty($product_checks_detail[0]['checkname']))
                $assign_name = $product_checks_detail[0]['checkname'];
        }
        $review_group = Modules::run('api/_get_specific_table_with_pagination',array("assign_id" =>$assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','approval_team','1','1')->result_array();
        if(isset($review_group[0]['approval_team']) && !empty($review_group[0]['approval_team'])) {
            $fcm_token = Modules::run('api/_get_specific_table_with_pagination_and_where',array("fcm_token !="=>"",'status'=>'1'),'id desc','users','fcm_token','1','0','(`second_group`="'.$review_group[0]['approval_team'].'" or `group`="'.$review_group[0]['approval_team'].'")','','')->result_array();
            $user_name = "";
            $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$this->session->userdata['user_data']['user_id']),'id desc','users','user_name','1','1')->result_array();
            if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name']))
                $user_name = $user_detail[0]['user_name'];
            if(!empty($fcm_token)) {
                $token = array();
                foreach ($fcm_token as $key => $value):
                    $token[] = $value['fcm_token'];
                endforeach;
                $fcm_token = $token;
                $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,$assign_name." has been reviewed by ".$user_name.", please review and approve the provided information.",false,false,"");
                Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
            }
            $users_id = Modules::run('api/_get_specific_table_with_pagination_and_where',array(),'id desc','users','id','1','0','(`second_group`="'.$review_group[0]['approval_team'].'" or `group`="'.$review_group[0]['approval_team'].'")','','')->result_array();
            if(!empty($users_id)) {
                foreach ($users_id as $key => $ui):
                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$ui['id'],"outlet_id"=>DEFAULT_OUTLET,"notification_message"=>$assign_name." has been reviewed by ".$user_name.", please review and approve the provided information.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                endforeach;
            }
        }*/
        /////////// notification code umar end///////////
        $status = $this->update_assignment_status($where, $data);
        redirect(ADMIN_BASE_URL.'assignments/pending_approval');
    }
    function get_reassignment_detail() {
        $data['selected_type'] = 'group';
        $assign = $this->input->post('assign');
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        $selected = 0;
        if(!empty($type) && $type =='edit') {
            $selected = $this->input->post('group');
            if(empty($selected)) {
                $data['selected_type'] ='user';
                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id" =>DEFAULT_OUTLET,"id"=>$user_id),'id desc','id','users','group','1','0','','','')->result_array();
                if(isset($user_detail[0]['group']) && !empty($user_detail[0]['group']))
                    $selected = $user_detail[0]['group'];
            }
        }
        else{
            $selected_group = Modules::run('api/_get_specific_table_with_pagination',array('assign_id'=>$assign), 'assign_id desc',DEFAULT_OUTLET.'_assignments','inspection_team','1','0')->result_array();
            if(isset($selected_group[0]['inspection_team']) && !empty($selected_group[0]['inspection_team']))
                $selected = $selected_group[0]['inspection_team'];
        }
        $data['groups'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['users'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id" =>DEFAULT_OUTLET,"status"=>"1"),'id desc','id','users','id,first_name,last_name','1','0','(`group` = "'.$selected.'" OR `group` = "'.$selected.'")','','')->result_array();
        $data['assign_group'] = $selected;
        $data['assign_id'] = $assign;
        $data['user_id'] = $user_id;
        $this->load->view('reassign_detail',$data);
    }
    function get_group_users(){
        $selected = $this->input->post('group');
        $data['users'] = array();
        if(!empty($selected)) {
            $data['users'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id" =>DEFAULT_OUTLET,"status"=>"1"),'id desc','id','users','id,first_name,last_name','1','0','(`group` = "'.$selected.'" OR `group` = "'.$selected.'")','','')->result_array();
        }
        $data['type'] = 'onlyuser';
        $this->load->view('reassign_detail',$data);
    }
    function check_again_for_assignment(){
        $data['assign_id'] = $assign_id = $this->input->post('assign_id');
        $data['check_id'] = $check_id = $this->input->post('check_id');
        $data['reassign_id'] = $this->input->post('reassign_id');
        $data['question'] = array();
        $data['reassign_status'] = '0';
        if(!empty($check_id)) {
            $question_condition['checkid'] = $check_id;
            $assignment_detail = Modules::run('api/_get_specific_table_with_pagination',array('assign_id'=>$assign_id), 'assign_id desc',DEFAULT_OUTLET.'_assignments','product_id','1','0')->result_array();
            if(isset($assignment_detail[0]['product_id']) && !empty($assignment_detail[0]['product_id']))
                $question_condition['assignment_id'] = $assign_id;
            $data['question'] = Modules::run('api/_get_specific_table_with_pagination',$question_condition, 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question_id,question','1','0')->result_array();
            if(!empty($data['reassign_id'])) {
                $reassign_detail = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$data['reassign_id']), 'assign_ans_id desc',DEFAULT_OUTLET.'_assignment_answer','assign_ans_id','1','0')->num_rows();
                if(!empty($reassign_detail))
                    $data['reassign_status'] = '1';
            }
        }
         /////////////////code by asad////////////
        $wherre['reassign_id']=$assign_id;
        $selected='';
        $editable=false;
        $reassign_data= Modules::run('api/_get_specific_table_with_pagination',$wherre, 'assign_id desc',DEFAULT_OUTLET.'_assignments','inspection_team,reassign_user,assign_id','1','0')->result_array();
        if(isset($reassign_data) && !empty($reassign_data)){
            $rq_assign_id=$reassign_data[0]['assign_id'];

            $editable=TRUE;
            if(!empty($reassign_data[0]['inspection_team'])){
                $selected="group";
                $group_id=$reassign_data[0]['inspection_team'];
                $data['assign_group']=$reassign_data[0]['inspection_team'];

            }
            elseif(!empty($reassign_data[0]['reassign_user'])){
                $selected="user";$editable=TRUE;
                $data['selected_user']=$reassign_data[0]['reassign_user'];
                if(empty($group_id)){
                     $group_data= Modules::run('api/_get_specific_table_with_pagination_and_where',array(),'id desc','users','group','1','0',array('id'=> $data['selected_user']),'','')->result_array();
                     $group_id=$group_data[0]['group'];
                     $data['assign_group']=$group_id;
                }

            }
            $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
            $data['groups']=$groups;
            $data['assign_group_users']= array();
                if(!empty($group_id)) {
                    $data['assign_group_users']= Modules::run('api/_get_specific_table_with_pagination_and_where',array(),'id desc','users','id,first_name,last_name','1','0','(`second_group`="'.$group_id.'" or `group`="'.$group_id.'")','','')->result_array();
                }
                 $data['arr_question'] = Modules::run('api/_get_specific_table_with_pagination',array('rq_assign_id'=>$rq_assign_id), 'rq_id desc',DEFAULT_OUTLET.'_reassign_questions','rq_question_id','1','0')->result_array();

        }
        $data['editable']=$editable;
        $data['selected']=$selected;
        
        /////////////end asad
        $data['selected']=$selected;
        $data['assign_id'] = $assign_id;
        $data['shows'] = 'heading';
        echo $this->load->view('checkagain_modal',$data,TRUE);
    }
    function get_all_groups() {
        $data['editable']=false;
        $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['groups']=$groups;
        $data['shows'] = 'group';
        echo $this->load->view('checkagain_modal',$data,TRUE);
    }
    function get_all_group_users() {
        $data['editable']=false;
        $group_id  = $this->input->post('group_id');
        $data['assign_group_users']= array();
        if(!empty($group_id)) {
            $data['assign_group_users']= Modules::run('api/_get_specific_table_with_pagination_and_where',array(),'id desc','users','id,first_name,last_name','1','0','(`second_group`="'.$group_id.'" or `group`="'.$group_id.'")','','')->result_array();
        }
        $data['shows'] = 'user';
        echo $this->load->view('checkagain_modal',$data,TRUE);
    }
    function submit_recheck() {
        $status = 'error';
        $message = "something went wrong";
        $assign_id = $this->input->post('assign_id');
        $check_id = $this->input->post('check_id');
        $type = $this->input->post('responsible_type');
        $team = $this->input->post('responsible_team');
        $user = $this->input->post('responsible_user');
        $questions = $this->input->post('groups');
        if(!empty($assign_id) && !empty($check_id)) {
            date_default_timezone_set("Asia/karachi");
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(!empty($timezone)) {
                if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                    date_default_timezone_set($timezone[0]['timezones']);
            }
            $currentDate = strtotime(date("Y-m-d H:i:s"));
            $check_detail = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_product_checks','id,frequency,review_team,approval_team','1','0')->result_array();
            if(!empty($check_detail)) {
                $start_date = $end_date = $start_time = $endtime = "";
                if(isset($check_detail[0]['frequency']) && !empty($check_detail[0]['frequency'])) {
                    if(strtolower($check_detail[0]['frequency']) == strtolower('30 Mins')) {
                        $start_date = $end_date = date('Y-m-d', $currentDate);
                        if(date('i', $currentDate) <= 30) {
                            $start_time = date('H', $currentDate).':30:00';
                            $endtime = date('H', strtotime('1 hour')).':00:00';
                        }
                        else{
                            $start_time = date('H', strtotime('1 hour')).':00:00';
                            $endtime = date('H', strtotime('1 hour')).':30:00';
                        }
                        if(date('H', $currentDate) >  date('H', $start_time)) {
                            $start_date = $end_date = date($start_date, strtotime('1 day'));
                        }
                    }
                    elseif(strtolower($check_detail[0]['frequency']) == strtolower('hourly')) {
                        $start_date = $end_date = date('Y-m-d', $currentDate);
                        $start_time = date('H', strtotime('1 hour')).':00:00';
                        $endtime = date('H', strtotime('2 hour')).':00:00';
                        if(date('H', $currentDate) >  date('H', $start_time)) {
                            $start_date = $end_date = date($start_date, strtotime('1 day'));
                        }
                    }
                    elseif(strtolower($check_detail[0]['frequency']) == strtolower('Daily')) {
                        $start_date = $end_date = date($start_date, strtotime('1 day'));
                        $start_time = '00:00:00';
                        $endtime = '00:00:00';
                    }
                    elseif(strtolower($check_detail[0]['frequency']) == strtolower('Weekly')) {
                        $start_date = date('Y-m-d', strtotime('next monday'));
                        $end_date = date($start_date, strtotime('7 day'));
                        $start_time = '00:00:00';
                        $endtime = '00:00:00';
                    }
                    if($type =='user')
                        $team = '0';
                    $new_assign_id = Modules::run('api/insert_into_specific_table',array("checkid"=>$check_id,"inspection_team"=>$team,"review_team"=>$check_detail[0]['review_team'],"approval_team"=>$check_detail[0]['approval_team'],"outlet_id"=>DEFAULT_OUTLET,"start_date"=>$start_date,"end_date"=>$end_date,"start_time"=>$start_time,"end_time"=>$endtime,"assign_status"=>'Open',"reassign_id"=>$assign_id,"reassign_user"=>$user),DEFAULT_OUTLET.'_assignments');
                    if(!empty($questions)) {
                        foreach ($questions as $key => $qa):
                            Modules::run('api/insert_into_specific_table',array("rq_assign_id"=>$new_assign_id,"rq_question_id"=>$qa),DEFAULT_OUTLET.'_reassign_questions');
                        endforeach;
                    }
                    $status  = 'success';
                    $message = "Reassignmen has been created";
                    
                }
                else
                    $message = "Frequency can not be defined";
            }
            else
                $message = "Invalid assignment";
        }
        else
            $message = "Invalid assignment";
        $this->session->set_flashdata('message', 'Assignment Re assigned successfully');
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'assignments/pending_review');  
    }
    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
        $data['function'] = $this->input->post('function');
        $questions=$this->get_question_for_assignment($update_id)->result_array();
        $i=0;
        foreach ($questions as $key => $value):
            $arr_questions[$i]['question']=$value['question'];
            $arr_questions[$i]['type']=$value['type'];
            if($value['type']=='Choice') {
                $arr_answers=$this->get_question_answer_detail($value['question_id'],$update_id)->result_array();
                if(isset($arr_answers) && !empty($arr_answers)) {
                    $arr_questions[$i]['choice_type']=$arr_answers[0]['possible_answer'].'/'.$arr_answers[1]['possible_answer'];
                }
            
            }
            elseif($value['type']=='Range') {
                $arr_answers=$this->get_question_answer_detail($value['question_id'],$update_id)->result_array();
                if(isset($arr_answers) && !empty($arr_answers)){
                    $arr_questions[$i]['min']=$arr_answers[0]['min'];
                    $arr_questions[$i]['max']=$arr_answers[0]['max'];                
                } 
            }
            $i=$i+1;
        endforeach;
        $data['questions']=$arr_questions;
        $data['assign_detail']=$this->get_qa_checks_detail($update_id)->result_array();
        $data['checkname']=$data['assign_detail'][0]['checkname'];
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }
    
    function pending_review_detail() {
        $update_id = $this->input->post('id');
        $data['reviewable']=TRUE;
        $data['assignment_detailid']=$update_id ;
        $data['function'] = $this->input->post('function');
        $data['both_permission'] = $this->input->post('review_approval');
        $data['questions'] = $this->get_assignment_question_detail(array("assignment_answer.assignment_id"=>$update_id), 'assign_ans_id desc','assign_ans_id','assignment_answer.question_id,assignment_answer.answer_id,assignment_answer.comments,assignment_answer.range,assignment_answer.is_acceptable,assignment_answer.given_answer,assignment_answer.answer_type,checks_questions.question','1','0','','','')->result_array();
        $data['assign_detail']=$this->get_qa_checks_detail($update_id)->result_array();
        $data['checkname']=$data['assign_detail'][0]['checkname'];
        $data['update_id'] = $update_id;
        $data['datacomment']=$this->input->post('datacomment');
        $data['is_reasigned']=False;
        $wherre['reassign_id']=$update_id;
        $data['reassign_data'] = $reassign_data= Modules::run('api/_get_specific_table_with_pagination',$wherre, 'assign_id desc',DEFAULT_OUTLET.'_assignments','inspection_team,reassign_user,assign_id,assign_status','1','0')->result_array();
        if(isset($reassign_data) && !empty($reassign_data)){
            $data['is_reasigned']=TRUE;
            $data['reviewable']=False;
            $data['reassign_data']=$reassign_data;
            $reassign_id=$reassign_data[0]['assign_id'];
            $data['again_question'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("rq_assign_id"=>$reassign_id),'rq_id desc','rq_id',DEFAULT_OUTLET.'_reassign_questions','rq_question_id,rq_assign_id','1','0','','','')->result_array();
            if($reassign_data[0]['assign_status']=="Review") {
                $data['reviewable']=TRUE;
                $data['reassign_questions'] = $this->get_assignment_question_detail(array("assignment_answer.assignment_id"=>$reassign_id), 'assign_ans_id desc','assign_ans_id','assignment_answer.question_id,assignment_answer.answer_id,assignment_answer.comments,assignment_answer.range,assignment_answer.is_acceptable,assignment_answer.answer_type,checks_questions.question','1','0','','','')->result_array();
            }
        }
        $sixten_groups = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("role"=>'116'),'id desc','id',DEFAULT_OUTLET.'_groups','id','1','0','','','')->result_array();
        $seventen_groups = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("role"=>'117'),'id desc','id',DEFAULT_OUTLET.'_groups','id','1','0','','','')->result_array();
        if(!empty($sixten_groups) && !empty($seventen_groups)){
            $counter= 0;$text="";
            foreach ($sixten_groups as $key => $si):
                foreach ($seventen_groups as $key => $sg):
                    if(empty($text))
                        $text = '(`group`="'.$si['id'].'" AND `second_group`="'.$sg['id'].'") OR (`second_group`="'.$si['id'].'" AND `group`="'.$sg['id'].'")';
                    else
                        $text = $text.' OR (`group`="'.$si['id'].'" AND `second_group`="'.$sg['id'].'") OR (`second_group`="'.$si['id'].'" AND `group`="'.$sg['id'].'")';
                endforeach;
            endforeach;
            if(!empty($text)) {
                $text = '('.$text.')';
                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$this->session->userdata['user_data']['user_id']),'id desc','id,user_name','users','id','1','1',$text,'','')->result_array();
                if(!empty($user_detail))
                    $review_approval = true;
            }
        }
        $data['review_approval'] = $review_approval;
        $this->load->view('pending_review_detail', $data);
    }
    function static_checks_status() {
        $id = $this->input->post('id');
        $txt = $this->input->post('txt');
        if(!empty($id) && !empty($txt)) {
            if($txt == "Review & Approved" || $txt=="Approved") {
                Modules::run('api/update_specific_table',array("assign_id"=>$id),array("review_user"=>$this->session->userdata['user_data']['user_id'],'review_datetime'=>date("Y-m-d H:i:s"),'approval_user'=>$this->session->userdata['user_data']['user_id'],'approval_datetime'=>date("Y-m-d H:i:s"),'assign_status'=>'Approved'),DEFAULT_OUTLET.'_static_assignments');
            }
            elseif($txt == "Reviewed") {
                Modules::run('api/update_specific_table',array("assign_id"=>$id),array("review_user"=>$this->session->userdata['user_data']['user_id'],'review_datetime'=>date("Y-m-d H:i:s"),'assign_status'=>'Reviewed'),DEFAULT_OUTLET.'_static_assignments');
            }
            else{
                $status = "";
            }
        }
    }
///////////////////////////     HELPER FUNCTIONS    ////////////////////
     function update_assignment_status($where,$data) {
        $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->update_assignment_status($where,$data);
        return $query;
    }
    function get_question_for_assignment($assign_id) {
        $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->get_question_for_assignment($assign_id);
        return $query;
    }
    function get_question_answer_detail($question_id,$assign_id){
        $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->get_question_answer_detail($question_id,$assign_id);
        return $query;
    }
    function get_qa_checks_detail($assign_id) {
        $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->get_qa_checks_detail($assign_id);
        return $query;
    }

    function _get($order_by,$where) {
        $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->_get($order_by,$where);
        return $query;
    }
    function get_checklisting_data($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having='',$like=''){
        $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->get_checklisting_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having,$like);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_assignments');
        return $this->mdl_assignments->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_assignments');
        return $this->mdl_assignments->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_assignments');
        $this->mdl_assignments->_update($arr_col, $data);
    }
    function get_assignment_question_detail($cols, $order_by,$group_by='',$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_assignments');
        $query = $this->mdl_assignments->get_assignment_question_detail($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
}