<?php // print_r($cat_details['cat_name']); exit(); ?>

<h4 ><b>Title:&nbsp;&nbsp;</b></h4><?php echo $cat_details['cat_name']; ?>

<div class="page-content-wrapper">
<?php // print_r($cat_details['cat_name']);exit; ?>
        <!-- END PAGE HEADER-->
       
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">

                       
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                            <div class="form-body">                               

                                    <h4 class="form-section">Url Slug</h4>
                           
                                    <div class="row">
                                        <div class="col-sm-12">
                                                <?php echo ($cat_details['url_slug']); ?>
                                            </span>
                                        </div>
                                    </div>

                                <h4 class="form-section">Meta Description</h4>
                           
                                <div class="row">
                                    <div class="col-sm-8">
                                            <?php if(isset($cat_details['meta_description']) && $cat_details['meta_description'])
                                                echo $cat_details['meta_description'];
                                            else
                                                echo "Nill";
                                            ?>
                                    </div>
                                    <div class="col-sm-4">
                                    <h4 class="form-section">Image</h4>
                                           
                                            <?php
                                            $item_img = base_url() . "static/admin/theme1/image/no_item_image_small.jpg";
                                            if (!empty($cat_details['image']) && file_exists(FCPATH . SMALL_CATAGORIES_IMAGE_PATH . $cat_details['image']))

                                                $item_img = IMAGE_BASE_URL . 'catagories/small_images/' . $cat_details['image'];
                                            else 
                                            {
                                               $cat_details['image'] =    'no_photo.jpg';
                                                $item_img = IMAGE_BASE_URL . 'catagories/small_images/' . $cat_details['image'];
                                            }
                                            ?>
                                            <img src="<?= $item_img ?>" width="150px;"/>
                                          
                                    </div>
                                </div>


                                  <h4 class="form-section">Description</h4>
                                    <!--/span-->
                                    <div class="row" >
                                            <div class="col-md-12" >
                                                    <?php if(isset($cat_details['cat_desc']) && $cat_details['cat_desc'])
                                                        echo $cat_details['cat_desc'];
                                                    else
                                                        echo "Nill";
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


