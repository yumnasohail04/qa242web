<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Static_form extends MX_Controller
{

    function __construct() {
    parent::__construct();
    date_default_timezone_set("Asia/karachi");
    $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
        date_default_timezone_set($timezone[0]['timezones']);

    }

  
    function index() {
        $this->manage();
    }

    function manage() {
        $data['static_form'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sf_delete_status"=>'0'),'sf_id desc','sf_id',DEFAULT_OUTLET.'_static_form','sf_id,sf_name,sf_start_datetime,sf_end_datetime,sf_reviewer,sf_approver,sf_status','1','0','','','');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $data['groups'] = Modules::run('api/_get_specific_table_with_pagination',array('status'=>'1'), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $update_id = $this->uri->segment(4);
        $data['selected_program'] = $data['inspection_team'] = array();
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $data['inspection_team'] = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$update_id), 'sci_id desc',DEFAULT_OUTLET.'_static_checks_inspection','sci_team_id','1','0')->result_array();
            $data['selected_program'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("spt_check_id"=>$update_id),'spt_id desc','spt_id',DEFAULT_OUTLET.'_static_program_type','spt_program_id','1','0','','','')->result_array();
        } 
        else
            $data['news'] = $this->_get_data_from_post();
        $data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id !=" => "12"), 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit() {
        $program_id = $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $current_status = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sf_id'=>$update_id),'sf_id desc','sf_id',DEFAULT_OUTLET.'_static_form','sf_status','1','1','','','')->row_array();
            if(empty($data['is_dates']) && $current_status['sf_status'] == '1') {
                $data['sf_end_datetime'] = date('Y-m-d H:i:s', strtotime('+18 years', strtotime(date("Y-m-d H:i:s"))));
            }
            Modules::run('api/update_specific_table',array("sf_id"=>$update_id),$data,DEFAULT_OUTLET.'_static_form');
            Modules::run('api/delete_from_specific_table',array("sci_check_id"=>$update_id),DEFAULT_OUTLET."_static_checks_inspection");
            $this->session->set_flashdata('message', 'Data Updated');
        }
        else {
            $program_id = $update_id = Modules::run('api/insert_into_specific_table',$data,DEFAULT_OUTLET.'_static_form');
            $this->session->set_flashdata('message', 'Check Submitted');
        }
        $inspection_team = $this->input->post('inspection_team');
        if(!empty($inspection_team)) {
            foreach ($inspection_team as $key => $it):
                Modules::run('api/insert_or_update',array("sci_check_id"=>$update_id,"sci_team_id"=>$it),array("sci_check_id"=>$update_id,"sci_team_id"=>$it),DEFAULT_OUTLET.'_static_checks_inspection');
            endforeach;
        }
        if(!empty($program_id) && is_numeric($program_id)) {
            $program_types = $this->input->post('program_type');
            $previous_program = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('spt_check_id'=>$program_id),'spt_id desc','spt_id',DEFAULT_OUTLET.'_static_program_type','spt_id,spt_program_id','1','0','','','')->result_array();
            if(!empty($previous_program)) {
                foreach ($previous_program as $pn_key => $pp):
                    if(empty(in_array($pp['spt_program_id'], $program_types))) {
                        Modules::run('api/delete_from_specific_table',array("spt_id"=>$pp['spt_id']),DEFAULT_OUTLET.'_static_program_type');
                    }
                endforeach;
            }
            if(!empty($program_types)) {
                foreach ($program_types as $pt_key => $pt):
                    $checking = array_search($pt, array_column($previous_program, 'spt_program_id'));
                    if(!is_numeric($checking)) {
                        Modules::run('api/insert_into_specific_table',array("spt_check_id"=>$update_id,"spt_program_id"=>$pt,'spt_status'=>'1'),DEFAULT_OUTLET.'_static_program_type');
                    }
                endforeach;
            }
        }
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'static_form');  
    }
    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('sf_status' => $status);
        if($status == 1) {
            $check_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sf_id'=>$id),'sf_id desc','sf_id',DEFAULT_OUTLET.'_static_form','sf_start_datetime,sf_end_datetime','1','0','','','')->result_array();
            $sf_start_datetime = date("Y-m-d H:i:s");
            $sf_end_datetime = date('Y-m-d H:i:s', strtotime('+18 years'));
            if(!empty($check_detail)) {
                if(isset($check_detail[0]['sf_start_datetime']) && !empty($check_detail[0]['sf_start_datetime'])) 
                    if($check_detail[0]['sf_start_datetime'] != '0000-00-00 00:00:00')
                        $sf_start_datetime = $check_detail[0]['sf_start_datetime'];
                if(isset($check_detail[0]['sf_end_datetime']) && !empty($check_detail[0]['sf_end_datetime']))
                    if($check_detail[0]['sf_end_datetime'] != '0000-00-00 00:00:00')
                        $sf_end_datetime = $check_detail[0]['sf_end_datetime'];

            }
            $data['sf_start_datetime'] = $sf_start_datetime;
            $data['sf_end_datetime'] = $sf_end_datetime;
        }
        Modules::run('api/update_specific_table',array("sf_id"=>$id),$data,DEFAULT_OUTLET.'_static_form');
        echo $status;
    }
    function detail() {
        $update_id = $this->input->post('id');
        $data['static_form'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sf_status'=>'1',"sf_delete_status"=>'0',"sf_id"=>$update_id),'sf_id desc','sf_id',DEFAULT_OUTLET.'_static_form','sf_id,sf_name,sf_start_datetime,sf_end_datetime,sf_reviewer,sf_approver,sf_status','1','1','','','')->result_array();
        $this->load->view('detail', $data);
    }
    function delete() {
        $delete_id = $this->input->post('id');
        Modules::run('api/update_specific_table',array("sf_id"=>$delete_id),array("sf_delete_status"=>"1"),DEFAULT_OUTLET.'_static_form');
    }

    function _get_data_from_post() {
        $data['sf_name'] = $this->input->post('sf_name');
        $is_dates = $this->input->post('is_dates');
        $data['is_dates'] = '0';
        if(!empty($is_dates)) {
            $data['is_dates'] = '1';
            $data['sf_start_datetime'] = "";
            if(!empty($this->input->post('start_date')) || !empty($this->input->post('start_time')))
                $data['sf_start_datetime'] = date("Y-m-d H:i:s", strtotime($this->input->post('start_date')." ".$this->input->post('start_time')));
            $data['sf_end_datetime'] = "";
            if(($this->input->post('end_date') != '0000-00-00 00:00:00') && (!empty($this->input->post('end_date')) || !empty($this->input->post('end_time'))))
                $data['sf_end_datetime'] = date("Y-m-d H:i:s", strtotime($this->input->post('end_date')." ".$this->input->post('end_time')));
            else {
                $data['sf_end_datetime'] = date('Y-m-d H:i:s', strtotime('+18 years', strtotime(date("Y-m-d H:i:s"))));
            }
        }
        $data['sf_reviewer'] = $this->input->post('review_team');
        $data['sf_approver'] = $this->input->post('approve_team');
        return $data;
    }
    function _get_data_from_db($update_id) {
        $where['sf_id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['sf_name'] = $row->sf_name;
            $data['sf_start_datetime'] = $row->sf_start_datetime;
            $data['sf_end_datetime'] = $row->sf_end_datetime;
            $data['sf_reviewer'] = $row->sf_reviewer;
            $data['sf_approver'] = $row->sf_approver;
            $data['is_dates'] = $row->is_dates;
        }
        return $data;
    }

    function manage_attributes() {
        $parent_id = $this->uri->segment(4);
        $name = $this->uri->segment(5);
        $data['ParentId'] = $parent_id;
        $data['parent_name'] =  urldecode($name);
        $data['view_file'] = 'manage_sub_attributes';
        $data['selected_rank'] = array();
        if(is_numeric($parent_id) && !empty($parent_id))
           $data['selected_rank'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfq_check_id'=>$parent_id,'sfq_delete'=>'0'),'page_rank desc','page_rank',DEFAULT_OUTLET.'_static_form_question','page_rank','1','0','','','')->result_array();
         for ($i = 1; $i <= 500; $i++) {  $resultRank[$i] = $i; 	}
        $data['rank'] = $resultRank;
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create_attributes(){
        $is_edit = 0;
        $parent_id = $this->uri->segment(4);
        $self_id = $this->uri->segment(5);
        ///////////////////////For Language///////////////////////////
        
        $attribute_type=$this->uri->segment(6);
        $attribute_id=$this->uri->segment(7);
        $answer_id=$this->uri->segment(8);
        if(isset($attribute_type) && $attribute_type=="range"){
            $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$parent_id,'sfq_id'=>$attribute_id), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question,page_rank','1','1','','','')->row_array();
            if(isset($data['sfq_question']) && !empty($data['sfq_question']))
                $data['sfq_question'] = $data['sfq_question'];
            else
                $data['sfq_question'] = '';
            
        }else{
            $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$parent_id,'sfq_delete'=>'0','sfq_id'=>$attribute_id), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','*','1','0','','','')->row_array();
        }
		$data['back_page'] = $_SERVER['HTTP_REFERER'];
        $data['check_name'] = $data['cat_name'] = $self_id;
        $data['attribute_type']=$attribute_type;
        $data['attribute_id']=$attribute_id;
        $data['answer_id']=$answer_id;
        $data['parent_id'] = $parent_id;
        $data['update_id'] = $attribute_id;
        $data['view_file'] = 'create_sub_attributes';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function get_range_attribute_detail($ParentId,$sfq_id,$sfa_id){
        $temp_data=array();
         $range_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_id'=>$sfq_id), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question,page_rank','1','0','','','')->result_array();
        if (isset($range_data) && !empty($range_data)) {
            foreach ($range_data as $rd):
                $data_values = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfa_delete'=>'0','sfa_question_id'=>$rd['sfq_id'],'sfa_id'=>$sfa_id), 'sfa_id desc', 'sfa_id',DEFAULT_OUTLET.'_static_form_answer','sfa_id,sfa_min,sfa_max,sfa_target,sfa_answer_acceptance','1','0','','','')->result_array();
                if(!empty($data_values)) {
                    foreach ($data_values as $key => $dv):
                        $temp_data['sfq_question']=$rd['sfq_question'];
                        $temp_data['page_rank']=$rd['page_rank'];
                        $temp_data['sfa_answer_acceptance']=$dv['sfa_answer_acceptance'];
                        $temp_data['sfa_min']=$dv['sfa_min'];
                        $temp_data['sfa_max']=$dv['sfa_max'];
                        $temp_data['sfa_target']=$dv['sfa_target'];
                    endforeach;
                } 
            endforeach;
        } 
        return $temp_data;
    }
    function submit_attributes() {
        $update_id = $this->uri->segment(5);
        $data = $this->get_attribute_post_data();
        if (is_numeric($update_id) && $update_id != 0) {
        	$attribute_type=$this->input->post('attribute_type');
            $attribute_id=$update_id;
            $checkname=$this->input->post('checkname');
            $answer_id=$this->input->post('range_answer_id');
            $previous_question = $sixten_groups = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_id"=>$update_id),'sfq_id desc','sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_question_type','1','1','','','')->result_array();
            Modules::run('api/update_specific_table',array("sfq_id"=>$attribute_id),$data,DEFAULT_OUTLET.'_static_form_question');
            if(!empty($data['sfq_question_type'])) {
                $previous_type = "";
                if(isset($previous_question[0]['sfq_question_type']) && !empty($previous_question[0]['sfq_question_type']))
                    $previous_type = $previous_question[0]['sfq_question_type'];
                if(strtolower($data['sfq_question_type']) != strtolower($previous_type))
                    Modules::run('api/update_specific_table',array("sfa_question_id"=>$attribute_id),array("sfa_delete"=>"1"),DEFAULT_OUTLET.'_static_form_answer');
                if(strtolower($data['sfq_question_type']) == 'choice') {
                    if(strtolower($data['sfq_selection_type']) != 'other') {
                        $new_data = explode("/",$data['sfq_selection_type']);
                        if(!empty($new_data)) {
                            for ($i=0; $i < 2 ; $i++) { 
                                $acceptance = "acceptable";
                                if($i != 0)
                                    $acceptance = "unacceptable";
                                Modules::run('api/insert_or_update',array("sfa_question_id"=>$update_id,"sfa_answer"=>$new_data[$i],"sfa_answer_acceptance"=>$acceptance),array("sfa_question_id"=>$update_id,"sfa_answer"=>$new_data[$i],"sfa_answer_acceptance"=>$acceptance),DEFAULT_OUTLET.'_static_form_answer');
                            }
                        }
                    }
                    else {
                        $choice_name = $this->input->post('choice_name');
                        $acceptance = $this->input->post('acceptance');
                        $others = $this->input->post('others');
                        $previous_others = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfa_question_id'=>$update_id),'sfa_id desc','sfa_id',DEFAULT_OUTLET.'_static_form_answer','sfa_id','1','0','','','')->result_array();
                        if(!empty($previous_others)) {
                            foreach ($previous_others as $po_key => $po):
                                if(empty(in_array($po['sfa_id'], $others)))
                                    Modules::run('api/update_specific_table',array("sfa_id"=>$po['sfa_id']),array("sfa_delete"=>"1"),DEFAULT_OUTLET.'_static_form_answer');
                            endforeach;
                        }
                        if(!empty($choice_name)) {
                            foreach ($choice_name as $cn_key => $cn):
                                $checking = "";
                                if(!empty($others[$cn_key]))
                                    $checking = array_search($others[$cn_key], array_column($previous_others, 'sfa_id'));
                                if(!is_numeric($checking)) {
                                    Modules::run('api/insert_into_specific_table',array("sfa_question_id"=>$update_id,"sfa_answer"=>$cn,"sfa_answer_acceptance"=>$acceptance[$cn_key],"sfa_status"=>"1"),DEFAULT_OUTLET.'_static_form_answer');
                                }
                                elseif(is_numeric($checking)) {
                                    Modules::run('api/update_specific_table',array("sfa_id"=>$others[$cn_key]),array("sfa_question_id"=>$update_id,"sfa_answer"=>$cn,"sfa_answer_acceptance"=>$acceptance[$cn_key],"sfa_status"=>"1"),DEFAULT_OUTLET.'_static_form_answer');
                                }
                            endforeach;
                        }
                    }
                }
                elseif(strtolower($data['sfq_question_type']) == 'range') {
                    $ref_min = $this->input->post('refrigerated_min_value');
                    $ref_max = $this->input->post('refrigerated_max_value');
                    if((!empty($ref_min) || is_numeric($ref_min)) || (!empty($ref_max) || is_numeric($ref_max))) {
                        $answer_id = $this->input->post('ref_id');
                        Modules::run('api/insert_or_update',array("sfa_question_id"=>$update_id,'sfa_id'=>$answer_id),array("sfa_question_id"=>$update_id,"sfa_min"=>$ref_min,"sfa_max"=>$ref_max,"sfa_target"=>$this->input->post('refrigerated_target_value'),"sfa_answer_acceptance"=>"refrigerated"),DEFAULT_OUTLET.'_static_form_answer');
                    }
                    $fro_min = $this->input->post('frozen_min_value');
                    $fro_max = $this->input->post('frozen_max_value');
                    if((!empty($fro_min) || is_numeric($fro_min)) || (!empty($fro_max) || is_numeric($fro_max))) {
                        $answer_id = $this->input->post('frozen_id');
                        Modules::run('api/insert_or_update',array("sfa_question_id"=>$update_id,'sfa_id'=>$answer_id),array("sfa_question_id"=>$update_id,"sfa_min"=>$fro_min,"sfa_max"=>$fro_max,"sfa_target"=>$this->input->post('frozen_target_value'),"sfa_answer_acceptance"=>"frozen"),DEFAULT_OUTLET.'_static_form_answer');
                    }
                    else {
                        if(empty($this->input->post('frozen_target_value')) && !is_numeric($this->input->post('frozen_target_value')))
                            Modules::run('api/delete_from_specific_table',array("sfa_question_id"=>$update_id,'sfa_answer_acceptance'=>'frozen'),DEFAULT_OUTLET."_static_form_answer");
                    }
                }
                else
                    echo "";
            }
        }
        else {
            $question_id = Modules::run('api/insert_into_specific_table',$data,DEFAULT_OUTLET.'_static_form_question');
            if(!empty($data['sfq_question_type'])) {
                if(strtolower($data['sfq_question_type']) == 'choice') {
                    if(strtolower($data['sfq_selection_type']) != 'other') {
                        $new_data = explode("/",$data['sfq_selection_type']);
                        if(!empty($new_data)) {
                            for ($i=0; $i < 2 ; $i++) { 
                                $acceptance = "acceptable";
                                if($i != 0)
                                    $acceptance = "unacceptable";
                                Modules::run('api/insert_into_specific_table',array("sfa_question_id"=>$question_id,"sfa_answer"=>$new_data[$i],"sfa_answer_acceptance"=>$acceptance),DEFAULT_OUTLET.'_static_form_answer');
                            }
                        }
                    }
                    else {
                        $choice_name = $this->input->post('choice_name');
                        $acceptance = $this->input->post('acceptance');
                        if(!empty($choice_name)) {
                            foreach ($choice_name as $keying => $cn):
                                Modules::run('api/insert_into_specific_table',array("sfa_question_id"=>$question_id,"sfa_answer"=>$cn,"sfa_answer_acceptance"=>$acceptance[$keying]),DEFAULT_OUTLET.'_static_form_answer');
                            endforeach;
                        }
                    }
                }
                elseif(strtolower($data['sfq_question_type']) == 'range') {
                    $ref_min = $this->input->post('refrigerated_min_value');
                    $ref_max = $this->input->post('refrigerated_max_value');
                    if((!empty($ref_min) || is_numeric($ref_min)) && (!empty($ref_max) || is_numeric($ref_max)))
                        Modules::run('api/insert_into_specific_table',array("sfa_question_id"=>$question_id,"sfa_min"=>$ref_min,"sfa_max"=>$ref_max,"sfa_target"=>$this->input->post('refrigerated_target_value'),"sfa_answer_acceptance"=>"refrigerated"),DEFAULT_OUTLET.'_static_form_answer');
                    $fro_min = $this->input->post('frozen_min_value');
                    $fro_max = $this->input->post('frozen_max_value');
                    if((!empty($fro_min) || is_numeric($fro_min)) && (!empty($fro_max) || is_numeric($fro_max)))
                        Modules::run('api/insert_into_specific_table',array("sfa_question_id"=>$question_id,"sfa_min"=>$fro_min,"sfa_max"=>$fro_max,"sfa_target"=>$this->input->post('frozen_target_value'),"sfa_answer_acceptance"=>"frozen"),DEFAULT_OUTLET.'_static_form_answer');
                }
                else
                    echo "";
            }
            $this->session->set_flashdata('message', 'Check Submitted');
        }
        redirect(ADMIN_BASE_URL . 'static_form/manage_attributes/'.$this->input->post('hdnParentId').'/'.$checkname);  
    }
    function get_attribute_post_data() {
        $data['sfq_check_id'] = $this->input->post('hdnParentId');
        $data['sfq_question'] = $this->input->post('attribute_name');
        $data['sfq_question_type'] = $this->input->post('attribute_type');
        $data['sfq_question_selection'] = $this->input->post('selection_type');
        if(empty($data['sfq_question_selection']))
        $data['sfq_question_selection']="single_select";
        $data['sfq_selection_type'] = $this->input->post('possible_answer');
        $data['page_rank'] = $this->input->post('page_rank');
        return $data;
    }
 	
	function static_form_detail() {
        $data['url'] = $_SERVER['HTTP_REFERER'];
        $data['update_id'] = $data['assignment_detailid'] = $update_id = $this->input->post('id');
        $data['function'] = $this->input->post('function');
        $data['questions'] = $this->get_static_question_detail(array("saa.assignment_id"=>$update_id), 'assign_ans_id desc','assign_ans_id','saa.question_id,saa.answer_id,saa.comments,saa.is_acceptable,saa.given_answer,saa.answer_type,static_form_question.sfq_question as question,user_id,line_no','1','0','','','')->result_array();
        $data['assign_detail']=$this->get_static_checks_detail($update_id)->result_array();
        $user_data = $this->session->userdata('user_data');
        $data['review_text'] = '';
        $data['review_status'] = false;
        $data['permission'] = '';
    	$check_review_approval= false;
        if(isset($user_data['role']) && !empty($user_data['role'])) {
            if(strtolower($user_data['role']) == 'admin' && $data['function'] != 'static_forms_approved') {
                $data['review_text'] = 'Review & Approved';
                $data['review_status'] = true;
                $data['permission'] = 'both';
                $check_review_approval = true;
            }
        }
        if($check_review_approval == false && $data['function'] != 'static_forms_approved') {
        	if(isset($data['assign_detail'][0]['review_team']) && $data['assign_detail'][0]['review_team'] && empty($data['assign_detail'][0]['review_user'])) {
            if((!empty($user_data['group']) && is_numeric($user_data['group']) &&  $user_data['group'] == $data['assign_detail'][0]['review_team']) || (!empty($user_data['second_group']) && is_numeric($user_data['second_group']) && $user_data['second_group'] == $data['assign_detail'][0]['review_team'])) {
                $data['review_text'] = 'Reviewed';
                $data['review_status'] = true;
                $data['permission'] = 'review';
            }
        }
        	if(isset($data['assign_detail'][0]['approval_team']) && $data['assign_detail'][0]['approval_team']  && empty($data['assign_detail'][0]['approval_user'])) {
            if((!empty($user_data['group']) && is_numeric($user_data['group']) && $user_data['group'] == $data['assign_detail'][0]['approval_team']) || (!empty($user_data['second_group']) && is_numeric($user_data['second_group']) && $user_data['second_group'] == $data['assign_detail'][0]['approval_team'])) {
                if($data['review_status'] == true) {
                    $data['permission'] = 'both';
                    $data['review_text'] = 'Review & Approved';
                }
                else {
                    $data['permission'] = 'approve';
                    $data['review_text'] = 'Review & Approved';
                }

                $data['review_status'] = true;
            }
        }
        }
        //print_r($data);echo "<br><br>";print_r($user_data);exit;
        $this->load->view('static_detail', $data);
    }
    function change_static_form_permission() {
        $url = $this->input->post('url');
        $id = $this->input->post('update_id');
        $review_comments = $this->input->post('review_comments');
        $permission = $this->input->post('permission');
        if(!empty($permission) && !empty($id) && !empty($id)) {
            if($permission == 'both')
                Modules::run('api/update_specific_table',array("assign_id"=>$id),array("review_user"=>$this->session->userdata['user_data']['user_id'],'review_datetime'=>date("Y-m-d H:i:s"),'review_comments'=>$review_comments,'approval_user'=>$this->session->userdata['user_data']['user_id'],'approval_datetime'=>date("Y-m-d H:i:s"),'approval_comments'=>$review_comments,'assign_status'=>'Approved'),DEFAULT_OUTLET.'_static_assignments');
            elseif($permission == 'review')
                Modules::run('api/update_specific_table',array("assign_id"=>$id),array("review_user"=>$this->session->userdata['user_data']['user_id'],'review_datetime'=>date("Y-m-d H:i:s"),'review_comments'=>$review_comments,'assign_status'=>'Reviewed'),DEFAULT_OUTLET.'_static_assignments');
            elseif($permission == 'review')
                Modules::run('api/update_specific_table',array("assign_id"=>$id),array('approval_user'=>$this->session->userdata['user_data']['user_id'],'approval_datetime'=>date("Y-m-d H:i:s"),'approval_comments'=>$review_comments,'assign_status'=>'Approved'),DEFAULT_OUTLET.'_static_assignments');
            else
                echo "";
        }
        $this->session->set_flashdata('message', 'Status has been changed');
        if(empty($url))
            redirect(ADMIN_BASE_URL . 'static_form'); 
        else
            redirect($url); 
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_static_form');
        return $this->mdl_static_form->_get_by_arr_id($arr_col);
    }
    function delete_sub_catagories_attributes(){
    	$delete_id = $this->input->post('id');
    	Modules::run('api/update_specific_table',array("sfa_question_id"=>$delete_id),array("sfa_delete"=>"1"),DEFAULT_OUTLET.'_static_form_answer');
    	Modules::run('api/update_specific_table',array("sfq_id"=>$delete_id),array("sfq_delete"=>"1"),DEFAULT_OUTLET.'_static_form_question');
    }
    function  update_specific_attribute(){
        $attr_id=$this->input->post('attr_id');
        $page_rank=$this->input->post('page_rank');
        Modules::run('api/update_specific_table',array('sfq_id'=>$attr_id), array('page_rank'=>$page_rank),DEFAULT_OUTLET.'_static_form_question');
        $this->session->set_flashdata('message', 'Order Number has been changed');
        $this->session->set_flashdata('status', 'success');
    }
	function get_static_question_detail($cols, $order_by,$group_by='',$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_static_form');
        $query = $this->mdl_static_form->get_static_question_detail($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_static_checks_detail($assign_id) {
        $this->load->model('mdl_static_form');
        $query = $this->mdl_static_form->get_static_checks_detail($assign_id);
        return $query;
    }
}