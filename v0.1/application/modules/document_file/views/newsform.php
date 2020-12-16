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
    fieldset .input-group  mb-3 {
    margin-bottom: 15px;
    }
    input[type="checkbox"] {
    height: 16px;
    }
</style>  
<?php include_once("select_box.php");?>

          <main>
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <h1> <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Document';
                else 
                    $strTitle = 'Edit Document';
                    echo $strTitle;
                    ?></h1>
                  <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'document_file'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
                  <div class="separator mb-5"></div>
                </div>
              </div>
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="mb-4">
              
                </h5>



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
                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Document Name<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="input-group  mb-3">
                              <?php if(!isset($carrier_type)) $carrier_type = array();
                              if(!isset($news['carrier_type'])) $news['carrier_type'] = ""; ?>
                              <?php $options = $carrier_type ;
                              $attribute = array('class' => 'control-label col-md-4');
                              echo form_label('Assign to <span style="color:red">*</span>', 'role_id', $attribute);?>
                              <div class="col-md-8">
                                <?php echo form_dropdown('carrier_type', $options, $news['carrier_type'],  'class="form-control select2me required validatefield" tabindex ="8"'); ?>
                              </div>
                            </div>
                         </div> -->



                         
                         <div class="form-body col-sm-6 " >                   
                            <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Assign to<span style="color:red">*</span></button>
                                </div>
                                  <select  multiple class="form-control select-1 restaurant_type " name="carrier_type[]" required="required">
                                      <?php
                                        if(!isset($carrier_type) || empty($carrier_type))
                                            $carrier_type = array();
                                          foreach ($carrier_type as $value): ?>
                                      <option value="<?=$value['id']?>"
                                      <?php foreach($selected_type as $new){ if($value['id']== $new) echo 'selected="selected"';}?>><?= $value['type']?></option>
                                      <?php endforeach ?>
                                  </select>
                            </div>
                          </div>



                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Ask Question with it ?<span style="color:red">*</span></button>
                                </div>
                              <input type="checkbox" name="question" id="selectboxing"  class="form-control" <?php if($news['question']=="1") echo "checked";?>  <?php if(!empty($news['question']))?> value=" <?php echo $news['question']; ?>";>
                            </div>
                         </div>
                    </div>
                    <div id="selected_div" <?php if($news['question']!="1") {?> style="display:none" <?php } ?> >
                    <legend>Question</legend>
                    <div class="row">
                      <div class="col-sm-6">
                          <div class="input-group  mb-3">
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
                              <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Question<span style="color:red">*</span></button>
                                </div>
                                  <?php echo form_input($data); ?>
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group  mb-3">
                          <?php if(!isset($type)) $type = array();
                          if(!isset($new['type'])) $new['type'] = ""; ?>
                          <?php $options = $type ;
                          $attribute = array('class' => 'control-label col-md-4');?>
                          <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Submission<span style="color:red">*</span></button>
                                </div>
                            <?php echo form_dropdown('type', $options, $new['type'],  'class="form-control select2me required validatefield"  tabindex ="8"'); ?>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group  mb-3">
                       
                        <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button"> Add Comment box?<span style="color:red">*</span></button>
                                </div>
                          <input type="checkbox" name="comment_box" id="comment_box" class="form-control" <?php if( isset($new['comment_box']) && $new['comment_box']=="1") echo "checked";?>  <?php if( isset($new['comment_box']) && !empty($new['comment_box'])){?> value=" <?php echo $new['comment_box']; ?>" <?php } ?>>
                        </div>
                      </div>
                      <!-- <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group  mb-3">
                        <label class="control-label col-md-4">
                            Add Reference Link ?
                        </label>
                        <div class="col-md-8">
                            <input type="checkbox" name="reference_link" id="reference_link" class="form-control" <?php if(isset($new['reference_link']) && $new['reference_link']=="1") echo "checked";?> <?php if( isset($new['reference_link']) && !empty($new['reference_link'])){?> value=" <?php echo $new['reference_link']; ?>" <?php } ?>>
                          </div>
                        </div>
                      </div>
                      </div> -->
                    </div>
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'document_file'; ?>">
                        <button type="button" class="btn greenbtn-outline-primary" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
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
