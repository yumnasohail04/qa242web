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
    	$timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
            date_default_timezone_set($timezone[0]['timezones']);
    }

    function index(){
        
        $data['sites_report']=$this->get_sites_checkreport();
       // data['ppc_report']);exit();
        $data['view_file'] = 'home';
        $data['dashboard_file'] = 'asdfsadf';
        $this->load->module('template');
        $this->template->admin($data);
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
        }
        elseif($data_type == "month") {
            $top = $this->create_top_charts(date("Y-m-01", strtotime(date("Y-m-01") . "-2 months")).' 00:00:00',date("Y-m-d"),'1',"months",'M y','');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-01"),date("Y-m-d"),"+1 day",'j M','-1 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-01"),date("Y-m-d"),"+1 day",'Y-m-d');
        }
        elseif($data_type == "threemonth") {
            $top = $this->create_top_charts(date("Y-m-01", strtotime(date("Y-m-01") . "-8 months")).' 00:00:00',date("Y-m-d"),'3',"months",'M y','M y');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-01")."-2 months")),date("Y-m-d"),"+3 day",'j M','-3 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-01")."-2 months")),date("Y-m-d"),"+3 day",'Y-m-d');
        }
        elseif($data_type == "sixmonth") {
            $top = $this->create_top_charts(date("Y-m-01", strtotime(date("Y-m-01") . "-17 months")).' 00:00:00',date("Y-m-d"),'6',"months",'M y','M y');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-m-01")."-5 months")),date("Y-m-d"),"+1 months",'M y','-6 months');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-m-01")."-5 months")),date("Y-m-d"),"+1 months",'Y-m-d');
        }
        elseif($data_type == "oneyear") {
            $top = $this->create_top_charts(date("Y-01-01", strtotime(date("Y-m-d") . "-2 years")).' 00:00:00',date("Y-m-d"),'1',"years",'Y','');
            $trendline_graph_data = $this->create_trend_line_chart(date("Y-m-d", strtotime(date("Y-01-01"))),date("Y-m-d"),"+1 months",'M y','-1 year');
            $plant_graph = $this->create_plant_chart(date("Y-m-d", strtotime(date("Y-01-01"))),date("Y-m-d"),"+1 months",'Y-m-d');
        }
        else {
            $top = $this->create_top_charts(date("Y-01-01", strtotime(date("Y-m-d") . "-5 years")).' 00:00:00',date("Y-m-d"),'2',"years",'Y','Y');
            $trendline_graph_data = $this->create_trend_line_chart(date('Y-01-01', strtotime('-1 years')),date("Y-m-d"),"+1 months",'M y','-2 year');
            $plant_graph = $this->create_plant_chart(date('Y-01-01', strtotime('-1 years')),date("Y-m-d"),"+1 months",'Y-m-d');
        }
        echo json_encode(array("ppc_pie_report"=>$top['ppc_pie_report_data'],"ccp_pie_report"=>$top['ccp_pie_report_data'],"atp_swab_pie_report"=>$top['atp_swab_pie_report_data'],"receivinglog_pie_report"=>$top['receivinglog_pie_report_data'],"ppc_bar_report"=>$top['ppc_bar_report'],"ccp_bar_report"=>$top['ccp_bar_report'],"atp_swab_bar_report"=>$top['atp_swab_bar_report'],"receivinglog_bar_report"=>$top['receivinglog_bar_report'],"trendline_graph_data"=> $trendline_graph_data,"data_type"=>$data_type,"final"=>$plant_graph['final'],"plants_name"=>$plant_graph['plants_name'],"plant_indexes"=>$plant_graph['plant_indexes']));
    }
    function get_date_wise_pie_report($startdate,$enddate,$name,$itertion,$start_format,$end_format) {
        $pass = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$startdate.'" AND "'.$enddate.'") AND LOWER(pro_check.checkname) LIKE  "%'.strtolower($name).'%"','','')->num_rows();
        $fail = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'fail'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$startdate.'" AND "'.$enddate.'") AND LOWER(pro_check.checkname) LIKE  "%'.strtolower($name).'%"','','')->num_rows();
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
        $bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'Pre-op',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar_result[$itertion] = $data['bar_chart'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
        $return['ppc_pie_report_data'] = $this->get_passed_failed_perecntage($pass,$fail,'Pre-op');
        $return['ppc_bar_report'] = array_reverse(array_reverse($bar_result));
        /////////// End PPC////
        ////////////////CCP ////
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $pass = $fail = 0;
        $bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'Ccp',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar_result[$itertion] = $data['bar_chart'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
        $return['ccp_pie_report_data'] = $this->get_passed_failed_perecntage($pass,$fail,'CCP');
        $return['ccp_bar_report'] = array_reverse(array_reverse($bar_result));
        /////////// End CCP////
        ////////////////ATP swab ////
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $pass = $fail = 0;
        $bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'ATP Swab',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar_result[$itertion] = $data['bar_chart'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
        $return['atp_swab_pie_report_data'] = $this->get_passed_failed_perecntage($pass,$fail,'ATP Swab');
        $return['atp_swab_bar_report'] = array_reverse(array_reverse($bar_result));
        /////////// End ATP swab////
        ////////////////Receiving Log ////
        $startdate = $setstartdate;
        $enddate = $setenddate;
        $pass = $fail = 0;
        $bar_result = array();
        for ($itertion = 3; $itertion >= 1; $itertion--) {
            $enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate . "+".($diff_no)." ".$diff_text)) . "-1 days")).' 23:59:59';
            $data = $this->get_date_wise_pie_report($startdate,$enddate,'Receiving Inpection Log',$itertion,$start_format,$end_format);
            $pass = $pass + $data['pass'];
            $fail = $fail + $data['fail'];
            $bar_result[$itertion] = $data['bar_chart'];
            $startdate = date("Y-m-d", strtotime($startdate. "+".($diff_no)." ".$diff_text)).' 00:00:00';
        }
        $return['receivinglog_pie_report_data'] = $this->get_passed_failed_perecntage($pass,$fail,'Receiving');
        $return['receivinglog_bar_report'] = array_reverse(array_reverse($bar_result));
        return $return;
    }
    function create_trend_line_chart($startdate,$enddate,$increment,$date_formate,$decrement) {
        $tacking = $pass = $fail = $previous = array();
        for ($i = $startdate; $i <= $enddate ; ) {
            $end = date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days'));
            $passing = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'pass'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
            $failing = $this->get_standard_complete_assignments_data(array("LOWER(pf_status)"=>'fail'), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows();
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
            $counter = 1;
            for ($i = $startdate; $i <= $enddate ; ) {
                $end = date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days'));
                $record = $arr_record =  array();
                foreach($plants as $key => $value):
                    $temp = array();
                    $pass = $this->get_standard_complete_assignments_data_with_answer(array("assign.pf_status"=>"pass","plant_no"=>$value['plant_id']), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows;
                    $pass = $pass + $this->get_static_complete_assignments_data_with_answer(array("static_assign.pf_status"=>"pass","static_assign_answer.plant_id"=>$value['plant_id']), 'assign_id desc','assign_id',DEFAULT_OUTLET,'assign_id','1','0','(approval_datetime between "'.$i.' 00:00:00'.'" AND "'.date("Y-m-d", strtotime(date("Y-m-d", strtotime($i.$increment)).'-1 days')).' 23:59:59'.'")','','')->num_rows;
                        $temp_new['pass_count']= $pass;
                        $temp_new['date']=  $i;
                        $temp_new['plant_id'] = $value['plant_id'];
                        $temp_new['plant_name'] = $value['plant_name'];
                        if($counter == 1)
                            $plants_name[]  = $value['plant_name'];
                    $record[]=$temp_new; 
                endforeach;
                $arr_record['y']= date($date_formate, strtotime($i));
                $x = 'a';
                foreach($record as $key => $value) {   
                    $arr_record[$x]=$value['pass_count'];
                    if($counter == 1)
                        $plant_indexes[]  = $x;
                    $x++;
                }
                $final[]=$arr_record;
                $counter++;
                $i = date("Y-m-d", strtotime($i.$increment));
            }
        }
        $data['final']=$final;
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
        $var_time_period = $this->input->post('var_time_period');
    	$start_data = $end_date = date('Y-m-d');
    	switch ($var_time_period) {
        	case "7":
            	$start_data = date("Y-m-d", strtotime(date("Y-m-d") . "-6 days"));
            	break;
        	case "1":
            	$start_data = date("Y-m-01");
            	break;
        	case "3":
            	$start_data = date("Y-m-d", strtotime(date("Y-m-01")."-2 months"));
            	break;
        	case "6":
            	$start_data = date("Y-m-d", strtotime(date("Y-m-01")."-5 months"));
            	break;
        	case "12":
            	$start_data = date("Y-m-d", strtotime(date("Y-01-01")));
            	break;
        	default:
            	$start_data = date('Y-01-01', strtotime('-1 years'));
    	}
    	$start_data = $start_data." 00:00:00";
    	$end_date = $end_date." 23:59:59";
    	$where['approval_datetime >=']= $start_data;
    	$where['approval_datetime <=']= $end_date;
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
        
        $data['final_array']=$final_array;
        echo  $this->load->view('report_checks',$data,TRUE);
    }
    function get_table_data()
    {
        $var_time_period = $this->input->post('var_time_period');
        $row = $this->input->post('row');
    	$start_data = $end_date = date('Y-m-d');
    	switch ($var_time_period) {
        	case "7":
            	$start_data = date("Y-m-d", strtotime(date("Y-m-d") . "-6 days"));
            	break;
        	case "1":
            	$start_data = date("Y-m-01");
            	break;
        	case "3":
            	$start_data = date("Y-m-d", strtotime(date("Y-m-01")."-2 months"));
            	break;
        	case "6":
            	$start_data = date("Y-m-d", strtotime(date("Y-m-01")."-5 months"));
            	break;
        	case "12":
            	$start_data = date("Y-m-d", strtotime(date("Y-01-01")));
            	break;
        	default:
            	$start_data = date('Y-01-01', strtotime('-1 years'));
    	}
    	if($row=="Receiving"){$row="Receiving Inpection Log";}
    	$start_data = $start_data." 00:00:00";
    	$end_date = $end_date." 23:59:59";
    	$where['approval_datetime >=']= $start_data;
    	$where['approval_datetime <=']= $end_date;
    	$where['pf_status <=']= "Failed";
        $result=$this->get_data_for_completed_assignments_from_db($where,$row,'')->result_array();
        foreach($result as $key => $value)
        {
        	$result[$key]['is_static']="0";
        }
        $static_result=$this->get_static_data_for_completed_assignments($where,$row,'')->result_array();
		foreach($static_result as $keys => $value)
        {
        	$static_result[$keys]['is_static']="1";
        }
        $final_array = array_merge($result,$static_result);
        
        $final_array = array_map("unserialize", array_unique(array_map("serialize", $final_array)));
        
        $data['final_array']=$final_array;
        echo  $this->load->view('report_checks',$data,TRUE);
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
        $startdate=date('Y-m-d',strtotime($this->input->post("start_date")));
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
                $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
                return $startdate;
                break;
            case "1":
                 $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
                return $startdate;
                break;
            case "3":
                 $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
                return $startdate;
                break;
            case "6":
                $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
                return $startdate;
                break;
            case "12":
                $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
                return $startdate;
                break;
            case "24":
                 $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
                return $startdate;
                break;

            default:
                 $startdate = date('Y-m-01 00:00:00',strtotime('-2 Month',strtotime($enddate)));
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
        $data[0]['label']=$label;
        $data[1]['label']=$label;
        if(empty($total)) {
            $data[0]['value'] = $this->get_percentage($pass,$toatl);
            $data[1]['value'] = $this->get_percentage($fail,$toatl);
        }
        else {
            $data[0]['value']= '0';
            $data[1]['value']= '0';
        }
        return $data;
    }
    function get_standard_complete_assignments_data($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_standard_complete_assignments_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
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
}