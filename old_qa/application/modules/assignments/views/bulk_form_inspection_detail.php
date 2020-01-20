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
                                        if(isset($inspection[0]['bfi_initial']) && !empty($inspection[0]['bfi_initial']))
                                          $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['bfi_initial']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                      <?php $name=''; if(isset($inspection[0]['bfi_line']) && !empty($inspection[0]['bfi_line'])) $name=$inspection[0]['bfi_line']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Shift
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_shift']) && !empty($inspection[0]['bfi_shift'])) $name=$inspection[0]['bfi_shift']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Plant
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_plant']) && !empty($inspection[0]['bfi_plant'])) $name=$inspection[0]['bfi_plant']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
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
                                      <?php if(isset($inspection[0]['bfi_datetime']) && !empty($inspection[0]['bfi_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['bfi_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Date:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['bfi_date']) && !empty($inspection[0]['bfi_date'])) {
                                          echo date('m-d-Y',strtotime($inspection[0]['bfi_date'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Item:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_item']) && !empty($inspection[0]['bfi_item'])) $name=$inspection[0]['bfi_item']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Lot Code:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_lotcode']) && !empty($inspection[0]['bfi_lotcode'])) $name=$inspection[0]['bfi_lotcode']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Exp Date:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['bfi_expdate']) && !empty($inspection[0]['bfi_expdate'])) {
                                          echo date('m-d-Y',strtotime($inspection[0]['bfi_expdate'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Time:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_time']) && !empty($inspection[0]['bfi_time'])) $name=$inspection[0]['bfi_time']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Allergen:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_allergen']) && !empty($inspection[0]['bfi_allergen'])) $name=$inspection[0]['bfi_allergen']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Quantity:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_quantity']) && !empty($inspection[0]['bfi_quantity'])) $name=$inspection[0]['bfi_quantity']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Pallet Number:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['bfi_pallet_no']) && !empty($inspection[0]['bfi_pallet_no'])) $name=$inspection[0]['bfi_pallet_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php $check =false;
                               if(isset($inspection[0]['bfi_review']) && !empty($inspection[0]['bfi_review']) && isset($inspection[0]['bfi_approve']) && !empty($inspection[0]['bfi_approve'])){
                                if($inspection[0]['bfi_review'] == $inspection[0]['bfi_approve'])
                                  $check = true;
                               } ?>
                              <?php if(isset($inspection[0]['bfi_review']) && !empty($inspection[0]['bfi_review'])) { ?>
                              <h3>Review Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                      Reviewed <?php if($check == true) echo "& Approved"; ?> By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['bfi_review']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['bfi_review_datetime']) && !empty($inspection[0]['bfi_review_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['bfi_review_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php } ?>
                              <?php if(isset($inspection[0]['bfi_approve']) && !empty($inspection[0]['bfi_approve']) && $check == false) { ?>
                              <h3>Approval Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                       Approved By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['bfi_approve']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['bfi_approve_datetime']) && !empty($inspection[0]['bfi_approve_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['bfi_approve_datetime'])); 
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


