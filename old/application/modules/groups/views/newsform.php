<section>
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
                    $strTitle = 'Add Group';
                else 
                    $strTitle = 'Edit Group';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'groups'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'groups/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'groups/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    <legend > Group Information</legend>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'group_title',
                                    'id' => 'group_title',
                                    'class' => 'form-control',
                                    'value' => $news['group_title'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label(' Title <span class="required" style="color:red">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-sm-5">
                                    <div class="form-group">
                                        <?php
                                        $data = array(
                                            'name' => 'group_desc',
                                            'id' => 'group_desc',
                                            'rows' => '11',
                                            'cols' => '10',
                                            'class' => 'form-control note-editor',
                                            'data-parsley-maxlength'=>1000,
                                             'required' => 'required',
                                            'value' => $news['group_desc']
                                        );
                                        $attribute = array('class' => 'control-label col-md-4');
                                        echo form_label(' Description', 'txtShortDesc', $attribute);
                                        ?>

                                        <div class="col-md-8">
                                            <?php echo form_textarea($data); ?> 
                                        </div>
                                    </div>
                                </div>
                      

                     <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php

                                    $options = array('' => 'Select')+$roles_title ;
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label(' Role <span style="color:red">*</span>', 'role', $attribute);?>
                                    <div class="col-md-8"><?php echo form_dropdown('role', $options, $news['role'],  'class="form-control select2me" required="required" id="role" tabindex ="12"'); ?></div>                            </div>
                    </div>
                        
                       
                      
                        
                        
                    
                    </div>
                
               
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
</section>