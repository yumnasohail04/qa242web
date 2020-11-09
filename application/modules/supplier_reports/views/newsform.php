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
    fieldset .input-group mb-3 {
    margin-bottom: 15px;
}
</style>
<?php include_once("select_box.php");?>
<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1> <?php if (empty($update_id)) 
        $strTitle = 'Add Document';
      else 
        $strTitle = 'Edit Document';
        echo $strTitle;
      ?></h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'document'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
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
                            $hidden = array('hdnId' => $update_id); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'document/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'document/submit/' . $update_id, $attributes);
                        ?>
                  <div class="row">
                         <div class="col-sm-6">
                            <div class="input-group mb-3">
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
                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                              <?php if(!isset($assign)) $assign = array();
                              if(!isset($news['assign_to'])) $news['assign_to'] = ""; ?>
                              <?php $options = $assign ;
                              $attribute = array('class' => 'control-label col-md-4');?>
                              <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Assign to<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_dropdown('assign_to', $options, $news['assign_to'],  'class="form-control select2me required validatefield" id="selectboxing" tabindex ="8"'); ?>
                            </div>
                         </div>
                         
                         <div class="col-sm-6">
                            <div class="input-group mb-3">
                              <?php if(!isset($level)) $level = array();
                              if(!isset($news['level'])) $news['level'] = ""; ?>
                              <?php $options =$level ;
                              $attribute = array('class' => 'control-label col-md-4');?>
                              <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Importance<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_dropdown('level', $options, $news['level'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                            </div>
                         </div>
                      
                         <div class="form-body col-sm-6 " id="type_check" style="<?php if($news['assign_to']=="supplier" || !empty($news['assign_to']) || isset($news['assign_to'])){ ?> display:none;<?php  }else{?> display:block;<?php } ?>">                   
                             <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Type<span style="color:red">*</span></button>
                                </div>
                                  <select  multiple class="select-1 form-control restaurant_type  " name="type_id[]" >
                                      <?php
                                        if(!isset($type) || empty($type))
                                            $type = array();
                                          foreach ($type as $value): ?>
                                      <option value="<?=$value['id']?>"
                                      <?php foreach($selected_ing_type as $new){ if($value['id']== $new) echo 'selected="selected"';}?>><?= $value['name']?></option>
                                      <?php endforeach ?>
                                  </select>
                               </div>
                          </div>
                         <div class="form-body col-sm-6 " id="supplier_type" style="<?php if($news['assign_to']=="supplier" || !empty($news['assign_to']) || isset($news['assign_to'])){ ?> display:block;<?php  }else{?> display:none;<?php } ?>">                   
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Supplier Type<span style="color:red">*</span></button>
                                </div>
                                  <select  multiple class=" select-1 form-control restaurant_type " name="supplier_type[]" >
                                      <?php
                                        if(!isset($supplier_type) || empty($supplier_type))
                                            $supplier_type = array();
                                          foreach ($supplier_type as $value): ?>
                                      <option value="<?=$value['id']?>"
                                      <?php foreach($selected_type as $new){ if($value['id']== $new) echo 'selected="selected"';}?>><?= $value['name']?></option>
                                      <?php endforeach ?>
                                  </select>
                            </div>
                          </div>
                         <div class="col-sm-6" id="doc_type" style="<?php if($news['assign_to']!="supplier" || empty($news['assign_to']) || isset($news['assign_to'])){ ?> display:none;<?php  }else{?> display:block;<?php } ?>">
                            <div class="input-group mb-3">
                              <?php if(!isset($doc_type)) $doc_type = array();
                              if(!isset($news['doc_type'])) $news['doc_type'] = ""; ?>
                              <?php $options =$doc_type ;
                              $attribute = array('class' => 'control-label col-md-4');?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Document Type <span style="color:red">*</span></button>
                                </div>
                                <?php echo form_dropdown('doc_type', $options, $news['doc_type'],  'class="form-control select2me validatefield" id="role_id" tabindex ="8"'); ?>
                            </div>
                         </div>
      					</div>
                </div>
          <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'document'; ?>">
                        <button type="button" class="btn green btn-outline-primary" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
                
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
        var value=$('#selectboxing').val();
        if(value=="supplier")
      {
          document.getElementById( 'supplier_type' ).style.display = 'block';
          document.getElementById( 'type_check' ).style.display = 'none';
          document.getElementById( 'doc_type' ).style.display = 'none';
          
      }
      else
      {
          document.getElementById( 'supplier_type' ).style.display = 'none';
          document.getElementById( 'type_check' ).style.display = 'block';
          document.getElementById( 'doc_type' ).style.display = 'block';
      }

    });

    
    $(document).off("change", "#selectboxing").on("change", "#selectboxing",function(event){
      var value=$('#selectboxing').val();
      if(value=="supplier")
      {
          document.getElementById( 'supplier_type' ).style.display = 'block';
          document.getElementById( 'type_check' ).style.display = 'none';
          document.getElementById( 'doc_type' ).style.display = 'none';
      }
      else
      {
          document.getElementById( 'supplier_type' ).style.display = 'none';
          document.getElementById( 'type_check' ).style.display = 'block';
          document.getElementById( 'doc_type' ).style.display = 'block';
      }
    });


</script>
