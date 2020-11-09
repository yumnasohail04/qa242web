<div class="section-box attr-chose">
                                                                                       
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
                                        <th   >Attribute Name</th>
                                        <th   >Choice Type</th>
                                        
                                        <!--<th  >Possible Value</th>-->
                                        <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody>
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
                 <input type="hidden" class="choice_type" name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuess['possible_answers'])) ?>">
              <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />    
                                    
             <?php if($datacheck==false){?>
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-plus  pull-right addto_attribute"  data-org_id="0" data-outlet_id="0" style="margin-left: 20px;" onclick="myfunction(this)" title=" Add this attribute to check"></i>              </div>
                   
                   
            </div></td> <?}?>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
                                   <h4>Fixed attributes:</h4>
 <table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        
                                        <th  ></th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody>
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
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8"'); ?>
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
                 <input type="hidden"  name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuerrr['possible_answers'])) ?>">
             <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />                 
                                    
              <?php if($datacheck==false){?>
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-plus  pull-right addto_attribute"  data-org_id="0" data-outlet_id="0" style="margin-left: 20px;" title=" Add this attribute to check"></i>              </div>
                   
                   
            </div></td> <?}?>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
 <h4>Range attributes:</h4>
<table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        <th  >Min</th>
                                        <th  >Target</th>
                                        <th style="display:none;"></th>
                                        <th  >Max</th>
                                        <!--<th  >Possible Value</th>-->
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                             
                                        foreach($master_attributes as $valuettt){ 
                                        
                                        if($valuettt['attribute_type']=='Range'){?>
                                      <tr>
                                        <td style="width:35%;!important"> <div class="form-group">

            <?php
             $products=array();
             $products[$valuettt['id']]=$valuettt['attribute_name'];
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
                      'value' => $valuettt['attribute_type'],
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
              
               <div   class="col-md-8 " <?php if($valuettt['attribute_type']=="Choice" || $valuettt['attribute_type']=="Fixed") echo ' style="display:none;"';else echo 'style="width:100%;"'?>>
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                                        <td><div class="form-group">
               <?php
                if($valuettt['attribute_type']=="Choice")
               $value['target']='N/A';
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
           
               <div class="col-md-8" <?php if($valuettt['attribute_type']=="Choice"|| $valuettt['attribute_type']=="Fixed") echo ' style="display:none;" ' ;else echo 'style="width:100%;"'?>>
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
           
               <div class="col-md-8" <?php if($valuettt['attribute_type']=="Choice"|| $valuettt['attribute_type']=="Fixed") echo ' style="display:none;"';else echo 'style="width:100%;"'?> >
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
             <?php if($datacheck==false){?>
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-plus  pull-right addto_attribute"  data-org_id="0" data-outlet_id="0" style="margin-left: 20px;"  title=" Add this attribute to check"></i>              </div>
                   
                   
            </div></td> <?}?>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>

                                  <h4>Date attributes:</h4>
                              <table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th  style="width:100%;"   >Attribute Name</th>
                                        
                                        <th  ></th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                        foreach($master_attributes as $valuerrr){
                                            
                                        if($valuerrr['attribute_type']=='Date' ){?>
                                      <tr>
                                        <td style="width:35%;!important"> <div class="form-group">

            <?php
             $products=array();
             $products[$valuerrr['id']]=$valuerrr['attribute_name'];
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
                <td><h5>User will be asked to provide Date</h5></td>
                 <input type="hidden"  name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuerrr['possible_answers'])) ?>">
             <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />                 
                                    
              <?php if($datacheck==false){?>
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-plus  pull-right addto_attribute"  data-org_id="0" data-outlet_id="0" style="margin-left: 20px;" title=" Add this attribute to check"></i>              </div>
                   
                   
            </div></td> <?}?>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>

                                  <h4>DateTime attributes:</h4>
                                    <table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th   style="width:100%;"  >Attribute Name</th>
                                        
                                        <th  ></th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                        foreach($master_attributes as $valuerrr){
                                            
                                        if($valuerrr['attribute_type']=='DateTime' ){?>
                                      <tr>
                                        <td style="width:35%;!important"> <div class="form-group">

            <?php
             $products=array();
             $products[$valuerrr['id']]=$valuerrr['attribute_name'];
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
                <td><h5>User will be asked to provide DateTime</h5></td>
                 <input type="hidden"  name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuerrr['possible_answers'])) ?>">
             <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />                 
                                    
              <?php if($datacheck==false){?>
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-plus  pull-right addto_attribute"  data-org_id="0" data-outlet_id="0" style="margin-left: 20px;" title=" Add this attribute to check"></i>              </div>
                   
                   
            </div></td> <?}?>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
                                  <h4>Time attributes:</h4>
                                 <table class="table table-responsive  table-bordered table-striped mb-0" style="color: black !important;">
                                    <thead>
                                      <tr>
                                        <th  style="width:100%;" >Attribute Name</th>
                                        
                                        <th  ></th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                        foreach($master_attributes as $valuerrr){
                                            
                                        if($valuerrr['attribute_type']=='Time' ){?>
                                      <tr>
                                        <td style="width:35%;!important"> <div class="form-group">

            <?php
             $products=array();
             $products[$valuerrr['id']]=$valuerrr['attribute_name'];
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
                <td><h5>User will be asked to provide Time</h5></td>
                 <input type="hidden"  name="possible_answers[]" value="<?=strtolower( str_replace(',', '/',$valuerrr['possible_answers'])) ?>">
             <input type="hidden" name="min_value[]" value="" />
              <input type="hidden" name="max_value[]" value="" />
               <input type="hidden" name="target_val[]" value="" />                 
                                    
              <?php if($datacheck==false){?>
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-plus  pull-right addto_attribute"  data-org_id="0" data-outlet_id="0" style="margin-left: 20px;" title=" Add this attribute to check"></i>              </div>
                   
                   
            </div></td> <?}?>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>             
                    </div>

  </div>

</div>