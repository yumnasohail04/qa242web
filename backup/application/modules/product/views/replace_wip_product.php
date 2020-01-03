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
        $update_id=0;
                    $strTitle = 'Replace Wip Product';
                
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'product/wip_products'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        echo form_open_multipart(ADMIN_BASE_URL . 'product/submit_wips_replacement_data/', $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                 

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                              <label class="col-sm-4 control-label">Select New WIP Nav: <span class="required" style="color:#ff60a3">*</span></label>
                                <div class="col-sm-8">
                                    <select  id="selectboxing" class="selectpicker new_wip"  data-show-subtext="true" data-live-search="true" name="new_wip" required="required">
                                        <option>Select</option>
                                      <?php 
                                        if(isset($all_navigation) && !empty($all_navigation)) { 
                                            foreach($all_navigation as $key=> $an): ?>
                                        <option  value="<?=$an['navision_number'];?>" data-subtext="<?php if(isset($an['navision_number']) && !empty($an['navision_number'])) echo $an['navision_number'];?>"><?=$an['product_name'];?></option>
                                       <?php endforeach; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                              <label class="col-sm-4 control-label">Select Old WIP Nav: <span class="required" style="color:#ff60a3">*</span></label>
                                <div class="col-sm-8">
                                    <select  id="selectboxing" class="selectpicker old_wip"  data-show-subtext="true" data-live-search="true" name="old_wip" required="required">
                                        <option>Select</option>
                                        <?php 
                                        if(isset($all_navigation) && !empty($all_navigation)) { 
                                            foreach($all_navigation as $key=> $an): ?>
                                        <option  value="<?=$an['navision_number'];?>" data-subtext="<?php if(isset($an['navision_number']) && !empty($an['navision_number'])) echo $an['navision_number'];?>"><?=$an['product_name'];?></option>
                                       <?php endforeach; } ?>
                                    </select>
                                </div>
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


