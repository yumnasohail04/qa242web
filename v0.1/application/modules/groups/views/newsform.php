<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1>  <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Group';
                else 
                    $strTitle = 'Edit Group';
                    echo $strTitle;
                    ?></h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'groups'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
        <div class="separator mb-5"></div>
      </div>
    </div>
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="mb-4">
              </h5>
                <div class="portlet-body form " style="padding-top:15px;"> 
                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'groups/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'groups/submit/' . $update_id, $attributes);
                        ?>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'group_title',
                            'id' => 'group_title',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['group_title'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button">Title<span style="color:red">*</span></button>
                            </div>
                            <?php echo form_input($data); ?>
                          </div>
                          </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">Description</button>
                              </div>
                              <textarea id="group_desc" name="group_desc" class="form-control" aria-label="With textarea" value="<?php echo $news['group_desc'];?>"></textarea>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group mb-3">
                              <?php $options = $roles_title ;
                              ?>
                              <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">Role<span style="color:red">*</span></button>
                              </div>
                              <?php echo form_dropdown('role', $options, $news['role'],  'class="custom-select" id="sec_grp"'); ?>
                          </div>
                        </div>
                      </div>
                
               
                    <div class="row">
                      <div class="input-group" style="margin-top:3%;">
                        <button type="submit" class="btn btn-outline-success mb-1 buttonsubmit btnsave">Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'groups'; ?>"><button type="button" class="btn btn-outline-primary  mb-1">Cancel</button></a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </main>     


<script>

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });



</script>
