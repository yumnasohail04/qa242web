<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_checks extends MX_Controller
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
        $data['news'] = $this->_get('id desc',array('checktype ='=>"general qa check"));
        $data['groups'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
        function create() {
        $update_id = $this->uri->segment(4);
         $data['datacheck']=false;
        $master_attributes=array();
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
           $arr_where['checkid']=$update_id;
           $resonce = Modules::run('api/_get_specific_table_with_pagination',$arr_where, 'assign_id desc',DEFAULT_OUTLET.'_assignments','*','1','0')->result_array();
           if(!empty($resonce)){
             $data['datacheck']=true;
           }
           
            $productid=$data['news']['productid'];
            $arr_sub=array();
            
            if($data['news']['checktype']=="general qa check"){
                
            $sub_catagories = Modules::run('api/_get_specific_table_with_pagination',array('parent_id'=>$data['news']['check_cat_id']), 'id desc','catagories','id,cat_name','1','0')->result_array();
           
              foreach ($sub_catagories as $key => $value) {
                $arr_sub[$value['id']]=$value['cat_name'];
              }
               $where_attr['id']=$productid;
                $master_attributes=$this->get_attriutes_list($update_id)->result_array();
              
                
            }
            /*else{
                $where_attr['id']=$productid;
                $data['master_attributes']=$this->get_attriutes_list($productid)->result_array();
            
            }*/
            $where['checkid']=$update_id;
            $data['team']=$this->get_checkteam_list($where)->result_array();
            $data['arr_sub']=$arr_sub;
       
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $master_attributes = array_map("unserialize", array_unique(array_map("serialize", $master_attributes)));
        
        $data['master_attributes']=$master_attributes;
        $arrCategories=array();
        $where_attr['status']=1;
        $products=$this->get_products_list_from_db($where_attr);
          foreach ($products->result() as $category) {
            $arrCategories[$category->id] = $category->product_title;
        }
        
         $groups = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
         $master_catagories = Modules::run('api/_get_specific_table_with_pagination',array('parent_id'=>0), 'id desc','catagories','id,cat_name','1','0')->result_array();
        foreach ($master_catagories as $key => $value) {
            $arr_process[$value['id']]=$value['cat_name'];
        }
        $data['arr_process']=$arr_process;
        $data['groups'] = $groups;
        
        $data['products'] = $arrCategories;
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function get_attibutes_div_ajax(){
        $data['product_attribute']=array();
        $productid=$this->input->post('productid');
        $data['product_attribute']=$this->get_attriutes_list($productid)->result_array();
        echo $this->load->view('fileupload',$data,true);
    }
    function get_product_info(){
        $productid=$this->input->post('productid');
        $where_attr['id']=$productid;
        $productinfo=$this->_get_by_arr_id_product_info($where_attr)->result_array();
        if(isset($productinfo) && !empty($productinfo)){
            $data['shape']=$productinfo[0]['shape'];
            $data['unit_weight']=$productinfo[0]['unit_weight'];
            $data['product_attribute']=$this->get_attriutes_list($productid)->result_array();
         echo $this->load->view('productinfo',$data,true);
        }
    }
     function _get_data_from_db($update_id) {
        $where[DEFAULT_OUTLET.'_product_checks.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['checkname'] = $row->checkname;
            $data['checktype'] = $row->checktype;
            $data['check_desc'] = $row->check_desc;
            $data['productid'] = $row->productid;
            $data['status'] = $row->status;
            $data['unit_weight'] = $row->unit_weight;
            $data['frequency'] = $row->frequency;
            $data['product_shape'] = $row->product_shape;
            $start_datetime = new DateTime($row->start_datetime);
            $start_date = $start_datetime->format('Y-m-d');
            $start_time = $start_datetime->format('H:i');
            $end_datetime = new DateTime($row->end_datetime);
            $end_date = $end_datetime->format('Y-m-d');
            $end_time = $end_datetime->format('H:i');
            $data['start_datetime'] = $start_datetime;
            $data['end_datetime'] = $end_datetime ;
            $data['start_time'] =$start_time ;
            $data['start_date'] =$start_date ;
            $data['end_date'] =$end_date ;
            $data['end_time'] =  $end_time;
            $data['outlet_id'] = $row->outlet_id;
            $data['inspection_team'] = $row->inspection_team;
            $data['review_team'] = $row->review_team;
            $data['approval_team'] = $row->approval_team;
            $data['check_cat_id'] = $row->check_cat_id;
            $data['check_subcat_id'] = $row->check_subcat_id;
            $data['start_day'] = $row->start_day;
        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['checkname'] = $this->input->post('checkname');
        $data['checktype'] = $this->input->post('checktype');
        $data['check_desc'] = $this->input->post('check_desc');
        $data['productid'] = $this->input->post('productid');
        $data['product_shape'] = $this->input->post('shape');
        $data['unit_weight'] = $this->input->post('unit_weight');
        $data['frequency'] =  $this->input->post('frequency');
       // $data['start_day'] =  $this->input->post('start_day');
        ////////////////////General check parameter
        $data['check_cat_id'] =  $this->input->post('check_cat_id');
        $data['check_subcat_id'] =  $this->input->post('check_subcat_id');
        //////////////////General check parameter////////
        $data['created_datetme'] = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $start_time = $this->input->post('start_time');
        $end_date =   date('Y-m-d', strtotime($this->input->post('end_date')));
        $end_time =  $this->input->post('end_time');
        $data['start_datetime']=date('Y-m-d H:i:s', strtotime($start_date.$start_time));
        $data['end_datetime']=date('Y-m-d H:i:s', strtotime($end_date.$end_time));
        $data['outlet_id'] =DEFAULT_OUTLET;
        $data['inspection_team'] = $this->input->post('inspection_team');
        $data['review_team'] = $this->input->post('review_team');
        $data['approval_team'] = $this->input->post('approval_team');
        $data['status'] = $this->input->post('hdnActive');
        return $data;
    }
     function _get_attribute_data_from_post($check_id) {
        $productid=$this->input->post('productid');
        $attribute_list= $this->input->post('attribute_name');
        $min_value=$this->input->post('min_value');
        $max_value=$this->input->post('max_value');
        $target_value=$this->input->post('target_val');
        $total=count($attribute_list);
        if(isset($attribute_list) && !empty($attribute_list)){
        for ($i=0; $i <$total; $i++) {
            //$where_attr['productid']=$productid;
            //$where_attr['attribute_id']=$attribute_list[$i];
           // $where_attr['check_id']=$check_id;
            //$arr_attr_data= $this->check_atrribute_exists($where_attr)->result_array();
            //if(empty($arr_attr_data)){
            //$arr_attribute['productid']=$productid;
            //$arr_attribute['check_id']=$check_id;
            //$arr_attribute['attribute_id']=$attribute_list[$i];
            //$arr_attribute['min_value']=$min_value[$i];
            //$arr_attribute['target_value']=$target_value[$i];
            //$arr_attribute['max_value']=$max_value[$i];
            //$attribute_ids[]=$this->insert_attribute_data($arr_attribute);
            //}
            //elseif(!empty($arr_attr_data)){
                $where_attr['product_id']=$productid;
                $where_attr['id']=$attribute_list[$i];
                  $attribute_data['min_value']=$min_value[$i];
                  $attribute_data['target_value']=$target_value[$i];
                  $attribute_data['max_value']=$max_value[$i];
                  $attribute_ids=$this->update_attribute_data($where_attr,$attribute_data);
            //}
            
        }

      
     }
  }
  function _get_general_checks_attribute_data_from_post($checkid){
        $attribute_list= $this->input->post('attribute_name');
        $min_value=$this->input->post('min_value');
        $max_value=$this->input->post('max_value');
        $target_value=$this->input->post('target_val');
        $attribute_type=$this->input->post('attribute_type');
        $possible_value=$this->input->post('possible_value');
        $possible_answer=$this->input->post('possible_answers');
        
        
       
        $total=count($attribute_list);
        for ($i=0; $i< $total;  $i++) { 
            $where_attr['id']=$attribute_list[$i];
            $arr_attr_data= $master_catagories = Modules::run('api/_get_specific_table_with_pagination',array('check_catagories_attributes.id'=>$attribute_list[$i]), 'id desc','check_catagories_attributes','id,attribute_name','1','0')->result_array();
            $attribute_name=$arr_attr_data[0]['attribute_name'];
            $data['checkid']=$checkid;
            $data['type']=$attribute_type[$i];
            $data['question']=$attribute_name;
            
            //$insert_id=$this->insert_check_questions_db($data);
            $a=0;
            $insert_or_update=$this->insert_or_update(array("checkid"=>$checkid,"question"=>$attribute_name),$data,DEFAULT_OUTLET."_checks_questions");
            
            $ans_data['question_id']=$insert_or_update;
            if($attribute_type[$i]=="Choice" ){
                $ans_array=explode(" ",$possible_answer);

                if($possible_answer[$i]=="yes/no"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='yes';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='no';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }elseif($possible_answer[$i]=="acceptable/unacceptable" ||  $possible_answer[$i]=="acceptable/not acceptable"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='acceptable';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='unacceptable';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }
                elseif($possible_answer[$i]=="completed/not completed"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='completed';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='not completed';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;


 


                }
                elseif($possible_answer[$i]=="cleaned/uncleaned"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='cleaned';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                     $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='uncleaned';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }
                elseif($possible_answer[$i]=="cleaned/completed"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='cleaned';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='completed';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }
                elseif($possible_answer[$i]=="'release/hold"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='release';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='hold';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }
                elseif($possible_answer[$i]=="pass/fail"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='pass';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='fail';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }
                elseif($possible_answer[$i]=="positive/negative"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='positive';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='negative';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }
                elseif($possible_answer[$i]=="sealed/locked"){
                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='sealed';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;

                    $insert_answer_data[1]['possible_answer']='locked';
                    $insert_answer_data[1]['min']=0;
                    $insert_answer_data[1]['max']= 0;
                    $insert_answer_data[1]['is_acceptable']=0;
                    $insert_answer_data[1]['checkid']=$checkid;
                    $insert_answer_data[1]['question_id']=$insert_or_update;
                }else{

                    $insert_answer_data=array();
                    $insert_answer_data[0]['possible_answer']='yes';
                    $insert_answer_data[0]['min']=0;
                    $insert_answer_data[0]['max']= 0;
                    $insert_answer_data[0]['is_acceptable']=1;
                    $insert_answer_data[0]['checkid']=$checkid;
                    $insert_answer_data[0]['question_id']=$insert_or_update;


                    
                }
                
                //$this->insert_question_answer_data($ans_data);
                if(!empty($insert_answer_data)){
                    foreach ($insert_answer_data as $key => $valueddd) {
                       // print_r($insert_answer_data);echo "<br><br>";exit();
                      $this->insert_question_answer_data($valueddd);
                    }
                }
               
               
            }elseif($attribute_type[$i]=="Fixed"){
                $ans_data['possible_answer']=$possible_value[$i];
                $ans_data['min']=0;
                $ans_data['max']= 0;
                $ans_data['is_acceptable']=1;
                $ans_data['checkid']=$checkid;
                $ans_data['question_id']=$insert_or_update;
                //$this->insert_question_answer_data($ans_data);
               
               $this->insert_question_answer_data($ans_data);
            }
            else{

                $ans_data=array();
                $ans_data['possible_answer']='';
                $ans_data['min']= $min_value[$i];
                $ans_data['max']= $max_value[$i];
                $ans_data['is_acceptable']=0;
                $ans_data['checkid']=$checkid;
                $ans_data['question_id']=$insert_or_update;
                
                $a=$a+1;
                //////////update data table in check catagories attribute////////
                $update_data['possible_value']='';
                $update_data['min']=$min_value[$i];
                $update_data['max']= $max_value[$i];
                $update_data['target']=$target_value[$i];;
                ///////////// update data table in check catagories attribute///////
                
                $this->insert_question_answer_data($ans_data);
                
               // $insert_or_updatess=$this->insert_or_update(array("checkid"=>$checkid,"question_id"=>$ans_data['question_id']),$ans_data,DEFAULT_OUTLET."_checks_answers");
            }
            
            //$this->update_general_check_attribute_data($where,$update_data);
        } 
    }

  function get_team_data_from_post($checkid){
    
    ///////////// there can be multiple groups///////
  
    $groups=$this->input->post('groups');
    $total=count($groups);
    $where['checkid']=$checkid;
    $this->delete_checks_team($where);
    if(isset($groups) && !empty($groups)){
    for ($i=0; $i <$total; $i++) {
        $data=array();
         $data['checkid']=$checkid;
         $data['checktype']=$this->input->post('checktype');
         $data['group_id']=$groups[$i];
         $data['member_id']=0;
         $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));

        $data['start_time'] = $this->input->post('start_time');
        $data['end_date'] =   date('Y-m-d', strtotime($this->input->post('end_date')));
        $data['end_time'] =  $this->input->post('end_time');
         $this->insert_checkteam_data($data);
    }

    }
    
  }
    function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        $update_data['frequency']=$data['frequency'];
        /*$update_data['start_datetime']=$data['start_datetime'];
        $update_data['end_datetime']=$data['end_datetime'];
        $update_data['checkname']=$data['checkname'];
        $update_data['check_desc']=$data['check_desc'];
        $data['checktype'] = $this->input->post('checktype');
        $data['check_cat_id'] =  $this->input->post('check_cat_id');
        $data['check_subcat_id'] =  $this->input->post('check_subcat_id');*/
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $arr_where['checkid']=$update_id;
            
            $resonce = Modules::run('api/_get_specific_table_with_pagination',$arr_where, 'assign_id desc',DEFAULT_OUTLET.'_assignments','*','1','0')->result_array();
            if(empty($resonce)){
                $this->delete_checks_question_from_db($arr_where);
                $this->delete_checks_answers_from_db($arr_where);
                $check_cat= Modules::run('api/_get_specific_table_with_pagination',array('catagories.id'=> $data['check_cat_id']), 'id desc','catagories','id,cat_name','1','1')->row_array();
                
                    $this->_get_general_checks_attribute_data_from_post($update_id);
               
                $this->_update($where, $data); 
            }else{
                unset($data['check_cat_id']);
                unset($data['check_subcat_id']);
                 $this->_update($where, $data);
            }
            Modules::run('api/delete_from_specific_table',array("fc_check_id"=>$update_id),DEFAULT_OUTLET."_checks_frequency");
            if(isset($update_data['frequency']) && !empty($update_data['frequency'])) {
                if($update_data['frequency'] == 'Shift') {
                    $shift_timing = $this->input->post('start_shift');
                    if(!empty($shift_timing)){
                        foreach ($shift_timing as $key => $value):
                            Modules::run('api/insert_into_specific_table',array("fc_check_id"=>$update_id,"fc_frequency"=>$value),DEFAULT_OUTLET.'_checks_frequency');
                        endforeach;
                    }
                }
                elseif($update_data['frequency'] == 'Weekly') {
                    $weekly_timing = $this->input->post('start_day');
                    if(!empty($weekly_timing)){
                        foreach ($weekly_timing as $key => $value):
                            Modules::run('api/insert_into_specific_table',array("fc_check_id"=>$update_id,"fc_frequency"=>$value),DEFAULT_OUTLET.'_checks_frequency');
                        endforeach;
                    }
                }
                elseif($update_data['frequency'] == 'Monthly') {
                    $monthly_timing = $this->input->post('monthly_frequency');
                    if(!empty($monthly_timing)){
                        foreach ($monthly_timing as $key => $value):
                            Modules::run('api/insert_into_specific_table',array("fc_check_id"=>$update_id,"fc_frequency"=>$value),DEFAULT_OUTLET.'_checks_frequency');
                        endforeach;
                    }
                }
                else
                    echo "";
            }
           // $this->get_team_data_from_post($update_id);
            //$this->_get_attribute_data_from_post($update_id);
            //$this->insert_qa_checks_shapes_questions($update_id);
           // $this->insert_attribute_question_data($update_id);
           
            $this->session->set_flashdata('message', 'product'.' '.DATA_UPDATED);                                       
                    $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $checktype = $this->input->post('checktype');
            $id = $this->_insert($data);
            if(isset($data['frequency']) && !empty($data['frequency'])) {
                if($data['frequency'] == 'Shift') {
                    $shift_timing = $this->input->post('start_shift');
                    if(!empty($shift_timing)){
                        foreach ($shift_timing as $key => $value):
                            Modules::run('api/insert_into_specific_table',array("fc_check_id"=>$id,"fc_frequency"=>$value),DEFAULT_OUTLET.'_checks_frequency');
                        endforeach;
                    }
                }
                elseif($data['frequency'] == 'Weekly') {
                    $weekly_timing = $this->input->post('start_day');
                    if(!empty($weekly_timing)){
                        foreach ($weekly_timing as $key => $value):
                            Modules::run('api/insert_into_specific_table',array("fc_check_id"=>$id,"fc_frequency"=>$value),DEFAULT_OUTLET.'_checks_frequency');
                        endforeach;
                    }
                }
                elseif($data['frequency'] == 'Monthly') {
                    $monthly_timing = $this->input->post('monthly_frequency');
                    if(!empty($monthly_timing)){
                        foreach ($monthly_timing as $key => $value):
                            Modules::run('api/insert_into_specific_table',array("fc_check_id"=>$id,"fc_frequency"=>$value),DEFAULT_OUTLET.'_checks_frequency');
                        endforeach;
                    }
                }
                else
                    echo "";
            }
            if($checktype=="product attribute"){
              $this->_get_attribute_data_from_post($id);
              $this->get_team_data_from_post($id);
              $this->insert_qa_checks_shapes_questions($id);
              $this->insert_attribute_question_data($id);
            }elseif($checktype=="general qa check"){
                $this->_get_general_checks_attribute_data_from_post($id);
            }
           
            $this->session->set_flashdata('message', 'product'.' '.DATA_SAVED);                                     
            $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'product_checks');
    }
    function insert_qa_checks_shapes_questions($checkid){
        $shape=$this->input->post('shape');

        $data['checkid']=$checkid;
        $data['type']="Dropdown";
        $data['question']="Shape";
        $insert_id=$this->insert_check_questions_db($data);
        $ans_data['question_id']=$insert_id;
        $ans_data['possible_answer']=$shape;
        $ans_data['min']=0;
        $ans_data['max']=0;
        $ans_data['checkid']=$checkid;
        $ans_data['is_acceptable']=1;
        $this->insert_question_answer_data($ans_data);


        ////////////////////////end shape Question///////////
        $unit_weight=$this->input->post('unit_weight');
        $data['checkid']=$checkid;
        $data['type']="Fixed";
        $data['question']="Unit weight";
        $insert_id=$this->insert_check_questions_db($data);
        $ans_data['question_id']=$insert_id;
        $ans_data['possible_answer']=$unit_weight;
        $ans_data['min']=0;
        $ans_data['max']=0;
        $ans_data['checkid']=$checkid;
        $ans_data['is_acceptable']=1;
        $this->insert_question_answer_data($ans_data);
    }
    function insert_attribute_question_data($checkid){
    
        $attribute_list= $this->input->post('attribute_name');
        $min_value=$this->input->post('min_value');
        $max_value=$this->input->post('max_value');

        $total=count($attribute_list);
        for ($i=0; $i< $total;  $i++) { 
            $where_attr['id']=$attribute_list[$i];
            $arr_attr_data= $this->check_atrribute_exists($where_attr)->result_array();
            $attribute_name=$arr_attr_data[0]['attribute_name'];
            $data['checkid']=$checkid;
            $data['type']="Range";
            $data['question']=$attribute_name;
            $insert_id=$this->insert_check_questions_db($data);
            $ans_data['question_id']=$insert_id;
            $ans_data['possible_answer']='';
            $ans_data['min']=$min_value[$i];
            $ans_data['max']= $max_value[$i];
            $ans_data['checkid']=$checkid;
            $ans_data['is_acceptable']=0;
            $this->insert_question_answer_data($ans_data);
        }
    }
    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
        $where['product_id'] =$delete_id;
        $where['outlet_id'] = DEFAULT_OUTLET;
        $arr_where['checkid']= $delete_id ;
       $this->delete_checks_question_from_db($arr_where);
       $this->delete_checks_answers_from_db($arr_where);
       $this->delete_checks_team($arr_where);
    }
     function delete_attributes() {
        $delete_id = $this->input->post('id');  
        $productid = $this->input->post('productid');  
        $where['id'] = $delete_id;
        $where['product_id'] = $productid;
        $where['outlet_id'] = DEFAULT_OUTLET;
        //$this->_delete_product_attributes($where);
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
    function detail() {
        $update_id = $this->input->post('id');
       // $lang_id = $this->input->post('lang_id');
        $data['post'] = $this->_get_data_from_db($update_id);
        $data['product_attribute']=$this->get_attriutes_list($update_id)->result_array();
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_product');
        return $this->mdl_product->_getItemById($id);
    }

    function _get($order_by,$where) {
        $this->load->model('mdl_product');
        $query = $this->mdl_product->_get($order_by,$where);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_product');
        return $this->mdl_product->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_product');
        return $this->mdl_product->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_product');
        $this->mdl_product->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_product');
        $this->mdl_product->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_product');
        $this->mdl_product->_delete($arr_col);
    }
    function _delete_product_attributes($arr_col) {       
        $this->load->model('mdl_product');
        $this->mdl_product->_delete_product_attributes($arr_col);
    }
    /////////////////////////////
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
    function check_if_exists($arr_col) {       
        $this->load->model('mdl_product');
       return $this->mdl_product->check_if_exists($arr_col);
    }
    function check_atrribute_exists($arr_col){
        $this->load->model('mdl_product');
        return $this->mdl_product->check_atrribute_exists($arr_col);
    }
    function insert_attribute_data($data){
        $this->load->model('mdl_product');
       return $this->mdl_product->insert_attribute_data($data);
    }
    function update_attribute_data($where,$attribute_data){
        $this->load->model('mdl_product');
       return $this->mdl_product->update_attribute_data($where,$attribute_data);
    }
    function get_attriutes_list($product_id){
         $this->load->model('mdl_product');
       return $this->mdl_product->get_attriutes_list($product_id);
    }
    /////////////////////////////////
    function get_products_list_from_db($arr_col){
         $this->load->model('mdl_product');
       return $this->mdl_product->get_products_list_from_db($arr_col);
    }
    function _get_by_arr_id_product_info($arr_col) {
        $this->load->model('mdl_product');
        return $this->mdl_product->_get_by_arr_id_product_info($arr_col);
    }
    function delete_checks_team($arr_col){
          $this->load->model('mdl_product');
        return $this->mdl_product->delete_checks_team($arr_col);
    }
    function insert_checkteam_data($data){
          $this->load->model('mdl_product');
        return $this->mdl_product->insert_checkteam_data($data);
    }
    function get_checkteam_list($arr_col){
        $this->load->model('mdl_product');
        return $this->mdl_product->get_checkteam_list($arr_col);
    }
    function insert_check_questions_db($data){
        $this->load->model('mdl_product');
        return $this->mdl_product->insert_check_questions_db($data);
    }
    function insert_question_answer_data($data){
        $this->load->model('mdl_product');
        return $this->mdl_product->insert_question_answer_data($data);
    }
    function delete_checks_question_from_db($where){
         $this->load->model('mdl_product');
        return $this->mdl_product->delete_checks_question_from_db($where);
    }
    function delete_checks_answers_from_db($where){
         $this->load->model('mdl_product');
        return $this->mdl_product->delete_checks_answers_from_db($where);
    }
     
     function get_responsible_team($chekid){
        $this->load->model('mdl_product');
        return $this->mdl_product->get_responsible_team($chekid);
    }
    ////////////////////////////GEneral Qa Checks/////////////////
    function check_general_checks_attributes(){
        $cat_id=$this->input->post('cat_id');
        $where['catagories.id']=$cat_id;
        $result=$this->get_type_general_check($where)->result_array();
        if(isset($result) && !empty($result) && $result[0]['is_product']=="Yes"){
            echo "product";
        }elseif (isset($result) && !empty($result) && $result[0]['is_ingredients']=="Yes") {
            echo "ingredients";
        }else echo "no";
    }
    function get_sub_catagories()
    {
       $cat_id=$this->input->post('cat_id');
       $html='<option value="">Select</option>';
        $master_catagories = Modules::run('api/_get_specific_table_with_pagination',array('parent_id'=>$cat_id), 'id desc','catagories','id,cat_name','1','0')->result_array();
        foreach ($master_catagories as $key => $value) {
            $html.='<option value="'.$value['id'].'">'.$value['cat_name'].'</option>';
        }
        
       
        echo $html;
    }


    function get_general_checks_attributes(){
        $cat_id=$this->input->post('cat_id');
        $update_id=$this->input->post('update_id');

        $master_catagories = Modules::run('api/_get_specific_table_with_pagination',array('check_cat_id'=>$cat_id), 'id asc','check_catagories_attributes','*','1','0')->result_array();
        $data['master_attributes']=$master_catagories;
        
        echo $this->load->view('check_attributes',$data,TRUE);

    }
    function get_sub_catagories_detail(){
        $cat_id=$this->input->post('cat_id');
        $status=FALSE;
        $data_array=array();
        $subcat_id=$this->input->post('subcat_id');
        $master_catagories = Modules::run('api/_get_specific_table_with_pagination',array('catagories.id'=>$subcat_id,'catagories.parent_id'=>$cat_id), 'id desc','catagories','id,parent_id,is_product,is_ingredients','1','0')->row_array();
        if(isset($master_catagories) && !empty($master_catagories)){
            $status=true;
            $data_array=$master_catagories;
        }
         header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "data_array"=>$data_array));

    }
    ////////////
    function get_type_general_check($where){
        $this->load->model('mdl_product');
        return $this->mdl_product->get_type_general_check($where);
    }
    function update_general_check_attribute_data($where,$data){
        $this->load->model('mdl_product');
        return $this->mdl_product->update_general_check_attribute_data($where,$data);
    }
    function insert_or_update($where,$data,$table){
            $this->load->model('mdl_product');
            return $this->load->mdl_product->insert_or_update($where,$data,$table);
        }
}
