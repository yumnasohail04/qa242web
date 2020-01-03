<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>pretty-checkbox.min.css">
<style type="text/css">
   /*.pretty.p-default input~.state label:before {
    border: 1px solid red !important;
  }*/
  /*.pretty.p-default input:checked~.state label:before {
    border: 1px solid #bdc3c7 !important;
  }*/

  .redd {
    border: 1px solid red !important;
  }
  .check_set {
          margin-left: -30%!important;
  }
</style>
<?php include_once("select_box.php");?>
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
                    $strTitle = 'Add ';
                else 
                    $strTitle = 'Edit ';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'scorecard_form'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                  }
                  if (isset($hidden) && !empty($hidden))
                      echo form_open_multipart(ADMIN_BASE_URL . 'scorecard_form/submit/' . $update_id, $attributes, $hidden);
                  else
                      echo form_open_multipart(ADMIN_BASE_URL . 'scorecard_form/submit/' . $update_id, $attributes);
                  ?>
                  <div class="form-body">
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    <div class="row">
                      <div class="col-sm-5" >
                        <div class="form-group">
                          <?php
                          $data = array(
                          'name' => 'sf_name',
                          'id' => 'sf_name',
                          'class' => 'form-control validate_form',
                          'type' => 'text',
                          'value' => $news['sf_name'],
                          'required'=>'required',
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('ScoreCard Team<span class="red" style="color:red;">*</span>', 'txtPhone', $attribute); ?>
                          <div class="col-md-8">
                          <?php echo form_input($data); ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-5" >
                        <div class="form-group">
                          <?php
                          $data = array(
                          'name' => 'sf_desc',
                          'id' => 'sf_desc',
                          'class' => 'form-control validate_form',
                          'type' => 'text',
                          'value' => $news['sf_desc'],
                          'required'=>'required',
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Description<span class="red" style="color:red;">*</span>', 'txtPhone', $attribute); ?>
                          <div class="col-md-8">
                          <?php echo form_input($data); ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php if(!isset($groups)) $groups = array();
                            if(!isset($value['assigned_to'])) $value['assigned_to'] = ""; ?>
                            <?php $options = $groups ;
                            $attribute = array('class' => 'control-label col-md-4');
                            echo form_label('Assigned to <span style="color:red">*</span>', 'role_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('assigned_to', $options, $value['assigned_to'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions fluid no-mrg">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                           <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary submit_from"><i class="fa fa-check"></i>&nbsp;Save</button>
                            <a href="<?php echo ADMIN_BASE_URL . 'scorecard_form'; ?>">
                            <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                            </a> </div>
                        </div>
                        <div class="col-md-6"> </div>
                      </div>
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