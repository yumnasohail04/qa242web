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
    fieldset .input-group  mb-3 {
    margin-bottom: 15px;
    }
    input[type="checkbox"] {
    height: 16px;
    }
     .form-control {
      min-height: calc(0em + .8rem);
    }
    .clone-remover , .delete_attribute
    {
      position: absolute;
      top: 3%;
      right: -8%;
    }
</style>  
<?php include_once("select_box.php");?>

          <main>
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <h1> <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Document';
                else 
                    $strTitle = 'Edit Document';
                    echo $strTitle;
                    ?></h1>
                  <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'ingredient_doc'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'ingredient_doc/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'ingredient_doc/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body section-box">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                   <div class="container">
                    <div class="row">
                      <div class="col-sm-6">
                          <div class="input-group  mb-3">
                              <?php
                              $data = array(
                                  'name' => 'title',
                                  'id' => 'title',
                                  'class' => 'form-control',
                                  'value' => $new['title'],
                                  'type' => 'text',
                                  'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                              <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Question<span style="color:red">*</span></button>
                                </div>
                                  <?php echo form_input($data); ?>
                          </div>
                      </div>
                      <div class="col-sm-6">
                            <div class="input-group mb-3">
                              <?php if(!isset($selection_type)) $selection_type = array();
                              if(!isset($new['type'])) $new['type'] = ""; ?>
                              <?php $options =$selection_type ;
                              $attribute = array('class' => 'control-label col-md-4');?>
                              <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Selection Type<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_dropdown('type', $options, $new['type'],  'class="form-control select2me required validatefield" id="selection_type" tabindex ="8"'); ?>
                            </div>
                         </div>
                      </div>
                      <div class="row rap_clone" id="custom_options">
                      <div style="text-align: right;" class="col-sm-12 col-md-12">
                          <button type="button" style="position:absolute;right:0;" class="btn btn-sm btn-outline-primary add_field_button">+</button>
                      </div>
                      <?php if(isset($option_quest) && !empty($option_quest)){
                        foreach($option_quest as $key=> $val){ ?>
                        <div class="col-sm-12 col-md-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'option[]',
                                    'id' => 'option',
                                    'class' => 'form-control',
                                    'value' => $val['option'],
                                    'type' => 'text',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                      <button class="btn btn-outline-secondary" type="button">Option<span style="color:red">*</span></button>
                                  </div>
                                    <?php echo form_input($data); ?>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary delete_attribute" rel="<?php echo $val['id']; ?>">x</button>
                        </div>
                        <?php } } else
                        {?>
                        <div class="col-sm-12 col-md-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'option[]',
                                    'id' => 'option',
                                    'class' => 'form-control',
                                    'value' => '',
                                    'type' => 'text',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                      <button class="btn btn-outline-secondary" type="button">Option<span style="color:red">*</span></button>
                                  </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <?php } ?>
                      
                      </div>
                      <div class="row">
                      <div class="col-sm-12">
                        <div class="input-group  mb-3">
                       
                        <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button"> Comment box?<span style="color:red">*</span></button>
                                </div>
                          <input type="checkbox" name="comment_box" id="comment_box" class="form-control" <?php if( isset($new['comment_box']) && $new['comment_box']=="1") echo "checked";?>  <?php if( isset($new['comment_box']) && !empty($new['comment_box'])){?> value=" <?php echo $new['comment_box']; ?>" <?php } ?>>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="input-group  mb-3">
                       
                        <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button"> Supporting Attachment?<span style="color:red">*</span></button>
                                </div>
                          <input type="checkbox" name="attachment" id="attachment" class="form-control" <?php if( isset($new['attachment']) && $new['attachment']=="1") echo "checked";?>  <?php if( isset($new['attachment']) && !empty($new['attachment'])){?> value=" <?php echo $new['attachment']; ?>" <?php } ?>>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="input-group  mb-3">
                        <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button"> Supporting Attachment Expiration Date?<span style="color:red">*</span></button>
                                </div>
                          <input type="checkbox" name="expiry" id="expiry" class="form-control" <?php if( isset($new['expiry']) && $new['expiry']=="1") echo "checked";?>  <?php if( isset($new['expiry']) && !empty($new['expiry'])){?> value=" <?php echo $new['expiry']; ?>" <?php } ?>>
                        </div>
                      </div>



                     




                    </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'ingredient_doc'; ?>">
                        <button type="button" class="btn greenbtn-outline-primary" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                </div>
                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </main>


<script>

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
   

    });

    
   

    $(document).off("change", "#comment_box").on("change", "#comment_box",function(event){
        if(document.getElementById('comment_box').checked)
            $('#comment_box').val('1')
        else
            $('#comment_box').val('0')
      });


    $(document).off("change", "#reference_link").on("change", "#reference_link",function(event){
      if(document.getElementById('reference_link').checked)
          $('#reference_link').val('1')
      else
          $('#reference_link').val('0')
    });

    function check_sub_options(other){
      if(other=="other")
        document.getElementById( 'custom_options' ).style.display = 'block';
      else
        document.getElementById( 'custom_options' ).style.display = 'none';
    }
        
    $(document).ready(function(){
      check_sub_options($('#selection_type').val());
    });
    $(document).off("change", "#selection_type").on("change", "#selection_type",function(event){
            check_sub_options($(this).val());
        });

        $(document).ready(function() {
        var add_button      = $(".add_field_button");
            hyTy = ' <div class="col-sm-6"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Option<span style="color:red">*</span></button> </div><input type="text" class="form-control" id="option" name="option[]"> </div> <button type="button" class="btn btn-sm btn-outline-primary clone-remover">x</button></div>';
            $(add_button).click(function(e){
                e.preventDefault();
                     $(this).parent().parent().parent().find('.rap_clone').append(hyTy);
                     $(".input-group.date").datepicker({
                        autoclose: true,
                        rtl: false,
                        templates: {
                        leftArrow: '<i class="simple-icon-arrow-left"></i>',
                        rightArrow: '<i class="simple-icon-arrow-right"></i>'
                        }
                    });
                    $('.clone-remover').on("click", function(e){
                        $(this).parent().remove();
                    })
            });
            $('.clone-remover').on("click", function(e){
                $(this).parent().remove();
            })
        });

        
        $(document).on('click', '.delete_attribute', function(e){
              e.preventDefault();
              var id = $(this).attr('rel');
              swal({
                title : "Are you sure to delete the selected Option?",
                text : "You will not be able to recover this Option!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : true
              },
                function () {
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>ingredient_doc/delete_attribute",
                            data: {'id': id},
                            async: false,
                            success: function() {
                              location.reload();
                            }
                        });
                swal("Deleted!", "Option has been deleted.", "success");
              });

            });

</script>
