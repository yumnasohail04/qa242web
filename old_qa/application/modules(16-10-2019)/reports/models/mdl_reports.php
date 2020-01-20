<?php 
/*************************************************
Created By: umar farooq
Dated: 30-09-2019
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_reports extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_table() {
		$table = "tablename";
		return $table;
	}



}