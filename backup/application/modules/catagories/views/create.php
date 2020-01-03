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
                    if (empty($update_id)) 
                        $strTitle = 'Add Category';
                    else 
                        $strTitle = 'Edit Category';
                    
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'catagories'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                                $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                                    if (empty($update_id)) {
                                        $update_id = 0;
                                    } else {
                                        $hidden = array('hdnId' => $update_id); ////edit case
                                    }
                                    if (isset($hidden) && !empty($hidden))
                                        echo form_open_multipart(ADMIN_BASE_URL . 'catagories/submit/' . $update_id , $attributes, $hidden);
                                    else
                                        echo form_open_multipart(ADMIN_BASE_URL . 'catagories/submit/' . $update_id , $attributes);
                                ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    <div class="row">
                      <div class="col-sm-5">
                         <div class="form-group">
                                                    <?php
                                                    $data = array(
                                                        'name' => 'txtCatName',
                                                        'maxlength'   => '500',
                                                        'id'          => 'txtCatName',
                                                        'class' => 'form-control text-input',
                                                        'value' => $catagories['cat_name'],
                                                        'required' => 'required',
                                                    );
                                                    $attribute = array('class' => 'control-label col-md-4');
                                                    ?>
                                                    <?php echo form_label('Process step <span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                                                    <div class="col-md-8">
                                                    <?php echo form_input($data); ?>
                                                    </div>
                                                    
                                                </div>
                      </div>
                                                  


                     
                    </div>
 <h3 class="form-section">Check Types</h3>
                     <div class="row rap_clone section-box">
                    <?php if(isset($subcat_arr) && !empty($subcat_arr)){
                        foreach($subcat_arr as $value){

                            ?>
                    <div class="input_fields_wrap">
                    <input type="hidden" name="cat_ids[]" value="<?=$value['id']?>" />
                      <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'subcat[]',
                                    'id' => 'attribute_name',
                                    'class' => 'form-control',
                                    'value' => $value['cat_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Check type name: <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          
                         
                        
                        <i class="fa fa-times delete_record cross-icon" rel="<?php echo $value['id'];?>" rel_product="<?php echo $value['parent_id'];?>" style="float:left;"></i>
                    </div>
                    <?}}else{?>
                            <div class="input_fields_wrap">
                            <input type="hidden" name="cat_ids[]" value="" />
                      <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'subcat[]',
                                    'id' => 'attribute_name',
                                    'class' => 'form-control',
                                    'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label(' Sub Category <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          
                    </div>
                    <?}?>
                </div>
                <br>
                <div >
                    <button class="add_field_button btn btn-primary" style="float:right;margin-right: 30px;">Add Sub Category</button>
                </div>
                  

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

<script type="text/javascript">

 $('#form_sample').submit(function() {

        var error = 0;
        var comment = $('#comment').val();
        if (comment == '') {
            error = 1;
           $('#error').html('This value is required').css('color', 'red');;
        }

        if (error) {
            return false;
        } else {
            return true;
        }

    });
$('#txtCatName').keyup(function() {
    $('#txtPageUrl').val($(this).val());
});
    

$(document).ready(function() {
        $("#catagories_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
    var max_fields      = 500;
    var wrapper         = $(".input_fields_wrap");
    var add_button      = $(".add_field_button");
    
    var x = 1;
    hyTy = '<div class="input_fields_wrap"> <input type="hidden" name="cat_ids[]" value="" /><div class="col-sm-5"> <div class="form-group"> <label for="txtNewsTitle" class="control-label col-md-4">Check type name: <span class="required" style="color:#ff60a3">*</span></label> <div class="col-md-8"> <input type="text" name="subcat[]" value="" id="attribute_name" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div><i class="fa fa-times clone-remover cross-icon" style="float:left;"></i></div>';
    $(add_button).click(function(e){
         var curInputs = $('#attribute_name');
               isValid = true;
               
           $(".form-group").removeClass("has-error");
           for(var i=0; i<curInputs.length; i++){
               if (!curInputs[i].validity.valid){
                   isValid = false;
                   $(curInputs[i]).closest(".form-group").addClass("has-error");
               }
   
           }
        e.preventDefault();
             $('.rap_clone').append(hyTy);
             if($('.input_fields_wrap').length == 1){ 
                
                $('.wrapclone').find('.chosen-container').remove();
               
             } else {
                $(".wrapclone:last-child").find('.chosen-container').remove();
             }
            
             $('.chosen-select').chosen();
             $('.clone-remover').on("click", function(e){
                $(this).parent().remove();
            })
    });
    
    $('.clone-remover').on("click", function(e){

        e.preventDefault();  $(this).parent().remove();
         x--;
    })
});

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                var productid = $(this).attr('rel_product');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Sub Category?",
                text : "You will not be able to recover this Sub Category!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>catagories/delete_sub_catagories",
                            data: {'id': id,'pid':productid},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", " Sub Category has been deleted.", "success");
              });

            });

</script>