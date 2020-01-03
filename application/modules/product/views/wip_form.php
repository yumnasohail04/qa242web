<?php include_once("select_box.php");?>
<style>
    .red {
        border: 1px solid red !important;
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
            if(!isset($update_id) || empty($update_id))
                $update_id = 0; 
            if (empty($update_id))
                $strTitle = 'Add New Wip Product';
            else 
                $strTitle = 'Edit Wip Product';
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
                        echo form_open_multipart(ADMIN_BASE_URL . 'product/submit_wips_data/', $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                 

                    <div class="row section-box">
                        <input type="hidden" name="update_id" value="<?=$update_id?>">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                if(!isset($news[0]['navision_number']))
                                    $news[0]['navision_number'] = '';
                                $data = array(
                                    'name' => 'navision_number',
                                    'id' => 'navision_number',
                                    'class' => 'form-control validate_form',
                                    'value' => $news[0]['navision_number'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('New Nav No: <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?> <span id="message"></span>
                                </div>
                                <input type="hidden" name="old_nav" value="<?=$news[0]['navision_number']?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php
                                if(!isset($news[0]['product_name']))
                                    $news[0]['product_name'] = '';
                                $data = array(
                                    'name' => 'product_name',
                                    'id' => 'product_name',
                                    'class' => 'form-control validate_form',
                                    'value' => $news[0]['product_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                   
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('WIP Product Title: <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                    	<div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                if(!isset($news[0]['document_name']))
                                    $news[0]['document_name'] = '';
                                $data = array(
                                    'name' => 'document_name',
                                    'id' => 'document_name',
                                    'class' => 'form-control validate_form',
                                    'value' => $news[0]['document_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                   
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Document Name: <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Select Finish Good(s): <span class="required" style="color:#ff60a3">*</span></label>
                                <div class="col-sm-8">
                                    <select  multiple="multiple" class="form-control product_select  chosen-select " name="product_select[]">
                                        <?php
                                        if(!isset($products) || empty($products))
                                            $products = array();
                                        if(!empty($products)) {
                                            if(!isset($selected) || empty($selected))
                                                $selected = array();
                                            foreach ($products as $key => $an):
                                                $checking = array_search($an['id'], array_column($selected, 'product_id'));
                                                if(is_numeric($checking) || $an['status'] == '1') { ?>
                                                    <option <?php if(is_numeric($checking)) echo 'selected="selected"'; ?> value="<?=$an['id']?>">
                                                        <?=$an['navision_no']?>
                                                    </option>
                                                <?php }
                                            endforeach;
                                        }?>
                                    </select>
                                </div>
                            </div>
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
    $(document).off('click', '.submited_form').on('click', '.submited_form', function(e){
        e.preventDefault();
        if(validateForm()) {
            $("#message").html("<img src='<?= STATIC_ADMIN_IMAGE?>ajax-loader.gif' />")
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>product/checking_navigation_name",
                data: {'updation': '<?=$update_id?>','nav_name':$("input[name=navision_number]").val()},
                async: false,
                success: function(result) {
                    if(result == 1){
                       $("#message").html("<span style='color:red;'>New Nav already exist..!</span>");
                    }
                    else {
                       $("#message").html("");
                       $('#form_sample_1').attr('action', "<?= ADMIN_BASE_URL.'product/submit_wips_data/';?>").submit();
                    }
                }
            });
        } else {
          console.log('');
        }
    });
    function validateForm() {
        var isValid = true;
        $('.validate_form').each(function(){
          if($(this).val() == '' || $(this).val() == null){
            $(this).addClass('red');
            isValid = false;
          } else {
            $(this).removeClass('red');
          }
        });
        if($('.product_select').val() == '' || $('.product_select').val() == null || $('.product_select').val()== 'undefined') {
            isValid = false;
            $('.product_select').parent().find('.chosen-choices').addClass('red');
        }
        else
            $('.product_select').parent().find('.chosen-choices').removeClass('red');
        return isValid;
    }
</script>


