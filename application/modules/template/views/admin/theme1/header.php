<!-- Header   -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="DS Car Wash">
   <meta name="keywords" content="">
   <title>QA Project- Admin</title>
    <link rel="icon" href="<?php echo STATIC_FRONT_IMAGE?>16X16.ico" type="image/x-icon">
   
   <!-- JQUERY-->
   <script src="<?php echo STATIC_ADMIN_JS?>jquery.js"></script>
   <!-- =============== APP SCRIPTS ===============-->


    <!-- =============== Custom CSS ===============-->
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>custom.css">

  <!-- ============== Toastr ====================== -->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css"> 

   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>font-awesome.min.css">

   <!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>simple-line-icons.css">
    
   <!-- ANIMATE.CSS-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>animate.min.css">

   <!-- WHIRL (spinners)-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>whirl.css">

   <!-- SWEET ALERT-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>sweetalert.css">
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bs-filestyle.css">
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>dropify.min.css">
   <!-- DATATABLES-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>dataTables.colVis.css">
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>dataTables.bootstrap.css">

   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap.css" id="bscss">

   <!-- =============== APP STYLES ===============-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>app.css"    id="maincss">
  
   <!-- =============== DATETIME PICKER STYLES ===============-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap-datetimepicker.min.css" id="maincss">
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>chosen.min.css">
    <!-- FULLCALENDAR  addedd by wasim 29-02-2016-->
   <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>fullcalendar.css">
   <script src="<?php echo STATIC_ADMIN_JS?>chosen.jquery.min.js"></script>
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
         <nav role="navigation" class="navbar topnavbar" style="margin-top:15px;">
            <!-- START navbar header-->
           <?php $displaymod='';   foreach($outlets['all_outlet_id'] as $logo_row) {
			    
				if ($logo_row['id']==DEFAULT_OUTLET)
				$displaymod='';
				else
				$displaymod='style="display:none"';
			   ?>
           
            <div class="navbar-header" id="logo_<?php echo $logo_row['id']?>" <?php echo $displaymod;?>>
               <a href="<?php echo ADMIN_BASE_URL.'dashboard'; ?>" class="navbar-brand">
                  <div class="brand-logo">
                    <img src="<?php echo STATIC_ADMIN_IMAGE.'logoqa.png' ?>" style="width:30%;">
                  </div>
                  <div class="brand-logo-collapsed">
                     <img src="<?php echo STATIC_ADMIN_IMAGE.'logoqa.png' ?>" style="width:50%;">
                  </div>
               </a>
            </div>
           <?php } ?>
           
            <!-- END navbar header-->

            <!-- START Nav wrapper-->
            <div class="nav-wrapper">
               <!-- START Left navbar-->
               <ul class="nav navbar-nav">
                  <li class="asider-collapse custome-toggle">
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a  href="#" data-toggle-state="aside-collapsed" class="hidden-xs font-collapse">
                        <i class="fa fa-tasks "></i>                     </a>
                     <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                     <a href="#" data-toggle-state="aside-toggled" data-no-persist="true" class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                     </a>
                  </li>
                    <!--_________________________notification code________________________________!-->
                   <?php if(isset($total_notification) && !empty($total_notification)) { ?>
                    <span class="badge"><?=$total_notification?></span>
                    <?php } ?>
                   <li class="header-icons dropdown ">
                     <i class="dropbtn" data-feather="bell" style="margin-top: 75%;color: black;" onclick="myFunction()"></i>
                     <div id="myDropdown" class="dropdown-content" style="    width: 500px;">
                     <div class="notify_head">
                       <p class="p_notify">Notification</p>
                       <span class="mark_view dropbtn">Mark all as read</span>
                     </div>
                     <?php if(isset($notification) && !empty($notification)) {
                      foreach ($notification as $key => $noti):
                      ?>
                     <div class="position_set">
                      <a href="javascript:void(0);">
                        <div class="li-set">
                          <p class="text-style"><?=$noti['notification_message']?></p>
                        </div>
                        <div class="close_btn">
                          <div class="close_div dropbtn">
                          <span class="cross_set dropbtn" notiattr= "<?=$noti['notification_id']?>">x</span>
                          </div>
                        </div>
                      </a>
                      </div>
                      <?php endforeach; } ?>
                      </div>
                  </li>
                  <!--_________________notification code end__ also add the sript(go down)___________!-->
                  <li class="header-icons">
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a  href="<?=ADMIN_BASE_URL.'chat'; ?>"  class="hidden-xs  header-icon-font">
                     <i data-feather="message-square"></i>
                     </a>
                  </li>
                    <li class="header-icons">
                     <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                     <a  href="<?=ADMIN_BASE_URL.'global_configuration'?>"  class="hidden-xs  header-icon-font">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                  
                     </a>
                  </li>
               </ul>

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
<!--_________________________notification code________________________________!-->
<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}
/*$('li.myDropdown').on('click', function (event) {
    document.getElementById("myDropdown").classList.toggle("show");
});*/

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }

    }
  }
}
  $(document).off('click', '.cross_set').on('click', '.cross_set', function(e){
       e.preventDefault();
      $this = $(this);
      var id  =$this .attr('notiattr'); 
      $.ajax({
        type: 'POST',
        url: "<?= ADMIN_BASE_URL ?>dashboard/change_notification_status",
        data: {'id': id},
        async: false,
        success: function(result) {
          $this.parent().parent().parent().parent().remove();
          var number = parseInt($('.badge').text(), 10);
          $('.badge').text(number-1);
        }
      });
    });
    $(document).off('click', '.mark_view').on('click', '.mark_view', function(e){
       e.preventDefault();
      $this = $(this);
      var id  =$this .attr('notiattr'); 
      $.ajax({
        type: 'POST',
        url: "<?= ADMIN_BASE_URL ?>dashboard/change_all_notification_status",
        data: {},
        async: false,
        success: function(result) {
          location.reload();
        }
      });
    });
</script>
<!--_________________notification code end_____________!-->