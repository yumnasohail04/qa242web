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
                       <form method="post" id="submited_shift" action="<?= ADMIN_BASE_URL.'global_configuration/submit_shift_data/';?>">
                            <div class="form-body"> 
                                <div class=" main_div">
                                   	<div class="col-sm-12 selecting_div">
                                        <div class="form-group">
                                          <label class="col-sm-4 control-label">Shift Name</label>
                                            <div class="col-sm-12">
                                               	<input type="text" name="shift_name" class="form-control validate_form" value="<?=ucfirst($shift_name);?>">
                                                <input type="hidden" name="update_id" class="form-control" value="<?=$update_id?>">
                                            </div>
                                        </div>
                                        <!-- <hr>
                                        <div class="form-group" style="margin-top: 8px;">
                                          <label class="col-sm-4 control-label">Shift Day</label>
                                            <div class="col-sm-8">
                                              <select name="shift_day" class="form-control validate_form">
                                                <option value="">Select Day</option>
                                                <option value="Sunday">Sunday</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                              </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: left;margin-top: 8px;">
                                          <label class="col-sm-4 control-label">Start Time</label>
                                            <div class="col-sm-8">
                                                <div class="input-group date">
                                                  <input type="text" name="start_time" class="form-control validate_form" value="" >
                                                  <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: left;">
                                          <label class="col-sm-4 control-label">End Time</label>
                                            <div class="col-sm-8">
                                                <div class="input-group date">
                                                  <input type="text" name="end_time" class="form-control validate_form" value="">
                                                  <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                  </span>
                                                </div>
                                            </div>
                                        </div> -->
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
  $(document).off('click', '.submited_shift').on('click', '.submited_shift', function(e){
    e.preventDefault();
    if(validateForm()) {
      $('#submited_shift').attr('action', "<?= ADMIN_BASE_URL.'global_configuration/submit_shift_data/';?>").submit();
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