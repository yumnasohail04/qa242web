<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | EQSMART</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_FONT ?>iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_FONT ?>simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS ?>vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS ?>vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS ?>vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS ?>main.css" />    
    <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS ?>custom.css" />
    <script src="<?php echo STATIC_ADMIN_JS ?>vendor/jquery-3.3.1.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS ?>vendor/bootstrap.bundle.min.js"></script>
    <!-- <script>
          var css_path;
          $(document).ready(function(){
            css_path="<?php echo STATIC_ADMIN_CSS ?>";
            alert(css_path)
          });
    </script> -->
</head>
<style>
.text-white {
    font-weight: 800;
}
.white {
    font-weight: 700;
}
</style>
<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side " style="background-color: #001729;background-image: none;">
                            <p class=" text-white h2">LOGIN</p>
                            <p class="white mb-0">
                                Please use your credentials to login.
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="Dashboard.Default.html">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4"></h6>
                            <?php
                            $attributes = array('autocomplete' => 'off', 'id' => 'login');
                            echo form_open(ADMIN_BASE_URL.'login/submit_login',$attributes);?>
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="text" name="txtUserName" />
                                    <span>Username</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" placeholder="" name="txtPassword" />
                                    <span>Password</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- <a href="#">Forget password?</a> -->
                                    <button class="btn btn-outline-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                                </div>
                                <?php echo form_close(); ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script>
function css_constant(){
     var css_constant= "<?php echo STATIC_ADMIN_CSS ?>";
return css_constant;
}
</script>
    <script src="<?php echo STATIC_ADMIN_JS ?>dore.script.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS ?>scripts.js"></script>
</body>

</html>