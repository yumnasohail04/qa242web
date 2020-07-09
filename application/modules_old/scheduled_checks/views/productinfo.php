<div class="row_add row">
   <div class="col-sm-5">
      <div class="form-group">
         <?php 
          if(!isset($shape))
            $shape="";
            $data = array(
                'name' => 'shape',
                'id' => 'navision_no',
                'class' => 'form-control',
                'value' => $shape,
                'type' => 'text',
                'required' => 'required',
                'data-parsley-maxlength'=>TEXT_BOX_RANGE
            );
            $attribute = array('class' => 'control-label col-md-4');
            ?>
         <?php echo form_label('Shape <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
         <div class="col-md-8">
            <?php echo form_input($data); ?>
         </div>
      </div>
   </div>
   <div class="col-sm-5">
      <div class="form-group">
         <?php
         if(!isset($unit_weight))
            $unit_weight="";
            $data = array(
                'name' => 'unit_weight',
                'id' => 'unit_weight',
                'class' => 'form-control',
                'value' =>   $unit_weight,
                'type' => 'text',
                'required' => 'required',
                'data-parsley-maxlength'=>TEXT_BOX_RANGE
            );
            $attribute = array('class' => 'control-label col-md-4');
            ?>
         <?php echo form_label('Unit weight <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
         <div class="col-md-8">
            <?php echo form_input($data); ?>
         </div>
      </div>
   </div>
   <br>
    <?php if(isset($product_attribute) && !empty($product_attribute)){?>
   <div class="attribute_form">
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
              
                 <?php foreach($product_attribute as $value){?>
               <tr>
                  <td>
                     <div class="form-group">
                        <?php
                           $products=array();
                            $products[$value['id']]=$value['attribute_name'];
                              if(!isset($news['group'])) $news['group'] = ""; ?>
                        <?php $options =$products ;?>
                        <div class="col-md-10">
                           <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8"'); ?>
                        </div>
                     </div>
                  </td>
                  <td>
                     <div class="form-group">
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
                     </div>
                  </td>
                  <td>
                     <div class="form-group">
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
                     </div>
                  </td>
                  <td>
                     <div class="form-group">
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
                     </div>
                  </td>
               </tr>
               <?}}?>
            </tbody>
         </table>
         <br>
        
         
      </div>
       <div class="">
             <span style="color:red;font-size:20px;">Note*: </span><span>If you want to change these values,please do from the product form</span>
         </div>
   </div>
   <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
</div>
