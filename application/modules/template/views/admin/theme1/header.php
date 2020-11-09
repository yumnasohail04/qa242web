<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>EQ SMART - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_FONT?>iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_FONT?>simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/datatables.responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/select2.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/glide.core.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/nouislider.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>main.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>custom.css" />  
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>sweetalert.css">  
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>chosen.min.css">
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css">
	<link href="http://valor-software.com/ngx-bootstrap/assets/css/glyphicons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>


    <script src="<?php echo STATIC_ADMIN_JS?>vendor/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>dropify.min.css">
    <script src="<?php echo STATIC_ADMIN_JS?>dropify.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>chosen.jquery.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>select-boxes.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>select-boxes.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>
</head>
<script>
function css_constant(){
     var css_constant= "<?php echo STATIC_ADMIN_CSS ?>";
return css_constant;
}
</script>
<style>
th {
    text-align: inherit!important;
    padding-left: 1%;
}
</style>
<?php $data = $this->session->userdata('user_data');?>
<!-- show-spinner -->
<body id="app-container" class="menu-default show-spinner" >
<nav class="navbar fixed-top">
        <div class="d-flex align-items-center navbar-left">
            <a href="#" class="menu-button d-none d-md-block">
                <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                    <rect x="0.48" y="0.5" width="7" height="1" />
                    <rect x="0.48" y="7.5" width="7" height="1" />
                    <rect x="0.48" y="15.5" width="7" height="1" />
                </svg>
                <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                    <rect x="1.56" y="0.5" width="16" height="1" />
                    <rect x="1.56" y="7.5" width="16" height="1" />
                    <rect x="1.56" y="15.5" width="16" height="1" />
                </svg>
            </a>
            <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                    <rect x="0.5" y="0.5" width="25" height="1" />
                    <rect x="0.5" y="7.5" width="25" height="1" />
                    <rect x="0.5" y="15.5" width="25" height="1" />
                </svg>
            </a>
        </div>
        <a class="navbar-logo" href="<?php echo ADMIN_BASE_URL.'dashboard' ?>">
            <span class="logo d-none d-xs-block"></span>
            <span class="logo-mobile d-block d-xs-none"></span>
        </a>
        <div class="navbar-right">
            <div class="header-icons d-inline-block align-middle">
                <div class="position-relative d-none d-sm-inline-block">
                    <button class="header-icon btn btn-empty" type="button" id="iconMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-grid"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right mt-3  position-absolute" id="iconMenuDropdown">
                        <a href="<?php echo ADMIN_BASE_URL.'global_configuration'; ?>" class="icon-menu-item">
                            <i class="iconsminds-equalizer d-block"></i>
                            <span>Settings</span>
                        </a>
                        <a href="<?php echo ADMIN_BASE_URL.'users' ?>" class="icon-menu-item">
                            <i class="iconsminds-male-female d-block"></i>
                            <span>Users</span>
                        </a>
                        <a href="#" class="icon-menu-item">
                            <div class="d-none d-md-inline-block align-text-bottom mr-3">
                                <div class="custom-switch custom-switch-primary-inverse custom-switch-small pl-1" 
                                    data-toggle="tooltip" data-placement="left" title="Dark Mode">
                                    <input class="custom-switch-input" id="switchDark" type="checkbox" checked>
                                    <label class="custom-switch-btn" for="switchDark"></label>
                                </div>
                            </div>
                            <span>Dark Mode</span>
                        </a>
                        <a href=""  class="icon-menu-item view_chat">
                            <i class="simple-icon-bubbles d-block"></i>
                            <span>Chat</span>
                        </a>
                    </div>
                </div>

                <div class="position-relative d-inline-block">
                    <button class="header-icon btn btn-empty" type="button" id="notificationButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-bell"></i>
                        <?php if(isset($total_notification) && !empty($total_notification)) { ?>
                        <span class="count"><?=$total_notification?></span>
                        <?php } ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right mt-3 position-absolute" id="notificationDropdown" onclick="myFunction()">
                        <div class="scroll">
                            <?php if(isset($notification) && !empty($notification)) {
                            foreach ($notification as $key => $noti):
                            ?>
                            <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                <div class="pl-3">
                                    <a href="#">
                                        <p class="font-weight-medium mb-1"><?=$noti['notification_message']?></p>
                                        <!-- <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p> -->
                                    </a>
                                </div>
                                <div class="close_btn">
                                  <div class="close_div dropbtn">
                                  <span class="cross_set dropbtn" notiattr= "<?=$noti['notification_id']?>">x</span>
                                  </div>
                                </div>
                            </div>
                            <?php endforeach; } ?>
                        </div>
                    </div>
                </div>

                <button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
                    <i class="simple-icon-size-fullscreen"></i>
                    <i class="simple-icon-size-actual"></i>
                </button>

            </div>
            <?php $data = $this->session->userdata('user_data');?>
            <div class="user d-inline-block">
                <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="name"><?php echo $data['name']; ?></span>
                    <span>
                        <img alt="Profile Picture" src="<?php   if(empty($data['user_image']) || !file_exists(ACTUAL_OUTLET_USER_IMAGE_PATH.$data['user_image']) ){
                          echo STATIC_ADMIN_IMAGE.'no_item_image_small.jpg'; } else { echo BASE_URL.ACTUAL_OUTLET_USER_IMAGE_PATH.$data['user_image']; } ?>" />
                    </span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-3">
                    <!-- <a class="dropdown-item" href="#">Account</a>
                    <a class="dropdown-item" href="#">Features</a>
                    <a class="dropdown-item" href="#">History</a> -->
                    <a class="dropdown-item change_password" rel="<?=$data['user_id']?>" href="#">Change Password</a>
                    <a class="dropdown-item" href="<?php echo ADMIN_BASE_URL?>login/logout">Sign out</a>
                </div>
            </div>
        </div>
    </nav>



<?php
$message = $this->session->flashdata('message');$status = $this->session->flashdata('status');
if (isset($message) && !empty($message) && $status == 'success') {?><script>$(document).ready(function() {toastr.success("<?php echo $message?>")});</script><?php }
if (isset($message) && !empty($message) && $status == 'error') {?><script>$(document).ready(function() {toastr.error("<?php echo $message?>")});</script><?php }
?>

<script>
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
<script>
    function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
    }
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
            var number = parseInt($('.badge_noti').text(),10);
            $('.badge_noti').text(number-1);
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