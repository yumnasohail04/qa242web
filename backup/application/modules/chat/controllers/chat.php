<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends MX_Controller
{

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');
}

        function index() {
            $data['limit'] = '20';
            $user_id = "0";
            if(isset($this->session->userdata['user_data']['user_id']) && !empty($this->session->userdata['user_data']['user_id']))
                $user_id = $this->session->userdata['user_data']['user_id'];
            $left_panel = array();
            $user_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$user_id,"outlet_id" =>DEFAULT_OUTLET,"status"=>"1"),'id desc','users','group,second_group,first_name,last_name,user_image','1','1')->result_array();
            $default_checking = true;
            $data['user_name'] = "N/A";
            $data['user_image'] = STATIC_FRONT_IMAGE. "user.png";
            if(!empty($user_detail)) {
                $first_name = "";
                if(isset($user_detail[0]['first_name']) && !empty($user_detail[0]['first_name'])) 
                    $first_name=$user_detail[0]['first_name'];
                $second_name = "";
                if(isset($user_detail[0]['last_name']) && !empty($user_detail[0]['last_name'])) 
                    $second_name=$user_detail[0]['last_name'];
                $data['user_name']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                $user_image = "user.png";
                if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image']))
                    $user_image=$user_detail[0]['user_image'];
                $user_image=  Modules::run('api/string_length',$user_image,'8000','');
                $data['user_image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                $primary_group = '0';
                if(isset($user_detail[0]['group']) && !empty($user_detail[0]['group'])) {
                    $primary_group = $user_detail[0]['group'];
                    $temp['id'] = $user_detail[0]['group'];
                    $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_detail[0]['group']),'id desc','id',DEFAULT_OUTLET.'_groups','group_title','1','0','','','')->result_array();
                    $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                    $temp['trackig_id'] = 'G_'.$user_detail[0]['group'];
                    $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$user_detail[0]['group']), 'chat_id desc','chat_id',DEFAULT_OUTLET,'message,chat_id','1','1','','','')->result_array();
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
                        $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$user_detail[0]['second_group']),'id desc','id',DEFAULT_OUTLET.'_groups','group_title','1','0','','','')->result_array();
                        $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                        $temp['trackig_id'] = 'G_'.$user_detail[0]['second_group'];
                        $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$user_detail[0]['second_group']), 'chat_id desc','chat_id',DEFAULT_OUTLET,'message,chat_id','1','1','','','')->result_array();
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
                $group_chat = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("group_id !="=>'0'), 'chat_id desc','group_id',DEFAULT_OUTLET.'_chat_detail','group_id','1','0','(`message_to` = "'.$user_id.'" OR `message_from` = "'.$user_id.'")','(`group_id` != "'.$primary_group.'" AND `group_id` != "'.$secondry_group.'")','')->result_array();
                if(!empty($group_chat)) {
                    foreach ($group_chat as $key => $gc):
                        $temp['id'] = $gc['group_id'];
                        $group_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$gc['group_id']),'id desc','id',DEFAULT_OUTLET.'_groups','group_title','1','0','','','')->result_array();
                        $temp['name'] = ""; if(isset($group_detail[0]['group_title']) && !empty($group_detail[0]['group_title'])) $temp['name']=$group_detail[0]['group_title']; $temp['name']=  Modules::run('api/string_length',$temp['name'],'8000','');
                        $temp['trackig_id'] = 'G_'.$user_detail[0]['second_group'];
                        $group_message = Modules::run('admin_api/get_chat_detail',array("group_id"=>$gc['group_id']), 'chat_id desc','group_id',DEFAULT_OUTLET,'message,chat_id','1','1','','','')->result_array();
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
                $group_users= Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id" =>DEFAULT_OUTLET,"status"=>"1",'id !='=>$user_id),'id desc','id','users','id,first_name,last_name,user_image,is_online','1','0','','','')->result_array();
            /*(`group` = "'.$primary_group.'" OR `group` = "'.$secondry_group.'" OR `second_group` = "'.$primary_group.'" OR `second_group` = "'.$secondry_group.'")*/    
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
                        $last_detail = Modules::run('admin_api/get_chat_detail',array("group_id"=>'0'), 'chat_id desc','chat_id',DEFAULT_OUTLET,'message,chat_id','1','1','((`message_to` = "'.$user_id.'" AND `message_from` = "'.$gc['id'].'") OR (`message_to` = "'.$gc['id'].'" AND `message_from` = "'.$user_id.'"))','','')->result_array();
                        $temp['last_message'] = "";
                        if(isset($last_detail[0]['message']) && !empty($last_detail[0]['message']))
                            $temp['last_message']=$last_detail[0]['message'];
                        $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                        $temp['last_chat'] = "0";
                        if(isset($last_detail[0]['chat_id']) && !empty($last_detail[0]['chat_id'])) 
                            $temp['last_chat']=$last_detail[0]['chat_id'];
                        $pre_temp['last_message'] = $temp['last_message'];
                        $pre_temp['type'] = $temp['type'] = 'user';
                        $user_image = "user.png"; if(isset($gc['user_image']) && !empty($gc['user_image'])) $user_image=$gc['user_image']; $user_image=  Modules::run('api/string_length',$user_image,'8000','');

                        $pre_temp['image'] = $temp['image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                        $pre_temp['next_chat'] = $temp['next_chat'] = true;
                        $pre_temp['is_online'] = $temp['is_online'] = false;
                        if(isset($gc['is_online']) && !empty($gc['is_online'])) 
                            $pre_temp['is_online'] = $temp['is_online'] = true;
                        $left_panel[] = $temp;
                        $previous_user[] = $pre_temp;
                        unset($temp);
                    endforeach;
                }
                /*$and_where = "";
                $or_where = "";
                if(!empty($previous_user)) {
                    foreach ($previous_user as $key => $pu):
                        if(isset($pu['user_id']) && !empty($pu['user_id']))
                            $temp_array[]= $pu['user_id'];
                    endforeach;
                    if(isset($temp_array) && !empty($temp_array)) {
                        $and_where = Modules::run('admin_api/get_and_where',$temp_array,'message_to!');
                        $or_where = Modules::run('admin_api/get_and_where',$temp_array,'message_from!');
                        if(!empty($or_where))
                            $or_where = "AND ".$or_where;
                    }
                }
                $group_chat = Modules::run('admin_api/get_chat_detail',array("group_id"=>'0'), 'chat_id desc','message_to,message_from',DEFAULT_OUTLET,'message_to,message_from,chat_detail.message_id,message,chat_id','1','0','(`message_to` = "'.$user_id.'" OR `message_from` = "'.$user_id.'")'.$or_where,$and_where,'')->result_array();
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
                                    $pre_temp['name'] = $temp['name']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                    if($user_id > $gc['message_to'])
                                        $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$user_id.'_'.$gc['message_to'];
                                    else
                                        $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$gc['message_to'].'_'.$user_id;
                                    $temp['last_message'] = ""; if(isset($gc['message']) && !empty($gc['message'])) $temp['last_message']=$gc['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                                    $temp['last_chat'] = "0";
                                    if(isset($gc['chat_id']) && !empty($gc['chat_id'])) 
                                        $temp['last_chat']=$gc['chat_id'];
                                    $pre_temp['last_message'] = $temp['last_message'];
                                    $pre_temp['type'] = $temp['type'] = 'user';
                                    $user_image = "user.png"; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $user_image=$user_detail[0]['user_image']; $user_image=  Modules::run('api/string_length',$user_image,'8000','');

                                    $pre_temp['image'] = $temp['image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                                    $pre_temp['next_chat'] = $temp['next_chat'] = true;
                                    if(isset($user_detail[0]['is_online']) && !empty($gc['is_online'])) 
                                        $pre_temp['is_online'] = $temp['is_online'] = true;
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
                                    $pre_temp['name'] = $temp['name']=  Modules::run('api/string_length',$first_name,'8000','',$second_name);
                                    if($user_id > $gc['message_from'])
                                        $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$user_id.'_'.$gc['message_from'];
                                    else
                                        $pre_temp['trackig_id'] = $temp['trackig_id'] = 'U_'.$gc['message_from'].'_'.$user_id;
                                    $temp['last_message'] = ""; if(isset($gc['message']) && !empty($gc['message'])) $temp['last_message']=$gc['message']; $temp['last_message']=  Modules::run('api/string_length',$temp['last_message'],'8000','');
                                    $temp['last_chat'] = "0";
                                    if(isset($gc['chat_id']) && !empty($gc['chat_id'])) 
                                        $temp['last_chat']=$gc['chat_id'];
                                    $pre_temp['last_message'] = $temp['last_message'];
                                    $pre_temp['type'] = $temp['type'] = 'user';
                                    $user_image = "user.png"; if(isset($user_detail[0]['user_image']) && !empty($user_detail[0]['user_image'])) $user_image=$user_detail[0]['user_image']; $user_image=  Modules::run('api/string_length',$user_image,'8000','');

                                    $pre_temp['image'] = $temp['image'] = Modules::run('api/image_path_with_default',ACTUAL_OUTLET_USER_IMAGE_PATH,$user_image,STATIC_FRONT_IMAGE,'user.png');
                                    $pre_temp['next_chat'] = $temp['next_chat'] = true;
                                    $pre_temp['next_chat'] = $temp['next_chat'] = true;
                                    if(isset($user_detail[0]['is_online']) && !empty($gc['is_online'])) 
                                        $pre_temp['is_online'] = $temp['is_online'] = true;
                                    $left_panel[] = $temp;
                                    $previous_user[] = $pre_temp;
                                    unset($temp);
                                }
                            }
                        }
                    endforeach;
                }*/
            }
            $data['chat_css'] = "chat_css";
            $data['left_panel'] = $left_panel;
            $data['view_file'] = 'chat_listing';
            $this->load->module('template');
            $this->template->admin($data);
        }

        function get_chat_messages() {
            $limit = $this->input->post('limit');
            if(empty($limit))
                $limit = 20;            
            $page_number = $this->input->post('page_number');
            if(empty($page_number))
                $page_number = 1;
            $lastcheater = $this->input->post('lastcheater');
            if(empty($lastcheater))
                $lastcheater = 0;
            $data['lastcheater'] = $lastcheater;
            $chating = $this->input->post('chating');
            $data['page_number'] = $page_number;
            $data['limit'] = $limit;
            $chating = $this->input->post('chating');
            $cheatertype = $this->input->post('cheatertype');
            if($cheatertype =='group') {
                $data['chat_detail'] = Modules::run('admin_api/get_chat_detail',array("group_id"=>$chating,'chat_id <='=>$lastcheater),'chat_id desc','group_id,chat_detail.message_id',DEFAULT_OUTLET,'chat_id,message_to,message_from,message_datetime,message',$page_number,$limit,'','','')->result_array();
            }
            elseif($cheatertype =='user') {
                $data['chat_detail'] = Modules::run('admin_api/get_chat_detail',array("group_id"=>'0','chat_id <='=>$lastcheater),'chat_id desc','chat_id',DEFAULT_OUTLET,'chat_id,message_to,message_from,message_datetime,message',$page_number,$limit,'((`message_to` = "'.$this->session->userdata['user_data']['user_id'].'" AND `message_from` = "'.$chating.'") OR (`message_to` = "'.$chating.'" AND `message_from` = "'.$this->session->userdata['user_data']['user_id'].'"))','','')->result_array();
            }
            else
                $data['chat_detail'] = array();
            $this->load->view('append_chat',$data);
        }
        function store_message() {
            $status = false;
            $api_message = "Something went wrong";
            $chat_id = 0;
            date_default_timezone_set("Asia/karachi");
            $timezone = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id" =>DEFAULT_OUTLET), 'id asc','general_setting','timezones','1','1')->result_array();
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                date_default_timezone_set($timezone[0]['timezones']);
            $createdat = date("Y-m-d H:i:s");
            $chating = $this->input->post('chating');
            $cheatertype = $this->input->post('cheatertype');
            $message = $this->input->post('message');
            $name = "";
            $user_image = STATIC_FRONT_IMAGE.'user.png';
            if(!empty($message) && !empty($cheatertype) && !empty($cheatertype)) {
                $status = true;
                $api_message = "Message Send";
                $message_id = Modules::run('api/insert_into_specific_table',array("message"=>$message),DEFAULT_OUTLET.'_messages');
                if($cheatertype == 'user') {
                    $chat_id = Modules::run('api/insert_into_specific_table',array("message_to"=>$chating,"message_from"=>$this->session->userdata['user_data']['user_id'],"message_id"=>$message_id,"message_datetime"=>$createdat,"group_id"=>"0"),DEFAULT_OUTLET.'_chat_detail');
                }
                elseif($cheatertype == 'group') {
                    $group_users = Modules::run('api/_get_specific_table_with_pagination_and_where',array('status'=>'1'),'id desc','users','id','1','0','(`second_group`="'.$chating.'" or `group`="'.$chating.'")','','')->result_array();
                    if(!empty($group_users)) {
                        foreach ($group_users as $key => $gu):
                            $chat_id = Modules::run('api/insert_into_specific_table',array("message_to"=>$gu['id'],"message_from"=>$this->session->userdata['user_data']['user_id'],"message_id"=>$message_id,"message_datetime"=>$createdat,"group_id"=>$chating),DEFAULT_OUTLET.'_chat_detail');
                        endforeach;
                    }
                }
                else
                    echo "";
                $user_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$this->session->userdata['user_data']['user_id']),'id desc','id','users','first_name,last_name,user_image','1','1','','','')->result_array();
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
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $api_message, "chat_id" => $chat_id, "chat_id" => $chat_id, "createdAt" => $createdat, "text" => $message, "user_id" => $this->session->userdata['user_data']['user_id'], "user_name" => $name, "user_image" => $user_image));
        }
}