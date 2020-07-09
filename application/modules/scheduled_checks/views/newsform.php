<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>pretty-checkbox.min.css">
<style type="text/css">
   /*.pretty.p-default input~.state label:before {
    border: 1px solid red !important;
  }*/
  /*.pretty.p-default input:checked~.state label:before {
    border: 1px solid #bdc3c7 !important;
  }*/

  .select2-search__field {
    width: 100% !important;
  }
  .select2-selection.select2-selection--multiple {
    border-color: rgb(221, 230, 233);
  }
  .check_set
  {
          margin-left: -30%!important;
  }
</style>
<?php include_once("select_box.php");?>
<style type="text/css">
   .stepwizard-step p {
   margin-top: 10px;
       font-size: 15px;
       color: #656565;

   }
   .stepwizard-row {
   display: table-row;
   }
   .stepwizard {
   display: table;
   width: 100%;
   position: relative;
   }
   .stepwizard-step button[disabled] {
   background-color: #F7D16E;
   }
   .stepwizard-row:before {
   top: 8px;
   bottom: 0;
   position: absolute;
   content: " ";
   width: 100%;
   height: 1px;
   background-color: #ccc;
   z-order: 0;
   }
   .stepwizard-step {
   display: table-cell;
   text-align: center;
   position: relative;
   }
   .btn-circle {
   width: 30px;
   height: 30px;
   text-align: center;
   padding: 6px 0;
   font-size: 12px;
   line-height: 1.428571429;
   border-radius: 15px;
   }
   .setting_multiselect {
    width: 100% !important;
    box-shadow: 0 0 0 #000 !important;
   }
   .select2-container{
        width: 100% !important;
   }
