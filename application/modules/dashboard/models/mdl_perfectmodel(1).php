<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_perfectmodel extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
$table = "tablename";
return $table;
}
function get_data_for_completed_assignments_from_db($where,$sNeedle,$group_by){
		if(!empty($group_by)){
			$this->db->select('count(*) as count ,Year( `approval_datetime` ) as year , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN assign_answer.comments !="" THEN "Failed" else  "passed" END) AS Status' );
		}else{
			$this->db->select('assignments.*,products_check.checkname as checkname,assign_answer.comments ,Year( `approval_datetime` ) as year , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN comments !="" THEN "Failed" else  "passed" END) AS Status,products.product_title,plants.plant_name,assign_answer.line_no,assign_answer.shift_no' );
		}
		
		$this->db->from('1_assignments assignments');
		$this->db->join('1_assignment_answer assign_answer','assignments.assign_id=assign_answer.assignment_id','left');
		$this->db->join('1_product_checks products_check','products_check.id=assignments.checkid','left');

		
		$this->db->join('1_product products','products.id=assignments.product_id','left');
		$this->db->join('1_plants plants','plants.plant_id=assign_answer.plant_id','left');
		$this->db->where($where);
		
		$this->db->where('assignments.assign_status','Completed');
		if(!empty($sNeedle)){
			$this->db->like('products_check.checkname',$sNeedle);
			
		}
		if(!empty($group_by)){
			
			$this->db->group_by($group_by);
		}
		return $this->db->get();
	
}

function get_static_data_for_completed_assignments($where,$sNeedle,$group_by){
	if(!empty($group_by)){
		$this->db->select('count(*) as count,Year( `approval_datetime` ) as year , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN comments !="" THEN "Failed" else  "passed" END) AS Status' );
		}else{
			$this->db->select('s_assignments.*,static_form.sf_name as checkname,s_form_answer.comments ,Year( `approval_datetime` ) as year , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN comments !="" THEN "Failed" else  "passed" END) AS Status,plants.plant_name,s_form_answer.line_no,s_form_answer.shift_no' );
		}
		
		$this->db->from('1_static_assignments s_assignments');
		$this->db->join('1_static_assignment_answer  s_form_answer ','s_assignments.assign_id=s_form_answer.assignment_id','left');
		$this->db->join('1_static_form static_form','static_form.sf_id=s_assignments.check_id','left');
		$this->db->join('1_plants plants','plants.plant_id=s_form_answer.plant_id','left');
		$this->db->where($where);
		if(!empty($sNeedle)){
			$this->db->like('static_form.sf_name',$sNeedle);
			
		}
		if(!empty($group_by)){
			
			$this->db->group_by($group_by);
		}

		$this->db->where('s_assignments.assign_status','Approved');
		$query=$this->db->get();
//print_r($this->db->last_query());echo '<br><br> ';
		return $query;
}
function get_static_charts_data_from_db($where,$sNeedle,$group_by){
	
		$this->db->select('*,count(*) as count ,Year( `approval_datetime` ) as year,date( `approval_datetime` ) as date , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN pf_status !="pass" THEN "Failed" else  "Passed" END) AS Status' );
		$this->db->from('1_static_assignments s_assignments');
		$this->db->join('1_static_form static_form','static_form.sf_id=s_assignments.check_id','left');
		
		$this->db->where($where);
		if(!empty($sNeedle)){
			$this->db->like('static_form.sf_name',$sNeedle);
			
		}
		if(!empty($group_by)){
			
			$this->db->group_by($group_by);
		}
		$this->db->where('s_assignments.assign_status','Approved');

		$query=$this->db->get();

		return $query;
}
function get_charts_data_from_db($where,$sNeedle,$group_by){
	
		$this->db->select('*,count(*) as count  ,Year( `approval_datetime` ) as year , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN pf_status !="pass" THEN "Failed" else  "Passed" END) AS Status' );
		$this->db->from('1_assignments assignments');
		$this->db->join('1_product_checks products_check','products_check.id=assignments.checkid','left');

		$this->db->where('assignments.assign_status','Completed');
		$this->db->where($where);
		if(!empty($sNeedle)){
			$this->db->like('products_check.checkname',$sNeedle);
			
		}
			
		if(!empty($group_by)){
			
			$this->db->group_by($group_by);
		}
		
		$query=$this->db->get();

		return $query;
}
function get_sites_checkreport_plantwise($where,$table,$j_table1)
 {
        $this->db->select("COUNT(assign_id) as pass_count");
        $this->db->from($table);
        $this->db->join("$j_table1","$table.assign_id=$j_table1.assignment_id","LEFT");
        $this->db->where($where);
        $this->db->group_by("$j_table1.assignment_id");
        return $this->db->get();
 }


 function get_trendline_graph_data_db($where,$sNeedle,$group_by){
 		$this->db->select('Year( `approval_datetime` ) as year ,date( `approval_datetime` ) as date , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN pf_status !="pass" THEN "Failed" else  "Passed" END) AS Status' );
		$this->db->from('1_assignments assignments');
	
		$this->db->where('assignments.assign_status','Completed');
		$this->db->where($where);
		if(!empty($group_by)){
			
			$this->db->group_by($group_by);
		}
		$query=$this->db->get();

		return $query;
 }
 function get_static_trendline_graph_data_db($where,$sNeedle,$group_by){
 		$this->db->select('Year( `approval_datetime` ) as year,date( `approval_datetime` ) as date , MONTHNAME( `approval_datetime` ) as month,(CASE WHEN pf_status !="pass" THEN "Failed" else  "Passed" END) AS Status' );
		$this->db->from('1_static_assignments s_assignments');
	
		
		$this->db->where($where);
		
		if(!empty($group_by)){
			
			$this->db->group_by($group_by);
		}
		$this->db->where('s_assignments.assign_status','Approved');

		$query=$this->db->get();

		return $query;
 }
 	function get_standard_complete_assignments_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($outlet_id.'_assignments assign');
		$this->db->join($outlet_id.'_product_checks pro_check','assign.checkid = pro_check.id','left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($and_where))
            $this->db->where($and_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
    function get_static_complete_assignments_data($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($outlet_id.'_static_assignments static_assign');
		$this->db->join($outlet_id.'_static_form static_form','static_assign.check_id = static_form.sf_id','left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($and_where))
            $this->db->where($and_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
    function get_standard_complete_assignments_data_with_answer($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($outlet_id.'_assignments assign');
        $this->db->join($outlet_id.'_product_checks pro_check','assign.checkid = pro_check.id','left');
		$this->db->join($outlet_id.'_assignment_answer assign_answer','assign.assign_id = assign_answer.assignment_id','left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($and_where))
            $this->db->where($and_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
    function get_static_complete_assignments_data_with_answer($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
        $offset=($page_number-1)*$limit;
        $this->db->select($select);
        $this->db->from($outlet_id.'_static_assignments static_assign');
		$this->db->join($outlet_id.'_static_form static_form','static_assign.check_id = static_form.sf_id','left');
		$this->db->join($outlet_id.'_static_assignment_answer static_assign_answer','static_assign.assign_id = static_assign_answer.assignment_id','left');
        if(!empty($group_by))
            $this->db->group_by($group_by);
        if(!empty($cols))
            $this->db->where($cols);
        if(!empty($or_where))
            $this->db->where($or_where);
        if(!empty($and_where))
            $this->db->where($and_where);
        if(!empty($having))
            $this->db->having($having);
        if($limit != 0)
            $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query=$this->db->get();
        return $query;
    }
}