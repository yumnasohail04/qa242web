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

                           
                                     <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Product Title:
                                              </th>
                                              <td>
                                                  <?php echo $post['product_title']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Navision Number:
                                              </th>
                                              <td>
                                                  <?php echo $post['navision_no']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Brand Name:
                                              </th>
                                              <td>
                                                  <?php echo $post['brand_name']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Package Type:
                                              </th>
                                              <td>
                                                  <?php echo $post['packaging_type']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Unit Weight:
                                              </th>
                                              <td>
                                                  <?php echo $post['unit_weight']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Shape:
                                              </th>
                                              <td>
                                                  <?php echo $post['shape']; ?>
                                              </td>
                                          </tr>
            							  <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Program Type:
                                              </th>
                                              <td>
                                                <?php $get_ppt = Modules::run('api/_get_specific_table_with_pagination',array('ppt_product_id'=>$update_id), 'ppt_id desc',DEFAULT_OUTLET.'_product_program_type','ppt_program_id','1','0')->result_array();
                                                	$counter = 1;
                                                	if(!empty($get_ppt)) {
                                                    	foreach ($get_ppt as $key => $gppt):
                                                        	if(!empty($gppt['ppt_program_id'])) {
                                                            	$key = array_search($gppt['ppt_program_id'], array_column($program_type, 'program_id'));
                                                            	if (is_numeric($key)) {
                                                                	if($counter >1)
                                                                    	echo ",";
                                                                	echo $program_type[$key]['program_name'];
                                                                	$counter++;
                                                            	}
                                                        	}
                                                    	endforeach;
                                                	}
                                            	?>
                                              </td>
                                          </tr>
            							  <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Storage Type:
                                              </th>
                                              <td>
                                                  <?php echo $post['storage_type']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Channel:
                                              </th>
                                              <td>
                                                  <span><?php echo $post['channel']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Shelf life:
                                              </th>
                                              <td>
                                                  <?php echo $post['shelf_life']; ?>
                                              </td>
                                          </tr>
                                      </tbody>
        </table>

                                
                           

                                </div>
                           
                             <!-- BEGIN FORM-->
                       <legend> <?php echo $post['product_title']; ?> Attributes List</legend>
                            <div class="form-body">                               

                           
                                        <table class="table table-bordered" >
                                    <thead>
                                      <tr>
                                        <th  style="color: #6C9CDE !important">Attribute</th>
                                        <th style="color: #6C9CDE !important">Min</th>
                                        <th style="color: #6C9CDE !important">Target</th>
                                        <th style="color: #6C9CDE !important">Max</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($product_attribute) && !empty($product_attribute)){
                                        foreach($product_attribute as $value){?>
                                      <tr>
                                        <td><?php echo $value['attribute_name']; ?></td>
                                        <td> <?php echo $value['min_value']; ?></td>
                                        <td> <?php echo $value['target_value']; ?></td>
                                         <td><?php echo $value['max_value']; ?></td>
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


