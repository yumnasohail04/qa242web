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
                    $strTitle = 'Add Product';
                else 
                    $strTitle = 'Edit Product';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="txtNewsTitle" class="control-label col-md-12 heading-label">Product Information<span class="required" style="color:#ff60a3"></span></label>
                        </div>
                    </div>
                    </div>
                    <div class="row section-box">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'product_title',
                                    'id' => 'product_title',
                                    'class' => 'form-control',
                                    'value' => $news['product_title'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Product Title <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'navision_no',
                                    'id' => 'navision_no',
                                    'class' => 'form-control',
                                    'value' => $news['navision_no'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Navision Number<span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'brand_name',
                                    'id' => 'brand_name',
                                    'class' => 'form-control',
                                    'value' => $news['brand_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Brand Name <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'unit_weight',
                                    'id' => 'unit_weight',
                                    'class' => 'form-control',
                                    'value' => $news['unit_weight'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Unit Weight (oz)<span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'shape',
                                    'id' => 'shape',
                                    'class' => 'form-control',
                                    'value' => $news['shape'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Product Shape <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'channel',
                                    'id' => 'channel',
                                    'class' => 'form-control',
                                    'value' => $news['channel'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Product Channel <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'shelf_life',
                                    'id' => 'shelf_life',
                                    'class' => 'form-control',
                                    'value' => $news['shelf_life'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Shelf Life <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'packaging_type',
                                    'id' => 'packaging_type',
                                    'class' => 'form-control',
                                    'value' => $news['packaging_type'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Packaging Type <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $product_type = array('Gluten'=>'Gluten','Seafood'=>'Seafood','Vegetarian'=>'Vegetarian','Meat'=>'Meat','FDA'=>'FDA','USDA'=>'USDA','Organic'=>'Organic');
                                $options = array('General' => 'General')+$product_type ;
                                $attribute = array('class' => 'control-label col-md-4');
                                echo form_label('Product Type <span style="color:red">*</span>', 'product_type', $attribute);?>
                                <div class="col-md-8">
                                    <?php echo form_dropdown('product_type', $options, $news['product_type'],  'class="form-control select2me" required="required" id="product_type" tabindex ="12"'); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $storage_type = array('Refrigerated'=>'Refrigerated','Frozen'=>'Frozen');
                                $options = array('Refrigerated' => 'Refrigerated')+$storage_type ;
                                $attribute = array('class' => 'control-label col-md-4');
                                echo form_label('Storage Type <span style="color:red">*</span>', 'product_type', $attribute);?>
                                <div class="col-md-8">
                                    <?php echo form_dropdown('storage_type', $options, $news['storage_type'],  'class="form-control select2me" required="required" id="storage_type" tabindex ="12"'); ?>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="txtNewsTitle" class="control-label col-md-12 heading-label">Product's attribute<span class="required" style="color:#ff60a3"></span></label>
                        </div>
                    </div>
                </div>
                <div class="row rap_clone section-box">
                    <?php if(isset($product_attribute) && !empty($product_attribute)){
                        foreach($product_attribute as $value){

                            ?>
                    <div class="input_fields_wrap">
                      <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'attribute_name[]',
                                    'id' => 'attribute_name',
                                    'class' => 'form-control',
                                    'value' => $value['attribute_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Attribute Name <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'min_value[]',
                                    'id' => 'min_value',
                                    'class' => 'form-control',
                                    'value' => $value['min_value'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Min value <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'target_val[]',
                                    'id' => 'target_val',
                                    'class' => 'form-control',
                                    'value' => $value['target_value'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Target value <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'max_value[]',
                                    'id' => 'max_value',
                                    'class' => 'form-control',
                                    'value' => $value['max_value'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Max value <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <i class="fa fa-times delete_record cross-icon" rel="<?php echo $value['id'];?>" rel_product="<?php echo $value['product_id'];?>" style="float:left;"></i>
                    </div>
                    <?}}else{?>
                    <div class="input_fields_wrap">
                      <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'attribute_name[]',
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
                                <?php echo form_label('Attribute Name <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'min_value[]',
                                    'id' => 'min_value',
                                    'class' => 'form-control',
                                    'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Min value <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'target_val[]',
                                    'id' => 'target_val',
                                    'class' => 'form-control',
                                     'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Target value <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                          <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'max_value[]',
                                    'id' => 'max_value',
                                    'class' => 'form-control',
                                    'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Max value <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?}?>
                </div>
                <br>
                <div>
                    <button class="add_field_button btn btn-primary" style="float:right;margin-right: 30px;">Add more Attributes</button>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="txtNewsTitle" class="control-label col-md-12 heading-label">Wip Profile<span class="required" style="color:#ff60a3"></span></label>
                        </div>
                    </div>
                </div>
                <div class="row section-box">
                    <div class="row">
                        <div class="col-sm-5" style="clear: both !important;">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Select Wip Product<span class="required" style="color:#ff60a3">*</span></label>
                                <div class="col-sm-8">
                                    <select  multiple="multiple" class="form-control product_select  chosen-select " name="navigation_select[]">
                                        <?php
                                            if(!isset($all_navigation) || empty($all_navigation))
                                                $all_navigation = array();
                                            if(!empty($all_navigation)) {
                                                if(!isset($selected_navigation) || empty($selected_navigation))
                                                    $selected_navigation = array();
                                                foreach ($all_navigation as $key => $an):
                                                    $checking = array_search($an['navision_number'], array_column($selected_navigation, 'navision_number'));
                                                    if(is_numeric($checking) || $an['status'] == '1') { ?>
                                                        <option <?php if(is_numeric($checking)) echo 'selected="selected"'; ?> value="<?=$an['navision_number']?>">
                                                            <?=$an['navision_number']?>
                                                        </option>
                                                    <?php }
                                                endforeach;
                                            }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>">
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

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });



</script>
<script type="text/javascript">
    $(document).ready(function() {
    var max_fields      = 5;
    var wrapper         = $(".input_fields_wrap");
    var add_button      = $(".add_field_button");
    
    var x = 1;
    hyTy = '<div class="input_fields_wrap"> <div class="col-sm-5"> <div class="form-group"> <label for="txtNewsTitle" class="control-label col-md-4">Attribute Name <span class="required" style="color:#ff60a3">*</span></label> <div class="col-md-8"> <input type="text" name="attribute_name[]" value="" id="attribute_name" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div><div class="col-sm-5"> <div class="form-group"> <label for="txtNewsTitle" class="control-label col-md-4">Min value <span class="required" style="color:#ff60a3">*</span></label> <div class="col-md-8"> <input type="text" name="min_value[]" value="" id="min_value" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div><div class="col-sm-5"> <div class="form-group"> <label for="txtNewsTitle" class="control-label col-md-4">Target value <span class="required" style="color:#ff60a3">*</span></label> <div class="col-md-8"> <input type="text" name="target_val[]" value="" id="target_val" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div><div class="col-sm-5"> <div class="form-group"> <label for="txtNewsTitle" class="control-label col-md-4">Max value <span class="required" style="color:#ff60a3">*</span></label> <div class="col-md-8"> <input type="text" name="max_value[]" value="" id="max_value" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div><i class="fa fa-times clone-remover cross-icon" style="float:left;"></i></div>';
    $(add_button).click(function(e){
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
                title : "Are you sure to delete the selected Product's attribute?",
                text : "You will not be able to recover this Attribute!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>product/delete_attributes",
                            data: {'id': id,'productid':productid},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "Attribute has been deleted.", "success");
              });

            });

</script>