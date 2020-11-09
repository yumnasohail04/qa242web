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
.gif {
    background: url(https://clipartix.com/wp-content/uploads/2018/09/green-clipart-2018-24.png);
    width: 30px;
    height: 34px;
    background-size: contain;
}
</style>
            <main>
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-12">
                            <h1>  <?php 
                            if (empty($update_id)) 
                                        $strTitle = 'Add Supplier';
                                    else 
                                        $strTitle = 'Edit Supplier';
                                        echo $strTitle;
                                        ?></h1>
                            <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
                            <div class="separator mb-5"></div>
                        </div>
                        </div>
                    <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">
                        
                        </h5>
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'supplier/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'supplier/submit/' . $update_id, $attributes);
                        ?>
                 <div class="form-body section-box">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    <fieldset>
                            <legend>Supplier Detail</legend>
                        
                        </fieldset>
                    <div class="row">
                        
                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Name<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'supplier_no',
                                    'id' => 'supplier_no',
                                    'class' => 'form-control',
                                    'value' => $news['supplier_no'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Supplier Number<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Email<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'phone_no',
                                    'id' => 'phone_no',
                                    'class' => 'form-control',
                                    'value' => $news['phone_no'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Phone Number<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Address<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                         <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">City<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
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
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">State<span style="color:red">*</span></button>
                                </div>
                                    <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group  mb-3">
                                <?php
                                $data = array(
                                    'name' => 'country',
                                    'id' => 'country',
                                    'class' => 'form-control',
                                    'value' => $news['country'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Country<span style="color:red">*</span></button>
                                </div>
                                <?php echo form_input($data); ?>
                            </div>
                        </div>
                        <!-- <div class="col-sm-5">
                            <div class="form-group">
                            <label class="control-label col-md-4">Supplier Type<span class="required" style="color:#ff60a3">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control"  name="supplier_type" id="supplier_type">
                                        <?php foreach($supplier_types as $key => $value){?>
                                            <option  value="<?php echo $value['id'] ?>" 
                                            <?php  if($news['supplier_type']==$value['id']) echo "selected"; ?>
                                            ><?php echo $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <input type="hidden" id="supplier_type" value="<?php echo $news['supplier_type'] ?>" name="supplier_type">
                        </div>
                        <fieldset>
                            <legend>Documents</legend>
                        
                        </fieldset>
                        <div class=" row append_doc">
                            
                        </div>
                        <?php if(!empty($uploaded_doc)){?>
                        <legend> Uploaded Files</legend>
                            <div class="form-body">
                                <table id="datatable1" class="table table-bordered">
                                    <tbody class="table-body">
                                        <thead class="bg-th">
                                        <tr class="bg-col">
                                            <th>Document</th>
                                            <th>Expiration Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                     <?php 
                                     foreach($uploaded_doc as $key => $value){?>
                                      <tr class="bg-col">
                                          <td>
                                              <a href="<?php echo BASE_URL.SUPPLIER_DOCUMENTS_PATH.$value['document']; ?>" download <?php if($value['expiry_date']<= date('Y-m-d') ){?> style="color:red;"<?php }?>><?php echo $value['document']; ?></a>
                                          </td>
                                          <td <?php if($value['expiry_date']<= date('Y-m-d') ){?> style="color:red;"<?php }?>>
                                              <?php echo date("m-d-Y", strtotime($value['expiry_date'])); ?> 
                                          </td>
                                          <td>
                                              <p class="col-md-1" style="font-size: 15px; cursor:pointer;" id="delete_doc" data-doc-id="<?php echo $value['id']; ?>"><i class="simple-icon-close"></i></p>
                                          </td>
                                      </tr>
                                      <?php } ?>
                                  </tbody>
                                </table>
                            </div>
                        <?php } ?>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button  class="btn btn-outline-primary " id="submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'supplier'; ?>">
                        <button type="button" class="btn green btn-outline-primary " style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
              </div>
            </div>
          </div>
        </main>


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
                            url: "<?php echo ADMIN_BASE_URL?>supplier/delete_doc",
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


            $(document).on("change", "#supplier_type", function(event){
            event.preventDefault();
            supplier_data();
    });

    $(document).ready(function(){
      supplier_data();
    });
    function  supplier_data()
      {
        var supplier_type=$('#supplier_type').val();
            $('.append_doc').html('');
            if(supplier_type!="0"){
              $.ajax({
              type: 'POST',
              url: "<?php echo BASE_URL?>supplier/get_supplier_documents",
              data: {'supplier_type':supplier_type,'update_id':<?php echo $update_id ?>},
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
</script>