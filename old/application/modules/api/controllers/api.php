<?php

/* * ***********************************************
  Created By: Tahir Mehmood
  Dated: 28-09-2016
 * *********************************************** */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Api extends MX_Controller {

    protected $data = '';

    function __construct() {
        date_default_timezone_set('Asia/Karachi');
        $this->lang->load('english', 'english');
        parent::__construct();
    }
                                                                                                                
    function user_login_action() {
        $phone = $this->input->post('phone', TRUE);
        $password = $this->input->post('password', TRUE);
        $locations = $this->input->post('location');
        $locations = json_decode($locations);
        $fcmtoken = $this->input->post('fcm_token'); 
        if((isset($phone) && !empty($phone)) && (isset($password) && !empty($password))){
            $where_check['phone'] = $phone;
            $where_check['password'] = Modules::run('site_security/make_hash', $password);
            $response = new \stdClass();
            $response->is_verified = false;
            $query = Modules::run('customers/_get_by_arr_id_for_login', $where_check);
            if ($query->num_rows() > 0) {
               $data = array();
                $customer_id=0;
                foreach ($query->result() as $row) {
                    $data['id'] = $row->id;
                    $data['name'] = $row->name;
                    $data['email'] = $row->email;
                    $data['phone'] = $row->phone;
                    $pro_image =STATIC_FRONT_IMAGE.'user.png';
                    if(isset($row->id) && !!empty($row->id) && !empty($fcmtoken))
                        $this->update_specific_table(array("id"=>$row->id),array("fcm_token"=>$fcmtoken),'users');
                    if(isset($row->cus_image) && !empty($row->cus_image)) {
                        if( file_exists(ACTUAL_CUSTOMER_IMAGE_PATH.$row->cus_image))
                            $pro_image = BASE_URL.ACTUAL_CUSTOMER_IMAGE_PATH.$row->cus_image;
                    }
                    $data['customer_image'] = $pro_image;
                    $customer_id = $row->id;
                    if($row->is_verified == 1)
                        $response->is_verified = true;
                    else {
                        $ref['verification_code'] =substr(md5(uniqid(rand(), true)), 6, 6);
                        for ($today=1; $today <70 ; $today++) { 
                            $unique_number =substr(md5(uniqid(rand(), true)), 16, 16);
                            $check_number= Modules::run('slider/_get_where_cols',array("verification_code" =>$unique_number),'id desc','customers','verification_code')->result_array();
                            if (!empty($check_number))  {
                                $ref['verification_code'] = $unique_number;
                                break;
                            }
                        }
                        $query = Modules::run('customers/_update_id_front_login', $row->id, $ref);
                        $message=" your verification code is ".$ref['verification_code'];
                        $this->send_sms_verification($data['phone'],$message);
                        $this->load->library('email');
                        $port = 465;
                        $user = "no-reply@dinehome.no";
                        $pass = "uKbW1MVIj)Hg";
                        $host = 'ssl://mail.dinehome.no';

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
                        $this->email->from($user, 'Dinehome.no');
                       
                        $this->email->to($data['email']);
                        $this->email->subject('Dinehome.no' . ' - Verification');
                        $this->email->message('<p>Dear ' . $data['name'] . ',<br><br>Thank you for Verification at ' . 'Dinehome.no and your verification code is <b>'.$ref['verification_code'] . '</b> </br>With Best Regards,<br>' . 'Dinehome.no' . 'Team');
                        $this->email->send();
                    }
                }
                $response->status = true;
                $location_data=array();
                if(!empty($locations) && is_numeric($customer_id))
                
                    foreach ($locations->Locations as $key => $loc_data) {
                       
                        $loc['customer_id']=$customer_id;
                        $loc['location_address']=$loc_data->Address;
                        $loc['location_type']=$loc_data->Type;
                        $loc['location_latitude']=$loc_data->Lat;
                        $loc['location_longitude']=$loc_data->Long;
                        $loc['country']=$loc_data->Country;
                        $loc['city']=$loc_data->City;
                        $loc['cus_area']=$loc_data->Area;
                         
                        if(isset($loc['location_address']) && !empty($loc['location_address'])  && isset($loc['location_type']) && !empty($loc['location_type']) && isset($loc['location_latitude']) && !empty($loc['location_latitude']) && isset($loc['location_longitude']) && !empty($loc['location_longitude']) && $loc['location_type']!= "43b5c9175984c071f30b873fdce0a000" ) {
                            $insert_or_update=$this->insert_or_update(array("customer_id"=>$loc['customer_id'],"location_type"=>$loc['location_type']),$loc,'customer_location');
                            $default['location_is_default']=$loc_data->Default;
                            if(!empty($default['location_is_default'])) {
                                if($default['location_is_default'] == true)
                                    $default['location_is_default']=1;
                                else
                                    $default['location_is_default'] = 0;
                                $this->insert_or_update(array("customer_id"=>$loc['customer_id']),array("location_is_default"=>'0'),'customer_location');
                                $this->insert_or_update(array("customer_id"=>$loc['customer_id'],"location_type"=>$loc['location_type']),$default,'customer_location');
                            }
                        }
                        unset($default_path);
                    }
                $temp_locations = Modules::run('slider/_get_where_cols',array("customer_id" =>$data['id'],"location_status" =>'active',"location_is_default" =>'1'),'cl-id desc','customer_location','location_is_default')->result_array();
                if(empty($temp_locations)) {
                    $temp_locations = Modules::run('slider/_get_where_cols',array("customer_id" =>$data['id'],"location_status" =>'active',"location_is_default" =>'0'),'cl-id desc','customer_location','location_is_default')->result_array();
                    $last_location =$this->_get_specific_table_with_pagination(array("customer_id" =>$data['id'],"location_status" =>'active',"location_is_default" =>'0'), 'cl-id desc','customer_location','cl-id','1','1')->result_array();
                    if(isset($last_location[0]['cl-id']) && !empty($last_location[0]['cl-id'])) 
                        $this->insert_or_update(array("cl-id"=>$last_location[0]['cl-id']),array("location_is_default"=>"1"),'customer_location');
                }
                $response->id = $data['id'];
                $response->name = $data['name'];
                if(isset($data['email']) && !empty($data['email']))
                $response->email = $data['email'];
                $response->phone = $data['phone'];
                $response->customer_image = $data['customer_image'];
                $response->message = "successfully login";
                $response->Locations = Modules::run('slider/_get_where_cols',array("customer_id" =>$data['id'],"location_status" =>'active'),'cl-id desc','customer_location','location_latitude as Lat,location_longitude,location_address as Address,location_street as Street,location_house_no as Houseno,location_type as Type,country as Country,city as City,cus_area as Area,location_is_default')->result_array();
                    $main_locations=array();
                    
                $main_locations['Status']=false;
                if(!empty($response->Locations)) {
                    $main_locations['Status']=true;
                    $temp=array();
                    foreach ($response->Locations as $key => $loc) {
                        $loc['Long']=$loc['location_longitude'];
                        if(isset($loc['location_is_default']) && !empty($loc['location_is_default'])) {
                            if($loc['location_is_default'] = '1')
                                $loc['Default'] =true;
                            else
                                $loc['Default'] = false;
                        }
                        else
                            $loc['Default'] = false;
                        unset($loc['location_is_default']);
                        $loc['Long'] = $loc['location_longitude'];
                        unset($loc['location_longitude']);
                        /*$loc=$this->replace_key($loc,'location_longitude','Long');*/
                        $temp[]=$loc;
                    }
                    $main_locations['Locations']=$temp;
                    $response->Locations=$main_locations;

                }

               } else {
                $response->status = false;
                $response->message = "Phone number or password is incorrect";
                }
                echo json_encode($response);
        } else {
            $response->status = false;
            $response->message = "Sorry something went wrong";
            echo json_encode($response);
        }
    }
    function replace_key($arr, $oldkey, $newkey) {
     if(array_key_exists( $oldkey, $arr)) {
     $keys = array_keys($arr);
         $keys[array_search($oldkey, $keys)] = $newkey;
         return array_combine($keys, $arr); 
     }
        return $arr;    
    }

    function register_user_data(){
        date_default_timezone_set('Asia/Karachi');
        $response = new \stdClass();
        $data['name'] = $this->input->post('name', TRUE);
        $data['email'] = $this->input->post('email', TRUE);
        $data['phone']=$this->input->post('phone', TRUE);
        $data['is_verified']=0;
        
        $password = $this->input->post('password', TRUE);
        $cpassword = $this->input->post('cpassword', TRUE);
        if ($password !=$cpassword) {
            $response->status = false;
            $response->message = "Password Doesn't Match";
            echo json_encode($response);exit();
        }
        $data['password'] = Modules::run('site_security/make_hash', $password);
       $where_check_username['phone'] = $data['phone'];
        
        $check_register_username = Modules::run('customers/_get_by_arr_id_for_login', $where_check_username); 

        
        if ($check_register_username->num_rows() > 0) {
            $response->status = false;
            $response->message = "User already exist";
        } else {
            $data['verification_code'] =substr(md5(uniqid(rand(), true)), 6, 6);
            for ($today=1; $today <70 ; $today++) { 
                $unique_number =substr(md5(uniqid(rand(), true)), 16, 16);
                $check_number= Modules::run('slider/_get_where_cols',array("verification_code" =>$unique_number),'id desc','customers','verification_code')->result_array();
                if (!empty($check_number))  {
                    $data['verification_code'] = $check_number;
                    break;
                }
            }
            $query = Modules::run('customers/_insert_front_login', $data);
           
            $where_id['id'] = $this->db->insert_id();
    if(!empty($data['phone'])){
            $row = Modules::run('customers/_get_by_arr_id_for_login', $where_id)->row();
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['profile_image'] = $row->cus_image;
            $data['email'] = $row->email;
            $data['phone'] = $row->phone;
            $data['address'] = $row->address;
            $ref['user_referal_code']=strtoupper(substr($row->name, 0, 2)).'00'.$row->id;
            $query = Modules::run('customers/_update_id_front_login', $row->id, $ref);
            $message=" your verification is ".$data['verification_code'];
            $this->send_sms_verification('03047548507',$message);
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
            $this->email->from($user, 'Dinehome.no');
           
            $this->email->to($data['email']);
            $this->email->subject('Dinehome.no' . ' - Registration');
            $this->email->message('<p>Dear ' . $data['name'] . ',<br><br>Thank you for registration at ' . 'Dinehome.no and your verification is '.$data['verification_code'] . '</br>With Best Regards,<br>' . 'Dinehome.no' . 'Team');
            $this->email->send();
    }
            $response->status = true;
            $response->message = "successfully registered";
            $response->userid = $data['id'];
            }

           
            
    echo json_encode($response);exit();
}

function send_sms_verification($number,$message){

    $param = array(
        'username' => 'iqbalsons',
        'password' => '123',
        'sender' => 'Iqbal Sons',
        'text' => $message,
        'type' => 'text',
        'datetime' => '2017-12-14 15:42:33',
    );
   $recipients= array('923047548507');

    $post = 'to=' . implode(';', $recipients);
    foreach ($param as $key => $val) {
        $post .= '&' . $key . '=' . rawurlencode($val);
    }
    $url = "http://sms2.amtpakistan.com/api/api_http.php";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Connection: close"));
    $result = curl_exec($ch);
    if(curl_errno($ch)) {
        $result = "cURL ERROR: " . curl_errno($ch) . " " . curl_error($ch);
    } else {
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        switch($returnCode) {
            case 200 :
                break;
            default :
                $result = "HTTP ERROR: " . $returnCode;
        }
    }
    curl_close($ch);
    


}
    function get_restaurant_list(){

    $data=array();
    $status=false;
    $result=$this->get_restaurant_data_from_db()->result_array();
    if (isset($result) && !empty($result)) {
       
        $i=0;
        foreach ($result as $key => $value) {
           $data[$i]['id']=$value['id'];
           $data[$i]['title']=$value['name'];
           $data[$i]['rating']='4.4';
           $data[$i]['time']='20-30 MIN';
           $data[$i]['tags']="#fastfood . #Burger";
           $data[$i]['featured']="Featured";
           $data[$i]['img']=BASE_URL.ACTUAL_OUTLET_IMAGE_PATH.$value['image'];
        $i=$i+1;
        }
        $status=true;
    }
    header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "items"=>$data));
}

function get_restaurant_data_from_db() {
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_restaurant_data_from_db();
            return $query;
        }
//////////////////////////////jahanzaib Dinehome business app//////////////////


    function register_restaurant(){
        $message="something went wrong";
        $status=false;
        $data['name']=$this->input->post('name');
        $data['url_slug']=str_replace(['  ', '/','--','---','----', ' '], "-", $this->input->post('name'));
        $data['phone']=$this->input->post('phone');
        $data['email']=$this->input->post('email');
        $data['country']=$this->input->post('country');
        $data['city']=$this->input->post('city');
        $data['state']=$this->input->post('state');
        $data['orgination_no']=$this->input->post('organization_no');
        $data['post_code']=$this->input->post('post_code');
        $data['address']=$this->input->post('address');
        $data['latitude']=$this->input->post('latitude');
        $data['longitude']=$this->input->post('langitude');
        if(isset($data) && !empty($data) && !empty($data['name'])){
            $outlet_id=Modules::run('outlet/_insert', $data);
            if(isset($outlet_id)&& !empty($outlet_id) && is_numeric($outlet_id)){
                Modules::run('outlet/_create_tables', $outlet_id);
                $outlet_cat=$this->get_outlet_catagory_from_post($outlet_id);
                if(isset($outlet_cat) && !empty($outlet_cat)){
                    Modules::run('outlet/_insert_outlet_catagories', $outlet_cat);
                }
                $outlet_dietaries=$this->get_outlet_dietaries_from_post($outlet_id);
                $status=true;
                $message="restaurant registered succesfully";
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "message"=>$message));
    }
    function get_outlet_catagory_from_post($id){
        $catagory=$this->input->post('restaurant_type');
        $catagory=explode(",",$catagory);
        if (isset($catagory) && !empty($catagory)) {
            $i=0;
            foreach ($catagory as $key => $value) {
               $data[$i]['outlet_id']=$id;
               $data[$i]['outlet_catagory']=$value;
                $i=$i+1;
            }
            return $data;
        }
    }
    function get_outlet_dietaries_from_post($id){
        $dietary=$this->input->post('dietary');
        $dietary=explode(",",$dietary);
        if (isset($dietary) && !empty($dietary)) {
            foreach ($dietary as $key => $value) {
               $data['od_outlet_id']=$id;
               $data['od_dietary_id']=$value;
               if(!empty($value))
                Modules::run('outlet/insert_dietary_data', $data);
               unset($data);
            }
        }
    }

