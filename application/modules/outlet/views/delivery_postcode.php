<input type="hidden" id="hdnpostcode_outlet" value="<?=$update_id?>" >
<div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtpostcode',
                'id' => 'txtpostcode',
                'class' => 'form-control',
                'type' => 'text',
                'required' => 'required',
                'value' => $outlet['name']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Post Code <span class="required" style="color:red">*</span>', 'txtpostcode', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
            	<div class="form-group">
                <?php
                $data = array(
                'name' => 'txtDeliveryCost',
                'id' => 'txtDeliveryCost',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['url']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Delivery Charges ', 'txtDeliveryCost', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>  
        
        <div class="row" >
            <div class="col-md-12">
            <div class="col-md-offset-10 col-md-2">
            <button type="button" class="btn btn-primary" id="add_postcode" ><i class="fa fa-check"></i>&nbsp;Add</button>
            </div>
            </div>
        </div>
        
  <div class="row" id="postcode_list" style="margin-top:15px; padding-left:5px; padding-right:5px"  >
  <?php include_once('post_codelisting.php'); ?>
   </div>
