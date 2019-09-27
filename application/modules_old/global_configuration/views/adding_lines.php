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
                       <form method="post" id="submited_line" action="<?= ADMIN_BASE_URL.'global_configuration/submit_line_data/';?>">
                            <div class="form-body"> 
                                <div class="row main_div">
                                   	<div class="col-sm-12 selecting_div">
                                        <div class="form-group">
                                          <label class="col-sm-4 control-label">Line Name</label>
                                            <div class="col-sm-8">
                                               	<input type="number" name="line_name" class="form-control validate_form" value="<?=$line_name?>">
                                                <input type="hidden" name="update_id" class="form-control" value="<?=$update_id?>">
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
  $(document).off('click', '.submited_line').on('click', '.submited_line', function(e){
    e.preventDefault();
    if(validateForm()) {
      $('#submited_line').attr('action', "<?= ADMIN_BASE_URL.'global_configuration/submit_line_data/';?>").submit();
    } else {
      //return
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