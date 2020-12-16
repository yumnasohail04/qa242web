<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1> <?php if (empty($update_id)) 
        $strTitle = 'Add Users';
      else 
        $strTitle = 'Edit Users';
        echo $strTitle;
      ?></h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'users'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
        <div class="separator mb-5"></div>
      </div>
    </div>
<div class="card mb-4">
  <div class="card-body">
    <h5 class="mb-4">
    
      </h5>
      <?php
        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal', 'data-parsley-validate' => '', 'novalidate' => '' );
        if (empty($update_id)) {
          $update_id = 0;
        } else {
          $hidden = array('hdnId' => $update_id);
        }
        if (isset($hidden) && !empty($hidden))
          echo form_open_multipart(ADMIN_BASE_URL . 'users/submit/' . $update_id , $attributes, $hidden);
        else
          echo form_open_multipart(ADMIN_BASE_URL . 'users/submit/' . $update_id , $attributes);
      ?>

                    <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group  mb-3">
                          <?php
                          $data = array(
                          'name' => 'user_name',
                          'id' => 'user_name',
                          'class' => 'form-control validatefield',
                          'type' => 'text',
                          'required' => 'required',
                          'aria-label' => '',
                          'aria-describedby'=>"basic-addon1",
                          'value' => $users['user_name'],
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>                   
                          <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Username<span style="color:red">*</span></button>
                                </div>
                          <?php echo form_input($data); ?>
                         
                        </div>
                      <div id="message"></div>
                         <?php  $read_only = false;
                          if (isset($update_id) && !empty($update_id)) { ?>
                          <script type="text/javascript">jQuery('#user_name').attr('readonly', true);</script>
                          <?php } ?>
                      </div>



                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php
                          $data = array(
                          'name' => 'email',
                          'id' => 'email',
                          'class' => 'form-control validatefield',
                          'type' => 'email',
                          'tabindex' => '2',
                          'value' => $users['email'],
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Email<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php
                          $data = array(
                          'name' => 'first_name',
                          'id' => 'first_name',
                          'class' => 'form-control validatefield',
                          'type' => 'text',
                          'tabindex' => '3',
                          'required' => 'required',
                         'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                          'value' => $users['first_name'],
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">First Name<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>



                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php
                          $data = array(
                          'name' => 'last_name',
                          'id' => 'last_name',
                          'class' => 'form-control validatefield',
                          'type' => 'text',
                          'tabindex' => '4',
                          //'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                         'value' => $users['last_name'],
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Last Name<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>                     
                      </div>          
                     <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php
                          $data = array(
                          'name' => 'phone',
                          'id' => 'phone',
                          'class' => 'form-control validatefield',
                          'type' => 'number',
                          'tabindex' => '5',
                          'value' => $users['phone'],
                          //'pattern' => '\d{3}[\-]\d{3}[\-]\d{4}',
                          ); ?>
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Phone<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php
                          $data = array(
                            'name' => 'office_phone',
                            'id' => 'office_phone',
                            'class' => 'form-control validatefield',
                            'type' => 'number',
                            'tabindex' => '6',
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                            'value' => $users['office_phone'],
                            );
                            ?>
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Office Phone<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>
						          <?php if($update_id == 0){ ?>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php
                          $data = array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control validatefield',
                            'type' => 'password',
                            'tabindex' => '7',
                            'required' => 'required',
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                          );?>
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Password<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>
                      <?php } ?>
                     <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <?php if(!isset($groups)) $groups = array();
                          if(!isset($users['group'])) $users['group'] = ""; ?>
                          <input type="hidden" name="previous_primary" value="<?=$users['group']?>">
                          <?php $options = array('' => 'Select')+$groups ;
                          ?>
                          <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Primary Group<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_dropdown('group', $options, $users['group'],  'class="custom-select validatefield" id="prim_grp"'); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-group mb-3">
                       <?php if(!isset($groups)) $groups = array();
                          if(!isset($users['second_group'])) $users['second_group'] = ""; ?>
                          <input type="hidden" name="previous_secondry" value="<?=$users['second_group']?>">
                          <?php $options = array('' => 'Select')+$groups ;
                          ?>
                          <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Secondary Group<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_dropdown('second_group', $options, $users['second_group'],  'class="custom-select validatefield" id="sec_grp"'); ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6" style="margin-bottom: 5px;">
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Profile Pic</button>
                          </div>
                            <div class="col-md-10" imagetype="imagevalidation" id=""  image="">
                            <?php
                            $path="";
                              if(!isset($users['user_image']))
                                  $users['user_image'] = "";
                              $file_name=  BASE_URL.ACTUAL_OUTLET_USER_IMAGE_PATH.$users['user_image'];?>
                                <input type="file" name="user_image" id="user_image"  class="dropify imagevalidation dropify-image-clone"  accept='image/*' data-default-file="<?php echo $file_name?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" style="margin-bottom: 5px;" id="sign_show">
                        <div class="input-group">
                         <?php
                            $path="";
                              if(!isset($users['sign_image']))
                                  $users['sign_image'] = "";
                              $file_name=  BASE_URL.ACTUAL_SIGNATURE_IMAGE_PATH.$users['sign_image'];?>
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Signature</button>
                          </div>
                            <div class="col-md-10" imagetype="imagevalidation" id="<?php echo $update_id; ?>"  image="<?php echo $file_name; ?>">
                                <input type="file" name="sign_image" id="sign_image"   class="dropify imagevalidation dropify-image-clone"  accept='image/*' data-default-file="<?php echo $file_name?>">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="input-group" style="margin-top:3%;">
                        <button type="submit" class="btn btn-outline-success mb-1 buttonsubmit btnsave">Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'users'; ?>"><button type="button" class="btn btn-outline-primary  mb-1">Cancel</button></a>
                      </div>
                    </div>
                   

                  </div>
                </div>

                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </main>



<script type="text/javascript">
        $(document).ready(function(){
          check_group_role();
        });
        var datasubmit=null;   
        $(document).off("click", ".buttonsubmit").on("click", ".buttonsubmit", function(event){
          event.preventDefault();
          if(validateForm()) {
            $("#message").html("<img src='<?= STATIC_ADMIN_IMAGE?>ajax-loader.gif' />");
            var user_name=$("#user_name").val();
            $.ajax({
              type:"post",
              data: {'user_name': user_name},
              url: "<?php ADMIN_BASE_URL?>users/validate",
              success:function(result){
                if(result == 1){
                   $("#message").html("<span style='color:red;'>User already exists..!</span>");
                }
                else {
                   $("#message").html("<img src='<?= STATIC_ADMIN_IMAGE?>ajax-loader.gif' />").hide(); 
                   $( ".form-horizontal" ).submit();
                }
              }
            });
          }
        })

        function validateForm() {
          var isValid = true;
          $('.validatefield').each(function() {
            if ( $(this).val() === '') {
               $(this).css("border", "1px solid red");
              isValid = false;
            }
            else 
                $(this).css("border", "1px solid #28a745");
          });
          if($('#role_id').find(":selected").val() != '' && $('#role_id').find(":selected").val() != '0') {
            $('#role_id').attr('style','border:1px solid #dde6e9;');
          }
          else {
            $('#role_id').attr('style','border:1px solid red !important;');
            isValid = false;
          }
          if($('#designation').find(":selected").val() != '' && $('#designation').find(":selected").val() != '0') {
            $('#designation').attr('style','border:1px solid #dde6e9;');
          }
          else {
            $('#designation').attr('style','border:1px solid red !important;');
            isValid = false;
          }
          return isValid;

        }
        $(document).on("change", "#prim_grp", function(event){
            check_group_role();
        })
        $(document).on("change", "#sec_grp", function(event){
            check_group_role();
        })
        function check_group_role()
        {
          var sec_grp=$("#sec_grp").val();
          var prim_grp=$("#prim_grp").val();
          $.ajax({
              type:"post",
              data: {'prim_grp': prim_grp,'sec_grp': sec_grp},
              url: "<?php echo ADMIN_BASE_URL?>users/check_if_editor",
              success:function(result){
                if(result == 1){
                  document.getElementById("sign_show").style.display = "block";
                }
                else {
                  document.getElementById("sign_show").style.display = "none";
                }
              }
            });
        }
        function image_remover() {
            var pathURL = "file_path/";
            var dropifyElements = {};
            $('.dropify').each(function() {
                dropifyElements[this.id] = true;
            });
            var drEvent = $('.dropify').dropify();
            drEvent.on('dropify.beforeClear', function(event, element) {
                if($('.dropify-image-clone').length >1) {
                    var abc = $(this);
                    id = event.target.id;
                    if(dropifyElements[id]) {
                        swal({
                            title: "Are you sure?",
                            text: "You will not be able undo this operation!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel please!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }, function(isConfirm) {
                            if (isConfirm) {
                                var id = abc.parent().parent().attr('id');
                                var image = abc.parent().parent().attr('image');
                                if(id) {
                                    $.ajax({
                                        type: 'POST',
                                        url: "<?= ADMIN_BASE_URL?>product/delete_product_image",
                                        data: {'id': id,image:image},
                                        async: false,
                                        success: function(result) {
                                            var array = []; 
                                            $("input[name='"+change_images_id+"[]']").each(function() {
                                                if($(this).val() !== null && $(this).val() !== '' || $(this).val() != 0 && id != $(this).val())
                                                    array.push($(this).val());
                                            });
                                            $("input[name='"+change_images_id+"[]']").val(array);
                                        }
                                    });
                                }
                                element.resetPreview();
                                element.clearElement();
                                swal.close();
                               // abc.parent().parent().parent().parent().remove();
                            } else {
                                swal({
                                    title:"Cancelled",
                                    text:"Delete Cancelled :)",
                                    type:"error",
                                    timer: 2000,
                                });
                            }
                        });
                        return false;
                    }
                }
                else {
                    swal({title:"Cancelled",text:"Last image can't be remove :)",type:"error",timer: 2000,});
                    return false;
                }
            });
            drEvent.on('change', function(event, element) {
                var abc = $(this);
                var id = abc.parent().parent().attr('id');
                var array = []; 
                $("input[name='"+change_images_id+"[]']").each(function() {
                    if($(this).val() !== null && $(this).val() !== '' || $(this).val() != 0)
                        array.push($(this).val());
                });
                if(id !== null && id !== '' || id != 0)
                    array.push(id);
                if (array.length != 0)
                    $("input[name='"+change_images_id+"[]']").val(array);
            });
	}
	image_remover();
       </script>