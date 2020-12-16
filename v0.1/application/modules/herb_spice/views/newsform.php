
                
                <main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1>      <?php 
        if (empty($update_id)) 
        $update_id=0;
                    $strTitle = 'Add Ingredients';
                
                    echo $strTitle;
                    ?></h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'herb_spice'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
        <div class="separator mb-5"></div>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="mb-4">
        
          </h5>
      
      
      
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'herb_spice/submit/'.$checkid.'/'.$update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'herb_spice/submit/'.$checkid.'/'.$update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                 

                   <div class="row section-box">
                         <div class="col-sm-6">
                            <div class="input-group mb-3">
                                <?php
                                $data = array(
                                    'name' => 'product_name',
                                    'id' => 'product_name',
                                    'class' => 'form-control',
                                    'value' => $news['product_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                   
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                            <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Product Title<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                   		<div class="col-sm-6">
                            <div class="input-group mb-3">
                                <?php
                                $data = array(
                                    'name' => 'navision_number',
                                    'id' => 'navision_number',
                                    'class' => 'form-control',
                                    'value' => $news['navision_number'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                            <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Navision Number<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                     </div>
                    <br><br>
                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'herb_spice'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
                <!-- END FORM--> 
                
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>