function get_restaurant_catagories(){
    $status=false;
   
 $data=$this->get_outlet_types()->result_array();
        if(isset($data) && !empty($data)){
           
            $status=true;


        }
         header('Content-Type: application/json');
        echo json_encode(array("status"=>1, "catagories"=>$data));
}




 function get_outlet_types() {
            $this->load->model("mdl_perfectmodel");
            return $this->mdl_perfectmodel->get_outlet_types();
        }

 function get_country_list(){
    $status=false;

    $where['countries.status']=1;
    $result=array();
    $countries=Modules::run('countries/_get_by_arr_id',$where)->result_array();
    if(isset($countries) && !empty($countries)){
        $status=true;
        $i=0;
        foreach ($countries as $key => $value) {
            $result[$i]['id']=$value['id'];
            $result[$i]['country_name']=$value['country_name'];
             $i=$i+1;
        }
    }
    header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "data"=>$result));
  }
  function get_state_list(){
    $status=false;
    
    $where['states.status']=1;
    $where['states.country_id']=$this->input->post('country_id');
    $result=array();
    $countries=Modules::run('countries/_get_by_arr_id_states',$where)->result_array();
    if(isset($countries) && !empty($countries)){
        $status=true;
        $i=0;
        foreach ($countries as $key => $value) {
            $result[$i]['id']=$value['id'];
            $result[$i]['state_name']=$value['state_name'];
             $i=$i+1;
        }
    }
    header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "data"=>$result));
  }
  function get_cities_list(){
    $status=false;
    
    $where['cities.status']=1;
    $where['cities.state_id']=$this->input->post('state_id');
    $result=array();
    $countries=Modules::run('countries/_get_by_arr_id_cities',$where)->result_array();
    if(isset($countries) && !empty($countries)){
        $status=true;
        $i=0;
        foreach ($countries as $key => $value) {
            $result[$i]['id']=$value['id'];
            $result[$i]['city_name']=$value['city_name'];
            $$i=$i+1;
        }
    }
    header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "data"=>$result));
  }

    ///////////////////////////umar apis start/////////////////////////
        function outlet_categories_product(){
            $status=false;
            $deal_status=false;
            $message="Something went wrong";
            $outlet_id=$this->input->post('outlet_id');
            $requested_from = $this->input->post('requested_from');
            //"name, logo,backgroundimage,rating"
            ///////////////////////////umar insights start/////////////////////////
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_id=$user_location_data['user_id'];
            ///////////////////////////umar insights end/////////////////////////
            $category_data=array();
            $data=$this->get_outlet_types()->result_array();
            $product_image_path=BASE_URL. ACTUAL_ITEMS_IMAGE_PATH.$outlet_id.'/';
            $category_image_path=BASE_URL. MEDIUM_CATAGORIES_IMAGE_PATH;
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $outlet_detail = array();
            if(isset($outlet_id) && is_numeric($outlet_id)) {
                ///////////////////////////umar insights start/////////////////////////
                date_default_timezone_set("Asia/Karachi");
                $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                if(!empty($timezone)) {
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                        date_default_timezone_set($timezone[0]['timezones']);
                }
                $visited_id = $this->insert_into_specific_table(array("ua_user_id"=>$user_location_data['user_id'],"ua_outlet_id"=>$outlet_id,"ua_type"=>"visit","ua_device"=>$user_location_data['device'],"ua_datetime"=>date("Y-m-d H:i:s"),"ua_country"=>$user_location_data["Country"],"ua_city"=>$user_location_data["City"],"ua_town"=>$user_location_data["Area"]),'outlet_activity');
                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                    $this->requested_data_store('outlet_activity',$visited_id,$user_location_data);
                }
                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                    $this->requested_city_store('outlet_activity',$visited_id,$user_location_data);
                }
                ///////////////////////////umar insights end/////////////////////////
                $status=true;
                $message="category record fetched";
                $where_categories['is_active'] = 1;
                $where_categories['outlet_id'] =  $outlet_id ;
                
                $cat_data="";
                $cat_data = Modules::run('catagories/_get_by_arr_id', $where_categories,'api');
                $cat_discount=0;
                
                $cat_data = array_map("unserialize", array_unique(array_map("serialize", $cat_data)));
                if(isset($cat_data) && !empty($cat_data)) {
                    foreach ($cat_data as $key => $cat) {
                        $where_prod['products.status'] = 1;
                        $where_prod['products.category_id'] = $cat['id'];
                        $where_prod['products.outlet_id'] =  $outlet_id ;
                        $temp_pro=array();
                        $category_discount=Modules::run('slider/_get_where_cols',array("cd_cat_id" =>$cat['id']),'cd_cat_id desc', $outlet_id.'_category_discount','cd_discount')->result_array();
                        $point_slogan=Modules::run('slider/_get_where_cols',array("id" =>$outlet_id),'id desc', 'outlet','point_slogan')->result_array();
                        if(isset($point_slogan) && !empty($point_slogan))
                        $point_slogan=$point_slogan[0]['point_slogan'];
                        if(isset($category_discount) && !empty($category_discount))
                        $cat_discount=$category_discount[0]['cd_discount'];
                        $limited_cat['cat_id']= $cat['id'];
                        $limited_cat['cat_name']= $cat['cat_name'];
                        $limited_cat['product']=$product= Modules::run('catagories/_get_product_detail_with_min_value', $where_prod,$product_name='', $outlet_id= $outlet_id,"products.id as product_id,products.title as name,products.image as image,products.add_on_id as add_on_id,MIN(stock.price) as minimum_price,product_discount as discount")->result_array();
                        if(!empty($limited_cat['product']) ) {
                            ///////////////////////////umar insights start/////////////////////////
                            $project_checking = array();
                            if(isset($pro['product_id']) && !empty($pro['product_id'])) {
                                if (!in_array($pro['product_id'], $project_checking)) {
                                    $visited_id = $this->insert_into_specific_table(array("pa_user_id"=>$user_location_data['user_id'],"pa_outlet_id"=>$outlet_id,"pa_type"=>"impression","pa_device"=>$user_location_data['device'],"pa_datetime"=>date("Y-m-d H:i:s"),"pa_country"=>$user_location_data["Country"],"pa_city"=>$user_location_data["City"],"pa_town"=>$user_location_data["Area"],'pa_product_id'=>$pro['product_id']),'product_activity');
                                    if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                                        $this->requested_data_store('product_activity',$visited_id,$user_location_data);
                                    }
                                    if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                                        $this->requested_city_store('product_activity',$visited_id,$user_location_data);
                                    }
                                }
                            }
                            ///////////////////////////umar insights end/////////////////////////
                            foreach ($limited_cat['product'] as $key => $pro) {
                                $pro_image =STATIC_FRONT_IMAGE.'pattren.png';
                                if(isset($pro['image']) && !empty($pro['image'])) {
                                    if( file_exists(ACTUAL_ITEMS_IMAGE_PATH.$outlet_id.'/'.$pro['image']))
                                        $pro_image = BASE_URL.ACTUAL_ITEMS_IMAGE_PATH.$outlet_id.'/'.$pro['image'];
                                }
                                $product_discount=0;
                                $product_discount=$pro['discount']+$cat_discount;
                                if(!empty($product_discount))
                                $pro['discount']=$product_discount;
                                $pro['image'] = $pro_image;
                                $pro['favourite_status'] = '0';
                                if(isset($user_id) && is_numeric($user_id)) {
                                    $where['user_id']=$user_id;
                                    $where['product_id']=$pro['product_id'];
                                    $where['outlet_id']=$outlet_id;
                                    $favourite = $this->check_favourite_food($where)->result_array();
                                    if(isset($favourite) && !empty($favourite))
                                      $pro['favourite_status'] = '1';
                                    else
                                        $pro['favourite_status'] = '0';
                                }
                                $temp_pro[]=$pro;
                                unset($where);
                            }
                            $limited_cat['product']=$temp_pro;
                        }
                        $temp[]=$limited_cat;
                    }
                    
                    $category_data=$temp;
                }
                else
                    $message = "category record empty";
                if(isset($requested_from) && !empty($requested_from) && isset($outlet_id) && !empty($outlet_id)) {
                    $outlet = $this->_get_specific_table_with_pagination(array("id"=>$outlet_id), 'id desc','outlet',',outlet.outlet_cover_image as image,outlet.image as logo,name','1','1')->result_array();
                    if(!empty($outlet)) {
                        foreach ($outlet as $key => $out):
                            $outlet_detail['name'] = $out['name'];
                            if(isset($out['image'] ) &&!empty($out['image']) &&file_exists(ACTUAL_OUTLET_TYPE_IMAGE_PATH.$out['image'])){
                                 $outlet_detail['image'] = BASE_URL.ACTUAL_OUTLET_TYPE_IMAGE_PATH.$out['image'];
                            }
                            else{
                                $outlet_detail['image'] = STATIC_FRONT_IMAGE."pattren.png";
                            }
                             if(isset($out['logo'] ) &&!empty($out['logo']) &&file_exists(ACTUAL_OUTLET_IMAGE_PATH.$out['logo'])){
                                 $outlet_detail['logo'] = BASE_URL.ACTUAL_OUTLET_IMAGE_PATH.$out['logo'];
                            }
                            else{
                                $outlet_detail['logo'] = STATIC_FRONT_IMAGE."pattren.png";
                            }
                            $rating = $this->_get_specific_table_with_pagination(array("outlet_id"=>$outlet_id), 'id desc','reviews','AVG(reviews.rating) AS rating','1','1')->result_array();
                            $outlet_detail['rating'] = '0';
                            if(isset($rating[0]['rating']) && !empty($rating[0]['rating']))
                                $outlet_detail['rating'] = round($rating[0]['rating'], 1);
                        endforeach;
                    }
                }
            }
            
            $arr_deals=$this->get_deals_list();
            if(!empty($arr_deals))
            $deal_status=true;
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"category_data"=>$category_data,"product_image_path"=>$product_image_path,"category_image_path"=>$category_image_path,"deals_status"=>$deal_status,"deals_data"=>$arr_deals,"point_slogan"=>$point_slogan,"outlet_detail"=>$outlet_detail));
        }
        function get_areas() {
            $status=false;
            $message = "Something went wrong";
            $country_name = $this->input->post('country_name');
            $city_name = $this->input->post('city_name');
            $areas = array();
            $page_number = $this->input->post('page_number');
            $limit=$this->input->post('limit');
            if(empty($limit))
                $limit=2000;
            if(empty($page_number))
                $page_number=1;
            $total_pages=0;
            if(!empty($country_name)) {
                $status = true;
                $message = "Areas of current city";
                $or_where = "";
                $country =$this->_get_specific_table_with_pagination(array("country_name"=>strtolower($country_name)), 'c_id desc','country','country.c_id','1','0')->result_array();
                if(isset($country[0]['c_id']) && !empty($country[0]['c_id'])) {
                    $where = array('c_id'=>$country[0]['c_id'],'city_status'=>'1');
                    if(isset($city_name) && !empty($city_name))
                        $where['city_name'] = strtolower($city_name);
                    $city_data =$this->_get_specific_table_with_pagination($where, 'city_id desc','city','city.city_id','1','0')->result_array();
                    if(isset($city_data) && !empty($city_data)) {
                        foreach ($city_data as $key => $cd) {
                            if(isset($cd['city_id']) && !empty($cd['city_id']))
                                $or_where_array[] = $cd['city_id'];
                        }
                        if(isset($or_where_array) && !empty($or_where_array))
                        $or_where = Modules::run('admin_api/get_or_where',$or_where_array,'city_town_id');
                        $areas = $this->get_city_areas(array('town_status'=>'1','town_name !='=>'other'), 'town_id desc','','city_town.town_name as value,town_id as id,city_name as city',$page_number,$limit,$or_where,'','')->result_array();
                        $total_pages = $this->get_city_areas(array('town_status'=>'1','town_name !='=>'other'), 'town_id desc','','city_town.town_name as value,town_id as id,city_name as city','1','0',$or_where,'','')->num_rows();
                        $diviser=($total_pages/$limit);
                        $reminder=($total_pages%$limit);
                        if($reminder>0)
                           $total_pages=intval($diviser)+1;
                        else
                            $total_pages=intval($diviser);
                    }
                    
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=> $status, "data"=>$areas,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        function offer_like_or_dislike() {
            $status=false;
            $message = "Something went wrong";
            $offer_id = $this->input->post('offer_id');
            $user_id = $this->input->post('user_id');
            $insert_or_delete =0;
            if(!empty($offer_id) && !empty($user_id)) {
                $users =$this->_get_specific_table_with_pagination(array("id"=>$user_id), 'id desc','customers','id','1','0')->result_array();
                if(!empty($users)) {
                    $offers =$this->_get_specific_table_with_pagination(array("id"=>$offer_id), 'id desc','offers','id','1','0')->result_array();
                    if(!empty($offers)) {
                        $insert_or_delete = $this->insert_or_delete(array("lo_offer_id"=>$offer_id,"lo_user_id"=>$user_id),array("lo_offer_id"=>$offer_id,"lo_user_id"=>$user_id),'like_offers');
                        if($insert_or_delete == 0)
                            $message="Removed from your Likes";
                        else
                            $message="Added to yours Likes";
                        $status=true;
                    }
                    else
                        $message = "Invalid Offer";
                }
                else
                    $message = "Invalid User";

            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=> $status, "message"=>$message));
        }
        function offer_share() {
            $status=false;
            $message = "Something went wrong";
            $offer_id = $this->input->post('offer_id');
            $outlet_id = $this->input->post('outlet_id');
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_id=$user_location_data['user_id'];
            $insert_or_delete =0;
            if(!empty($offer_id) && !empty($outlet_id)) {
                $offers =$this->_get_specific_table_with_pagination(array("id"=>$offer_id), 'id desc','offers','id,outlet_id','1','0')->result_array();
                if(!empty($offers)) {
                    if($offers[0]['outlet_id'] == $outlet_id) {
                        date_default_timezone_set("Asia/Karachi");
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                        $this->insert_into_specific_table(array("os_user_id"=>$user_location_data['user_id'],"os_outlet_id"=>$outlet_id,"os_offer_id"=>$offer_id,"os_device"=>$user_location_data["device"],"os_datetime"=>date("Y-m-d H:i:s"),"os_country_id"=>$user_location_data["Country"],"os_city_id"=>$user_location_data["City"],"os_town_id"=>$user_location_data["Area"]),"offer_share");
                        $message="Added to share list";
                        $status=true;
                    }
                    else
                        $message="Invalid Restaurant";
                }
                else
                    $message = "Invalid Offer";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=> $status, "message"=>$message));
        }
        function product_share() {
            $status=false;
            $message = "Something went wrong";
            $product_id = $this->input->post('product_id');
            $outlet_id = $this->input->post('outlet_id');
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_id=$user_location_data['user_id'];
            if(!empty($product_id) && !empty($outlet_id)) {
                $product =$this->_get_specific_table_with_pagination(array("id"=>$product_id), 'id desc',$outlet_id.'_products','id,outlet_id','1','0')->result_array();
                if(!empty($product)) {
                    if($product[0]['outlet_id'] == $outlet_id) {
                        date_default_timezone_set("Asia/Karachi");
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                        $this->insert_into_specific_table(array("ps_user_id"=>$user_location_data['user_id'],"ps_outlet_id"=>$outlet_id,"ps_product_id"=>$product_id,"ps_device"=>$user_location_data["device"],"ps_datetime"=>date("Y-m-d H:i:s"),"ps_country_id"=>$user_location_data["Country"],"ps_city_id"=>$user_location_data["City"],"ps_town_id"=>$user_location_data["Area"]),"product_share");
                        $message="Added to share list";
                        $status=true;
                    }
                    else
                        $message="Invalid Restaurant";
                }
                else
                    $message = "Invalid Product";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=> $status, "message"=>$message));
        }
        function announcement_share() {
            $status=false;
            $message = "Something went wrong";
            $announcements_id = $this->input->post('announcements_id');
            $outlet_id = $this->input->post('outlet_id');
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_id=$user_location_data['user_id'];
            if(!empty($announcements_id) && !empty($outlet_id)) {
                $announcements =$this->_get_specific_table_with_pagination(array("id"=>$announcements_id), 'id desc','announcements','id,outlet_id','1','1')->result_array();
                if(!empty($announcements)) {
                    if($announcements[0]['outlet_id'] == $outlet_id) {
                        date_default_timezone_set("Asia/Karachi");
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                        $this->insert_into_specific_table(array("as_user_id"=>$user_location_data['user_id'],"as_outlet_id"=>$outlet_id,"as_announcements_id"=>$announcements_id,"as_device"=>$user_location_data["device"],"as_datetime"=>date("Y-m-d H:i:s"),"as_country_id"=>$user_location_data["Country"],"as_city_id"=>$user_location_data["City"],"as_town_id"=>$user_location_data["Area"]),"announcements_share");
                        $message="Added to share list";
                        $status=true;
                    }
                    else
                        $message="Invalid Restaurant";
                }
                else
                    $message = "Invalid Announcement";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=> $status, "message"=>$message));
        }
        function get_current_location($location) {
            $temp['Lat'] = $temp['Long'] = $temp['Address'] = $temp['Area'] = $temp['City'] = $temp['Country'] = $temp['Default'] = $temp['Type'] = $temp['requested_country'] = $temp['requested_city'] = $temp['requested_area'] = '';
            if(isset($location->Lat) && !empty($location->Lat))
                $temp['Lat'] = $location->Lat;
            if(isset($location->Long) && !empty($location->Long))
                $temp['Long'] = $location->Long;
            if(isset($location->Address) && !empty($location->Address))
                $temp['Address'] = $location->Address;
            if(isset($location->Country) && !empty($location->Country)) {
                $country =$this->_get_specific_table_with_pagination(array("country_name"=>strtolower($location->Country)), 'c_id desc','country','country.c_id','1','0')->result_array();
                if(isset($country[0]['c_id']) && !empty($country[0]['c_id'])) {
                    if($country[0]['c_id'] > 0)
                        $temp['Country'] = $country[0]['c_id'];
                }
                if(isset($temp['Country']) && empty($temp['Country'])) {
                    $temp['Country'] = $this->insert_into_specific_table(array("country_name"=>strtolower($location->Country)),"country");
                }
            }
            else
                $temp['Country'] = '0';
            
            if(isset($location->City) && !empty($location->City)) {
                $city_data =$this->_get_specific_table_with_pagination(array("c_id"=>$temp['Country'],"city_name"=>strtolower($location->City)),'city_id desc','city','city.city_id','1','0')->result_array();
                if(isset($city_data[0]['city_id']) && !empty($city_data[0]['city_id'])) {
                    if($city_data[0]['city_id'] > 0)
                        $temp['City'] = $city_data[0]['city_id'];
                }
                if(isset($temp['City']) && empty($temp['City'])) {
                    if(isset($location->City))
                        $temp['requested_city'] = $location->City;
                    $area_data =$this->_get_specific_table_with_pagination(array("city_name"=>'other',"c_id"=>$temp['Country']), 'city_id desc','city','city.city_id','1','0')->result_array();
                    if(isset($area_data[0]['city_id']) && !empty($area_data[0]['city_id']))
                        $temp['City'] = $area_data[0]['city_id'];
                    else
                        $temp['City'] = $this->insert_into_specific_table(array("city_name"=>'other',"c_id"=>$temp['Country']),"city");
                }
            }
            else
                $temp['City'] = '0';
            
            if(isset($location->Area) && !empty($location->Area)) {
                $area_data =$this->_get_specific_table_with_pagination(array("town_name"=>strtolower($location->Area),"city_town_id"=>$temp['City']), 'town_id desc','city_town','city_town.town_id','1','0')->result_array();
                if(isset($area_data[0]['town_id']) && !empty($area_data[0]['town_id'])) {
                    if($area_data[0]['town_id'] > 0)
                        $temp['Area'] = $area_data[0]['town_id'];
                }
                if(isset($temp['Area']) && empty($temp['Area'])) {
                    if(isset($location->Area))
                        $temp['requested_area'] = $location->Area;
                    $area_data =$this->_get_specific_table_with_pagination(array("town_name"=>'other',"city_town_id"=>$temp['City']), 'town_id desc','city_town','city_town.town_id','1','0')->result_array();
                    if(isset($area_data[0]['town_id']) && !empty($area_data[0]['town_id']))
                        $temp['Area'] = $area_data[0]['town_id'];
                    else
                        $temp['Area'] = $this->insert_into_specific_table(array("town_name"=>'other',"city_town_id"=>$temp['City']),"city_town");
                }
            }
            else
                $temp['Area'] = '0';
            if(isset($location->Default) && !empty($location->Default))
                $temp['Default'] = $location->Default;
            if(isset($location->Type) && !empty($location->Type))
                $temp['Type'] = $location->Type;
            $temp['device'] = $this->input->post('device');
            $temp['user_id'] = $this->input->post('user_id');
            $temp['deviceid'] = $this->input->post('Deviceid');
            return $temp;
        }
        function get_fvrt_count(){
            $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>5),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
           
        }
        function slider_types() {
            $page_number="";
            $page_number=$this->input->post('page_number');
            if(empty($page_number))
            $page_number=1;
            $limit=10;
            $gift_status = true;
            $status=false;
            $message="Something went wrong!";
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_lat=$user_location_data['Lat'];
            $user_long=$user_location_data['Long'];
            $user_id=$user_location_data['user_id'];
            $temp_slide_array=array();
            
            if(isset($user_lat) && is_numeric($user_lat) && isset($user_long) && is_numeric($user_long)) {
                $maxLat=$minLat=$maxLon=$minLon="";
                $distance=5.6;
                if(!empty($distance) && !empty($user_lat) && !empty($user_long)) {
                    $R="6371";
                    $maxLat = $user_lat + rad2deg($distance/$R);
                    $minLat = $user_lat - rad2deg($distance/$R);
                    $maxLon = $user_long + rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                    $minLon = $user_long - rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                }
                $where['outlet.latitude >=']=$minLat;
                $where['outlet.latitude <=']=$maxLat;
                $where['outlet.longitude >=']=$minLon;
                $where['outlet.longitude <=']=$maxLon;
                $where['outlet.status']=1;
                
                $slider_array=array();
                $catagory_array=array();
                $point_array=array();
                $where_in=array();
                $total_pages=0;
                $slider_types=$this->get_slider_types()->result_array();
                
                $total_count=$this->get_featured_outlets($where,'distance asc',$user_lat,$user_long,$page_number,'0',$where_in)->num_rows();
                $diviser=($total_count/$limit);
                $reminder=($total_count%$limit);
                if($reminder>0)
                    $total_pages=intval($diviser)+1;
                else
                    $total_pages=intval($diviser);
            
                if(isset($slider_types) && !empty($slider_types)) {
                   /* $i=1;
                    if($page_number==1){
                         $temp_slide_array[0]['type']='ad';
                    $temp_slide_array[0]['image']="https://storage.googleapis.com/news-photo/1528703747_GuFlPj_Campaign-Still-2.jpg";
                    }
                    else{
                         $i=0;
                    }*/
                   $i=0;  $j=0;
                    foreach ($slider_types as $key => $row_slider) {
                        if ($row_slider['st_name']=='catagories' && $page_number==1) {
                          $catagory_array=$this->get_outlet_catagories($where);
                          if(!empty($catagory_array)){
                          $temp_slide_array[$i]['type']='catagories';
                          $temp_slide_array[$i]['data']=$catagory_array;
                          }
                        }
                        elseif ($row_slider['st_name']=='slider' && $page_number==1 && $total_count>5 ) {
                            $page_number=$this->input->post('page_number');
                            $page_number=1;
                            if(isset($page_number) && $page_number==1 ){
                                $slider_array=$this->get_outlet_slider_array($where,$user_lat,$user_long,$where_in,$user_id);
                                $where_in=$this->get_outlet_ids_from_array($slider_array,'slider');
                                if(!empty($slider_array)){
                                    $temp_slide_array[$i]['type']='slider';
                                $temp_slide_array[$i]['data']=$slider_array;
                                // $temp_slide_array[]=$slider_array;
                                }
                            }
                        }
                        elseif ($row_slider['st_name']=='point') {
                            $point_array=$this->get_outlet_point_array($where,$user_lat,$user_long,$where_in,$user_id);
                       
                            $where_in=$this->get_outlet_ids_from_array($point_array,'point');
                            /* $temp_slide_array[$i]['type']='point';
                            $temp_slide_array[$i]['data']=$point_array;*/
                            if($i==0)
                                $j=1;
                            if (isset($point_array) && !empty($point_array)) 
                                foreach ($point_array as $key => $row) {
                                    $temp_slide_array[$i]=$row;
                                    $i= $i+1;
                                }
                        }
                         if($j==0)
                        $i= $i+1;
                    }
                }
            }
            if($total_count>0){
                $status=true;
                $message="Record fetched successfully";
            }
            ///////////////////////////umar insights start/////////////////////////
            if(isset($user_location_data['deviceid']) && !empty($user_location_data['deviceid']) && isset($user_location_data['Type']) && !empty($user_location_data['Type'])) {
                $this->insert_or_update(array("acd_customer_id"=>$user_location_data['deviceid'],'acd_type'=>$user_location_data['Type']),array("acd_customer_id"=>$user_location_data['deviceid'],"acd_location_address"=>$user_location_data['Address'],"acd_city"=>$user_location_data['City'],"acd_country"=>$user_location_data['Country'],'acd_area'=>$user_location_data['Area'],"acd_location_latitude"=>$user_location_data['Lat'],"acd_location_longitude"=>$user_location_data['Long'],'acd_type'=>$user_location_data['Type']),'app_customers');
            }
            $zone_count = 1;
            date_default_timezone_set("Asia/Karachi");
            if(!empty($temp_slide_array)) {
                foreach ($temp_slide_array as $key => $tsa) {
                    if(isset($tsa['type']) && !empty($tsa['type'])) {
                        if($tsa['type'] == 'slider' || $tsa['type'] == 'point') {
                            if(isset($tsa['data']) && !empty($tsa['data'])) {
                                foreach ($tsa['data'] as $key => $data_val):
                                    if(isset($data_val['id']) && !empty($data_val['id'])) {
                                        if($zone_count ==1) {
                                            $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$data_val['id']),'id desc','general_setting','timezones')->result_array();
                                            if(!empty($general_setting))
                                                date_default_timezone_set($general_setting[0]['timezones']);
                                        }
                                        $impression_id = $this->insert_into_specific_table(array("ua_user_id"=>$user_location_data['user_id'],"ua_outlet_id"=>$data_val['id'],"ua_type"=>"impression","ua_device"=>$user_location_data["device"],"ua_datetime"=>date("Y-m-d H:i:s"),"ua_country"=>$user_location_data["Country"],"ua_city"=>$user_location_data["City"],"ua_town"=>$user_location_data["Area"]),"outlet_activity");
                                        if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                                            $this->requested_data_store('outlet_activity',$impression_id,$user_location_data);
                                        }
                                        if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                                            $this->requested_city_store('outlet_activity',$impression_id,$user_location_data);
                                        }
                                    }
                                endforeach;
                            }
                        }
                    }
                }
            }
            $locations = json_decode($this->input->post('user_location_data'));
            if(isset($location->City) && !empty($location->City) && isset($location->Country) && !empty($location->Country) && isset($user_location_data['user_id']) && !empty($user_location_data['user_id'])) {
                $country = strtolower($location->Country);
                $city = strtolower($location->City);
                $offers_list = $this->_get_offers_table_with_pagination(array("end_date >="=>date('Y-m-d'),'status'=>'1','start_date <='=>date('Y-m-d'),'outlet.country'=>$country,'outlet.city'=>$city), 'id asc','offers','offers.id,offers.outlet_id,offers.start_date,offers.end_date,outlet.name as outlet_name,outlet.image as logo,offers.offer_title,offer_description,offer_discount,offer_image,offers.offer_url as share_url','1','0')->result_array();
                if(!empty($offers_list)){
                    foreach ($offers_list as $key => $off):
                        if(isset($off['id']) && !empty($off['id'])) {
                            if(isset($off['outlet_id']) && !empty($off['outlet_id'])) {
                                if(isset($user_location_data['user_id']) && !empty($user_location_data['user_id'])) {
                                    $offer_activity = $this->_get_specific_table_with_pagination(array('oa_offer_id'=>$off['id'],'oa_user_id'=>$user_location_data["user_id"],'oa_outlet_id'=>$off['outlet_id']), 'oa_id desc','offers_activity','oa_id','1','0')->result_array();
                                    if(!empty($offer_activity)) {
                                        $gift_status = false;
                                        break;
                                    }
                                }
                            }
                        }
                    endforeach;
                }
                if($gift_status == true) {
                    $announcements = $this->_get_offers_table_with_pagination(array("end_date >="=>date('Y-m-d'),'status'=>'1'), 'id asc','announcements',' id','1','0')->result_array();
                    if(!empty($announcements)) {
                        foreach ($announcements as $key => $anu):
                            $announcements_activity = $this->_get_specific_table_with_pagination(array('aa_anouncement_id'=>$anu['id'],'aa_user_id'=>$user_location_data["user_id"]), 'aa_id desc','announcements_activity','aa_id','1','0')->result_array();
                            if(!empty($announcements_activity)) {
                                $gift_status = false;
                                break;
                            }
                        endforeach;
                    }
                }
                if($gift_status == true) {
                    $products = $this->get_trending_products_from_db(array("country"=>$country,'city'=>$city,'status'=>'1'),$page_number,$limit)->result_array();
                    if(!empty($products)) {
                        foreach ($products as $key => $pro):
                            $product_activity = $this->_get_specific_table_with_pagination(array('pa_product_id'=>$pro['product_id'],'pa_user_id'=>$user_location_data["user_id"],'pa_outlet_id'=>$pro['outlet_id']), 'pa_id desc','product_activity','pa_id','1','0')->result_array();
                            if(!empty($product_activity)) {
                                $gift_status = false;
                                break;
                            }
                        endforeach;
                    }
                }
            }
            ///////////////////////////umar insights end/////////////////////////
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_slide_array,"device"=>$_SERVER['HTTP_USER_AGENT'],"page_number"=>$page_number,"total_pages"=>$total_pages,'gift_status'=>$gift_status));
        }
        function requested_data_store($type="",$type_id="",$user_location_data) {
            if(!empty($user_location_data) && !empty($type) && !empty($type_id)) {
                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                    $this->insert_into_specific_table(array("rt_name"=>strtolower($user_location_data["requested_area"]),"rt_type"=>$type,"type_id"=>$type_id,'rt_city'=>$user_location_data["City"]),"requested_town");
                }
            }
        }
        function requested_city_store($type="",$type_id="",$user_location_data) {
            if(!empty($user_location_data) && !empty($type) && !empty($type_id)) {
                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                    $this->insert_into_specific_table(array("rc_name"=>strtolower($user_location_data["requested_city"]),"rc_type"=>$type,"type_id"=>$type_id,'rc_country'=>$user_location_data["Country"]),"requested_city");
                }
            }
        }
        function get_outlet_ids_from_array($outlet_array,$Type=''){
            $outlet_ids=array();
            if(isset($outlet_array) && !empty($outlet_array)) {
                foreach ($outlet_array as $key => $row) {
                    $outlet_ids[]=$row['id'];
                }
            }
            return $outlet_ids;
        }
        function get_outlet_slider_array($where,$user_lat,$user_long,$where_in,$user_id){
            $page_number=$this->input->post('page_number');
            if(!is_numeric($page_number))
            $page_number = 1;
            $limit = 5;
            $total_pages=0;
            
            $rec_outlets=$this->get_featured_outlets($where,'distance asc',$user_lat,$user_long,$page_number,$limit,$where_in)->result_array();
         
            $arr_data=array();
            if(isset($rec_outlets) && !empty($rec_outlets)){
                foreach ($rec_outlets as $key => $value) {
                     $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$value['outlet_id']),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
                     $arr_data['id']=$value['outlet_id'];
                     $arr_data['name']=$value['name'];
                    if(isset($value['image'] ) &&!empty($value['image']) &&file_exists(ACTUAL_OUTLET_TYPE_IMAGE_PATH.$value['image'])){
                         $arr_data['image']=BASE_URL.ACTUAL_OUTLET_TYPE_IMAGE_PATH.$value['image'];
                    }
                    else{
                        $arr_data['image']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                     if(isset($value['logo'] ) &&!empty($value['logo']) &&file_exists(ACTUAL_OUTLET_IMAGE_PATH.$value['logo'])){
                         $arr_data['logo']=BASE_URL.ACTUAL_OUTLET_IMAGE_PATH.$value['logo'];
                    }
                    else{
                        $arr_data['logo']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                    $arr_data['rating']="0.0";
                     if($value['rating']!=null && !empty($value['rating']))
                     $arr_data['rating']=round($value['rating'],1);
                     if(!empty($value['delivery_time']))
                      $arr_data['deliverytime']=$value['delivery_time'].' Mins';
                        if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                     $arr_data['followers']=$follewers[0]['followers'];
                     $follewers="";
                     if(isset($value['outlet_slogan']) && !empty($value['outlet_slogan']))
                     $arr_data['featured']=$value['outlet_slogan'];
                     else
                     $arr_data['featured']='featured';
                   // $arr_data['Type']='slider';
                     $time=$this->outlet_open_close($value['outlet_id']);
                  if($time=="Closed")
                        $arr_data['open_close']=$time;
                       $cat=$this->get_restaurant_categories($value['outlet_id']);
                    if(!empty($cat))
                    $arr_data['catagories']=$cat;
                     $arr_data['followstatus']=$this->check_favourite_outlet($user_id,$value['outlet_id']);
                    $arr_catagories[]=$arr_data;
                }
               
                
             return $arr_catagories;
         }
        }
       function get_outlet_point_array($where,$user_lat,$user_long,$where_in,$user_id){
            $page_number=$this->input->post('page_number');
           
            if(!is_numeric($page_number))
            $page_number = 1;
            $limit = 10;
            $total_pages=0;
            $rec_outlets=$this->get_featured_outlets($where,'distance asc',$user_lat,$user_long,$page_number,$limit,$where_in)->result_array();
            $arr_data=array();
            if(isset($rec_outlets) && !empty($rec_outlets)){
                $j=0;
                foreach ($rec_outlets as $key => $value) {
                  
                    if($j==3){
                        $where_add=array();
                        $ads_data=$this->get_ads_outlet($where,$where_add,$user_id);
                        if(!empty($ads_data)){
                            $arr_catagories[]=$ads_data;
                            $where_add=array_column($ads_data, 'id');
                            unset($ads_data);
                              $j=0;
                        }
                        
                       
                    }
                       
                    unset($arr_data);
                 $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$value['outlet_id']),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
                    $arr_data['id']=$value['outlet_id'];
                    $arr_data['name']=$value['name'];
                   if(isset($value['image'] ) &&!empty($value['image']) &&file_exists(ACTUAL_OUTLET_TYPE_IMAGE_PATH.$value['image'])){
                         $arr_data['image']=BASE_URL.ACTUAL_OUTLET_TYPE_IMAGE_PATH.$value['image'];
                    }
                    else{
                        $arr_data['image']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                     if(isset($value['logo'] ) &&!empty($value['logo']) &&file_exists(ACTUAL_OUTLET_IMAGE_PATH.$value['logo'])){
                         $arr_data['logo']=BASE_URL.ACTUAL_OUTLET_IMAGE_PATH.$value['logo'];
                    }
                    else{
                        $arr_data['logo']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                    $arr_data['type']='point';
                     $arr_data['rating']="0.0";
                    if($value['rating']!=null && !empty($value['rating']))
                     $arr_data['rating']=round($value['rating'],1);
                     if(!empty($value['delivery_time']))
                      $arr_data['deliverytime']=$value['delivery_time'].' Mins';
                      $total_discount=$value['discount']+$value['percentage'];
                      if(!empty($total_discount))
                      $arr_data['discount']=$total_discount;

                     
                     if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                     $arr_data['followers']=$follewers[0]['followers'];
                     $follewers="";
                     if(isset($value['outlet_slogan']) && !empty($value['outlet_slogan']))
                     $arr_data['featured']=$value['outlet_slogan'];
                     else
                     $arr_data['featured']='featured';
                    $time=$this->outlet_open_close($value['outlet_id']);

                  if($time=="Closed")
                        $arr_data['open_close']=$time;
                    $cat=$this->get_restaurant_categories($value['outlet_id']);
                    if(!empty($cat))
                    $arr_data['catagories']=$cat;
                     $arr_data['followstatus']=$this->check_favourite_outlet($user_id,$value['outlet_id']);
                    $arr_catagories[]=$arr_data;
                      $j=$j+1;
                }
            
             return $arr_catagories;
            }
           
        }
        /////////////////////Ads oultet/////////////
        function get_ads_outlet($where,$where_in,$user_id){
            $where_in='';
            $arr_data=array();
            date_default_timezone_set("Asia/Karachi");
            
                
            $where['ads_outlet.start_date <=']=date('Y-m-d');
            $where['ads_outlet.end_date >=']=date('Y-m-d');
            $where['ads_outlet.status']=1;
            $arr_outlet=$this->get_ads_outlet_from_db($where,$where_in)->result_array();
            foreach ($arr_outlet as $key => $value) {
               $arr_data['type']='ad';
               $arr_data['id']=$value['outlet_id'];
               $arr_data['name']=$value['name'];
               if(isset($value['ads_image']) && !empty($value['ads_image']) && file_exists(ACTUAL_ADS_OUTLET_IMAGE_PATH.$value['ads_image']))
                $arr_data['ads_image']=BASE_URL.ACTUAL_ADS_OUTLET_IMAGE_PATH.$value['ads_image'];
                else
                $arr_data['ads_image']=BASE_URL.ACTUAL_ADS_OUTLET_IMAGE_PATH.$value['image'];
                 if(isset($value['image'] ) &&!empty($value['image']) &&file_exists(ACTUAL_OUTLET_TYPE_IMAGE_PATH.$value['image'])){
                         $arr_data['image']=BASE_URL.ACTUAL_OUTLET_TYPE_IMAGE_PATH.$value['image'];
                    }
                    else{
                        $arr_data['image']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                     if(isset($value['logo'] ) &&!empty($value['logo']) &&file_exists(ACTUAL_OUTLET_IMAGE_PATH.$value['logo'])){
                         $arr_data['logo']=BASE_URL.ACTUAL_OUTLET_IMAGE_PATH.$value['logo'];
                    }
                    else{
                        $arr_data['logo']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                     $arr_data['rating']="0.0";
                    if($value['rating']!=null && !empty($value['rating']))
                     $arr_data['rating']=round($value['rating'],1);
                     if(!empty($value['delivery_time']))
                      $arr_data['deliverytime']=$value['delivery_time'].' Mins';
                      $total_discount=$value['discount']+$value['percentage'];
                      if(!empty($total_discount))
                      $arr_data['discount']=$total_discount;

                     
                     if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                     $arr_data['followers']=$follewers[0]['followers'];
                     $follewers="";
                     if(isset($value['outlet_slogan']) && !empty($value['outlet_slogan']))
                     $arr_data['featured']=$value['outlet_slogan'];
                     else
                     $arr_data['featured']='featured';
                     $arr_data['followstatus']=$this->check_favourite_outlet($user_id,$value['outlet_id']);

                    
            }
            return $arr_data;
        }
        function get_ads_outlet_from_db($where,$where_in){
             $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_ads_outlet_from_db($where,$where_in);
        }
        
         function get_outlet_catagories($where){
            $where['catagories.is_home']=1;
            $where['catagories.parent_id']=0;
            $temp_arr=array();
            $catagories=$this->get_outlet_catagories_db($where)->result_array();
            if(isset($catagories) && !empty($catagories)){
                 $i=0;
                foreach ($catagories as $key => $value) {
                    $arr_data[$i]['id']=$value['id'];
                    $arr_data[$i]['name']=$value['cat_name'];

                       if(isset($value['image']) && !empty($value['image']) && file_exists(ACTUAL_CATAGORIES_IMAGE_PATH.$value['image'])){
                         $arr_data[$i]['image']=BASE_URL.ACTUAL_CATAGORIES_IMAGE_PATH.$value['image'];
                    }
                    else{
                        $arr_data[$i]['image']=STATIC_FRONT_IMAGE."pattren.png";
                    }
                    //$arr_data['Type']='catagories';
                    $i=$i+1;
                    //$arr_catagories[]=$arr_data;
                }
              $arr_catagories = array_map("unserialize", array_unique(array_map("serialize", $arr_data)));
              foreach ($arr_catagories as $key => $value) {
                  $temp_arr[]=$value;
              }
            }
          return $temp_arr;

        }
         function get_restaurant_categories($outlet_id){
        
        $arr_cat=$this->get_restaurant_categories_db($outlet_id)->result_array();
        $cat_html=array();
        if(isset($arr_cat) && !empty($arr_cat
            )){
            foreach ($arr_cat as $key => $value) {
                $cat_html[]=$value['cat_name'];
                
            }
        }
        if(isset($cat_html) && !empty($cat_html))
       return implode(' . ', $cat_html);
    }
    
     function check_favourite_outlet($user_id,$outlet_id){
        $rec = false;
        if(isset($user_id) && is_numeric($user_id)) {
            $favourite = Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$outlet_id,"of_user_id" =>$user_id),'of_id desc','outlet_favourite','outlet_favourite.of_id,outlet_favourite.of_outlet_id,outlet_favourite.of_user_id')->result_array();
            if(!empty($favourite))
                $rec = true;
            unset($favourite);
        }
        return $rec;
    }
    
    function mobile_user_agent_switch(){
        $device = 'Web';
        $server = strtolower($_SERVER['HTTP_USER_AGENT']);
        if( stristr($server,'ipad') || stristr($server,'ipod') || stristr($server,'ios') || stristr($server,'iphone') || strstr($server,'iphone') )
            $device = "IPhone";
        elseif( stristr($server,'blackberry') || stristr($server,'android') )
            $device = "Android";
        else 
            $device = "Web";
        return $device;
    }
    function get_offers_list(){
        date_default_timezone_set("Asia/Karachi");
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $message="No offers found";
        $status=false;
        $page_number="";
        $page_number=$this->input->post('page_number');
        $limit=10;
        if(empty($page_number))
            $page_number=1;
        $total_pages=0;
        $offers_array=array();
        $where_in['end_date >=']=date('Y-m-d');
        $offers_list = $this->_get_offers_table_with_pagination($where_in, 'id asc','offers','offers.id,offers.outlet_id,offers.start_date,offers.end_date,outlet.name as outlet_name,outlet.image as logo,offers.offer_title,offer_description,offer_discount,offer_image,offers.offer_url as share_url',$page_number,$limit)->result_array();
        if(!empty($offers_list)) {
            $i=0;
            ///////////////////////////umar insights start/////////////////////////
            $zone_count = 1;
            date_default_timezone_set("Asia/Karachi");
            foreach ($offers_list as $key => $value) {
                if($zone_count ==1) {
                    if(isset($value['outlet_id']) && !empty($value['outlet_id'])) {
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$value['outlet_id']),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                    }
                }
                $offers_activity_id = $this->insert_into_specific_table(array("oa_user_id"=>$user_location_data['user_id'],"oa_outlet_id"=>$value['outlet_id'],"oa_type"=>"impression","oa_device"=>$user_location_data["device"],"oa_datetime"=>date("Y-m-d H:i:s"),"oa_country_id"=>$user_location_data["Country"],"oa_city_id"=>$user_location_data["City"],"oa_town_id"=>$user_location_data["Area"],'oa_offer_id'=>$value['id']),"offers_activity");
                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                    $this->requested_data_store('offers_activity',$offers_activity_id,$user_location_data);
                }
                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                    $this->requested_city_store('offers_activity',$offers_activity_id,$user_location_data);
                }
                ///////////////////////////umar insights end/////////////////////////
                $value['is_my_like'] = false;
                $value['total_likes'] = $value['total_shares'] = '0';
                if(isset($value['id']) && !empty($value['id']) && is_numeric($value['id'])) {
                    $user_offer =$this->_get_specific_table_with_pagination(array('lo_offer_id'=>$value['id'],'lo_user_id'=>$user_location_data["user_id"]), 'lo_id desc','like_offers','lo_id','1','1')->result_array();
                    if(!empty($user_offer))
                        $value['is_my_like'] = true;
                    $value['total_likes'] =$this->_get_specific_table_with_pagination(array('lo_offer_id'=>$value['id']), 'lo_id desc','like_offers','lo_id','1','0')->num_rows();
                    $value['total_shares'] =$this->_get_specific_table_with_pagination(array('os_offer_id'=>$value['id']), 'os_id desc','offer_share','os_id','1','0')->num_rows();
                }
                if(isset($value['share_url']))
                    $value['share_url'] = BASE_URL.'offer-detail/'.$value['share_url'];
                $offers_array[$i]=$value;
                unset($offers_array[$i]['start_date']);
                unset($offers_array[$i]['end_date']);
                $offers_array[$i]['date']=$value['start_date'].' to '.$value['end_date'];
                if(isset($value['offer_image']) && !empty($value['offer_image']) && file_exists(ACTUAL_OFFER_IMAGE_PATH.$value['offer_image'])){
                    $offers_array[$i]['offer_image']=BASE_URL.ACTUAL_OFFER_IMAGE_PATH.$value['offer_image'];
                }else{
                     $offers_array[$i]['offer_image']=STATIC_FRONT_IMAGE."pattren.png";
                }
                if(isset($value['logo']) && !empty($value['logo']) && file_exists(ACTUAL_OUTLET_IMAGE_PATH.$value['logo'])){
                    $offers_array[$i]['logo']=BASE_URL.ACTUAL_OUTLET_IMAGE_PATH.$value['logo'];
                }else{
                     $offers_array[$i]['logo']=STATIC_FRONT_IMAGE."pattren.png";
                }         
                $i=$i+1;
            }
            $total_pages = $this->_get_offers_table_with_pagination($where_in, 'id asc','offers','offers.id,outlet.name,outlet.image as logo,offers.offer_title,offers.outlet_id,offers.offer_description,offers.offer_discount,offers.offer_image as image,offers.offer_url as share_url',$page_number,'0')->num_rows();
            $diviser=($total_pages/$limit);
            $reminder=($total_pages%$limit);
            if($reminder>0)
               $total_pages=intval($diviser)+1;
            else
                $total_pages=intval($diviser);
            $status =true;
            $message="Offers record fetched successfully";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"offer_data"=>$offers_array,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    function get_offers_detail(){
        date_default_timezone_set("Asia/Karachi");
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $user_lat = $user_location_data['Lat'];
        $user_long = $user_location_data['Long'];
        $status=false;
        $message='Something went wrong';
        $offer_id=$this->input->post('offer_id');
        $outlet_id=$this->input->post('outlet_id');
        
        $offer_detail_array=array();
        if(isset($offer_id) && !empty($offer_id)){
            $offer_data=$this->get_offer_detail_from_db($offer_id,$outlet_id)->result_array();
           
            $current_date=date('Y-m-d');
            if (isset($offer_data) && !empty($offer_data)) {
                    ///////////////////////////umar insights start/////////////////////////
                    date_default_timezone_set("Asia/Karachi");
                    if(isset($outlet_id) && !empty($outlet_id)) {
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                    }
                    $offers_activity_id = $this->insert_into_specific_table(array("oa_user_id"=>$user_location_data['user_id'],"oa_outlet_id"=>$outlet_id,"oa_type"=>"visit","oa_device"=>$user_location_data["device"],"oa_datetime"=>date("Y-m-d H:i:s"),"oa_country_id"=>$user_location_data["Country"],"oa_city_id"=>$user_location_data["City"],"oa_town_id"=>$user_location_data["Area"],'oa_offer_id'=>$offer_data[0]['offer_id']),"offers_activity");
                    if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                        $this->requested_data_store('offers_activity',$offers_activity_id,$user_location_data);
                    }
                    if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                        $this->requested_city_store('offers_activity',$offers_activity_id,$user_location_data);
                    }
                    ///////////////////////////umar insights end/////////////////////////
                    $temp_arr['offer_id']=$offer_data[0]['offer_id'];
                    $temp_arr['offer_title']=$offer_data[0]['offer_title'];
                    $temp_arr['description']=$offer_data[0]['offer_description'];
               
                 $i=0;
                foreach ($offer_data as $key => $row_data) {
                    if($current_date>=$row_data['start_date'] && $current_date<=$row_data['end_date'])
                    $temp_data[$i]['product_id']=$row_data['product_id'];
                    $temp_data[$i]['cat_id']=$row_data['category_id'];
                    $temp_data[$i]['outlet_id']=$outlet_id;
                    $temp_data[$i]['product_name']=$row_data['product_name'];
                    $temp_data[$i]['description']=$row_data['product_description'];
                    
                    
                    $temp_data[$i]['price']=$row_data['price'];
                    if(isset($row_data['product_image']) && !empty($row_data['product_image']) && file_exists(ACTUAL_ITEMS_IMAGE_PATH.$outlet_id.'/'.$row_data['product_image'])) 
                    $temp_data[$i]['product_image']=BASE_URL.ACTUAL_ITEMS_IMAGE_PATH.$outlet_id.'/'.$row_data['product_image'];
                    else
                    $temp_data[$i]['product_image']=STATIC_FRONT_IMAGE."pattren.png";  
                   $i= $i+1;  
                }
                 $status=true;
                $message="Offers's record fetched successfully";
            }
         $offer_detail_array=$temp_arr;
         $offer_detail_array['offer_data']=$temp_data;
          header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"offer_data"=>$offer_detail_array));
          
        }
    }
    function get_announcements_list(){
        $temp_data=array();
        $status=false;
        $page_number="";
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $page_number=$this->input->post('page_number');
        $limit=10;
        if(empty($page_number))
            $page_number=1;
        $total_pages=0;
        $message="No announcement found";
        //$where['create_date']=date('Y-m-d');
        $where=array();
        $announcement = $this->_get_specific_table_with_pagination($where, 'id desc','announcements','announcements.*',$page_number,$limit)->result_array();
        if(!empty($announcement)) {
            $status=true;
            $message="Record fetched successfully";
            $total_pages = $this->_get_specific_table_with_pagination($where, 'id desc','announcements','announcements.*',$page_number,'0')->num_rows();
            $diviser=($total_pages/$limit);
            $reminder=($total_pages%$limit);
            if($reminder>0)
               $total_pages=intval($diviser)+1;
            else
                $total_pages=intval($diviser);
            $i=0;
            if(!empty($announcement)){
                ///////////////////////////umar insights start/////////////////////////
                $zone_count = 1;
                date_default_timezone_set("Asia/Karachi");
                foreach ($announcement as $key => $value) {
                    if($zone_count ==1) {
                        if(isset($value['outlet_id']) && !empty($value['outlet_id'])) {
                            $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$value['outlet_id']),'id desc','general_setting','timezones')->result_array();
                            if(!empty($general_setting))
                                date_default_timezone_set($general_setting[0]['timezones']);
                        }
                    }
                $anouncement_id = $this->insert_into_specific_table(array("aa_user_id"=>$user_location_data['user_id'],"aa_outlet_id"=>$value['outlet_id'],"aa_type"=>"impression","aa_device"=>$user_location_data["device"],"aa_datetime"=>date("Y-m-d H:i:s"),"aa_country_id"=>$user_location_data["Country"],"aa_city_id"=>$user_location_data["City"],"aa_town_id"=>$user_location_data["Area"],'aa_anouncement_id'=>$value['id']),"announcements_activity");
                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                    $this->requested_data_store('announcements_activity',$anouncement_id,$user_location_data);
                }
                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                    $this->requested_city_store('announcements_activity',$anouncement_id,$user_location_data);
                }
                ///////////////////////////umar insights end/////////////////////////
                  $temp_data[$i]['title']=$value['title'];
                  $temp_data[$i]['description']=$value['description'];
                  if(isset($value['image']) && !empty($value['image']) && file_exists(ACTUAL_ANNOUNCEMENTS_IMAGE_PATH.$value['image']))
                   $temp_data[$i]['image']=BASE_URL.ACTUAL_ANNOUNCEMENTS_IMAGE_PATH.$value['image'];
                   else{
                         $temp_data[$i]['image']=STATIC_FRONT_IMAGE.$value['image'];
                   }
                    $i=$i+1;
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_data,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
    }
        ////////////////////////////
        function get_featured_outlets($where,$order_by,$user_lat,$user_long,$page_number,$limit,$where_in){
            $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->get_oultets_from_db($where,$order_by,$user_lat,$user_long,$page_number,$limit,$where_in);
        } 
        function get_slider_types(){
           $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->get_slider_types();
        }
        

        function get_outlet_catagories_db($where){
             $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->get_outlet_catagories_db($where);
        }

     function outlet_open_close($outlet_id){
    $open_close='Closed';
        $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
        if(!empty($timezone)) {
            if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones'])) {
                date_default_timezone_set($timezone[0]['timezones']);
                $timing=Modules::run('outlet/outlet_open_close',array("timing.outlet_id"=>$outlet_id,"timing.day"=>date('l'),"timing.opening <="=>date('H:i:s')),"(CASE WHEN closing < opening THEN '23:59:59' else  closing END) AS closssing,is_closed",array("closssing >="=>date('H:i:s')))->result_array();
                if(!empty($timing)) {
                    if($timing[0]['is_closed'] ==0)
                        $open_close='Open';

                }
            }
        }
      return $open_close;
   }
   
      function get_restaurant_categories_db($outlet_id){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_resturant_categories($outlet_id);
    } 
    function _get_offers_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit){
              $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_offers_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit);
            return $query;
        }
        function get_offer_detail_from_db($offer_id,$outlet_id){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_offer_detail_from_db($offer_id,$outlet_id);
            return $query;
        }
        function restaurant_rating(){ 
            $outlet_id=$this->input->post('outlet_id');
            $status=false;
            $message="Something went wrong";
            $temp_arr=array();
            if(!empty($outlet_id)){
                 $rating=$this->get_restaurant_rating($outlet_id)->result_array();
                 if (isset($rating) && !empty($rating)) {
                        $temp_arr['total_rating']="0.0";
                        $temp_arr['taste']= number_format((float)$rating[0]['taste'], 1, '.', '');
                        $temp_arr['environment']= number_format((float)$rating[0]['environment'], 1, '.', '');
                        $temp_arr['total_rating']= number_format((float)$rating[0]['total_rating'], 1, '.', '');
                        $temp_arr['total_reviews']= $rating[0]['total_reviews'];
                        $temp_arr['behaviour']= number_format((float)$rating[0]['behaviour'], 1, '.', '');
                        $temp_arr['responce_time']= number_format((float)$rating[0]['responce_time'], 1, '.', '');
                        $status=true;
                        $message="Record fetched succesfully";
                         
                   
                 }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_arr));
        }

    function get_restaurant_rating($outlet_id){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_restaurant_rating($outlet_id);
    }
    function get_restaurant_reviews_list(){
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $user_lat = $user_location_data['Lat'];
        $user_long = $user_location_data['Long'];
        $temp_data=array();
        $status=false;
        $page_number="";
        $page_number=$this->input->post('page_number');
        $outlet_id=$this->input->post('outlet_id');
        $limit=20;
        if(empty($page_number))
            $page_number=1;
        $total_pages=0;
        $message="No Reviews found";
        //$where['create_date']=date('Y-m-d');
        $where['reviews.outlet_id']=$outlet_id;
        $reviews_arr = $this->_get_restaurant_reviews_list_from_db($where,$page_number,$limit)->result_array();
       
        if(!empty($reviews_arr)) {
            ///////////////////////////umar insights start/////////////////////////
            $zone_count = 1;
            date_default_timezone_set("Asia/Karachi");
            foreach ($reviews_arr as $key => $value) {
                if($zone_count ==1) {
                    if(isset($value['outlet_id']) && !empty($value['outlet_id'])) {
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$value['outlet_id']),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                    }
                }
                $reviews_activity_id = $this->insert_into_specific_table(array("ra_user_id"=>$user_location_data['user_id'],"ra_outlet_id"=>$value['outlet_id'],"ra_type"=>"impression","ra_device"=>$user_location_data["device"],"ra_datetime"=>date("Y-m-d H:i:s"),"ra_country"=>$user_location_data["Country"],"ra_city"=>$user_location_data["City"],"ra_town"=>$user_location_data["Area"],'ra_review_id'=>$value['id']),"reviews_activity");
                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                    $this->requested_data_store('reviews_activity',$reviews_activity_id,$user_location_data);
                }
                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                    $this->requested_city_store('reviews_activity',$reviews_activity_id,$user_location_data);
                }
            }
            ///////////////////////////umar insights end/////////////////////////
            $status=true;
            $message="Record fetched successfully";
            $total_pages = $this->_get_restaurant_reviews_list_from_db($where,$page_number,"0")->num_rows();
            $diviser=($total_pages/$limit);
            $reminder=($total_pages%$limit);
            if($reminder>0)
               $total_pages=intval($diviser)+1;
            else
                $total_pages=intval($diviser);
            $i=0;
            if(!empty($reviews_arr)){
                foreach ($reviews_arr as $key => $value) {
                  $temp_data[$i]['user_name']=$value['name'];
                  $temp_data[$i]['user_review']=$value['user_review'];
                  $temp_data[$i]['rating']=$value['rating'];
                 
                    $i=$i+1;
                }
            }
           
        }
         header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_data,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    function _get_restaurant_reviews_list_from_db($where,$page_number,$limit){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->_get_restaurant_reviews_list_from_db($where,$page_number,$limit);
    }
        
        function get_notifications_list(){
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_lat = $user_location_data['Lat'];
            $user_long = $user_location_data['Long'];
            $user_id = $user_location_data['user_id'];
            $temp_data=array();
            $status=false;
            $page_number="";
            $page_number=$this->input->post('page_number');
            $limit=20;
            if(empty($page_number))
                $page_number=1;
            $total_pages=0;
            $message="No Notifications found";
            //$where['create_date']=date('Y-m-d');
            $where['app_notifications.status']=1;
            $notification_arr = $this->get_notifcations_list_from_db($where,$page_number,$limit)->result_array();


            if(!empty($notification_arr)) {

                $status=true;
                $message="Record fetched successfully";
                $total_pages = $this->get_notifcations_list_from_db($where,$page_number,0)->num_rows();
                $diviser=($total_pages/$limit);
                $reminder=($total_pages%$limit);
                if($reminder>0)
                   $total_pages=intval($diviser)+1;
                else
                    $total_pages=intval($diviser);
            $i=0;
            if(!empty($notification_arr)){
                foreach ($notification_arr as $key => $value) {
                    if(!empty($user_id)){
                          $this->insert_or_update(array("user_id"=>$user_id,"notification_id"=>$value['id']),array("user_id"=>$user_id,"notification_id"=>$value['id'],"notification_status"=>"seen"),"notification_status");
                      }
                  $temp_data[$i]['title']=$value['title'];
                  $temp_data[$i]['description']=$value['description'];
                  $temp_data[$i]['icon']=$value['icon'];
                  if(isset($value['image']) && !empty($value['image']) && file_exists(ACTUAL_NOTIFICATIONS_IMAGE_PATH.$value['image']))
                     $temp_data[$i]['image']=BASE_URL.ACTUAL_NOTIFICATIONS_IMAGE_PATH.$value['image'];
                   else
                    $temp_data[$i]['image']=STATIC_FRONT_IMAGE."pattren.png";
                $i=$i+1;
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_data,"page_number"=>$page_number,"total_pages"=>$total_pages));
     }
 }
 function get_latest_notification_count_from_db($user_id){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_latest_notification_count_from_db($user_id);
 }
     function get_notifcations_list_from_db($where,$page_number,$limit){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_notifcations_list_from_db($where,$page_number,$limit);
     }
     function get_search_products(){
         $status=false;
         $message="Something went wrong";
         $distance='5.67';
         $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
         $user_lat = $user_location_data['Lat'];
         $user_long = $user_location_data['Long'];
        
         $like=$this->input->post('outlet_name');
         $min_price=$this->input->post('min_price');
         $max_price=$this->input->post('max_price');
         $page_number=$this->input->post("page_number");
         $category_id=$this->input->post('category_id');
         if (empty($page_number))
            $page_number=1;
         $limit=10;
            
        if(isset($user_lat) && is_numeric($user_lat) && isset($user_long) && is_numeric($user_long)) {
           
            $maxLat=$minLat=$maxLon=$minLon="";
            if(!empty($distance) && !empty($user_lat) && !empty($user_long)) {
                $R="6371";
                $maxLat = $user_lat + rad2deg($distance/$R);
                $minLat = $user_lat - rad2deg($distance/$R);
                $maxLon = $user_long + rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                $minLon = $user_long - rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
            }
            $where_produtcs="";
          if(isset($min_price) && !empty($min_price) && is_numeric($min_price) && isset($max_price) && is_numeric($max_price) && !empty($max_price))
                $where_produtcs=array("price >="=>$min_price,"price <="=>$max_price);
                if(empty($category_id) && !is_numeric($category_id))
                    $outlets=$this->get_nearest_outlest(array("outlet.latitude >=" =>$minLat,"outlet.latitude <=" =>$maxLat,"outlet.longitude >=" =>$minLon,"outlet.longitude <=" =>$maxLon,"outlet.status"=>"1"),$order_by)->result_array();
                else
                    $outlets=$this->get_nearest_outlest(array("outlet.latitude >=" =>$minLat,"outlet.latitude <=" =>$maxLat,"outlet.longitude >=" =>$minLon,"outlet.longitude <=" =>$maxLon,"outlet_catagories.outlet_catagory"=>$category_id,"outlet.status"=>"1"),$order_by)->result_array();
       
     //   $outlets=$this->get_nearest_outlest($where_outlet,"","order by id asc")->result_array();
      

    
        $outlets_arr=array_column($outlets, 'id');
       
        if(!empty($outlets)){
            $status=true;
            $message="No search result found";
            foreach($outlets as $row){
                $outlets_arrr[]=$row['id'];
            }
            //print_r($outlets_arr);exit;
            $arr_products=$this->get_products_search_by_cat($outlets_arrr,$where_produtcs,$like,"order by id desc",$page_number,$limit)->result_array();
            $arr_products = array_map("unserialize", array_unique(array_map("serialize", $arr_products)));
            $total_pages=$this->get_products_search_by_cat($outlets_arr,$where_produtcs,$like,"order by id desc",$page_number,"0")->num_rows();
               
                 $temp_products=array();
                  if(!empty($arr_products) ) {
                            foreach ($arr_products as $key => $pro) {
                            $prod['product_id']=$pro['id'];
                             $prod['outlet_id']=$pro['outlet_id'];
                            $prod['name']=$pro['title'];
                            $prod['minimum_price']=$pro['min_price'];
                            $prod['outlet_name']=$pro['name'];
                            $prod['category_id']=$pro['category_id'];
                            $prod['product_discount']=$pro['cat_discount']+$pro['product_discount'];
                                $pro_image =STATIC_FRONT_IMAGE.'pattren.png';
                                if(isset($pro['image']) && !empty($pro['image'])) {
                                    if(file_exists(ACTUAL_ITEMS_IMAGE_PATH.$pro['outlet_id'].'/'.$pro['image']))
                                        $pro_image = BASE_URL.ACTUAL_ITEMS_IMAGE_PATH.$pro['outlet_id'].'/'.$pro['image'];
                                }
                                $prod['image'] = $pro_image;
                               
                                $temp_products[]=$prod;
                               
                            }
                        $status=true;
                        $message="Record fetched successfully";
                        }
                $diviser=($total_pages/$limit);
                $reminder=($total_pages%$limit);
                if($reminder>0)
                   $total_pages=intval($diviser)+1;
                else
                    $total_pages=intval($diviser);
            $temp_products=array_map("unserialize", array_unique(array_map("serialize", $temp_products)));
        }
    }
     header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"outlets"=>$temp_products,"page_number"=>$page_number,"total_pages"=>$total_pages,));
 }
 
 function get_products_search_by_cat($outlet_arr,$where_produtcs,$like,$order_by,$page_number,$limit){
         $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_products_search_by_cat($outlet_arr,$where_produtcs,$like,$order_by,$page_number,$limit);
 }
    function get_recipes_list(){
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $user_lat = $user_location_data['Lat'];
        $user_long = $user_location_data['Long'];
        $temp_data=array();
        $status=false;
        $page_number="";
        $page_number=$this->input->post('page_number');
        $limit=20;
        if(empty($page_number))
            $page_number=1;
        $total_pages=0;
        $outlet_id = $this->input->post('outlet_id');
        $message="No recipies found";
        //$where['create_date']=date('Y-m-d');
        if(isset($outlet_id) && !empty($outlet_id) && is_numeric($outlet_id)) {
            $status=true;
            $message="Record fetched successfully";
            $where['status']=1;
            $where['outlet_id']=$outlet_id;
              $recipes_arr = $this->_get_specific_table_with_pagination($where, 'id desc','outlet_recipes','outlet_recipes.*',$page_number,$limit)->result_array();
            if(!empty($recipes_arr)) {
                    $total_pages = $this->_get_specific_table_with_pagination($where, 'id desc','outlet_recipes','outlet_recipes.*',$page_number,'0')->num_rows();
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                $i=0;
                if(!empty($recipes_arr)) {
                    ///////////////////////////umar insights start/////////////////////////
                    $zone_count = 1;
                    date_default_timezone_set("Asia/Karachi");
                    foreach ($recipes_arr as $key => $value) {
                        if($zone_count ==1) {
                            if(isset($value['outlet_id']) && !empty($value['outlet_id'])) {
                                $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$value['outlet_id']),'id desc','general_setting','timezones')->result_array();
                                if(!empty($general_setting))
                                    date_default_timezone_set($general_setting[0]['timezones']);
                            }
                        }
                        $recipies_activity_id = $this->insert_into_specific_table(array("ra_user_id"=>$user_location_data['user_id'],"ra_outlet_id"=>$value['outlet_id'],"ra_type"=>"impression","ra_device"=>$user_location_data["device"],"ra_datetime"=>date("Y-m-d H:i:s"),"ra_country"=>$user_location_data["Country"],"ra_city"=>$user_location_data["City"],"ra_town"=>$user_location_data["Area"],'ra_recipie_id'=>$value['id']),"recipies_activity");
                        if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                            $this->requested_data_store('recipies_activity',$recipies_activity_id,$user_location_data);
                        }
                        if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                            $this->requested_city_store('recipies_activity',$recipies_activity_id,$user_location_data);
                        }
                        ///////////////////////////umar insights end/////////////////////////
                        $temp_data[$i]['title']=$value['recipes_title'];
                        $temp_data[$i]['description']=$value['description'];
                        if(isset($value['image']) && !empty($value['image']) && file_exists(ACTUAL_RECIPES_IMAGE_PATH.$value['image']))
                            $temp_data[$i]['image']=BASE_URL.ACTUAL_RECIPES_IMAGE_PATH.$value['image'];
                        else
                            $temp_data[$i]['image']=STATIC_FRONT_IMAGE."pattren.png";
                        $i=$i+1;
                    }
                }  
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_data,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
     function get_oultet_info(){
        $status=false;
        $message="Something went wrong";
        $arr_services=array();
        $arr_timing=array();
        date_default_timezone_set("Asia/Karachi");
        $outlet_id=$this->input->post('outlet_id');
        $outlet_id=2;
        if (!empty($outlet_id)) {
            $status=true;
            $message="Record fetched successfully";
        $services=$this->get_outlet_facilities($outlet_id)->result_array();
        if($services){
            $i=0;
            foreach ($services as $key => $value) {
               $arr_services[$i]=$value['icon'];
               $arr_services[$i]=$value['features'];
               $i=$i+1;
            }
        }
        $i=0;
       
        $outlet_loc=Modules::run('slider/_get_where_cols',array("id" =>$outlet_id),'id asc','outlet','latitude,longitude')->result_array();
        
        $arr_loc=$outlet_loc[0];
        $outlet_timing=Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id asc','timing','timing.*')->result_array();
        if(isset($outlet_timing) && !empty($outlet_timing)){
            foreach ($outlet_timing as $key => $value) {
                $arr_timing[$i]['day']=$value['day'];
                if($value['is_closed']==1){
                     $arr_timing[$i]['timing']="Closed";
                }
                else{
                    $opening=date("g:i a", strtotime($value['opening']));
                    $closing=date("g:i a", strtotime($value['closing']));
                    $arr_timing[$i]['timing']=$opening.' to '.$closing;
                }
                if($value['day']==date('l'))
                     $arr_timing[$i]['today']="today";
                 $i=$i+1;
            }
        }
    }
       
         header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"location_data"=>$arr_loc,"service_data"=>$arr_services,"timing_data"=>$arr_timing));
    }

    function get_outlet_facilities($outlet_id){
         $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_outlet_facilities($outlet_id);
    }
     function get_deals_list(){
            $status=false;
            $message="Something went wrong";
            $arr_deals=array();
            $outlet_id=$this->input->post('outlet_id'); 
            $limit=6; 
             $page_number=1;
            $pagination=$this->input->post('pagination');       
           if($pagination=='nopagination'){
               $page_number=1;
               $limit=0;
           }
           
            
        if(isset($outlet_id) && !empty($outlet_id)){
            $status=true;
        
            $message="No deals found";
            $where['outlet_id']=$outlet_id;
            $where['status']=1;
            $where['start_date <=']=date('Y-m-d');
            $where['end_date >=']=date('Y-m-d');
            $out_deals=$this->get_deals_list_from_db($where,$page_number,$limit)->result_array();
            if(isset($out_deals) && !empty($out_deals)){
                ///////////////////////////umar insights start/////////////////////////
                $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
                date_default_timezone_set("Asia/Karachi");
                if(isset($outlet_id) && !empty($outlet_id)) {
                    $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                    if(!empty($general_setting))
                        date_default_timezone_set($general_setting[0]['timezones']);
                }
                ///////////////////////////umar insights end/////////////////////////
                $message="Record fetched successfully";
                $i=0;
                foreach ($out_deals as $key => $value) {
                    ///////////////////////////umar insights start/////////////////////////
                    $deals_activity_id = $this->insert_into_specific_table(array("da_user_id"=>$user_location_data['user_id'],"da_outlet_id"=>$outlet_id,"da_type"=>"impression","da_device"=>$user_location_data["device"],"da_datetime"=>date("Y-m-d H:i:s"),"da_country_id"=>$user_location_data["Country"],"da_city_id"=>$user_location_data["City"],"da_town_id"=>$user_location_data["Area"],'da_deals_id'=>$value['deal_id']),"deals_activity");
                    if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                        $this->requested_data_store('deals_activity',$deals_activity_id,$user_location_data);
                    }
                    if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                        $this->requested_city_store('deals_activity',$deals_activity_id,$user_location_data);
                    }
                    ///////////////////////////umar insights end/////////////////////////
                    $arr_deals[$i]=$value;
                    if(isset($value['image']) && !empty($value['image']) && file_exists(ACTUAL_DEAL_IMAGE_PATH.$value['image']))
                    $arr_deals[$i]['image']=BASE_URL.ACTUAL_DEAL_IMAGE_PATH.$value['image'];
                    else
                    $arr_deals[$i]['image']=STATIC_FRONT_IMAGE."pattren.png";
                    $arr_deals[$i]['description']=$this->string_length($value['description'],'50','','');
                    $i=$i+1;
                }
            } 
       
        }
          if(isset($pagination) && !empty($pagination)&& $pagination=='nopagination'){
                 header('Content-Type: application/json');
             echo json_encode(array("status"=>$status,"message"=>$message,"deals_data"=>$arr_deals));exit;
           }
           else{
         return $arr_deals;
           }

    }
    function get_deals_list_from_db($where,$page_number,$limit){
        $this->load->model('mdl_perfectmodel');
        $query = $this->mdl_perfectmodel->get_deals_list_from_db($where,$page_number,$limit);
        return $query;
    }
     function get_deals_detail(){
        
        $outlet_id=$this->input->post('outlet_id');
        $deal_id=$this->input->post('product_id');
        $status=false;
        $data_status=false;
        $temp_size=array();
        $message="Something went wrong";
        $deal_desc='';
        if(isset($outlet_id) && !empty($outlet_id) && isset($deal_id) && !empty($deal_id)){
             $status=true;
        $deal_desc = Modules::run('slider/_get_where_cols',array("deal_id"=> $deal_id),'deal_id desc','deals','description')->result_array();
        if(isset($deal_desc) && !empty($deal_desc))
            $deal_desc=$deal_desc[0]['description'];
        $where['deals_products.deal_id']=$deal_id;
        //$where['deals.outlet_id']=$outlet_id;
        $items_data =$this->get_deals_detail_db($where)->result_array();
              
               if(!empty($items_data)) {
                    ///////////////////////////umar insights start/////////////////////////
                    $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
                    date_default_timezone_set("Asia/Karachi");
                    if(isset($outlet_id) && !empty($outlet_id)) {
                        $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                        if(!empty($general_setting))
                            date_default_timezone_set($general_setting[0]['timezones']);
                    }
                    ///////////////////////////umar insights end/////////////////////////
                    $i=0;
                    foreach ($items_data as $key => $value) {
                        if(empty($value['product_size']))
                            $value['product_size']=0;
                      if($value['is_optional']==1){
                         if(!empty($value['product_size']))
                        $temp[$i]['ao_title'] =$value['cat_name'] .' ('.$value['product_size'].')';
                        else
                        $temp[$i]['ao_title'] =$value['cat_name'];
                        $temp[$i]['ao_required'] = TRUE;
                        $temp[$i]['check'] = 'Addon';
                        $temp[$i]['counter'] =$value['quantity'];
                        
     
                        $arr_catagories=$this->get_cat_deals_products($outlet_id,$deal_id,$value['catagory_id'],$value['product_size'])->result_array();
                         if(!empty($arr_catagories)) {
                                $temp_arr=array();
                                foreach($arr_catagories as $value){
                                    $value['stock_price']='0.00';
                                    $temp_arr[]=$value;
                                }
                                $temp[$i]['add_ons_detail'] =$temp_arr;
                               
                                //$add_on_data[$i]=$temp;
                                $data_status=true;
                           }
                        $i=$i+1;
                      }
                       $add_on_data=$temp;
                    ///////////////////////////umar insights start/////////////////////////
                    $deals_activity_id = $this->insert_into_specific_table(array("da_user_id"=>$user_location_data['user_id'],"da_outlet_id"=>$outlet_id,"da_type"=>"visit","da_device"=>$user_location_data["device"],"da_datetime"=>date("Y-m-d H:i:s"),"da_country_id"=>$user_location_data["Country"],"da_city_id"=>$user_location_data["City"],"da_town_id"=>$user_location_data["Area"],'da_deals_id'=>$deal_id),"deals_activity");
                    if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                        $this->requested_data_store('deals_activity',$deals_activity_id,$user_location_data);
                    }
                    if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                        $this->requested_city_store('deals_activity',$deals_activity_id,$user_location_data);
                    }
                    ///////////////////////////umar insights end/////////////////////////
                      $message="Record fetched successfully";
                    }
               
               }
                else
                 $message="Record not found";
       
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=> $status,"message"=>$message,"add_on_data"=>$add_on_data,"data_status"=> $data_status,"description"=>$deal_desc));exit;
    }
    function get_deals_detail_db($where){
          $this->load->model('mdl_perfectmodel');
        return $this->mdl_perfectmodel->get_deals_detail_db($where);
    }
    function get_cat_deals_products($outlet_id,$deal_id,$catagory_id,$stock_size){
          $this->load->model('mdl_perfectmodel');
        return $this->mdl_perfectmodel->get_cat_deals_products($outlet_id,$deal_id,$catagory_id,$stock_size);
    }
    function get_timelines_list(){
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $user_lat = $user_location_data['Lat'];
        $user_long = $user_location_data['Long'];
        $temp_data=array();
        $status=false;
        $page_number="";
        $page_number=$this->input->post('page_number');
        $limit=20;
        if(empty($page_number))
            $page_number=1;
        $total_pages=0;
        $message="No timeline found";
        //$where['create_date']=date('Y-m-d');
       
        $outlet_id=$this->input->post('outlet_id');
        if(isset($outlet_id) && !empty($outlet_id) && is_numeric($outlet_id)) {
            $status=true;
            $message="Record fetched successfully";
            $where['status']=1;
            $where['outlet_id']=$outlet_id;
            $notification_arr = $this->get_timelines_list_from_db($where,$page_number,$limit)->result_array();
            $temp_data = array();
            if(!empty($notification_arr)) {
                $total_pages = $this->get_timelines_list_from_db($where,$page_number,0)->num_rows();
                $diviser=($total_pages/$limit);
                $reminder=($total_pages%$limit);
                if($reminder>0)
                   $total_pages=intval($diviser)+1;
                else
                    $total_pages=intval($diviser);
                $i=0;
            //print_r($notification_arr);exit;
                if(!empty($notification_arr)) {
                    foreach ($notification_arr as $key => $value) {
                        if($value['notifications_type']=="notifications"){
                            $temp_data[$i]['type']=$value['notifications_type'];
                            $temp_data[$i]['title']=$value['title'];
                            $temp_data[$i]['description']=$value['description'];
                     
                            if(isset($value['image']) && !empty($value['image']) && file_exists(ACTUAL_NOTIFICATIONS_IMAGE_PATH.$value['image']))
                                $temp_data[$i]['image']=BASE_URL.ACTUAL_NOTIFICATIONS_IMAGE_PATH.$value['image'];
                            else
                                $temp_data[$i]['image']=STATIC_FRONT_IMAGE."pattren.png";
                    

                        }
                        else {
                            $temp_data[$i]['type']=$value['notifications_type'];
                            $slide_arr=Modules::run('slider/_get_where_cols', array("timeline_id" =>$value['id']),'id desc','timelines_gallery','image')->result_array();
                            $j=0;
                            foreach ($slide_arr as $key => $row) {
                                if(isset($row['image']) && !empty($row['image']) && file_exists(ACTUAL_TIMELINES_IMAGE_PATH.$row['image']))
                                    $temp_img[$j]['image']=BASE_URL.ACTUAL_TIMELINES_IMAGE_PATH.$row['image'];
                                else
                                    $temp_img[$j]['image']=STATIC_FRONT_IMAGE."pattren.png";
                                $j=$j+1;
                            }
                            $temp_data[$i]['data']=$temp_img;
                        }
                        $i=$i+1;
                    }
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"data"=>$temp_data,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    function get_timelines_list_from_db($where,$page_number,$limit){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_timelines_list_from_db($where,$page_number,$limit);
    }
     function privacy_policy(){
     $page_content="";
     $url_slug='privacy-policy';
     $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
     $arrPage = $arrPage->row();
        if (isset($arrPage) && !empty($arrPage)) {
        $page_content= $arrPage->page_content;
      
    }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>true,"data"=>$page_content));
}
 function about_us(){
     $page_content="";
     $url_slug='about-us';
     $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
     $arrPage = $arrPage->row();
        if (isset($arrPage) && !empty($arrPage)) {
        $page_content= $arrPage->page_content;
      
    }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>true,"data"=>$page_content));
}
 function terms_and_conditions(){
     $page_content="";
     $url_slug='terms-and-conditions';
     $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
     $arrPage = $arrPage->row();
        if (isset($arrPage) && !empty($arrPage)) {
        $page_content= $arrPage->page_content;
      
    }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>true,"data"=>$page_content));
}
    
    /////////////////////asad heyfood api's///////////

        function outlet_favourite(){
            $status=false;
            $message="Something went wrong";
            $outlet_id=$this->input->post('outlet_id');
            $user_id=$this->input->post('user_id');
            $insert_or_delete =0;
            if(isset($outlet_id) && is_numeric($outlet_id) && isset($user_id) && is_numeric($user_id)) {

                $insert_or_delete = $this->insert_or_delete(array("of_outlet_id"=>$outlet_id,"of_user_id"=>$user_id),array("of_outlet_id"=>$outlet_id,"of_user_id"=>$user_id),'outlet_favourite');
                if($insert_or_delete == 0)
                    $message="Removed from follows";
                else
                    $message="Added to follows";
                $status=true;
             
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"insert_or_delete"=>$insert_or_delete));
        }
        function get_restaurants(){
            $status=false;
            $message="Something went wrong";
            $page_number=$this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit=$this->input->post('limit');
            if(!is_numeric($limit))
                $limit = 20;
            $total_pages=0;
            $restaurants = $this->_get_specific_table_with_pagination(array(), 'id asc','outlet','outlet.id,outlet.name,outlet.address',$page_number,$limit)->result_array();
            if(!empty($restaurants)) {
                $total_pages = $this->_get_specific_table_with_pagination(array(), 'id asc','outlet','outlet.id,outlet.name,outlet.address',$page_number,'0')->num_rows();
                $diviser=($total_pages/$limit);
                $reminder=($total_pages%$limit);
                if($reminder>0)
                   $total_pages=intval($diviser)+1;
                else
                    $total_pages=intval($diviser);
                $status =true;
                $message="outlet data fetched";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"restaurants"=>$restaurants,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        function outlet_detail(){
            $status=false;
            $message="Something went wrong";
            $outlet_id = $this->input->post('outlet_id');
            $outlet_record=array();
            if(isset($outlet_id) && is_numeric($outlet_id)) {
                $message="outlet data fetched";
                $outlet_record = Modules::run('slider/_get_where_cols',array("id"=> $outlet_id),'id desc','outlet','id,name,phone,email,orgination_no,country,state,city,post_code,address,latitude,longitude')->result_array();
                if(!empty($outlet_record)) {
                    if(!isset($outlet_record[0]['latitude']) || empty($outlet_record[0]['latitude']))
                        $outlet_record[0]['latitude'] = 0;
                    if(!isset($outlet_record[0]['longitude']) || empty($outlet_record[0]['longitude']))
                        $outlet_record[0]['longitude'] = 0;
                    $outlet_record[0]['dietaries'] = Modules::run('slider/_get_where_cols',array("od_outlet_id"=> $outlet_record[0]['id']),'od_id desc','outlet_dietary','od_dietary_id')->result_array();
                    if(!empty($outlet_record[0]['dietaries'])) {
                        $dietary="";
                        foreach ($outlet_record[0]['dietaries'] as $key => $die) {
                            if(empty($dietary))
                                $dietary = $die['od_dietary_id'].",";
                            else
                                $dietary = $dietary.$die['od_dietary_id'].",";
                        }
                        $outlet_record[0]['dietaries']= $dietary;
                    }
                    else
                        $outlet_record[0]['dietaries'] = "";
                    $outlet_record[0]['categories'] = Modules::run('slider/_get_where_cols',array("outlet_id"=> $outlet_record[0]['id']),'id desc','outlet_catagories','outlet_catagory')->result_array();
                    if(!empty($outlet_record[0]['categories'])) {
                        $categories="";
                        foreach ($outlet_record[0]['categories'] as $key => $cat) {
                            if(empty($categories))
                                $categories = $cat['outlet_catagory'].",";
                            else
                                $categories = $categories.$cat['outlet_catagory'].",";
                        }
                        $outlet_record[0]['categories']= $categories;
                    }
                    else
                        $outlet_record[0]['categories'] = "";
                }
                if(!empty($outlet_record)) {
                    $status =true;
                    $message="outlet data found";
                }
                
            }
            
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"outlet_record"=>$outlet_record));
        }
        function outlet_update(){
            $status=false;
            $message="Something went wrong";
            $outlet_id = $this->input->post('id');
            $data=array();
            $dietary = $this->input->post('dietary');
            $category = $this->input->post('category');
            if(!empty($_POST)){
                foreach ($_POST as $key => $value) {
                    if($key !== 'id' && $key !== 'dietary' && $key !== 'category' ) {
                        $data[$key] = $value;
                    }
                }
            }
            if(isset($outlet_id) && is_numeric($outlet_id) && !empty($data)) {
                $outlet_record = Modules::run('outlet/_update_where_cols',array("id"=> $outlet_id),$data);
                if(!empty($dietary)) {
                    $dietary = explode(",", $dietary);
                    $dietary = array_filter($dietary);
                    $this->delete_from_specific_table(array("od_outlet_id"=>$outlet_id),"outlet_dietary");
                    foreach ($dietary as $key => $die) {
                        $this->insert_or_update(array("od_outlet_id"=>$outlet_id,"od_dietary_id"=>$die),array("od_outlet_id"=>$outlet_id,"od_dietary_id"=>$die),"outlet_dietary");
                    }
                }
                if(!empty($category)) {
                    $category = explode(",", $category);
                    $category = array_filter($category);
                    $this->delete_from_specific_table(array("outlet_id"=>$outlet_id),"outlet_catagories");
                    foreach ($category as $key => $cat) {
                        $this->insert_or_update(array("outlet_id"=>$outlet_id,"outlet_catagory"=>$cat),array("outlet_id"=>$outlet_id,"outlet_catagory"=>$cat),"outlet_catagories");
                    }
                }
                $status=true;
                $message="record updated";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function product_add_on_and_items(){
            $status=false;
            $data_status=false;
            $message="Something went wrong";
            $outlet_id = $this->input->post('outlet_id');
            $product_id = $this->input->post('product_id'); 
            $category_id = $this->input->post('category_id'); 
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            if($category_id=="deal"){
                $this->get_deals_detail();
            }
            else{
            $add_on_data=array();
            $product_detail="";
            $product_max_no=5;
            $product_availability='Closed';
            $product_timing=array();
            $product_title="";
            if(isset($outlet_id) && is_numeric($outlet_id) && isset($product_id) && is_numeric($product_id)) {
                Modules::run('product/check_product_add_on_table',$outlet_id);
                $status=true;
                $message="data fetched";
                $detail = Modules::run('slider/_get_where_cols',array("id" =>$product_id),'id desc',$outlet_id.'_products','title,description,p_max_no')->result_array();
                if(!empty($detail)) {
                    ///////////////////////////umar insights start/////////////////////////
                    date_default_timezone_set("Asia/Karachi");
                    $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                    if(!empty($timezone)) {
                        if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']))
                            date_default_timezone_set($timezone[0]['timezones']);
                    }
                    $visited_id = $this->insert_into_specific_table(array("pa_user_id"=>$user_location_data['user_id'],"pa_outlet_id"=>$outlet_id,"pa_type"=>"visit","pa_device"=>$user_location_data['device'],"pa_datetime"=>date("Y-m-d H:i:s"),"pa_country"=>$user_location_data["Country"],"pa_city"=>$user_location_data["City"],"pa_town"=>$user_location_data["Area"],'pa_product_id'=>$product_id),'product_activity');
                        if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                            $this->requested_data_store('product_activity',$visited_id,$user_location_data);
                        }
                        if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                            $this->requested_city_store('product_activity',$visited_id,$user_location_data);
                        }
                    ///////////////////////////umar insights end/////////////////////////
                    if(isset($detail[0]['description']) && !empty($detail[0]['description']))
                        $product_detail = $detail[0]['description'];
                    if(isset($detail[0]['p_max_no']) && !empty($detail[0]['p_max_no'])) {
                        $product_max_no = $detail[0]['p_max_no'];
                    }
                    if(isset($detail[0]['title']) && !empty($detail[0]['title']))
                        $product_title = $detail[0]['title'];
                }
                $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                $product_timing = Modules::run('slider/_get_where_cols',array("pt_product_id" =>$product_id),'pt_day asc',$outlet_id.'_product_timing','pt_id,pt_day,pt_opening,pt_closing,pt_is_closed')->result_array();
                if(!empty($timezone))
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']) && !empty($product_timing)) {
                         date_default_timezone_set($timezone[0]['timezones']);
                         foreach ($product_timing as $key => $pt) {
                             if($pt['pt_day'] == date('l')) {
                                if(date("H:i:s") >= $pt['pt_opening'] && date("H:i:s") <= $pt['pt_closing']) 
                                    $product_availability='Open';
                             }
                         }
                    }
                $items_data = Modules::run('slider/_get_where_cols',array("product_id" =>$product_id),'id desc',$outlet_id.'_stock','id as stock_id,label as stock_label,price as stock_price,product_id')->result_array();
                if(!empty($items_data)) {
                    $temp_size=array();
                    $temp['ao_title'] = 'Sizes';
                    $temp['ao_required'] = TRUE;
                    $temp['check'] = 'Size';
                    foreach ($items_data as $key => $id) {
                        if(isset($id['stock_label']) && !empty($id['stock_label'])) {
                            $id['product_title'] = $product_title;
                            $temp_size[]=$id;
                        }
                    }
                    if(!empty($temp_size)) {
                        $temp['add_ons_detail'] =$temp_size;
                        $add_on_data[]=$temp;
                        $data_status=true;
                    }
                    /*$temp['add_ons_detail'] =$items_data;
                        $add_on_data[]=$temp;
                        $data_status=true;*/
                }
                $product_add_ons=$this->get_product_add_on_with_add_detail(array("pao_pid" =>$product_id),$outlet_id.'_add_on.add_on_rank asc',$outlet_id.'_product_add_ons.pao_add_on,'.$outlet_id.'_add_on.title,'.$outlet_id.'_add_on.is_optional,'.$outlet_id.'_add_on.max_qty as product_max_no',$outlet_id,'1','0')->result_array();
                if(!empty($product_add_ons)) {
                    $data_status=true;
                    foreach ($product_add_ons as $key => $pao):
                        if(isset($pao['pao_add_on']) && is_numeric($pao['pao_add_on'])){
                            $add_on_id=$pao['pao_add_on'];
                            $where_add_on_products['add_on.id'] = $add_on_id;
                            $where_add_on_products['add_on.outlet_id'] = $outlet_id;
                            $add_ons_detail = Modules::run('add_on/_get_add_on_products_join_front_limited_select', $where_add_on_products, $outlet_id,'stock.id as stock_id,  products.id as product_id,products.category_id,products.title as product_title,stock.label as stock_label,stock.price as stock_price')->result_array();
                            $add_ons_detail_temp = array();
                            if(!empty($add_ons_detail)) {
                                foreach ($add_ons_detail as $key => $value) {
                                    if(empty($value['stock_label']))
                                        unset($value['stock_label']);
                                    $add_ons_detail_temp[]=$value;
                                }
                            $main['ao_title'] =$pao['title'];
                            $main['ao_required']= FALSE;
                            $main['check'] = 'Addon';
                            if($pao['is_optional'] == 0)
                                $main['ao_required']= FALSE; 
                            $main['add_ons_detail'] = $add_ons_detail_temp;
                            $add_on_data[]=$main;
                            }
                            
                            unset($where_add_on_products);
                            unset($main);
                        }
                    endforeach;
                }
            }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"data_status"=>$data_status,"message"=>$message,"product_detail"=>$product_detail,"product_availability"=>$product_availability,"product_timing"=>$product_timing,"add_on_data"=>$add_on_data));
        }
        function customer_location(){
            $status=false;
            $message="Something went wrong";
            $insert_or_update=0;
            $data['customer_id'] = $this->input->post('user_id');
            $data['location_address'] = $this->input->post('location_address');
            $data['location_street'] = $this->input->post('location_street');
            $data['location_house_no'] = $this->input->post('location_house_no');
            $data['location_type'] = $this->input->post('location_type');
            $data['location_latitude'] = $this->input->post('location_latitude');
            $data['location_longitude'] = $this->input->post('location_longitude');
            $data['cus_area'] = $this->input->post('area');
            $data['city'] = $this->input->post('city');
            $data['country'] = $this->input->post('country');
            $default['location_is_default'] = $this->input->post('location_is_default');
            if(isset($data['customer_id']) && is_numeric($data['customer_id']) && isset($data['location_address']) && !empty($data['location_address'])  && isset($data['location_type']) && !empty($data['location_type']) && isset($data['location_latitude']) && !empty($data['location_latitude']) && isset($data['location_longitude']) && !empty($data['location_longitude']) && $data['location_type']!= "43b5c9175984c071f30b873fdce0a000") {
                $status=true;
                $message="data insert/update";
                $insert_or_update=$this->insert_or_update(array("customer_id"=>$data['customer_id'],"location_type"=>$data['location_type']),$data,'customer_location');
                $user_Locations = Modules::run('slider/_get_where_cols',array("customer_id" =>$data['customer_id'],"location_status" =>'active'),'cl-id desc','customer_location','location_latitude as Lat,location_longitude,location_address as Address,location_street as Street,location_house_no as Houseno,location_type as Type,location_is_default')->result_array();

                if(isset($user_Locations) && !empty($user_Locations) && Count($user_Locations)==1) {
                    $this->insert_or_update(array("customer_id"=>$data['customer_id'],"location_type"=>$data['location_type']),array("location_is_default"=>'0'),'customer_location');
                }

            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"insert_or_update="=>$insert_or_update));
        }
        function customer_default_location(){
            $status=false;
            $message="Something went wrong";
            $data['customer_id'] = $this->input->post('user_id');
            $data['location_type'] = $this->input->post('location_type');
            $default['location_is_default'] = '1';
            if(isset($data['customer_id']) && is_numeric($data['customer_id'])  && isset($data['location_type']) && !empty($data['location_type'])&& isset($default['location_is_default']) && !empty($default['location_is_default']) ) {
                $status=true;
                $message="Default update";
                $this->insert_or_update(array("customer_id"=>$data['customer_id']),array("location_is_default"=>'0'),'customer_location');
                $this->insert_or_update(array("customer_id"=>$data['customer_id'],"location_type"=>$data['location_type']),$default,'customer_location');

            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function customer_location_delete(){
            $status=false;
            $message="Something went wrong";
            $where['customer_id'] = $this->input->post('user_id');
            $where['location_type'] = $this->input->post('location_type');
            if(isset($where['customer_id']) && is_numeric($where['customer_id']) && isset($where['location_type']) && !empty($where['location_type'])) {
                $status=true;
                $message="data insert/update";
                $this->delete_from_specific_table($where,'customer_location');
                }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function restaurant_report(){
            date_default_timezone_set('Asia/Karachi');
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $status=false;
            $message="Something went wrong";
            $insert_or_update=0;
            $data['outlet_id'] = $this->input->post('outlet_id');
            $data['user_id'] = $user_location_data['user_id'];
            $data['user_report'] = $this->input->post('user_report');
            $data['report_date'] = date("Y-m-d");
            $data['report_status'] = '1';
            if(isset($data['outlet_id']) && is_numeric($data['outlet_id']) && isset($data['user_id']) && !empty($data['user_id']) && isset($data['user_report']) && !empty($data['user_report']) && isset($data['report_date']) && !empty($data['report_date']) && isset($data['report_status']) && !empty($data['report_status'])) {
                $status=true;
                $message="Report submitted successfully";
                $insert_or_update=$this->insert_or_update(array("user_id"=>$data['user_id'],"outlet_id"=>$data['outlet_id']),$data,'restaurant_report');
                $status=true;
            $message="Report submitted succesfully";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"insert_or_update="=>$insert_or_update));
        }
        function submit_restaurant_reviews(){
            date_default_timezone_set('Asia/Karachi');
            $status=false;
            $message="Something went wrong";
            $insert_or_update=0;
            $data['outlet_id'] = $this->input->post('outlet_id');
            $data['user_id'] = $this->input->post('user_id');
            $data['user_review'] = $this->input->post('user_review');
            $data['responce_time'] = $this->input->post('responce_time');
            $data['taste'] = $this->input->post('taste');
            $data['behaviour'] = $this->input->post('behaviour');
            $data['environment'] = $this->input->post('environment');
           
            $data['attempt_date'] = date("Y-m-d h:i:s");
          
            if(isset($data['outlet_id']) && is_numeric($data['outlet_id']) && isset($data['user_id']) && !empty($data['user_id']) && isset($data['user_review']) && !empty($data['user_review']) && isset($data['attempt_date']) && !empty($data['attempt_date'])) {
                
                $status=true;
                $message="Review submitted successfully";
                $insert_or_update=$this->insert_or_update(array("user_id"=>$data['user_id'],"outlet_id"=>$data['outlet_id']),$data,'reviews');
            $status=true;
            $message="Review Submitted succesfully";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"insert_or_update="=>$insert_or_update));
        }
        function restaurant_report_delete(){
            $status=false;
            $message="Something went wrong";
            $where['outlet_id'] = $this->input->post('outlet_id');
            $where['user_id'] = $this->input->post('user_id');
            if(isset($where['outlet_id']) && is_numeric($where['outlet_id']) && isset($where['user_id']) && !empty($where['user_id'])) {
                $status=true;
                $message="data insert/update";
                $this->delete_from_specific_table($where,'restaurant_report');
                }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function user_profile_pic_update(){
            $status= false;
            $data=array();
            $message="error";
            $user_id= $this ->input->post('user_id');
            $pro_image =STATIC_FRONT_IMAGE.'user.png';
            $user_data = Modules::run('slider/_get_where_cols',array("id" =>$user_id),'id desc','customers','id,cus_image')->result_array();
            if(empty($user_data))
                $message = "user does not exist";
            if(isset($_FILES['image']) && is_numeric($user_id) && isset($user_data) && !empty($user_data)) {
                if ($_FILES['image']['size'] > 0) {
                    $data=$this->get_specific_table_data(array("id"=>$user_id),"id desc","cus_image","customers","1","1")->result_array();
                    if(!empty($data)){
                        if($_FILES['image']['size']>0) {
                            if(isset($data[0]['cus_image']) && !empty($data[0]['cus_image']))
                                $this->delete_images_by_name(ACTUAL_CUSTOMER_IMAGE_PATH,LARGE_CUSTOMER_IMAGE_PATH,MEDIUM_CUSTOMER_IMAGE_PATH,SMALL_CUSTOMER_IMAGE_PATH,$data[0]['cus_image']);
                            $this->upload_dynamic_image(ACTUAL_CUSTOMER_IMAGE_PATH,LARGE_CUSTOMER_IMAGE_PATH,MEDIUM_CUSTOMER_IMAGE_PATH,SMALL_CUSTOMER_IMAGE_PATH,$user_id,'image','cus_image','id','customers');
                            $query = Modules::run('customers/_get_by_arr_id_for_login',array("id"=>$user_id))->result_array();
                            if(!empty($query)) {
                                if(isset($query[0]['cus_image']) && !empty($query[0]['cus_image']))
                                    if( file_exists(ACTUAL_CUSTOMER_IMAGE_PATH.$query[0]['cus_image']))
                                        $pro_image = BASE_URL.ACTUAL_CUSTOMER_IMAGE_PATH.$query[0]['cus_image'];
                            }
                            $status=true;
                            $message="user image update";
                        }
                    } 
                } 
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message,"Image"=>$pro_image));
        }
        function user_profile_info(){
            $status=false;
            $message="Something went wrong";
            $user_id = $this->input->post('user_id');
            $user_data = Modules::run('slider/_get_where_cols',array("id" =>$user_id),'id desc','customers','*')->result_array();
            if(isset($user_data) && !empty($user_data)) {
                if(isset($user_data[0]['dob']) && !empty($user_data[0]['dob']))
                    if($user_data[0]['dob'] != "0000-00-00")
                        $user_data[0]['dob'] = date("d-m-Y", strtotime($user_data[0]['dob']));
                    else
                        $user_data[0]['dob'] = "00-00-0000";
                else
                    $user_data[0]['dob'] = "00-00-0000";
                $status=true;
                $message="user data found";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"user_data"=>$user_data));
        }
        function user_profile_info_update(){
            $status=false;
            $message="Something went wrong";
            $user_id=0;
            if(isset($_POST['id']) && !empty($_POST['id']))
                $user_id = $_POST['id'];
            if(isset($user_id) && !empty($user_id)) {
                unset($_POST['id']);
                if(isset($_POST['dob']) && !empty($_POST['dob']))
                   $_POST['dob']= date("Y-m-d", strtotime($_POST['dob']));
                    unset($_POST['device']);
                $this->update_specific_table(array("id"=>$user_id),$_POST,'customers');
                $status=true;
                $message="user information update";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function user_referal_code_info(){
            $status=false;
            $user_data = array();
            $myRefLinks=array();
            $message="Something went wrong";
            $user_id=$this->input->post('user_id');
            $page_number=$this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit=$this->input->post('limit');
            if(!is_numeric($limit))
                $limit = 20;
            $total_pages=0;
            $isMyRefCodeAdded=false;
            if(isset($user_id) && !empty($user_id)) {
                $user_data = Modules::run('slider/_get_where_cols',array("id" =>$user_id),'id desc','customers','id,name,user_referal_code')->result_array();
                if(!empty($user_data)) {
                    $status = true;
                    $message = "user record found";
                    if(isset($user_data[0]['user_referal_code']) && !empty($user_data[0]['user_referal_code'])) {
                        $myRefLinks = $this->_get_specific_table_with_pagination(array("from_referal_code" =>$user_data[0]['user_referal_code']),'id desc','customers','id,name,user_referal_code,from_referal_code',$page_number,$limit)->result_array();
                        if(!empty($myRefLinks)) {
                            $isMyRefCodeAdded = true;
                            $total_pages = $this->_get_specific_table_with_pagination(array("from_referal_code" =>$user_data[0]['user_referal_code']),'id desc','customers','id,name,user_referal_code,from_referal_code',$page_number,'0')->num_rows();
                            $diviser=($total_pages/$limit);
                            $reminder=($total_pages%$limit);
                            if($reminder>0)
                               $total_pages=intval($diviser)+1;
                            else
                                $total_pages=intval($diviser);
                        }
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"isMyRefCodeAdded"=>$isMyRefCodeAdded,"message"=>$message,"user_data"=>$user_data,"myRefLinks"=>$myRefLinks,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        function add_user_referal_code(){
            $status=false;
            $message="Something went wrong";
            $user_id=$this->input->post('user_id');
            $referral_code=$this->input->post('referral_code');
            $user_data = Modules::run('slider/_get_where_cols',array("id" =>$user_id),'id desc','customers','id,name,user_referal_code')->result_array();
            if(isset($user_id) && !empty($user_id) && !empty($user_data) && !empty($referral_code)) {
                $ref['from_referal_code']=$referral_code;
                $query = Modules::run('customers/_update_id_front_login', $user_id, $ref);
                $status=true;
                $message="user information update";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function user_favourites_products(){
            $status=false;
            $favourite_products = array();
            $message="Something went wrong";
            $user_id=$this->input->post('user_id');
            $page_number=$this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit=$this->input->post('limit');
            if(!is_numeric($limit))
                $limit = 20;
            $total_pages=0;
            $final_favourite=array();
            if(isset($user_id) && !empty($user_id)) {
                $status = true;
                $message = "user record found";
                $favourite_products = $this->_get_user_favourite_products_with_pagination(array("user_id" =>$user_id),'favourite_food.id as fav_id,favourite_food.outlet_id as fav_outlet,favourite_food.product_id as fav_pid,customers.id as c_id,customers.name as c_name,outlet.id as outlet_id,outlet.name as outlet_name',$page_number,$limit)->result_array();
                if(!empty($favourite_products)) {
                    $total_pages = $this->_get_user_favourite_products_with_pagination(array("user_id" =>$user_id),'favourite_food.id as fav_id,favourite_food.outlet_id as fav_outlet,favourite_food.product_id as fav_pid,customers.id as c_id,customers.name as c_name,outlet.id as outlet_id,outlet.name as outlet_name',$page_number,'0')->num_rows();
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                    foreach ($favourite_products as $key => $fav) {
                        $fav['product_title'] = $fav['product_image'] = $fav['product_min_price'] = $fav['add_on_id'] = '';
                        $fav['discount'] = 0;
                        if(!empty($fav['fav_outlet']) && !empty($fav['fav_pid'])) {
                            $product= Modules::run('catagories/_get_product_detail_with_min_value', array('products.id'=>$fav['fav_pid']),$product_name='', $outlet_id= $fav['fav_outlet'],"products.title as product_title,products.image as product_image,MIN(stock.price) as product_min_price,category_id,product_discount,products.add_on_id as add_on_id")->result_array();
                            if(isset($products[0]['category_id']) && !empty($products[0]['category_id'])) {
                                $category_discount=Modules::run('slider/_get_where_cols',array("cd_cat_id" =>$products[0]['category_id']),'cd_cat_id desc', $outlet_id.'_category_discount','cd_discount')->result_array();
                                if(isset($category_discount) && !empty($category_discount))
                                    $fav['discount'] = $fav['discount'] + $category_discount[0]['cd_discount'];
                            }
                            if(isset($products[0]['product_discount']) && !empty($products[0]['product_discount']))
                                    $fav['discount'] = $fav['discount'] + $products[0]['product_discount'];
                            unset($product[0]['product_discount']);
                        }

                        $fav=array_merge($fav,$product[0]);
                        if(!empty($fav['product_image']))
                            $fav['product_image']=$this->image_path_with_default(ACTUAL_ITEMS_IMAGE_PATH.$fav['fav_outlet'].'/',$fav['product_image'],STATIC_FRONT_IMAGE,'pattren.png');
                        $final_favourite[]=$fav;


                    }
                    
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"favourite_products"=>$final_favourite,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        function user_favourite_products_add_or_delete(){
            $status=false;
            $message="Something went wrong";
            $outlet_id=$this->input->post('outlet_id');
            $user_id=$this->input->post('user_id');
            $product_id=$this->input->post('product_id');
            $insert_or_delete =0;
            if(isset($outlet_id) && is_numeric($outlet_id) && isset($user_id) && is_numeric($user_id)&& isset($product_id) && is_numeric($product_id)) {
                $insert_or_delete = $this->insert_or_delete(array("user_id"=>$user_id,"outlet_id"=>$outlet_id,"product_id"=>$product_id),array("user_id"=>$user_id,"outlet_id"=>$outlet_id,"product_id"=>$product_id),'favourite_food');
                if($insert_or_delete == 0)
                    $message="product is un favourite now";
                else
                    $message="product is favourite now";
                $status=TRUE;
             
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"insert_or_delete"=>$insert_or_delete));
        }
        function customer_password_reset(){
            $status=false;
            $message="Something went wrong!";
            $old_password=$this->input->post('old_password');
            $new_password=$this->input->post('new_password');
            $user_id=$this->input->post('user_id');
            if(isset($user_id) && is_numeric($user_id) && isset($old_password) && !empty($old_password)&& isset($new_password) && !empty($new_password)) {
                $where_check['id'] = $user_id;
                $where_check['password'] = Modules::run('site_security/make_hash', $old_password);
                $query = Modules::run('customers/_get_by_arr_id_for_login', $where_check)->result_array();
                if (!empty($query)) {
                    $data['password'] = Modules::run('site_security/make_hash', $new_password);
                    $query = Modules::run('customers/_update_id_front_login', $user_id, $data);
                        $status = TRUE;
                        $message = "Password changed successfully";
                } 
                else
                    $message = "Incorrect Password";
             
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }
        function outlet_categories(){
            $status=false;
            $message="Something went wrong!";
            $catagories_record=array();
            $cat_record = Modules::run('slider/_get_where_cols',array("status" =>'1'),'id desc','outlet_types','id,type as name,type_image as image')->result_array();
            if(isset($cat_record) && !empty($cat_record)) {
                foreach ($cat_record as $key => $cat):
                    $cat['type_image'] = $this->image_path_with_default(ACTUAL_OUTLET_TYPE_IMAGE_PATH,$cat['type_image'],STATIC_FRONT_IMAGE,'pattren.png');
                    $catagories_record[]=$cat;
                endforeach;
                
                $status=true;
                $message="outlet catagories";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"catagories_record"=>$catagories_record));
        }
        function get_catagory_outlets(){
            $status=false;
            $message="Something went wrong";
            $catagories_outlets=array();
            $cat_id=$this->input->post('catagory_id');
            $page_number=$this->input->post('page_number');
            if(!isset($page_number) || !is_numeric($page_number))
                $page_number = 1;
            $limit=$this->input->post('limit');
            if(!isset($limit) || !is_numeric($limit))
                $limit = 20;
            $total_pages = 0;
            if(isset($cat_id) && is_numeric($cat_id)) {
                $cat_record =$this->get_catagories_outlets(array("outlet_catagories.outlet_catagory"=>$cat_id),'outlet.id as outlet_id,outlet.name as outlet_name,outlet.image as outlet_image','outlet_catagories.outlet_id desc',$page_number,$limit);
                $total_pages =$cat_record->num_rows();
                $cat_record = $cat_record->result_array();
                if(!empty($cat_record)) {
                    foreach ($cat_record as $key => $cat):
                        $cat['outlet_image'] = $this->image_path_with_default(ACTUAL_OUTLET_TYPE_IMAGE_PATH,$cat['type_image'],STATIC_FRONT_IMAGE,'pattren.png');
                        $catagories_outlets[]=$cat;
                    endforeach;
                    $status=true;
                    $message="user information update";
                }
                if($total_pages > 0) {
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"catagories_outlets"=>$catagories_outlets,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        function outlet_types(){
            $status=false;
            $message="Something went wrong";
            $outlet_types=array();
            $page_number=$this->input->post('page_number');
            if(!isset($page_number) || !is_numeric($page_number))
                $page_number = 1;
            $limit=$this->input->post('limit');
            if(!isset($limit) || !is_numeric($limit))
                $limit = 20;
            $total_pages = 0;
            $distance=$this->input->post('distance');
            if(empty($distance) || !is_numeric($distance))
                $distance='5.67';
           $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_lat=$user_location_data['Lat'];
            $user_long=$user_location_data['Long'];
    
            $outlet_types =array();
            $offset=($page_number-1)*$limit;
            if(!empty($user_lat) && !empty($user_long)) {
                $maxLat=$minLat=$maxLon=$minLon="";
                if(!empty($distance) && !empty($user_lat) && !empty($user_long)) {
                    $R="6371";
                    $maxLat = $user_lat + rad2deg($distance/$R);
                    $minLat = $user_lat - rad2deg($distance/$R);
                    $maxLon = $user_long + rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                    $minLon = $user_long - rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                }
                $outlets=$this->get_nearest_outlest(array("outlet.latitude >=" =>$minLat,"outlet.latitude <=" =>$maxLat,"outlet.longitude >=" =>$minLon,"outlet.longitude <=" =>$maxLon,"outlet.status"=>1),"",'id desc')->result_array();
                if(!empty($outlets)) {
                    $temp =array();
                    foreach($outlets as $out){
                    $temp =$this->_get_outlet_types(array("outlet_catagories.outlet_id"=>$out['id']), "outlet_catagories.id desc",'outlet_catagories.outlet_catagory,catagories.id,catagories.cat_name as type,catagories.image as type_image','1','0')->result_array();
                    
               
                    
                    if(!empty($temp)) {
                        foreach ($temp as $key => $value) {
                            $check2 = array_search($value['outlet_catagory'], array_column($outlet_types,'outlet_catagory'));
                            if(empty($check2)  ) {
                                $path=STATIC_FRONT_IMAGE.'pattren.png';
                                if(file_exists(ACTUAL_CATAGORIES_IMAGE_PATH.$value['type_image']))
                                    $path = BASE_URL.ACTUAL_CATAGORIES_IMAGE_PATH.$value['type_image'];
                                $value['type_image'] = $path;
                                if(isset($value['outlet_catagory']))
                                unset($value['outlet_catagory']);
                                $outlet_types[] = $value;
                            }
                        }
                    }
                    }
                }
                $outlet_types=array_map("unserialize", array_unique(array_map("serialize", $outlet_types)));
                if(!empty($outlet_types)) {
                    $status = true;
                    $message = "data fetched";
                    $total_pages = count($outlet_types);
                    if($total_pages >0) {
                        $diviser=($total_pages/$limit);
                        $reminder=($total_pages%$limit);
                        if($reminder>0)
                           $total_pages=intval($diviser)+1;
                        else
                            $total_pages=intval($diviser);
                    }
                    if($page_number > $total_pages) {
                        $message = "Invalid page number:)";
                        $status = false;
                        $outlet_types = array();
                    }
                    else
                        $outlet_types =array_slice($outlet_types, $offset,$limit);
                }
                else
                    $message = "no catagory found";
            }
            else 
                $message = "No nearest food point found";
            if($status == false  && $page_number > 1 && $page_number < $total_pages  && empty($outlet_types)) {
                $message = "";
                $status = true;
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"outlet_types"=>$outlet_types,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        function checkout_info(){
            $status=false;
            $message="Something went wrong!";
            $outlet_id=$this->input->post('outlet_id');
            $taxes=array();
            $card_taxes=array();
            $discounts=array();
            $post_code=$this->input->post('post_code');
            $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_latitude=$user_location_data['Lat'];
            $user_longitude=$user_location_data['Long'];
            $delivery_charges =0;
            $delivery_status = false;
            $delivery_message = "Something went wrong!";
            $order_type = array();
            $payment_type=array();
            if(is_numeric($outlet_id)) {
                $out_record = Modules::run('slider/_get_where_cols',array("id" =>$outlet_id),'id desc','outlet','longitude,latitude,percentage,name')->result_array();
                $general_record = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','take_in_vat,take_out_vat,card_tax,delivery_charges_vat,dc_per_km,delivery_km_range,free_delivery_km_range,discount,delivery_charges,timezones,take_in,take_out,delivery,is_cash_on_delivery,is_online_cash')->result_array();
                if(!empty($out_record) && !empty($general_record)) {
                    $status = true;
                    $message = "";
                    $takein=array();
                    $default_payment="";
                    if(isset($general_record[0]['is_online_cash']) && $general_record[0]['is_online_cash'] > 0) {
                        $default_payment=2;
                        $temp_order_type = array();
                        $temp_order_type['Type'] = 'Credit card';
                        $temp_order_type['Val'] = 2 ;
                        if(!empty($temp_order_type))
                            $payment_type[] = $temp_order_type;
                    }
                    if(isset($general_record[0]['is_cash_on_delivery']) && $general_record[0]['is_cash_on_delivery'] > 0) {
                        if(empty($default_payment))
                        $default_payment=1;
                        $temp_order_type = array();
                        $temp_order_type['Type'] = 'Cash';
                        $temp_order_type['Val'] =1;
                      
                        if(!empty($temp_order_type))
                            $payment_type[] = $temp_order_type;
                    }
                   
                     if(empty($payment_type)) {
                          $default_payment=2;
                            $temp_order_type = array();
                            $temp_order_type['Type'] = 'Credit card';
                            $temp_order_type['Val'] = 2 ;
                            if(!empty($temp_order_type))
                                $payment_type[] = $temp_order_type;
                        }
                    if(isset($general_record[0]['take_in']) && $general_record[0]['take_in'] > 0) {
                        $temp_order_type = array();
                        $temp_order_type['Type'] = 'Take In';
                        $temp_order_type['Val'] = 'takein';
                        if(!empty($temp_order_type))
                            $order_type[] = $temp_order_type;
                    }
                    if(isset($general_record[0]['take_out']) && $general_record[0]['take_out'] > 0) {
                        $temp_order_type = array();
                        $temp_order_type['Type'] = 'Take Away';
                        $temp_order_type['Val'] = 'takeaway';
                        if(!empty($temp_order_type))
                            $order_type[] = $temp_order_type;
                    }
                    if(isset($general_record[0]['delivery']) && $general_record[0]['delivery'] > 0) {
                        $temp_order_type = array();
                        $temp_order_type['Type'] = 'Delivery';
                        $temp_order_type['Val'] = 'delivery';
                        if(!empty($temp_order_type))
                            $order_type[] = $temp_order_type;
                    }
                    if(isset($general_record[0]['take_in_vat']) && $general_record[0]['take_in_vat'] > 0) {
                        $takein[0]['tax_name'] = 'Take In Vat';
                        $takein[0]['tax_type'] = '%';
                        $takein[0]['tax_amount'] = $general_record[0]['take_in_vat'];
                    }
                    if(!empty($takein))
                        $taxes['takein'] =$takein;
                    $takeaway=array();
                    if(isset($general_record[0]['take_out_vat']) && $general_record[0]['take_out_vat'] > 0) {
                        $takeaway[0]['tax_name'] = 'Take away Vat';
                        $takeaway[0]['tax_type'] = '%';
                        $takeaway[0]['tax_amount'] = $general_record[0]['take_out_vat'];
                    }
                    if(!empty($takeaway))
                        $taxes['takeaway'] =$takeaway;
                    $delivery=array();
                    if(isset($general_record[0]['delivery_charges_vat']) && $general_record[0]['delivery_charges_vat'] > 0) {
                        $delivery[0]['tax_name'] = 'delivery vat charges';
                        $delivery[0]['tax_type'] = '%';
                        $delivery[0]['tax_amount'] = $general_record[0]['delivery_charges_vat'];
                        $delivery[1]['tax_name'] = 'Take away Vat';
                        $delivery[1]['tax_type'] = '%';
                        $delivery[1]['tax_amount'] = $general_record[0]['take_out_vat'];
                    }
                    if(!empty($delivery))
                        $taxes['delivery'] =$delivery;
                    
                     $credit_tax=array();
                     
                    if(isset($general_record[0]['card_tax']) && $general_record[0]['card_tax'] > 0) {
                        $credit_tax[0]['charges_name'] = 'Transaction Charges';
                        $credit_tax[0]['charges_type'] = 'Kr';
                        $credit_tax[0]['charges_amount'] = $general_record[0]['card_tax'];
                    }
                    else{
                        $credit_tax[0]['charges_name'] = 'Transaction Charges';
                        $credit_tax[0]['charges_type'] = 'Kr';
                        $credit_tax[0]['charges_amount'] =1.67;
                    }
                    
                    if(!empty($credit_tax))
                        $card_taxes =$credit_tax;
                    $delivery=array();
                    if(isset($general_record[0]['discount']) && $general_record[0]['discount'] > 0) {
                        $delivery[0]['discount_name'] =$out_record[0]['name'].' Discount';
                        $delivery[0]['discount_type'] = '%';
                        $delivery[0]['discount_amount'] = $general_record[0]['discount'];
                        
                    }
                    if(isset($out_record[0]['percentage']) && $out_record[0]['percentage'] > 0) {
                        $delivery[1]['discount_name'] ='Dinehome Discount';
                        $delivery[1]['discount_type'] = '%';
                        $delivery[1]['discount_amount'] = $out_record[0]['percentage'];
                    }
                    if(!empty($delivery))
                        $discounts['delivery'] =$delivery;
                }
                
                if(is_numeric($post_code) && is_numeric($outlet_id) && is_numeric($user_latitude) && is_numeric($user_longitude)) {
                    if(!empty($out_record) && !empty($general_record)) {
                        date_default_timezone_set($general_setting[0]['timezones']);
                        $day=date("l");
                        $delivery_status = true;
                        $delivery_message = "Delivery charges has been calculated";
                        if(isset($out_record[0]['latitude']) && !empty($out_record[0]['latitude']) && isset($out_record[0]['longitude']) && !empty($out_record[0]['longitude'])) {
                            $responce=file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$user_latitude.','.$user_longitude.'&destinations='.$out_record[0]['latitude'].','.$out_record[0]['longitude'].'&key=AIzaSyCh3gFtkJ80krj9k4MCgXbcLGD6NoT7_D8');
                            $responce=json_decode($responce);
                            $outer_status=$responce->status;
                            $inner_status=$responce->rows[0]->elements[0]->status;
                            
                            if(isset($outer_status) && $outer_status=="OK" && isset($inner_status) && $inner_status=="OK" ){
                            $distance = ceil(preg_replace("/[^0-9.]/", "", $responce->rows[0]->elements[0]->distance->text));
                            
                            if($distance > $general_record[0]['delivery_km_range'] || $general_record[0]['delivery_km_range'] <= "0") {
                                $delivery_status = false;
                                $delivery_message = "Sorry we don't serve at your location currently";
                            }
                            else {
                                $post_code_charges= Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id,"post_code"=>$post_code,"delivery_day"=>$day),'id desc','post_code_delivery','delivery_charges')->result_array();
                                if(isset($post_code_charges[0]['delivery_charges']) && !empty($post_code_charges[0]['delivery_charges']))
                                    $delivery_charges = $delivery_charges+$post_code_charges[0]['delivery_charges'];
                                else {
                                    $code_charges= Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id,"post_code"=>$post_code),'id desc','post_code_delivery','delivery_charges')->result_array();
                                    if(isset($code_charges[0]['delivery_charges']) && !empty($code_charges[0]['delivery_charges']))
                                        $delivery_charges = $delivery_charges+$code_charges[0]['delivery_charges'];
                                    else
                                        if(isset($general_record[0]['delivery_charges']) && !empty($general_record[0]['delivery_charges']))
                                            $delivery_charges =$delivery_charges+ $general_record[0]['delivery_charges'];
                                        else
                                            $delivery_charges = "74";
                                }   
                                if($distance <= $general_record[0]['free_delivery_km_range'])
                                    $delivery_charges = $delivery_charges+0;
                                else {
                                    $difference_distance = $distance - $general_record[0]['free_delivery_km_range'];
                                    $delivery_charges =$delivery_charges+($difference_distance*$general_record[0]['dc_per_km']);
                                }
                            }
                            }
                            else{
                                 $status = false;
                                 $message = "Something went wrong with your location";
                            }
                        }
                    }
                    else
                        $delivery_message = "Sorry outlet is closed now.";
                }
                else
                    $delivery_message = "Please enter your postcode.";
            }
            $is_copen=false;
            $check_copen=$out_record = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','is_coupon')->result_array();
           if(isset($check_copen) && !empty($check_copen) && $check_copen[0]['is_coupon'])
           $is_copen=true;
         
            if(!empty($taxes) && !empty($discounts))
                $array=array("status"=>$status,"is_coupon"=>$is_copen,"message"=>$message,"taxes"=>$taxes,"discounts"=>$discounts);
            elseif(!empty($taxes))
                $array=array("status"=>$status,"is_coupon"=>$is_copen,"message"=>$message,"taxes"=>$taxes);
            else
                 $array=array("status"=>$status,"is_coupon"=>$is_copen,"message"=>$message,"discounts"=>$discounts);
             if(!empty($payment_type))
                $array['payment_type'] =$payment_type;
            if(!empty($card_taxes))
                $array['other_charges']=$card_taxes;
            if(!empty($user_latitude) && !empty($user_longitude)) {
                $array['delivery_charges']=$delivery_charges;
                $array['delivery_status']=$delivery_status;
                $array['delivery_message']=$delivery_message;
            }
            if(empty($order_type)) {
                $temp_order_type = array();
                $temp_order_type['Type'] = 'Take Away';
                $temp_order_type['Val'] = 'takeaway';
                if(!empty($temp_order_type))
                    $order_type[] = $temp_order_type;
            }
            $array['default_payment']=$default_payment;
            $array['order_type']=$order_type;
            
            header('Content-Type: application/json');
            echo json_encode($array);
        }
        /*function distance_wise_charges(){
            $status=false;
            $message="Something went wrong! \nPlease update your location";
            $outlet_id=$this->input->post('outlet_id');
            $user_latitude=$this->input->post('lat');
            $user_longitude=$this->input->post('long');
            $delivery_charges =0;
            if(is_numeric($outlet_id) && is_numeric($user_latitude) && is_numeric($user_longitude)) {
                $out_record = Modules::run('slider/_get_where_cols',array("id" =>$outlet_id),'id desc','outlet','longitude,latitude,percentage,name')->result_array();
                $general_record = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','take_in_vat,take_out_vat,delivery_charges_vat,dc_per_km,delivery_km_range,free_delivery_km_range,discount')->result_array();
                if(!empty($out_record) && !empty($general_record)) {
                    $status = true;
                    $message = "Delivery charges has been calculated";
                    if(isset($out_record[0]['latitude']) && !empty($out_record[0]['latitude']) && isset($out_record[0]['longitude']) && !empty($out_record[0]['longitude']) ) {
                        $responce=file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$user_latitude.','.$user_longitude.'&destinations='.$out_record[0]['latitude'].','.$out_record[0]['longitude'].'&key=AIzaSyDIHoHvIosxw4wz4bDEKzfcPzCPFmPA5rw');
                        $responce=json_decode($responce);
                        $distance = round($responce->rows[0]->elements[0]->distance->text);
                        if($distance > $general_record[0]['delivery_km_range']) {
                            $status = false;
                            $message = "Sorry we don't serve at your location currently";
                        }
                        else {
                            if($distance <= $general_record[0]['free_delivery_km_range'])
                                $delivery_charges = 0;
                            else {
                                $difference_distance = $distance - $general_record[0]['free_delivery_km_range'];
                                $delivery_charges = $difference_distance*$general_record[0]['dc_per_km'];
                            }
                        }
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"delivery_charges"=>$delivery_charges));
        }*/
        function distance_wise_charges(){
            $status=false;
            $message="Something went wrong! \nPlease update your location";
            $outlet_id=$this->input->post('outlet_id');
            $post_code=$this->input->post('area');
            $user_latitude=$this->input->post('lat');
            $user_longitude=$this->input->post('long');
            $delivery_charges =0;
            if(!empty($post_code) && is_numeric($outlet_id) && is_numeric($user_latitude) && is_numeric($user_longitude)) {
                $out_record = Modules::run('slider/_get_where_cols',array("id" =>$outlet_id),'id desc','outlet','longitude,latitude,percentage,name')->result_array();
                $general_record = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','take_in_vat,take_out_vat,delivery_charges_vat,dc_per_km,delivery_km_range,free_delivery_km_range,discount,delivery_charges,timezones')->result_array();
                if(!empty($out_record) && !empty($general_record)) {
                    date_default_timezone_set($general_record[0]['timezones']);
                    $day=date("l");
                    $status = true;
                     
                    $message = "Delivery charges has been calculated";
                    if(isset($out_record[0]['latitude']) && !empty($out_record[0]['latitude']) && isset($out_record[0]['longitude']) && !empty($out_record[0]['longitude'])) {
                        $responce=file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.$user_latitude.','.$user_longitude.'&destinations='.$out_record[0]['latitude'].','.$out_record[0]['longitude'].'&key=AIzaSyCh3gFtkJ80krj9k4MCgXbcLGD6NoT7_D8');
                        $responce=json_decode($responce);
                        $outer_status=$responce->status;
                        $inner_status=$responce->rows[0]->elements[0]->status;
                       
                        if(isset($outer_status) && $outer_status=="OK" && isset($inner_status) && $inner_status=="OK" ){
                        $distance = ceil(preg_replace("/[^0-9.]/", "", $responce->rows[0]->elements[0]->distance->text));
                    
                        if($distance > $general_record[0]['delivery_km_range']  || $general_record[0]['delivery_km_range'] <= "0") {
                            $status = false;
                            $message = "Sorry we don't serve at your location currently";
                        }
                        else {
                            $post_code_charges= Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id,"post_code"=>$post_code,"delivery_day"=>$day),'id desc','post_code_delivery','delivery_charges')->result_array();
                            if(isset($post_code_charges[0]['delivery_charges']) && !empty($post_code_charges[0]['delivery_charges']))
                                $delivery_charges = $delivery_charges+$post_code_charges[0]['delivery_charges'];
                            else {
                                $code_charges= Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id,"post_code"=>$post_code),'id desc','post_code_delivery','delivery_charges')->result_array();
                                if(isset($code_charges[0]['delivery_charges']) && !empty($code_charges[0]['delivery_charges']))
                                    $delivery_charges = $delivery_charges+$code_charges[0]['delivery_charges'];
                                else
                                    if(isset($general_record[0]['delivery_charges']) && !empty($general_record[0]['delivery_charges']))
                                        $delivery_charges =$delivery_charges+ $general_record[0]['delivery_charges'];
                                    else
                                        $delivery_charges = "0";
                            }   
                            if($distance <= $general_record[0]['free_delivery_km_range'])
                                $delivery_charges = $delivery_charges+0;
                            else {
                                $difference_distance = $distance - $general_record[0]['free_delivery_km_range'];
                                $delivery_charges =$delivery_charges+($difference_distance*$general_record[0]['dc_per_km']);
                            }
                        }
                        }
                        else{
                             $status = false;
                             $message = "Something went wrong with your location";
                        }
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"delivery_charges"=>$delivery_charges));
        }
        function promo_code_discount(){
            $status=false;
            
            $message="Something went wrong!";
            $outlet_id=$this->input->post('outlet_id');
            $promo_code=$this->input->post('promo_code');
            $order_price=$this->input->post('order_price');
            $postal_code=$this->input->post('postal_code');
            $user_id=$this->input->post('user_id');
            $discount_status =false;
            $discount ="0";
            if(is_numeric($outlet_id) && !empty($promo_code) && is_numeric($order_price) && !empty($postal_code) && is_numeric($user_id)) {
                $message="Your have entered invalid code";
                $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                if(!empty($general_setting)) {
                    date_default_timezone_set($general_setting[0]['timezones']);
                    $now_date=date("Y-m-d H:i:s");
                    $campaign_record = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id,"coupon_code" =>$promo_code,"amount_limit >=" =>$order_price,"date_start <=" =>$now_date,"date_end >=" =>$now_date),'id desc','campaign','id,is_allow_mulitple_times,amount')->result_array();
                    if(isset($campaign_record[0]['id']) && !empty($campaign_record[0]['id'])) {
                        $status = true;
                        $message="";
                        $check=true;
                        $message_check=true;
                        $campaign_towns = Modules::run('slider/_get_where_cols',array("ct_campaign_id" =>$campaign_record[0]['id']),'ct_id desc','campaign_towns','ct_town_id')->result_array();
                        $post_towns = Modules::run('slider/_get_where_cols',array("postcode" =>$postal_code),'tpc_id desc','town_postcodes','tpc_town_id')->result_array();
                        if(!isset($post_towns[0]['tpc_town_id']) || empty($post_towns[0]['tpc_town_id'])) {
                            $check =false;
                            $message = "Coupon is not valid for your Area!";
                            $message_check=false;
                        }
                        if(!empty($campaign_towns) && isset($post_towns[0]['tpc_town_id'])) {
                            $block_check = array_search($post_towns[0]['tpc_town_id'], array_column($campaign_towns, 'ct_town_id'));
                            if(!is_numeric($block_check)) {
                                $check =false;
                                if($message_check != false) {
                                    $message = "Coupon has been used";
                                    $message_check=false;
                                }
                            }
                        }
                        $campaign_customers = Modules::run('slider/_get_where_cols',array("campaign_id" =>$campaign_record[0]['id'],"customer_id"=>$user_id,"is_used"=>'0'),'id desc','campaign_customers','id')->result_array();
                        if(!empty($campaign_customers)) {
                            $check =false; 
                            if($message_check != false) {
                                $message = "Coupon has been used";
                                $message_check=false;
                            }
                        }
                        $used_campaign= Modules::run('slider/_get_where_cols',array("campaign_id" =>$campaign_record[0]['id'],"is_used"=>'0'),'id desc','campaign_customers','COUNT(id) as total')->result_array();
                        if($used_campaign[0]['total'] > $campaign_record[0]['is_allow_mulitple_times']) {
                            $check=false;
                            if($message_check != false) 
                                $message ="Coupon Expired!";
                        }
                            

                        if($check == true) {
                            $discount_status =true;
                            $discount=$campaign_record[0]['amount'];
                        }
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"discount_status"=>$discount_status,"discount"=>$discount));
        }
        function search_for_resturants() {
            $status=false;
            $message="Something went wrong";
            $distance=$this->input->post('distance');
            if(empty($distance) || !is_numeric($distance))
                $distance='5.67';
           
            /*$user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
            $user_lat=$user_location_data['Lat'];
            $user_long=$user_location_data['Long'];*/
            $user_lat=28.42540504;
            $user_long=70.30860359;
            $category_id=$this->input->post('category_id');
            
            $user_id = $user_location_data['user_id'];
            if(!$category_id > 0 || !is_numeric($category_id))
                $category_id="";
            $outlet_name=$this->input->post('outlet_name');
            $min_price=$this->input->post('min_price');
            $max_price=$this->input->post('max_price');
            $page_number=$this->input->post("page_number");
            if(empty($page_number))
                $page_number = 1;
            $limit=$this->input->post("limit");
            if(empty($limit))
                $limit = 20;
            $total_pages=0;
            $offset=($page_number-1)*$limit;
       
            /*$min_price=0;
            $max_price=100;*/
            $dietary=$this->input->post('dietary');
            if(!empty($dietary)) {
                $dietary = explode(",",$dietary);
            }
            /*$dietary[]=3;
            $dietary[]=4;*/
            /*$order_by='delivery_time';*/
            $order_by = $this->input->post("order_by");
            $image_check=true;
            if($order_by == 'popular') {
                $order_by = "popular desc";
            }
            elseif($order_by == 'rating') {
                $order_by = "rating desc";
            }
            elseif($order_by == 'delivery_time') {
                $order_by = "delivery_time asc";
            }
            else {
                $order_by = 'page_rank asc';
            }
            if(isset($user_lat) && is_numeric($user_lat) && isset($user_long) && is_numeric($user_long)) {
                $status = true;
                $message = "outlet data";
                $maxLat=$minLat=$maxLon=$minLon="";
                if(!empty($distance) && !empty($user_lat) && !empty($user_long)) {
                    $R="6371";
                    $maxLat = $user_lat + rad2deg($distance/$R);
                    $minLat = $user_lat - rad2deg($distance/$R);
                    $maxLon = $user_long + rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                    $minLon = $user_long - rad2deg(asin($distance/$R) / cos(deg2rad($user_lat)));
                }
                if(empty($category_id) && !is_numeric($category_id))
                    $outlets=$this->get_nearest_outlest(array("outlet.latitude >=" =>$minLat,"outlet.latitude <=" =>$maxLat,"outlet.longitude >=" =>$minLon,"outlet.longitude <=" =>$maxLon,"outlet.status"=>"1"),array("outlet.name"=>$outlet_name),$order_by)->result_array();
                else
                    $outlets=$this->get_nearest_outlest(array("outlet.latitude >=" =>$minLat,"outlet.latitude <=" =>$maxLat,"outlet.longitude >=" =>$minLon,"outlet.longitude <=" =>$maxLon,"outlet_catagories.outlet_catagory"=>$category_id,"outlet.status"=>"1"),array("outlet.name"=>$outlet_name),$order_by)->result_array();
           
                $temp_price=array();
                if(isset($min_price) && is_numeric($min_price) && !empty($min_price) && !empty($max_price) && isset($max_price) && is_numeric($max_price) && !empty($outlets)) {
                    foreach ($outlets as $key => $out) {
                        $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id']),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
                        if($image_check == true) {
                            $out['image'] = $this->image_path_with_default(ACTUAL_OUTLET_TYPE_IMAGE_PATH,$out['image'],STATIC_FRONT_IMAGE,'pattren.png');
                            $out['logo'] = $this->image_path_with_default(ACTUAL_OUTLET_IMAGE_PATH,$out['logo'],STATIC_FRONT_IMAGE,'pattren.png');
                        }
                        if(!empty($out['delivery_time']))
                            $out['delivery_time'] = $out['delivery_time']." Mins";
                        else {
                            if(isset($out['delivery_time']))
                                unset($out['delivery_time']);
                        }
                        if(empty($out['rating']))
                            $out['rating'] = "0.0";
                        else
                            $out['rating'] = round($out['rating'], 2);
                        $out['followstatus'] = false;
                        if(isset($user_id) && is_numeric($user_id)) {
                            $favourite = Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id'],"of_user_id" =>$user_id),'of_id desc','outlet_favourite','outlet_favourite.of_id,outlet_favourite.of_outlet_id,outlet_favourite.of_user_id')->result_array();
                            if(!empty($favourite))
                                $out['followstatus'] = true;
                        if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                             $out['followers']=$follewers[0]['followers'];
                             $follewers="";
                         if(isset($out['outlet_slogan']) && !empty($out['outlet_slogan']))
                         $out['featured']=$out['outlet_slogan'];
                         else
                         $out['featured']='featured';
                         
                          $total_discount=$out['discount']+$out['percentage'];
                      if(!empty($total_discount))
                      $out['discount']=$total_discount;
                   // $arr_data['Type']='slider';
                        $time=$this->outlet_open_close($out['id']);
                        if($time=="Closed")
                        $out['open_close']=$time;
                        $cat=$this->get_restaurant_categories($out['id']);
                        if(!empty($cat))
                        $out['catagories']=$cat;
                        $out['followstatus']=$this->check_favourite_outlet($user_id,$out['id']);
                        }
                        $product=$this->get_outlet_product_max_min_price(array("outlet.id"=>$out['id']),$out['id'],array("min_price >="=>$min_price,"max_price <="=>$max_price))->result_array();
                        if(!empty($product))
                            $temp_price[]=$out;
                    }
                    $image_check =false;
                    $outlets = $temp_price;
                }
                $temp_array=array();
                if(!empty($outlets) && !empty($dietary)) {
                    foreach ($outlets as $key => $out) {
                         $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id']),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
                        if($image_check == true) {
                            $out['image'] = $this->image_path_with_default(ACTUAL_OUTLET_TYPE_IMAGE_PATH,$out['image'],STATIC_FRONT_IMAGE,'pattren.png');
                            $out['logo'] = $this->image_path_with_default(ACTUAL_OUTLET_IMAGE_PATH,$out['logo'],STATIC_FRONT_IMAGE,'pattren.png');
                        }
                        if(!empty($out['delivery_time']))
                            $out['delivery_time'] = $out['delivery_time']." Mins";
                        else
                            unset($out['delivery_time']);
                        if(empty($out['rating']))
                            $out['rating'] = "0.0";
                        $out['followstatus'] = false;
                        if(isset($user_id) && is_numeric($user_id)) {
                            $favourite = Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id'],"of_user_id" =>$user_id),'of_id desc','outlet_favourite','outlet_favourite.of_id,outlet_favourite.of_outlet_id,outlet_favourite.of_user_id')->result_array();
                            if(!empty($favourite))
                                $out['followstatus'] = true;
                                
                        }
                        if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                             $out['followers']=$follewers[0]['followers'];
                             $follewers="";
                           if(isset($out['outlet_slogan']) && !empty($out['outlet_slogan']))
                         $out['featured']=$out['outlet_slogan'];
                         else
                         $out['featured']='featured';
                          $total_discount=$out['discount']+$out['percentage'];
                      if(!empty($total_discount))
                      $out['discount']=$total_discount;
                   // $arr_data['Type']='slider';
                        $time=$this->outlet_open_close($out['id']);
                        if($time=="Closed")
                        $out['open_close']=$time;
                        $cat=$this->get_restaurant_categories($out['id']);
                        if(!empty($cat))
                        $out['catagories']=$cat;
                        $out['followstatus']=$this->check_favourite_outlet($user_id,$out['id']);
                        $check =true;
                        foreach ($dietary as $key => $diet) {
                            $dietary_record = Modules::run('slider/_get_where_cols',array("od_outlet_id"=> $out['id'],"od_dietary_id" =>$diet),'od_id desc','outlet_dietary','od_id')->result_array();
                            if(empty($dietary_record))
                                $check =false;
                        }
                        if($check == true)
                            $temp_array[] = $out;
                        
                    }
                    $image_check =false;
                    $outlets= $temp_array;
                }
                
                /////////////by asad////////////
                 if(empty($outlets) && !empty($outlet_name)){
                $temp_image=array();
                     $outlets=$this->get_nearest_outlest_search_wise(array("outlet.latitude >=" =>$minLat,"outlet.latitude <=" =>$maxLat,"outlet.longitude >=" =>$minLon,"outlet.longitude <=" =>$maxLon,"outlet.status"=>"1"),$outlet_name,$order_by);
                     
                }
            }
            if(!empty($outlets)) {
                $temp_image=array();
                if($image_check == true) {
                    foreach ($outlets as $key => $out) {
                         $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id']),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
                        $out['image'] = $this->image_path_with_default(ACTUAL_OUTLET_TYPE_IMAGE_PATH,$out['image'],STATIC_FRONT_IMAGE,'pattren.png');
                        $out['logo'] = $this->image_path_with_default(ACTUAL_OUTLET_IMAGE_PATH,$out['logo'],STATIC_FRONT_IMAGE,'pattren.png');
                        if(!empty($out['delivery_time']))
                            $out['delivery_time'] = $out['delivery_time']." Mins";
                        else {
                            if(isset($out['delivery_time']))
                                unset($out['delivery_time']);
                        }
                            
                        if(empty($out['rating']))
                            $out['rating'] = "0.0";
                        $out['followstatus'] = false;
                        if(isset($user_id) && is_numeric($user_id)) {
                            $favourite = Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id'],"of_user_id" =>$user_id),'of_id desc','outlet_favourite','outlet_favourite.of_id,outlet_favourite.of_outlet_id,outlet_favourite.of_user_id')->result_array();
                            if(!empty($favourite))
                                $out['followstatus'] = true;
                        }
                         if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                             $out['followers']=$follewers[0]['followers'];
                             $follewers="";
                            if(isset($out['outlet_slogan']) && !empty($out['outlet_slogan']))
                         $out['featured']=$out['outlet_slogan'];
                         else
                         $out['featured']='featured';
                          $total_discount=$out['discount']+$out['percentage'];
                      if(!empty($total_discount))
                      $out['discount']=$total_discount;
                   // $arr_data['Type']='slider';
                        $time=$this->outlet_open_close($out['id']);
                        if($time=="Closed")
                        $out['open_close']=$time;
                        $cat=$this->get_restaurant_categories($out['id']);
                        if(!empty($cat))
                        $out['catagories']=$cat;
                        
                        $temp_image[]=$out;
                    }
                    $outlets = $temp_image;
                }
               
                $total_pages = count($outlets);
                if($total_pages >0) {
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                }
                $outlets =array_slice($outlets, $offset,$limit);
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"outlets"=>$outlets,"page_number"=>$page_number,"total_pages"=>$total_pages));
            
        }
        function resend_user_email() {
            $status= false;
            $message="user not exist";
            $user_id=$this->input->post("user_id");
            if(is_numeric($user_id)) {
                $checking = Modules::run('customers/_get_by_arr_id_for_login',array("id" => $user_id));
                $row = $checking->row();
                $checking =$checking->result_array();
                if(!empty($checking)){
                    $status = true;
                    $message = "user data exist";
                    $data['id'] = $row->id;
                    $data['name'] = $row->name;
                    $data['profile_image'] = $row->cus_image;
                    $data['email'] = $row->email;
                    $data['phone'] = $row->phone;
                    $data['address'] = $row->address;
                    $ref['verification_code'] =substr(md5(uniqid(rand(), true)), 6, 6);
                    for ($today=1; $today <70 ; $today++) { 
                        $unique_number =substr(md5(uniqid(rand(), true)), 16, 16);
                        $check_number= Modules::run('slider/_get_where_cols',array("verification_code" =>$unique_number),'id desc','customers','verification_code')->result_array();
                        if (!empty($check_number))  {
                            $ref['verification_code'] = $unique_number;
                            break;
                        }
                    }
                    $query = Modules::run('customers/_update_id_front_login', $row->id, $ref);
                    $this->load->library('email');
                    $port = 465;
                    $user = "no-reply@dinehome.no";
                    $pass = "uKbW1MVIj)Hg";
                    $host = 'ssl://mail.dinehome.no';

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
                    $this->email->from($user, 'Dinehome.no');
                   
                    $this->email->to($data['email']);
                    $this->email->subject('Dinehome.no' . ' - Registration');
                    $this->email->message('<p>Dear ' . $data['name'] . ',<br><br>Thank you for registration at ' . 'Dinehome.no and your verification is <b>'.$ref['verification_code'] . '</b> </br>With Best Regards,<br>' . 'Dinehome.no' . 'Team');
                    $this->email->send();
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }
        function password_reset_email() {
            $status= false;
            $message="user not exist";
            $phone=$this->input->post("phone");
            if(!empty($phone)) {
                $checking = Modules::run('customers/_get_by_arr_id_for_login',array("phone" => $phone));
                $row = $checking->row();
                $checking =$checking->result_array();
                if(!empty($checking)){
                    $status = true;
                    $message = "user data exist";
                    $data['id'] = $row->id;
                    $data['name'] = $row->name;
                    $data['profile_image'] = $row->cus_image;
                    $data['email'] = $row->email;
                    $data['phone'] = $row->phone;
                    $data['address'] = $row->address;
                    $unique_number = $ref['password'] =substr(md5(uniqid(rand(), true)), 6, 6);
                    $ref['password'] = Modules::run('site_security/make_hash', $ref['password']);
                    for ($today=1; $today <70 ; $today++) { 
                        $ref['password'] = $unique_number =substr(md5(uniqid(rand(), true)), 6, 6);
                        $ref['password'] = Modules::run('site_security/make_hash', $ref['password']);
                        $check_number= Modules::run('slider/_get_where_cols',array("password" =>$ref['password']),'id desc','customers','password')->result_array();
                        if (!empty($check_number))  {
                            $ref['password'] =$ref['password'];
                            break;
                        }
                    }
                    $query = Modules::run('customers/_update_id_front_login', $row->id, $ref);
                    $this->load->library('email');
                    $port = 465;
                    $user = "no-reply@dinehome.no";
                    $pass = "uKbW1MVIj)Hg";
                    $host = 'ssl://mail.dinehome.no'; 

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
                    $this->email->from($user, 'Dinehome.no');
                   
                    $this->email->to($data['email']);
                    $this->email->subject('Dinehome.no' . ' - Reset Password');
                    $this->email->message('<p>Dear ' . $data['name'] . ',<br><br> Your password is reset please use <b>'.$unique_number . '</b> as your password </br>With Best Regards,<br>' . 'Dinehome.no' . 'Team');
                    $this->email->send();
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }
        function code_verification() {
            $status= false;
            $message="Something went wrong";
            $code = $this->input->post("code");
            $user_id = $this->input->post("user_id");
            $locations = $this->input->post('location');
            $locations = json_decode($locations);
            $data=array();
            $id = $name = $email = $phone = "";
            $Locations = array();
            $customer_image =STATIC_FRONT_IMAGE.'user.png';
            if(!empty($code) && is_numeric($user_id)) {
                $verification_code = Modules::run('slider/_get_where_cols',array("verification_code" =>$code,"id"=>$user_id),'id desc','customers','id,verification_code,name,email,phone,cus_image')->result_array();
                $message = "invalid code";
                if(!empty($verification_code)) {
                    $status = true;
                    $message = "user verified";
                    Modules::run('customers/_update_id_front_login', $verification_code[0]['id'],array("is_verified"=>"1"));
                    if(isset($verification_code[0]['name']) && !empty($verification_code[0]['name']))
                        $name = $verification_code[0]['name'];
                    if(isset($verification_code[0]['phone']) && !empty($verification_code[0]['phone']))
                        $phone = $verification_code[0]['phone'];
                    if(isset($verification_code[0]['email']) && !empty($verification_code[0]['email']))
                        $email = $verification_code[0]['email'];
                    if(isset( $verification_code[0]['cus_image']) && !empty($verification_code[0]['cus_image'])) {
                        if( file_exists(ACTUAL_CUSTOMER_IMAGE_PATH.$verification_code[0]['cus_image']))
                            $customer_image = BASE_URL.ACTUAL_CUSTOMER_IMAGE_PATH.$verification_code[0]['cus_image'];
                    }
                    unset($data['cus_image']);
                    $customer_id = $id = $verification_code[0]['id'];
                    if(!empty($locations) && is_numeric($customer_id)) {
                        foreach ($locations->Locations as $key => $loc_data) {
                           
                            $loc['customer_id']=$customer_id;
                            $loc['location_address']=$loc_data->Address;
                            $loc['location_street']=$loc_data->Street;
                            $loc['location_house_no']=$loc_data->Houseno;
                            $loc['location_type']=$loc_data->Type;
                            $loc['location_latitude']=$loc_data->Lat;
                            $loc['location_longitude']=$loc_data->Long;
                             
                            if(isset($loc['location_address']) && !empty($loc['location_address']) && isset($loc['location_type']) && !empty($loc['location_type']) && isset($loc['location_latitude']) && !empty($loc['location_latitude']) && isset($loc['location_longitude']) && !empty($loc['location_longitude']) && $loc['location_type'] !="43b5c9175984c071f30b873fdce0a000") {
                                $insert_or_update=$this->insert_or_update(array("customer_id"=>$loc['customer_id'],"location_type"=>$loc['location_type']),$loc,'customer_location');
                                $default['location_is_default']=$loc_data->Default;
                                if(!empty($default['location_is_default'])) {
                                    if($default['location_is_default'] == true)
                                        $default['location_is_default']=1;
                                    else
                                        $default['location_is_default'] = 0;
                                    $this->insert_or_update(array("customer_id"=>$loc['customer_id']),array("location_is_default"=>'0'),'customer_location');
                                    $this->insert_or_update(array("customer_id"=>$loc['customer_id'],"location_type"=>$loc['location_type']),$default,'customer_location');
                                }
                            }
                            unset($default_path);
                        }
                    }
                    $Locations = Modules::run('slider/_get_where_cols',array("customer_id" =>$customer_id,"location_status" =>'active'),'cl-id desc','customer_location','location_latitude as Lat,location_longitude,location_address as Address,location_street as Street,location_house_no as Houseno,location_type as Type,location_is_default')->result_array();
                    $main_locations=array();
                    $main_locations['Status']=false;
                    if(!empty($Locations)) {
                        $main_locations['Status']=true;
                        $temp=array();
                        foreach ($Locations as $key => $loc) {
                            $loc['Long']=$loc['location_longitude'];
                            if(isset($loc['location_is_default']) && !empty($loc['location_is_default'])) {
                                if($loc['location_is_default'] = '1')
                                    $loc['Default'] =true;
                                else
                                    $loc['Default'] = false;
                            }
                            else
                                $loc['Default'] = false;
                            unset($loc['location_is_default']);
                            $loc['Long'] = $loc['location_longitude'];
                            unset($loc['location_longitude']);
                            $temp[]=$loc;
                        }
                        $main_locations['Locations']=$temp;
                        $Locations=$main_locations;

                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"id"=>$id,"name"=>$name,"email"=>$email,"phone"=>$phone,"customer_image"=>$customer_image,"Locations"=>$Locations));
        }
        
        function driver_login() {
            $status= false;
            $data=array();
            $message="Invalid username or password";
            $driver_user_name= $this ->input->post('user_name');
            $driver_password= $this ->input-> post('password');
            if (!empty($driver_user_name) && !empty($driver_password)) {
                $password=md5($driver_password);
                $data=$this->get_specific_table_data(array("driver_email"=>$driver_user_name,"driver_password"=>$password),"driver_id desc","driver_id,driver_first_name,driver_middle_name,driver_last_name,driver_picture","driver","1","1")->result_array();
                if(!empty($data)){
                    $status= true;
                    $message="ok";
                    if(!isset($data[0]['driver_picture']))
                        $data[0]['driver_picture'] = "";
                    $data[0]['driver_picture']=  $this->image_path_with_default(MEDIUM_DRIVER_IMAGE_PATH,$data[0]['driver_picture'],STATIC_FRONT_IMAGE,'user.png');
                } 
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message,"driver_record"=>$data ));

        }
        function driver_status_update() {
            $status= false;
            $message="error";
            $driver_id= $this ->input->post('driver_id');
            $driver_status = $this ->input->post('driver_status');
            if (is_numeric($driver_id) && is_numeric($driver_status)) {
                $this->update_specific_table(array("driver_id"=>$driver_id),array("driver_status"=>$driver_status),'driver');
                $status= true;
                $message="ok";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }

        function update_driver_profile_picture() {
            $status= false;
            $data=array();
            $message="error";
            $driver_image =STATIC_FRONT_IMAGE.'user.png';
            $driver_id= $this ->input->post('driver_id');
            if (!empty($driver_id) && isset($_FILES['image']['size'])) {
                $data=$this->get_specific_table_data(array("driver_id"=>$driver_id),"driver_id desc","driver_picture","driver","1","1")->result_array();
                if(!empty($data)){
                    if($_FILES['image']['size']>0) {
                        if(isset($data[0]['driver_picture']) && !empty($data[0]['driver_picture']))
                            $this->delete_images_by_name(ACTUAL_DRIVER_IMAGE_PATH,LARGE_DRIVER_IMAGE_PATH,MEDIUM_DRIVER_IMAGE_PATH,SMALL_DRIVER_IMAGE_PATH,$data[0]['driver_picture']);
                        $this->upload_dynamic_image(ACTUAL_DRIVER_IMAGE_PATH,LARGE_DRIVER_IMAGE_PATH,MEDIUM_DRIVER_IMAGE_PATH,SMALL_DRIVER_IMAGE_PATH,$driver_id,'image','driver_picture','driver_id','driver');
                        $query=$this->get_specific_table_data(array("driver_id"=>$driver_id),"driver_id desc","driver_picture","driver","1","1")->result_array();
                        if(!empty($query)) {
                            if(isset($query[0]['driver_picture']) && !empty($query[0]['driver_picture']))
                                if( file_exists(ACTUAL_DRIVER_IMAGE_PATH.$query[0]['driver_picture']))
                                    $driver_image = BASE_URL.ACTUAL_DRIVER_IMAGE_PATH.$query[0]['driver_picture'];
                        }
                        $status=true;
                        $message="driver image update";
                    }
                } 
            } 
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message,"image"=>$driver_image));
        }

        function driver_basic_profile(){
            $status= false;
            $message="error";
            $driver_id = $this ->input->post('driver_id');
            $data= array();
            if (!empty($driver_id)) {
                $data=$this->get_driver_basic_info(array("driver_id"=>$driver_id),'driver_id desc','driver_first_name,driver_middle_name,driver_last_name,driver_email,driver_street,driver_cell_phone,driver_country,country_name,driver_city,city_name,driver_town,town_name,driver_post_code,postcode')->result_array();
                $status= true;
                $message="ok";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message,"data"=>$data ));
        }

        function driver_vehicles_information(){
            $status= false;
            $message="error";
            $driver_id = $this ->input->post('driver_id');
            $data= array();
            if (!empty($driver_id)) {
                $data=$this->get_driver_vehicle_info(array("driver_vehicle.driver_id"=>$driver_id),'driver_vehicle.dv_active desc','driver_first_name,driver_middle_name,driver_last_name,dv_id,vehicle_cat_name,vehicle_mod_name,vehicle_bd_name,vehicle_number,vehicle_color,dv_active')->result_array();
                $status= true;
                $message="ok";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message,"data"=>$data ));
        }

        function driver_active_vehicle(){
            $status= false;
            $message="error";
            $driver_id = $this ->input->post('driver_id');
            $data= array();
            $logs_count = 0;
            if (!empty($driver_id)) {
                $data=$this->get_driver_vehicle_info(array("driver_vehicle.driver_id"=>$driver_id,"driver_vehicle.dv_active"=>'1'),'driver.driver_id desc','driver_first_name,driver_middle_name,driver_last_name,driver_status,dv_id,vehicle_cat_name,vehicle_mod_name,vehicle_bd_name,vehicle_number,vehicle_color,dv_active')->result_array();
                $logs_count = $this->_get_specific_table_with_pagination(array("driver_id" =>$driver_id,"notification_status" =>"1"),'notification_id desc',"notification","notification_id",$page_number,$limit)->num_rows();
                $status= true;
                $message="ok";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message,"data"=>$data,"logs_count"=>$logs_count));
        }
        function update_driver_active_vehicle(){
            $status= false;
            $message="error";
            $driver_id = $this ->input->post('driver_id');
            $driver_vehicle_id = $this ->input->post('vehicle_id');
            $vehicle_status = $this ->input->post('status');
            if (is_numeric($driver_vehicle_id) && is_numeric($driver_id) && is_numeric($vehicle_status)) {
                $this->update_specific_table(array("driver_id"=>$driver_id),array("dv_active"=>'0'),'driver_vehicle');
                $this->update_specific_table(array("dv_id"=>$driver_vehicle_id),array("dv_active"=>$vehicle_status),'driver_vehicle');
                $status= true;
                $message="ok";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }
        function rating_outlet(){
            $status= false;
            $message="error";
            $customer_id = $this ->input->post('customer_id');
            $outlet_id = $this ->input->post('outlet_id');
            $rating = $this ->input->post('rating');
            if (is_numeric($customer_id) && is_numeric($outlet_id) && is_numeric($rating)) {
                $$query =$this->insert_or_update(array("user_id"=> $customer_id,"outlet_id"=>$outlet_id),array("user_id"=> $customer_id,"outlet_id"=>$outlet_id,"rating"=>$rating),'reviews');
                $status= true;
                $message="ok";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }

        function country_list(){
            $status=false;
            $message="record not found";
            $catagories_record=array();
            $country_record = Modules::run('slider/_get_where_cols',array("c_status" =>'1'),'c_id desc','country','c_id,country_name,country_language,country_code,country_currency')->result_array();
            if(isset($country_record) && !empty($country_record)) {
                $status=true;
                $message="country list";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"country_record"=>$country_record));
        }

        function country_cities(){
            $status=false;
            $message="record not found";
            $country_cities=array();
            $country_id = $this->input->post('country_id');
            if(isset($country_id) && !empty($country_id)) {
                $country_cities = Modules::run('slider/_get_where_cols',array("c_id" =>$country_id,"city_status" =>'1'),'city_id desc','city','city_id,city_name')->result_array();
                $status=true;
                $message="country list";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"country_cities"=>$country_cities));
        }
        
        function city_towns(){
            $status=false;
            $message="record not found";
            $city_town=array();
            $city_id = $this->input->post('city_id');
            if(isset($city_id) && !empty($city_id)) {
                $city_town = Modules::run('slider/_get_where_cols',array("city_town_id" =>$city_id,"town_status" =>'1'),'town_id desc','city_town','town_id,town_name')->result_array();
                $status=true;
                $message="Town list";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"city_town"=>$city_town));
        }

        function town_post_codes(){
            $status=false;
            $message="record not found";
            $post_code=array();
            $town_id = $this->input->post('town_id');
            if(isset($town_id) && !empty($town_id)) {
                $post_code = Modules::run('slider/_get_where_cols',array("tpc_town_id" =>$town_id,"tpc_status" =>'1'),'tpc_id desc','town_postcodes','tpc_id as post_id,postcode')->result_array();
                $status=true;
                $message="Post Code list";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"post_code"=>$post_code));
        }

        function update_driver_profile() {
            $status= false;
            $message="Something went wrong";
            $driver_id= $this ->input->post('driver_id');
            $data=array();
            if(!empty($_POST))
                foreach ($_POST as $key => $value)
                    $data[$key] = $value;
            if (!empty($driver_id) && is_numeric($driver_id) && !empty($data)) {
                unset($_POST['driver_id']);
                $this->update_specific_table(array("driver_id"=>$driver_id),$data,'driver');
                $status= true;
                $message="Profile updated successfully";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }

        function update_driver_password() {
            $status= false;
            $data=array();
            $message="error";
            $driver_id= $this ->input->post('driver_id');
            $driver_password= $this ->input->post('driver_password');
            $driver_new_password= $this ->input->post('driver_new_password');
            if (!empty($driver_id) && !empty($driver_password) && !empty($driver_new_password)) {
                $password=md5($driver_password);
                $data=$this->get_specific_table_data(array("driver_id"=>$driver_id,"driver_password"=>$password),"driver_id desc","driver_password","driver","1","1")->result_array();
                if(!empty($data)) {
                    $status= true;
                    $message="ok";
                    $driver_new_password=md5($driver_new_password);
                    $this->update_specific_table(array("driver_id"=>$driver_id),array("driver_password"=>$driver_new_password),'driver');
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }
        function get_dietary_list(){
            $status=false;
            $message="record not found";
            $dietary_list=array();
            $dietary_list = Modules::run('slider/_get_where_cols',array("dietary_status" =>'1'),'dietary_id desc','dietary','dietary_id,dietary_name')->result_array();
            if(!empty($dietary_list)) {
                $status=true;
                $message="Dietary List";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"dietary_list"=>$dietary_list));
        }
        function get_user_orders() {
            $status=false;
            $message="Something went wrong";
            $customer_id = $this->input->post('customer_id');
            $where_status = $this->input->post('status');
            $page_number = $this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit = $this->input->post('limit');
            if(!is_numeric($limit))
                $limit = 20;
            $total_pages = 0;
            $order_list = array();
            if(!empty($where_status)) {
                $where_status = explode(",", $where_status);
                $where_status = array_filter($where_status);
            }
            if(is_numeric($customer_id)) {
                $status = true;
                $message = "parameter true";
                $order_list = $this->_get_user_order_list(array("user_id"=>$customer_id),"id desc","users_orders","users_orders.id,users_orders.order_id,users_orders.outlet_id,outlet.id as outlet_id,name as outlet_name,users_orders.order_status",$where_status,$page_number,$limit)->result_array();
                $total_pages = $this->_get_user_order_list(array("user_id"=>$customer_id),"id desc","users_orders","users_orders.id,users_orders.order_id,users_orders.outlet_id,outlet.id as outlet_id,name as outlet_name,users_orders.order_status",$where_status,$page_number,"0")->num_rows();
                if(!empty($order_list)) {
                    $temp = array();
                    foreach ($order_list as $key => $detail) {
                        $order_detail = Modules::run('slider/_get_where_cols',array("id" =>$detail['order_id']),'id desc',$detail['outlet_id'].'_orders','create_date,total_price')->result_array();
                        if(!empty($order_detail)) {
                            $detail['create_date'] = $order_detail[0]['create_date'];
                            $detail['total_price'] = $order_detail[0]['total_price'];
                            $temp[] = $detail;
                        }
                    }
                    $order_list = $temp;
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"order_list"=>$order_list,"page_number" => $page_number,"total_pages" => $total_pages));
        }

        function order_detail() {
            $status=false;
            $message="Something went wrong";
            $order_no = $this->input->post('order_no');
            $outlet_id = $this->input->post('outlet_id');
            $order_detail = array();
            $final_array =array();
            $final_array['Rating'] = "";
            if(is_numeric($order_no) && is_numeric($outlet_id)) {
                $message = "order detail does not exist";
                $order_detail = Modules::run('slider/_get_where_cols',array("id" =>$order_no),'id desc',$outlet_id.'_orders','id as Orderid,create_date as Orderdate,subtotal as Subtotal,total_price as Ordertotal,delivery_lat as Lat,delivery_lang,address as Address,street_no as Street,postcode as Postalcode,city as City,country as Country,houseno as Houseno,total_products as Quantity')->result_array();
                if(!empty($order_detail)) {
                    $order_status=$this->_get_user_order_list(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"users_orders.id desc","users_orders","order_status,user_id,uo_driver_id","","1",'1')->result_array();
                    $order_detail[0]['Orderstatus'] = "";
                    if(isset($order_status[0]['order_status']) && !empty($order_status[0]['order_status']))
                        $order_detail[0]['Orderstatus'] = $order_status[0]['order_status'];
                    if(isset($order_status[0]['user_id']) && !empty($order_status[0]['user_id'])) {
                        $user_rating = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id,"user_id"=>$order_status[0]['user_id']),"id asc","reviews","user_id,outlet_id,order_id","rating")->result_array();
                        if(isset($user_rating[0]['rating']) && !empty($user_rating[0]['rating']))
                            $final_array['Rating']=$user_rating[0]['rating'];

                    }
                    if(isset($order_status[0]['uo_driver_id']) && !empty($order_status[0]['uo_driver_id'])) {
                        $driver_detail = Modules::run('slider/_get_where_cols',array("driver_id" =>$order_status[0]['uo_driver_id']),'driver_id desc','driver','driver_first_name,driver_middle_name,driver_last_name,driver_cell_phone')->result_array();
                        $driver_vehicle=$this->get_driver_vehicle_info(array("driver_vehicle.driver_id"=>$order_status[0]['uo_driver_id'],"driver_vehicle.dv_active"=>"1"),'driver.driver_id desc','driver_vehicle.vehicle_number')->result_array();
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
                    $order_detail[0]['Deliverylocation']['Lat'] = $order_detail[0]['Deliverylocation']['Long'] = $order_detail[0]['Deliverylocation']['Address'] = $order_detail[0]['Deliverylocation']['Street'] = $order_detail[0]['Deliverylocation']['Postalcode'] = $order_detail[0]['Deliverylocation']['City'] = $order_detail[0]['Deliverylocation']['Country'] = $order_detail[0]['Deliverylocation']['Houseno'] ="";
                    if(!empty($order_detail[0]['Lat']))
                        $order_detail[0]['Deliverylocation']['Lat'] = $order_detail[0]['Lat'];
                    if(!empty($order_detail[0]['delivery_lang']))
                        $order_detail[0]['Deliverylocation']['Long'] = $order_detail[0]['delivery_lang'];
                    if(!empty($order_detail[0]['Address']))
                        $order_detail[0]['Deliverylocation']['Address'] = $order_detail[0]['Address'];
                    if(!empty($order_detail[0]['Street']))
                        $order_detail[0]['Deliverylocation']['Street'] = $order_detail[0]['Street'];
                    if(!empty($order_detail[0]['Postalcode']))
                        $order_detail[0]['Deliverylocation']['Postalcode'] = $order_detail[0]['Postalcode'];
                    if(!empty($order_detail[0]['City']))
                        $order_detail[0]['Deliverylocation']['City'] = $order_detail[0]['City'];
                    if(!empty($order_detail[0]['Country']))
                        $order_detail[0]['Deliverylocation']['Country'] = $order_detail[0]['Country'];
                    if(!empty($order_detail[0]['Houseno']))
                        $order_detail[0]['Deliverylocation']['Houseno'] = $order_detail[0]['Houseno'];
                    unset($order_detail[0]['Houseno']);unset($order_detail[0]['Country']);unset($order_detail[0]['City']);unset($order_detail[0]['Postalcode']);unset($order_detail[0]['Street']);unset($order_detail[0]['Address']);unset($order_detail[0]['delivery_lang']);unset($order_detail[0]['Lat']);
                    $status = true;
                    $message = "order detail";
                    $items = $this->get_order_items(array("order_id"=>$order_no,"parent_id"=>"0"),"product_id asc",$outlet_id."_orders_detail","order_id,product_id","product_id,product_name as Productname,product_price as Productprice,quantity as Productquantity,total_product_price as Totalprice")->result_array();
                    if(!empty($items)) {
                        $temp=array();
                        foreach ($items as $key => $it) {
                            $it['Sizes'] = false;
                            $sizes = $this->get_order_items(array("order_id"=>$order_no,"product_id"=>$it['product_id'],"parent_id"=> "0","check"=>"Size"),"product_id asc",$outlet_id."_orders_detail","","product_name as Name,specs_label as Label,product_price as Price,quantity as Quantity")->result_array();
                            $it['Data'] =array();
                            if(!empty($sizes)) {
                                $it['Sizes'] = true;
                                foreach ($sizes as $key => $value) {
                                    $value['Check'] = "Size";
                                    $it['Data'][] = $value;
                                }
                            }
                            $add_ons = $this->get_order_items(array("order_id"=>$order_no,"parent_id"=>$it['product_id'],"check"=>"Addon"),"product_id asc",$outlet_id."_orders_detail","","product_name as Name,specs_label as Label,product_price as Price,quantity as Quantity")->result_array();
                            if(!empty($add_ons)) {
                                foreach ($add_ons as $key => $value) {
                                    $value['Check'] = "Addon";
                                    $it['Data'][] = $value;
                                }
                            }
                            unset($it['product_id']);
                            $temp[]=$it;
                        }
                        $order_detail[0]['Charges'] = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"oc_id asc",$outlet_id."_order_charges","","charges_name,charges_type,charges_amount")->result_array();
                        $order_detail[0]['Taxes'] = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"ot_id asc",$outlet_id."_order_taxes","","tax_name,tax_type,tax_value as tax_amount")->result_array();
                        $order_detail[0]['Discounts'] = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"od_id asc",$outlet_id."_order_discount","","discount_name,discount_type,discount_value as discount_amount")->result_array();
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
            $final_array['status'] = $status;
            $final_array['message'] = $message;
            header('Content-Type: application/json');
            echo json_encode($final_array);
        }
        function get_drivers_orders() {
            $status=false;
            $message="Something went wrong";
            $customer_id = $this->input->post('driver_id');
            $where_status = $this->input->post('status');
            $page_number = $this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit = $this->input->post('limit');
            if(!is_numeric($limit))
                $limit = 20;
            $total_pages = 0;
            $order_list = array();
            if(!empty($where_status)) {
                $where_status = explode(",", $where_status);
                $where_status = array_filter($where_status);
            }
            if(is_numeric($customer_id)) {
                $status = true;
                $message = "parameter true";
                $order_list = $this->_get_user_order_list(array("uo_driver_id"=>$customer_id),"id desc","users_orders","users_orders.id,users_orders.order_id,users_orders.outlet_id,outlet.id as outlet_id,name as outlet_name,address as pickup_address,users_orders.order_status",$where_status,$page_number,$limit)->result_array();
                if(!empty($order_list)) {
                    $total_pages = $this->_get_user_order_list(array("uo_driver_id"=>$customer_id),"id desc","users_orders","users_orders.id,users_orders.order_id,users_orders.outlet_id,outlet.id as outlet_id,name as outlet_name,address as pickup_address,users_orders.order_status",$where_status,$page_number,"0")->num_rows();
                    $temp = array();
                    foreach ($order_list as $key => $detail) {
                        $order_detail = Modules::run('slider/_get_where_cols',array("id" =>$detail['order_id']),'id desc',$detail['outlet_id'].'_orders','create_date,address,street_no,city,country,postcode,houseno')->result_array();
                        if(!empty($order_detail)) {
                            $detail['create_date'] = $order_detail[0]['create_date'];
                            $detail['address'] = $order_detail[0]['address'];
                            $detail['street_no'] = $order_detail[0]['street_no'];
                            $detail['city'] = $order_detail[0]['city'];
                            $detail['country'] = $order_detail[0]['country'];
                            $detail['postcode'] = $order_detail[0]['postcode'];
                            $detail['houseno'] = $order_detail[0]['houseno'];
                            $temp[] = $detail;
                        }
                    }
                    $order_list = $temp;
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"order_list"=>$order_list,"page_number" => $page_number,"total_pages" => $total_pages));
        }

        function driver_order_detail() {
            $status=false;
            $message="Something went wrong";
            $order_no = $this->input->post('order_no');
            $outlet_id = $this->input->post('outlet_id');
            $order_detail = array();
            if(is_numeric($order_no) && is_numeric($outlet_id)) {
                $message = "order detail does not exist";
                $order_detail = Modules::run('slider/_get_where_cols',array("id" =>$order_no),'id desc',$outlet_id.'_orders','id as order_id,create_date,subtotal,total_price,customer_name,mobile,address as user_address,street_no as user_street_no,country user_country,city as user_city,postcode as user_postcode,houseno user_houseno,delivery_lat,delivery_lang,payment_method,payment_status')->result_array();
                if(!empty($order_detail)) {
                    $order_status=$this->_get_user_order_list(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"users_orders.id desc","users_orders","order_status","","1",'1')->result_array();
                    if(!empty($order_status))
                        $order_detail[0]['order_status'] = $order_status[0]['order_status'];
                    if(isset($order_detail[0]['payment_method']) && !empty($order_detail[0]['payment_method'])) {
                        if($order_detail[0]['payment_method'] == "1")
                            $order_detail[0]['payment_method'] = "Cash";
                        elseif($order_detail[0]['payment_method'] == "2")
                            $order_detail[0]['payment_method'] = "Card";
                        else
                            $order_detail[0]['payment_method']="";
                    }
                    else
                        $order_detail[0]['payment_method'] = "";
                    $payment_status = false;
                    if(isset($order_detail[0]['payment_status']) && !empty($order_detail[0]['payment_status']))
                        if($order_detail[0]['payment_status'] == "1")
                            $payment_status = true;
                    $order_detail[0]['payment_status'] = $payment_status;
                    $order_detail[0]['outlet_name'] = $order_detail[0]['outlet_phone'] = $order_detail[0]['outlet_address'] = $order_detail[0]['outlet_country'] = $order_detail[0]['outlet_city'] = $order_detail[0]['outlet_state'] = $order_detail[0]['outlet_post_code'] = $order_detail[0]['outlet_latitude'] = $order_detail[0]['outlet_longitude'] = "";
                    $outlet_detail = Modules::run('slider/_get_where_cols',array("id" =>$outlet_id),'id desc','outlet','name as outlet_name,phone as outlet_phone,address as outlet_address,country as outlet_country,city as outlet_city,state as outlet_state,post_code as outlet_post_code,latitude as outlet_latitude,longitude as outlet_longitude')->result_array();
                    if(!empty($outlet_detail)) {
                        if(isset($outlet_detail[0]['outlet_name']) && !empty($outlet_detail[0]['outlet_name']))
                            $order_detail[0]['outlet_name'] =$outlet_detail[0]['outlet_name'];
                        if(isset($outlet_detail[0]['outlet_phone']) && !empty($outlet_detail[0]['outlet_phone']))
                            $order_detail[0]['outlet_phone'] =$outlet_detail[0]['outlet_phone'];
                        if(isset($outlet_detail[0]['outlet_address']) && !empty($outlet_detail[0]['outlet_address']))
                            $order_detail[0]['outlet_address'] =$outlet_detail[0]['outlet_address'];
                        if(isset($outlet_detail[0]['outlet_country']) && !empty($outlet_detail[0]['outlet_country']))
                            $order_detail[0]['outlet_country'] =$outlet_detail[0]['outlet_country'];
                        if(isset($outlet_detail[0]['outlet_city']) && !empty($outlet_detail[0]['outlet_city']))
                            $order_detail[0]['outlet_city'] =$outlet_detail[0]['outlet_city'];
                        if(isset($outlet_detail[0]['outlet_state']) && !empty($outlet_detail[0]['outlet_state']))
                            $order_detail[0]['outlet_state'] =$outlet_detail[0]['outlet_state'];
                        if(isset($outlet_detail[0]['outlet_post_code']) && !empty($outlet_detail[0]['outlet_post_code']))
                            $order_detail[0]['outlet_post_code'] =$outlet_detail[0]['outlet_post_code'];
                        if(isset($outlet_detail[0]['outlet_latitude']) && !empty($outlet_detail[0]['outlet_latitude']))
                            $order_detail[0]['outlet_latitude'] =$outlet_detail[0]['outlet_latitude'];
                        if(isset($outlet_detail[0]['outlet_longitude']) && !empty($outlet_detail[0]['outlet_longitude']))
                            $order_detail[0]['outlet_longitude'] =$outlet_detail[0]['outlet_longitude'];
                    }
                    $status = true;
                    $message = "order detail";
                    $items = $this->get_order_items(array("order_id"=>$order_no,"parent_id"=>"0"),"product_id asc",$outlet_id."_orders_detail","order_id,product_id","id as detail_id,product_id,product_no,product_name,product_price,quantity")->result_array();
                    if(!empty($items)) {
                        $temp=array();
                        foreach ($items as $key => $it) {
                            $it['sizes'] = $this->get_order_items(array("order_id"=>$order_no,"product_id"=>$it['product_id'],"parent_id"=> "0","check"=>"Size"),"product_id asc",$outlet_id."_orders_detail","","id as detail_id,product_id,product_no,product_name,specs_label,product_price,quantity")->result_array();
                            $it['add_ons'] = $this->get_order_items(array("order_id"=>$order_no,"parent_id"=>$it['product_id'],"check"=>"Addon"),"product_id asc",$outlet_id."_orders_detail","","id as detail_id,product_id,product_no,product_name,product_price,quantity")->result_array();
                            $it['charges'] = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"oc_id asc",$outlet_id."_order_charges","","oc_id,charges_name,charges_type,charges_amount")->result_array();
                            $it['taxes'] = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"ot_id asc",$outlet_id."_order_taxes","","ot_id,tax_name,tax_type,tax_value")->result_array();
                            $it['discount'] = $this->get_order_items(array("order_id"=>$order_no,"outlet_id"=>$outlet_id),"od_id asc",$outlet_id."_order_discount","","od_id,discount_name,discount_type,discount_value")->result_array();
                            $temp[]=$it;
                        }
                        $items=$temp;
                    }
                    $order_detail[0]['items'] = $items;
                }
                
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"order_detail"=>$order_detail));
        }
        
        function get_driver_notification() {
            $status=false;
            $message="Something went wrong";
            $driver_id = $this->input->post('driver_id');
            $page_number = $this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit = $this->input->post('limit');
            if(!is_numeric($limit) || empty($limit))
                $limit = 20;
            $total_pages = 0;
            $notification = array();
            $status_check = $this->input->post('status_check');
            if(is_numeric($driver_id) && !empty($driver_id)) {
                $where['driver_id'] = $driver_id;
                if(empty($status_check))
                    $where['notification_status'] = '1';
                $notification_data = $this->_get_specific_table_with_pagination($where,'notification_id desc',"notification","notification_id,order_id,outlet_id,notification_type,notification_message",$page_number,$limit)->result_array();
                if(!empty($notification_data)) {
                    $status = true;
                    $message ="api working :)";
                    $total_pages = $this->_get_specific_table_with_pagination($where,'notification_id desc',"notification","notification_id,order_id,outlet_id,notification_type",$page_number,$limit)->num_rows();
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                       $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                    foreach ($notification_data as $key => $nd) {
                        if(isset($nd['notification_id']) && is_numeric($nd['notification_id']))
                            $this->update_specific_table(array("notification_id" =>$nd['notification_id']),array("notification_status"=>"0"),"notification");
                        $order_detail = Modules::run('orders/order_detail',$nd['order_id'],"fixed",$nd['outlet_id']);
                        $order_detail['notification_type'] = $nd['notification_type'];
                        $order_detail['notification_message'] = $nd['notification_message'];
                        if(!empty($status_check)) {
                            $order_detail['check'] = false;
                            $driver_check = $this->_get_specific_table_with_pagination(array("outlet_id"=>$nd['outlet_id'],"order_id"=>$nd['order_id']), 'id desc','users_orders',"uo_driver_id",'1','1')->result_array();
                                if(isset($driver_check[0]['uo_driver_id']) && !empty($driver_check[0]['uo_driver_id'])) {
                                    $order_detail['check'] = true;
                                    $order_detail['rider_id'] = $driver_check[0]['uo_driver_id'];
                                }
                        }
                        $notification[] = $order_detail;
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"notification"=>$notification,"page_number"=>$page_number,"total_pages"=>$total_pages));
        }
        
        function driver_order_accept_or_reject() {
            $status=false;
            $fcm_notification_check=1;
            $message="parameter missing";
            $driver_id = $this->input->post('driver_id');
            $outlet_id = $this->input->post('outlet_id');
            $order_id = $this->input->post('order_id');
            $notification_type = $this->input->post('notification_type');
            $requestion_action = $this->input->post('request_action');
            if(empty($notification_type))
                $notification_type = "fixed";
            if(empty($requestion_action))
                $requestion_action = "accept";
            if(is_numeric($driver_id) && !empty($driver_id) && is_numeric($outlet_id) && !empty($outlet_id) && is_numeric($order_id) && !empty($order_id)) {
                $order_detail = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id,"order_id"=>$order_id),'id desc','users_orders','uo_driver_id,user_id')->result_array();
                if(!empty($order_detail)) {
                    if($notification_type == "fixed" || $requestion_action == "reject") {
                        $status = true;
                        $message = "Notification status has been changed";
                        $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id,"driver_id"=>$driver_id),array("notification_status"=>"0"),"notification");
                        if($requestion_action == "reject")
                            $fcm_notification_check=0;
                        elseif($notification_type == "fixed") {
                            $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("uo_driver_id"=>$driver_id,"order_status"=>"Ready to deliver"),"users_orders");
                        }
                        else
                            echo "";
                    }
                    elseif($notification_type == "broadcast" && $requestion_action == "Ready to deliver") {
                        if(isset($order_detail[0]['uo_driver_id']) && empty($order_detail[0]['uo_driver_id']) ) {
                            $status = true;
                            $message = "Order is ready to delivery and notification status has been changed";
                            $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("notification_status"=>"0"),"notification");
                            $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("uo_driver_id"=>$driver_id,"order_status"=>"Ready to deliver","driver_status"=>"0","driver_reason"=>"","reject_from"=>"","us_rejecter_id"=>""),"users_orders");

                        }
                        else {
                            $fcm_notification_check=0;
                            $message = "Order Driver already assign to this order";
                        }
                    }
                    else
                        echo "";
                    if($fcm_notification_check == "1") {
                        if(isset($order_detail[0]['user_id']) && !empty($order_detail[0]['user_id'])) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id" =>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token']))
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                        }
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"admin"),'id desc','users','users.fcm_token')->result_array();
                        if(isset($outlet_detail) && !empty($outlet_detail)) {
                            foreach ($outlet_detail as $key => $out) {
                                if(!empty($out['fcm_token']))
                                    $fcmToken[]=$out['fcm_token'];
                            }
                        }
                        if(isset($fcmToken) && !empty($fcmToken)) {
                            $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Ready to deliver",false,false,"");
                            $fcm_data['fcmToken'] =  $fcmToken;
                            $this->load->view('firebase_notification', $fcm_data);
                        }
                    }
                }
                else
                    $message="Restaurant and order number is incorrect.";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
        }

        function driver_password_reset_email() {
            $status= false;
            $message="user not exist";
            $email=$this->input->post("email");
            if(!empty($email)) {
                $checking = Modules::run('slider/_get_where_cols',array("driver_email" =>$email),'driver_id desc','driver','driver_id,driver_first_name,driver_picture,driver_cell_phone,driver_street,driver_email');
                $row = $checking->row();
                $checking =$checking->result_array();
                if(!empty($checking)){
                    $status = true;
                    $message = "user data exist";
                    $data['id'] = $row->driver_id;
                    $data['name'] = $row->driver_first_name;
                    $data['profile_image'] = $row->driver_picture;
                    $data['email'] = $row->driver_email;
                    $data['phone'] = $row->driver_cell_phone;
                    $data['address'] = $row->driver_street;
                    $unique_number = $ref['driver_password'] =substr(md5(uniqid(rand(), true)), 6, 6);
                    $ref['driver_password'] = md5($ref['driver_password']);
                    for ($today=1; $today <70 ; $today++) { 
                        $ref['driver_password'] = $unique_number =substr(md5(uniqid(rand(), true)), 6, 6);
                        $ref['driver_password'] =md5($ref['driver_password']);
                        $check_number= Modules::run('slider/_get_where_cols',array("driver_password" =>$ref['driver_password']),'driver_id desc','driver','driver_password')->result_array();
                        if (!empty($check_number))  {
                            $ref['driver_password'] =$ref['driver_password'];
                            break;
                        }
                    }
                    $this->update_specific_table(array("driver_id" =>$row->driver_id),array("driver_password" =>$ref['driver_password']),"driver");
                    $this->load->library('email');
                    $port = 465;
                    $user = "no-reply@dinehome.no";
                    $pass = "uKbW1MVIj)Hg";
                    $host = 'ssl://mail.dinehome.no'; 

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
                    $this->email->from($user, 'Dinehome.no');
                   
                    $this->email->to($data['email']);
                    $this->email->subject('Dinehome.no' . ' - Reset Password');
                    $this->email->message('<p>Dear ' . $data['name'] . ',<br><br> Your password is reset please use <b>'.$unique_number . '</b> as your password </br>With Best Regards,<br>' . 'Dinehome.no' . 'Team');
                    $this->email->send();
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status" => $status, "message" => $message));
        }
        
        function changed_order_status() {
            $api_status=false;
            $fcm_notification_check=1;
            $message="parameter missing";
            $order_id = $this->input->post('order_id');
            $outlet_id = $this->input->post('outlet_id');
            $status = $this->input->post('status');
            $rejected_from = $this->input->post('rejected_from');
            $rejected_reason = $this->input->post('rejected_reason');
            $chef_id = $this->input->post('user_id');
            $fcmToken =array();
            if(!empty($order_id) && is_numeric($order_id) && !empty($outlet_id) && is_numeric($outlet_id) && !empty($status)) {
                $order_detail = Modules::run('slider/_get_where_cols',array("order_id"=>$order_id,"outlet_id"=>$outlet_id),'id desc','users_orders','uo_driver_id,user_id,outlet_id')->result_array();
                if(!empty($order_detail)) {
                    $api_status = true;
                    $message = "Status has been changed";
                    if($status == "Ready") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            }
                        }
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"admin"),'id desc','users','users.fcm_token')->result_array();
                        if(isset($outlet_detail) && !empty($outlet_detail)) {
                            foreach ($outlet_detail as $key => $out) {
                                if(!empty($out['fcm_token']))
                                    $fcmToken[]=$out['fcm_token'];
                            }
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Ready for Delivered.",false,false,"");
                        
                    }
                    elseif($status == "AgainReady") {
                        $fcm_notification_check = 0;
                        $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("order_status"=>"Ready","driver_status"=>"0","driver_reason"=>"","reject_from"=>"","us_rejecter_id"=>""),"users_orders");
                    }
                    elseif($status == "Accepted" || $status == "againAccepted") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id'])) && $status == "Accepted") {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            }
                        }
                        $chef_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"chef"),'id desc','users','fcm_token')->result_array();
                        if(!empty($chef_detail)) {
                            if(isset($chef_detail[0]['fcm_token']) && !empty($chef_detail[0]['fcm_token'])) {
                                $fcmToken[]=$chef_detail[0]['fcm_token'];
                            }
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." in queue.",false,false,"");
                        if($status == "againAccepted") {
                            $fcm_notification_check = 0;
                            $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("order_status"=>"Accepted","chef_status"=>"0","chef_reason"=>"","reject_from"=>"","us_rejecter_id"=>""),"users_orders");
                        }
                    }
                    elseif($status == "Picked Up") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            }
                        }
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"admin"),'id desc','users','users.fcm_token')->result_array();
                        if(isset($outlet_detail) && !empty($outlet_detail)) {
                            foreach ($outlet_detail as $key => $out) {
                                if(!empty($out['fcm_token']))
                                    $fcmToken[]=$out['fcm_token'];
                            }
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Picked Up by the Driver.",false,false,"");
                    }
                    elseif($status == "Arrived") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                                $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Your Order has been Arrived at your address.",false,false,"");
                            }
                        }
                    }
                    elseif($status == "Delivered" || $status == "Cancelled") {
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"admin"),'id desc','users','users.fcm_token')->result_array();
                        $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                        $driver_detail = Modules::run('slider/_get_where_cols',array("driver_id"=>$order_detail[0]['uo_driver_id']),'driver_id desc','driver','driver_fcm_token')->result_array();
                        if($status == "Cancelled") {
                            $rejection_data['us_rejecter_id'] = "";
                            $rejection_check =1;
                            if($rejected_from  == "outlet") {
                                if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                    $fcmToken[]=$customer_detail[0]['fcm_token'];
                                }
                                if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token'])) {
                                    $fcmToken[]=$driver_detail[0]['driver_fcm_token'];
                                }
                                $rejection_data['us_rejecter_id'] = $outlet_id;
                            }
                            elseif($rejected_from  == "user") {
                                if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token']))
                                    $fcmToken[]=$driver_detail[0]['driver_fcm_token'];
                                if(isset($outlet_detail) && !empty($outlet_detail)) {
                                    foreach ($outlet_detail as $key => $out) {
                                        if(!empty($out['fcm_token']))
                                            $fcmToken[]=$out['fcm_token'];
                                    }
                                }
                                $rejection_data['us_rejecter_id'] = $order_detail[0]['user_id'];
                            }
                            elseif($rejected_from  == "driver") {
                                if(isset($outlet_detail) && !empty($outlet_detail)) {
                                    foreach ($outlet_detail as $key => $out) {
                                        if(!empty($out['fcm_token']))
                                            $fcmToken[]=$out['fcm_token'];
                                    }
                                }
                                if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token']))
                                    $fcmToken[]=$customer_detail[0]['fcm_token'];
                                $rejection_data['us_rejecter_id'] = $order_detail[0]['uo_driver_id'];
                                $rejection_check = $fcm_notification_check = 2;
                                $rejection_data['driver_status'] = '1';
                                $rejection_data['driver_reason'] = $rejected_reason;
                                $rejection_data['order_status'] = "Ready";
                                $this->update_specific_table(array("order_id" =>$order_id,"outlet_id"=>$outlet_id),$rejection_data,"users_orders");
                            }
                            elseif($rejected_from  == "chef" && !empty($chef_id) && is_numeric($chef_id)) {
                                if(isset($outlet_detail) && !empty($outlet_detail)) {
                                    foreach ($outlet_detail as $key => $out) {
                                        if(!empty($out['fcm_token']))
                                            $fcmToken[]=$out['fcm_token'];
                                    }
                                }
                                $rejection_data['us_rejecter_id'] = $chef_id;
                                $rejection_check = $fcm_notification_check = 2;
                                $rejection_data['chef_status'] = '1';
                                $rejection_data['chef_reason'] = $rejected_reason;
                                $rejection_data['order_status'] = "Accepted";
                                $this->update_specific_table(array("order_id" =>$order_id,"outlet_id"=>$outlet_id),$rejection_data,"users_orders");
                            }
                            else
                                $rejection_check =0;
                            if($rejection_check == 1 ) {
                                $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Cancelled from ".$rejected_from.".",false,false,"");
                                $rejection_data['reject_from'] = $rejected_from;
                                $rejection_data['accept_reject_reason'] = $rejected_reason;
                                $this->update_specific_table(array("order_id" =>$order_id,"outlet_id"=>$outlet_id),$rejection_data,"users_orders");
                            }
                            elseif($rejection_check == 2 ) {
                                $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Cancelled from ".$rejected_from.".",false,false,"");
                            }
                            else {
                                $api_status = false;
                                $message = "Cancelled parameter missing"; 
                            }
                        }
                        else {
                            if(isset($outlet_detail) && !empty($outlet_detail)) {
                                foreach ($outlet_detail as $key => $out) {
                                    if(!empty($out['fcm_token']))
                                        $fcmToken[]=$out['fcm_token'];
                                }
                            }
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token']))
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Completed",false,false,"");
                        }
                    }
                    elseif($status == "Ready to deliver") {
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"admin"),'id desc','users','users.fcm_token')->result_array();
                        if(isset($outlet_detail) && !empty($outlet_detail)) {
                            foreach ($outlet_detail as $key => $out) {
                                if(!empty($out['fcm_token']))
                                    $fcmToken[]=$out['fcm_token'];
                            }
                            
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Ready To Delivery.",false,false,"");
                    }
                    else {
                        $fcm_notification_check = 0;
                        $api_status = false;
                        $message = "invalid status given";
                    }
                    if($fcm_notification_check == "1") {
                        $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("order_status"=>$status),"users_orders");
                    }
                    if(!empty($fcmToken) && isset($fcm_data['data']) && !empty($fcm_data['data'])) {
                        $fcm_data['fcmToken'] =  $fcmToken;
                        $abc =$this->load->view('firebase_notification', $fcm_data);
                    }

                }
                else
                    $message = "Sorry! this order can not be exist";
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$api_status,"message"=>$message));
        }
        function trending_products() {
            $status = false;
            $message = "Something went wrong";
            $locations = json_decode($this->input->post('user_location_data'));
            $user_location_data = $this->get_current_location($locations);
            $page_number=$this->input->post('page_number');
            if(!is_numeric($page_number))
                $page_number = 1;
            $limit=$this->input->post('limit');
            if(!is_numeric($limit))
                $limit = 20;
            $total_pages=0;
            if(isset($locations->Country) && !empty($locations->Country) && isset($locations->City) && !empty($locations->City)) {
                $status = true;
                $message = "Tranding Products";
                $products = $this->get_trending_products_from_db(array("country"=>$locations->Country,'city'=>$locations->City,'status'=>'1'),$page_number,$limit)->result_array();
                if(!empty($products)) {
                    $temp = array();
                    foreach ($products as $key => $pro):
                        $pro_image =STATIC_FRONT_IMAGE.'pattren.png';
                        if(isset($pro['image']) && !empty($pro['image'])) {
                            if( file_exists(ACTUAL_ITEMS_IMAGE_PATH.$pro['outlet_id'].'/'.$pro['image']))
                                $pro_image = BASE_URL.ACTUAL_ITEMS_IMAGE_PATH.$outlet_id.'/'.$pro['image'];
                        }
                        $pro['image'] = $pro_image;
                        $pro['minimum_price'] = 0;
                        if(isset($pro['product_id']) && is_numeric($pro['product_id']) && !empty($pro['product_id'])) {
                            $price = Modules::run('api/_get_specific_table_with_pagination',array("product_id"=>$pro['product_id']), 'id desc',$pro['outlet_id'].'_stock','MIN('.$pro['outlet_id'].'_stock.price) as price','1','1')->result_array();
                            if(isset($price[0]['price']) && !empty($price[0]['price']))
                                $pro['minimum_price'] = $price[0]['price'];
                            $discount = 0;
                            if(isset($pro['product_discount']) && is_numeric($pro['product_discount']) && !empty($pro['product_discount']))
                                $discount = $pro['product_discount'];
                            if(isset($pro['cat_id']) && is_numeric($pro['cat_id']) && !empty($pro['cat_id']) && isset($pro['outlet_id']) && is_numeric($pro['outlet_id']) && !empty($pro['outlet_id'])) {
                                $cat_discount=$this->_get_specific_table_with_pagination(array("cd_cat_id"=>$pro['cat_id']),'cd_id desc',$pro['outlet_id'].'_category_discount','cd_discount','1','1')->result_array();
                                if(isset($cat_discount[0]['cd_discount']) && !empty($cat_discount[0]['cd_discount']) && is_numeric($cat_discount[0]['cd_discount']))
                                    $discount = $discount + $cat_discount[0]['cd_discount'];
                            }
                            $pro['discount'] = $discount;
                            unset($pro['orders']); unset($pro['product_discount']);
                            $visited_id = $this->insert_into_specific_table(array("pa_user_id"=>$user_location_data['user_id'],"pa_outlet_id"=>$pro['outlet_id'],"pa_type"=>"impression","pa_device"=>$user_location_data['device'],"pa_datetime"=>date("Y-m-d H:i:s"),"pa_country"=>$user_location_data["Country"],"pa_city"=>$user_location_data["City"],"pa_town"=>$user_location_data["Area"],'pa_product_id'=>$pro['product_id']),'product_activity');
                                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                                    $this->requested_data_store('product_activity',$visited_id,$user_location_data);
                                }
                                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                                    $this->requested_city_store('product_activity',$visited_id,$user_location_data);
                                }
                        }
                        $temp[] = $pro;
                    endforeach;
                    $products = $temp;
                    $total_pages = $this->get_trending_products_from_db(array("country"=>$locations->Country,'city'=>$locations->City,'status'=>'1'),'1','0')->num_rows();
                    $diviser=($total_pages/$limit);
                    $reminder=($total_pages%$limit);
                    if($reminder>0)
                        $total_pages=intval($diviser)+1;
                    else
                        $total_pages=intval($diviser);
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message,"products"=>$products,'page_number'=>$page_number,'total_pages'=>$total_pages));
        }
        
        /*function changed_order_status() {
            $api_status=false;
            $fcm_notification_check=1;
            $message="Something went wrong";
            $order_id = $this->input->post('order_id');
            $outlet_id = $this->input->post('outlet_id');
            $status = $this->input->post('status');
            $rejected_from = $this->input->post('rejected_from');
            $rejected_reason = $this->input->post('rejected_reason');
            $fcmToken =array();
            if(!empty($order_id) && is_numeric($order_id) && !empty($outlet_id) && is_numeric($outlet_id) && !empty($status)) {
                $order_detail = Modules::run('slider/_get_where_cols',array("order_id"=>$order_id,"outlet_id"=>$outlet_id),'id desc','users_orders','uo_driver_id,user_id,outlet_id')->result_array();
                if(!empty($order_detail)) {
                    $api_status = true;
                    $message = "Status has been changed";
                    if($status == "Ready") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            }
                        }
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("id"=>$outlet_id),'id desc','outlet','fcm_token')->result_array();
                        if(isset($outlet_detail[0]['fcm_token']) && !empty($outlet_detail[0]['fcm_token'])) {
                            $fcmToken[]=$outlet_detail[0]['fcm_token'];
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Ready for Delivered.",false,false,"");
                    }
                    elseif($status == "Accepted") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            }
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Accepted.",false,false,"");
                    }
                    elseif($status == "Picked Up") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            }
                        }
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("id"=>$outlet_id),'id desc','outlet','fcm_token')->result_array();
                        if(isset($outlet_detail[0]['fcm_token']) && !empty($outlet_detail[0]['fcm_token'])) {
                            $fcmToken[]=$outlet_detail[0]['fcm_token'];
                        }
                        $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Picked Up by the Driver.",false,false,"");
                    }
                    elseif($status == "Arrived") {
                        if(isset($order_detail[0]['user_id']) && !empty(isset($order_detail[0]['user_id']))) {
                            $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                                $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Your Order has been Arrived at your address.",false,false,"");
                            }
                        }
                    }
                    elseif($status == "Delivered" || $status == "Cancelled") {
                        $outlet_detail = Modules::run('slider/_get_where_cols',array("id"=>$outlet_id),'id desc','outlet','fcm_token')->result_array();
                        $customer_detail = Modules::run('slider/_get_where_cols',array("id"=>$order_detail[0]['user_id']),'id desc','customers','fcm_token')->result_array();
                        $driver_detail = Modules::run('slider/_get_where_cols',array("driver_id"=>$order_detail[0]['uo_driver_id']),'driver_id desc','driver','driver_fcm_token')->result_array();
                        if($status == "Cancelled") {
                            $rejection_data['rejecter_id'] = "";
                            $rejection_check =1;
                            if($rejected_from  == "outlet") {
                                if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token'])) {
                                    $fcmToken[]=$customer_detail[0]['fcm_token'];
                                }
                                if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token'])) {
                                    $fcmToken[]=$driver_detail[0]['driver_fcm_token'];
                                }
                                $rejection_data['rejecter_id'] = $outlet_id;
                            }
                            elseif($rejected_from  == "driver") {
                                if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token']))
                                    $fcmToken[]=$customer_detail[0]['fcm_token'];
                                if(isset($outlet_detail[0]['fcm_token']) && !empty($outlet_detail[0]['fcm_token']))
                                    $fcmToken[]=$outlet_detail[0]['fcm_token'];
                                $rejection_data['rejecter_id'] = $order_detail[0]['uo_driver_id'];
                            }
                            elseif($rejected_from  == "user") {
                                if(isset($driver_detail[0]['driver_fcm_token']) && !empty($driver_detail[0]['driver_fcm_token']))
                                    $fcmToken[]=$driver_detail[0]['driver_fcm_token'];
                                if(isset($outlet_detail[0]['fcm_token']) && !empty($outlet_detail[0]['fcm_token']))
                                    $fcmToken[]=$outlet_detail[0]['fcm_token'];
                                $rejection_data['rejecter_id'] = $order_detail[0]['user_id'];
                            }
                            else
                                $rejection_check =0;
                            if($rejection_check == 1 ) {
                                $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Cancelled.",false,false,"");
                                $rejection_data['reject_from'] = $rejected_from;
                                $rejection_data['accepted_or_rejected_reason'] = $rejected_reason;
                                $this->update_specific_table(array("outlet_order_id" =>$order_id),$rejection_data,$outlet_id."_orders");
                            }
                            else {
                                $api_status = false;
                                $message = "Cancelled Something went wrong"; 
                            }
                        }
                        else {
                            if(isset($customer_detail[0]['fcm_token']) && !empty($customer_detail[0]['fcm_token']))
                                $fcmToken[]=$customer_detail[0]['fcm_token'];
                            $fcm_data['data']=$this->notifiction_message("Order Id: ".$order_id,"Order no. ".$order_id." has been Completed",false,false,"");
                        }
                    }
                    else {
                        $fcm_notification_check = 0;
                        $api_status = false;
                        $message = "invalid status given";
                    }
                    if($fcm_notification_check == "1") {
                        $this->update_specific_table(array("outlet_id" =>$outlet_id,"order_id"=>$order_id),array("order_status"=>$status),"users_orders");
                    }

                    if(!empty($fcmToken) && isset($fcm_data['data']) && !empty($fcm_data['data'])) {
                        $fcm_data['fcmToken'] =  $fcmToken;
                        $this->load->view('firebase_notification', $fcm_data);
                    }

                }
            }
            header('Content-Type: application/json');
            echo json_encode(array("status"=>$api_status,"message"=>$message));
        }*/
        
        function notifiction_message($title,$message,$is_background_task,$is_new_job,$job_data) {
            if(!isset($is_background_task) || empty($is_background_task))
                $is_background_task = false;
            if(!isset($is_new_job) || empty($is_new_job))
                $is_new_job = false;
            $res = array();
            if(isset($title) && !empty($title))
                $res['data']['title'] = $title;
            if(isset($message) && !empty($message))
                $res['data']['message'] = $message;
            $res['data']['is_background_task'] = $is_background_task;
            $res['data']['is_new_job'] = $is_new_job;
            if(isset($job_data) && !empty($job_data))
                $res['data']['job_data'] = $job_data;
            $res['data']['timestamp'] = date('Y-m-d G:i:s');
            return $res;
        }
        
        function image_path_with_default($image_path,$image_name,$default_path,$default_name) {
            $path= $default_path.$default_name;
            if(isset($image_name) && !empty($image_name)) {
                $mystring = 'abc';
                $findme   = 'https://';
                $findme2   = 'http://';
                $pos = strpos($image_name, $findme);
                $pos2 = strpos($image_name, $findme2);
                if (is_numeric($pos) || is_numeric($pos2)){
                    if(file_exists($image_name))
                        $path = $image_name;
                }
                else
                  if(file_exists($image_path.$image_name))
                    $path = $image_path.$image_name;
            }
            $path=BASE_URL.$path;
            $path= str_replace(BASE_URL.BASE_URL, BASE_URL, $path);
            $path= str_replace(BASE_URL.BASE_URL.BASE_URL, BASE_URL, $path);
            return $path;
        }

        function upload_dynamic_image($actual,$large,$medium,$small,$nId,$input_name,$image_field,$image_id_fild,$table) {
            $upload_image_file = $_FILES[$input_name]['name'];
            $upload_image_file = str_replace(' ', '_', $upload_image_file);
            $file_name = 'custom_image_'.substr(md5(uniqid(rand(), true)), 8, 8). $nId . '_' . $upload_image_file;
            $file_name = strtolower(str_replace(['  ', '/','-','--','---','----', '_', '__'], '-',$file_name));
            $config['upload_path'] = $actual;
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
            $config['max_size'] = '20000';
            $config['max_width'] = '2000000000';
            $config['max_height'] = '2000000000';
            $config['file_name'] = $file_name;
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (isset($_FILES[$input_name])) {
                $this->upload->do_upload($input_name);
            }
            $upload_data = $this->upload->data();

            /////////////// Large Image ////////////////
            $config['source_image'] = $upload_data['full_path'];
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = true;
            $config['width'] = 500;
            $config['height'] = 400;
            $config['new_image'] = $large;
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
            $config['new_image'] = $medium;
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
            $data = array($image_field => $file_name);
            $where[$image_id_fild] = $nId;
            $this->insert_or_update_specific_image($where,$data,$table,$table.$image_id_fild);
        }
        function set_all_product_timing() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            if(!empty($outlet)) {
                foreach($outlet as $key => $out ) {
                    Modules::run('product/check_specific_table',$out['id'],'product_timing');
                    Modules::run('product/check_specific_table',$out['id'],'products');
                    $product = Modules::run('slider/_get_where_cols',array(),'id desc',$out['id'].'_products','id')->result_array();
                    if(!empty($product)) {
                        foreach ($product as $key => $pro) {
                            echo "outlet id  :".$out['id']. "  product id  : ".$pro['id']."<br><br>";
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Sunday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Sunday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Monday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Monday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Tuesday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Tuesday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Wednesday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Wednesday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Thursday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Thursday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Friday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Friday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                            $query =$this->insert_or_update(array("pt_product_id"=> $pro['id'],"pt_day"=>'Saturday'),array("pt_opening"=>"00:01:00","pt_closing"=>"23:59:00","pt_day"=>'Saturday',"pt_is_closed"=>'0',"pt_product_id"=>$pro['id'],"pt_outlet_id"=>$out['id']),$out['id'].'_product_timing');
                        }
    
                    }
                }
            }

        }
        function add_field() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'products');
                if ($this->db->field_exists('p_max_no', $out['id'].'_products'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_products` ADD `p_max_no` INT(100) NOT NULL AFTER `outlet_id`;');
            }
        }
        function add_order_charges_discount_taxes_table() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->num_rows();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'order_charges');
                Modules::run('product/check_specific_table',$out['id'],'order_discount');
                Modules::run('product/check_specific_table',$out['id'],'order_taxes');
            }
        }
        function add_field_order_field() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                echo $out['id']."===<br><br>";
                Modules::run('product/check_specific_table',$out['id'],'orders');
                if ($this->db->field_exists('total_products', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `total_products` varchar(100) NOT NULL AFTER `id`;');
                if ($this->db->field_exists('street_no', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `street_no` varchar(100) NOT NULL AFTER `address`;');
                if ($this->db->field_exists('houseno', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `houseno` varchar(50) NOT NULL AFTER `postcode`;');
                if ($this->db->field_exists('delivery_lat', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `delivery_lat` varchar(1000) NOT NULL AFTER `doorbell_name`;');
                if ($this->db->field_exists('delivery_lang', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `delivery_lang` varchar(1000) NOT NULL AFTER `delivery_lat`;');
                if ($this->db->field_exists('delivery_date', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `delivery_date` varchar(1000) NOT NULL AFTER `delivery_lang`;');
                if ($this->db->field_exists('delivery_time', $out['id'].'_orders'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `delivery_time` varchar(1000) NOT NULL AFTER `delivery_date`;');
            }
        }
        function add_add_on_rank() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'add_on');
                if ($this->db->field_exists('add_on_rank', $out['id'].'_add_on'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_add_on` ADD `add_on_rank` INT(11) NOT NULL AFTER `max_qty`;');
            }
        }
        function add_product_add_ons_table() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'product_add_ons');
            }
        }
        function set_outlet_dietaries() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                $dietary_data=Modules::run('slider/_get_where_cols',array("dietary_status" =>'1'),'dietary_id desc','dietary','dietary_id')->result_array();
                foreach ($dietary_data as $key => $dietary) {
                    Modules::run('outlet/insert_dietary_data',array("od_outlet_id"=>$out['id'],"od_dietary_id" =>$dietary['dietary_id']));
                }
                
            }
        }
        function add_checkin_order_detail() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'orders_detail');
                if ($this->db->field_exists('check', $out['id'].'_orders_detail'))
                {
                        echo "already exist<br>";
                }
                else
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders_detail` ADD `check` varchar(100) NOT NULL AFTER `specs_label`;');
            }
        }
        function add_charges_discount_taxes_table() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'order_charges');
                Modules::run('product/check_specific_table',$out['id'],'order_discount');
                Modules::run('product/check_specific_table',$out['id'],'order_taxes');
                Modules::run('product/check_specific_table',$out['id'],'product_timig');
            }
        }
        function add_product_timing_table() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'product_timing');
            }
        }
        function add_category_discount_table() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                Modules::run('product/check_specific_table',$out['id'],'category_discount');
            }
        }
        function truncate_add_on_product() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                echo $out['id']."=====";
                if($this->db->table_exists($out['id'].'_add_on_products'))  {
                    echo "add on products delete=======";
                    $this->db->query('TRUNCATE TABLE '.$out['id'].'_add_on_products ;');
                }
                if($this->db->table_exists($out['id'].'_product_add_ons')) {
                    echo "products add on delete=======";
                    $this->db->query('TRUNCATE TABLE '.$out['id'].'_product_add_ons ;');
                }
                if($this->db->table_exists($out['id'].'_add_on')) {
                    echo "add on delete=======";
                    $this->db->query('TRUNCATE TABLE '.$out['id'].'_add_on ;');
                }
                echo "<br><br>";
            }
        }
        function increase_postcode_city_country_lenght() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                $this->db->query('ALTER TABLE `'.$out['id'].'_orders` CHANGE `postcode` `postcode` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;');
                $this->db->query('ALTER TABLE `'.$out['id'].'_orders` CHANGE `city` `city` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;');
                $this->db->query('ALTER TABLE `'.$out['id'].'_orders` CHANGE `country` `country` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;;');
            }
            echo "adfdsaf";exit;
        }
        function check_tables_exist() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                echo $out['id']."=====";
                if($this->db->table_exists($out['id'].'_add_on'))  {
                    echo "add_on exist=======";
                }
                if($this->db->table_exists($out['id'].'_add_on_products')) {
                    echo "_add_on_products exist=======";
                }
                if($this->db->table_exists($out['id'].'_catagories')) {
                    echo "_catagories exist=======";
                }
                if($this->db->table_exists($out['id'].'_customers')) {
                    echo "_customers exist=======";
                }
                if($this->db->table_exists($out['id'].'_orders')) {
                    echo "_orders exist=======";
                }
                if($this->db->table_exists($out['id'].'_orders_detail')) {
                    echo "_orders_detail exist=======";
                }
                if($this->db->table_exists($out['id'].'_order_charges')) {
                    echo "_order_charges exist=======";
                }
                if($this->db->table_exists($out['id'].'_order_discount')) {
                    echo "_order_discount exist=======";
                }
                if($this->db->table_exists($out['id'].'_order_taxes')) {
                    echo "_order_taxes exist=======";
                }
                if($this->db->table_exists($out['id'].'_products')) {
                    echo "_products exist=======";
                }
                if($this->db->table_exists($out['id'].'_product_add_ons')) {
                    echo "_product_add_ons exist=======";
                }
                if($this->db->table_exists($out['id'].'_product_timing')) {
                    echo "_product_timing exist=======";
                }
                if($this->db->table_exists($out['id'].'_stock')) {
                    echo "_stock exist=======";
                }
                echo "<br><br>";
            }
        }
        
        function rejected_from_rejected_id_addin_every_orders() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                echo $out['id']."======outlet====<br><br>";
                Modules::run('product/check_specific_table',$out['id'],'orders');
                if ($this->db->field_exists('reject_from', $out['id'].'_orders')) {
                        echo "already reject_from exist<br>";
                }
                else {
                    echo $out['id']."======reject_from====<br><br>";
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `reject_from` VARCHAR(100) NOT NULL AFTER `accepted_or_rejected_time`;');
                }
                if ($this->db->field_exists('rejecter_id', $out['id'].'_orders')) {
                        echo "already rejecter_id exist<br>";
                }
                else {
                    echo $out['id']."======rejecter_id====<br><br>";
                    $this->db->query('ALTER TABLE `'.$out['id'].'_orders` ADD `rejecter_id` INT(100) NOT NULL AFTER `reject_from`;');
                }
            }
        }
        
        function delete_all_previous_orders() {
            $outlet = Modules::run('slider/_get_where_cols',array(),'id desc','outlet','id')->result_array();
            foreach ($outlet as $key => $out) {
                echo $out['id']."===<br><br>";
                if($this->db->table_exists($out['id'].'_orders')) {
                    $orders = Modules::run('slider/_get_where_cols',array('create_date <='=>'2019-01-02 00:00:00'),'id desc',$out['id'].'_orders','id')->result_array();
                    if(!empty($orders)) {
                        foreach ($orders as $key => $or) {
                            echo "outlet id====".$out['id']."=====order id====".$or['id']."====<br><br>";
                            echo "order detail deleted========<br><br>";
                            $this->delete_from_specific_table(array("order_id"=>$or['id']),$out['id'].'_orders_detail');
                            echo "order charges deleted========<br><br>";
                            $this->delete_from_specific_table(array("order_id"=>$or['id']),$out['id'].'_order_charges');
                            echo "order taxes deleted========<br><br>";
                            $this->delete_from_specific_table(array("order_id"=>$or['id']),$out['id'].'_order_taxes');
                            echo "order discount deleted========<br><br>";
                            $this->delete_from_specific_table(array("order_id"=>$or['id']),$out['id'].'_order_discount');
                            echo "deleted from orders===========<br><br>";
                            $this->delete_from_specific_table(array("id"=>$or['id']),$out['id'].'_orders');

                            echo "deleted from users orders===========<br><br>";
                            $this->delete_from_specific_table(array("outlet_id"=>$out['id'],"order_id"=>$or['id']),'users_orders');
                        }
                        $orders = Modules::run('slider/_get_where_cols',array('create_date <='=>'2019-01-02 00:00:00'),'id desc',$out['id'].'_orders','id')->result_array();
                        if(empty($orders)) {
                            $this->delete_from_specific_table(array("id !="=>"0"),$out['id'].'_orders_detail');
                            $this->delete_from_specific_table(array("oc_id !="=>"0"),$out['id'].'_order_charges');
                            $this->delete_from_specific_table(array("ot_id !="=>"0"),$out['id'].'_order_taxes');
                            $this->delete_from_specific_table(array("od_id !="=>"0"),$out['id'].'_order_discount');
                            $this->delete_from_specific_table(array("id !="=>"0"),$out['id'].'_orders');
                            $this->delete_from_specific_table(array("outlet_id"=>$out['id']),'users_orders');
                        }
                    }
                    else {
                        $this->delete_from_specific_table(array("outlet_id"=>$out['id']),'users_orders');
                        echo $out['id']."===have no order =====<br><br>";
                    }
                    echo $out['id']."=======delete==customer table<br><br>";
                    $this->db->query('DROP TABLE IF EXISTS `'.$out['id'].'_customers`');
                }
                else
                    echo $out['id'].'_orders'."=========table does not exist=======<br><br>";
            }
        }
        function delete_images_by_name($actual_path,$large_path,$medium_path,$small_pathm,$name) {
            if (file_exists($actual_path.$name))
                unlink($actual_path.$name);
            if (file_exists($large_path.$name))
                unlink($large_path.$name);
            if (file_exists($medium_path.$name))
                unlink($medium_path.$name);
            if (file_exists($small_pathm.$name))
                unlink($small_pathm.$name);
        }
        function check_favourite_food($where_check){
            $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->check_favourite_food($where_check);

        }
        function insert_or_delete($where,$data,$table){
            $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->insert_or_delete($where,$data,$table);

        }
        function insert_or_update($where,$data,$table){
            $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->insert_or_update($where,$data,$table);
        }
        function insert_into_specific_table($data,$table){
            $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->_insert_into_specific_table($data,$table);
        }
        function delete_from_specific_table($where,$table) {
            $this->load->model('mdl_perfectmodel');
            return $this->load->mdl_perfectmodel->delete_from_specific_table($where,$table);

        }
        function insert_or_update_specific_image($where,$data,$table,$index){
            $this->load->model('mdl_perfectmodel');
            return $this->mdl_perfectmodel->insert_or_update_specific_image($where,$data,$table,$index);
        }
        function update_specific_table($where,$data,$table){
            $this->load->model('mdl_perfectmodel');
            return $this->mdl_perfectmodel->update_specific_table($where,$data,$table);
        }
        function _get_specific_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_specific_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit);
            return $query;
        }
        ///////////////////////////umar insights start/////////////////////////
        function get_city_areas($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_city_areas($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where,$and_where,$having);
            return $query;
        }
        function _get_specific_table_with_pagination_and_where($cols, $order_by,$table,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_specific_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having='');
            return $query;
        }
        function _get_specific_table_with_pagination_where_groupby($cols, $order_by,$group_by='',$table,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_specific_table_with_pagination_where_groupby($cols, $order_by,$group_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having='');
            return $query;
        }
        ///////////////////////////umar insights end/////////////////////////
        function get_trending_products_from_db($where,$page_number,$limit) {
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_trending_products_from_db($where,$page_number,$limit);
            return $query;
        }
        function _get_outlet_types($cols, $order_by,$select,$page_number,$limit){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_outlet_types($cols, $order_by,$select,$page_number,$limit);
            return $query;
        }
        function _get_user_favourite_products_with_pagination($cols,$select,$page_number,$limit){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_user_favourite_products_with_pagination($cols,$select,$page_number,$limit);
            return $query;
        }
        function get_catagories_outlets($cols,$select,$order_by,$page_number,$limit){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_catagories_outlets($cols,$select,$order_by,$page_number,$limit);
            return $query;
        }
        function get_product_add_on_with_add_detail($where,$order_by,$select,$outlet_id,$page_number,$limit){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_product_add_on_with_add_detail($where,$order_by,$select,$outlet_id,$page_number,$limit);
            return $query;
        }
        function get_nearest_outlest($where,$like,$order_by){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_nearest_outlest($where,$like,$order_by);
            return $query;
        }
        function get_nearest_outlest_by_cat_name($where,$like,$order_by){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_nearest_outlest_by_cat_name($where,$like,$order_by);
            return $query;
        }
         function get_nearest_outlest_search_wise($where,$like,$order_by){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_nearest_outlest_search_wise($where,$like,$order_by);
            return $query;
        }
       
        function get_outlet_product_max_min_price($where,$outlet_id,$having){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_outlet_product_max_min_price($where,$outlet_id,$having);
            return $query;
        }
        function get_specific_table_data($where,$order,$select,$table_name,$page_number,$limit) {
            $this->load->model('mdl_perfectmodel');
            return $this->mdl_perfectmodel->get_specific_table_data($where,$order,$select,$table_name,$page_number,$limit);
        }
        function get_driver_basic_info($where,$order_by,$select){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_driver_basic_info($where,$order_by,$select);
            return $query;
        }
        function get_driver_vehicle_info($where,$order_by,$select){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_driver_vehicle_info($where,$order_by,$select);
            return $query;
        }
        function _get_user_order_list($cols, $order_by,$table,$select,$where_status,$page_number,$limit){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->_get_user_order_list($cols, $order_by,$table,$select,$where_status,$page_number,$limit);
            return $query;
        }
        function get_order_items($where, $order_by,$table_name,$group_by,$select){
            $this->load->model('mdl_perfectmodel');
            $query = $this->mdl_perfectmodel->get_order_items($where, $order_by,$table_name,$group_by,$select);
            return $query;
        }
        /*((latitude-"'.$user_lat.'")*(latitude-"'.$user_lat.'")) + ((longitude - "'.$user_long.'")*(longitude - "'.$user_long.'")) ASC*/
    ///////////////////////////end umar apis/////////////////////////
    /////////////////////asad apis////////////////////////
   function get_product_detail(){
       $item=$this->input->post('product_data');
       
     /* $item='{"status":"true","order_type":"schedule","date":"2018-10-28","time":"13:15:00","outlet_id":12,"product_data":[{"product_id":8},{"product_id":11}]}';*/
       $chek_out_array=array();
       
        $product_id='';  
        $checkout_detail=json_decode($item);
        $order_type=$checkout_detail->order_type;
        
        $outlet_id=$checkout_detail->outlet_id;
        $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
            if(!empty($timezone))
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones'])) {
                         date_default_timezone_set($timezone[0]['timezones']);
                     }
        
        

        $product_ids=$checkout_detail->product_data;
        if(isset($order_type) && $order_type=="schedule"){
            
            $schedule_date=$checkout_detail->date;
            $schedule_time=$checkout_detail->time;
            $day=date('l', strtotime($schedule_date));
            
             $timing=Modules::run('outlet/outlet_open_close',array("timing.outlet_id"=>$outlet_id,"timing.day"=>$day,"timing.opening <="=>$schedule_time,"timing.closing >="=>$schedule_time))->result_array();

           if(!empty($timing)) {
            if($timing[0]['is_closed'] ==0)
                $rec['open_close']='Open';
            else
                {
                $rec['open_close']='Close';
                $message="Food point will  closed on your schedule time";
                }

            }
            else{
                 $rec['open_close']='Close';
                  $message="Food point will closed on your schedule time";
             }
               
        }
        else{
            
            
            $timing=Modules::run('outlet/outlet_open_close',array("timing.outlet_id"=>$outlet_id,"timing.day"=>date('l'),"timing.opening <="=>date('H:i:s'),"timing.closing >="=>date('H:i:s')))->result_array();
          
            if(!empty($timing)) {
            if($timing[0]['is_closed'] ==0)
                $rec['open_close']='Open';
            else{
                $rec['open_close']='Close';
                $message="Food point is closed now";
            }
                


            }
             else{
                 $rec['open_close']='Close';
                  $message="Food point is closed now";
             }
                
                
        }
        if(isset($rec) && $rec['open_close']=='Close'){
             header('Content-Type: application/json');
                echo json_encode(array("status"=>false,"outlet_id"=>$outlet_id, "outlet_status"=>$rec['open_close'],"message"=>$message));exit();
        }
        if (isset($product_ids) && !empty($product_ids)) {
           
            foreach ($product_ids as $key => $product_data) {  
              $data['product_id']=$product_data->product_id;
              
              if(isset($order_type) && $order_type=="schedule"){
                $current_date=date('Y-m-d');
                $current_time=date("h:i:"."00");
                $schedule_date=$checkout_detail->date;
                 $schedule_time=$checkout_detail->time;
                $next_date=date('Y-m-d', strtotime(' +3 day'));
                
                if ($schedule_date < $current_date || $schedule_time <  $current_time || $schedule_date >$next_date) {
                     header('Content-Type: application/json');
                echo json_encode(array("status"=>false,"outlet_id"=>$outlet_id, "message"=>"please make schedule b/w next three days"));exit();
                }
                $schedule_date=$checkout_detail->date;
                $schedule_time=$checkout_detail->time;
                if(isset($product_data->Cat_id) && !empty($product_data->Cat_id) &&$product_data->Cat_id="deal"){
                    $data['available']=$this->schedule_product_avaibility_time_deals($outlet_id,$product_data->product_id,$schedule_date,$schedule_time);
                }
                else{
                    
                    $data['available']=$this->schedule_product_avaibility_time($outlet_id,$product_data->product_id,$schedule_date,$schedule_time);
                }
                
              }
              else{
                   
                  if(isset($product_data->Cat_id) && !empty($product_data->Cat_id) && $product_data->Cat_id="deal"){
                    $data['available']=$this->check_product_avaibility_time_deals($outlet_id,$product_data->product_id);
                }
                else{
                    $data['available']=$this->check_product_avaibility_time($outlet_id,$product_data->product_id);
                    
       
                }
                 
                
              }
              
              $chek_out_array[]=$data;
            }
        }
        $avaibility=true;
        $count=0;
        if(isset($chek_out_array) && !empty($chek_out_array)){
            foreach($chek_out_array as $row){
                if($row['available']==false){
                    $count=$count+1;
                }
                
            }
        }
        if($count >0)  $avaibility=false;
        header('Content-Type: application/json');
        echo json_encode(array("status"=>true,"availability"=>$avaibility,"outlet_id"=>$outlet_id, "outlet_status"=>$rec['open_close'],"items"=>$chek_out_array));
    }
    function check_product_avaibility_time($outlet_id,$product_id){
        $product_availability=false;  
        $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                $product_timing = Modules::run('slider/_get_where_cols',array("pt_product_id" =>$product_id),'pt_day asc',$outlet_id.'_product_timing','pt_id,pt_day,pt_opening,pt_closing,pt_is_closed')->result_array();
                
                if(!empty($timezone))
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']) && !empty($product_timing)) {
                         date_default_timezone_set($timezone[0]['timezones']);

                         foreach ($product_timing as $key => $pt) {
                              if($pt['pt_is_closed'] ==1){
                                $product_availability=false;
                            }elseif($pt['pt_day'] == date('l')) {
                                if(date("H:i:s") >= $pt['pt_opening'] && date("H:i:s") <= $pt['pt_closing']) 
                                    $product_availability=true;
                                else
                                    $product_availability=false;
                             }
                         }
           
        }
        return $product_availability;             
    }
    function check_product_avaibility_time_deals($outlet_id,$product_id){
        $product_availability=false;
         
        $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                $product_timing = Modules::run('slider/_get_where_cols',array("dt_deal_id" =>$product_id),'dt_day asc','deals_timing','dt_id,dt_day,dt_opening,dt_closing,dt_is_closed')->result_array();
                
                if(!empty($timezone))
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']) && !empty($product_timing)) {
                         date_default_timezone_set($timezone[0]['timezones']);

                         foreach ($product_timing as $key => $pt) {
                              if($pt['dt_is_closed'] ==1){
                                $product_availability=false;
                            }elseif($pt['dt_day'] == date('l')) {
                                if(date("H:i:s") >= $pt['dt_opening'] && date("H:i:s") <= $pt['dt_closing']) 
                                    $product_availability=true;
                                else
                                    $product_availability=false;
                             }
                         }
           
        }
        return $product_availability;             
    }
    function schedule_product_avaibility_time($outlet_id,$product_id,$date,$time){
        $product_availability=false;
     
        $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                $product_timing = Modules::run('slider/_get_where_cols',array("pt_product_id" =>$product_id),'pt_day asc',$outlet_id.'_product_timing','pt_id,pt_day,pt_opening,pt_closing,pt_is_closed')->result_array();
                
                if(!empty($timezone))
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']) && !empty($product_timing)) {
                         date_default_timezone_set($timezone[0]['timezones']);
                         $day=date('l', strtotime($date));
                        
                         $current_time=date('H:i:s');
                         foreach ($product_timing as $key => $pt) {
                              if($pt['pt_is_closed'] ==1){
                                $product_availability=false;
                                
                            }elseif($pt['pt_day'] == $day) {
                                if($time >= $pt['pt_opening'] && $time<= $pt['pt_closing'] ) 
                                    $product_availability=true;
                                else
                                    $product_availability=false;
                             }
                         }
           
        }
        return $product_availability;   
        
    }
    function schedule_product_avaibility_time_deals($outlet_id,$product_id,$date,$time){
        $product_availability=false;
        $timezone = Modules::run('slider/_get_where_cols',array("outlet_id" =>$outlet_id),'id desc','general_setting','timezones')->result_array();
                $product_timing = Modules::run('slider/_get_where_cols',array("dt_deal_id" =>$product_id),'dt_day asc','deals_timing','dt_id,dt_day,dt_opening,dt_closing,dt_is_closed')->result_array();
                
                if(!empty($timezone))
                    if(isset($timezone[0]['timezones']) && !empty($timezone[0]['timezones']) && !empty($product_timing)) {
                         date_default_timezone_set($timezone[0]['timezones']);
                         $day=date('l', strtotime($date));
                        
                         $current_time=date('H:i:s');
                         foreach ($product_timing as $key => $pt) {
                              if($pt['dt_is_closed'] ==1){
                                $product_availability=false;
                                
                            }elseif($pt['dt_day'] == $day) {
                                if($time >= $pt['dt_opening'] && $time<= $pt['dt_closing'] ) 
                                    $product_availability=true;
                                else
                                    $product_availability=false;
                             }
                         }
           
        }
        return $product_availability;   
        
    }
    ///////////////////////end asad apis////////////
    function test_api(){
         header('Content-Type: application/json');
            echo json_encode(array("status"=>1));
    }
    ////////////////////////////////
              /////////////Final PLace order api with Payment integration     BY Asad Ali           ///////////////////////////////
     function place_order(){
        $order_data=json_decode($this->input->post('order_data'));
        $outlet_id=$order_data->Cartdata[0]->Outletid;

        
        $order_id=$this->get_user_order_detail();
        $user_id=$order_data->Userdata[0]->Userid;
        ////////////charges table
        $order_charges=$order_data->Charges;
        if(isset($order_charges) && !empty($order_charges)){
            foreach ($order_charges as $key => $chr_value) {
                $charges['order_id']=$order_id;
                $charges['outlet_id']=$outlet_id;
                $charges['charges_name']=$chr_value->charges_name;
                $charges['charges_type']=$chr_value->charges_type;
                $charges['charges_amount']=$chr_value->charges_amount;
                $charges_id[]=$this->insert_user_order_taxes($charges,
                "order_charges",$outlet_id);
            }
            
        }
       //////////////////////charges End
        /////////Discount TAble///////////
        $order_discount=$order_data->Discounts;
        if(isset($order_discount) && !empty($order_discount)){
            foreach ($order_discount as $key => $disc_value) {
                $disc['order_id']=$order_id;
                $disc['outlet_id']=$outlet_id;
                $disc['discount_name']=$disc_value->discount_name;
                $disc['discount_type']=$disc_value->discount_type;
                $disc['discount_value']=$disc_value->discount_amount;
                $disc_id[]=$this->insert_user_order_taxes($disc,"order_discount",$outlet_id);
            }
            
        }
        ////////////////////Taxes table/////
        ///////
         $order_taxes=$order_data->Taxes;
        if(isset($order_taxes) && !empty($order_taxes)){
            foreach ($order_taxes as $key => $disc_value) {
                $taxes['order_id']=$order_id;
                $taxes['outlet_id']=$outlet_id;
                $taxes['tax_name']=$disc_value->tax_name;
                $taxes['tax_type']=$disc_value->tax_type;
                $taxes['tax_value']=$disc_value->tax_amount;
                $taxes_id[]=$this->insert_user_order_taxes($taxes,"order_taxes",$outlet_id);
            }
            
        }
        $orderamount=$order_data->Finalprice;
        $orderamount=$orderamount;
        $orderamount=floor($orderamount);
        $orderamount=$orderamount.'00';
        $amount=(int)$orderamount;
       
        
        
        $this->get_order_detail_products($order_id,$outlet_id);
        ///////////////////////////umar insights start/////////////////
        if(isset($outlet_id) && !empty($outlet_id) && is_numeric($outlet_id) && ($outlet_id > 0) && isset($order_id) && !empty($order_id) && is_numeric($order_id) && ($order_id > 0)) {
            $outlet_detail = Modules::run('slider/_get_where_cols',array("outlet_id"=>$outlet_id,"designation"=>"admin"),'id desc','users','users.fcm_token')->result_array();
            if(isset($outlet_detail) && !empty($outlet_detail)) {
                foreach ($outlet_detail as $key => $out):
                    if(!empty($out['fcm_token']))
                        $fcmToken[]=$out['fcm_token'];
                endforeach;
            }
            $fcm_data['data']=$this->notifiction_message("Order No: ".$order_id,"New Order Received.",false,false,"");
            if(!empty($fcmToken) && isset($fcm_data['data']) && !empty($fcm_data['data'])) {
                $fcm_data['fcmToken'] =  $fcmToken;
                $abc =$this->load->view('firebase_notification', $fcm_data);
            }
        } 
        ///////////////////////////umar insights end/////////////////
       
        $history['outlet_id']=$outlet_id;
        $history['user_id']=$user_id;
        $history['order_id']=$order_id;
        $history['order_status']="Order Placed";
        $history['order_type']=$order_data->Ordertype;
        
        $history['payment_status']=PS_IN_COMPLETE;
        $payment_method=$order_data->payment_type;
        if(isset( $payment_method)&& $payment_method==PM_CARD){
            $payment_method = PM_CARD;
        }
        elseif (isset($payment_method) && $payment_method==PM_CASH){
            $payment_method = PM_CASH;
        }
        else{
          $payment_method = PM_CARD;
          
        }
        $id=$this->_insert_user_order_history($history,$outlet_id);
        $responce=$this->get_payment_url_response($order_id,$amount);
       if(isset($payment_method) && $payment_method==PM_CARD){
        $responce=$this->get_payment_url_response($order_id,$amount);
        $xml_responce=simplexml_load_string($responce); 
        $json_array = json_encode($xml_responce); // convert the XML string to JSON
        $simple_array= json_decode($json_array,TRUE);
        if(isset($simple_array) && !empty($simple_array)){
            $data_in['outlet_id']=$outlet_id;
            $data_in['order_id']=$order_id;
            $data_in['transaction_id']=$simple_array['TransactionId'];
            $ret_id=$this->insert_transaction_detail_db($data_in);
             header('Content-Type: application/json');
            echo json_encode(array("status"=> true, "transactionid"=>$simple_array['TransactionId'],"Orderid"=>$order_id));
        }
       }else{
         $this->send_email($order_id,$outlet_id,0);
        header('Content-Type: application/json');
            echo json_encode(array("status"=> true,"Orderid"=>$order_id,"Outletid"=>$outlet_id));
       }
      

        
    }
    function get_payment_url_response($order_id,$amount){
        $site=BASE_URL.'payment-responce';
        $url = "https://epayment.nets.eu/Netaxept/Register.aspx?merchantId=712356&token=8w?F_4P&orderNumber=".$order_id."&amount=".$amount."&CurrencyCode=NOK&redirectUrl=".$site."";
         $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        // This is what solved the issue (Accepting gzip encoding)
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
   function get_payment_responce()  {

       $transactionId=$this->input->get('transactionId');
       $resp_code=$this->input->get('responseCode');

       if ($resp_code=="Cancel") {
        $data_update['is_print'] = 1;
        $data_update['payment_status'] = PS_IN_COMPLETE;
        $data_update['transaction_id'] = $transactionId;
        $where['transaction_id']=$transactionId;
        
        $result=$this->get_transaction_detail_db($where)->result_array();
        $outlet_id=$result[0]['outlet_id'];
        $order_id=$result[0]['order_id'];

        $chk = Modules::run('orders/_update_where_id', $order_id, $data_update, $outlet_id);
        $data['order_status']="Cancelled";
        $data['reject_from']="user";
        $data['accept_reject_reason']="Payment cancelled by user";
        $data['payment_status']=PS_IN_COMPLETE;
        $insert_or_update=$this->insert_or_update(array("order_id"=>$order_id,"outlet_id"=>$outlet_id),$data,'users_orders');
           redirect(BASE_URL.'cancelurl');
          
       }
       $data_update['transaction_id']=$transactionId;
        $where['transaction_id']=$transactionId;
        
        $result=$this->get_transaction_detail_db($where)->result_array();
        $outlet_id=$result[0]['outlet_id'];
        $order_id=$result[0]['order_id'];
       $chk = Modules::run('orders/_update_where_id', $order_id, $data_update, $outlet_id);
       
       $url= "https://epayment.nets.eu/Netaxept/Process.aspx?merchantId=712356&token=8w?F_4P&transactionId=".$transactionId."&operation=AUTH";
        
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        // This is what solved the issue (Accepting gzip encoding)
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
        $response = curl_exec($ch);
        curl_close($ch);
         $xml_responce=simplexml_load_string($response); 
        $json_array = json_encode($xml_responce); // convert the XML string to JSON
        $simple_array= json_decode($json_array,TRUE);

        $responce_code=$simple_array['ResponseCode'];
        if(isset($responce_code)&& $responce_code=="OK"){
            $transactionId=$simple_array['TransactionId'];
            $this->get_final_payment_result($transactionId);
        }
        else{
            redirect(BASE_URL.'payment-error');

        }
        
    }
     function cancelurl() {
         $data['title'] = 'Canceled';
         $data['message'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.';
         return $this->load->view('paymentresult',$data);
        /*$status=false;
        $error="Cancel";
        $message="Du har kansellert betaling. Fortsett til handlekurven";
         header('Content-Type: application/json');
        echo json_encode(array("status"=>$status, "error"=>$error,"message"=>$message));*/
     
    }
     function payment_error(){
         $data['title'] = 'Error';
         $data['message'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.';
         return $this->load->view('paymentresult',$data);
        /*$status=false;
        $error="failed";
        $message="transaksjonen feilet:-Transaksjonen er kansellert av kortutstederen din";
         header('Content-Type: application/json');
        echo json_encode(array("status"=>$status, "error"=>$error,"message"=>$message));*/
      
    }
    function update_payment_status($data_update,$order_id,$transactionId){
       
        
     $where['transaction_id']=$transactionId;
       $where['order_id']=$order_id;
       $result=$this->get_transaction_detail_db($where)->result_array();
       $outlet_id=$result[0]['outlet_id'];
       $this->send_email($order_id,$outlet_id,0);
        if (isset($data_update['cardno']) && !empty($data_update['cardno']) ){
        $chk = Modules::run('orders/_update_where_id', $order_id, $data_update, $outlet_id);
        $data['order_status']="Order Placed";
        $data['payment_status']=PS_COMPLETE;
        $insert_or_update=$this->insert_or_update(array("order_id"=>$order_id,"outlet_id"=>$outlet_id),$data,'users_orders');
        }
    } 
     function get_final_payment_result($transactionId){
        $id = $transactionId;
       
        $finalurl="https://epayment.nets.eu/Netaxept/Query.aspx?merchantId=712356&token=8w?F_4P&transactionId=".$id."";
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $finalurl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        // This is what solved the issue (Accepting gzip encoding)
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
        $response = curl_exec($ch);
        curl_close($ch);
         $xml_responce=simplexml_load_string($response); 
        $json_array = json_encode($xml_responce); // convert the XML string to JSON
        $simple_array= json_decode($json_array,TRUE);

        $order_id=$simple_array['OrderInformation']['OrderNumber'];
        $data_update['cardno']=$simple_array['CardInformation']['MaskedPAN'];
        $data_update['is_print'] = 0;
        $data_update['payment_status'] = PS_COMPLETE;
        $data_update['transaction_id'] = $id;


        $this->update_payment_status($data_update,$order_id,$id);
        redirect(BASE_URL.'accept-url');
    }
     function payment_accepturl() {
         $data['title'] = 'Success';
         $data['message'] = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.';
         return $this->load->view('paymentresult',$data);
      /*  $status=true;
        $message="Transaction completed";
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message));*/
     }
    function get_user_order_detail(){
        $order_data=json_decode($this->input->post('order_data'));
        $order['customer_id'] = $order_data->Userdata[0]->Userid;
        $order['customer_name'] = $order_data->Userdata[0]->Username;
        $order['mobile'] = $order_data->Userdata[0]->Usernumber;
        $order['email'] = $order_data->Userdata[0]->Useremail;
        $order['create_date'] = date('Y-m-d H:i:s');
        $order['type'] = $order_data->Ordertype;
        $order['transaction_id'] = '';
        $order['user_id'] = 0;
        $order['emp_code'] = 0;
        $order['is_print']=0; 
        $outlet_id=$order_data->Cartdata[0]->Outletid;

        $order['outlet_id']=$outlet_id;
        $order['status'] = OS_IN_PROCESS;
         $payment_method=$order_data->payment_type;
       if(isset( $payment_method)&& $payment_method==PM_CARD){
          $order['payment_method'] = PM_CARD;
          $order['payment_status'] = PS_IN_COMPLETE;
          $order['is_print']=1;
        }
        elseif (isset($payment_method) && $payment_method==PM_CASH){
            $order['payment_method'] = PM_CASH;
            $order['payment_status'] = PS_IN_COMPLETE;
            $order['is_print']=0;
        }
        else{
          $order['payment_method'] = PM_CARD;
          $order['payment_status'] = PS_IN_COMPLETE;
          $order['is_print']=1;
        }
        $order['is_bill'] = '';  // DISCUSS ??
        $order['is_walking'] = '';  // DISCUSS ??
        
        $order['subtotal'] = $order_data->Cartdata[0]->Grandprice;
        $order['total_products'] = $order_data->Cartdata[0]->Quantity;
        $order['total_price']=$order_data->Finalprice;
        $order['delivery_note'] = $order_data->Ordernote;
        $order['create_from'] = "Android";
        $general_setting = $this->get_general_setting($outlet_id)->result_array();

       if ($order['type'] == "delivery") {
            if(isset($order_data->Deliverylocation[0]->Lat) && !empty($order_data->Deliverylocation[0]->Lat)){
                $order['delivery_lat'] = $order_data->Deliverylocation[0]->Lat;
            }
            else{
                $order['delivery_lat'] = "";
            }
            if(isset($order_data->Deliverylocation[0]->Long) && !empty($order_data->Deliverylocation[0]->Long)){
                $order['delivery_lang'] = $order_data->Deliverylocation[0]->Long;
            }
            else{
               $order['delivery_lang'] ="";
            }
            if(isset($order_data->Deliverylocation[0]->Address) && !empty($order_data->Deliverylocation[0]->Address)){
                $order['address'] = $order_data->Deliverylocation[0]->Address;
            }
            else{
              $order['address'] = "";
            }
            if(isset($order_data->Deliverylocation[0]->Street) && !empty($order_data->Deliverylocation[0]->Street)){
                $order['street_no'] = $order_data->Deliverylocation[0]->Street;
            }
            else{
              $order['street_no'] = "";
            }
             if(isset($order_data->Deliverylocation[1]->Flat) && !empty($order_data->Deliverylocation[1]->Flat)){
               $order['houseno'] = $order_data->Deliverylocation[1]->Flat;
            }
            else{
             $order['houseno'] ="";
            }
            if(isset($order_data->Deliverylocation[0]->Country) && !empty($order_data->Deliverylocation[0]->Country)){
             $order['country'] =$order_data->Deliverylocation[0]->Country;
            
            }
            else{
             $order['country'] ="";
            }
              
            if(isset($order_data->Deliverylocation[0]->City) && !empty($order_data->Deliverylocation[0]->City)){
              
             $order['city'] =$order_data->Deliverylocation[0]->City;
             $where['city.city_name']=$order_data->Deliverylocation[0]->City;
             $city_data =$this->_get_specific_table_with_pagination($where, 'city_id desc','city','city.city_id','1','0')->result_array();
                if(empty($city_data)  && !empty($order_data->Deliverylocation[0]->Country)){
                $where_country['country.country_name']=$order_data->Deliverylocation[0]->Country;
                $country_data =$this->_get_specific_table_with_pagination($where, 'c_id desc','country','country.c_id','1','0')->result_array();
                    if(!empty($country_data))
                        $country_id=$country_data[0]['c_id'];
                   $impression_id = $this->insert_into_specific_table(array("rc_name"=>$order_data->Deliverylocation[0]->City,"rc_type"=>"order","type_id"=>$order_id,"outlet_id"=>$outlet_id,"rc_country"=>$country_id),"requested_city");
                 }
                 elseif(!empty($city_data)){
                     $city_id=$city_data[0]['city_id'];
                 }
                
            }
            else{
             $order['city'] ="";
            }
           if(isset($order_data->Deliverylocation[0]->Area) && !empty($order_data->Deliverylocation[0]->Area)){
              $order['postcode'] = $order_data->Deliverylocation[0]->Area;
            }
            else{
             $order['postcode'] ="";
            }
           if(isset($order_data->Date) && !empty($order_data->Date))
                $order['delivery_date']=$order_data->Date;
             if(isset($order_data->Time) && !empty($order_data->Time))
                $order['delivery_time']=$order_data->Time;
        }
        $arr_where['outlet_id'] = $outlet_id;
        $outlet_order_id = Modules::run('orders/_get_max_where', $arr_where, 'outlet_order_id',$outlet_id);
        if (isset($outlet_order_id) && !empty($outlet_order_id))
            $outlet_order_id = $outlet_order_id + 1;
        else
            $outlet_order_id = 1;
        $order['outlet_order_id'] = $outlet_order_id;  // this colum added by wasim
        $order['station_name'] = Modules::run('outlet/_get_name', $outlet_id);
        $order_id = Modules::run('orders/_insert', $order,$outlet_id);
        
        ///////////////////////////umar insights/////////////////
        $country_id=0;
        $city_id=0;
         if(isset($order_data->Deliverylocation[0]->City) && !empty($order_data->Deliverylocation[0]->City)){
              
             $where['city.city_name']=$order_data->Deliverylocation[0]->City;
             $city_data =$this->_get_specific_table_with_pagination($where, 'city_id desc','city','city.city_id','1','0')->result_array();
                if(empty($city_data)  && !empty($order_data->Deliverylocation[0]->Country)){
                $where_country['country.country_name']=$order_data->Deliverylocation[0]->Country;
                $country_data =$this->_get_specific_table_with_pagination($where, 'c_id desc','country','country.c_id','1','0')->result_array();
                    if(!empty($country_data)){
                          $country_id=$country_data[0]['c_id'];
                            $impression_id = $this->insert_into_specific_table(array("rc_name"=>$order_data->Deliverylocation[0]->City,"rc_type"=>"order","type_id"=>$order_id,"outlet_id"=>$outlet_id,"rc_country"=>$country_id),"requested_city");
                       }
                       else{
                             $country_id = $this->insert_into_specific_table(array("country_name"=>$order_data->Deliverylocation[0]->Country),"country");
                       }
                      
                   
                 }
                 elseif(!empty($city_data)){
                     $city_id=$city_data[0]['city_id'];
                 }
                
            }
            if(isset($order_data->Deliverylocation[0]->Area) && !empty($order_data->Deliverylocation[0]->Area)){
               $where_country['city_town.town_name']=$order_data->Deliverylocation[0]->Area;
               $where_country['city_town.city_town_id']=$city_id;
                $town_data =$this->_get_specific_table_with_pagination($where, 'town_id desc','city_town','city_town.town_id','1','0')->result_array();
                if(empty($town_data)){
                      $impression_id = $this->insert_into_specific_table(array("rt_name"=>$order_data->Deliverylocation[0]->Area,"  rt_type"=>"order","type_id"=>$order_id,"outlet_id"=>$outlet_id,"rt_city"=>$city_id),"requested_town");
                     }
                    
            }
            ///////////////////////////umar insights/////////////////
        return $order_id;
    }
    function get_order_detail_products($order_id,$outlet_id){
        $order_data=json_decode($this->input->post('order_data'));
        $arr_products=$order_data->Cartdata;
        $arr_products=$arr_products[0]->Data;
        if(isset($arr_products) && !empty($arr_products)){
         
                    foreach ($arr_products as $key => $order_data) {

                        if(isset($order_data->Sizes) && $order_data->Sizes==true){
                            foreach ($order_data->Data as $key => $sizes_data) {
                                
                                if($sizes_data->Check=="Size"){
                                $detail_data['product_id'] =$sizes_data->Productid;
                                $detail_data['product_name'] =$sizes_data->Name;
                                $detail_data['category_id'] =$order_data->Catid;
                                $detail_data['check']=$sizes_data->Check;
                                $detail_data['total_product_price']=$order_data->Totalprice;
                               
                                $detail_data['product_price'] =$sizes_data->Price;
                               
                                $detail_data['stock_id'] =$sizes_data->Id;
                                $detail_data['comments'] = "";
                                if(isset($sizes_data->Label))
                                $detail_data['specs_label'] =$sizes_data->Label;
                                else
                                    $detail_data['specs_label'] ="";
                                $detail_data['item_id'] = "";
                                $detail_data['quantity'] = $sizes_data->Quantity; //
                                $detail_data['product_no'] = "";
                                $detail_data['order_id'] = $order_id;
                                $detail_data['parent_id'] = 0; 
                                
                                //
                                $order_detail_id = Modules::run('orders/_insert_table_order_detail', $detail_data,$outlet_id);
                                }
                                
                            }
                          
                        }
                        elseif(isset($order_data->Sizes) && $order_data->Sizes==false){
                            $detail_data['product_id'] =$order_data->Productid;
                            $detail_data['category_id'] =$order_data->Catid;
                                $detail_data['product_name'] =$order_data->Productname;
                              
                                $detail_data['check']="";
                                $detail_data['product_price'] =$order_data->Productprice;
                                $detail_data['total_product_price']=$order_data->Totalprice;
                                $detail_data['stock_id'] =0;
                                $detail_data['comments'] = "";
                                $detail_data['specs_label'] ="";
                                $detail_data['item_id'] = "";
                                $detail_data['quantity'] = $order_data->Productquantity; 
                                $detail_data['product_no'] = "";
                                $detail_data['order_id'] = $order_id;
                                $detail_data['parent_id'] = 0; //
                              
                            $order_detail_id = Modules::run('orders/_insert_table_order_detail', $detail_data,$outlet_id);
                        }
                    foreach ($order_data->Data as $key => $addon_data) {
                        
                              if($addon_data->Check=="Addon"){
                                $detail_data['product_id'] =$addon_data->Productid;
                                $detail_data['category_id'] =$order_data->Catid;
                                $detail_data['product_name'] =$addon_data->Name;
                                $detail_data['check']=$addon_data->Check;
                               
                                $detail_data['product_price'] =$addon_data->Price;
                                 $detail_data['total_product_price']="";
                                $detail_data['stock_id'] =$addon_data->Id;
                                $detail_data['comments'] = "";
                                 if(isset($addon_data->Label))
                                $detail_data['specs_label'] =$addon_data->Label;
                                else
                                    $detail_data['specs_label'] ="";
                               
                                $detail_data['item_id'] = "";
                                $detail_data['quantity'] = $addon_data->Quantity; //
                                $detail_data['product_no'] = "";
                                $detail_data['order_id'] = $order_id;
                                $detail_data['parent_id'] = $order_data->Productid; //
                                 $order_detail_id = Modules::run('orders/_insert_table_order_detail', $detail_data,$outlet_id);
                                }
                               
                        }
                    }
                
        }
    }
    function string_length($first,$limit,$default_text,$second) {
        if(!isset($default_text))
            $default_text="";
        if(!isset($first))
            $first="";
        if(!isset($second))
            $second="";
        $string=$default_text;
        if(!empty($first))
            $string=$first;
        if(!empty($second))
            $string=$first." ".$second;
        if(strlen($string) > $limit)
            $string= substr($string,0,$limit)."...";
        return $string;
    }
    
    function search_outlet(){
        $status = false;
        $message = "Record Not Found";
        $search_text = $this->input->post('search_text');
        $search_data = $this->get_search_outlet_data($search_text)->result_array();
        if(isset($search_data) && !empty($search_data)){
            $status = true;
            $message = "Record Found";
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=> $status, "message" => $message, "restaurants"=>$search_data));
    }
    function get_search_outlet_data($search_text){
        $this->load->model('mdl_perfectmodel');
        return $this->mdl_perfectmodel->get_search_outlet_data($search_text);
    }
   
   
   function get_general_setting($outlet_id){
   $this->load->model('mdl_perfectmodel');
    return $this->load->mdl_perfectmodel->get_general_setting($outlet_id);
    }
    
    function insert_user_order_taxes($data,$table,$outlet_id){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->insert_user_order_taxes($data,$table,$outlet_id);
    }
    function _insert_user_order_history($data,$outlet_id){
         $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->_insert_user_order_history($data,$outlet_id);
    }

    function insert_transaction_detail_db($data_in){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->insert_transaction_detail_db($data_in);
    }
    function get_transaction_detail_db($where){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_transaction_detail_db($where);
    }
    /////////////////// favourite api by Asad///////////
    function get_favourite_outlets(){
        $user_location_data = $this->get_current_location(json_decode($this->input->post('user_location_data')));
        $user_id=$user_location_data['user_id'];
        $status=false;
        $message="record not found";
        $outlets=array();
        $image_check=true;
        $page_number=$this->input->post('page_number');
        if(!is_numeric($page_number))
            $page_number = 1;
        $limit=$this->input->post('limit');
        if(!is_numeric($limit))
            $limit = 20;
        $total_pages=0;
        $res_array=$this->get_favourite_outlets_db($user_id,$page_number,$limit)->result_array();
        if(isset($res_array) && !empty($res_array)) {
            $total_pages=$this->get_favourite_outlets_db($user_id,$page_number,"0")->num_rows();
            $diviser=($total_pages/$limit);
            $reminder=($total_pages%$limit);
            if($reminder>0)
               $total_pages=intval($diviser)+1;
            else
                $total_pages=intval($diviser);
            $zone_count = 1;
            foreach ($res_array as $key => $out) {
                ///////////////////////////umar insights start/////////////////////////
                if($zone_count ==1) {
                    $general_setting = Modules::run('slider/_get_where_cols',array("outlet_id" =>$out['id']),'id desc','general_setting','timezones')->result_array();
                    if(!empty($general_setting))
                        date_default_timezone_set($general_setting[0]['timezones']);
                }
                $impression_id = $this->insert_into_specific_table(array("ua_user_id"=>$user_location_data['user_id'],"ua_outlet_id"=>$out['id'],"ua_type"=>"impression","ua_device"=>$user_location_data["device"],"ua_datetime"=>date("Y-m-d H:i:s"),"ua_country"=>$user_location_data["Country"],"ua_city"=>$user_location_data["City"],"ua_town"=>$user_location_data["Area"]),"outlet_activity");
                if(isset($user_location_data["requested_area"]) && !empty($user_location_data["requested_area"])) {
                    $this->requested_data_store('outlet_activity',$impression_id,$user_location_data);
                }
                if(isset($user_location_data["requested_city"]) && !empty($user_location_data["requested_city"])) {
                    $this->requested_city_store('outlet_activity',$impression_id,$user_location_data);
                }
                ///////////////////////////umar insights end/////////////////////////
                $out['image'] = $this->image_path_with_default(ACTUAL_OUTLET_TYPE_IMAGE_PATH,$out['image'],STATIC_FRONT_IMAGE,'pattren.png');
                if($image_check == true)
                    $out['logo'] = $this->image_path_with_default(ACTUAL_OUTLET_IMAGE_PATH,$out['logo'],STATIC_FRONT_IMAGE,'pattren.png');
                if(!empty($out['delivery_time']))
                    $out['deliverytime'] = $out['delivery_time']." Mins";
                else {
                    if(isset($out['delivery_time']))
                        unset($out['delivery_time']);
                }
                $total_discount=$out['discount']+$out['percentage'];
                if(!empty($total_discount))
                    $out['discount']=$total_discount;
                else {
                    if(isset($out['discount']))
                        unset($out['discount']);
                    if(isset($out['percentage']))
                        unset($out['percentage']);
                }
                
                 $follewers= Modules::run('slider/_get_where_cols',array("of_outlet_id" =>$out['id']),'of_id desc','outlet_favourite','count(outlet_favourite.of_id) as followers')->result_array();
                    if(isset($follewers) && !empty($follewers) && $follewers[0]['followers']>0)
                     $out['followers']=$follewers[0]['followers'];
                     $follewers="";
                     $out['followstatus']=true;
                    $time = $this->outlet_open_close($out['id']);
                $out['featured']='featured';
                if($time=="Closed")
                    $out['open_close']=$time;
                $cat = $this->get_restaurant_categories($out['id']);
                if(!empty($cat))
                    $out['catagories']=$cat;
                if(empty($out['rating']))
                    $out['rating'] = "0.0";
                else
                    $out['rating'] = round($out['rating'], 2);
               
                $temp_price[]=$out;
            }
            $outlets = $temp_price;
        }
        if(isset($outlets) && !empty($outlets)){
            $status=true;
            $message="";
            
        }
        header('Content-Type: application/json');
        echo json_encode(array("status"=>$status,"message"=>$message,"outlets_favourites"=>$outlets,"page_number"=>$page_number,"total_pages"=>$total_pages));
    }
    function get_favourite_outlets_db($user_id,$page_number,$limit){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_favourite_outlets_db($user_id,$page_number,$limit);
    }
    function insert_order_rating(){
       
        $status = false;
        $message = "Something went wrong";
        $order_id=$this->input->post('order_id');
        $outlet_id=$this->input->post('outlet_id');
        $user_id=$this->input->post('user_id');
        $rating=$this->input->post('rating');
        $data['user_id']=$user_id;
        $data['outlet_id']=$outlet_id;
        $data['order_id']=$order_id;
        $data['rating']=$rating;
        if(isset($data) && !empty($data) && !empty($order_id) && !empty($outlet_id) && !empty($user_id) && !empty($rating)){
         $status = true;
         $message = "Successfully inserted";
         $insert_or_update=$this->insert_or_update(array("order_id"=>$data['order_id'],"outlet_id"=>$data['outlet_id'],"user_id"=>$data['user_id']),$data,'reviews');
         
        }
      header('Content-Type: application/json');
            echo json_encode(array("status"=>$status,"message"=>$message));
            
    }
    
    function send_email($order_id,$outlet_id,$user_only='0'){
          
        if (isset($order_id) && $order_id > 0){

        $row_order = Modules::run('orders/_get_where_id', $order_id, $outlet_id)->row();
      
        $data['order'] =  $row_order;
      
        $db = & DB();

        $general_setting = $db->get_where('general_setting', array('outlet_id' => $outlet_id))->row();
        $data['order'] =  $row_order;
        $data['delivery_charges_vat']=$general_setting->delivery_charges_vat;
        $data['take_in_vat']=$general_setting->take_in_vat;
        $data['take_out_vat']=$general_setting->take_out_vat;
        $order_data['id'] = $order_id;
        $order_data['outlet_order_id'] = $row_order->outlet_order_id;
       
        $order_data['transaction_id'] = $row_order->transaction_id;
        $order_data['create_date'] = $row_order->create_date;
        $order_data['vat'] = $row_order->vat;
        $order_data['vat_amount'] = $row_order->vat_amount;
        $order_data['delivery_charges'] = $row_order->delivery_charges;
        $order_data['delivery_charges_vat'] =$row_order->delivery_charges_vat;
        $order_data['delivery_charges_vat_amount'] = $row_order->delivery_charges_vat_amount;
        $order_data['discount'] = $row_order->discount;
        $order_data['type'] = $row_order->type;
        $order_data['payment_method'] =$row_order->payment_method;
        $order_data['payment_status'] = $row_order->payment_status;
        $order_data['is_bill'] = $row_order->is_bill;
        $order_data['is_walking'] = $row_order->is_walking;
        $order_data['outlet_id'] = $row_order->outlet_id;
        $order_data['station_name'] = $row_order->station_name;
        $order_data['subtotal'] = $row_order->subtotal;
        $order_data['total_price'] = $row_order->total_price;
        $order_data['create_from'] = $row_order->create_from;
        $order_data['merchant_id'] = DEFAULT_MERCHANT;

        $is_customer_email = $row_order->is_customer_email;
        $is_owner_email = $row_order->is_owner_email;
        $data['Charges'] = $this->get_order_items(array("order_id"=>$order_id,"outlet_id"=>$outlet_id),"oc_id asc",$outlet_id."_order_charges","","charges_name,charges_type,charges_amount")->result_array();
        $data['Taxes'] = $this->get_order_items(array("order_id"=>$order_id,"outlet_id"=>$outlet_id),"ot_id asc",$outlet_id."_order_taxes","","tax_name,tax_type,tax_value as tax_amount")->result_array();
        $data['Discounts'] = $this->get_order_items(array("order_id"=>$order_id,"outlet_id"=>$outlet_id),"od_id asc",$outlet_id."_order_discount","","discount_name,discount_type,discount_value as discount_amount")->result_array();
        
        Modules::run('orders/_insert_all', $order_data);
            

        $data['arr_order_details'] = Modules::run('orders/get_order_details_email', $order_id, $outlet_id);
       
        $front_user_data = $this->session->userdata('front_user_data');

        if (!isset($data['order']->email) || empty($data['order']->email)) {
            $where['id'] = $front_user_data['id'];
            $row_customer = Modules::run('customers/_get_where_cols', $where, 'id asc', $outlet_id)->row();
            $customer_email = $row_customer->email;
        } else
        $customer_email = $data['order']->email;

        /////////////////////////////////////
        $this->load->library('email');

        //print'this outlet id =-==>>>'.$outlet_id;

        //print'<br> this DEFAULT_OUTLET id =-==>>>'.DEFAULT_OUTLET;

        // print'<br> this DEFAULT_OUTLET id =-==>>>'.$data_email['DEFAULT_OUTLET_EMAIL'];
        // exit;

        
            //$data_email = $this->get_constants($outlet_id);
             $user = "delivery@heyfood.pk";
             $pass = "{fltq9H]IhRd";
             $host = 'ssl://mail.heyfood.pk';
             $port=465;
             $default_email="delivery@heyfood.pk";
      



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
        //if (DEFAULT_SENDER_EMAIL != '') $user = DEFAULT_SENDER_EMAIL;

        ////////////////////////// EMAIL TO CUSTOMER /////////////////////
        
       if ($user_only != '1' && $is_customer_email != '1')
        {
             $this->email->from($user, 'Bestill Booking');
             $this->email->to($customer_email);
             $this->email->cc(array($default_email));
             $this->email->subject('Bestill Booking: '.$order_id);
             $message = $this->load->view('mail_format', $data, TRUE);
            
             $this->email->message($message);
             $returnval = $this->email->send();
           
             $sql = 'update '.$outlet_id.'_orders set is_customer_email =  1 where id = '.$order_id;
             $res_booking_update = Modules::run('orders/_custom_query', $sql);
       }
        ////////////////////////// EMAIL TO ADMIN /////////////////////
        //print'user only ===>>'.$user_only;


        if ($is_owner_email != '1')
        {
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->from($user, 'Bestill Booking');
            $this->email->to($default_email);
            $this->email->cc(array('bestilling@dinehome.no'));
            $this->email->subject('Bestill Booking');
            $message = $this->load->view('mail_format', $data, TRUE);
            $this->email->message($message);
            $this->email->send();
           
            $sql = 'update '.$outlet_id.'_orders set is_owner_email =  1 where id = '.$order_id;
            $res_booking_update = Modules::run('orders/_custom_query', $sql);     
        }
         if ($is_owner_email != '1')
        {
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->from($user, 'Bestill Booking');
            $this->email->to($default_email);
            $this->email->cc(array($default_email,$outlet_email));
            $this->email->subject('Bestill Booking');
            $message = $this->load->view('mail_format_outlet', $data, TRUE);
            $this->email->message($message);
            $this->email->send();
           
            $sql = 'update '.$outlet_id.'_orders set is_owner_email =  1 where id = '.$order_id;
            $res_booking_update = Modules::run('orders/_custom_query', $sql);     
        }
        //echo $this->email->print_debugger();
        //exit;
        }
} 
         
        
}