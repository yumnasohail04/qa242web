<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scorecard extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
Modules::run('site_security/has_permission');
date_default_timezone_set("Asia/karachi");
}

    function index() {

     
        $this->manage();
    }
    function manage() {
        $suppliers=array();
        $data['news'] = $this->_get_data_from_post();
        $supplier =$this->get_suppliers_list_for_scorecard()->result_array();
        if(!empty($supplier)) {
                $temp= array();
                foreach ($supplier as $key => $gp):
                    $temp[$gp['id']] = $gp['name'];
                endforeach;
                $suppliers = $temp;
            }
        $groups =Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"1"),'id desc','',DEFAULT_OUTLET.'_groups','*','1','0','','','')->result_array();
        if(!empty($groups)) {
                $temp= array();
                foreach ($groups as $key => $gp):
                    $temp[$gp['id']] = $gp['group_title'];
                endforeach;
                $group = $temp;
            }
        $data['supplier']=$suppliers;
        $data['groups']=$group;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            
        } else {
            
            $data['news'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function fill_card()
    {
        $update_id = $this->uri->segment(4);
        $data['supplier']= $this->get_supplier_data($update_id)->row_array();
        $questions= $this->get_card_questions($update_id)->result_array();
        foreach($questions as $key => $value)
        {
            $answers= $this->get_questions_answers($value['sfq_id'])->result_array();
            $questions[$key]['answers']=$answers;
        }
        $data['questions']=$questions;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'scorecard';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function submitt_scorecard()
    {
        $result_arr=array();
        $result_arr=$this->input->post('result_arr');
        $result_arr=json_decode($result_arr);
        $id=$this->input->post('id');
        $teamcount=$tot_points=$rec_points=0;
        $card= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$id),'id desc','id',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->row_array();
        $data['sc_id']=$card['sc_id'];	
        $data['team_id']=$card['team_id'];
        foreach ($result_arr as $key => $form_data) {
            $data['question_id']=$form_data->questId;
            $data['answer_id']=$form_data->ansId;
            $rec_points=$rec_points+$form_data->points;
            $tot_points=$tot_points+100;
            $this->_insert_data($data,DEFAULT_OUTLET."_scorecard_assign_answers");
        }
        $team_count= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$data['sc_id']),'id desc','',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->num_rows();
        $team_count=$team_count+1;
        $team_count=100/$team_count;
        $points=$rec_points/$tot_points*$team_count;
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>"1"), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
        date_default_timezone_set($timezones[0]['timezones']);
        $user_id=$this->session->userdata['user_data']['user_id'];
        $this->update_table_(array('id'=>$id),array("fill_status"=>"1","reviewed_date"=>date('Y-m-d H:i:s'),"review_user"=>$user_id,"percentage"=>$points),DEFAULT_OUTLET.'_scorecard_team_assign');
        $status= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$data['sc_id']),'id desc','id',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->result_array();
        $stat="1";
        foreach($status as $key => $value)
        {
            if($value['fill_status']=="0"){$stat="0";}  
        }
        if($stat=="1"){$this->update_table_(array('id'=>$data['sc_id']),array("status"=>"Review"),DEFAULT_OUTLET.'_scorecard_assignment');}
    }
    function submit_pending_scorecard()
    {
        $result_arr=array();
        $result_arr=$this->input->post('result_arr');
        $result_arr=json_decode($result_arr);
        $id=$this->input->post('id');
        $card= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$id),'id desc','id',DEFAULT_OUTLET.'_scorecard_assignment','*','1','0','','','')->row_array();
        $data['sc_id']=$id;	
        $data['team_id']=$card['approval_team'];
        foreach ($result_arr as $key => $form_data) {
            $data['question_id']=$form_data->questId;
            $data['answer_id']=$form_data->ansId;
            $rec_points=$rec_points+$form_data->points;
            $tot_points=$tot_points+100;
            $this->_insert_data($data,DEFAULT_OUTLET."_scorecard_assign_answers");
        }
        $team_count= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$id),'id desc','',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->num_rows();
        $team_count=$team_count+1;
        $team_count=100/$team_count;
        $points=$rec_points/$tot_points*$team_count;
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>"1"), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $user_id=$this->session->userdata['user_data']['user_id'];
        $team_data= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$id),'id desc','',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->result_array();
        $percentage=0;
        foreach($team_data as $key => $value)
        {
          $percentage=$percentage+$value['percentage'];
        }
        $percentage=$percentage+$points;
        $this->update_table_(array('id'=>$id),array("status"=>"Complete","at_reviewed_date"=>date('Y-m-d H:i:s'),"at_review_user"=>$user_id,"at_percentage"=>$points,"total_percentage"=>$percentage),DEFAULT_OUTLET.'_scorecard_assignment');
    }
    function inprogress_scorecard() {
        $group_id=$this->session->userdata['user_data']['group'];
        if($this->session->userdata['user_data']['role']=="Admin" || $this->session->userdata['user_data']['role']=="Purchasing Admin")
        {
            $where=array(DEFAULT_OUTLET."_scorecard_team_assign.fill_status"=>"0");
        }
        else
        {
            $where=array(DEFAULT_OUTLET."_scorecard_team_assign.fill_status"=>"0", DEFAULT_OUTLET."_scorecard_team_assign.team_id"=>$group_id);
        }
        $data['card_list'] =$this->get_scorecard_list($where);
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function pending_scorecard() {
        $group_id=$this->session->userdata['user_data']['group'];
        if($this->session->userdata['user_data']['role']=="Admin" || $this->session->userdata['user_data']['role']=="Purchasing Admin")
        {
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Review");
        }
        else
        {
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Review", DEFAULT_OUTLET."_scorecard_assignment.approval_team"=>$group_id);
        }
        $data['card_list'] =$this->pending_scorecard_list($where)->result_array();
        foreach($data['card_list'] as $key => $value)
        {
            $detail= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$value['id']),'reviewed_date desc','reviewed_date',DEFAULT_OUTLET.'_scorecard_team_assign','reviewed_date','1','0','','','')->result_array();
            $data['card_list'][$key]['last_review_date']=$detail[0]['reviewed_date'];
        }
        $data['view_file'] = 'pending_news';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function fill_pending_scorecard()
    {
        $update_id = $this->uri->segment(4);
        $data['supplier']= $this->get_supplier_data_pending($update_id)->row_array();
        $questions= $this->get_card_questions_pending($update_id)->result_array();
        foreach($questions as $key => $value)
        {
            $answers= $this->get_questions_answers($value['sfq_id'])->result_array();
                $questions[$key]['answers']=$answers;
            $answers= $this->get_questions_answers_pending($value['sfq_id'],$update_id)->row_array();
                $questions[$key]['filled_answers']=$answers['sfa_answer'];
        }
        $data['team_data']=$this->get_review_teams_result($update_id)->result_array();
        $data['questions']=$questions;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'pending_scorecard';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function complete_scorecard()
    {
        $group_id=$this->session->userdata['user_data']['group'];
        if($this->session->userdata['user_data']['role']=="Admin" || $this->session->userdata['user_data']['role']=="Purchasing Admin")
        {
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete");
        }
        else
        {
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete", DEFAULT_OUTLET."_scorecard_assignment.approval_team"=>$group_id);
        }
        $data['card_list'] =$this->get_completed_scorecard($where)->result_array();
        $data['view_file'] = 'completed_scorecard';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function detail() {
        $update_id = $this->input->post('id');
        $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete",DEFAULT_OUTLET."_scorecard_assignment.id"=>$update_id);
        $card =$this->get_completed_scorecard($where)->result_array();
            $card[0]['questions']= $this->get_card_questions_pending($update_id)->result_array();
                foreach($card[0]['questions'] as $key => $value)
                {
                    $answers= $this->get_questions_answers_pending($value['sfq_id'],$update_id)->result_array();
                        $card[0]['questions'][$key]['filled_answers']=$answers;
                }
        $data['card'] = $card;
        $data['team_data']=$this->get_review_teams_result($update_id)->result_array();
        $data['approv_team']=$this->get_approval_teams_result($update_id)->result_array();
        $this->load->view('detail', $data);
    }
     function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['doc_name'] = $row->doc_name;
        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['supplier_id'] = $this->input->post('supplier_id');
        $data['approval_team'] = $this->input->post('group_id');
        $data['create_date'] = date('Y-m-d H:i:s');
        return $data;
    }
    function submit_supplier()
    {   
       $data = $this->_get_data_from_post();
       $id = $this->_insert_data($data,DEFAULT_OUTLET."_scorecard_assignment");
       $team= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sf_status'=>'1','sf_delete_status'=>'0'),'sf_id desc','sf_id',DEFAULT_OUTLET.'_scorecard_form','sf_id, assigned_to','1','0','','','')->result_array();
        foreach($team as $key => $value )
        {
            $score['sc_id']=$id;
            $score['questioniar_id']=$value['sf_id'];
            $score['team_id']=$value['assigned_to'];
            $tassign_id=$this->_insert_data($score,DEFAULT_OUTLET."_scorecard_team_assign");
            $question= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfq_check_id'=>$value['sf_id'],'sfq_status'=>'1','sfq_delete'=>'0'),'sfq_id desc','sfq_id',DEFAULT_OUTLET.'_scorecard_form_question','sfq_id, sfq_question','1','0','','','')->result_array();
                foreach($question as $keys => $values )
                {
                    $ques['sc_id']=$id;
                    $ques['tassign_id']=$tassign_id;
                    $ques['questioniar_id']=$value['sf_id'];
                    $ques['question_id']=$values['sfq_id'];
                    $ques['question']=$values['sfq_question'];
                    $this->_insert_data($ques,DEFAULT_OUTLET."_scorecard_assign_questions");
                }
        }
       $this->session->set_flashdata('message', 'Scorecard Created');
	   $this->session->set_flashdata('status', 'success');
	   redirect(ADMIN_BASE_URL . 'scorecard');
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $this->session->set_flashdata('message', 'Scorecard Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $this->session->set_flashdata('message', 'Scorecard'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        }
        
        redirect(ADMIN_BASE_URL . 'scorecard');
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
    

    function _getItemById($id) {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_scorecard');
        $query = $this->mdl_scorecard->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_scorecard');
        $this->mdl_scorecard->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_scorecard');
        $this->mdl_scorecard->_update_id($id, $data);
    }
    
    function _insert_data($data,$table)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->_insert_data($data,$table);
    }
    function _delete($arr_col) {       
        $this->load->model('mdl_scorecard');
        $this->mdl_scorecard->_delete($arr_col);
    }
    function get_suppliers_list_for_scorecard(){       
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_suppliers_list_for_scorecard();
        
    }
    function get_scorecard_list($where)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_scorecard_list($where);
    }
    function pending_scorecard_list($where)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->pending_scorecard_list($where);
    }
    function get_card_questions($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_card_questions($id);
    }
    function get_card_questions_pending($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_card_questions_pending($id);
    }
    function get_questions_answers($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_questions_answers($id);
    }
    function get_questions_answers_pending($question_id,$sc_id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_questions_answers_pending($question_id,$sc_id);
    }
    function get_supplier_data($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_supplier_data($id);
    }
    function get_supplier_data_pending($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_supplier_data_pending($id);
    }
    function update_table_($where,$data,$table)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->update_table_($where,$data,$table);
    }
    function get_review_teams_result($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_review_teams_result($id);
    }
    function get_completed_scorecard($where)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_completed_scorecard($where);
    }
    function get_approval_teams_result($id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_approval_teams_result($id);
    }
    
     
}
