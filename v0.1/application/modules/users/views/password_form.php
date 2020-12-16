<?php
$attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal' , 'data-parsley-validate' => '', 'novalidate' => '');
if (empty($update_id)) {
	$update_id = 0;
} else {
	$hidden = array('hdnId' => $update_id); ////edit case
}
if (isset($hidden) && !empty($hidden))
	echo form_open_multipart(ADMIN_BASE_URL . 'users/change_pass/' . $update_id , $attributes, $hidden);
else
	echo form_open_multipart(ADMIN_BASE_URL . 'users/change_pass/' . $update_id , $attributes);
?>
    <div class="col-sm-12">
        <div class="input-group mb-3">
        <?php
        $data = array(
        'name' => 'user_name',
        'id' => 'user_name',
        'class' => 'form-control',
        'type' => 'text',
        'value' => $users['user_name'],
        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
        
        'readonly'=>'true',
        );
        $attribute = array('class' => 'control-label col-md-3');
        ?>
         <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Username<span style="color:red">*</span></button>
                          </div>
        <?php echo form_input($data); ?>
    </div>
    </div>

    <div class="col-sm-12">
        <div class="input-group mb-3">
        <?php
        $data = array(
        'name' => 'password',
        'id' => 'new_password',
        'class' => 'form-control',
        'type' => 'password',
        'required' => 'required',
        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
        
        );
        $attribute = array('class' => 'control-label col-md-3');
        ?>
        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">New Password<span style="color:red">*</span></button>
                          </div>
        <?php echo form_input($data); ?>
          </div>
    </div>

<div class="form-actions fluid no-mrg">
        <div class="col-md-offset-3 col-md-3">
            <button type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
        </div>
</div>

<?php echo form_close(); ?> 
    
<script>
$('#form_sample_1').parsley();

$(document).off("submit", "#form_sample_1").on("submit", "#form_sample_1", function(event){
	event.preventDefault();
	$.ajax({
		type: 'POST',
		url: "<?= ADMIN_BASE_URL ?>users/change_password_action",
		data: {'user_name': $("#user_name").val(), 'password': $("#new_password").val()},
		async: false,
		success: function(){
			$('#password_Modal').modal('hide')
			toastr.success('Password changed successfully.');
		}
	});

});

</script>