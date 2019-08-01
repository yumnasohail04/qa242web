<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">        <title>Login</title>     	<link href="/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">     
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>static/admin/theme1/assets/css/login.css" />
        <script src="<?php echo base_url();?>static/admin/theme1/assets/plugins/jquery-1.10.2.min.js"></script>
		  <script src="<?php echo base_url();?>static/admin/theme1/assets/scripts/jquery_ui.js"></script>
		<script type="text/javascript">
		jQuery(document).ready(function() {
		<?php if(validation_errors()):?>
			jQuery("#login_inner").effect( "shake");
		 <?php endif; ?>
	
	   });
	</script>
    </head>
	<body>
    <div id="content">

