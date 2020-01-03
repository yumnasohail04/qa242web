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
                                        if(isset($inspection[0]['ci_monitor_name']) && !empty($inspection[0]['ci_monitor_name']))
                                          $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ci_monitor_name']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                      <?php $name=''; if(isset($inspection[0]['ci_line']) && !empty($inspection[0]['ci_line'])) $name=$inspection[0]['ci_line']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Shift
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_shift']) && !empty($inspection[0]['ci_shift'])) $name=$inspection[0]['ci_shift']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <th>
                                       Plant
                                    </th>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_plant']) && !empty($inspection[0]['ci_plant'])) $name=$inspection[0]['ci_plant']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <h3>Check Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <thead class="bg-th">
                                    <tr class="bg-col">
                                        <th>Question</th>
                                        <th>Given Answer</th>
                                        <th>Correct Answer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-col">
                                        <td>
                                          Circle:
                                        </td>
                                        <td>
                                          <?php $name=''; if(isset($inspection[0]['ci_circle']) && !empty($inspection[0]['ci_circle'])) $name=$inspection[0]['ci_circle']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                        </td>
                                        <td>
                                          -
                                        </td>
                                    </tr>
                                    <tr class="bg-col">
                                        <td>
                                          Product Last Produced:
                                        </td>
                                        <td>
                                          <?php $name=''; if(isset($inspection[0]['ci_last_product']) && !empty($inspection[0]['ci_last_product'])) $name=$inspection[0]['ci_last_product']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                        </td>
                                        <td>
                                          -
                                        </td>
                                    </tr>
                                    <tr class="bg-col">
                                        <td>
                                          Allergn Profile:
                                        </td>
                                        <td>
                                          <?php $name=''; if(isset($inspection[0]['ci_allergen_profile']) && !empty($inspection[0]['ci_allergen_profile'])) $name=$inspection[0]['ci_allergen_profile']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                        </td>
                                        <td>
                                          -
                                        </td>
                                    </tr>
                                    <tr class="bg-col">
                                        <td>
                                          Product to be Started:
                                        </td>
                                        <td>
                                          <?php $name=''; if(isset($inspection[0]['ci_product_start']) && !empty($inspection[0]['ci_product_start'])) $name=$inspection[0]['ci_product_start']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                        </td>
                                        <td>
                                          -
                                        </td>
                                    </tr>
                                    <tr class="bg-col">
                                        <td>
                                          Allergn Profile:
                                        </td>
                                        <td>
                                          <?php $name=''; if(isset($inspection[0]['ci_allergen_second_profile']) && !empty($inspection[0]['ci_allergen_second_profile'])) $name=$inspection[0]['ci_allergen_second_profile']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                        </td>
                                        <td>
                                          -
                                        </td>
                                    </tr>
                                  <tr class="bg-col">
                                    <td>
                                      No visible food debris or contaminants on exposed food contact surfaces after allergen cleaning
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question1_answer']) && !empty($inspection[0]['ci_question1_answer'])) $name=$inspection[0]['ci_question1_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question1_correct_answer']) && !empty($inspection[0]['ci_question1_correct_answer'])) $name=$inspection[0]['ci_question1_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Verify product formulation and ingredients
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question2_answer']) && !empty($inspection[0]['ci_question2_answer'])) $name=$inspection[0]['ci_question2_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question2_correct_answer']) && !empty($inspection[0]['ci_question2_correct_answer'])) $name=$inspection[0]['ci_question1_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      All food contact surfaces conform to the Parameters/ Limits
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question3_answer']) && !empty($inspection[0]['ci_question3_answer'])) $name=$inspection[0]['ci_question3_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question3_correct_answer']) && !empty($inspection[0]['ci_question3_correct_answer'])) $name=$inspection[0]['ci_question3_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Filling mixer/ Dough mixer
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question4_answer']) && !empty($inspection[0]['ci_question4_answer'])) $name=$inspection[0]['ci_question4_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question4_correct_answer']) && !empty($inspection[0]['ci_question4_correct_answer'])) $name=$inspection[0]['ci_question4_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      770's / Agnelli machine parts, clean and knobs intact
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question5_answer']) && !empty($inspection[0]['ci_question5_answer'])) $name=$inspection[0]['ci_question5_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question5_correct_answer']) && !empty($inspection[0]['ci_question5_correct_answer'])) $name=$inspection[0]['ci_question5_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Beginning of pasteurizer - shaker/spreader
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question6_answer']) && !empty($inspection[0]['ci_question6_answer'])) $name=$inspection[0]['ci_question6_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question6_correct_answer']) && !empty($inspection[0]['ci_question6_correct_answer'])) $name=$inspection[0]['ci_question6_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      End of pasteurizer - vibrator
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question7_answer']) && !empty($inspection[0]['ci_question7_answer'])) $name=$inspection[0]['ci_question7_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question7_correct_answer']) && !empty($inspection[0]['ci_question7_correct_answer'])) $name=$inspection[0]['ci_question7_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Conveyors - pasteurizer & cooling conveyors
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question8_answer']) && !empty($inspection[0]['ci_question8_answer'])) $name=$inspection[0]['ci_question8_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question8_correct_answer']) && !empty($inspection[0]['ci_question8_correct_answer'])) $name=$inspection[0]['ci_question8_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Product entry to spiral freezer - Guides, Edges
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question9_answer']) && !empty($inspection[0]['ci_question9_answer'])) $name=$inspection[0]['ci_question9_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question9_correct_answer']) && !empty($inspection[0]['ci_question9_correct_answer'])) $name=$inspection[0]['ci_question9_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Spiral freezer, clean and light covers intact
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question10_answer']) && !empty($inspection[0]['ci_question10_answer'])) $name=$inspection[0]['ci_question10_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question10_correct_answer']) && !empty($inspection[0]['ci_question10_correct_answer'])) $name=$inspection[0]['ci_question10_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Spiral discharge area
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question11_answer']) && !empty($inspection[0]['ci_question11_answer'])) $name=$inspection[0]['ci_question11_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question11_correct_answer']) && !empty($inspection[0]['ci_question11_correct_answer'])) $name=$inspection[0]['ci_question11_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Incline conveyor's
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question12_answer']) && !empty($inspection[0]['ci_question12_answer'])) $name=$inspection[0]['ci_question12_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question12_correct_answer']) && !empty($inspection[0]['ci_question12_correct_answer'])) $name=$inspection[0]['ci_question12_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Pasta weighing machine-Ishida scale
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question13_answer']) && !empty($inspection[0]['ci_question13_answer'])) $name=$inspection[0]['ci_question13_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question13_correct_answer']) && !empty($inspection[0]['ci_question13_correct_answer'])) $name=$inspection[0]['ci_question13_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Discharge shoot to packaging
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question14_answer']) && !empty($inspection[0]['ci_question14_answer'])) $name=$inspection[0]['ci_question14_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question14_correct_answer']) && !empty($inspection[0]['ci_question14_correct_answer'])) $name=$inspection[0]['ci_question14_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Verify the bulk product by checking the filling
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question15_answer']) && !empty($inspection[0]['ci_question15_answer'])) $name=$inspection[0]['ci_question15_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question15_correct_answer']) && !empty($inspection[0]['ci_question15_correct_answer'])) $name=$inspection[0]['ci_question15_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      No product or residue from previews run (packaging)
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question16_answer']) && !empty($inspection[0]['ci_question16_answer'])) $name=$inspection[0]['ci_question16_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question16_correct_answer']) && !empty($inspection[0]['ci_question16_correct_answer'])) $name=$inspection[0]['ci_question16_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Employee glove & sleeve changes performed as necessary
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question17_answer']) && !empty($inspection[0]['ci_question17_answer'])) $name=$inspection[0]['ci_question17_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question17_correct_answer']) && !empty($inspection[0]['ci_question17_correct_answer'])) $name=$inspection[0]['ci_question17_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Coats/smocks and aprons changed
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question18_answer']) && !empty($inspection[0]['ci_question18_answer'])) $name=$inspection[0]['ci_question18_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question18_correct_answer']) && !empty($inspection[0]['ci_question18_correct_answer'])) $name=$inspection[0]['ci_question18_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Labeling is correct
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question19_answer']) && !empty($inspection[0]['ci_question19_answer'])) $name=$inspection[0]['ci_question19_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question19_correct_answer']) && !empty($inspection[0]['ci_question19_correct_answer'])) $name=$inspection[0]['ci_question19_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                  <tr class="bg-col">
                                    <td>
                                      Metal detector rejects removed
                                    </td>
                                    <td>
                                      <?php $name=''; if(isset($inspection[0]['ci_question20_answer']) && !empty($inspection[0]['ci_question20_answer'])) $name=$inspection[0]['ci_question20_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                    <td>
                                      <?php $name='-'; if(isset($inspection[0]['ci_question20_correct_answer']) && !empty($inspection[0]['ci_question20_correct_answer'])) $name=$inspection[0]['ci_question20_correct_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php $check =false;
                               if(isset($inspection[0]['ci_review']) && !empty($inspection[0]['ci_review']) && isset($inspection[0]['ci_approve']) && !empty($inspection[0]['ci_approve'])){
                                if($inspection[0]['si_review'] == $inspection[0]['ci_approve'])
                                  $check = true;
                               } ?>
                              <?php if(isset($inspection[0]['ci_review']) && !empty($inspection[0]['ci_review'])) { ?>
                              <h3>Review Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                      Reviewed <?php if($check == true) echo "& Approved"; ?> By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ci_review']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['ci_review_datetime']) && !empty($inspection[0]['ci_review_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ci_review_datetime'])); 
                                        } ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <?php } ?>
                              <?php if(isset($inspection[0]['ci_approve']) && !empty($inspection[0]['ci_approve']) && $check == false) { ?>
                              <h3>Approval Detail</h3>
                              <table class="table table-bordered" style="color: black !important">
                                <tbody>
                                  <tr class="bg-col">
                                    <th>
                                       Approved By
                                    </th>
                                    <td>
                                        <?php 
                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$inspection[0]['ci_approve']),'id desc','users','first_name,last_name','1','1')->result_array();
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
                                        <?php if(isset($inspection[0]['ci_approve_datetime']) && !empty($inspection[0]['ci_approve_datetime'])) {
                                          echo date('m-d-Y H:i:s',strtotime($inspection[0]['ci_approve_datetime'])); 
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


