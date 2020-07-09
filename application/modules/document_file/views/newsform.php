<style type="text/css">
    .red_class {
        border: 1px solid red !important;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    {
        width:100%;
    }
    .btn-group.open .dropdown-toggle {
        background-color: transparent;
    }
    fieldset .form-group {
    margin-bottom: 15px;
    }
    input[type="checkbox"] {
    height: 16px;
    }
</style>
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
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Document';
                else 
                    $strTitle = 'Edit Document';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'document_file'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
       </h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="border-radius:10px;">
         
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'document_file/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'document_file/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body section-box">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                   
                    <div class="row">
                        <fieldset>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'doc_name',
                                    'id' => 'doc_name',
                                    'class' => 'form-control',
                                    'value' => $news['doc_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Document Name<span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                              <?php if(!isset($carrier_type)) $carrier_type = array();
                              if(!isset($news['carrier_type'])) $news['carrier_type'] = ""; ?>
                              <?php $options = $carrier_type ;
                              $attribute = array('class' => 'control-label col-md-4');
                              echo form_label('Assign to <span style="color:red">*</span>', 'role_id', $attribute);?>
                              <div class="col-md-8">
                                <?php echo form_dropdown('carrier_type', $options, $news['carrier_type'],  'class="form-control select2me required validatefield" tabindex ="8"'); ?>
                              </div>
                            </div>
                         </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                            <label class="control-label col-md-4">
                                Ask Question with it ?
                            </label>
                            <div class="col-md-8">
                              <input type="checkbox" name="question" id="selectboxing"  class="form-control" <?php if($news['question']=="1") echo "checked";?>  <?php if(!empty($news['question']))?> value=" <?php echo $news['question']; ?>";>
                              </div>
                            </div>
                         </div>
                    </fieldset>
                    </div>
                    <div id="selected_div" <?php if($news['question']!="1") {?> style="display:none" <?php } ?> >
                    <legend>Question</legend>
                    <div class="row">
                      <div class="col-sm-5">
                          <div class="form-group">
                              <?php
                              $data = array(
                                  'name' => 'title',
                                  'id' => 'title',
                                  'class' => 'form-control',
                                  'value' => $new['title'],
                                  'type' => 'text',
                                  'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                              <?php echo form_label('Question<span style="color:#ff60a3">*</span>', 'title', $attribute); ?>
                              <div class="col-md-8">
                                  <?php echo form_input($data); ?>
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php if(!isset($type)) $type = array();
                          if(!isset($new['type'])) $new['type'] = ""; ?>
                          <?php $options = $type ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Submission <span style="color:red">*</span>', 'role_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('type', $options, $new['type'],  'class="form-control select2me required validatefield"  tabindex ="8"'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                        <label class="control-label col-md-4">
                            Add Comment box?
                        </label>
                        <div class="col-md-8">
                          <input type="checkbox" name="comment_box" id="comment_box" class="form-control" <?php if( isset($new['comment_box']) && $new['comment_box']=="1") echo "checked";?>  <?php if( isset($new['comment_box']) && !empty($new['comment_box'])){?> value=" <?php echo $new['comment_box']; ?>" <?php } ?>>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                        <label class="control-label col-md-4">
                            Add Reference Link ?
                        </label>
                        <div class="col-md-8">
                            <input type="checkbox" name="reference_link" id="reference_link" class="form-control" <?php if(isset($new['reference_link']) && $new['reference_link']=="1") echo "checked";?> <?php if( isset($new['reference_link']) && !empty($new['reference_link'])){?> value=" <?php echo $new['reference_link']; ?>" <?php } ?>>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'document_file'; ?>">
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


<script>

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
   

    });

    
    $(document).off("change", "#selectboxing").on("change", "#selectboxing",function(event){
      if(document.getElementById('selectboxing').checked)
      {
          document.getElementById( 'selected_div' ).style.display = 'block';
          $('#selectboxing').val('1')
      }
      else
      {
          document.getElementById( 'selected_div' ).style.display = 'none';
          $('#selectboxing').val('0')
      }
    });

    $(document).off("change", "#comment_box").on("change", "#comment_box",function(event){
        if(document.getElementById('comment_box').checked)
            $('#comment_box').val('1')
        else
            $('#comment_box').val('0')
      });


    $(document).off("change", "#reference_link").on("change", "#reference_link",function(event){
      if(document.getElementById('reference_link').checked)
          $('#reference_link').val('1')
      else
          $('#reference_link').val('0')
    });



</script>
