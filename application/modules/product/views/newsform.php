<?php include('select_box.php'); ?>             
<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1> <?php if (empty($update_id)) 
        $strTitle = 'Add Product';
      else 
        $strTitle = 'Edit Product';
        echo $strTitle;
      ?></h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'product'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
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
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes);
                        ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'product_title',
                            'id' => 'product_title',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['product_title'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Product Title<span style="color:red">*</span></button>
                                    </div>
                            <?php echo form_input($data); ?>
                            
                            </div>
                        </div>
                        
                       <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'navision_no',
                            'id' => 'navision_no',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['navision_no'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Navision Number<span style="color:red">*</span></button>
                                    </div>
                            <?php echo form_input($data); ?>
                            
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'brand_name',
                            'id' => 'brand_name',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['brand_name'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Brand Name<span style="color:red">*</span></button>
                                    </div>
                            <?php echo form_input($data); ?>
                            
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'channel',
                            'id' => 'channel',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['channel'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Product Channel <span style="color:red">*</span></button>
                                    </div>
                            <?php echo form_input($data); ?>
                            
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'shelf_life',
                            'id' => 'shelf_life',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['shelf_life'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Shelf Life <span style="color:red">*</span></button>
                                    </div>
                            <?php echo form_input($data); ?>
                            
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                            <?php
                            $data = array(
                            'name' => 'packaging_type',
                            'id' => 'packaging_type',
                            'class' => 'form-control validatefield',
                            'type' => 'text',
                            'required' => 'required',
                            'aria-label' => '',
                            'aria-describedby'=>"basic-addon1",
                            'value' => $news['packaging_type'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>                   
                            <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Packaging Type <span style="color:red">*</span></button>
                                    </div>
                            <?php echo form_input($data); ?>
                            
                            </div>
                        </div>
<!--                         <div class="col-sm-6">
                            <div class="input-group mb-3">
                            <?php if(!isset($groups)) $groups = array();
                                if(!isset($users['second_group'])) $users['second_group'] = ""; ?>
                                <input type="hidden" name="previous_secondry" value="<?=$users['second_group']?>">
                                <?php $options = array('' => 'Select')+$groups ;
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Program Type<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_dropdown('second_group', $options, $users['second_group'],  'class="custom-select" id="sec_grp"'); ?>
                            </div>
                        </div> -->
                         <div class="col-sm-6">
                            <div class="input-group mb-3">
                                <?php
                                $storage_type = array('Refrigerated'=>'Refrigerated','Frozen'=>'Frozen');
                                $options = array('Refrigerated' => 'Refrigerated')+$storage_type ;
                                $attribute = array('class' => 'control-label col-md-4');?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Storage Type<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_dropdown('storage_type', $options, $news['storage_type'],  'class="form-control select2me validatefield" required="required" id="storage_type" tabindex ="12"'); ?>
                              
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Program Type<span style="color:red">*</span></button>
                                </div>
                                <select multiple="multiple" class="select-1 custom-select  program_type validatefield" id="inputGroupSelect03" name="program_type[]">
                                    <?php 
                                        if(!isset($program_type)) 
                                            $program_type = array();
                                        if(!isset($selected_program))
                                            $selected_program = array();
                                        if(!empty($program_type)) {
                                            foreach ($program_type as $pt_key => $pt):
                                                $checking = array_search($pt['program_id'], array_column($selected_program, 'ppt_program_id'));
                                                if($pt['program_status'] != 0 || is_numeric($checking)) { ?>
                                                <option value="<?=$pt['program_id']?>" <?php if(is_numeric($checking)) echo 'selected="selected"'; ?>>
                                                    <?=$pt['program_name']?>
                                                </option>
                                                <?php }
                                            endforeach;
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>


                        
                    
                    </div>
               
                <div class="row section-box" style="box-shadow:none;">
                   <fieldset  class="col-sm-12" >
                      <legend>Fixed Attributes</legend>
                   </fieldset>
                     <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'unit_weight',
                                    'id' => 'unit_weight',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['unit_weight'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Min Unit Weight (oz)<span style="color:red">*</span></button>
                                    </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>

                   		<div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'max_unitweight',
                                    'id' => 'max_unitweight',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['max_unitweight'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Max Unit Weight (oz)<span style="color:red">*</span></button>
                                    </div>
                                    <?php echo form_input($data); ?>
                            </div>
                         </div>
                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'machine_number',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['machine_number'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Machine Number<span style="color:red">*</span></button>
                                    </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'whole_weight',
                                    'id' => 'whole_weight',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['whole_weight'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                 <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Whole Weight<span style="color:red">*</span></button>
                                    </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>



                       


                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'dough_weight',
                                    'id' => 'dough_weight',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['dough_weight'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Dough Weight<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'filling_weight',
                                    'id' => 'filling_weight',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['filling_weight'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Filling Weight<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'filling_percentage',
                                    'id' => 'filling_percentage',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['filling_percentage'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Filling Percentage<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'shape',
                                    'id' => 'shape',
                                    'class' => 'form-control validatefield',
                                    'value' => $news['shape'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Product Shape<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                  </div>
                <div class="row rap_clone section-box" >
                <fieldset class="col-sm-12">
                   <legend> Range Attributes</legend>
                </fieldset>
                    <?php if(isset($product_attribute) && !empty($product_attribute)){
                        foreach($product_attribute as $value){ ?>
                    <div class="input_fields_wrap " style="display: contents;width:100%">
                      <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'attribute_name[]',
                                    'class' => 'form-control validatefield',
                                    'value' => $value['attribute_name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Attribute Name <span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>



                          <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'min_value[]',
                                    'class' => 'form-control validatefield',
                                    'value' => $value['min_value'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Min value<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                          <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'target_val[]',
                                    'class' => 'form-control validatefield',
                                    'value' => $value['target_value'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Target value<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                          <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'max_value[]',
                                    'class' => 'form-control validatefield',
                                    'value' => $value['max_value'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Max value<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <i class="fa fa-times delete_record cross-icon" rel="<?php echo $value['id'];?>" rel_product="<?php echo $value['product_id'];?>" style="float:left;"></i>
                    </div>
                    <?}}else{?>
                    <div class="input_fields_wrap " style="display: contents; width:100%;">
                      <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'attribute_name[]',
                                    'class' => 'form-control validatefield',
                                    'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Attribute Name<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                          <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'min_value[]',
                                    'class' => 'form-control validatefield',
                                    'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Min value<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                          <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'target_val[]',
                                    'class' => 'form-control validatefield',
                                     'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                 <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Target value<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                          <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'max_value[]',
                                    'class' => 'form-control validatefield',
                                    'value' => '',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-type'=>"integer",
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Max value<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                    </div>
                    <?}?>
                </div>
                <br>
                <div>
                    <button class="add_field_button btn btn-outline-primary" style="float:right;margin-right: 30px;">Add Attribute</button>
                </div>
                <br>
                <div class="">
                <fieldset class="col-sm-12">
                   <legend> Wip Profile</legend>
                </fieldset>
                    <div class="col-sm-6" style="clear: both !important;">
                        <div class="input-group  mb-3">
                        <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Wip Product<span style="color:red">*</span></button>
                                </div>
                            <select  multiple="multiple" class="select-1 form-control product_select " name="navigation_select[]">
                                <?php
                                    if(!isset($all_navigation) || empty($all_navigation))
                                        $all_navigation = array();
                                    if(!empty($all_navigation)) {
                                        if(!isset($selected_navigation) || empty($selected_navigation))
                                            $selected_navigation = array();
                                        foreach ($all_navigation as $key => $an):
                                            $checking = array_search($an['navision_number'], array_column($selected_navigation, 'navision_number'));
                                            if(is_numeric($checking) || $an['status'] == '1') { ?>
                                                <option <?php if(is_numeric($checking)) echo 'selected="selected"'; ?> value="<?=$an['navision_number']?>">
                                                    <?=$an['navision_number']?>
                                                </option>
                                            <?php }
                                        endforeach;
                                    }?>
                            </select>
                        </div>
                    </div>
                </div>





                <!-- <div class="col-sm-6">
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
                        </div> -->



                <br>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-outline-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>">
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


<script>

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });



</script>
<script type="text/javascript">
    $(document).ready(function() {
    var max_fields      = 5;
    var wrapper         = $(".input_fields_wrap");
    var add_button      = $(".add_field_button");
    
    var x = 1;
    
    hyTy = '<div class="input_fields_wrap" style=" display:contents;width:100%;"><i class="simple-icon-close clone-remover cross-icon col-md-12" style="font-size: 24px;float: right;padding: 1%;"></i><div class="col-sm-6"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Attribute Name<span style="color:red">*</span></button> </div><input type="text" name="attribute_name[]" value="" id="attribute_name" class="form-control validatefield" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div><div class="col-sm-6"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Min value<span style="color:red">*</span></button> </div><input type="text" name="min_value[]" value=""  class="form-control validatefield" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div><div class="col-sm-6"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Target value<span style="color:red">*</span></button> </div><input type="text" name="target_val[]" value=""  class="form-control validatefield" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div><div class="col-sm-6"> <div class="input-group mb-3"> <div class="input-group-prepend"> <button class="btn btn-outline-secondary" type="button">Max value<span style="color:red">*</span></button> </div><input type="text" name="max_value[]" value=""  class="form-control validatefield" required="required" data-parsley-type="integer" data-parsley-maxlength="100"> </div></div></div>';
    $(add_button).click(function(e){
        e.preventDefault();
             $('.rap_clone').append(hyTy);
             if($('.input_fields_wrap').length == 1){ 
                
                $('.wrapclone').find('.chosen-container').remove();
               
             } else {
                $(".wrapclone:last-child").find('.chosen-container').remove();
             }
            
             $('.chosen-select').chosen();
             $('.clone-remover').on("click", function(e){
                $(this).parent().remove();
            })
    });
    
    $('.clone-remover').on("click", function(e){

        e.preventDefault();  
        $(this).parent().remove();
         x--;
    })
    return false;
});

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                var productid = $(this).attr('rel_product');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Product's attribute?",
                text : "You will not be able to recover this Attribute!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                        $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>product/delete_attributes",
                            data: {'id': id,'productid':productid},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "Attribute has been deleted.", "success");
              });

            });
    $(document).off('click', '.submited_form').on('click', '.submited_form', function(e){
        e.preventDefault();
        if(validateForm()) {
            $('#form_sample_1').submit();
        } else {
          //console.log('');
          return false;
        }
    });
    function validateForm() {
        var isValid = true;
        $('.validatefield').each(function(){
          if($(this).val() === '' || $(this).val() == null){
          
            $(this).css("border", "1px solid red");
            isValid = false;
          } else {
            $(this).css("border", "1px solid #28a745");
          }
        });
        var program_select = $('.program_type').val();
        if(program_select == '' || program_select == null || program_select == 'undefined' ) {
            isValid = false;
            $('.program_type').parent().find('.chosen-choices').addClass('red_class');
        }
        else
            $('.program_type').parent().find('.chosen-choices').removeClass('red_class');
    
        return isValid;
    
    }
</script>