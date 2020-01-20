<div class="content-wrapper">

    <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body"> Widget settings form goes here </div>
                <div class="modal-footer">
                    <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
                    <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
                </div>
            </div>
        </div>
    </div>

    <h3>
    <?php
    if (empty($update_id)) 
		$strTitle = 'Add Webpage';
    else 
		$strTitle = 'Edit Webpage';
    echo $strTitle;
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'webpages'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    </h3>

    <div class="panel panel-default">
        <div class="panel-body">
        <?php 
        $attributes = array('autocomplete' => 'off', 'id' => 'frmWebpages');
        if(empty($update_id)){
            $update_id = 0;
        }
        echo form_open_multipart(ADMIN_BASE_URL.'webpages/submit/'.$update_id,$attributes); ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"> 
                <?php
                $data = array(
                'name'        => 'txtPageTitle',
                'maxlength'   => '30',
                'id'          => 'txtPageTitle',
                'class'     => 'form-control form-control1 text-input col-md-9',
                'value'       => $webpage['page_title'],
                'required'   => 'required',
                );
                $attribute = array('class' => 'control-label form-control1 col-md-4');
                echo form_label('Page Title <span class="required" style="color:red">*</span>','txtPageTitle', $attribute);
                echo '<div class="col-md-8" style="margin-bottom:15px;">'.form_input($data).'</div>';
                ?>

                <?php
                $data = array(
                'name'        => 'txtPageUrl',
                'id'          => 'txtPageUrl',
                'maxlength'   => '60',
                'class'     => 'form-control form-control1',
                'value'       => $webpage['url_slug'],
                'type' => 'text',
                'readonly' => 'readonly',
                );
                $attribute = array('class' => 'control-label form-control1 col-md-4');
                echo form_label('Page Slug ','txtPageUrl', $attribute);
                echo '<div class="col-md-8" style="margin-bottom:15px;">'.form_input($data).'</div>';
                ?>

                <?php
                $options = array(''=> 'Select') + $rank;
                $attribute = array('class' => 'control-label  col-md-4');
                echo form_label('Page Rank ','lstRank', $attribute);
                echo '<div class="col-md-8" style="margin-bottom:15px;">'.form_dropdown('lstRank', $options,$webpage['page_rank'], 'class = "form-control  form-control1 select2me " id = "lstRank"').'</div>';
                ?>

                 <?php
                    $options = $type;
                    $attribute = array('class' => 'control-label col-md-4');
                    echo form_label('Type', 'is_web_page', $attribute);?>
                    <div class="col-md-8" style="margin-bottom:15px;" ><?php echo form_dropdown('type', $options, $webpage['type'], 'class="form-control select2me" id="type"'); ?></div>

 <?php
                    $options = $app_type;
                    $attribute = array('class' => 'control-label col-md-4');
                    echo form_label('App Type', 'is_web_page', $attribute);?>
                    <div class="col-md-8" style="margin-bottom:15px;" ><?php echo form_dropdown('app_type', $options, $webpage['app_type'], 'class="form-control select2me" id="app_type"'); ?></div>


                </div>
<!-- /////////////////////////// Icon Start //////////////////////////////////-->
                
<!-- /////////////////////////// Icon End //////////////////////////////////-->
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtMetaDesc',
                'id' => 'maxlength_textarea',
                'rows' => '8',
                'cols' => '10',
                'class' => 'form-control note-editor',
                'value' => $webpage['meta_description']
                
                );
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Meta Description', 'txtMetaDesc', $attribute);
                ?>
                <div class="col-md-8"> <?php echo form_textarea($data); ?> </div>
                </div>    
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            <?php
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Icon', 'Icon', $attribute);
                ?>
                <div class="col-md-4">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <?
                            $filename = './uploads/web_pages/actual_images/' . $webpage['icon'];
                            if (isset($webpage['icon']) && !empty($webpage['icon']) && file_exists($filename)) {
                                ?>
                                <img src = "<?= base_url() .'uploads/web_pages/actual_images/' . $webpage['icon'] ?>" />
                                <?php
                            } else {
                                ?>
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                <?php
                            }
                            ?>

                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                        </div>
                        <div>
                            <span class="btn default btn-file">
                                <span class="fileupload-new">
                                    <i class="fa fa-paper-clip"></i> Select Image
                                </span>
                                <span class="fileupload-exists">
                                    <i class="fa fa-undo"></i> Change
                                </span>
                                <input type="file" name="icon" id="icon" class="default">
                                <input type="hidden" id="hdn_icon" value="<?= $webpage['icon'] ?>" name="hdn_icon">
                            </span>
                            <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                        </div>
                    </div>
                </div>
        </div>

            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'short_desc',
                'id' => 'short_desc',
                'rows' => '8',
                'cols' => '10',
                'class' => 'form-control note-editor',
                'value' => $webpage['short_desc']
                
                );
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Short Description', 'short_desc', $attribute);
                ?>
                <div class="col-md-8"> <?php echo form_textarea($data); ?> </div>
                </div>    
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <?php 
                $attribute = array('class' => 'control-label col-md-2');
                echo form_label('Long Description', 'txtPageCont', $attribute);
                ?>
                <div class="col-md-10"><textarea class="ckeditor form-control" name="txtPageCont" rows="10"><?php echo $webpage['page_content']?></textarea></div>
                </div>
            </div>
        </div>                                                                             
        
       <br/><div class="row">
            <div class="col-md-6">
            <div class="col-md-offset-4 col-md-10">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
            <a href="<?php echo ADMIN_BASE_URL . 'webpages'; ?>">
            <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
            </a>
            </div>
            </div>
        </div>

	    <?php echo form_close(); ?> 

        </div>
    </div>
</div>

<script>
$(document).ready(function() {

	$(document).off("keyup", "#txtPageTitle").on("keyup", "#txtPageTitle", function(event) {
		var page_title = $(this).val();
		$("#txtPageUrl").val(page_title.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''));
	});	

	$(document).off("focusout", "#txtPageTitle").on("focusout","#txtPageTitle", function(event) {
		event.preventDefault();
		var page_title = $(this).val();
		var id = <?=$update_id?>;
		$.ajax({
		type: 'POST',
		url: "<?= ADMIN_BASE_URL ?>webpages/check_page_title",
		data: {'page_title': page_title, 'id':id},
		async: false,
		success: function(result) {
			if(result == true){
				toastr.error('Webpage Title already exist.');
				$("#txtPageTitle").focus();
			}
		}
		});
	});	

    $("#icon").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_icon').val(replaced_val);
    });

    // $("#frmWebpages").on('submit', function(e){
    //     e.preventDefault();
    //     alert("<textarea>"+$(this).serialize()+"</textarea>");
    // });

});
</script>