

<div class="page-content-wrapper">
<?php // print_r($post['title']);exit; ?>
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
                       <legend> <?php echo $post['product_title']; ?></legend>
                            <div class="form-body">                               

                           
                                    <div class="row">
                                        
                                        <div class="col-sm-6">
                                            <h4 class="form-section">Product Title</h4>
                                                 <span><?php echo $post['product_title']; ?>
                                            </span>
                                        </div>
                                        
                                         <div class="col-sm-6">
                                            <h4 class="form-section">Navision Number</h4>
                                                 <span><?php echo $post['navision_no']; ?>
                                            </span>
                                        </div>
                                        
                                         <div class="col-sm-6">
                                             <h4 class="form-section">Brand Name</h4>
                                               <span>  <?php echo $post['brand_name']; ?>
                                            </span>
                                        </div>
                                         
                                         <div class="col-sm-6">
                                             <h4 class="form-section">Package Type</h4>
                                                <span> <?php echo $post['packaging_type']; ?>
                                            </span>
                                        </div>
                                         
                                         <div class="col-sm-6">
                                            <h4 class="form-section">Unit Weight</h4>
                                              <span> <?php echo $post['unit_weight']; ?>
                                            </span>
                                        </div>
                                      
                                         <div class="col-sm-6">
                                              <h4 class="form-section">Shape</h4>
                                                <span> <?php echo $post['shape']; ?>
                                            </span>
                                        </div>
                                        
                                         <div class="col-sm-6">
                                            <h4 class="form-section">Channel</h4>
                                                 <span><?php echo $post['channel']; ?>
                                            </span>
                                        </div>
                                      
                                         <div class="col-sm-6">
                                            <h4 class="form-section">Shelf life</h4>
                                                <span> <?php echo $post['shelf_life']; ?>
                                            </span>
                                        </div>
                                    </div>

                                
                           

                                </div>
                           
                             <!-- BEGIN FORM-->
                       <legend> <?php echo $post['product_title']; ?> Attributes List</legend>
                            <div class="form-body">                               

                           
                                    <div class="row">
                                        <?php if(isset($product_attribute) && !empty($product_attribute)){
                                        foreach($product_attribute as $value){?>
                                        <div class="col-sm-3">
                                            <h4 class="form-section">Attribute</h4>
                                                 <span><?php echo $value['attribute_name']; ?>
                                            </span>
                                        </div>
                                         <div class="col-sm-3">
                                            <h4 class="form-section">Min</h4>
                                                <?php echo $value['min_value']; ?>
                                            </span>
                                        </div>
                                         <div class="col-sm-3">
                                            <h4 class="form-section">Target</h4>
                                               <span>  <?php echo $value['target_value']; ?>
                                            </span>
                                        </div>
                                         <div class="col-sm-3">
                                            <h4 class="form-section">Max</h4>
                                                <span> <?php echo $value['max_value']; ?>
                                            </span>
                                        </div>
                                        <hr>
                                        <?} };?>
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


