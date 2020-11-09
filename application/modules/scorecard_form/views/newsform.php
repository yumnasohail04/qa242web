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
            <main>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                    <h1> <?php 
                  if (empty($update_id)) 
                    $strTitle = 'Add ';
                else 
                    $strTitle = 'Edit ';
                    echo $strTitle;
                    ?></h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'scorecard_form'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
                    <div class="separator mb-5"></div>
                  </div>
                </div>
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="mb-4">
                
                  </h5>
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
                      <div class="col-sm-6" >
                        <div class="input-group  mb-3">
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
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">ScoreCard Team<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>
                      <div class="col-sm-6" >
                        <div class="input-group  mb-3">
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
                          <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Description<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group  mb-3">
                          <?php if(!isset($groups)) $groups = array();
                            if(!isset($value['assigned_to'])) $value['assigned_to'] = ""; ?>
                            <?php $options = $groups ;
                            $attribute = array('class' => 'control-label col-md-4');?>
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Assigned to<span style="color:red">*</span></button>
                            </div>
                            <?php echo form_dropdown('assigned_to', $options, $value['assigned_to'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions fluid no-mrg">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                           <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submit_from"><i class="fa fa-check"></i>&nbsp;Save</button>
                            <a href="<?php echo ADMIN_BASE_URL . 'scorecard_form'; ?>">
                              <button type="button" class="btn green btn-outline-primary" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
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