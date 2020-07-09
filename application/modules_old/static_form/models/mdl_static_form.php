<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_static_form extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    function _get_by_arr_id($arr_col) {
        $table = DEFAULT_OUTLET.'_static_form';
        $this->db->where($arr_col);
        return $this->db->get($table);
    }
     
}