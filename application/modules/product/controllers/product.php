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
        $data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby','', 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
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
            $data['selected_navigation'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("product_id"=>$update_id),'id desc','navision_number','wip_attributes','navision_number,status,product_name','1','0','','','')->result_array();
            $data['selected_program'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("ppt_product_id"=>$update_id),'ppt_id desc','ppt_id',DEFAULT_OUTLET.'_product_program_type','ppt_program_id','1','0','','','')->result_array();
        } else {
            $data['news'] = $this->_get_data_from_post();
            $data['selected_program'] = array();
        }
        $data['all_navigation'] =  Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'id desc','navision_number','wip_attributes','navision_number,status,product_name','1','0','','','')->result_array();
        $data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby','', 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin_form($data);
    }
    function submit_wips_replacement_data() {
        $new_wip = $this->input->post('new_wip');
        $old_wip = $this->input->post('old_wip');
        $product_select = $this->input->post('product_select');
        if(!empty($new_wip) && !empty($old_wip)) {
            if($new_wip != $old_wip) {
                $old_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$old_wip),'id desc','navision_number','wip_attributes','product_name,product_name','1','1','','','')->row_array();
                $new_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$new_wip),'id desc','navision_number','wip_attributes','product_id,product_name','1','1','','','')->row_array();
                $new_products = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$new_wip),'id desc','id','wip_attributes','product_id,product_name','1','1','','','')->row_array();
                $previous_navigation = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$old_wip),'id desc','id','wip_attributes','product_id,id','1','0','','','')->result_array();
                if(!empty($previous_navigation)) {
                    foreach ($previous_navigation as $pn_key => $pn):
                        if(empty(in_array($pn['product_id'], $product_select))) {
                            echo "delete<br><br>";
                            Modules::run('api/delete_from_specific_table',array("id"=>$pn['id']),"wip_attributes");
                        }
                    endforeach;
                }
                if(!empty($product_select)) {
                    foreach ($product_select as $ns_key => $ns):
                        $checking = array_search($ns, array_column($previous_navigation, 'product_id'));
                        $new_checking = array_search($ns, array_column($new_products, 'product_id'));
                        if(!is_numeric($checking) && !is_numeric($new_checking)) {
                            $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$ns),'id desc','id',DEFAULT_OUTLET.'_product','navision_no','1','1','','','')->row_array();
                            if(!isset($product_detail['navision_no']))
                                $product_detail['navision_no']="";
                            if(!isset($old_detail['product_name']))
                                $old_detail['product_name']="";
                            Modules::run('api/insert_into_specific_table',array("product_id"=>$ns,"navision_number"=>$old_wip,"product_name"=>$old_detail['product_name'],"parent_navision"=>$product_detail['navision_no'],'status'=>'1'),'wip_attributes');
                        }
                    endforeach;
                }
                Modules::run('api/update_specific_table',array("navision_number"=>$old_wip),array("navision_number"=>$new_wip,'product_name'=>$new_detail['product_name']),'wip_attributes');
                $this->session->set_flashdata('message', 'Wip product replaced successfully');
                $this->session->set_flashdata('status', 'success');
            }
        }
        redirect(ADMIN_BASE_URL.'product/wip_products/');
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
        $update_id = $this->input->post('update_id');
        $old_nav = $this->input->post('old_nav');
        $product_select = $this->input->post('product_select');
        $document_name = $this->input->post('document_name');
        if (is_numeric($update_id) && $update_id != 0) {
            $navision_number = $this->input->post('navision_number');
            $product_name = $this->input->post('product_name');
            $product_select = $this->input->post('product_select');
            $previous_product = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$old_nav),'id desc','id','wip_attributes','product_id,id','1','0','','','')->result_array();
            if(!empty($previous_product)) {
                foreach ($previous_product as $pn_key => $pp):
                    if(empty(in_array($pp['product_id'], $product_select))) {
                        echo "delete<br><br>";
                        Modules::run('api/delete_from_specific_table',array("id"=>$pp['id']),"wip_attributes");
                    }
                endforeach;
            }
            if(!empty($product_select)) {
                foreach ($product_select as $ns_key => $ps):
                    $checking = array_search($ps, array_column($previous_product, 'product_id'));
                    if(!is_numeric($checking)) {
                        $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$ps),'id desc','id',DEFAULT_OUTLET.'_product','navision_no','1','1','','','')->row_array();
                        if(!isset($product_detail['navision_no']))
                            $product_detail['navision_no'] = '';
                        Modules::run('api/insert_into_specific_table',array("product_id"=>$ps,"navision_number"=>$navision_number,"product_name"=>$product_name,"parent_navision"=>$product_detail['navision_no'] ,'status'=>'1'),'wip_attributes');
                    }
                endforeach;
            }
            Modules::run('api/update_specific_table',array("navision_number"=>$old_nav), array("navision_number"=>$navision_number,"product_name"=>$product_name,"document_name"=>$document_name),'wip_attributes');
            $this->session->set_flashdata('message', 'Wip Product Updated');
            $this->session->set_flashdata('status', 'success');
        }
        else {            
            if(!empty($product_select)){
                foreach ($product_select as $key => $ps):
                    $arr_data['product_id'] = $ps;
                    $arr_data['navision_number']= $this->input->post('navision_number');
                    $arr_data['product_name']= $this->input->post('product_name');
                    $arr_data['document_name']= $document_name;
                    $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$ps),'id desc','id',DEFAULT_OUTLET.'_product','product_title','1','1','','','')->row_array();
                    $arr_data['parent_navision'] = $product_detail['product_title'];
                    Modules::run('api/insert_into_specific_table',$arr_data,'wip_attributes');
                endforeach;
                $this->session->set_flashdata('message', 'New Wip Product Saved');
                $this->session->set_flashdata('status', 'success');
            }
        }
        
        redirect(ADMIN_BASE_URL.'product/wip_products/');
    }
     function _get_data_from_db($update_id) {
        $where['product.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['product_title'] = $row->product_title;
            $data['navision_no'] = $row->navision_no;
            $data['brand_name'] = $row->brand_name;
            $data['packaging_type'] = $row->packaging_type;
            $data['storage_type'] = $row->storage_type;
            $data['status'] = $row->status;
            $data['unit_weight'] = $row->unit_weight;
            $data['max_unitweight'] = $row->max_unitweight;
            $data['machine_number'] = $row->machine_number;
            $data['whole_weight'] = $row->whole_weight;
            $data['dough_weight'] = $row->dough_weight;
            $data['filling_weight'] = $row->filling_weight;
            $data['filling_percentage'] = $row->filling_percentage;
            $data['shape'] = $row->shape;
            $data['channel'] = $row->channel;
            $data['shelf_life'] = $row->shelf_life;
            $data['outlet_id'] = $row->outlet_id;

        }
        return $data;
    }
    
    function _get_data_from_post() {
        $data['product_title'] = $this->input->post('product_title');
        $data['navision_no'] = $this->input->post('navision_no');
        $data['brand_name'] = $this->input->post('brand_name');
        $data['unit_weight'] = $this->input->post('unit_weight');
        $data['max_unitweight'] = $this->input->post('max_unitweight');
        $data['machine_number'] = $this->input->post('machine_number');
        $data['whole_weight'] = $this->input->post('whole_weight');
        $data['dough_weight'] = $this->input->post('dough_weight');
        $data['filling_weight'] = $this->input->post('filling_weight');
        $data['filling_percentage'] = $this->input->post('filling_percentage');
        $data['shape'] = $this->input->post('shape');
        $data['channel'] = $this->input->post('channel');
        $data['shelf_life'] = $this->input->post('shelf_life');
        $data['packaging_type'] = $this->input->post('packaging_type');
        $data['storage_type'] = $this->input->post('storage_type');
        $data['outlet_id'] = DEFAULT_OUTLET;
        $data['status'] = $this->input->post('hdnActive');
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
        $program_types = $this->input->post('program_type');
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $this->_get_attribute_data_from_post($update_id);
            $this->session->set_flashdata('message', 'product Data Saved');
	        $this->session->set_flashdata('status', 'success');
            $navigation_select = $this->input->post('navigation_select');
            $previous_navigation = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('product_id'=>$update_id),'id desc','id','wip_attributes','navision_number,id','1','0','','','')->result_array();
            if(!empty($previous_navigation)) {
                foreach ($previous_navigation as $pn_key => $pn):
                    if(empty(in_array($pn['navision_number'], $navigation_select))) {
                        echo "delete<br><br>";
                        Modules::run('api/delete_from_specific_table',array("id"=>$pn['id']),"wip_attributes");
                    }
                endforeach;
            }
            if(!empty($navigation_select)) {
                foreach ($navigation_select as $ns_key => $ns):
                    $checking = array_search($ns, array_column($previous_navigation, 'navision_number'));
                    if(!is_numeric($checking)) {
                        $navigation_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$ns),'id desc','navision_number','wip_attributes','product_name','1','1','','','')->row_array();
                        if(!empty($navigation_detail))
                            Modules::run('api/insert_into_specific_table',array("product_id"=>$update_id,"navision_number"=>$ns,"product_name"=>$navigation_detail['product_name'],"parent_navision"=>$data['product_title'],'status'=>'1'),'wip_attributes');
                    }
                endforeach;
            }
            $previous_program = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('ppt_product_id'=>$update_id),'ppt_id desc','ppt_id',DEFAULT_OUTLET.'_product_program_type','ppt_id,ppt_program_id','1','0','','','')->result_array();
            if(!empty($previous_program)) {
                foreach ($previous_program as $pn_key => $pp):
                    if(empty(in_array($pp['ppt_program_id'], $program_types))) {
                        Modules::run('api/delete_from_specific_table',array("ppt_id"=>$pp['ppt_id']),DEFAULT_OUTLET.'_product_program_type');
                    }
                endforeach;
            }
            if(!empty($program_types)) {
                foreach ($program_types as $pt_key => $pt):
                    $checking = array_search($pt, array_column($previous_program, 'ppt_program_id'));
                    if(!is_numeric($checking)) {
                        Modules::run('api/insert_into_specific_table',array("ppt_product_id"=>$update_id,"ppt_program_id"=>$pt,'ppt_status'=>'1'),DEFAULT_OUTLET.'_product_program_type');
                    }
                endforeach;
            }
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $this->_get_attribute_data_from_post($id);
            $this->session->set_flashdata('message', 'product'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
            $navigation_select = $this->input->post('navigation_select');
            if(!empty($navigation_select)) {
                foreach ($navigation_select as $key => $ns):
                    if(!empty($ns)) {
                        $navigation_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('navision_number'=>$ns),'id desc','navision_number','wip_attributes','product_name','1','1','','','')->row_array();
                        if(!empty($navigation_detail))
                            Modules::run('api/insert_into_specific_table',array("product_id"=>$id,"navision_number"=>$ns,"product_name"=>$navigation_detail['product_name'],"parent_navision"=>$data['product_title'],'status'=>'1'),'wip_attributes');
                    }
                endforeach;
            }
            $previous_program = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('ppt_product_id'=>$id),'ppt_id desc','ppt_id',DEFAULT_OUTLET.'_product_program_type','ppt_id,ppt_program_id','1','0','','','')->result_array();
            if(!empty($previous_program)) {
                foreach ($previous_program as $pn_key => $pp):
                    if(empty(in_array($pp['ppt_program_id'], $program_types))) {
                        Modules::run('api/delete_from_specific_table',array("ppt_id"=>$pp['ppt_id']),DEFAULT_OUTLET.'_product_program_type');
                    }
                endforeach;
            }
            if(!empty($program_types)) {
                foreach ($program_types as $pt_key => $pt):
                    $checking = array_search($pt, array_column($previous_program, 'ppt_program_id'));
                    if(!is_numeric($checking)) {
                        Modules::run('api/insert_into_specific_table',array("ppt_product_id"=>$id,"ppt_program_id"=>$pt,'ppt_status'=>'1'),DEFAULT_OUTLET.'_product_program_type');
                    }
                endforeach;
            }
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
    function wip_products() {
        $data['news'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'id desc','navision_number','wip_attributes','id,navision_number,product_name,status','1','0','','','');
        $data['view_file'] = 'new_wips';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function add_new_wip() {
        $data['update_id'] = $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('id'=>$update_id),'id desc','id','wip_attributes','id,navision_number,product_name,document_name','1','1','','','')->result_array();
            if(isset($data['news'][0]['navision_number']) && $data['news'][0]['navision_number']) {
                $data['selected'] = $this->selected_navigation_products(array('navision_number'=>$data['news'][0]['navision_number']), 'wip_attributes.id desc','wip_attributes.id',DEFAULT_OUTLET,'product_id,navision_no','1','0','','','')->result_array();
            }
            else
                $data['selected'] = array();
        }
        $data['products'] = Modules::run('api/_get_specific_table_with_pagination',array('status'=>'1'), 'product_title asc',DEFAULT_OUTLET.'_product','id,navision_no,product_title,status','1','0')->result_array();
        $data['view_file'] = 'wip_form';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function replace_wip_product() {
        $data['all_navigation'] =  Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'id desc','navision_number','wip_attributes','navision_number,status,product_name','1','0','','','')->result_array();
        $data['view_file'] = 'replace_wip_product';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function get_old_wip_products() {
        $navigation = $this->input->post('testing');
        $data['selected'] = $this->selected_navigation_products(array('navision_number'=>$navigation), 'wip_attributes.id desc','wip_attributes.id',DEFAULT_OUTLET,'product_id','1','0','','','')->result_array();
        $data['products'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'product_title asc',DEFAULT_OUTLET.'_product','id,product_title,status','1','0')->result_array();
        $this->load->view('multi_product_select',$data);
    }
    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
        $wherer['product_id'] =$delete_id;
        $wherer['outlet_id'] = DEFAULT_OUTLET;
        $this->_delete_product_attributes($wherer);
        $this->_delete_wips_db(array('product_id'=>$delete_id));
    }
    function delete_wips(){
        $delete_id = $this->input->post('id'); 
        if(!empty($delete_id))
            Modules::run('api/delete_from_specific_table',array("navision_number"=>$delete_id),'wip_attributes');
    }
	function checking_navigation_name() {
        $status = 0;
        $update_id = $this->input->post('updation');
        $nav_name = strtolower($this->input->post('nav_name'));
        if(!empty($update_id)) {
            $get_navision = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$update_id),'id desc','id','wip_attributes','navision_number','1','1','','','')->row_array();
            if(!isset($get_navision['navision_number']))
                $get_navision['navision_number'] = '';
            if(strtolower($get_navision['navision_number']) != $nav_name) {
                $checking = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("LOWER(navision_number)"=>$nav_name),'id desc','id','wip_attributes','id','1','0','','','')->num_rows();
                if($checking > 0)
                    $status = 1;
            }
        }
        else {
            $checking = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("LOWER(navision_number)"=>$nav_name),'id desc','id','wip_attributes','id','1','0','','','')->num_rows();
            if($checking > 0)
                $status = 1;
        }
        echo $status;
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
    function wip_change_status() {
        print_r($_POST);
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('status' => $status);
        $status = Modules::run('api/update_specific_table',array("navision_number"=>$id), $data,'wip_attributes');
        echo $status;
    }
    function detail() {
        $update_id = $this->input->post('id');
       // $lang_id = $this->input->post('lang_id');
    	$data['program_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby','', 'program_types.name asc','program_types.id',DEFAULT_OUTLET.'_program_types as program_types','program_types.id as program_id,program_types.name as program_name, program_types.status as program_status','1','0','','','')->result_array();
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
    function selected_navigation_products($cols, $order_by,$group_by='',$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $this->load->model('mdl_product');
        $query = $this->mdl_product->selected_navigation_products($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having);
        return $query;
    }
}
