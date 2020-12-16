<style type="text/css">
    .red_class {
        border: 1px solid red !important;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    {
        width:100%;
    }
    .btn-group.open .dropdown-toggle {
        background-color: transparent;
    }
    .input-group  mb-3{
        padding-bottom: 15px;
    }
.input_fields_wrap
{
   border: 1px solid #757576;
    padding: 1%;
    margin-bottom: 2%;
    margin-top: 2%;
    margin-left: 0%;
}
.cross-icon
{
width:100%}
</style>
<?php include_once("select_box.php");?>
                <main>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-12">
                        <h1> <?php if (empty($update_id)) 
                        $strTitle = 'Add Ingredient';
                      else 
                        $strTitle = 'Edit Ingredient';
                        echo $strTitle;
                      ?></h1>
                        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'ingredients/supplier_item'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
                        <div class="separator mb-5"></div>
                      </div>
                    </div>
                <div class="card mb-4">
                  <div class="card-body">
                    <h5 class="mb-4">
                      </h5>


                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'ingredients/submit_supplier_item/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'ingredients/submit_supplier_item/' . $update_id, $attributes);
                        ?>
                  <div class="form-body section-box">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                   
                  
                        <fieldset>
                          <legend>Supplier Items</legend>

                        </fieldset>
                        <div class="row">
                      
                        
                      
                        <div class="rap_clone" style="width:100%;">
                            <?php if(isset($selected_supplier) && !empty($selected_supplier)){
                                foreach($selected_supplier as $value){ ?>
                            <div class="input_fields_wrap row" style="width:100%;">
                            <i class="simple-icon-close delete_record cross-icon" rel="<?php echo $value['id'];?>" rel_ingredient="<?php echo $value['ingredient_id'];?>" style="float:right;"></i>

                                <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                      <?php if(!isset($groups)) $groups = array();
                                      if(!isset($value['supplier_id'])) $value['supplier_id'] = ""; ?>
                                      <?php $options = $groups ;
                                      $attribute = array('class' => 'control-label col-md-4');
                                      ?>
                                      <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Name <span style="color:red">*</span></button>
                                      </div>
                                        <?php echo form_dropdown('supplier_name[]', $options, $value['supplier_id'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                                    </div>
                                 </div>
                                 <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                      <?php if(!isset($role)) $role = array();
                                      if(!isset($value['role'])) $value['role'] = ""; ?>
                                      <?php $options = $role ;
                                      $attribute = array('class' => 'control-label col-md-4');?>
                                      <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Role <span style="color:red">*</span></button>
                                      </div>
                                        <?php echo form_dropdown('role[]', $options, $value['role'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                                    </div>
                                 </div>
                                  <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                        <?php
                                        $data = array(
                                            'name' => 's_item_name[]',
                                            'id' => 's_item_name',
                                            'class' => 'form-control',
                                            'value' => $value['s_item_name'],
                                            'type' => 'text',
                                            'required' => 'required',
                                            'data-parsley-type'=>"integer",
                                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Item Name <span style="color:red">*</span></button>
                                      </div>
                                            <?php echo form_input($data); ?>
                                    </div>
                                </div>
                                  <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                        <?php
                                        $data = array(
                                            'name' => 's_item_no[]',
                                            'id' => 's_item_no',
                                            'class' => 'form-control',
                                            'value' => $value['s_item_no'],
                                            'type' => 'text',
                                            'required' => 'required',
                                            'data-parsley-type'=>"integer",
                                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Item Number<span style="color:red">*</span></button>
                                      </div>
                                            <?php echo form_input($data); ?>
                                    </div>
                                </div>
                            </div>
                            <?}}else{?>
                            <div class="input_fields_wrap row" style="width:100%;">
                                <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                      <?php if(!isset($groups)) $groups = array();
                                      if(!isset($value['supplier_id'])) $value['supplier_id'] = ""; ?>
                                      <?php $options = $groups ;
                                      $attribute = array('class' => 'control-label col-md-4');?>
                                      <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Name<span style="color:red">*</span></button>
                                      </div>
                                        <?php echo form_dropdown('supplier_name[]', $options, $value['supplier_id'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                                    </div>
                                 </div>
                                <div class="col-sm-6">
                                    <div class="input-group  mb-3">
                                      <?php if(!isset($role)) $role = array();
                                      $options = $role ;
                                      $attribute = array('class' => 'control-label col-md-4');?>
                                      <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Role<span style="color:red">*</span></button>
                                      </div>
                                        <?php echo form_dropdown('role[]', $options, "",  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                                    </div>
                                 </div>
                                  <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                        <?php
                                        $data = array(
                                            'name' => 's_item_name[]',
                                            'id' => 's_item_name',
                                            'class' => 'form-control',
                                             'value' => '',
                                            'type' => 'text',
                                            'required' => 'required',
                                            'data-parsley-type'=>"integer",
                                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Item Name<span style="color:red">*</span></button>
                                      </div>
                                            <?php echo form_input($data); ?>
                                    </div>
                                </div>
                                  <div class="col-sm-5">
                                    <div class="input-group  mb-3">
                                        <?php
                                        $data = array(
                                            'name' => 's_item_no[]',
                                            'id' => 's_item_no',
                                            'class' => 'form-control',
                                            'value' => '',
                                            'type' => 'text',
                                            'required' => 'required',
                                            'data-parsley-type'=>"integer",
                                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        ?>
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-secondary" type="button">Supplier Item Number <span style="color:red">*</span></button>
                                        </div>
                                        <?php echo form_input($data); ?>
                                    </div>
                                </div>
                            </div>
                            <?}?>
                        </div>
                        <div class="col-md-12">
                            <button class="add_field_button btn btn-outline-primary" style="margin-right: 30px;">Add Supplier</button>
                        </div>
                      <div class="col-md-12" >
                      <a href="<?php echo ADMIN_BASE_URL . 'ingredients'; ?>">
                        <button type="button" class="btn green btn-outline-primary" style="margin-left:20px;float:right;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> 
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submited_form" style="float:right;"><i class="fa fa-check"></i>&nbsp;Save</button>
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
        var type_id=$('#selectboxing').val();
        $.ajax({
          type: "POST",
          url: "<?php echo ADMIN_BASE_URL?>ingredients/get_doc_name",
          data: {'type_id': type_id},
          success: function(data){
            var html="";
            if(data.doc !=""){
            for(var i = 0; i < data.doc.length; i++) {
                    var obj = data.doc[i];
                    html += '<div class="col-md-12"><div class="input-group  mb-3"> <label class="control-label col-md-4" id="doc_label">'+obj+'</label><div class="col-md-8"> <input type="file" name="news_main_page_file_'+i+'" id="news_d_file" class="default"></div></div></div>';
                }
            }else
            {
                html += 'No Documents to be Uploaded';
            }
            $('.doc_data').html(html);
            
          }
       });
    });

    $(document).off("change", "#selectboxing").on("change", "#selectboxing",function(event){
      var type_id=$('#selectboxing').val();
        $.ajax({
          type: "POST",
          url: "<?php echo ADMIN_BASE_URL?>ingredients/get_doc_name",
          data: {'type_id': type_id},
          success: function(data){
            var html="";
            if(data.doc !=""){
            for(var i = 0; i < data.doc.length; i++) {
                    var obj = data.doc[i];
                    html += '<div class="col-md-12"><div class="input-group  mb-3"> <label class="control-label col-md-4" id="doc_label">'+obj+'</label><div class="col-md-8"> <input type="file" name="news_main_page_file_'+i+'" id="news_d_file" class="default"></div></div></div>';
                }
            }else
            {
                html += 'No Documents to be Uploaded';
            }
            $('.doc_data').html(html);
            
          }
       });
    });
    
    $(document).off('click', '#delete_doc').on('click', '#delete_doc', function(e){
                var doc_id=$(this).attr("data-doc-id");
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Document?",
                text : "You will not be able to recover this Document!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>ingredients/delete_doc",
                            data: {'doc_id': doc_id},
                            async: false,
                            success: function() {
                                location.reload();
                            }
                        });
                swal("Deleted!", "Document has been deleted.", "success");
              });

            });
            
        $(document).ready(function() {
            var max_fields      = 5;
            var wrapper         = $(".input_fields_wrap");
            var add_button      = $(".add_field_button");
            
            var x = 1;
            hyTy = '<div class="input_fields_wrap row" style="width:100%;"> <i class="simple-icon-close clone-remover cross-icon" style="float:right;"></i><div class="col-sm-5"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Supplier Name <span style="color:red">*</span></button> </div><select name="supplier_name[]" class="form-control select2me required validatefield" id="role_id" tabindex="8"> <?php foreach($group as $key=> $value){?> <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option> <?php }?> </select> </div></div><div class="col-sm-5"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Supplier Role <span style="color:red">*</span></button> </div><select name="role[]" class="form-control select2me required validatefield" id="role_id" tabindex="8"> <?php foreach($role as $key=> $value){ ?> <option value="<?php echo $value; ?>"><?php echo $value; ?></option> <?php }?> </select> </div></div><div class="col-sm-5"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Supplier Item Name <span style="color:red">*</span></button> </div><input type="text" name="s_item_name[]" value="" id="s_item_name" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div><div class="col-sm-5"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Supplier Item Number <span style="color:red">*</span></button> </div><input type="text" name="s_item_no[]" value="" id="s_item_no" class="form-control" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div>';
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
            var ingredientid = $(this).attr('rel_ingredient');
            e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Ingredient's Supplier?",
                text : "You will not be able to recover this Supplier!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                        $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>ingredients/delete_attributes",
                            data: {'id': id,'ingredientid':ingredientid},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "Supplier has been deleted.", "success");
              });

            });
</script>