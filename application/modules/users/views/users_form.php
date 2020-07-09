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
          <?php if (empty($update_id)) 
                        $strTitle = 'Add Users';
                    else 
                        $strTitle = 'Edit Users';
                        echo $strTitle;
             
                 ?>
                            <a href="<?php echo ADMIN_BASE_URL . 'users'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a> 
        </h3>
          
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
           <div class="tab-content" style="margin-top:-30px;">
          <div class="panel panel-default">
            <div class="tab-pane  active" id="tab_2">
              <div class="portlet box green">
                <div class="portlet-title">

                </div>
                <div class="portlet-body form"> 

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

                    <div class="row" style="margin-top:15px;">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                          $data = array(
                          'name' => 'user_name',
                          'id' => 'user_name',
                          'class' => 'form-control validatefield',
                          'type' => 'text',
                          'required' => 'required',
                          'tabindex' => '1',
                          'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                          'value' => $users['user_name'],
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>                   
                          <?php echo form_label('User Name<span style="color:red">*</span>', 'user_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?>  <span id="message"></span></div>
                         
                        </div>
                         <?php  $read_only = false;
                          if (isset($update_id) && !empty($update_id)) { ?>
                          <script type="text/javascript">jQuery('#user_name').attr('readonly', true);</script>
                          <? } ?>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                          $data = array(
                          'name' => 'email',
                          'id' => 'email',
                          'class' => 'form-control validatefield',
                          'type' => 'email',
                          'tabindex' => '2',
                          'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                          'value' => $users['email'],
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Email<span style="color:red">*</span>', 'email', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
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
                          <?php echo form_label('First Name<span style="color:red">*</span>', 'first_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
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
                          <?php echo form_label('Last Name<span style="color:red">*</span>', 'last_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>                     
                      </div>                   
                    </div>

                    <div class="row">
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                          $data = array(
                          'name' => 'phone',
                          'id' => 'phone',
                          'class' => 'form-control validatefield',
                          'type' => 'number',
                          'tabindex' => '5',
                          'value' => $users['phone'],
                          //'pattern' => '\d{3}[\-]\d{3}[\-]\d{4}',
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Cell Phone<span style="color:red">*</span>', 'phone', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
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
                            $attribute = array('class' => 'control-label col-md-4');
                            echo form_label('Office Phone<span style="color:red">*</span>', 'office_phone', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    
                    
                    <div class="row">
						          <?php if($update_id == 0){ ?>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                          $data = array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control validatefield',
                            'type' => 'password',
                            'tabindex' => '7',
                            'required' => 'required',
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Password<span style="color:red">*</span>', 'password', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
						          <?php } ?>
                    </div>
                    
                    <div class="row">
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php if(!isset($groups)) $groups = array();
                          if(!isset($users['group'])) $users['group'] = ""; ?>
                          <input type="hidden" name="previous_primary" value="<?=$users['group']?>">
                          <?php $options = array('' => 'Select')+$groups ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Primary Group <span style="color:red">*</span>', 'role_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('group', $options, $users['group'],  'class="form-control select2me required validatefield" id="prim_grp" tabindex ="8"'); ?>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group">
                       <?php if(!isset($groups)) $groups = array();
                          if(!isset($users['second_group'])) $users['second_group'] = ""; ?>
                          <input type="hidden" name="previous_secondry" value="<?=$users['second_group']?>">
                          <?php $options = array('' => 'Select')+$groups ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Secondary Group ', 'role_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('second_group', $options, $users['second_group'],  'class="form-control select2me" id="sec_grp" tabindex ="8"'); ?>
                        </div>
                      </div>
                    </div>
                     
                    <div class="col-sm-5">
                      <div class="form-group">
                      <label class="control-label col-md-4">Image</label>
                      <div class="col-md-8">
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                      <?php
                      if(!isset($users['user_image']))
                          $users['user_image'] = "";
                      $filename =  FCPATH.'/'.ACTUAL_OUTLET_USER_IMAGE_PATH.$users['user_image'];
                      if (isset($users['user_image']) && !empty($users['user_image']) && file_exists($filename)) {
                      ?>
                      <img class="uploaded-image" src = "<?php echo BASE_URL.ACTUAL_OUTLET_USER_IMAGE_PATH.$users['user_image'] ?>" />
                      <?php
                      } else {
                      ?>
                      <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                      <?php
                      }
                      ?>
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                      </div>
                      <div>
                      <span class="btn default btn-file">
                      <span class="fileupload-new">
                      <i class="fa fa-paper-clip"></i> Select Image
                      </span>
                      <span class="fileupload-exists">
                      <i class="fa fa-undo"></i> Change
                      </span>
                      <input type="file" name="user_image" id="user_image" class="default" />
                      </span>
                      <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                      </div>
                      </div>
                      </div>
                      </div>
                    </div> 
                    <div class="col-sm-5" id="sign_show">
                      <div class="form-group last">
                      <label class="control-label col-md-4">Signature</label>
                      <div class="col-md-8">
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                      <?php
                      if(!isset($users['sign_image']))
                          $users['sign_image'] = "";
                      $filename =  FCPATH.'/'.ACTUAL_SIGNATURE_IMAGE_PATH.$users['sign_image'];
                      if (isset($users['sign_image']) && !empty($users['sign_image']) && file_exists($filename)) {
                      ?>
                      <img class="uploaded-image" src = "<?php echo BASE_URL.ACTUAL_SIGNATURE_IMAGE_PATH.$users['sign_image'] ?>" />
                      <?php
                      } else {
                      ?>
                      <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                      <?php
                      }
                      ?>
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                      </div>
                      <div>
                      <span class="btn default btn-file">
                      <span class="fileupload-new">
                      <i class="fa fa-paper-clip"></i> Select Image
                      </span>
                      <span class="fileupload-exists">
                      <i class="fa fa-undo"></i> Change
                      </span>
                      <input type="file" name="sign_image" id="sign_image" class="default" />
                      </span>
                      <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                      </div>
                      </div>
                      </div>
                      </div>
                    </div>
                     
                    </div>

                    <div class="form-actions fluid no-mrg">
                      <div class="row">
                        <div class="col-md-6">
                         <div class="col-md-offset-3 col-md-9" style="padding-bottom:15px;">
                            <button type="submit" class="btn btn-primary buttonsubmit btnsave" tabindex="13" style="margin-left:10px;"><i class="fa fa-check"></i>&nbsp;Save</button>
                            <a href="<?php echo ADMIN_BASE_URL . 'users'; ?>">
                             <button type="button"  class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                            </a> </div>
                        </div>
                        <div class="col-md-6"> </div>
                      </div>
                    </div>

                  </div>
                </div>

                <?php echo form_close(); ?> 
                <!-- END <--> 
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
                $(this).css("border", "1px solid #dde6e9");
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
        
       </script>