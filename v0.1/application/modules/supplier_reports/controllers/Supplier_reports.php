<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supplier_reports extends MX_Controller
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
    	$data['supplier'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1"),'id desc','id','supplier','id,name','1','0','','','')->result_array();
    	$data['ingredients'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1"),'id desc','id',DEFAULT_OUTLET.'_ingredients','id,item_name','1','0','','','')->result_array();
        $data['ing_type'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1"),'id desc','id','ingredient_types','name,id','1','0','','','')->result_array();
        $data['choice_questions'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1","del_status"=>"0","type"=>"choice"),'id desc','id','ing_form_questions','title,id','1','0','','','')->result_array();
        $quest = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1","del_status"=>"0","title"=>"Country of origin"),'id desc','id','ing_form_questions','id','1','0','','','')->row_array();
        $data['country'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("del_status"=>"0","quest_id"=>$quest['id']),'id desc','id','ing_form_options','id,option','1','0','','','')->result_array();
        $quest = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status"=>"1","del_status"=>"0","title"=>"Allergen"),'id desc','id','ing_form_questions','id','1','0','','','')->row_array();
        $data['allergens'] = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("del_status"=>"0","quest_id"=>$quest['id']),'id desc','id','ing_form_options','id,option','1','0','','','')->result_array();
        
        
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function search()
    {
        $where=array();
        parse_str($_POST['form_data'], $formdata);
        $data['option']=$formdata['options'];
        $supplier=$supplier_type=$status=$ingredient=$ingredient_type="";
        if(!empty($formdata['supplier']))
            $supplier=$formdata['supplier'];
        if(!empty($formdata['supplier_type']))
            $supplier_type=$formdata['supplier_type'];
        if(!empty($formdata['product']))
            $product=$formdata['product'];
        if(!empty($formdata['country']))
            $country=$formdata['country'];
        if(!empty($formdata['allergens']))
            $allergens=$formdata['allergens'];
        if(!empty($formdata['status']))
        {
            if($formdata['status']=="inactive")
                $where['supplier.status']="0";
            else
                $where['supplier.status']="1";
        }
        if(!empty($formdata['ingredient']))
            $ingredient=$formdata['ingredient'];
        if(!empty($formdata['ingredient_type']))
            $ingredient_type=$formdata['ingredient_type'];
        if(empty($product) && empty($country) && empty($allergens)){
            if(!empty($supplier))
            $where['supplier.id']=$supplier;
            if(!empty($supplier_type))
                $where[DEFAULT_OUTLET.'_ingredients_supplier.role']=$supplier_type;
            if(!empty($ingredient))
                $where[DEFAULT_OUTLET.'_ingredients_supplier.ingredient_id']=$ingredient;
            if(!empty($ingredient_type))
            {
                $where[DEFAULT_OUTLET.'_assigned_ingredient_types.type_id']=$ingredient_type;
                $data['result'] = $this->get_supplier_detail_ingredients($where,"supplier.*, ingredient_types.name as type_name,item_no,item_name,plm_no,role,s_item_name,s_item_no","supplier.id desc,".DEFAULT_OUTLET."_ingredients.id as ing_id","","supplier",DEFAULT_OUTLET."_ingredients_supplier","supplier.id",DEFAULT_OUTLET."_ingredients_supplier.supplier_id",DEFAULT_OUTLET."_ingredients",DEFAULT_OUTLET."_ingredients_supplier.ingredient_id",DEFAULT_OUTLET."_ingredients.id")->result_array();
            }
            else
            {
                $data['result'] = $this->get_supplier_detail($where,"supplier.*,item_no,item_name,plm_no,role,s_item_name,s_item_no,".DEFAULT_OUTLET."_ingredients.id as ing_id","supplier.id desc","","supplier",DEFAULT_OUTLET."_ingredients_supplier","supplier.id",DEFAULT_OUTLET."_ingredients_supplier.supplier_id",DEFAULT_OUTLET."_ingredients",DEFAULT_OUTLET."_ingredients_supplier.ingredient_id",DEFAULT_OUTLET."_ingredients.id")->result_array();
                foreach($data['result'] as $k => $v):
                    $data['result'][$k]['type_name']="";
                    if(!empty($v['ing_id'])){
                        $new_name="";
                        $selected_type = Modules::run('ingredients/_get_data_from_db_table',array("ingredient_id"=>$v['ing_id']),DEFAULT_OUTLET.'_assigned_ingredient_types',"","","type_id","")->result_array();
                        foreach($selected_type as $key => $val):
                            $type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$val['type_id']),'id desc','id',' ingredient_types','name','1','0','','','')->row_array();
                            $new_name=$new_name.",".$type['name'];
                        endforeach;
                        $data['result'][$k]['type_name']=$new_name;
                    }
                endforeach;
            }  
        }else{
            $or_where=array();
            
            if(!empty($allergens) && !empty($country))
            {
                $or_where="`ing_form_options_ans`.`option` = '".$country."' OR `ing_form_options_ans`.`option`='".$allergens."'";
            }
            else
            {
                if(!empty($country))
                    $where['ing_form_options_ans.option']=$country;
                if(!empty($allergens))
                    $where['ing_form_options_ans.option']=$allergens;
            }
            if(!empty($product)){
                $where['ing_form_ans.quest_id']=$product;
                $where['ing_form_options_ans.option']="1";
            }
            if(!empty($supplier))
            $where['supplier.id']=$supplier;
            if(!empty($ingredient))
                $where[DEFAULT_OUTLET.'_ingredients.id']=$ingredient;


            $data['result'] = $this->get_ingredient_form_detail($where,$or_where,"supplier.*,item_no,item_name,plm_no,".DEFAULT_OUTLET."_ingredients.id as ing_id","supplier.id desc"," ing_form_ans.supplier_id,  ing_form_ans.ing_id","supplier",DEFAULT_OUTLET."_ingredients_supplier","supplier.id",DEFAULT_OUTLET."_ingredients_supplier.supplier_id",DEFAULT_OUTLET."_ingredients",DEFAULT_OUTLET."_ingredients_supplier.ingredient_id",DEFAULT_OUTLET."_ingredients.id")->result_array();
            foreach($data['result'] as $k => $v):
                $data['result'][$k]['type_name']="";
                if(!empty($v['ing_id'])){
                    $new_name="";
                    $selected_type = Modules::run('ingredients/_get_data_from_db_table',array("ingredient_id"=>$v['ing_id']),DEFAULT_OUTLET.'_assigned_ingredient_types',"","","type_id","")->result_array();
                    foreach($selected_type as $key => $val):
                        $type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$val['type_id']),'id desc','id',' ingredient_types','name','1','0','','','')->row_array();
                        $new_name=$new_name.",".$type['name'];
                    endforeach;
                    $data['result'][$k]['type_name']=$new_name;
                }
                if(!empty($v['ing_id']) && !empty($v['id'])){
                    $res = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("ingredient_id" =>$v['ing_id'],"supplier_id"=>$v['id']),'id desc','id',DEFAULT_OUTLET."_ingredients_supplier",'*','1','0','','','')->row_array();
                    $data['result'][$k]['role']=$res['role'];
                    $data['result'][$k]['s_item_name']=$res['s_item_name'];
                    $data['result'][$k]['s_item_no']=$res['s_item_no'];
                }

            endforeach;
     }  
        $this->load->view('tableview',$data);
    }
    
    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
            $selected_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("doc_id" =>$update_id),'id desc','id','doc_supplier_types','id,supplier_type','1','0','','','')->result_array();
            if(!empty($selected_type)) {
                $temp= array();
                foreach ($selected_type as $key => $gp):
                    $temp[$gp['id']] = $gp['supplier_type'];
                endforeach;
                $selected_type = $temp;
            }
            $data['selected_type']=$selected_type;
            $data['selected_ing_type']=array();
            $selected_ing_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("doc_id" =>$update_id),'id desc','id','doc_ingredient_types','id,ing_type','1','0','','','')->result_array();
            if(!empty($selected_ing_type)) {
                $temp= array();
                foreach ($selected_ing_type as $key => $gp):
                    $temp[$gp['id']] = $gp['ing_type'];
                endforeach;
                $selected_ing_type = $temp;
            }
            $data['selected_ing_type']=$selected_ing_type;
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','ingredient_types','id,name','1','0','','','')->result_array();
        $data['type'] = $type;    
        $supplier_type = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("status" =>'1'),'id desc','id','supplier_type','id,name','1','0','','','')->result_array();
        $data['supplier_type'] = $supplier_type;
        $data['level']=array("Mandatory"=>"Mandatory","Not Mandatory"=>"Not Mandatory");
        $data['assign']=array("supplier"=>"Supplier","ingredient"=>"Ingredient");
        $data['doc_type']=array("location specific"=>"Location Specific","ingredient specific"=>"Ingredient Specific");
        $data['type'] = $type;    
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
 
    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as $row) {
            $data['doc_name'] = $row->doc_name;
            $data['type_id'] = $row->type_id;
            $data['level'] = $row->level;
            $data['assign_to'] = $row->assign_to;
            $data['doc_type'] = $row->doc_type;
            $data['supplier_type'] = $row->supplier_type;
            $result = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$data['type_id']),'id desc','id','ingredient_types','name','1','0','','','')->row_array();
            $data['type_name'] = "None";
            if(isset($result['name']) && !empty($result['name']))
            $data['type_name'] = $result['name'];
            $result = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id" =>$data['supplier_type']),'id desc','id','supplier_type','name','1','0','','','')->row_array();
            $data['supplier_type_name'] = "None";
            if(isset($result['name']) && !empty($result['name']))
            $data['supplier_type_name'] = $result['name'];
        }
        return $data;
    }
    function _get_data_from_post() {
        $data['doc_name'] = $this->input->post('doc_name');
        $data['level'] = $this->input->post('level');
        $data['assign_to'] = $this->input->post('assign_to');
        $data['doc_type'] = $this->input->post('doc_type');
        if($data['assign_to']=="supplier")
        {
            $data['type_id'] = "0";
        }
        return $data;
    }

	function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();
        if (is_numeric($update_id) && $update_id != 0) {
            $where['id'] = $update_id;
            $this->_update($where, $data);
            Modules::run('api/delete_from_specific_table',array("doc_id"=>$update_id),'doc_supplier_types');
            $where_arr['doc_id'] = $update_id;
            $supplier_type = $this->input->post('supplier_type');
            if(!empty($supplier_type)) {
                foreach ($supplier_type as $key => $it):
                    Modules::run('api/insert_or_update',array("doc_id"=>$update_id,"supplier_type"=>$it),array("doc_id"=>$update_id,"supplier_type"=>$it),'doc_supplier_types');
                endforeach;
            }
            $type_id = $this->input->post('type_id');
            if(!empty($type_id)) {
                foreach ($type_id as $key => $it):
                    Modules::run('api/insert_or_update',array("doc_id"=>$update_id,"ing_type"=>$it),array("doc_id"=>$update_id,"ing_type"=>$it),'doc_ingredient_types');
                endforeach;
            }
            $this->session->set_flashdata('message', 'document Data Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        if (is_numeric($update_id) && $update_id == 0) {
            $id = $this->_insert($data);
            $supplier_type = $this->input->post('supplier_type');
            if(!empty($supplier_type)) {
                foreach ($supplier_type as $key => $it):
                    Modules::run('api/insert_or_update',array("doc_id"=>$id,"supplier_type"=>$it),array("doc_id"=>$id,"supplier_type"=>$it),'doc_supplier_types');
                endforeach;
            }
            $this->session->set_flashdata('message', 'document'.' Saved');
	        $this->session->set_flashdata('status', 'success');
        }
        redirect(ADMIN_BASE_URL . 'document');
    }
    function delete() {
        $delete_id = $this->input->post('id');  
        $where['id'] = $delete_id;
        $this->_delete($where);
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
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_supplier_reports');
        return $this->mdl_supplier_reports->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_supplier_reports');
        $query = $this->mdl_supplier_reports->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_supplier_reports');
        return $this->mdl_supplier_reports->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_supplier_reports');
        return $this->mdl_supplier_reports->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_supplier_reports');
        $this->mdl_supplier_reports->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_supplier_reports');
        $this->mdl_supplier_reports->_update_id($id, $data);
    }

    function _delete($arr_col) {       
        $this->load->model('mdl_supplier_reports');
        $this->mdl_supplier_reports->_delete($arr_col);
    }

    function check_atrribute_exists($arr_col,$table){
        $this->load->model('mdl_supplier_reports');
        return $this->mdl_supplier_reports->check_atrribute_exists($arr_col,$table);
    }
    function insert_attribute_data($data,$table){
        $this->load->model('mdl_supplier_reports');
       return $this->mdl_supplier_reports->insert_attribute_data($data,$table);
    }
    function update_attribute_data($where,$attribute_data,$table){
        $this->load->model('mdl_supplier_reports');
       return $this->mdl_supplier_reports->update_attribute_data($where,$attribute_data,$table);
    }
    function delete_from_table($where,$table)
    {
        $this->load->model('mdl_supplier_reports');
        $this->mdl_supplier_reports->delete_from_table($where,$table);
    }
    function get_supplier_detail($where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1){
        $this->load->model('mdl_supplier_reports');
       return $this->mdl_supplier_reports->get_supplier_detail($where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1);
    }
    function get_supplier_detail_ingredients($where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1){
        $this->load->model('mdl_supplier_reports');
       return $this->mdl_supplier_reports->get_supplier_detail_ingredients($where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1);
    }
    function get_ingredient_form_detail($where,$or_where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1){
        $this->load->model('mdl_supplier_reports');
       return $this->mdl_supplier_reports->get_ingredient_form_detail($where,$or_where,$select,$order_by,$group_by,$table,$join_table,$table_attr,$join_attr,$join_table1,$table_attr1,$join_attr1);
    }
    
}
