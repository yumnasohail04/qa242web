<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ingredients extends MX_Controller
{

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');
date_default_timezone_set("Asia/karachi");
}

    function index() {

     
        $this->manage();
    }
    function manage() {
        $data['news'] = $this->_get('id desc')->result_array();
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function create(){
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $data['selected_type'] = $this->_get_data_from_db_table(array("ingredient_id"=>$update_id),DEFAULT_OUTLET.'_assigned_ingredient_types',"","","type_id","")->result_array();
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $group = Modules::run('api/_get_specific_table_with_pagination',array(), 'id asc','supplier','id,name','1','0')->result_array();
        if(!empty($group)) {
            $temp= array();
            foreach ($group as $key => $gp):
                $temp[$gp['id']] = $gp['name'];
            endforeach;
            $groups = $temp;
        }
        $data['groups'] = $groups;
        $data['group'] = $group;
        $data['type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','ingredient_types','id,name','1','0','','','')->result_array();
        $data['type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','ingredient_types','id,name','1','0','','','')->result_array();
        $data['selected_supplier'] = $this->_get_data_from_db_table_supplier_name(array("ingredient_id"=>$update_id))->result_array();
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function edit_supplier_item(){
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['selected_supplier'] = $this->_get_data_from_db_table(array("ingredient_id"=>$update_id),DEFAULT_OUTLET.'_ingredients_supplier',"","","id,supplier_id,role,s_item_no,s_item_name,ingredient_id","")->result_array();
        } 
        $group = Modules::run('api/_get_specific_table_with_pagination',array(), 'id asc','supplier','id,name','1','0')->result_array();
        if(!empty($group)) {
            $temp= array();
            foreach ($group as $key => $gp):
                $temp[$gp['id']] = $gp['name'];
            endforeach;
            $groups = $temp;
        }
        $data['groups'] = $groups;
        $data['group'] = $group;
        $data['type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','ingredient_types','id,name','1','0','','','')->result_array();
        $data['role']=array("primary"=>"primary","secondary"=>"secondary");
        $data['update_id'] = $update_id;
        $data['view_file'] = 'ingrefient_linkage';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function supplier_item() {
        $data['news'] = $this->_get('id desc')->result_array();
        $data['view_file'] = 'supplier_items';
        $this->load->module('template');
        $this->template->admin($data);
    }
     function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['item_no'] = $row->item_no;
            $data['item_name'] = $row->item_name;
            $data['plm_no'] = $row->plm_no;
        }
        return $data;
    }
    function get_doc_name()
    {
        $doc=array();
        $type_id=$this->input->post('type_id');
        foreach($type_id as $key => $value)
        {
            $result = $this->_get_data_from_db_table(array("type_id"=>$value,"assign_to"=>"ingredient","status"=>"1"),'document',"","","doc_name","")->result_array();
            if(!empty($result))
            {
                foreach($result as $key => $value)
                {
                    $doc[]=$value['doc_name'];
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array("doc"=>$doc));
    }
      function delete_attributes() {
        $delete_id = $this->input->post('id');  
        $ingredientid = $this->input->post('ingredientid');  
        $where['id'] = $delete_id;
        $where['ingredient_id'] = $ingredientid;
        $this->delete_from_table($where,DEFAULT_OUTLET.'_ingredients_supplier');
    }
    function _get_data_from_post() {
        $data['item_no'] = $this->input->post('item_no');
        $data['item_name'] = $this->input->post('item_name');
        $data['plm_no'] = $this->input->post('plm_no');
        return $data;
    }
    function _get_supplier_data_from_post($update_id) {
        $supplier_name= $this->input->post('supplier_name');
        $role=$this->input->post('role');
        $s_item_name=$this->input->post('s_item_name');
        $s_item_no=$this->input->post('s_item_no');
        $total=count($supplier_name);
        if(isset($supplier_name) && !empty($supplier_name)){
        for ($i=0; $i <$total; $i++) {
            $where_attr['ingredient_id']=$update_id;
            $where_attr['supplier_id']=$supplier_name[$i];
            $arr_attr_data= $this->check_atrribute_exists($where_attr,DEFAULT_OUTLET.'_ingredients_supplier')->result_array();
            if(empty($arr_attr_data)){
            $arr_attribute['ingredient_id']=$update_id;
            $arr_attribute['supplier_id']=$supplier_name[$i];
            $arr_attribute['role']=$role[$i];
            $arr_attribute['s_item_name']=$s_item_name[$i];
            $arr_attribute['s_item_no']=$s_item_no[$i];
            $attribute_ids[]=$this->insert_attribute_data($arr_attribute,DEFAULT_OUTLET.'_ingredients_supplier');
            }
            elseif(!empty($arr_attr_data)){
                  $where['id']=$arr_attr_data[0]['id'];
                  $attribute_data['s_item_name']=$s_item_name[$i];
                  $attribute_data['s_item_no']=$s_item_no[$i];
                  $attribute_ids=$this->update_attribute_data($where,$attribute_data,DEFAULT_OUTLET.'_ingredients_supplier');

            }
            
        }
     }
  }
    function import_file(){
        
        $data['view_file'] = 'fileupload';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function submit_csv(){
      $this->load->library('PHPExcel');
      $ext = pathinfo($_FILES['csvfile']['name'], PATHINFO_EXTENSION);
        if($ext=="xls" || $ext=="xlsx"){
          $path = $_FILES['csvfile']['tmp_name'];
          $object = PHPExcel_IOFactory::load($path);
          foreach($object->getWorksheetIterator() as $worksheet):
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for($row=2; $row<=$highestRow; $row++) {
              $storing_check = true;
              $NAV_Number = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
              $RM_PLM_Number = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
              $Raw_Material_Name = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
              $priority = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
              $supplier_Item_Name= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
              $Supplier_Item_Number= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
              $Supplier= $worksheet->getCellByColumnAndRow(8, $row)->getValue();
              $Supplier=preg_match('/[^A-Za-z0-9\-]/', '', $Supplier);
              $ing_data['item_no']=$NAV_Number;
              $ing_data['item_name']=$Raw_Material_Name;
              $ing_data['plm_no']=$RM_PLM_Number;
              $ing_data['status']=1;
              $arr_where['item_no']=$NAV_Number;
              $check_arr=$this->check_if_exists($arr_where,DEFAULT_OUTLET."_ingredients")->result_array();
              if(!empty($check_arr)){
                $ing_id=$check_arr[0]['id'];
              }
              if(isset($check_arr) && empty($check_arr)){
                $ing_id=$this->_insert($ing_data);
              }
              if(!empty($priority)){
                  $supplier = $this->_get_data_from_db_table(array("name"=>$Supplier),'supplier',"","","id","")->result_array();
                    if(!empty($supplier)){
                        $where_attr['ingredient_id']=$ing_id;
                        $where_attr['supplier_id']=$supplier[0]['id'];
                        $arr_attr_data= $this->check_atrribute_exists($where_attr,DEFAULT_OUTLET.'_ingredients_supplier')->result_array();
                        if(empty($arr_attr_data)){
                        $arr_attribute['ingredient_id']=$ing_id;
                        $arr_attribute['supplier_id']=$supplier[0]['id'];
                        $arr_attribute['role']=strtolower($priority);
                        $arr_attribute['s_item_name']=$supplier_Item_Name;
                        $arr_attribute['s_item_no']=$Supplier_Item_Number;
                        $attribute_ids=$this->insert_attribute_data($arr_attribute,DEFAULT_OUTLET.'_ingredients_supplier');
                        }
                    }
              }
                $this->session->set_flashdata('message', 'Ingredients File Uploaded ');                                        
                $this->session->set_flashdata('status', 'success');
            }
          endforeach;
        }
        else{
            $this->session->set_flashdata('message', "Invalid file format");                                        
            $this->session->set_flashdata('status', 'success');
            }
        redirect(ADMIN_BASE_URL . 'ingredients');
    }
	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            $this->delete_from_table(array("ingredient_id"=>$update_id),DEFAULT_OUTLET.'_assigned_ingredient_types');
            $selected_type= $this->input->post('type');
            if(!empty($selected_type)){
                 foreach($selected_type as $key => $value)
                {
                    $type['ingredient_id']=$update_id;
                    $type['type_id']=$value;
                    $this->_insert_data($type,DEFAULT_OUTLET.'_assigned_ingredient_types');
                }
            }
            $this->session->set_flashdata('message', 'Ingredients Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $selected_type= $this->input->post('type');
            if(!empty($selected_type)){
                 foreach($selected_type as $key => $value)
                {
                    $supply['ingredient_id']=$update_id;
                    $supply['type_id']=$value;
                    $this->_insert_data($supply,DEFAULT_OUTLET.'_assigned_ingredient_types');
                }
            }
           
            $this->session->set_flashdata('message', 'Ingredients '.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'ingredients');
    }
    function submit_supplier_item() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $this->_get_supplier_data_from_post($update_id);
            $this->session->set_flashdata('message', 'Supplier Item saved');
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'ingredients/supplier_item');
    }
     function upload_dynamic_image($actual,$nId,$input_name,$image_field,$image_id_fild,$table,$doc_id,$supp_id) {
        $upload_image_file = $_FILES[$input_name]['name'];
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'Ingredient_doc' . $nId.'_'.$doc_id. '_' . $upload_image_file;
        $config['upload_path'] = $actual;
        $config['allowed_types'] = 'pdf|xlsx|docx|PDF|XLSX|DOCX|TXT|txt';
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
        unset($data);unset($where);
        $data = array($image_field => $file_name,"ingredient_id"=>$nId,"document_id"=>$doc_id,"supplier_id"=>$supp_id);
        $this->insert_or_update_user_review($data,$table);
    }
       function delete_images_by_name($actual_path,$name) {
        if (file_exists($actual_path.$name))
            unlink($actual_path.$name);
    }
  
    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
        $this->delete_from_table(array("ingredient_id"=>$delete_id),DEFAULT_OUTLET.'_ingredients_supplier');
        $this->delete_from_table(array("ingredient_id"=>$delete_id),DEFAULT_OUTLET.'_ingredients_document');
    }
    function delete_doc()
    {
        $delete_id = $this->input->post('doc_id');  
        $doc = $this->_get_data_from_db_table(array("id"=>$delete_id),DEFAULT_OUTLET.'_ingredients_document',"","","document","")->result_array();
        if (file_exists(INGREDIENT_DOCUMENTS_PATH.$doc[0]['document']))
            unlink(INGREDIENT_DOCUMENTS_PATH.$doc[0]['document']);
        $this->delete_from_table(array("id"=>$delete_id),DEFAULT_OUTLET.'_ingredients_document');
        
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
        $data['post'] = $this->_get_data_from_db($update_id);
        $data['ingredient_type'] = $this->_get_data_from_db_table_type(array("ingredient_id"=>$update_id))->result_array();
        $data['supplier'] = $this->_get_data_from_db_table_supplier(array("ingredient_id"=>$update_id))->result_array();
        foreach($data['supplier'] as $key =>$value){
            $data['supplier'][$key]['sub'] = $this->_get_data_from_db_table_document(array("ingredient_id"=>$update_id,"supplier_id"=>$value['supplier_id']))->result_array();
        }
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_ingredients');
        $query = $this->mdl_ingredients->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_ingredients');
        $this->mdl_ingredients->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_ingredients');
        $this->mdl_ingredients->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_ingredients');
        $this->mdl_ingredients->_delete($arr_col);
    }
    function _insert_data($data,$table){
        $this->load->model('mdl_ingredients');
        $this->mdl_ingredients->_insert_data($data,$table);
    }
    function _get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit)
    {
        $this->load->model('mdl_ingredients');
        return  $this->mdl_ingredients->_get_data_from_db_table($where,$table,$order_by,$group_by,$select,$limit);
    }
    function delete_from_table($where,$table)
    {
        $this->load->model('mdl_ingredients');
        $this->mdl_ingredients->delete_from_table($where,$table);
    }
     function insert_or_update_user_review($data,$table){
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->insert_or_update_user_review($data,$table);
    }
    function _get_data_from_db_table_supplier($where)
    {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_get_data_from_db_table_supplier($where);
    }
    function _get_data_from_db_table_supplier_name($where)
    {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_get_data_from_db_table_supplier_name($where);
    }
    function _get_data_from_db_table_document($where)
    {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_get_data_from_db_table_document($where);
    }
    function _get_data_from_db_table_wip($where)
    {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_get_data_from_db_table_wip($where);
    }
    function check_atrribute_exists($arr_col,$table){
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->check_atrribute_exists($arr_col,$table);
    }
    function insert_attribute_data($data,$table){
        $this->load->model('mdl_ingredients');
       return $this->mdl_ingredients->insert_attribute_data($data,$table);
    }
    function update_attribute_data($where,$attribute_data,$table){
        $this->load->model('mdl_ingredients');
       return $this->mdl_ingredients->update_attribute_data($where,$attribute_data,$table);
    }
    function _get_data_from_db_table_type($where)
    {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->_get_data_from_db_table_type($where);
    }
    function check_if_exists($arr_where,$table)
    {
        $this->load->model('mdl_ingredients');
        return $this->mdl_ingredients->check_if_exists($arr_where,$table);
    }
}
