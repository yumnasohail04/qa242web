<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

for ($i = 1; $i <= 30; $i++) {
    $resultRank[$i] = $i;
}

for ($year = 2014; $year <= 2050; $year++) {
    $arr_year[$year] = $year;
}

date_default_timezone_set("Asia/Karachi");
$config = array(
    'Date_Format_Type' => array(1 => date("Y/m/d"), 2 => date('m/d/Y'), 3 => date('d/m/Y')),
    'time_Format_Type' => array(1 => date("H:s A"), 2 => date('H:s a'), 3 => date('H:s')),
    'Date_Format_Type_JS' => array(1 => "YYYY/MM/DD", 2 => 'MM/DD/YYYY', 3 => 'DD/MM/YYYY'),
    'time_Format_Type_JS' => array(1 => "h:mm A", 2 => 'h:mm a', 3 => 'H:mm'),
    'Rank' => $resultRank,
    'sub_modules' => array('outlet_lang'),
	'Gender' => array(1 => 'Male', 2 => 'Female'),
	'Employment_Contract_Code' => array(1 => 'Employed', 2 => 'Contractor')

);