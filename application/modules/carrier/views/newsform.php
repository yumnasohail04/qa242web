<script src="<?php echo STATIC_FRONT_JS ?>custom-file-input.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>component.css" />
 
 <style type="text/css">
    .red_class {
        border: 1px solid red !important;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    {
        width:100%;
    }
    .btn-group.open .dropdown-toggle {
        background-color: transparent;
    }
    fieldset .form-group {
    margin-bottom: 15px;
}
.odd
{
    display:none;
}
.pdf-img
{
    width: 50%;
}
.gif {
    background: url(https://clipartix.com/wp-content/uploads/2018/09/green-clipart-2018-24.png);
    width: 30px;
    height: 34px;
    background-size: contain;
}.table > thead > tr > th {
    color: #81b1ef !important;
}
.active {
    color: #3c3c3c !important;
}
</style>

<div class="page-content-wrapper">
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
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
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
    <!-- /.modal --> 
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM--> 
    <!-- BEGIN PAGE HEADER-->
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Carrier';
                else 
                    $strTitle = 'Edit Carrier';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'carrier'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
       </h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="border-radius:10px;">
         
            <div class="tab-pane  active" id="tab_2" >
              <div class="portlet box green ">
                <div class="portlet-title ">
                 
                </div>
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'carrier/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'carrier/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body section-box">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                   
                    <div class="row">
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'name',
                                    'id' => 'first_name',
                                    'class' => 'form-control',
                                    'value' => $news['name'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Name <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'contact',
                                    'id' => 'contact',
                                    'class' => 'form-control',
                                    'value' => $news['contact'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Contact <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'email',
                                    'id' => 'email',
                                    'class' => 'form-control',
                                    'value' => $news['email'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Email<span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'phone',
                                    'id' => 'phone',
                                    'class' => 'form-control',
                                    'value' => $news['phone'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Phone Number<span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'address',
                                    'id' => 'address',
                                    'class' => 'form-control',
                                    'value' => $news['address'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Address<span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                         <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'city',
                                    'id' => 'city',
                                    'class' => 'form-control',
                                    'value' => $news['city'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('City <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'state',
                                    'id' => 'state',
                                    'class' => 'form-control',
                                    'value' => $news['state'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('State <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'zipcode',
                                    'id' => 'zipcode',
                                    'class' => 'form-control',
                                    'value' => $news['zipcode'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Zipcode <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>  
                        <div class="col-sm-5">
                            <div class="form-group">
                            <label class="control-label col-md-4">Type<span class="required" style="color:#ff60a3">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control"  name="type" id="carrier_type">
                                    <?php foreach($carrier_type as $key => $value){ ?>
                                        <option  value=<?php echo $value['id'] ?> <?php  if($value['id']==$news['type']) echo "selected"; ?>><?php echo $value['type'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="col-sm-12">
                            <table class="table table-user-information table_doc table-striped append_doc">
                            <thead>
                                <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Options</th>
                                <th scope="col">Document Name</th>
                                <th scope="col">Upload</th>
                                <th scope="col">Uploaded Document</th>
                                <th scope="col">Comment Box</th>
                                <th scope="col">Reference Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php 
                                        foreach($doc as $keys => $values){ ?>
                                        <tr data-id="<?php echo $values['id']; ?>">
                                            <?php if(!empty($values['sub_question'])) {  ?>
                                                <td><?php echo  $values['sub_question']->title; ?></td>
                                                <td style="width: 120px; margin-right: 3px;">
                                                    <input type="radio" id="check_answer" <?php if( $values['sub_ans']->option=="1") echo "checked";?>  name="answer_<?php echo $keys ?>" value="1">Yes
                                                    <input type="radio" id="check_answer" <?php if($values['sub_ans']->option=="0") echo "checked";?> name="answer_<?php echo $keys ?>" style="margin-left: 17px;margin-right: 3px;" value="0">No</td>
                                            <?php } else{?>
                                                <td></td>
                                                <td></td>
                                            <?php }?>
                                            <td style="display:none;"><input type="hidden" name="id_<?php echo $keys; ?>" value="<?php echo $values['id'] ?>"></td>
                                            <td><span><?php echo $values['doc_name']; ?></span></td>
                                            <td>
                                                <div class="box">
                                                    <input type="file" data-doc-name="<?php echo $values['doc_name']; ?>" name="news_main_page_file_<?php echo $keys; ?>" id="file-<?php echo $keys; ?>" class=" file_load inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                                                    <label  for="file-<?php echo $keys; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span style="font-size: 1rem;"></span></label>
                                                </div>
                                            </td>
                                            <td style="width:6%;">
                                            <?php if(!empty($values['doc_uploaded'])){ ?>
                                                <a href="<?php echo BASE_URL.CARRIER_DOCUMENTS_PATH.$values['doc_uploaded']->document;?>"  download><img class="pdf-img" src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a>
                                            <?php }else{ ?>
                                                <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>" class="pdf-img">
                                            <?php  
                                            } ?>
                                            </td>
                                            <?php 
                                            if(!empty($values['sub_question'])){
                                                if($values['sub_question']->comment_box=="1"){?>
                                                    
                                                    <td style="width: 15%;"><input type="text" name="comment_<?php echo $keys; ?>" class="form-control" placeholder="Comments Here..." value="<?php if(isset($values['sub_ans']->comment_box) && !empty($values['sub_ans']->comment_box)) echo $values['sub_ans']->comment_box;?>"></td>
                                                <?php }else{ ?>
                                                    <td></td>
                                                <?php }
                                                }else{ ?>
                                                    <td></td>
                                                <?php }
                                                ?>
                                            <?php 
                                                if(!empty($values['sub_question'])){
                                                    if($values['sub_question']->reference_link=="1"){?>
                                                        <td style="width: 15%;"><input type="text" name="reference_link_<?php echo $keys; ?>" class="form-control" placeholder="Reference Link..." value="<?php if(isset($values['sub_ans']->reference_link) && !empty($values['sub_ans']->reference_link)) echo $values['sub_ans']->reference_link;?>"></td>
                                                <?php } else{ ?>
                                                    <td></td>
                                                <?php }
                                                }else{ ?>
                                                    <td></td>
                                                <?php }
                                                ?>
                                        </tr>
                                        
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                       
                <div class="form-actions fluid no-mrg" style="margin-top: 3%;">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button  class="btn btn-primary " id="submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'carrier'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
                <!-- END FORM--> 
                
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>


<script>

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });

        $(document).off('click', '#delete_doc').on('click', '#delete_doc', function(e){
                var doc_id=$(this).attr("data-doc-id");
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Document?",
                text : "You will not be able to recover this Document!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>carrier/delete_doc",
                            data: {'doc_id': doc_id},
                            async: false,
                            success: function() {
                                location.reload();
                            }
                        });
                swal("Deleted!", "Document has been deleted.", "success");
              });

            });
            
            $(document).off('change', '#news_d_file').on('change', '#news_d_file', function(e){
                e.preventDefault();
                var str=$(this).val();
                var name=$(this).attr("data-doc-name").toLowerCase().replace(/\s/g, '');
                str=str.split("\\"); 
                str = str[str.length - 1];
                str = str.substring( 0, str.indexOf(".")).toLowerCase().replace(/\s/g, '');
                if(str!=name)
                {
                    toastr.error("Document and title name must be same");
                    $(this).val('')
                }else{
                    $(this).parent().parent().find('.tick').find('.addtick').addClass('gif')
                }
            });
            



            $(document).on("change", "#carrier_type", function(event){
            event.preventDefault();
            carrier_data();
    });

    $(document).ready(function(){
      carrier_data();
    });
    function  carrier_data()
      {
        var carrier_type=$('#carrier_type').val();
            $('.append_doc').html('');
            if(carrier_type!="0"){
              $.ajax({
              type: 'POST',
              url: "<?php echo BASE_URL?>carrier/get_carrier_documents",
              data: {'carrier_type':carrier_type,'update_id':<?php echo $update_id ?>},
              async: false,
              success: function(result) {
                  $('.append_doc').html(result);
              }
          });
        }
        $('.datetimepicker2').datetimepicker({
            icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-crosshairs',
            clear: 'fa fa-trash'
            },
            //viewMode: 'years',
            format:'MM/DD/YYYY'
        });
      }

      file_image_change();
function file_image_change(){
  $(document).off('change', '.file_load').on('change', '.file_load', function(e){
      e.preventDefault();
        $(this).parent().parent().parent().find('td').find('img').attr("src","<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>");
  });
}

$(document).off('click', '.#submited_form').on('click', '#submited_form', function(e){
                e.preventDefault();
                var valid="1";
                <?php foreach($doc as $key => $value){ ?>
                var vul=$("input[name=news_main_page_file_<?php echo $key?>]").val();
                var exp=$("input[name=expiry_date_<?php echo $key?>]").val();
                if(vul!=="")
                {
                    if(exp=="" || exp=="undefined")
                    {
                        valid=="0";
                        toastr.error("Please Provide Expiration date of the uploaded documents");
                        return false;
                    }
                }
                <?php } ?>
                if(valid="1")
                {
                    $( ".form-horizontal" ).submit();
                }
            });
</script>
