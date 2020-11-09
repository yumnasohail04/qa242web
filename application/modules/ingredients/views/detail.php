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
                       <legend> <?php echo $post['item_name']; ?></legend>
                            <div class="form-body">                               

                           
                                     <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th >
                                                 Raw Material Name
                                              </th>
                                              <td>
                                                   <?php echo $post['item_name']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th  >
                                                  NAV Number:
                                              </th>
                                              <td>
                                                  <?php echo $post['item_no']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th  >
                                                  RM PLM Number:
                                              </th>
                                              <td>
                                                  <?php echo $post['plm_no']; ?>
                                              </td>
                                          </tr>
                                           <tr class="bg-col">
                                              <th  >
                                                  Type:
                                              </th>
                                              <td>
                                                 
                                                  <?php
                                                  foreach($ingredient_type as $key => $value)
                                                  {
                                                  echo $value['name'].','; 
                                                  }?>
                                              </td>
                                          </tr>
                                      </tbody>
                                </table>
                        </div>
                        
                        <legend> <?php echo $post['item_name']; ?> Suppliers List</legend>
                            <div class="form-body">                               

                           
                                        <table class="table table-bordered"  >
                                    <thead>
                                      <tr>
                                        <th  style="color: #6C9CDE !important">Supplier</th>
                                        <th style="color: #6C9CDE !important">Role</th>
                                        <th style="color: #6C9CDE !important">Supplier Item Name</th>
                                        <th style="color: #6C9CDE !important">Supplier Item Number</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($supplier) && !empty($supplier)){
                                        foreach($supplier as $value){?>
                                      <tr>
                                        <td><?php echo $value['name']; ?></td>
                                        <td> <?php echo $value['role']; ?></td>
                                        <td> <?php echo $value['s_item_name']; ?></td>
                                         <td><?php echo $value['s_item_no']; ?></td>
                                      </tr>
                                      <?}}?>
                                     
                                    </tbody>
                                  </table>
                            </div>
                        
                        <legend> <?php echo $post['item_name']; ?> Documents List</legend>
                            <div class="form-body">    
                                <table class="table table-bordered"  >
                                    <thead>
                                      <tr>
                                        <th  style="color: #6C9CDE !important">Supplier</th>
                                        <th  style="color: #6C9CDE !important">Document Name</th>
                                        <th style="color: #6C9CDE !important">File</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($supplier) && !empty($supplier)){
                                        foreach($supplier as  $value){?>
                                        <?php   foreach($value['sub'] as  $values){ ?>
                                      <tr>
                                        <td><?php echo $value['name']; ?></td>
                                        <td><?php echo $values['doc_name']; ?></td>
                                        <td> <a href="<?php echo BASE_URL.INGREDIENT_DOCUMENTS_PATH.$values['document']; ?>" download><?php echo $values['document']; ?></a></td>
                                      </tr>
                                      <?}}
                                      }?>
                                     
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


