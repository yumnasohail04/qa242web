<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="Bootstrap Admin App + jQuery">
<meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
<title>Bilpleien - Login</title>
<link rel="icon" href="<?php echo STATIC_FRONT_IMAGE?>16X16.ico" type="image/x-icon">
<!-- =============== VENDOR STYLES ===============-->
<!-- ============== Toastr ====================== -->
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css"> 
<!-- FONT AWESOME-->
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>font-awesome.min.css">
<!-- SIMPLE LINE ICONS-->
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>simple-line-icons.css">
<!-- =============== BOOTSTRAP STYLES ===============-->
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap.css" id="bscss">
<!-- =============== APP STYLES ===============-->
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>app.css" id="maincss">
</head>
<body>
<div class="wrapper">
  <div class="block-center mt-xl wd-xl">
     <!-- START panel-->
     <div class="panel panel-dark panel-flat">
        <div class="panel-heading text-center">
           <a href="#">
               <img src="<?php echo base_url().'uploads/general_setting/small_images/logo_car.png'?>" alt="logo" class="img-responsive" id="login_logo"/>
           </a>
        </div>
        <div class="panel-body">
           <p class="text-center pv">SET YOUR NEW PASSWORD.</p>
           <?php
                $attributes = array('autocomplete' => 'off', 'id' => 'reset_password');
                echo form_open(ADMIN_BASE_URL.'login/submit_login', $attributes);
				echo '<input type="hidden" name="hdn_email" id="hdn_email" value="'.$email.'"> ';				
        echo '<div class="form-group has-feedback"><label>New Password</label>';
                $data = array(
          'name'        => 'txtNewPassword',
          'id'          => 'txtNewPassword',
          'class'   => 'form-control',
		'type'  =>'password',
        );
        echo form_input($data);
        echo '<span class="fa fa-lock form-control-feedback text-muted"></span>';
        echo '</div>';       
    echo '<div class="form-group has-feedback"><label>Confirm New Password</label>';
                $data = array(
          'name'        => 'txtConfPassword',
          'id'          => 'txtConfPassword',
          'class'   => 'form-control',
		'type'  =>'password',
          'value'       => '',
        );
        echo form_input($data);
        echo '<span class="fa fa-lock form-control-feedback text-muted"></span>';
        echo '</div>';         
                 
     ?>            
              <button type="submit" class="btn btn-block btn-primary mt-lg">Submit</button>
           </form>
        </div>
     </div>
     <!-- END panel-->
     <div class="p-lg text-center">
        <span>&copy;</span>
        <span>2015</span>
        <span>-</span>
        <span>Car Wash</span>
        <br>
     </div>
  </div>
</div>
<!-- =============== VENDOR SCRIPTS ===============-->
<!-- MODERNIZR-->
<script src="<?php echo STATIC_ADMIN_JS?>modernizr.js"></script>
<!-- JQUERY-->
<script src="<?php echo STATIC_ADMIN_JS?>jquery.js"></script>
<!-- ===================== Toastr ========================= -->
<script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>
<!-- BOOTSTRAP-->
<script src="<?php echo STATIC_ADMIN_JS?>bootstrap.js"></script>
<!-- STORAGE API-->
<script src="<?php echo STATIC_ADMIN_JS?>jquery.storageapi.js"></script>
<!-- PARSLEY-->
<script src="<?php echo STATIC_ADMIN_JS?>parsley.min.js"></script>
<!-- =============== APP SCRIPTS ===============-->
<script src="<?php echo STATIC_ADMIN_JS?>app.js"></script>

<script type="text/javascript">
  
$(document).ready(function() {
	
	$(document).off("submit", "#reset_password").on("submit", "#reset_password", function(event){
		event.preventDefault();
		var check_validate_form = validate_form();
		if( check_validate_form == false){
			return;
		}

		$.ajax({
			type: 'POST',
			url: "<?= ADMIN_BASE_URL ?>login/submit_reset_password",
			data: {'new_password': $("#txtNewPassword").val(), 'email': $("#hdn_email").val()},
			async: false,
			success: function(res) {
				if(res == 0)
					toastr.error("Password could not be changed.");
				else
					toastr.success("Password changed successfully.");
			}
		});
	});
});

function validate_form(){
	var check = true;
	if( !$.trim($("#txtNewPassword").val()) || $.trim($("#txtNewPassword").val()) == ''){
		toastr.error('Please enter new password.');check = false;return check;
	}else if( !$.trim($("#txtConfPassword").val()) || $.trim($("#txtConfPassword").val()) == ''){
		toastr.error('Please enter confirm password.');check = false;return check;
	}else if( $("#txtNewPassword").val() != $("#txtConfPassword").val() ){
		toastr.error('New password and confirm password must be same.');check = false;return check;
	}
	return check;	
}
</script>

</body>
</html>