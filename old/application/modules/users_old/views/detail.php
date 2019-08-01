
<div class="page-content-wrapper">
<?php // print_r($news['title']);exit; ?>
        <!-- END PAGE HEADER-->
       
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                            <div class="form-body">                               
                            
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mrg-b-5">
                                            <label class="control-label col-md-4"><b>User Name:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                    <?php echo $users_res['user_name']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                   
                                 </div>

                                <!--/row-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Address1:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                   <?php echo $users_res['email']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Full Name:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                   <?php echo $users_res['first_name']." ".$users_res['last_name']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Phone no:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                   <?php echo $users_res['phone']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Office Phone:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                   <?php echo $users_res['office_phone']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/span-->
                                    
                                    <!--/span-->
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Gender:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                   <?php echo $users_res['gender']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">   
                                        <h4 class="form-section">Driver Picture </h4>  
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <?php  $image="";
                                            if(isset($users_res['user_image']) && !empty($users_res['user_image']))
                                                $image = ACTUAL_OUTLET_USER_IMAGE_PATH.$users_res['user_image'];
                                            $filename =  $image;
                                            if (file_exists($filename)) {
                                            ?>
                                            <img style="width: 200px; height: 145px;" src = "<?php echo BASE_URL . $image; ?>" />
                                            <?php
                                        } else {
                                            ?>
                                            <img style="width: 200px; height: 145px;" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                            <?php
                                        }
                                        ?>
                                        </div> 
                                                                   
                                               
                                        </div>
                                </div>
                            </div>
                        
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!--    </div>-->
</div>
</div>
