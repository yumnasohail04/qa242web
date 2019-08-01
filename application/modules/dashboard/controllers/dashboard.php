<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MX_Controller{

	function __construct() {
		parent::__construct();
		// Modules::run('site_security/is_login');
        //Modules::run('site_security/has_permission');
	}

	function index(){
 				/*$this->load->library('excel');
 				$this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('HELLO');
                //Main Heading of excel sheet
                $this->excel->getActiveSheet()->setCellValue('A1', ' Excel Sheet');
                //merge cell A1 until K1 of main heading
                $this->excel->getActiveSheet()->mergeCells('A1:K1');
                 //set aligment to center for that merged cell (A1 to J1)
                $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //make the font become bold
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
                $styleArray = array('font'  => array('bold'  => true,'color' => array('rgb' => 'ffff00'),'size'  => 20));
                $this->excel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                $this->excel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FF0000');


                //Colums heading 
                $this->excel->getActiveSheet()->setCellValue('A3', 'Check id');
                $this->excel->getActiveSheet()->setCellValue('B3', 'Product ID');
                $this->excel->getActiveSheet()->setCellValue('C3', 'Inspection Team');
                $this->excel->getActiveSheet()->setCellValue('D3', 'Review Team');
                $this->excel->getActiveSheet()->setCellValue('E3', 'Approval Team');
                $this->excel->getActiveSheet()->setCellValue('F3', 'Outlet ID');
                $this->excel->getActiveSheet()->setCellValue('G3', 'Line Timing');
                $this->excel->getActiveSheet()->setCellValue('H3', 'Start Date Time');
                $this->excel->getActiveSheet()->setCellValue('I3', 'End Date Time');
                $this->excel->getActiveSheet()->setCellValue('J3', 'Assignment Status');
                $this->excel->getActiveSheet()->setCellValue('K3', 'Complete Date Time');
                //Make the heading become bold
                $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
                
                for($col = ord('A'); $col <= ord('K'); $col++){ 
                 //change the font size
                $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                 }
                //retrive  table data
                $rs = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(), 'assign_id','assign_id','1_assignments','checkid,product_id,inspection_team,review_team,approval_team,outlet_id,line_timing,start_datetime,end_datetime,assign_status,complete_datetime','1','5','','','');
                $exceldata="";
                foreach ($rs->result_array() as $row){
                $exceldata[] = $row;
                }
                //Fill data
                $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
                $filename='PHPExcelDemo.xls'; //save our workbook as this file name
                header('Content-Type: application/vnd.ms-excel'); //mime type
                header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                header('Cache-Control: max-age=0'); //no cache
                //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
                //if you want to save it as .XLSX Excel 2007 format
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                //force user to download the Excel file without writing it to server's HD
                $objWriter->save('php://output');
                exit();*/
		$data['products'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_product','id','1','0')->num_rows();
		$data['users'] = Modules::run('api/_get_specific_table_with_pagination',array('outlet_id'=>DEFAULT_OUTLET), 'id desc','users','id','1','0')->num_rows();
		$data['groups'] = Modules::run('api/_get_specific_table_with_pagination',array(), 'id desc',DEFAULT_OUTLET.'_groups','id','1','0')->num_rows();
		$data['view_file'] = 'home';
        $data['dashboard_file'] = 'asdfsadf';
		$this->load->module('template');
		$this->template->admin($data);
	}
	function change_notification_status() {
		$id = $this->input->post('id');
		if(!empty($id)) {
			MOdules::run('api/update_specific_table',array("notification_id"=>$id),array("notification_status"=>'0'),'notification');
		}
	}
	function change_all_notification_status() {
		MOdules::run('api/update_specific_table',array("outlet_id"=>DEFAULT_OUTLET),array("notification_status"=>'0'),'notification');
	}
    function reporting() {
        $api_status = "error";
        $message = "Bad Request";
        $startdate = $this->input->post('startdate');
        $enddate = $this->input->post('enddate');
        $selecting = $this->input->post('selecting');
        if(!empty($startdate) && !empty($enddate) && !empty($selecting)) {
            $startdate = date('Y-m-d',strtotime($startdate)).' 00:00:00';
            $enddate = date('Y-m-d',strtotime($enddate)).' 23:59:59';
            if($selecting == 'receivinginspectionlog') {
                $file_name = $title = 'Receiving Inspection Log';
                $heading = array("Date","Monitor","Time","Invoice No","Item Name","Supplier Name","Is supplier and product on the Approved list?","Carrier Name","Truck License Plate","Trailer License Plate","Driver License Info","Is Trailer Sealed?","Is Trailer Locked?","Are trailer and materials free of signs of tampering?","Truck Condition","Product condition","Product Temperature","Visual Verification","Allergen","Product Contains Allergens?","Expiration Date","Inspection Summary","Follow Up Actions","Corrective Actions","Status","Reviewer","Review Datetime","Approver","Approved Datetime");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("ti_datetime >="=>$startdate,"ti_datetime <="=>$enddate), 'ti_id desc','ti_id',DEFAULT_OUTLET.'_truck_inspection','ti_datetime as date,ti_monitor_name,ti_datetime as time,ti_invoice_no,ti_item_name,ti_suppler_name,ti_suppler_approve,ti_carrier_name,ti_truck_license,ti_trailer_license,ti_driver_license_info,ti_trailer_sealed,ti_trailer_locked,ti_signs_of_tampering,ti_truck_condition_acceptable,ti_product_condition,ti_product_temperature,ti_visual_verification,ti_allergen_verification,ti_contains_allergen,ti_expiration_date,ti_summery,ti_follow_up_action,ti_corrective_action,ti_status,ti_review,ti_review_datetime,ti_approve,ti_approve_datetime','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        if(isset($dt['ti_expiration_date']) && !empty($dt['ti_expiration_date']))
                            $dt['ti_expiration_date'] = date('m-d-Y',strtotime($dt['ti_expiration_date']));
                        $dt['ti_review'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ti_review']);
                        if(isset($dt['ti_review_datetime']) && !empty($dt['ti_review_datetime']))
                            $dt['ti_review_datetime'] = date('m-d-Y',strtotime($dt['ti_review_datetime']));
                        $dt['ti_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ti_approve']);
                        if(isset($dt['ti_approve_datetime']) && !empty($dt['ti_approve_datetime']))
                            $dt['ti_approve_datetime'] = date('m-d-Y',strtotime($dt['ti_approve_datetime']));
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            elseif($selecting == 'shippinginspection') {
                $file_name = $title = 'Shipping Inspection';
                $heading = array("Date","Monitor Name","Time","Sale Order Number","Item Name","Customer Name","Carrier Name","Truck License Plate","Driver License Info","Truck Set Temparture","Truck Reading Temparture","Truck Condition Acceptable","Frozen Product Temp","Refrigerated Product","First Product Surface Temp","Last Product Surface Temp","Product Condition Acceptable","Sign Of Temparing","Is Trailer Secured","Seal No","Is Bol","Inspection Summary","Checkout Time","Follow Up Actions","Corrective Actions","Lot Number Check","Lot Number","Status","Line","Shift","Plant","Reviewer","Review Datetime","Approver","Approved Datetime");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("si_checkin_time >="=>$startdate,"si_checkin_time <="=>$enddate), 'si_id desc','si_id',DEFAULT_OUTLET.'_shipping_inspection','si_checkin_time as date,si_monitor_name,si_checkin_time as time,si_sale_order_no,si_item_name,si_customer_name,si_carrier_name,si_truck_trailer_plate,si_driver_info,si_truck_set_temp,si_truck_reading_temp,si_truck_condition_acceptable,si_frozen_product_temp,si_refrigerated_product,si_first_product_surface_temp,si_last_product_surface_temp,si_product_condition_acceptable,si_sign_of_temparing,si_is_secured,si_seal_no,si_is_bol,si_inspection_summary,si_checkout_time,si_followup_action,si_corrective_action,si_lot_number_check,si_lot_number,si_status,si_line,si_shift,si_plant,si_review,si_review_datetime,si_approve,si_approve_datetime','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        if(isset($dt['si_checkout_time']) && !empty($dt['si_checkout_time']))
                            $dt['si_checkout_time'] = date('m-d-Y H:i:s',strtotime($dt['si_checkout_time']));
                        $dt['si_review'] = $this->get_user_name(DEFAULT_OUTLET,$dt['si_review']);
                        if(isset($dt['si_review_datetime']) && !empty($dt['si_review_datetime']))
                            $dt['si_review_datetime'] = date('m-d-Y',strtotime($dt['si_review_datetime']));
                        $dt['si_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['si_approve']);
                        if(isset($dt['si_approve_datetime']) && !empty($dt['si_approve_datetime']))
                            $dt['si_approve_datetime'] = date('m-d-Y',strtotime($dt['si_approve_datetime']));
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            elseif($selecting == 'palletizinginspection') {
                $file_name = $title = 'Palletizing Inspection';
                $heading = array("Date","Monitor Name","Time","Item Name","Pallet Number","Cases","Used By Date","Code Date","Status","Line","Shift","Plant");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("pi_time >="=>$startdate,"pi_time <="=>$enddate), 'pi_id desc','pi_id',DEFAULT_OUTLET.'_palletizing_inspection','pi_time as date,pi_initials,pi_time as time,pi_item_number,pi_pallet_number,pi_cases,pi_used_by_date,pi_code_date,pi_status,pi_line,pi_shift,pi_plant','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        if(isset($dt['pi_used_by_date']) && !empty($dt['pi_used_by_date']))
                            $dt['pi_used_by_date'] = date('m-d-Y H:i:s',strtotime($dt['pi_used_by_date']));
                        if(isset($dt['pi_code_date']) && !empty($dt['pi_code_date']))
                            $dt['pi_code_date'] = date('m-d-Y H:i:s',strtotime($dt['pi_code_date']));
                        $dt['pi_initials'] = $this->get_user_name(DEFAULT_OUTLET,$dt['pi_initials']);
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            elseif($selecting == 'cleaninginspection') {
                $file_name = $title = 'Cleaning Inspection';
                $heading = array("Date","Monitor Name","Time","Circle","Product Last Produced","Allergn Profile","Product To be Started","Allergn Profile","No Visible Food Debris","Product Formulation And Ingredients","Food Contact Surfaces Conform To The Parameters","Filling Mixer","770's Machine Parts","Beginning Of Pasteurizer","End Of Pasteurizer","Pasteurizer & Cooling Conveyors","Product Entry To Spiral Freezer","Sprial Freezer,Clean And Light Covers Intact","Spiral Discharge Area","Incline Conveyor's","Pasta weighing machine","Discharge Shoot To Packaging","Bulk Product By Checking","No product or residue from previews run","Employee glove & sleeve changes","Coats/smocks and aprons changed","Labeling is correct","Metal detector rejects removed","Status","Line","Shift","Plant","Reviewer","Review Datetime","Approver","Approved Datetime");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("ci_datetime >="=>$startdate,"ci_datetime <="=>$enddate), 'ci_id desc','ci_id',DEFAULT_OUTLET.'_cleaning_inspection','ci_datetime as date,ci_monitor_name,ci_datetime as time,ci_circle,ci_last_product,ci_allergen_profile,ci_product_start,ci_allergen_second_profile,ci_question1_answer,ci_question1_correct_answer,ci_question2_answer,ci_question2_correct_answer,ci_question3_answer,ci_question3_correct_answer,ci_question4_answer,ci_question4_correct_answer,ci_question5_answer,ci_question5_correct_answer,ci_question6_answer,ci_question6_correct_answer,ci_question7_answer,ci_question7_correct_answer,ci_question8_answer,ci_question8_correct_answer,ci_question9_answer,ci_question9_correct_answer,ci_question10_answer,ci_question10_correct_answer,ci_question11_answer,ci_question11_correct_answer,ci_question12_answer,ci_question12_correct_answer,ci_question13_answer,ci_question13_correct_answer,ci_question14_answer,ci_question14_correct_answer,ci_question15_answer,ci_question15_correct_answer,ci_question16_answer,ci_question16_correct_answer,ci_question17_answer,ci_question17_correct_answer,ci_question18_answer,ci_question18_correct_answer,ci_question19_answer,ci_question19_correct_answer,ci_question20_answer,ci_question20_correct_answer,ci_status,ci_line,ci_shift,ci_plant,ci_review,ci_review_datetime,ci_approve,ci_approve_datetime','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        $dt['ci_monitor_name'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ci_monitor_name']);
                        for ($i=1; $i < 21; $i++) { 
                            if(!empty($dt['ci_question'.$i.'_correct_answer']))
                                $dt['ci_question'.$i.'_answer'] = $dt['ci_question'.$i.'_correct_answer'];
                            unset($dt['ci_question'.$i.'_correct_answer']);
                        }
                        $dt['ci_review'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ci_review']);
                        if(isset($dt['ci_review_datetime']) && !empty($dt['ci_review_datetime']))
                            $dt['ci_review_datetime'] = date('m-d-Y',strtotime($dt['ci_review_datetime']));
                        $dt['ci_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ci_approve']);
                        $dt['ci_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ci_approve']);
                        if(isset($dt['ci_approve_datetime']) && !empty($dt['ci_approve_datetime']))
                            $dt['ci_approve_datetime'] = date('m-d-Y',strtotime($dt['ci_approve_datetime']));
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            elseif($selecting == 'bulkpastatemplogeverytub') {
                $file_name = $title = 'Bulk Pasta Temp Log Every Tub';
                $heading = array("Date","Monitor Name","Time","packing operator","Product Name","item number","container / Pallet #","Time in cooler","time out of cooler","Temperature","Status","Line","Shift","Plant","Reviewer","Review Datetime","Approver","Approved Datetime");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("bi_datetime >="=>$startdate,"bi_datetime <="=>$enddate), 'bi_id desc','bi_id',DEFAULT_OUTLET.'_bulk_tub_inspection','bi_datetime as date,bi_initial,bi_datetime as time,bi_packing_operator,bi_product_name,bi_item_no,bi_pallet_no,bi_time_in_cooler,bi_time_out_cooler,bi_temperature,bi_status,bi_line,bi_shift,bi_plant,bi_review,bi_review_datetime,bi_approve,bi_approve_datetime','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        $dt['bi_initial'] = $this->get_user_name(DEFAULT_OUTLET,$dt['bi_initial']);
                        if(isset($dt['bi_time_in_cooler']) && !empty($dt['bi_time_in_cooler']))
                            $dt['bi_time_in_cooler'] = date('H:i:s',strtotime($dt['bi_time_in_cooler']));
                        if(isset($dt['bi_time_out_cooler']) && !empty($dt['bi_time_out_cooler']))
                            $dt['bi_time_out_cooler'] = date('H:i:s',strtotime($dt['bi_time_out_cooler']));
                        $dt['bi_review'] = $this->get_user_name(DEFAULT_OUTLET,$dt['bi_review']);
                        if(isset($dt['bi_review_datetime']) && !empty($dt['bi_review_datetime']))
                            $dt['bi_review_datetime'] = date('m-d-Y',strtotime($dt['bi_review_datetime']));
                        $dt['bi_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['bi_approve']);
                        if(isset($dt['bi_approve_datetime']) && !empty($dt['bi_approve_datetime']))
                            $dt['bi_approve_datetime'] = date('m-d-Y',strtotime($dt['bi_approve_datetime']));
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            elseif($selecting == 'bulkpastatemplogeveryform') {
                $file_name = $title = 'Bulk Pasta Temp Log Every Form';
                $heading = array("Submited Date","Monitor Name","Time","item","date","lot code","exp date","exp time","allergn","qty","pallet no","Line","Shift","Plant","Reviewer","Review Datetime","Approver","Approved Datetime");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("bfi_datetime >="=>$startdate,"bfi_datetime <="=>$enddate), 'bfi_id desc','bfi_id',DEFAULT_OUTLET.'_bulk_form_inspection','bfi_datetime as date,bfi_initial,bfi_datetime as time,bfi_item,bfi_date,bfi_lotcode,bfi_expdate,bfi_time,bfi_allergen,bfi_quantity,bfi_pallet_no,bfi_status,bfi_line,bfi_shift,bfi_plant,bfi_review,bfi_review_datetime,bfi_approve,bfi_approve_datetime','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        $dt['bfi_initial'] = $this->get_user_name(DEFAULT_OUTLET,$dt['bfi_initial']);
                        if(isset($dt['bfi_date']) && !empty($dt['bfi_date']))
                            $dt['bfi_date'] = date('m-d-Y',strtotime($dt['bfi_date']));
                        if(isset($dt['bfi_expdate']) && !empty($dt['bfi_expdate']))
                            $dt['bfi_expdate'] = date('m-d-Y',strtotime($dt['bfi_expdate']));
                        if(isset($dt['bfi_time']) && !empty($dt['bfi_time']))
                            $dt['bfi_time'] = date('H:i:s',strtotime($dt['bfi_time']));
                        $dt['bfi_review'] = $this->get_user_name(DEFAULT_OUTLET,$dt['bfi_review']);
                        if(isset($dt['bfi_review_datetime']) && !empty($dt['bfi_review_datetime']))
                            $dt['bfi_review_datetime'] = date('m-d-Y',strtotime($dt['bfi_review_datetime']));
                        $dt['bfi_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['bfi_approve']);
                        if(isset($dt['bfi_approve_datetime']) && !empty($dt['bfi_approve_datetime']))
                            $dt['bfi_approve_datetime'] = date('m-d-Y',strtotime($dt['bfi_approve_datetime']));
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            elseif($selecting == 'recodeinspection') {
                $file_name = $title = 'Recode Inspection';
                $heading = array("Date","Monitor Name","Time","source name","source item number","source product temperature","source brand name","source product name","source allergn(s) content","source cases used","source production tag date","source nav lot code no","packing item number","packing brand name","packing product name","packing allergen content","packing cases made","packing expiration date","status","line","Shift","plant","reviewer","review datetime","approver","approve datetime");
                $data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("ri_datetime >="=>$startdate,"ri_datetime <="=>$enddate), 'ri_id desc','ri_id',DEFAULT_OUTLET.'_recode_inspection','ri_datetime as date,ri_initial,ri_datetime as time,ri_selected_source,ri_source_item_no,ri_source_product_temperature,ri_source_brand_name,ri_source_product_name,ri_source_allergens,ri_source_case_used,ri_source_production_date,ri_source_nav_lot_code,ri_pack_item_no,ri_pack_brand_name,ri_pack_product_name,ri_pack_allergens,ri_pack_cases_made,ri_pack_exp_date,ri_status,ri_line,ri_shift,ri_plant,ri_review,ri_review_datetime,ri_approve,ri_approve_datetime','1','0','','','')->result_array();
                if(!empty($data)) {
                    $temp = "";
                    foreach ($data as $key => $dt):
                        if(isset($dt['date']) && !empty($dt['date']))
                            $dt['date'] = date('m-d-Y',strtotime($dt['date']));
                        if(isset($dt['time']) && !empty($dt['time']))
                            $dt['time'] = date('H:i:s',strtotime($dt['time']));
                        $dt['ri_initial'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ri_initial']);
                        if(isset($dt['ri_source_production_date']) && !empty($dt['ri_source_production_date']))
                            $dt['ri_source_production_date'] = date('m-d-Y',strtotime($dt['ri_source_production_date']));
                        if(isset($dt['ri_pack_exp_date']) && !empty($dt['ri_pack_exp_date']))
                            $dt['ri_pack_exp_date'] = date('m-d-Y',strtotime($dt['ri_pack_exp_date']));
                        $dt['ri_review'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ri_review']);
                        if(isset($dt['ri_review_datetime']) && !empty($dt['ri_review_datetime']))
                            $dt['ri_review_datetime'] = date('m-d-Y',strtotime($dt['ri_review_datetime']));
                        $dt['ri_approve'] = $this->get_user_name(DEFAULT_OUTLET,$dt['ri_approve']);
                        if(isset($dt['ri_approve_datetime']) && !empty($dt['ri_approve_datetime']))
                            $dt['ri_approve_datetime'] = date('m-d-Y',strtotime($dt['ri_approve_datetime']));
                        $temp[] = $dt;
                    endforeach;
                    $data = $temp;
                }
                else {
                    $api_status = 'success';
                    $message = "No record found between selected dates";
                }
            }
            else
                echo "";
            if(!empty($title) && !empty($heading) && !empty($data)) {
                $api_status = 'success';
                $message = "File download";
                $row_counter = "A"; $colum_counter= 1;
                $this->load->library('excel');
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle($title);
                $heading_count = 0;
                for($row=1; $row <= count($heading);$row++) {
                    $this->excel->getActiveSheet()->setCellValue($row_counter.$colum_counter,ucwords($heading[$heading_count]));
                    $this->excel->getActiveSheet()->getStyle($row_counter.$colum_counter)->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle($row_counter.$colum_counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle($row_counter.$colum_counter)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('8EAADC');
                    $heading_count++;
                    $row_counter++;
                }
                $col = "A";
                for($row = 1; $row <= count($heading); $row++){ 
                    $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                    $this->excel->getActiveSheet()->getStyle($col)->getFont()->setSize(12);
                    $this->excel->getActiveSheet()->getStyle($col)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle($col)->getFill()->getStartColor()->setARGB('#333');
                    $col++;
                 }
                $colum_counter++;
                $this->excel->getActiveSheet()->fromArray($data, null, 'A2');
                $filename='PHPExcelDemo.xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$title.'.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');
            }
        }
        $this->session->set_flashdata('message', $message);
        $this->session->set_flashdata('status', $api_status);
        redirect(ADMIN_BASE_URL.'dashboard/index');
    }
    function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
    function get_user_name($outlet_id,$user_id) {
        $final_name = "";
        $user = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$user_id),'id desc','users','first_name,last_name','1','1')->result_array();
        $first_name = $last_name =''; 
        if(isset($user[0]['first_name']) && !empty($user[0]['first_name']))
            $first_name=$user[0]['first_name'];
        if(isset($user[0]['last_name']) && !empty($user[0]['last_name']))
            $last_name=$user[0]['last_name'];
        return  Modules::run('api/string_length',$first_name,'8000','',$last_name);

    }
}