<script src="<?php echo STATIC_FRONT_JS ?>custom-file-input.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>component.css" />
<?php include_once("select_box.php");?>
<style>
.inputfile + label {
    padding: unset;
}
.inputfile-4 + label figure {
    width: 50px;
    height: 50px;
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
.select2-container{
    width:100%!important;
}
.inputfile + label * {
    font-size: 11px;
    color: #000000;
    font-weight: 500;
}
</style>
<table class="table table-user-information table_doc table-striped">        
    <thead>
    <tr>
        <th >Product Information</th>
        <th >Check one or more(if applicable)</th>
        <th >Comments</th>
        <th >Supporting Attachment</th>
        <th >Supporting Attachment Expiration Date </th>
    </tr>
    </thead>
    <tbody>
        <?php 
            foreach($question as $keys => $value){ ?>
            <tr>
                <td><?php echo  $value['title']; ?></td>
                <td>
                <?php if($value['type']=="choice"){ ?>
                    <input type="radio" id="check_answer" name="answer_<?php echo $keys ?>" value="1">Yes
                    <input type="radio" id="check_answer" name="answer_<?php echo $keys ?>" value="0">No
                <?php }else if($value['type']=="date"){ ?>
                    <div class="input-group date mb-3 ">
                        <input type="text" class="form-control" id="" value="" >
                        <span class="input-group-text input-group-append input-group-addon">
                            <i class="simple-icon-clock"></i>
                        </span>
                    </div>
                <?php } else{
                    if(!empty($value['sub']))
                    if($value['selection']=="1"){?>
                        <select multiple="multiple" class=" select-1 form-control" name="" required="required">
                        <?php 
                                foreach ($value['sub'] as $attr => $at):?>
                                    <option value="<?=$at['id']?>" ><?=$at['option']?></option>
                                <?php  endforeach; ?>
                        </select>
                <?php  }else{ ?>
                    <select class="form-control" name="" required="required">
                        <?php 
                        foreach ($value['sub'] as $attr => $at):?>
                            <option value="<?=$at['id']?>" ><?=$at['option']?></option>
                        <?php  endforeach; ?>
                    </select>
                <?php  } } ?>
                </td>
                <td> <?php if($value['comment_box']==1){ ?>
                    <input type="text" name="" class="form-control comment_opt" placeholder="" value="">
                <?php  } ?></td>
                <td>
                <?php if($value['attachment']==1){?>
                    <div class="box">
                        <input type="file" data-doc-name="" name="" id="file" class=" file_load inputfile inputfile-4 tooltip" data-multiple-caption="{count} files selected" multiple />
                        <label  for="file"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span></span></label>
                    </div>
                <?php } ?>
                </td>
                <td>
                <?php if($value['expiry']==1){?>
                    <div class="input-group  mb-3 date">
                        <input type="text" class="form-control" id="" value="" >
                        <span class="input-group-text input-group-append input-group-addon">
                            <i class="simple-icon-clock"></i>
                        </span>
                    </div>
                <?php  } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>Inputselector()</script>