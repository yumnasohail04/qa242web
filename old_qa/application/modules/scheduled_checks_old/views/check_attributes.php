
<div class="attribute">
 <table class="table " style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: black !important">Attribute</th>
                                        <th style="color: black !important">Min</th>
                                        <th style="color: black !important">Target</th>
                                        <th style="display:none;"></th>
                                        <th style="color: black !important">Max</th>
                                        <th style="color: black !important">Possible Value</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                        foreach($master_attributes as $value){?>
                                      <tr>
                                        <td> <div class="form-group">

            <?php
             $products=array();
             $products[$value['id']]=$value['attribute_name'];
               if(!isset($news['group'])) $news['group'] = ""; ?>
            <?php $options =$products ;?>
          
            <div class="col-md-12">
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8"'); ?>
            </div>
         </div></td>
                 <td style="display:none;"><div class="form-group">
               <?php
                
               
                  $data = array(
                      'name' => 'attribute_type[]',
                      'id' => 'attribute_type',
                      'class' => 'form-control',
                      'value' => $value['attribute_type'],
                      'type' => 'text',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
              
               <div class="col-md-8">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                <td><div class="form-group">
               <?php
                if($value['attribute_type']=="Choice")
               $value['min']='N/A';
                  $data = array(
                      'name' => 'min_value[]',
                      'id' => 'min_value',
                      'class' => 'form-control',
                      'value' => $value['min'],
                      'type' => 'text',
                      'required' => 'required',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
              
               <div class="col-md-8">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                                        <td><div class="form-group">
               <?php
                if($value['attribute_type']=="Choice")
               $value['target']='N/A';
                  $data = array(
                      'name' => 'target_val[]',
                      'id' => 'target_val',
                      'class' => 'form-control',
                      'value' => $value['target'],
                      'type' => 'text',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                  
                  ?>
           
               <div class="col-md-8">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                                         <td> <div class="form-group">
               <?php
                if($value['attribute_type']=="Choice")
               $value['max']='N/A';
                  $data = array(
                      'name' => 'max_value[]',
                      'id' => 'max_value',
                      'class' => 'form-control',
                      'value' => $value['max'],
                      'type' => 'text',
                      'placeholder'=>"Required",
                      
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
           
               <div class="col-md-8">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>

                                         <td> <div class="form-group">
               <?php
                if($value['attribute_type']=="Range")
               $value['possible_value']='N/A';
                  $data = array(
                      'name' => 'possible_value[]',
                      'id' => 'possible_value',
                      'class' => 'form-control',
                      'value' => $value['possible_value'],
                      'type' => 'text',
                       'placeholder'=>"Required",
                      'data-parsley-type'=>"integer",
                      'data-parsley-maxlength'=>TEXT_BOX_RANGE
                  );
                 
                  ?>
           
               <div class="col-md-8">
                  <?php echo form_input($data); ?>
               </div>
            </div></td>
                                      </tr>
                                      <?}}?>
                                     
                                    </tbody>
                                  </table>
                                  <br><br>
           <div class="col-sm-12">
                                          <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                                        </div>
                                       </div>
                                 </div>
  </div>