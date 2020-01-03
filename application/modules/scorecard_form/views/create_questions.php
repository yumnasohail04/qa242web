<style type="text/css">
  .wrapclone  {
    border: 1px dotted;
    float: left;
    width: 100%;
    padding: 20px 0px 10px 0px;
    position: relative;
    margin-bottom:5px; 
  }
  .removedealsitem_frozen {
    position: absolute;
    top: 0;
    right: 0;
  }
.clone-remover {
    position: absolute;
    top: 0;
    padding: 3px 5px 4px 5px;
    border: 1px solid #ddd;
    border-radius: 50%;
    box-shadow: 0px 0px 6px 0px #ddd;
  }
  .redborder {
    border:1px solid red;
  }
  .append-cat-data {
    border: 1px dashed #23b7e5;
    float: left;
    padding: 20px;
    margin-bottom: 20px;
    width: 100%;
    position: relative;
  }
  .removedealsitem {
    font-size: 15px;
    position: absolute;
    right: -10px;
    top: -10px;
    padding-left: 8px;
    padding-right: 7px;
    border-radius: 50%;
    background-color: white;
    cursor: pointer;
    box-shadow: 1px 2px 2px 1px rgba(128, 128, 128, 0.9);
  }
  .marging {
    margin-top: 20px;
  }
</style>
<?php if(!isset($sfq_question_selection)) $sfq_question_selection = '';?>
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
            $cat_name =  $this->uri->segment(6);
            $cat_name_sub =  $this->uri->segment(6);
            if (!empty($cat_name_sub)) {
              $cat_name =  $this->uri->segment(6);
              $strTitle = "Edit attribute";
            }
            else
            {
               $strTitle = "Question Detail";
            }
                    
                    echo $strTitle;
                    ?>
                    <a href="<?php echo $back_page; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                          $attributes = array('autocomplete' => 'off', 'id' => 'frmSubCatagories', 'class' => 'form-horizontal');
                          if(empty($update_id)){
                            $update_id = 0;
                            $hidden = array('parent_id' => $parent_id,'checkname'=>$check_name, 'update_id' => $update_id);
                          }
                          else{
                            $hidden = array('parent_id' => $parent_id, 'update_id' => $update_id,'checkname'=>$check_name); ////edit case
                          }
                          echo form_open_multipart(ADMIN_BASE_URL.'scorecard_form/submit_question', $attributes, $hidden); ?>
                <div class="form-body">
                  <div class="row" >
                    <div class="col-md-5">
                      <div class="form-group">
                          <?php if(!isset($questions['question']))
                            $questions['question'] = '';
                           $data = array(
                              'name' => 'question',
                              'id' => 'question',
                              'class' => 'form-control validate[required] text-input dropify-wrappe',
                              'value' => $questions['question'],
                              'required' => 'required',
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Question <span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                          <div class="col-md-8">
                              <?php echo form_input($data); ?>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="form-group">
                          <?php if(!isset($questions['description']))
                            $questions['description'] = '';
                          $data = array(
                              'name' => 'detail',
                              'id' => 'detail',
                              'rows' => '11',
                              'cols' => '10',
                              'class' => 'form-control note-editor',
                              'data-parsley-maxlength'=>'10000',
                              'value' => $questions['description'],
                              'required' => 'required'
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Description <span class="red" style="color:red;">*</span>', 'detail', $attribute);
                          ?>

                          <div class="col-md-8">
                              <?php echo form_textarea($data); ?> 
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                 

                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo $back_page; ?>">
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
