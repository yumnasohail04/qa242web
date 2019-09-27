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
                                        if(isset($inspection[0]['ri_initial']) && !empty($inspection[0]['ri_initial']))
                                          $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ri_initial']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                      <?php $name=''; if(isset($inspection[0]['ri_line']) && !empty($inspection[0]['ri_line'])) $name=$inspection[0]['ri_line']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Shift
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_shift']) && !empty($inspection[0]['ri_shift'])) $name=$inspection[0]['ri_shift']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Plant
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_plant']) && !empty($inspection[0]['ri_plant'])) $name=$inspection[0]['ri_plant']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h3>Source Detail</h3>
                              <table id="datatable1" class="table table-bordered">
                                <tbody class="table-body">
                                  <tr class="bg-col">
                                    <th>
                                      Check In Time:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['ri_datetime']) && !empty($inspection[0]['ri_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ri_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Item No.:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_item_no']) && !empty($inspection[0]['ri_source_item_no'])) $name=$inspection[0]['ri_source_item_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Product Temperature:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_product_temperature']) && !empty($inspection[0]['ri_source_product_temperature'])) $name=$inspection[0]['ri_source_product_temperature']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Brand Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_brand_name']) && !empty($inspection[0]['ri_source_brand_name'])) $name=$inspection[0]['ri_source_brand_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Product Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_product_name']) && !empty($inspection[0]['ri_source_product_name'])) $name=$inspection[0]['ri_source_product_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Allergens:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_allergens']) && !empty($inspection[0]['ri_source_allergens'])) $name=$inspection[0]['ri_source_allergens']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Cases Used:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_case_used']) && !empty($inspection[0]['ri_source_case_used'])) $name=$inspection[0]['ri_source_case_used']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Production Date:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['ri_source_production_date']) && !empty($inspection[0]['ri_source_production_date'])) {
                                          echo date('m-d-Y',strtotime($inspection[0]['ri_source_production_date'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Nav Lot Code:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_source_nav_lot_code']) && !empty($inspection[0]['ri_source_nav_lot_code'])) $name=$inspection[0]['ri_source_nav_lot_code']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h3>Pack Detail</h3>
                              <table id="datatable1" class="table table-bordered">
                                <tbody class="table-body">
                                  <tr class="bg-col">
                                    <th>
                                      Item No.:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_pack_item_no']) && !empty($inspection[0]['ri_pack_item_no'])) $name=$inspection[0]['ri_pack_item_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Brand Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_pack_brand_name']) && !empty($inspection[0]['ri_pack_brand_name'])) $name=$inspection[0]['ri_pack_brand_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Product Name:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_pack_product_name']) && !empty($inspection[0]['ri_pack_product_name'])) $name=$inspection[0]['ri_pack_product_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Allergens:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_pack_allergens']) && !empty($inspection[0]['ri_pack_allergens'])) $name=$inspection[0]['ri_pack_allergens']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Cases Made:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_pack_cases_made']) && !empty($inspection[0]['ri_pack_cases_made'])) $name=$inspection[0]['ri_pack_cases_made']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Selected Source:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_selected_source']) && !empty($inspection[0]['ri_selected_source'])) $name=$inspection[0]['ri_selected_source']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Expire Date:
                                    </th>
                                    <td>
                                      <?php if(isset($inspection[0]['ri_pack_exp_date']) && !empty($inspection[0]['ri_pack_exp_date'])) {
                                          echo date('m-d-Y',strtotime($inspection[0]['ri_pack_exp_date'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                      Comments:
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ri_comments']) && !empty($inspection[0]['ri_comments'])) $name=$inspection[0]['ri_comments']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php $check =false;
                               if(isset($inspection[0]['ri_review']) && !empty($inspection[0]['ri_review']) && isset($inspection[0]['ri_approve']) && !empty($inspection[0]['ri_approve'])){
                                if($inspection[0]['ri_review'] == $inspection[0]['ri_approve'])
                                  $check = true;
                               } ?>
                              <?php if(isset($inspection[0]['ri_review']) && !empty($inspection[0]['ri_review'])) { ?>
                              <h3>Review Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                      Reviewed <?php if($check == true) echo "& Approved"; ?> By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ri_review']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['ri_review_datetime']) && !empty($inspection[0]['ri_review_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ri_review_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php } ?>
                              <?php if(isset($inspection[0]['ri_approve']) && !empty($inspection[0]['ri_approve']) && $check == false) { ?>
                              <h3>Approval Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                       Approved By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ri_approve']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['ri_approve_datetime']) && !empty($inspection[0]['ri_approve_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ri_approve_datetime'])); 
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