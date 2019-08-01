<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="Bootstrap Admin App + jQuery">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <title>QA - Admin</title>
    <link rel="icon" href="<?php echo STATIC_FRONT_IMAGE?>16X16.ico" type="image/x-icon">

    <!-- JQUERY-->
   <script src="<?php echo STATIC_ADMIN_JS?>jquery.js"></script>   

   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>font-awesome.min.css">

   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>simple-line-icons.css">

   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>animate.min.css">

     <!-- ============== Toastr ====================== -->
       <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css">

   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>whirl.css">
   <!-- SWEET ALERT-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>sweetalert.css">

   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap.css" id="bscss">

   <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>app.css"    id="maincss">
   
    <!-- DATETIMEPICKER-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap-datetimepicker.min.css">

	<!-- DATETIMEPICKER-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bs-filestyle.css">   
     <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>dropify.min.css">

  <!-- DATETIMEPICKER-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap-fileupload.css">

   <!-- chosen multi select -->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>chosen.min.css">
  <style type="text/css">
 
#myInput {
    border-box: box-sizing;
    background-image: url('searchicon.png');
    background-position: 14px 12px;
    background-repeat: no-repeat;
    font-size: 16px;
    padding: 14px 20px 12px 45px;
    border: none;
    border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f6f6f6;
    min-width: 230px;
    overflow: auto;
    border: 1px solid #ddd;
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {background-color: #ddd}

.show {display:block;}
.scrollable-menu{
      height: auto;
    max-height: 400px;
    overflow-x: hidden;
}
  </style>
</head>
<body>
<div class="wrapper">
      <!-- top navbar-->
      <header class="topnavbar-wrapper">
         <!-- START Top Navbar-->
         <nav role="navigation" class="navbar topnavbar">
            <!-- START navbar header-->
             <?php $displaymod='';   foreach($outlets['all_outlet_id'] as $logo_row) {
			    
				if ($logo_row['id']==DEFAULT_OUTLET)
				$displaymod='';
				else
				$displaymod='style="display:none"';
			   ?>
            <div class="navbar-header" id="logo_<?php echo $logo_row['id']?>" <?php echo $displaymod;?>>
               <a href="#/" class="navbar-brand">
                  <div class="brand-logo">
                    <span style="color:white; padding-top:17px!important;"> QA Project </span>
                  </div>
                  <div class="brand-logo-collapsed">
                       <span style="color:white; padding-top:17px!important;"> QA Project</span>
                  </div>
               </a>
            </div>
              <?php } ?>
            <!-- END navbar header-->

            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li>
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a href="#" data-toggle-state="aside-collapsed" class="hidden-xs">
                        <em class="fa fa-navicon"></em>
                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
               </ul>

				<?php 
				$user_data = $this->session->userdata('user_data');
				if(isset($outlets['outlets']) && $outlets['outlets'] != NULL && $user_data['role'] == 'portal admin'):
					$total_outlets = count($outlets['outlets']);
				?>
                <ul class="nav navbar-nav" id="outlet_dd">
                    <li class="dropdown dropdown_custom">
                    <?php 
                    foreach($outlets['outlets'] as $row):
					if($row['id'] == DEFAULT_OUTLET){
                    ?>
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle dropdown-toggle-custom"><?php echo $row['name'];?> <b class="caret caret_custom"></b></a>
                    <?  
                    }
                    endforeach;
                    ?>
                    <ul class="dropdown-menu scrollable-menu"  id="myDropdown">
                    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()"><i class="fa fa-search" aria-hidden="true" style="position: relative;float:right;top: -30px;right: 20px;
"></i>
                    <? $count_outlet = 1;foreach($outlets['outlets'] as $row ):
                    if($row['id'] != DEFAULT_OUTLET) {
                    ?>
                    <li><a href="javascript:;" rel="<?=$row['id']?>"><?=$row['name']?></a></li>
                    <?php if(($count_outlet - 2) != ($total_outlets - 2)){echo '<li role="separator" class="divider"></li>';}?>
                    <? 
                    }
                    $count_outlet++;endforeach; ?>
                    </ul>
                    </li>
                </ul>
                <?php endif;?>

               <?php $data = $this->session->userdata('user_data');?>
               <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                         <span class="username"><img src="<?php   if(empty($data['user_image'])){
                 echo STATIC_ADMIN_IMAGE.'no_item_image_small.jpg'; } else { echo BASE_URL.ACTUAL_OUTLET_USER_IMAGE_PATH.$data['user_image']; } ?>" style="width: 40px;border-radius: 23px;"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="change_password" rel="<?=$data['user_id']?>" href="#"><i class="fa fa-key"></i> Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=ADMIN_BASE_URL.'logout'?>"><i class="fa fa-key"></i> Log Out</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle-fullscreen=""><em class="fa fa-expand"></em> Full Screen</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo ADMIN_BASE_URL?>login/logout" title="Lock screen"><em class="icon-lock"></em> Lock Screen</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle-state="offsidebar-open" data-no-persist="true"><em class="icon-notebook"></em> Right Panel</a></li>
                        </ul>
                    </li>
               </ul>
               <!-- END Right Navbar-->
            </div>
            <!-- END Nav wrapper-->
		
         </nav>
         <!-- END Top Navbar-->
      </header>
      
<?php
$message = $this->session->flashdata('message');$status = $this->session->flashdata('status');
if (isset($message) && !empty($message) && $status == 'success') {?><script>$(document).ready(function() {toastr.success("<?php echo $message?>")});</script><?php }
if (isset($message) && !empty($message) && $status == 'error') {?><script>$(document).ready(function() {toastr.error("<?php echo $message?>")});</script><?php }
?>

<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    a = div.getElementsByTagName("li");
    for (i = 0; i < a.length; i++) {
        if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}
</script>