
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
                            <div class="form-body">
                                  <?php if(isset($update_id) && !empty($update_id) && !empty($assign_id) && $function == "pending_review") {
                                    $product_check = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_id),'id desc',DEFAULT_OUTLET.'_product_checks','productid','1','1')->result_array();
                                    $product_id = ""; 
                                    if(isset($product_check[0]['productid']) && !empty($product_check[0]['productid']))
                                      $product_id = $product_check[0]['productid'];
                                    $prodct_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$product_id),'id desc',DEFAULT_OUTLET.'_product','product_title','1','1')->result_array();
                                    $assignmet_answers = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$update_id),'assign_ans_id desc',DEFAULT_OUTLET.'_assignment_answer','question_id,answer_id,user_id,comments,line_no,shift_no,answer_type,range','1','1')->result_array();
                                    $answered_user = "";
                                    if(isset($assignmet_answers[0]['user_id']) && !empty($assignmet_answers[0]['user_id']))
                                      $answered_user = $assignmet_answers[0]['user_id'];
                                    $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$answered_user),'id desc','users','user_name','1','1')->result_array();
                                   ?>                    
                                  <h3><?php if(isset($checkname)) echo $checkname;?></h3>        
                                  <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th>
                                                   Product name:
                                              </th>
                                              <td>
                                                <?php $name=''; if(isset($prodct_detail[0]['product_title']) && !empty($prodct_detail[0]['product_title'])) $name=$prodct_detail[0]['product_title']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  User name:
                                              </th>
                                              <td>
                                                  <?php $name=''; if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name'])) $name=$user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Line number:
                                              </th>
                                              <td>
                                                  <?php $name=''; if(isset($assignmet_answers[0]['line_no']) && !empty($assignmet_answers[0]['line_no'])) $name=$assignmet_answers[0]['line_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Shift detail:
                                              </th>
                                              <td>
                                                  <?php $name=''; if(isset($assignmet_answers[0]['shift_no']) && !empty($assignmet_answers[0]['shift_no'])) $name=$assignmet_answers[0]['shift_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Date & time:
                                              </th>
                                              <td>
                                                  <?php if(isset($assign_detail[0]['complete_datetime']) && !empty($assign_detail[0]['complete_datetime'])) {
                                                    echo date('m-d-Y H:i:s',strtotime($assign_detail[0]['complete_datetime'])); 
                                                  } ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Image/Video:
                                              </th>
                                              <td>
                                                  
                                              </td>
                                          </tr>
                                      </tbody>
                                </table>
                                <?php } ?>
                                <h3>Check Detail</h3>
                                <br>
                                 <h2>Choice Type Attributes</h2>
                                 <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6c9cde !important;">Attribute</th>
                                        <th style="color: #6c9cde !important;">Choice Type</th>
                                       
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($questions) && !empty($questions)){
                                        foreach($questions as $value){
                                        if($value['type']=="Choice"){?>
                                      <tr>
                                        <td><?php echo $value['question']; ?></td>
                                        <td><?php if(isset($value['choice_type'] ) && !empty($value['choice_type']))  echo $value['choice_type'];?></td>
                                        </tr>
                                      <?}}}?>
                                    </tbody>
                                  </table>
                                  <h2>Range Type Attributes</h2>
                                  <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6c9cde !important;">Attribute</th>
                                        <th style="color: #6c9cde !important;">Min Value</th>
                                        <th style="color: #6c9cde !important;">Max Value</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($questions) && !empty($questions)){
                                        foreach($questions as $value){
                                       if($value['type']=="Range"){ ?>
                                      <tr>
                                        <td><?php echo $value['question']; ?></td>
                                        <td><?php if(isset($value['min'] ) && !empty($value['min']))  echo $value['min'];?></td>
                                        <td><?php if(isset($value['max'] ) && $value['max']==1)  echo $value['max'];?></td>
                                      </tr>
                                      <?}}}?>
                                    </tbody>
                                  </table>
                                   <h2>Fixed  Attributes</h2>
                                  <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6c9cde !important;">Attribute</th>
                                        <th style="color: #6c9cde !important;">Value</th>
                                       
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($questions) && !empty($questions)){
                                        foreach($questions as $value){
                                         if($value['type']=="Fixed"){ ?>
                                      <tr>
                                        <td><?php echo $value['question']; ?></td>
                                        <td>-</td>
                                          
                                          </tr>
                                      <?}}}?>
                                    </tbody>
                                  </table>

                                 
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


