<script src="<?php echo STATIC_FRONT_JS ?>custom-file-input.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>component.css" />
<?php include_once("select_box.php");?>
<style>
.inputfile + label {
    padding: unset;
}
.inputfile-4 + label figure {
    width: 40px;
    height: 40px;
    padding: 10px;
    margin: unset;
}
fieldset {
    border: none; 
    margin: unset; 
    padding: unset; 
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #d7d7d7!important;
}
td .select2-container{
    width:100%!important;
}
.inputfile + label * {
    font-size: 11px;
    color: #000000;
    font-weight: 500;
}

.showw
{
  box-shadow: 0 0 32px rgba(0,0,0,0.11);
  border-color:red;
}
.tooltiptext {
  visibility: visible;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;

  /* Position the tooltip */
  position: absolute;
  z-index: 1;
}
.tooltiptext-hide
{
  visibility: hidden;
}
td img
{
    width: 40px;
}
.tooltiptext-show
{
  visibility: visible;
}
</style>


<table class="table table-user-information table_doc table-striped">        
    <thead>
    <tr>
        <th >Product Information</th>
        <th >Check one or more(if applicable)</th>
        <th >Comments</th>
        <th style="width:10%">Supporting Attachment</th>
        <th style="width:10%">Uploaded Attachment</th>
        <th >Supporting Attachment Expiration Date </th>
    </tr>
    </thead>
    <tbody>
        <?php 
            foreach($question as $keys => $value){ ?>
            <tr>
                <td><?php echo  $value['title']; ?></td>
                <td data-type="<?php echo $value['type']; ?>" data-attachment="<?php echo $value['attachment']; ?>">
                <?php if($value['type']=="choice"){ 
                    if(isset($value['ans_options']) && !empty($value['ans_options'])){
                    foreach($value['ans_options'] as $a =>$ans_val):?>
                    <input type="radio" id="check_answer" name="options_<?php echo $keys ?>[]" value="1" <?php if($ans_val['option']=="1") echo "checked"; ?>>Yes
                    <input type="radio" id="check_answer" name="options_<?php echo $keys ?>[]" value="0" <?php if($ans_val['option']=="0") echo "checked"; ?>>No
                    <?php endforeach;
                    }else
                    { ?>
                        <input type="radio" id="check_answer" name="options_<?php echo $keys ?>[]" value="1" >Yes
                        <input type="radio" id="check_answer" name="options_<?php echo $keys ?>[]" value="0" >No
                    <?php }
                      }else if($value['type']=="date"){ 
                        if(isset($value['ans_options']) && !empty($value['ans_options'])){
                        foreach($value['ans_options'] as $a =>$ans_val): ?>
                    <div class="input-group  mb-3 date">
                        <input type="text" class="form-control" id="" value="<?php echo date('m/d/Y',strtotime($ans_val['option'])); ?>" name="options_<?php echo $keys ?>[]" >
                        <span class="input-group-text input-group-append input-group-addon">
                            <span class="simple-icon-calendar"></span>
                        </span>
                    </div>
                <?php endforeach;
                        }else{ ?>
                            <div class="input-group  mb-3 date">
                        <input type="text" class="form-control" id="" value="" name="options_<?php echo $keys ?>[]" >
                        <span class="input-group-text input-group-append input-group-addon">
                            <span class="simple-icon-calendar"></span>
                        </span>
                    </div>
                       <?php  }
                } else{
                    if(!empty($value['sub']))
                    if($value['selection']=="1"){?>
                        <select multiple="multiple" class=" select-1 form-control" name="options_<?php echo $keys ?>[]" required="required">
                        <?php 
                            foreach ($value['sub'] as $attr => $at):
                                if(isset($value['ans_options']) && !empty($value['ans_options'])){
                                    $select="";
                                foreach($value['ans_options'] as $a =>$ans_val):
                                    if($ans_val['option']==$at['id']) $select="selected"; 
                                endforeach; ?>
                                <option value="<?=$at['id']?>" <?php echo $select; ?> ><?=$at['option']?></option>
                            <?php  
                                }else{ ?>
                                    <option value="<?=$at['id']?>" ><?=$at['option']?></option>
                                <?php
                        } endforeach; ?>
                        </select>
                <?php  }else{ ?>
                    <select class="form-control" name="options_<?php echo $keys ?>[]" required="required">
                        <?php 
                        foreach ($value['sub'] as $attr => $at):
                            if(isset($value['ans_options']) && !empty($value['ans_options'])){
                                $select="";
                                foreach($value['ans_options'] as $a =>$ans_val):
                                    if($ans_val['option']==$at['id']) $select="selected"; 
                                endforeach; ?>
                                <option value="<?=$at['id']?>" <?php echo $select; ?> ><?=$at['option']?></option>
                        <?php  
                    }else{ ?>
                     <option value="<?=$at['id']?>" ><?=$at['option']?></option>
                    <?php }
                    endforeach; ?>
                    </select>
                <?php  } } ?>
                </td>
                <td> <?php if($value['comment_box']==1){ ?>
                    <input type="text" name="comment_box_<?php echo $keys ?>" class="form-control comment_opt" placeholder="" value="<?php if(isset($value['ans_comment']) && !empty($value['ans_comment'])) echo $value['ans_comment']; ?>" data-ctype="<?php echo $value['comment_type']; ?>" c_exist="<?php  if(isset($value['ans_comment']) && !empty($value['ans_comment'])) echo "1"; else echo "0"; ?>">
                <?php  } ?></td>
                <td>
                <?php if($value['attachment']==1){?>
                        <input type="file" data-doc-name="<?php echo  $value['title']; ?>" name="file_data_<?php echo $keys ?>" id="file_<?php echo $keys ?>" class=" file_load inputfile inputfile-4 tooltip" data-multiple-caption="{count} files selected"  />
                        <label  for="file_<?php echo $keys ?>"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span></span></label>
                    <span class="tooltiptext tooltiptext-hide">Upload File</span> 
                <?php } ?>
                </td>
                <td >
                    <?php if(isset($value['ans_document']) && !empty(['ans_document'])){ ?>
                        <a href="<?php echo BASE_URL.ACTUAL_ING_FORM_IMAGE_PATH.$value['ans_document']; ?>" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png'; ?>"  class="pdf-img"  rel-exist="1">
                    <?php }else { ?>
                        <img src="" class="pdf-img"  rel-exist="0">
                    <?php  } ?>
                </td>
                <td>
                <?php if($value['expiry']==1){?>
                    <div class="input-group  mb-3 date">
                        <input type="text" class="form-control"  value="<?php if(isset($value['ans_expiry']) && !empty($value['ans_expiry']) && $value['ans_expiry']!="0000-00-00") echo date('m/d/Y',strtotime($value['ans_expiry'])); ?>" name="expiry_<?php echo $keys ?>" >
                        <span class="input-group-text input-group-append input-group-addon">
                            <span class="simple-icon-calendar"></span>
                        </span>
                    </div>
                <?php  } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<button id="submited_ing_form" class="btn btn-sm btn-outline-primary" > Save</button>
<script>Inputselector()</script>