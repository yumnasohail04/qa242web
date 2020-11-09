<!-- <!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="">
<meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
<title>QA242 - Login</title>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>latest_js.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/2.3.0/knockout-min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap-datetimepicker.min.css" id="maincss">
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>chosen.min.css">
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>fullcalendar.css">
<script src="<?php echo STATIC_ADMIN_JS?>chosen.jquery.min.js"></script>

</head>
<body> -->



<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <title>EQ Smart - Supplier Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="EQ Smart - Supplier Profile" />
    <meta name="keywords" content="vcard, resposnive, retina, resume, jquery, css3, bootstrap, Sunshine, portfolio" />
    <meta name="author" content="lmtheme" />
    <link rel="shortcut icon" href="favicon.ico">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>bootstrap.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>normalize.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>transition-animations.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>owl.carousel.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>magnific-popup.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>animate.css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>main.css" type="text/css">
    <link rel="stylesheet" href="<?php echo STATIC_FRONT_CSS?>lmpixels-demo-panel.css" type="text/css">
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css" type="text/css">
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','<?php echo STATIC_FRONT_JS?>analytics.js','ga');

      ga('create', 'UA-92992662-1', 'auto');
      ga('send', 'pageview');

    </script>

    
    <script src="<?php echo STATIC_FRONT_JS?>jquery-2.1.3.min.js"></script>
    <script src="<?php echo STATIC_FRONT_JS?>bootstrap.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>moment/min/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
    <script src="<?php echo STATIC_FRONT_JS?>modernizr.custom.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>
    <script src='<?php echo STATIC_FRONT_JS?>api.js'></script>
  </head>

  <body>
    <!-- Loading animation -->
    <!-- <div class="preloader">
      <div class="preloader-animation">
        <div class="dot1"></div>
        <div class="dot2"></div>
      </div>
    </div> -->
    <!-- /Loading animation -->

    <div id="page" class="page">
      <!-- Header -->
      <header id="site_header" class="header mobile-menu-hide">
        <div class="my-photo">
          <img src="<?php echo STATIC_FRONT_IMAGE?>my_photo.png" alt="image">
          <div class="mask"></div>
        </div>

        <div class="site-title-block">
          <h1 class="site-title"><?php echo $detail['name'] ?></h1>
          <p class="site-description">Supplier Number</p>
        </div>

        <!-- Navigation & Social buttons -->
        <div class="site-nav">
          <!-- Main menu -->
          <ul id="nav" class="site-main-menu">
            <!-- About Me Subpage link -->
            <li>
              <a class="pt-trigger" href="#home" data-animation="58" data-goto="1">Home</a>
            </li>
            <!-- /About Me Subpage link -->
            <!-- About Me Subpage link -->
            <li>
              <a class="pt-trigger" href="#supplier_documents" data-animation="59" data-goto="2">Supplier Documents</a>
            </li>
            <!-- <li>
              <a class="pt-trigger" href="#ingredient" data-animation="59" data-goto="3">Add Ingredients</a>
            </li> -->
            <!-- /About Me Subpage link -->
            <li>
              <a class="pt-trigger" href="#ingredient_location" data-animation="59" data-goto="3">Ingredients Documents</a>
            </li>
            <li>
              <a class="pt-trigger" href="#profile_update" data-animation="59" data-goto="4">Update Profile</a>
            </li>
           
            <li>
              <a class="pt-trigger" href="#security" data-animation="59" data-goto="5">Security</a>
            </li>
            <li>
              <a  href="<?php echo BASE_URL.'logout/'.$detail['id'] ?>">logout</a>
            </li>
          </ul>
          <!-- /Main menu -->
        </div>
        <!-- Navigation & Social buttons -->
      </header>


<?php
  $message = $this->session->flashdata('message');
  $status = $this->session->flashdata('status');
  if (isset($message) && !empty($message) && $status == 'success') {?>
    <script>$(document).ready(function() {toastr.success("<?php echo $message?>")});</script>
  <?php }
  if (isset($message) && !empty($message) && $status == 'error') {?>
    <script>$(document).ready(function() {toastr.error("<?php echo $message?>")});</script>
  <?php }
?>