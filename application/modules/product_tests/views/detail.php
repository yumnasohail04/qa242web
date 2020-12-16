

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
                            <div class="form-body">                               

                           
                                  <h2>Attributes List</h2>        
                                  <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: black !important">Attribute Name</th>
                                        <th style="color: black !important">Type</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($product_attribute) && !empty($product_attribute)){
                                        foreach($product_attribute as $value){?>
                                      <tr>
                                        <td><?php echo $value['attribute_name']; ?></td>
                                        <td> <?php echo $value['attribute_type']; ?></td>
                                      </tr>
                                      <?}}?>
                                     
                                    </tbody>
                                  </table>
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


