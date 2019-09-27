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
                        <h3>Initials</h3>
                        <table class="table table-bordered" style="color: black !important">
                          <tbody>
                            <tr class="bg-col">
                              <th>
                                Submited By
                              </th>
                              <td>
                                  <?php 
                                  if(isset($inspection[0]['pi_initials']) && !empty($inspection[0]['pi_initials']))
                                    $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['pi_initials']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                <?php $name=''; if(isset($inspection[0]['pi_line']) && !empty($inspection[0]['pi_line'])) $name=$inspection[0]['pi_line']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                 Shift
                              </th>
                              <td>
                                <?php $name=''; if(isset($inspection[0]['pi_shift']) && !empty($inspection[0]['pi_shift'])) $name=$inspection[0]['pi_shift']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                 Plant
                              </th>
                              <td>
                                <?php $name=''; if(isset($inspection[0]['pi_plant']) && !empty($inspection[0]['pi_plant'])) $name=$inspection[0]['pi_plant']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
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
                                <?php if(isset($inspection[0]['pi_time']) && !empty($inspection[0]['pi_time'])) {
                                    echo date('m-d-Y H:i:s',strtotime($inspection[0]['pi_time'])); 
                                  } ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                Item Number:
                              </th>
                              <td>
                                <?php $name=''; if(isset($inspection[0]['pi_item_number']) && !empty($inspection[0]['pi_item_number'])) $name=$inspection[0]['pi_item_number']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                Pallet Number:
                              </th>
                              <td>
                                <?php $name=''; if(isset($inspection[0]['pi_pallet_number']) && !empty($inspection[0]['pi_pallet_number'])) $name=$inspection[0]['pi_pallet_number']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                Cases:
                              </th>
                              <td>
                                <?php $name=''; if(isset($inspection[0]['pi_cases']) && !empty($inspection[0]['pi_cases'])) $name=$inspection[0]['pi_cases']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                Used by Date:
                              </th>
                              <td>
                                <?php if(isset($inspection[0]['pi_used_by_date']) && !empty($inspection[0]['pi_used_by_date'])) {
                                    echo date('m-d-Y',strtotime($inspection[0]['pi_used_by_date'])); 
                                  } ?>
                              </td>
                            </tr>
                            <tr class="bg-col">
                              <th>
                                Code Date:
                              </th>
                              <td>
                                <?php if(isset($inspection[0]['pi_code_date']) && !empty($inspection[0]['pi_code_date'])) {
                                    echo date('m-d-Y',strtotime($inspection[0]['pi_code_date'])); 
                                  } ?>
                              </td>
                            </tr>>
                            <tr class="bg-col">
                              <th>
                                Status:
                              </th>
                              <td>
                                <?php $name=''; if(isset($inspection[0]['pi_status']) && !empty($inspection[0]['pi_status'])) $name=$inspection[0]['pi_status']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <?php $check =false;
                         if(isset($inspection[0]['pi_review']) && !empty($inspection[0]['pi_review']) && isset($inspection[0]['pi_accept']) && !empty($inspection[0]['pi_accept'])){
                          if($inspection[0]['pi_review'] == $inspection[0]['pi_accept'])
                            $check = true;
                         } ?>
                        <?php if(isset($inspection[0]['pi_review']) && !empty($inspection[0]['pi_review'])) { ?>
                        <h3>Review Detail</h3>
                        <table class="table table-bordered" style="color: black !important">
                          <tbody>
                            <tr class="bg-col">
                              <th>
                                Reviewed <?php if($check == true) echo "& Approved"; ?> By
                              </th>
                              <td>
                                  <?php 
                                  $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['pi_review']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                  <?php if(isset($inspection[0]['pi_review_datetime']) && !empty($inspection[0]['pi_review_datetime'])) {
                                    echo date('m-d-Y H:i:s',strtotime($inspection[0]['pi_review_datetime'])); 
                                  } ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <?php } ?>
                        <?php if(isset($inspection[0]['pi_accept']) && !empty($inspection[0]['pi_accept']) && $check == false) { ?>
                        <h3>Approval Detail</h3>
                        <table class="table table-bordered" style="color: black !important">
                          <tbody>
                            <tr class="bg-col">
                              <th>
                                 Approved By
                              </th>
                              <td>
                                  <?php 
                                  $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['pi_accept']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                  <?php if(isset($inspection[0]['pi_accept_datetime']) && !empty($inspection[0]['pi_accept_datetime'])) {
                                    echo date('m-d-Y H:i:s',strtotime($inspection[0]['pi_accept_datetime'])); 
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


