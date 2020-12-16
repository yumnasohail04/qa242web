<style type="text/css">
	.red {
		border: 1px solid red;
	}
</style>
<div class="page-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       <form method="post" id="submited_shift_timing" action="<?= ADMIN_BASE_URL.'global_configuration/submit_shift_timing_data/';?>">
                            <div class="form-body"> 
                                <div class="row main_div">
                                   	<div class="col-sm-12 selecting_div">
                                        <div class="form-group">
                                          <label class="col-sm-4 control-label">Shift Name</label>
                                            <div class="col-sm-12">
                                               	<select name="shift" class="form-control validate_form">
                                                  <option value="">Select </option>
                                                  <?php if(isset($shifts) && !empty($shifts)) {
                                                    foreach ($shifts as $key => $sh): ?>
                                                      <option value="<?=$sh['shift_id'];?>" <?php if(isset($st_shift) && !empty($st_shift)) if($st_shift == $sh['shift_id']) echo 'selected="selected"'; ?> ><?=$sh['shift_name'];?></option>
                                                    <?php endforeach;
                                                  } ?>
                                                </select>
                                                <input type="hidden" name="update_id" class="form-control" value="<?=$update_id?>">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group" style="margin-top: 8px;">
                                          <label class="col-sm-4 control-label">Shift Day</label>
                                            <div class="col-sm-12">
                                              <select name="shift_day" class="form-control validate_form">
                                                <option value="">Select Day</option>
                                                <option value="Sunday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Sunday') echo 'selected="selected"'; ?>>Sunday</option>
                                                <option value="Monday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Monday') echo 'selected="selected"'; ?>>Monday</option>
                                                <option value="Tuesday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Tuesday') echo 'selected="selected"'; ?>>Tuesday</option>
                                                <option value="Wednesday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Wednesday') echo 'selected="selected"'; ?>>Wednesday</option>
                                                <option value="Thursday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Thursday') echo 'selected="selected"'; ?>>Thursday</option>
                                                <option value="Friday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Friday') echo 'selected="selected"'; ?>>Friday</option>
                                                <option value="Saturday" <?php if(isset($st_day) && !empty($st_day)) if($st_day == 'Saturday') echo 'selected="selected"'; ?>>Saturday</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 8px;">
                                          <label class="col-sm-4 control-label">Start Time</label>
                                            <div class="col-sm-12">
                                                <div class="input-group datetimepicker1">
                                                  <input type="text" name="start_time" class="form-control validate_form" value="<?php if(isset($st_start) && !empty($st_start)) echo $st_start; ?>" >
                                                  <span class="input-group-text input-group-append input-group-addon">
                                                      <i class="simple-icon-clock"></i>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="">
                                          <label class="col-sm-4 control-label">End Time</label>
                                            <div class="col-sm-12">
                                                <div class="input-group datetimepicker1">
                                                  <input type="text" name="end_time" class="form-control validate_form" value="<?php if(isset($st_end) && !empty($st_end)) echo $st_end; ?>">
                                                  <span class="input-group-text input-group-append input-group-addon">
                                                      <i class="simple-icon-clock"></i>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!--    </div>-->
</div>
</div>
<script type="text/javascript">
  $(document).off('click', '.submited_shift_timing').on('click', '.submited_shift_timing', function(e){
    e.preventDefault();
    if(validateForm()) {
      $('#submited_shift_timing').attr('action', "<?= ADMIN_BASE_URL.'global_configuration/submit_shift_timing_data/';?>").submit();
    }
  });
  function validateForm() {
    var isValid = true;
    $('.validate_form').each(function(){
      if($(this).val() == '' || $(this).val() == null){
        $(this).attr('style','border:1px solid red;');
        $(this).siblings('.chosen-container').attr('style','border:1px solid red;')
        isValid = false;
      } else {
        $(this).removeAttr('style');
        if($(this).siblings('.chosen-container')){
          $(this).siblings('.chosen-container').removeAttr('style');
        }
      }
    });
    return isValid;
  }
</script>