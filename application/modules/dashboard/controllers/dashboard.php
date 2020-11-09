<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MX_Controller{

    function __construct() {
        parent::__construct();
        // Modules::run('site_security/is_login');
        //Modules::run('site_security/has_permission');
        date_default_timezone_set("Asia/karachi");
    }

    function db_null()
    {
      //  $this->table_list();
    }

    function index(){
        $user_data = $this->session->userdata('user_data');
    	$role=$user_data['role'];
    	if(strtolower($role)=="purchasing admin" || strtolower($role)=="purchasing team" )
    	{
    		//$this->get_scorecard_reporting();
    		$data=$this->scoring_detail();
    		$data['view_file'] = 'home2';
    	}
    	else
    	{
        
    		$data['sites_report']=$this->get_sites_checkreport();
        	$where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete");
        	$data['card_list'] =Modules::run('scorecard/get_completed_scorecard',$where)->result_array();
            $data['a_users'] = Modules::run('api/_get_specific_table_with_pagination',array("status"=>'1'),'id desc',"users",'id','','')->num_rows();
        	$data['t_users'] = Modules::run('api/_get_specific_table_with_pagination',array(),'id desc',"users",'id','','')->num_rows();
        	$data['user_percent']=($data['a_users']/$data['t_users'])*100;
        	$data['a_groups'] = Modules::run('api/_get_specific_table_with_pagination',array("status"=>'1'),'id desc',DEFAULT_OUTLET."_groups",'id','','')->num_rows();
        	$data['t_groups'] = Modules::run('api/_get_specific_table_with_pagination',array(),'id desc',DEFAULT_OUTLET."_groups",'id','','')->num_rows();
        	$data['group_percent']=($data['a_groups']/$data['t_groups'])*100;
        	$data['a_schedule'] = Modules::run('api/_get_specific_table_with_pagination',array("checktype"=>'scheduled_checks',"status"=>'1'),'id desc',DEFAULT_OUTLET."_product_checks",'id','','')->num_rows();
        	$data['t_schedule'] = Modules::run('api/_get_specific_table_with_pagination',array("checktype"=>'scheduled_checks'),'id desc',DEFAULT_OUTLET."_product_checks",'id','','')->num_rows();
        	$data['schedule_percent']=($data['a_schedule']/$data['t_schedule'])*100;	
        	$data['a_standard'] = Modules::run('api/_get_specific_table_with_pagination',array("checktype"=>'general qa check',"status"=>'1'),'id desc',DEFAULT_OUTLET."_product_checks",'id','','')->num_rows();
        	$data['t_standard'] = Modules::run('api/_get_specific_table_with_pagination',array("checktype"=>'general qa check'),'id desc',DEFAULT_OUTLET."_product_checks",'id','','')->num_rows();
        	$data['standard_percent']=($data['a_standard']/$data['t_standard'])*100;		
        	$data['a_static'] = Modules::run('api/_get_specific_table_with_pagination',array("sf_status"=>'1',"sf_delete_status"=>'1'),'sf_id desc',DEFAULT_OUTLET."_static_form",'sf_id','','')->num_rows();
        	$data['t_static'] = Modules::run('api/_get_specific_table_with_pagination',array("sf_delete_status"=>'1'),'sf_id desc',DEFAULT_OUTLET."_static_form",'sf_id','','')->num_rows();
			$data['static_percent']=($data['a_static']/$data['t_static'])*100;	
        	$data['static']['pass'] = Modules::run('api/_get_specific_table_with_pagination',array("assign_status "=>"Approved","pf_status"=>'pass'),'assign_id desc',DEFAULT_OUTLET."_static_assignments",'assign_id','','')->num_rows();
       		$data['static']['fail'] = Modules::run('api/_get_specific_table_with_pagination',array("assign_status "=>"Approved","pf_status"=>'fail'),'assign_id desc',DEFAULT_OUTLET."_static_assignments",'assign_id','','')->num_rows();
        
        	$result=$this->get_checks_ratio();
        	$data['checks']=json_encode($result);
       		$data['static']=json_encode($data['static']);
    		$data['view_file'] = 'home';
    	}
        $data['dashboard_file'] = 'asdfsadf';
        $this->load->module('template');
        $this->template->admin($data);
    }


	function get_checks_ratio()
    {
    	$dt=date("Y-m-d", strtotime(date("Y-m-d")." -6 days"));
		for ($i = 0; $i < 7; $i++){
            $date = date("Y-m-d", strtotime($dt ." +".$i." days"));
        	$day=date("D", strtotime($date));
        	$data['day'][]=$day;
        	$data['total_checks'][]=Modules::run('api/_get_specific_table_with_pagination',array("start_datetime >= "=>$date." 00:00:00","start_datetime <= "=> $date." 23:59:59"),'assign_id desc',DEFAULT_OUTLET."_assignments",'assign_id','','')->num_rows();
        	$data['completed_checks'][]=Modules::run('api/_get_specific_table_with_pagination',array("start_datetime >= "=>$date." 00:00:00","start_datetime <= "=> $date." 23:59:59","assign_status"=>"Completed"),'assign_id desc',DEFAULT_OUTLET."_assignments",'assign_id','','')->num_rows();
        	$data['pending_reviews'][]=Modules::run('api/_get_specific_table_with_pagination',array("start_datetime >= "=>$date." 00:00:00","start_datetime <= "=> $date." 23:59:59","assign_status"=>"Review"),'assign_id desc',DEFAULT_OUTLET."_assignments",'assign_id','','')->num_rows();
       		$data['pending_approval'][]=Modules::run('api/_get_specific_table_with_pagination',array("start_datetime >= "=>$date." 00:00:00","start_datetime <= "=> $date." 23:59:59","assign_status"=>"Approval"),'assign_id desc',DEFAULT_OUTLET."_assignments",'assign_id','','')->num_rows();
		
        }
    
    return $data;
    
    }
    function supplier(){
        $user_data = $this->session->userdata('user_data');
    	$role=$user_data['role'];
    	$data=$this->scoring_detail();
    	$data['view_file'] = 'home2';
        $data['dashboard_file'] = 'asdfsadf';
        $this->load->module('template');
        $this->template->admin($data);
    }
	function get_scorecard_list()
	{
    	$start=$this->input->post('start_range');
    	$end=$this->input->post('end_range');
        $where=array(DEFAULT_OUTLET."_scorecard_assignment.status"=>"Complete",
                     DEFAULT_OUTLET."_scorecard_assignment.total_percentage >= "=>$start, DEFAULT_OUTLET."_scorecard_assignment.total_percentage <= "=>$end);
        $data['card_list'] =Modules::run('scorecard/get_completed_scorecard',$where)->result_array();
    	echo  $this->load->view('report_scorecard',$data,TRUE);
	}
	function dashboard_audit_list(){
        $audit_val=$this->input->post('audit');
    	$where['audit']=$audit_val;
        $result =Modules::run('scorecard/get_completed_scorecard',$where)->result_array();
        $data['card_list']=$result;
        echo  $this->load->view('report_scorecard',$data,TRUE);
    }
    function dashboard_scorecard_list()
    {
        if(!empty($this->input->post("start")))
            $where['total_percentage >=']=$this->input->post("start");
        if(!empty($this->input->post("end")))
        	$where['total_percentage <=']=$this->input->post("end");
    	$where['1_scorecard_assignment.status']="Complete";
        $result =Modules::run('scorecard/get_completed_scorecard',$where)->result_array();
        $data['card_list']=$result;
        echo  $this->load->view('report_scorecard',$data,TRUE);
    }
	function ingredient_detail()
    {
    	$id=$this->input->post("id");
    	$data['list'] = Modules::run('scorecard/get_supplier_ingreients',array("supplier_id"=>$id))->result_array();
    	echo  $this->load->view('ingredient_list',$data,TRUE);
    }
	function scoring_detail()
	{
    	$total = Modules::run('api/_get_specific_table_with_pagination',array("status"=>'Complete'),'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
		$query = Modules::run('api/_get_specific_table_with_pagination',"total_percentage BETWEEN  00 AND 50  AND  status='Complete'",'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
        $data['morris_one'][0]['label']="Less than 50%";
        $data['morris_one'][0]['value']=$query;
    	// $data['morris_one'][1]['label']="";
    	// $data['morris_one'][1]['value']=$total-$query;
        $query = Modules::run('api/_get_specific_table_with_pagination',"total_percentage BETWEEN  51 AND 75 AND  status='Complete'",'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
        $data['morris_two'][0]['label']="51%-75%";
        $data['morris_two'][0]['value']=$query;
    	// $data['morris_two'][1]['label']="";
    	// $data['morris_two'][1]['value']=$total-$query;
        $query = Modules::run('api/_get_specific_table_with_pagination',"total_percentage BETWEEN  76 AND 89 AND  status='Complete'",'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
        $data['morris_three'][0]['label']="76%-89%";
        $data['morris_three'][0]['value']=$query;
    	// $data['morris_three'][1]['label']="";
    	// $data['morris_three'][1]['value']=$total-$query;
        $query = Modules::run('api/_get_specific_table_with_pagination',"total_percentage BETWEEN  90 AND 100 AND  status='Complete'",'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
        $data['morris_four'][0]['label']="Above 90%";
        $data['morris_four'][0]['value']=$query;
    	// $data['morris_four'][1]['label']="";
        // $data['morris_four'][1]['value']=$total-$query;
        $query = Modules::run('api/_get_specific_table_with_pagination',array("audit"=>"1"),'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
        $data['morris_five'][0]['label']="Facility Visit";
        $data['morris_five'][0]['value']=$query;
        $query = Modules::run('api/_get_specific_table_with_pagination',array("audit"=>"0"),'id desc',DEFAULT_OUTLET."_scorecard_assignment",'id','','')->num_rows();
        $data['morris_six'][0]['label']="Not Approved";
        $data['morris_six'][0]['value']=$query;
        

    return $data;
	}
  function change_all_notification_status()
    {
        $this->update_attribute_data(array(),array("notification_status"=>"0"),"notification");
    }
    function change_notification_status()
    {
        $id=$this->input->post('id');
        $this->update_attribute_data(array("notification_id"=>$id),array("notification_status"=>"0"),"notification");
    }
    function testing() {
        $data_type = $this->input->post('var_time_period');
        if(empty($data_type))
            $data_type = 'week';
        $data_type = strtolower($data_type);
        //$data_type = "asfdasdf";
        if($data_type == "week") {
            $top = $this->create_top_charts(date("Y-m-d", strtotime(date("Y-m-d") . "-21 days")).' 00:00:00',date("Y-m-d"),'7',"days",'j M','j M');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-d")."-6 days")),date("Y-m-d"),"+1 day",'D','-7 days');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-6 days")),date("Y-m-d"),'+1 day','Y-m-d');
        	$compliant_graph = $this->create_compliant_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-21 days")).' 00:00:00',date("Y-m-d"),'7',"days",'j M','j M');
        	$status_graph = $this->create_status_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-21 days")).' 00:00:00',date("Y-m-d"),'7',"days",'j M','j M');
        }
        elseif($data_type == "month") {
            $top = $this->create_top_charts(date("Y-m-d", strtotime(date("Y-m-d") . "-3 months")).' 00:00:00',date("Y-m-d"),'1',"months",'j M','j M');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-d")."-30 days")),date("Y-m-d"),"+1 day",'j M','-1 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-d")."-1 months")),date("Y-m-d"),"+1 day",'Y-m-d');  
        	$compliant_graph = $this->create_compliant_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-3 months")).' 00:00:00',date("Y-m-d"),'1',"months",'j M','j M');
        	$status_graph = $this->create_status_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-3 months")).' 00:00:00',date("Y-m-d"),'1',"months",'j M','j M');
        }
        elseif($data_type == "threemonth") {
            $top = $this->create_top_charts(date("Y-m-d", strtotime(date("Y-m-d") . "-9 months")).' 00:00:00',date("Y-m-d"),'3',"months",'j M y','j M y');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-01")."-2 months")),date("Y-m-d"),"+3 day",'j M','-3 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-d")."-2 months")),date("Y-m-d"),"+3 day",'Y-m-d');
        	$compliant_graph = $this->create_compliant_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-9 months")).' 00:00:00',date("Y-m-d"),'3',"months",'j M y','j M y');
        	$status_graph = $this->create_status_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-9 months")).' 00:00:00',date("Y-m-d"),'3',"months",'j M y','j M y');
        }
        elseif($data_type == "sixmonth") {
            $top = $this->create_top_charts(date("Y-m-d", strtotime(date("Y-m-d") . "-18 months")).' 00:00:00',date("Y-m-d"),'6',"months",'j M y','j M y');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-01")."-5 months")),date("Y-m-d"),"+1 months",'M y','-6 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-d")."-5 months")),date("Y-m-d"),"+1 months",'Y-m-d');
        	$compliant_graph = $this->create_compliant_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-18 months")).' 00:00:00',date("Y-m-d"),'6',"months",'j M y','j M y');
        	$status_graph = $this->create_status_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-18 months")).' 00:00:00',date("Y-m-d"),'6',"months",'j M y','j M y');
        }
        elseif($data_type == "oneyear") {
            //$top = $this->create_top_charts(date("Y-m-01", strtotime(date("Y-01-01") . "-24 months")).' 00:00:00',date("Y-m-d"),'11',"months",'M y','M y');
            //$trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-01-01")."-11 months")),date("Y-m-d"),"+1 months",'M y','-11 months');
            //$plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-01-01")."-11 months")),date("Y-m-d"),"+1 months",'Y-m-d');
            $top = $this->create_top_charts(date("Y-m-d", strtotime(date("Y-m-d") . "-36 months")).' 00:00:00',date("Y-m-d"),'12',"months",'j M y','j M y');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-01")."-11 months")),date("Y-m-d"),"+1 months",'M y','-12 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-d")."-11 months")),date("Y-m-d"),"+1 months",'Y-m-d');
        	$compliant_graph = $this->create_compliant_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-36 months")).' 00:00:00',date("Y-m-d"),'12',"months",'j M y','j M y');
        	$status_graph = $this->create_status_chart(date("Y-m-d", strtotime(date("Y-m-d") . "-36 months")).' 00:00:00',date("Y-m-d"),'12',"months",'j M y','j M y');
        }
        else {
            $top = $this->create_top_charts(date("Y-01-01", strtotime(date("Y-m-d") . "-5 years")).' 00:00:00',date("Y-m-d"),'2',"years",'Y','Y');
            $trendline_graph_data = $this->create_trend_line_chart(date('Y-01-01', strtotime('-2 years')),date("Y-m-d"),"+1 months",'M y','-2 year');
            $plant_graph = $this->create_plant_chart(date('Y-01-01', strtotime('-2 years')),date("Y-m-d"),"+1 months",'Y-m-d');
        	$compliant_graph = $this->create_compliant_chart(date("Y-01-01", strtotime(date("Y-m-d") . "-5 years")).' 00:00:00',date("Y-m-d"),'2',"years",'Y','Y');
        	$status_graph = $this->create_status_chart(date("Y-01-01", strtotime(date("Y-m-d") . "-5 years")).' 00:00:00',date("Y-m-d"),'2',"years",'Y','Y');
        }
        echo json_encode(array("status_graph"=>$status_graph,"compliant_graph"=>$compliant_graph,"ppc_pie_report"=>$top['ppc_pie_report_data'],"ccp_pie_report"=>$top['ccp_pie_report_data'],"atp_swab_pie_report"=>$top['atp_swab_pie_report_data'],"receivinglog_pie_report"=>$top['receivinglog_pie_report_data'],"ppc_bar_report"=>$top['ppc_bar_report'],"ccp_bar_report"=>$top['ccp_bar_report'],"atp_swab_bar_report"=>$top['atp_swab_bar_report'],"receivinglog_bar_report"=>$top['receivinglog_bar_report'],"trendline_graph_data"=> $trendline_graph_data,"data_type"=>$data_type,"plants"=>$plant_graph['plants'],"date"=>$plant_graph['date'],"plants_name"=>$plant_graph['plants_name']));
    }
	function create_status_chart($setstartdate,$setenddate,$diff_no,$diff_text,$start_format,$end_format)
    {
    	$data=array();
     	$startdate = $setstartdate;
        $enddate = $setenddate;
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
          	if(!empty($end_format))
            	$date[] = date($start_format, strtotime($startdate)).'-'.date($end_format, strtotime($enddate));
        	else
            	$date[] = date($start_format, strtotime($startdate));
        	$pending[] = $this->get_graph_checks_count(array("assign_status != "=>"Completed","assign_status != "=>"Overdue","assign_status != "=>"Closed"), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(start_datetime between "'.$startdate.'" AND "'.$enddate.'")','','')->num_rows();
        	$completed[] = $this->get_graph_checks_count(array("assign_status "=>"Completed"), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(start_datetime between "'.$startdate.'" AND "'.$enddate.'")','','')->num_rows();
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
        $data['date']=$date;
   		$data['pending']=$pending;
    	$data['completed']=$completed;
    	return $data;
    }
	function create_compliant_chart($setstartdate,$setenddate,$diff_no,$diff_text,$start_format,$end_format)
    {
   		$data=array();
     	$startdate = $setstartdate;
        $enddate = $setenddate;
        for ($itertion = 3; $itertion >= 1; $itertion--) {
        $pass=$fail="0";
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
          	if(!empty($end_format))
            	$date[] = date($start_format, strtotime($startdate)).'-'.date($end_format, strtotime($enddate));
        	else
            	$date[] = date($start_format, strtotime($startdate));
        	$pass = $this->get_graph_checks_count(array("assign_status "=>"Completed","pf_status != "=>"pass"), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(start_datetime between "'.$startdate.'" AND "'.$enddate.'")','','')->num_rows();
        	$pass=$pass+$this->get_graph_checks_count_static(array("assign_status "=>"Approved","pf_status != "=>"pass"), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(start_datetime between "'.$startdate.'" AND "'.$enddate.'")','','')->num_rows();	
       		$fail = $this->get_graph_checks_count(array("assign_status "=>"Completed","pf_status != "=>"false"), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(start_datetime between "'.$startdate.'" AND "'.$enddate.'")','','')->num_rows();
            $fail = $fail+$this->get_graph_checks_count_static(array("assign_status "=>"Approved","pf_status != "=>"fail"), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(start_datetime between "'.$startdate.'" AND "'.$enddate.'")','','')->num_rows();
        	$startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        $compliant[]=$pass;
        $non_compliant[]=$fail;
        }
        $data['date']=$date;
   		$data['compliant']=$compliant;
    	$data['non_compliant']=$non_compliant;
    	return $data;
    }

    function get_date_wise_pie_report($startdate,$enddate,$name,$itertion,$start_format,$end_format) {
        $pass = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$startdate.'" AND "'.$enddate.'") AND LOWER(pro_check.checkname) LIKE  "%'.strtolower($name).'%"','','')->num_rows();
        $fail = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'false'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$startdate.'" AND "'.$enddate.'") AND LOWER(pro_check.checkname) LIKE  "%'.strtolower($name).'%"','','')->num_rows();
        $pass = $pass + $this->get_static_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$startdate.'" AND "'.$enddate.'") AND LOWER(static_form.sf_name) LIKE  "%'.strtolower($name).'%"','','')->num_rows();
        $fail = $fail + $this->get_static_complete_assignments_data(array("LOWER(pf_status)"=>'fail'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$startdate.'" AND "'.$enddate.'") AND LOWER(static_form.sf_name) LIKE  "%'.strtolower($name).'%"','','')->num_rows();
        if(!empty($end_format))
            $out_array['y'] = date($start_format, strtotime($startdate)).'-'.date($end_format, strtotime($enddate));
        else
            $out_array['y'] = date($start_format, strtotime($startdate));
            $out_array['a'] = $array['pass'] = $pass;
            $out_array['b'] = $array['fail'] = $fail;
        $array['bar_chart'] = $out_array;
        return $array;
    }
    function create_top_charts($setstartdate,$setenddate,$diff_no,$diff_text,$start_format,$end_format) {
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $return = array();
        ////////////////PPC ////
        $pass = $fail = 0;
       $bar= $bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'Pre-op',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar['pass'][]=$data['bar_chart']['a'];
            $bar['fail'][]=$data['bar_chart']['b'];
            $bar['title'][]=$data['bar_chart']['y'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
        $bar_result[$itertion] = $bar;
        $return['ppc_pie_report_data'] = $this->get_passed_failed_perecntage($data['pass'],$data['fail'],'Pre-op');
        $return['ppc_bar_report'] = array_reverse(array_reverse($bar_result));
        /////////// End PPC////


        ////////////////CCP ////
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $pass = $fail = 0;
        $bar=$bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'CCP',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar['pass'][]=$data['bar_chart']['a'];
            $bar['fail'][]=$data['bar_chart']['b'];
            $bar['title'][]=$data['bar_chart']['y'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
     	$bar_result[$itertion] = $bar;
        $return['ccp_pie_report_data'] = $this->get_passed_failed_perecntage($data['pass'],$data['fail'],'CCP');
        $return['ccp_bar_report'] = array_reverse(array_reverse($bar_result));
        /////////// End CCP////

        
        ////////////////ATP swab ////
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $pass = $fail = 0;
        $bar=$bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'ATP Swab',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar['pass'][]=$data['bar_chart']['a'];
            $bar['fail'][]=$data['bar_chart']['b'];
            $bar['title'][]=$data['bar_chart']['y'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
     	$bar_result[$itertion] = $bar;
        $return['atp_swab_pie_report_data'] = $this->get_passed_failed_perecntage($data['pass'],$data['fail'],'ATP Swab');
        $return['atp_swab_bar_report'] = array_reverse(array_reverse($bar_result));
        /////////// End ATP swab////


        ////////////////Receiving Log ////
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $pass = $fail = 0;
        $bar=$bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'Receiving Inpection Log',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar['pass'][]=$data['bar_chart']['a'];
            $bar['fail'][]=$data['bar_chart']['b'];
            $bar['title'][]=$data['bar_chart']['y'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
     	$bar_result[$itertion] = $bar;
        $return['receivinglog_pie_report_data'] = $this->get_passed_failed_perecntage($data['pass'],$data['fail'],'Receiving');
        $return['receivinglog_bar_report'] = array_reverse(array_reverse($bar_result));
        return $return;
    }
 function get_table_data()
    {
 		$start_data=date('Y-m-d',strtotime($this->input->post("start_date")));
        $end_date=date('Y-m-d 23:59:59',strtotime($this->input->post("end_date")));
        $var_time_period=$this->input->post("var_time_period");
        $start_data= $this->converted_dates_using_switch($var_time_period,$end_date);
 		$row = $this->input->post('row');
    	if($row['label']=="Receiving"){$row['label']="Receiving Inpection Log";}
    	$where=array("approval_datetime >=" => $start_data, "approval_datetime <=" => $end_date,"comments !="=>" ");
        $result=$this->get_data_for_completed_assignments_from_db($where,$row['label'],'')->result_array();
        foreach($result as $key => $value)
        {
        	$result[$key]['is_static']="0";
        }
        $static_result=$this->get_static_data_for_completed_assignments($where,$row['label'],'')->result_array();
		foreach($static_result as $keys => $value)
        {
        	$static_result[$keys]['is_static']="1";
        }
        $final_array = array_merge($result,$static_result);
        
        $final_array = array_map("unserialize", array_unique(array_map("serialize", $final_array)));
        
        $data['final_array']=$final_array;
        echo  $this->load->view('reports',$data,TRUE);
    }
    function create_trend_line_chart($startdate,$enddate,$increment,$date_formate,$decrement) {
        $tacking = $pass = $fail = $previous = array();
        for ($i = $startdate; $i <= $enddate ; ) {
            $end = date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days'));
            $passing = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            $failing = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'false'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            $passing = $passing + $this->get_static_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            $failing = $failing + $this->get_static_complete_assignments_data(array("LOWER(pf_status)"=>'fail'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            $tacking[] = date($date_formate, strtotime($i));
            $pass[] = $passing;
            $fail[] = $failing;
            $i = date("Y-m-d", strtotime($i.$increment));
        }
        for ($i = date("Y-m-d", strtotime($startdate.$decrement)); $i < $startdate ; ) {
            $passing = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.$i.' 23:59:59'.'")','','')->num_rows();
            $passing = $passing + $this->get_static_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.$i.' 23:59:59'.'")','','')->num_rows();
            $previous[] = $passing;
           $i = date("Y-m-d", strtotime($i.$increment));
        }
        $data['arr_month_dates']=$tacking;
        $data['passed_array']=$pass;
        $data['failed_array']=$fail;
        $data['previous_array']=$previous;
        return $data;
    }
    function create_plant_chart($startdate,$enddate,$increment,$date_formate) {
        $plant_indexes = $plants_name = $final = array();
        $plants = Modules::run('api/_get_specific_table_with_pagination',array("plant_status"=>"1"),'plant_id desc','1_plants','plant_name,plant_id','','')->result_array();
        if(!empty($plants)) {
            $counter = 0;
            for ($i = $startdate; $i <= $enddate ; ) {
                $end = date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days'));
                $record = $arr_record =  array();
                foreach($plants as $key => $value):
                    $temp = array();
                    $pass = $this->get_standard_complete_assignments_data_with_answer(array("assign.pf_status"=>"pass","plant_no"=>$value['plant_id']), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            		$pass = $pass +  $this->get_static_complete_assignments_data_with_answer(array("static_assign.pf_status"=>"pass","static_assign_answer.plant_id"=>$value['plant_id']), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            		//   $temp_new['pass_count']= $pass;
                      //  $temp_new['date']=  $i;
                        $temp_new['plant_name'] = $value['plant_name'];
                        if($counter == 1)
                            $plants_name[]  = $value['plant_name'];
            
            			$plant[$key]['count'][]=$pass;
            			$plant[$key]['name']=$value['plant_name'];
                    $record[]=$temp_new; 
                endforeach;
                $date[]= date($date_formate, strtotime($i));
                $counter++;
                $i = date("Y-m-d", strtotime($i.$increment));
            }
        
        }
        $data['plants']=$plant;
   		$data['date']=$date;
        $data['plants_name']=$plants_name;
        $data['plant_indexes']=$plant_indexes;
        return $data;
    }
    function get_sites_checkreport()
    {
        $m=date("m");
        $de=date("d");
        $y=date("Y");
        $plants = Modules::run('api/_get_specific_table_with_pagination',array("plant_status"=>"1"),'plant_id desc','1_plants','plant_name,plant_id','','')->result_array();
        for($i=6;$i>=0;$i--) {
            $record=array();
            foreach($plants as $key => $value):
                $temp=array();
                $start_date=date('Y-m-d', mktime(0,0,0,$m,($de-$i),$y));
                $where=array("1_assignments.pf_status"=>"pass","1_assignments.approval_datetime >="=>$start_date." 00:00:00","1_assignments.approval_datetime <="=>$start_date." 23:59:59","1_assignment_answer.plant_id"=>$value['plant_id']);
                $temp=$this->get_sites_checkreport_plantwise($where,"1_assignments","1_assignment_answer")->result_array();
                    if(!isset($temp[0]['pass_count']))
                    $temp[0]['pass_count']="0";
                    
                $where=array("1_static_assignments.pf_status"=>"pass","1_static_assignments.approval_datetime >="=>$start_date." 00:00:00","1_static_assignments.approval_datetime <="=>$start_date." 23:59:59","1_static_assignment_answer.plant_id"=>$value['plant_id']);
                $temp_s=$this->get_sites_checkreport_plantwise($where,"1_static_assignments","1_static_assignment_answer")->result_array();
                    if(!isset($temp_s[0]['pass_count']))
                    $temp_s[0]['pass_count']="0";
                    $pass_count=$temp[0]['pass_count']+$temp_s[0]['pass_count'];
                    
                    $temp_new['pass_count']=$pass_count;
                    $temp_new['date']=$start_date;
                    $temp_new['plant_id']=$value['plant_id'];
                    $temp_new['plant_name']=$value['plant_name'];
                $record[]=$temp_new; 
            endforeach;
            $arr_record=array();
            $arr_record['y']=$start_date;
            $x = 'a';
            foreach($record as $key => $value)
            {   
               $arr_record[$x]=$value['pass_count'];
                    $x++;
            }
            $final[]=$arr_record;
        
        }
        $data['final']=json_encode($final);
        $data['plants']=$plants;
        return $data;
    }
    function get_dashboard_data(){
      
        $where['approval_datetime >=']=date('Y-m-d 00:00:00',strtotime($this->input->post("start_date")));
        $where['approval_datetime <=']=date('Y-m-d 23:59:59',strtotime($this->input->post("end_date")));;
        $result=$this->get_data_for_completed_assignments_from_db($where,'','')->result_array();
    	foreach($result as $key => $value)
        {
        	$result[$key]['is_static']="0";
        }
        $static_result=$this->get_static_data_for_completed_assignments($where,'','')->result_array();
   		foreach($static_result as $keys => $value)
        {
        	$static_result[$keys]['is_static']="1";
        }
        $final_array = array_merge($result,$static_result);
        
        $final_array = array_map("unserialize", array_unique(array_map("serialize", $final_array)));
        if(!empty($final_array))
            $final_array = $this->array_sort($final_array, 'approval_datetime', SORT_DESC);
        $data['final_array']=$final_array;
        echo  $this->load->view('report_checks',$data,TRUE);
    }
    function array_sort($array, $on, $order=SORT_DESC){
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v):
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            endforeach;
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v):
                $new_array[$k] = $array[$k];
            endforeach;
        }
        return $new_array;
    }
    function get_sites_checkreport_plantwise($where,$table,$j_table1)
    {
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_sites_checkreport_plantwise($where,$table,$j_table1);
    }
  
    function get_percentage($percentage,$total){
        if($total >0)
        $new_width =round( ($percentage / $total) * 100);
        else $new_width=0;
        return $new_width;
    }
   
    function get_data_for_completed_assignments_from_db($where,$sNeedle,$group_by){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_data_for_completed_assignments_from_db($where,$sNeedle,$group_by);
    }
    function get_static_data_for_completed_assignments($where,$sNeedle,$group_by){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_static_data_for_completed_assignments($where,$sNeedle,$group_by);
    }
      function get_graphs_data(){
        $startdate=date('Y-m-d 00:00:00',strtotime($this->input->post("start_date")));
        $enddate=date('Y-m-d 23:59:59',strtotime($this->input->post("end_date")));
        $var_time_period=$this->input->post("var_time_period");
        $startdate= $this->converted_dates_using_switch($var_time_period,$enddate);
        $where['approval_datetime >=']=$startdate;
        $where['approval_datetime <=']=$enddate;
        $arr_month= $this->get_month_lists($startdate,$enddate);
        ////////////////PPC ////
        $ppc_result=$this->get_charts_data_from_db($where,'Pre-op','Status')->result_array();
        $ppc_result=array_filter(array_map('array_filter', $ppc_result));
        $ppc_static_result=$this->get_static_charts_data_from_db($where,'Pre-op','Status')->result_array();
        $ppc_static_result=array_filter(array_map('array_filter', $ppc_static_result));
        $ppc_final_array = array_merge($ppc_result,$ppc_static_result);
        $ppc_pie_report_data=$this->get_passed_failed_perecntage_ppc($ppc_final_array,'Pre-op');
         
        $ppc_bar_result=$this->get_charts_data_from_db($where,'Pre-op','Status,month')->result_array();
        $ppc_bar_static_result=$this->get_static_charts_data_from_db($where,'Pre-op','Status,month')->result_array();

        $ppc_bar_final_array = array_merge($ppc_result,$ppc_static_result);
        
        $ppc_bar_report=$this->get_data_for_bars_charts($arr_month,$ppc_bar_final_array);
         
        
        /////////// End PPC////

        ////////////////CCP ////
        //
        $ppc_result=$this->get_charts_data_from_db($where,'ccp','Status')->result_array();
        $ppc_result=array_filter(array_map('array_filter', $ppc_result));
        $ppc_static_result=$this->get_static_charts_data_from_db($where,'ccp','Status')->result_array();
        $ppc_static_result=array_filter(array_map('array_filter', $ppc_static_result));
        $ppc_final_array = array_merge($ppc_result,$ppc_static_result);
        $ppc_final_array=$this->filter_multi_array($ppc_final_array );
        $ccp_pie_report_data=$this->get_passed_failed_perecntage_ppc($ppc_final_array,'CCP');

        $ccp_bar_result=$this->get_charts_data_from_db($where,'ccp','Status,month')->result_array();
        $ccp_bar_static_result=$this->get_static_charts_data_from_db($where,'ccp','Status,month')->result_array();

        $ccp_bar_final_array = array_merge($ppc_result,$ppc_static_result);
        $ccp_bar_final_array=$this->filter_multi_array($ccp_bar_final_array );
        $ccp_bar_report=$this->get_data_for_bars_charts($arr_month,$ccp_bar_final_array);
        /////////// End CCP////

        ////////////////ATP swab ////
        $ppc_result=$this->get_charts_data_from_db($where,'ATP Swab','')->result_array();
        $ppc_result=array_filter(array_map('array_filter', $ppc_result));
        $ppc_static_result=$this->get_static_charts_data_from_db($where,'ATP Swab','Status')->result_array();
        $ppc_static_result=array_filter(array_map('array_filter', $ppc_static_result));
        $ppc_final_array = array_merge($ppc_result,$ppc_static_result);
        $ppc_final_array=$this->filter_multi_array($ppc_final_array );
        
        $atp_swab_pie_report_data=$this->get_passed_failed_perecntage_ppc($ppc_final_array,'ATP Swab');

        $atp_swab_bar_result=$this->get_charts_data_from_db($where,'ATP Swab','Status,month')->result_array();
        $atp_swab_bar_static_result=$this->get_static_charts_data_from_db($where,'ATP Swab','Status,month')->result_array();

        $atp_swab_bar_final_array = array_merge($ppc_result,$ppc_static_result);
        $atp_swab_bar_final_array=$this->filter_multi_array($atp_swab_bar_final_array );
        $atp_swab_bar_report=$this->get_data_for_bars_charts($arr_month,$atp_swab_bar_final_array);
      print_r($atp_swab_bar_report);exit;
        /////////// End ATP swab////

        ////////////////Receiving Log ////
        $ppc_result=$this->get_charts_data_from_db($where,'Receiving Inpection Log','Status')->result_array();
        $ppc_result=array_filter(array_map('array_filter', $ppc_result));
        $ppc_static_result=$this->get_static_charts_data_from_db($where,'Receiving Inpection Log','Status')->result_array();
        $ppc_static_result=array_filter(array_map('array_filter', $ppc_static_result));
        $ppc_final_array = array_merge($ppc_result,$ppc_static_result);
        $ppc_final_array=$this->filter_multi_array($ppc_final_array );
        
        $receivinglog_pie_report_data=$this->get_passed_failed_perecntage_ppc($ppc_final_array,'Receiving');

        $receivinglog_bar_result=$this->get_charts_data_from_db($where,'Receiving Inpection Log','Status,month')->result_array();
        $receivinglog_bar_static_result=$this->get_static_charts_data_from_db($where,'Receiving Inpection Log','Status,month')->result_array();

        $receivinglog_bar_final_array = array_merge($ppc_result,$ppc_static_result);
        $receivinglog_bar_final_array=$this->filter_multi_array($receivinglog_bar_final_array );
        $receivinglog_bar_report=$this->get_data_for_bars_charts($arr_month,$receivinglog_bar_final_array);
        /////////// End Receiving Log////
        $trendline_graph_data=$this->get_trendline_graph_data();
       echo json_encode(array("ppc_pie_report"=>$ppc_pie_report_data,"ccp_pie_report"=>$ccp_pie_report_data,"atp_swab_pie_report"=>$atp_swab_pie_report_data,"receivinglog_pie_report"=>$receivinglog_pie_report_data,"ppc_bar_report"=>$ppc_bar_report,"ccp_bar_report"=>$ccp_bar_report,"atp_swab_bar_report"=>$atp_swab_bar_report,"receivinglog_bar_report"=>$receivinglog_bar_report,"trendline_graph_data"=> $trendline_graph_data));

      
    }
    function get_month_lists($startdate,$enddate){
        
        
        
        $output = [];
        $time   = strtotime($startdate);
        $last   = date('Y-m', strtotime($enddate));
       // print_r($time);exit();

        do {
            $month = date('Y-m', $time);
            $total = date('t', $time);

            $output[] = [
                'month' => $month,
                'total' => $total,
            ];

            $time = strtotime('+1 month', $time);
            
        } while ($month != $last);

       $arr_month=array();
       foreach ($output as $key => $value) {
        
           $arr_month[]=date('F',strtotime($value['month']));
       }
       return $arr_month;
    }
    function converted_dates_using_switch($var_time_period,$enddate){
        switch ($var_time_period) {
            case "7":
                $startdate =date("Y-m-d", strtotime(date("Y-m-d") . "-6 days"));
                return $startdate;
                break;
            case "1":
                 $startdate = date("Y-m-d", strtotime(date("Y-m-d")."-1 months"));
                return $startdate;
                break;
            case "3":
                 $startdate = date("Y-m-d", strtotime(date("Y-m-d")."-2 months"));
                return $startdate;
                break;
            case "6":
                $startdate =date("Y-m-d", strtotime(date("Y-m-d")."-5 months"));
                return $startdate;
                break;
            case "12":
                $startdate = date("Y-m-d", strtotime(date("Y-m-d")."-11 months"));
                return $startdate;
                break;
            case "24":
                 $startdate = date('Y-m-d', strtotime('-2 years'));
                return $startdate;
                break;

            default:
                 $startdate =date("Y-m-d", strtotime(date("Y-m-d")."-1 months"));
                return $startdate;
        }
    }
    function get_charts_data_from_db($where,$sNeedle,$group_by){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_charts_data_from_db($where,$sNeedle,$group_by);
    }
    function get_static_charts_data_from_db($where,$sNeedle,$group_by){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_static_charts_data_from_db($where,$sNeedle,$group_by);
    }
    function get_passed_failed_perecntage_ppc($final_array,$label){
        $passed_array=0;
        $failed_array=0;
        $data=array();
        foreach ($final_array as $key => $value) {
           
            if($value['Status']=='Failed'){
                $failed_array= $value['count'];
            }
            if($value['Status']=='Passed'){
                $passed_array= $value['count'];
            }


        }
        $failed_array_count=$failed_array;
        $passed_array_count=$passed_array;
        $toatlcount=$failed_array_count+$passed_array_count;
        $data[0]['label']=$label;
        $data[1]['label']=$label;
        $data[0]['value']=$this->get_percentage($passed_array_count,$toatlcount);
        $data[1]['value']=$this->get_percentage($failed_array_count,$toatlcount);
         return $data;
    }
    function get_data_for_bars_charts($arr_month,$ppc_final_array){
        $prev_month_year='';
        $i=0;
        $temp_arr=array();
        $out_array=array();
        $j=0;
        foreach ($arr_month as $key => $tmp) {
            if($this->searchForIndex_by_value($tmp,$ppc_final_array)==true){
               
                  foreach ($ppc_final_array as $key => $value) {
                   
                     $prev_month_year=$value['month'];
                     
                    if($value['month']!=$prev_month_year)
                        $i=$i+1;
                    $value['month'] = substr($value['month'], 0, 3);
// multibyte strings
                    $value['month'] = mb_substr($value['month'], 0, 3);
                    $temp_arr['y']=$value['month'];
                   
                    if($value['Status']=='Passed')
                     $temp_arr['a']=$value['count'];
                    else
                        $temp_arr['a']=0;
                     if($value['Status']=='Failed')
                        $temp_arr['b']=$value['count'];
                    else
                        $temp_arr['b']=0;
                    $out_array[$j]=$temp_arr;
                  }
            }else{
                $tmp = substr($tmp, 0, 3);
// multibyte strings
                $tmp = mb_substr($tmp, 0, 3);
               $out_array[$j]['y']=$tmp;
               $out_array[$j]['a']=0;
               $out_array[$j]['b']=0;
            }
             $j= $j+1;
      }
     
        return $out_array;
    }
   function searchForIndex_by_value($search_value, $array) { 
  
    // Iterating over main array 
    foreach ($array as $key1 => $val1) { 
  
        
          
        // Adding current key to search path 
       
  
        // Check if this value is an array 
        // with atleast one element 
        if(is_array($val1) and count($val1)) { 
  
            // Iterating over the nested array 
            foreach ($val1 as $key2 => $val2) { 
  
                if($val2 == $search_value) { 
                          
                    
                          
                    return  true; 
                } 
            } 
        } 
          
        elseif($val1 == $search_value) { 
            return  true; 
        } 
    } 
      
    return false; 
} 
  function filter_multi_array($array){
    $temp_data=array();
    foreach ($array as $key => $value) {
       if(isset($value['count']) && $value['count'] >0){
        $temp_data[]=$value;
       }
    }
    return $temp_data;
  }  
  function get_trendline_graph_data(){
     $where['approval_datetime >=']=date("Y-m-01 00:00:00");
     $where['approval_datetime <=']=date("Y-m-d 23:59:59");

    $period = new DatePeriod(
     new DateTime(date("Y-m-01")),
     new DateInterval('P1D'),
     new DateTime(date("Y-m-d 23:59:59"))
);
 foreach ($period as $key => $value) {
    $arr_month_dates[]=$value->format('Y-m-d');     
}
   
     $ppc_result=$this->get_trendline_graph_data_db($where,'','')->result_array();

     $ppc_result=array_filter(array_map('array_filter', $ppc_result));

     $ppc_static_result=$this->get_static_trendline_graph_data_db($where,'','')->result_array();

     $ppc_static_result=array_filter(array_map('array_filter', $ppc_static_result));

     $ppc_final_array = array_merge($ppc_result,$ppc_static_result);
      
     $prev_month_year='';
     $prev_status='';
     $i=0;
    
     foreach ($arr_month_dates as $key => $month) {
        

            $passed_array[$i]=0;
            $failed_array[$i]=0;
         foreach ($ppc_final_array as $key => $value) {
            $prev_month_year=$value['date'];
            if($value['date']==$month && $value['Status']=="Passed"){
               
                $passed_array[$i]=$passed_array[$i]+1;
            }
            if($value['date']==$month && $value['Status']=="Failed"){
              
                $failed_array[$i]=$failed_array[$i]+1;
            }

         }
        
             
                $i=$i+1;
    }
    $data['arr_month_dates']=$arr_month_dates;
    $data['passed_array']=$passed_array;
    $data['failed_array']=$failed_array;

    $where['approval_datetime >=']=date("Y-m-05 00:00:00");
    $where['approval_datetime <=']=date("Y-m-d 23:59:59");
    $where['pf_status']="pass";
    $data['current_month']=$this->get_current_month_trendline($where,$arr_month_dates);
    /*$where['approval_datetime >=']=date('Y-m-d H:i:s',strtotime('-1 month',strtotime(date("Y-m-01 00:00:00"))));
    $where['approval_datetime <=']=date('Y-m-t H:i:s',strtotime('-1 month',strtotime(date("Y-m-t 00:00:00"))));
    $where['pf_status']="pass";
    $data['prev_month']=$this->get_prev_month_trendline($where,$arr_month_dates);*/
    return $data;
  }
  function get_current_month_trendline($where,$arr_month_dates){
    $ppc_result=$this->get_trendline_graph_data_db($where,'','')->result_array();

     $ppc_result=array_filter(array_map('array_filter', $ppc_result));

     $ppc_static_result=$this->get_static_trendline_graph_data_db($where,'','')->result_array();

     $ppc_static_result=array_filter(array_map('array_filter', $ppc_static_result));

     $ppc_final_array = array_merge($ppc_result,$ppc_static_result);
     
     $prev_month_year='';
     $prev_status='';
     $i=0;
     $passed_array=array();
     foreach ($arr_month_dates as $key => $month) {
        

            $passed_array[$i]=0;
            
         foreach ($ppc_final_array as $key => $value) {
             $prev_month_year=$value['date'];
            if($value['date']==$month && $value['Status']=="Passed"){
               
                $passed_array[$i]=$passed_array[$i]+1;
            }
           
           
         }
        
             
                $i=$i+1;
    }
   return $passed_array;
  }
  function get_trendline_graph_data_db($where,$sNeedle,$group_by){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_trendline_graph_data_db($where,$sNeedle,$group_by);
    }
    function get_static_trendline_graph_data_db($where,$sNeedle,$group_by){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_static_trendline_graph_data_db($where,$sNeedle,$group_by);
    }


    function get_passed_failed_perecntage($pass,$fail,$label){
        $toatl = $pass + $fail;
        $data['label']=$label;
        if(empty($total)) {
            $data['pass'] = $this->get_percentage($pass,$toatl);
            $data['fail'] = $this->get_percentage($fail,$toatl);
        }
        else {
            $data['pass']= '0';
            $data['fail']= '0';
        }
        return $data;
    }
    function get_standard_complete_assignments_data($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_standard_complete_assignments_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
	function get_graph_checks_count($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_graph_checks_count($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
	function get_graph_checks_count_static($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having='')
	{
    	$this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_graph_checks_count_static($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
	}
    function get_static_complete_assignments_data($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_static_complete_assignments_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_standard_complete_assignments_data_with_answer($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_standard_complete_assignments_data_with_answer($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_static_complete_assignments_data_with_answer($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_static_complete_assignments_data_with_answer($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
	function update_attribute_data($where,$attribute_data,$table){
        $this->load->model('mdl_perfectmodel');
       return $this->mdl_perfectmodel->update_attribute_data($where,$attribute_data,$table);
    }
    function get_scorecard_reporting(){
        $this->load->model('mdl_perfectmodel');
       return $this->mdl_perfectmodel->get_scorecard_reporting();
    }
    function table_list()
    {
        $this->load->model('mdl_perfectmodel');
       return $this->mdl_perfectmodel->table_list();
    }
}