<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_scheduled_checks extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = DEFAULT_OUTLET."_product_checks";
        return $table;
    }
    function get_table_attribute(){
        $table =  DEFAULT_OUTLET."_product_checks";
        return $table;
    }
    
    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
     function _get($order_by,$where) {
        $table = DEFAULT_OUTLET."_product_checks product_checks";
        $product_table= DEFAULT_OUTLET."_product product";
        $this->db->select('product_checks.*,product.product_title,product.navision_no,catagories.cat_name');
        $this->db->join( $product_table, 'product_checks.productid = product.id' , 'left');
        $this->db->join('catagories', 'product_checks.check_cat_id = catagories.id' , 'left');
        $this->db->order_by('product_checks.id desc');
        if(!empty($where))
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query;
    }
    function get_responsible_team($checkid){
        $table = DEFAULT_OUTLET."_groups groups";
        $team= DEFAULT_OUTLET."_product_checksteam checksteam";
        $this->db->select('groups.group_title');
        $this->db->join($team, 'checksteam.group_id = groups.id' , 'left');
        $this->db->where('checksteam.checkid',$checkid);
        $query = $this->db->get($table);
        return $query;
    }
    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _update($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }
       function _update_id($id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }

    function _delete($arr_col) {       
        $table = DEFAULT_OUTLET."_product_checks";
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
    function check_if_exists($arr_col){
        $table = $this->get_table();
        $this->db->where($arr_col);
       return $this->db->get($table);
    }
    function check_atrribute_exists($arr_col){
        $table =  DEFAULT_OUTLET."_product_attributes";
        $this->db->where($arr_col);
       return $this->db->get($table);
    }
    function insert_attribute_data($data){
         $table = DEFAULT_OUTLET."_product_check_attribute";
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
      function get_attriutes_list($product_id){
       $table = DEFAULT_OUTLET."_checks_answers checks_answers";
        $product_table= DEFAULT_OUTLET."_checks_questions checks_questions";
        $this->db->from(DEFAULT_OUTLET."_checks_questions checks_questions");
        $this->db->select('checks_questions.question_id,checks_questions.page_rank,check_catagories_attributes.id,check_catagories_attributes.attribute_name as attribute_name,check_catagories_attributes.attribute_name,check_catagories_attributes.possible_answers , check_catagories_attributes.attribute_type as attribute_type,checks_answers.min,checks_answers.max,checks_answers.target');
        $this->db->join( $table, 'checks_questions.question_id = checks_answers.question_id' , 'left');
        $this->db->join('check_catagories_attributes', 'check_catagories_attributes.attribute_name = checks_questions.question' , 'left');
        $this->db->join(DEFAULT_OUTLET."_product_checks product_checks", 'check_catagories_attributes.check_cat_id = product_checks.check_subcat_id' , 'left');
        $this->db->order_by('checks_questions.question_id asc');
        ///if(!empty($where))
        $this->db->where('checks_questions.checkid',$product_id);
        $this->db->where('product_checks.id',$product_id);
        $query = $this->db->get();
      
        return $query;
      }
      function   _delete_product_attributes($arr_col){
        $table =  $this->get_table_attribute();
        $this->db->where($arr_col);
        $this->db->delete($table);
      }
        function update_attribute_data($where,$attribute_data){
                 $table = DEFAULT_OUTLET."_product_attributes";
                 $this->db->where($where);
                 $this->db->update($table, $attribute_data);
        }
        function get_products_list_from_db($arr_col){
            $table = DEFAULT_OUTLET."_product";
            $this->db->where($arr_col);
            return $this->db->get($table);
        }
        function _get_by_arr_id_product_info($arr_col){
                $table = DEFAULT_OUTLET."_product";
                $this->db->where($arr_col);
                return $this->db->get($table);
        }
        function delete_checks_team($arr_col){
            $table =  DEFAULT_OUTLET."_product_checksteam";
            $this->db->where($arr_col);
            $this->db->delete($table);
        }
          function insert_checkteam_data($data){
         $table = DEFAULT_OUTLET."_product_checksteam";
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function get_checkteam_list($arr_col){
        $table =  DEFAULT_OUTLET."_product_checksteam";
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
    function insert_check_questions_db($data){
        $table = DEFAULT_OUTLET."_checks_questions";
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_question_answer_data($data){
         $table = DEFAULT_OUTLET."_checks_answers";
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function delete_checks_question_from_db($where){
        $table =  DEFAULT_OUTLET."_checks_questions";
        $this->db->where($where);
        $this->db->delete($table);
    }
     function delete_checks_answers_from_db($where){
        $table =  DEFAULT_OUTLET."_checks_answers";
        $this->db->where($where);
        $this->db->delete($table);
    }
     //////////////////////////// Gneral Checks funstions//////////
    function get_type_general_check($where){

        $table = "catagories";
        $this->db->where($where);
        return $this->db->get($table);
    }
     function update_general_check_attribute_data($where,$attribute_data){
                 $table ="check_catagories_attributes";
                 $this->db->where($where);
                 $this->db->update($table, $attribute_data);
        }
 function insert_or_update($where,$data,$table) {
            $insert_id = 0;
            if(!empty($where))
                $this->db->where($where);
            $query=$this->db->get($table);
            //$querys=$this->db->get($table);
            if($query->num_rows() > 0) {
                $array=$query->row_array();
                $insert_id=$array['question_id'];
               
              if(!empty($where))
                $this->db->where($where);
                $this->db->update($table, $data);
            }
            else {
              $this->db->insert($table, $data);
              $insert_id = $this->db->insert_id();
            }
            return $insert_id; 
        }
}