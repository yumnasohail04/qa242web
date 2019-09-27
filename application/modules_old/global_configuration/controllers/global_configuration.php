<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Global_configuration extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
Modules::run('site_security/has_permission');

}
    function index() {
        $this->manage();
    }
    /*function pingAddress($ip){
        $pingresult = shell_exec("start /b ping $ip -n 1");
        $dead = "Request timed out.";
        $deadoralive = strpos($dead, $pingresult);
    
        if ($deadoralive == false){
            echo "The IP address, $ip, is dead";
        } else {
            echo "The IP address, $ip, is alive";
        }
    
    }
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }*/
    function manage() {
      /*echo pingAddress("127.0.0.1")."<br><br>";
      echo $this->get_client_ip_env();exit();*/
      $outlet_name = urldecode($this->uri->segment(5));
      $outlet_id =DEFAULT_OUTLET;
      $data['outlet_id'] = $outlet_id;
      $data['view_file'] = 'timing';
      $days = $this->get_days();
      $arr_days = [];
      
      foreach ($days as $day) {
        $time_data = $this->db->query("SELECT * FROM `timing` where outlet_id = ".$outlet_id." and day ='".$day."'")->result_array();
        $arr_days[$day] = $time_data;
      }

      $data['days'] = $arr_days;
      $data['news'] = $this->_get('id desc')->result_array();
      $data['groups'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
      date_default_timezone_set("Asia/karachi");
      $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
      if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
          date_default_timezone_set($timezone[0]['timezones']);
      $year = date('o', strtotime(date("Y-m-d")));
      $week = date('W', strtotime(date("Y-m-d")));
      $week_start=date("Y-m-d ", strtotime($year.'W'.$week.'1'));
      $temp_product = array();
      if(!empty($week_start)) {
        for ($i=0; $i <=5; $i++) { 
          $temp['date'] = date('m-d-Y', strtotime($week_start));
          $temp['day'] = date('l', strtotime($week_start));
          $temp['data'] = $this->get_product_schedules_from_db(array("ps_date >="=>$week_start,"ps_end_date <="=>$week_start),'ps_date desc','ps_id',DEFAULT_OUTLET,'product_title,ps_line,ps_id,ps_product,navision_no,product_type,ps_date','1','0','','','')->result_array();
          $week_start = date('Y-m-d',strtotime($week_start . "+1 days"));
          $temp_product[] = $temp;
          unset($temp);
        }
      }
      $data['line_plants'] = Modules::run('api/_get_specific_table_with_pagination',array('plant_status'=>'1'), 'plant_id asc',DEFAULT_OUTLET.'_plants','plant_id,plant_name,plant_status','1','0')->result_array();
      $data['all_plants'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'plant_id asc',DEFAULT_OUTLET.'_plants','plant_id,plant_name,plant_status','1','0')->result_array();
      $data['lines'] = Modules::run('api/_get_specific_table_with_pagination',array('line_status'=>'1'), 'line_id asc',DEFAULT_OUTLET.'_lines','line_id,line_name,line_status','1','0')->result_array();
      $data['all_lines'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'line_id asc',DEFAULT_OUTLET.'_lines','line_id,line_name,line_status','1','0')->result_array();
      $data['shifts'] = Modules::run('api/_get_specific_table_with_pagination',array('shift_status'=>'1'), 'shift_id asc',DEFAULT_OUTLET.'_shifts','shift_id,shift_name,shift_status','1','0')->result_array();
      $shift_timing = Modules::run('api/_get_specific_table_with_pagination',array('st_status'=>'1'), 'st_id asc',DEFAULT_OUTLET.'_shift_timing','st_shift,st_day,st_start,st_end,st_id','1','0')->result_array();
      if(!empty($shift_timing)) {
        $temp = array();
        foreach ($shift_timing as $key => $st):
          if(isset($st['st_shift']) && !empty($st['st_shift'])) {
            $shift_detail = Modules::run('api/_get_specific_table_with_pagination',array("shift_id"=>$st['st_shift']), 'shift_id asc',DEFAULT_OUTLET.'_shifts','shift_name,shift_status','1','1')->result_array();
            $st['shift_status'] = 0; $st['shift_name'] = "";
            if(isset($shift_detail[0]['shift_name']) && !empty($shift_detail[0]['shift_name']))
              $st['shift_name'] = $shift_detail[0]['shift_name'];
            if(isset($shift_detail[0]['shift_status']))
              $st['shift_status'] = $shift_detail[0]['shift_status'];
            $temp[] = $st;
          }
        endforeach;
        $shift_timing = $temp;
      }
      $data['fb_document_name'] = "";
      $document_name = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','document_name','1','1')->result_array();
      if(isset($document_name[0]['document_name']) && !empty($document_name[0]['document_name']))
        $data['fb_document_name'] = $document_name[0]['document_name'];
      $datas= Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc','apps_setting','android_link,ios_link','1','1')->row_array();
      $data['shift_timing'] = $shift_timing;
      $data['product_schedule'] = $temp_product;
      $data['ios_link']=$datas['ios_link'];
      $data['android_link']=$datas['android_link'];
      $data['view_file'] = 'news';
      $this->load->module('template');
      $this->template->admin($data);
    }
    function get_plant_html() {
      $data['update_id'] = $this->input->post('id');
      $data['p_name'] = $this->input->post('p_name');
      $this->load->view('adding_plant',$data);
    }
    function get_shift_html() {
      $data['update_id'] = $this->input->post('id');
      $data['shift_name'] = $this->input->post('shift_name');
      $this->load->view('adding_shift',$data);
    }
    function get_shift_timing_html() {
      $data['update_id'] = $this->input->post('id');
      $data['from'] = $this->input->post('from');
      $data['shift_name'] = $this->input->post('shift_name');
      $data['st_shift'] = $this->input->post('st_shift');
      $data['st_day'] = $this->input->post('st_day');
      $data['st_start'] = $this->input->post('st_start');
      $data['st_end'] = $this->input->post('st_end');
      $where =  array();
      if(!empty($from))
        $where['shift_status'] = '1';
      $data['shifts'] = Modules::run('api/_get_specific_table_with_pagination',$where, 'shift_id asc',DEFAULT_OUTLET.'_shifts','shift_id,shift_name,shift_status','1','0')->result_array();
      $this->load->view('adding_shift_timing',$data);
    }
    function set_outlet_timezone(){
        $api_status = false;
        $message = "Bad Request";
        $timezone = $this->input->post('timezone');
        if(isset($timezone) && !empty($timezone)) {
          $api_status = true;
        $message = "TimeZone chnaged";
          Modules::run('api/update_specific_table',array("outlet_id"=>DEFAULT_OUTLET),array("timezones"=>$timezone),'general_setting');
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$api_status,"message"=>$message));
    }
    function get_line_html() {
      $data['update_id'] = $this->input->post('id');
      $data['line_name'] = $this->input->post('line_name');
      $this->load->view('adding_lines',$data);
    }
    function update_line_plants(){
      $status= 'warning';
      $message = $return_previous_selected = "";
      $line_id = $this->input->post('line_id');
      $plant_number = $this->input->post('plant_number');
      $previous_selected =explode(",",$this->input->post('previous_selected'));
      $total_plant= $this->count_array($line_id);
      $total_selected = $this->count_array($previous_selected);
      if($total_plant > $total_selected) {
        foreach ($line_id as $key => $pi):
          if(!in_array($pi, $previous_selected)){
            $checking =Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("line_id"=>$pi),'line_id desc','line_id',DEFAULT_OUTLET.'_lines','line_status','1','1','','','')->result_array();
            if(!empty($checking)) {
              if(!empty($checking[0]['line_status'])) {
                $status= 'success';
                $message = "New Line added";
                Modules::run('api/insert_or_update',array("lp_plant "=>$plant_number,'lp_line'=>$pi),array("lp_plant "=>$plant_number,'lp_line'=>$pi),DEFAULT_OUTLET.'_line_plants');
              }
              else
                $message = "Sorry, now plant not available";
            }
            else
              $message = "Sorry, Plant not exist";
          }
          if(!empty($return_previous_selected))
              $return_previous_selected= $return_previous_selected.',';
          $return_previous_selected = $return_previous_selected.$pi;
        endforeach;
      }
      else{
        foreach ($previous_selected as $key => $ps):
          if(!in_array($ps, $line_id)){
            $status= 'success';
            $message = "Plant deleted";
            Modules::run('api/delete_from_specific_table',array("lp_plant"=>$plant_number,'lp_line'=>$ps),DEFAULT_OUTLET.'_line_plants');
          }
        endforeach;
        if(!empty($line_id))
          foreach ($line_id as $key => $pi):
            if(!empty($return_previous_selected))
              $return_previous_selected= $return_previous_selected.',';
            $return_previous_selected = $return_previous_selected.$pi;
          endforeach;
      }
      header('Content-Type: application/json');
      echo json_encode(array("message" => $message, "return_previous_selected" => $return_previous_selected,'status'=>$status));
    }
    function count_array($array) {
      $total = 0;
      if(!empty($array)) {
        foreach ($array as $key => $arr):
          if(!empty($arr))
            $total++;
        endforeach;
      }
      return $total;
    }
    function get_product_schedules() {
      date_default_timezone_set("Asia/karachi");
      $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
      if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
        date_default_timezone_set($timezone[0]['timezones']);
      $data['update_id'] = $this->input->post('id');
      $data['start_date'] = $this->input->post('start_date');
      if(!empty($data['start_date']))
        $data['start_date'] = date('m/d/Y', strtotime($data['start_date']));
      else
        $data['start_date'] = date('m/d/Y');
      $data['end_date'] = $data['start_date'];
      $data['selected_product'] = $this->input->post('product');
      $data['line'] = $this->input->post('line');
      $data['products'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id',DEFAULT_OUTLET.'_product','id,product_title,navision_no','1','0','','','')->result_array();
      $this->load->view('product_schedule',$data);
    }
    function submit_plant_data() {
      $update_id = $this->input->post('update_id');
      if(!empty($update_id))
        Modules::run('api/insert_or_update',array("plant_id"=>$update_id),array("plant_name"=>$this->input->post('plant_name')),DEFAULT_OUTLET.'_plants');
      else
        Modules::run('api/insert_or_update',array("plant_name"=>$this->input->post('plant_name')),array("plant_name"=>$this->input->post('plant_name')),DEFAULT_OUTLET.'_plants');
      redirect(ADMIN_BASE_URL.'global_configuration');
    }
    function submit_line_data() {
      $update_id = $this->input->post('update_id');
      if(!empty($update_id))
        Modules::run('api/insert_or_update',array("line_id"=>$update_id),array("line_name"=>$this->input->post('line_name')),DEFAULT_OUTLET.'_lines');
      else
        Modules::run('api/insert_or_update',array("line_name"=>$this->input->post('line_name')),array("line_name"=>$this->input->post('line_name')),DEFAULT_OUTLET.'_lines');
      redirect(ADMIN_BASE_URL.'global_configuration');
    }
    function submit_shift_data() {
      $update_id = $this->input->post('update_id');
      if(!empty($update_id)) {
        Modules::run('api/insert_or_update',array("shift_id"=>$update_id),array("shift_id"=>$update_id,"shift_name"=>strtolower($this->input->post('shift_name'))),DEFAULT_OUTLET.'_shifts');
      }
      else 
        Modules::run('api/insert_or_update',array("shift_name"=>strtolower($this->input->post('shift_name'))),array("shift_id"=>$update_id,"shift_name"=>strtolower($this->input->post('shift_name'))),DEFAULT_OUTLET.'_shifts');
      redirect(ADMIN_BASE_URL.'global_configuration');
    }
    function submit_shift_timing_data() {
      $status= 'warning';
      $message = "shift date time saved";
      $update_id = $this->input->post('update_id');
      if(!empty($update_id)) {
        $message = "Duplicate shift day time";
        $total = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("st_shift"=>$this->input->post('shift'),"st_day"=>$this->input->post('shift_day'),'st_id !='=>$update_id),'st_id desc','st_id',DEFAULT_OUTLET.'_shift_timing','st_id','1','0','','','')->num_rows();
        if($total < 1) {
            $status = 'true';
            Modules::run('api/insert_or_update',array("st_id"=>$update_id),array("st_shift"=>$this->input->post('shift'),"st_day"=>$this->input->post('shift_day'),"st_start"=>$this->input->post('start_time'),"st_end"=>$this->input->post('end_time')),DEFAULT_OUTLET.'_shift_timing');
        }
      }
      else {
        $status = 'true';
        Modules::run('api/insert_or_update',array("st_shift"=>$this->input->post('shift'),"st_day"=>$this->input->post('shift_day')),array("st_shift"=>$this->input->post('shift'),"st_day"=>$this->input->post('shift_day'),"st_start"=>$this->input->post('start_time'),"st_end"=>$this->input->post('end_time')),DEFAULT_OUTLET.'_shift_timing');
      }
      redirect(ADMIN_BASE_URL.'global_configuration');
    }
    function submit_product_reschedule() {
      $product = $this->input->post('product_name');
      $date = date('Y-m-d', strtotime($this->input->post('scheduledate')));
      $enddate = date('Y-m-d', strtotime($this->input->post('enddate')));
      $shift = $this->input->post('shift');
      $update_id = $this->input->post('update_id');
      if(!empty($product) && !empty($date) && !empty($shift) && !empty($enddate))  {
        if(!empty($update_id))
          Modules::run('api/insert_or_update',array("ps_id"=>$update_id),array("ps_product"=>$product,"ps_date"=>$date,"ps_end_date"=>$date,"ps_line"=>$shift),DEFAULT_OUTLET.'_product_schedules');
        else
          Modules::run('api/insert_or_update',array("ps_product"=>$product,"ps_date"=>$date,"ps_end_date"=>$enddate),array("ps_product"=>$product,"ps_date"=>$date,"ps_end_date"=>$date,"ps_line"=>$shift),DEFAULT_OUTLET.'_product_schedules');
      }
      redirect(ADMIN_BASE_URL.'global_configuration');
    }
    function get_upload_file() {
      $this->load->view('get_upload_file','');
    }
    function submit_upload_image() {
      $this->load->library('PHPExcel');
      if(isset($_FILES['upload_file']) && $_FILES['upload_file']['size'] >0) {
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
          date_default_timezone_set($timezone[0]['timezones']);
        $ext = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
        if($ext=="xls" || $ext=="xlsx"){
          $path = $_FILES["upload_file"]["tmp_name"];
          $object = PHPExcel_IOFactory::load($path);
          $store_date= "";
          $checking = false;
          foreach($object->getWorksheetIterator() as $worksheet):
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++) {
              $storing_check = true;
              $date = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
              $date = PHPExcel_Style_NumberFormat::toFormattedString($date, "YYYY-M-D");
              if($this->checkIsAValidDate($date) == 1) {
                $checking = true;
                $storing_check = false;
                $store_date = date('Y-m-d', strtotime($date));
              } 
              if($checking == true) {
                $line = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $navigation_number = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                if(!empty($line) && !empty($navigation_number) && !empty($store_date) && $storing_check == true) {
                  $line = substr($line, -1);
                  $counter ++;
                  $navigation_number = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                  $product = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("navision_no"=>$navigation_number),'id desc','id',DEFAULT_OUTLET.'_product','id','1','0','','','')->result_array();
                  if(!empty($product[0]['id']))
                    Modules::run('api/insert_or_update',array("ps_product"=>$product[0]['id'],"ps_date"=>$store_date,"ps_end_date"=>$store_date),array("ps_product"=>$product[0]['id'],"ps_date"=>$store_date,"ps_end_date"=>$store_date,"ps_line"=>$line),DEFAULT_OUTLET.'_product_schedules');
                }
              }
            }
          endforeach;
          if($checking == true)
            $this->session->set_flashdata('message', 'product scheduling'.' Data Saved');
          else
            $this->session->set_flashdata('message', 'product scheduling'.' Data Saved');
          $this->session->set_flashdata('status', 'success');
          /*$data = $this->csvToArray($_FILES['upload_file']['tmp_name'], ',');
          $count = count($data) - 1;
          $labels = array_shift($data);  
          foreach ($labels as $label) {
            $keys[] = $label;
          }
          $keys[] = 'id';
          for ($i = 0; $i < $count; $i++) {
            $data[$i][] = $i;
          }
          for ($j = 0; $j < $count; $j++) {
            $d = array_combine($keys, $data[$j]);
            $newArray[$j] = $d;
          }
          if(isset($newArray) && !empty($newArray)){
            foreach ($newArray as $key => $row_value):
              if(isset($row_value['Navigation Number']) && !empty($row_value['Navigation Number'])) {
                $product = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("navision_no"=>$row_value['Navigation Number']),'id desc','id',DEFAULT_OUTLET.'_product','id','1','0','','','')->result_array();
                if(!empty($product[0]['id'])) {
                  $start_date = date('Y-m-d');
                  if(isset($row_value['Start Date']) && !empty($row_value['Start Date']))
                    $start_date = date('Y-m-d', strtotime($row_value['Start Date']));
                  $end_date = date('Y-m-d',strtotime('+1 Week',strtotime(date('Y-m-d'))));
                  if(isset($row_value['End Date']) && !empty($row_value['End Date']))
                    $end_date = date('Y-m-d', strtotime($row_value['End Date']));
                  $line = 1;
                  if(isset($row_value['Line']) && !empty($row_value['Line']) && is_numeric($row_value['Line']) ) 
                      $line = $row_value['Line'];
                  Modules::run('api/insert_or_update',array("ps_product"=>$product[0]['id'],"ps_date"=>$start_date,"ps_end_date"=>$end_date),array("ps_product"=>$product[0]['id'],"ps_date"=>$start_date,"ps_end_date"=>$end_date,"ps_line"=>$line),DEFAULT_OUTLET.'_product_schedules');
                }
              }
            endforeach;
          }
          $this->session->set_flashdata('message', 'product scheduling'.' Data Saved');
          $this->session->set_flashdata('status', 'success');*/
        }
        else{
          $this->session->set_flashdata('message', "Invalid file format");
          $this->session->set_flashdata('status', 'success');
        }
      }
      else{
        $this->session->set_flashdata('message', "Please select the file");
        $this->session->set_flashdata('status', 'success');
      }
      redirect(ADMIN_BASE_URL.'global_configuration');
    }
    function checkIsAValidDate($myDateString){
        return (bool)strtotime($myDateString);
    }
    function csvToArray($file, $delimiter) { 
      if (($handle = fopen($file, 'r')) !== FALSE) { 
        $i = 0; 
        while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
          for ($j = 0; $j < count($lineArray); $j++) { 
            $arr[$i][$j] = $lineArray[$j]; 
          } 
          $i++; 
        } 
        fclose($handle); 
      } 
      return $arr; 
    }
    function adding_line() {
      $row = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'line_id desc','line_id',DEFAULT_OUTLET.'_lines','line_id','1','0','','','')->num_rows();
      Modules::run('api/insert_into_specific_table',array("line_name"=>$row+1),DEFAULT_OUTLET.'_lines');
    } 
    function delete_schedule_product() {
        $delete_id = $this->input->post('id');
        if(!empty($delete_id))
          Modules::run('api/delete_from_specific_table',array("ps_id"=>$delete_id),DEFAULT_OUTLET."_product_schedules");
    }
    function delete_plant() {
        $delete_id = $this->input->post('id');
        if(!empty($delete_id))
          Modules::run('api/insert_or_update',array("plant_id"=>$delete_id),array("plant_status"=>'0'),DEFAULT_OUTLET.'_plants');
    }
    function delete_shift() {
        $delete_id = $this->input->post('id');
        if(!empty($delete_id))
          Modules::run('api/insert_or_update',array("shift_id"=>$delete_id),array("shift_status"=>'0'),DEFAULT_OUTLET.'_shifts');
    }
    function delete_shift_timing() {
        $delete_id = $this->input->post('id');
        if(!empty($delete_id))
          Modules::run('api/delete_from_specific_table',array("st_id"=>$delete_id),DEFAULT_OUTLET.'_shift_timing');
    }
    function delete_line() {
        $delete_id = $this->input->post('id');
        if(!empty($delete_id))
          Modules::run('api/insert_or_update',array("line_id"=>$delete_id),array("line_status"=>'0'),DEFAULT_OUTLET.'_lines');
    }
    function get_days() {
        $arr_days = $this->get_enum_values( 'timing', 'day' );
        return $arr_days;
    }
    
     function get_enum_values( $table, $field ){
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }
    function _get_data_from_post() {
        $data=array();
       $groups=$this->input->post('groups');
       if(isset($groups) && !empty($groups)){
           $total=count($groups);
           for($i=0;$i<$total;$i++){
               $data[$i]['group_id']=$groups[$i];
           }
       }
       return $data;
    }

    function submit() {
                $this->delete_table_data();
                $data = $this->_get_data_from_post();
                foreach($data as $value){
                  
                    $this->_insert($value);
                }
                $app_data['ios_link']=$this->input->post('ios_link');
                $app_data['android_link']=$this->input->post('android_link');
                Modules::run('api/update_specific_table',array(),$app_data,'apps_setting');
    			Modules::run('api/update_specific_table',array('outlet_id'=>DEFAULT_OUTLET),array("document_name"=>$this->input->post('fb_document_name')),'general_setting');
    }

   
  
 


///////////////////////////     HELPER FUNCTIONS    ////////////////////

   

    function _get($order_by) {
        $this->load->model('mdl_global_configuration');
        $query = $this->mdl_global_configuration->_get($order_by);
        return $query;
    }

  
    function _insert($data) {
        $this->load->model('mdl_global_configuration');
        return $this->mdl_global_configuration->_insert($data);
    }

    function delete_table_data(){
        $this->load->model('mdl_global_configuration');
        return $this->mdl_global_configuration->delete_table_data();
    }
    function get_product_schedules_from_db($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_global_configuration');
        $query = $this->mdl_global_configuration->get_product_schedules_from_db($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
}