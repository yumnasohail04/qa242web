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
   }c
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
            <a href="<?php echo ADMIN_BASE_URL . 'product_tests'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                           <div class="portlet-body form " style="padding-top:15px;">
                              <!-- BEGIN FORM-->
                              <?php
                                 $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal','role'=>"form");
                                 if (empty($update_id)) {
                                     $update_id = 0;
                                 } else {
                                     $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                                 }
                                 if (isset($hidden) && !empty($hidden))
                                     echo form_open_multipart(ADMIN_BASE_URL . 'product_tests/submit/' . $update_id, $attributes, $hidden);
                                 else
                                     echo form_open_multipart(ADMIN_BASE_URL . 'product_tests/submit/' . $update_id, $attributes);
                                 ?>
                              <div class="stepwizard">
                                 <div class="stepwizard-row setup-panel">
                                    <div class="stepwizard-step">
                                       <a href="javascript:;" tab_id="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                                       <p>QA Checks</p>
                                    </div>
                                   
                                    <div class="stepwizard-step">
                                       <a href="javascript:;" tab_id="#step-2" type="button" class="btn btn-default btn-circle" >2</a>
                                       <p>Responsible Team</p>
                                    </div>
                                   
                                 </div>
                              </div>
                              <br>
                              <form role="form">
                                 <div class="row setup-content" id="step-1">
                                    <div class="col-xs-12">
                                       <div class="col-md-12">
                                          <h3 style="margin-left: 15px;">QA Checks</h3>
                                          <div class="col-sm-8" >
                                             <div class="form-group">
                                                <?php  $checks = array('product attribute'=>"Product Atrribute",'unit weight(tray+pasta)'=>"Unit Weight(Tray+Pasta)","wip_profile"=>"WIP Profile","bowl_filling"=>"Bowl Filling");
                                                   if(!isset($news['checktype'])) $news['checktype'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$checks ;
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   echo form_label('Select Check Type <span style="color:red">*</span>', 'role_id', $attribute);?>
                                                <div class="col-md-8">
                                                   <?php echo form_dropdown('checktype', $options, $news['checktype'],  'class="form-control checktype required validatefield" id="role_id" tabindex ="8"'); ?>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-sm-8 subtype";>
                                             <div class="form-group">
                                                <?php  $checks = array('Filling Check'=>"Filling Check",'Dough Check'=>"Dough Check");
                                                   if(!isset($news['checksubtype'])) $news['checksubtype'] = ""; ?>
                                                <?php $options = array('' => 'Select')+$checks ;
                                                   $attribute = array('class' => 'control-label col-md-4');
                                                   echo form_label('Select Check Sub Type <span style="color:red">*</span>', 'role_id', $attribute);?>
                                                <div class="col-md-8">
                                                   <?php echo form_dropdown('checksubtype', $options, $news['checksubtype'],  'class="form-control  required validatefield" id="role_id" tabindex ="8"'); ?>
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
                                                <label class="col-sm-4 control-label">Frequency</label>
                                                <div class="col-sm-8">
                                                  <select  class="validate_form form-control responsible_user" name="frequency" required="required">
                                                      <option value="">Select</option>
                                                      <?php
                                                      if(!isset($news['frequency']) || empty($news['frequency'])) 
                                                        $news['frequency'] = '';
                                                        if(!isset($frequency_array) || empty($frequency_array)) 
                                                          $frequency_array = array('30 Mins'=>"30 Mins",'hourly'=>"hourly",'Daily'=>'Daily','Weekly'=>'Weekly');
                                                        foreach ($frequency_array as $key=>$value): ?>
                                                      <option value="<?=$key?>" <?php if(strtolower($news['frequency']) == strtolower($value)) echo 'selected="selected"';; ?>>
                                                          <?=$value?>
                                                        </option>
                                                      <?php endforeach ?>
                                                  </select>
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
                                          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                                        </div>
                                       </div>
                                    </div>
                                 </div>
                                
                                 <div class="row setup-content" id="step-2" style="display: none;">
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

                                       
                                    </div>
                                     <div class="form-actions fluid no-mrg">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                                                <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary btnsave"><i class="fa fa-check"></i>&nbsp;Save</button>
                                                <a href="<?php echo ADMIN_BASE_URL . 'product_tests'; ?>">
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
                                       <a href="<?php echo ADMIN_BASE_URL . 'product_tests'; ?>">
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
   function allfunction() {
       var navListItems = $('div.setup-panel div a'),
               allWells = $('.setup-content'),
               allNextBtn = $('.nextBtn');
   
       allWells.hide();
   
       navListItems.off('click').click(function (e) {
        if($('div.setup-panel div a').hasClass('tabs-check')){
          return
        } else {
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
           
               
               if(isValid==false){
                $(document).ready(function() {toastr.warning("Select all required fields")});
               }
           if (isValid) {
            $('div.setup-panel div a').removeClass('tabs-check')
            $('div.setup-panel div a[tab_id="#' + curStepBtn + '"]').addClass('selected')
          if(curStepBtn == 'step-1'){
            $('attr-chose').html('')
            if($('.select2me').val() == 'product attribute'){
               var id = $('.select_attributes').val();
               //alert(id); return false;
               $(".row_add").remove();
               $request=1;
                  $.ajax({
                       type: 'POST',
                       url: "<?=ADMIN_BASE_URL?>product_tests/get_product_info",
                       data: {'productid': id},
                       async: false,
                       success: function(test_body) {
                       $('.section-box').append(test_body);
                          allfunction()
                          $request=2;
                       }
                   });
              // $('attr-chose').load('./productinfo.php')
            } else if($('.select2me').val() == 'general qa check') {
              qacheck()
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
                       url: "<?=ADMIN_BASE_URL?>product_tests/get_general_checks_attributes",
                       data: {'cat_id': subcat_id,'update_id':upddate_id},
                       async: false,
                       success: function(test_body) {
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
      $('.product-select').attr('style','display:none')
      if($('.select2me').val() == 'product attribute'){
         $('.product-select').attr('style','display:block')
         $('.gen_checktype').attr('style','display:none');
         $('#checkheading').text('Product Attributes')
      }
      if($('.select2me').val() == 'general qa check')
      {
          $('.gen_checktype').attr('style','display:block')
          $('#checkheading').text('Check Attributes')

      }
   })


   $(document).ready(function() {
      $('.subtype').attr('style','display:none')
      if($('.checktype').val() == 'wip_profile' || $('.checktype').val() == 'bowl_filling' ){
         $('.subtype').attr('style','display:block')
      }
      else
      {
          $('.subtype').attr('style','display:none')
      }
   });
   $('.checktype').change(function(){
      $('.subtype').attr('style','display:none')
      if($('.checktype').val() == 'wip_profile' || $('.checktype').val() == 'bowl_filling' ){
         $('.subtype').attr('style','display:block')
      }
      else
      {
          $('.subtype').attr('style','display:none')
      }
   })
   
    $('#category_id').change(function(e){
    var cat_id=$(this).val();
         $.ajax({
                       type: 'POST',
                       url: "<?=ADMIN_BASE_URL?>product_tests/get_sub_catagories",
                       data: {'cat_id': cat_id},
                       async: false,
                       success: function(test_body) {
                        $('#gen_subchecktyp select').html(test_body);
                        $('.gen_subchecktyp').attr('style','display:block');
                        }
                   });
    })

$('#subcategory_id').on('change', function (e) {
  
    var subcat_id=$(this).val();
    var cat_id=$('#category_id').val();
    alert()
          $.ajax({
                  url: "<?=ADMIN_BASE_URL?>product_tests/get_sub_catagories_detail", 
                  type: 'post',
                  data:  {'cat_id':cat_id,'subcat_id':subcat_id},
                  complete: function(responce) {
                        jsonreturn = JSON.parse(responce.responseText);
                      
                      if (jsonreturn.status==false) {
                        $('.product-select').attr('style','display:none');

                        $('.select_attributes').removeClass('selectpicker');
                          $(document).ready(function() {toastr.warning("Something went wrong")});
                      } else {
                          if(jsonreturn.data_array.is_product=="Yes"){
                            $('.product-select').attr('style','display:block');
                            $('.select_attributes').addClass('selectpicker');
                          }else{
                            $('.product-select').attr('style','display:none');
                            $('.select_attributes').removeClass('selectpicker');
                          }
                      }
                    }  
        
                  
          });
    
});
</script>