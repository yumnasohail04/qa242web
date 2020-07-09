<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends MX_Controller{

	function __construct() {
		parent::__construct();
		Modules::run('site_security/is_login');
        Modules::run('site_security/has_permission');
	}

	function index(){
		$data['view_file'] = 'home';
        $data['dashboard_file'] = 'asdfsadf';
		$this->load->module('template');
		$this->template->admin($data);
	}

	function save_report_default_questions(){
		$question = $this->input->post("questions");
		if (!empty($question) && strpos($question, ',') == false)
			$question = $question.',';

        echo json_encode($this->db->query("call proc_save_report_default_questions("
            .$this->input->post("program_types"). " ," .$this->input->post("product_checks")
            . " , '" .$question. "', '".$this->input->post("product_type")."' )")->result_array()[0]);
    }
}