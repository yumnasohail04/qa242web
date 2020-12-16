                

<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1> <?php
          $update_id=$this->uri->segment(4);
            if (!empty($update_id)) {
              $strTitle = "Edit attribute";
            }
            else
            {
               $strTitle = "Add attribute";
            }        
            echo $strTitle;
          ?></h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'wip_profile'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
        <div class="separator mb-5"></div>
      </div>
    </div>
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="mb-4">
          
            </h5>
                  
                  <!-- BEGIN FORM-->
                          <?php 
                          $attributes = array('autocomplete' => 'off', 'id' => 'frmSubCatagories', 'class' => 'form-horizontal');
                          if(empty($update_id)){
                            $update_id = 0;
                            $hidden = array();
                          }
                          else{
                           
                            $hidden = array('hdnId' => $update_id,'hdnActive' => $catagories['status']); ////edit case
                          }
                          echo form_open_multipart(ADMIN_BASE_URL.'wip_profile/submit_sub_catagories_attributes/'.$update_id, $attributes, $hidden); ?>
                                    <div class="form-body">
                                        
                                       
                                                  
                            <fieldset>
                              <legend>Check Attributes</legend>
                               <div class="row add_row" >
                                             <div class="col-md-6">
                                                <div class="input-group mb-3">
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
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary" type="button">Attibute`Name<span style="color:red">*</span></button>
                                                    </div>
                                                        <?php echo form_input($data); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 ">
                                                <div class="input-group mb-3">
                                                 <?php $attribute = array('class' => 'control-label col-md-4');
                                                    ?>
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary" type="button">Check type<span style="color:red">*</span></button>
                                                    </div>
                                                       <select name="wip_type" class="form-control " required="required">
                                                         <option value="">--Select--</option>
                                                         <option value="Ingredient Process Control (Filling check)" <?php if($catagories['wip_type']=="Ingredient Process Control (Filling check)") echo 'selected="selected"';?>>Ingredient Process Control (Filling check)</option>
                                                         <option value="Ingredient Process Control (Dough check)" <?php if($catagories['wip_type']=="Ingredient Process Control (Dough check)") echo 'selected="selected"';?>>Ingredient Process Control (Dough check)</option>
                                                         <option value="Bowl Filling (Filling check)" <?php if($catagories['wip_type']=="Bowl Filling (Filling check)") echo 'selected="selected"';?>>Bowl Filling (Filling check)</option>
                                                         <option value="Bowl Filling (Dough check)" <?php if($catagories['wip_type']=="Bowl Filling (Dough check)") echo 'selected="selected"';?>>Bowl Filling (Dough check)</option>
                                                       </select>
                                                </div>
                                            </div>
                                            
                                            <br><br>
                                            <br>
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                 <?php $attribute = array('class' => 'control-label col-md-4');
                                                    ?>
                                                    <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary" type="button">Attibute`type<span style="color:red">*</span></button>
                                                    </div>
                                                       <select name="attribute_type" class="form-control answer_type" required="required">
                                                         <option value="">--Select--</option>
                                                         <option value="Range" <?php if($catagories['attribute_type']=="Range") echo 'selected="selected"';?>>Range</option>
                                                         <option value="Choice" <?php if($catagories['attribute_type']=="Choice") echo 'selected="selected"';?>>Choice</option>
                                                         <option value="Fixed" <?php if($catagories['attribute_type']=="Fixed") echo 'selected="selected"';?>>Text</option>
                                                       </select>
                                                </div>
                                            </div>
                                          
                                    </div>
                                    <div class="possible_select" <?php if($update_id==0 ) echo 'style="display:none;"'?>>
                                     <div class=" add_answers " >
                                     <?php $arr_choices=explode(',', $catagories['possible_answers']);  if(($catagories['attribute_type']=="Choice" ) && !empty($arr_choices)){ 
                                      $d=1;
                                     ?>
                                        <div >
                                     <div class="col-md-6" style="margin-bottom:20px;">
                                            	<div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                        <button class="btn btn-outline-secondary" type="button">Choice Type<span style="color:red">*</span></button>
                                                    </div>
                                            			<select name="possible_answer" class="form-control answer_type" required="required">
                                            				<option value="">--Select--</option>
                                            				<option value="yes/no" <?php if($catagories['possible_answers']=='yes/no') echo 'selected="selected"';?>>Yes/No</option>
                                            				<option value="acceptable/unacceptable" <?php if($catagories['possible_answers']=='acceptable/unacceptable') echo 'selected="selected"';?>>Acceptable/Unacceptable</option>
                                            				<option value="completed/not completed" <?php if($catagories['possible_answers']=='completed/not completed') echo 'selected="selected"';?>>Completed/not Completed</option>
                                            				<option value="cleaned/completed" <?php if($catagories['possible_answers']=='cleaned/completed') echo 'selected="selected"';?>>Cleaned/Completed</option>
                                            			</select>
                                            	</div>
                                            </div>
                                       
                                      <?  }elseif($catagories['attribute_type']=="Fixed"){?>
                                          <p style=""font-size:16px;color: #7296CA;>User will be asked to provide an input on mobile app.</p>
                                          <?}elseif($catagories['attribute_type']=="Range"){?>
                                          <div class="col-md-6" style="margin-bottom:20px;"> <div class="input-group mb-3"><div class="input-group-prepend"><button class="btn btn-outline-secondary" >Min Value<span style="color:red">*</span></button></div>  <input type="text" name="min_value" value="<?=$catagories['min']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"></div></div><div class="col-md-6" style="margin-bottom:20px;"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Max Value<span style="color:red">*</span></button></div><input type="text" name="max_value" value="<?=$catagories['max']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"></div></div><div class="col-md-6" style="margin-bottom:20px;"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Target Value<span style="color:red">*</span></button></div>  <input type="text" name="target_value" value="<?=$catagories['target']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"></div></div>
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
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'catagories'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </main>


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

                    $(wrapper).append('<div style="width:100%"> <div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Attibute`type<span style="color:red">*</span></button></div><select name="attribute_type" class="form-control answer_type" required="required"> <option value="">--Select--</option><option value="Range">Range</option><option value="Choice">Choice</option> <option value="Fixed" selected="selected">Text</option> </select> </div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Attribute Value <span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="possible_answer[]" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-5"> </div></div>');
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
                var outlet_id = $(this).attr('data-outlet_id');
                e.preventDefault();
                if((outlet_id!=0 || outlet_id!=null || outlet_id!=undefined) ){
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
                            url: "<?php echo  ADMIN_BASE_URL?>wip_profile/delete_catagories_attributes",
                            data: {'attribute_id':outlet_id},
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
      $('.add_answers').html('<div style="width:100%" ><div class="col-md-6 " style="margin-bottom:20px;"><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Choice Type<span style="color:red">*</span></button></div><select name="possible_answer" class="form-control answer_type" required="required"><option value="">--Select--</option><option value="yes/no">Yes/No</option><option value="acceptable/unacceptable">Acceptable/Unacceptable</option><option value="completed/not completed" >Completed/not Completed</option><option value="cleaned/completed" >Cleaned/Completed</option></select></div></div><br> ');
      var htty='<p style=""font-size:16px;color: #7296CA;>User will be asked to provide an input on mobile app.</p>';
      var httvrange=''
      var rangrtt='<div class="col-md-6" style="margin-bottom:20px;"><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Min Value<span style="color:red">*</span></button></div><input type="text" name="min_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"></div></div><div class="col-md-6" style="margin-bottom:20px;"><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Max Value<span style="color:red">*</span></button></div><input type="text" name="max_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"></div></div><div class="col-md-6" style="margin-bottom:20px;"><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" >Target Value<span style="color:red">*</span></button></div><input type="text" name="target_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"></div></div>';
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

