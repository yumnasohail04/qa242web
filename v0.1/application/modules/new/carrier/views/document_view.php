
<thead>
    <tr>
      <th scope="col">Question</th>
      <th scope="col">Options</th>
      <th scope="col">Document Name</th>
      <th scope="col">Upload</th>
      <th scope="col">Uploaded Document</th>
      <th scope="col">Comment Box</th>
      <!-- <th scope="col">Reference Link</th> -->
    </tr>
  </thead>
<tbody>
        <?php 
            foreach($doc as $keys => $values){ ?>
            <tr data-id="<?php echo $values['id']; ?>">
                <?php if(!empty($values['sub_question'])) {  ?>
                    <td style="width:40%"><?php echo  $values['sub_question']->title; ?></td>
                    <td style="width:10%;margin-right: 3px;">
                        <input type="radio" id="check_answer" <?php if( $values['sub_ans']->option=="1") echo "checked";?>  name="answer_<?php echo $keys ?>" value="1">Yes
                        <input type="radio" id="check_answer" <?php if($values['sub_ans']->option=="0") echo "checked";?> name="answer_<?php echo $keys ?>" style="margin-left: 17px;margin-right: 3px;" value="0">No</td>
                <?php } else{?>
                    <td></td>
                    <td></td>
                <?php }?>
                <td style="display:none;"><input type="hidden" name="id_<?php echo $keys; ?>" value="<?php echo $values['id'] ?>"></td>
                <td style="width:10%"><span><?php echo $values['doc_name']; ?></span></td>
                <td >
                    <div class="box">
                        <input type="file" data-doc-name="<?php echo $values['doc_name']; ?>" name="news_main_page_file_<?php echo $keys; ?>[]" id="file-<?php echo $keys+1; ?>" class=" file_load inputfile inputfile-4 tooltip" data-multiple-caption="{count} files selected" multiple />
                        <label  for="file-<?php echo $keys+1; ?>"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span></span></label>
                    </div>
                    <span class="tooltiptext tooltiptext-hide">Upload File</span> 
                 <br> 
                </td>
                <td >
                <?php if(!empty($values['doc_uploaded'])){ ?>
                    <a><img class="pdf-img" src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a><br>
                    <?php foreach($values['doc_uploaded'] as $dc => $doc_list):?><br>
                    <div>
                        <span><a href="<?php echo BASE_URL.CARRIER_DOCUMENTS_PATH.$doc_list['document'];?>"  download ><?php echo $doc_list['document'] ?></a></span>
                        <span><i class="fa fa-close del_doc" del_id="<?php echo $doc_list['id'] ?>"></i></span>
                    </div>
                    <?php endforeach; ?>
                <?php }else{ ?>
                    <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>" class="pdf-img">
                <?php  
                } ?>
                </td>
                <?php 
                if(!empty($values['sub_question'])){
                    if($values['sub_question']->comment_box=="1"){?>
                        
                        <td ><input type="text" name="comment_<?php echo $keys; ?>" class="form-control comment_opt" placeholder="Comments Here..." value="<?php if(isset($values['sub_ans']->comment_box) && !empty($values['sub_ans']->comment_box)) echo $values['sub_ans']->comment_box;?>"></td>
                    <?php }else{ ?>
                        <td></td>
                    <?php }
                    }else{ ?>
                        <td></td>
                    <?php }
                     ?>
                <!-- <?php 
                    if(!empty($values['sub_question'])){
                        if($values['sub_question']->reference_link=="1"){?>
                            <td style="width: 15%;"><input type="text" name="reference_link_<?php echo $keys; ?>" class="form-control" placeholder="Reference Link..." value="<?php if(isset($values['sub_ans']->reference_link) && !empty($values['sub_ans']->reference_link)) echo $values['sub_ans']->reference_link;?>"></td>
                    <?php } else{ ?>
                        <td></td>
                    <?php }
                    }else{ ?>
                        <td></td>
                    <?php }
                     ?> -->
            </tr>
            
        <?php
        } ?>
    </tbody>
<script>Inputselector()</script>