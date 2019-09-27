<?php

/* * ***********************************************
  Created By: Tahir Mehmood
  Dated: 28-09-2016
 * *********************************************** */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Admin_api extends MX_Controller {

    protected $data = '';

    function __construct() {
        $this->lang->load('english', 'english');
        date_default_timezone_set("Asia/karachi");
        parent::__construct();
    }
    function delete_join_table_data(){
        $this->db->where('1_checks_questions.assignment_id !=', 0);
         $this->db->delete('1_checks_questions');
       /* $result_arr=$this->db->get('1_checks_questions')->result_array();
      
        foreach($result_arr as $value){
            $table="1_checks_answers";
            $this->db->where('1_checks_answers.question_id ', $value['question_id']);
            $this->db->delete($table);
            
            
        }*/
       
        
    }
    function admin_login() {
        $status=false;
        $message="parameter missing";
        $username = $this->input->post('user_name');
        $password = md5($this->input->post('password'));
        $fcmtoken = $this->input->post('fcm_token');  
        $api_key = $this->check_developer_api_key();
        $document_name = "";
        $data= array();
        if($api_key['key_status'] == true) {
            if(!empty($username) && !empty($password)) {
                $row= Modules::run('api/_get_specific_table_with_pagination',array("user_name" =>$username,"password" =>$password,"status"=>"1"),'id desc','users','id,user_name,group,outlet_id,user_image,second_group,phone,first_name,last_name,email','1','1')->row();
                if($row) {
                    if(isset($row->outlet_id) && !empty($row->outlet_id)) {
                        $check = true;
                        if((isset($row->group) && !empty($row->group))|| (isset($row->second_group) && !empty($row->second_group))) {
                            $group_status= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$row->group),'id desc',$row->outlet_id.'_groups','id,status,role','1','1')->result_array();
                            $second_status= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$row->second_group),'id desc',$row->outlet_id.'_groups','id,status,role','1','1')->result_array();
                            if(!empty($group_status) || !empty($second_status)) {
                                $check = false;
                                $gp_status = $sec_status =  0;
                                if(isset($group_status[0]['status']) && !empty($group_status[0]['status'])) {
                                    $check = true;
                                    $gp_status = $group_status[0]['status'];
                                }
                                if(isset($second_status[0]['status']) && !empty($second_status[0]['status'])) {
                                    $sec_status = $second_status[0]['status'];
                                    $check = true;
                                }
                                if($check == true) {
                                    $second_check = false;
                                    $gp_role = $sec_role = "";
                                    if(isset($group_status[0]['role']) && !empty($group_status[0]['role'])) {
                                        $second_check = true;
                                        $role_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$group_status[0]['role']),'id desc','roles','role','1','1')->result_array();
                                        if(isset($role_detail[0]['role']) && !empty($role_detail[0]['role']))
                                            $gp_role = $role_detail[0]['role'];
                                    }
                                    if(isset($second_status[0]['role']) && !empty($second_status[0]['role'])) {
                                        $second_check = true;
                                        $role_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$second_status[0]['role']),'id desc','roles','role','1','1')->result_array();
                                        if(isset($role_detail[0]['role']) && !empty($role_detail[0]['role']))
                                            $sec_role = $role_detail[0]['role'];
                                    }
                                    if($second_check == true) {
                                        $role_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$group_status[0]['role']),'id desc','roles','role','1','1')->result_array();
                                        if(!empty($role_detail)) {
                                            $status = true;
                                            $message = "user login successful";
                                            $data['user_id'] = $row->id; 
                                            $data['name'] = $row->user_name;
                                            $data['outlet_id'] = $row->outlet_id;
                                            $data['designation'] = strtolower($role_detail[0]['role']);
                                            $data['cell_phone'] = $row->phone;
                                            $data['first_name'] = $row->first_name;
                                            $data['last_name'] = $row->last_name;
                                            $data['email'] = $row->email;
                                            $data['shifts'] = Modules::run('api/_get_specific_table_with_pagination',array("shift_status" =>'1'),'shift_id asc',$row->outlet_id.'_shifts','shift_id,shift_name','1','0')->result_array();
                                            $plants = Modules::run('api/_get_specific_table_with_pagination',array("plant_status" =>'1'),'plant_id asc',$row->outlet_id.'_plants','plant_id,plant_name','1','0')->result_array();
                                            if(!empty($plants)){
                                                $temp = array();
                                                foreach ($plants as $key => $pi):
                                                    $pi['lines'] = $this->get_plants_lines(array("lp_plant"=>$pi['plant_id']),'lp_id asc','lp_id',$row->outlet_id,'lp_line as line_id,line_name','1','0','','','')->result_array();
                                                    $temp[] = $pi;
                                                endforeach;
                                                $plants = $temp;
                                            }
                                            $data['plants'] = $plants;
                                            if(isset($row->id) && !empty($row->id) && !empty($fcmtoken))
                                                Modules::run('api/update_specific_table',array("id"=>$row->id),array("fcm_token"=>$fcmtoken),'users');
                                            Modules::run('api/update_specific_table',array("id"=>$row->id),array("is_online"=>'1'),'users');
                                            $data['token'] = substr(md5(uniqid(rand(), true)), 16, 16);
                                            for ($today=1; $today <70 ; $today++) { 
                                                $unique_number =substr(md5(uniqid(rand(), true)), 16, 16);
                                                $check_number = Modules::run('api/_get_specific_table_with_pagination',array("token" =>$unique_number),'id desc','users','id','1','1')->result_array();
                                                if (empty($check_number))  {
                                                    $data['token'] = $unique_number;
                                                    break;
                                                }
                                            }
                                            Modules::run('api/insert_or_update',array("id"=>$data['user_id']),array("token"=>$data['token'],"token_status"=>'1'),'users');
                                            $data['user_image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$row->user_image,STATIC_FRONT_IMAGE,'user.png');
                                            $data['groups'][0]['id'] = $row->group;
                                            $data['groups'][0]['status'] = $gp_status;
                                            $data['groups'][0]['role'] = strtolower($gp_role);
                                            $data['groups'][0]['primary'] = true;
                                            $data['groups'][1]['id'] = $row->second_group;
                                            $data['groups'][1]['status'] = $sec_status;
                                            $data['groups'][1]['role'] = strtolower($sec_role);
                                            $data['groups'][1]['primary'] = false;
                                        	$general_setting = Modules::run('api/_get_specific_table_with_pagination',array('outlet_id' => $data['outlet_id']),'id asc','general_setting','document_name','1','1')->result_array();
                                            if (isset($general_setting[0]['document_name']) && !empty($general_setting[0]['document_name']))
                                                $document_name = $general_setting[0]['document_name'];
                                        }
                                        else
                                            $message = "Please change the role of group, contact to admin";
                                    }
                                    else
                                        $message = "Please change the role of group, contact to admin";
                                }
                                else
                                    $message = "Group is temporary blocked by the admin";
                            }
                            else
                                $message = "Invalid group assign to user";
                        }
                        else
                            $message= "User can not be member of any Group";
                    }
                    else
                        $message= "User can not be member of any Business";
                }
                else
                    $message = "Invalid username and password";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data,'document_name'=>$document_name));
    }
    function user_profile_update() {
        $status=false;
        $message="parameter missing";
        $user_id = $this->input->post('user_id');
        $api_key = $this->check_user_api_key();
        if($api_key['key_status'] == true) {
            if(is_numeric($user_id) && !empty($user_id) && $user_id >0) {
                $user=Modules::run('api/get_specific_table_data',array("id"=>$user_id,"status"=>"1"),"id desc","user_name,user_image","users","1","1")->result_array();
                if(!empty($user)) {
                    $data = $this->get_user_post_data();
                    Modules::run('api/update_specific_table',array("id"=>$user_id),$data,'users');
                    $status = true;
                    $message = "user profile update";
                }
                else
                    $message = "user does not exist or temporary blocked";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function user_picture_update() {
        $status=false;
        $message="parameter missing";
        $user_id = $this->input->post('user_id');
        $api_key = $this->check_user_api_key();
        $user_image = STATIC_FRONT_IMAGE.'user.png';
        if($api_key['key_status'] == true) {
            if(is_numeric($user_id) && !empty($user_id) && $user_id >0) {
                $user=Modules::run('api/get_specific_table_data',array("id"=>$user_id,"status"=>"1"),"id desc","user_name,user_image","users","1","1")->result_array();
                if(!empty($user)) {
                    if(isset($_FILES['user_image'])) {
                        if ($_FILES['user_image']['size'] > 0) {
                            if(isset($user[0]['user_image']) && !empty($user[0]['user_image']))
                                Modules::run("api/delete_images_by_name",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$user[0]['user_image']);
                            Modules::run("api/upload_dynamic_image",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$user_id,'user_image','user_image','id','users');
                            $status=true;
                            $message="user image update";
                            $user=Modules::run('api/get_specific_table_data',array("id"=>$user_id,"status"=>"1"),"id desc","user_name,user_image","users","1","1")->result_array();
                            if(isset($user[0]['user_image']) && !empty($user[0]['user_image']))
                                $user_image = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user[0]['user_image'],STATIC_FRONT_IMAGE,'user.png');
                        }
                        else
                            $message = "please select the image";
                    }
                    else
                        $message = "please select the image";
                }
                else
                    $message = "user does not exist or temporary blocked";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"user_image"=>$user_image));
    }
    function admin_password_reset_email() {
        $status= false;
        $message="Parameter missing";
        $email = $this->input->post("email");
        $api_key = $this->check_developer_api_key();
        if($api_key['key_status'] == true) {
            if(!empty($email)) {
                $checking = Modules::run('api/_get_specific_table_with_pagination',array("email" =>$email), 'id asc','users','user_name,status,outlet_id','1','1')->result_array();
                if(!empty($checking)) {
                    $message = "user data exist";
                    if(isset($checking[0]['status']) && $checking[0]['status'] =='1') {
                        if(isset($checking[0]['outlet_id']) && !empty($checking[0]['outlet_id']) && is_numeric($checking[0]['outlet_id']) && $checking[0]['outlet_id'] >0 ) {
                            date_default_timezone_set("Asia/karachi");
                            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$checking[0]['outlet_id']), 'id asc','general_setting','timezones','1','1')->result_array();
                            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                                date_default_timezone_set($timezone[0]['timezones']);
                            $user_name = "";
                            if(isset($checking[0]['user_name']) && !empty($checking[0]['user_name']))
                                $user_name = $checking[0]['user_name'];
                            $status = true;
                            $message = "Please check your email.";
                            $currentDate = strtotime(date("Y-m-d H:i:s"));
                            $futureDate = $currentDate+(60*5);
                            $formatDate = date("Y-m-d H:i:s", $futureDate);
                            $unique_number = substr(md5(uniqid(rand(), true)), 8, 8);
                            for ($today=1; $today <70 ; $today++) {
                                $unique_number =substr(md5(uniqid(rand(), true)), 8, 8);
                                $check_number = Modules::run('api/_get_specific_table_with_pagination',array("verification_code" =>$unique_number), 'id asc','users','verification_code','1','1')->result_array();
                                if (!empty($check_number))  {
                                    break;
                                }
                            }
                            Modules::run('api/update_specific_table',array("email" =>$email),array("verification_code" =>$unique_number,"code_datetime"=>$formatDate),"users");
                            $this->load->library('email');
                            $user = "delivery@heyfood.pk";
                             $pass = "{fltq9H]IhRd";
                             $host = 'ssl://mail.heyfood.pk';
                             $port=465;
                             $default_email="hwtechnologiez@gmail.com";

                            $config = Array(
                              'protocol' => 'smtp',
                              'smtp_host' => $host,
                              'smtp_port' => $port,
                              'smtp_user' =>  $user,
                              'smtp_pass' =>  $pass,
                              'mailtype'  => 'html', 
                              'starttls'  => true,
                              'newline'   => "\r\n"
                            );   

                            $this->email->initialize($config);
                            $this->email->from($user, 'QA242');
                           
                            $this->email->to($email);
                            $this->email->subject('QA242' . ' - Reset Password');
                            $this->email->message('<p>Dear ' . $user_name . ',<br><br> Your reset password verification code is <b>'.$unique_number . '</b>. Please use with in 5 minutes to verifiy your account. </br>With Best Regards,<br>' . 'QA242' . 'Team');
                            $this->email->send();
                        }
                        else
                            $message = "Sorry now you are not be a part of any business.";
                    }
                    else
                        $message = "your account is temporary block, contact to admin.";
                }
                else
                    $message = "Invalid email address.";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
    }
    function admin_password_code_verification() {
        $status = false;
        $message="Please fill the code.";
        $code = $this->input->post("code");
        $checking = array();
        $api_key = $this->check_developer_api_key();
        if($api_key['key_status'] == true) {
            if(isset($code) && !empty($code)) {
                $checking = Modules::run('api/_get_specific_table_with_pagination',array("verification_code" =>$code), 'id asc','users','user_name,email,outlet_id,code_datetime','1','1')->result_array();
                if(!empty($checking)) {
                    if(isset($checking[0]['outlet_id']) && !empty($checking[0]['outlet_id']) && is_numeric($checking[0]['outlet_id']) && $checking[0]['outlet_id'] >0 ) {
                        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$checking[0]['outlet_id']), 'id asc','general_setting','timezones','1','1')->result_array();
                        if(!empty($timezone)) {
                            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones'])) {
                                date_default_timezone_set($timezone[0]['timezones']);
                                $currentDate = date("Y-m-d H:i:s");
                                if($currentDate <= $checking[0]['code_datetime']) {
                                    $status = true;
                                    $message = "verification code is confirmed.";
                                }
                                else
                                    $message = "Verification code is expired, Please try again.";
                            }
                            else
                                $message = "TimeZone is not specified by the Business.";
                        }
                        else
                            $message = "TimeZone is not specified by the Business.";

                        unset($checking[0]['outlet_id']);
                        unset($checking[0]['user_name']);
                    }
                    else
                        $message = "Sorry now you are not be a part of any Business.";
                }
                else
                    $message = "Invalid verificaiton code.";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message,"data"=>$checking));
    }
    function admin_verification_password_update() {
        $status = false;
        $message="Please fill the code.";
        $email = $this->input->post("email");
        $new_password = $this->input->post("new_password");
        $confirm_password = $this->input->post("confirm_password");
        $api_key = $this->check_developer_api_key();
        if($api_key['key_status'] == true) {
            if(isset($email) && !empty($email) && isset($new_password) && !empty($new_password) && isset($confirm_password) && !empty($confirm_password)) {
                $checking = Modules::run('api/_get_specific_table_with_pagination',array("email" =>$email), 'id asc','users','outlet_id,status','1','1')->result_array();
                if(!empty($checking)) {
                    if(isset($checking[0]['outlet_id']) && !empty($checking[0]['outlet_id']) && is_numeric($checking[0]['outlet_id']) && $checking[0]['outlet_id'] >0 ) {
                        if(isset($checking[0]['status']) && $checking[0]['status'] =='1') {
                            if($new_password == $confirm_password) {
                                $status = true;
                                $message = "password update";
                                Modules::run('api/update_specific_table',array("email" =>$email),array("password" =>md5($new_password)),"users");
                            }
                            else
                                $message = "confirm password can not be matched.";
                        }
                        else
                            $message = "your account is temporary block, contact to owner.";
                    }
                    else
                        $message = "Sorry now you are not be a part of any Business.";
                }
                else
                    $message = "User does not exist";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
    }
    function update_user_password() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $old_password = $this->input->post("old_password");
        $new_password = $this->input->post("new_password");
        $api_key = $this->check_user_api_key();
        if($api_key['key_status'] == true) {
            if(isset($user_id) && !empty($user_id) && isset($new_password) && !empty($new_password) && isset($old_password) && !empty($old_password)) {
                $checking = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$user_id,'password'=>md5($old_password)), 'id asc','users','outlet_id,status','1','1')->result_array();
                if(!empty($checking)) {
                    if(isset($checking[0]['outlet_id']) && !empty($checking[0]['outlet_id']) && is_numeric($checking[0]['outlet_id']) && $checking[0]['outlet_id'] >0 ) {
                        if(isset($checking[0]['status']) && $checking[0]['status'] =='1') {
                            $status = true;
                            $message = "password update";
                            Modules::run('api/update_specific_table',array("id" =>$user_id),array("password" =>md5($new_password)),"users");
                        }
                        else
                            $message = "your account is temporary block, contact to owner.";
                    }
                    else
                        $message = "Sorry now you are not be a part of any Business.";
                }
                else
                    $message = "User does not exist or invalid password";
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
    }
    function get_user_notification() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $outlet_id = $this->input->post("outlet_id");
        $api_key = $this->check_user_api_key();
        $page_number=$this->input->post('page_number');
        if(!is_numeric($page_number))
            $page_number = 1;
        $limit=$this->input->post('limit');
        if(!is_numeric($limit))
            $limit = 20;
        $total_pages=0;
        if($api_key['key_status'] == true) {
            if(!empty($outlet_id) && !empty($user_id) && is_numeric($outlet_id) && is_numeric($user_id) && $outlet_id > 0 && $user_id > 0) {
                $status = true;
                $message = "User notifications";
                $notifications = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("user_id"=>$user_id,"outlet_id"=>$outlet_id),'notification_id desc','notification_id','notification','notification_id,assingment_id,notification_message as message, notification_datetime as datetime,outlet_id',$page_number,$limit,'','','')->result_array();
                if(!empty($notifications)) {
                    $temp =array();
                    foreach ($notifications as $key => $noti):
                        $noti['title'] = '';
                        if(isset($noti['assingment_id']) && !empty($noti['assingment_id']) && isset($noti['outlet_id']) && !empty($noti['outlet_id'])) {
                            $assignment_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("assign_id"=>$noti['assingment_id']),'assign_id desc','assign_id',$noti['outlet_id'].'_assignments','checkid','1','1','','','')->result_array();
                            if(isset($assignment_detail[0]['checkid']) && !empty($assignment_detail[0]['checkid'])) {
                                $check_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$assignment_detail[0]['checkid']),'id desc','id',$noti['outlet_id'].'_product_checks','checkname','1','1','','','')->result_array();
                                 if(isset($check_detail[0]['checkname']) && !empty($check_detail[0]['checkname'])) $noti['title']=$check_detail[0]['checkname']; $noti['title']=  Modules::run('api/string_length',$noti['title'],'8000',''); 
                            }
                        }
                        $temp[] = $noti;
                    endforeach;
                    $notifications = $temp;
                    Modules::run('api/update_specific_table',array("user_id"=>$user_id,"outlet_id"=>$outlet_id),array("notification_status"=>'0'),'notification');
                    $total_pages =  Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("user_id"=>$user_id,"outlet_id"=>$outlet_id),'notification_id desc','notification_id','notification','notification_id,assingment_id,notification_message as message, notification_datetime as datetime',$page_number,'0','','','')->num_rows();
                        $diviser=($total_pages/$limit);
                        $reminder=($total_pages%$limit);
                        if($reminder>0)
                           $total_pages=intval($diviser)+1;
                        else
                            $total_pages=intval($diviser);
                }

            }
            else
                $message = "Invalid user or business";
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message,"notifications"=>$notifications,'page_number'=>$page_number,"total_pages"=>$total_pages));
    }
    function mobile_user_logout() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $outlet_id = $this->input->post("outlet_id");
        $key = $this->input->post('session_token');
        if(!empty($outlet_id) && !empty($user_id) && is_numeric($outlet_id) && is_numeric($user_id) && $outlet_id > 0 && $user_id > 0) {
            $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_id,"outlet_id"=>$outlet_id),'id desc','id','users','id','1','1','','','')->result_array();
            if(!empty($user_detail)) {
                $status = true;
                $message = "User notifications";
                Modules::run('api/update_specific_table',array("id"=>$user_id,"outlet_id"=>$outlet_id,"token"=>$key),array("fcm_token"=>'',"token"=>'','is_online'=>'0'),'users');
            }
            else
                $message = "Invalid user";
        }
        else
            $message = "Invalid user or business";
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
    }
    function user_chat_list() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $outlet_id = $this->input->post("outlet_id");
        $api_key = $this->check_user_api_key();
        $key = $this->input->post('session_token');
        $left_panel = array();
        if($api_key['key_status'] == true) {
            if(!empty($outlet_id) && !empty($user_id) && is_numeric($outlet_id) && is_numeric($user_id) && $outlet_id > 0 && $user_id > 0) {
                $user_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$user_id,"outlet_id" =>$outlet_id,"status"=>"1"),'id desc','users','group,second_group','1','1')->result_array();
                if(!empty($user_detail)) {
                    $status = true;
                    $message = "User left panel";
                    $primary_group = '0';
                    if(isset($user_detail[0]['group']) && !empty($user_detail[0]['group'])) {
                        $primary_group = $user_detail[0]['group'];
                        $temp['id'] = $user_detail[0]['group'];
                        $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_detail[0]['group']),'id desc','id',$outlet_id.'_groups','group_title','1','0','','','')->result_array();
                        $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                        $temp['trackig_id'] = 'G_'.$user_detail[0]['group'];
                        $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$user_detail[0]['group']), 'chat_id desc','chat_id',$outlet_id,'message,chat_id','1','1','','','')->result_array();
                        $temp['last_message'] = ""; if(isset($group_message[0]['message']) && !empty($group_message[0]['message'])) $temp['last_message']=$group_message[0]['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                        $temp['last_chat'] = "0";
                        if(isset($group_message[0]['chat_id']) && !empty($group_message[0]['chat_id'])) 
                            $temp['last_chat']=$group_message[0]['chat_id'];
                        $temp['type'] = 'group';
                        $temp['image'] = STATIC_FRONT_IMAGE.'group.png';
                        $temp['next_chat'] = true;
                        $left_panel[] = $temp;
                        unset($temp);
                    }
                    $secondry_group = '0';
                    if(isset($user_detail[0]['second_group']) && !empty($user_detail[0]['second_group'])) {
                        $secondry_group = $user_detail[0]['second_group'];
                        if(!isset($user_detail[0]['group']))
                            $user_detail[0]['group'] = '';
                        if($user_detail[0]['group'] != $user_detail[0]['second_group']) {
                            $temp['id'] = $user_detail[0]['second_group'];
                            $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_detail[0]['second_group']),'id desc','id',$outlet_id.'_groups','group_title','1','0','','','')->result_array();
                            $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                            $temp['trackig_id'] = 'G_'.$user_detail[0]['second_group'];
                            $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$user_detail[0]['second_group']), 'chat_id desc','chat_id',$outlet_id,'message,chat_id','1','1','','','')->result_array();
                            $temp['last_message'] = ""; if(isset($group_message[0]['message']) && !empty($group_message[0]['message'])) $temp['last_message']=$group_message[0]['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                            $temp['last_chat'] = "0";
                            if(isset($group_message[0]['chat_id']) && !empty($group_message[0]['chat_id'])) 
                                $temp['last_chat']=$group_message[0]['chat_id'];
                            $temp['type'] = 'group';
                            $temp['image'] = STATIC_FRONT_IMAGE.'group.png';
                            $temp['next_chat'] = true;
                            $left_panel[] = $temp;
                            unset($temp);
                        }
                    }
                    $group_chat = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id !="=>'0'), 'chat_id desc','group_id',$outlet_id.'_chat_detail','group_id','1','0','(`message_to` = "'.$user_id.'" OR `message_from` = "'.$user_id.'")','(`group_id` != "'.$primary_group.'" AND `group_id` != "'.$secondry_group.'")','')->result_array();
                    if(!empty($group_chat)) {
                        foreach ($group_chat as $key => $gc):
                            $temp['id'] = $gc['group_id'];
                            $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$gc['group_id']),'id desc','id',$outlet_id.'_groups','group_title','1','0','','','')->result_array();
                            $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                            $temp['trackig_id'] = 'G_'.$user_detail[0]['second_group'];
                            $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$gc['group_id']), 'chat_id desc','group_id',$outlet_id,'message,chat_id','1','1','','','')->result_array();
                            $temp['last_message'] = ""; if(isset($group_message[0]['message']) && !empty($group_message[0]['message'])) $temp['last_message']=$group_message[0]['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                            $temp['last_chat'] = "0";
                            if(isset($group_message[0]['chat_id']) && !empty($group_message[0]['chat_id'])) 
                                $temp['last_chat']=$group_message[0]['chat_id'];
                            $temp['type'] = 'group';
                            $temp['image'] = STATIC_FRONT_IMAGE.'user.png';
                            $temp['next_chat'] = false;
                            $left_panel[] = $temp;
                            unset($temp);
                        endforeach;
                    }
                    $previous_user = array();
                    $group_chat = Modules::run('admin_api/get_chat_detail',array("group_id"=>'0'), 'chat_id desc','chat_id',$outlet_id,'message_to,message_from,chat_detail.message_id,message,chat_id','1','0','(`message_to` = "'.$user_id.'" OR `message_from` = "'.$user_id.'")','','','')->result_array();
                    if(!empty($group_chat)) {
                        foreach ($group_chat as $key => $gc):
                            if(isset($gc['message_to']) && !empty($gc['message_to'])) {
                                if($gc['message_to'] != $user_id) {
                                    $temp = $pre_temp = array();
                                    $key = array_search($gc['message_to'], array_column($previous_user, 'user_id'));
                                    if(!is_numeric($key)) {
                                        $pre_temp['user_id'] = $temp['id'] = $gc['message_to'];
                                        $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$gc['message_to']),'id desc','id','users','first_name,last_name,user_image,is_online','1','1','','','')->result_array();
                                        $first_name = "";
                                        if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                            $first_name=$user_detail[0]['first_name'];
                                        $second_name = "";
                                        if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                                            $second_name=$user_detail[0]['last_name'];
                                        $temp['name']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                        if($user_id > $gc['message_to'])
                                            $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$user_id.'_'.$gc['message_to'];
                                        else
                                            $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$gc['message_to'].'_'.$user_id;
                                        $temp['last_message'] = ""; if(isset($gc['message']) && !empty($gc['message'])) $temp['last_message']=$gc['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                                        $temp['last_chat'] = "0";
                                        if(isset($gc['chat_id']) && !empty($gc['chat_id'])) 
                                            $temp['last_chat']=$gc['chat_id'];
                                        $temp['last_message'];
                                        $temp['is_online'] = false;
                                        if(isset($user_detail[0]['is_online']) && !empty($user_detail[0]['is_online'])) 
                                            $temp['is_online']=true;
                                        $temp['type'] = 'user';
                                        $user_image = "user.png"; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $user_image=$user_detail[0]['user_image']; $user_image=  Modules::run('api/string_length',$user_image,'8000','');

                                        $temp['image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                                        $temp['next_chat'] = true;
                                        $left_panel[] = $temp;
                                        $previous_user[] = $pre_temp;
                                        unset($temp);
                                    }
                                }
                            }
                            if(isset($gc['message_from']) && !empty($gc['message_from'])) {
                                if($gc['message_from'] != $user_id) {
                                    $temp = $pre_temp = array();
                                    $key = array_search($gc['message_from'], array_column($previous_user, 'user_id'));
                                    if(!is_numeric($key)) {
                                        $pre_temp['user_id'] = $temp['id'] = $gc['message_from'];
                                        $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$gc['message_from']),'id desc','id','users','first_name,last_name,user_image,is_online','1','1','','','')->result_array();
                                        $first_name = "";
                                        if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                            $first_name=$user_detail[0]['first_name'];
                                        $second_name = "";
                                        if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                                            $second_name=$user_detail[0]['last_name'];
                                        $temp['name']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                        if($user_id > $gc['message_from'])
                                            $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$user_id.'_'.$gc['message_from'];
                                        else
                                            $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$gc['message_from'].'_'.$user_id;
                                        $temp['last_message'] = ""; if(isset($gc['message']) && !empty($gc['message'])) $temp['last_message']=$gc['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                                        $temp['last_chat'] = "0";
                                        if(isset($gc['chat_id']) && !empty($gc['chat_id'])) 
                                            $temp['last_chat']=$gc['chat_id'];
                                        $temp['last_message'];
                                        $temp['is_online'] = false;
                                        if(isset($user_detail[0]['is_online']) && !empty($user_detail[0]['is_online'])) 
                                            $temp['is_online']=true;
                                        $temp['type'] = 'user';
                                        $user_image = "user.png"; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $user_image=$user_detail[0]['user_image']; $user_image=  Modules::run('api/string_length',$user_image,'8000','');

                                        $temp['image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                                        $temp['next_chat'] = true;
                                        $left_panel[] = $temp;
                                        $previous_user[] = $pre_temp;
                                        unset($temp);
                                    }
                                }
                            }
                        endforeach;
                    }
                }
                else
                    $message = "Invalid user";
                
            }
            else
                $message = "Invalid user or business";
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message, "left_panel" => $left_panel));
    }
    function get_users_list() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $outlet_id = $this->input->post("outlet_id");
        $api_key = $this->check_user_api_key();
        $left_panel = $group_panel = array();
        if($api_key['key_status'] == true) {
            if(!empty($outlet_id) && !empty($user_id) && is_numeric($outlet_id) && is_numeric($user_id) && $outlet_id > 0 && $user_id > 0) {
                $user_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$user_id,"outlet_id" =>$outlet_id,"status"=>"1"),'id desc','users','group,second_group','1','1')->result_array();
                if(!empty($user_detail)) {
                    $status = true;
                    $message = "Contact list";
                    $primary_group = '0';
                    if(isset($user_detail[0]['group']) && !empty($user_detail[0]['group'])) {
                        $primary_group = $user_detail[0]['group'];
                        $temp['id'] = $user_detail[0]['group'];
                        $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_detail[0]['group']),'id desc','id',$outlet_id.'_groups','group_title','1','0','','','')->result_array();
                        $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                        $temp['trackig_id'] = 'G_'.$user_detail[0]['group'];
                        $temp['type'] = 'group';
                        $temp['image'] = STATIC_FRONT_IMAGE.'group.png';
                        $left_panel[] = $temp;
                        unset($temp);
                    }
                    $secondry_group = '0';
                    if(isset($user_detail[0]['second_group']) && !empty($user_detail[0]['second_group'])) {
                        $secondry_group = $user_detail[0]['second_group'];
                        if(!isset($user_detail[0]['group']))
                            $user_detail[0]['group'] = '';
                        if($user_detail[0]['group'] != $user_detail[0]['second_group']) {
                            $temp['id'] = $user_detail[0]['second_group'];
                            $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_detail[0]['second_group']),'id desc','id',$outlet_id.'_groups','group_title','1','0','','','')->result_array();
                            $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                            $temp['trackig_id'] = 'G_'.$user_detail[0]['second_group'];
                            $temp['type'] = 'group';
                            $temp['image'] = STATIC_FRONT_IMAGE.'group.png';
                            $left_panel[] = $temp;
                            unset($temp);
                        }
                    }
                    $group_panel = $left_panel;
                    $left_panel = $previous_user = array();
                    $group_users= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id" =>$outlet_id,"status"=>"1",'id !='=>$user_id),'id desc','id','users','id,first_name,last_name,user_image,is_online','1','0','','','')->result_array();
                    if(!empty($group_users)) {
                        foreach ($group_users as $key => $gc):
                            $pre_temp['user_id'] = $temp['id'] = $gc['id'];
                            $first_name = "";
                            if(isset($gc['first_name']) && !empty($gc['first_name'])) 
                                $first_name=$gc['first_name'];
                            $second_name = "";
                            if(isset($gc['last_name']) && !empty($gc['last_name'])) 
                                $second_name=$gc['last_name'];
                            $pre_temp['name'] = $temp['name']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                            if($user_id > $gc['id'])
                                $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$user_id.'_'.$gc['id'];
                            else
                                $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$gc['id'].'_'.$user_id;
                            $pre_temp['type'] = $temp['type'] = 'user';
                            $user_image = "user.png"; if(isset($gc['user_image']) && !empty($gc['user_image'])) $user_image=$gc['user_image']; $user_image=  Modules::run('api/string_length',$user_image,'8000','');

                            $pre_temp['image'] = $temp['image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                            $pre_temp['is_online'] = $temp['is_online'] = false;
                            if(isset($gc['is_online']) && !empty($gc['is_online'])) 
                                $pre_temp['is_online'] = $temp['is_online'] = true;
                            $left_panel[] = $temp;
                            $previous_user[] = $pre_temp;
                            unset($temp);
                        endforeach;
                    }
                }
                else
                    $message = "Invalid user";
            }
            else
                $message = "Invalid user or business";
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message,"user_list"=>$left_panel,'group_list'=>$group_panel));
    }
    function send_user_message() {
        $status = false;
        $message="Something went wrong";
        $outlet_id = $this->input->post("outlet_id");
        $cheatertype = $this->input->post('chattype');
        $send_message = $this->input->post('message');
        $to = $this->input->post('to');
        $from = $this->input->post('user_id');
        $name = "";
        $chat_id = 0;
        $user_image = STATIC_FRONT_IMAGE.'user.png';
        $api_key = $this->check_user_api_key();
        date_default_timezone_set("Asia/karachi");
        $createdat = date("Y-m-d H:i:s");
        if($api_key['key_status'] == true) {
            if(!empty($send_message) && !empty($cheatertype) && !empty($outlet_id) && !empty($to) && !empty($from)) {
                $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
                if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                    date_default_timezone_set($timezone[0]['timezones']);
                    $createdat = date("Y-m-d H:i:s");
                $status = true;
                $message = "Message Send";
                $message_id = Modules::run('api/insert_into_specific_table',array("message"=>$send_message),$outlet_id.'_messages');
                if($cheatertype == 'user') {
                    $chat_id = Modules::run('api/insert_into_specific_table',array("message_to"=>$to,"message_from"=>$from,"message_id"=>$message_id,"message_datetime"=>$createdat,"group_id"=>"0"),$outlet_id.'_chat_detail');
                }
                elseif($cheatertype == 'group') {
                    $group_users = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','id','1','0','(`second_group`="'.$to.'" or `group`="'.$to.'")','','')->result_array();
                    if(!empty($group_users)) {
                        foreach ($group_users as $key => $gu):
                            $chat_id = Modules::run('api/insert_into_specific_table',array("message_to"=>$gu['id'],"message_from"=>$from,"message_id"=>$message_id,"message_datetime"=>$createdat,"group_id"=>$to),$outlet_id.'_chat_detail');
                        endforeach;
                    }
                }
                else
                    echo "";
                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$from),'id desc','id','users','first_name,last_name,user_image','1','1','','','')->result_array();
                $first_name = "";
                if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                    $first_name=$user_detail[0]['first_name'];
                $second_name = "";
                if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                    $second_name=$user_detail[0]['last_name'];
                $name=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                $user_image = "user.png"; 
                if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) 
                    $user_image=$user_detail[0]['user_image']; 
                $user_image=  Modules::run('api/string_length',$user_image,'8000','');
                $user_image = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
            }
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message, "chat_id" => $chat_id, "chat_id" => $chat_id, "createdAt" => $createdat, "text" => $send_message, "user_id" => $from, "user_name" => $name, "user_image" => $user_image));
    }
    function change_status_for_review() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $outlet_id = $this->input->post("outlet_id");
        $assign_id = $this->input->post('assign_id');
        $review_comments=$this->input->post('review_comments');
        $api_key = $this->check_user_api_key();
        if($api_key['key_status'] == true) {
            if(!empty($outlet_id) && !empty($user_id) && is_numeric($outlet_id) && is_numeric($user_id) && $outlet_id > 0 && $user_id > 0) {
                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_id,"outlet_id"=>$outlet_id,'status'=>'1'),'id desc','id,user_name','users','id','1','1','','','')->result_array();
                if(!empty($user_detail)) {
                    if(!empty($assign_id)&& is_numeric($assign_id)&& $assign_id > 0) {
                        $check_reassign= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("reassign_id"=>$assign_id),'assign_id desc','assign_id',$outlet_id.'_assignments','assign_id','1','0','(`assign_status` ="Open" OR `assign_status` ="OverDue")' ,'','')->result_array();
                        if(empty($check_reassign)) {
                            $status = true;
                            $message = "Assignment has been reviewed";
                            $where['assign_id']=$assign_id;
                            date_default_timezone_set("Asia/karachi");
                            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
                            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                                date_default_timezone_set($timezone[0]['timezones']);
                            $data = array('assign_status' =>'Approval',"review_user"=>$user_id,"review_datetime"=>date("Y-m-d H:i:s"),"review_comments"=>$review_comments);
                            /////////// notification code umar start///////////
                            $assign_name = "Assignment Name";
                            $assign_detail = Modules::run('api/_get_specific_table_with_pagination',array("assign_id"=>$assign_id),'assign_id desc',$outlet_id.'_assignments','checkid','1','1')->result_array();
                            if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid'])) {
                                $product_checks_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_detail[0]['checkid']),'id desc',$outlet_id.'_product_checks','checkname','1','1')->result_array();
                                if(isset($product_checks_detail[0]['checkname']) && !empty($product_checks_detail[0]['checkname']))
                                    $assign_name = $product_checks_detail[0]['checkname'];
                            }
                            $review_group = Modules::run('api/_get_specific_table_with_pagination',array("assign_id" =>$assign_id),'assign_id desc',$outlet_id.'_assignments','approval_team','1','1')->result_array();
                            if(isset($review_group[0]['approval_team']) && !empty($review_group[0]['approval_team'])) {
                                $fcm_token = Modules::run('api/_get_specific_table_with_pagination_and_where',array("fcm_token !="=>"",'status'=>'1'),'id desc','users','fcm_token','1','0','(`second_group`="'.$review_group[0]['approval_team'].'" or `group`="'.$review_group[0]['approval_team'].'")','','')->result_array();
                                $user_name = "";
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
                                        Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$ui['id'],"outlet_id"=>$outlet_id,"notification_message"=>$assign_name." has been reviewed by ".$user_name.", please review and approve the provided information.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                    endforeach;
                                }
                            }
                            /////////// notification code umar end///////////
                            Modules::run('api/update_specific_table',$where,$data,$outlet_id.'_assignments');
                        }
                        else
                            $message = "Check could not be reviewed because it is in reassigne state";
                    }
                    else
                        $message = "Invalid Assignment";
                }
                else
                    $message = "Invalid user";
            }
            else
                $message = "Invalid user or business";
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
    }
    function change_status_for_approve() {
        $status = false;
        $message="Please fill the code.";
        $user_id = $this->input->post("user_id");
        $outlet_id = $this->input->post("outlet_id");
        $assign_id = $this->input->post('assign_id');
        $api_key = $this->check_user_api_key();
        if($api_key['key_status'] == true) {
            if(!empty($outlet_id) && !empty($user_id) && is_numeric($outlet_id) && is_numeric($user_id) && $outlet_id > 0 && $user_id > 0) {
                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_id,"outlet_id"=>$outlet_id,'status'=>'1'),'id desc','id,user_name','users','id','1','1','','','')->result_array();
                if(!empty($user_detail)) {
                    if(!empty($assign_id)&& is_numeric($assign_id)&& $assign_id > 0) {
                        $status = true;
                        $message = "Assignment has been Approved";
                        $where['assign_id']=$assign_id;
                        date_default_timezone_set("Asia/karachi");
                        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
                        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                            date_default_timezone_set($timezone[0]['timezones']);
                        $data = array('assign_status' =>'Completed',"approval_user"=>$user_id,"approval_datetime"=>date("Y-m-d H:i:s"));
                         Modules::run('api/update_specific_table',$where,$data,$outlet_id.'_assignments');
                    
                    }
                    else
                        $message = "Invalid Assignment";
                }
                else
                    $message = "Invalid user";
            }
            else
                $message = "Invalid user or business";
        }
        else
            $message = $api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
    }
    function check_user_api_key() {
        $key_status = false;
        $key_message = "Invalid User Token";
        $key = $this->input->post('session_token');
        $user_id = $this->input->post('user_id');
        $key_detail = Modules::run('api/_get_specific_table_with_pagination',array("token" =>$key,"id" =>$user_id),'token desc','users','token','1','1')->num_rows();
        if($key_detail > 0)
            $key_status = true;
        $array['key_status'] = $key_status;
        $array['key_message'] = $key_message;
        return $array;
    }
    function check_developer_api_key() {
        $key_status = false;
        $key_message = "Invalid Api Key";
        $key = $this->input->post('api_key');
        if(isset($key) && !empty($key)) {
            if(isset($_SERVER['HTTP_DATETIME']) && !empty($_SERVER['HTTP_DATETIME'])) {
                if(isset($_SERVER['HTTP_URL']) && !empty($_SERVER['HTTP_URL'])) {
                    if(isset($_SERVER['HTTP_KEY']) && !empty($_SERVER['HTTP_KEY'])) {
                        if(base64_encode(hash_hmac('sha1',$_SERVER['HTTP_DATETIME'].$_SERVER['HTTP_URL'], $key)) == base64_encode($_SERVER['HTTP_KEY'])) {
                            $key_detail = Modules::run('api/_get_specific_table_with_pagination',array("dak_key" =>$key,"dak_status"=>"1"),'dak_id desc','developer_api_key','dak_id','1','1')->num_rows();
                            if($key_detail > 0)
                                $key_status = true;
                        }
                    }
                }
                else
                    $key_message = "Bad Request";
            }
            else
                $key_message = "Bad Request";
        }
        $array['key_status'] = $key_status;
        $array['key_message'] = $key_message;
        return $array;
    }
    function get_user_post_data() {
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['phone'] = $this->input->post('phone');
        return $data;
    }
    
    
    function basic_outlet_detail() {
        $status=false;
        $message="parameter missing";
        $outlet_id = $this->input->post('outlet_id');
        $data= array();
        if(!empty($outlet_id)) {
            $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
            if(!empty($timezone)) {
                $status = true;
                $message = "Basic information on outlet";
                $data['cancelled'] = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id,"order_status"=>"Cancelled"),'id desc','users_orders','order_status','1','0')->num_rows();
                $data['complete'] = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id,"order_status"=>"Delivered"),'id desc','users_orders','order_status','1','0')->num_rows();
                $data['total'] = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id),'id desc','users_orders','order_status','1','0')->num_rows();
                $data['queue'] = $data['total'] - ($data['complete'] + $data['cancelled']);
                $data['open_close']='Closed';
                if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones'])) {
                    date_default_timezone_set($timezone[0]['timezones']);
                    $timing=Modules::run('outlet/outlet_open_close',array("timing.outlet_id"=>$outlet_id,"timing.day"=>date('l'),"timing.opening <="=>date('H:i:s')),"(CASE WHEN closing < opening THEN '23:59:59' else  closing END) AS closssing,is_closed",array("closssing >="=>date('H:i:s')))->result_array();
                    if(!empty($timing)) {
                        if($timing[0]['is_closed'] ==0)
                            $data['open_close']='Open';
                    }
                }
            }
            else
                $message = "invalid outlet";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data));
    }
    function outlet_order_list() {
        $status=false;
        $message="parameter missing";
        $outlet_id = $this->input->post('outlet_id');
        $list_status = $this->input->post('status');
        $user_type = $this->input->post('user_type');
        $page_number=$this->input->post('page_number');
        if(!is_numeric($page_number))
            $page_number = 1;
        $limit=$this->input->post('limit');
        if(!is_numeric($limit))
            $limit = 20;
        $total_pages=0;
        $data = array();
        if(!empty($outlet_id) && !empty($list_status) && !empty($user_type)) {
            $user_check = 0;
            if($user_type == "admin" || $user_type == "chef")
                $user_check = 1;                
            if($user_check == 1) {
                $list_check = 1;
                if($list_status == 'Cancelled' && $user_type == "admin")
                    $list_where['order_status'] = "Cancelled";
                elseif($list_status == 'Completed' && $user_type == "admin")
                    $list_where['order_status'] = "Delivered";
                elseif($list_status == 'Inqueue' && $user_type == "admin")
                    $list_where=$this->get_and_where(array('Cancelled','Delivered'),'order_status!');
                elseif($list_status == 'Completed' && $user_type == "chef")
                    $list_where['order_status'] = "Ready";
                elseif($list_status == 'Inqueue' && $user_type == "chef")
                    $list_where['order_status'] = "Accepted";
                else
                    $list_check = 0;
                if($list_check == 1) {
                    $status = true;
                    $message = "outlet order list";
                    $data = $this->get_outlet_order_list(array("users_orders.outlet_id"=>$outlet_id),'users_orders.id desc',$outlet_id,"users_orders.order_id,users_orders.order_status,total_price,create_date",$list_where,$page_number,$limit)->result_array();
                    if(!empty($data)) {
                        $total_pages = $this->get_outlet_order_list(array("users_orders.outlet_id"=>$outlet_id),'users_orders.id desc',$outlet_id,"users_orders.order_id,users_orders.order_status,total_price,create_date",$list_where,$page_number,'0')->num_rows();
                        $diviser=($total_pages/$limit);
                        $reminder=($total_pages%$limit);
                        if($reminder>0)
                           $total_pages=intval($diviser)+1;
                        else
                            $total_pages=intval($diviser);
                    }
                }
                else
                    $message = "invalid list required";
            }
            else
                $message = "invalid user";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    
    function outlet_order_detail() {
        $status=false;
        $message="parameter missing";
        $order_no = $this->input->post('order_no');
        $outlet_id = $this->input->post('outlet_id');
        $order_detail = array();
        $final_array =array();
        $final_array['Rating'] = "";
        if(is_numeric($order_no) && is_numeric($outlet_id)) {
            $message = "order detail does not exist";
            $order_detail = Modules::run('slider/_get_where_cols',array("id" =>$order_no),'id desc',$outlet_id.'_orders','id as Orderid,create_date as Orderdate,subtotal as Subtotal,total_price as Ordertotal,delivery_lat as Lat,delivery_lang,address as Address,street_no as Street,postcode as Postalcode,city as City,country as Country,houseno as Houseno,total_products as Quantity,customer_name as Name,email as Email,mobile as Mobile')->result_array();
            if(!empty($order_detail)) {
                $order_status=Modules::run('api/_get_user_order_list',array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"users_orders.id desc","users_orders","order_status,user_id,uo_driver_id","","1",'1')->result_array();
                $order_detail[0]['Orderstatus'] = "";
                if(isset($order_status[0]['order_status']) && !empty($order_status[0]['order_status']))
                    $order_detail[0]['Orderstatus'] = $order_status[0]['order_status'];
                if(isset($order_status[0]['user_id']) && !empty($order_status[0]['user_id'])) {
                    $user_rating = Modules::run('api/get_order_items',array("order_id"=>$order_no,"outlet_id"=>$outlet_id,"user_id"=>$order_status[0]['user_id']),"id asc","reviews","user_id,outlet_id,order_id","rating")->result_array();
                    if(isset($user_rating[0]['rating']) && !empty($user_rating[0]['rating']))
                        $final_array['Rating']=$user_rating[0]['rating'];

                }
                if(isset($order_status[0]['uo_driver_id']) && !empty($order_status[0]['uo_driver_id'])) {
                    $driver_detail = Modules::run('slider/_get_where_cols',array("driver_id" =>$order_status[0]['uo_driver_id']),'driver_id desc','driver','driver_first_name,driver_middle_name,driver_last_name,driver_cell_phone')->result_array();
                    $driver_vehicle=Modules::run('api/get_driver_vehicle_info',array("driver_vehicle.driver_id"=>$order_status[0]['uo_driver_id'],"driver_vehicle.dv_active"=>"1"),'driver.driver_id desc','driver_vehicle.vehicle_number')->result_array();
                    $final_driver=array();
                    $driver_name = "N/A";
                    if(isset($driver_detail[0]['driver_first_name']) && !empty($driver_detail[0]['driver_first_name']))
                        $driver_name = $driver_detail[0]['driver_first_name'];
                    if(isset($driver_detail[0]['driver_middle_name']) && !empty($driver_detail[0]['driver_middle_name'])) {
                        if(!empty($driver_name))
                            $driver_name = $driver_name ." ";
                        $driver_name =$driver_name.$driver_detail[0]['driver_middle_name'];
                    }
                    if(isset($driver_detail[0]['driver_last_name']) && !empty($driver_detail[0]['driver_last_name'])) {
                        if(!empty($driver_name))
                            $driver_name = $driver_name ." ";
                        $driver_name =$driver_name.$driver_detail[0]['driver_last_name'];
                    }
                    $final_driver['driver_id'] = $order_status[0]['uo_driver_id'];
                    $final_driver['driver_name'] = $driver_name ;
                    $final_driver['driver_contact'] =$final_driver['vehicle_number']="";
                    if(isset($driver_detail[0]['driver_cell_phone']) && !empty($driver_detail[0]['driver_cell_phone']))
                        $final_driver['driver_contact'] = $driver_detail[0]['driver_cell_phone'];
                     if(isset($driver_vehicle[0]['vehicle_number']) && !empty($driver_vehicle[0]['vehicle_number']))
                        $final_driver['vehicle_number'] = $driver_vehicle[0]['vehicle_number'];
                    $order_detail[0]['driver_detail'] =$final_driver;
                }
                $order_detail[0]['UserDetail']['DeliveryAddress'] = $order_detail[0]['UserDetail']['Street']  = $order_detail[0]['UserDetail']['UserCity'] = $order_detail[0]['UserDetail']['UserCountry'] = $order_detail[0]['UserDetail']['Houseno'] =$order_detail[0]['UserDetail']['UserName'] = $order_detail[0]['UserDetail']['UserEmail'] = $order_detail[0]['UserDetail']['UserPhone'] ="";
                if(!empty($order_detail[0]['Address']))
                    $order_detail[0]['UserDetail']['DeliveryAddress'] = $order_detail[0]['Address'];
                if(!empty($order_detail[0]['Street']))
                    $order_detail[0]['UserDetail']['Street'] = $order_detail[0]['Street'];
                if(!empty($order_detail[0]['City']))
                    $order_detail[0]['UserDetail']['UserCity'] = $order_detail[0]['City'];
                if(!empty($order_detail[0]['Country']))
                    $order_detail[0]['UserDetail']['UserCountry'] = $order_detail[0]['Country'];
                if(!empty($order_detail[0]['Houseno']))
                    $order_detail[0]['UserDetail']['Houseno'] = $order_detail[0]['Houseno'];
                if(!empty($order_detail[0]['Name']))
                    $order_detail[0]['UserDetail']['UserName'] = $order_detail[0]['Name'];
                if(!empty($order_detail[0]['Email']))
                    $order_detail[0]['UserDetail']['UserEmail'] = $order_detail[0]['Email'];
                if(!empty($order_detail[0]['Mobile']))
                    $order_detail[0]['UserDetail']['UserPhone'] = $order_detail[0]['Mobile'];
                unset($order_detail[0]['Houseno']);unset($order_detail[0]['Country']);unset($order_detail[0]['City']);unset($order_detail[0]['Street']);unset($order_detail[0]['Address']);unset($order_detail[0]['Name']);unset($order_detail[0]['Email']);unset($order_detail[0]['Mobile']);
                $status = true;
                $message = "order detail";
                $items = Modules::run('api/get_order_items',array("order_id"=>$order_no,"parent_id"=>"0"),"product_id asc",$outlet_id."_orders_detail","order_id,product_id","product_id,product_name as Productname,product_price as Productprice,quantity as Productquantity,total_product_price as Totalprice")->result_array();
                if(!empty($items)) {
                    $temp=array();
                    foreach ($items as $key => $it) {
                        $it['Sizes'] = false;
                        $sizes = Modules::run('api/get_order_items',array("order_id"=>$order_no,"product_id"=>$it['product_id'],"parent_id"=> "0","check"=>"Size"),"product_id asc",$outlet_id."_orders_detail","","product_name as Name,specs_label as Label,product_price as Price,quantity as Quantity")->result_array();
                        $it['Data'] =array();
                        if(!empty($sizes)) {
                            $it['Sizes'] = true;
                            foreach ($sizes as $key => $value) {
                                $value['Check'] = "Size";
                                $it['Data'][] = $value;
                            }
                        }
                        $add_ons = Modules::run('api/get_order_items',array("order_id"=>$order_no,"parent_id"=>$it['product_id'],"check"=>"Addon"),"product_id asc",$outlet_id."_orders_detail","","product_name as Name,specs_label as Label,product_price as Price,quantity as Quantity")->result_array();
                        if(!empty($add_ons)) {
                            foreach ($add_ons as $key => $value) {
                                $value['Check'] = "Addon";
                                $it['Data'][] = $value;
                            }
                        }
                        unset($it['product_id']);
                        $temp[]=$it;
                    }
                    $order_detail[0]['Charges'] = Modules::run('api/get_order_items',array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"oc_id asc",$outlet_id."_order_charges","","charges_name,charges_type,charges_amount")->result_array();
                    $order_detail[0]['Taxes'] = Modules::run('api/get_order_items',array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"ot_id asc",$outlet_id."_order_taxes","","tax_name,tax_type,tax_value as tax_amount")->result_array();
                    $order_detail[0]['Discounts'] = Modules::run('api/get_order_items',array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"od_id asc",$outlet_id."_order_discount","","discount_name,discount_type,discount_value as discount_amount")->result_array();
                    $items=$temp;
                }
                $order_detail[0]['Cartdata'][0]['Grandprice'] = $order_detail[0]['Cartdata'][0]['Quantity'] = $order_detail[0]['Cartdata'][0]['Outletid'] = "";
                if(!empty($order_detail[0]['Ordertotal']))
                    $order_detail[0]['Cartdata'][0]['Grandprice'] = $order_detail[0]['Ordertotal'];
                if(!empty($order_detail[0]['Quantity']))
                    $order_detail[0]['Cartdata'][0]['Quantity'] = $order_detail[0]['Quantity'];
                $order_detail[0]['Cartdata'][0]['Outletid'] = $outlet_id;
                $order_detail[0]['Cartdata'][0]['Data'] = $items;
                foreach ($order_detail[0] as $key => $value) {
                    $final_array[$key] = $value;
                }
            }
        }
        $final_array['Status'] = $status;
        $final_array['message'] = $message;
        header('Content-Type: application/json');
        echo json_encode($final_array);
    }
    
    function outlet_driver_list() {
        $status=false;
        $message="parameter missing";
        $outlet_id = $this->input->post('outlet_id');
        $page_number=$this->input->post('page_number');
        if(!is_numeric($page_number))
            $page_number = 1;
        $limit=$this->input->post('limit');
        if(!is_numeric($limit))
            $limit = 20;
        $total_pages=0;
        $data = array();
        if(!empty($outlet_id)) {
            $status = true;
            $message = "outlet deriver list";
            $driver = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id),'driver_id desc',"driver","driver_id,driver_first_name,driver_middle_name,driver_last_name,driver_cell_phone,driver_status,status,driver_picture",$page_number,$limit)->result_array();
            if(!empty($driver)) {
                $total_pages = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id),'driver_id desc',"driver","driver_id,driver_first_name,driver_middle_name,driver_last_name,driver_cell_phone,driver_status,status as online,driver_picture",$page_number,$limit)->num_rows();
                $diviser=($total_pages/$limit);
                $reminder=($total_pages%$limit);
                if($reminder>0)
                   $total_pages=intval($diviser)+1;
                else
                    $total_pages=intval($diviser);
                foreach ($driver as $key => $result) {
                    $temp =array();
                    $driver_name = "";
                    if(isset($result['driver_first_name']) && !empty($result['driver_first_name']))
                        $driver_name = $result['driver_first_name'];
                    if(isset($result['driver_middle_name']) && !empty($result['driver_middle_name'])) {
                        if(!empty($driver_name))
                            $driver_name = $driver_name ." ";
                        $driver_name =$driver_name.$result['driver_middle_name'];
                    }
                    if(isset($result['driver_last_name']) && !empty($result['driver_last_name'])) {
                        if(!empty($driver_name))
                            $driver_name = $driver_name ." ";
                        $driver_name =$driver_name.$result['driver_last_name'];
                    }
                    $temp['id'] = $result['driver_id'];
                    $temp['name'] = $driver_name;
                    $temp['phone'] = $result['driver_cell_phone'];
                    $temp['status'] = $result['driver_status'];
                    if(!isset($result['driver_picture']))
                        $result['driver_picture'] = "";
                    $temp['driver_picture']=  Modules::run('api/image_path_with_default',MEDIUM_DRIVER_IMAGE_PATH,$result['driver_picture'],STATIC_FRONT_IMAGE,'user.png');
                    $temp['online_offline'] = "Offline";
                    if(isset($result['status']) && !empty($result['status']))
                        if($result['status'] == 1)
                            $temp['online_offline'] = "Online";
                    $data[]=$temp;
                    unset($temp);
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    
    function outlet_driver_detail() {
        $status=false;
        $message="parameter missing";
        $driver_id = $this->input->post('driver_id');
        $driver_detail = array();
        if(is_numeric($driver_id) && !empty($driver_id) && $driver_id >0) {
            $status = true;
            $message = "Driver information.";
            $driver_detail=Modules::run('api/get_specific_table_data',array("driver_id"=>$driver_id),"driver_id desc","driver_first_name,driver_middle_name,driver_last_name,driver_cell_phone,driver_picture","driver","1","1")->result_array();
            if(!empty($driver_detail)) {
                    $driver_name = "driver_detail";
                    if(isset($driver_detail[0]['driver_first_name']) && !empty($driver_detail[0]['driver_first_name'])) {
                        $driver_name = $driver_detail[0]['driver_first_name'];
                        unset($driver_detail[0]['driver_middle_name']);
                    }
                    if(isset($driver_detail[0]['driver_middle_name']) && !empty($driver_detail[0]['driver_middle_name'])) {
                        if(!empty($driver_name))
                            $driver_name = $driver_name ." ";
                        $driver_name =$driver_name.$driver_detail[0]['driver_middle_name'];
                        unset($driver_detail[0]['driver_middle_name']);
                    }
                    if(isset($driver_detail[0]['driver_last_name']) && !empty($driver_detail[0]['driver_last_name'])) {
                        if(!empty($driver_name))
                            $driver_name = $driver_name ." ";
                        $driver_name =$driver_name.$driver_detail[0]['driver_last_name'];
                        unset($driver_detail[0]['driver_last_name']);
                    }
                    $driver_detail[0]['full_name'] = $driver_name;
                    if(!isset($driver_detail[0]['driver_picture']))
                        $driver_detail[0]['driver_picture'] = "";
                    $driver_detail[0]['driver_picture']=  Modules::run('api/image_path_with_default',MEDIUM_DRIVER_IMAGE_PATH,$driver_detail[0]['driver_picture'],STATIC_FRONT_IMAGE,'user.png');
                    $driver_detail[0]['vehicle_info'] = Modules::run('api/get_driver_vehicle_info',array("driver_vehicle.driver_id"=>$driver_id,"driver_vehicle.dv_active"=>"1"),'driver_vehicle.dv_id','dv_id,vehicle_cat_name,vehicle_mod_name,vehicle_bd_name,vehicle_number,vehicle_color,dv_active')->result_array();
            }
            else
                $message = "Driver not found";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$driver_detail));
    }
    
    function admin_outlet_detail() {
        $status=false;
        $message="parameter missing";
        $outlet_id = $this->input->post('outlet_id');
        $outlet_record = array();
        if(is_numeric($outlet_id) && !empty($outlet_id) && $outlet_id >0) {
            $outlet_record = Modules::run('slider/_get_where_cols',array("id"=> $outlet_id,"status"=>"1"),'id desc','outlet','id,name,phone,email,orgination_no,country,state,city,post_code,address,outlet.image as outlet_image,outlet.outlet_cover_image as cover_image')->result_array();
            if(!empty($outlet_record)) {
                $status = true;
                $message = "Outlet detail";
                if(!isset($outlet_record[0]['outlet_image']))
                    $outlet_record[0]['outlet_image'] = "";
                $outlet_record[0]['outlet_image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_IMAGE_PATH,$outlet_record[0]['outlet_image'],STATIC_FRONT_IMAGE,'Patteren Food.jpg');
                if(!isset($outlet_record[0]['cover_image']))
                    $outlet_record[0]['cover_image'] = "";
                $outlet_record[0]['cover_image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_TYPE_IMAGE_PATH,$outlet_record[0]['cover_image'],STATIC_FRONT_IMAGE,'Patteren Food.jpg');
                $outlet_record[0]['rating'] = "0.0";
                $rating = Modules::run('slider/_get_where_cols',array("outlet_id"=> $outlet_id),'id desc','reviews','AVG(reviews.rating) as rating')->result_array();
                if(!empty($rating))
                    if(isset($rating[0]['rating']) && !empty($rating[0]['rating']))
                       $outlet_record[0]['rating'] = round($rating[0]['rating'], 2);
                $outlet_record[0]['timing'] = "45 Mins";
                $timing = Modules::run('slider/_get_where_cols',array("outlet_id"=> $outlet_id),'id desc','general_setting','delivery_time')->result_array();
                if(!empty($timing))
                    if(isset($timing[0]['delivery_time']) && !empty($timing[0]['delivery_time']))
                       $outlet_record[0]['timing'] = $timing[0]['delivery_time']." Mins";
            }
            else
                $message = "Opps! outlet record not found";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$outlet_record));
    }
    
    function outlet_user_profile_detail() {
        $status=false;
        $message="parameter missing";
        $user_id = $this->input->post('user_id');
        $data = array();
        if(is_numeric($user_id) && !empty($user_id) && $user_id >0) {
            $user=Modules::run('api/get_specific_table_data',array("id"=>$user_id,"status"=>"1"),"id desc","user_name,first_name,last_name,email,phone,country,state,city,address1 as address,user_image,gender","users","1","1")->result_array();
            if(!empty($user)) {
                if(!isset($user[0]['user_image']))
                    $user[0]['user_image'] = "";
                $user[0]['user_image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user[0]['user_image'],STATIC_FRONT_IMAGE,'Patteren Food.jpg');
                $status = true;
                $message = "user detail";
                $data = $user;
            }
            else
                $message = "Opps! user data not found";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data));
    }
    
    function outlet_open_close_status_change() {
        $status=false;
        $message="parameter missing";
        $outlet_id = $this->input->post('outlet_id');
        $status = $this->input->post('status');
        if(is_numeric($outlet_id) && !empty($outlet_id) && $outlet_id >0 && ($status == 'Open' || $status == "Closed")) {
            $status = 0;
            if ($status == 'Open') 
                $status = 1;
            $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
            if(!empty($general_setting)) {
                date_default_timezone_set($general_setting[0]['timezones']);
                $day=date("l");
                $timing = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"day"=>$day),'id desc','timing','is_closed')->result_array();
                if(!empty($timing)) {
                    Modules::run('api/update_specific_table',array("outlet_id"=>$outlet_id,"day"=>$day),array("is_closed"=>$status),'timing');
                    $status = true;
                    if($status == 0)
                        $message = "Restaurant has been closed.";
                    else
                        $message = "Restaurant has been opened now";
                }
                else
                    $message = "Restaurant timing not found";
            }
            else
                $message = "Opps! Restaurant data not found";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }

    function broadcast_order_to_driver() {
        $response['status'] = false;
        $response['message'] = "Parameter missing";
        $response['outlet_id'] = $outlet_id = $this->input->post('outlet_id');
        $response['order_id'] = $order_id = $this->input->post('order_id');
        $driver = $this->input->post("driver");
        if(!empty($driver))
            $driver = json_decode($driver);
        if(!empty($outlet_id) && !empty($order_id) && is_numeric($outlet_id) && $outlet_id> 0 && is_numeric($order_id) && $order_id >0) {
            $fcmToken = "";
            $message = "";
            $check = 0;
            $driver_array = array();
            if(empty($driver)) {
                $check =1;
                $response['message'] = "No Driver Found with in range";
            }
            else {                    
                foreach ($driver as $key => $value) {
                    $driver_detail =Modules::run('slider/_get_where_cols',array("driver_id"=>$value->id,"status"=>"1","driver_status"=>"1","created_by"=>"admin"),'driver_id desc','driver','driver_fcm_token')->result_array(); 
                    if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token'])) {
                        $driver_array[] = $value->id;
                        $fcmToken[] = $driver_detail[0]['driver_fcm_token'];
                    }
                }
                if (empty($fcmToken))
                    $response['message'] = "Delivery guy not found arround you.";
            }
            if($check == 0 && !empty($fcmToken)) {
                if(isset($driver_array) && !empty($driver_array)) {
                    foreach ($driver_array as $key => $da) {
                        Modules::run('api/insert_or_update',array("driver_id"=>$da,"order_id"=>$order_id,"outlet_id"=>$outlet_id),array("driver_id"=>$da,"order_id"=>$order_id,"notification_type"=>"order_assign","outlet_id"=>$outlet_id,"notification_status"=>"1","notification_message"=>"broadcast"),'notification');
                    }
                }
                $response['message'] = "Order broad cast now.";
                $response['status'] = true;
                $data['data'] =  $this->notifiction_message($order_id,"broadcast",$response['outlet_id']);
                $data['fcmToken'] =  $fcmToken;
                $this->load->view('firebase_notification', $data);
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    function broadcast_order_response() {
        $response['status'] = 'false';
        $response['message'] = "Parameter missing";
        $response['outlet_id'] = $outlet_id = $this->input->post('outlet_id');
        $response['order_id'] = $order_id = $this->input->post('order_id');
        $driver = $this->input->post("driver");
        if(!empty($outlet_id) && !empty($order_id) && is_numeric($outlet_id) && $outlet_id> 0 && is_numeric($order_id) && $order_id >0) {
            $distance = "500";
            $fcmToken = "";
            $message = "";
            $check = 0;
            $driver_array = array();
            if(empty($driver)) {
                $check =1;
                $response['message'] = "No Driver Found";
            }
            else {
                $outlet_detail =Modules::run('slider/_get_where_cols',array("id"=>$outlet_id,"status"=>"1"),'id desc','outlet','latitude,longitude')->result_array();
                if(isset($outlet_detail[0]['latitude']) && !empty($outlet_detail[0]['latitude']) && isset($outlet_detail[0]['longitude']) && !empty($outlet_detail[0]['longitude'])) {
                    $maxLat=$minLat=$maxLon=$minLon="";
                    $R="6371";
                    $maxLat = $outlet_detail[0]['latitude'] + rad2deg($distance/$R);
                    $minLat = $outlet_detail[0]['latitude'] - rad2deg($distance/$R);
                    $maxLon = $outlet_detail[0]['longitude'] + rad2deg(asin($distance/$R) / cos(deg2rad($outlet_detail[0]['latitude'])));
                    $minLon = $outlet_detail[0]['longitude'] - rad2deg(asin($distance/$R) / cos(deg2rad($outlet_detail[0]['latitude'])));
                    foreach ($driver as $key => $value) {
                        if($value['lat'] >=$minLat && $value['lat'] <= $maxLat && $value['long'] >=$minLon && $value['long'] <=$maxLon) {
                            $driver_detail =Modules::run('slider/_get_where_cols',array("driver_id"=>$value['id'],"status"=>"1","driver_status"=>"1","created_by"=>"admin"),'driver_id desc','driver','driver_fcm_token')->result_array(); 
                            if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token'])) {
                                $driver_array[] = $value['id'];
                                $fcmToken[] = $driver_detail[0]['driver_fcm_token'];
                            }
                            
                        }
                    }
                    if (empty($fcmToken))
                        $response['message'] = "Delivery guy not found arround you.";
                }
                else
                    $response['message'] = "Your restaurant location is not set";
            }
            if($check == 0 && !empty($fcmToken)) {
               if(isset($driver_array) && !empty($driver_array)) {
                foreach ($driver_array as $key => $da) {
                    Modules::run('api/insert_or_update',array("driver_id"=>$da,"order_id"=>$order_id,"outlet_id"=>$outlet_id),array("driver_id"=>$da,"order_id"=>$order_id,"notification_type"=>"order_assign","outlet_id"=>$outlet_id,"notification_status"=>"1","notification_message"=>"broadcast"),'notification');
                }
               }
                $response['message'] = "Order broad cast now.";
                $response['status'] = 'true';
                $data['data'] =  $this->notifiction_message($order_id,"broadcast",$response['outlet_id']);
                $data['fcmToken'] =  $fcmToken;
                $this->load->view('firebase_notification', $data);
            }
        }
        $this->load->view('broadcast_response',$response);

    }
    
    function outlet_order_income_reports() {
        $status = false;
        $message="Some thing went wrong";
        $outlet_id = $this->input->post("outlet_id");
        $report_selection = "orders";
        $query = "COUNT(".$outlet_id."_orders.id) as orders";
        $where = array("users_orders.outlet_id" => $outlet_id);
        $selection = $this->input->post("selection");
        $month_number = $this->input->post("month_number");
        $year_number = $this->input->post("year_number");
        if(!empty($selection)) {
            if($selection == "income") {
                $where['order_status !='] = "Cancelled";
                $query = "SUM(".$outlet_id."_orders.subtotal) as orders";
            }
        }
        $type = $this->input->post("report_type");
        $report_ype = "over_all";
        if(!empty($type)) {
            if($type == "monthly")
                $report_ype = "monthly";
            elseif($type == "annual")
                $report_ype = "annual";
            else
                echo "";
        }
        $report_record = $last_seven = $month_wise = $year_wise = $temp = array();
        if(!empty($outlet_id) && is_numeric($outlet_id)) {
            $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones'])) {
                    date_default_timezone_set($timezone[0]['timezones']);
                    if($report_ype == "annual" || $report_ype == "monthly") {
                        if(!empty($month_number) && is_numeric($month_number) && $month_number >0) {
                            if(!empty($year_number) && is_numeric($year_number) && $year_number >0) {
                                $status =true;
                                $message = "Reports";
                                $check_empty = 0;
                                $end = cal_days_in_month(CAL_GREGORIAN,$month_number,$year_number);
                                $first_day = $year_number.'-'.$month_number.'-01';
                                for ($i=1; $i <= $end; $i++) {
                                    $temp = $row = array();
                                    $temp['day'] = $i;
                                    $temp_where= $where;
                                    $temp_where['create_date >='] = $first_day." 00:00:00";
                                    $temp_where['create_date <='] = $first_day." 23:59:59";
                                    $row= $this->_get_outlet_order_income_reports($temp_where,$outlet_id.'_orders.id desc',$outlet_id.'_orders',$query,'1','0')->result_array();
                                    if(isset($row[0]['orders']) && (!empty($row[0]['orders']))) {
                                        $check_empty = 1;
                                        $temp['value'] = $row[0]['orders'];
                                    }
                                    else
                                        $temp['value'] = "0";
                                    $month_wise[]= $temp;
                                    unset($row);unset($temp);
                                    $first_day = date('Y-m-d', strtotime($first_day. ' +1 days'));
                                }
                                if(($report_ype == "monthly" && $check_empty == 1) || $report_ype == "annual")
                                    $report_record['month_wise'] = $month_wise;
                                else
                                    $report_record['month_wise'] = array();
                                if($report_ype == "annual") {
                                    for ($i=1; $i <= 12; $i++) {
                                        $temp = $row = array();
                                        $temp['month'] = $i;
                                        $end_day = cal_days_in_month(CAL_GREGORIAN,$i, $year_number);
                                        $end_day = $year_number.'-'.$i.'-'.$end_day." 23:59:59";
                                        $first_day = $year_number.'-'.$i.'-01 00:00:00';
                                        $temp_where= $where;
                                        $temp_where['create_date >='] = $first_day;
                                        $temp_where['create_date <='] = $end_day;
                                        $row= $this->_get_outlet_order_income_reports($temp_where,$outlet_id.'_orders.id desc',$outlet_id.'_orders',$query,'1','0')->result_array();
                                        $row= Modules::run('api/_get_specific_table_with_pagination',array("create_date >=" =>$first_day,"create_date <=" =>$end_day),'id desc',$outlet_id.'_orders',$query,'1','0')->result_array();
                                        if(isset($row[0]['orders']) && (!empty($row[0]['orders'])))
                                            $temp['value'] = $row[0]['orders'];
                                        else
                                            $temp['value'] = "0";
                                        $year_wise[]= $temp;
                                        unset($row);unset($temp);
                                        $report_record['year_wise'] = $year_wise;
                                    }
                                }
                                if($report_ype == "monthly" && $check_empty == 0) {
                                    $status = false;
                                    $message = "No_data_found";
                                }
                            }
                            else
                                $message = "Please select the Year";
                        }
                        else
                            $message = "Please select the month";
                    }
                    else {
                        $status =true;
                        $message = "Reports";
                        $date = strtotime(date("Y-m-d"));
                        $month = date("m",strtotime(date("Y-m-d")));
                        $start = date('Y-m-d', strtotime('-6 days'));
                        $end = date("Y-m-d");
                        $first = date("Y",strtotime(date("Y-m-d"))).'-'.date("m",strtotime(date("Y-m-d"))).'-01';
                        for ($i=1; $i <= 7 ; $i++) {
                            if($start <= $end && $start >= $first) {
                                $temp = array();
                                $temp_where= $where;
                                $temp_where['create_date >='] = $start." 00:00:00";
                                $temp_where['create_date <='] = $start." 23:59:59";
                                $row= $this->_get_outlet_order_income_reports($temp_where,$outlet_id.'_orders.id desc',$outlet_id.'_orders',$query,'1','0')->result_array();
                                $temp['day'] = date('d', strtotime($start));
                                if(isset($row[0]['orders']) && (!empty($row[0]['orders'])))
                                    $temp['value'] = $row[0]['orders'];
                                else {
                                    $temp['value'] = "0";
                                }
                                $last_seven[]= $temp;
                                unset($row);unset($temp);
                            }
                            $start = date('Y-m-d', strtotime($start. ' +1 days'));
                        }
                        $report_record['last_seven'] = $last_seven;
                        $end = cal_days_in_month(CAL_GREGORIAN, date("m",strtotime(date("Y-m-d"))), date("Y",strtotime(date("Y-m-d"))));
                        $start = $first;
                        for ($i=1; $i <= $end; $i++) {
                            $temp = $row = array();
                            $temp['day'] = date('d', strtotime($start));
                            if($i <= date('d', strtotime(date("Y-m-d")))) {
                                $temp_where= $where;
                                $temp_where['create_date >='] = $start." 00:00:00";
                                $temp_where['create_date <='] = $start." 23:59:59";
                                $row= $this->_get_outlet_order_income_reports($temp_where,$outlet_id.'_orders.id desc',$outlet_id.'_orders',$query,'1','0')->result_array();
                            }
                            if(isset($row[0]['orders']) && (!empty($row[0]['orders']))) {
                                $temp['value'] = $row[0]['orders'];
                            }
                            else
                                $temp['value'] = "0";
                            $month_wise[]= $temp;
                            unset($row);unset($temp);
                            $start = date('Y-m-d', strtotime($start. ' +1 days'));
                        }
                        $report_record['month_wise'] = $month_wise;
                        $current_month = date("m",strtotime(date("Y-m-d")));
                        for ($i=1; $i <= 12; $i++) {
                            $temp = $row = array();
                            $temp['month'] = $i;
                            $end_day = cal_days_in_month(CAL_GREGORIAN,$i, date("Y",strtotime(date("Y-m-d"))));
                            $end_day = date("Y",strtotime(date("Y-m-d"))).'-'.$i.'-'.$end_day." 23:59:59";
                            $first_day = date("Y",strtotime(date("Y-m-d"))).'-'.$i.'-01 00:00:00';
                            if($i <= $current_month) {
                                $temp_where= $where;
                                $temp_where['create_date >='] = $first_day;
                                $temp_where['create_date <='] = $end_day;
                                $row= $this->_get_outlet_order_income_reports($temp_where,$outlet_id.'_orders.id desc',$outlet_id.'_orders',$query,'1','0')->result_array();
                            }
                            if(isset($row[0]['orders']) && (!empty($row[0]['orders']))) {
                                $temp['value'] = $row[0]['orders'];
                            }
                            else
                                $temp['value'] = "0";
                            $year_wise[]= $temp;
                            unset($row);unset($temp);
                            $report_record['year_wise'] = $year_wise;
                        }
                    }
                }
                else 
                    $message = "Sorry Restaurant does not exist";
        }
        else
            $message = "Restaurant registeration number missing";
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message,"report_record"=>$report_record));
    }

    
    
    function assign_order_to_driver() {
        $status=false;
        $message="parameter missing";
        $outlet_id = $this->input->post('outlet_id');
        $order_id = $this->input->post('order_id');
        $driver_id = $this->input->post('driver_id');
        if(!empty($outlet_id) && is_numeric($outlet_id) && !empty($order_id) && is_numeric($order_id) && !empty($driver_id) && is_numeric($driver_id)) {
            $fcmToken = "";
            $driver_detail =Modules::run('slider/_get_where_cols',array("driver_id"=>$driver_id,'driver_status'=>'1'),'driver_id desc','driver','driver_fcm_token,status')->result_array();
            if(!empty($driver_detail)) {
                if(isset($driver_detail[0]['status']) && !empty($driver_detail[0]['status']) && $driver_detail[0]['status']== 1 ) {
                    $order_detail =Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"order_id"=>$order_id),'id desc','users_orders','id')->result_array();
                    if(!empty($order_detail)) {
                        $status = true;
                        $message = "Order assign to driver";
                        Modules::run('api/update_specific_table',array("outlet_id"=>$outlet_id,"order_id"=>$order_id),array("uo_driver_id"=>$driver_id),'users_orders');
                        Modules::run('api/insert_or_update',array("driver_id"=>$driver_id,"order_id"=>$order_id,"outlet_id"=>$outlet_id),array("driver_id"=>$driver_id,"order_id"=>$order_id,"notification_type"=>"order_assign","outlet_id"=>$outlet_id,"notification_status"=>"1","notification_message"=>"fixed"),'notification');
                        if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token'])) {
                            $fcmToken[] = $driver_detail[0]['driver_fcm_token'];
                            $notification_data['data'] =  $this->notifiction_message($order_id,"fixed",$outlet_id);
                            $notification_data['fcmToken'] =  $fcmToken;
                            $this->load->view('firebase_notification', $notification_data);
                        }
                    }
                    else
                        $message = "Miss Match parameter send";
                }
                else 
                    $message = "Driver is not online";
                    
            }
            else
                $message = "Please change the status of driver first";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }


    function notifiction_message($order_id,$type,$outlet_id) {
        $res = array();
        $res['data']['title'] = "New Order";
        $res['data']['message'] = "Tap here to view the order detail";
        $res['data']['is_background_task'] = false;
        $res['data']['is_new_job'] = true;
        $res['data']['job_data'] = $this->order_detail($order_id,$type,$outlet_id);
        $res['data']['timestamp'] = date('Y-m-d G:i:s');
        $res['data']['alert'] = "";
        $res['data']['badge'] = "787";
        $res['data']['Content-available'] = "1";
        $res['data']['sound'] = "";
        return $res;
    }
    function order_detail($order_id,$type,$outlet_id){
        $res = array();
        $rec['order_number'] = $order_id;
        $rec['outlet_id'] = $outlet_id;
        $rec['time_counter'] = "15";
        $rec['notification_message'] = $type;
        $rec['payment_status'] = "Cash On Delivery";
        $rec['total'] = $rec['resturant_name'] = $out_address = $shipping = "";
        $order_detail =Modules::run('slider/_get_where_cols',array("outlet_order_id"=>$order_id),'id desc',$outlet_id.'_orders','total_price,payment_status,address,street_no,city')->result_array();
        $outlet_detail =Modules::run('slider/_get_where_cols',array("id"=>$outlet_id),'id desc','outlet','name,address,city,state')->result_array();
        if(isset($order_detail[0]['total_price']) && !empty($order_detail[0]['total_price']))
            $rec['total'] = $order_detail[0]['total_price'];
        if(isset($order_detail[0]['payment_status']) && !empty($order_detail[0]['payment_status'])) {
            if($order_detail[0]['payment_status'] == 1)
                $rec['payment_status'] = "Paid";
        }
        if(isset($order_detail[0]['address']) && !empty($order_detail[0]['address']))
            $shipping = $order_detail[0]['address'];
        if(isset($order_detail[0]['street_no']) && !empty($order_detail[0]['street_no'])) {
            if(!empty($shipping))
                $shipping= $shipping." ";
            $shipping = $shipping.$order_detail[0]['street_no'];
        }
        if(isset($order_detail[0]['street_no']) && !empty($order_detail[0]['street_no'])) {
            if(!empty($shipping))
                $shipping= $shipping.",";
            $shipping = $shipping.$order_detail[0]['street_no'];
        }
        if(isset($order_detail[0]['city']) && !empty($order_detail[0]['city'])) {
            if(!empty($shipping))
                $shipping= $shipping.",";
            $shipping = $shipping.$order_detail[0]['city'];
        }
        $rec['shipping'] = $shipping;
        if(isset($outlet_detail[0]['name']) && !empty($outlet_detail[0]['name']))
            $rec['resturant_name'] = $outlet_detail[0]['name'];
        if(isset($outlet_detail[0]['address']) && !empty($outlet_detail[0]['address']))
            $out_address = $outlet_detail[0]['address'];
        if(isset($outlet_detail[0]['city']) && !empty($outlet_detail[0]['city'])) {
            if(!empty($out_address))
                $out_address= $out_address.",";
            $out_address = $out_address.$outlet_detail[0]['city'];
        }
        if(isset($outlet_detail[0]['state']) && !empty($outlet_detail[0]['state'])) {
            if(!empty($out_address))
                $out_address= $out_address.",";
            $out_address = $out_address.$outlet_detail[0]['state'];
        }
        $rec['out_address'] = $out_address;
        return $rec;
    }
    function get_and_where($input,$field_name) {
        $result = "";
        if(!empty($input)) {
            $result="(";
            foreach ($input as $key => $value) {
                if($key==0)
                {
                    $char=$field_name ."=".'"'.$value.'"';
                   $result .= $char; 
                }
                else
                {
                    $char= " AND ".$field_name ."=".'"'.$value .'"';
                   $result .= $char; 
                }
            }
            $result.=")";
        }
      return $result;
    }
    function get_or_where($input,$field_name) {
        $result = "";
        if(!empty($input)) {
            $result="(";
            foreach ($input as $key => $value) {
                if($key==0)
                {
                    $char=$field_name ."=".'"'.$value.'"';
                   $result .= $char; 
                }
                else
                {
                    $char= " OR ".$field_name ."=".'"'.$value .'"';
                   $result .= $char; 
                }
            }
            $result.=")";
        }
      return $result;
    }
    function get_outlet_order_list($where,$order,$outlet_id,$select,$where_status,$page_number,$limit) {
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_outlet_order_list($where,$order,$outlet_id,$select,$where_status,$page_number,$limit);
    }
    function _get_outlet_order_income_reports($cols, $order_by,$table,$select,$page_number,$limit){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->_get_outlet_order_income_reports($cols, $order_by,$table,$select,$page_number,$limit);
        return $query;
    }
     ////////////////////////////////////// Qa project api///////////
    function get_user_check_lists(){
        date_default_timezone_set("Asia/karachi");
        $page_number = $this->input->post('page_number');
        if(empty($page_number) || $page_number < 0 || !is_numeric($page_number))
            $page_number=1;
        $limit = $this->input->post('limit');
        if(empty($limit) || $limit < 0 || !is_numeric($limit))
            $limit=20;
        $total_pages=0;
        $checklist_data=array();
        $status=false;
        $message="Something went wrong";
        $user_id=$this->input->post('user_id');
        $outlet_id=$this->input->post('outlet_id');
        $line_timing=$this->input->post('line_timing');
        if(!isset($line_timing) || empty($line_timing))
            $line_timing = '1,2,3';
        $role=$this->input->post('role');
        if(!isset($role) || empty($role))
            $role = 'agent';
        $group_id=$this->input->post('group_id');
        if(!isset($group_id) || empty($group_id))
            $group_id = '0';
        $user_key = $this->check_user_api_key();
        $complete = $overdue = $pending = $open = 0;
        $total_notification = '0';
        $calling_status = $this->input->post('calling_status');
      //  if($user_key['key_status'] == true) {
            if(!empty($user_id) && !empty($outlet_id) && !empty($role)){
                $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones','1','1')->result_array();
                if(!empty($timezone)) {
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                        date_default_timezone_set($timezone[0]['timezones']);
                }
                if(strtolower($role) == 'agent' || strtolower($role) == 'packingtech' || strtolower($role) == 'production' || strtolower($role) == 'warehouse') {
                    $status=true;
                    $checklist_or_where = '(inspection_teams.inspection_team_id ="'.$group_id.'" OR assignments.reassign_user ="'.$user_id.'")';
                    if(!empty($calling_status))
                        if(strtolower($calling_status) !='Completed')
                            $checklist_where = array('assignments.assign_status'=>$calling_status);
                        else {
                           $checklist_where = $this->get_and_where(array('OverDue','Open'),'assignments.assign_status !'); 
                           $checklist_or_where = '(assignments.user_id ="'.$user_id.'")';
                        }
                    else
                        $checklist_where = array('assignments.assign_status'=>'Open');
                    if(empty($calling_status)|| (!empty($calling_status) && strtolower($calling_status) != strtolower('Completed'))){
                       
                    
                        $checklist_data = $this->get_checks_lists_from_db($checklist_where,'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status,assignments.start_datetime,assignments.assignment_type',$page_number,$limit,$checklist_or_where,'','',$line_timing)->result_array();
                    }else
                        $checklist_data = $this->get_complete_by_user(array("user_id"=>$user_id), 'assignments.assign_id',"assignment_answer.assignment_id",$outlet_id,'assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status,assignments.start_datetime,assignments.assignment_type',$page_number,$limit,$this->get_and_where(array('OverDue','Open'),'assignments.assign_status !'),'','')->result_array();
                    //print_r($checklist_data);exit;
                    if(!empty($checklist_data)) {
                        $temp = array();
                        foreach ($checklist_data as $key => $cd):
                            $cd['outlet_id'] = $outlet_id;
                            $cd['checkname'] = $cd['check_desc'] = "";
                            if(isset($cd['checkid']) && !empty($cd['checkid'])) {
                                $check_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$cd['checkid']),'id desc',$outlet_id.'_product_checks.id',$outlet_id.'_product_checks','checkname,check_desc,checktype','1','1','','','',$line_timing)->result_array();
                                if(isset($check_detail[0]['checkname']) && !empty($check_detail[0]['checkname'])) $cd['checkname'] =$check_detail[0]['checkname']; $cd['checkname']=  Modules::run('api/string_length',$cd['checkname'],'8000','');
                                if(isset($check_detail[0]['check_desc']) && !empty($check_detail[0]['check_desc'])) $cd['check_desc'] =$check_detail[0]['check_desc']; $cd['check_desc']=  Modules::run('api/string_length',$cd['check_desc'],'8000','');
                                if(isset($check_detail[0]['checktype']) && !empty($check_detail[0]['checktype'])) $cd['checktype'] =$check_detail[0]['checktype']; $cd['checktype']=  Modules::run('api/string_length',$cd['checktype'],'8000','');
                            	
                            	$cd['timestamp'] = date('m-d-Y h:i:s A');
                                if(isset($checklist_data[0]['start_datetime']) && !empty($checklist_data[0]['start_datetime']))
                                $cd['timestamp'] = date('m-d-Y h:i:s A',strtotime($checklist_data[0]['start_datetime']));
                                unset($checklist_data[0]['start_datetime']);    
                            unset($cd['checkid']);
                                $temp[] = $cd;
                            }
                        endforeach;
                        $checklist_data = $temp;
                        $message="Record fetched successfully";
                        if(empty($calling_status)|| (!empty($calling_status) && strtolower($calling_status) !=strtolower('Completed')))
                            $total_pages= $this->get_checks_lists_from_db($checklist_where,'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status',$page_number,'0',$checklist_or_where,'','',$line_timing)->num_rows();
                        else {
                            $total_pages = $this->get_complete_by_user(array("user_id"=>$user_id), 'assignments.assign_id',"assignment_answer.assignment_id",$outlet_id,'assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status','1','0',$this->get_and_where(array('OverDue','Open'),'assignments.assign_status !'),'','')->num_rows();
                        }
                        $diviser=($total_pages/$limit);
                        $reminder=($total_pages%$limit);
                        if($reminder>0)
                           $total_pages=intval($diviser)+1;
                        else
                            $total_pages=intval($diviser);
                    }
                    else
                        $message="No checklist found";
                    $open = $this->get_checks_lists_from_db(array('assignments.assign_status'=>"Open"),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status','1','0','(inspection_teams.inspection_team_id ="'.$group_id.'" OR assignments.reassign_user ="'.$user_id.'")','','',$line_timing)->num_rows();
                    $overdue = $this->get_checks_lists_from_db(array('assignments.assign_status'=>"OverDue"),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status','1','0','(inspection_teams.inspection_team_id ="'.$group_id.'" OR assignments.reassign_user ="'.$user_id.'")','','',$line_timing)->num_rows();
                    $complete = $this->get_complete_by_user(array("user_id"=>$user_id), 'assignments.assign_id',"assignment_answer.assignment_id",$outlet_id,'assign_id','1','0',$this->get_and_where(array('OverDue','Open'),'assignments.assign_status !'),'','')->num_rows();
                    
                }
                elseif(strtolower($role) == 'editor') {
                    if(!empty($group_id)) {
                        $status = true;
                        if(empty($calling_status)|| (!empty($calling_status) && strtolower($calling_status) !=strtolower('Completed')))
                            $checklist_data = $this->get_checks_lists_from_db(array("assign_status"=>"Review",$outlet_id."_assignments.review_team"=>$group_id,$outlet_id."_assignments.reassign_id"=>'0'),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status,assignments.complete_datetime',$page_number,$limit,'','','','')->result_array();
                        else
                            $checklist_data = $this->get_checks_lists_from_db(array("review_user"=>$user_id),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status,assignments.complete_datetime',$page_number,$limit,'','','','')->result_array();
                        if(!empty($checklist_data)) {
                            $temp = array();
                            foreach ($checklist_data as $key => $cd):
                                $cd['outlet_id'] = $outlet_id;
                                $cd['checkname'] = $cd['check_desc'] = $cd['checktype'] = "";
                                if(isset($cd['checkid']) && !empty($cd['checkid'])) {
                                    $check_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$cd['checkid']),'id desc',$outlet_id.'_product_checks.id',$outlet_id.'_product_checks','checkname,check_desc,checktype','1','1','','','')->result_array();
                                    if(isset($check_detail[0]['checkname']) && !empty($check_detail[0]['checkname'])) $cd['checkname'] =$check_detail[0]['checkname']; $cd['checkname']=  Modules::run('api/string_length',$cd['checkname'],'8000','');
                                    if(isset($check_detail[0]['check_desc']) && !empty($check_detail[0]['check_desc'])) $cd['check_desc'] =$check_detail[0]['check_desc']; $cd['check_desc']=  Modules::run('api/string_length',$cd['check_desc'],'8000','');
                                    if(isset($check_detail[0]['checktype']) && !empty($check_detail[0]['checktype'])) $cd['checktype'] =$check_detail[0]['checktype']; $cd['checktype']=  Modules::run('api/string_length',$cd['checktype'],'8000','');
                                	$cd['timestamp'] = date('m-d-Y h:i:s A');
                                    if(isset($cd['complete_datetime']) && !empty($cd['complete_datetime']))
                                    $cd['timestamp'] = date('m-d-Y h:i:s A',strtotime($cd['complete_datetime']));
                                    unset($cd['complete_datetime']);    
                                	unset($cd['checkid']);
                                    $temp[] = $cd;
                                }
                            endforeach;
                            $checklist_data = $temp;
                            $message="Record fetched successfully";
                            if(empty($calling_status)|| (!empty($calling_status) && strtolower($calling_status) !=strtolower('Completed')))
                                $total_pages = $this->get_checks_lists_from_db(array("assign_status"=>"Review",$outlet_id."_assignments.review_team"=>$group_id,$outlet_id."_assignments.reassign_id"=>'0'),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status',$page_number,'0','','','','')->num_rows();
                            else
                                $total_pages = $this->get_checks_lists_from_db(array("review_user"=>$user_id),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status','1','0','','','','')->num_rows();
                            $diviser=($total_pages/$limit);
                            $reminder=($total_pages%$limit);
                            if($reminder>0)
                               $total_pages=intval($diviser)+1;
                            else
                                $total_pages=intval($diviser);
                        }
                        else
                            $message="No checklist found";
                    }
                    else
                        $message = "user can not be member of any group";
                    $open =  Modules::run('api/_get_specific_table_with_pagination',array("review_team"=>$group_id,'assign_status'=>"Review","reassign_id"=>'0'),'assign_id desc',$outlet_id.'_assignments','assign_id','1','0')->num_rows();
                    $complete =  Modules::run('api/_get_specific_table_with_pagination',array("review_user"=>$user_id),'assign_id desc',$outlet_id.'_assignments','assign_id','1','0')->num_rows();
                }
                elseif(strtolower($role) == 'admin') {
                    if(!empty($group_id)) {
                        $status = true;
                        if(strtolower($calling_status) !='completed')
                            $checklist_data = $this->get_checks_lists_from_db(array("assign_status"=>"Approval",$outlet_id."_assignments.approval_team"=>$group_id,$outlet_id."_assignments.reassign_id"=>'0'),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status,assignments.review_datetime',$page_number,$limit,'','','','')->result_array();
                        else
                            $checklist_data =  Modules::run('api/_get_specific_table_with_pagination',array("approval_user"=>$user_id),'assign_id desc',$outlet_id.'_assignments assignments','assign_id,checkid,start_time,end_time,assign_status,review_datetime',$page_number,$limit)->result_array();
                        if(!empty($checklist_data)) {
                            $temp = array();
                            foreach ($checklist_data as $key => $cd):
                                $cd['outlet_id'] = $outlet_id;
                                $cd['checkname'] = $cd['check_desc'] = $cd['checktype'] = "";
                                if(isset($cd['checkid']) && !empty($cd['checkid'])) {
                                    $check_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$cd['checkid']),'id desc',$outlet_id.'_product_checks.id',$outlet_id.'_product_checks','checkname,check_desc,checktype','1','1','','','')->result_array();
                                    if(isset($check_detail[0]['checkname']) && !empty($check_detail[0]['checkname'])) $cd['checkname'] =$check_detail[0]['checkname']; $cd['checkname']=  Modules::run('api/string_length',$cd['checkname'],'8000','');
                                    if(isset($check_detail[0]['check_desc']) && !empty($check_detail[0]['check_desc'])) $cd['check_desc'] =$check_detail[0]['check_desc']; $cd['check_desc']=  Modules::run('api/string_length',$cd['check_desc'],'8000','');
                                    if(isset($check_detail[0]['checktype']) && !empty($check_detail[0]['checktype'])) $cd['checktype'] =$check_detail[0]['checktype']; $cd['checktype']=  Modules::run('api/string_length',$cd['checktype'],'8000','');
                                	$cd['timestamp'] = date('m-d-Y h:i:s A');
                                    if(isset($cd['review_datetime']) && !empty($cd['review_datetime']))
                                    $cd['timestamp'] = date('m-d-Y h:i:s A',strtotime($cd['review_datetime']));
                                    unset($cd['review_datetime']);    
                                	unset($cd['checkid']);
                                    $temp[] = $cd;
                                }
                            endforeach;
                            $checklist_data = $temp;
                            $message="Record fetched successfully";
                            if(strtolower($calling_status) !='completed')
                                $total_pages = $this->get_checks_lists_from_db(array("assign_status"=>"Approval",$outlet_id."_assignments.approval_team"=>$group_id,$outlet_id."_assignments.reassign_id"=>'0'),'',$outlet_id.'_assignments assignments','assignments.assign_id,assignments.checkid,assignments.start_time,assignments.end_time,assignments.assign_status',$page_number,'0','','','','')->num_rows();
                            else
                            $total_pages =  Modules::run('api/_get_specific_table_with_pagination',array("approval_user"=>$user_id),'assign_id desc',$outlet_id.'_assignments','assign_id,checkid,start_time,end_time,assign_status','1','0')->num_rows();
                            $diviser=($total_pages/$limit);
                            $reminder=($total_pages%$limit);
                            if($reminder>0)
                               $total_pages=intval($diviser)+1;
                            else
                                $total_pages=intval($diviser);
                        }
                        else
                            $message="No checklist found";
                    }
                    else
                        $message = "user can not be member of any group";
                    $open =  Modules::run('api/_get_specific_table_with_pagination',array("approval_team"=>$group_id,'assign_status'=>"Approval","reassign_id"=>'0'),'assign_id desc',$outlet_id.'_assignments','assign_id','1','0')->num_rows();
                    $complete =  Modules::run('api/_get_specific_table_with_pagination',array("approval_user"=>$user_id),'assign_id desc',$outlet_id.'_assignments','assign_id','1','0')->num_rows();
                }
                else
                    echo "";
                unset($where);
                $total_notification =  Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("user_id"=>$user_id,"outlet_id"=>$outlet_id),'notification_id desc','notification_id','notification','notification_id,assingment_id,notification_message as message, notification_datetime as datetime','1','0','','','')->num_rows();
            }
        //}
       // else
           // $message = $user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$checklist_data,"page_number"=>$page_number,"total_pages"=>$total_pages,"complete"=>$complete,"overdue" => $overdue,"pending" => $pending,"open" => $open,'total_notification'=>$total_notification));
    }
    /*function checklists_detail(){
        //////////////////////// function for check list detail///////
        $status=false;
        $message="Something Went Wrong";
        $arr_data=array();
        $outlet_id=$this->input->post('outlet_id');
        $assign_id=$this->input->post('assign_id');
        $role=$this->input->post('role');
        if(empty($role))
            $role = 'agent';
        $user_key = $this->check_user_api_key();
        $checking = false;
        if($user_key['key_status'] == true) {
            if(isset($outlet_id) && !empty($outlet_id) && isset($assign_id) && !empty($assign_id)) {
                $status=true;
                $message="No Data Found";
                $where['assignments.outlet_id']=$outlet_id;
                $where['assignments.assign_id']=$assign_id;
                $where['product_checks.status']=1;
                $checksdata=$this->get_checks_detail_from_db($where,$outlet_id)->result_array();
                $i=0;
                if(!empty($checksdata)){
                    $message="Record found successfully";
                    $check=array();
                    foreach ($checksdata as $key => $value):
                        if (!in_array($value['id'], $check)) {
                            $arr_data['productid']=$value['productid'];
                            $arr_data['productname']=$value['product_title'];
                            $j=0;
                            foreach ($checksdata as $key => $row):
                                $arr_question[$j]['question_id']=$row['question_id'];
                                $arr_question[$j]['question_title']=$row['question'];
                                $arr_question[$j]['question_type']=$row['type'];
                                $where_ans['question_id']=$row['question_id'];
                                $ans_data=$this->get_question_answers($where_ans,$outlet_id)->result_array();
                                $arr_question[$j]['answers']=$ans_data;
                                if($role == 'editor') {
                                    $arr_question[$j]['givenanswers']= Modules::run('api/_get_specific_table_with_pagination',array("assignment_id" =>$assign_id,"question_id" =>$row['question_id']),'assign_ans_id desc',$outlet_id.'_assignment_answer','answer_id,comments,answer_type,range,line_no,shift_no,user_id','1','1')->result_array();
                                    if(!empty($arr_question[$j]['givenanswers']) && $checking == false) {
                                        $checking = true;
                                        if(isset($arr_question[$j]['givenanswers'][0]['line_no']) && !empty($arr_question[$j]['givenanswers'][0]['line_no'])) {
                                            if(strtolower($arr_question[$j]['givenanswers'][0]['line_no']) !='n/a')
                                                $arr_data['line_no'] = $arr_question[$j]['givenanswers'][0]['line_no'];
                                        }
                                        if(isset($arr_question[$j]['givenanswers'][0]['shift_no']) && !empty($arr_question[$j]['givenanswers'][0]['shift_no'])) {
                                            if(strtolower($arr_question[$j]['givenanswers'][0]['shift_no']) !='n/a')
                                                $arr_data['shift_no'] = $arr_question[$j]['givenanswers'][0]['shift_no'];
                                        }
                                        if(isset($arr_question[$j]['givenanswers'][0]['user_id']) && !empty($arr_question[$j]['givenanswers'][0]['user_id'])) {
                                            $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$arr_question[$j]['givenanswers'][0]['user_id']),'id desc','users','first_name,last_name','1','1')->result_array();
                                            if(!empty($user_detail)) {
                                                $name = $second_name ='';
                                                if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                                    $name=$user_detail[0]['first_name'];
                                                if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name']))
                                                    $second_name=$user_detail[0]['last_name'];
                                                $arr_data['full_name']=  Modules::run('api/string_length',$name,'8000','',$second_name);
                                            }
                                        }
                                        $arr_data['complete_datetime']=$value['complete_datetime'];
                                    }
                                }
                                $j=$j+1;
                            endforeach;
                            $arr_data['questions']=$arr_question;
                            $check[]=$value['id'];
                        }
                    endforeach;
                }
            }
        }
        else
            $message=$api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>array($arr_data)));
    }*/
    /*function checklists_detail(){
        //////////////////////// function for check list detail///////
        $status=false;
        $message="Something Went Wrong";
        $arr_data=array();
        $outlet_id=$this->input->post('outlet_id');
        $assign_id=$this->input->post('assign_id');
        $role=$this->input->post('role');
        if(empty($role))
            $role = 'agent';
        $user_key = $this->check_user_api_key();
        $checking = false;
        if($user_key['key_status'] == true) {
            if(isset($outlet_id) && !empty($outlet_id) && isset($assign_id) && !empty($assign_id)) {
                $status=true;
                $table = $outlet_id.'_assignments';
                $message="No Data Found";
                $where['assignments.outlet_id']=$outlet_id;
                $where['assignments.assign_id']=$assign_id;
                $where['product_checks.status']=1;
                $checksdata=$this->get_checks_detail_from_db($where,$outlet_id)->result_array();
                $assignment_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array($table.".assign_id"=>$assign_id), $table.".assign_id desc",$table.".assign_id desc",$table,'checkid,complete_datetime','1','1','','','')->result_array();
                $i=0;
                if(isset($assignment_detail[0]['checkid']) && !empty($assignment_detail[0]['checkid'])){
                    $message="Record found successfully";
                    $checksdata = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$assignment_detail[0]['checkid']),"id desc","id desc",$outlet_id.'_product_checks','checkname,productid','1','1','','','')->result_array();
                    if(!empty($checksdata)) {
                        $arr_data['productid']='0'; if(isset($checksdata[0]['productid']) && !empty($checksdata[0]['productid'])) $arr_data['productid']=$checksdata[0]['productid']; $arr_data['productid']=  Modules::run('api/string_length',$arr_data['productid'],'8000','');
                        $arr_data['productname'] = "";
                        if(!empty($arr_data['productid'])) {
                            $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$checksdata[0]['productid']),"id desc","id desc",$outlet_id.'_product','product_title','1','1','','','')->result_array();
                            $arr_data['productname']='N/A'; if(isset($product_detail[0]['product_title']) && !empty($product_detail[0]['product_title'])) $arr_data['productname']=$product_detail[0]['product_title']; $arr_data['productname']=  Modules::run('api/string_length',$arr_data['productname'],'8000','');
                        }
                        else {
                            $arr_data['productname']='N/A'; if(isset($checksdata[0]['checkname']) && !empty($checksdata[0]['checkname'])) $arr_data['productname']=$checksdata[0]['checkname']; $arr_data['productname']=  Modules::run('api/string_length',$arr_data['productname'],'8000','');
                        }
                        $j=0;
                        $questions = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("checkid"=>$assignment_detail[0]['checkid']),"question_id desc","question_id desc",$outlet_id.'_checks_questions','type,question_id,question','1','0','','','')->result_array();
                        if(!empty($questions)) {
                            foreach ($questions as $key => $row):
                                $arr_question[$j]['question_id']=$row['question_id'];
                                $arr_question[$j]['question_title']=$row['question'];
                                $arr_question[$j]['question_type']=$row['type'];
                                $where_ans['question_id']=$row['question_id'];
                                $ans_data=$this->get_question_answers($where_ans,$outlet_id)->result_array();
                                $arr_question[$j]['answers']=$ans_data;
                                
                                if($role == 'editor') {
                                    $arr_question[$j]['givenanswers']= Modules::run('api/_get_specific_table_with_pagination',array("assignment_id" =>$assign_id,"question_id" =>$row['question_id']),'assign_ans_id desc',$outlet_id.'_assignment_answer','answer_id,comments,answer_type,range,line_no,shift_no,user_id','1','1')->result_array();
                                    if(!empty($arr_question[$j]['givenanswers']) && $checking == false) {
                                        $checking = true;
                                        if(isset($arr_question[$j]['givenanswers'][0]['line_no']) && !empty($arr_question[$j]['givenanswers'][0]['line_no'])) {
                                            if(strtolower($arr_question[$j]['givenanswers'][0]['line_no']) !='n/a')
                                                $arr_data['line_no'] = $arr_question[$j]['givenanswers'][0]['line_no'];
                                        }
                                        if(isset($arr_question[$j]['givenanswers'][0]['shift_no']) && !empty($arr_question[$j]['givenanswers'][0]['shift_no'])) {
                                            if(strtolower($arr_question[$j]['givenanswers'][0]['shift_no']) !='n/a')
                                                $arr_data['shift_no'] = $arr_question[$j]['givenanswers'][0]['shift_no'];
                                        }
                                        if(isset($arr_question[$j]['givenanswers'][0]['user_id']) && !empty($arr_question[$j]['givenanswers'][0]['user_id'])) {
                                            $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$arr_question[$j]['givenanswers'][0]['user_id']),'id desc','users','first_name,last_name','1','1')->result_array();
                                            if(!empty($user_detail)) {
                                                $name = $second_name ='';
                                                if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                                    $name=$user_detail[0]['first_name'];
                                                if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name']))
                                                    $second_name=$user_detail[0]['last_name'];
                                                $arr_data['full_name']=  Modules::run('api/string_length',$name,'8000','',$second_name);
                                            }
                                        }
                                        $arr_data['complete_datetime']=$assignment_detail[0]['complete_datetime'];
                                    }
                                }
                                $j=$j+1;
                            endforeach;
                            $arr_data['questions']=$arr_question;
                        }
                    }
                }
            }
        }
        else
            $message=$api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>array($arr_data)));
    }*/
     function checklists_detail(){
        //////////////////////// function for check list detail///////
        $reassing_answer = $reassign = $status=false;
        $message="Something Went Wrong";
        $arr_data=array();
        $outlet_id=$this->input->post('outlet_id');
        $assign_id=$this->input->post('assign_id');
        $checktype=$this->input->post('checktype');
        $role=$this->input->post('role');
      
        if(empty($role))
            $role = 'agent';
        $user_key = $this->check_user_api_key();
        $checking = false;
       //if($user_key['key_status'] == true) {
            if(isset($outlet_id) && !empty($outlet_id) && isset($assign_id) && !empty($assign_id)) {
                  $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones','1','1')->result_array();
                        if(!empty($timezone)) {
                            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                                date_default_timezone_set($timezone[0]['timezones']);
                        }
                $status=true;
                $table = $outlet_id.'_assignments';
                $message="No Data Found";
                /*$where['assignments.outlet_id']=$outlet_id;
                $where['assignments.assign_id']=$assign_id;
                $where['product_checks.status']=1;
                $checksdata=$this->get_checks_detail_from_db($where,$outlet_id)->result_array();*/
                $assignment_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array($table.".assign_id"=>$assign_id), $table.".assign_id desc",$table.".assign_id desc",$table,'checkid,complete_datetime,reassign_id,review_user,review_datetime,review_comments,approval_user,approval_datetime,appoval_comments,product_id,assignment_type','1','1','','','')->result_array();
                $i=0;
                if(isset($assignment_detail[0]['checkid']) && !empty($assignment_detail[0]['checkid'])){
                    $message="Record found successfully";
                    $checksdata = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$assignment_detail[0]['checkid']),"id desc","id desc",$outlet_id.'_product_checks','checkname,productid,check_subcat_id','1','1','','','')->result_array();
                    if(!empty($checksdata)) {
                        if(isset($assignment_detail[0]['product_id']) && !empty($assignment_detail[0]['product_id']))
                            $arr_data['productid'] = $assignment_detail[0]['product_id'];
                        elseif(isset($checksdata[0]['productid']) && !empty($checksdata[0]['productid']))
                            $arr_data['productid']=$checksdata[0]['productid'];
                        else
                            $arr_data['productid']='0';
                        $arr_data['productname'] = "";
                        if(!empty($arr_data['productid'])) {
                                $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$arr_data['productid']),"id desc","id desc",$outlet_id.'_product','product_title','1','1','','','')->result_array();
                                $arr_data['productname']='N/A'; if(isset($product_detail[0]['product_title']) && !empty($product_detail[0]['product_title'])) $arr_data['productname']=$product_detail[0]['product_title']; $arr_data['productname']=  Modules::run('api/string_length',$arr_data['productname'],'8000','');
                        }
                        elseif(isset($checksdata[0]['check_subcat_id']) && !empty($checksdata[0]['check_subcat_id'])) {
                            $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$checksdata[0]['check_subcat_id']),"id desc","id desc",'catagories','cat_name','1','1','','','')->result_array();
                            $arr_data['productname']='N/A'; if(isset($product_detail[0]['cat_name']) && !empty($product_detail[0]['cat_name'])) $arr_data['productname']=$product_detail[0]['cat_name']; $arr_data['productname']=  Modules::run('api/string_length',$arr_data['productname'],'8000','');
                        }
                        else {
                            $arr_data['productname']='N/A'; if(isset($checksdata[0]['checkname']) && !empty($checksdata[0]['checkname'])) $arr_data['productname']=$checksdata[0]['checkname']; $arr_data['productname']=  Modules::run('api/string_length',$arr_data['productname'],'8000','');
                        }
                        $j=0;
                        $question_condtion = array("checkid"=>$assignment_detail[0]['checkid']);
                        $assignment_type = false;
                        if(isset($assignment_detail[0]['assignment_type']) && !empty(!empty($assignment_detail[0]['assignment_type'])))
                            if($assignment_detail[0]['assignment_type'] == 'general_check')
                                $assignment_type = true;
                        if(isset($assignment_detail[0]['product_id']) && !empty($assignment_detail[0]['product_id']) && $assignment_type == true)
                            $question_condtion['assignment_id'] = $assign_id;
                        $questions = Modules::run('api/_get_specific_table_with_pagination_where_groupby',$question_condtion,"page_rank asc","question_id desc",$outlet_id.'_checks_questions','type,question_id,question','1','0','','','')->result_array();
                        $reassign_question = array();
                        if(!empty($assignment_detail[0]['reassign_id'])) {
                            $reassign_question = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("rq_assign_id"=>$assign_id),"rq_id desc","rq_id",$outlet_id.'_reassign_questions','rq_question_id,','1','0','','','')->result_array();
                        }
                        $arr_question = array();
                        if(!empty($questions)) {
                            foreach ($questions as $key => $row):
                                $key = "";
                                if(!empty($reassign_question)) {
                                    $key = array_search($row['question_id'], array_column($reassign_question, 'rq_question_id'));
                                }
                                if (is_numeric($key) || empty($reassign_question) ) {
                                    $arr_question[$j]['question_id']=$row['question_id'];
                                    $arr_question[$j]['question_title']=$row['question'];
                                    $arr_question[$j]['question_type']=$row['type'];
                                    $where_ans['question_id']=$row['question_id'];
                                    $ans_data=$this->get_question_answers($where_ans,$outlet_id)->result_array();
                                    $arr_question[$j]['answers']=$ans_data;
                                    if($role == 'editor' || $role == 'admin') {
                                        $arr_question[$j]['givenanswers']= Modules::run('api/_get_specific_table_with_pagination',array("assignment_id" =>$assign_id,"question_id" =>$row['question_id']),'assign_ans_id desc',$outlet_id.'_assignment_answer','answer_id,comments,answer_type,range,user_id,given_answer,line_no,shift_no','1','1')->result_array();
                                        if(!empty($arr_question[$j]['givenanswers']) && $checking == false) {
                                            $checking = true;
                                            if(isset($arr_question[$j]['givenanswers'][0]['line_no']) && !empty($arr_question[$j]['givenanswers'][0]['line_no'])) {
                                                if(strtolower($arr_question[$j]['givenanswers'][0]['line_no']) !='n/a')
                                                    $arr_data['line_no'] = $arr_question[$j]['givenanswers'][0]['line_no'];
                                            }
                                            if(isset($arr_question[$j]['givenanswers'][0]['shift_no']) && !empty($arr_question[$j]['givenanswers'][0]['shift_no'])) {
                                                if(strtolower($arr_question[$j]['givenanswers'][0]['shift_no']) !='n/a')
                                                    $arr_data['shift_no'] = $arr_question[$j]['givenanswers'][0]['shift_no'];
                                            }
                                            unset($arr_question[$j]['givenanswers'][0]['line_no']);
                                            unset($arr_question[$j]['givenanswers'][0]['shift_no']);
                                            if(isset($arr_question[$j]['givenanswers'][0]['user_id']) && !empty($arr_question[$j]['givenanswers'][0]['user_id'])) {
                                                $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$arr_question[$j]['givenanswers'][0]['user_id']),'id desc','users','first_name,last_name','1','1')->result_array();
                                                if(!empty($user_detail)) {
                                                    $name = $second_name ='';
                                                    if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                                        $name=$user_detail[0]['first_name'];
                                                    if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name']))
                                                        $second_name=$user_detail[0]['last_name'];
                                                    $arr_data['full_name']=  Modules::run('api/string_length',$name,'8000','',$second_name);
                                                }
                                            }
                                            $arr_data['complete_datetime']=$assignment_detail[0]['complete_datetime'];
                                            $arr_data['review_user']='N/A'; 
                                            if(isset($assignment_detail[0]['review_user']) && !empty($assignment_detail[0]['review_user'])) {
                                                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$assignment_detail[0]['review_user']),"id desc","id",'users','first_name,last_name','1','1','','','')->result_array();
                                                $first_name = "";
                                                if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                                    $first_name=$user_detail[0]['first_name'];
                                                $second_name = "";
                                                if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                                                    $second_name=$user_detail[0]['last_name'];
                                                $arr_data['review_user']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                            }
                                            $arr_data['reviewer_datetime']=''; if(isset($assignment_detail[0]['review_datetime']) && !empty($assignment_detail[0]['review_datetime'])) $arr_data['reviewer_datetime']=$assignment_detail[0]['review_datetime']; $arr_data['reviewer_datetime']=  Modules::run('api/string_length',$arr_data['reviewer_datetime'],'8000','');
                                            $arr_data['review_comments']=''; if(isset($assignment_detail[0]['review_comments']) && !empty($assignment_detail[0]['review_comments'])) $arr_data['review_comments']=$assignment_detail[0]['review_comments']; $arr_data['review_comments']=  Modules::run('api/string_length',$arr_data['review_comments'],'8000','');

                                            $arr_data['approval_user']='N/A'; 
                                            if(isset($assignment_detail[0]['approval_user']) && !empty($assignment_detail[0]['approval_user'])) {
                                                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$assignment_detail[0]['approval_user']),"id desc","id",'users','first_name,last_name','1','1','','','')->result_array();
                                                $first_name = "";
                                                if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                                    $first_name=$user_detail[0]['first_name'];
                                                $second_name = "";
                                                if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                                                    $second_name=$user_detail[0]['last_name'];
                                                $arr_data['approval_user']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                            }
                                            $arr_data['approval_datetime']=''; if(isset($assignment_detail[0]['approval_datetime']) && !empty($assignment_detail[0]['approval_datetime'])) $arr_data['approval_datetime']=$assignment_detail[0]['approval_datetime']; $arr_data['approval_datetime']=  Modules::run('api/string_length',$arr_data['approval_datetime'],'8000','');
                                            $arr_data['appoval_comments']=''; if(isset($assignment_detail[0]['appoval_comments']) && !empty($assignment_detail[0]['appoval_comments'])) $arr_data['appoval_comments']=$assignment_detail[0]['appoval_comments']; $arr_data['appoval_comments']=  Modules::run('api/string_length',$arr_data['appoval_comments'],'8000','');
                                        }
                                    }
                                    $j=$j+1;
                                }
                            endforeach;
                            $arr_data['questions']=$arr_question;
                        }
                        $media_files = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$assign_id,'outlet_id'=>$outlet_id),'media_id desc',$outlet_id.'_media','media_name,media_type','1','0')->result_array();
                        if(!empty($media_files)) {
                            $temp ="";
                            foreach ($media_files as $key => $mf):
                                $path = STATIC_ADMIN_IMAGE.'no-image-available.jpg';
                                if(isset($mf['media_name']) && !empty($mf['media_name']))
                                    $path=Modules::run('api/image_path_with_default',ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH,$mf['media_name'],STATIC_ADMIN_IMAGE,'no-image-available.jpg');
                                $mf['media_name'] = $path;
                                $temp[] = $mf;
                            endforeach;
                            $media_files = $temp; unset($temp);
                        }
                        $arr_data['media_files'] = $media_files;
                        if($role == 'editor' || $role == 'admin') {
                            
                            $reassign_data = array();
                            $reassign_assignment = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("reassign_id"=>$assign_id),"assign_id desc","assign_id",$outlet_id.'_assignments','assign_id,checkid,inspection_team,reassign_user','1','1','','','')->result_array();
                            if(!empty($reassign_assignment)) {
                                $reassign = true;
                                $name = "N/A";
                                $name_type = "";
                                $reassign_user = 0;
                                if(isset($reassign_assignment[0]['inspection_team']) && !empty($reassign_assignment[0]['inspection_team'])) {
                                    $group_name = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$reassign_assignment[0]['inspection_team']),"id desc","id",$outlet_id.'_groups','group_title','1','1','','','')->result_array();
                                    $name=''; if(isset($group_name[0]['group_title']) && !empty($group_name[0]['group_title'])) $name=$group_name[0]['group_title']; $name=  Modules::run('api/string_length',$name,'8000','');
                                    $name_type = "group";
                                }
                                elseif(isset($reassign_assignment[0]['reassign_user']) && !empty($reassign_assignment[0]['reassign_user'])) {
                                    $reassign_user = $reassign_assignment[0]['reassign_user'];
                                    $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$reassign_assignment[0]['reassign_user']),"id desc","id",'users','first_name,last_name','1','1','','','')->result_array();
                                    $first_name = "";
                                    if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                        $first_name=$user_detail[0]['first_name'];
                                    $second_name = "";
                                    if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                                        $second_name=$user_detail[0]['last_name'];
                                    $name=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                    $name_type = "user";
                                }
                                else
                                    echo "";
                                $reassign_data['name'] = $name;
                                $reassign_data['name_type'] = $name_type;
                                $assignment_answer = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("assignment_id"=>$reassign_assignment[0]['assign_id']),"assign_ans_id desc","assign_ans_id",$outlet_id.'_assignment_answer','line_no,shift_no,user_id','1','1','','','')->result_array();
                                $reassign_data['line_no']=''; if(isset($assignment_answer[0]['line_no']) && !empty($assignment_answer[0]['line_no'])) { $reassign_data['line_no']=$assignment_answer[0]['line_no']; $reassing_answer = true; } $reassign_data['line_no']=  Modules::run('api/string_length',$reassign_data['line_no'],'8000','');
                                $reassign_data['shift_no']=''; if(isset($assignment_answer[0]['shift_no']) && !empty($assignment_answer[0]['shift_no'])) { $reassign_data['shift_no']=$assignment_answer[0]['shift_no']; $reassing_answer = true; } $reassign_data['shift_no']=  Modules::run('api/string_length',$reassign_data['shift_no'],'8000','');
                                if(isset($assignment_answer[0]['user_id']) && !empty($assignment_answer[0]['user_id'])) {
                                    if($assignment_answer[0]['user_id'] != $reassign_user && $reassign_user != 0) {
                                        $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$assignment_answer[0]['user_id']),"id desc","id",'users','first_name,last_name','1','1','','','')->result_array();
                                        $first_name = "";
                                        if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                                            $first_name=$user_detail[0]['first_name'];
                                        $second_name = "";
                                        if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                                            $second_name=$user_detail[0]['last_name'];
                                        $name=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                        $name_type = "user";
                                        $reassign_data['name'] = $name;
                                    }
                                }
                                $reassign_question = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("rq_assign_id"=>$reassign_assignment[0]['assign_id']),"rq_id desc","rq_id",$outlet_id.'_reassign_questions','rq_question_id,','1','0','','','')->result_array();
                                $j = 0;
                                if(isset($reassign_question) && !empty($reassign_question) && !empty($questions)) {
                                    foreach ($questions as $key => $row):
                                        $key = array_search($row['question_id'], array_column($reassign_question, 'rq_question_id'));
                                        if (is_numeric($key)) {
                                            $reassign_data['question'][$j]['question_id']=$row['question_id'];
                                            $reassign_data['question'][$j]['question_title']=$row['question'];
                                            $reassign_data['question'][$j]['question_type']=$row['type'];
                                            $where_ans['question_id']=$row['question_id'];
                                            $ans_data=$this->get_question_answers($where_ans,$outlet_id)->result_array();
                                            $reassign_data['question'][$j]['answers']=$ans_data;
                                            $reassign_data['question'][$j]['givenanswers']= Modules::run('api/_get_specific_table_with_pagination',array("assignment_id" =>$reassign_assignment[0]['assign_id'],"question_id" =>$row['question_id']),'assign_ans_id desc',$outlet_id.'_assignment_answer','answer_id,comments,answer_type,range,user_id,given_answer,line_no,shift_no','1','1')->result_array();
                                            $j=$j+1;
                                        }
                                    endforeach;
                                }
                            $arr_data['reassign_data'] = $reassign_data;
                            
                            }
                        }
                    }
               }
            }
            if($checktype !="general qa check" || $checktype!='herb_spice'){
                $table = $outlet_id.'_assignments';
                $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'));
                $assignment_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array($table.".assign_id"=>$assign_id), $table.".assign_id desc",$table.".assign_id desc",$table,'checkid,complete_datetime,reassign_id,review_user,review_datetime,review_comments,approval_user,approval_datetime,appoval_comments,product_id,assignment_type','1','1','','','')->result_array();
                if(!empty($assignment_detail)){
                    $checkid=$assignment_detail[0]['checkid'];
                    $checkdetail_s=$this->get_check_category_details($checkid)->row_array();
                      if(strtolower($checkdetail_s['cat_name']) =="usda"){
                       $product_type="USDA";
                       $where_data['storage_type']=$product_type;
                     }
                     elseif(strtolower($checkdetail_s['cat_name']) =="fda"){
                     $product_type="FDA";
                        $where_data['storage_type']=$product_type;
                     }
                     elseif(strtolower($checkdetail_s['cat_name']) =="organic"){
                     $product_type="Organic";
                     $where_data['product_type']=$product_type;
                     }
                     elseif(strtolower($checkdetail_s['cat_name']) =="frozen"){
                   
                     $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),"storage_type"=>"Frozen");
                      $where_data['storage_type']='Frozen';
                     }
                     elseif(strtolower($checkdetail_s['cat_name']) =="refrigerated"){
                      $where_data['storage_type']='Refrigerated';
                    
                     }
                     
                       
                        $product_schedules = $this->get_product_schedules_from_db($where_data,'ps_id desc','ps_id',DEFAULT_OUTLET,'id,ps_product,product_title,ps_line,unit_weight,shape,product_type,storage_type','1','0','','','')->result_array();
                        if(!empty($product_schedules)){
                            foreach($product_schedules as $product){
                                $temp_data['productid']=$product['id'];
                                $temp_data['product_title']=$product['product_title'];
                                $temp_array[]=$temp_data;
                            }
                        }
                       
                }
            }
       // }
        //else
          // $message=$api_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>array($arr_data),"reassign"=>$reassign,"reassing_answer"=>$reassing_answer));
    }
    function submit_assignments_answers(){
        $status=false;
        $message="Please check something went wrong";
        $line_no=$this->input->post('line_no');
        $shift_no=$this->input->post('shift_no');
        $assign_id=$this->input->post('assign_id');
        $user_id=$this->input->post('user_id');
        $outlet_id=$this->input->post('outlet_id');
        $assign_name=$this->input->post('assign_name');
        $program_types=$this->input->post('program_types');
        if(!empty($program_types))
            $program_types = explode(',', $program_types);
        $ques_response = json_decode($this->input->post('ques_response'));
        if(empty($assign_name))
            $assign_name = "Assignment Name";
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(isset($line_no) && !empty($line_no) && isset($shift_no) && !empty($shift_no) && isset($assign_id) && !empty($assign_id) && isset($ques_response) && !empty($ques_response) && isset($outlet_id) && !empty($outlet_id) && isset($user_id) && !empty($user_id)){
                if($open_close=="Open"){
                    $where['assignment_id']=$assign_id;
                    $arr_assignments=$this->check_from_assignment_answers($where,$outlet_id)->result_array();
                    if(empty($arr_assignments)){
                        date_default_timezone_set("Asia/karachi");
                        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones','1','1')->result_array();
                        if(!empty($timezone)) {
                            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                                date_default_timezone_set($timezone[0]['timezones']);
                        }
                        $check = 1;
                        foreach ($ques_response as $key => $qs):
                            if(isset($qs->resp->quesId) && !empty($qs->resp->quesId)) {
                                $check = $check+1;
                                $data['line_no']=$line_no;
                                $data['shift_no']=$shift_no;
                                $data['answer_type']=$qs->resp->quesType;
                                if($data['answer_type']=="Range")
                                    $data['range']=$qs->resp->givenRange;
                                else
                                    $data['range']='0.0';
                                $data['assignment_id']=$assign_id;
                                $data['question_id']=$qs->resp->quesId;
                                $data['answer_id']=$qs->resp->selecetedAnsId;
                                $data['comments']=$qs->resp->comment;
                                $data['given_answer']=$qs->resp->givenAns;
                                $data['user_id']=$user_id;
                                $insert_id = $this->insert_assign_answers($outlet_id,$data);
                                unset($data);
                            }
                        endforeach;
                        if($check !=1) {
                            $status=true;
                            $message="Answer submitted successfully";
                            $where_assign['assign_id']=$assign_id;
                            $update_data['assign_status']="Review";
                            $update_data['complete_datetime'] = date("Y-m-d H:i:s");
                            $this->update_assignment_status($where_assign,$update_data,$outlet_id);
                            if(!empty($program_types)) {
                                foreach ($program_types as $key => $pt):
                                    if(!empty($pt))
                                        Modules::run('api/insert_or_update',array("ap_assignment"=>$assign_id,"ap_outlet_id"=>$outlet_id,"ap_program"=>$pt),array("ap_assignment"=>$assign_id,"ap_outlet_id"=>$outlet_id,"ap_program"=>$pt),$outlet_id.'_assignment_programs');
                                endforeach;
                            }
                        }
                        /////////// notification code umar start///////////
                        $review_group = Modules::run('api/_get_specific_table_with_pagination',array("assign_id" =>$assign_id),'assign_id desc',$outlet_id.'_assignments','review_team','1','1')->result_array();
                        if(isset($review_group[0]['review_team']) && !empty($review_group[0]['review_team'])) {
                            $fcm_token = Modules::run('api/_get_specific_table_with_pagination_and_where',array("fcm_token !="=>"",'status'=>'1'),'id desc','users','fcm_token','1','0','(`second_group`="'.$review_group[0]['review_team'].'" or `group`="'.$review_group[0]['review_team'].'")','','')->result_array();
                            $user_name = "";
                            $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$user_id),'id desc','users','user_name','1','1')->result_array();
                            if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name']))
                                $user_name = $user_detail[0]['user_name'];
                            if(!empty($fcm_token)) {
                                $token = array();
                                foreach ($fcm_token as $key => $value):
                                    $token[] = $value['fcm_token'];
                                endforeach;
                                $fcm_token = $token;
                                $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been completed by ".$user_name.", please login to the system to review the data.",false,false,"");
                                Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                            }
                            $users_id = Modules::run('api/_get_specific_table_with_pagination_and_where',array(),'id desc','users','id','1','0','(`second_group`="'.$review_group[0]['review_team'].'" or `group`="'.$review_group[0]['review_team'].'")','','')->result_array();
                            if(!empty($users_id)) {
                                foreach ($users_id as $key => $ui):
                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$ui['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been completed by ".$user_name.", please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                endforeach;
                            }
                        }
                        /////////// notification code umar end///////////
                    }
                    else{
                        $message="this question has been answerd already!";
                    }
                   
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function delete_media_file() {
        $status=false;
        $message="Bad request";
        $assign_id=$this->input->post('assign_id');
        $outlet_id=$this->input->post('outlet_id');
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($assign_id) &&  !empty($outlet_id)) {
                $previous_images = $myRefLinks = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id" =>$assign_id,"outlet_id"=>$outlet_id),'assignment_id desc',$outlet_id.'_media','media_name','1','0')->result_array();
                if(!empty($previous_images)) {
                    foreach($previous_images as $key=>$pi):
                        if(isset($pi['media_name']) && !empty($pi['media_name']))
                            Modules::run('api/delete_images_by_name',ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH,LARGE_ASSIGNMENT_ANSWER_IMAGE_PATH,MEDIUM_ASSIGNMENT_ANSWER_IMAGE_PATH,SMALL_ASSIGNMENT_ANSWER_IMAGE_PATH,$pi['media_name']);
                    endforeach;
                }
                Modules::run('api/delete_from_specific_table',array("assignment_id"=>$assign_id,"outlet_id"=>$outlet_id),$outlet_id."_media");
                $status = true;
                $message = "Successfuly deleted";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_media_file() {
        $status=false;
        $message="Bad request";
        $assign_id=$this->input->post('assign_id');
        $user_id=$this->input->post('user_id');
        $outlet_id=$this->input->post('outlet_id');
        $media_type=$this->input->post('media_type');
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($assign_id) && !empty($user_id) && !empty($outlet_id) && !empty($media_type)) {
                if(isset($_FILES['answer_media']) && !empty($_FILES['answer_media']) && $_FILES['answer_media']['size'] >0) {
                    $status = true;
                    $message ="Data saved";
                    $this->upload_answer_media_files($assign_id,$outlet_id,$media_type);
                }
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_truck_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("ti_monitor_name"=>$this->input->post('monitorName'),"ti_datetime"=>date("Y-m-d")." ".$this->input->post('time'),"ti_invoice_no"=>$this->input->post('InvoiceNo'),"ti_item_name"=>$this->input->post('itemName'),"ti_suppler_name"=>$this->input->post('supplierName'),"ti_suppler_approve"=>$this->input->post('SPApprovedIndex'),"ti_carrier_name"=>$this->input->post('carrierName'),"ti_truck_license"=>$this->input->post('truckLPlate'),"ti_trailer_license"=>$this->input->post('trailerLPlate'),"ti_driver_license_info"=>$this->input->post('driverLInfo'),"ti_trailer_sealed"=>$this->input->post('trailerSealedIndx'),"ti_trailer_locked"=>$this->input->post('trailerLockedIndx'),"ti_signs_of_tampering"=>$this->input->post('materialsFreeIndex'),"ti_truck_condition_acceptable"=>$this->input->post('truckInsideIndx'),"ti_product_condition"=>$this->input->post('productCondtionIndx'),"ti_product_temperature"=>$this->input->post('productTempIndx'),"ti_visual_verification"=>$this->input->post('vvOfProductIndx'),"ti_allergen_verification"=>$this->input->post('allergenContentIndx'),"ti_contains_allergen"=>$this->input->post('allergentaqggedIndx'),"ti_expiration_date"=>$this->input->post('markedWithExpDateIndx'),"ti_summery"=>$this->input->post('inspectionSummaryIndx'),"ti_follow_up_action"=>$this->input->post('followUpAction'),"ti_corrective_action"=>$this->input->post('correctiveActionDetail'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("ti_monitor_name"=>$this->input->post('monitorName'),"ti_datetime"=>date("Y-m-d")." ".$this->input->post('time')),$data,$outlet_id.'_truck_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_shipping_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("si_checkin_time"=>date("Y-m-d")." ".$this->input->post('checkIntime'),"si_sale_order_no"=>$this->input->post('soNo'),"si_item_name"=>$this->input->post('itemName'),"si_customer_name"=>$this->input->post('customerName'),"si_carrier_name"=>$this->input->post('carrierName'),"si_truck_trailer_plate"=>$this->input->post('truckTrailerLPlate'),"si_driver_info"=>$this->input->post('driverLInfo'),"si_truck_set_temp"=>$this->input->post('truckSetTemp'),"si_truck_reading_temp"=>$this->input->post('truckReadingTemp'),"si_truck_condition_acceptable"=>$this->input->post('truckCondiAcceptable'),"si_frozen_product_temp"=>$this->input->post('frozenProductTemp'),"si_refrigerated_product"=>$this->input->post('refrigeratedProductTemp'),"si_first_product_surface_temp"=>$this->input->post('firstProductSurfaceTemp'),"si_last_product_surface_temp"=>$this->input->post('lastProductSurfaceTemp'),"si_product_condition_acceptable"=>$this->input->post('productCondiAcceptable'),"si_sign_of_temparing"=>$this->input->post('signOfTemparing'),"si_is_secured"=>$this->input->post('isSecured'),"si_seal_no"=>$this->input->post('sealNo'),"si_is_bol"=>$this->input->post('isBOL'),"si_inspection_summary"=>$this->input->post('inspectionSummary'),"si_checkout_time"=>date("Y-m-d").' '.$this->input->post('checkOutTime'),"si_followup_action"=>$this->input->post('followUpAction'),"si_corrective_action"=>$this->input->post('correctiveAction'),"si_monitor_name"=>$this->input->post('user_id'),"si_line"=>$this->input->post('line_timing'),"si_shift"=>$this->input->post('shift_timing'),"si_plant"=>$this->input->post('plant_name'),"si_lot_number"=>$this->input->post('lotNo'),"si_lot_number_check"=>$this->input->post('lotNoCheck'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("si_monitor_name"=>$this->input->post('monitorName'),"si_checkin_time"=>date("Y-m-d")." ".$this->input->post('checkIntime')),$data,$outlet_id.'_shipping_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_palletizing_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("pi_time"=>date("Y-m-d")." ".$this->input->post('time'),"pi_item_number"=>$this->input->post('itemNumber'),"pi_pallet_number"=>$this->input->post('palletNo'),"pi_cases"=>$this->input->post('cases'),"pi_used_by_date"=>date('Y-m-d',strtotime(str_replace("-","/",$this->input->post('usedByDate')))),"pi_code_date"=>date('Y-m-d',strtotime(str_replace("-","/",$this->input->post('codeDate')))),"pi_initials"=>$this->input->post('user_id'),"pi_line"=>$this->input->post('line_timing'),"pi_shift"=>$this->input->post('shift_timing'),"pi_plant"=>$this->input->post('plant_name'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("pi_time"=>date("Y-m-d")." ".$this->input->post('time'),"pi_item_number"=>$this->input->post('itemNumber')),$data,$outlet_id.'_palletizing_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_cleaning_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("ci_datetime"=>date("Y-m-d H:i:s"),"ci_monitor_name"=>$this->input->post('user_id'),"ci_circle"=>$this->input->post('circleSelectedVal'),"ci_last_product"=>$this->input->post('plProduced'),"ci_product_start"=>$this->input->post('ptbStarted'),"ci_allergen_profile"=>$this->input->post('allergenProfile1'),"ci_allergen_second_profile"=>$this->input->post('allergenProfile2'),"ci_question1_answer"=>$this->input->post('q1SelectedVal'),"ci_question1_correct_answer"=>$this->input->post('q1CorrectiveAction'),"ci_question2_answer"=>$this->input->post('q2SelectedVal'),"ci_question2_correct_answer"=>$this->input->post('q2CorrectiveAction'),"ci_question3_answer"=>$this->input->post('q3SelectedVal'),"ci_question3_correct_answer"=>$this->input->post('q3CorrectiveAction'),"ci_question4_answer"=>$this->input->post('q4SelectedVal'),"ci_question4_correct_answer"=>$this->input->post('q4CorrectiveAction'),"ci_question5_answer"=>$this->input->post('q5SelectedVal'),"ci_question5_correct_answer"=>$this->input->post('q5CorrectiveAction'),"ci_question6_answer"=>$this->input->post('q6SelectedVal'),"ci_question6_correct_answer"=>$this->input->post('q6CorrectiveAction'),"ci_question7_answer"=>$this->input->post('q7SelectedVal'),"ci_question7_correct_answer"=>$this->input->post('q7CorrectiveAction'),"ci_question8_answer"=>$this->input->post('q8SelectedVal'),"ci_question8_correct_answer"=>$this->input->post('q8CorrectiveAction'),"ci_question9_answer"=>$this->input->post('q9SelectedVal'),"ci_question9_correct_answer"=>$this->input->post('q9CorrectiveAction'),"ci_question10_answer"=>$this->input->post('q10SelectedVal'),"ci_question10_correct_answer"=>$this->input->post('q10CorrectiveAction'),"ci_question11_answer"=>$this->input->post('q11SelectedVal'),"ci_question11_correct_answer"=>$this->input->post('q11CorrectiveAction'),"ci_question12_answer"=>$this->input->post('q12SelectedVal'),"ci_question12_correct_answer"=>$this->input->post('q12CorrectiveAction'),"ci_question13_answer"=>$this->input->post('q13SelectedVal'),"ci_question13_correct_answer"=>$this->input->post('q13CorrectiveAction'),"ci_question14_answer"=>$this->input->post('q14SelectedVal'),"ci_question14_correct_answer"=>$this->input->post('q14CorrectiveAction'),"ci_question15_answer"=>$this->input->post('q15SelectedVal'),"ci_question15_correct_answer"=>$this->input->post('q15CorrectiveAction'),"ci_question16_answer"=>$this->input->post('q16SelectedVal'),"ci_question16_correct_answer"=>$this->input->post('q16CorrectiveAction'),"ci_question17_answer"=>$this->input->post('q17SelectedVal'),"ci_question17_correct_answer"=>$this->input->post('q17CorrectiveAction'),"ci_question18_answer"=>$this->input->post('q18SelectedVal'),"ci_question18_correct_answer"=>$this->input->post('q18CorrectiveAction'),"ci_question19_answer"=>$this->input->post('q19SelectedVal'),"ci_question19_correct_answer"=>$this->input->post('q19CorrectiveAction'),"ci_question20_answer"=>$this->input->post('q20SelectedVal'),"ci_line"=>$this->input->post('line_timing'),"ci_shift"=>$this->input->post('shift_timing'),"ci_plant"=>$this->input->post('plant_name'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("ci_datetime"=>date("Y-m-d H:i:s"),"ci_monitor_name"=>$this->input->post('user_id')),$data,$outlet_id.'_cleaning_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_bulk_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("bi_datetime"=>date("Y-m-d H:i:s"),"bi_initial"=>$this->input->post('user_id'),"bi_packing_operator"=>$this->input->post('packingOperator'),"bi_product_name"=>$this->input->post('productName'),"bi_item_no"=>$this->input->post('itemNumber'),"bi_pallet_no"=>$this->input->post('palletNo'),"bi_time_in_cooler"=>date('H:i:s',strtotime(str_replace("-","/",$this->input->post('timeInCooler')))),"bi_time_out_cooler"=>date('H:i:s',strtotime($this->input->post('timeOutCooler'))),"bi_temperature"=>$this->input->post('temp'),"bi_corrective_action"=>$this->input->post('correctiveAction'),"bi_line"=>$this->input->post('line_timing'),"bi_shift"=>$this->input->post('shift_timing'),"bi_plant"=>$this->input->post('plant_name'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("bi_datetime"=>date("Y-m-d H:i:s"),"bi_initial"=>$this->input->post('user_id')),$data,$outlet_id.'_bulk_tub_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_bulk_form_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("bfi_datetime"=>date("Y-m-d H:i:s"),"bfi_initial"=>$this->input->post('user_id'),"bfi_item"=>$this->input->post('item'),"bfi_lotcode"=>$this->input->post('lotCode'),"bfi_expdate"=>date('Y-m-d',strtotime(str_replace("-","/",$this->input->post('expDate')))),"bfi_date"=>date('Y-m-d',strtotime(str_replace("-","/",$this->input->post('date')))),"bfi_time"=>date('H:i:s',strtotime($this->input->post('time'))),"bfi_allergen"=>$this->input->post('allergen'),"bfi_quantity"=>$this->input->post('qty'),"bfi_pallet_no"=>$this->input->post('palletNo'),"bfi_line"=>$this->input->post('line_timing'),"bfi_shift"=>$this->input->post('shift_timing'),"bfi_plant"=>$this->input->post('plant_name'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("bfi_datetime"=>date("Y-m-d H:i:s"),"bfi_initial"=>$this->input->post('user_id')),$data,$outlet_id.'_bulk_form_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function submit_recode_inspection(){
        $status=false;
        $message="Please check something went wrong";
        $outlet_id = $this->input->post('outlet_id');
        date_default_timezone_set("Asia/karachi");
        if(isset($outlet_id) && !empty($outlet_id))
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
        if(isset($timezones[0]['timezones']) && !empty($timezones[0]['timezones']))
            date_default_timezone_set($timezones[0]['timezones']);
        $data=array("ri_datetime"=>date("Y-m-d H:i:s"),"ri_initial"=>$this->input->post('user_id'),"ri_source_item_no"=>$this->input->post('source_item_no'),"ri_source_product_temperature"=>$this->input->post('source_product_temp'),"ri_source_brand_name"=>$this->input->post('source_brand_name'),"ri_source_product_name"=>$this->input->post('source_product_name'),"ri_source_allergens"=>$this->input->post('source_allergens'),"ri_source_case_used"=>$this->input->post('source_case_used'),"ri_source_production_date"=>date('Y-m-d',strtotime(str_replace("-","/",$this->input->post('source_production_date')))),"ri_source_nav_lot_code"=>$this->input->post('source_nav_lot_code'),"ri_pack_item_no"=>$this->input->post('pack_to_item_no'),"ri_pack_brand_name"=>$this->input->post('pack_to_brand_name'),"ri_pack_product_name"=>$this->input->post('pack_to_product_name'),"ri_pack_allergens"=>$this->input->post('pack_to_allergens'),"ri_pack_cases_made"=>$this->input->post('pack_to_cases_made'),"ri_pack_exp_date"=>date('Y-m-d',strtotime(str_replace("-","/",$this->input->post('pack_to_exp_date')))),"ri_comments"=>$this->input->post('comments'),"ri_selected_source"=>$this->input->post('selected_source'),"ri_line"=>$this->input->post('line_timing'),"ri_shift"=>$this->input->post('shift_timing'),"ri_plant"=>$this->input->post('plant_name'));
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
            if(!empty($data)){
                if($open_close=="Open"){
                    $status=true;
                    $message="Inpection saved";
                    Modules::run('api/insert_or_update',array("ri_datetime"=>date("Y-m-d H:i:s"),"ri_initial"=>$this->input->post('user_id')),$data,$outlet_id.'_recode_inspection');  
                }
                else
                    $message="Business Has been Closed";
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
    }
    function upload_answer_media_files($nId,$outlet_id,$media_type){
        $upload_image_file = $_FILES['answer_media']['name'];
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'assignment-'.$outlet_id.$nId . '-'.$this->random_color().'_'. $upload_image_file;
        $file_name = strtolower(str_replace(['  ', '/','-','--','---','----', '_', '__'], '-',$file_name));
        $config['upload_path'] = ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH;
        $config['allowed_types'] = '*';
        $config['max_size'] = '20000';
        $config['max_width'] = '2000000000';
        $config['max_height'] = '2000000000';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES['answer_media'])) {
            $this->upload->do_upload('answer_media');
        }
        $upload_data = $this->upload->data();
        unset($data);unset($where);
        $data = array('media_name' => $file_name,'outlet_id'=>$outlet_id,'assignment_id'=>$nId);
        $where['assignment_id'] = $nId;
        Modules::run('api/insert_into_specific_table',array('media_name' => $file_name,'outlet_id'=>$outlet_id,'assignment_id'=>$nId,'media_type'=>$media_type),$outlet_id.'_media');
    }
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
    function get_fixed_forms() {
        $status=false;
        $message="Bad request";
        $group_id = $this->input->post('group_id');
        $user_id=$this->input->post('user_id');
        $outlet_id=$this->input->post('outlet_id');
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        $page_number=$this->input->post('page_number');
        if(!is_numeric($page_number))
            $page_number = 1;
        $limit=$this->input->post('limit');
        if(!is_numeric($limit))
            $limit = 20;
        $total_pages=0;
        $static_form = array();
        if($user_key['key_status'] == true) {
            if(is_numeric($group_id) && is_numeric($outlet_id)) {
                $status = true;
                $message = "Successfuly executed";
                date_default_timezone_set("Asia/karachi");
                $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
                if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                    date_default_timezone_set($timezone[0]['timezones']);
                $static_form = $this->get_static_forms(array("sf_status"=>'1','sf_delete_status'=>'0','sf_start_datetime <='=>date("Y-m-d H:i:s"),'sf_end_datetime >='=>date("Y-m-d H:i:s"),"sci_team_id"=>$group_id),'sf_id desc','sf_id',$outlet_id,'sf_name as check_name,sf_start_datetime as start_datetime,sf_id as check_id',$page_number,$limit,'','','')->result_array();
                if(!empty($static_form)) {
                    $total_pages = $this->get_static_forms(array("sf_status"=>'1','sf_delete_status'=>'0','sf_start_datetime <='=>date("Y-m-d H:i:s"),'sf_end_datetime >='=>date("Y-m-d H:i:s"),"sci_team_id"=>$group_id),'sf_id desc','sf_id',$outlet_id,'sf_name as check_name,sf_start_datetime as start_datetime,sf_id as check_id','1','0','','','')->num_rows();
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                }
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"static_form"=>$static_form,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    function get_fixed_forms_detail() {
        $status=false;
        $message="Bad request";
        $check_id = $this->input->post('check_id');
        $user_id=$this->input->post('user_id');
        $outlet_id=$this->input->post('outlet_id');
        $open_close=$this->outlet_open_close($outlet_id);
        $user_key = $this->check_user_api_key();
        $final_array = array();
        if($user_key['key_status'] == true) {
            if(is_numeric($check_id) && is_numeric($outlet_id)) {
                $status = true;
                $message = "Successfuly executed";
                $questions= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_status"=>'1',"sfq_delete"=>"0","sfq_check_id"=>$check_id),'sfq_id desc','sfq_id',$outlet_id.'_static_form_question','sfq_id as question_id,sfq_question as question,sfq_question_type as question_type,sfq_question_selection as selection,sfq_selection_type as custom_answers','1','0','','','')->result_array();
                if(!empty($questions)) {
                    foreach ($questions as $key => $qa):
                        if(isset($qa['question_type']) && !empty($qa['question_type'])) {
                            $qa['question_type'] = strtolower($qa['question_type']);
                            if($qa['question_type'] == 'choice') {
                                $qa['possible_answer'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfa_status"=>'1',"sfa_delete"=>"0","sfa_question_id"=>$qa['question_id']),'sfa_id desc','sfa_id',$outlet_id.'_static_form_answer','sfa_id as answer_id,sfa_answer as answer,sfa_answer_acceptance as acceptance','1','0','','','')->result_array();
                            }
                            elseif($qa['question_type'] == 'range') {
                                $possible_answer[0]['name'] = 'refrigerated';
                                $possible_answer[0]['data'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfa_status"=>'1',"sfa_delete"=>"0","sfa_question_id"=>$qa['question_id'],'sfa_answer_acceptance'=>'refrigerated'),'sfa_id desc','sfa_id',$outlet_id.'_static_form_answer','sfa_id as answer_id,sfa_min as min,sfa_max as max,sfa_target as target','1','0','','','')->result_array();
                                $possible_answer[1]['name'] = 'frozen';
                                $possible_answer[1]['data'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfa_status"=>'1',"sfa_delete"=>"0","sfa_question_id"=>$qa['question_id'],'sfa_answer_acceptance'=>'frozen'),'sfa_id desc','sfa_id',$outlet_id.'_static_form_answer','sfa_id as answer_id,sfa_min as min,sfa_max as max,sfa_target as target','1','0','','','')->result_array();
                                $qa['possible_answer'] = $possible_answer;
                                unset($possible_answer);
                            }
                            else
                                echo "";
                            $final_array[] = $qa;
                            unset($qa);
                        }
                    endforeach;
                }
            }
        }
        else
            $message=$user_key['key_message'];
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"final_array"=>$final_array));
    }
    /*function checklists_detail(){   //////////////////////// function for check list detail///////
    $status=false;
    $message="Something Went Wrong";
    $arr_data=array();
    $outlet_id=$this->input->post('outlet_id');
    $assign_id=$this->input->post('assign_id');
    
             $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {
    if(isset($outlet_id) && !empty($outlet_id) && isset($assign_id) && !empty($assign_id)){
        $status=true;
        $message="No Data Found";
            $where['assignments.outlet_id']=$outlet_id;
            $where['assignments.assign_id']=$assign_id;
            $where['product_checks.status']=1;
            //$where['checks_questions.checkid']=$checkid;
           
            $checksdata=$this->get_checks_detail_from_db($where,$outlet_id)->result_array();
            $i=0;
                if(!empty($checksdata)){
                    $message="Record found successfully";
                    $check='';
                        foreach ($checksdata as $key => $value) {
                          
                            if($check!=$value['id']){
                            $arr_data['productid']=$value['productid'];
                            $arr_data['productname']=$value['product_title'];
                            $j=0;
                          foreach ($checksdata as $key => $row) {
                            $arr_question[$j]['question_id']=$row['question_id'];
                            $arr_question[$j]['question_title']=$row['question'];
                            $arr_question[$j]['question_type']=$row['type'];
                            $where_ans['question_id']=$row['question_id'];
                            $ans_data=array();
                            $ans_data=$this->get_question_answers($where_ans,$outlet_id)->result_array();
                           
                          
                            $arr_question[$j]['answers']=$ans_data;
                            $j=$j+1;

                          }
                          $arr_data['questions']=$arr_question;
                            $check=$value['id'];
                        }
                    }
                  
                }
        }
     
     }else
        $message=$api_key['key_message'];
       header('Content-Type: application/json');
        
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>array($arr_data)));
  }*/
  /*function submit_assignments_answers(){
    $status=false;
    $message="Something went wrong";
    $line_no=$this->input->post('line_no');
    $shift_no=$this->input->post('shift_no');
    $assign_id=$this->input->post('assign_id');
    $question_id=$this->input->post('question_id');
    $answer_id=$this->input->post('answer_id');
    $comments=$this->input->post('comments');
    $user_id=$this->input->post('user_id');
    $outlet_id=$this->input->post('outlet_id');
    $answer_type=$this->input->post('answer_type');
    $range=$this->input->post('range');
    $answer_media=$this->input->post('answer_media');
   
    $open_close=$this->outlet_open_close($outlet_id);
      
        
    
             $user_key = $this->check_user_api_key();
        if($user_key['key_status'] == true) {

    if(isset($line_no) && !empty($line_no) && isset($shift_no) && !empty($shift_no) && isset($assign_id) && !empty($assign_id) && isset($question_id) && !empty($question_id) && isset($answer_id) && !empty($answer_id) && isset($outlet_id) && !empty($outlet_id) && isset($user_id) && !empty($user_id)){
        if($open_close=="Open"){
        $where['assignment_id']=$assign_id;
        $where['question_id']=$question_id;
        $arr_assignments=$this->check_from_assignment_answers($where,$outlet_id)->result_array();
        if(empty($arr_assignments)){
              $status=true;
            $message="Answer submitted successfully";
            $data['line_no']=$line_no;
            $data['shift_no']=$shift_no;
            $data['answer_type']=$answer_type;
            if($answer_type=="Range"){
                $data['range']=$range;
            }else
            $data['range']='0.0';
            
            $data['assignment_id']=$assign_id;
            $data['question_id']=$question_id;
            $data['answer_id']=$answer_id;
            $data['comments']=$comments;
            $data['user_id']=$user_id;
           $insert_id= $this->insert_assign_answers($outlet_id,$data);
             if(isset($_FILES['answer_media']) && !empty($_FILES['answer_media']) && $_FILES['answer_media']['size'] >0){
                
            $this->upload_answer_media_files($insert_id,$outlet_id);
           
            }
            $where_assign['assign_id']=$assign_id;
            $update_data['assign_status']="Review";
             $this->update_assignment_status($where_assign,$update_data,$outlet_id);
        }else{
            $message="this question has been answerd already!";
        }
       
    }
    else
        $message="Business Has been Closed";
    }

    
     }else
        $message=$api_key['key_message'];
     header('Content-Type: application/json');
        
        echo json_encode(array("status"=>$status,"message"=>$message));
  }
   function upload_answer_media_files($nid,$outlet_id){
            $upload_image_file = $_FILES['answer_media']['name'];
            $upload_image_file = str_replace(' ', '_', $upload_image_file);
            $file_name = 'assignment-'.$outlet_id.$nId . '-' . $upload_image_file;
            $file_name = strtolower(str_replace(['  ', '/','-','--','---','----', '_', '__'], '-',$file_name));
            $config['upload_path'] = ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
            $config['max_size'] = '20000';
            $config['max_width'] = '2000000000';
            $config['max_height'] = '2000000000';
            $config['file_name'] = $file_name;
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (isset($_FILES['answer_media'])) {
                $this->upload->do_upload('answer_media');
            }
            $upload_data = $this->upload->data();
            /////////////// Large Image ////////////////
            $config['source_image'] = $upload_data['full_path'];
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = true;
            $config['width'] = 500;
            $config['height'] = 400;
            $config['new_image'] = LARGE_ASSIGNMENT_ANSWER_IMAGE_PATH;
            $this->load->library('image_lib');
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();
            /////////////  Medium Size /////////////////// 
            $config['source_image'] = $upload_data['full_path'];
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = true;
            $config['width'] = 300;
            $config['height'] = 200;
            $config['new_image'] = MEDIUM_ASSIGNMENT_ANSWER_IMAGE_PATH;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();
            ////////////////////// Small Size ////////////////
            $config['source_image'] = $upload_data['full_path'];
            $config['image_library'] = 'gd2';
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 100;
            $config['height'] = 100;
            $config['new_image'] =$small;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();
            unset($data);unset($where);
            $data = array('answer_media' => $file_name);
            $where[$image_id_fild] = $nId;
            $this->update_where_assignment_answer($where,$data,$outlet_id);
   }*/
   //////////////////////////////Qa project api's//////////////
    function send_test_cron_job($check){
        $this->load->library('email');
        $port = 465;
        $user = "verification@heyfood.pk";
        $pass = "uKbW1MVIj)Hg";
        $host = 'ssl://mail.heyfood.pk';
        $config = Array(
          'protocol' => 'smtp',
          'smtp_host' => $host,
          'smtp_port' => $port,
          'smtp_user' =>  $user,
          'smtp_pass' =>  $pass,
          'mailtype'  => 'html', 
          'starttls'  => true,
          'newline'   => "\r\n"
        );   

        $this->email->initialize($config);
        $this->email->from($user, 'QA242');
       
        $this->email->to('umar7400@gmail.com');
        $this->email->subject('QA242' . '-'.$check);
        $this->email->message('<p>Dear  Cron job,<br><br> Your reset password verification code is <b> 133</b>. Please use with in 5 minutes to verifiy your account. </br>With Best Regards,<br>' . 'QA242' . 'Team');
        echo ($this->email->send());
    }
           
    function create_schedule_aqchecks_list_thirty() {
       
        date_default_timezone_set("Asia/karachi");
    	$timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
        $where['product_checks.outlet_id']=DEFAULT_OUTLET;
        $where['product_checks.status']=1;
        $open_close=$this->outlet_open_close(DEFAULT_OUTLET);
        $counter = 1;
  
        if($open_close=="Open"){
            /*$this->send_test_cron_job();*/
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status >=']='1';
            $where['product_checks.is_dates']='1';
            $where['product_checks.checktype !=']='wip_profile';
            $where['product_checks.checktype !=']='bowl_filling';
             $where['product_checks.checktype !=']='herb_spice';
             $where['product_checks.checktype !=']='scheduled_checks';
            $where_frequency[]='30 Mins';
            $where_frequency[]='Shift';
            $check_lists=$this->get_all_check_list_from_db_without_join($where,$outlet_id=DEFAULT_OUTLET,$where_frequency)->result_array();
      
            if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value) {
                       print_r($value);echo "<br><br><br>";
                                    
                    $assign_data = $where_assig = array();
                    if($value['frequency']=="30 Mins") {
                        $assign_data =array();
                        $where_assign = array();
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                            	$futher_process= true;
                                if(isset($value['check_cat_id']) && !empty($value['check_cat_id'])) {
                                    $cat_name = Modules::run('api/_get_specific_table_with_pagination_and_where',array("id"=>$value['check_cat_id']), 'id desc','catagories','cat_name','1','1','','','')->result_array();
                                    if(isset($cat_name[0]['cat_name']) && !empty($cat_name[0]['cat_name'])) {
                                        if(strtolower($cat_name[0]['cat_name']) == 'gluten free' || strtolower($cat_name[0]['cat_name']) == 'seafood')
                                            $futher_process = false;
                                    }
                                }
                                if($futher_process == true) {
                                	$outlet_id=$value['outlet_id'];
                                	$assign_data['checkid']=$value['id'];
                                	$assign_data['inspection_team']=$value['inspection_team'];
                                	$assign_data['review_team']=$value['review_team'];
                                	$assign_data['approval_team']=$value['approval_team'];
                                	$assign_data['outlet_id']=$value['outlet_id'];
                                	$assign_data['start_datetime']=date('Y-m-d H:i:s');
                                	$assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                	$assign_data['assign_status']='Open';
                                	/////////////check for already exists
                                	$where_assign['checkid']=$value['id'];
                                	//$where_assign['inspection_team']=$value['inspection_team'];
                                	$where_assign['review_team']=$value['review_team'];
                                	$where_assign['approval_team']=$value['approval_team'];
                                	$where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                	$where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                	$check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                	$inspection_team_array=array();
                                	$inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                
                                	if(empty($check_if) && !empty($inspection_team_array)){
                                    	$assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                    	
                                     	/////////// notification code umar start///////////
                                    	if(!empty($assign_id) && !empty($outlet_id)) {
                                        	$assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                        	$fcm_token = array();
                                            foreach ($inspection_team_array as $key => $insp_team):
                                                
                                                Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                            	$tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                            	if(!empty($tokens)) {
                                                	foreach ($tokens as $key => $to):
                                                    	if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                        	$fcm_token[] = $to['fcm_token'];
                                                    	if(isset($to['id']) && !empty($to['id'])) {
                                                        	Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                    	}
                                                	endforeach;
                                            	}
                                            endforeach;
                                        	if(!empty($fcm_token) && $counter== 1) {
                                            	$fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                            	Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                            	$counter = $counter + 1;
                                        	}
                                    	}
                                    	/////////// notification code umar end///////////
                                	}
                                }
                            }
                            else {
                                
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                                if(!empty($product_schedules)) {
                                    foreach ($product_schedules as $key => $ps):
                                        $product_attribute = array();
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("product_id"=>$ps['ps_product'],"outlet_id"=>DEFAULT_OUTLET),'id desc','id',DEFAULT_OUTLET.'_product_attributes','attribute_name,min_value,target_value,max_value','1','0','','','')->result_array();
                                        $valid = false;
                                        if(isset($ps['unit_weight']) && !empty($ps['unit_weight']))
                                            $valid = true;
                                        elseif(isset($ps['shape']) && !empty($ps['shape']))
                                            $valid = true;
                                        elseif(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        if($valid == true) {
                                            $assign_data['line_timing'] = $ps['ps_line'];
                                            $assign_data['product_id'] = $ps['ps_product'];
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                            //$assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                            $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                            $assign_data['assign_status']='Closed';
                                            $where_assign['checkid']=$value['id'];
                                        	$where_assign['product_id'] = $ps['ps_product'];
                                            //$where_assign['inspection_team']=$value['inspection_team'];
                                            $where_assign['review_team']=$value['review_team'];
                                            $where_assign['approval_team']=$value['approval_team'];
                                            $where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                            $where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                          	$inspection_team_array=array();
                                	        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                        
                                	        if(empty($check_if) && !empty($inspection_team_array)){
                                            $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                             /////////////check for already exists
                               
                                            if(isset($ps['shape']) && !empty($ps['shape'])) {
                                                $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Dropdown',"question"=>'Shape',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['shape'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                            }
                                            if(isset($ps['unit_weight']) && !empty($ps['unit_weight'])) {
                                                $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Fixed',"question"=>'Unit weight',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['unit_weight'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                            }
                                            if(isset($product_attribute) && !empty($product_attribute)) {
                                                foreach ($product_attribute as $key => $pa):
                                                    $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>'Range',"question"=>$pa['attribute_name'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                    Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>'',"min"=>$pa['min_value'],"max"=>$pa['max_value'],'checkid'=>$value['id'],'is_acceptable'=>'0'),$outlet_id.'_checks_answers');
                                                endforeach;
                                            }
                                            }       
                                            /////////// notification code umar start///////////
                                            /*if(!empty($assign_id) && !empty($outlet_id)) {
                                                $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                $fcm_data = $fcm_token = array();
                                                  foreach ($inspection_team_array as $key => $insp_team):
                                                        Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                               
                                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                        
                                                        if(!empty($tokens)) {
                                                            foreach ($tokens as $key => $to):
                                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                    $fcm_token[] = $to['fcm_token'];
                                                                if(isset($to['id']) && !empty($to['id'])) {
                                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                }
                                                            endforeach;
                                                        }
                                                    endforeach;
                                                if(!empty($fcm_token) && $counter== 1) {
                                                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                    $counter = $counter + 1;
                                                }
                                            }*/
                                            /////////// notification code umar end///////////
                                        }
                                    endforeach;
                                }
                            }
                        }
                    }
                    elseif(strtolower($value['frequency']) == "shift") {
                        $futher_process= true;
                        if(isset($value['check_cat_id']) && !empty($value['check_cat_id'])) {
                            $cat_name = Modules::run('api/_get_specific_table_with_pagination_and_where',array("id"=>$value['check_cat_id']), 'id desc','catagories','cat_name','1','1','','','')->result_array();
                            if(isset($cat_name[0]['cat_name']) && !empty($cat_name[0]['cat_name'])) {
                                if(strtolower($cat_name[0]['cat_name']) == 'gluten free' || strtolower($cat_name[0]['cat_name']) == 'seafood')
                                    $futher_process = false;
                            }
                        }
                        if($futher_process == true) {
                            $assign_data =array();
                            $where_assign = array();

                            if(isset($value['checktype']) && !empty($value['checktype'])) {
                                if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                    $shift_timing = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id']), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();


                                if(!empty($shift_timing)) {
                                        $all_shifts = Modules::run('api/_get_specific_table_with_pagination',array("shift_status" =>'1'), 'shift_id asc',DEFAULT_OUTLET.'_shifts','shift_id','1','0')->result_array();
                                        if(!empty($all_shifts)){
                                            foreach ($all_shifts as $key => $as):
                                                $current_shift_timig = Modules::run('api/_get_specific_table_with_pagination',array("st_day" =>date("l"),'st_shift'=>$as['shift_id'],'st_status'=>'1'), 'st_id asc',DEFAULT_OUTLET.'_shift_timing','st_start,st_end','1','0')->result_array();
                                        if(!empty($current_shift_timig)){
                                                    $check = false;
                                                    $start_time = date('H:i:s');
                                                    $end_time = date('H:i:s',strtotime('+30 minutes',strtotime(date('H:i:s'))));
                                                    $start_time = date('H:i:s',strtotime('-1 minutes',strtotime($start_time)));
                                                    foreach ($shift_timing as $key => $st):
                                                        $check = false;

                                                        if($st['fc_frequency'] == 'Start') {

                                                            if($current_shift_timig[0]['st_start'] <= $start_time && $current_shift_timig[0]['st_start'] <= $end_time) {
                                                                $check = TRUE;
                                                            }
                                                        }
                                                        elseif($st['fc_frequency'] == 'End') {

                                                            if($current_shift_timig[0]['st_end'] <= $start_time && $current_shift_timig[0]['st_end'] <= $end_time) {
                                                                $check = TRUE;
                                                            }
                                                        }
                                                        elseif($st['fc_frequency'] == 'Middle') {
                                                            $matching_time= "";

                                                            if($current_shift_timig[0]['st_end'] > $current_shift_timig[0]['st_start']) {
                                                                $timeDiff=$current_shift_timig[0]['st_end']-$current_shift_timig[0]['st_start'];
                                                                $timeDiff = round(round($timeDiff)/2);
                                                                $matching_time = date('H:i:s',strtotime('+'.$timeDiff.' hour',strtotime($current_shift_timig[0]['st_start'])));
                                                                if($matching_time >= $start_time && $matching_time <= $end_time)
                                                                    $check = TRUE;
                                                            }                                            
                                                        }
                                                        else
                                                            $check = false;
                                             			
                                                        if($check == true) {
                                                            $outlet_id=$value['outlet_id'];
                                                            $assign_data['checkid']=$value['id'];
                                                           // $assign_data['inspection_team']=$value['inspection_team'];
                                                            $assign_data['review_team']=$value['review_team'];
                                                            $assign_data['approval_team']=$value['approval_team'];
                                                            $assign_data['outlet_id']=$value['outlet_id'];
                                                            $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                                            $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                                            $assign_data['assign_status']='Open';
                                                            /////////////check for already exists
                                                            $where_assign['checkid']=$value['id'];
                                                           // $where_assign['inspection_team']=$value['inspection_team'];
                                                            $where_assign['review_team']=$value['review_team'];
                                                            $where_assign['approval_team']=$value['approval_team'];
                                                            $where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                                            $where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                                            $inspection_team_array=array();
                                	                        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                                        
                                	                        if(empty($check_if) && !empty($inspection_team_array)){
                                                                 $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                                                 /////////// notification code umar start///////////
                                                                if(!empty($assign_id) && !empty($outlet_id)) {
                                                                    $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                                    $fcm_token = array();
                                                                     foreach ($inspection_team_array as $key => $insp_team):
                                                                         Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                               
                                                                            $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                                            if(!empty($tokens)) {
                                                                                foreach ($tokens as $key => $to):
                                                                                    if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                                        $fcm_token[] = $to['fcm_token'];
                                                                                    if(isset($to['id']) && !empty($to['id'])) {
                                                                                        Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                                    }
                                                                                endforeach;
                                                                            }
                                                                         endforeach;
                                                                    if(!empty($fcm_token) && $counter== 1) {
                                                                        $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                                        Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                                        $counter = $counter + 1;
                                                                    }
                                                                }
                                                                /////////// notification code umar end///////////
                                                            }
                                                        }
                                                    endforeach;
                                                }
                                            endforeach;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                        echo "";                
                }
            }
        }
    }
    function create_schedule_aqchecks_list_hourly(){
        // $this->send_test_cron_job('hourly assignment');
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
        $where['product_checks.outlet_id']=DEFAULT_OUTLET;
        $where['product_checks.status']=1;
         $where_frequency=array();
        $open_close=$this->outlet_open_close(DEFAULT_OUTLET);
        if($open_close=="Open"){
            //$this->send_test_cron_job();
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status >=']='1';
            $where['product_checks.frequency']='hourly';
            $where['product_checks.checktype !=']='wip_profile';
            $where['product_checks.checktype !=']='bowl_filling';
            $where['product_checks.checktype !=']='herb_spice';
            $where['product_checks.checktype !=']='scheduled_checks';
            $check_lists=$this->get_all_check_list_from_db_without_join($where,$outlet_id=DEFAULT_OUTLET,$where_frequency)->result_array();
        
            $counter = 1;
            if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value):
                    $assign_data = $where_assig = array();
                    if(strtolower($value['frequency']) == strtolower("hourly")) {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                            	$futher_process= true;
                                if(isset($value['check_cat_id']) && !empty($value['check_cat_id'])) {
                                    $cat_name = Modules::run('api/_get_specific_table_with_pagination_and_where',array("id"=>$value['check_cat_id']), 'id desc','catagories','cat_name','1','1','','','')->result_array();
                                    if(isset($cat_name[0]['cat_name']) && !empty($cat_name[0]['cat_name'])) {
                                        if(strtolower($cat_name[0]['cat_name']) == 'gluten free' || strtolower($cat_name[0]['cat_name']) == 'seafood')
                                            $futher_process = false;
                                    }
                                }
                                if($futher_process == true) {
                                	$outlet_id=$value['outlet_id'];
                                	$assign_id='';
                                	$check_if='';
                                	$assign_data['checkid']=$value['id'];
                                	//$assign_data['inspection_team']=$value['inspection_team'];
                                	$assign_data['review_team']=$value['review_team'];
                                	$assign_data['approval_team']=$value['approval_team'];
                                	$assign_data['outlet_id']=$value['outlet_id'];
                                	$assign_data['start_datetime']=date('Y-m-d H:i:s');
                                	$assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                	$assign_data['assign_status']='Open';
                                	/////////////check for already exists
                                	$where_assign['checkid']=$value['id'];
                                //	$where_assign['inspection_team']=$value['inspection_team'];
                                	$where_assign['review_team']=$value['review_team'];
                                	$where_assign['approval_team']=$value['approval_team'];
                                	$where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                	$where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                	$check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                    $inspection_team_array=array();
        	                        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                
        	                        if(empty($check_if) && !empty($inspection_team_array)){
                                                      
                        	           
                                    	$assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                    	/////////// notification code umar start///////////
                                    	if(!empty($assign_id) && !empty($outlet_id)) {
                                        	$assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                        	$fcm_token = array();
                                         foreach ($inspection_team_array as $key => $insp_team):
                                             Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                   
                                                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                if(!empty($tokens)) {
                                                    foreach ($tokens as $key => $to):
                                                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                            $fcm_token[] = $to['fcm_token'];
                                                        if(isset($to['id']) && !empty($to['id'])) {
                                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                        }
                                                    endforeach;
                                                }
                                             endforeach;
                                        	if(!empty($fcm_token)  && $counter== 1) {
                                            	$fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                            	Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                        	}
                                    	}
                                    	/////////// notification code umar end///////////
                                	}
                                }
                            }
                            else {
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                                if(!empty($product_schedules)) {
                                    foreach ($product_schedules as $key => $ps):
                                        $product_attribute = array();
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("product_id"=>$ps['ps_product'],"outlet_id"=>DEFAULT_OUTLET),'id desc','id',DEFAULT_OUTLET.'_product_attributes','attribute_name,min_value,target_value,max_value','1','0','','','')->result_array();
                                        $valid = false;
                                        if(isset($ps['unit_weight']) && !empty($ps['unit_weight']))
                                            $valid = true;
                                        elseif(isset($ps['shape']) && !empty($ps['shape']))
                                            $valid = true;
                                        elseif(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        if($valid == true) {
                                            $assign_data['line_timing'] = $ps['ps_line'];
                                            $assign_data['product_id'] = $ps['ps_product'];
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                           // $assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                            $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                            $assign_data['assign_status']='Closed';
                                        	$where_assign['product_id'] = $ps['ps_product'];
                                           // $where_assign['inspection_team']=$value['inspection_team'];
                                            $where_assign['review_team']=$value['review_team'];
                                            $where_assign['approval_team']=$value['approval_team'];
                                            $where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                            $where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                            $inspection_team_array=array();
        	                                $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                
        	                            if(empty($check_if) && !empty($inspection_team_array)){
                                            $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                            if(isset($ps['shape']) && !empty($ps['shape'])) {
                                                $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Dropdown',"question"=>'Shape',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['shape'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                            }
                                            if(isset($ps['unit_weight']) && !empty($ps['unit_weight'])) {
                                                $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Fixed',"question"=>'Unit weight',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['unit_weight'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                            }
                                            if(isset($product_attribute) && !empty($product_attribute)) {
                                                foreach ($product_attribute as $key => $pa):
                                                    $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>'Range',"question"=>$pa['attribute_name'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                    Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>'',"min"=>$pa['min_value'],"max"=>$pa['max_value'],'checkid'=>$value['id'],'is_acceptable'=>'0'),$outlet_id.'_checks_answers');
                                                endforeach;
                                            }
                                        }
                                            /////////// notification code umar start///////////
                                            /*if(!empty($assign_id) && !empty($outlet_id)) {
                                                $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                $fcm_data = $fcm_token = array();
                                                foreach ($inspection_team_array as $key => $insp_team):
                                                Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                   
                                                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                if(!empty($tokens)) {
                                                    foreach ($tokens as $key => $to):
                                                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                            $fcm_token[] = $to['fcm_token'];
                                                        if(isset($to['id']) && !empty($to['id'])) {
                                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                        }
                                                    endforeach;
                                                }
                                                endforeach;
                                                if(!empty($fcm_token) && $counter== 1) {
                                                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                    $counter = $counter + 1;
                                                }
                                            }*/
                                            /////////// notification code umar end///////////
                                        }
                                    endforeach;
                                }
                            }
                        }
                    }
                endforeach;
            }
        	$this->create_seafood_checks(date('Y-m-d'),date('Y-m-d'),date('Y-m-d'),date('H:i:s'),date('Y-m-d'),date('H:i:s',strtotime('+1 hour',strtotime(date('H:i:s')))),date('l'),DEFAULT_OUTLET);
        }
    }
    function create_schedule_aqchecks_list_Daily() {
        //$this->send_test_cron_job('hourly assignment');
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
        $where['product_checks.outlet_id']=DEFAULT_OUTLET;
        $where['product_checks.status']=1;
        $where_frequency[]='Daily';
        $where_frequency[]='Weekly';
        $where_frequency[]='Monthly';
        $open_close=$this->outlet_open_close(DEFAULT_OUTLET);
        if($open_close=="Open"){
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status']='1';
            $where['product_checks.checktype !=']='wip_profile';
            $where['product_checks.checktype !=']='bowl_filling';
            $where['product_checks.checktype !=']='herb_spice';
            $where['product_checks.checktype !=']='scheduled_checks';
            $check_lists=$this->get_all_check_list_from_db_without_join($where,$outlet_id=DEFAULT_OUTLET,$where_frequency)->result_array();
        print_r($check_lists);echo "<br><br>start check list<br><br><br>";
            $counter = 1;
            if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value):
            	echo "<br><br>";print_r($value);echo "full array<br><br>";
                    $assign_data = $where_assig = array();
                    if(strtolower($value['frequency']) == strtolower("Daily")){
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $futher_process= true;
                                if(isset($value['check_cat_id']) && !empty($value['check_cat_id'])) {
                                    $cat_name = Modules::run('api/_get_specific_table_with_pagination_and_where',array("id"=>$value['check_cat_id']), 'id desc','catagories','cat_name','1','1','','','')->result_array();
                                    if(isset($cat_name[0]['cat_name']) && !empty($cat_name[0]['cat_name'])) {
                                        if(strtolower($cat_name[0]['cat_name']) == 'gluten free' || strtolower($cat_name[0]['cat_name']) == 'seafood')
                                            $futher_process = false;
                                    }
                                }
                                
                                if($futher_process == true) {
                                    $outlet_id=$value['outlet_id'];
                                    $assign_data['checkid']=$value['id'];
                                   // $assign_data['inspection_team']=$value['inspection_team'];
                                    $assign_data['review_team']=$value['review_team'];
                                    $assign_data['approval_team']=$value['approval_team'];
                                    $assign_data['outlet_id']=$value['outlet_id'];
                                    $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                    $assign_data['end_datetime']=date('Y-m-d 23:59:00');
                                    $assign_data['assign_status']='Open';
                                    /////////////check for already exists
                                    $where_assign['checkid']=$value['id'];
                                  //  $where_assign['inspection_team']=$value['inspection_team'];
                                    $where_assign['review_team']=$value['review_team'];
                                    $where_assign['approval_team']=$value['approval_team'];
                                    $where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                    $where_assign['end_datetime >=']= date('Y-m-d 23:59:00');

                                    $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                     $inspection_team_array=array();
                                	 $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                                        
                                    if(empty($check_if) && !empty($inspection_team_array)){

                                    $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                    /////////// notification code umar start///////////
                                    if(!empty($assign_id) && !empty($outlet_id)) {
                                        $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                        $fcm_token = array();
                                        foreach ($inspection_team_array as $key => $insp_team):
                                             Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                               
                                                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                if(!empty($tokens)) {
                                                    
                                                    foreach ($tokens as $key => $to):
                                                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                            $fcm_token[] = $to['fcm_token'];
                                                        if(isset($to['id']) && !empty($to['id'])) {
                                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                        }
                                                    endforeach;
                                                }
                                         endforeach;
                                        if(!empty($fcm_token)  && $counter== 1) {
                                            $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                            Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                        }
                                    }
                                    /////////// notification code umar end///////////
                                }
                                }
                            }
                            else {
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                                echo "<br>all products<br><br>";
                                print_r($product_schedules);
                                echo "<br>";
                                
                                if(!empty($product_schedules)) {
                                    foreach ($product_schedules as $key => $ps):
                                        $product_attribute = array();
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("product_id"=>$ps['ps_product'],"outlet_id"=>DEFAULT_OUTLET),'id desc','id',DEFAULT_OUTLET.'_product_attributes','attribute_name,min_value,target_value,max_value','1','0','','','')->result_array();
                                        $valid = false;
                                        if(isset($ps['unit_weight']) && !empty($ps['unit_weight']))
                                            $valid = true;
                                        elseif(isset($ps['shape']) && !empty($ps['shape']))
                                            $valid = true;
                                        elseif(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        echo "check id  ".$value['id']."   product id  ".$ps['ps_product']."<br><br>";
                                        echo "<br> is valid  ".$valid."<br>";
                                        if($valid == true) {
                                            $assign_data['line_timing'] = $ps['ps_line'];
                                            $assign_data['product_id'] = $ps['ps_product'];
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                            //$assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                            $assign_data['end_datetime']=date('Y-m-d 23:59:00');
                                            $assign_data['assign_status']='Closed';
                                            /////////////check for already exists
                                            $where_assign['checkid']=$value['id'];
                                        	$where_assign['product_id'] = $ps['ps_product'];
                                            //$where_assign['inspection_team']=$value['inspection_team'];
                                            $where_assign['review_team']=$value['review_team'];
                                            $where_assign['approval_team']=$value['approval_team'];
                                            $where_assign['start_datetime <=']=date('Y-m-d H:i:s');
                                            $where_assign['end_datetime >=']= date('Y-m-d 23:59:00');
                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                             $inspection_team_array=array();
                                	         $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                    
                                            echo "<br><br>is check created or not <br>";
                                            print_r($check_if);
                                            echo "<br><br>";
                                            if(empty($check_if)  && !empty($inspection_team_array)){
                                            	$assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                            echo "assign_id ".$assign_id."========<br><br>";
                                                if(isset($ps['shape']) && !empty($ps['shape'])) {
                                                    $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Dropdown',"question"=>'Shape',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                    Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['shape'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                                }
                                                if(isset($ps['unit_weight']) && !empty($ps['unit_weight'])) {
                                                    $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Fixed',"question"=>'Unit weight',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                    Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['unit_weight'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                                }
                                                if(isset($product_attribute) && !empty($product_attribute)) {
                                                    foreach ($product_attribute as $key => $pa):
                                                        $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>'Range',"question"=>$pa['attribute_name'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                        Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>'',"min"=>$pa['min_value'],"max"=>$pa['max_value'],'checkid'=>$value['id'],'is_acceptable'=>'0'),$outlet_id.'_checks_answers');
                                                    endforeach;
                                                }
                                            }
                                            /////////// notification code umar start///////////
                                           /* if(!empty($assign_id) && !empty($outlet_id)) {
                                                $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                $fcm_data = $fcm_token = array();
                                                foreach ($inspection_team_array as $key => $insp_team):
                                                     Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                       
                                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                        if(!empty($tokens)) {
                                                            
                                                            foreach ($tokens as $key => $to):
                                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                    $fcm_token[] = $to['fcm_token'];
                                                                if(isset($to['id']) && !empty($to['id'])) {
                                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                }
                                                            endforeach;
                                                        }
                                                endforeach;
                                                if(!empty($fcm_token) && $counter== 1) {
                                                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                    $counter = $counter + 1;
                                                }
                                            }*/
                                            /////////// notification code umar end///////////
                                        }
                                    endforeach;
                                }
                            }
                        }
                    }
                    elseif(strtolower($value['frequency']) == strtolower("Weekly")) {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $futher_process= true;
                                if(isset($value['check_cat_id']) && !empty($value['check_cat_id'])) {
                                    $cat_name = Modules::run('api/_get_specific_table_with_pagination_and_where',array("id"=>$value['check_cat_id']), 'id desc','catagories','cat_name','1','1','','','')->result_array();
                                    if(isset($cat_name[0]['cat_name']) && !empty($cat_name[0]['cat_name'])) {
                                        if(strtolower($cat_name[0]['cat_name']) == 'gluten free' || strtolower($cat_name[0]['cat_name']) == 'seafood')
                                            $futher_process = false;
                                    }
                                }
                                $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("l")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($today_valid) && $futher_process == true) {
                                    $outlet_id=$value['outlet_id'];
                                    $assign_data['checkid']=$value['id'];
                                    //$assign_data['inspection_team']=$value['inspection_team'];
                                    $assign_data['review_team']=$value['review_team'];
                                    $assign_data['approval_team']=$value['approval_team'];
                                    $assign_data['outlet_id']=$value['outlet_id'];
                                    $assign_data['start_datetime']=date('Y-m-d').' 00:00:00';
                                    $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d').' 23:59:59';
                                    $assign_data['assign_status']='Open';
                                   /////////////check for already exists
                                     $where_assign['checkid']=$value['id'];
                                    //$where_assign['inspection_team']=$value['inspection_team'];
                                    $where_assign['review_team']=$value['review_team'];
                                    $where_assign['approval_team']=$value['approval_team'];
                                    $where_assign['start_datetime <=']=date('Y-m-d h:i:s');
                                    $where_assign['end_datetime >=']= date('Y-m-d').' 23:59:59';
                                    $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                    $inspection_team_array=array();
                                	$inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                    
                                    if(empty($check_if) && !empty($inspection_team_array)){
                                        $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                        /////////// notification code umar start///////////
                                        if(!empty($assign_id) && !empty($outlet_id)) {
                                            $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                            $fcm_token = array();
                                            foreach ($inspection_team_array as $key => $insp_team):
                                                     Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                       
                                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                        if(!empty($tokens)) {
                                                            
                                                            foreach ($tokens as $key => $to):
                                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                    $fcm_token[] = $to['fcm_token'];
                                                                if(isset($to['id']) && !empty($to['id'])) {
                                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                }
                                                            endforeach;
                                                        }
                                            endforeach;
                                            if(!empty($fcm_token)  && $counter== 1) {
                                                $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                            }
                                        }
                                        /////////// notification code umar end///////////
                                    }
                                }
                            }
                        }
                    }
                    elseif(strtolower($value['frequency']) == strtolower("Monthly")) {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $futher_process= true;
                                if(isset($value['check_cat_id']) && !empty($value['check_cat_id'])) {
                                    $cat_name = Modules::run('api/_get_specific_table_with_pagination_and_where',array("id"=>$value['check_cat_id']), 'id desc','catagories','cat_name','1','1','','','')->result_array();
                                    if(isset($cat_name[0]['cat_name']) && !empty($cat_name[0]['cat_name'])) {
                                        if(strtolower($cat_name[0]['cat_name']) == 'gluten free' || strtolower($cat_name[0]['cat_name']) == 'seafood')
                                            $futher_process = false;
                                    }
                                }
                                $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("j")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($today_valid)  && $futher_process == true) {
                                    $outlet_id=$value['outlet_id'];
                                    $assign_data['checkid']=$value['id'];
                                   // $assign_data['inspection_team']=$value['inspection_team'];
                                    $assign_data['review_team']=$value['review_team'];
                                    $assign_data['approval_team']=$value['approval_team'];
                                    $assign_data['outlet_id']=$value['outlet_id'];
                                    $assign_data['start_datetime']=date('Y-m-d').' 00:00:00';
                                    $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d').' 23:59:59';
                                    $assign_data['assign_status']='Open';
                                   /////////////check for already exists
                                     $where_assign['checkid']=$value['id'];
                                   // $where_assign['inspection_team']=$value['inspection_team'];
                                    $where_assign['review_team']=$value['review_team'];
                                    $where_assign['approval_team']=$value['approval_team'];
                                    $where_assign['start_datetime <=']=date('Y-m-d h:i:s');
                                    $where_assign['end_datetime >=']= date('Y-m-d').' 23:59:59';
                                    $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                    $inspection_team_array=array();
                                	$inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                    
                                    if(empty($check_if)){
                                        $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                        /////////// notification code umar start///////////
                                        if(!empty($assign_id) && !empty($outlet_id)) {
                                            $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                            $fcm_token = array();
                                           foreach ($inspection_team_array as $key => $insp_team):
                                                     Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                       
                                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                        if(!empty($tokens)) {
                                                            
                                                            foreach ($tokens as $key => $to):
                                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                    $fcm_token[] = $to['fcm_token'];
                                                                if(isset($to['id']) && !empty($to['id'])) {
                                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                }
                                                            endforeach;
                                                        }
                                            endforeach;
                                            if(!empty($fcm_token)  && $counter== 1) {
                                                $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                            }
                                        }
                                        /////////// notification code umar end///////////
                                    }
                                }
                            }
                        }
                    }
                    else
                        echo "";
                endforeach;
            }
            $this->create_seafood_checks(date('Y-m-d'),date('Y-m-d'),date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')),"00:00:00",date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')),"23:59:59",date('l', strtotime(date('l') . ' +1 day')),DEFAULT_OUTLET);
        }
    }
  	function create_seafood_checks($checking_start_date,$checking_end_date,$day_start_date,$day_start_time,$day_end_date,$day_end_time,$day_name,$outlet_id) {
        $seafood_products = $this->get_schedules_product(array("ps_date <="=>$checking_start_date,"ps_end_date >="=>$checking_end_date,"product_type"=>"Seafood"),$outlet_id.'_product.id',$outlet_id.'_product.id',$outlet_id,$outlet_id.'_product.id as ps_product,ps_line','1','0','','','')->result_array();
        if(!empty($seafood_products)) {
            $cat = "";
            $categories = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("LOWER(cat_name)"=>'seafood'),'id desc','id','catagories','id','1','0','','','')->result_array();
            if(!empty($categories)) {
                foreach ($categories as $key => $ctg):
                    if(!empty($ctg['id'])) {
                        if(!empty($cat))
                            $cat = $cat.' or ';
                        $cat = $cat.'`check_cat_id`='.$ctg['id'];
                    }
                endforeach;
                $cat = '('.$cat.')';
                foreach ($seafood_products as $key => $sp):
                    $seafood_checks = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("start_datetime <="=>$checking_start_date,'end_datetime >='=>$checking_end_date),'id desc','id',$outlet_id.'_product_checks','id,frequency,inspection_team,review_team,approval_team','1','0',$cat,'','')->result_array();
                    if(!empty($seafood_checks)) {
                        foreach ($seafood_checks as $key => $sc):
                            print_r($sc);echo "<br><br>";
                            $sp['id'] = $sc['id'];
                            $sp['outlet_id'] = $outlet_id;
                            $sp['assignment_type'] = 'seafood';
                            $sp['inspection_team'] = $sc['inspection_team'];
                            $sp['review_team'] = $sc['review_team'];
                            $sp['approval_team'] = $sc['approval_team'];
                            if(isset($sc['frequency']) && !empty($sc['frequency'])) {
                                if(strtolower($sc['frequency']) == 'daily' || strtolower($sc['frequency']) == 'hourly') {
                                    if(strtolower($day_name) == 'saturday' || strtolower($day_name) == 'sunday') {
                                        $final_start_time = date('Y-m-d', strtotime('next monday')).' '.$day_start_time;
                                        $final_end_time = date('Y-m-d', strtotime('next monday')).' '.$day_end_time;
                                    }
                                    else {
                                        $final_start_time = $day_start_date.' '.$day_start_time;
                                        $final_end_time = $day_end_date.' '.$day_end_time;
                                    }
                                    print_r($sp);echo "<br><br>";
                                    echo $final_start_time."========".$final_end_time."<br><br>";
                                    $this->create_assignment($sp,$outlet_id,$final_start_time,$final_end_time);
                                }
                                else
                                    echo "";
                            }
                        endforeach;
                    }
                endforeach;
            }
        }
    }
    function create_assignment($data,$outlet_id,$start_date_time,$end_date_time) {
        $assign_data =array();
        $where_assign = array();
        $assign_data['line_timing'] = $data['ps_line'];
        $assign_data['product_id'] = $data['ps_product'];
        $assign_data['assignment_type']=$data['assignment_type'];
        $assign_data['checkid']=$data['id'];
        $assign_data['inspection_team']=$data['inspection_team'];
        $assign_data['review_team']=$data['review_team'];
        $assign_data['approval_team']=$data['approval_team'];
        $assign_data['outlet_id']=$outlet_id;
        $assign_data['start_datetime']=$start_date_time;
        $assign_data['end_datetime']=$end_date_time;
        $assign_data['assign_status']='Closed';
        $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
        /////////////check for already exists
        /*$where_assign['checkid']=$data['id'];
        $where_assign['inspection_team']=$data['inspection_team'];
        $where_assign['review_team']=$data['review_team'];
        $where_assign['approval_team']=$data['approval_team'];
        $where_assign['start_datetime <=']=$start_date_time;
        $where_assign['end_datetime >=']= $end_date_time;
        $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id)->result_array();
        if(empty($check_if)){
             
            /*if(!empty($assign_id) && !empty($outlet_id)) {
                $assign_name='Assignment Name'; if(isset($data['checkname']) && !empty($data['checkname'])) $assign_name=$data['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                $fcm_token = array();
                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$data['inspection_team'].'" or `group`="'.$data['inspection_team'].'")','','')->result_array();
                if(!empty($tokens)) {
                    foreach ($tokens as $key => $to):
                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                            $fcm_token[] = $to['fcm_token'];
                        if(isset($to['id']) && !empty($to['id'])) {
                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                        }
                    endforeach;
                }
                if(!empty($fcm_token)) {
                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                }
            }
        }*/
    }
	function get_schedules_product($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_schedules_product($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having='');
        return $query;
    }
  /*  function create_schedule_aqchecks_list_weekly(){
        date_default_timezone_set("Asia/karachi");
        $where['outlet_id']=DEFAULT_OUTLET;
        $where['status']=1;
        $open_close=$this->outlet_open_close(DEFAULT_OUTLET);
        if($open_close=="Open"){
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status >=']='1';
            $check_lists=$this->get_all_check_list_from_db($where,$outlet_id=DEFAULT_OUTLET)->result_array();
            $counter = 1;
            if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value):
                    $assign_data = $where_assig = array();
                    if(strtolower($value['frequency']) == strtolower("Weekly")){
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $outlet_id=$value['outlet_id'];
                                $assign_data['checkid']=$value['id'];
                                $assign_data['inspection_team']=$value['inspection_team'];
                                $assign_data['review_team']=$value['review_team'];
                                $assign_data['approval_team']=$value['approval_team'];
                                $assign_data['outlet_id']=$value['outlet_id'];
                                $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 Week',strtotime(date('Y-m-d H:i:s'))));
                                $assign_data['assign_status']='Open';
                               /////////////check for already exists///
                                 $where_assign['checkid']=$value['id'];
                                $where_assign['inspection_team']=$value['inspection_team'];
                                $where_assign['review_team']=$value['review_team'];
                                $where_assign['approval_team']=$value['approval_team'];
                                $where_assign['start_datetime  <=']=date('Y-m-d H:i:s');
                                $where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+1 Week',strtotime(date('Y-m-d H:i:s'))));
                                $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                if(empty($check_if)){
                                    $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                    /////////// notification code umar start///////////
                                    if(!empty($assign_id) && !empty($outlet_id)) {
                                        $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                        $fcm_token = array();
                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$value['inspection_team'].'" or `group`="'.$value['inspection_team'].'")','','')->result_array();
                                        if(!empty($tokens)) {
                                            foreach ($tokens as $key => $to):
                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                    $fcm_token[] = $to['fcm_token'];
                                                if(isset($to['id']) && !empty($to['id'])) {
                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                }
                                            endforeach;
                                        }
                                        if(!empty($fcm_token)  && $counter== 1) {
                                            $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                            Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                        }
                                    }
                                    /////////// notification code umar end///////////
                                }
                            }
                            else {
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                                if(!empty($product_schedules)) {
                                    foreach ($product_schedules as $key => $ps):
                                        $product_attribute = array();
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("product_id"=>$ps['ps_product'],"outlet_id"=>DEFAULT_OUTLET),'id desc','id',DEFAULT_OUTLET.'_product_attributes','attribute_name,min_value,target_value,max_value','1','0','','','')->result_array();
                                        $valid = false;
                                        if(isset($ps['unit_weight']) && !empty($ps['unit_weight']))
                                            $valid = true;
                                        elseif(isset($ps['shape']) && !empty($ps['shape']))
                                            $valid = true;
                                        elseif(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        if($valid == true) {
                                            $assign_data['line_timing'] = $ps['ps_line'];
                                            $assign_data['product_id'] = $ps['ps_product'];
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                            $assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                            $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+1 Week',strtotime(date('Y-m-d H:i:s'))));
                                            $assign_data['assign_status']='Open';
                                            $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                            if(isset($ps['shape']) && !empty($ps['shape'])) {
                                                $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Dropdown',"question"=>'Shape',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['shape'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                            }
                                            if(isset($ps['unit_weight']) && !empty($ps['unit_weight'])) {
                                                $insert_id=Modules::run('api/insert_into_specific_table',array("type"=>'Fixed',"question"=>'Unit weight',"checkid"=>$value['id'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>$ps['unit_weight'],"min"=>'0',"max"=>'0','checkid'=>$value['id'],'is_acceptable'=>'1'),$outlet_id.'_checks_answers');
                                            }
                                            if(isset($product_attribute) && !empty($product_attribute)) {
                                                foreach ($product_attribute as $key => $pa):
                                                    $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>'Range',"question"=>$pa['attribute_name'],"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                    Modules::run('api/insert_into_specific_table',array("question_id"=>$insert_id,"possible_answer"=>'',"min"=>$pa['min_value'],"max"=>$pa['max_value'],'checkid'=>$value['id'],'is_acceptable'=>'0'),$outlet_id.'_checks_answers');
                                                endforeach;
                                            }
                                            /////////// notification code umar start///////////
                                            if(!empty($assign_id) && !empty($outlet_id)) {
                                                $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                $fcm_data = $fcm_token = array();
                                                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$value['inspection_team'].'" or `group`="'.$value['inspection_team'].'")','','')->result_array();
                                                if(!empty($tokens)) {
                                                    foreach ($tokens as $key => $to):
                                                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                            $fcm_token[] = $to['fcm_token'];
                                                        if(isset($to['id']) && !empty($to['id'])) {
                                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                        }
                                                    endforeach;
                                                }
                                                if(!empty($fcm_token) && $counter== 1) {
                                                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                    $counter = $counter + 1;
                                                }
                                            }
                                            /////////// notification code umar end///////////
                                        }
                                    endforeach;
                                }
                            }
                        }
                    }
                endforeach;
            }
        }
    }*/
    function check_for_updated_assignments(){
       date_default_timezone_set("Asia/karachi");
       $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
        $outlet_id=DEFAULT_OUTLET;
        $where['assignments.outlet_id']=$outlet_id;
        $where['assignments.end_datetime <=']=date('Y-m-d h:i:s');
       // $where['assignments.end_timetime <']=date('H:i');
        $where['assignments.assign_status']="Open";
        $ass_arr=$this->get_over_due_assignment($where,$outlet_id)->result_array();
        
      
        if(isset($ass_arr) && !empty($ass_arr)){
            foreach($ass_arr as $value){
                $where_assign['assign_id']=$value['assign_id'];
                $where_assign['outlet_id']=$value['outlet_id'];
                $data['assign_status']="OverDue";
                $this->update_assignment_status($where,$data,$outlet_id);
                /////////// notification code umar start///////////
                $assign_id = $value['assign_id'];
                $outlet_id = $value['outlet_id'];
                if(!empty($assign_id) && !empty($outlet_id)) {
                    $assign_name = "Assignment Name";
                    $assign_detail = Modules::run('api/_get_specific_table_with_pagination',array("assign_id"=>$assign_id),'assign_id desc',$value['outlet_id'].'_assignments','checkid','1','1')->result_array();
                    if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid'])) {
                        $product_checks_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_detail[0]['checkid']),'id desc',$value['outlet_id'].'_product_checks','checkname','1','1')->result_array();
                        if(isset($product_checks_detail[0]['checkname']) && !empty($product_checks_detail[0]['checkname']))
                            $assign_name = $product_checks_detail[0]['checkname'];
                    }
                    $review_group = Modules::run('api/_get_specific_table_with_pagination',array(),'id desc','notification_setting','group_id','1','1')->result_array();
                    $fcm_token = array();
                    $user_array = array();
                    if(isset($review_group) && !empty($review_group)) {
                        foreach ($review_group as $key => $rg):
                            $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array("fcm_token !="=>"",'status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$rg['group_id'].'" or `group`="'.$rg['group_id'].'")','','')->result_array();
                            if(!empty($tokens)) {
                                foreach ($tokens as $key => $value):
                                    $fcm_token[] = $value['fcm_token'];
                                    if(isset($value['id']) && !empty($value['id'])) {
                                        if(!in_array($value['id'], $user_array)) {
                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$value['id'],"outlet_id"=>$outlet_id,"notification_message"=>$assign_name." has been over due, please login to the system to answer the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                            $user_array[] = $value['id'];
                                        }
                                    }
                                endforeach;
                            }
                        endforeach;
                        if(!empty($fcm_token)) {
                            $user_name = "";
                            $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id" =>$user_id),'id desc','users','user_name','1','1')->result_array();
                            if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name']))
                                $user_name = $user_detail[0]['user_name'];
                            $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,$assign_name." has been over due, please login to the system to answer the data.",false,false,"");
                            Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                        }
                    }
                }
                /////////// notification code umar end///////////
           
            }
        }
    }
    function send_test_cron_job_wip(){
         $this->load->library('email');
                $port = 465;
                $user = "verification@heyfood.pk";
                $pass = "uKbW1MVIj)Hg";
                $host = 'ssl://mail.heyfood.pk';

                $config = Array(
                  'protocol' => 'smtp',
                  'smtp_host' => $host,
                  'smtp_port' => $port,
                  'smtp_user' =>  $user,
                  'smtp_pass' =>  $pass,
                  'mailtype'  => 'html', 
                  'starttls'  => true,
                  'newline'   => "\r\n"
                );   

                $this->email->initialize($config);
                $this->email->from($user, 'QA242');
                $this->email->to('asadbloch78@gmail.com');
                $this->email->subject('QA242' . ' -Assignment Wip Created successfully');
                $this->email->message('<p>Dear  QA242,<br><br> Your Assignment # 112 has been OverDue .Contact To admin For Futher Info</br>With Best Regards,<br>' . 'QA242' . 'Team');
               $this->email->send();
    }

    ///////////////////// WIP PROFILE FUNCTIONS////////////
    function schedule_for_wip_profile_assignments(){
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
        $this->create_gluten_free_checks();
        $this->schedule_for_herbspice_checks_assignments();
        $where['product_checks.outlet_id']=DEFAULT_OUTLET;
        $where['product_checks.status']=1;

        $open_close=$this->outlet_open_close(DEFAULT_OUTLET);
        $counter = 1;
        if($open_close=="Open"){
          /*  date_default_timezone_set("Asia/karachi");
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);*/
            //$this->send_test_cron_job_wip();
            
            $where_in[]='wip_profile';
            $where_in[]='bowl_filling';
          
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status >=']='1';
            //$where['product_checks.checktype']='wip_profile';
            //$where['product_checks.checktype']='bowl_filling';

            $check_lists=$this->get_all_product_check_list_from_db($where,$outlet_id=DEFAULT_OUTLET,$where_in)->result_array();
          
            if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value) {
                     if(isset($value['checktype']) && !empty($value['checktype'])) {
                        if(strtolower($value['checktype']) == strtolower('wip_profile')) {
                            if($value['frequency']=="30 Mins") {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                            
                                $this->create_wip_profile_assignments($value,$start_date_time,$end_date_time);
        
                            }elseif ($value['frequency']=="hourly") {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                
                                 $this->create_wip_profile_assignments($value,$start_date_time,$end_date_time);
                            }elseif ($value['frequency']=="Daily") {
                                $start_date_time='';
                                $end_date_time='';
                                 $start_date_time=date('Y-m-d H:i:s');
                               $end_date_time=  date('Y-m-d 23:59:00');
                                
                                 $this->create_wip_profile_assignments($value,$start_date_time,$end_date_time);
                            }elseif ($value['frequency']=="Weekly") {
                                 
                                $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("l")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($today_valid)) {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                                    
                                 
                                 $this->create_wip_profile_assignments($value,$start_date_time,$end_date_time);
                                }
                            }
                            }elseif(strtolower($value['checktype']) == strtolower('bowl_filling')){
                            if($value['frequency']=="30 Mins") {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                            
                                $this->create_wip_profile_bowlfilling_assignments($value,$start_date_time,$end_date_time);
        
                            }elseif ($value['frequency']=="hourly") {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                
                                 $this->create_wip_profile_bowlfilling_assignments($value,$start_date_time,$end_date_time);
                            }elseif ($value['frequency']=="Daily") {
                                $start_date_time='';
                                $end_date_time='';
                                 $start_date_time=date('Y-m-d H:i:s');
                               $end_date_time=  date('Y-m-d 23:59:00');
                                  $this->create_wip_profile_bowlfilling_assignments($value,$start_date_time,$end_date_time);
                            }elseif ($value['frequency']=="Weekly") {
                                 
                                $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("l")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($today_valid)) {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                                 $this->create_wip_profile_bowlfilling_assignments($value,$start_date_time,$end_date_time);
                                }
                            }
                        }
        
                    }
                }
                                
            }
        }
    }
 
    function create_wip_profile_assignments($value,$start_date_time,$end_date_time){
         $counter = 1;
                        $outlet_id=DEFAULT_OUTLET;
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array(); 
                               
                                if(!empty($product_schedules)) {
                                 
                                    foreach ($product_schedules as $key => $ps):
                                        $product_attribute = array();
                                        $product_ingredients = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('product_id'=>$ps['ps_product']),'id desc','id','wip_attributes','*','1','0','','','')->result_array();
                                        if(!empty($product_ingredients)){
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('wip_type'=>'ingredients'),'wip_id desc','wip_id','wip_profile','*','1','0','','','')->result_array();
                                            $valid = false;

                                        if(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        if($valid == true) {
                                            $assign_data['line_timing'] = $ps['ps_line'];
                                            $assign_data['product_id'] = $ps['ps_product'];
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                            //$assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=$start_date_time;
                                            $assign_data['end_datetime']=$end_date_time;
                                            $assign_data['assign_status']='Closed';
                                            /////////////check for already exists
                                            $where_assign['checkid']=$value['id'];
                                           // $where_assign['inspection_team']=$value['inspection_team'];
                                            $where_assign['review_team']=$value['review_team'];
                                            $where_assign['approval_team']=$value['approval_team'];
                                            $where_assign['start_datetime <=']=$start_date_time;
                                            $where_assign['end_datetime >=']= $end_date_time;
                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                            $inspection_team_array=array();
                                	        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                                        
                                            if(empty($check_if) && !empty($inspection_team_array)){
                                                $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                                
                                                if(isset($product_attribute) && !empty($product_attribute)) {$attribute_name='';
                                                    foreach ($product_ingredients as $key => $ingr_value) {
                                                       
                                                 
                                                    foreach ($product_attribute as $key => $pa):
                                                        
                                                        $attribute_name=$ingr_value['product_name'].' : '.$pa['attribute_name'];
                                                        $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>$pa['attribute_type'],"question"=>$attribute_name,"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                       if($pa['attribute_type']=="Choice" ){
                                                            $ans_array=explode(" ",$possible_answer);
    
                                                            if($pa['possible_answers']=="yes/no"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='yes';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='no';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }elseif($pa['possible_answers']=="acceptable/unacceptable" ||  $possible_answer[$i]=="acceptable/not acceptable"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='acceptable';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='unacceptable';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }
                                                            elseif($pa['possible_answers']=="completed/not completed"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='completed';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='not completed';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
    
    
                                             
    
    
                                                            }
                                                            elseif($pa['possible_answers']=="cleaned/uncleaned"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='cleaned';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                 $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='uncleaned';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }
                                                            elseif($pa['possible_answers']=="cleaned/completed"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='cleaned';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='completed';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }else{
    
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='yes';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
    
                                                                
                                                            }
                                                            
                                                            //$this->insert_question_answer_data($ans_data);
                                                            if(!empty($insert_answer_data)){
                                                                foreach ($insert_answer_data as $key => $valueddd) {
                                                                   // print_r($insert_answer_data);echo "<br><br>";exit();
                                                                  ///$this->insert_question_answer_data($valueddd);
                                                                   $insert_id_ans_data[]=Modules::run('api/insert_into_specific_table',$valueddd,DEFAULT_OUTLET.'_checks_answers');
                                                                }
                                                            }
                                                           
                                                           
                                                        }elseif($pa['possible_answers']=="Fixed"){
                                                            $ans_data['possible_answer']='';
                                                            $ans_data['min']=0;
                                                            $ans_data['max']= 0;
                                                            $ans_data['is_acceptable']=1;
                                                            $ans_data['checkid']=$checkid;
                                                            $ans_data['question_id']=$insert_id;
                                                            //$this->insert_question_answer_data($ans_data);
                                                           
                                                           $insert_id_questions[]=Modules::run('api/insert_into_specific_table',$ans_data,DEFAULT_OUTLET.'_checks_answers');
                                                        }
                                                        else{
    
                                                            $ans_data=array();
                                                            $ans_data['possible_answer']='';
                                                            $ans_data['min']= $pa['min'];
                                                            $ans_data['max']= $pa['max'];
                                                            $ans_data['is_acceptable']=0;
                                                            $ans_data['checkid']=$value['id'];
                                                            $ans_data['question_id']=$insert_id;
                                                            
                                                            
                                                           
                                                            
                                                           // $this->insert_question_answer_data($ans_data);
                                                            $insert_id_questions[]=Modules::run('api/insert_into_specific_table',$ans_data,DEFAULT_OUTLET.'_checks_answers');
                                                          
                                                        }
                                                    endforeach;
                                                    }
                                                }
                                                /////////// notification code umar start///////////
                                                /*if(!empty($assign_id) && !empty($outlet_id)) {
                                                    $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                    $fcm_data = $fcm_token = array();
                                                    foreach ($inspection_team_array as $key => $insp_team):
                                                     Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                       
                                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                        if(!empty($tokens)) {
                                                            
                                                            foreach ($tokens as $key => $to):
                                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                    $fcm_token[] = $to['fcm_token'];
                                                                if(isset($to['id']) && !empty($to['id'])) {
                                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                }
                                                            endforeach;
                                                        }
                                                    endforeach;
                                                    if(!empty($fcm_token) && $counter== 1) {
                                                        $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                        Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                        $counter = $counter + 1;
                                                    }
                                                }*/
                                                /////////// notification code umar end///////////
                                            }
                                        }
                                        
                                    }
                                    endforeach;
                                }
                           
    }
    function create_wip_profile_bowlfilling_assignments($value,$start_date_time,$end_date_time){
         $counter = 1;
                        $outlet_id=DEFAULT_OUTLET;
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array(); 
                               
                                if(!empty($product_schedules)) {
                                    foreach ($product_schedules as $key => $ps):
                                        $product_attribute = array();
                                        
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('wip_type'=>'bowl_filling'),'wip_id desc','wip_id','wip_profile','*','1','0','','','')->result_array();
                                            $valid = false;

                                        if(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        if($valid == true) {
                                            $assign_data['line_timing'] = $ps['ps_line'];
                                            $assign_data['product_id'] = $ps['ps_product'];
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                            //$assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=$start_date_time;
                                            $assign_data['end_datetime']=$end_date_time;
                                            $assign_data['assign_status']='Closed';
                                            /////////////check for already exists
                                            $where_assign['checkid']=$value['id'];
                                            //$where_assign['inspection_team']=$value['inspection_team'];
                                            $where_assign['review_team']=$value['review_team'];
                                            $where_assign['approval_team']=$value['approval_team'];
                                            $where_assign['start_datetime <=']=$start_date_time;
                                            $where_assign['end_datetime >=']= $end_date_time;
                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                              $inspection_team_array=array();
                                	        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                                        
                                            if(empty($check_if) && !empty($inspection_team_array)){
                                                    $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                                    
                                                    if(isset($product_attribute) && !empty($product_attribute)) {$attribute_name='';
                                                       
                                                           
                                                     
                                                        foreach ($product_attribute as $key => $pa):
                                                            
                                                            $attribute_name=$pa['attribute_name'];
                                                            $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>$pa['attribute_type'],"question"=>$attribute_name,"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                           if($pa['attribute_type']=="Choice" ){
                                                                $ans_array=explode(" ",$possible_answer);
        
                                                                if($pa['possible_answers']=="yes/no"){
                                                                    $insert_answer_data=array();
                                                                    $insert_answer_data[0]['possible_answer']='yes';
                                                                    $insert_answer_data[0]['min']=0;
                                                                    $insert_answer_data[0]['max']= 0;
                                                                    $insert_answer_data[0]['is_acceptable']=1;
                                                                    $insert_answer_data[0]['checkid']=$value['id'];
                                                                    $insert_answer_data[0]['question_id']=$insert_id;
        
                                                                    $insert_answer_data[1]['possible_answer']='no';
                                                                    $insert_answer_data[1]['min']=0;
                                                                    $insert_answer_data[1]['max']= 0;
                                                                    $insert_answer_data[1]['is_acceptable']=0;
                                                                    $insert_answer_data[1]['checkid']=$value['id'];
                                                                    $insert_answer_data[1]['question_id']=$insert_id;
                                                                }elseif($pa['possible_answers']=="acceptable/unacceptable" ||  $possible_answer[$i]=="acceptable/not acceptable"){
                                                                    $insert_answer_data=array();
                                                                    $insert_answer_data[0]['possible_answer']='acceptable';
                                                                    $insert_answer_data[0]['min']=0;
                                                                    $insert_answer_data[0]['max']= 0;
                                                                    $insert_answer_data[0]['is_acceptable']=1;
                                                                    $insert_answer_data[0]['checkid']=$value['id'];
                                                                    $insert_answer_data[0]['question_id']=$insert_id;
        
                                                                    $insert_answer_data[1]['possible_answer']='unacceptable';
                                                                    $insert_answer_data[1]['min']=0;
                                                                    $insert_answer_data[1]['max']= 0;
                                                                    $insert_answer_data[1]['is_acceptable']=0;
                                                                    $insert_answer_data[1]['checkid']=$value['id'];
                                                                    $insert_answer_data[1]['question_id']=$insert_id;
                                                                }
                                                                elseif($pa['possible_answers']=="completed/not completed"){
                                                                    $insert_answer_data=array();
                                                                    $insert_answer_data[0]['possible_answer']='completed';
                                                                    $insert_answer_data[0]['min']=0;
                                                                    $insert_answer_data[0]['max']= 0;
                                                                    $insert_answer_data[0]['is_acceptable']=1;
                                                                    $insert_answer_data[0]['checkid']=$value['id'];
                                                                    $insert_answer_data[0]['question_id']=$insert_id;
        
                                                                    $insert_answer_data[1]['possible_answer']='not completed';
                                                                    $insert_answer_data[1]['min']=0;
                                                                    $insert_answer_data[1]['max']= 0;
                                                                    $insert_answer_data[1]['is_acceptable']=0;
                                                                    $insert_answer_data[1]['checkid']=$value['id'];
                                                                    $insert_answer_data[1]['question_id']=$insert_id;
        
        
                                                                }
                                                                elseif($pa['possible_answers']=="cleaned/uncleaned"){
                                                                    $insert_answer_data=array();
                                                                    $insert_answer_data[0]['possible_answer']='cleaned';
                                                                    $insert_answer_data[0]['min']=0;
                                                                    $insert_answer_data[0]['max']= 0;
                                                                    $insert_answer_data[0]['is_acceptable']=1;
                                                                    $insert_answer_data[0]['checkid']=$value['id'];
                                                                     $insert_answer_data[0]['question_id']=$insert_id;
        
                                                                    $insert_answer_data[1]['possible_answer']='uncleaned';
                                                                    $insert_answer_data[1]['min']=0;
                                                                    $insert_answer_data[1]['max']= 0;
                                                                    $insert_answer_data[1]['is_acceptable']=0;
                                                                    $insert_answer_data[1]['checkid']=$value['id'];
                                                                    $insert_answer_data[1]['question_id']=$insert_id;
                                                                }
                                                                elseif($pa['possible_answers']=="cleaned/completed"){
                                                                    $insert_answer_data=array();
                                                                    $insert_answer_data[0]['possible_answer']='cleaned';
                                                                    $insert_answer_data[0]['min']=0;
                                                                    $insert_answer_data[0]['max']= 0;
                                                                    $insert_answer_data[0]['is_acceptable']=1;
                                                                    $insert_answer_data[0]['checkid']=$value['id'];
                                                                    $insert_answer_data[0]['question_id']=$insert_id;
        
                                                                    $insert_answer_data[1]['possible_answer']='completed';
                                                                    $insert_answer_data[1]['min']=0;
                                                                    $insert_answer_data[1]['max']= 0;
                                                                    $insert_answer_data[1]['is_acceptable']=0;
                                                                    $insert_answer_data[1]['checkid']=$value['id'];
                                                                    $insert_answer_data[1]['question_id']=$insert_id;
                                                                }else{
        
                                                                    $insert_answer_data=array();
                                                                    $insert_answer_data[0]['possible_answer']='yes';
                                                                    $insert_answer_data[0]['min']=0;
                                                                    $insert_answer_data[0]['max']= 0;
                                                                    $insert_answer_data[0]['is_acceptable']=1;
                                                                    $insert_answer_data[0]['checkid']=$value['id'];
                                                                    $insert_answer_data[0]['question_id']=$insert_id;
        
        
                                                                    
                                                                }
                                                                
                                                                //$this->insert_question_answer_data($ans_data);
                                                                if(!empty($insert_answer_data)){
                                                                    foreach ($insert_answer_data as $key => $valueddd) {
                                                                       // print_r($insert_answer_data);echo "<br><br>";exit();
                                                                      ///$this->insert_question_answer_data($valueddd);
                                                                       $insert_id_ans_data[]=Modules::run('api/insert_into_specific_table',$valueddd,DEFAULT_OUTLET.'_checks_answers');
                                                                    }
                                                                }
                                                               
                                                               
                                                            }elseif($pa['possible_answers']=="Fixed"){
                                                                $ans_data['possible_answer']='';
                                                                $ans_data['min']=0;
                                                                $ans_data['max']= 0;
                                                                $ans_data['is_acceptable']=1;
                                                                $ans_data['checkid']=$checkid;
                                                                $ans_data['question_id']=$insert_id;
                                                                //$this->insert_question_answer_data($ans_data);
                                                               
                                                               $insert_id_questions[]=Modules::run('api/insert_into_specific_table',$ans_data,DEFAULT_OUTLET.'_checks_answers');
                                                            }
                                                            else{
        
                                                                $ans_data=array();
                                                                $ans_data['possible_answer']='';
                                                                $ans_data['min']= $pa['min'];
                                                                $ans_data['max']= $pa['max'];
                                                                $ans_data['is_acceptable']=0;
                                                                $ans_data['checkid']=$value['id'];
                                                                $ans_data['question_id']=$insert_id;
                                                                
                                                                
                                                               
                                                                
                                                               // $this->insert_question_answer_data($ans_data);
                                                                $insert_id_questions[]=Modules::run('api/insert_into_specific_table',$ans_data,DEFAULT_OUTLET.'_checks_answers');
                                                              
                                                            }
                                                        endforeach;
                                                        }
                                                    
                                                    /////////// notification code umar start///////////
                                                    /*if(!empty($assign_id) && !empty($outlet_id)) {
                                                        $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                        $fcm_data = $fcm_token = array();
                                                       foreach ($inspection_team_array as $key => $insp_team):
                                                            Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                           
                                                            $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                            if(!empty($tokens)) {
                                                                
                                                                foreach ($tokens as $key => $to):
                                                                    if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                        $fcm_token[] = $to['fcm_token'];
                                                                    if(isset($to['id']) && !empty($to['id'])) {
                                                                        Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                    }
                                                                endforeach;
                                                            }
                                                        endforeach;
                                                        if(!empty($fcm_token) && $counter== 1) {
                                                            $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                            Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                            $counter = $counter + 1;
                                                        }
                                                    }*/
                                                    /////////// notification code umar end///////////
                                                }
                                        }
                                    
                                    endforeach;
                                }
                           
    }
    function create_gluten_free_checks(){
            date_default_timezone_set("Asia/karachi");
            $outlet_id=DEFAULT_OUTLET;
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
            /*$this->send_test_cron_job();*/
            
            
            $where_in=array();
          
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status >=']='1';

            $check_lists=$this->get_all_gluten_free_product_check_list_from_db($where,$outlet_id=DEFAULT_OUTLET,$where_in)->result_array() ;
         
             if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value) {
                    if($value['frequency']=="30 Mins"){
                        $start_date_time='';
                        $end_date_time='';
                        $start_date_time=date('Y-m-d H:i:s');
                        $end_date_time= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                         $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                        if(!empty($product_schedules)) {
                            foreach ($product_schedules as $key => $ps){
                                  
                                    $this->create_schedule_glutenfree_seafood_list_thirty($value,$start_date_time,$end_date_time,$ps);
                            }
                        
                        }
                    }
                    elseif ($value['frequency']=="hourly"){
                        $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                         $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                        if(!empty($product_schedules)) {
                            foreach ($product_schedules as $key => $ps){
                                  
                                    $this->create_schedule_glutenfree_seafood_list_thirty($value,$start_date_time,$end_date_time,$ps);
                            }
                        
                        }
                    } 
                    elseif($value['frequency']=="Daily"){
                       $start_date_time='';
                                $end_date_time='';
                                 $start_date_time=date('Y-m-d H:i:s');
                               $end_date_time=  date('Y-m-d 23:59:00');
                         $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                        if(!empty($product_schedules)) {
                            foreach ($product_schedules as $key => $ps){
                             $this->create_schedule_glutenfree_seafood_list_thirty($value,$start_date_time,$end_date_time,$ps);
                            }
                        
                        }
                    }  
                    elseif($value['frequency']=="Weekly"){
                        
                           $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("l")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                   if(!empty($today_valid)) {
                                    $start_date_time='';
                                    $end_date_time='';
                                    $start_date_time=date('Y-m-d H:i:s');
                                    $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                            $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                           
                            if(!empty($product_schedules)) {
                                foreach ($product_schedules as $key => $ps){
                                 $this->create_schedule_glutenfree_seafood_list_thirty($value,$start_date_time,$end_date_time,$ps);
                                }
                            
                            }
                        }
                    
                    } 
                    elseif($value['frequency']=="Shift"){
                            $start_date_time='';
                            $end_date_time='';
                            $start_date_time=date('Y-m-d').' 00:00:00';
                            $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                            $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array();
                            if(!empty($product_schedules)) {
                                foreach ($product_schedules as $key => $ps){
                                 $this->create_schedule_glutenfree_seafood_list_thirty($value,$start_date_time,$end_date_time,$ps);
                                }
                            
                            }
                       
                    } 
                }
            }
          
    }
    function create_schedule_glutenfree_seafood_list_thirty($value,$start_date_time,$end_date_time,$ps) {
      
        $counter = 1; $product_type='';
                if(strtolower($value['cat_name'] ) =="seafood")
                $product_type="Seafood";
                elseif(strtolower($value['cat_name'] ) =="gluten free")
                 $product_type="Gluten";
            $is_valid_product = Modules::run('api/_get_specific_table_with_pagination',array("product_type" =>$product_type,'id'=>$ps['ps_product']), 'id asc',DEFAULT_OUTLET.'_product','id','1','0')->result_array();
          
            if(!empty($is_valid_product)){   
               
                if(strtolower($value['cat_name'] ) =="gluten free"){
                    if(strtolower($value['cat_name'] ) =="seafood"){
                        $assignment_type="seafood";
                    }else
                         $assignment_type="gluten_free";
                    if($value['frequency']!= "Shift") {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            $assign_data =array();
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $outlet_id=$value['outlet_id'];
                                $assign_data['line_timing'] = $ps['ps_line'];
                                $assign_data['product_id'] = $ps['ps_product'];
                                $assign_data['assignment_type']=$assignment_type;
                                $assign_data['checkid']=$value['id'];
                                //$assign_data['inspection_team']=$value['inspection_team'];
                                $assign_data['review_team']=$value['review_team'];
                                $assign_data['approval_team']=$value['approval_team'];
                                $assign_data['outlet_id']=$value['outlet_id'];
                                $assign_data['start_datetime']=$start_date_time;
                                $assign_data['end_datetime']=$end_date_time;
                                $assign_data['assign_status']='Closed';
                                /////////////check for already exists
                                $where_assign['checkid']=$value['id'];
                            	$where_assign['product_id'] = $ps['ps_product'];
                               // $where_assign['inspection_team']=$value['inspection_team'];
                                $where_assign['review_team']=$value['review_team'];
                                $where_assign['approval_team']=$value['approval_team'];
                                $where_assign['start_datetime <=']=$start_date_time;
                                $where_assign['end_datetime >=']= $end_date_time;
                                $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                 
                                 $inspection_team_array=array();
                    	        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                            
                                if(empty($check_if) && !empty($inspection_team_array)){
                                     $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                    
                                     /////////// notification code umar start///////////
                                    if(!empty($assign_id) && !empty($outlet_id)) {
                                        $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                        $fcm_token = array();
                                          foreach ($inspection_team_array as $key => $insp_team):
                                                Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                               
                                                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                if(!empty($tokens)) {
                                                    
                                                    foreach ($tokens as $key => $to):
                                                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                            $fcm_token[] = $to['fcm_token'];
                                                        if(isset($to['id']) && !empty($to['id'])) {
                                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                        }
                                                    endforeach;
                                                }
                                            endforeach;
                                        if(!empty($fcm_token) && $counter== 1) {
                                            $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                            Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                            $counter = $counter + 1;
                                        }
                                    }
                                    /////////// notification code umar end///////////
                                }
                            }
                           
                           
                        }                
                    }
                    elseif($value['frequency'] == "Shift") {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            $assign_data =array();
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $shift_timing = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id']), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($shift_timing)) {
                                    $all_shifts = Modules::run('api/_get_specific_table_with_pagination',array("shift_status" =>'1'), 'shift_id asc',DEFAULT_OUTLET.'_shifts','shift_id','1','0')->result_array();
                                    if(!empty($all_shifts)){
                                        foreach ($all_shifts as $key => $as):
                                            $current_shift_timig = Modules::run('api/_get_specific_table_with_pagination',array("st_day" =>date("l"),'st_shift'=>$as['shift_id'],'st_status'=>'1'), 'st_id asc',DEFAULT_OUTLET.'_shift_timing','st_start,st_end','1','0')->result_array();
                                            if(!empty($current_shift_timig)){
                                                $check = false;
                                                $start_time = date('H:i:s');
                                                $end_time = date('H:i:s',strtotime('+30 minutes',strtotime(date('H:i:s'))));
                                            	$start_time = date('H:i:s',strtotime('-1 minutes',strtotime($start_time)));
                                                foreach ($shift_timing as $key => $st):
                                                    $check = false;
                                                    if($st['fc_frequency'] == 'Start') {
                                                        if($current_shift_timig[0]['st_start'] >= $start_time && $current_shift_timig[0]['st_start'] <= $end_time) {
                                                            $check = TRUE;
                                                        }
                                                    }
                                                    elseif($st['fc_frequency'] == 'End') {
                                                        if($current_shift_timig[0]['st_end'] >= $start_time && $current_shift_timig[0]['st_end'] <= $end_time) {
                                                            $check = TRUE;
                                                        }
                                                    }
                                                    elseif($st['fc_frequency'] == 'Middle') {
                                                        $matching_time= "";
                                                        if($current_shift_timig[0]['st_end'] > $current_shift_timig[0]['st_start']) {
                                                            $timeDiff=$current_shift_timig[0]['st_end']-$current_shift_timig[0]['st_start'];
                                                            $timeDiff = round(round($timeDiff)/2);
                                                            $matching_time = date('H:i:s',strtotime('+'.$timeDiff.' hour',strtotime($current_shift_timig[0]['st_start'])));
                                                            if($matching_time >= $start_time && $matching_time <= $end_time)
                                                                $check = TRUE;
                                                        }                                            
                                                    }
                                                    else
                                                        $check = false;
                                                    if($check == true) {
                                                        $outlet_id=$value['outlet_id'];
                                                        $assign_data['line_timing'] = $ps['ps_line'];
                                                        $assign_data['product_id'] = $ps['ps_product'];
                                                        $assign_data['assignment_type']=$assignment_type;
                                                        $assign_data['checkid']=$value['id'];
                                                       // $assign_data['inspection_team']=$value['inspection_team'];
                                                        $assign_data['review_team']=$value['review_team'];
                                                        $assign_data['approval_team']=$value['approval_team'];
                                                        $assign_data['outlet_id']=$value['outlet_id'];
                                                        $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                                        $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                                        $assign_data['assign_status']='Closed';
                                                        /////////////check for already exists
                                                        $where_assign['checkid']=$value['id'];
                                                    	$where_assign['product_id'] = $ps['ps_product'];
                                                        //$where_assign['inspection_team']=$value['inspection_team'];
                                                        $where_assign['review_team']=$value['review_team'];
                                                        $where_assign['approval_team']=$value['approval_team'];
                                                        $where_assign['start_datetime  <=']=date('Y-m-d H:i:s');
                                                        $where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                                        $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                                        if(empty($check_if)){
                                                             $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                                             /////////// notification code umar start///////////
                                                            if(!empty($assign_id) && !empty($outlet_id)) {
                                                                $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                                $fcm_token = array();
                                                                $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$value['inspection_team'].'" or `group`="'.$value['inspection_team'].'")','','')->result_array();
                                                                if(!empty($tokens)) {
                                                                    foreach ($tokens as $key => $to):
                                                                        if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                            $fcm_token[] = $to['fcm_token'];
                                                                        if(isset($to['id']) && !empty($to['id'])) {
                                                                            Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                        }
                                                                    endforeach;
                                                                }
                                                                if(!empty($fcm_token) && $counter== 1) {
                                                                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                                    $counter = $counter + 1;
                                                                }
                                                            }
                                                            /////////// notification code umar end///////////
                                                        }
                                                    }
                                                endforeach;
                                            }
                                        endforeach;
                                    }
                                }
                            }
                        }
                    }
                    else
                        echo "";                
                }
            }
           
        
    }
    /////////////functioons for //////////
    
    
     function schedule_for_herbspice_checks_assignments(){
        date_default_timezone_set("Asia/karachi");
        $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
       
        $where['product_checks.outlet_id']=DEFAULT_OUTLET;
        $where['product_checks.status']=1;

        $open_close=$this->outlet_open_close(DEFAULT_OUTLET);
        $counter = 1;
        if($open_close=="Open"){
            /*date_default_timezone_set("Asia/karachi");
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);*/
            
            $where_in[]='herb_spice';
           
          
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status']='1';

            $check_lists=$this->get_all_product_check_list_from_db($where,$outlet_id=DEFAULT_OUTLET,$where_in)->result_array();
          
            if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value) {
                     if(isset($value['checktype']) && !empty($value['checktype'])) {
                        if(strtolower($value['checktype']) == strtolower('herb_spice')) {
                            if($value['frequency']=="30 Mins") {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                            
                                $this->create_herbspice_checks_assignments($value,$start_date_time,$end_date_time);
        
                            }elseif ($value['frequency']=="hourly") {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                                
                                 $this->create_herbspice_checks_assignments($value,$start_date_time,$end_date_time);
                            }elseif ($value['frequency']=="Daily") {
                                $start_date_time='';
                                $end_date_time='';
                                 $start_date_time=date('Y-m-d H:i:s');
                               $end_date_time=  date('Y-m-d 23:59:00');
                                
                                 $this->create_herbspice_checks_assignments($value,$start_date_time,$end_date_time);
                            }elseif ($value['frequency']=="Weekly") {
                                 
                                $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("l")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($today_valid)) {
                                $start_date_time='';
                                $end_date_time='';
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                                    
                                 
                                 $this->create_herbspice_checks_assignments($value,$start_date_time,$end_date_time);
                                }
                            }
                            }
                          
        
                    }
                }
                                
            }
        }
    }
     function create_herbspice_checks_assignments($value,$start_date_time,$end_date_time){
         $counter = 1;
                        $outlet_id=DEFAULT_OUTLET;
                                $product_schedules = $this->get_product_schedules_from_db(array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d')),'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape','1','0','','','')->result_array(); 
                               
                                
                                        $product_attribute = array();
                                        $product_ingredients = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('checkid'=>$value['id']),'id desc','id','herb_spice','*','1','0','','','')->result_array();
                                        if(!empty($product_ingredients)){
                                        $product_attribute = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('wip_type'=>'herb_spice','checkid'=>$value['id']),'wip_id desc','wip_id','herbspice_attributes','*','1','0','','','')->result_array();
                                            $valid = false;

                                        if(!empty($product_attribute))
                                            $valid = true;
                                        else
                                            $valid = false;
                                        if($valid == true) {
                                            $outlet_id=$value['outlet_id'];
                                            $assign_data['checkid']=$value['id'];
                                            $assign_data['inspection_team']=$value['inspection_team'];
                                            $assign_data['review_team']=$value['review_team'];
                                            $assign_data['approval_team']=$value['approval_team'];
                                            $assign_data['outlet_id']=$value['outlet_id'];
                                            $assign_data['start_datetime']=$start_date_time;
                                            $assign_data['end_datetime']=$end_date_time;
                                            $assign_data['assign_status']='Open';
                                            /////////////check for already exists
                                            $where_assign['checkid']=$value['id'];
                                            $where_assign['inspection_team']=$value['inspection_team'];
                                            $where_assign['review_team']=$value['review_team'];
                                            $where_assign['approval_team']=$value['approval_team'];
                                            $where_assign['start_datetime <=']=$start_date_time;
                                            $where_assign['end_datetime >=']= $end_date_time;
                                            $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                            if(empty($check_if)){
                                                $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                                
                                                if(isset($product_attribute) && !empty($product_attribute)) {$attribute_name='';
                                                    foreach ($product_ingredients as $key => $ingr_value) {
                                                       
                                                 
                                                    foreach ($product_attribute as $key => $pa):
                                                        
                                                        $attribute_name=$ingr_value['product_name'].' : '.$pa['attribute_name'];
                                                        $insert_id=Modules::run('api/insert_into_specific_table',array("checkid"=>$value['id'],"type"=>$pa['attribute_type'],"question"=>$attribute_name,"assignment_id"=>$assign_id),$outlet_id.'_checks_questions');
                                                       if($pa['attribute_type']=="Choice" ){
                                                           
    
                                                            if($pa['possible_answers']=="yes/no"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='yes';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='no';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }elseif($pa['possible_answers']=="acceptable/unacceptable" ||  $possible_answer[$i]=="acceptable/not acceptable"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='acceptable';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='unacceptable';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }
                                                            elseif($pa['possible_answers']=="completed/not completed"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='completed';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='not completed';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
    
    
                                             
    
    
                                                            }
                                                            elseif($pa['possible_answers']=="cleaned/uncleaned"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='cleaned';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                 $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='uncleaned';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }
                                                            elseif($pa['possible_answers']=="cleaned/completed"){
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='cleaned';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
                                                                $insert_answer_data[1]['possible_answer']='completed';
                                                                $insert_answer_data[1]['min']=0;
                                                                $insert_answer_data[1]['max']= 0;
                                                                $insert_answer_data[1]['is_acceptable']=0;
                                                                $insert_answer_data[1]['checkid']=$value['id'];
                                                                $insert_answer_data[1]['question_id']=$insert_id;
                                                            }else{
    
                                                                $insert_answer_data=array();
                                                                $insert_answer_data[0]['possible_answer']='yes';
                                                                $insert_answer_data[0]['min']=0;
                                                                $insert_answer_data[0]['max']= 0;
                                                                $insert_answer_data[0]['is_acceptable']=1;
                                                                $insert_answer_data[0]['checkid']=$value['id'];
                                                                $insert_answer_data[0]['question_id']=$insert_id;
    
    
                                                                
                                                            }
                                                            
                                                            //$this->insert_question_answer_data($ans_data);
                                                            if(!empty($insert_answer_data)){
                                                                foreach ($insert_answer_data as $key => $valueddd) {
                                                                   // print_r($insert_answer_data);echo "<br><br>";exit();
                                                                  ///$this->insert_question_answer_data($valueddd);
                                                                   $insert_id_ans_data[]=Modules::run('api/insert_into_specific_table',$valueddd,DEFAULT_OUTLET.'_checks_answers');
                                                                }
                                                            }
                                                           
                                                           
                                                        }elseif($pa['possible_answers']=="Fixed"){
                                                            $ans_data['possible_answer']='';
                                                            $ans_data['min']=0;
                                                            $ans_data['max']= 0;
                                                            $ans_data['is_acceptable']=1;
                                                            $ans_data['checkid']=$checkid;
                                                            $ans_data['question_id']=$insert_id;
                                                            //$this->insert_question_answer_data($ans_data);
                                                           
                                                           $insert_id_questions[]=Modules::run('api/insert_into_specific_table',$ans_data,DEFAULT_OUTLET.'_checks_answers');
                                                        }
                                                        else{
    
                                                            $ans_data=array();
                                                            $ans_data['possible_answer']='';
                                                            $ans_data['min']= $pa['min'];
                                                            $ans_data['max']= $pa['max'];
                                                            $ans_data['is_acceptable']=0;
                                                            $ans_data['checkid']=$value['id'];
                                                            $ans_data['question_id']=$insert_id;
                                                            
                                                            
                                                           
                                                            
                                                           // $this->insert_question_answer_data($ans_data);
                                                            $insert_id_questions[]=Modules::run('api/insert_into_specific_table',$ans_data,DEFAULT_OUTLET.'_checks_answers');
                                                          
                                                        }
                                                    endforeach;
                                                    }
                                                }
                                                /////////// notification code umar start///////////
                                                if(!empty($assign_id) && !empty($outlet_id)) {
                                                    $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                    $fcm_data = $fcm_token = array();
                                                    $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$value['inspection_team'].'" or `group`="'.$value['inspection_team'].'")','','')->result_array();
                                                    if(!empty($tokens)) {
                                                        foreach ($tokens as $key => $to):
                                                            if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                $fcm_token[] = $to['fcm_token'];
                                                            if(isset($to['id']) && !empty($to['id'])) {
                                                                Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                            }
                                                        endforeach;
                                                    }
                                                    if(!empty($fcm_token) && $counter== 1) {
                                                        $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                        Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                        $counter = $counter + 1;
                                                    }
                                                }
                                                /////////// notification code umar end///////////
                                            }
                                        }
                                        
                                    }
                                    
                           
    }
    ////////////////// END WIP PROFILE FUNCTONS //////////
    /////////////////////////////////model functions/////////////////
    function get_checks_lists_from_db($cols,$group_by='',$table,$select,$page_number,$limit,$or_where='',$and_where='',$having='',$like=''){
          $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_checks_lists_from_db($cols,$group_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having,$like);
        return $query;
    }
    function get_all_check_list_from_db($where,$outlet_id,$where_frequency){
          $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_all_check_list_from_db($where,$outlet_id,$where_frequency);
        return $query;
    }
	function get_all_check_list_from_db_without_join($where,$outlet_id,$where_frequency){
          $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_all_check_list_from_db_without_join($where,$outlet_id,$where_frequency);
        return $query;
    }
    /////////////////wip profile///////////////
     function get_all_product_check_list_from_db($where,$outlet_id,$where_inarray){
          $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_all_product_check_list_from_db($where,$outlet_id,$where_inarray);
        return $query;
    }
      function get_all_gluten_free_product_check_list_from_db($where,$outlet_id,$where_inarray){
          $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_all_gluten_free_product_check_list_from_db($where,$outlet_id,$where_inarray);
        return $query;
    }
    /////////////end wip profile function/////////////
    function insert_assignment_data($data,$outlet_id){
          $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->insert_assignment_data($data,$outlet_id);
            return $query;
    }
     function outlet_open_close($outlet_id){
    $open_close='Closed';
      
                date_default_timezone_set('Asia/karachi');
     			$timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            	if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
                $timing=Modules::run('outlet/outlet_open_close',array("timing.outlet_id"=>$outlet_id,"timing.day"=>date('l'),"timing.opening <="=>date('H:i:s'),"timing.closing >="=>date('H:i:s')),"(CASE WHEN closing < opening THEN '23:59:59' else  closing END) AS closssing,is_closed",array("closssing >="=>date('H:i:s')))->result_array();
                if(!empty($timing)) {
                    if($timing[0]['is_closed'] ==0)
                        $open_close='Open';

                }
        
      return $open_close;
   }     
   function check_if_assignment_exists($where,$outlet_id){
     $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->check_if_assignment_exists($where,$outlet_id);
            return $query;
   }  
    function get_checks_detail_from_db($where,$outlet_id){
         $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_checks_detail_from_db($where,$outlet_id);
            return $query;
   }
   function get_question_answers($where,$outlet_id){
          $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_question_answers($where,$outlet_id);
            return $query;
   }
   function get_over_due_assignment($where,$outlet_id){
         $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_over_due_assignment($where,$outlet_id);
            return $query;
   }
   function update_assignment_status($where,$data,$outlet_id){
         $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->update_assignment_status($where,$data,$outlet_id);
            return $query;
   }
   function check_from_assignment_answers($where,$outlet_id){
         $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->check_from_assignment_answers($where,$outlet_id);
            return $query;
   }
   function insert_assign_answers($outlet_id,$data){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->insert_assign_answers($outlet_id,$data);
            return $query;
   }
   function update_where_assignment_answer($where,$data,$outlet_id){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->update_where_assignment_answer($where,$data,$outlet_id);
            return $query;
   }
    function get_assign_data($cols, $order_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_assign_data($cols, $order_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_complete_by_user($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_complete_by_user($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_chat_detail($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_chat_detail($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_product_schedules_from_db($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_product_schedules_from_db($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_plants_lines($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_plants_lines($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
	function delete_current_date_checks() {
        $outlet_id = '1';
        $start_time = '2019-01-19 00:00:00';
        $end_time= "2019-12-12 15:39:31";
        $checks = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("start_datetime >="=>$start_time),'assign_id desc','assign_id',$outlet_id.'_assignments','checkid,assign_id','1','0','','','')->result_array();
        print_r($checks);echo "<br><br>";
        if(isset($checks) && !empty($checks)) {
            foreach ($checks as $key => $ck):
                if(isset($ck['checkid']) && !empty($ck['checkid'])) {
                   $check_detail =  Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$ck['checkid']),'id desc','id',$outlet_id.'_product_checks','checktype','1','0','','','')->result_array();
                    if(isset($check_detail) && !empty($check_detail)) {
                        foreach ($check_detail as $key => $cd):
                            if(isset($cd['checktype']) && !empty($cd['checktype'])) {
                                if(strtolower($cd['checktype']) == 'product attribute') {
                                    $questions = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("checkid"=>$ck['checkid']),'question_id desc','question_id',$outlet_id.'_checks_questions','question_id','1','0','','','')->result_array();
                                    if(!empty($questions)) {
                                        foreach ($questions as $key => $qa):
                                            if(isset($qa['question_id']) && !empty($qa['question_id']))
                                                Modules::run('api/delete_from_specific_table',array("question_id"=>$qa['question_id']),$outlet_id."_checks_answers");
                                        endforeach;
                                        Modules::run('api/delete_from_specific_table',array("question_id"=>$qa['question_id']),$outlet_id."_checks_questions");
                                    }
                                    else
                                        echo "<br><br>no questions available of current check  ".$ck['checkid']."<br>";
                                }
                            }
                            else
                                echo "<br><br>check type  does not exit  of current check ".$ck['checkid']."<br>";
                        endforeach;
                        
                        
                    }
                    else
                        echo "<br><br>check detail does not exit ".$ck['checkid']."<br>";
                }
                else
                    echo "<br><br>check date not available of current assignment ".$ck['assign_id']."<br>";
                Modules::run('api/delete_from_specific_table',array("assign_id"=>$ck['assign_id']),$outlet_id."_assignments");
            endforeach;
        }
        else
            echo "<br><br>no checks available during start datetime ".$start_time." and end datetime ".$end_time."<br>";
    }
    function get_static_forms($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_static_forms($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    ////////////////\
   function create_scheduled_checks(){
          date_default_timezone_set("Asia/karachi");
            $outlet_id=DEFAULT_OUTLET;
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
            $where_in=array();
          
            $where['product_checks.start_datetime <=']=date('Y-m-d H:i');
            $where['product_checks.end_datetime >=']=date('Y-m-d H:i');
            $where['product_checks.status >=']='1';
            $where['product_checks.checktype']='scheduled_checks';

            $check_lists=$this->get_all_scheduled_checks($where,$outlet_id=DEFAULT_OUTLET)->result_array() ;
           
             if(isset($check_lists) && !empty($check_lists)){
                foreach ($check_lists as $key => $value) {
                     $start_date_time='';
                     $end_date_time='';
                    if($value['frequency']=="30 Mins"){
                        $start_date_time=date('Y-m-d H:i:s');
                        $end_date_time= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                    }
                    elseif ($value['frequency']=="hourly"){
                                $start_date_time=date('Y-m-d H:i:s');
                                $end_date_time= date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date('Y-m-d H:i:s'))));
                       
                    } 
                    elseif($value['frequency']=="Daily"){
                               $start_date_time=date('Y-m-d H:i:s');
                               $end_date_time=  date('Y-m-d 23:59:00');
                    }  
                    elseif($value['frequency']=="Weekly"){
                                    $today_valid = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id'],'fc_frequency'=>date("l")), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                    if(!empty($today_valid)) {
                                    $start_date_time=date('Y-m-d H:i:s');
                                    $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                                    }
                    
                    } 
                    elseif($value['frequency']=="Shift"){
                            $start_date_time=date('Y-m-d').' 00:00:00';
                            $end_date_time=$cenvertedTime = date('Y-m-d').' 23:59:59';
                    }
                     if(strtolower($value['cat_name']) =="usda"){
                      $product_type="USDA";
                       $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),"product_type"=>$product_type);
                     }
                     elseif(strtolower($value['cat_name']) =="fda"){
                     $product_type="FDA";
                      $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),"product_type"=>$product_type);
                     }
                     elseif(strtolower($value['cat_name']) =="organic"){
                     $product_type="Organic";
                     $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),"product_type"=>$product_type);
                     }
                     elseif(strtolower($value['cat_name']) =="frozen"){
                   
                     $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),"storage_type"=>"Frozen");
                     }
                     elseif(strtolower($value['cat_name']) =="refrigerated"){
                     
                     $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),"storage_type"=>"Refrigerated");
                     }
                     
                       
                        $product_schedules = $this->get_product_schedules_from_db($where_data,'ps_id desc','ps_id',DEFAULT_OUTLET,'ps_product,product_title,ps_line,unit_weight,shape,product_type,storage_type','1','0','','','')->result_array();
                        
                       
                        if(!empty($product_schedules)) {
                        foreach ($product_schedules as $key => $ps){
                        $this->create_scheduled_assignments($value,$start_date_time,$end_date_time,$ps);
                        }
                            
                    }
                }
            }
          
    }
    function create_scheduled_assignments($value,$start_date_time,$end_date_time,$ps) {
      
                $counter = 1; 
                
                $is_valid_product = Modules::run('api/_get_specific_table_with_pagination',array("product_type" =>$product_type,'id'=>$ps['ps_product']), 'id asc',DEFAULT_OUTLET.'_product','id','1','0')->result_array();
          
                
               
              
                  
                         $assignment_type="scheduled_checks";
                        if($value['frequency']!= "Shift") {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            $assign_data =array();
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $outlet_id=$value['outlet_id'];
                                $assign_data['line_timing'] = $ps['ps_line'];
                                $assign_data['product_id'] =  $ps['ps_product'];
                                $assign_data['assignment_type']=$assignment_type;
                                $assign_data['checkid']=$value['id'];
                               // $assign_data['inspection_team']=$value['inspection_team'];
                                $assign_data['review_team']=$value['review_team'];
                                $assign_data['approval_team']=$value['approval_team'];
                                $assign_data['outlet_id']=$value['outlet_id'];
                                $assign_data['start_datetime']=$start_date_time;
                                $assign_data['end_datetime']=$end_date_time;
                                $assign_data['assign_status']='Closed';
                                /////////////check for already exists
                                $where_assign['checkid']=$value['id'];
                            	$where_assign['product_id'] = $ps['ps_product'];
                               // $where_assign['inspection_team']=$value['inspection_team'];
                                $where_assign['review_team']=$value['review_team'];
                                $where_assign['approval_team']=$value['approval_team'];
                                $where_assign['start_datetime <=']=$start_date_time;
                                $where_assign['end_datetime >=']= $end_date_time;
                                $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                 $inspection_team_array=array();
                                 $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                    
                                if(empty($check_if) && !empty($inspection_team_array)){
                                     $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                    
                                     /////////// notification code umar start///////////
                                    /*if(!empty($assign_id) && !empty($outlet_id)) {
                                        $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                        $fcm_token = array();
                                         
                                            foreach ($inspection_team_array as $key => $insp_team):
                                                     Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                       
                                                        $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                        if(!empty($tokens)) {
                                                            
                                                            foreach ($tokens as $key => $to):
                                                                if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                    $fcm_token[] = $to['fcm_token'];
                                                                if(isset($to['id']) && !empty($to['id'])) {
                                                                    Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                }
                                                            endforeach;
                                                        }
                                            endforeach;
                                        if(!empty($fcm_token) && $counter== 1) {
                                            $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                            Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                            $counter = $counter + 1;
                                        }
                                    }*/
                                    /////////// notification code umar end///////////
                                }
                            }
                           
                           
                        }                
                    }
                    elseif($value['frequency'] == "Shift") {
                        if(isset($value['checktype']) && !empty($value['checktype'])) {
                            $assign_data =array();
                            if(strtolower($value['checktype']) != strtolower('product attribute')) {
                                $shift_timing = Modules::run('api/_get_specific_table_with_pagination',array("fc_check_id" =>$value['id']), 'fc_id asc',DEFAULT_OUTLET.'_checks_frequency','fc_frequency','1','0')->result_array();
                                if(!empty($shift_timing)) {
                                    $all_shifts = Modules::run('api/_get_specific_table_with_pagination',array("shift_status" =>'1'), 'shift_id asc',DEFAULT_OUTLET.'_shifts','shift_id','1','0')->result_array();
                                    if(!empty($all_shifts)){
                                        foreach ($all_shifts as $key => $as):
                                            $current_shift_timig = Modules::run('api/_get_specific_table_with_pagination',array("st_day" =>date("l"),'st_shift'=>$as['shift_id'],'st_status'=>'1'), 'st_id asc',DEFAULT_OUTLET.'_shift_timing','st_start,st_end','1','0')->result_array();
                                            if(!empty($current_shift_timig)){
                                                $check = false;
                                                $start_time = date('H:i:s');
                                                $end_time = date('H:i:s',strtotime('+30 minutes',strtotime(date('H:i:s'))));
                                            	$start_time = date('H:i:s',strtotime('-1 minutes',strtotime($start_time)));
                                                foreach ($shift_timing as $key => $st):
                                                    $check = false;
                                                    if($st['fc_frequency'] == 'Start') {
                                                        if($current_shift_timig[0]['st_start'] >= $start_time && $current_shift_timig[0]['st_start'] <= $end_time) {
                                                            $check = TRUE;
                                                        }
                                                    }
                                                    elseif($st['fc_frequency'] == 'End') {
                                                        if($current_shift_timig[0]['st_end'] >= $start_time && $current_shift_timig[0]['st_end'] <= $end_time) {
                                                            $check = TRUE;
                                                        }
                                                    }
                                                    elseif($st['fc_frequency'] == 'Middle') {
                                                        $matching_time= "";
                                                        if($current_shift_timig[0]['st_end'] > $current_shift_timig[0]['st_start']) {
                                                            $timeDiff=$current_shift_timig[0]['st_end']-$current_shift_timig[0]['st_start'];
                                                            $timeDiff = round(round($timeDiff)/2);
                                                            $matching_time = date('H:i:s',strtotime('+'.$timeDiff.' hour',strtotime($current_shift_timig[0]['st_start'])));
                                                            if($matching_time >= $start_time && $matching_time <= $end_time)
                                                                $check = TRUE;
                                                        }                                            
                                                    }
                                                    else
                                                        $check = false;
                                                    if($check == true) {
                                                        $outlet_id=$value['outlet_id'];
                                                        $assign_data['line_timing'] = $ps['ps_line'];
                                                        $assign_data['product_id'] =$ps['ps_product'];
                                                        $assign_data['assignment_type']=$assignment_type;
                                                        $assign_data['checkid']=$value['id'];
                                                        //$assign_data['inspection_team']=$value['inspection_team'];
                                                        $assign_data['review_team']=$value['review_team'];
                                                        $assign_data['approval_team']=$value['approval_team'];
                                                        $assign_data['outlet_id']=$value['outlet_id'];
                                                        $assign_data['start_datetime']=date('Y-m-d H:i:s');
                                                        $assign_data['end_datetime']=$cenvertedTime = date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                                        $assign_data['assign_status']='Closed';
                                                        /////////////check for already exists
                                                        $where_assign['checkid']=$value['id'];
                                                        $where_assign['product_id'] = $ps['ps_product'];
                                                       // $where_assign['inspection_team']=$value['inspection_team'];
                                                        $where_assign['review_team']=$value['review_team'];
                                                        $where_assign['approval_team']=$value['approval_team'];
                                                        $where_assign['start_datetime  <=']=date('Y-m-d H:i:s');
                                                        $where_assign['end_datetime >=']= date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s'))));
                                                        $check_if=$this->check_if_assignment_exists($where_assign,$outlet_id=DEFAULT_OUTLET)->result_array();
                                                        $inspection_team_array=array();
                                                        $inspection_team_array = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$value['id']), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                  
                                                        if(empty($check_if)){
                                                             $assign_id = $this->insert_assignment_data($assign_data,$outlet_id);
                                                             /////////// notification code umar start///////////
                                                           /* if(!empty($assign_id) && !empty($outlet_id)) {
                                                                $assign_name='Assignment Name'; if(isset($value['checkname']) && !empty($value['checkname'])) $assign_name=$value['checkname']; $assign_name=  Modules::run('api/string_length',$assign_name,'8000','');
                                                                $fcm_token = array();
                                                                   foreach ($inspection_team_array as $key => $insp_team):
                                                                         Modules::run('api/insert_into_specific_table',array("inspection_team_id"=>$insp_team['sci_team_id'],"assignment_id"=>$assign_id,"assignment_checkid"=>$value['id']),$outlet_id.'_assignment_inspection_teams');
                                                                           
                                                                            $tokens = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','fcm_token,id','1','0','(`second_group`="'.$insp_team['sci_team_id'].'" or `group`="'.$insp_team['sci_team_id'].'")','','')->result_array();
                                                                            if(!empty($tokens)) {
                                                                                
                                                                                foreach ($tokens as $key => $to):
                                                                                    if(isset($to['fcm_token']) && !empty($to['fcm_token']))
                                                                                        $fcm_token[] = $to['fcm_token'];
                                                                                    if(isset($to['id']) && !empty($to['id'])) {
                                                                                        Modules::run('api/insert_into_specific_table',array("assingment_id"=>$assign_id,"user_id"=>$to['id'],"outlet_id"=>$outlet_id,"notification_message"=>"New ".$assign_name." has been assign to you, please login to the system to review the data.","notification_datetime"=>date("Y-m-d H:i:s")),'notification');
                                                                                    }
                                                                                endforeach;
                                                                            }
                                                                    endforeach;
                                                                if(!empty($fcm_token) && $counter== 1) {
                                                                    $fcm_data['data']=Modules::run('api/notifiction_message',$assign_name,"New ".$assign_name." has been assign to you, please login to the system to review the data.",false,false,"");
                                                                    Modules::run('api/send_fcm_message',$fcm_token,$fcm_data['data']);
                                                                    $counter = $counter + 1;
                                                                }
                                                            }*/
                                                            /////////// notification code umar end///////////
                                                        }
                                                    }
                                                endforeach;
                                            }
                                        endforeach;
                                    }
                                }
                            }
                        }
                    }
                    else
                        echo "";                
                }
    
    function get_all_scheduled_checks($where,$outlet_id){
         $this->load->model('mdl_perfectmodel');
         $query = $this->mdl_perfectmodel->get_all_scheduled_checks($where,$outlet_id);
        return $query;
    }
    
    function get_product_for_schedule_checks($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_product_for_schedule_checks($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
    function get_check_category_details($checkid){
         $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_check_category_details($checkid);
        return $query;
    }
    function get_scheduled_checks_products(){
            $status=false;
            $message="No scheduled products found";
            $line_number=$this->input->post('line');
            $outlet_id=DEFAULT_OUTLET;
            if(!empty($line_number)){
                 date_default_timezone_set("Asia/karachi");
                            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>$outlet_id), 'id asc','general_setting','timezones','1','1')->result_array();
                            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                                date_default_timezone_set($timezone[0]['timezones']);
                $table = $outlet_id.'_assignments';
                $where_data=array("ps_date <="=>date('Y-m-d'),"ps_end_date >="=>date('Y-m-d'),'ps_line'=>$line_number);
                $assignment_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array($table.".assign_id"=>$assign_id), $table.".assign_id desc",$table.".assign_id desc",$table,'checkid,complete_datetime,reassign_id,review_user,review_datetime,review_comments,approval_user,approval_datetime,appoval_comments,product_id,assignment_type','1','1','','','')->result_array();
                $product_schedules = $this->get_product_schedules_from_db($where_data,'ps_id desc','ps_id',DEFAULT_OUTLET,'id,ps_product,product_title,ps_line,unit_weight,shape,product_type,storage_type','1','0','','','')->result_array();
                        if(!empty($product_schedules)){
                            $status=true;
                            $message="Data fetched";
                            foreach($product_schedules as $product){
                                
                                $temp_data['productid']=$product['id'];
                                $temp_data['product_title']=$product['product_title'];
                                $temp_array[]=$temp_data;
                            }
                        }
                       
                
            }
            header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_array));
    }
}
