<style>
    .my-custom-scrollbar {
position: relative;
height: 600px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

</style>
<?php $datacheck=false; function searchForId($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['attribute_type'] === $id) {
           return $key;
       }
   }
   return null;
}?>
<div class="attribute">
    <div class=" table-wrapper-scroll-y my-custom-scrollbar ">
    <h4>Choice  attributes:</h4>
 <table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th  style="color: black !important">Attribute Name</th>
                                        <th  style="color: black !important">Choice Type</th>
                                         <th style="color: black !important">Order</th>
                                        <!--<th style="color: black !important">Possible Value</th>-->
                                        <?php  if($datacheck==false){?>
                                        <th style="color: black !important"></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody id="choice_table">
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                        foreach($master_attributes as $valuess){
                                            
                                        if($valuess['attribute_type']=='Choice' ){?>
                                      <tr>
                                        <td style="width:35%;!important"> <div class="form-group">

            <?php
             $products=array();
             $products[$valuess['id']]=$valuess['attribute_name'];
               if(!isset($news['group'])) $news['group'] = ""; ?>
            <?php $options =$products ;?>
          
            <div class="col-md-12" >
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8"'); ?>
            </div>
         </div></td>
                 <td style="display:none;"><div class="form-group">
               <?php
                
               
                  $data = array(
                      'name' => 'attribute_type[]',
                      'id' => 'attribute_type',
                      'class' => 'form-control',
                      'value' => $valuess['attribute_type'],
                      'type' => 'text',
                       'readonly'=>true,
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
              
               <div class="col-md-8" style="width:100%;">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                <td><?=strtolower( str_replace(',', '/',$valuess['possible_answers'])) ?></td>
                 <input type="hidden" name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuess['possible_answers'])) ?>">
              <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />    
            <td>

              <div class="form-group">
                <?php
                $options = array('' => 'Select') + $rank;
                if(!isset($valuess['question_id']))
                $valuess['question_id']='0';
                ?>
                <div class="col-md-12" id="cities_cont">
                  <?php echo form_dropdown('page_rank[]', $options, $valuess['page_rank'], 'class = "form-control chosen-select" id = "rank" attr_id="'.$valuess['question_id'].'"'); ?>
                </div>
              </div>
                                        
            </td>                    
            
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="fa fa-times  pull-right remove_attribute"   attr_id="<?php if(isset($valuess['question_id']) && $valuess['question_id'] >0) echo $valuess['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
                                   <h4>Fixed attributes:</h4>
 <table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th  style="color: black !important">Attribute Name</th>
                                        
                                        <th style="color: black !important"></th>
                                         <th style="color: black !important">Order</th>
                                       <?php if($datacheck==false){?>
                                        <th style="color: black !important"></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody  id="fixed_table">
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                        foreach($master_attributes as $valuerrr){
                                            
                                        if($valuerrr['attribute_type']=='Fixed' ){?>
                                      <tr>
                                        <td style="width:35%;!important"> <div class="form-group">

            <?php
             $products=array();
             $products[$valuerrr['id']]=$valuerrr['attribute_name'];
               if(!isset($news['group'])) $news['group'] = ""; ?>
            <?php $options =$products ;?>
          
            <div class="col-md-12" >
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8" '); ?>
            </div>
         </div></td>
                 <td style="display:none;"><div class="form-group">
               <?php
                
               
                  $data = array(
                      'name' => 'attribute_type[]',
                      'id' => 'attribute_type',
                      'class' => 'form-control',
                      'value' => $valuerrr['attribute_type'],
                      'type' => 'text',
                       'readonly'=>true,
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
              
               <div class="col-md-8" style="width:100%;">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                <td><h5>User will be asked to provide a text input</h5></td>
                 <input type="hidden" name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuerrr['possible_answers'])) ?>">
             <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />                 
               <td>

              <div class="form-group">
                <?php
                $options = array('' => 'Select') + $rank;
                if(!isset($valuerrr['question_id']))
                $valuerrr['question_id']='0';
                ?>
                <div class="col-md-12" id="cities_cont">
                  <?php echo form_dropdown('page_rank[]', $options,$valuerrr['page_rank'], 'class = "form-control chosen-select" id = "rank" attr_id="'.$valuerrr['question_id'].'"'); ?>
                </div>
              </div>
                                        
            </td>                          
             
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="fa fa-times  pull-right remove_attribute"   attr_id="<?php if(isset($valuerrr['question_id']) && $valuerrr['question_id'] >0) echo $valuerrr['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td> 
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
 <h4>Range attributes:</h4>
<table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th  style="color: black !important">Attribute Name</th>
                                        <th style="color: black !important;width:15%;">Min</th>
                                        <th style="color: black !important;width:15%;">Target</th>
                                        <th style="display:none;width:15%;"></th>
                                        <th style="color: black !important;width:15%;">Max</th>
                                        <th style="color: black !important;width:15%;">Rank</th>
                                        <!--<th style="color: black !important">Possible Value</th>-->
                                       <?php if($datacheck==false){?>
                                        <th style="color: black !important"></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody  id="range_table">
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                             
                                        foreach($master_attributes as $valuettt){ 
                                        
                                        if($valuettt['attribute_type']=='Range'){?>
                                      <tr>
                                        <td > <div class="form-group">

            <?php
             $products=array();
             $products[$valuettt['id']]=$valuettt['attribute_name'];
               if(!isset($news['group'])) $news['group'] = ""; ?>
            <?php $options =$products ;?>
          
            <div class="col-md-12" >
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8" '); ?>
            </div>
         </div></td>
                 <td style="display:none;"><div class="form-group">
               <?php
                
               
                  $data = array(
                      'name' => 'attribute_type[]',
                      'id' => 'attribute_type',
                      'class' => 'form-control',
                      'value' => $valuettt['attribute_type'],
                      'type' => 'text',
                       'readonly'=>true,
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
              
               <div class="col-md-12" style="width:100%;">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                <td><div class="form-group">
               <?php
                if($valuettt['attribute_type']=="Choice")
               $valuettt['min']='N/A';
                  $data = array(
                      'name' => 'min_value[]',
                      'id' => 'min_value',
                      'class' => 'form-control',
                      'value' => $valuettt['min'],
                      'type' => 'text',
                      'required' => 'required',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
              
               <div   class="col-md-12 " <?php if($valuettt['attribute_type']=="Choice" || $valuettt['attribute_type']=="Fixed") echo ' style="display:none;"';else echo ''?>>
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                                        <td><div class="form-group">
               <?php
                if(!is_numeric($valuettt['target']) || !isset($valuettt['target']))
                  $valuettt['target'] = 0;
                  $data = array(
                      'name' => 'target_val[]',
                      'id' => 'target_val',
                      'class' => 'form-control',
                      'value' => $valuettt['target'],
                      'type' => 'text',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                  
                  ?>
           
               <div class="col-md-12" <?php if($valuettt['attribute_type']=="Choice"|| $valuettt['attribute_type']=="Fixed") echo ' style="display:none;" ' ;else echo ''?>>
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                                         <td> <div class="form-group">
               <?php
                if($valuettt['attribute_type']=="Choice")
               $valuettt['max']='N/A';
                  $data = array(
                      'name' => 'max_value[]',
                      'id' => 'max_value',
                      'class' => 'form-control',
                      'value' => $valuettt['max'],
                      'type' => 'text',
                      'placeholder'=>"Required",
                      
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
           
               <div class="col-md-12" <?php if($valuettt['attribute_type']=="Choice"|| $valuettt['attribute_type']=="Fixed") echo ' style="display:none;"';else echo ''?> >
                  <?php echo form_input($data); ?>
               </div>
            </div></td>

                                      <!--   <td> <div class="form-group">
               <?php
                if($valuettt['attribute_type']=="Range")
               $valuettt['possible_value']='N/A';
                  $data = array(
                      'name' => 'possible_value[]',
                      'id' => 'possible_value',
                      'class' => 'form-control',
                      'value' => $valuettt['possible_value'],
                      'type' => 'text',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
           
               <div class="col-md-8" <?php if($valuettt['attribute_type']=="Range") echo ' style="display:none;"';else echo 'style="width:100%;"'?>>
                  <?php echo form_input($data); ?>
               </div>
            </div></td>-->
              <input type="hidden" name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuettt['possible_answers'])) ?>">  
              <td>

              <div class="form-group">
                <?php
                $options = array('' => 'Select') + $rank;
                if(!isset($valuettt['question_id']))
                $valuettt['question_id']='0';
               ?>
                <div class="col-md-12" id="cities_cont">
                  <?php echo form_dropdown('page_rank[]', $options, $valuettt['page_rank'], 'class = "form-control chosen-select" id = "rank" attr_id="'.$valuettt['question_id'].'" '); ?>
                </div>
              </div>
                                        
            </td>     
             
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="fa fa-times  pull-right remove_attribute"  attr_id="<?php if(isset($valuettt['question_id']) && $valuettt['question_id'] >0) echo $valuettt['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td> 
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
                                  
                    </div>
                     <br><br>
           
                                       </div>
                                 </div>
  </div>
<script>
    $('.chosen-select').on('change', function() {
         var attr_id=$(this).attr('attr_id');
         var select_val=$(this).val();
         var checkid=<?=$update_id?>;
      
         if(attr_id >0 && checkid >0){
                 $.ajax({
                       type: 'POST',
                       url: "<?=ADMIN_BASE_URL?>product_checks/update_specific_attribute",
                       data: {'page_rank': select_val,'attr_id':attr_id,'checkid':checkid},
                       async: false,
                       success: function(test_body) {
                        
                        }
                   });
         }
});
</script>