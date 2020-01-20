<?php
// print'this front here ====>>';exit;
/* * ***********************************************
  Created By: Tahir Mehmood
  Dated: 28-09-2016
 * *********************************************** */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Front extends MX_Controller {

    protected $data = '';

    function __construct() {
        //print'this front here ====>>';exit;
        if(DEFAULT_LANGUAGE === 'english'){
            $this->lang->load('english', 'english');
        } else{
            $this->lang->load('norwegian', 'norwegian');
        }
        parent::__construct();
    }

    ////////////////////////// FOR HOME PAGE  verfied in punjabitikka  /////////////////////
    

    function index(){ 
        //$data=$this->get_tables();
   
    $this->load->module('template');
    $data['has_header_ad'] = 1;
    if ($this->session->userdata('user_session'))
         $data['has_right_ad'] = 2;
     else
    $data['has_right_ad'] = 1;
    $data['has_header_ad'] = 1;
    $data['header_file'] = 'header';
    $data['page_title'] = 'Home';
    $data['view_file'] = 'home_page';
    $this->template->front($data);
    }
    ///////////////////payment integration by asad///////////////
     function get_payment_url(){
        $order_id=$this->input->post('order_id');
        $where_order['id']=$order_id;
        $outlet_id=$this->session->userdata('order_outlet_id');
        $oderdetail=$this->get_order_details($where_order,$outlet_id)->result_array();
        $orderamount=$oderdetail[0]['subtotal'];
        $orderamount=$orderamount;
        $orderamount=floor($orderamount);
        $orderamount=$orderamount.'00';
        $amount=(int)$orderamount;

        $url = "https://epayment.nets.eu/Netaxept/Register.aspx?merchantId=712356&token=8w?F_4P&orderNumber=".$order_id."&amount=".$amount."&CurrencyCode=NOK&redirectUrl=http://dinehome.no/payment-responce";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        // This is what solved the issue (Accepting gzip encoding)
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response);exit();
        //echo $response;
    }
    
       function get_payment_responce()  {
       $transactionId=$this->input->get('transactionId');
       $data_update['transaction_id']=$transactionId;
       $outlet_id=$this->session->userdata('order_outlet_id');
       $order_id=$this->session->userdata('payment_order');

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
       
        $response = trim(preg_replace('/\s\s+/', ' ', $response));
       
       ?>

       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script> var ljk = '<?php print_r($response) ?>'; var responce = $(ljk).find('ResponseCode').text();  
       if(responce == 'OK'){
       $.ajax({
      type: 'POST',
      data:{'data':'<?php echo $transactionId?>'},
      url: '<?php echo BASE_URL ?>front/get_final_payment_result',
      success: function(result) {



       var Issuer= $(result).find("CardInformation").find("Issuer").text();
       var IssuerCountry= $(result).find("CardInformation").find("IssuerCountry").text();
       var cardno= $(result).find("CardInformation").find("MaskedPAN").text();
       
      
        var order_id= $(result).find("OrderInformation").find("OrderNumber").text();
        
            
             $.ajax({
                type: "post",
                url: "<?=BASE_URL.'front/update_payment_status'?>",
                data: {'order_id':order_id,'cardno':cardno,'Issuer':Issuer,'IssuerCountry':IssuerCountry},
                success: function (data) {
                    window.location="<?=BASE_URL.'accepturl/'?>"+order_id;
                }
            });



      },
  }); }
       else 
        window.location="<?=BASE_URL.'accepturl/'?>";

       </script> 

       <?php 
      
      
       
      
    
     
    }

   
   
    function get_final_payment_result(){
        $id = $this->input->post('data');
       
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
        print_r($response);exit();
      
        
        ?>  <?php
       
       
    }
  function get_order_details($arr_col,$outlet_id){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_order_details($arr_col,$outlet_id);
    }
  
   function update_payment_status(){
       
        
        $data_update['cardno'] = $this->input->post('cardno');
        $data_update['is_print'] = 0;
        $order_id=$this->input->post('order_id');
        $data_update['create_date'] = date('Y-m-d H:i:s');
        $data_update['payment_status'] = PS_COMPLETE;
        $outlet_id=$this->session->userdata('order_outlet_id');
        if (isset($data_update['cardno']) && !empty($data_update['cardno']) )
            $chk = Modules::run('orders/_update_where_id', $order_id, $data_update, $outlet_id);
        

      
    } 
    function payment_error(){
        $message['class'] = 'error';
        $message['text'] = $this->lang->line('text_transaction_failed') . ' : ' . $this->lang->line('text_transaction_has_been_cancelled_by_your_card_issuer');
        $this->session->set_flashdata('message', $message);
    }
    
    
    
    
    
    
    
    
    
    ///////////payment integration by asad///////////
