<div class="page-content-wrapper">
<?php // print_r($post['title']);exit; ?>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                            <div class="form-body">
                                    <h3>Initial</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                      Submited By
                                    </th>
                                    <td>
                                        <?php 
                                        if(isset($inspection[0]['si_monitor_name']) && !empty($inspection[0]['si_monitor_name']))
                                          $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['si_monitor_name']),'id desc','users','first_name,last_name','1','1')->result_array();
                                        $fisrt_name=''; 
                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                        $last_name=''; 
                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                          $last_name=$review_user_detail[0]['last_name']; 
                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name; 
                                         ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Line
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_line']) && !empty($inspection[0]['si_line'])) $name=$inspection[0]['si_line']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Shift
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_shift']) && !empty($inspection[0]['si_shift'])) $name=$inspection[0]['si_shift']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Plant
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_plant']) && !empty($inspection[0]['si_plant'])) $name=$inspection[0]['si_plant']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h3>Checks Detail</h3>
                              <table id="datatable1" class="table table-bordered">
                                <tbody class="table-body">
                                  <tr class="bg-col">
                                    <th>
                                      Check In Time:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['si_checkin_time']) && !empty($inspection[0]['si_checkin_time'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['si_checkin_time'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Sales Order Number:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_sale_order_no']) && !empty($inspection[0]['si_sale_order_no'])) $name=$inspection[0]['si_sale_order_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Item Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_item_name']) && !empty($inspection[0]['si_item_name'])) $name=$inspection[0]['si_item_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Customer Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_customer_name']) && !empty($inspection[0]['si_customer_name'])) $name=$inspection[0]['si_customer_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Carrier Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_carrier_name']) && !empty($inspection[0]['si_carrier_name'])) $name=$inspection[0]['si_carrier_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Truck License Plate / Trailer License Plate:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_truck_trailer_plate']) && !empty($inspection[0]['si_truck_trailer_plate'])) $name=$inspection[0]['si_truck_trailer_plate']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Driver License Info:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_driver_info']) && !empty($inspection[0]['si_driver_info'])) $name=$inspection[0]['si_driver_info']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Truck trailer set, F:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_truck_set_temp']) && !empty($inspection[0]['si_truck_set_temp'])) $name=$inspection[0]['si_truck_set_temp']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Truck trailer reading tempetaure, F:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_truck_reading_temp']) && !empty($inspection[0]['si_truck_reading_temp'])) $name=$inspection[0]['si_truck_reading_temp']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Is Truck inside condition acceptable? 
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_truck_condition_acceptable']) && !empty($inspection[0]['si_truck_condition_acceptable'])) $name=$inspection[0]['si_truck_condition_acceptable']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Truck temp Frozen:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_frozen_product_temp']) && !empty($inspection[0]['si_frozen_product_temp'])) $name=$inspection[0]['si_frozen_product_temp']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Truck temp Refrigerated:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_refrigerated_product']) && !empty($inspection[0]['si_refrigerated_product'])) $name=$inspection[0]['si_refrigerated_product']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      First Product Surface Temp:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_first_product_surface_temp']) && !empty($inspection[0]['si_first_product_surface_temp'])) $name=$inspection[0]['si_first_product_surface_temp']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Last Product Surface Temp:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_last_product_surface_temp']) && !empty($inspection[0]['si_last_product_surface_temp'])) $name=$inspection[0]['si_last_product_surface_temp']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Are Product Condition Acceptable?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_product_condition_acceptable']) && !empty($inspection[0]['si_product_condition_acceptable'])) $name=$inspection[0]['si_product_condition_acceptable']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Are the trailer and materials free of signs of tampering?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_sign_of_temparing']) && !empty($inspection[0]['si_sign_of_temparing'])) $name=$inspection[0]['si_sign_of_temparing']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Is Trailer Secure?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_is_secured']) && !empty($inspection[0]['si_is_secured'])) $name=$inspection[0]['si_is_secured']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      If Sealed, Enter Seal #:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_seal_no']) && !empty($inspection[0]['si_seal_no'])) $name=$inspection[0]['si_seal_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Visual Verification of Product - Does Quantity/Lot Codes Match BOL/P.O.?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_is_bol']) && !empty($inspection[0]['si_is_bol'])) $name=$inspection[0]['si_is_bol']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Inspection Summary?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_inspection_summary']) && !empty($inspection[0]['si_inspection_summary'])) $name=$inspection[0]['si_inspection_summary']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Check Out Time:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['si_checkout_time']) && !empty($inspection[0]['si_checkout_time'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['si_checkout_time'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Follow-up action:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_followup_action']) && !empty($inspection[0]['si_followup_action'])) $name=$inspection[0]['si_followup_action']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Corrective Actions:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_corrective_action']) && !empty($inspection[0]['si_corrective_action'])) $name=$inspection[0]['si_corrective_action']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Lot # check: Verification of Product, Quantity vs. P.O. :
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_lot_number_check']) && !empty($inspection[0]['si_lot_number_check'])) $name=$inspection[0]['si_lot_number_check']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Lot Number:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_lot_number']) && !empty($inspection[0]['si_lot_number'])) $name=$inspection[0]['si_lot_number']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Status:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['si_status']) && !empty($inspection[0]['si_status'])) $name=$inspection[0]['si_status']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php $check =false;
                               if(isset($inspection[0]['si_review']) && !empty($inspection[0]['si_review']) && isset($inspection[0]['si_approve']) && !empty($inspection[0]['si_approve'])){
                                if($inspection[0]['si_review'] == $inspection[0]['si_approve'])
                                  $check = true;
                               } ?>
                              <?php if(isset($inspection[0]['si_review']) && !empty($inspection[0]['si_review'])) { ?>
                              <h3>Review Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                      Reviewed <?php if($check == true) echo "& Approved"; ?> By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['si_review']),'id desc','users','first_name,last_name','1','1')->result_array();
                                        $fisrt_name=''; 
                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                        $last_name=''; 
                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                          $last_name=$review_user_detail[0]['last_name']; 
                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name; 
                                         ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Reviewed <?php if($check == true) echo "& Approved"; ?> Date & time:
                                    </th>
                                    <td>
                                        <?php if(isset($inspection[0]['si_review_datetime']) && !empty($inspection[0]['si_review_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['si_review_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php } ?>
                              <?php if(isset($inspection[0]['si_approve']) && !empty($inspection[0]['si_approve']) && $check == false) { ?>
                              <h3>Approval Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                       Approved By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['si_approve']),'id desc','users','first_name,last_name','1','1')->result_array();
                                        $fisrt_name=''; 
                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                        $last_name=''; 
                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                          $last_name=$review_user_detail[0]['last_name']; 
                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name; 
                                         ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Approved Date & time:
                                    </th>
                                    <td>
                                        <?php if(isset($inspection[0]['si_approve_datetime']) && !empty($inspection[0]['si_approve_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['si_approve_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>      
                                </tbody>
                              </table>
                              <?php } ?>
                              <div class="status_value"><?=$status?></div>
                            </div>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!-- </div>-->
</div>
</div>