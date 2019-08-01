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
        parent::__construct();
    }
    function admin_login() {
        $status=false;
        $message="parameter missing";
        $username = $this->input->post('user_name');
        $password = md5($this->input->post('password')); 
        $api_key = $this->check_api_key();
        $data= array();
        if($api_key['key_status'] == true) {
            if(!empty($username) && !empty($password)) {
                $row= Modules::run('api/_get_specific_table_with_pagination',array("user_name" =>$username,"password" =>$password,"status"=>"1"),'id desc','users','id,user_name,group,outlet_id','1','1')->row();
                if($row) {
                    if(isset($row->outlet_id) && !empty($row->outlet_id)) {
                        if(isset($row->group) && !empty($row->group)) {
                            $group_status= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$row->group),'id desc',$row->outlet_id.'_groups','id,status,role','1','1')->result_array();
                            if(!empty($group_status)) {
                                if($group_status[0]['status'] == '1') {
                                    if(is_numeric($group_status[0]['role']) && $group_status[0]['role'] !='0') {
                                        $role_detail= Modules::run('api/_get_specific_table_with_pagination',array("id" =>$group_status[0]['role']),'id desc','roles','role','1','1')->result_array();
                                        if(!empty($role_detail)) {
                                            $status = true;
                                            $message = "user login successful";
                                            $data['user_id'] = $row->id; 
                                            $data['name'] = $row->user_name;
                                            $data['outlet_id'] = $row->outlet_id;
                                            $data['designation'] =strtolower( $role_detail[0]['role']);
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
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$data));
    }
    function check_api_key() {
        $key_status = false;
        $key_message = "Invalid Api Key";
        $key = $this->input->post('key');
        $key_detail = Modules::run('api/_get_specific_table_with_pagination',array("dak_key" =>$key,"dak_status"=>"1"),'dak_id desc','developer_api_key','dak_id','1','1')->num_rows();
        if($key_detail > 0)
            $key_status = true;
        $array['key_status'] = $key_status;
        $array['key_message'] = $key_message;
        return $array;
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
    
    function outlet_user_profile_update() {
        $status=false;
        $message="parameter missing";
        $user_id = $this->input->post('user_id');
        if(is_numeric($user_id) && !empty($user_id) && $user_id >0) {
            $user=Modules::run('api/get_specific_table_data',array("id"=>$user_id,"status"=>"1"),"id desc","user_name,user_image","users","1","1")->result_array();
            if(!empty($user)) {
                $data = $this->get_user_post_data();
                if(isset($_FILES['user_image'])) {
                    if ($_FILES['user_image']['size'] > 0) {
                        if(isset($user[0]['user_image']) && !empty($user[0]['user_image']))
                            Modules::run("api/delete_images_by_name",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$user[0]['user_image']);
                        Modules::run("api/upload_dynamic_image",ACTUAL_OUTLET_USER_IMAGE_PATH,LARGE_OUTLET_USER_IMAGE_PATH,MEDIUM_OUTLET_USER_IMAGE_PATH,SMALL_OUTLET_USER_IMAGE_PATH,$user_id,'user_image','user_image','id','users');
                        $status=true;
                        $message="user image update";
                    } 
                }
                Modules::run('api/update_specific_table',array("id"=>$user_id),$data,'users');
                $status = true;
                $message = "user profile update";
            }
            else
                $message = "Opps! user data not found";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));
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
    
    
    function admin_password_code_verification() {
        $status = false;
        $message="Please fill the code.";
        $code = $this->input->post("code");
        $checking = array();
        if(isset($code) && !empty($code)) {
            $checking = Modules::run('api/_get_specific_table_with_pagination',array("verification_code" =>$code), 'id asc','users','user_name,email,outlet_id,code_datetime','1','1')->result_array();
            if(!empty($checking)) {
                if(isset($checking[0]['outlet_id']) && !empty($checking[0]['outlet_id']) && is_numeric($checking[0]['outlet_id']) && $checking[0]['outlet_id'] >0 ) {
                    $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$checking[0]['outlet_id']),'id desc','general_setting','timezones')->result_array();
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
                            $message = "TimeZone is not specified by the restaurant.";
                    }
                    else
                        $message = "TimeZone is not specified by the restaurant.";

                    unset($checking[0]['outlet_id']);
                    unset($checking[0]['user_name']);
                }
                else
                    $message = "Sorry now you are not be a part of any restaurant.";
            }
            else
                $message = "Invalid verificaiton code.";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message,"data"=>$checking));
    }

    function admin_verification_password_update() {
        $status = false;
        $message="Please fill the code.";
        $email = $this->input->post("email");
        $new_password = $this->input->post("new_password");
        $confirm_password = $this->input->post("confirm_password");
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
                    $message = "Sorry now you are not be a part of any restaurant.";
            }
            else
                $message = "User does not exist";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status" => $status, "message" => $message));
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

    function get_user_post_data() {
        $data['first_name'] = $this->input->post('first_name');
        $data['last_name'] = $this->input->post('last_name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['country'] = $this->input->post('country');
        $data['state'] = $this->input->post('state');
        $data['city'] = $this->input->post('city');
        $data['address1'] = $this->input->post('address');
        $data['gender'] = $this->input->post('gender');
        return $data;
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
        
}