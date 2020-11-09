<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap-select.min.css" />
<script src="<?php echo STATIC_ADMIN_JS?>bootstrap-select.min.js"></script>
<?php include_once("select_box.php");?>
<style>
    .red {
        border: 1px solid red !important;
    }
    .selectbox-class {
    background-color: white;
    color: #3a3f51;
  }
  .bootstrap-select {
    width: 100% !important;
  }
</style>

<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1> 
        <?php 
        if (empty($update_id)) 
        $update_id=0;
        $strTitle = 'Replace Wip Product';
    
        echo $strTitle;
        ?>
        </h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'product/wip_products'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
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
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        echo form_open_multipart(ADMIN_BASE_URL . 'product/submit_wips_replacement_data/', $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                 

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Select New WIP Nav:<span style="color:red">*</span></button>
                                </div>
                                    <select  id="selectboxing" class="form-control selectpicker new_wip"  data-show-subtext="true" data-live-search="true" name="new_wip" required="required">
                                        <option>Select</option>
                                      <?php 
                                        if(isset($all_navigation) && !empty($all_navigation)) { 
                                            foreach($all_navigation as $key=> $an): ?>
                                        <option  value="<?=$an['navision_number'];?>" data-subtext="<?php if(isset($an['navision_number']) && !empty($an['navision_number'])) echo $an['navision_number'];?>"><?=$an['product_name'];?></option>
                                       <?php endforeach; } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Select Old WIP Nav:<span style="color:red">*</span></button>
                                </div>
                                    <select  id="selectboxing" class="form-control selectpicker old_wip"  data-show-subtext="true" data-live-search="true" name="old_wip" required="required">
                                        <option>Select</option>
                                        <?php 
                                        if(isset($all_navigation) && !empty($all_navigation)) { 
                                            foreach($all_navigation as $key=> $an): ?>
                                        <option  value="<?=$an['navision_number'];?>" data-subtext="<?php if(isset($an['navision_number']) && !empty($an['navision_number'])) echo $an['navision_number'];?>"><?=$an['product_name'];?></option>
                                       <?php endforeach; } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="multi_select_product">
                        </div>
                    </div>
                    <br><br>
                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product/wip_products'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
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

<script type="text/javascript">
    $('.selectpicker').selectpicker('refresh');
    $( ".selectpicker" ).addClass('selectbox-class');
    function submit_change_function() {
        $(document).off('click', '.submited_form').on('click', '.submited_form', function(e){
            e.preventDefault();
            if(validateForm()) {
              $('#form_sample_1').attr('action', "<?= ADMIN_BASE_URL.'product/submit_wips_replacement_data/';?>").submit();
            } else {
              console.log('sdfsafsf');
            }
        });
    }
    submit_change_function();
    function validateForm() {
        var isValid = true;
        if($('.product_select').val() == '' || $('.product_select').val() == null || $('.product_select').val()== 'undefined') {
            isValid = false;
            $('.product_select').parent().find('.chosen-choices').addClass('red');
        }
        else
            $('.product_select').parent().find('.chosen-choices').removeClass('red');
        if($('.new_wip').val() == '' || $('.new_wip').val() == null || $('.new_wip').val()== 'undefined' || $('.new_wip').val().toLowerCase() =='select') {
            isValid = false;
            $('.new_wip').parent().find('.btn-default.selectbox-class').addClass('red');
        }
        else
            $('.new_wip').parent().find('.btn-default.selectbox-class').removeClass('red');
        if($('.old_wip').val() == '' || $('.old_wip').val() == null || $('.old_wip').val()== 'undefined'  || $('.old_wip').val().toLowerCase() =='select') {
            isValid = false;
            $('.old_wip').parent().find('.btn-default.selectbox-class').addClass('red');
        }
        else
            $('.old_wip').parent().find('.btn-default.selectbox-class').removeClass('red');
        return isValid;
    }
    $('.old_wip').on('change', function() {
        var abc = $(this);
        if(abc.val()) {
            $.ajax({
              type: 'POST',
              url: "<?= ADMIN_BASE_URL?>product/get_old_wip_products",
              data: {'testing':abc.val()},
              async: false,
              success: function(test_body) {
               $(".multi_select_product").html(test_body);
                $('.selectpicker').selectpicker('refresh');
                $( ".selectpicker" ).addClass('selectbox-class');
                $('.chosen-select').chosen();
                submit_change_function();
              }
            });
        }
    });
</script>


