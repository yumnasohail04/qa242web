
<?php if(!isset($function)) $function=""; 
$assign_id = "";
if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid']))
  $assign_id = $assign_detail[0]['checkid'];
 ?>

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
                            <div class="form-body">  <!--                 
                                  <h3><?php if(isset($checkname)) echo $checkname;?></h3> -->
                              <table id="datatable1" class="table table-bordered">
                                <tbody class="table-body">
                                  <tr class="bg-col">
                                    <th>
                                      Monitor Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_monitor_name']) && !empty($inspection[0]['ti_monitor_name'])) $name=$inspection[0]['ti_monitor_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Time:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['ti_datetime']) && !empty($inspection[0]['ti_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ti_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Invoice No.:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_invoice_no']) && !empty($inspection[0]['ti_invoice_no'])) $name=$inspection[0]['ti_invoice_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Item Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_item_name']) && !empty($inspection[0]['ti_item_name'])) $name=$inspection[0]['ti_item_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Suppler Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_suppler_name']) && !empty($inspection[0]['ti_suppler_name'])) $name=$inspection[0]['ti_suppler_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Is Supplier and Product On the Approved List?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_suppler_approve']) && !empty($inspection[0]['ti_suppler_approve'])) $name=$inspection[0]['ti_suppler_approve']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Carrier Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_carrier_name']) && !empty($inspection[0]['ti_carrier_name'])) $name=$inspection[0]['ti_carrier_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Truck License Plate:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_truck_license']) && !empty($inspection[0]['ti_truck_license'])) $name=$inspection[0]['ti_truck_license']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Trailer License Plate:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_trailer_license']) && !empty($inspection[0]['ti_trailer_license'])) $name=$inspection[0]['ti_trailer_license']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Driver License Info:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_driver_license_info']) && !empty($inspection[0]['ti_driver_license_info'])) $name=$inspection[0]['ti_driver_license_info']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Is Trailer Secure?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_trailer_sealed']) && !empty($inspection[0]['ti_trailer_sealed'])) $name=$inspection[0]['ti_trailer_sealed']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Is Trailer Locked?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_trailer_locked']) && !empty($inspection[0]['ti_trailer_locked'])) $name=$inspection[0]['ti_trailer_locked']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Are the trailer and materials free of signs of tampering?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_signs_of_tampering']) && !empty($inspection[0]['ti_signs_of_tampering'])) $name=$inspection[0]['ti_signs_of_tampering']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Is Truck inside condition acceptable?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_truck_condition_acceptable']) && !empty($inspection[0]['ti_truck_condition_acceptable'])) $name=$inspection[0]['ti_truck_condition_acceptable']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Are Product Condition (# damaged)/Pallet Condition (not broken, smelly,contaminated):
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_product_condition']) && !empty($inspection[0]['ti_product_condition'])) $name=$inspection[0]['ti_product_condition']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Product Temperature:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_product_temperature']) && !empty($inspection[0]['ti_product_temperature'])) $name=$inspection[0]['ti_product_temperature']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Visual Verification of Product:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_visual_verification']) && !empty($inspection[0]['ti_visual_verification'])) $name=$inspection[0]['ti_visual_verification']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Allergen Verification:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_allergen_verification']) && !empty($inspection[0]['ti_allergen_verification'])) $name=$inspection[0]['ti_allergen_verification']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      If Product Contains Allergens?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_contains_allergen']) && !empty($inspection[0]['ti_contains_allergen'])) $name=$inspection[0]['ti_contains_allergen']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Was the Product Marked with Expiration Date?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_expiration_date']) && !empty($inspection[0]['ti_expiration_date'])) $name=$inspection[0]['ti_expiration_date']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Inspection Summary?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_summery']) && !empty($inspection[0]['ti_summery'])) $name=$inspection[0]['ti_summery']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Follow-up Action?
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_follow_up_action']) && !empty($inspection[0]['ti_follow_up_action'])) $name=$inspection[0]['ti_follow_up_action']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Corrective Action Detail:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_corrective_action']) && !empty($inspection[0]['ti_corrective_action'])) $name=$inspection[0]['ti_corrective_action']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Status:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ti_status']) && !empty($inspection[0]['ti_status'])) $name=$inspection[0]['ti_status']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php $check =false;
                               if(isset($inspection[0]['ti_review']) && !empty($inspection[0]['ti_review']) && isset($inspection[0]['ti_approve']) && !empty($inspection[0]['ti_approve'])){
                                if($inspection[0]['ti_review'] == $inspection[0]['ti_approve'])
                                  $check = true;
                               } ?>
                              <?php if(isset($inspection[0]['ti_review']) && !empty($inspection[0]['ti_review'])) { ?>
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
                                        <?php if(isset($inspection[0]['ti_review_datetime']) && !empty($inspection[0]['ti_review_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ti_review_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php } ?>
                              <?php if(isset($inspection[0]['ti_approve']) && !empty($inspection[0]['ti_approve']) && $check == false) { ?>
                              <h3>Approval Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                       Approved By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ti_approve']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['ti_approve_datetime']) && !empty($inspection[0]['ti_approve_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ti_approve_datetime'])); 
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