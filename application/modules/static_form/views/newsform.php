<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>pretty-checkbox.min.css">
<style type="text/css">
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
                    <h1>  <?php 
                    if (empty($update_id)) 
                                $strTitle = 'Add Checks';
                            else 
                                $strTitle = 'Edit Checks';
                                echo $strTitle;
                                ?></h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'static_form'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
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
                      echo form_open_multipart(ADMIN_BASE_URL . 'static_form/submit/' . $update_id, $attributes, $hidden);
                  else
                      echo form_open_multipart(ADMIN_BASE_URL . 'static_form/submit/' . $update_id, $attributes);
                  ?>
                  <div class="form-body">
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    <div class="row">
                      <div class="col-sm-6" >
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
                          <?php echo form_label('Check Name<span class="red" style="color:red;">*</span>', 'txtPhone', $attribute); ?>
                          <div class="col-md-12">
                          <?php echo form_input($data); ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Inspection Team<span class="red" style="color:red;">*</span></label>
                          <div class="col-sm-12">
                            <select name="inspection_team[]" class="form-control select-1 inspection_team" required="required" multiple>
                              <option >Select</option>
                              <?php if(!isset($groups) || empty($groups))
                                      $groups = array();
                                foreach ($groups as $value): ?>
                                  <option value="<?=$value['id']?>" 
                                    <?php 
                                    $exist = array_search($value['id'], array_column($inspection_team, 'sci_team_id'));
                                    foreach($news as $new){ if(is_numeric($exist)) echo 'selected="selected"';}?>><?= $value['group_title']?>
                                  </option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Review Team<span class="red" style="color:red;">*</span></label>
                          <div class="col-sm-12">
                            <select class="form-control review_team" name="review_team" required="required">
                              <option >Select</option>
                              <?php if(!isset($groups) || empty($groups))
                                      $groups = array();
                                foreach ($groups as $value): ?>
                                  <option value="<?=$value['id']?>" 
                                    <?php foreach($news as $new){ if($value['id']== $news['sf_reviewer']) echo 'selected="selected"';}?>><?= $value['group_title']?>
                                  </option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">Approve Team<span class="red" style="color:red;">*</span></label>
                          <div class="col-sm-12">
                            <select class="form-control approve_team" name="approve_team" required="required">
                              <option >Select</option>
                              <?php if(!isset($groups) || empty($groups))
                                      $groups = array();
                                foreach ($groups as $value): ?>
                                  <option value="<?=$value['id']?>" 
                                    <?php foreach($news as $new){ if($value['id'] == $news['sf_approver']) echo 'selected="selected"';}?>><?= $value['group_title']?>
                                  </option>
                                <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="col-sm-4 control-label">
                            Program Type <span class="required" style="color:#ff60a3">*</span>
                          </label>
                          <div class="col-sm-12">
                            <select  multiple="multiple" class="form-control program_type select-1 " name="program_type[]">
                              <?php 
                                  if(!isset($program_type)) 
                                      $program_type = array();
                                  if(!isset($selected_program))
                                      $selected_program = array();
                                  if(!empty($program_type)) {
                                    foreach ($program_type as $pt_key => $pt):
                                        $checking = array_search($pt['program_id'], array_column($selected_program, 'spt_program_id'));
                                      if($pt['program_status'] != 0 || is_numeric($checking)) { ?>
                                        <option value="<?=$pt['program_id']?>" <?php if(is_numeric($checking)) echo 'selected="selected"'; ?>>
                                          <?=$pt['program_name']?>
                                        </option>
                                      <?php }
                                    endforeach;
                                  }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="pretty p-icon p-toggle p-plain">
                        <input type="checkbox" />
                        <div class="state p-success-o p-on">
                            <i class="icon mdi mdi-eye"></i>
                            <label>Show preview</label>
                        </div>
                        <div class="state p-off">
                            <i class="icon mdi mdi-eye-off"></i>
                            <label>Hide preview</label>
                        </div>
                      </div> -->
                      <div class="col-sm-6" style="clear: both">
                        <div class="form-group">
                          <div class="pretty p-default ">
                                <label class="col-sm-4">Set Check duration</label>
                            <input type="checkbox" name="is_dates" class="validate_form col-sm-8 check_set" <?php if(!empty($news['is_dates'])) echo 'checked="checked"'; ?> />
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row datetimeshow" <?php if(!isset($news['is_dates']) || empty($news['is_dates'])) echo 'style="display: none;"';?> >
                        <fieldset style="width:100%;">
                    <legend>Check Duration</legend>
                        
                    </fieldset>
                      <div class="col-sm-6">
                        <?php $news_date='';
                         if (isset($news['sf_start_datetime']) && $news['sf_start_datetime'] != "0000-00-00 00:00:00" && !empty($news['sf_start_datetime']) && $news['sf_start_datetime']!="1970-01-01") {
                             $news_date = date('m/d/Y', strtotime($news['sf_start_datetime']));
                            } 
                          else
                            $news_date = date('m/d/Y');
                          ?>
                        <div class="form-group">
                          <?php
                            $data = array(
                                'name' => 'start_date',
                                'id' => 'start_date',
                                'class' => 'form-control',
                                'value' => $news_date,
                                'type' => 'text',
                                'required' => '1',
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('Start Date <span class="required" style="color:red">*</span>', 'start_date', $attribute); ?>
                          <div class="col-md-12 input-group date datetimepicker2"> <?php echo form_input($data); ?> 
                            <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <?php $news_date='';
                        if (isset($news['sf_start_datetime']) && $news['sf_start_datetime'] != "0000-00-00 00:00:00" && !empty($news['sf_start_datetime'])) {
                           $news_date = date('H:i', strtotime($news['sf_start_datetime']));
                        } 
                        else { 
                         $news_date = date('H:i');
                       
                          $timestamp =strtotime($news_date) + 60*60;
                          $news_date = date('H:i', $timestamp);
                        } ?>
                        <div class="form-group">
                           <?php
                              $data = array(
                                  'name' => 'start_time',
                                  'id' => 'start_time',
                                  'class' => 'form-control',
                                  'value' => $news_date ,
                                  'type' => 'text',
                                  'required' => '1',
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                           <?php echo form_label('Start time <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                           <div class="col-md-12 input-group  datetimepicker1"> <?php echo form_input($data); ?> 
                              <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-clock"></i>
                                            </span>
                           </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <?php $news_date='';
                          if (isset($news['sf_end_datetime']) &&  $news['sf_end_datetime'] != "0000-00-00 00:00:00" && !empty($news['sf_end_datetime'])  && $news['sf_end_datetime']!="1970-01-01") {
                               $news_date = date('m/d/Y', strtotime($news['sf_end_datetime']));
                          } 
                          else
                            $news_date = '';
                        ?>
                        <div class="form-group">
                          <?php
                            $data = array(
                                'name' => 'end_date',
                                'id' => 'end_date',
                                'class' => 'form-control',
                                'value' => $news_date,
                                'type' => 'text'
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            echo form_label('End date', 'txtNewsDate', $attribute);
                          ?>
                          <div class="col-md-12 input-group date datetimepicker2"> <?php echo form_input($data); ?> 
                              <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <?php 
                          $news_date='';
                          if (isset($news['sf_end_datetime']) && $news['sf_end_datetime'] != "0000-00-00 00:00:00" && !empty($news['sf_end_datetime'])) {
                            $news_date = date('H:i', strtotime($news['sf_end_datetime']));
                          } 
                          else { 
                            $news_date = '';
                            /*$news_date = date('H:i');
                            $timestamp =strtotime($news_date) + 60*60;
                            $news_date = date('H:i', $timestamp);*/
                          } 
                        ?>
                        <div class="form-group">
                          <?php
                            $data = array(
                              'name' => 'end_time',
                              'id' => 'end_time',
                              'class' => 'form-control',
                              'value' =>  $news_date,
                              'type' => 'text'
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            echo form_label('End time', 'txtNewsDate', $attribute);
                          ?>
                          <div class="col-md-12 input-group  datetimepicker1"> <?php echo form_input($data); ?> 
                             <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-clock"></i>
                                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-actions fluid no-mrg">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                           <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submit_from"><i class="fa fa-check"></i>&nbsp;Save</button>
                            <a href="<?php echo ADMIN_BASE_URL . 'static_form'; ?>">
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
<script type="text/javascript">
  $(document).off('click', '.submit_from').on('click', '.submit_from', function(e){
    var reviewing = $( ".review_team option:selected" ).val();
    var approve = $( ".approve_team option:selected" ).val();
    e.preventDefault();
    if(validateForm()) {
      var checkingg = true;
      if(reviewing.toLowerCase() == 'select' && approve.toLowerCase() == 'select')
        console.log("both not selected");
      else {
        if((reviewing == '' || reviewing == null || reviewing == 'undefined' || reviewing.toLowerCase() == 'select') || (approve == '' || approve == null || approve == 'undefined' || approve.toLowerCase() == 'select')) {
          checkingg = false;
          if(reviewing == '' || reviewing == null || reviewing == 'undefined' || reviewing.toLowerCase() == 'select')
            $( ".review_team" ).addClass('redd');
          else
            $( ".review_team" ).removeClass('redd');
          if(approve == '' || approve == null || approve == 'undefined' || approve.toLowerCase() == 'select')
            $( ".approve_team" ).addClass('redd');
          else
            $( ".approve_team" ).removeClass('redd');
        }
      }
      if(checkingg == true)
        $('#form_sample_1').submit();
      } 
      else {
      console.log("a");
      }
  });
  function validateForm() {
    var isValid = true;
    $('.validate_form').each(function(){
      if($(this).val() == '' || $(this).val() == null){
        $(this).addClass('redd');
        isValid = false;
      } else {
        $(this).removeClass('redd');
      }
    });
    if($('.inspection_team').val() == '' || $('.inspection_team').val() == null || $('.inspection_team').val()== 'undefined') {
      isValid = false;
      $('.inspection_team').parent().find('.chosen-choices').addClass('redd');
    }
    else
      $('.inspection_team').parent().find('.chosen-choices').removeClass('redd');
    var program_select = $('.program_type').val();
    if(program_select == '' || program_select == null || program_select == 'undefined' ) {
      isValid = false;
      $('.program_type').parent().find('.chosen-choices').addClass('redd');
    }
    else
      $('.program_type').parent().find('.chosen-choices').removeClass('redd');
    var ischecked= $(".pretty input:checkbox").is(':checked');
    if(!ischecked) {

      $('.pretty.p-default input~.state label:before').css('border', '1px solid red !important;');
    }
    else
      $('.pretty.p-default input:checked~.state label:before').css('border', 'border: 1px solid #bdc3c7 !important;');
    /*if($( ".selectpicker option:selected" ).val() == '' || $( ".selectpicker option:selected" ).val() == null || $('.enddate').val()== 'undefined') {
      isValid = false;
      $(".selectpicker").eq(1).addClass('red');
    }
    else
      $(".selectpicker").eq(1).removeClass('red');
    alert($( ".selectpicker option:selected" ).val());*/
    return isValid;
  }
  $(".pretty input:checkbox").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked)
      $('.datetimeshow').css('display', 'none');
    else
      $('.datetimeshow').css('display', 'inline');
  }); 
  $('.chosen-select').chosen();
</script>