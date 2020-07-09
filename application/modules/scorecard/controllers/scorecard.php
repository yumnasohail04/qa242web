<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scorecard extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
Modules::run('site_security/has_permission');
date_default_timezone_set("Asia/karachi");
$timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
date_default_timezone_set($timezone[0]['timezones']);
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
        $data['scorecards'] =Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"Pending"),'id desc','',DEFAULT_OUTLET.'_scorecard_assignment','*','1','0','','','')->result_array();
        if(!empty( $data['scorecards'])){
            foreach($data['scorecards'] as $key => $value)
            {
                $sup =Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$value['supplier_id']),'id desc','','supplier','name','1','0','','','')->row_array();
                $data['scorecards'][$key]['name'] =$sup['name'];
            }
        }
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function delete_scorecard()
    {
        $delete_id = $this->input->post('id');  
        $this->_delete_scorecard(array("sc_id"=>$delete_id),DEFAULT_OUTLET."_scorecard_assign_questions");
        $this->_delete_scorecard(array("sc_id"=>$delete_id),DEFAULT_OUTLET."_scorecard_team_assign");
        $this->_delete_scorecard(array("id"=>$delete_id),DEFAULT_OUTLET."_scorecard_assignment");
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
    function scorecard_report() {
        $supplier =Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"1"),'id asc','','supplier','*','1','0','','','')->result_array();
        if(!empty($supplier)) {
            $temp= array();
            foreach ($supplier as $key => $gp):
                $temp[$gp['id']] = $gp['name'];
            endforeach;
            $suppliers = $temp;
        }
        $data['supplier']=$suppliers;
        $data['view_file'] = 'report';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function reporting_list()
    {
        $graph_date=$graph_points=array();
        $supplier_id=$this->input->post('supplier_id');
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        if(!empty($startdate) && !empty($enddate)){
            $startdate = date("Y-m-d", strtotime($startdate));
            $enddate = date("Y-m-d", strtotime($enddate));
        }
        if(!empty($supplier_id))
        {
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete",DEFAULT_OUTLET."_scorecard_assignment.supplier_id"=>$supplier_id);
            if(!empty($startdate) && !empty($enddate))
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete",DEFAULT_OUTLET."_scorecard_assignment.supplier_id"=>$supplier_id,DEFAULT_OUTLET."_scorecard_assignment.at_reviewed_date >= "=>$startdate." 00:00:00",DEFAULT_OUTLET."_scorecard_assignment.at_reviewed_date <= "=>$enddate." 23:59:59");
        } else
        {
            $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete",DEFAULT_OUTLET."_scorecard_assignment.at_reviewed_date >= "=>$startdate." 00:00:00",DEFAULT_OUTLET."_scorecard_assignment.at_reviewed_date <= "=>$enddate." 23:59:59");
        }  
        $data['card_list'] =$this->get_completed_scorecard($where)->result_array();
        foreach($data['card_list'] as $key => $value)
        {
            $graph_date[]=date("d-m-Y", strtotime($value['at_reviewed_date']));
            $graph_points[]=number_format((float)$value['total_percentage'], 2, '.', '');
        }
        
        $data['graph_date']=$graph_date;
        $data['graph_points']=$graph_points;
        echo  $this->load->view('report_list',$data,TRUE);
    }
    function cron_job()
    {
        $card= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"Complete"),'id desc','supplier_id',DEFAULT_OUTLET.'_scorecard_assignment','*','1','','','','')->result_array();
        foreach($card as $key => $value)
        {
            $exist= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"Pending",'supplier_id'=>$value['supplier_id']),'id desc','id',DEFAULT_OUTLET.'_scorecard_assignment','*','1','','','','')->result_array();
            if(empty($exist)){
                $dates = explode(' ', $value['at_reviewed_date']);
                $dates = date("Y-m-d", strtotime($dates[0]."+3 months"));
                if(date("Y-m-d")==$dates)
                {
                $app_gp = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id"=>DEFAULT_OUTLET), 'id desc','general_setting','scorecard_approv','1','0')->row_array();
                $data['supplier_id'] = $value['supplier_id'];
                $data['approval_team'] = $app_gp['scorecard_approv'];
                $data['create_date'] = date('Y-m-d H:i:s');
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
                }
            }
        }
    }
    function fill_card()
    {
        $update_id = $this->uri->segment(4);
        $data['supplier']= $this->get_supplier_data($update_id)->row_array();
        $questions= $this->get_card_questions($update_id)->result_array();
        foreach($questions as $key => $value)
        {
        	if($value['question_id']=="0")
            {
            	$answers= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'sfa_id asc','sfa_id',DEFAULT_OUTLET.'_ingredient_document_ans','*','1','0','','','')->result_array();
            	if($value['document_id']!="0"){
                	$questions[$key]['type']="Document";
                	$doc= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("s_doc_id"=>$value['document_id'],"supplier_id"=>$data['supplier']['supplier_id']),'id asc','id','supplier_documents','document','1','0','','','')->row_array();
                    if(isset($doc['document']))
                    $questions[$key]['doc']=$doc['document'];
                    if(!isset($doc['document']))
                    $questions[$key]['doc_stat']="0";
                }
                if($value['ingredient_id']!="0"){
                	$questions[$key]['type']="Ingredient";
                	$name= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$value['ingredient_id']),'id asc','id',DEFAULT_OUTLET.'_ingredients','item_name','1','0','','','')->row_array();
                	$questions[$key]['question']=$questions[$key]['question'];
                    $questions[$key]['ingredient']=$name['item_name'];
                }
            }else{
        		$answers= $this->get_questions_answers($value['question_id'])->result_array();
            	$questions[$key]['type']="General";
            }
            $questions[$key]['answers']=$answers;
        }
        $questions =Modules::run('dashboard/array_sort',$questions, 'id', SORT_DESC);
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
            $data['qauto_id']=$form_data->questId;
            $data['answer_id']=$form_data->ansId;
            $rec_points=$rec_points+$form_data->points;
            $tot_points=$tot_points+100;
            $this->_insert_data($data,DEFAULT_OUTLET."_scorecard_assign_answers");
        }
        $team_count= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$data['sc_id']),'id desc','',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->num_rows();
        $team_count=100/$team_count;
        $points=$rec_points/$tot_points*$team_count;
        if($points<20)
        {
            $this->update_table_(array('id'=>$id),array("final_review"=>"1"),DEFAULT_OUTLET.'_scorecard_team_assign');
        }
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
        date_default_timezone_set($timezones[0]['timezones']);
        $user_id=$this->session->userdata['user_data']['user_id'];
        $this->update_table_(array('id'=>$id),array("fill_status"=>"1","reviewed_date"=>date('Y-m-d H:i:s'),"review_user"=>$user_id,"percentage"=>$points,"points"=>$team_count),DEFAULT_OUTLET.'_scorecard_team_assign');
        $status= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$data['sc_id']),'id desc','id',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->result_array();
        $stat="1";
        $review_stat="0";
        $team_data= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$data['sc_id']),'id desc','',DEFAULT_OUTLET.'_scorecard_team_assign','*','1','0','','','')->result_array();
        $percentage=0;
        foreach($team_data as $key => $value)
        {
        $percentage=$percentage+$value['percentage'];
        }
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
        date_default_timezone_set($timezones[0]['timezones']);
        $this->update_table_(array('id'=>$data['sc_id']),array("status"=>"Complete","total_percentage"=>$percentage),DEFAULT_OUTLET.'_scorecard_assignment');
        foreach($status as $key => $value)
        {
            if($value['fill_status']=="0"){
                $stat="0";
            } 
            if($value['final_review']=="1"){
                $review_stat="1";
            }  
        }
        if($stat=="1"){
            if($review_stat=="1"){
                $this->update_table_(array('id'=>$data['sc_id']),array("status"=>"Review"),DEFAULT_OUTLET.'_scorecard_assignment');
            }else{
                
                $this->update_table_(array('id'=>$data['sc_id']),array("status"=>"Complete"),DEFAULT_OUTLET.'_scorecard_assignment');
            }
        }
    }
    function submit_pending_scorecard()
    {
        $result_arr=array();
        $result_arr=$this->input->post('result_arr');
        $result_arr=json_decode($result_arr);
        $id=$this->input->post('id');
        $data['sc_id']=$id;	
        $audit=2;
        foreach ($result_arr as $key => $form_data) {
            $data['quest_id']=$form_data->questId;
            $data['answer']=$form_data->ansId;
            $this->_insert_data($data,DEFAULT_OUTLET."_approv_scorecard_ans");
            if($form_data->ansId=="1")
                $audit="1";
            else if($form_data->ansId=="0")
                $audit="0";
        }
        $user_id=$this->session->userdata['user_data']['user_id'];
    	$timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id desc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
        date_default_timezone_set($timezones[0]['timezones']);
        $this->update_table_(array('id'=>$id),array("status"=>"Complete","audit"=>$audit,"at_reviewed_date"=>date('Y-m-d H:i:s'),"at_review_user"=>$user_id,"comments"=>$this->input->post('comments')),DEFAULT_OUTLET.'_scorecard_assignment');
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
            $detail= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sc_id'=>$value['id']),'reviewed_date desc','reviewed_date',DEFAULT_OUTLET.'_scorecard_team_assign','reviewed_date,percentage','1','0','','','')->result_array();
            $data['card_list'][$key]['last_review_date']=$detail[0]['reviewed_date'];
        		$total="0";
        		foreach($detail as $keys => $values)
                {
                	$total=$total+$values['percentage'];
                }
        		$data['card_list'][$key]['avg']=$total;
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
        $count=0;
        foreach($questions as $key => $value)
        {
            if($value['question_id']=="0")
            {
            	$answers= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'sfa_id asc','sfa_id',DEFAULT_OUTLET.'_ingredient_document_ans','*','1','0','','','')->result_array();
            	$questions[$key]['answers']=$answers;
            	$answers= $this->get_questions_answers_pending_($value['id'],$update_id)->row_array();
                $questions[$key]['filled_answers']=$answers['sfa_answer'];
            	if($value['document_id']!="0"){
                	$questions[$key]['type']="Document";
                	$doc= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("s_doc_id"=>$value['document_id'],"supplier_id"=>$data['supplier']['supplier_id']),'id asc','id','supplier_documents','document','1','0','','','')->row_array();
                	$questions[$key]['doc']=$doc['document'];
                }
                if($value['ingredient_id']!="0"){
                	$questions[$key]['type']="Ingredient";
                	$name= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$value['ingredient_id']),'id asc','id',DEFAULT_OUTLET.'_ingredients','item_name','1','0','','','')->row_array();
                	$questions[$key]['question']=$questions[$key]['question'];
                    $questions[$key]['ingredient']=$name['item_name'];
                    $answers= $this->get_questions_answers_pending_($value['id'],$update_id)->row_array();
                    $percentage=$percentage+$answers['sfa_points'];
                    $count++;
                }
            }else{
        		$answers= $this->get_questions_answers($value['question_id'])->result_array();
            	$questions[$key]['answers']=$answers;
            	$questions[$key]['type']="General";
            	$answers= $this->get_questions_answers_pending($value['id'],$update_id)->row_array();
                $questions[$key]['filled_answers']=$answers['sfa_answer'];
            }
        }
        $count=$count*100;
        $ing_percent=($percentage/$count)*100;
        $data['ing_percent']=$ing_percent;
        $questions =Modules::run('dashboard/array_sort',$questions, 'id', SORT_DESC);
    	$questions_approv = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1"),'id asc','id',DEFAULT_OUTLET.'_approv_scorecard_quest','*','1','0','','','')->result_array();
        $data['team_data']=$this->get_review_teams_result($update_id)->result_array();
        $data['questions']=$questions;
        $data['questions_approv']=$questions_approv;
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
    	$final_team= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$update_id),'id asc','id',DEFAULT_OUTLET.'_scorecard_assignment','approval_team','1','0','','','')->row_array();
    	$final_team=$final_team['approval_team'];
        $card =$this->get_completed_scorecard($where)->result_array();
        $card[0]['questions']= $this->get_card_questions_pending($update_id)->result_array();
            foreach($card[0]['questions'] as $key => $value)
            {
            	if($value['question_id']=="0")
                {
            		$answers= $this->get_questions_answers_final_($value['id'],$update_id,array(DEFAULT_OUTLET."_scorecard_assign_answers.team_id != "=>$final_team))->row_array();
                    $card[0]['questions'][$key]['answers_review']=$answers;
            		if($value['document_id']!="0"){
                		 $card[0]['questions'][$key]['type']="Document";
                    	 $doc= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("s_doc_id"=>$value['document_id'],"supplier_id"=>$card[0]['supplier_id']),'id asc','id','supplier_documents','document','1','0','','','')->row_array();
                		 $card[0]['questions'][$key]['doc']=$doc['document'];
                    }
                	if($value['ingredient_id']!="0"){
                		 $card[0]['questions'][$key]['type']="Ingredient";
                		 $name= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$value['ingredient_id']),'id asc','id',DEFAULT_OUTLET.'_ingredients','item_name','1','0','','','')->row_array();
                    	 $card[0]['questions'][$key]['question']= $card[0]['questions'][$key]['question'];
                    	 $card[0]['questions'][$key]['ingredient']=$name['item_name'];
                	}
            	}else{
                    $card[0]['questions'][$key]['type']="General";
                    $answers= $this->get_questions_answers_final($value['id'],$update_id,array(DEFAULT_OUTLET."_scorecard_assign_answers.team_id != "=>$final_team))->row_array();
                    $card[0]['questions'][$key]['answers_review']=$answers;
                }	
            }
    	$card[0]['questions'] =Modules::run('dashboard/array_sort', $card[0]['questions'], 'id', SORT_DESC);
        $data['card'] = $card;
        $data['team_data']=$this->get_review_teams_result($update_id)->result_array();
        $this->load->view('detail', $data);
    }
    function detail_view()
    {
        $update_id = $this->input->post('id');
        $data['team_data']=$this->get_review_teams_result($update_id)->result_array();
        $this->load->view('detail_card', $data);
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
        $team= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>DEFAULT_OUTLET),'id desc','id','general_setting','scorecard_approv','1','0','','','')->row_array();
        $data['approval_team'] = $team['scorecard_approv'];
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
       		$title= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$value['assigned_to']),'id desc','id',DEFAULT_OUTLET.'_groups','group_title','1','0','','','')->row_array();
			if(strtolower($title['group_title'])=="regulatory")	
            {
            	$result_ingredient=$this->get_supplier_ingreients(array("supplier_id"=>$data['supplier_id']))->result_array();
            	foreach($result_ingredient as $si =>$val)
                {
                    $quest= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"1"),'id desc','id',' ingredient_risk_assessment','title,description','1','0','','','')->result_array();
                	foreach($quest as $ira =>$i_val)
                    {
                    	$qu['sc_id']=$id;
                    	$qu['tassign_id']=$tassign_id;
                    	$qu['questioniar_id']=$value['sf_id'];
                    	$qu['ingredient_id']=$val['ingredient_id'];
                        $qu['question']=$i_val['title'];
                        $qu['sfq_description']=$i_val['description'];
                    	$this->_insert_data($qu,DEFAULT_OUTLET."_scorecard_assign_questions");
                    }
                } 
            	$docs= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('status'=>"1","assign_to"=>"supplier"),'id desc','id',' document','doc_name,id','1','0','','','')->result_array();
            	foreach($docs as $d =>$doc)
                {
                    	$dd['sc_id']=$id;
                    	$dd['tassign_id']=$tassign_id;
                    	$dd['questioniar_id']=$value['sf_id'];
                    	$dd['document_id']=$doc['id'];
                    	$dd['question']=$doc['doc_name'];
                    	$this->_insert_data($dd,DEFAULT_OUTLET."_scorecard_assign_questions");
                }
            }
            $question= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfq_check_id'=>$value['sf_id'],'sfq_status'=>'1','sfq_delete'=>'0'),'sfq_id desc','sfq_id',DEFAULT_OUTLET.'_scorecard_form_question','sfq_id, sfq_question,sfq_description','1','0','','','')->result_array();
                foreach($question as $keys => $values )
                {
                    $ques['sc_id']=$id;
                    $ques['tassign_id']=$tassign_id;
                    $ques['questioniar_id']=$value['sf_id'];
                    $ques['question_id']=$values['sfq_id'];
                    $ques['question']=$values['sfq_question'];
                	$ques['sfq_description']=$values['sfq_description'];
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
    
	function get_supplier_ingreients($where)
    {
     	$this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_supplier_ingreients($where);
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
	function get_questions_answers_pending_($question_id,$sc_id)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_questions_answers_pending_($question_id,$sc_id);
    }
	function get_questions_answers_final($question_id,$sc_id,$where)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_questions_answers_final($question_id,$sc_id,$where);
    }
	function get_questions_answers_final_($question_id,$sc_id,$where)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->get_questions_answers_final_($question_id,$sc_id,$where);
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
    function _delete_scorecard($where,$table)
    {
        $this->load->model('mdl_scorecard');
        return $this->mdl_scorecard->_delete_scorecard($where,$table);
    }
    
     
}
