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
            <main>
              <div class="container-fluid">
                <div class="row">
                  <div class="col-12">
                    <h1> <?php
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
                    ?></h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo $back_page; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
                    <div class="separator mb-5"></div>
                  </div>
                </div>
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="mb-4">
                
                  </h5>
                  
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
                    <div class="col-sm-6">
                      <div class="input-group mb-3">
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
                          <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Question<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_input($data); ?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-group mb-3">
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
                          $attribute = array('class' => 'control-label col-md-4');?>

                          <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button">Description<span style="color:red">*</span></button>
                          </div>
                          <?php echo form_textarea($data); ?> 
                      </div>
                    </div>
                  </div>
                </div>

                 

                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo $back_page; ?>">
                        <button type="button" class="btn green btn-outline-primary" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </main>
