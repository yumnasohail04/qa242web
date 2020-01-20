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
                                        if(isset($inspection[0]['bi_initial']) && !empty($inspection[0]['bi_initial']))
                                          $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['bi_initial']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                      <?php $name=''; if(isset($inspection[0]['bi_line']) && !empty($inspection[0]['bi_line'])) $name=$inspection[0]['bi_line']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Shift
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_shift']) && !empty($inspection[0]['bi_shift'])) $name=$inspection[0]['bi_shift']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Plant
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_plant']) && !empty($inspection[0]['bi_plant'])) $name=$inspection[0]['bi_plant']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
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
                                      <?php if(isset($inspection[0]['bi_datetime']) && !empty($inspection[0]['bi_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['bi_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Packing Operator:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_packing_operator']) && !empty($inspection[0]['bi_packing_operator'])) $name=$inspection[0]['bi_packing_operator']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Product Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_product_name']) && !empty($inspection[0]['bi_product_name'])) $name=$inspection[0]['bi_product_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Item Number:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_item_no']) && !empty($inspection[0]['bi_item_no'])) $name=$inspection[0]['bi_item_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Pallet Number:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_pallet_no']) && !empty($inspection[0]['bi_pallet_no'])) $name=$inspection[0]['bi_pallet_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Time In Cooler:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['bi_time_in_cooler']) && !empty($inspection[0]['bi_time_in_cooler'])) {
                                          echo date('H:i:s',strtotime($inspection[0]['bi_time_in_cooler'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Time Out Cooler:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['bi_time_out_cooler']) && !empty($inspection[0]['bi_time_out_cooler'])) {
                                          echo date('H:i:s',strtotime($inspection[0]['bi_time_out_cooler'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Temperature:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_temperature']) && !empty($inspection[0]['bi_temperature'])) $name=$inspection[0]['bi_temperature']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Corrective Action:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bi_corrective_action']) && !empty($inspection[0]['bi_corrective_action'])) $name=$inspection[0]['bi_corrective_action']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php $check =false;
                               if(isset($inspection[0]['bi_review']) && !empty($inspection[0]['bi_review']) && isset($inspection[0]['bi_approve']) && !empty($inspection[0]['bi_approve'])){
                                if($inspection[0]['bi_review'] == $inspection[0]['bi_approve'])
                                  $check = true;
                               } ?>
                              <?php if(isset($inspection[0]['bi_review']) && !empty($inspection[0]['bi_review'])) { ?>
                              <h3>Review Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                      Reviewed <?php if($check == true) echo "& Approved"; ?> By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['bi_review']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['bi_review_datetime']) && !empty($inspection[0]['bi_review_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['bi_review_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php } ?>
                              <?php if(isset($inspection[0]['bi_approve']) && !empty($inspection[0]['bi_approve']) && $check == false) { ?>
                              <h3>Approval Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                       Approved By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['bi_approve']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['bi_approve_datetime']) && !empty($inspection[0]['bi_approve_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['bi_approve_datetime'])); 
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


