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
                    <a href="<?php echo ADMIN_BASE_URL . 'document'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'document/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'document/submit/' . $update_id, $attributes);
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
                              <?php if(!isset($assign)) $assign = array();
                              if(!isset($news['assign_to'])) $news['assign_to'] = ""; ?>
                              <?php $options = $assign ;
                              $attribute = array('class' => 'control-label col-md-4');
                              echo form_label('Assign to <span style="color:red">*</span>', 'role_id', $attribute);?>
                              <div class="col-md-8">
                                <?php echo form_dropdown('assign_to', $options, $news['assign_to'],  'class="form-control select2me required validatefield" id="selectboxing" tabindex ="8"'); ?>
                              </div>
                            </div>
                         </div>
                         
                         <div class="col-sm-5">
                            <div class="form-group">
                              <?php if(!isset($level)) $level = array();
                              if(!isset($news['level'])) $news['level'] = ""; ?>
                              <?php $options =$level ;
                              $attribute = array('class' => 'control-label col-md-4');
                              echo form_label('Importance <span style="color:red">*</span>', 'role_id', $attribute);?>
                              <div class="col-md-8">
                                <?php echo form_dropdown('level', $options, $news['level'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                              </div>
                            </div>
                         </div>
                        <div class="col-sm-5 " id="type_check" style="<?php if($news['assign_to']=="supplier" || empty($news['assign_to']) || !isset($news['assign_to'])){ ?> display:none;<?php  }else{?> display:block;<?php } ?>">
                            <div class="form-group">
                              <?php if(!isset($type)) $type = array();
                              if(!isset($news['type_id'])) $news['type_id'] = ""; ?>
                              <?php $options =$type ;
                              $attribute = array('class' => 'control-label col-md-4');
                              echo form_label('Type <span style="color:red">*</span>', 'role_id', $attribute);?>
                              <div class="col-md-8">
                                <?php echo form_dropdown('type_id', $options, $news['type_id'],  'class="form-control select2me validatefield" id="role_id" tabindex ="8"'); ?>
                              </div>
                            </div>
                         </div>
                    </fieldset>
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'document'; ?>">
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
      var value=$('#selectboxing').val();
      if(value=="supplier")
      {
          document.getElementById( 'type_check' ).style.display = 'none';
      }
      else
      {
          document.getElementById( 'type_check' ).style.display = 'block';
      }
    });

</script>
