<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Front extends MX_Controller {
	protected $data = '';
		function __construct() {
		parent::__construct();
		$this->load->library("pagination");
		 $this->load->helper("url");
		}

		function index() {
		    $this->load->module('template');
		    $data['header_file'] = 'header';
		    $data['view_file'] = 'home_page';
		    $this->template->front($data);
		}
}