</style>
<div class="page-content-wrapper">
   <div class="page-content">
      <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
      <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                  <h4 class="modal-title">Modal title</h4>
               </div>
               <div class="modal-body"> Widget settings form goes here </div>
               <div class="modal-footer">
                  <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
                  <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
               </div>
            </div>
            <!-- /.modal-content --> 
         </div>
         <!-- /.modal-dialog --> 
      </div>
      <!-- /.modal --> 
      <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM--> 
      <!-- BEGIN PAGE HEADER-->
      <div class="content-wrapper">
         <!-- BEGIN PAGE TITLE & BREADCRUMB-->
         <h3>
            <?php 
               if (empty($update_id)) 
                           $strTitle = 'QA Checks';
                       else 
                            $strTitle = 'QA Checks';
                           echo $strTitle;
                           ?>
            <a href="<?php echo ADMIN_BASE_URL . 'scheduled_checks'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
         </h3>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="tabbable tabbable-custom boxless">
               <div class="tab-content">
                  <div class="panel panel-default" style="border-radius:10px;">
                     <div class="tab-pane  active" id="tab_2" >
                        <div class="portlet box green ">
                           <div class="portlet-title ">
                           </div>
                           <div class="portlet-body form " style="padding-top:15px;width:100%;">
                              <!-- BEGIN FORM-->
                              <?php
                                 $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal','role'=>"form");
                                 if (empty($update_id)) {
                                     $update_id = 0;
                                 } else {
                                     $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); 
                                 }
                                 if (isset($hidden) && !empty($hidden))
                                     echo form_open_multipart(ADMIN_BASE_URL . 'scheduled_checks/submit/' . $update_id, $attributes, $hidden);
                                 else
                                     echo form_open_multipart(ADMIN_BASE_URL . 'scheduled_checks/submit/' . $update_id, $attributes);
                                 ?>
                              <div class="stepwizard">
                                 <div class="stepwizard-row setup-panel">
                                    <div class="stepwizard-step">
                                       <a href="javascript:;" tab_id="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                                       <p>QA Checks</p>
                                    </div>
                                    <div class="stepwizard-step">
                                       <a href="javascript:;" tab_id="#step-2" type="button" class="btn btn-default btn-circle" >2</a>
                                       <p id="checkheading"><?if($update_id >0 && $news['checktype']=="product attribute") echo 'Product';else echo 'Check';?> Attributes</p>
                                    </div>
                                    <div class="stepwizard-step">
                                       <a href="javascript:;" tab_id="#step-3" type="button" class="btn btn-default btn-circle" >3</a>
                                       <p>Responsible Team</p>
                                    </div>
                                    <div class="stepwizard-step">
                                       <a href="javascript:;" tab_id="#step-4" type="button" class="btn btn-default btn-circle" >4</a>
                                       <p>Scheduling</p>
                                    </div>
                                 </div>
                              </div>
                              <br>
                              <form role="form">
                                 <div class="row setup-content" id="step-1">
                                    <div class="col-xs-12">
                                       <div class="col-md-12">
                                          <h3 style="margin-left: 15px;">QA Checks</h3>
                                          <div class="col-sm-8" style="display:none;">
                                             <div class="form-group">
                                                <?php  $news['checktype']="scheduled_checks"; $checks = array('product attribute'=>"Product Atrribute","scheduled_checks"=>"scheduled_checks");
                                                   if(!isset($news['checktype'])) $news['checktype'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$checks ;
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   echo form_label('Select Check Type <span style="color:red">*</span>', 'role_id', $attribute);?>
                                                <div class="col-md-8">
                                                   <?php echo form_dropdown('checktype', $options, $news['checktype'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                                                </div>
                                             </div>
                                          </div>
                                           <div class="col-sm-8 gen_checktype" <?php if( $news['checktype']=="product attribute") echo ' style="display: none;"';?>>
                                             <div class="form-group">
                                                <?php  $checks = $arr_process;
                                                   if(!isset($news['check_cat_id'])) $news['check_cat_id'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$checks ;
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   echo form_label('Select Process Step <span style="color:red">*</span>', 'role_id', $attribute);?>
                                                <div class="col-md-8">
                                                   <?php echo form_dropdown('check_cat_id', $options, $news['check_cat_id'],  'class="form-control select3me  validatefield" id="category_id" tabindex ="8"'); ?>
                                                </div>
                                            </div>
                                          </div>
                                           <div class="col-sm-8 gen_subchecktyp" <?php if($update_id==0 || $news['checktype']=="product attribute") echo ' style="display: none;"';?>>
                                             <div class="form-group" >

                                                <?php if(!empty($arr_sub)) $sub_catchecks =$arr_sub;else $sub_catchecks=array();
                                                   if(!isset($news['check_subcat_id'])) $news['check_subcat_id'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$sub_catchecks ;
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   echo form_label('Process Check Type <span style="color:red">*</span>', 'role_id', $attribute);?>
                                                <div class="col-md-8" id="gen_subchecktyp">
                                                <?php if($update_id >0 && $news['checktype']=="scheduled_checks"){?>
                                                     <?php echo form_dropdown('check_subcat_id', $options, $news['check_subcat_id'],  'class="form-control select4me  validatefield" id="subcategory_id" tabindex ="8"'); ?>
                                                  <?}else{?>
                                                     <select class="form-control   validatefield category_id select4me" id="subcategory_id" tabindex ="8" name="check_subcat_id">

                                                   </select>
                                                  <?}?>
                                                  
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-sm-8 gen_program_type" <?php if($update_id==0 || $news['checktype']=="product attribute") echo ' style="display: none;"';?>>
                                            <div class="form-group" >
                                                <label for="role_id" class="control-label col-md-4">
                                                  Program Type: <span style="color:red">*</span>
                                                </label>
                                                <div class="col-md-8">
                                                  <select multiple="multiple" class="form-control program_type  chosen-select " name="program_type[]" required="required">
                                                    <?php 
                                                      if(!isset($program_type)) 
                                                          $program_type = array();
                                                      if(!isset($selected_program))
                                                          $selected_program = array();
                                                      if(!empty($program_type)) {
                                                          foreach ($program_type as $pt_key => $pt):
                                                              $checking = array_search($pt['program_id'], array_column($selected_program, 'cpt_program_type'));
                                                            if($pt['program_status'] != 0 || is_numeric($checking)) { ?>
                                                              <option value="<?=$pt['program_id']?>" <?php if(is_numeric($checking)) echo 'selected="selected"'; ?>>
                                                                <?=$pt['program_name']?>
                                                              </option>
                                                            <?php }
                                                          endforeach;
                                                      }
                                                  ?>
                                                  </select>
                                                </div>
                                            </div>
                                          </div>
                                           <div class="col-sm-8 product-select" <?php if(empty($update_id) || $news['productid']==0) echo ' style="display: none;"'?>>
                                             <div class="form-group select_box">
                                                <?php  if(!isset($products)) $products = array();
                                                   if(!isset($news['productid'])) $news['productid'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$products ;
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   echo form_label('Select Product <span style="color:red">*</span>', 'product_id', $attribute);?>
                                                <div class="col-md-8">
                                                   <?php echo form_dropdown('productid', $options, $news['productid'],  'class="form-control select_attributes   required validatefield selectpicker show-tick" data-live-search="true" id="product_id" tabindex ="8"'); ?>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-sm-8">
                                             <div class="form-group">
                                                <?php
                                                   $data = array(
                                                       'name' => 'checkname',
                                                       'id' => 'checkname',
                                                       'class' => 'form-control',
                                                       'value' =>$news['checkname'],
                                                       'type' => 'text',
                                                       'required' => 'required',
                                                       'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                   );
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   ?>
                                                <?php echo form_label('Enter Check Name <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                                <div class="col-md-8">
                                                   <?php echo form_input($data); ?>
                                                </div>
                                             </div>
                                          </div>
                                           <div class="col-sm-8">
                                             <div class="form-group">
                                                <?php
                                                   $data = array(
                                                       'name' => 'check_desc',
                                                        'id' => 'check_desc',
                                                        'rows' => '5',
                                                        'cols' => '10',
                                                        'class' => 'form-control ',
                                                        'data-parsley-maxlength'=>500,
                                                        'value' => $news['check_desc']
                                                   );
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   ?>
                                                <?php echo form_label('Enter Check Description <span class="required" style="color:#ff60a3"></span>', 'txtNewsTitle', $attribute); ?>
                                                <div class="col-md-8">
                                                   <?php echo form_textarea($data); ?>
                                                </div>
                                             </div>
                                          </div>
                                        </br>
                                         
                                             <div class="col-sm-12">
                                          <button class="btn btn-primary nextBtn  pull-right" type="button" >Next</button>
                                        </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row setup-content" id="step-2" style="display: none;">
                                    <div class="col-xs-12">
                                       <div class="col-md-12">
                                          <h3 style="margin-left: 15px;">Current Attributes</h3>
                                          
                                          <input type="hidden" name="dependent_array" value="" id="dependent_array">
                                          <div class="section-box attr-chose">
                                            <?php if($update_id >0){?>
                                             <?php include('check_attributes.php');?>
                                             <?}?>

                                          </div>
                                             <button class="btn btn-primary nextBtn  pull-right" type="button" style="margin-top: 30px;margin-right: 42px;">Next</button>
                                           <button type="button" class="btn btn-primary btn-previous pull-right" style="margin-top: 30px;">Previous</button>
                                           <?php if($update_id >0){?>
                                             <button class="btn btn-success pull-left mt-30" id="add_attribute" type="button" style="margin-top: 30px;
    margin-left: 30px;">Add new Attribute</button>
     <?}?>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row setup-content" id="step-3" style="display: none;">
                                    <div class="col-xs-12">
                                      
                                        <div class="col-md-12">
                                          <h3 style="margin-left: 15px;">Select Responsible Team </h3>
                                          <div class="col-sm-5">
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label">Responsible Team </label>
                                                <div class="col-sm-8">
                                                    <select name="inspection_team[]" class="form-control chosen-select inspection_team" required="required" multiple>
                                                      <option >Select</option>
                                                      <?php if(!isset($groups) || empty($groups))
                                                              $groups = array();
                                                        foreach ($groups as $value): ?>
                                                          <option value="<?=$value['id']?>" 
                                                            <?php 
                                                            $exist = array_search($value['id'], array_column($inspection_team, 'sci_team_id'));
                                                            foreach($news as $new){ if(is_numeric($exist)) echo 'selected="selected"';}?>><?= $value['group_title']?>
                                                          </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                  </div>
                                             </div>
                                             
                                          </div>
                                          <div class="col-sm-5">
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label">Responsible For Review</label>
                                                <div class="col-sm-8">
                                                
                                                   <select  class="form-control restaurant_type" name="review_team" required="required">
                                                       <option >Select</option>
                                                      <?php
                                                        
                                                         if(!isset($groups) || empty($groups))
                                                             $groups = array();
                                                              if(!isset($news['review_team'])) $news['review_team'] = "";
                                                           foreach ($groups as $value): ?>
                                                      <option value="<?=$value['id']?>" <?php  
                                                       
                                                       if($value['id']== $news['review_team']) echo 'selected="selected"'; ?>><?= $value['group_title']?></option>
                                                      <?php endforeach ?>
                                                   </select>
                                                </div>
                                             </div>
                                             
                                          </div>
                                          <div class="col-sm-5">
                                             <div class="form-group">
                                                <label class="col-sm-4 control-label">Approval Team</label>
                                                <div class="col-sm-8">
                                                   <select  class=" form-control restaurant_type" name="approval_team" required="required">
                                                    <option >Select</option>
                                                      <?php
                                                         
                                                         if(!isset($groups) || empty($groups))
                                                             $groups = array();
                                                              if(!isset($news['approval_team'])) $news['approval_team'] = "";
                                                           foreach ($groups as $value): ?>
                                                      <option value="<?=$value['id']?>" <?php 
                                                       if($value['id']== $news['approval_team']) echo 'selected="selected"';?>><?= $value['group_title']?></option>
                                                      <?php endforeach ?>
                                                   </select>
                                                </div>
                                             </div>
                                             
                                          </div>
                                       </div>

                                       <button class="btn btn-primary nextBtn  pull-right" type="button" >Next</button>
                                       <button type="button" class="btn   btn-primary btn-previousss pull-right">Previous</button>
                                    </div>
                                 </div>
                                 <div class="row setup-content" id="step-4" style="display: none;">
                                    <div class="col-xs-12">
                                       <div class="col-md-5">
                                          <div class="col-sm-12">
                                             <div class="form-group">
                                                <?php  $frequency = array('30 Mins'=>"30 Mins",'hourly'=>"hourly",'Daily'=>'Daily','Shift'=>'Shift','Weekly'=>'Weekly','Monthly'=>'Monthly');
                                                   if(!isset($news['frequency'])) $news['frequency'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$frequency ;?>
                                                <?php echo form_label('Select Frequency <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                                <div class="col-md-8">
                                                   <?php echo form_dropdown('frequency', $options, $news['frequency'],  'class="form-control select2me required validatefield select_frequency" id="role_id" tabindex ="8"'); ?>
                                                </div>
                                             </div>
                                          </div>
                                        </div>
                                    	<div class="col-md-5">
                                          <div class="col-sm-12 " >
                                            <div class="form-group" id="select_shift" <?php if($update_id==0 || $news['frequency'] 
                                          !='Shift')echo 'style="display:none"; ';?>>
                                              <label for="txtCatName" class="control-label col-md-4">
                                                Select Shift<span class="red" style="color:red;">*</span>
                                              </label>
                                              <div class="col-md-8">
                                                <?php 
                                                  if(isset($update_id) && $update_id != 0)
                                                    $selected_option = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("cs_check_id"=>$update_id),'cs_id desc','cs_id',DEFAULT_OUTLET.'_check_shifts','cs_id,cs_shift','1','0','','','')->result_array();
                                                  else
                                                    $selected_option = array();
                                                  if(isset($update_id) && $update_id != 0)
                                                    $all_shifts = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array(),'shift_id desc','shift_id',DEFAULT_OUTLET.'_shifts','shift_id,shift_name,shift_status','1','0','','','')->result_array();
                                                  else
                                                    $all_shifts = array();
                                                  $html =  "";
                                                  foreach ($all_shifts as $key => $value):
                                                    if(isset($selected_option) &&  !empty($selected_option)) 
                                                      $check = array_search($value['shift_id'], array_column($selected_option, 'cs_shift'));
                                                    else
                                                        $check='===';
                                                    if (is_numeric($check) || $value['shift_status'] == '1') {
                                                      if(is_numeric($check))
                                                        $html .= '<option  value="'.$value['shift_id'].'" selected= selected >'.$value['shift_name'].'</option>';
                                                      else
                                                        $html .= '<option value="'.$value['shift_id'].'">'.$value['shift_name'].'</option>';
                                                    }
                                                  endforeach;
                                                ?>
                                                <select name="check_shift[]"   multiple="multiple" class = "select-1 form-control Item check_shift">
                                                  <?=$html?>
                                                </select>
                                              </div>
                                            </div>
                                            <?php unset($html);unset($all_options); ?>
                                          </div>
                                        </div>
                                        <div class="col-md-5 next_div">
                                          <div class="col-sm-12 " >
                                            <div class="form-group" id="shift_answer" <?php if($update_id==0 || $news['frequency'] 
                                          !='Shift')echo 'style="display:none"; ';?>>
                                              <label for="txtCatName" class="control-label col-md-4">
                                                Select Shift Timing<span class="red" style="color:red;">*</span>
                                              </label>
                                              <div class="col-md-8">
                                                <?php 
                                                  if(isset($update_id) && $update_id != 0)
                                                    $selected_option = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("fc_check_id"=>$update_id),'fc_id desc','fc_id',DEFAULT_OUTLET.'_checks_frequency','fc_id,fc_check_id,fc_frequency','1','0','','','')->result_array();
                                                  else
                                                    $selected_option = array();
                                                  $html =  "";
                                                  if(!isset($all_options))
                                                    $all_options = array('Start'=>'Start','Middle'=>'Middle','End'=>'End');
                                                  foreach ($all_options as $key => $value):
                                                    if(isset($selected_option) &&  !empty($selected_option)) 
                                                      $check = array_search($value, array_column($selected_option, 'fc_frequency'));
                                                    else
                                                        $check='===';
                                                    if (is_numeric($check))
                                                      $html .= '<option  value="'.$key.'" selected= selected >'.$value.'</option>';
                                                    else
                                                      $html .= '<option value="'.$key.'">'.$value.'</option>';
                                                  endforeach;
                                                ?>
                                                <select name="start_shift[]"   multiple="multiple" class = "select-1 form-control Item start_shift">
                                                  <?=$html?>
                                                </select>
                                              </div>
                                            </div>
                                            <?php unset($html);unset($all_options);?>
                                            <div class="form-group" id="weekly_answer" <?php if($update_id==0 || $news['frequency'] 
                                          !='Weekly')echo 'style="display:none"; ';?>>
                                              <label for="txtCatName" class="control-label col-md-4">
                                                Select Day<span class="red" style="color:red;">*</span>
                                              </label>
                                              <div class="col-md-8">
                                                <?php 
                                                  $html =  "";
                                                  if(!isset($all_options))
                                                    $all_options = array('Monday'=>'Monday','Tuesday'=>'Tuesday','Wednessday'=>'Wednessday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday','Sunday'=>'Sunday');
                                                  foreach ($all_options as $key => $value):
                                                    if(isset($selected_option) &&  !empty($selected_option)) 
                                                      $check = array_search($value, array_column($selected_option, 'fc_frequency'));
                                                    else
                                                        $check='===';
                                                    if (is_numeric($check))
                                                      $html .= '<option  value="'.$key.'" selected= selected >'.$value.'</option>';
                                                    else
                                                      $html .= '<option value="'.$key.'">'.$value.'</option>';
                                                  endforeach;
                                                ?>
                                                <select name="start_day[]"   multiple="multiple" class = "select-1 form-control Item week_type">
                                                  <?=$html?>
                                                </select>
                                              </div>
                                            </div>
                                            <?php unset($html);unset($all_options); ?>
                                            <div class="form-group" id="monthly_answer" <?php if($update_id==0 || $news['frequency'] 
                                          !='Monthly')echo 'style="display:none"; ';?>>
                                              <label for="txtCatName" class="control-label col-md-4">
                                                Select Month Day<span class="red" style="color:red;">*</span>
                                              </label>
                                              <div class="col-md-8">
                                                <?php 
                                                  $lsp = array();
                                                  $html =  "";
                                                  if(!isset($all_options)) {
                                                    for ($i=1; $i < 32; $i++)
                                                      $all_options[$i] = $i;
                                                  }
                                                  foreach ($all_options as $key => $value):
                                                    if(isset($selected_option) &&  !empty($selected_option)) 
                                                      $check = array_search($value, array_column($selected_option, 'fc_frequency'));
                                                    else
                                                        $check='===';
                                                    if (is_numeric($check))
                                                      $html .= '<option  value="'.$key.'" selected= selected >'.$value.'</option>';
                                                    else
                                                      $html .= '<option value="'.$key.'">'.$value.'</option>';
                                                  endforeach;
                                                ?>
                                                <select name="monthly_frequency[]"   multiple="multiple" class = "select-1 form-control Item monthly_type">
                                                  <?=$html?>
                                                </select>
                                              </div>
                                            </div>
                                            <?php unset($html);unset($all_options); ?>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                       <div class="col-sm-5">
                                        <div class="form-group">
                                          <div class="pretty p-default ">
                                                <label class="col-sm-4">Set Check duration</label>
                                            <input type="checkbox" name="is_dates" class="validate_form col-sm-8 check_set" <?php if(!empty($news['is_dates'])) echo 'checked="checked" value="1"'; ?> />
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                      
                                    <div class="col-xs-12 datetimeshow"  <?php if(!isset($news['is_dates']) || empty($news['is_dates'])) echo 'style="display: none;"';?>>
                                       <div class="col-sm-5">
                                          <?php $news_date='';
                                          
                                             if (isset($news['start_date']) && $news['start_date'] != "0000-00-00" && !empty($news['start_date']) && $news['start_date']!="1970-01-01") {
                                                 $news_date = date('m/d/Y', strtotime($news['start_date']));
                                                
                                             } else { 

                                              $news_date = date('m/d/Y');

                                                
                                             }
                                             ?>
                                          <div class="form-group">
                                             <?php
                                                $data = array(
                                                    'name' => 'start_date',
                                                    'id' => 'start_date',
                                                    'class' => 'form-control',
                                                    'value' => $news_date,
                                                    'type' => 'text',
                                                    'required' => '1',
                                                );
                                                $attribute = array('class' => 'control-label col-md-4');
                                                ?>
                                             <?php echo form_label('Start Date <span class="required" style="color:red">*</span>', 'start_date', $attribute); ?>
                                             <div class="col-md-8 input-group date datetimepicker2"> <?php echo form_input($data); ?> 
                                                <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-5">
                                          <?php $news_date='';
                                         
                                             if (isset($news['start_time']) && $news['start_time'] != "0000-00-00" && !empty($news['start_time'])) {
                                                 $news_date = date('H:i', strtotime($news['start_time']));
                                             } else { 
                                               $news_date = date('H:i');
                                             
                                                $timestamp =strtotime($news_date) + 60*60;
                                                $news_date = date('H:i', $timestamp);
                                                
                                             }
                                             
                                             ?>
                                          <div class="form-group">
                                             <?php
                                                $data = array(
                                                    'name' => 'start_time',
                                                    'id' => 'start_time',
                                                    'class' => 'form-control',
                                                    'value' => $news_date ,
                                                    'type' => 'text',
                                                    'required' => '1',
                                                );
                                                $attribute = array('class' => 'control-label col-md-4');
                                                ?>
                                             <?php echo form_label('Start time <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                             <div class="col-md-8 input-group date datetimepicker4"> <?php echo form_input($data); ?> 
                                                <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-5">
                                          <?php $news_date='';
                                             if (isset($news['end_date']) &&  $news['end_date'] != "0000-00-00" && !empty($news['end_date'])  && $news['start_date']!="1970-01-01") {
                                                 $news_date = date('m/d/Y', strtotime($news['end_date']));
                                             } else {
                                                 $news_date = date('m/d/Y');
                                             }
                                             ?>
                                          <div class="form-group">
                                             <?php
                                                $data = array(
                                                    'name' => 'end_date',
                                                    'id' => 'end_date',
                                                    'class' => 'form-control',
                                                    'value' => $news_date,
                                                    'type' => 'text',
                                                    'required' => '1',
                                                );
                                                $attribute = array('class' => 'control-label col-md-4');
                                                ?>
                                             <?php echo form_label('End date <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                             <div class="col-md-8 input-group date datetimepicker2"> <?php echo form_input($data); ?> 
                                                <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-sm-5">
                                          <?php $news_date='';
                                             if (isset($news['end_time']) && $news['end_time'] != "00:00" && !empty($news['end_time'])) {
                                                 $news_date = date('H:i', strtotime($news['end_time']));
                                             } else { 
                                               $news_date = date('H:i');
                                             
                                                $timestamp =strtotime($news_date) + 60*60;
                                                $news_date = date('H:i', $timestamp);
                                                
                                             }
                                             ?>
                                          <div class="form-group">
                                             <?php
                                                $data = array(
                                                    'name' => 'end_time',
                                                    'id' => 'end_time',
                                                    'class' => 'form-control',
                                                    'value' =>  $news_date,
                                                    'type' => 'text',
                                                    'required' => '1',
                                                );
                                                $attribute = array('class' => 'control-label col-md-4');
                                                ?>
                                             <?php echo form_label('End time <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                             <div class="col-md-8 input-group date datetimepicker4"> <?php echo form_input($data); ?> 
                                                <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    </br>
                                    <div class="form-actions fluid no-mrg">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                                                <span style="margin-left:40px"></span>
                                                <button type="button" class="btn  btn-primary btn-previous ">Previous</button>
                                                 <button type="submit" class="btn btn-primary btnsave"><i class="fa fa-check"></i>&nbsp;Save</button>
                                                <a href="<?php echo ADMIN_BASE_URL . 'scheduled_checks'; ?>">
                                                <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>

                                                </a> 
                                             </div>
                                          </div>
                                          <div class="col-md-6"> </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                              <br>
                              <!--    <div class="form-actions fluid no-mrg">
                                 <div class="row">
                                   <div class="col-md-6">
                                     <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                                      <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary btnsave"><i class="fa fa-check"></i>&nbsp;Save</button>
                                       <a href="<?php echo ADMIN_BASE_URL . 'scheduled_checks'; ?>">
                                       <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                                       </a> </div>
                                   </div>
                                   <div class="col-md-6"> </div>
                                 </div>
                                 </div> -->
                              <?php echo form_close(); ?> 
                              <!-- END FORM--> 
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>

<script type="text/javascript">
	$(document).off('click', '.btnsave').on('click', '.btnsave', function(e){
      e.preventDefault();
      var isValid = true;
      var select_frequency = $('.select_frequency').val();
      if(select_frequency == '' || select_frequency == null || select_frequency == 'undefined'|| select_frequency.toLowerCase() == 'select') {
        isValid = false;
        $('.select_frequency').css("border-color","#f05050");
      }
      else
        $('.select_frequency').css("border-color","#dde6e9");
      if(select_frequency == '' || select_frequency == null || select_frequency == 'undefined'|| select_frequency.toLowerCase() == 'select') {
        isValid = false;
        $('.select_frequency').css("border-color","#f05050");
      }
      else
        $('.select_frequency').css("border-color","#dde6e9");
      if(select_frequency.toLowerCase() == 'shift') {
        var start_shift = $('.start_shift').val();
        if(start_shift == '' || start_shift == null || start_shift == 'undefined') {
          isValid = false;
          $('.start_shift').parent().find('.select2-selection.select2-selection--multiple').css("border-color","#f05050");
        }
        else {
          $('.start_shift').parent().find('.select2-selection.select2-selection--multiple').css("border-color","rgb(221, 230, 233)");
        }
        var check_shift = $('.check_shift').val();
        if(check_shift == '' || check_shift == null || check_shift == 'undefined') {
          isValid = false;
          $('.check_shift').parent().find('.select2-selection.select2-selection--multiple').css("border-color","#f05050");
        }
        else
          $('.check_shift').parent().find('.select2-selection.select2-selection--multiple').css("border-color","rgb(221, 230, 233)");
      }
      if(isValid==false){
        $(document).ready(function() {toastr.warning("Select all required fields")});
      }
      else {
        var selection_arr=localStorage.getItem('selection_arr');

          $('#dependent_array').val(selection_arr);
          $('#form_sample_1').submit();
      } 
  });
 var checkattribute=false;
  var prev_value='<?=$news['checktype'] ?>';
 <?php if($update_id >0){?>
 checkattribute=true;
 <?}?>
  function allfunction() {
    var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');
    allWells.hide();
    navListItems.off('click').click(function (e) {
      if($('div.setup-panel div a').hasClass('tabs-check')){
        return
      }
      else {
        navListItems.addClass('tabs-check')
      }
      e.preventDefault();
      var $target = $($(this).attr('tab_id')),
      $item = $(this);
      if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-primary').addClass('btn-default');
        $item.addClass('btn-primary');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
      }
    });
    allNextBtn.off('click').click(function(){
      if(prev_value!=$('.select2me').val()){
        checkattribute=false;
      }
      prev_value=$('.select2me').val();
      var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[tab_id="#' + curStepBtn + '"]').parent().next().children("a"),
      curInputs = curStep.find("input[type='text'],input[type='url']"),
      isValid = true;
      $(".form-group").removeClass("has-error");
      for(var i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid){
          isValid = false;
          $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
      }
      if($('.select2me').val()=='' || $('.select2me').val()=='' || $('.select2me').val()==null ){
        $(".select2me").css("border-color","#f05050");
        isValid = false;
      }
      var select3me = $('.select3me').val();
      if(select3me=='' || select3me=='' || select3me==null || select3me.toLowerCase()== 'select'){
        $(".select3me").css("border-color","#f05050");
        isValid = false;
      }
      else
        $(".select3me").css("border-color","#dde6e9");
      var select4me = $('.select4me').val();
      if(select4me=='' || select4me=='' || select4me==null || select4me.toLowerCase()== 'select'){
        $(".select4me").css("border-color","#f05050");
        isValid = false;
      }
      else
        $(".select4me").css("border-color","#dde6e9");
      var program_select = $('.program_type').val();
      if(program_select == '' || program_select == null || program_select == 'undefined') {
        isValid = false;
        $('.program_type').parent().find('.chosen-choices').css("border-color","#f05050");
      }
      else
        $('.program_type').parent().find('.chosen-choices').css("border-color","#dde6e9");
      if($('.selectpicker').val() == '' && $('.select2me').val() == 'product attribute'){
        $(".selectpicker").css("border-color","#f05050");
        isValid = false;
      }
      if(isValid==false){
        $(document).ready(function() {toastr.warning("Select all required fields")});
      }
      if (isValid) {
        $('div.setup-panel div a').removeClass('tabs-check')
        $('div.setup-panel div a[tab_id="#' + curStepBtn + '"]').addClass('selected')
        if(curStepBtn == 'step-1'){
          $('attr-chose').html('')
          if($('.select2me').val() == 'product attribute' && checkattribute==false){
            var id = $('.select_attributes').val();
            checkattribute=true;
            //alert(id); return false;
            $(".row_add").remove();
            $request=1;
            $.ajax({
              type: 'POST',
              url: "<?=ADMIN_BASE_URL?>scheduled_checks/get_product_info",
              data: {'productid': id},
              async: false,
              success: function(test_body) {
                $('.section-box').html('');
                $('.section-box').append(test_body);
                allfunction()
                $request=2;
              }
            });
            // $('attr-chose').load('./productinfo.php')
          } 
          else if($('.select2me').val() == 'scheduled_checks'  && checkattribute==false) {
            checkattribute=true;
            qacheck();
          }
        }
      }
      nextStepWizard.removeAttr('disabled').trigger('click');
    });
  }
  allfunction()
  $('div.setup-panel div a.btn-primary').trigger('click');
  function qacheck(){
    var subcat_id=$('#subcategory_id').val();
    var upddate_id=<?=$update_id;?>;
    $.ajax({
      type: 'POST',
      url: "<?=ADMIN_BASE_URL?>scheduled_checks/get_general_checks_attributes",
      data: {'cat_id': subcat_id,'update_id':upddate_id},
      async: false,
      success: function(test_body) {
        $('.section-box').html('');
        $('.section-box').append(test_body);
        allfunction()
        $request=2;
      }
    });
    $('.choice-type').off('change').change(function(){
      $('.checkchoicetype').remove()
         if($(this).val() == 'range'){
            $('.section-box').append(rangeinput)  
         } else if ($(this).val() == 'choice'){
            $('.section-box').append(choiceinput)
            addmorechoice()
         }
      })
   }
   function addmorechoice(){
      $('.moreanswer').off('click').click(function(){
         $('.section-box').append(choiceinput)
         addmorechoice()
      })
   }
   $('.select2me').change(function(){
       checkattribute=false;
      $('.product-select').attr('style','display:none')
      if($('.select2me').val() == 'product attribute'){
         $('.product-select').attr('style','display:block')
         $('.gen_checktype').attr('style','display:none');
         $('#checkheading').text('Product Attributes');
         $('.gen_subchecktyp').attr('style','display:none');
         $('.gen_program_type').attr('style','display:none');
      }
      if($('.select2me').val() == 'scheduled_checks')
      {
        $('.gen_program_type').attr('style','display:block');
          $('.gen_checktype').attr('style','display:block')
          $('#checkheading').text('Check Attributes')

      }
   })
   
    $('#category_id').change(function(e){
      var cat_id=$(this).val();
      $.ajax({
        type: 'POST',
        url: "<?=ADMIN_BASE_URL?>scheduled_checks/get_sub_catagories",
        data: {'cat_id': cat_id},
        async: false,
        success: function(test_body) {
          $('#gen_subchecktyp select').html(test_body);
          $('.gen_subchecktyp').attr('style','display:block');
          $('.gen_program_type').attr('style','display:block');
        }
      });
    })

$('#subcategory_id').on('change', function (e) {
  checkattribute=false;
   
});
</script>
<script type="text/javascript">
  function myfunction(tss){
    var attr_id=$(tss).attr('attr_id');
    var checkid=$(tss).attr('checkid');
    var numItems = $('.remove_attribute').length;
    var selection_arr=JSON.parse(localStorage.getItem('selection_arr'));
    if(numItems >1){
      var attribute_val=$(tss).parent().parent().parent().parent().find(':selected').val();
      if(attr_id >0 ){
          swal({
          title : "Are you sure to delete the selected Post?",
          text : "You will not be able to recover this Post!",
          type : "warning",
          showCancelButton : true,
          confirmButtonColor : "#DD6B55",
          confirmButtonText : "Yes, delete it!",
          closeOnConfirm : false
        },
        function () {
          $.ajax({
            type: 'POST',
            url: "<?php echo  ADMIN_BASE_URL?>scheduled_checks/delete_specific_check_attribute",
            data: {'question_id': attr_id,'checkid':checkid},
            async: false,
            success: function() {
              $(tss).parent().parent().parent().parent().remove();
            }
          });
          swal("Deleted!", "Post has been deleted.", "success");
        });
        if(selection_arr!=null){
          index = selection_arr.findIndex(x => x.question_id==attr_id);
          if(index != -1 ){
            selection_arr.splice(index,1);
          }
        }
      }
      else {
        attr_val=attribute_val+'_new';
        if(selection_arr!=null){
          index = selection_arr.findIndex(x => x.question_id==attr_val);
          if(index != -1 ){
            selection_arr.splice(index,1);
          }
        }
        $(tss).parent().parent().parent().parent().remove();
      }
      if(selection_arr!=null){
          index = selection_arr.findIndex(x => x.attr_id==attribute_val);
          if(index != -1 ){
            selection_arr.splice(index,1);
          }
        }
      attr_array=JSON.parse(attr_array)
      index = attr_array.findIndex(x => x.attribute_id==attribute_val);
      if(index != -1 ){
        attr_array.splice(index,1);
      }
      attr_array=JSON.stringify(attr_array)
      localStorage.setItem("selection_arr",JSON.stringify(selection_arr))
    }
    
  }
</script>
<script type="text/javascript">
    $(document).ready(function () {
 // previous step
    $('.btn-previous').on('click', function () {
        $(this).parents('.setup-content').fadeOut(400, function () {
            $(this).prev().fadeIn();
        });
    });
     });
  </script>
  <script>
  $('.select_frequency').change(function(){
    $('.next_div').css("clear","none");
    if($('.select_frequency').val()=='Shift'){
      $('.next_div').css("clear","both");
      $('#select_shift').attr('style','display:block');
      $('#shift_answer').attr('style','display:block');
      $('#weekly_answer').attr('style','display:none');
      $('#monthly_answer').attr('style','display:none');
      $(".week_type").attr('required','required');
      $('.week_type').removeAttr("required");
      $(".monthly_type").removeAttr("required");
    }
    else if($('.select_frequency').val()=='Weekly'){
      $('#select_shift').attr('style','display:none');
      $('#shift_answer').attr('style','display:none');
      $('#weekly_answer').attr('style','display:block');
      $('#monthly_answer').attr('style','display:none');
      $(".shift_type").removeAttr("required");
      $('.week_type').attr('required','required');
      $(".monthly_type").removeAttr("required");
    }
    else if($('.select_frequency').val()=='Monthly'){
      $('#select_shift').attr('style','display:none');
      $('#shift_answer').attr('style','display:none');
      $('#weekly_answer').attr('style','display:none');
      $('#monthly_answer').attr('style','display:block');
      $(".shift_type").removeAttr("required");
      $('.week_type').removeAttr("required");
      $(".monthly_type").attr('required','required');
    }
    else {
      $('#select_shift').attr('style','display:none');
      $('#shift_answer').attr('style','display:none');
      $('#weekly_answer').attr('style','display:none');
      $('#monthly_answer').attr('style','display:none');
      $(".shift_type").removeAttr("required");
      $('.week_type').removeAttr("required");
      $(".monthly_type").removeAttr("required");
    }
  })
  $(".select2-selection").addClass("setting_multiselect");
  $(".select2-container").addClass("setting_multiselect");
  </script>
     <script type="text/javascript">
    $(document).ready(function () {
 // previous step

    $('.btn-previousss').on('click', function () {
         $('#step-2').show();
      $('#step-3').hide();
    });
     });
  </script>
    <!-- script For adding new attributes-->
  <script>
       $(document).on("click", "#add_attribute", function(event){
            event.preventDefault();
            var id = $('#category_id').val();
            var subid = $('#subcategory_id').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>scheduled_checks/get_new_attributs_list_from_db",
                data: {'id': id,'subid':subid},
                async: false,
                success: function(test_body) {
                    var test_desc = test_body;
                        //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                        $('#myModallarge1').modal('show')
                        //$("#myModal .modal-title").html(test_title);
                        $("#myModallarge1 .modal-body").html(test_desc);
                    }
                });
        });


 $(document).on("click", ".addto_attribute", function(event){
            event.preventDefault();
    
          
          var attribute_name=$(this).parent().parent().parent().parent().find('.select2me ').text();
          var attribute_id=$(this).parent().parent().parent().parent().find('.select2me ').val();
          var attribute_type=$(this).parent().parent().parent().parent().find('#attribute_type').val();
          var choice_type=$(this).parent().parent().parent().parent().find('.choice_type').val();
          var min_value=$(this).parent().parent().parent().parent().find('#min_value').val();
          var target_value=$(this).parent().parent().parent().parent().find('#target_val').val();
          var max_value=$(this).parent().parent().parent().parent().find('#max_value').val();
           
         var add_clone='';
           if(attribute_type==="Choice"){
                add_clone='<tr><td style="width:35%;!important"><div class="form-group"><div class="col-md-12"> <select name="new_attribute_name[]" class="form-control select2me required validatefield" id="product_id" tabindex="8"><option value="'+attribute_id+'">'+attribute_name+'</option> </select></div></div></td><td style="display:none;"><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_attribute_type[]" value="'+attribute_type+'" id="attribute_type" class="form-control" readonly="1" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td style="width:30%;">'+choice_type+'</td><td style="padding-top: 0px;width:20%"> <select   class="form-control dependent_attributes " id="dependent_attributes" attr_id="'+attribute_id+'_new" > </select> </td> <input type="hidden" name="new_possible_answers[]" value="'+choice_type+'"> <input type="hidden" name="new_min_value[]" value=""> <input type="hidden" name="new_max_value[]" value=""> <input type="hidden" name="new_target_val[]" value=""><td> <div class="form-group"> <div class="col-md-12" id="cities_cont"> <select name="page_rank[]" class="form-control chosen-select" id="rank"><option value="">Select</option><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option><option value="101">101</option><option value="102">102</option><option value="103">103</option><option value="104">104</option><option value="105">105</option><option value="106">106</option><option value="107">107</option><option value="108">108</option><option value="109">109</option><option value="110">110</option><option value="111">111</option><option value="112">112</option><option value="113">113</option><option value="114">114</option><option value="115">115</option><option value="116">116</option><option value="117">117</option><option value="118">118</option><option value="119">119</option><option value="120">120</option><option value="121">121</option><option value="122">122</option><option value="123">123</option><option value="124">124</option><option value="125">125</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="130">130</option><option value="131">131</option><option value="132">132</option><option value="133">133</option><option value="134">134</option><option value="135">135</option><option value="136">136</option><option value="137">137</option><option value="138">138</option><option value="139">139</option><option value="140">140</option><option value="141">141</option><option value="142">142</option><option value="143">143</option><option value="144">144</option><option value="145">145</option><option value="146">146</option><option value="147">147</option><option value="148">148</option><option value="149">149</option><option value="150">150</option><option value="151">151</option><option value="152">152</option><option value="153">153</option><option value="154">154</option><option value="155">155</option><option value="156">156</option><option value="157">157</option><option value="158">158</option><option value="159">159</option><option value="160">160</option><option value="161">161</option><option value="162">162</option><option value="163">163</option><option value="164">164</option><option value="165">165</option><option value="166">166</option><option value="167">167</option><option value="168">168</option><option value="169">169</option><option value="170">170</option><option value="171">171</option><option value="172">172</option><option value="173">173</option><option value="174">174</option><option value="175">175</option><option value="176">176</option><option value="177">177</option><option value="178">178</option><option value="179">179</option><option value="180">180</option><option value="181">181</option><option value="182">182</option><option value="183">183</option><option value="184">184</option><option value="185">185</option><option value="186">186</option><option value="187">187</option><option value="188">188</option><option value="189">189</option><option value="190">190</option><option value="191">191</option><option value="192">192</option><option value="193">193</option><option value="194">194</option><option value="195">195</option><option value="196">196</option><option value="197">197</option><option value="198">198</option><option value="199">199</option><option value="200">200</option><option value="201">201</option><option value="202">202</option><option value="203">203</option><option value="204">204</option><option value="205">205</option><option value="206">206</option><option value="207">207</option><option value="208">208</option><option value="209">209</option><option value="210">210</option><option value="211">211</option><option value="212">212</option><option value="213">213</option><option value="214">214</option><option value="215">215</option><option value="216">216</option><option value="217">217</option><option value="218">218</option><option value="219">219</option><option value="220">220</option><option value="221">221</option><option value="222">222</option><option value="223">223</option><option value="224">224</option><option value="225">225</option><option value="226">226</option><option value="227">227</option><option value="228">228</option><option value="229">229</option><option value="230">230</option><option value="231">231</option><option value="232">232</option><option value="233">233</option><option value="234">234</option><option value="235">235</option><option value="236">236</option><option value="237">237</option><option value="238">238</option><option value="239">239</option><option value="240">240</option><option value="241">241</option><option value="242">242</option><option value="243">243</option><option value="244">244</option><option value="245">245</option><option value="246">246</option><option value="247">247</option><option value="248">248</option><option value="249">249</option><option value="250">250</option><option value="251">251</option><option value="252">252</option><option value="253">253</option><option value="254">254</option><option value="255">255</option><option value="256">256</option><option value="257">257</option><option value="258">258</option><option value="259">259</option><option value="260">260</option><option value="261">261</option><option value="262">262</option><option value="263">263</option><option value="264">264</option><option value="265">265</option><option value="266">266</option><option value="267">267</option><option value="268">268</option><option value="269">269</option><option value="270">270</option><option value="271">271</option><option value="272">272</option><option value="273">273</option><option value="274">274</option><option value="275">275</option><option value="276">276</option><option value="277">277</option><option value="278">278</option><option value="279">279</option><option value="280">280</option><option value="281">281</option><option value="282">282</option><option value="283">283</option><option value="284">284</option><option value="285">285</option><option value="286">286</option><option value="287">287</option><option value="288">288</option><option value="289">289</option><option value="290">290</option><option value="291">291</option><option value="292">292</option><option value="293">293</option><option value="294">294</option><option value="295">295</option><option value="296">296</option><option value="297">297</option><option value="298">298</option><option value="299">299</option><option value="300">300</option><option value="301">301</option><option value="302">302</option><option value="303">303</option><option value="304">304</option><option value="305">305</option><option value="306">306</option><option value="307">307</option><option value="308">308</option><option value="309">309</option><option value="310">310</option><option value="311">311</option><option value="312">312</option><option value="313">313</option><option value="314">314</option><option value="315">315</option><option value="316">316</option><option value="317">317</option><option value="318">318</option><option value="319">319</option><option value="320">320</option><option value="321">321</option><option value="322">322</option><option value="323">323</option><option value="324">324</option><option value="325">325</option><option value="326">326</option><option value="327">327</option><option value="328">328</option><option value="329">329</option><option value="330">330</option><option value="331">331</option><option value="332">332</option><option value="333">333</option><option value="334">334</option><option value="335">335</option><option value="336">336</option><option value="337">337</option><option value="338">338</option><option value="339">339</option><option value="340">340</option><option value="341">341</option><option value="342">342</option><option value="343">343</option><option value="344">344</option><option value="345">345</option><option value="346">346</option><option value="347">347</option><option value="348">348</option><option value="349">349</option><option value="350">350</option><option value="351">351</option><option value="352">352</option><option value="353">353</option><option value="354">354</option><option value="355">355</option><option value="356">356</option><option value="357">357</option><option value="358">358</option><option value="359">359</option><option value="360">360</option><option value="361">361</option><option value="362">362</option><option value="363">363</option><option value="364">364</option><option value="365">365</option><option value="366">366</option><option value="367">367</option><option value="368">368</option><option value="369">369</option><option value="370">370</option><option value="371">371</option><option value="372">372</option><option value="373">373</option><option value="374">374</option><option value="375">375</option><option value="376">376</option><option value="377">377</option><option value="378">378</option><option value="379">379</option><option value="380">380</option><option value="381">381</option><option value="382">382</option><option value="383">383</option><option value="384">384</option><option value="385">385</option><option value="386">386</option><option value="387">387</option><option value="388">388</option><option value="389">389</option><option value="390">390</option><option value="391">391</option><option value="392">392</option><option value="393">393</option><option value="394">394</option><option value="395">395</option><option value="396">396</option><option value="397">397</option><option value="398">398</option><option value="399">399</option><option value="400">400</option><option value="401">401</option><option value="402">402</option><option value="403">403</option><option value="404">404</option><option value="405">405</option><option value="406">406</option><option value="407">407</option><option value="408">408</option><option value="409">409</option><option value="410">410</option><option value="411">411</option><option value="412">412</option><option value="413">413</option><option value="414">414</option><option value="415">415</option><option value="416">416</option><option value="417">417</option><option value="418">418</option><option value="419">419</option><option value="420">420</option><option value="421">421</option><option value="422">422</option><option value="423">423</option><option value="424">424</option><option value="425">425</option><option value="426">426</option><option value="427">427</option><option value="428">428</option><option value="429">429</option><option value="430">430</option><option value="431">431</option><option value="432">432</option><option value="433">433</option><option value="434">434</option><option value="435">435</option><option value="436">436</option><option value="437">437</option><option value="438">438</option><option value="439">439</option><option value="440">440</option><option value="441">441</option><option value="442">442</option><option value="443">443</option><option value="444">444</option><option value="445">445</option><option value="446">446</option><option value="447">447</option><option value="448">448</option><option value="449">449</option><option value="450">450</option><option value="451">451</option><option value="452">452</option><option value="453">453</option><option value="454">454</option><option value="455">455</option><option value="456">456</option><option value="457">457</option><option value="458">458</option><option value="459">459</option><option value="460">460</option><option value="461">461</option><option value="462">462</option><option value="463">463</option><option value="464">464</option><option value="465">465</option><option value="466">466</option><option value="467">467</option><option value="468">468</option><option value="469">469</option><option value="470">470</option><option value="471">471</option><option value="472">472</option><option value="473">473</option><option value="474">474</option><option value="475">475</option><option value="476">476</option><option value="477">477</option><option value="478">478</option><option value="479">479</option><option value="480">480</option><option value="481">481</option><option value="482">482</option><option value="483">483</option><option value="484">484</option><option value="485">485</option><option value="486">486</option><option value="487">487</option><option value="488">488</option><option value="489">489</option><option value="490">490</option><option value="491">491</option><option value="492">492</option><option value="493">493</option><option value="494">494</option><option value="495">495</option><option value="496">496</option><option value="497">497</option><option value="498">498</option><option value="499">499</option><option value="500">500</option></select> </div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <i style="color:#ffc735;" class="fa fa-times pull-right remove_attribute" data-org_id="0" data-outlet_id="0" onclick="myfunction(this)"   title="You can exclude this attribute from check"></i></div></div></td></tr>';
                $("#choice_table").append(add_clone);
               
           }else if(attribute_type==="Fixed"){
                 add_clone='<tr><td style="width:35%;!important"><div class="form-group"><div class="col-md-12"> <select name="new_attribute_name[]" class="form-control select2me required validatefield" id="product_id" tabindex="8"><option value="'+attribute_id+'">'+attribute_name+'</option> </select></div></div></td><td style="display:none;"><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_attribute_type[]" value="'+attribute_type+'" id="attribute_type" class="form-control" readonly="1" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td style="width:30%;"><h5>User will be asked to provide a text input</h5></td><td style="padding-top: 0px;width:20%"> <select   class="form-control dependent_attributes " id="dependent_attributes" attr_id="'+attribute_id+'_new" > </select> </td> <input type="hidden" name="new_possible_answers[]" value="0"> <input type="hidden" name="new_min_value[]" value=""> <input type="hidden" name="new_max_value[]" value=""> <input type="hidden" name="new_target_val[]" value=""><td> <div class="form-group"> <div class="col-md-12" id="cities_cont"> <select name="page_rank[]" class="form-control chosen-select" id="rank"><option value="">Select</option><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option><option value="101">101</option><option value="102">102</option><option value="103">103</option><option value="104">104</option><option value="105">105</option><option value="106">106</option><option value="107">107</option><option value="108">108</option><option value="109">109</option><option value="110">110</option><option value="111">111</option><option value="112">112</option><option value="113">113</option><option value="114">114</option><option value="115">115</option><option value="116">116</option><option value="117">117</option><option value="118">118</option><option value="119">119</option><option value="120">120</option><option value="121">121</option><option value="122">122</option><option value="123">123</option><option value="124">124</option><option value="125">125</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="130">130</option><option value="131">131</option><option value="132">132</option><option value="133">133</option><option value="134">134</option><option value="135">135</option><option value="136">136</option><option value="137">137</option><option value="138">138</option><option value="139">139</option><option value="140">140</option><option value="141">141</option><option value="142">142</option><option value="143">143</option><option value="144">144</option><option value="145">145</option><option value="146">146</option><option value="147">147</option><option value="148">148</option><option value="149">149</option><option value="150">150</option><option value="151">151</option><option value="152">152</option><option value="153">153</option><option value="154">154</option><option value="155">155</option><option value="156">156</option><option value="157">157</option><option value="158">158</option><option value="159">159</option><option value="160">160</option><option value="161">161</option><option value="162">162</option><option value="163">163</option><option value="164">164</option><option value="165">165</option><option value="166">166</option><option value="167">167</option><option value="168">168</option><option value="169">169</option><option value="170">170</option><option value="171">171</option><option value="172">172</option><option value="173">173</option><option value="174">174</option><option value="175">175</option><option value="176">176</option><option value="177">177</option><option value="178">178</option><option value="179">179</option><option value="180">180</option><option value="181">181</option><option value="182">182</option><option value="183">183</option><option value="184">184</option><option value="185">185</option><option value="186">186</option><option value="187">187</option><option value="188">188</option><option value="189">189</option><option value="190">190</option><option value="191">191</option><option value="192">192</option><option value="193">193</option><option value="194">194</option><option value="195">195</option><option value="196">196</option><option value="197">197</option><option value="198">198</option><option value="199">199</option><option value="200">200</option><option value="201">201</option><option value="202">202</option><option value="203">203</option><option value="204">204</option><option value="205">205</option><option value="206">206</option><option value="207">207</option><option value="208">208</option><option value="209">209</option><option value="210">210</option><option value="211">211</option><option value="212">212</option><option value="213">213</option><option value="214">214</option><option value="215">215</option><option value="216">216</option><option value="217">217</option><option value="218">218</option><option value="219">219</option><option value="220">220</option><option value="221">221</option><option value="222">222</option><option value="223">223</option><option value="224">224</option><option value="225">225</option><option value="226">226</option><option value="227">227</option><option value="228">228</option><option value="229">229</option><option value="230">230</option><option value="231">231</option><option value="232">232</option><option value="233">233</option><option value="234">234</option><option value="235">235</option><option value="236">236</option><option value="237">237</option><option value="238">238</option><option value="239">239</option><option value="240">240</option><option value="241">241</option><option value="242">242</option><option value="243">243</option><option value="244">244</option><option value="245">245</option><option value="246">246</option><option value="247">247</option><option value="248">248</option><option value="249">249</option><option value="250">250</option><option value="251">251</option><option value="252">252</option><option value="253">253</option><option value="254">254</option><option value="255">255</option><option value="256">256</option><option value="257">257</option><option value="258">258</option><option value="259">259</option><option value="260">260</option><option value="261">261</option><option value="262">262</option><option value="263">263</option><option value="264">264</option><option value="265">265</option><option value="266">266</option><option value="267">267</option><option value="268">268</option><option value="269">269</option><option value="270">270</option><option value="271">271</option><option value="272">272</option><option value="273">273</option><option value="274">274</option><option value="275">275</option><option value="276">276</option><option value="277">277</option><option value="278">278</option><option value="279">279</option><option value="280">280</option><option value="281">281</option><option value="282">282</option><option value="283">283</option><option value="284">284</option><option value="285">285</option><option value="286">286</option><option value="287">287</option><option value="288">288</option><option value="289">289</option><option value="290">290</option><option value="291">291</option><option value="292">292</option><option value="293">293</option><option value="294">294</option><option value="295">295</option><option value="296">296</option><option value="297">297</option><option value="298">298</option><option value="299">299</option><option value="300">300</option><option value="301">301</option><option value="302">302</option><option value="303">303</option><option value="304">304</option><option value="305">305</option><option value="306">306</option><option value="307">307</option><option value="308">308</option><option value="309">309</option><option value="310">310</option><option value="311">311</option><option value="312">312</option><option value="313">313</option><option value="314">314</option><option value="315">315</option><option value="316">316</option><option value="317">317</option><option value="318">318</option><option value="319">319</option><option value="320">320</option><option value="321">321</option><option value="322">322</option><option value="323">323</option><option value="324">324</option><option value="325">325</option><option value="326">326</option><option value="327">327</option><option value="328">328</option><option value="329">329</option><option value="330">330</option><option value="331">331</option><option value="332">332</option><option value="333">333</option><option value="334">334</option><option value="335">335</option><option value="336">336</option><option value="337">337</option><option value="338">338</option><option value="339">339</option><option value="340">340</option><option value="341">341</option><option value="342">342</option><option value="343">343</option><option value="344">344</option><option value="345">345</option><option value="346">346</option><option value="347">347</option><option value="348">348</option><option value="349">349</option><option value="350">350</option><option value="351">351</option><option value="352">352</option><option value="353">353</option><option value="354">354</option><option value="355">355</option><option value="356">356</option><option value="357">357</option><option value="358">358</option><option value="359">359</option><option value="360">360</option><option value="361">361</option><option value="362">362</option><option value="363">363</option><option value="364">364</option><option value="365">365</option><option value="366">366</option><option value="367">367</option><option value="368">368</option><option value="369">369</option><option value="370">370</option><option value="371">371</option><option value="372">372</option><option value="373">373</option><option value="374">374</option><option value="375">375</option><option value="376">376</option><option value="377">377</option><option value="378">378</option><option value="379">379</option><option value="380">380</option><option value="381">381</option><option value="382">382</option><option value="383">383</option><option value="384">384</option><option value="385">385</option><option value="386">386</option><option value="387">387</option><option value="388">388</option><option value="389">389</option><option value="390">390</option><option value="391">391</option><option value="392">392</option><option value="393">393</option><option value="394">394</option><option value="395">395</option><option value="396">396</option><option value="397">397</option><option value="398">398</option><option value="399">399</option><option value="400">400</option><option value="401">401</option><option value="402">402</option><option value="403">403</option><option value="404">404</option><option value="405">405</option><option value="406">406</option><option value="407">407</option><option value="408">408</option><option value="409">409</option><option value="410">410</option><option value="411">411</option><option value="412">412</option><option value="413">413</option><option value="414">414</option><option value="415">415</option><option value="416">416</option><option value="417">417</option><option value="418">418</option><option value="419">419</option><option value="420">420</option><option value="421">421</option><option value="422">422</option><option value="423">423</option><option value="424">424</option><option value="425">425</option><option value="426">426</option><option value="427">427</option><option value="428">428</option><option value="429">429</option><option value="430">430</option><option value="431">431</option><option value="432">432</option><option value="433">433</option><option value="434">434</option><option value="435">435</option><option value="436">436</option><option value="437">437</option><option value="438">438</option><option value="439">439</option><option value="440">440</option><option value="441">441</option><option value="442">442</option><option value="443">443</option><option value="444">444</option><option value="445">445</option><option value="446">446</option><option value="447">447</option><option value="448">448</option><option value="449">449</option><option value="450">450</option><option value="451">451</option><option value="452">452</option><option value="453">453</option><option value="454">454</option><option value="455">455</option><option value="456">456</option><option value="457">457</option><option value="458">458</option><option value="459">459</option><option value="460">460</option><option value="461">461</option><option value="462">462</option><option value="463">463</option><option value="464">464</option><option value="465">465</option><option value="466">466</option><option value="467">467</option><option value="468">468</option><option value="469">469</option><option value="470">470</option><option value="471">471</option><option value="472">472</option><option value="473">473</option><option value="474">474</option><option value="475">475</option><option value="476">476</option><option value="477">477</option><option value="478">478</option><option value="479">479</option><option value="480">480</option><option value="481">481</option><option value="482">482</option><option value="483">483</option><option value="484">484</option><option value="485">485</option><option value="486">486</option><option value="487">487</option><option value="488">488</option><option value="489">489</option><option value="490">490</option><option value="491">491</option><option value="492">492</option><option value="493">493</option><option value="494">494</option><option value="495">495</option><option value="496">496</option><option value="497">497</option><option value="498">498</option><option value="499">499</option><option value="500">500</option></select> </div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <i style="color:#ffc735;" class="fa fa-times pull-right remove_attribute" data-org_id="0"  onclick="myfunction(this)"  data-outlet_id="0" title="You can exclude this attribute from check"></i></div></div></td></tr>';
                $("#fixed_table").append(add_clone);
               
           }else if(attribute_type==="Range"){
                 add_clone='<tr><td style="width:35%;!important"><div class="form-group"><div class="col-md-12"> <select name="new_attribute_name[]" class="form-control select2me required validatefield" id="product_id" tabindex="8"><option value="'+attribute_id+'">'+attribute_name+'</option> </select></div></div></td><td style="padding-top: 0px;style="width:20%"> <select   class="form-control dependent_attributes " id="dependent_attributes" attr_id="'+attribute_id+'_new" > </select> </td><td style="display:none;"><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_attribute_type[]" value="'+attribute_type+'" id="attribute_type" class="form-control" readonly="1" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td><div class="form-group"><div class="col-md-8 " style="width:100%;"> <input type="text" name="new_min_value[]" value="'+min_value+'" id="min_value" class="form-control" required="required" placeholder="Required" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_target_val[]" value="'+target_value+'" id="target_val" class="form-control" placeholder="Required" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_max_value[]" value="'+max_value+'" id="max_value" class="form-control" placeholder="Required" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td> <input type="hidden" name="new_possible_answers[]" value="0"><td> <div class="form-group"> <div class="col-md-12" id="cities_cont"> <select name="page_rank[]" class="form-control chosen-select" id="rank"><option value="">Select</option><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option><option value="101">101</option><option value="102">102</option><option value="103">103</option><option value="104">104</option><option value="105">105</option><option value="106">106</option><option value="107">107</option><option value="108">108</option><option value="109">109</option><option value="110">110</option><option value="111">111</option><option value="112">112</option><option value="113">113</option><option value="114">114</option><option value="115">115</option><option value="116">116</option><option value="117">117</option><option value="118">118</option><option value="119">119</option><option value="120">120</option><option value="121">121</option><option value="122">122</option><option value="123">123</option><option value="124">124</option><option value="125">125</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="130">130</option><option value="131">131</option><option value="132">132</option><option value="133">133</option><option value="134">134</option><option value="135">135</option><option value="136">136</option><option value="137">137</option><option value="138">138</option><option value="139">139</option><option value="140">140</option><option value="141">141</option><option value="142">142</option><option value="143">143</option><option value="144">144</option><option value="145">145</option><option value="146">146</option><option value="147">147</option><option value="148">148</option><option value="149">149</option><option value="150">150</option><option value="151">151</option><option value="152">152</option><option value="153">153</option><option value="154">154</option><option value="155">155</option><option value="156">156</option><option value="157">157</option><option value="158">158</option><option value="159">159</option><option value="160">160</option><option value="161">161</option><option value="162">162</option><option value="163">163</option><option value="164">164</option><option value="165">165</option><option value="166">166</option><option value="167">167</option><option value="168">168</option><option value="169">169</option><option value="170">170</option><option value="171">171</option><option value="172">172</option><option value="173">173</option><option value="174">174</option><option value="175">175</option><option value="176">176</option><option value="177">177</option><option value="178">178</option><option value="179">179</option><option value="180">180</option><option value="181">181</option><option value="182">182</option><option value="183">183</option><option value="184">184</option><option value="185">185</option><option value="186">186</option><option value="187">187</option><option value="188">188</option><option value="189">189</option><option value="190">190</option><option value="191">191</option><option value="192">192</option><option value="193">193</option><option value="194">194</option><option value="195">195</option><option value="196">196</option><option value="197">197</option><option value="198">198</option><option value="199">199</option><option value="200">200</option><option value="201">201</option><option value="202">202</option><option value="203">203</option><option value="204">204</option><option value="205">205</option><option value="206">206</option><option value="207">207</option><option value="208">208</option><option value="209">209</option><option value="210">210</option><option value="211">211</option><option value="212">212</option><option value="213">213</option><option value="214">214</option><option value="215">215</option><option value="216">216</option><option value="217">217</option><option value="218">218</option><option value="219">219</option><option value="220">220</option><option value="221">221</option><option value="222">222</option><option value="223">223</option><option value="224">224</option><option value="225">225</option><option value="226">226</option><option value="227">227</option><option value="228">228</option><option value="229">229</option><option value="230">230</option><option value="231">231</option><option value="232">232</option><option value="233">233</option><option value="234">234</option><option value="235">235</option><option value="236">236</option><option value="237">237</option><option value="238">238</option><option value="239">239</option><option value="240">240</option><option value="241">241</option><option value="242">242</option><option value="243">243</option><option value="244">244</option><option value="245">245</option><option value="246">246</option><option value="247">247</option><option value="248">248</option><option value="249">249</option><option value="250">250</option><option value="251">251</option><option value="252">252</option><option value="253">253</option><option value="254">254</option><option value="255">255</option><option value="256">256</option><option value="257">257</option><option value="258">258</option><option value="259">259</option><option value="260">260</option><option value="261">261</option><option value="262">262</option><option value="263">263</option><option value="264">264</option><option value="265">265</option><option value="266">266</option><option value="267">267</option><option value="268">268</option><option value="269">269</option><option value="270">270</option><option value="271">271</option><option value="272">272</option><option value="273">273</option><option value="274">274</option><option value="275">275</option><option value="276">276</option><option value="277">277</option><option value="278">278</option><option value="279">279</option><option value="280">280</option><option value="281">281</option><option value="282">282</option><option value="283">283</option><option value="284">284</option><option value="285">285</option><option value="286">286</option><option value="287">287</option><option value="288">288</option><option value="289">289</option><option value="290">290</option><option value="291">291</option><option value="292">292</option><option value="293">293</option><option value="294">294</option><option value="295">295</option><option value="296">296</option><option value="297">297</option><option value="298">298</option><option value="299">299</option><option value="300">300</option><option value="301">301</option><option value="302">302</option><option value="303">303</option><option value="304">304</option><option value="305">305</option><option value="306">306</option><option value="307">307</option><option value="308">308</option><option value="309">309</option><option value="310">310</option><option value="311">311</option><option value="312">312</option><option value="313">313</option><option value="314">314</option><option value="315">315</option><option value="316">316</option><option value="317">317</option><option value="318">318</option><option value="319">319</option><option value="320">320</option><option value="321">321</option><option value="322">322</option><option value="323">323</option><option value="324">324</option><option value="325">325</option><option value="326">326</option><option value="327">327</option><option value="328">328</option><option value="329">329</option><option value="330">330</option><option value="331">331</option><option value="332">332</option><option value="333">333</option><option value="334">334</option><option value="335">335</option><option value="336">336</option><option value="337">337</option><option value="338">338</option><option value="339">339</option><option value="340">340</option><option value="341">341</option><option value="342">342</option><option value="343">343</option><option value="344">344</option><option value="345">345</option><option value="346">346</option><option value="347">347</option><option value="348">348</option><option value="349">349</option><option value="350">350</option><option value="351">351</option><option value="352">352</option><option value="353">353</option><option value="354">354</option><option value="355">355</option><option value="356">356</option><option value="357">357</option><option value="358">358</option><option value="359">359</option><option value="360">360</option><option value="361">361</option><option value="362">362</option><option value="363">363</option><option value="364">364</option><option value="365">365</option><option value="366">366</option><option value="367">367</option><option value="368">368</option><option value="369">369</option><option value="370">370</option><option value="371">371</option><option value="372">372</option><option value="373">373</option><option value="374">374</option><option value="375">375</option><option value="376">376</option><option value="377">377</option><option value="378">378</option><option value="379">379</option><option value="380">380</option><option value="381">381</option><option value="382">382</option><option value="383">383</option><option value="384">384</option><option value="385">385</option><option value="386">386</option><option value="387">387</option><option value="388">388</option><option value="389">389</option><option value="390">390</option><option value="391">391</option><option value="392">392</option><option value="393">393</option><option value="394">394</option><option value="395">395</option><option value="396">396</option><option value="397">397</option><option value="398">398</option><option value="399">399</option><option value="400">400</option><option value="401">401</option><option value="402">402</option><option value="403">403</option><option value="404">404</option><option value="405">405</option><option value="406">406</option><option value="407">407</option><option value="408">408</option><option value="409">409</option><option value="410">410</option><option value="411">411</option><option value="412">412</option><option value="413">413</option><option value="414">414</option><option value="415">415</option><option value="416">416</option><option value="417">417</option><option value="418">418</option><option value="419">419</option><option value="420">420</option><option value="421">421</option><option value="422">422</option><option value="423">423</option><option value="424">424</option><option value="425">425</option><option value="426">426</option><option value="427">427</option><option value="428">428</option><option value="429">429</option><option value="430">430</option><option value="431">431</option><option value="432">432</option><option value="433">433</option><option value="434">434</option><option value="435">435</option><option value="436">436</option><option value="437">437</option><option value="438">438</option><option value="439">439</option><option value="440">440</option><option value="441">441</option><option value="442">442</option><option value="443">443</option><option value="444">444</option><option value="445">445</option><option value="446">446</option><option value="447">447</option><option value="448">448</option><option value="449">449</option><option value="450">450</option><option value="451">451</option><option value="452">452</option><option value="453">453</option><option value="454">454</option><option value="455">455</option><option value="456">456</option><option value="457">457</option><option value="458">458</option><option value="459">459</option><option value="460">460</option><option value="461">461</option><option value="462">462</option><option value="463">463</option><option value="464">464</option><option value="465">465</option><option value="466">466</option><option value="467">467</option><option value="468">468</option><option value="469">469</option><option value="470">470</option><option value="471">471</option><option value="472">472</option><option value="473">473</option><option value="474">474</option><option value="475">475</option><option value="476">476</option><option value="477">477</option><option value="478">478</option><option value="479">479</option><option value="480">480</option><option value="481">481</option><option value="482">482</option><option value="483">483</option><option value="484">484</option><option value="485">485</option><option value="486">486</option><option value="487">487</option><option value="488">488</option><option value="489">489</option><option value="490">490</option><option value="491">491</option><option value="492">492</option><option value="493">493</option><option value="494">494</option><option value="495">495</option><option value="496">496</option><option value="497">497</option><option value="498">498</option><option value="499">499</option><option value="500">500</option></select> </div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <i style="color:#ffc735;" class="fa fa-times pull-right remove_attribute" data-org_id="0" data-outlet_id="0" onclick="myfunction(this)"   title="You can exclude this attribute from check"></i></div></div></td></tr>';
                $("#range_table").append(add_clone);
               
           }
           else if(attribute_type==="Date"){
                 add_clone='<tr><td style="width:35%;!important"><div class="form-group"><div class="col-md-12"> <select name="new_attribute_name[]" class="form-control select2me required validatefield" id="product_id" tabindex="8"><option value="'+attribute_id+'">'+attribute_name+'</option> </select></div></div></td><td style="display:none;"><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_attribute_type[]" value="'+attribute_type+'" id="attribute_type" class="form-control" readonly="1" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td style="width:30%;"><h5>User will be asked to provide Date</h5></td><td style="padding-top: 0px;width:20%"> <select   class="form-control dependent_attributes " id="dependent_attributes" attr_id="'+attribute_id+'_new" > </select> </td> <input type="hidden" name="new_possible_answers[]" value="0"> <input type="hidden" name="new_min_value[]" value=""> <input type="hidden" name="new_max_value[]" value=""> <input type="hidden" name="new_target_val[]" value=""><td> <div class="form-group"> <div class="col-md-12" id="cities_cont"> <select name="page_rank[]" class="form-control chosen-select" id="rank"><option value="">Select</option><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option><option value="101">101</option><option value="102">102</option><option value="103">103</option><option value="104">104</option><option value="105">105</option><option value="106">106</option><option value="107">107</option><option value="108">108</option><option value="109">109</option><option value="110">110</option><option value="111">111</option><option value="112">112</option><option value="113">113</option><option value="114">114</option><option value="115">115</option><option value="116">116</option><option value="117">117</option><option value="118">118</option><option value="119">119</option><option value="120">120</option><option value="121">121</option><option value="122">122</option><option value="123">123</option><option value="124">124</option><option value="125">125</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="130">130</option><option value="131">131</option><option value="132">132</option><option value="133">133</option><option value="134">134</option><option value="135">135</option><option value="136">136</option><option value="137">137</option><option value="138">138</option><option value="139">139</option><option value="140">140</option><option value="141">141</option><option value="142">142</option><option value="143">143</option><option value="144">144</option><option value="145">145</option><option value="146">146</option><option value="147">147</option><option value="148">148</option><option value="149">149</option><option value="150">150</option><option value="151">151</option><option value="152">152</option><option value="153">153</option><option value="154">154</option><option value="155">155</option><option value="156">156</option><option value="157">157</option><option value="158">158</option><option value="159">159</option><option value="160">160</option><option value="161">161</option><option value="162">162</option><option value="163">163</option><option value="164">164</option><option value="165">165</option><option value="166">166</option><option value="167">167</option><option value="168">168</option><option value="169">169</option><option value="170">170</option><option value="171">171</option><option value="172">172</option><option value="173">173</option><option value="174">174</option><option value="175">175</option><option value="176">176</option><option value="177">177</option><option value="178">178</option><option value="179">179</option><option value="180">180</option><option value="181">181</option><option value="182">182</option><option value="183">183</option><option value="184">184</option><option value="185">185</option><option value="186">186</option><option value="187">187</option><option value="188">188</option><option value="189">189</option><option value="190">190</option><option value="191">191</option><option value="192">192</option><option value="193">193</option><option value="194">194</option><option value="195">195</option><option value="196">196</option><option value="197">197</option><option value="198">198</option><option value="199">199</option><option value="200">200</option><option value="201">201</option><option value="202">202</option><option value="203">203</option><option value="204">204</option><option value="205">205</option><option value="206">206</option><option value="207">207</option><option value="208">208</option><option value="209">209</option><option value="210">210</option><option value="211">211</option><option value="212">212</option><option value="213">213</option><option value="214">214</option><option value="215">215</option><option value="216">216</option><option value="217">217</option><option value="218">218</option><option value="219">219</option><option value="220">220</option><option value="221">221</option><option value="222">222</option><option value="223">223</option><option value="224">224</option><option value="225">225</option><option value="226">226</option><option value="227">227</option><option value="228">228</option><option value="229">229</option><option value="230">230</option><option value="231">231</option><option value="232">232</option><option value="233">233</option><option value="234">234</option><option value="235">235</option><option value="236">236</option><option value="237">237</option><option value="238">238</option><option value="239">239</option><option value="240">240</option><option value="241">241</option><option value="242">242</option><option value="243">243</option><option value="244">244</option><option value="245">245</option><option value="246">246</option><option value="247">247</option><option value="248">248</option><option value="249">249</option><option value="250">250</option><option value="251">251</option><option value="252">252</option><option value="253">253</option><option value="254">254</option><option value="255">255</option><option value="256">256</option><option value="257">257</option><option value="258">258</option><option value="259">259</option><option value="260">260</option><option value="261">261</option><option value="262">262</option><option value="263">263</option><option value="264">264</option><option value="265">265</option><option value="266">266</option><option value="267">267</option><option value="268">268</option><option value="269">269</option><option value="270">270</option><option value="271">271</option><option value="272">272</option><option value="273">273</option><option value="274">274</option><option value="275">275</option><option value="276">276</option><option value="277">277</option><option value="278">278</option><option value="279">279</option><option value="280">280</option><option value="281">281</option><option value="282">282</option><option value="283">283</option><option value="284">284</option><option value="285">285</option><option value="286">286</option><option value="287">287</option><option value="288">288</option><option value="289">289</option><option value="290">290</option><option value="291">291</option><option value="292">292</option><option value="293">293</option><option value="294">294</option><option value="295">295</option><option value="296">296</option><option value="297">297</option><option value="298">298</option><option value="299">299</option><option value="300">300</option><option value="301">301</option><option value="302">302</option><option value="303">303</option><option value="304">304</option><option value="305">305</option><option value="306">306</option><option value="307">307</option><option value="308">308</option><option value="309">309</option><option value="310">310</option><option value="311">311</option><option value="312">312</option><option value="313">313</option><option value="314">314</option><option value="315">315</option><option value="316">316</option><option value="317">317</option><option value="318">318</option><option value="319">319</option><option value="320">320</option><option value="321">321</option><option value="322">322</option><option value="323">323</option><option value="324">324</option><option value="325">325</option><option value="326">326</option><option value="327">327</option><option value="328">328</option><option value="329">329</option><option value="330">330</option><option value="331">331</option><option value="332">332</option><option value="333">333</option><option value="334">334</option><option value="335">335</option><option value="336">336</option><option value="337">337</option><option value="338">338</option><option value="339">339</option><option value="340">340</option><option value="341">341</option><option value="342">342</option><option value="343">343</option><option value="344">344</option><option value="345">345</option><option value="346">346</option><option value="347">347</option><option value="348">348</option><option value="349">349</option><option value="350">350</option><option value="351">351</option><option value="352">352</option><option value="353">353</option><option value="354">354</option><option value="355">355</option><option value="356">356</option><option value="357">357</option><option value="358">358</option><option value="359">359</option><option value="360">360</option><option value="361">361</option><option value="362">362</option><option value="363">363</option><option value="364">364</option><option value="365">365</option><option value="366">366</option><option value="367">367</option><option value="368">368</option><option value="369">369</option><option value="370">370</option><option value="371">371</option><option value="372">372</option><option value="373">373</option><option value="374">374</option><option value="375">375</option><option value="376">376</option><option value="377">377</option><option value="378">378</option><option value="379">379</option><option value="380">380</option><option value="381">381</option><option value="382">382</option><option value="383">383</option><option value="384">384</option><option value="385">385</option><option value="386">386</option><option value="387">387</option><option value="388">388</option><option value="389">389</option><option value="390">390</option><option value="391">391</option><option value="392">392</option><option value="393">393</option><option value="394">394</option><option value="395">395</option><option value="396">396</option><option value="397">397</option><option value="398">398</option><option value="399">399</option><option value="400">400</option><option value="401">401</option><option value="402">402</option><option value="403">403</option><option value="404">404</option><option value="405">405</option><option value="406">406</option><option value="407">407</option><option value="408">408</option><option value="409">409</option><option value="410">410</option><option value="411">411</option><option value="412">412</option><option value="413">413</option><option value="414">414</option><option value="415">415</option><option value="416">416</option><option value="417">417</option><option value="418">418</option><option value="419">419</option><option value="420">420</option><option value="421">421</option><option value="422">422</option><option value="423">423</option><option value="424">424</option><option value="425">425</option><option value="426">426</option><option value="427">427</option><option value="428">428</option><option value="429">429</option><option value="430">430</option><option value="431">431</option><option value="432">432</option><option value="433">433</option><option value="434">434</option><option value="435">435</option><option value="436">436</option><option value="437">437</option><option value="438">438</option><option value="439">439</option><option value="440">440</option><option value="441">441</option><option value="442">442</option><option value="443">443</option><option value="444">444</option><option value="445">445</option><option value="446">446</option><option value="447">447</option><option value="448">448</option><option value="449">449</option><option value="450">450</option><option value="451">451</option><option value="452">452</option><option value="453">453</option><option value="454">454</option><option value="455">455</option><option value="456">456</option><option value="457">457</option><option value="458">458</option><option value="459">459</option><option value="460">460</option><option value="461">461</option><option value="462">462</option><option value="463">463</option><option value="464">464</option><option value="465">465</option><option value="466">466</option><option value="467">467</option><option value="468">468</option><option value="469">469</option><option value="470">470</option><option value="471">471</option><option value="472">472</option><option value="473">473</option><option value="474">474</option><option value="475">475</option><option value="476">476</option><option value="477">477</option><option value="478">478</option><option value="479">479</option><option value="480">480</option><option value="481">481</option><option value="482">482</option><option value="483">483</option><option value="484">484</option><option value="485">485</option><option value="486">486</option><option value="487">487</option><option value="488">488</option><option value="489">489</option><option value="490">490</option><option value="491">491</option><option value="492">492</option><option value="493">493</option><option value="494">494</option><option value="495">495</option><option value="496">496</option><option value="497">497</option><option value="498">498</option><option value="499">499</option><option value="500">500</option></select> </div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <i style="color:#ffc735;" class="fa fa-times pull-right remove_attribute" data-org_id="0"  onclick="myfunction(this)"  data-outlet_id="0" title="You can exclude this attribute from check"></i></div></div></td></tr>';
                $("#date_table").append(add_clone);
               
           }
           else if(attribute_type==="DateTime"){
                 add_clone='<tr><td style="width:35%;!important"><div class="form-group"><div class="col-md-12"> <select name="new_attribute_name[]" class="form-control select2me required validatefield" id="product_id" tabindex="8"><option value="'+attribute_id+'">'+attribute_name+'</option> </select></div></div></td><td style="display:none;"><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_attribute_type[]" value="'+attribute_type+'" id="attribute_type" class="form-control" readonly="1" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td style="width:30%;"><h5>User will be asked to provide Date and Time</h5></td><td style="padding-top: 0px;width:20%"> <select   class="form-control dependent_attributes " id="dependent_attributes" attr_id="'+attribute_id+'_new" > </select> </td> <input type="hidden" name="new_possible_answers[]" value="0"> <input type="hidden" name="new_min_value[]" value=""> <input type="hidden" name="new_max_value[]" value=""> <input type="hidden" name="new_target_val[]" value=""><td> <div class="form-group"> <div class="col-md-12" id="cities_cont"> <select name="page_rank[]" class="form-control chosen-select" id="rank"><option value="">Select</option><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option><option value="101">101</option><option value="102">102</option><option value="103">103</option><option value="104">104</option><option value="105">105</option><option value="106">106</option><option value="107">107</option><option value="108">108</option><option value="109">109</option><option value="110">110</option><option value="111">111</option><option value="112">112</option><option value="113">113</option><option value="114">114</option><option value="115">115</option><option value="116">116</option><option value="117">117</option><option value="118">118</option><option value="119">119</option><option value="120">120</option><option value="121">121</option><option value="122">122</option><option value="123">123</option><option value="124">124</option><option value="125">125</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="130">130</option><option value="131">131</option><option value="132">132</option><option value="133">133</option><option value="134">134</option><option value="135">135</option><option value="136">136</option><option value="137">137</option><option value="138">138</option><option value="139">139</option><option value="140">140</option><option value="141">141</option><option value="142">142</option><option value="143">143</option><option value="144">144</option><option value="145">145</option><option value="146">146</option><option value="147">147</option><option value="148">148</option><option value="149">149</option><option value="150">150</option><option value="151">151</option><option value="152">152</option><option value="153">153</option><option value="154">154</option><option value="155">155</option><option value="156">156</option><option value="157">157</option><option value="158">158</option><option value="159">159</option><option value="160">160</option><option value="161">161</option><option value="162">162</option><option value="163">163</option><option value="164">164</option><option value="165">165</option><option value="166">166</option><option value="167">167</option><option value="168">168</option><option value="169">169</option><option value="170">170</option><option value="171">171</option><option value="172">172</option><option value="173">173</option><option value="174">174</option><option value="175">175</option><option value="176">176</option><option value="177">177</option><option value="178">178</option><option value="179">179</option><option value="180">180</option><option value="181">181</option><option value="182">182</option><option value="183">183</option><option value="184">184</option><option value="185">185</option><option value="186">186</option><option value="187">187</option><option value="188">188</option><option value="189">189</option><option value="190">190</option><option value="191">191</option><option value="192">192</option><option value="193">193</option><option value="194">194</option><option value="195">195</option><option value="196">196</option><option value="197">197</option><option value="198">198</option><option value="199">199</option><option value="200">200</option><option value="201">201</option><option value="202">202</option><option value="203">203</option><option value="204">204</option><option value="205">205</option><option value="206">206</option><option value="207">207</option><option value="208">208</option><option value="209">209</option><option value="210">210</option><option value="211">211</option><option value="212">212</option><option value="213">213</option><option value="214">214</option><option value="215">215</option><option value="216">216</option><option value="217">217</option><option value="218">218</option><option value="219">219</option><option value="220">220</option><option value="221">221</option><option value="222">222</option><option value="223">223</option><option value="224">224</option><option value="225">225</option><option value="226">226</option><option value="227">227</option><option value="228">228</option><option value="229">229</option><option value="230">230</option><option value="231">231</option><option value="232">232</option><option value="233">233</option><option value="234">234</option><option value="235">235</option><option value="236">236</option><option value="237">237</option><option value="238">238</option><option value="239">239</option><option value="240">240</option><option value="241">241</option><option value="242">242</option><option value="243">243</option><option value="244">244</option><option value="245">245</option><option value="246">246</option><option value="247">247</option><option value="248">248</option><option value="249">249</option><option value="250">250</option><option value="251">251</option><option value="252">252</option><option value="253">253</option><option value="254">254</option><option value="255">255</option><option value="256">256</option><option value="257">257</option><option value="258">258</option><option value="259">259</option><option value="260">260</option><option value="261">261</option><option value="262">262</option><option value="263">263</option><option value="264">264</option><option value="265">265</option><option value="266">266</option><option value="267">267</option><option value="268">268</option><option value="269">269</option><option value="270">270</option><option value="271">271</option><option value="272">272</option><option value="273">273</option><option value="274">274</option><option value="275">275</option><option value="276">276</option><option value="277">277</option><option value="278">278</option><option value="279">279</option><option value="280">280</option><option value="281">281</option><option value="282">282</option><option value="283">283</option><option value="284">284</option><option value="285">285</option><option value="286">286</option><option value="287">287</option><option value="288">288</option><option value="289">289</option><option value="290">290</option><option value="291">291</option><option value="292">292</option><option value="293">293</option><option value="294">294</option><option value="295">295</option><option value="296">296</option><option value="297">297</option><option value="298">298</option><option value="299">299</option><option value="300">300</option><option value="301">301</option><option value="302">302</option><option value="303">303</option><option value="304">304</option><option value="305">305</option><option value="306">306</option><option value="307">307</option><option value="308">308</option><option value="309">309</option><option value="310">310</option><option value="311">311</option><option value="312">312</option><option value="313">313</option><option value="314">314</option><option value="315">315</option><option value="316">316</option><option value="317">317</option><option value="318">318</option><option value="319">319</option><option value="320">320</option><option value="321">321</option><option value="322">322</option><option value="323">323</option><option value="324">324</option><option value="325">325</option><option value="326">326</option><option value="327">327</option><option value="328">328</option><option value="329">329</option><option value="330">330</option><option value="331">331</option><option value="332">332</option><option value="333">333</option><option value="334">334</option><option value="335">335</option><option value="336">336</option><option value="337">337</option><option value="338">338</option><option value="339">339</option><option value="340">340</option><option value="341">341</option><option value="342">342</option><option value="343">343</option><option value="344">344</option><option value="345">345</option><option value="346">346</option><option value="347">347</option><option value="348">348</option><option value="349">349</option><option value="350">350</option><option value="351">351</option><option value="352">352</option><option value="353">353</option><option value="354">354</option><option value="355">355</option><option value="356">356</option><option value="357">357</option><option value="358">358</option><option value="359">359</option><option value="360">360</option><option value="361">361</option><option value="362">362</option><option value="363">363</option><option value="364">364</option><option value="365">365</option><option value="366">366</option><option value="367">367</option><option value="368">368</option><option value="369">369</option><option value="370">370</option><option value="371">371</option><option value="372">372</option><option value="373">373</option><option value="374">374</option><option value="375">375</option><option value="376">376</option><option value="377">377</option><option value="378">378</option><option value="379">379</option><option value="380">380</option><option value="381">381</option><option value="382">382</option><option value="383">383</option><option value="384">384</option><option value="385">385</option><option value="386">386</option><option value="387">387</option><option value="388">388</option><option value="389">389</option><option value="390">390</option><option value="391">391</option><option value="392">392</option><option value="393">393</option><option value="394">394</option><option value="395">395</option><option value="396">396</option><option value="397">397</option><option value="398">398</option><option value="399">399</option><option value="400">400</option><option value="401">401</option><option value="402">402</option><option value="403">403</option><option value="404">404</option><option value="405">405</option><option value="406">406</option><option value="407">407</option><option value="408">408</option><option value="409">409</option><option value="410">410</option><option value="411">411</option><option value="412">412</option><option value="413">413</option><option value="414">414</option><option value="415">415</option><option value="416">416</option><option value="417">417</option><option value="418">418</option><option value="419">419</option><option value="420">420</option><option value="421">421</option><option value="422">422</option><option value="423">423</option><option value="424">424</option><option value="425">425</option><option value="426">426</option><option value="427">427</option><option value="428">428</option><option value="429">429</option><option value="430">430</option><option value="431">431</option><option value="432">432</option><option value="433">433</option><option value="434">434</option><option value="435">435</option><option value="436">436</option><option value="437">437</option><option value="438">438</option><option value="439">439</option><option value="440">440</option><option value="441">441</option><option value="442">442</option><option value="443">443</option><option value="444">444</option><option value="445">445</option><option value="446">446</option><option value="447">447</option><option value="448">448</option><option value="449">449</option><option value="450">450</option><option value="451">451</option><option value="452">452</option><option value="453">453</option><option value="454">454</option><option value="455">455</option><option value="456">456</option><option value="457">457</option><option value="458">458</option><option value="459">459</option><option value="460">460</option><option value="461">461</option><option value="462">462</option><option value="463">463</option><option value="464">464</option><option value="465">465</option><option value="466">466</option><option value="467">467</option><option value="468">468</option><option value="469">469</option><option value="470">470</option><option value="471">471</option><option value="472">472</option><option value="473">473</option><option value="474">474</option><option value="475">475</option><option value="476">476</option><option value="477">477</option><option value="478">478</option><option value="479">479</option><option value="480">480</option><option value="481">481</option><option value="482">482</option><option value="483">483</option><option value="484">484</option><option value="485">485</option><option value="486">486</option><option value="487">487</option><option value="488">488</option><option value="489">489</option><option value="490">490</option><option value="491">491</option><option value="492">492</option><option value="493">493</option><option value="494">494</option><option value="495">495</option><option value="496">496</option><option value="497">497</option><option value="498">498</option><option value="499">499</option><option value="500">500</option></select> </div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <i style="color:#ffc735;" class="fa fa-times pull-right remove_attribute" data-org_id="0"  onclick="myfunction(this)"  data-outlet_id="0" title="You can exclude this attribute from check"></i></div></div></td></tr>';
                $("#datetime_table").append(add_clone);
               
           }
           else if(attribute_type==="Time"){
                 add_clone='<tr><td style="width:35%;!important"><div class="form-group"><div class="col-md-12"> <select name="new_attribute_name[]" class="form-control select2me required validatefield" id="product_id" tabindex="8"><option value="'+attribute_id+'">'+attribute_name+'</option> </select></div></div></td><td style="display:none;"><div class="form-group"><div class="col-md-8" style="width:100%;"> <input type="text" name="new_attribute_type[]" value="'+attribute_type+'" id="attribute_type" class="form-control" readonly="1" data-parsley-type="integer" data-parsley-maxlength="100"></div></div></td><td style="width:30%;"><h5>User will be asked to provide Time</h5></td><td style="padding-top: 0px;width:20%"> <select   class="form-control dependent_attributes " id="dependent_attributes" attr_id="'+attribute_id+'_new" > </select> </td> <input type="hidden" name="new_possible_answers[]" value="0"> <input type="hidden" name="new_min_value[]" value=""> <input type="hidden" name="new_max_value[]" value=""> <input type="hidden" name="new_target_val[]" value=""><td> <div class="form-group"> <div class="col-md-12" id="cities_cont"> <select name="page_rank[]" class="form-control chosen-select" id="rank"><option value="">Select</option><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option><option value="101">101</option><option value="102">102</option><option value="103">103</option><option value="104">104</option><option value="105">105</option><option value="106">106</option><option value="107">107</option><option value="108">108</option><option value="109">109</option><option value="110">110</option><option value="111">111</option><option value="112">112</option><option value="113">113</option><option value="114">114</option><option value="115">115</option><option value="116">116</option><option value="117">117</option><option value="118">118</option><option value="119">119</option><option value="120">120</option><option value="121">121</option><option value="122">122</option><option value="123">123</option><option value="124">124</option><option value="125">125</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="130">130</option><option value="131">131</option><option value="132">132</option><option value="133">133</option><option value="134">134</option><option value="135">135</option><option value="136">136</option><option value="137">137</option><option value="138">138</option><option value="139">139</option><option value="140">140</option><option value="141">141</option><option value="142">142</option><option value="143">143</option><option value="144">144</option><option value="145">145</option><option value="146">146</option><option value="147">147</option><option value="148">148</option><option value="149">149</option><option value="150">150</option><option value="151">151</option><option value="152">152</option><option value="153">153</option><option value="154">154</option><option value="155">155</option><option value="156">156</option><option value="157">157</option><option value="158">158</option><option value="159">159</option><option value="160">160</option><option value="161">161</option><option value="162">162</option><option value="163">163</option><option value="164">164</option><option value="165">165</option><option value="166">166</option><option value="167">167</option><option value="168">168</option><option value="169">169</option><option value="170">170</option><option value="171">171</option><option value="172">172</option><option value="173">173</option><option value="174">174</option><option value="175">175</option><option value="176">176</option><option value="177">177</option><option value="178">178</option><option value="179">179</option><option value="180">180</option><option value="181">181</option><option value="182">182</option><option value="183">183</option><option value="184">184</option><option value="185">185</option><option value="186">186</option><option value="187">187</option><option value="188">188</option><option value="189">189</option><option value="190">190</option><option value="191">191</option><option value="192">192</option><option value="193">193</option><option value="194">194</option><option value="195">195</option><option value="196">196</option><option value="197">197</option><option value="198">198</option><option value="199">199</option><option value="200">200</option><option value="201">201</option><option value="202">202</option><option value="203">203</option><option value="204">204</option><option value="205">205</option><option value="206">206</option><option value="207">207</option><option value="208">208</option><option value="209">209</option><option value="210">210</option><option value="211">211</option><option value="212">212</option><option value="213">213</option><option value="214">214</option><option value="215">215</option><option value="216">216</option><option value="217">217</option><option value="218">218</option><option value="219">219</option><option value="220">220</option><option value="221">221</option><option value="222">222</option><option value="223">223</option><option value="224">224</option><option value="225">225</option><option value="226">226</option><option value="227">227</option><option value="228">228</option><option value="229">229</option><option value="230">230</option><option value="231">231</option><option value="232">232</option><option value="233">233</option><option value="234">234</option><option value="235">235</option><option value="236">236</option><option value="237">237</option><option value="238">238</option><option value="239">239</option><option value="240">240</option><option value="241">241</option><option value="242">242</option><option value="243">243</option><option value="244">244</option><option value="245">245</option><option value="246">246</option><option value="247">247</option><option value="248">248</option><option value="249">249</option><option value="250">250</option><option value="251">251</option><option value="252">252</option><option value="253">253</option><option value="254">254</option><option value="255">255</option><option value="256">256</option><option value="257">257</option><option value="258">258</option><option value="259">259</option><option value="260">260</option><option value="261">261</option><option value="262">262</option><option value="263">263</option><option value="264">264</option><option value="265">265</option><option value="266">266</option><option value="267">267</option><option value="268">268</option><option value="269">269</option><option value="270">270</option><option value="271">271</option><option value="272">272</option><option value="273">273</option><option value="274">274</option><option value="275">275</option><option value="276">276</option><option value="277">277</option><option value="278">278</option><option value="279">279</option><option value="280">280</option><option value="281">281</option><option value="282">282</option><option value="283">283</option><option value="284">284</option><option value="285">285</option><option value="286">286</option><option value="287">287</option><option value="288">288</option><option value="289">289</option><option value="290">290</option><option value="291">291</option><option value="292">292</option><option value="293">293</option><option value="294">294</option><option value="295">295</option><option value="296">296</option><option value="297">297</option><option value="298">298</option><option value="299">299</option><option value="300">300</option><option value="301">301</option><option value="302">302</option><option value="303">303</option><option value="304">304</option><option value="305">305</option><option value="306">306</option><option value="307">307</option><option value="308">308</option><option value="309">309</option><option value="310">310</option><option value="311">311</option><option value="312">312</option><option value="313">313</option><option value="314">314</option><option value="315">315</option><option value="316">316</option><option value="317">317</option><option value="318">318</option><option value="319">319</option><option value="320">320</option><option value="321">321</option><option value="322">322</option><option value="323">323</option><option value="324">324</option><option value="325">325</option><option value="326">326</option><option value="327">327</option><option value="328">328</option><option value="329">329</option><option value="330">330</option><option value="331">331</option><option value="332">332</option><option value="333">333</option><option value="334">334</option><option value="335">335</option><option value="336">336</option><option value="337">337</option><option value="338">338</option><option value="339">339</option><option value="340">340</option><option value="341">341</option><option value="342">342</option><option value="343">343</option><option value="344">344</option><option value="345">345</option><option value="346">346</option><option value="347">347</option><option value="348">348</option><option value="349">349</option><option value="350">350</option><option value="351">351</option><option value="352">352</option><option value="353">353</option><option value="354">354</option><option value="355">355</option><option value="356">356</option><option value="357">357</option><option value="358">358</option><option value="359">359</option><option value="360">360</option><option value="361">361</option><option value="362">362</option><option value="363">363</option><option value="364">364</option><option value="365">365</option><option value="366">366</option><option value="367">367</option><option value="368">368</option><option value="369">369</option><option value="370">370</option><option value="371">371</option><option value="372">372</option><option value="373">373</option><option value="374">374</option><option value="375">375</option><option value="376">376</option><option value="377">377</option><option value="378">378</option><option value="379">379</option><option value="380">380</option><option value="381">381</option><option value="382">382</option><option value="383">383</option><option value="384">384</option><option value="385">385</option><option value="386">386</option><option value="387">387</option><option value="388">388</option><option value="389">389</option><option value="390">390</option><option value="391">391</option><option value="392">392</option><option value="393">393</option><option value="394">394</option><option value="395">395</option><option value="396">396</option><option value="397">397</option><option value="398">398</option><option value="399">399</option><option value="400">400</option><option value="401">401</option><option value="402">402</option><option value="403">403</option><option value="404">404</option><option value="405">405</option><option value="406">406</option><option value="407">407</option><option value="408">408</option><option value="409">409</option><option value="410">410</option><option value="411">411</option><option value="412">412</option><option value="413">413</option><option value="414">414</option><option value="415">415</option><option value="416">416</option><option value="417">417</option><option value="418">418</option><option value="419">419</option><option value="420">420</option><option value="421">421</option><option value="422">422</option><option value="423">423</option><option value="424">424</option><option value="425">425</option><option value="426">426</option><option value="427">427</option><option value="428">428</option><option value="429">429</option><option value="430">430</option><option value="431">431</option><option value="432">432</option><option value="433">433</option><option value="434">434</option><option value="435">435</option><option value="436">436</option><option value="437">437</option><option value="438">438</option><option value="439">439</option><option value="440">440</option><option value="441">441</option><option value="442">442</option><option value="443">443</option><option value="444">444</option><option value="445">445</option><option value="446">446</option><option value="447">447</option><option value="448">448</option><option value="449">449</option><option value="450">450</option><option value="451">451</option><option value="452">452</option><option value="453">453</option><option value="454">454</option><option value="455">455</option><option value="456">456</option><option value="457">457</option><option value="458">458</option><option value="459">459</option><option value="460">460</option><option value="461">461</option><option value="462">462</option><option value="463">463</option><option value="464">464</option><option value="465">465</option><option value="466">466</option><option value="467">467</option><option value="468">468</option><option value="469">469</option><option value="470">470</option><option value="471">471</option><option value="472">472</option><option value="473">473</option><option value="474">474</option><option value="475">475</option><option value="476">476</option><option value="477">477</option><option value="478">478</option><option value="479">479</option><option value="480">480</option><option value="481">481</option><option value="482">482</option><option value="483">483</option><option value="484">484</option><option value="485">485</option><option value="486">486</option><option value="487">487</option><option value="488">488</option><option value="489">489</option><option value="490">490</option><option value="491">491</option><option value="492">492</option><option value="493">493</option><option value="494">494</option><option value="495">495</option><option value="496">496</option><option value="497">497</option><option value="498">498</option><option value="499">499</option><option value="500">500</option></select> </div></div></td><td><div class="form-group"><div class="col-md-8" style="width:100%;"> <i style="color:#ffc735;" class="fa fa-times pull-right remove_attribute" data-org_id="0"  onclick="myfunction(this)"  data-outlet_id="0" title="You can exclude this attribute from check"></i></div></div></td></tr>';
                $("#time_table").append(add_clone);
               
           }

           var arr_attr={'attribute_id':attribute_id,"question":attribute_name};
           attr_array=JSON.parse(attr_array)
           attr_array.push(arr_attr)
           attr_array=JSON.stringify(attr_array)
           selection_code();
           
        });

  </script>
  <script>
      $(".pretty input:checkbox").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked)
      $('.datetimeshow').css('display', 'none');
    else
      $('.datetimeshow').css('display', 'inline');
  }); 
  </script>