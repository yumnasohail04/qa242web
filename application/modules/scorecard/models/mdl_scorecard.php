<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_scorecard extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function get_table() {
        $table = "scorecard";
        return $table;
    }
    
    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
     function _get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }
    function get_scorecard_list($where)
    {
        $table = DEFAULT_OUTLET."_scorecard_team_assign";
        $table1 = DEFAULT_OUTLET."_scorecard_assignment";
        $table2 = DEFAULT_OUTLET."_groups";
        $this->db->select("supplier.name,$table1.create_date,$table.id,$table2.group_title");
        $this->db->from($table);
        $this->db->order_by("$table.id desc");
        $this->db->join("$table1","$table.sc_id=$table1.id","LEFT");
        $this->db->join("supplier","$table1.supplier_id=supplier.id","LEFT");
        $this->db->join("$table2","$table.team_id=$table2.id","LEFT");
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
    function get_review_teams_result($id)
    {
        $table = DEFAULT_OUTLET."_scorecard_team_assign";
        $table1 = DEFAULT_OUTLET."_groups";
        $this->db->select("$table.percentage,$table.reviewed_date,$table1.group_title,users.first_name,users.last_name");
        $this->db->from($table);
        $this->db->order_by("$table.id desc");
        $this->db->join("$table1","$table.team_id=$table1.id","LEFT");
        $this->db->join("users","$table.review_user=users.id","LEFT");
        $this->db->where("sc_id",$id);
        $query = $this->db->get();
        return $query;
    }
    function pending_scorecard_list($where)
    {
        $table = DEFAULT_OUTLET."_scorecard_assignment";
        $this->db->select("supplier.name,$table.create_date,$table.id");
        $this->db->from($table);
        $this->db->order_by("$table.id desc");
        $this->db->join("supplier","$table.supplier_id=supplier.id","LEFT");
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
    function get_card_questions($id)
    {
        $table = DEFAULT_OUTLET."_scorecard_team_assign";
        $table1 = DEFAULT_OUTLET."_scorecard_assign_questions";
        $table2 = DEFAULT_OUTLET."_scorecard_form_question";
        $this->db->select("$table1.question,$table2.sfq_description,$table2.sfq_id");
        $this->db->from($table);
        $this->db->where("$table.id",$id);
        $this->db->join("$table1","$table.id=$table1.tassign_id","LEFT");
        $this->db->join("$table2","$table1.question_id=$table2.sfq_id","LEFT");
        $this->db->where("$table2.sfq_delete","0");
        $query = $this->db->get();
        return $query;
    }
    function get_completed_scorecard($where)
    {
        $table = DEFAULT_OUTLET."_scorecard_assignment";
        $this->db->select("supplier.name,at_reviewed_date,total_percentage,$table.id");
        $this->db->from($table);
        $this->db->order_by("$table.id desc");
        $this->db->join("supplier","$table.supplier_id=supplier.id","LEFT");
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
    function get_questions_answers($id){
        $table = DEFAULT_OUTLET."_scorecard_form_question";
        $table1 = DEFAULT_OUTLET."_scorecard_form_answer";
        $this->db->select("$table1.sfa_answer,$table1.sfa_id,$table1.sfa_points");
        $this->db->from($table);
        $this->db->join("$table1","$table.sfq_id=$table1.sfa_question_id","LEFT");
        $this->db->where("$table.sfq_id",$id);
        $query = $this->db->get();
        return $query;
    }
    function get_approval_teams_result($id)
    {
        $table = DEFAULT_OUTLET."_scorecard_assignment";
        $table1 = DEFAULT_OUTLET."_groups";
        $this->db->select("$table.at_percentage,$table.at_reviewed_date,$table1.group_title,users.first_name,users.last_name");
        $this->db->from($table);
        $this->db->order_by("$table.id desc");
        $this->db->join("$table1","$table.approval_team=$table1.id","LEFT");
        $this->db->join("users","$table.at_review_user=users.id","LEFT");
        $this->db->where("$table.id",$id);
        $query = $this->db->get();
        return $query;
    }
    function update_table_($where,$data,$table)
    {
        $this->db->where($where);
        $this->db->update($table,$data);
    }
    function get_supplier_data($id)
    {
        $table = DEFAULT_OUTLET."_scorecard_team_assign";
        $table1 = DEFAULT_OUTLET."_scorecard_assignment";
        $table2 = "supplier";
        $this->db->select("$table2.name");
        $this->db->from($table);
        $this->db->join("$table1","$table.sc_id=$table1.id","LEFT");
        $this->db->join("$table2","$table1.supplier_id=$table2.id","LEFT");
        $this->db->where("$table.id",$id);
        $query = $this->db->get();
        return $query;
    }
    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function _insert_data($data,$table)
    {
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
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->delete($table);
    }
    function insert_or_update_user_review($data,$table) {
        $this->db->insert($table, $data);
            
    }
    function get_suppliers_list_for_scorecard()
    {    
        $table = DEFAULT_OUTLET.'_scorecard_assignment'; 
        $this->db->select('supplier_id');
        $this->db->from($table);
        $this->db->where('status !=',"Complete");
        $result= $this->db->get()->result_array();
        $this->db->select('name,supplier.id');
        $this->db->from('supplier');
        foreach($result as $key => $value){
            $this->db->where('id !=',$value['supplier_id']);
        }
        $query= $this->db->get();
        return $query;
    }
    function get_questions_answers_pending($question_id,$sc_id){
        $table = DEFAULT_OUTLET."_scorecard_assign_answers";
        $table1 = DEFAULT_OUTLET."_scorecard_form_answer";
        $this->db->select("$table1.sfa_answer,$table1.sfa_id,$table1.sfa_points");
        $this->db->from($table);
        $this->db->join("$table1","$table.answer_id=$table1.sfa_id","LEFT");
        $this->db->where("$table.question_id",$question_id);
        $this->db->where("$table.sc_id",$sc_id);
        $query = $this->db->get();
        return $query;
    }
    function get_card_questions_pending($id)
    {
        $table = DEFAULT_OUTLET."_scorecard_assignment";
        $table0 = DEFAULT_OUTLET."_scorecard_team_assign";
        $table1 = DEFAULT_OUTLET."_scorecard_assign_questions";
        $table2 = DEFAULT_OUTLET."_scorecard_form_question";
        $this->db->select("$table1.question,$table2.sfq_description,$table2.sfq_id");
        $this->db->from($table);
        $this->db->where("$table.id",$id);
        $this->db->order_by("$table1.tassign_id desc");
        $this->db->join("$table0","$table.id=$table0.sc_id","LEFT");
        $this->db->join("$table1","$table0.id=$table1.tassign_id","LEFT");
        $this->db->join("$table2","$table1.question_id=$table2.sfq_id","LEFT");
        $this->db->where("$table2.sfq_delete","0");
        $query = $this->db->get();
        return $query;
    }
    function get_supplier_data_pending($id)
    {
        $table1 = DEFAULT_OUTLET."_scorecard_assignment";
        $table2 = "supplier";
        $this->db->select("$table2.name");
        $this->db->from($table1);
        $this->db->join("$table2","$table1.supplier_id=$table2.id","LEFT");
        $this->db->where("$table1.id",$id);
        $query = $this->db->get();
        return $query;
    }
   
}