<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends MX_Controller
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
        
        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
        function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $data['product_attribute']=$this->get_attriutes_list($update_id)->result_array();
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function import_file(){
        
        $data['view_file'] = 'fileupload';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
     function manage_wips(){
        $product_id=$this->uri->segment(4);
        $data['product_id']=$product_id;
        $data['news'] = $this->_get_wips_data('id desc',$product_id);
        $data['view_file'] = 'new_wips';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
     function import_wips(){
        $product_id=$this->uri->segment(4);
        $data['product_id']=$product_id;
        $data['view_file'] = 'import_wips';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
     function create_wips(){
          $product_id = $this->uri->segment(4);
          $update_id = $this->uri->segment(5);
          $data['product_id']=$product_id;
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news']=Modules::run('api/_get_specific_table_with_pagination',array("product_id" =>$product_id,'id'=>$update_id), 'id asc','wip_attributes','*','1','1')->row_array();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'wip_form';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function submit_wips_data(){
        $product_id = $this->uri->segment(4);
        $wip_id = $this->uri->segment(5);
        $where['product.id'] = $product_id;
            $query = $this->_get_by_arr_id($where)->row_array();
            if(!empty($query)){
            $arr_data['product_id']=$query['id'];
            $arr_data['navision_number']= $this->input->post('navision_number');;
            $arr_data['product_name']= $this->input->post('product_name');;
            $arr_data['parent_navision']=$query['navision_no'];
            if(empty($wip_id)){
                $arr_where['navision_number']=$arr_data['navision_number'];
                $arr_where['parent_navision']=$arr_data['parent_navision'];
            }else{
                $arr_where['id']=$wip_id;
                $arr_where['product_id']=$product_id;
            }
            
            Modules::run('api/insert_or_update',$arr_where,$arr_data,'wip_attributes');
            }
            redirect(ADMIN_BASE_URL.'product/manage_wips/'.$product_id);
    }
     function _get_data_from_db($update_id) {
        $where['product.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['product_title'] = $row->product_title;
            $data['navision_no'] = $row->navision_no;
            $data['brand_name'] = $row->brand_name;
            $data['packaging_type'] = $row->packaging_type;
            $data['status'] = $row->status;
            $data['unit_weight'] = $row->unit_weight;
            $data['shape'] = $row->shape;
            $data['channel'] = $row->channel;
            $data['shelf_life'] = $row->shelf_life;
            $data['outlet_id'] = $row->outlet_id;
            $data['product_type'] = $row->product_type;

        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['product_title'] = $this->input->post('product_title');
        $data['navision_no'] = $this->input->post('navision_no');
        $data['brand_name'] = $this->input->post('brand_name');
        $data['unit_weight'] = $this->input->post('unit_weight');
        $data['shape'] = $this->input->post('shape');
        $data['channel'] = $this->input->post('channel');
        $data['shelf_life'] = $this->input->post('shelf_life');
        $data['packaging_type'] = $this->input->post('packaging_type');
        $data['outlet_id'] = DEFAULT_OUTLET;
        $data['status'] = $this->input->post('hdnActive');
        $data['product_type'] = $this->input->post('product_type');
        return $data;
    }
     function _get_attribute_data_from_post($product_id) {
        $attribute_list= $this->input->post('attribute_name');
        $min_value=$this->input->post('min_value');
        $max_value=$this->input->post('max_value');
        $target_value=$this->input->post('target_val');
        $total=count($attribute_list);
        if(isset($attribute_list) && !empty($attribute_list)){
        for ($i=0; $i <$total; $i++) {
            $where_attr['product_id']=$product_id;
            $where_attr['attribute_name']=$attribute_list[$i];
            $arr_attr_data= $this->check_atrribute_exists($where_attr)->result_array();
            if(empty($arr_attr_data)){
            $arr_attribute['product_id']=$product_id;
            $arr_attribute['outlet_id']=DEFAULT_OUTLET;
            $arr_attribute['attribute_name']=$attribute_list[$i];
            $arr_attribute['min_value']=$min_value[$i];
            $arr_attribute['target_value']=$target_value[$i];
            $arr_attribute['max_value']=$max_value[$i];
            $attribute_ids[]=$this->insert_attribute_data($arr_attribute);
            }
            elseif(!empty($arr_attr_data)){
                  $where['id']=$arr_attr_data[0]['id'];
                  $attribute_data['min_value']=$min_value[$i];
                  $attribute_data['target_value']=$target_value[$i];
                  $attribute_data['max_value']=$max_value[$i];
                  $attribute_ids=$this->update_attribute_data($where,$attribute_data);

            }
            
        }

      
     }
  }

    function submit() {
       
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            if (is_numeric($update_id) && $update_id != 0) {
                $where['id'] = $update_id;
                $this->_update($where, $data);
                $this->_get_attribute_data_from_post($update_id);
                $this->session->set_flashdata('message', 'product'.' '.DATA_UPDATED);										
		                $this->session->set_flashdata('status', 'success');
            }
            if (is_numeric($update_id) && $update_id == 0) {
                $id = $this->_insert($data);
                $this->_get_attribute_data_from_post($id);
                $this->session->set_flashdata('message', 'product'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            }
            redirect(ADMIN_BASE_URL . 'product');

    }
    function submit_csv(){
        if(isset($_FILES['csvfile']) && $_FILES['csvfile']['size'] >0){
        $ext = pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION);
        if($ext=="csv"){
        $data = $this->csvToArray($_FILES['csvfile']['tmp_name'], ',');
       // Set number of elements (minus 1 because we shift off the first row)
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
        foreach ($newArray as $key => $row_value) {
            $product_id="";
            $arr_data['product_title']=$row_value['Product Name'];
            $arr_data['navision_no']=$row_value['Navision Number'];
            $arr_data['brand_name']=$row_value['Brand Name'];
            $arr_data['packaging_type']=$row_value['Packaging Type'];
            $arr_data['unit_weight']=$row_value['Unit Weight (oz)'];
            $arr_data['shape']=$row_value['Shape'];
            $arr_data['channel']=$row_value['Channel'];
            $arr_data['shelf_life']=$row_value['Shelf Life'];
            $arr_data['status']=1;
            $arr_data['created_date']=date('Y-m-d');
            $arr_data['outlet_id']=DEFAULT_OUTLET;
            $arr_where['navision_no']=$row_value['Navision Number'];
            $check_arr=$this->check_if_exists($arr_where)->result_array();
            if(isset($check_arr) && !empty($check_arr)){
                $product_id=$check_arr[0]['id'];
            }else{
                $product_id=$this->_insert($arr_data);
            }
            $where_attr['product_id']=$product_id;
            $where_attr['attribute_name']=$row_value['Attribute'];
            $arr_attr_data= $this->check_atrribute_exists($where_attr)->result_array();
            if(empty($arr_attr_data)){
            $arr_attribute['product_id']=$product_id;
            $arr_attribute['outlet_id']=DEFAULT_OUTLET;
            $arr_attribute['attribute_name']=$row_value['Attribute'];
            $arr_attribute['min_value']=$row_value['min '];
            $arr_attribute['target_value']=$row_value['target'];
            $arr_attribute['max_value']=$row_value['max'];
            $attribute_ids[]=$this->insert_attribute_data($arr_attribute);
            }
            
            
        }
    }
    $this->session->set_flashdata('message', 'product'.' '.DATA_SAVED);                                        
      $this->session->set_flashdata('status', 'success');
  }
  else{
    $this->session->set_flashdata('message', "Invalid file format");                                        
    $this->session->set_flashdata('status', 'success');
  }
      
  }
  else{
    $this->session->set_flashdata('message',"Invalid file format or something went wrong");                                        
    $this->session->set_flashdata('status', 'success');
  }
          
            
            redirect(ADMIN_BASE_URL . 'product');
}

 function submit_wips_csv(){
        $product_id = $this->uri->segment(4);
        if(isset($_FILES['csvfile']) && $_FILES['csvfile']['size'] >0){
        $ext = pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION);
       
        if($ext=="csv" || $ext=="xlsx"){
        $data = $this->csvToArray($_FILES['csvfile']['tmp_name'], ',');
       // Set number of elements (minus 1 because we shift off the first row)
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
        foreach ($newArray as $key => $row_value) {
            $product_id="";
            $where['product.navision_no'] = $row_value['Navision Number (FG)'];
            $query = $this->_get_by_arr_id($where)->row_array();
            if(!empty($query)){
            $arr_data['product_id']=$query['id'];
            $arr_data['navision_number']=$row_value['Navision Number (WIP)'];
            $arr_data['product_name']=$row_value['WIP Name'];
            $arr_data['parent_navision']=$row_value['Navision Number (FG)'];
            
            
            $arr_where['navision_number']=$row_value['Navision Number (WIP)'];
            $arr_where['parent_navision']=$row_value['Navision Number (FG)'];
            
            Modules::run('api/insert_or_update',$arr_where,$arr_data,'wip_attributes');
            }
            
        }
    }
    $this->session->set_flashdata('message', 'product'.' '.DATA_SAVED);                                        
      $this->session->set_flashdata('status', 'success');
  }
  else{
    $this->session->set_flashdata('message', "Invalid file format");                                        
    $this->session->set_flashdata('status', 'success');
  }
      
  }
  else{
    $this->session->set_flashdata('message',"Invalid file format or something went wrong");                                        
    $this->session->set_flashdata('status', 'success');
  }
          
            
            redirect(ADMIN_BASE_URL . 'product');
}
    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
        $where['product_id'] =$delete_id;
        $where['outlet_id'] = DEFAULT_OUTLET;
        $this->_delete_product_attributes($where);
        $this->_delete_wips_db(array('product_id'=>$delete_id));
    }
    function delete_wips(){
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete_wips_db($where);
        
    }
     function delete_attributes() {
        $delete_id = $this->input->post('id');  
        $productid = $this->input->post('productid');  
        $where['id'] = $delete_id;
        $where['product_id'] = $productid;
        $where['outlet_id'] = DEFAULT_OUTLET;
        $this->_delete_product_attributes($where);
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

    function _get($order_by) {
        $this->load->model('mdl_product');
        $query = $this->mdl_product->_get($order_by);
        return $query;
    }
     function _get_wips_data($order_by,$product_id) {
        $this->load->model('mdl_product');
        $query = $this->mdl_product->_get_wips_data($order_by,$product_id);
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
    function _delete_wips_db($arr_col) {       
        $this->load->model('mdl_product');
        $this->mdl_product->_delete_wips_db($arr_col);
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
}
