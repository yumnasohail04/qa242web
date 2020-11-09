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
<input type="hidden" value="<?php  echo $this->uri->segment('4'); ?>" id="check_id">
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
 <table class="table table-bordered mb-0">
                                    <thead>
                                      <tr>
                                        <th>Attribute Name</th>
                                        <th>Choice Type</th>
                                        <th>Dependent on</th>
                                        <th style="width:10%;">Order</th>
                                        <!--<th  >Possible Value</th>-->
                                        <?php  if($datacheck==false){?>
                                        <th  ></th><?}?> 
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
            </div>
            </td>
                <td style="width:30%;" ><?=strtolower( str_replace(',', '/',$valuess['possible_answers'])) ?></td>
                <td style="padding-top: 0px; width: 20%;">
                  <select class="form-control dependent_attributes " id="dependent_attributes" attr_id="<?php if(isset($valuess['question_id'])) echo $valuess['question_id'];else echo '0';?>" >
                  <?php   $res = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$valuess['question_id']), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','parent_id','1','0')->row();
                          if(!empty($res) && $res->parent_id!="0"){
                          $res_val = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$res->parent_id), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question','1','0')->row(); ?>
                  <option default><?php echo $res_val->question ?></option>
                          <?php  } ?>
                  </select>
                </td>
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
                  <?php echo form_dropdown('page_rank[]', $options, $valuess['page_rank'], 'class = "form-control chosen-selects" id = "rank" attr_id="'.$valuess['question_id'].'"'); ?>
                </div>
              </div>
                                        
            </td>                    
            
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-close  pull-right remove_attribute"   attr_id="<?php if(isset($valuess['question_id']) ) echo $valuess['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td>
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
                                   <h4>Fixed attributes:</h4>
 <table class="table table-bordered mb-0">
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        
                                        <th  ></th>
                                        <th   >Dependent on</th>
                                         <th style="width:10%;" >Order</th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
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
                <td style="width:30%;"><h5>User will be asked to provide a text input</h5></td>
                <td style="padding-top: 0px; width: 20%;">
                  <select class="form-control dependent_attributes " id="dependent_attributes" attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" >
                  <?php   $res = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$valuerrr['question_id']), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','parent_id','1','0')->row();
                          if(!empty($res) && $res->parent_id!="0"){
                            $res_val = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$res->parent_id), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question','1','0')->row(); ?>
                            <option default><?php echo $res_val->question ?></option>
                  <?php  } ?>
                  </select>
                </td>
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
                  <?php echo form_dropdown('page_rank[]', $options,$valuerrr['page_rank'], 'class = "form-control chosen-selects" id = "rank" attr_id="'.$valuerrr['question_id'].'"'); ?>
                </div>
              </div>
                                        
            </td>                          
             
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-close  pull-right remove_attribute"   attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td> 
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
               <h4>Range attributes:</h4>
                <table class="table table-bordered mb-0">
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        <th   >Dependent on</th>
                                        <th style="width:12%;">Min</th>
                                        <th style="width:12%;">Target</th>
                                        <th style="display:none;width:15%;"></th>
                                        <th style="width:12%;">Max</th>
                                        <th style="width:15%;">Order</th>
                                        <!--<th  >Possible Value</th>-->
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody  id="range_table">
                                         <?php if(isset($master_attributes) && !empty($master_attributes)){
                                             
                                        foreach($master_attributes as $valuettt){ 
                                        
                                        if($valuettt['attribute_type']=='Range'){?>
                                      <tr>
                                        <td> <div class="form-group">

            <?php
             $products=array();
             $products[$valuettt['id']]=$valuettt['attribute_name'];
               if(!isset($news['group'])) $news['group'] = ""; ?>
            <?php $options =$products ;?>
          
            <div class="col-md-12" >
               <?php echo form_dropdown('attribute_name[]', $options, $news['group'],  'class="form-control select2me required validatefield" id="product_id" tabindex ="8" '); ?>
            </div>
         </div></td>
         <td style="padding-top: 0px; width: 20%;">
                  <select  class="form-control dependent_attributes " id="dependent_attributes" attr_id="<?php if(isset($valuettt['question_id']) ) echo $valuettt['question_id'];else echo '0';?>" >
                  <?php   $res = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$valuettt['question_id']), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','parent_id','1','0')->row();
                          if(!empty($res) && $res->parent_id!="0"){
                            $res_val = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$res->parent_id), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question','1','0')->row(); ?>
                            <option default><?php echo $res_val->question ?></option>
                  <?php  } ?>
                  </select>
                </td>
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
                  <?php echo form_dropdown('page_rank[]', $options, $valuettt['page_rank'], 'class = "form-control chosen-selects" id = "rank" attr_id="'.$valuettt['question_id'].'" '); ?>
                </div>
              </div>
                                        
            </td>     
             
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-close  pull-right remove_attribute"  attr_id="<?php if(isset($valuettt['question_id']) ) echo $valuettt['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td> 
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
    
    
      <h4>Date attributes:</h4>
 <table class="table table-bordered mb-0" >
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        
                                        <th  ></th>
                                        <th  >Dependent on</th>
                                         <th style="width:10%;" >Order</th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody  id="date_table">
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
                <td style="width:30%;"><h5>User will be asked to provide Date</h5></td>
                <td style="padding-top: 0px;width: 20%;">
                  <select  parent_id="<?php echo $res->parent_id ?>"  class="form-control dependent_attributes " id="dependent_attributes" attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" >
                  <?php   $res = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$valuerrr['question_id']), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','parent_id','1','0')->row();
                          if(!empty($res) && $res->parent_id!="0"){
                            $res_val = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$res->parent_id), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question','1','0')->row(); ?>
                            <option default><?php echo $res_val->question ?></option>
                  <?php  } ?>
                  </select>
                </td>
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
                  
                    <i  style="color:#ffc735;" class="simple-icon-close  pull-right remove_attribute"   attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td> 
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
    
                                <h4>DateTime attributes:</h4>
                                  <table class="table table-bordered mb-0" >
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        
                                        <th  ></th>
                                        <th  >Dependent on</th>
                                         <th  style="width:10%;" >Order</th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody  id="datetime_table">
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
                <td style="width:30%;"><h5>User will be asked to provide a Date and Time</h5></td>
                <td style="padding-top: 0px;width: 20%;">
                  <select  parent_id="<?php echo $res->parent_id ?>"   class="form-control dependent_attributes " id="dependent_attributes" attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" >
                  <?php   $res = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$valuerrr['question_id']), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','parent_id','1','0')->row();
                          if(!empty($res) &&  $res->parent_id!="0"){
                            $res_val = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$res->parent_id), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question','1','0')->row(); ?>
                            <option default><?php echo $res_val->question ?></option>
                  <?php  } ?>
                  </select>
                </td>
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
                  <?php echo form_dropdown('page_rank[]', $options,$valuerrr['page_rank'], 'class = "form-control chosen-selects" id = "rank" attr_id="'.$valuerrr['question_id'].'"'); ?>
                </div>
              </div>
                                        
            </td>                          
             
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-close  pull-right remove_attribute"   attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
            </div></td> 
                             
                                      </tr>
                                      <?}}}?>
                                     
                                    </tbody>
                                  </table>
      <h4>Time attributes:</h4>
 <table class="table table-bordered mb-0" >
                                    <thead>
                                      <tr>
                                        <th   >Attribute Name</th>
                                        
                                        <th  ></th>
                                        <th  >Dependent on</th>
                                         <th  style="width:10%;">Order</th>
                                       <?php if($datacheck==false){?>
                                        <th  ></th><?}?> 
                                      </tr>
                                    </thead>
                                    <tbody  id="time_table">
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
                <td style="width:30%;"><h5>User will be asked to provide time</h5></td>
                <td style="padding-top: 0px;width: 20%;">
                  <select  parent_id="<?php echo $res->parent_id ?>"  class="form-control dependent_attributes " id="dependent_attributes" attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" >
                  <?php   $res = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$valuerrr['question_id']), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','parent_id','1','0')->row();
                          if(!empty($res) &&  $res->parent_id!="0"){
                            $res_val = Modules::run('api/_get_specific_table_with_pagination',array('question_id'=>$res->parent_id), 'question_id desc',DEFAULT_OUTLET.'_checks_questions','question','1','0')->row(); ?>
                            <option default><?php echo $res_val->question ?></option>
                  <?php  } ?>
                  </select>
                </td>
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
                  <?php echo form_dropdown('page_rank[]', $options,$valuerrr['page_rank'], 'class = "form-control chosen-selects" id = "rank" attr_id="'.$valuerrr['question_id'].'"'); ?>
                </div>
              </div>
                                        
            </td>                          
             
            <td> <div class="form-group">
            <div class="col-md-8" style="width:100%;">
                  
                    <i  style="color:#ffc735;" class="simple-icon-close  pull-right remove_attribute"   attr_id="<?php if(isset($valuerrr['question_id']) ) echo $valuerrr['question_id'];else echo '0';?>" checkid="<?=$update_id?>" style="margin-left: 20px;" onclick="myfunction(this)" title="You can exclude this attribute from check"></i>              </div>
                   
                   
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
    $('.chosen-selects').on('change', function() {
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
var selection_arr=[];
var attr_array=[];
$(document).ready(function(){
  localStorage.clear();
  var check_id=$('#check_id').val();
  var subcat_id=$('#subcategory_id').val();
  $.ajax({
        type: 'POST',
        url: "<?=ADMIN_BASE_URL?>scheduled_checks/get_all_attributes",
        data: {'check_id': check_id,'cat_id':subcat_id},
        async: false,
        success: function(result) {
          attr_array=result;
        }
    });
});

function selection_code(){
  $('.dependent_attributes')
      .select2({
          minimumResultsForSearch: Infinity, 
          templateResult: formatState,
          templateSelection: formatState
    })
  .on('select2:opening', function() {
    $('.dependent_attributes').html('');
    attr_arr=JSON.parse(attr_array);
    var attr_id=$(this).parent().parent().find('#product_id').val();
    var parent_id=$(this).attr('parent_id');
    if(!parent_id)
    {
      var parent_id="0";
    }
    var selection_arr=JSON.parse(localStorage.getItem('selection_arr'))
    var opt = document.createElement('option');
    opt.value = '';
    opt.innerHTML = "";
    this.appendChild(opt);
    var opt = document.createElement('option');
    opt.value = '0';
    opt.innerHTML = "Select";
    this.appendChild(opt);
    if(selection_arr!=null){
      attr_arr.map((Item,index) => {
        if(Item.attribute_id!=attr_id){
              //index = selection_arr.findIndex(x => x.attr_id==Item.attribute_id);
              //if(index==-1){
                var opt = document.createElement('option');
                if(parent_id==Item.question_id)
                  opt.selected = "selected";
                opt.value = Item.attribute_id;
                opt.innerHTML = Item.question;
                this.appendChild(opt);
              //}
        }
      })  
    }else{
      attr_arr.map((Item,index) => {
        if(Item.attribute_id!=attr_id){
              var opt = document.createElement('option');
              if(parent_id==Item.question_id)
                opt.selected = "selected";
              opt.value = Item.attribute_id;
              opt.innerHTML = Item.question;
              this.appendChild(opt);
        }
      }) 
    }
  }).on('select2:select', function (event) {
    var selection = $(event.target).find(':selected').val();
    var question_id=$(event.target).attr('attr_id');
    $('option:selected', this).attr("selected", "selected");
    var selection_arr=JSON.parse(localStorage.getItem('selection_arr'));
    if(selection_arr!=null){
      index = selection_arr.findIndex(x => x.question_id==question_id);
      if(index != -1 ){
        selection_arr.splice(index,1);
      }
    }else{
      selection_arr=[];
    }
    if(selection!="0"){
      if(question_id=="0")
        question_id=selection+'_new';
      var arr={'attr_id':selection,'question_id':question_id};
      selection_arr.push(arr);
    }
      localStorage.setItem("selection_arr",JSON.stringify(selection_arr))
    
  });
}
selection_code();

function formatState (state) {
   if (!state.id) { return state.text; }
   var el = $(state.element);
   var available = el.data('available');
   var $state = $('<span'+(!available ? ' class="not-available"' : '')+'>'+state.element.text.toLowerCase()+'<span></span></span>');
   return $state;
};


// $('select')
//     .select2({
//          minimumResultsForSearch: Infinity, 
//          templateResult: formatState,
//          templateSelection: formatState
//    })
//    .on('select2:opening', function(event){
//       prevselection = $(event.target).find(':selected');
//       $('select').val(null);
//    })
//    .on('select2:select', function (event) {

//       var _selection = $(event.target).find(':selected');
//       var available = _selection.data('available');

//       if(available === false){
//          alert('ok')
//       }
//    }).on('select2:closing', function (event) {
//       if(prevselection != null && $(this).val() == null){
//          $(this).val($(prevselection).val())
//       }
//    });

</script>