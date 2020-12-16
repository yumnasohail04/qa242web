<style>
td a img,
td img
{
    width:40px;
    height:40px;
}
</style>
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
                       <legend> Supplier</legend>
                            <div class="form-body">
                                     <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Name:
                                              </th>
                                              <td>
                                                  <?php echo $post['name']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Email:
                                              </th>
                                              <td>
                                                  <?php echo $post['email']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Phone #:
                                              </th>
                                              <td>
                                                  <?php echo $post['phone_no']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                Address:
                                              </th>
                                              <td>
                                                  <?php echo $post['address']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  City:
                                              </th>
                                              <td>
                                                  <?php echo $post['city']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Country:
                                              </th>
                                              <td>
                                                  <?php echo $post['country']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  State:
                                              </th>
                                              <td>
                                                  <?php echo $post['state']; ?>
                                              </td>
                                          </tr>
                                      </tbody>
                                    </table>
                                </div>
                                <legend> Basic Documents </legend>
                                <table class="table table-user-information table-bordered">
                                    <tr>
                                    <th>Document Name</th>
                                    <th>Expiry Date</th>
                                    <th>Uploaded File</th>
                                    <tr>
                                    <tbody>
                                    <?php 
                                    $level="";
                                    foreach($doc as $keys => $values){ ?>
                                    
                                    <tr>
                                    <td><?php echo $values['doc_name']; ?></td>
                                    <td>
                                        <?php echo $values['expiry_date']; ?>
                                    </td>
                                    <td>
                                    <?php if(!empty($values['document'])){ ?>
                                        <a href="<?php echo BASE_URL.SUPPLIER_DOCUMENTS_PATH.$values['document'];?>" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a>
                                    <?php }else{ ?>
                                        <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>">
                                    <?php } ?>
                                    </td>
                                    </tr>
                                    <?php
                                    } ?>
                                    </tbody>
                                </table>
                    				<legend> Ingredients List </legend>
                           			 <div class="form-body">   
                                    <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6C9CDE !important">NAV Number</th>
                                        <th style="color: #6C9CDE !important">RM PLM Number Name</th>
                                        <th style="color: #6C9CDE !important">Raw Material Name</th>
                                      	<th style="color: #6C9CDE !important">Supplier Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($ingredients) && !empty($ingredients)){
                                        foreach($ingredients as $value){?>
                                      <tr>
                                        <td><?php echo $value['item_no']; ?></td>
                                        <td> <?php echo $value['plm_no']; ?></td>
                                        <td> <?php echo $value['item_name']; ?></td>
                                      	<td> <?php echo $value['role']; ?></td>
                                      </tr>
                                      <?}}else{ ?>
                                    	 <tr>
                                        <td></td>
                                        <td>No Result Found</td>
                                        <td> </td>
                                      	<td> </td>
                                      </tr>
                                     <?php } ?>
                                    </tbody>
                                  </table>
                            	</div>
                               <legend>Other Documents</legend>
                                    <div class="form-body"> 
                                        <table class="table table-user-information table-bordered">
                                        <tr>
                                        <th>Document Name</th>
                                        <th>Document Type</th>
                                        <th>Location</th>
                                        <th>Uploaded File</th>
                                        <tr>
                                        <tbody>
                                            <?php
                                            $ing_name=$location="";
                                            if(!empty($ingredients_doc)){?>
                                                <?php foreach($ingredients_doc as $key => $value){
                                                if($ing_name!=$value['ing_name']){?>
                                                    <tr><td style="background-color: #2fc0d1;"><h3><?php echo $value['ing_name']; ?></h3></td></tr>
                                                    <?php } ?>
                                                    <tr>
                                                    <td><?php echo $value['doc_name']; ?></td>
                                                    <td><?php echo $value['doc_type']; ?></td>
                                                    <td><?php  if(isset($value['location'])) echo $value['location']; else echo "____"; ?></td>
                                                    <input type="hidden" name="ingredient_<?php echo $key; ?>" value="<?php echo $value['ing_id']; ?>">
                                                    <input type="hidden" name="doc_<?php echo $key; ?>" value="<?php echo $value['doc_id']; ?>">
                                                    <?php  if(isset($value['loc_id'])){?>
                                                    <input type="hidden" name="loc_<?php echo $key; ?>" value="<?php echo $value['loc_id']; ?>">
                                                    <?php } ?>
                                                    <td>
                                                    <?php if(!empty($value['document'])){ ?>
                                                        <a href="<?php echo BASE_URL.INGREDIENT_DOCUMENTS_PATH.$value['document'];?>" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a>
                                                    <?php }else{ ?>
                                                        <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>">
                                                        
                                                    <?php } ?>
                                                    </td>
                                                    </tr>
                                            <?php
                                                $ing_name=$value['ing_name'];
                                                }
                                            } ?>
                                            <input type="hidden" name="total" value="<?php echo $key; ?>">
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


