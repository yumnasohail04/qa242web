<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class widgets extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('mdl_widgets');
        // Modules::run('site_security/is_login');
        //Modules::run('site_security/has_permission');
    }

    function index(){
        echo "index";
    }

    function get_model(){
        return "";
    }

    function load_groups() {
        echo json_encode($this->db->query('call proc_load_groups_for_ddl()')->result_array());
    }

    function load_plants() {
        //echo json_encode($this->mdl_users->_load_plants());
        echo json_encode($this->db->query('call proc_load_plants_for_ddl()')->result_array());
    }
    function load_lines_by_plant_id()
    {
        echo json_encode($this->db->query("call proc_load_lines_by_plant_id_for_ddl(".$this->input->post('plant_id').')')->result_array());
    }
    function load_product_checks() {
        echo json_encode($this->db->query('call proc_load_product_checks_for_ddl()')->result_array());
    }
    function load_products() {
        echo json_encode($this->db->query('call proc_load_products_for_ddl()')->result_array());
    }
    function load_lines() {
        echo json_encode($this->db->query('call proc_load_lines_for_ddl()')->result_array());
    }
    function load_program_types() {
        echo json_encode($this->db->query('call proc_load_program_types_for_ddl()')->result_array());
    }
    function load_questions_by_program_type_or_product_checks(){
        echo json_encode($this->db->query("call proc_load_questions_by_program_type_or_product_checks_for_ddl("
                                          .$this->input->post("program_types"). " ," .$this->input->post("product_checks") . " )")->result_array());
    }
    function load_report_by_check(){
//        echo "call proc_get_assignment_answers_by_check_complete(".$this->input->post("product_checks")
//            ." , ".$this->input->post("lines")." , ".$this->input->post("productid")." , ".$this->input->post("status")
//            .", '2019-01-01' , '2019-10-17' , ".$this->input->post("program_types")." , '".$this->input->post("questions")."')";
//
//        echo 'call proc_get_assignment_answers_by_check_complete('.$this->input->post("product_checks")
//            .' , '.$this->input->post("lines").' , '.$this->input->post("productid").','.$this->input->post("status")
//            .' , \''.date("y-m-d", strtotime($this->input->post("start_date")))
//            .' \' , \''.date("y-m-d", strtotime($this->input->post("end_date")))
//            .' \' , \''.$this->input->post("program_types").' \' , \''.$this->input->post("questions").'\')';

        $arr_orignal = $this->db->query("call proc_get_assignment_answers_by_check_complete(".$this->input->post("product_checks")
            ." , ".$this->input->post("lines")." , ".$this->input->post("productid")." , ".$this->input->post("status")
            ." , '".date("y-m-d", strtotime($this->input->post("start_date")))
            ."' , '".date("y-m-d", strtotime($this->input->post("end_date")))
            ."' , ".$this->input->post("program_types")." , '".$this->input->post("questions")."')")->result_array();
        $data['arr_orignal']=$arr_orignal;
        $Mode = 0;
        if($this->input->post("view_request") == "dashboard_home") $Mode = 1;
        else if($this->input->post("view_request") == "report_home") $Mode = 2;
        $data['Mode'] = $Mode;
        //$data['tbl_id_name']=$this->input->post('tbl_id_name');

        echo $this->load->view('report_by_product_check',$data ,TRUE);
    }

    function load_chart_for_totals(){
        $model = 10;
        $data["model"] = $model;
        echo  $this->load->view('chart_for_totals',$data,TRUE);
    }

    function load_chart_for_compliants(){
        $model = 10;
        $data["model"] = $model;
        echo  $this->load->view('chart_for_compliants',$data,TRUE);
    }

    function load_chart_for_signed(){
        $model = 10;
        $data["model"] = $model;
        echo  $this->load->view('chart_for_signed',$data,TRUE);
    }

    function load_chart_for_corrections(){
        $model = 10;
        $data["model"] = $model;
        echo  $this->load->view('chart_for_corrections',$data,TRUE);
    }
}
