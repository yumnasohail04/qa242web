<html>
    <head>
        <meta charset="utf-8"/>
        <title> Pizza Milni | Admin Panel </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>static/admin/theme1/images/favicon.ico" />
        <meta name="MobileOptimized" content="320">
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/select2/select2_metro.css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/data-tables/DT_bootstrap.css"/>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
        
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-toastr/toastr.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/css/themes/<?php echo DEFAULT_THEME;?>.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url(); ?>static/admin/theme1/assets/css/popup.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
         <?php if(isset($lang_code) && $lang_code != ''):?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	    <script type="text/javascript" src="https://www.google.com/jsapi=INSERT-YOUR-KEY"></script>
		<script type="text/javascript">
         // Load the Google Onscreen Keyboard API
          google.load("elements", "1", {
              packages: "keyboard"
          });
          <?php if($lang_code == 'gb'):?>
          function onLoad() {
               var kbd = new google.elements.keyboard.Keyboard(
              [google.elements.keyboard.LayoutCode.ENGLISH]);
          }
          <?php 
            endif; 
          if($lang_code == 'no'):?>
          function onLoad() {
               var kbd = new google.elements.keyboard.Keyboard(
              [google.elements.keyboard.LayoutCode.NORWEGIAN]);
          }
          <?php endif; ?>
          
          google.setOnLoadCallback(onLoad);
          </script>
          <?php endif;?>
    </head>


    <body class="page-header-fixed">
        <!-- BEGIN HEADER -->
        <div class="header navbar navbar-inverse navbar-fixed-top">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="header-inner">
            <!-- BEGIN LOGO -->
                <a class="navbar-brand" href="<?php echo ADMIN_BASE_URL?>dashboard">
                    <img src="<?php echo base_url().'uploads/general_setting/small_images/'.DEFAULT_LOGO?>" alt="logo" class="img-responsive" id="site_logo"/>
                </a>
                
               
                
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<img src="<?php echo base_url(); ?>static/admin/theme1/assets/img/sidebar-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <!--<div class="sidebar-toggler hidden-phone">
                    </div>-->
                    
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
<!--                    <form class="sidebar-search" action="extra_search.html" method="POST">
                        <div class="form-container">
                            <div class="input-box">
                                <a href="javascript:;" class="remove"></a>
                                <input type="text" placeholder="Search..."/>
                                <input type="button" class="submit" value=" "/>
                            </div>
                        </div>
                    </form>-->
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <img src="<?php echo base_url(); ?>static/admin/theme1/assets/img/menu-toggler.png" alt=""/>
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                   
                <!-- BEGIN TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav pull-right">
                    
                    <li class="dropdown" id="header_task_bar">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                          <span class="username">
                          <?php 
						  		$user_data = $this->session->userdata('user_data');
								echo ucwords($user_data['user_name']);
						  ?>
                        </span>
                        <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?=ADMIN_BASE_URL.'logout'?>"><i class="fa fa-key"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- END TODO DROPDOWN -->
                </ul>
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- END HEADER -->
        <div class="clearfix">
        </div>
        <!-- BEGIN CONTAINER -->
