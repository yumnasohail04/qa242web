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



}