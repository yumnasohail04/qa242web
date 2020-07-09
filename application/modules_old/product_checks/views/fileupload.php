
<div class="attribute">
 <table class="table " style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: black !important">Attribute</th>
                                        <th style="color: black !important">Min</th>
                                        <th style="color: black !important">Target</th>
                                        <th style="color: black !important">Max</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                         <?php if(isset($product_attribute) && !empty($product_attribute)){
                                        foreach($product_attribute as $value){?>
                                      <tr>
                                        <td> <div class="form-group">

            <?php
            $products=array();
             $products[$value['id']]=$value['attribute_name'];
               if(!isset($news['group'])) $news['group'] = ""; ?>
            <?php $options =$products ;?>
          
            <div class="col-md-10">
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8"'); ?>
            </div>
         </div></td>
                                        <td>  <div class="form-group">
               <?php
                  $data = array(
                      'name' => 'min_value[]',
                      'id' => 'min_value',
                      'class' => 'form-control',
                      'value' => $value['min_value'],
                      'type' => 'text',
                      'required' => 'required',
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
                  $data = array(
                      'name' => 'target_val[]',
                      'id' => 'target_val',
                      'class' => 'form-control',
                      'value' => $value['target_value'],
                      'type' => 'text',
                      'required' => 'required',
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
                  $data = array(
                      'name' => 'max_value[]',
                      'id' => 'max_value',
                      'class' => 'form-control',
                      'value' => $value['max_value'],
                      'type' => 'text',
                      'required' => 'required',
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
                              
  </div>