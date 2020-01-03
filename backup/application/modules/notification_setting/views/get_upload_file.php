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
                       <form method="post" id="submit_upload_image" action="<?= ADMIN_BASE_URL.'notification_setting/submit_upload_image/';?>" enctype="multipart/form-data">
                            <div class="form-body"> 
                                <div class="row main_div">
                                  <div class="input-group">
                                  <input type="file" name="upload_file" id="filetype">
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
  $(document).off('click', '.submit_upload_image').on('click', '.submit_upload_image', function(e){
    e.preventDefault();
    if( document.getElementById("filetype").files.length == 0 )
        toastr.success("Please select the file");
    else
      $('#submit_upload_image').attr('action', "<?= ADMIN_BASE_URL.'notification_setting/submit_upload_image/';?>").submit();
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

