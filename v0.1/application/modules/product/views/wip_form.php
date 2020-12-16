<?php include_once("select_box.php");?>
<style>
    .red {
        border: 1px solid red !important;
    }
</style>






<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1>  <?php
            if(!isset($update_id) || empty($update_id))
                $update_id = 0; 
            if (empty($update_id))
                $strTitle = 'Add New Wip Product';
            else 
                $strTitle = 'Edit Wip Product';
            echo $strTitle; 
            ?></h1>
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
                        echo form_open_multipart(ADMIN_BASE_URL . 'product/submit_wips_data/', $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                 

                    <div class="row ">
                        <input type="hidden" name="update_id" value="<?=$update_id?>">
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">New Nav No<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?> <span id="message"></span>
                                <input type="hidden" name="old_nav" value="<?=$news[0]['navision_number']?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">WIP Product Title<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                       
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Select Finish Good(s):<span style="color:red">*</span></button>
                                </div>
                                    <select  multiple="multiple" class="select-1 form-control product_select validate_form " name="product_select[]">
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


                <div class="row">
                      <div class="input-group" style="margin-top:3%;">
                        <button type="submit" class="btn btn-outline-success mb-1 buttonsubmit btnsave submited_form">Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product/wip_products'; ?>"><button type="button" class="btn btn-outline-primary  mb-1">Cancel</button></a>
                      </div>
                    </div>
                
                <?php echo form_close(); ?> 
                
              </div>
            </div>
          </div>
        </main>

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


