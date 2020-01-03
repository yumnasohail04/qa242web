<div class="page-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                            <div class="form-body">       
                                  <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th>
                                                  Questioner Team:
                                              </th>
                                              <td>
                                                <?php echo $post['sf_name']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Description:
                                              </th>
                                              <td>
                                                  <?php  echo $post['sf_desc']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Assigned to:
                                              </th>
                                              <td>
                                                  <?php echo $post['assigned']; ?>
                                              </td>
                                          </tr>
                                          
                                      </tbody>
                                </table>
                            </div>
                            <div class="form-body">        
                                        <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6C9CDE !important">Question </th>
                                        <th style="color: #6C9CDE !important">Description</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($questions) && !empty($questions)){
                                        foreach($questions as $key=> $value){?>
                                      <tr>
                                        <td><?php echo $value['sfq_question']; ?></td>
                                        <td> <?php echo $value['sfq_description']; ?></td>
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


