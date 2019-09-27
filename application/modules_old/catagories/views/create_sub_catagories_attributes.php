<?php // print_r($thought_of_day); exit(); ?>

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
 <h3>
      
          <?php
            $cat_name =  $this->uri->segment(6);
            $cat_name_sub =  $this->uri->segment(6);
            if (!empty($cat_name_sub)) {
              $cat_name =  $this->uri->segment(6);
              $strTitle = "Edit attribute";
            }
            else
            {
               $strTitle = "Add attribute";
            }
                    
                    echo $strTitle.'-'. '('.$cat_name.')';
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL.'catagories/manage_sub_catagories/'.$parent_id.'/'.$cat_name; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    </h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" id="tab_2" >
              <div class="portlet box green ">
                <div class="portlet-title ">
                 
                </div>
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                  
                  <!-- BEGIN FORM-->
                          <?php 
                          $attributes = array('autocomplete' => 'off', 'id' => 'frmSubCatagories', 'class' => 'form-horizontal');
                          if(empty($update_id)){
                            $update_id = 0;
                            $hidden = array('hdnParentId' => $parent_id);
                          }
                          else{
                            if (!isset($catagories['is_active'])) {
                             $catagories['is_active'] = '';
                            }
                            $hidden = array('hdnParentId' => $parent_id, 'hdnId' => $update_id,'hdnActive' => $catagories['is_active']); ////edit case
                          }
                          echo form_open_multipart(ADMIN_BASE_URL.'catagories/submit_sub_catagories_attributes/'.$parent_id.'/'.$update_id.'/'.$cat_name, $attributes, $hidden); ?>
                                    <div class="form-body">
                                        
                                       
                                                  
                            <fieldset>
                              <legend>Check Attributes</legend>
                               <div class="row add_row" >
                                             <div class="col-md-5">
                                                <div class="form-group">
                                                    <?php
                                                     $data = array(
                                                        'name' => 'attribute_name',
                                                        'id' => 'attribute_name',
                                                        'class' => 'form-control validate[required] text-input dropify-wrappe',
                                                        'value' => $catagories['attribute_name'],
                                                        'required' => 'required',
                                                    );
                                                    $attribute = array('class' => 'control-label col-md-4');
                                                    ?>
                                                    <?php echo form_label('Attibute`Name <span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                                                    <div class="col-md-8">
                                                        <?php echo form_input($data); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 ">
                                                <div class="form-group">
                                                 <?php $attribute = array('class' => 'control-label col-md-4');
                                                    ?>
                                                    <?php echo form_label('Attibute`type<span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                                                    <div class="col-md-8">
                                                       <select name="attribute_type" class="form-control answer_type" required="required">
                                                         <option value="">--Select--</option>
                                                         <option value="Range" <?php if($catagories['attribute_type']=="Range") echo 'selected="selected"';?>>Range</option>
                                                         <option value="Choice" <?php if($catagories['attribute_type']=="Choice") echo 'selected="selected"';?>>Choice</option>
                                        <option value="Fixed" <?php if($catagories['attribute_type']=="Fixed") echo 'selected="selected"';?>>Text</option>
                                                       </select>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <br><br>
                                            <br>
                                    </div>
                                    <div class="possible_select" <?php if($update_id==0 ) echo 'style="display:none;"'?>>
                                     <div class="row add_answers " >
                                     <?php $arr_choices=explode(',', $catagories['possible_answers']);  if(($catagories['attribute_type']=="Choice" ) && !empty($arr_choices)){ 
                                      $d=1;
                                     ?>
                                        <div >
                                     <div class="col-md-12 " style="margin-bottom:20px;">
                                            	<div class="form-group">
                                            		<label for="txtCatName" class="control-label col-md-2">Choice Type<span class="red" style="color:red;">*</span>
                                            		</label>
                                            		<div class="col-md-5">
                                            			<select name="possible_answer" class="form-control answer_type" required="required">
                                            				<option value="">--Select--</option>
                                            				<option value="yes/no" <?php if($catagories['possible_answers']=='yes/no') echo 'selected="selected"';?>>Yes/No</option>
                                            				<option value="acceptable/unacceptable" <?php if($catagories['possible_answers']=='acceptable/unacceptable') echo 'selected="selected"';?>>Acceptable/Unacceptable</option>
                                            				<option value="completed/not completed" <?php if($catagories['possible_answers']=='completed/not completed') echo 'selected="selected"';?>>Completed/not Completed</option>
                                            				<option value="cleaned/uncleaned" <?php if($catagories['possible_answers']=='cleaned/completed' || $catagories['possible_answers']=='cleaned/uncleaned') echo 'selected="selected"';?>>Cleaned/Uncleaned</option>
                                            				<option value="release/hold" <?php if($catagories['possible_answers']=='release/hold') echo 'selected="selected"';?>>Release/Hold</option>
                                            				<option value="pass/fail" <?php if($catagories['possible_answers']=='pass/fail') echo 'selected="selected"';?>>Pass/Fail</option>
                                            				<option value="positive/negative" <?php if($catagories['possible_answers']=='positive/negative') echo 'selected="selected"';?>>Positive/Negative</option>
                                            				<option value="sealed/unsealed" <?php if($catagories['possible_answers']=='sealed/locked' || $catagories['possible_answers']=='sealed/unsealed') echo 'selected="selected"';?>>Sealed/Unsealed</option>
                                                        	<option value="checkin/checkout" <?php if($catagories['possible_answers']=='checkin/checkout' || $catagories['possible_answers']=='checkin/checkout') echo 'selected="selected"';?>>Checkin/Checkout/option>
                                            			</select>
                                            		</div>
                                            	</div>
                                            </div>
                                       
                                      <?  }elseif($catagories['attribute_type']=="Fixed"){?>
                                          <p style=""font-size:16px;color: #7296CA;>User will be asked to provide an input on mobile app.</p>
                                          <?}elseif($catagories['attribute_type']=="Range"){?>
                                          <div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Min Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="min_value" value="<?=$catagories['min']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Max Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="max_value" value="<?=$catagories['max']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Target Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="target_value" value="<?=$catagories['target']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div>
                                         <?}?>
                                            
                                     </div>
                                     
                                  </div >
                                  <br>
                                    
                                  </div>
                                 <!--    <div class="row">
                     <div class="col-sm-9">
                      </div>
                      <div class="col-sm-3">
                          <button class="btn btn-primary color_field_button pull-right"><i class="fa fa-plus"></i> Add More</button>
                      </div>
                    </div>    -->
                            </fieldset>

                 

                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'catagories'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
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

<script>

<?php
if (!empty($update_id)) {
    ?>
        $("#lstLanguage").css("pointer-events", "none");
        $("#lstLanguage").css("cursor", "default");
    <?php
        }
        ?>
    $(document).ready(function() {
        $("#catagories_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });

/*$('#rec_date').datepicker({
format: "<?php echo get_general_date_format();?>"
});

 $('.date-picker').datepicker({
    format: 'dd/mm/yyyy'
  });
*/

$('#txtCatName').keyup(function() {
   $('#txtPageUrl').val( $(this).val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'') );
});

</script>
<script type="text/javascript">


/////////////////////////////////
  $(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".add_answers");
        var add_button      = $(".color_field_");

        var x = 1;
        var slect_option="";
        $(add_button).click(function(e){
            e.preventDefault();
            var f_val =vehicle ="";
            if(x== 1)
              f_val = $(this).parent().parent().prev().children(":first").children().find('.dropify-wrappe').val();
            else
              f_val = $(this).parent().parent().prev().children(":last").children(":last").children().find('.dropify-wrappe').val();
            if (f_val=='') {
            
                toastr.error("Fill the empty fields first");
                f_val='';
            }
            else {
 
                if(x < max_fields){
                    x++;

                    $(wrapper).append('<div ><div class="col-md-12 "><div class="form-group"> <label for="txtCatName" class="control-label col-md-4">Attibute`type<span class="red" style="color:red;">*</span></label><div class="col-md-8"> <select name="attribute_type" class="form-control answer_type" required="required"><option value="">--Select--</option><option value="Range">Range</option><option value="Choice">Choice</option><option value="Fixed" selected="selected">Text</option> </select></div></div></div> <div class="col-md-12"  style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Attribute Value <span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="possible_answer[]" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-5"></div></div>');
                }
            }
            
        });

        $(wrapper).on("click",".remove_img_div", function(e){
            e.preventDefault(); $(this).parent().remove(); 
            x--;
        })
        
    });
   
  </script>
  <script type="text/javascript">
       $(document).off('click', '.remove_img_div_click').on('click', '.remove_img_div_click', function(e){
                var org_id = $(this).attr('data-org_id');
                var outlet_id = $(this).attr('data-outlet_id');
                e.preventDefault();
                if((org_id!=0 || org_id!=null || org_id!=undefined) && (outlet_id!=0 || outlet_id!=null || outlet_id!=undefined) ){
              swal({
                title : "Are you sure to delete the selected attributes ?",
                text : "You will not be able to recover this attributes",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },

                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo  ADMIN_BASE_URL?>catagories/delete_catagories_attributes",
                            data: {'cat_id': org_id,'attribute_id':outlet_id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "organisation has been deleted.", "success");
              });
          }
            });


        $('.answer_type').change(function(){
      $('.possible_select').attr('style','display:none');
      $('.add_ans_btn').attr('style','display:none');
      $('.add_answers').html('<div ><div class="col-md-12 " style="margin-bottom:20px;"><div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Choice Type<span class="red" style="color:red;">*</span></label><div class="col-md-5"> <select name="possible_answer" class="form-control answer_type" required="required"><option value="">--Select--</option><option value="yes/no">Yes/No</option><option value="acceptable/unacceptable">Acceptable/Unacceptable</option><option value="completed/not completed" >Completed/not Completed</option><option value="cleaned/completed" >Cleaned/Completed</option><option value="release/hold" >Release/Hold</option> <option value="pass/fail" >Pass/Fail</option><option value="positive/negative" >Positive/Negative</option><option value="sealed/locked" >Sealed/Locked</option><option value="checkin/checkout" >Checkin/Checkout</option></select></div></div></div><br> ');
      var htty='<p style=""font-size:16px;color: #7296CA;>User will be asked to provide an input on mobile app.</p>';
      var httvrange=''
      var rangrtt='<div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Min Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="min_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Max Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="max_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Target Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="target_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div>';
      if($('.answer_type').val() == 'Choice'){
         $('.possible_select').attr('style','display:block');
         $('.add_ans_btn').attr('style','display:block');
         
      }
      else if($('.answer_type').val() == 'Fixed'){
         $('.possible_select').attr('style','display:block');
         $('.add_answers').html(htty);
         $('.remove_img_div').remove();
      }
      else{
         $('.possible_select').attr('style','display:block');
         $('.add_answers').html(rangrtt);
         $('.add_ans_btn').attr('style','display:none');
      }
     
   })
  </script>