function get_tables(){
       $sess_trans_id = $this->session->userdata('sess_trans_id');
        if(empty($sess_trans_id) || $sess_trans_id == 0)
            $this->session->set_userdata('sess_trans_id', uniqid());      

        $arr_col['cat_id']=1;
        $arr_col['status']=1;
        $data['how_works'] = Modules::run('post/_get_with_limit',$arr_col,3, 'id asc');        

        $arr_col['cat_id']=2;   
        $res_testimonial = Modules::run('post/_get_where_orderby',$arr_col, 'id asc');

            if (isset($res_testimonial)) 
        foreach($res_testimonial as $row_testimonial){
            $arr_testimonial[] = $row_testimonial;
        }
        if (isset($res_testimonial)) 
        $data['arr_testimonial_chunks'] = array_chunk($arr_testimonial, 3);
    if (isset($res_testimonial)) 
        $data['count_testimonial_chunks'] = count($data['arr_testimonial_chunks']);

        $arr_col['cat_id']=3;   
        $data['whychoose'] =  Modules::run('post/_get_with_limit',$arr_col,4, 'id asc');
        if (isset($page)) 
         $arrBanner = Modules::run('banner_management/_get_banner', $type='Web', DEFAULT_OUTLET, 'Body', $page)->result_array();
        if (isset($arrBanner) && count($arrBanner) > 0)
            $data['body_banner'] = $arrBanner; //$arrBanner[0]['file_name'];
        else
            $data['body_banner'] = '';
        return $data;

}
    ////////////////////////// FOR MENU PAGE LEFT PANEL /////////////////////
    function get_left_panel() {
        $arr_add_on_products = array();
        $cat_id = $this->input->post("cat_id");
        $outlet_id = $this->input->post("outlet_id");
        $data['outlet_id']=$outlet_id ;
        $where_categories['is_active'] = 1;
        
        $where_categories['outlet_id'] = $outlet_id;
       
        $res_categories = Modules::run('catagories/_get_by_arr_id', $where_categories);

        foreach ($res_categories->result() as $row_category) {
            $arr_categories[] = $row_category;
        }
        $data['arr_categories'] = $arr_categories;

        $where_default_category['id'] = $cat_id;
        $where_default_category['outlet_id'] = $outlet_id;
        $data['row_default_category'] = Modules::run('catagories/_get_by_arr_id', $where_default_category)->row();

        $where_prod['products.status'] = 1;
        $where_prod['products.category_id'] = $data['row_default_category']->id;
        $where_prod['products.outlet_id'] = $outlet_id;

        $row_price_range = Modules::run('catagories/_get_price_range', $where_prod,$outlet_id)->row();
        $min_price = $row_price_range->min_price + (($row_price_range->min_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
        $max_price = $row_price_range->max_price + (($row_price_range->max_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
        $data['arr_min_price'] = arr_min_price($min_price, $max_price, '10');
        $data['arr_max_price'] = arr_max_price($min_price, $max_price, '10');

        $this->load->view('menu/left-panel', $data);
    }
   
    ////////////////////////// FOR MENY PAGE /////////////////////
    function menu() {
        $outlet_id = $this->uri->segment(2);
        $data['outlet_idd']=$outlet_id;
        $this->session->set_userdata('order_outlet_id',$outlet_id);
        $iddd=$this->check_outlet_existence($outlet_id)->result_array();
        if (isset($iddd) && empty($iddd)) {
            
            redirect(BASE_URL);
        }
            $this->cart->destroy();
            $this->session->unset_userdata('order_type');
            $this->session->unset_userdata('hdn_sub_total');
            $this->session->unset_userdata('hdn_final_total');
            $this->session->unset_userdata('delivery_note');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');
          
         $data['outlet_id']=$outlet_id;
        $where_search_outlet['id'] = $outlet_id;
       
        $data['res_search_outlets'] = Modules::run('outlet/_get_where_cols', $where_search_outlet)->result_array();
        $data['outlet_time']=$this->get_outlet_today_time($where_search_outlet['id']);
        $cat_id = $this->input->post('hdn_cat_id'); // When any item is clicked from home page.
   
            $outlet_id = $this->uri->segment(2);
       
        //print 'this ===>>'. $cat_id;exit;
        $where_categories['is_active'] = 1;
        
        $where_categories['outlet_id'] =  $outlet_id ;
        $res_categories = Modules::run('catagories/_get_by_arr_id', $where_categories);
        $cat_count = 1;
        foreach ($res_categories->result() as $row_category) {
            if (isset($cat_id) && !empty($cat_id)) {
                $where_default_category['id'] = $cat_id;
            } else if ($cat_count == 1) {
                 $cat_id = $row_category->id;
                $where_default_category['id'] = $row_category->id;
                $where_default_category['outlet_id'] = $outlet_id;
            }
            $product_cat=$where_default_category['id'];
            $data['row_default_category'] = Modules::run('catagories/_get_by_arr_id', $where_default_category)->row();
            $arr_categories[] = $row_category;
            $cat_count++;
        }
        if (isset($arr_categories)) 
        $data['arr_categories'] = $arr_categories;

        $where_prod['products.status'] = 1;
         $where_prod['products.category_id'] = $product_cat;
       
        $where_prod['products.outlet_id'] =  $outlet_id ;

       // $row_price_range = Modules::run('catagories/_get_price_range', $where_prod)->row();
       // $min_price = $row_price_range->min_price; //+ (($row_price_range->min_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
       // $max_price = $row_price_range->max_price;// + (($row_price_range->max_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
       // $data['arr_min_price'] = arr_min_price($min_price, $max_price, '10');
       // $data['arr_max_price'] = arr_max_price($min_price, $max_price, '10');

        $res_products = Modules::run('catagories/_get_menu_products', $where_prod,$product_name='', $outlet_id= $outlet_id );
        foreach ($res_products->result() as $row_product) {
            $where_add_on_products['add_on.id'] = $row_product->add_on_id;
            $where_add_on_products['add_on.outlet_id'] = $outlet_id;
            $res_add_on_products = Modules::run('add_on/_get_add_on_products_join_front', $where_add_on_products);
            $arr_add_on_products[$row_product->product_id] = $res_add_on_products->result();
        }

        $sess_order_type = $this->session->userdata('order_type');
        if (isset($sess_order_type) && !empty($sess_order_type)) {
            $data['sess_order_type'] = $sess_order_type;
        }
        $data['res_products'] = $res_products;
        if (isset($arr_add_on_products)) 
        $data['arr_add_on_products'] = $arr_add_on_products;
        //$data['header_file'] = 'mini_header';
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Menu';
        $data['view_file'] = 'menu/menu';
        $data['is_home'] = 0;
        $data['is_meny'] = 1;
        $data['cat_id'] =  $cat_id;
        

        

        $this->load->module('template');
        $this->template->front($data);
    }
    

     function search_outlets() {  
         $data=$this->get_tables();
            $this->cart->destroy();
            $this->session->unset_userdata('order_type');
            $this->session->unset_userdata('hdn_sub_total');
            $this->session->unset_userdata('hdn_final_total');
            $this->session->unset_userdata('delivery_note');
        $arr_search_outlet_pakages = '';
        $data['res_search_outlets'] = array();
        $search_outlet = $this->input->post('search_outlet');
       
        if(isset($search_outlet) && !empty($search_outlet)){
             $this->session->set_userdata('order_outlet_id',$search_outlet);
           $this->menu_search_outlets($search_outlet);
        }else{
             $temp_post_code = $this->input->post('post_code');
             
            if( isset($temp_post_code) && !empty($temp_post_code) ) {           
               $data['find_post_code']=(intval($temp_post_code)-10).' opp til '.(intval($temp_post_code)+10);
                $where_search_outlet['post_code >']=intval($temp_post_code)-10;
                $where_search_outlet['post_code <']=intval($temp_post_code)+10;
            }
            $where_search_outlet_pakages['pakke.status'] = 1;
            $where_search_outlet_pakages['car_type.status'] = 1;    
            $res_search_outlet_pakages = Modules::run('pakke/_get_outlet_pakke_by_car_type', $where_search_outlet_pakages, 'car_type.page_rank, pakke.rank asc '); // function update by wasim 23-02-16
            foreach($res_search_outlet_pakages->result() as $row_search_outlet_pakage){
                $arr_outlet_pakages[$row_search_outlet_pakage->outlet_id] = 1;

                $outlet_ranking[$row_search_outlet_pakage->outlet_id] = Modules::run('review/outlet_ranking', $row_search_outlet_pakage->outlet_id);
                    
            }
            $data['outlet_ranking'] = $outlet_ranking;

            $data['arr_outlet_pakages']=$arr_outlet_pakages;
            $where_search_outlet['status'] = 1;
            $where_search_outlet['is_default'] = 0;
            $res_search_outlets = Modules::run('outlet/_get_where_cols', $where_search_outlet);
            foreach($res_search_outlets->result() as $row_search_outlet){

                $arr_search_outlets[] = $row_search_outlet;
            }

            if (isset($arr_search_outlets))
            $data['arr_search_outlets'] = array_chunk($arr_search_outlets, 8);
            $data['count_search_outlet_chunks'] = count($data['arr_search_outlets']);
            $vheader=$this->input->post('vheader');
            if(isset($vheader) && $vheader==1){
                 $data['addID'] = 'id="search_outlets"';
                $this->load->view('search_outlets', $data);
            }else {
                $data['header_file'] = 'reduced_header';
                $data['page_title'] = 'Outlets';
                $data['addID'] = 'id="search_outlets"';
                $data['view_file'] = 'search_outlets';
                $this->load->module('template');
                $this->template->front($data);
          }
    
        }
    }
    function menu_search_outlets($menu_search_outlets) {
         $data['outlet_idd']=$menu_search_outlets;
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');
         $data['outlet_id']=$menu_search_outlets;
        $where_search_outlet['id'] = $menu_search_outlets;
             
        $data['res_search_outlets'] = Modules::run('outlet/_get_where_cols', $where_search_outlet)->result_array();
         $data['outlet_time']=$this->get_outlet_today_time($where_search_outlet['id']);
        $cat_id = $this->input->post('hdn_cat_id'); // When any item is clicked from home page.
   
            $outlet_id = $menu_search_outlets;
       
        //print 'this ===>>'. $cat_id;exit;
        $where_categories['is_active'] = 1;
        
        $where_categories['outlet_id'] =  $outlet_id ;
        $res_categories = Modules::run('catagories/_get_by_arr_id', $where_categories);
        $cat_count = 1;
        foreach ($res_categories->result() as $row_category) {
            if (isset($cat_id) && !empty($cat_id)) {
                $where_default_category['id'] = $cat_id;
            } else if ($cat_count == 1) {
                 $cat_id = $row_category->id;
                $where_default_category['id'] = $row_category->id;
                $where_default_category['outlet_id'] = $outlet_id;
            }
            $product_cat=$where_default_category['id'];
            $data['row_default_category'] = Modules::run('catagories/_get_by_arr_id', $where_default_category)->row();
            $arr_categories[] = $row_category;
            $cat_count++;
        }
        if (isset($arr_categories)) 
        $data['arr_categories'] = $arr_categories;

        $where_prod['products.status'] = 1;
       $where_prod['products.category_id'] =$product_cat;
        $where_prod['products.outlet_id'] =  $outlet_id ;

       // $row_price_range = Modules::run('catagories/_get_price_range', $where_prod)->row();
       // $min_price = $row_price_range->min_price; //+ (($row_price_range->min_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
       // $max_price = $row_price_range->max_price;// + (($row_price_range->max_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
       // $data['arr_min_price'] = arr_min_price($min_price, $max_price, '10');
       // $data['arr_max_price'] = arr_max_price($min_price, $max_price, '10');

        $res_products = Modules::run('catagories/_get_menu_products', $where_prod,$product_name='', $outlet_id= $outlet_id );
        foreach ($res_products->result() as $row_product) {
            $where_add_on_products['add_on.id'] = $row_product->add_on_id;
            $where_add_on_products['add_on.outlet_id'] =$outlet_id;
            $res_add_on_products = Modules::run('add_on/_get_add_on_products_join_front', $where_add_on_products);
            $arr_add_on_products[$row_product->product_id] = $res_add_on_products->result();
        }

        $sess_order_type = $this->session->userdata('order_type');
        if (isset($sess_order_type) && !empty($sess_order_type)) {
            $data['sess_order_type'] = $sess_order_type;
        }
        $data['res_products'] = $res_products;
        if (isset($arr_add_on_products)) 
        $data['arr_add_on_products'] = $arr_add_on_products;
        //$data['header_file'] = 'mini_header';
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Menu';
        $data['view_file'] = 'menu/menu';
        $data['is_home'] = 0;
        $data['is_meny'] = 1;
        $data['cat_id'] =  $cat_id;
        

        

        $this->load->module('template');
        $this->template->front($data);
    }
    ////////////////////////// FOR MENU ==> SEARCH PRODUCT PORTION /////////////////////
 
    function send_notification($tokens, $msg)
    {
        //print 'token here ::<pre>';print_r($tokens);
        //exit;
        $message = array("message" => $msg);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
             'registration_ids' => $tokens,
             'data' => $message
            );

        $headers = array(
            'Authorization:key = AIzaSyAde_ljxamw87t1Bt_vXJCy8hK1sDepQ14',
            'Content-Type: application/json'
            );

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       /*print '<br>resul here ===>>><pre>';
       print_r($result);
       exit;
       return $result;*/
    }
 function success_booking() {
        $booking_id = $this->uri->segment(2);
        $is_print = $this->uri->segment(3);
        $where_outlet['id'] = $this->session->userdata('front_user_selected_outlet_id');
        $res_user_selected_outlet = Modules::run('outlet/_get_by_arr_id', $where_outlet)->row();

        $where_booking['id'] = $booking_id;
        //$this->accepturl($booking_id);  // for testing 
        
        $res_booking = Modules::run('booking/_get_by_arr_id', $where_booking)->row();
        $where_booking_details['booking_id'] = $booking_id;
        $res_booking_details = Modules::run('booking/_get_by_arr_id_booking_detail', $where_booking_details);

        $data['booking_id'] = $booking_id;
        $data['res_outlet'] = $res_user_selected_outlet;
        $data['res_booking'] = $res_booking;
        $data['res_booking_details'] = $res_booking_details;
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'success-booking';
        $this->load->module('template');
        
        if(isset($is_print) && !empty($is_print)){
            $data['is_print'] = 'Yes';
            $data['page_title'] = 'Print';
            $this->template->front_print($data);
        }else{
            $data['page_title'] = 'Booking Success';
            $this->template->front($data);
        }
    }
  
    function about_us(){
        $where['url_slug']='about-us';
        $data['about_us'] = Modules::run('webpages/_get_page_content_by_url_slug', 'about-us');
        $data['terms_conditions'] = Modules::run('webpages/_get_page_content_by_url_slug', 'terms-conditions');
      
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages'); 
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'about-us';
        $data['page_title'] = 'Om Oss';
        $this->load->module('template');
        $this->template->front($data);
    }
    function Why_us(){
        $where['url_slug']='hvorfor-oss';
         $data['why_us'] = Modules::run('webpages/_get_page_content_by_url_slug', 'why-us');
         $data['terms_conditions'] = Modules::run('webpages/_get_page_content_by_url_slug', 'terms-conditions');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages'); 
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'why-us';
        $data['page_title'] = 'hvorfor-oss';
        $this->load->module('template');
        $this->template->front($data);
    }
     function contact_us(){
        $where['url_slug']='hvorfor-oss';
         $data['why_us'] = Modules::run('webpages/_get_page_content_by_url_slug', 'why-us');
         $data['terms_conditions'] = Modules::run('webpages/_get_page_content_by_url_slug', 'terms-conditions');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages'); 
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'contactus';
        $data['page_title'] = 'Kontakt Oss';
        $this->load->module('template');
        $this->template->front($data);
    }
     function join_us(){
        $where['url_slug']='hvorfor-oss';
         $data['why_us'] = Modules::run('webpages/_get_page_content_by_url_slug', 'bli-med-oss');
         $data['terms_conditions'] = Modules::run('webpages/_get_page_content_by_url_slug', 'terms-conditions');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages'); 
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'join-us';
        $data['page_title'] = 'bli med oss';
        $this->load->module('template');
        $this->template->front($data);
    }
    function terms_conditions(){
        
      
       $data['terms_conditions'] = Modules::run('webpages/_get_page_content_by_url_slug', 'terms-conditions');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages'); 
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'terms-conditions';
        $data['page_title'] = 'terms-conditions';
        $this->load->module('template');
        $this->template->front($data);
    }
    function privacy(){
       
        $data['privay'] = Modules::run('webpages/_get_page_content_by_url_slug', 'personvern');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages'); 
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'privacy';
        $data['view_file'] = 'privacy';
        $this->load->module('template');
        $this->template->front($data);
    }
    
    function get_web_pages_discription( $where){
        $this->load->model('mdl_perfectmodel');
      return  $this->load->mdl_perfectmodel->get_web_pages_discription($where)->result_array();
    }
        function join_us_action() {
        $this->load->module('template');
       $this->load->library('form_validation');
        $this->form_validation->set_rules('company_name', 'Navn', 'required|xss_clean');
        $this->form_validation->set_rules('restuarent_name', 'Navn', 'required|xss_clean');
        $this->form_validation->set_rules('owner_email', 'E-post', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect(BASE_URL . 'bli-med-oss');
        } else {

            $data['company_name'] = $this->input->post('company_name');
            $data['company_org_number'] = $this->input->post('company_or_number');
            $data['restuarent_name'] = $this->input->post('restuarent_name');
            $data['owner'] = $this->input->post('owner');
             $data['owner_mobile'] = $this->input->post('owner_mobile');
            $data['owner_email'] = $this->input->post('owner_email');
           
            $data['telephone'] = $this->input->post('telephone');
            $data['address'] = $this->input->post('address');
           

            Modules::run('restaurant_requests/_insert', $data);

             $this->load->library('email');
            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
            $host = 'ssl://send.one.com'; 

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
            //if (DEFAULT_SENDER_EMAIL != '') $user = '';
            $this->email->set_newline("\r\n");
            //$this->email->from($user, DEFAULT_OUTLET_NAME);
            $this->email->from( $data['owner_email'],  $data['restuarent_name']); // change it to yours
            $this->email->to($user,'dinehome.no');
            //print'this email ===>>>'.DEFAULT_OUTLET_EMAIL;
            //print'this message -===>>>'.$strMelding;

            $this->email->subject($data['owner'].' '.$data['owner_email']);
            $this->email->message($data['address']);
            $return_res = $this->email->send();
           // echo $this->email->print_debugger();
           // exit;
            if ($return_res == 1) {
                $message['class'] = 'success';
                $message['text'] = $this->lang->line('text_email_sent') . '........';
                $this->session->set_flashdata('message', $message);
            }
        }
                redirect(BASE_URL. 'bli-med-oss');

    }
    function get_outlet_today_time($where_search_outlet){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_outlet_today_time($where_search_outlet);
    }
    //////////////////asad../////////
    function search_products() {
        $arr_add_on_products = array();
        $product_name = $this->input->post("product_name");
        $min_price = $this->input->post("min_price");
        $max_price = $this->input->post("max_price");
        $cat_id = $this->input->post("cat_id");
        $outlet_id = $this->input->post("selected_cat");

        $where_default_category['id'] = $cat_id;
        $where_default_category['outlet_id']=$outlet_id;
        $data['row_default_category'] = Modules::run('catagories/_get_by_arr_id', $where_default_category)->row();
       
        if ($min_price != 'Min' && $min_price != '') {
            $min_price = $min_price - (($min_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
            $where_prod['stock.price >='] = $min_price;
            if ($max_price != 'Max' && $max_price != '') {
                $max_price = $max_price - (($max_price * ITEM_PRICE_VAT_INCLUDED_PERCENTAGE) / 100);
                $where_prod['stock.price <='] = $max_price;
            }
        }

        $where_prod['products.status'] = 1;
        $where_prod['products.category_id'] = $cat_id;
        $where_prod['products.outlet_id'] = $outlet_id;
        $res_products = Modules::run('catagories/_get_menu_products', $where_prod, $product_name,$outlet_id);

        foreach ($res_products->result() as $row_product) {
            $where_add_on_products['add_on.id'] = $row_product->add_on_id;
            $where_add_on_products['add_on.outlet_id'] = $outlet_id;
            $res_add_on_products = Modules::run('add_on/_get_add_on_products_join_front', $where_add_on_products);
            $arr_add_on_products[$row_product->product_id] = $res_add_on_products->result();
        }

        $data['res_products'] = $res_products;
        $data['arr_add_on_products'] = $arr_add_on_products;
        $data['product_name'] = $product_name;
        $data['min_price'] = $min_price;
        $data['max_price'] = $max_price;
        $this->load->view('menu/products', $data);
    }

    /////////////////////// ADD PRODUCT TO CART /////////////////////
   function add_to_cart() {
        $product_id = $this->input->post('product_id');
        $outlet_idd = $this->input->post('outlet_id');
        $stock_id = $this->input->post('stock_id');
        $comments = $this->input->post('comments');
        $parent_id = $this->input->post('parent_id');
        $arr_add_on_product_ids = $this->input->post('arr_add_on_ids');

        $data = array();
        $where_product['id'] = $product_id;
        $row_product = Modules::run('product/_get_by_arr_id', $where_product,$outlet_idd)->row();

        $where_stock['id'] = $stock_id;
        $row_stock = Modules::run('product/_get_by_arr_id_stock', $where_stock,$outlet_idd)->row();

        $data['id'] = $stock_id;
        $data['stock_id'] = $stock_id;
        $data['comments'] = $comments;
        $data['parent_id'] = $parent_id;

        $data['product_id'] = $product_id;
        $data['qty'] = 1;
        $data['price'] = $row_stock->price;
        $data['actual_price_without_vat'] = ceil(($data['price'] * 100)/(100 + TAKE_OUT_VAT));
        $data['name'] = $row_product->title;
        $data['label'] = $row_stock->label;
        $data['for_persons'] = $row_stock->for_persons;
        $data['product_no'] = $row_product->product_no;
         $chk_deal = 0;
        if ( $row_product->is_deal == '1' )
            $chk_deal = 1;


        $temp_add_on_product_ids = '';
        if(isset($arr_add_on_product_ids) && !empty($arr_add_on_product_ids)){
            $add_price = 0;
            foreach($arr_add_on_product_ids as $add_on_product_id){
                list($add_on_product_id, $add_on_stock_id) = explode("-", $add_on_product_id);
                $temp_add_on_product_ids .= $add_on_stock_id;
                $where_add_on_product_stock['products.id'] = $add_on_product_id;
                $where_add_on_product_stock['stock.id'] = $add_on_stock_id;
                
                $row_add_on_product = Modules::run('product/_get_add_on_products_join_stock', $where_add_on_product_stock)->row();
               //  print'this var dump 1===>>'.$chk_deal;var_dump( $row_add_on_product);
                if ( $chk_deal == '1')
                    $row_add_on_product->price = 0;
                //print'this var dump 2===>>'; var_dump( $row_add_on_product);
                $data['add_ons'][] = $row_add_on_product;

                $add_price = $add_price + $row_add_on_product->price;
            }
            $data['add_price'] =$add_price;

        }
        $data['temp_add_on_product_ids'] = $temp_add_on_product_ids;

        $rowid = md5($temp_add_on_product_ids.$stock_id); 
        $cart = $this->cart->contents();
        if (isset($cart[$rowid]))
        {
            $data['qty'] = $cart[$rowid]['qty'] + 1; 
        }
        //print '<br> this rowid ===>'.$cart[$rowid]['qty'];
        //print'<br>this ====>>data ---->';print_r($cart);
        $rowid = $this->cart->insert($data);
        echo $rowid;
    }

    /////////////////////// REMOVE PRODUCT FROM CART /////////////////////
    function remove_item_from_cart() {
        $product_id = $this->input->post('product_id');
        $rowid = $this->input->post('rowid');
        $data = array('rowid' => $rowid, 'qty' => 0);
        $this->cart->update($data);
    }

    /////////////////////// CLEAR CART / DESTROY CART /////////////////////
    function clear_cart() {
        $this->cart->destroy();
    }

    /////////////////////// UPDATE PRODUCT IN CART /////////////////////
    function update_cart() {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $data = array('rowid' => $rowid, 'qty' => $qty);
        $this->cart->update($data);
        $qty = $this->cart->total_items();
        if ($qty < 1) $this->cart->destroy();
    }

    /////////////////////// CART DROPDOWN /////////////////////
    function refresh_cart_dropdown() {
        $sess_order_type = $this->session->userdata('order_type');
        if (isset($sess_order_type) && !empty($sess_order_type)) {
            $data['sess_order_type'] = $sess_order_type;
        }

         $chk_free_delivery = 0;

        if ((IS_FREE_DELIVERY == 1) && (isset($sess_order_type) && !empty($sess_order_type) && $sess_order_type == DELIVERY))
        {
             $cart_total = $this->cart->total();
             $temp_free = FREE_DELIVERY_LIMIT - $cart_total;
             if ( $temp_free < 1){
                 $data['delivery_cost'] = 0;
                 $this->session->set_userdata('delivery_cost', 0);
             }
             else
             {
                $delivery_cost = $this->session->userdata('delivery_cost_old');
                $data['delivery_cost'] = $delivery_cost;
                $this->session->set_userdata('delivery_cost', $delivery_cost);
             }
            // print'cost ===>>'.$delivery_cost ;
            
        }

        $data['cart_products'] = $this->cart->contents();
        $data['discount'] = $this->cart->discount();
        $data['coupon_code'] = $this->cart->coupon_code();
        $this->load->view('cart-dropdown-html', $data);
    }

    /////////////////////// MENU PAGE CART PORTION /////////////////////
  function refresh_menu_page_cart(){
        $sess_order_type = $this->session->userdata('order_type');
        
        //echo '=================>'.$this->session->userdata('delivery_cost');
        $data['delivery_cost']=$this->session->userdata('delivery_cost');
        if(isset($sess_order_type) && !empty($sess_order_type)){
            $data['sess_order_type'] = $sess_order_type;
        }
         $chk_free_delivery = 0;
        if ((IS_FREE_DELIVERY == 1) && (isset($sess_order_type) && !empty($sess_order_type) && $sess_order_type == DELIVERY))
        {
             $cart_total = $this->cart->total();
             $temp_free = FREE_DELIVERY_LIMIT - $cart_total;
             if ( $temp_free < 1){
                 $data['delivery_cost'] = 0;
                 $this->session->set_userdata('delivery_cost', 0);
             }
             else
             {
                $delivery_cost = $this->session->userdata('delivery_cost_old');
                $data['delivery_cost'] = $delivery_cost;
                $this->session->set_userdata('delivery_cost', $delivery_cost);
             }
        }
        if (DEFAULT_CHILD == '1')
             $data['arr_outlet'] = Modules::run('outlet/get_sub_outlets_array', DEFAULT_OUTLET);

        $data['discount'] = $this->cart->discount();
        $data['coupon_code'] = $this->cart->coupon_code();
        $data['cart_products'] = $this->cart->contents();
        $this->load->view('menu/cart', $data);
    }

    function refresh_menu_page_cart_mobile(){
        $sess_order_type = $this->session->userdata('order_type');
        
        //echo '=================>'.$this->session->userdata('delivery_cost');
        $data['delivery_cost']=$this->session->userdata('delivery_cost');
        if(isset($sess_order_type) && !empty($sess_order_type)){
            $data['sess_order_type'] = $sess_order_type;
        }
        $data['discount'] = $this->cart->discount();
        $data['coupon_code'] = $this->cart->coupon_code();
        $data['cart_products'] = $this->cart->contents();
        if (DEFAULT_CHILD == '1')
             $data['arr_outlet'] = Modules::run('outlet/get_sub_outlets_array', DEFAULT_OUTLET);
        $this->load->view('menu/app_cart', $data);
    }
    

    /////////////////////// VIEW CART PAGE AFTER LOGIN /////////////////////
   function update_view_cart() {
        $order_type = $this->input->post('order_type');
        $post_code = $this->input->post('post_code');
        
        $this->session->set_userdata('order_type', $order_type);
        $sess_order_type = $this->session->userdata('order_type');
        $data['sess_order_type'] = $order_type;
     $delivery_cost;
        $data['delivery_note'] = '';
        if(isset($delivery_note) && !empty($delivery_note)){
            $data['delivery_note'] = $delivery_note; 
        }

        
        if(isset($order_type) && !empty($order_type) && $order_type == DELIVERY){

           
           // print'this ===>>>'.$post_code;exit;
            if (DELIVERY_FIXED == 1 && $chk_free_delivery == 0 )
            {
                $data['delivery_cost'] = DELIVERY_CHARGES;
                $delivery_cost = DELIVERY_CHARGES;
                $this->session->set_userdata('delivery_cost', DELIVERY_CHARGES);
                $this->session->set_userdata('delivery_cost_old', DELIVERY_CHARGES);
            }
            else if ( $chk_free_delivery == 0)
            {
                $arrcols['post_code']=$post_code;
                 $res_postcode =  Modules::run('outlet/_get_where_cols_post_code_delivery',$arrcols,'id asc');
                 $row_string='';
                if($res_postcode->num_rows > 0){
                    $row_delivery=$res_postcode->row();
                    $this->session->set_userdata('delivery_cost', $row_delivery->delivery_charges);
                    $this->session->set_userdata('delivery_postcode', $post_code);
                    $data['delivery_cost']=$row_delivery->delivery_charges;
                     $this->session->set_userdata('delivery_cost_old', $row_delivery->delivery_charges);
                   //exit;
                   $delivery_cost = $row_delivery->delivery_charges;
                 } 
           }
             $chk_free_delivery = 0;
            if (IS_FREE_DELIVERY == 1)
            {
                 $cart_total = $this->cart->total();
                 $temp_free = FREE_DELIVERY_LIMIT - $cart_total;
                 if ($temp_free < 1){
                     $data['delivery_cost'] = 0;
                     $delivery_cost = 0;
                     $this->session->set_userdata('delivery_cost', 0);
                     $chk_free_delivery = 1;
                 }
            }
                   
        }
        if (DEFAULT_CHILD == '1')
          $data['arr_outlet'] = Modules::run('outlet/get_sub_outlets_array', DEFAULT_OUTLET);
        if (isset($delivery_cost))
        $this->cart->updatedeliverey($delivery_cost);
        $data['discount'] = $this->cart->discount();
        $data['coupon_code'] = $this->cart->coupon_code();

        $data['cart_products'] = $this->cart->contents();

       // echo '<pre>';
        //print_r($data['cart_products']);
        $this->load->view('menu/cart', $data);
    }


    function update_view_cart_mobile() {
        $order_type = $this->input->post('order_type');
        $post_code = $this->input->post('post_code');
        
        $this->session->set_userdata('order_type', $order_type);
        $sess_order_type = $this->session->userdata('order_type');
        $data['sess_order_type'] = $order_type;
        $delivery_cost;
        $data['delivery_note'] = '';
        if(isset($delivery_note) && !empty($delivery_note)){
            $data['delivery_note'] = $delivery_note;
        }
        
        if(isset($order_type) && !empty($order_type) && $order_type == DELIVERY){


            if (DELIVERY_FIXED == 1 )
            {
                $data['delivery_cost'] = DELIVERY_CHARGES;
                $delivery_cost = DELIVERY_CHARGES;
                $this->session->set_userdata('delivery_cost', DELIVERY_CHARGES);
            }
            else
            {
                $arrcols['post_code']=$post_code;
                 $res_postcode =  Modules::run('outlet/_get_where_cols_post_code_delivery',$arrcols,'id asc');
                 $row_string='';
                if($res_postcode->num_rows > 0){
                    $row_delivery=$res_postcode->row();
                    $this->session->set_userdata('delivery_cost', $row_delivery->delivery_charges);
                    $this->session->set_userdata('delivery_postcode', $post_code);
                   $data['delivery_cost']=$row_delivery->delivery_charges;
                   $delivery_cost = $row_delivery->delivery_charges;
                 } 
           }
        }
        if (DEFAULT_CHILD == '1')
          $data['arr_outlet'] = Modules::run('outlet/get_sub_outlets_array', DEFAULT_OUTLET);
            if (isset($delivery_cost))
        $this->cart->updatedeliverey($delivery_cost);  
        $data['discount'] = $this->cart->discount();
        $data['coupon_code'] = $this->cart->coupon_code();

        $data['cart_products'] = $this->cart->contents();

        $this->load->view('menu/app_cart', $data);
    }

    /////////////////////// SET SESSION ORDER TYPE ON CLICK OF RADIO BUTTON ON CART POTION /////////////////////
    function set_session_order_type() {
        $order_type = $this->input->post('rdb_type');
        $this->session->set_userdata('order_type', $order_type);
    }

    /////////////////////// WHEN USER PRESSES CHECKOUT BUTTON FOR THE FIRST TIME /////////////////////
    function checkout() {
/*        print'this ===>>';
        print'<pre>';
        print_r($_POST);*/
        $this->session->set_userdata('url_from', 'checkout');
        if ($this->input->post()) {
           $order_type = $this->input->post('rdb_type'); //DELIVERY; // $this->input->post('rdb_type');
            $hdn_sub_total = $this->input->post('hdn_sub_total');
            $hdn_final_total = $this->input->post('hdn_final_total');
            $delivery_note = $this->input->post('delivery_note');
           $branch_id = $this->input->post('branch_id');

            if ($branch_id < 1)
               $branch_id = $this->input->post('branch_id_app');

            if ($branch_id > 0)
                $this->session->set_userdata('selected_branch', $branch_id);
            $this->session->set_userdata('order_type', $order_type);
            $this->session->set_userdata('hdn_sub_total', $hdn_sub_total);
            $this->session->set_userdata('hdn_final_total', $hdn_final_total);
            $this->session->set_userdata('delivery_note', $delivery_note);
        }
        $front_user_data = $this->session->userdata('front_user_data');
        if (isset($front_user_data) && !empty($front_user_data))
            $this->view_profile();
        else
            $this->front_login();
    }

    ////////////////////////// FOR LOGIN / REGISTER PAGE /////////////////////
    function front_login() {
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $cccc = Modules::run('site_security/get_captcha');
        $captcha = explode("::", $cccc);
        $this->session->set_userdata('captchaWord', $captcha['1']);
        $data['captchaimage'] = $captcha['0'];
        $url_slug = 'betingelser-og-vilkr';
        $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
        $arrPage = $arrPage->row();
        $data['terms_conditon'] = $arrPage->page_content;
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Login / Register';
        $data['view_file'] = 'front_login_register';
        

        $this->load->module('template');
        $this->template->front($data);
    }

    ////////////////////////// FOR FRONT LOGIN ACTION PAGE /////////////////////
    function front_login_action() {
        $email = $this->input->post('txtEmail', TRUE);
        $password = $this->input->post('txtPassword', TRUE);
    
        $where_check['email'] = $email;
        $where_check['password'] = Modules::run('site_security/make_hash', $password);
        
        $outlet_id=$this->session->userdata('order_outlet_id');

        $where_check['outlet_id'] = $outlet_id;
       
        $query = Modules::run('customers/_get_by_arr_id', $where_check,$outlet_id);
   
        if ($query->num_rows() > 0) {
            $data = array();
            foreach ($query->result() as $row) {
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['user_name'] = $row->user_name;
                $data['email'] = $row->email;
            }
            $this->session->set_userdata('front_user_data', $data);
            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_login_successful');
            $this->session->set_flashdata('message', $message);

            if ($this->session->userdata('url_from')) {
                redirect(BASE_URL . 'checkout');
            } else {
                redirect(BASE_URL);
            }
        } else {
            $message['class'] = 'error';
            $message['text'] = $this->lang->line('text_user_not_found');
            $this->session->set_flashdata('message', $message);
            redirect(BASE_URL . 'login');
        }
    }

     function front_login_facebook() {
        $email = $this->input->post('txtEmail', TRUE);
        $first_name = $this->input->post('first_name', TRUE);
        $last_name = $this->input->post('last_name', TRUE);
        $name=$first_name.' '.$last_name;
        $where_check['email'] = $email;
        $outlet_id=$this->session->userdata('order_outlet_id');
        $where_check['outlet_id'] = $outlet_id;
        $query = Modules::run('customers/_get_by_arr_id', $where_check,$outlet_id);
        if (isset($email) && empty($email)) {
          echo "error";exit();
        }
        if ($query->num_rows() > 0) {
           
            $data = array();
            foreach ($query->result() as $row) {
                $data['id'] = $row->id;
                $data['name'] = $row->name;
                $data['user_name'] = $row->user_name;
                $data['email'] = $row->email;
            }
            $this->session->set_userdata('front_user_data', $data);
            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_login_successful');
            $this->session->set_flashdata('message', $message);

            if ($this->session->userdata('url_from')) {
                echo BASE_URL . 'checkout';exit;
            } else {
                echo BASE_URL;exit;
            }
             //print'  found ===>>';exit;

        } else {
            
            $this->front_register_facebook($name, $email);
        }
    }

    ////////////////////////// FOR FRONT REGISTER ACTION PAGE /////////////////////
    function front_register_action() {
        $data['name'] = $this->input->post('register_name', TRUE);
        $data['email'] = $this->input->post('register_email', TRUE);
        $password = $this->input->post('register_password', TRUE);
        $txtCaptcha = $this->input->post('txtCaptcha', TRUE);
        $wordcapcha = $this->session->userdata('captchaWord');
        $data['password'] = Modules::run('site_security/make_hash', $password);
        $outlet_id=$this->session->userdata('order_outlet_id');
        $data['outlet_id'] = $outlet_id;
        $where_check_username['email'] = $data['email'];
        $where_check_username['outlet_id'] = $outlet_id;
        $check_register_username = Modules::run('customers/_get_where_cols', $where_check_username);
        /*if (strcmp($txtCaptcha, $wordcapcha) !== 0) {
            $message['class'] = 'error';
            $message['text'] = $this->lang->line('text_registration_failed') . ' : ' . $this->lang->line('text_wrong_captcha_code');
            $this->session->set_flashdata('message', $message);
        } else*/ if ($check_register_username->num_rows() > 0) {
            $message['class'] = 'error';
              $message['text'] = $this->lang->line('text_registration_failed') . ' : ' . $this->lang->line('text_customer_with_same_email_exists');
            $this->session->set_flashdata('message', $message);
        } else {
            
            $query = Modules::run('customers/_insert', $data,$outlet_id);
            $this->session->unset_userdata('captchaWord');
            $this->load->library('email');
            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
           $host = 'ssl://send.one.com'; 

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
            $this->email->from($user, 'dinehome.no');
            //$this->email->from(DEFAULT_OUTLET_EMAIL, DEFAULT_OUTLET_NAME);
            $this->email->to($data['email']);
            $this->email->subject('dinehome.no' . ' - Registration');
            $this->email->message('<p>Dear ' . $data['name'] . ',<br><br>Thank you for registration at  dinehome </br>With Best Regards,<br> dinehome.no Team');
            $this->email->send();
            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_registration_successful') . ' : ' . $this->lang->line('text_login_to_proceed');
            $this->session->set_flashdata('message', $message);
        }
        redirect(BASE_URL . 'login');
    }
    function front_register_facebook($name, $email) {
        $data['name'] = $name;
        $data['email'] = $email;
        
        $outlet_id=$this->session->userdata('order_outlet_id');

        $random_password = $this->random_password();
        $data['password'] = Modules::run('site_security/make_hash', $random_password);
        $data['outlet_id'] =  $outlet_id;
        $customer_id = Modules::run('customers/_insert', $data, $outlet_id);
        $this->session->unset_userdata('captchaWord');
        $this->load->library('email');
        $port = 465;
        $user = 'sale@dinehome.no';
        $pass = 'spinners';
        $host = 'ssl://send.one.com';

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
            $this->email->from($user, 'dinehome.no');
            //$this->email->from(DEFAULT_OUTLET_EMAIL, DEFAULT_OUTLET_NAME);
            $this->email->to($data['email']);
            $this->email->subject('Dinehome.no' . ' - Registration');
            $this->email->message('<p>Dear ' . $data['name'] . ',<br><br>Thank you for registration at  dinehome.no<br></br>Passord: '. $random_password . ' <br> </br></br>With Best Regards,<br>dinehome.no-Team');
            $this->email->send();
            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_registration_successful') . ' : ' . $this->lang->line('text_login_to_proceed');
            $this->session->set_flashdata('message', $message);

            $data = array();
            $data['id'] = $customer_id;
            $data['name'] = $name;
            $data['user_name'] = $name;
            $data['email'] = $email;
            $this->session->set_userdata('front_user_data', $data);
            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_login_successful');
            $this->session->set_flashdata('message', $message);
            if ($this->session->userdata('url_from')) {
                echo BASE_URL. 'checkout';exit;
            } else {
                echo BASE_URL;exit;
            }

             
    }

    ////////////////////////// FOR CHANGE PASSWORD PAGE /////////////////////
    function change_password() {
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Change Password';
        $data['view_file'] = 'front_change_password';
       

        $this->load->module('template');
        $this->template->front($data);
    }

    ////////////////////////// FOR CHANGE PASSWORD ACTION PAGE /////////////////////
    function front_change_password_action() {
        $front_user_data = $this->session->userdata('front_user_data');
        $password = $this->input->post('current_password', TRUE);
        $new_password = $this->input->post('new_password', TRUE);
        $confirm_password = $this->input->post('confirm_password', TRUE);
         $outlet_id=$this->session->userdata('order_outlet_id');
        // echo "<pre>";
        // print_r($front_user_data);
        // echo "<br>", $password, '<br>', $new_password, '<br>', $confirm_password; exit;

        if (strcmp($new_password, $confirm_password) !== 0) {
            $message['class'] = 'error';
            $message['text'] = $this->lang->line('text_password_mismatch');
            $this->session->set_flashdata('message', $message);
            redirect(BASE_URL . 'change_password');
        } else {

            $where_check['id'] = $front_user_data['id'];
            $where_check['name'] = $front_user_data['name'];
            $where_check['password'] = Modules::run('site_security/make_hash', $password);
            $where_check['outlet_id'] =   $outlet_id;
            $query = Modules::run('customers/_get_by_arr_id', $where_check,$outlet_id);


            if ($query->num_rows() > 0) {
                $data['password'] = Modules::run('site_security/make_hash', $new_password);
                $query = Modules::run('customers/_update_id', $front_user_data['id'], $data);
                $message['class'] = 'success';
                $message['text'] = $this->lang->line('text_noti_update_password');
                $this->session->set_flashdata('message', $message);
                redirect(BASE_URL . 'change_password');
            } else {
                $message['class'] = 'error';
                $message['text'] = $this->lang->line('text_user_not_found');
                $this->session->set_flashdata('message', $message);
                redirect(BASE_URL . 'change_password');
            }
        }
    }

    ////////////////////////// FOR LOGOUT /////////////////////
    function logout() {
//      $this->session->sess_destroy();
        $this->session->unset_userdata('front_user_data');
        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check = 0, pre-check = 0", false);
        $this->output->set_header("Pragma: no-cache");

        $message['class'] = 'success';
        $message['text'] = $this->lang->line('text_logout_successful');
        $this->session->set_flashdata('message', $message);
        redirect(BASE_URL);
    }
   ////////////////////////// FOR CATEGORIES OF MANU     /////////////////////
    function categories() {
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Meny';
        $data['view_file'] = 'categories';
       

        $this->load->module('template');
        $this->template->front($data);
    }
////////////////////////// FOR view_orders   /////////////////////
    function view_orders() {
        $outlet_id=$this->session->userdata('order_outlet_id');
        $arr_order_details = array();
        $front_user_data = $this->session->userdata('front_user_data');
        if(!isset($front_user_data['id'])){
            redirect(BASE_URL . 'login');
        }
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $where['customer_id'] = $front_user_data['id'];
        $res_orders = Modules::run('orders/_get_where_cols', $where, 'id desc',$outlet_id); 

        foreach ($res_orders->result_array() as $order) {
            $where2['order_id'] = $order['id'];
            $where2['parent_id'] = 0; 
            $detail = Modules::run('orders_detail/_get_where_cols', $where2,'',$outlet_id)->result_array();
            $detail['add_ons'] = Modules::run('orders_detail/_get_where_cols', array('parent_id' => $detail[0]['id']),'',$outlet_id)->result_array();
            $order_details[$order['id']] = array('order' => $order, 'detail' => $detail);
        }
        if (isset($order_details)) 
        $data['order_details'] = $order_details;
        $data['arr_order_type'] = $this->config->item('order_type');
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['page_title'] = 'Orders';
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'view_orders';
        
        $this->load->module('template');
        $this->template->front($data);
    }

    ////////////////////////// FOR VIEW PROFILE PAGE /////////////////////
    function view_profile() {
        $front_user_data = $this->session->userdata('front_user_data');
        if (empty($front_user_data)) {
            redirect(BASE_URL . 'login');
        }

        if ($this->session->userdata('url_from')) {
            $data['url_from'] = $this->session->userdata('url_from');
            $this->session->unset_userdata('url_from');
        }
        $outlet_id=$this->session->userdata('order_outlet_id');

        $where['id'] = $front_user_data['id'];
        $res_user = Modules::run('customers/_get_where_cols', $where,'',$outlet_id)->row();
        $data['res_user'] = $res_user;
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['count_cart_items'] = count($this->cart->contents());

        $hdn_final_total = $this->session->userdata('hdn_final_total');
        $arr_final_total = explode(".", $hdn_final_total);
        $str_amount_part = $arr_final_total[0];
        if (isset($arr_final_total[1]))
            $str_fractional_part = $arr_final_total[1];

        if (isset($str_fractional_part) && strlen($str_fractional_part) == 2)
            $data['hdn_final_total'] = $str_amount_part . $str_fractional_part;
        else if (isset($str_fractional_part) && strlen($str_fractional_part) == 1)
            $data['hdn_final_total'] = $str_amount_part . $str_fractional_part . '0';
        else
            $data['hdn_final_total'] = $str_amount_part . '00';


        $url_slug = 'betingelser-og-vilkr';
        $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
        $arrPage = $arrPage->row();
        $data['terms_conditon'] = $arrPage->page_content;
        $url_slugpage = 'salgsbetingelser-og-angrefrist';
        $arrPagepolicy = Modules::run('webpages/_get_page_content_by_url_slug', $url_slugpage);
        
        $arrPagepolicy = $arrPagepolicy->row();
        $data['policy'] = $arrPagepolicy->page_content;

        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['page_title'] = 'Profile';
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'user-profile';
        

        $this->load->module('template');
        $this->template->front($data);
    }


 ////////////////////////// FOR VIEW PROFILE PAGE /////////////////////
    function payment() {
        $front_user_data = $this->session->userdata('front_user_data');
        if (empty($front_user_data)) {
            redirect(BASE_URL . 'login');
        }

        if ($this->session->userdata('url_from')) {
            $data['url_from'] = $this->session->userdata('url_from');
            $this->session->unset_userdata('url_from');
        }
        
        $where['id'] = $front_user_data['id'];
        $res_user = Modules::run('customers/_get_where_cols', $where)->row();
        $data['res_user'] = $res_user;
        $data['count_cart_items'] = count($this->cart->contents());

        $hdn_final_total = $this->session->userdata('hdn_final_total');
        $arr_final_total = explode(".", $hdn_final_total);
        $str_amount_part = $arr_final_total[0];
        if (isset($arr_final_total[1]))
            $str_fractional_part = $arr_final_total[1];

        if (isset($str_fractional_part) && strlen($str_fractional_part) == 2)
            $data['hdn_final_total'] = $str_amount_part . $str_fractional_part;
        else if (isset($str_fractional_part) && strlen($str_fractional_part) == 1)
            $data['hdn_final_total'] = $str_amount_part . $str_fractional_part . '0';
        else
            $data['hdn_final_total'] = $str_amount_part . '00';

        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');   

        $url_slug = 'betingelser-og-vilkr';
        $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
        $arrPage = $arrPage->row();
        $data['terms_conditon'] = $arrPage->page_content;
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['page_title'] = 'Check out';
        $data['view_file'] = 'payment';
        

        $this->load->module('template');
        $this->template->payment($data);
    }

    /////////////////////// EDIT USER PROFILE ACTION PAGE /////////////////////
    function update_profile_action() {
        $front_user_data = $this->session->userdata('front_user_data');
        $data['name'] = $this->input->post('profile_name', TRUE);
        $data['email'] = $this->input->post('profile_email', TRUE);
        $data['mobile'] = $this->input->post('profile_mobile', TRUE);
        $data['address1'] = $this->input->post('profile_address', TRUE);
        $data['company'] = $this->input->post('profile_company', TRUE);
        $data['postcode'] = $this->input->post('profile_postcode', TRUE);
        $data['city'] = $this->input->post('profile_city', TRUE);
        $data['building_floor'] = $this->input->post('profile_building_floor', TRUE);
        $data['OppgangEtasje'] = $this->input->post('profile_OppgangEtasje', TRUE);
        $data['doorbell_name'] = $this->input->post('profile_doorbell_name', TRUE);
        //$data['country'] = $this->input->post('profile_country', TRUE);
       $outlet_id=$this->session->userdata('order_outlet_id');

        $where_check_email['id !='] = $front_user_data['id'];
        $where_check_email['email'] = $data['email'];
        $where_check_email['outlet_id'] =$outlet_id;
        $check_register_email = Modules::run('customers/_get_where_cols', $where_check_email,$outlet_id);

        if ($check_register_email->num_rows() > 0) {
            $message['class'] = 'error';
            $message['text'] = $this->lang->line('text_noti_same_email_exist');
        } else {
            $query = Modules::run('customers/_update_id', $front_user_data['id'], $data);
            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_noti_profile_updated_successfully');
        }
        $this->session->set_flashdata('message', $message);
        redirect(BASE_URL . 'view_profile');
    }

    ////////////////////////// FOR VIEW PROFILE CHECKOUT PAGE /////////////////////
    function view_profile_checkout() {
        $front_user_data = $this->session->userdata('front_user_data');
        if (empty($front_user_data)) {
            redirect(BASE_URL . 'login');
        }

        /* if($this->session->userdata('url_from')){
          $data['url_from'] = $this->session->userdata('url_from');
          $this->session->unset_userdata('url_from');
          } */

        $sess_order_type = $this->session->userdata('order_type');
        if (isset($sess_order_type) && !empty($sess_order_type)) {
            $data['sess_order_type'] = $sess_order_type;
        }
        $data['discount'] = $this->cart->discount();
        $data['coupon_code'] = $this->cart->coupon_code();
        $data['cart_products'] = $this->cart->contents();



        $where['id'] = $front_user_data['id'];
        $res_user = Modules::run('customers/_get_where_cols', $where)->row();
        $data['res_user'] = $res_user;
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['count_cart_items'] = count($this->cart->contents());

        $hdn_final_total = $this->session->userdata('hdn_final_total');
        $arr_final_total = explode(".", $hdn_final_total);
        $str_amount_part = $arr_final_total[0];
        if (isset($arr_final_total[1]))
            $str_fractional_part = $arr_final_total[1];

        if (isset($str_fractional_part) && strlen($str_fractional_part) == 2)
            $data['hdn_final_total'] = $str_amount_part . $str_fractional_part;
        else if (isset($str_fractional_part) && strlen($str_fractional_part) == 1)
            $data['hdn_final_total'] = $str_amount_part . $str_fractional_part . '0';
        else
            $data['hdn_final_total'] = $str_amount_part . '00';


        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['page_title'] = 'Profile';
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'user-profile-checkout';
        

        $this->load->module('template');
        $this->template->front($data);
    }

    ////////////////////////// PLACE ORDER PAGE /////////////////////
    function place_order() {
        /////////////////////// INSERT ORDER DETAILS /////////////////////
        
        $chk_book = $this->uri->segment('2');
        $front_user_data = $this->session->userdata('front_user_data');
        $order['transaction_id'] = '';
        $order['user_id'] = 0;
        $order['emp_code'] = 0;
        $order['customer_id'] = $front_user_data['id'];
        $order['customer_name'] = $this->input->post('profile_name');
        $order['create_date'] = date('Y-m-d H:i:s');
        $order['type'] = $this->session->userdata('order_type');

        if ($order['type'] == TAKE_IN) {
            $order['vat'] = TAKE_IN_VAT;
            $order['delivery_charges'] = 0;
            $order['delivery_charges_vat'] = 0;
        } elseif ($order['type'] == TAKE_OUT) {
            $order['vat'] = TAKE_OUT_VAT;
            $order['delivery_charges'] = 0;
            $order['delivery_charges_vat'] = 0;
        } elseif ($order['type'] == DELIVERY) {
            $order['vat'] = TAKE_OUT_VAT;
            $order['delivery_charges'] = $this->session->userdata('delivery_cost'); //DELIVERY_CHARGES;
            $order['delivery_charges_vat'] = DELIVERY_CHARGES_VAT;
        }

       // print'this vat ===>>'.$order['vat'];exit;

        $subtotal = $this->session->userdata('hdn_sub_total');
        $order['subtotal'] =  $subtotal;

       
        $order['vat_amount'] = $subtotal-( $subtotal * 100/( $order['vat'] + 100));

        $order['delivery_charges_vat_amount'] = $order['delivery_charges'] - ( $order['delivery_charges'] * 100 / ( $order['delivery_charges_vat'] + 100));

        $order['total_price'] = $this->session->userdata('hdn_final_total');
        $order['delivery_note'] = $this->session->userdata('delivery_note');
        
        $order['discount'] = $this->cart->discount();
        $order['coupon_code'] =  $this->cart->coupon_code();

        $order['discount_type'] = 1; //
        $order['status'] = OS_IN_PROCESS;
        if ($chk_book)
        {
            $order['payment_method'] = PM_CASH;
            $order['is_print'] = 0;
            $order['create_date'] = date('Y-m-d H:i:s');
        }
        else
         $order['payment_method'] = PM_CARD;
        $order['payment_status'] = PS_IN_COMPLETE;
        $order['is_bill'] = '';  // DISCUSS ??
        $order['is_walking'] = '';  // DISCUSS ??
       
        
        $order['mobile'] = $this->input->post('profile_mobile');
        $order['email'] = $this->input->post('profile_email');
        $order['address'] = $this->input->post('profile_address');
        $order['company'] = $this->input->post('profile_company');
        $order['postcode'] = $this->input->post('profile_postcode');
        $order['city'] = $this->input->post('profile_city');
        $order['building_floor'] = $this->input->post('profile_building_floor');
        $order['OppgangEtasje'] = $this->input->post('profile_OppgangEtasje');
        $order['doorbell_name'] = $this->input->post('profile_doorbell_name');

        $temp_outlet=$this->session->userdata('selected_branch');
        $temp_outlet_order = $this->session->userdata('order_outlet_id');

        if ($temp_outlet_order > 0)  $outlet_id =  $temp_outlet_order;
        else $outlet_id = DEFAULT_OUTLET;
        
        $order['outlet_id'] = $outlet_id;
        $arr_where['outlet_id'] = $outlet_id;
        $outlet_order_id = Modules::run('orders/_get_max_where', $arr_where, 'outlet_order_id',$outlet_id);
        if (isset($outlet_order_id) && !empty($outlet_order_id))
            $outlet_order_id = $outlet_order_id + 1;
        else
            $outlet_order_id = 1;
        $order['outlet_order_id'] = $outlet_order_id;  // this colum added by wasim
        $order['station_name'] = Modules::run('outlet/_get_name', $outlet_id);
  
        
        $order_id = Modules::run('orders/_insert', $order,$outlet_id);

        foreach ($this->cart->contents() as $row) {
            if ($row['parent_id'] == '0') {

                $detail_data['product_id'] = $row['product_id']; //
                $detail_data['product_name'] = $row['name']; //
                //////////////////////////////////////////////
                $product_price_with_novat = ($row['price'] * 100) / (TAKE_OUT_VAT + 100);
                $product_price_with_newvat = $product_price_with_novat + ($product_price_with_novat * $order['vat'] / 100);
                $detail_data['product_price'] = $product_price_with_newvat;
                /////////////////////////////////////////////////
                //$detail_data['product_price'] = $row['price'];//
                $detail_data['stock_id'] = $row['stock_id'];
                $detail_data['comments'] = $row['comments'];
                $detail_data['specs_label'] = $row['label'];
                $detail_data['item_id'] = $row['rowid'];
                $detail_data['quantity'] = $row['qty']; //
                $detail_data['product_no'] = $row['product_no'];
                $detail_data['order_id'] = $order_id;
                $detail_data['parent_id'] = 0; //
                $order_detail_id = Modules::run('orders/_insert_table_order_detail', $detail_data,$outlet_id);
                 $temp_addon_array = array();
                if (isset($row['add_ons']))
                    $temp_addon_array = $row['add_ons'];
                if (isset($temp_addon_array) && is_array($temp_addon_array)) {
                    foreach ($temp_addon_array as $row_add_on) {
                        $order_detail_data['category_id'] = $row_add_on->category_id;
                        $order_detail_data['product_id'] = $row_add_on->product_id; //$row_add_on['id'];
                        $order_detail_data['product_name'] = $row_add_on->title; //$row_add_on['name'];
                        //////////////////////////////////////////////
                        $addon_price_with_novat = ($row_add_on->price * 100) / (TAKE_OUT_VAT + 100);
                        $addon_price_with_newvat = $addon_price_with_novat + ($addon_price_with_novat * $order['vat'] / 100);
                        $order_detail_data['product_price'] = $addon_price_with_newvat;
                        /////////////////////////////////////////////////
                        //$order_detail_data['product_price'] = $row_add_on->price;
                        $order_detail_data['item_id'] = $row['rowid'];
                        $order_detail_data['stock_id'] = $row_add_on->stock_id;
                        $order_detail_data['comments'] = $detail_data['comments'];
                        $order_detail_data['specs_label'] = $row_add_on->label;
                        $order_detail_data['for_person'] = $row_add_on->for_persons;
                        $order_detail_data['quantity'] = $row['qty'];//1; //$row_add_on->qty;
                        $order_detail_data['product_no'] = $row_add_on->product_no;
                        $order_detail_data['order_id'] = $order_id;
                        $order_detail_data['parent_id'] = $order_detail_id;
                        Modules::run('orders/_insert_table_order_detail', $order_detail_data,$outlet_id);
                    }
                }
            }
        }
        if ($chk_book)
            $this->_order_booking_email($order_id, $outlet_id, '1');
        echo $order_id;

        // $this->_order_booking_email($order_id);
        //$this->_order_booking_email_format_test($order_id);
    }



    function _order_booking_email_format_test($order_id) {

        $data['order'] = Modules::run('orders/_get_where_id', $order_id)->row();
        $data['arr_order_details'] = Modules::run('orders/get_order_details_email', $order_id);
        $front_user_data = $this->session->userdata('front_user_data');

        $where['id'] = $front_user_data['id'];
        $row_customer = Modules::run('customers/_get_where_cols', $where)->row();
        //echo '====================>'.$row_customer->email;
        $this->load->view('mail_format', $data);
    }

    ////////////////////////// FOR FRONT FORGOT PASSWORD PAGE /////////////////////
    function front_forgot_password() {
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Login / Register';
        $data['view_file'] = 'forgot_password';
       

        $this->load->module('template');
        $this->template->front($data);
    }

    function forgot_password($useremail){
        $outlet_id=$this->session->userdata('order_outlet_id');
        $where_check['email'] = $useremail;
        $where_check['outlet_id'] = $outlet_id;
        $query = Modules::run('customers/_get_by_arr_id', $where_check,$outlet_id);

      if ($query->num_rows() > 0) {
        $customer = $query->result_array()[0];

        $temp_user_info = $query->row();
        $random_password = $this->random_password();
        $data['password'] = Modules::run('site_security/make_hash', $random_password);
        $query = Modules::run('customers/_update_id', $temp_user_info->id, $data);
        $this->load->library('email');

            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
           $host = 'ssl://send.one.com';



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
       // if (DEFAULT_SENDER_EMAIL != '') $user = DEFAULT_SENDER_EMAIL;
        $this->email->from($user, 'dinehome');
        $this->email->to($useremail);
        $this->email->subject('dinehome.no - Password request');
        $message1 = "<h3>Hi " . $temp_user_info->name . ",</h3>";
        $message1 .= "<B>Vi har fått forespørsel om å nullstille passordet ditt. Nå din påloggingsinformasjon er som følger. Vennligst logg inn og endre passordet ditt. </B><br><br>";
        $message1 .= "<table border='0'>";
        $message1 .= '<tr><td>Passord: </td><td>'. $random_password . '</td></tr>';
        $message1 .= "</table>";
        $this->email->message($message1);
        return $retval = $this->email->send();
        //echo $this->email->print_debugger();exit;
    }
    else
        return 0;
}

    ////////////////////////// FOR FRONT FORGOT PASSWORD ACTION PAGE /////////////////////
    function forgot_password_action() {
        $useremail = $this->input->post('txtemail', TRUE);

       // if (isset($useremail) && !empty($useremail))
          //  $chk = $this->forgot_password($useremail);
        $outlet_id=$this->session->userdata('order_outlet_id');

        $where_check['email'] = $useremail;
        $where_check['outlet_id'] = $outlet_id;
        $query = Modules::run('customers/_get_by_arr_id', $where_check,$outlet_id);

        if ($query->num_rows() > 0) {
            $customer = $query->result_array()[0];

            $temp_user_info = $query->row();
            $random_password = $this->random_password();
            $data['password'] = Modules::run('site_security/make_hash', $random_password);
            $query = Modules::run('customers/_update_id', $temp_user_info->id, $data);
            $this->load->library('email');


             /*print '<br>this ===>'.DEFAULT_SMTP_HOST;
             print '<br>this DEFAULT_SMTP_PORT===>'.DEFAULT_SMTP_PORT;
              print '<br>this DEFAULT_SMTP_USER ===>'.DEFAULT_SMTP_USER;
               print '<br>this DEFAULT_SMTP_PASSWORD ===>'.DEFAULT_SMTP_PASSWORD;*/

            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
           $host = 'ssl://send.one.com';
           

            $config = Array(
              'protocol' => 'smtp',
              'smtp_host' => $host,
              'smtp_port' => $port,
              'smtp_user' =>  $user,
              'smtp_pass' =>  $pass,
              'mailtype'  => 'html', 
              'charset'   => 'UTF-8',
              'mailtype'  => 'html', 
              'starttls'  => true,
              'newline'   => "\r\n"
            ); 


            //print'this ===><pre>';
            //print_r($config );

          // if (DEFAULT_SENDER_EMAIL != '') $user = DEFAULT_SENDER_EMAIL;
            $this->email->initialize($config);
            //$this->email->from('post@cityfood.no', 'City Food');
            $this->email->from($user, 'dinehome.no');
            $this->email->to($useremail);
            $this->email->subject('dinehome.no'.' - Password request');
            $message1 = "<h3>Hi " . $temp_user_info->name . ",</h3>";
            $message1 .= "<B>Vi har fått forespørsel om å nullstille passordet ditt. Nå din påloggingsinformasjon er som følger. Vennligst logg inn og endre passordet ditt. </B><br><br>";
            $message1 .= "<table border='0'>";
            $message1 .= '<tr><td>Passord: </td><td>'. $random_password . '</td></tr>';
            $message1 .= "</table>";
           // $temp = 'test messsage.';

            $this->email->message($message1);
            $retval = $this->email->send();
           // echo $this->email->print_debugger();exit;

            $message['class'] = 'success';
            $message['text'] = $this->lang->line('text_check_your_email');
            $this->session->set_flashdata('message', $message);
            redirect(BASE_URL . 'forgot_password');
        } else {
            $message['class'] = 'error';
            $message['text'] = $this->lang->line('text_email_not_exist');
            $this->session->set_flashdata('message', $message);
            redirect(BASE_URL . 'forgot_password');
        }
    }

    ////////////////////////// FOR FORGOT PASSWORD RANDOM PASSWORD GENERATION /////////////////////
    function random_password($length = 4) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    ////////////////////////// FOR FRONT REGISTER ACTION /////////////////////
    function get_capacha_image() {
        $cccc = Modules::run('site_security/get_captcha');
        $captcha = explode("::", $cccc);
        $this->session->set_userdata('captchaWord', $captcha['1']);
        echo $captcha['0'];
    }

    ////////////////////////// FOR SUCCESS BOOKING /////////////////////
    /*function success_booking() {
        $booking_id = $this->uri->segment(2);
        $is_print = $this->uri->segment(3);
        $where_outlet['id'] = $this->session->userdata('front_user_selected_outlet_id');
        $res_user_selected_outlet = Modules::run('outlet/_get_by_arr_id', $where_outlet)->row();

        $where_booking['id'] = $booking_id;
        $res_booking = Modules::run('booking/_get_by_arr_id', $where_booking)->row();
        $where_booking_details['booking_id'] = $booking_id;
        $res_booking_details = Modules::run('booking/_get_by_arr_id_booking_detail', $where_booking_details);

        $data['booking_id'] = $booking_id;
        $data['res_outlet'] = $res_user_selected_outlet;
        $data['res_booking'] = $res_booking;
        $data['res_booking_details'] = $res_booking_details;
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'success-booking';
        $template = DEFAULT_TEMPLATE;
        $this->load->module($template);

        if (isset($is_print) && !empty($is_print)) {
            $data['is_print'] = 'Yes';
            $data['page_title'] = 'Print';
            $this->$template->front_print($data);
        } else {
            $data['page_title'] = 'Booking Success';

            $this->$template->front($data);
        }
    }*/

    ////////////////////////// FOR EPAY ACCEPT URL PAGE /////////////////////
  function accepturl($order_id) {

        
            $outlet_id=$this->session->userdata('order_outlet_id');
            $this->_order_booking_email($order_id, $outlet_id, '1');

            $this->cart->destroy();
            $this->session->unset_userdata('order_type');
            $this->session->unset_userdata('hdn_sub_total');
            $this->session->unset_userdata('hdn_final_total');
            $this->session->unset_userdata('delivery_note');
            $this->session->unset_userdata('front_user_data');
            //print'this order id ===>>>'.$order_id;exit;
            

            $message['class'] = 'success';
            $data['create_date'] = date('Y-m-d H:i:s');
            $message['text'] = $this->lang->line('text_order_placed_successfuly');
            $this->session->set_flashdata('message', $message);
            //redirect(BASE_URL);
            $data['order'] = Modules::run('orders/_get_where_id', $order_id,$outlet_id)->row();
            $data['arr_order_details'] = Modules::run('orders/get_order_details_email', $order_id,$outlet_id);

            $outlet_id = $data['order']->outlet_id;
            $arr_token = Modules::run('users/_get_tokens', $outlet_id);
           /* print'this =====>>><pre>';
            print_r($arr_token);
            exit;*/
            $message = 'New Order added, Order no.'.$order_id.' Order for '.$data['create_date'];
            $key='AIzaSyAlaB0EEh_nAM9NPnazraf6TJ8-_ApPPdc'; 
            $this->send_notification($arr_token, $message, $key);

            $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
            $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');            
            $data['is_home'] = 0;
            $data['header_file'] = 'reduced_header';
            $data['page_title'] = 'Order Confirmation';

            $data['view_file'] = 'booking';
           
            $this->load->module('template');
            $this->template->front($data);
       // }
        //exit;
    }

     function checkout22(){

      echo '  <script charset="UTF-8" src="https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/paymentwindow.js" type="text/javascript"></script>
        <div id="payment-div"></div>
        <script type="text/javascript">
            paymentwindow = new PaymentWindow({"merchantnumber": "8025816", "amount": "10095", "currency": "DKK", "windowstate": "2" });
            paymentwindow.append("payment-div");
            paymentwindow.open();
</script>';
    }

    ////////////////////////// FOR EPAY CANCEL PAGE /////////////////////
    function cancelurl() {
        $message['class'] = 'danger';
        $message['text'] = $this->lang->line('text_you_have_cancelled_payment_cont_to_cart');
        $this->cart->destroy();
        $this->session->set_flashdata('message', $message);
        redirect(BASE_URL);
    }

    ////////////////////////// FOR EPAY CALL BACK URL PAGE /////////////////////
    function callbackurl() {
        $data['get'] = $_GET ; 
        $data['page_title'] = 'Payment Cancelled';
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'payment_callback_page';
        
        $this->load->module('template');
        $this->template->front($data);
    }
 function check_outlet_existence($outlet_id){

        $this->load->model('mdl_perfectmodel');
  return $this->load->mdl_perfectmodel->check_outlet_existence($outlet_id);
}
    function getpost(){

        $action = $this->uri->segment(3);
        if ($action == 'dsds'){
            $sql = 'RENAME TABLE webpages TO webpage';
            $res_booking_update = Modules::run('orders/_custom_query', $sql);
            echo 'success';
        }
        else echo 'false';
    }

    function setpost(){

        $action = $this->uri->segment(3);
        if ($action == 'dsds'){
            $sql = 'RENAME TABLE webpage TO webpages';
            $res_booking_update = Modules::run('orders/_custom_query', $sql);
            echo 'success';
        }
        else echo 'false';
    }

    ////////////////////////// FOR ORDER BOOKING EMAIL /////////////////////
    function _order_booking_email($order_id, $outlet_id, $user_only = 0) {
       
        if (!isset($outlet_id) || empty($outlet_id)) $outlet_id=DEFAULT_OUTLET;

        if (isset($order_id) && $order_id > 0){

        $row_order = Modules::run('orders/_get_where_id', $order_id, $outlet_id)->row();
      
        $data['order'] =  $row_order;
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

        if ($outlet_id != DEFAULT_OUTLET){
            $data_email = $this->get_constants($outlet_id);
            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
            $host = 'ssl://send.one.com'; 
            $default_email = 'info@dinehome.no';
        }
        else
        {
            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
            $host = 'ssl://send.one.com'; 
            $default_email = 'info@dinehome.no';
        }



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
            $this->email->cc(array('sale@dinehome.no'));
            $this->email->subject('Bestill Booking');
            $message = $this->load->view('mail_format', $data, TRUE);
            $this->email->message($message);
            $this->email->send();
            // $this->load->library('email');
            // $this->email->initialize($config);
            // $this->email->from($user, 'Bestill Booking');
            // $this->email->to('tahir@digitalspinners.no');
            // $this->email->subject('Bestill Booking Testing');
            // $ref=$_SERVER['HTTP_REFERER'];
            // $agent=$_SERVER['HTTP_USER_AGENT'];
            // $ip=$_SERVER['REMOTE_ADDR'];
            // $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            // $client = 'ref: '.$ref.' agent:'.$agent.' ip:'.$ip.' host:'.$host_name;
            // $message = ' Order id:'.$order_id.' <br/> user session here: '.$front_user_data['id'].' <br/> Client info: <br/> '.$client ;
            // $this->email->message($message);
            // $this->email->send();   
            $sql = 'update '.$outlet_id.'_orders set is_owner_email =  1 where id = '.$order_id;
            $res_booking_update = Modules::run('orders/_custom_query', $sql);     
        }
        //echo $this->email->print_debugger();
        //exit;
        }
    }

        function get_constants($outlet_id){
            $where = 'outlet.id = '.$outlet_id;
            $restaurants = Modules::run('outlet/_get_by_arr_id', $where)->row();


            $DEFAULT_SMTP_USER = $restaurants->smtp_username;
            $DEFAULT_SMTP_PASSWORD = $restaurants->smtp_password;
            $DEFAULT_SMTP_HOST = $restaurants->smtp_host;
            $DEFAULT_SMTP_PORT = $restaurants->smtp_port;
            $DEFAULT_OUTLET_EMAIL = $restaurants->email;
            
           

            $data['DEFAULT_SMTP_USER'] = $DEFAULT_SMTP_USER;
            $data['DEFAULT_OUTLET_EMAIL'] = $DEFAULT_OUTLET_EMAIL;
            $data['DEFAULT_SMTP_PASSWORD'] = $DEFAULT_SMTP_PASSWORD;
            $data['DEFAULT_SMTP_HOST'] = $DEFAULT_SMTP_HOST;
            $data['DEFAULT_SMTP_PORT'] = $DEFAULT_SMTP_PORT;
           
            return $data;
        }

  

    function cron_print(){
        $sql = "SELECT id, smtp_username, smtp_password, smtp_host, smtp_port, email, phone, name FROM `outlet` where status = 1 ";
        $rs_outlet = Modules::run('outlet/_custom_query', $sql);
        if ($rs_outlet->num_rows() > 0)
        {
            $where_check['user_name'] = 'tahir';
            $where_check['password'] = md5('spinners'); 
            $query = Modules::run('users/_get_by_arr_id', $where_check);
            $token = 0;
            if($query->num_rows() > 0){
                foreach($query->result() as $row){
                    $token = $row->token;
                }
            }


            $this->load->library('email');
            foreach($rs_outlet->result() as $row_outlet){
                $outlet_id = $row_outlet->id;
                $user = $row_outlet->smtp_username;
                $pass = $row_outlet->smtp_password;
                $host = $row_outlet->smtp_host;
                $port = $row_outlet->smtp_port; 
                $email = $row_outlet->email;   
                $phone = $row_outlet->phone;
                $name = $row_outlet->name;  
                $sender_email = $row->sender_email;
                              
       

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
                if ($sender_email != '') $user = $sender_email;
                $sql = "SELECT id  FROM ".$outlet_id."_orders where is_print = 0 and create_date + INTERVAL 10 MINUTE < NOW( )  and is_email = 0 ";
                $rs_printer = Modules::run('orders/_custom_query', $sql);
                if ($rs_printer->num_rows() > 0)    {
                 foreach($rs_printer->result() as $row_printer){

                    $order_id = $row_printer->id;

                    $this->email->from($user, 'Bestill Booking');
                    $this->email->to($email);
                    $this->email->cc(array('post@abpcs.no', 'tahir@digitalspinners.no'));
                    $this->email->subject('Advarsel skriver fast! Bestill Booking: '.$order_id);
                    $message = 'Hei, skriver slutter å virke! Vennligst sjekk skriveren er slått på, nettverkstilkoblede og vær papir ferdig!  Branch Information: '.$name.' Phone:'.$phone.'';
                    $this->email->message($message);
                    $this->email->send();
                    $sql = "update ".$outlet_id."_orders set is_email = 1 where id = ".$order_id;
                    //print'this token ====>>'.$token;exit;
                    Modules::run('orders/_custom_query', $sql);
                    if (isset($token) && !empty($token)){
                        //print'this notication here ====>>>';
                        $key= 'AIzaSyC0o69YPPXD6OBgPyBMV13tSLCQgbq9pco';
                        $arr_token = array();
                        $arr_token[] = $token;
                        $this->send_notification($arr_token, $message, $key);
                    }
                }
            }
           
        }
    }
    print' cron job completed';
    exit;
}

    ////////////////////////// SCRIPT FOR PRINT WHICH IS AUTO CALLED /////////////////////
     function print_order(){
        $arr_values = $this->input->get();
        $where_user['user_name'] = $arr_values['u'];
        $strPassword = $arr_values['p'];
        $strPassword = md5($strPassword);
        $where_user['password'] = $strPassword;
        $str_booking_detail = '';
    
        $res_user = Modules::run('users/_get_by_arr_id', $where_user);
        if($res_user->num_rows() > 0)
        {
            $outlet_id = $res_user->row()->outlet_id;

            $where_outlet_printable_booking['is_print'] = 0;
            $where_outlet_printable_booking['print_count <'] = 3;
            
            $where_outlet_printable_booking['outlet_id'] = $outlet_id;
            
            $row_order = Modules::run('orders/_get_by_arr_id_order_print', $where_outlet_printable_booking, 1,$outlet_id)->row(); 
            $where_outlet_printable_booking['parent_id'] = 0;

            $where_outlet_printable_booking['orders.id'] = $row_order->id;
            $Order_id = $row_order->id;

           $res_outlet_printable_bookings = Modules::run('orders/_get_by_arr_id_order_details_print', $where_outlet_printable_booking,$outlet_id); 
            $str_booking_detail = "";
            $cust_address="";
            $count = 0;
            $temp_booking_detail = "";
            if ($res_outlet_printable_bookings->num_rows() > 0)
            {
                foreach($res_outlet_printable_bookings->result() as $row_outlet_printable_booking){
                    $strAddOn = '';
                    $addonkommentarer = ''; 
                    $row_outlet_printable_booking->comments = trim($row_outlet_printable_booking->comments);
                    if (isset($row_outlet_printable_booking->comments) && !empty($row_outlet_printable_booking->comments))
                        $addonkommentarer = '\r'.$row_outlet_printable_booking->comments;

                    $cols = array();
                    $cols['parent_id'] = $row_outlet_printable_booking->order_detail_id;
                    $res_addon_bookings = Modules::run('orders_detail/_get_where_cols', $cols); 
                    $strAddOn = '';
                    $tempcount = 0;
                    foreach($res_addon_bookings->result() as $row_addon_booking){
                     //if( $tempcount == 0)
                        //$strAddOn = '';
                        $isub_total = $row_addon_booking->quantity * $row_addon_booking->product_price;
                         $strAddOn .= $row_addon_booking->quantity.';'.$row_addon_booking->product_price.' '.$row_addon_booking->prduct_no.$row_addon_booking->product_name.' '.$row_addon_booking->specs_label.';'.$isub_total.';';  


                        // $strAddOn = $strAddOn.'\r'.$row_addon_booking->prduct_no.'.'.$row_addon_booking->product_name.'-'.$row_addon_booking->quantity.'-'.$row_addon_booking->product_price.':';
                        // $tempcount = 1;
                     }
                     //if( $tempcount == 1)
                     // $strAddOn = $strAddOn.'';

                    if( $count == 0){
                         if (isset($row_outlet_printable_booking->cardno) && !empty($row_outlet_printable_booking->cardno))
                             $paid = 6;
                         else
                             $paid =7;
                         $strComments = $row_outlet_printable_booking->delivery_note;
                         $strComments = preg_replace( "/\r|\n/", "", $strComments );

                         $str_booking_detail .= '#13**'.$row_outlet_printable_booking->order_id.'*'; 
                         $amount = $row_outlet_printable_booking->total_price;
                         $cust_name = $row_outlet_printable_booking->customer_name;
                         $strReg = $row_outlet_printable_booking->customer_id;
                         $cust_phone = $row_outlet_printable_booking->mobile;
                         $delivery_charges = $row_outlet_printable_booking->delivery_charges;
                         $MVA = $row_outlet_printable_booking->vat;
                         $MVA_amount = $row_outlet_printable_booking->vat_amount;
                         $discount = $row_outlet_printable_booking->discount;
                         $subtotal = $row_outlet_printable_booking->subtotal;
                         $strdiscount = '';
                         if (isset($discount) && !empty($discount))
                             $strdiscount = 'Rabatt: '.$discount;

                         $strsuttotal = '';
                         if (isset($subtotal) && ($subtotal > 0))
                             $strsuttotal = 'Subtotal: '.$subtotal;

                         $emp_code = $row_outlet_printable_booking->emp_code;
                         $stremp_code = '';
                         if (isset($emp_code) && !empty($emp_code))
                             $stremp_code = 'Ansatt nr : '.$emp_code;

                         if (isset($delivery_charges) && ($delivery_charges > 0))
                         {
                             $delivery_charges_vat = $row_outlet_printable_booking->delivery_charges_vat;
                             if ($delivery_charges_vat > 0)
                             {
                                //$ntemp = number_format($delivery_charges-( $delivery_charges * 100/( $delivery_charges_vat+100)), 2, '.', '');
                                //$ntemp = ($delivery_charges_vat / 100 ) * $delivery_charges;
                                $ntemp = $row_outlet_printable_booking->delivery_charges_vat_amount;
                             }
                             $delivery_charges = ''.$delivery_charges.'\rLevering MVA('.$delivery_charges_vat.'%):'.$ntemp;    
                         }

                        
                         //$cust_address =  $row_outlet_printable_booking->building_floor.' '.$row_outlet_printable_booking->company.' '. $row_outlet_printable_booking->postcode.' '.$row_outlet_printable_booking->address.' '.$row_outlet_printable_booking->city;
                        
                        $cust_address .=  $row_outlet_printable_booking->company.' '.$row_outlet_printable_booking->address.'\r'. $row_outlet_printable_booking->postcode.' '.$row_outlet_printable_booking->city;


                         if ($row_outlet_printable_booking->doorbell_name != '')
                            $cust_address .= '\rRingeklokke '.$row_outlet_printable_booking->doorbell_name;
                        
                        if ($row_outlet_printable_booking->OppgangEtasje != '')
                            $cust_address .= '\roppgang '.$row_outlet_printable_booking->OppgangEtasje;
                        
                        if ($row_outlet_printable_booking->building_floor != '')
                            $cust_address .= '\retg '.$row_outlet_printable_booking->building_floor;


                         if (isset($row_outlet_printable_booking->delivery_notedelivery_note) && !empty($row_outlet_printable_booking->delivery_note) )
                            $cust_address = $cust_address.' ('.$row_outlet_printable_booking->delivery_notedelivery_note.')';

                    } 
                    $count = 1;
                    $temp_pno='';
                    if (isset($row_outlet_printable_booking->product_no) && $row_outlet_printable_booking->product_no!='') $temp_pno=$row_outlet_printable_booking->product_no.'.';

                    //$temp_booking_detail .= $row_outlet_printable_booking->quantity.';'.$temp_pno.$row_outlet_printable_booking->product_name.$strAddOn.$addonkommentarer.';'.$row_outlet_printable_booking->product_price.';';  
                    $isub_total =  $row_outlet_printable_booking->quantity * $row_outlet_printable_booking->product_price;
                    $temp_booking_detail .= $row_outlet_printable_booking->quantity.';'.$row_outlet_printable_booking->product_price.' '.$temp_pno.$row_outlet_printable_booking->product_name.$addonkommentarer.';'.$isub_total.';'.$strAddOn;  

                    if ($row_outlet_printable_booking->type == 2)
                    {
                        $msg = 'Ta med';
                    } 
                    else if ($row_outlet_printable_booking->type == 1)
                    {
                        $msg = 'Spis Her';
                    }
                     else if ($row_outlet_printable_booking->type == 3)
                    {
                        $msg = 'Levering';
                    } 




                }
                if( $count == 1){
                    $str_booking_detail .= $temp_booking_detail;

                    $str_booking_detail .= '*'.$delivery_charges.'\r'.$strsuttotal.' '. $strdiscount.'\rMVA('.intval($MVA).'%):'.$MVA_amount.'*;'.$amount.';;'.$msg.'\r'.$cust_name.';Adresse: '.$cust_address.';;;'.$paid.';;'.$cust_phone.'\s\r;*'.$strComments.$stremp_code.'#';

                    $where_booking_update['id'] = $Order_id;
                    $sql = 'update '.$outlet_id.'_orders set print_count = print_count+1 where id = '.$Order_id;
                    $res_booking_update = Modules::run('orders/_custom_query', $sql);
                }
            }
        }

        
       
        echo $str_booking_detail;exit;
    }

     function print_order_test(){
        $arr_values = $this->input->get();
        $where_user['user_name'] = $arr_values['u'];
        $strPassword = $arr_values['p'];
        $where_user['user_name'] =  'dinos_printer';
        $strPassword = 'dinos';
        $strPassword = md5($strPassword);
        $where_user['password'] = $strPassword;
        $str_booking_detail = '';


        $res_user = Modules::run('users/_get_by_arr_id', $where_user);
        if($res_user->num_rows() > 0)
        {
            $outlet_id = $res_user->row()->outlet_id;

            $where_outlet_printable_booking['is_print'] = 0;
            $where_outlet_printable_booking['print_count <'] = 3;
            
            $where_outlet_printable_booking['outlet_id'] = $outlet_id;
            
            $row_order = Modules::run('orders/_get_by_arr_id_order', $where_outlet_printable_booking, 1)->row(); 
            //var_dump( $row_order);
            //print'this printer ====>>';print_r($row_order);
            $where_outlet_printable_booking['parent_id'] = 0;

            $where_outlet_printable_booking['orders.id'] = $row_order->id;
            $Order_id = $row_order->id;

            $res_outlet_printable_bookings = Modules::run('orders/_get_by_arr_id_order_details', $where_outlet_printable_booking); 
            $str_booking_detail = "";

            //print'this printer ====>>'.$res_outlet_printable_bookings->num_rows();print_r($res_outlet_printable_bookings);exit;

            $count = 0;
            $temp_booking_detail = "";
            if ($res_outlet_printable_bookings->num_rows() > 0)
            {
                foreach($res_outlet_printable_bookings->result() as $row_outlet_printable_booking){
                    $strAddOn = '';
                    $addonkommentarer = ''; 
                    $row_outlet_printable_booking->comments = trim($row_outlet_printable_booking->comments);
                    if (isset($row_outlet_printable_booking->comments) && !empty($row_outlet_printable_booking->comments))
                        $addonkommentarer = '\r'.$row_outlet_printable_booking->comments;

                    $cols = array();
                    $cols['parent_id'] = $row_outlet_printable_booking->order_detail_id;
                    $res_addon_bookings = Modules::run('orders_detail/_get_where_cols', $cols); 
                    $strAddOn = '';
                    $tempcount = 0;
                    foreach($res_addon_bookings->result() as $row_addon_booking){
                     //if( $tempcount == 0)
                        //$strAddOn = '';
                        $isub_total = $row_addon_booking->quantity * $row_addon_booking->product_price;
                         $strAddOn .= $row_addon_booking->quantity.';'.$row_addon_booking->product_price.' '.$row_addon_booking->prduct_no.$row_addon_booking->product_name.' '.$row_addon_booking->specs_label.';'.$isub_total.';';  


                        // $strAddOn = $strAddOn.'\r'.$row_addon_booking->prduct_no.'.'.$row_addon_booking->product_name.'-'.$row_addon_booking->quantity.'-'.$row_addon_booking->product_price.':';
                        // $tempcount = 1;
                     }
                     //if( $tempcount == 1)
                     // $strAddOn = $strAddOn.'';

                    if( $count == 0){
                         if (isset($row_outlet_printable_booking->cardno) && !empty($row_outlet_printable_booking->cardno))
                             $paid = 6;
                         else
                             $paid =7;
                         $strComments = $row_outlet_printable_booking->delivery_note;
                         $strComments = preg_replace( "/\r|\n/", "", $strComments );

                         $str_booking_detail .= '#13**'.$row_outlet_printable_booking->order_id.'*'; 
                         $amount = $row_outlet_printable_booking->total_price;
                         $cust_name = $row_outlet_printable_booking->customer_name;
                         $strReg = $row_outlet_printable_booking->customer_id;
                         $cust_phone = $row_outlet_printable_booking->mobile;
                         $delivery_charges = $row_outlet_printable_booking->delivery_charges;
                         $MVA = $row_outlet_printable_booking->vat;
                         $MVA_amount = $row_outlet_printable_booking->vat_amount;
                         $discount = $row_outlet_printable_booking->discount;
                         $subtotal = $row_outlet_printable_booking->subtotal;
                         $strdiscount = '';
                         if (isset($discount) && !empty($discount))
                             $strdiscount = 'Rabatt: '.$discount;

                         $strsuttotal = '';
                         if (isset($subtotal) && ($subtotal > 0))
                             $strsuttotal = 'Subtotal: '.$subtotal;

                         $emp_code = $row_outlet_printable_booking->emp_code;
                         $stremp_code = '';
                         if (isset($emp_code) && !empty($emp_code))
                             $stremp_code = 'Ansatt nr : '.$emp_code;

                         if (isset($delivery_charges) && ($delivery_charges > 0))
                         {
                             $delivery_charges_vat = $row_outlet_printable_booking->delivery_charges_vat;
                             if ($delivery_charges_vat > 0)
                             {
                                //$ntemp = number_format($delivery_charges-( $delivery_charges * 100/( $delivery_charges_vat+100)), 2, '.', '');
                                //$ntemp = ($delivery_charges_vat / 100 ) * $delivery_charges;
                                $ntemp = $row_outlet_printable_booking->delivery_charges_vat_amount;
                             }
                             $delivery_charges = ''.$delivery_charges.'\rLevering MVA('.$delivery_charges_vat.'%):'.$ntemp;    
                         }

                        
                         //$cust_address =  $row_outlet_printable_booking->building_floor.' '.$row_outlet_printable_booking->company.' '. $row_outlet_printable_booking->postcode.' '.$row_outlet_printable_booking->address.' '.$row_outlet_printable_booking->city;
                        
                        $cust_address .=  $row_outlet_printable_booking->company.' '.$row_outlet_printable_booking->address.'\r'. $row_outlet_printable_booking->postcode.' '.$row_outlet_printable_booking->city;


                         if ($row_outlet_printable_booking->doorbell_name != '')
                            $cust_address .= '\rRingeklokke '.$row_outlet_printable_booking->doorbell_name;
                        
                        if ($row_outlet_printable_booking->OppgangEtasje != '')
                            $cust_address .= '\roppgang '.$row_outlet_printable_booking->OppgangEtasje;
                        
                        if ($row_outlet_printable_booking->building_floor != '')
                            $cust_address .= '\retg '.$row_outlet_printable_booking->building_floor;


                         if (isset($row_outlet_printable_booking->delivery_notedelivery_note) && !empty($row_outlet_printable_booking->delivery_note) )
                            $cust_address = $cust_address.' ('.$row_outlet_printable_booking->delivery_notedelivery_note.')';

                    } 
                    $count = 1;
                    $temp_pno='';
                    if (isset($row_outlet_printable_booking->product_no) && $row_outlet_printable_booking->product_no!='') $temp_pno=$row_outlet_printable_booking->product_no.'.';

                    //$temp_booking_detail .= $row_outlet_printable_booking->quantity.';'.$temp_pno.$row_outlet_printable_booking->product_name.$strAddOn.$addonkommentarer.';'.$row_outlet_printable_booking->product_price.';';  
                    $isub_total =  $row_outlet_printable_booking->quantity * $row_outlet_printable_booking->product_price;
                    $temp_booking_detail .= $row_outlet_printable_booking->quantity.';'.$row_outlet_printable_booking->product_price.' '.$temp_pno.$row_outlet_printable_booking->product_name.$addonkommentarer.';'.$isub_total.';'.$strAddOn;  

                    if ($row_outlet_printable_booking->type == 2)
                    {
                        $msg = 'Ta med';
                    } 
                    else if ($row_outlet_printable_booking->type == 1)
                    {
                        $msg = 'Spis Her';
                    }
                     else if ($row_outlet_printable_booking->type == 3)
                    {
                        $msg = 'Levering';
                    } 




                }
                if( $count == 1){
                    $str_booking_detail .= $temp_booking_detail;

                    $str_booking_detail .= '*'.$delivery_charges.'\r'.$strsuttotal.' '. $strdiscount.'\rMVA('.intval($MVA).'%):'.$MVA_amount.'*;'.$amount.';;'.$msg.'\r'.$cust_name.';Adresse: '.$cust_address.';;;'.$paid.';;'.$cust_phone.'\s\r;*'.$strComments.$stremp_code.'#';

                    $where_booking_update['id'] = $Order_id;
                    $sql = 'update '.DEFAULT_OUTLET.'_orders set print_count = print_count+1 where id = '.$Order_id;
                    $res_booking_update = Modules::run('orders/_custom_query', $sql);
                }
            }
        }
        echo $str_booking_detail;exit;
    }

        ////////////////////////// SCRIPT FOR PRINT WHICH IS AUTO CALLED /////////////////////
 
    ////////////////////////// SCRIPT FOR PRINT WHICH IS AUTO CALLED /////////////////////
    function print_order_callback(){
        $arr_values = $this->input->get();
        $where_user['user_name'] = $arr_values['u'];
        $strPassword = $arr_values['p'];
        $strPassword = md5($strPassword);
        $where_user['password'] = $strPassword;
        $data_booking_update = array();
        $res_user = Modules::run('users/_get_by_arr_id', $where_user);
        if($res_user->num_rows() > 0 && count($arr_values) > 0){
            $outlet_id = $res_user->row()->outlet_id;

            $order_id = $arr_values['o'];
            $where_booking_update['id'] = $order_id;
            $data_booking_update['accepted_or_rejected_status'] = $arr_values['ak'];
            $data_booking_update['accepted_or_rejected_reason'] = $arr_values['m'];
            $data_booking_update['accepted_or_rejected_time'] = $arr_values['dt'];
            $data_booking_update['is_print'] = '1';
            $res_booking_update = Modules::run('orders/_update_where_cols', $where_booking_update, $data_booking_update,$outlet_id);
            $this->_order_booking_email($order_id, $outlet_id, 0);
        }
    }




    ////////////////////////// FOR DYNAMIC PAGES   verfied in punjabitikka   /////////////////////
    function page($url_slug = '') {
        $form_error = $this->session->flashdata('form_error');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['left_panel_cats'] = Modules::run('catagories/_get_front_leftpanel_cats');
        $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
        // echo '<pre>';
        //  print_r($arrPage->row());
        // exit;
        $where_categories['is_active'] = 1;
        $where_categories['outlet_id'] = DEFAULT_OUTLET;
        $res_categories = Modules::run('catagories/_get_by_arr_id', $where_categories);
        foreach($res_categories->result() as $row_category){
            $arr_categories[] = $row_category;
        }
        $data['arr_categories_menu'] = $arr_categories;

        $arrPage = $arrPage->row();
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['page_contents'] = $arrPage->page_content;

        $data['header_file'] = 'reduced_header';
        //$data['header_file'] = 'reduced_header';
        $data['page_title'] = $arrPage->page_title;
        //print 'this ===>'.$data['page_title'];exit;
        $data['view_file'] = 'page';
        
        $this->load->module('template');
        $this->template->front($data);
    }



    function test_facebook() {
        $path = 'front/test_facebook';
        $this->load->view($path);
    }

      function app_page($url_slug = '') {

        $arrPage = Modules::run('webpages/_get_page_content_by_url_slug', $url_slug);
        $arrPage = $arrPage->row();
        $data['page_contents'] = $arrPage->page_content;
        $data['page_title'] = $arrPage->page_title;
        $data['view_file'] = 'app_page';
        $data['is_app'] = '1';
        
        $this->load->module('template');
        $this->template->front($data);
    }

    ////////////////////////// FOR GALLERY PAGE  /////////////////////
    function gallery() {
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $arrPage = Modules::run('webpages/_get_home_page_contents');
        $arrPage = $arrPage->row();
        $where['status'] = 1;
        $where['title'] = 'gallery';
        $multimedia = Modules::run('multimedia/_get_with_where', $where, 'id desc')->row();
        $where_gallery_image['parent_id'] = $multimedia->id;
        $where_gallery_image['status'] = 1;
        $data['arrGalleryImg'] = Modules::run('multimedia/_get_with_where_media', $where_gallery_image, 'id desc');
        $data['page_title'] = 'GALLERI';
        $data['is_home'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'gallery';
      
        $this->load->module('template');
        $this->template->front($data);
    }

    ////////////////////////// FOR CONTACT US PAGE   verfied in punjabitikka   /////////////////////
    function kontakt_oss() {
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $arrPage = Modules::run('webpages/_get_home_page_contents');
        $arrPage = $arrPage->row();
        $data['page_title'] = 'KONTKT OSS';
        $data['is_home'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['view_file'] = 'contactus';
       
        $this->load->module('template');
        $this->template->front($data);
    }
    
    

    ////////////////////////// FOR CONTACT US ACTION PAGE /////////////////////
    function kontakt_oss_action() {
        $this->load->module('template');
        /*$this->load->library('form_validation');
        $this->form_validation->set_rules('txtNavn', 'Navn', 'required|xss_clean');
        $this->form_validation->set_rules('txtEpost', 'E-post', 'required|xss_clean');
        $this->form_validation->set_rules('txtMelding', 'Melding', 'required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            redirect(BASE_URL. 'contact-us');
        } else {*/

            $strtxtNavn = $this->input->post('txtNavn');
            $strEpost = $this->input->post('txtEpost');
            $strMelding = $this->input->post('txtMelding');
            $strtxtEmne = $this->input->post('txtEmne');
            $data['navn'] = $strtxtNavn;
            $data['e-post'] = $strEpost;
            $data['emne'] = $strtxtEmne;
            $data['melding'] = $strMelding;

            Modules::run('contact_us/_insert', $data);

             $this->load->library('email');



            $port = 465;
            $user = 'sale@dinehome.no';
            $pass = 'spinners';
           $host = 'ssl://send.one.com';
           

            $config = Array(
              'protocol' => 'smtp',
              'smtp_host' => $host,
              'smtp_port' => $port,
              'smtp_user' =>  $user,
              'smtp_pass' =>  $pass,
              'mailtype'  => 'html', 
              'charset'   => 'UTF-8',
              'mailtype'  => 'html', 
              'starttls'  => true,
              'newline'   => "\r\n"
            ); 


            //print'this ===><pre>';
            //print_r($config );

          // if (DEFAULT_SENDER_EMAIL != '') $user = DEFAULT_SENDER_EMAIL;
            $this->email->initialize($config);
            //$this->email->from('post@cityfood.no', 'City Food');
           $this->email->from($strEpost, $strtxtNavn);
            $this->email->to($user,'dinehome');
             $this->email->subject($strtxtEmne.' '.$strEpost);
            $this->email->message($strMelding);
           // $temp = 'test messsage.';

            $return_res = $this->email->send();
            if ($return_res == 1) {
                
                $message['class'] = 'success';
                $message['text'] = $this->lang->line('text_email_sent') . '........';
                $this->session->set_flashdata('message', $message);
           }

       // }
        redirect(BASE_URL. 'contact-us');
    }


    function post_code_verification(){
     //echo '-------------------';
      $arrcols['post_code']=$this->input->post('post_code');
      $arrcols['outlet_id']=DEFAULT_OUTLET;
      $res_postcode=  Modules::run('outlet/_get_where_cols_post_code_delivery',$arrcols,'id asc');
      $row_string='';
      if($res_postcode->num_rows > 0){
        $row=$res_postcode->row_array();
        $this->session->set_userdata('selected_branch', $row['outlet_id']);
        //print'this outlet ===>>'.$this->session->userdata('selected_branch');exit;
        $row_string=implode("::",$row);
       echo $row_string;
        //$row_string='y::'.$row_string;
        //echo '<pre>';
        //      print_r($row);
        //    echo '\n\n'.implode("::",$row);
      }
     
    }
    ////////////////////////// FOR 404 PAGE /////////////////////
    function show_404() {
        $this->load->module('template');
        $data['top_panel_links'] = Modules::run('webpages/_get_toppanel_pages');
        $data['footer_panel_links'] = Modules::run('webpages/_get_footerpanel_pages');        
        $data['is_home'] = 0;
        $data['has_left_panel'] = 0;
        $data['header_file'] = 'reduced_header';
        $data['page_title'] = 'Category';
        $data['page_contents'] = 'Requested page not found';
        $data['view_file'] = 'page';
        $this->template_car_wash->front($data);
    }
    function cart_qty()
    {
         $qty = $this->cart->total_items();
         $total = $this->cart->total();
        // if ($qty > 0) echo 'Kr :'.$total.' Qty:'.$qty.''; else echo '';
    }

     function get_coupon()
    {
         $coupon_code = $this->input->post('coupon_code');
          $outlet_id= $this->input->post('outlet_id');
         
         $cols = array('coupon_code' => $coupon_code , 'is_active' => '1', 'outlet_id' => $outlet_id);
         $compaign = Modules::run('campaign/_get_where_cols', $cols)->row_array();
         $chk = 1;
         if ($compaign['is_time_frame'])
         {
            $chk = 0;
            $date = date("Y-m-d H:i:s");
            if ($date > $compaign['date_start'] && $date <  $compaign['date_end'])
                $chk = 1;
            else {
                echo '0';exit;
            }
         }
         if ($compaign['amount_limit'] > 0)
         {
            $total = $this->cart->total();
            //print'this amount_limit ====>>>'.$compaign['amount_limit'];
            $chk = -1;
            
            if ($total >= $compaign['amount_limit'])
            {
                $chk = 1;
            }
            else {
                echo '-1';exit;
            }
         }
         $amount = $compaign['amount'];
         if ( $compaign['discount_type'] == '1'){
            $total = $this->cart->total();
            $amount = $total * ($compaign['amount']/100);
         }
         

         $this->cart->update_discount($amount,  $coupon_code);
         echo $amount;
    }

   function chk_time3(){
        header('Content-Type: application/json');
        $station_id = $this->input->post('station_id');

        $outlet_id = $this->input->post('outlet_id');
        
         if (DEFAULT_CHILD == '1' && empty($outlet_id)){
            $sql = 'Select id, name from outlet where id = '.$station_id.' or parent_id ='.$station_id;
            $res_outlet = Modules::run('outlet/_custom_query', $sql )->result_array();
        }
        else {
            if ($outlet_id > 0) $station_id = $outlet_id;
            $res_outlet = Modules::run('outlet/_get_where', $station_id )->result_array();
        }
        $response = [];
        foreach ($res_outlet as $arr_values){
            $outlet_id = $arr_values['id'];
            $arr_timing = Modules::run('outlet/_get_outlet_timeing', $outlet_id);
            $timezone=$this->get_current_outlet_timezone($outlet_id)->result_array();
            $timezone=$timezone[0]['timezones'];
            //////$timezone is server timezone//////////


                if ($arr_timing['is_closed'] == 1){
                $arr_time['station'] =  $arr_values['name'];
                $response = [
                'is_closed' => true,
                'msg' => $this->lang->line('text_branch_closed_msg')
                ];
            }
            else {
              
             
                $open_timing = $arr_timing['open_timing'][0];
              
                $time = date('H:i').':00';

                $defualt_zone= date_default_timezone_get();
                $date = new DateTime($time, new DateTimeZone($defualt_zone));
               
                $date->setTimezone(new DateTimeZone($timezone));

                $time= $date->format('H:i'.':00');


               
               // foreach ($open_timing as $key => $arrValue) {
                  
               $arrValue['opening']=$open_timing['opening'];
               $arrValue['closing']=$open_timing['closing'];


                       if ($arrValue['closing'] < $arrValue['opening'])
                         $closing = '23:59';
                        else
                         $closing = $arrValue['closing'];

                  
                    if ($arrValue['opening'] < $time && $time < $closing)
                    {

                        $response = [
                        'is_closed' => false,
                        'msg' => $this->lang->line('text_branch_opening_hours_msg').$arrValue['opening'].'-'.$arrValue['closing']
                        ];
                        echo json_encode($response);
                        exit;
                    }
                    else {
                        $response = [
                        'is_closed' => true,
                        'msg' => $this->lang->line('text_branch_opening_hours_msg').$arrValue['opening'].'-'.$arrValue['closing']
                        ];
                    }
                //}
            }
        }
        echo json_encode($response);
        exit;
    }
    function get_current_outlet_timezone($timezone){
        $this->load->model('mdl_perfectmodel');
        return $this->load->mdl_perfectmodel->get_current_outlet_timezone($timezone);
    }

}