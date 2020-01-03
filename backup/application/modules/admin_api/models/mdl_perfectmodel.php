<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_perfectmodel extends CI_Model {

        function __construct() {
            parent::__construct();
        }
        function get_outlet_order_list($where,$order,$outlet_id,$select,$where_status,$page_number,$limit) {
            $offset = ($page_number-1) *$limit;
            $this->db->select($select);
            $this->db->from('users_orders');
            $this->db->join($outlet_id.'_orders','users_orders.order_id='.$outlet_id.'_orders.id','left');
            if(isset($where) && !empty($where))
                $this->db->where($where);
            if(isset($where_status) && !empty($where_status))
                $this->db->where($where_status);
            if(isset($limit) && !empty($limit))
                if($limit !=0)
                    $this->db->limit($limit,$offset);
            if(isset($order) && !empty($order))
                $this->db->order_by($order);
            return $this->db->get();
        }
        function _get_outlet_order_income_reports($cols, $order_by,$table,$select,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            $this->db->join('users_orders',$table.".id=users_orders.order_id",'left');
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        ////////////////////////////////////// Qa project api///////////
        
      ////////////////////////////// Qa project functions///////////
        function get_checks_lists_from_db($cols,$group_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having,$like){
            $offset=($page_number-1)*$limit;
           
            $this->db->select($select);
            $this->db->from($table);
            $this->db->join(DEFAULT_OUTLET.'_assignment_inspection_teams inspection_teams','inspection_teams.assignment_id=assignments.assign_id','left');
            $this->db->distinct($table.'.assign_id');
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
            if(!empty($like))
              $this->db->like('line_timing', $like);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by('assign_id','desc');
            /*$this->db->order_by("FIELD(`assign_status`, 'OverDue', 'Review', 'Open','Approval','Completed'),".$table.".assign_id", '', FALSE);*/
            $query=$this->db->get();
          
            return $query;
        }
        function get_all_check_list_from_db($where,$outlet_id,$where_frequency){
            $table=$outlet_id."_product_checks product_checks";
            $this->db->select('product_checks.*,,catagories.cat_name');
            $this->db->from($table);
        	$this->db->join("catagories","catagories.id=product_checks.check_cat_id","left");
        

             if(!empty($where))
            $this->db->where($where);
            $this->db->where('checktype !=','wip_profile ');
            $this->db->where('checktype !=','bowl_filling ');
            if(!empty($where_frequency))
            $this->db->where_in('product_checks.frequency',$where_frequency);
        	$this->db->where_not_in('catagories.cat_name ',array('Gluten Free','Seafood'));
           $query=$this->db->get();
          return $query;
        }
		function get_all_check_list_from_db_without_join($where,$outlet_id,$where_frequency){
          $table=$outlet_id."_product_checks product_checks";
          $this->db->from($table);
            $this->db->where($where);
          $this->db->where('checktype !=','wip_profile');
          $this->db->where('checktype !=','bowl_filling');
          if(!empty($where_frequency))
            $this->db->where_in('product_checks.frequency',$where_frequency);
          
          $query=$this->db->get();
          return $query;
        }
        function insert_assignment_data($data,$outlet_id){
              $table =$outlet_id."_assignments";
              $this->db->insert($table, $data);
             $insert_id = $this->db->insert_id();
           return $insert_id;
        }
         function check_if_assignment_exists($where,$outlet_id){
            $table =$outlet_id."_assignments";
             if(!empty($where))
             $this->db->where($where);
             $query=$this->db->get($table);
            
          return $query;
        }
         function get_checks_detail_from_db($where,$outlet_id){
            $table=$outlet_id."_product_checks product_checks";
            $team=$outlet_id."_checks_questions checks_questions";
            $assign=$outlet_id."_assignments assignments ";
            $this->db->select('product_checks.*,checks_questions.*,product.id,product.product_title,assignments.complete_datetime');
            $this->db->from($table);
            $this->db->join($team,"product_checks.id=checks_questions.checkid",'left');
             $this->db->join($assign,"product_checks.id=assignments.checkid",'left');
            $this->db->join($outlet_id."_product product","product.id=product_checks.productid",'left');
            if(!empty($where))
            $this->db->where($where);
            $query=$this->db->get();
            return $query;
        }
        function get_question_answers($where,$outlet_id){
            $table=$outlet_id."_checks_answers checks_answers";
            $this->db->select('checks_answers.answer_id,checks_answers.possible_answer,checks_answers.min,checks_answers.max,checks_answers.is_acceptable');
            if(!empty($where))
            $this->db->where($where);
            $query=$this->db->get($table);
            return $query;
        }
         function get_over_due_assignment($where,$outlet_id){
            $table=$outlet_id."_assignments assignments";
            $this->db->select('assignments.*');
             if(!empty($where))
            $this->db->where($where);
             $this->db->where('assignments.assign_status','Open');
           $query=$this->db->get($table);
          
          return $query;
        }
        function update_assignment_status($where,$data,$outlet_id){
            $table=$outlet_id."_assignments assignments";
            $this->db->where($where);
            $this->db->update($table,$data);
        }
        function check_from_assignment_answers($where,$outlet_id){
            $table=$outlet_id."_assignment_answer assignment_answer";
            $this->db->select('assignment_answer.*');
            $this->db->where($where);
           $query=$this->db->get($table);
          return $query;
        }
         function insert_assign_answers($outlet_id,$data){
            $table=$outlet_id."_assignment_answer";
           $this->db->insert($table, $data);
             $insert_id = $this->db->insert_id();
           return $insert_id;
        }
        function update_where_assignment_answer($where,$data,$outlet_id){
            $table=$outlet_id."_media";
            $this->db->where($where);
            $this->db->update($table,$data);
        }
        function get_assign_data($cols, $order_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having) {
          $offset=($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id."_assignments assignments");
          $this->db->group_by("assignments.assign_id");
          $this->db->join($outlet_id.'_product_checks product_checks' , 'product_checks.id = assignments.checkid' , 'left');
          $this->db->join($outlet_id.'_groups groups' , 'assignments.inspection_team = groups.id' , 'left');
          if(!empty($cols))
            $this->db->where($cols);
          if(!empty($or_where))
            $this->db->where($or_where);
          if(!empty($having))
            $this->db->having($having);
          if($limit != 0)
            $this->db->limit($limit, $offset);
          $this->db->order_by($order_by);
          return $this->db->get();
        }
        function get_complete_by_user($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having) {
          $offset=($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id."_assignments assignments");
          $this->db->group_by($group_by);
          $this->db->join($outlet_id.'_assignment_answer assignment_answer' , 'assignments.assign_id = assignment_answer.assignment_id' , 'left');
          if(!empty($cols))
            $this->db->where($cols);
          if(!empty($or_where))
            $this->db->where($or_where);
          if(!empty($having))
            $this->db->having($having);
          if($limit != 0)
            $this->db->limit($limit, $offset);
          $this->db->order_by($order_by);
          return $this->db->get();
        }
        function get_chat_detail($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($outlet_id."_chat_detail chat_detail");
            $this->db->join($outlet_id.'_messages messages' , 'chat_detail.message_id = messages.message_id' , 'left');
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
        function get_product_schedules_from_db($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
          $offset=($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_product_schedules as product_schedules');
          $this->db->join($outlet_id.'_product as product','product_schedules.ps_product=product.id','left');
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
        function get_plants_lines($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
          $offset=($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_line_plants as line_plants');
          $this->db->join($outlet_id.'_lines as liness','line_plants.lp_line= liness.line_id','left');
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
        /////////////// WIP PROFILE FUNCTIONS????????///////////////
        function get_all_product_check_list_from_db($where,$outlet_id,$where_inarray){
          $table=$outlet_id."_product_checks product_checks";
            $this->db->select('product_checks.*');
            $this->db->from($table);
             if(!empty($where))
            $this->db->where($where);
          if(!empty($where_inarray))
             $this->db->where_in('checktype',$where_inarray);
           $query=$this->db->get();
          return $query;
        }
         function get_all_gluten_free_product_check_list_from_db($where,$outlet_id,$where_inarray){
           $table=$outlet_id."_product_checks product_checks";
            $this->db->select('product_checks.*,catagories.cat_name');
            $this->db->join("catagories","catagories.id=product_checks.check_cat_id","left");
            $this->db->from($table);
             if(!empty($where))
            $this->db->where($where);
            $this->db->where_in('catagories.cat_name ',array('Gluten Free','Seafood'));
           $query=$this->db->get();
          return $query;
        }
		function get_schedules_product($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $table = $outlet_id."_product_schedules";
            $second_table = $outlet_id."_product";
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            $this->db->join($second_table,$table.'.ps_product='.$second_table.'.id','left');
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
        function get_static_forms($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having){
          $offset=($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_static_form');
          $this->db->join($outlet_id.'_static_checks_inspection',$outlet_id.'_static_form.sf_id ='.$outlet_id.'_static_checks_inspection.sci_check_id','left');
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
         /////////////// END WIP PROFILE FUNCTIONS????????///////////////
         
         function get_all_scheduled_checks($where,$outlet_id){
            $table=$outlet_id."_product_checks product_checks";
            $this->db->select('product_checks.*,catagories.cat_name');
            $this->db->join("catagories","catagories.id=product_checks.check_cat_id","left");
            $this->db->from($table);
             if(!empty($where))
            $this->db->where($where);
            //$this->db->where_in('catagories.cat_name ',array('USDA','FDA','Organic','Refrigerated','Frozen'));
            $query=$this->db->get();
          return $query;
         }
          function get_product_for_schedule_checks($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
          $offset=($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_product_schedules as product_schedules');
          $this->db->join($outlet_id.'_product as product','product_schedules.ps_product=product.id','left');
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
        function get_check_category_details($checkid){
             $table=DEFAULT_OUTLET."_product_checks product_checks";
            $this->db->select('product_checks.*,catagories.cat_name');
            $this->db->join("catagories","catagories.id=product_checks.check_cat_id","left");
            $this->db->from($table);
            $this->db->where('product_checks.id',$checkid);
          
            $query=$this->db->get();
          return $query;
        }
		function get_checks_program($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having) {
          $offset = ($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_checks_program_type checks_program_type');
          $this->db->join($outlet_id.'_program_types program_types','checks_program_type.cpt_program_type = program_types.id','left');
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
        function get_product_program($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having) {
          $offset = ($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_product_program_type product_program_type');
          $this->db->join($outlet_id.'_program_types program_types','product_program_type.ppt_program_id = program_types.id','left');
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
		function get_checks_detail_with_program_type($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having) {
          $offset = ($page_number-1)*$limit;
          $this->db->select($select);
          $this->db->from($outlet_id.'_product_checks product_checks');
          $this->db->join($outlet_id.'_checks_program_type checks_program_type','product_checks.id = checks_program_type.cpt_check_id','left');
          $this->db->join($outlet_id.'_program_types program_types','checks_program_type.cpt_program_type = program_types.id','left');
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
		function get_checks_for_delete($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($outlet_id.'_assignments assignments');
            $this->db->join($outlet_id.'_product_checks product_checks','assignments.checkid= product_checks.id','left');
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
		function get_in_progress_counter($cols, $order_by,$group_by,$outlet_id,$select,$page_number,$limit,$or_where,$and_where,$having){
        	$offset=($page_number-1)*$limit;
        	$this->db->select($select);
        	$this->db->from($outlet_id.'_static_draft static_draft');
        	$this->db->join($outlet_id.'_static_checks_inspection static_checks_inspection','static_draft.sd_check_id= static_checks_inspection.sci_check_id','left');
        	$this->db->join($outlet_id.'_static_form static_form','static_draft.sd_check_id= static_form.sf_id','left');
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
