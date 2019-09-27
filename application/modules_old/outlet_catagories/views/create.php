<?php // print_r($thought_of_day); exit(); ?>

<div class="page-content-wrapper">
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body"> Widget settings form goes here </div>
          <div class="modal-footer">
            <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
            <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
          </div>
        </div>
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
    <!-- /.modal --> 
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM--> 
    <!-- BEGIN PAGE HEADER-->
    <div class="content-wrapper">
     <h3>

      <?php
      if (empty($update_id)) 
        $strTitle = 'Add Category';
      else 
        $strTitle = 'Edit Category';

      echo $strTitle;
      ?>
      <a href="<?php echo ADMIN_BASE_URL . 'catagories'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    </h3>

  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tabbable tabbable-custom boxless">
        <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">

            <div class="tab-pane  active" id="tab_2" >
              <div class="portlet box green ">
                <div class="portlet-title ">

                </div>
                
                <div class="portlet-body form " style="padding-top:15px;"> 

                  <!-- BEGIN FORM-->
                  <?php
                  $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                  if (empty($update_id)) {
                    $update_id = 0;
                  } else {
                                        $hidden = array('hdnId' => $update_id); ////edit case
                                      }
                                      if (isset($hidden) && !empty($hidden))
                                        echo form_open_multipart(ADMIN_BASE_URL . 'catagories/submit/' . $update_id , $attributes, $hidden);
                                      else
                                        echo form_open_multipart(ADMIN_BASE_URL . 'catagories/submit/' . $update_id , $attributes);
                                      ?>
                                      <div class="form-body">

                                        <!-- <h3 class="form-section">Post Information</h3>-->
                                        <div class="row">
                                          <div class="col-sm-5">
                                           <div class="form-group">
                                            <?php
                                            $data = array(
                                              'name' => 'txtCatName',
                                             
                                              'id'          => 'maxlength_placement',
                                              'class' => 'form-control text-input',
                                              'value' => $catagories['cat_name'],
                                              'required' => 'required',
                                              );
                                            $attribute = array('class' => 'control-label col-md-4');
                                            ?>
                                            <?php echo form_label('Name <span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                                            <div class="col-md-8">
                                              <?php echo form_input($data); ?>
                                            </div>

                                          </div>
                                        </div>



                                        <div class="col-sm-5">
                                          <div class="form-group">
                                            <?php
                                            $data = array(
                                              'name'        => 'txtPageUrl',
                                              'id'          => 'txtPageUrl',
                                              'type' => 'text',
                                              'class'     => 'form-control',
                                              'value'       => $catagories['url_slug'],
                                              );
                                            $attribute = array('class' => 'control-label col-md-4');
                                            echo form_label('Page Url','txtPageUrl', $attribute);
                                            echo '<div class="col-md-8">'.form_input($data).'</div>';
                                            ?>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-sm-5">
                                          <div class="form-group">
                                            <?php
                                            $options = array('' => 'Select') + $rank;
                                            $attribute = array('class' => 'control-label col-md-4');
                                            echo form_label('Rank', 'rank', $attribute);
                                            ?>
                                            <div class="col-md-8" id="cities_cont">
                                              <?php echo form_dropdown('rank', $options, $catagories['rank'], 'class = "form-control chosen-select" id = "rank"'); ?>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      
                                      <div class="row">
                                        <div class="col-sm-5">
                                          <div class="form-group">
                                            <?php
                                            $data = array(
                                              'name' => 'txtMetaDesc',
                                              'id' => 'maxlength_textarea',
                                              'rows' => '11',
                                              'cols' => '10',

                                              'class' => 'form-control note-editor',
                                              'value' => $catagories['meta_description']

                                              );
                                            $attribute = array('class' => 'control-label col-md-4');
                                            echo form_label('Meta Description', 'txtMetaDesc', $attribute);
                                            ?>
                                            <div class="col-md-8"> <?php echo form_textarea($data); ?> </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-5">
                                          <div class="form-group last">
                                            <label class="control-label col-md-4">Image Upload </label>
                                            <div class="col-md-8">
                                              <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                  <?
                                                  $filename =  SMALL_CATAGORIES_IMAGE_PATH . $catagories['image'];
                                                  if (isset($catagories['image']) && !empty($catagories['image']) && file_exists($filename)) {
                                                    ?>
                                                    <img src = "<?php echo base_url() . MEDIUM_CATAGORIES_IMAGE_PATH . $catagories['image'] ?>" />
                                                    <?php
                                                  } else {
                                                    ?>
                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                                    <?php
                                                  }
                                                  ?>
                                                </div>
                                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                </div>
                                                <div>
                                                 <span class="btn btn-default btn-file">
                                                  <span class="fileupload-new">
                                                    <i class="fa fa-paper-clip"></i> Select image
                                                  </span>
                                                  <span class="fileupload-exists">
                                                    <i class="fa fa-undo"></i> Change
                                                  </span>
                                                  <input type="file" name="catagories_file" id="catagories_file" class="default required" />
                                                  <input type="hidden" id="hdn_image" value="<?= $catagories['image'] ?>" name="hdn_image"/>
                                                </span>
                                                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
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
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <?php 
                                  $attribute = array('class' => 'control-label col-md-2');
                                  echo form_label('Long Description', 'txtCatDesc', $attribute);
                                  ?>
                                  <div class="col-md-9" style="float:left; margin-left:135px; margin-bottom:50px;"><textarea class="ckeditor form-control" id="comment" name="txtCatDesc" rows="6"><?php echo $catagories['cat_desc']?></textarea></div>
                                </div>
                              </div>
                            </div>
                            <div class="form-actions fluid no-mrg">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                                   <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                                   <a href="<?php echo ADMIN_BASE_URL . 'catagories'; ?>">
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

      <script type="text/javascript">

       $('#form_sample').submit(function() {

        var error = 0;
        var comment = $('#comment').val();
        if (comment == '') {
          error = 1;
          $('#error').html('This value is required').css('color', 'red');;
        }

        if (error) {
          return false;
        } else {
          return true;
        }

      });

       $(document).ready(function() {
        $("#catagories_file").change(function() {
          var img = $(this).val();
          var replaced_val = img.replace("C:\\fakepath\\", '');
          $('#hdn_image').val(replaced_val);
        });
      });
     </script>