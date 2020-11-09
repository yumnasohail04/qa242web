<style type="text/css">
  .wrapclone  {
    border: 1px dotted;
    float: left;
    width: 100%;
    padding: 20px 0px 10px 0px;
    position: relative;
    margin-bottom:5px; 
  }
  .removedealsitem_frozen {
    position: absolute;
    top: 0;
    right: 0;
  }
.clone-remover {
    position: absolute;
    top: 0;
    padding: 3px 5px 4px 5px;
    border: 1px solid #ddd;
    border-radius: 50%;
    box-shadow: 0px 0px 6px 0px #ddd;
  }
  .redborder {
    border:1px solid red;
  }
  .append-cat-data {
    border: 1px dashed #23b7e5;
    float: left;
    padding: 20px;
    margin-bottom: 20px;
    width: 100%;
    position: relative;
  }
  .removedealsitem {
    font-size: 15px;
    position: absolute;
    right: -10px;
    top: -10px;
    padding-left: 8px;
    padding-right: 7px;
    border-radius: 50%;
    background-color: white;
    cursor: pointer;
    box-shadow: 1px 2px 2px 1px rgba(128, 128, 128, 0.9);
  }
  .marging {
    margin-top: 20px;
  }
</style>
<?php if(!isset($sfq_question_selection)) $sfq_question_selection = '';?>
              <main>
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <h1><?php
                        $cat_name =  $this->uri->segment(6);
                        $cat_name_sub =  $this->uri->segment(6);
                        if (!empty($cat_name_sub)) {
                          $cat_name =  $this->uri->segment(6);
                          $strTitle = "Edit attribute";
                        }
                        else
                        {
                          $strTitle = "New Attribute Detail";
                        }
                                
                                echo $strTitle;
                                ?></h1>
                      <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo $back_page; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
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
                            $hidden = array('hdnParentId' => $parent_id);
                          }
                          else{
                            if (!isset($catagories['is_active'])) {
                             $catagories['is_active'] = '';
                            }
                            $hidden = array('hdnParentId' => $parent_id, 'hdnId' => $update_id,'hdnActive' => $catagories['is_active'],'attribute_type'=>$attribute_type,'range_answer_id'=>$answer_id,'checkname'=>$check_name); ////edit case
                          }
                          echo form_open_multipart(ADMIN_BASE_URL.'static_form/submit_attributes/'.$parent_id.'/'.$update_id.'/'.$cat_name, $attributes, $hidden); ?>
                                    <div class="form-body">
                                        
                                       
                                                  
                            <fieldset>
                              <legend>Form Attributes</legend>
                                  <div class="row add_row" >
                                      <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <?php if(!isset($sfq_question))
                                            $sfq_question='';
                                              $data = array(
                                                'name' => 'attribute_name',
                                                'id' => 'attribute_name',
                                                'class' => 'form-control validate[required] text-input dropify-wrappe',
                                                'value' => $sfq_question,
                                                'required' => 'required',
                                            );
                                            $attribute = array('class' => 'control-label col-md-4');
                                            ?>
                                            <div class="input-group-prepend">
                                              <button class="btn btn-outline-secondary" type="button">Attibute Name</button>
                                            </div>
                                                <?php echo form_input($data); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                          <?php $attribute = array('class' => 'control-label col-md-4');
                                            ?>
                                            <div class="input-group-prepend">
                                              <button class="btn btn-outline-secondary" type="button">Attibute type</button>
                                            </div>
                                                <select name="attribute_type" class="form-control answer_type" required="required">
                                                  <option value="">--Select--</option>
                                                  <?php if(!isset($attribute_type))
                                                    $catagories['attribute_type']='';else $catagories['attribute_type']=$attribute_type;
                                                  ?>
                                                  <option value="Range" <?php if($catagories['attribute_type']=="range") echo 'selected="selected"';?>>Range</option>
                                                  <option value="Choice" <?php if($catagories['attribute_type']=="choice") echo 'selected="selected"';?>>Choice</option>
                                                <option value="Text" <?php if($catagories['attribute_type']=="text") echo 'selected="selected"';?>>Text</option>
                                                <option value="DateTime" <?php if($catagories['attribute_type']=="datetime") echo 'selected="selected"';?>>DateTime</option>
                                                <option value="Date" <?php if($catagories['attribute_type']=="dime") echo 'selected="selected"';?>>Date</option>
                                                <option value="Time" <?php if($catagories['attribute_type']=="time") echo 'selected="selected"';?>>Time</option>
                                                </select>
                                        </div>
                                    </div>
                                  
                                    <br><br>
                                    <br>
                                    </div>
                                    <div class="possible_select" <?php if($update_id==0 ) echo 'style="display:none;"'?>>
                                     <div class="row add_answers " >
                                     <?php  if((ucfirst($attribute_type)=="Choice" )){ 
                                      $d=1;
                                     ?>
                                        <div class="col-md-6" >
                                          <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                              <button class="btn btn-outline-secondary" type="button">Choice Type</button>
                                            </div>
                                            <?php if(!isset($sfq_selection_type))
                                           $sfq_selection_type = ""; ?>
                                              <select name="possible_answer" class="form-control choice_type" required="required">
                                                <option value="">--Select--</option>
                                                <option value="yes/no" <?php if($sfq_selection_type=='yes/no') echo 'selected="selected"';?>>Yes/No</option>
                                              	<option value="on/off" <?php if($sfq_selection_type=='on/off') echo 'selected="selected"';?>>On/Off</option>
                                                <option value="acceptable/unacceptable" <?php if($sfq_selection_type=='acceptable/unacceptable') echo 'selected="selected"';?>>Acceptable/Unacceptable</option>
                                                <option value="completed/not completed" <?php if($sfq_selection_type=='completed/not completed') echo 'selected="selected"';?>>Completed/not Completed</option>
                                                <option value="cleaned/completed" <?php if($sfq_selection_type=='cleaned/completed') echo 'selected="selected"';?>>Cleaned/Completed</option>
                                                <option value="release/hold" <?php if($sfq_selection_type=='release/hold') echo 'selected="selected"';?>>Release/Hold</option>
                                                <option value="pass/fail" <?php if($sfq_selection_type=='pass/fail') echo 'selected="selected"';?>>Pass/Fail</option>
                                                <option value="positive/negative" <?php if($sfq_selection_type=='positive/negative') echo 'selected="selected"';?>>Positive/Negative</option>
                                                <option value="sealed/locked" <?php if($sfq_selection_type=='sealed/locked') echo 'selected="selected"';?>>Sealed/Locked</option>
                                                <option value="other" <?php if($sfq_selection_type=='other') echo 'selected="selected"';?>>Other</option>
                                              </select>
                                          </div>
                                        </div>
                                        <?php  }elseif(ucfirst($attribute_type)=="Text" || ucfirst($attribute_type)=="DateTime" || ucfirst($attribute_type)=="Date" || ucfirst($attribute_type)=="Time"){?>
                                          <p style="" font-size:16px;color: #7296CA;>User will be asked to provide an input on mobile app.</p>
                                          <?}elseif($catagories['attribute_type']=="Range"){?>
                                          <div class="col-md-12"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Min Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="min_value" value="<?=$catagories['min']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-12" > <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Max Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="max_value" value="<?=$catagories['max']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-2">Target Value<span class="red" style="color:red;">*</span></label> <div class="col-md-5"> <input type="text" name="target_value" value="<?=$catagories['target']?>" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div>
                                          <?php }
                                          if(!empty($attribute_type) && $attribute_type=="range") {
                                            if($sfa_answer_acceptance == "refrigerated") {?>
                                              <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button"> Min Value</button>
                                                  </div>
                                                    <input type="text" name="refrigerated_min_value" value="<?=$sfa_min?>" id="refrigerated_min_value" class="form-control validate[required] text-input " required="required">
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                              <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button"> Max Value</button>
                                                  </div>
                                                    <input type="text" name="refrigerated_max_value" value="<?=$sfa_max?>" id="refrigerated_max_value" class="form-control validate[required] text-input " required="required">
                                                </div>
                                              </div>
                                              <div class="col-md-6 marging">
                                              <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button"> Target Value</button>
                                                  </div>
                                                    <input type="text" name="refrigerated_target_value" value="<?=$sfa_target?>" id="possible_answer" class="form-control validate[required] text-input " required="required">
                                                </div>
                                              </div>
                                            <?php }
                                            elseif($sfa_answer_acceptance=="frozen"){?>
                                              <span class="marging frozensec col-md-12">
                                                <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button"> Frozen Min Value</button>
                                                  </div>
                                                      <input type="text" name="frozen_min_value" value="<?=$sfa_min?>" id="refrigerated_min_value" class="form-control validate[required] text-input " required="required">
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button"> Frozen Max Value</button>
                                                  </div>
                                                      <input type="text" name="frozen_max_value" value="<?=$sfa_max?>" id="frozen_max_value" class="form-control validate[required] text-input " required="required">
                                                  </div>
                                                </div>
                                                <div class="col-md-6 ">
                                                <div class="input-group mb-3">
                                                  <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary" type="button"> Target Value</button>
                                                  </div>
                                                      <input type="text" name="frozen_target_value" value="<?=$sfa_target?>" id="frozen_target_value" class="form-control validate[required] text-input " required="required">                                                  
                                                    </div>
                                                  </div>
                                              </span>
                                            <?php }
                                            else
                                              echo "";
                                          }
                                          if(isset($sfq_selection_type) && !empty($sfq_selection_type)) {
                                            if(strtolower($sfq_selection_type) == 'other') { 
                                              if(!empty($this->uri->segment(7)) && is_numeric($this->uri->segment(7))) {
                                                $answers = Modules::run('api/_get_specific_table_with_pagination',array("sfa_question_id" =>$this->uri->segment(7),"sfa_delete"=>"0"),'sfa_id asc',DEFAULT_OUTLET.'_static_form_answer','sfa_id,sfa_answer,sfa_answer_acceptance','1','0')->result_array();
                                                if(!empty($answers)) {
                                                  $counter = 1;
                                                  foreach ($answers as $key => $ans):
                                                    if($counter == 1) { ?>
                                                    <div class="choice_attributes" style="width:100%">
                                                      <div class="col-md-6">
                                                      <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                          <button class="btn btn-outline-secondary" type="button">Selection Type</button>
                                                        </div>
                                                            <select name="selection_type" class="form-control selection_type" required="required">
                                                              <option value="single_select" <?php if(strtolower($sfq_question_selection) == 'single_select') echo 'selected'; ?>>Single Select</option>
                                                              <option value="multi_select" <?php if(strtolower($sfq_question_selection) == 'multi_select') echo 'selected'; ?>>Multi Select</option>
                                                            </select>
                                                        </div>
                                                      </div>
                                                      <?php } ?>
                                                      <?php if($counter == 1) { ?>
                                                      <span class="more_button"><button class="btn btn-info clone-cat">More</button></span>
                                                  <?php } $counter++; ?>
                                                      <span class="append-cat-data marging">
                                                        <?php if($counter != '1') echo '<span class="removedealsitem">x</span>'; ?>
                                                        <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                          <button class="btn btn-outline-secondary" type="button">Choice Name</button>
                                                        </div>
                                                              <input type="text" name="choice_name[]" value="<?php if(isset($ans['sfa_answer']) && !empty($ans['sfa_answer'])) echo $ans['sfa_answer']; ?>" id="choice_name" class="form-control validate[required] text-input dropify-wrappe" required="required">
                                                          </div>
                                                          <input type="hidden" name="others[]" value="<?php if(isset($ans['sfa_id']) && !empty($ans['sfa_id'])) echo $ans['sfa_id'];?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                          <button class="btn btn-outline-secondary" type="button">Acceptance</button>
                                                        </div>
                                                              <select name="acceptance[]" class="form-control acceptance" required="required">
                                                                <option value="acceptable" <?php if(isset($ans['sfa_answer_acceptance']) && !empty($ans['sfa_answer_acceptance'])) if(strtolower($ans['sfa_answer_acceptance']) == 'acceptable') echo 'selected'; ?>>Acceptable</option>
                                                                <option value="unacceptable" <?php if(isset($ans['sfa_answer_acceptance']) && !empty($ans['sfa_answer_acceptance'])) if(strtolower($ans['sfa_answer_acceptance']) == 'unacceptable') echo 'selected'; ?>>Unacceptable</option>
                                                              </select>
                                                          </div>
                                                        </div>
                                                      </span>
                                                       <?php endforeach; echo "
                                                    </div>";
                                                }
                                              }
                                                ?>
                                              
                                            <?php }
                                          }
                                          ?>     
                                     </div>
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
                        <a href="<?php echo $back_page; ?>">
                        <button type="button" class="btn greenbtn-outline-primary" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
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

                    $(wrapper).append('<div class="col-md-12 "> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Attribute Type<span style="color:red">*</span></button></div><select name="attribute_type" class="form-control answer_type" required="required"> <option value="">--Select--</option> <option value="Range">Range</option> <option value="Choice">Choice</option> <option value="Text" selected="selected">Text</option> <option value="DateTime" selected="selected">DateTime</option> <option value="Date" selected="selected">Date</option> <option value="Time" selected="selected">Time</option> </select> </div></div><div class="col-md-12" style="margin-bottom:20px;"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Attribute Value<span style="color:red">*</span></button></div><div class="col-md-5"> <input type="text" name="possible_answer[]" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-5"></div></div>');
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
        $('.add_answers').html('<div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Choice Type<span style="color:red">*</span></button></div><select name="possible_answer" class="form-control choice_type" required="required"> <option value="">--Select--</option> <option value="yes/no">Yes/No</option> <option value="on/off">On/Off</option> <option value="acceptable/unacceptable">Acceptable/Unacceptable</option> <option value="completed/not completed" >Completed/not Completed</option> <option value="cleaned/completed" >Cleaned/Completed</option> <option value="release/hold" >Release/Hold</option> <option value="pass/fail" >Pass/Fail</option> <option value="positive/negative" >Positive/Negative</option> <option value="sealed/locked" >Sealed/Locked</option> <option value="other" >Other</option> </select> </div></div>');
        var htty='<p style=""font-size:16px;color: #7296CA;>User will be asked to provide an input on mobile app.</p>';
        var httvrange=''
        var rangrtt='<div class="col-md-6"><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Min Value<span style="color:red">*</span></button></div><input type="text" name="refrigerated_min_value" value="" id="refrigerated_min_value" class="form-control validate[required] text-input " required="required"> </div></div><div class="col-md-6"><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Max Value<span style="color:red">*</span></button></div><input type="text" name="refrigerated_max_value" value="" id="refrigerated_max_value" class="form-control validate[required] text-input " required="required"> </div></div><div class="col-md-6 "><div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Target Value<span style="color:red">*</span></button></div><input type="text" name="refrigerated_target_value" value="" id="possible_answer" class="form-control validate[required] text-input " required="required"> </div></div>';
        if($('.answer_type').val() == 'Choice'){
           $('.possible_select').attr('style','display:block');
           $('.add_ans_btn').attr('style','display:block');
           
        }
        else if($('.answer_type').val() == 'Text' || $('.answer_type').val() == 'DateTime' || $('.answer_type').val() == 'Date' || $('.answer_type').val() == 'Time'){
           $('.possible_select').attr('style','display:block');
           $('.add_answers').html(htty);
           $('.remove_img_div').remove();
        }
        else if($('.answer_type').val() == 'Range'){
           $('.possible_select').attr('style','display:block');
           $('.add_answers').html(rangrtt);
           $('.add_ans_btn').attr('style','display:none');
           frozen();
           clone_frozen()
        }
        else
          toastr.error("Please select the Attribute type");
        choice_type();
    });
    function choice_type() {
      $('.choice_type').change(function(){
        var thiss= $(this);
        if(thiss.val() === 'other') {
          $('.choice_attributes').remove();
          $('.add_answers').append('<div class="choice_attributes" style="width:100%"> <div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Selection Type<span style="color:red">*</span></button></div><select name="selection_type" class="form-control selection_type" required="required"> <option value="single_select">Single Select</option> <option value="multi_select">Multi Select</option> </select> </div></div><span class="more_button"></span> <span class="append-cat-data marging"> <div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Choice Name<span style="color:red">*</span></button></div><input type="text" name="choice_name[]" value="" id="choice_name" class="form-control validate[required] text-input dropify-wrappe" required="required"><input type="hidden" name="others[]" value=""></div></div><div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Acceptance<span style="color:red">*</span></button></div><select name="acceptance[]" class="form-control acceptance" required="required"> <option value="acceptable">Acceptable</option> <option value="unacceptable">Unacceptable</option> </select> </div></div></span></div>');
          $('.more_button').last().append('<button class="btn btn-info clone-cat">More</button>');
          cloning();
        }
        else
          $('.choice_attributes').remove();
      });
    }
    choice_type();
    function cloning() {
      $('.append-cat-data').find('.cloning').remove();
      $('.append-cat-data').last().append('<div class="col-sm-6 cloning marging" style="float: right;"><div class="input-group mb-3"></div></div>');
      

      clone_cat();
    }
    function clone_cat() {
      $('.clone-cat').off('click').click(function(e){
        e.preventDefault();
        $('.add_answers').append('<span class="append-cat-data marging"> <span class="removedealsitem">x</span> <div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Choice Name<span style="color:red">*</span></button></div><input type="text" name="choice_name[]" value="" id="choice_name" class="form-control validate[required] text-input dropify-wrappe" required="required"> </div></div><div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Acceptance<span style="color:red">*</span></button></div><select name="acceptance[]" class="form-control acceptance" required="required"> <option value="acceptable">Acceptable</option> <option value="unacceptable">Unacceptable</option> </select> </div></div></span>');
        choice_type();
        cloning();
        removedealsitem();
      });
    }
    clone_cat();
    function removedealsitem() {
        $('.removedealsitem').off('click').click(function(){
            /*alert($('.append-cat-data').length);*/
            if($('.append-cat-data').length > 1){
                $(this).parent().remove();
            }
        })
    }
    removedealsitem();
    function frozen() {
      $('.add_answers').find('.frozing').remove();
      $('.add_answers').last().append('<div class="col-sm-6 frozing marging" style="float: right;"><div class="form-group"><label for="lstRank" class="control-label  col-md-7" style="float:right;margin-left: 20px;"><button class="btn btn-outline-primary  clone-frozen">Add Frozen Temperature</button></label></div></div>');
      clone_frozen();
    }
    function clone_frozen() {
      $('.clone-frozen').off('click').click(function(e){
        e.preventDefault();
        $('.frozensec').remove()
        $('.add_answers').append('<span class="row marging frozensec col-md-12"> <span class="removedealsitem_frozen"><i class="simple-icon-close"></i></span> <div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Frozen Min Value<span style="color:red">*</span></button></div><input type="text" name="frozen_min_value" value="" id="refrigerated_min_value" class="form-control validate[required] text-input " required="required"> </div></div><div class="col-md-6"> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Frozen Max Value<span style="color:red">*</span></button></div><input type="text" name="frozen_max_value" value="" id="frozen_max_value" class="form-control validate[required] text-input " required="required"> </div></div><div class="col-md-6 "> <div class="input-group mb-3"> <div class="input-group-prepend"><button class="btn btn-outline-secondary" type="button">Target Value<span style="color:red">*</span></button></div><input type="text" name="frozen_target_value" value="" id="frozen_target_value" class="form-control validate[required] text-input " required="required"> </div></div></span>');
        removedealsitem_frozen();
      });
      function removedealsitem_frozen() {
        $('.removedealsitem_frozen').off('click').click(function(){
            /*alert($('.append-cat-data').length);*/
                $('.frozensec').remove();
        })
    }
    removedealsitem();
    }
  </script>

