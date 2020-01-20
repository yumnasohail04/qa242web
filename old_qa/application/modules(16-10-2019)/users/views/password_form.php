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
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
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
        <?php echo form_label('Username ', 'user_name', $attribute); ?>
        <div class="col-md-7"> <?php echo form_input($data); ?> </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
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
        <?php echo form_label('New Password <span class="required" style="color:red">*</span>', 'password', $attribute); ?>
        <div class="col-md-7"> <?php echo form_input($data); ?> </div>
        </div>
    </div>
</div>

<div class="form-actions fluid no-mrg">
    <div class="row">
        <div class="col-md-offset-3 col-md-3">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
        </div>
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