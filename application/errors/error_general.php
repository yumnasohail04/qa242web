<!-- <!DOCTYPE html>
<html lang="en">
<head>
<title>Error</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html> -->







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Page not found!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>main.css" />
	<link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>custom.css" />
</head>

<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-sm-8 col-md-10 mx-auto my-auto">
                    <div class="card index-card">
                        <div class="card-body text-center form-side">
                            <a href="Dashboard.Default.html">
                                <span class="logo-single"></span>
                            </a>
                            <p class="lead mb-5">Dore will be available soon!</p>
                            <div id="timer" class="mb-5"></div>
                            <div class="row">
                                <div class="col-12 offset-0 col-md-8 offset-md-2 mb-2">
                                    <p>To receive our newsletter please complete the form below. We take your
                                        privacy seriously and we will not share your information with others.</p>
                                </div>
                                <div class="col-12 offset-0 col-md-8 offset-md-2 col-lg-6 offset-lg-3 newsletter-input-container">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="E-mail address">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary btn-xl" type="button">JOIN</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="<?php echo STATIC_ADMIN_JS?>jquery-3.3.1.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>bootstrap.bundle.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>countdown.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>dore.script.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>scripts.js"></script>
</body>

</html>

