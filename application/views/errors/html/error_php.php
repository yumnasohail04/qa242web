<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file'] ?><br />
			Line: <?php echo $error['line'] ?><br />
			Function: <?php echo $error['function'] ?>
			</p>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>
<!-- 

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Page not found!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>main.css" />
	<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>custom.css" />
</head>
<script>
function css_constant(){
     var css_constant= "<?php echo STATIC_ADMIN_CSS ?>";
return css_constant;
}
</script>
<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-sm-8 col-md-10 mx-auto my-auto">
                    <div class="card index-card">
                    
                 <img src="<?php echo STATIC_ADMIN_IMAGE.'Domestic-Robot-PNG-Clipart.png'; ?>" style="position:absolute;width: 56%;left: -47%;">
                        <div class="card-body text-center form-side">
                            <a href="Dashboard.Default.html">
                                <span class="logo-single"></span>
                            </a>
                            <p class="lead mb-5">Ooops!</p>
                            <div id="timer" class="mb-5"></div>
                            <div class="row">
                                <div class="col-12 offset-0 col-md-8 offset-md-2 mb-2">
                                    <p>Can't access this page</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="<?php echo STATIC_ADMIN_JS?>vendor/jquery-3.3.1.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>bootstrap.bundle.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>countdown.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>dore.script.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>scripts.js"></script>
</body>

</html> -->