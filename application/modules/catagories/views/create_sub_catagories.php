


<main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1>  <?php
            $cat_name =  $this->uri->segment(5);
            $cat_name_sub =  $this->uri->segment(6);
            if (!empty($cat_name_sub)) {
              $cat_name =  $this->uri->segment(6);
              $strTitle = "Edit Check Type";
            }
            else
            {
                $strTitle = "Add Check Type";
            }
                    
                    echo $strTitle.'-'. '('.$cat_name.')';
                    ?> 
            </h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL.'catagories/manage_sub_catagories/'.$parent_id.'/'.$cat_name; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
        <div class="separator mb-5"></div>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="mb-4">
    
      </h5>
          <?php 
          $attributes = array('autocomplete' => 'off', 'id' => 'frmSubCatagories', 'class' => 'form-horizontal');
          if(empty($update_id)){
            $update_id = 0;
            $hidden = array('hdnParentId' => $parent_id);
          }
          else{
            if (!isset($catagories['is_active'])) {
              $catagories['is_active'] = '';
            }
            $hidden = array('hdnParentId' => $parent_id, 'hdnId' => $update_id,'hdnActive' => $catagories['is_active']); ////edit case
          }
          echo form_open_multipart(ADMIN_BASE_URL.'catagories/submit_sub_catagories/'.$parent_id.'/'.$update_id, $attributes, $hidden); ?>
                        
          <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                      <?php
                        $data = array(
                          'name' => 'txtCatName',
                          'id' => 'txtCatName',
                          'class' => 'form-control validate[required] text-input',
                          'value' => $catagories['cat_name'],
                          'required' => 'required',
                      );
                      $attribute = array('class' => 'control-label col-md-4');
                      ?>
                      <div class="input-group-prepend">
                          <button class="btn btn-outline-secondary" type="button">Check type name<span style="color:red">*</span></button>
                      </div>
                      <?php echo form_input($data); ?>
                  </div>
              </div>
              <!--<div class="col-md-5">
                  <div class="form-group">
                    <?php $attribute = array('class' => 'control-label col-md-4');
                      ?>
                      <?php echo form_label('Is product specific <span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                      <div class="col-md-8">
                          <select name="is_product" class="form-control is_product" required="required">
                            <option value="">--Select--</option>
                            <option value="Yes" <?php if($catagories['is_product']=="Yes") echo 'selected="selected"'?>>Yes</option>
                            <option value="No" <?php if($catagories['is_ingredients']=="No") echo 'selected="selected"'?>>No</option>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="col-md-5 is_ingredients" <?php if(
              $update_id ==0 || $catagories['is_product']=="No" ) echo 'style="display:none;" ';?>>
                  <div class="form-group">
                    <?php $attribute = array('class' => 'control-label col-md-4');
                      ?>
                      <?php echo form_label('Is ingredients specific <span class="red" style="color:red;">*</span>', 'txtCatName', $attribute); ?>
                      <div class="col-md-8">
                          <select name="is_ingredients" class="form-control select_ingredients" >
                            <option value="">--Select--</option>
                            <option value="Yes" <?php if($catagories['is_ingredients']=="Yes") echo 'selected="selected"'?>>Yes</option>
                            <option value="No" <?php if($catagories['is_ingredients']=="No") echo 'selected="selected"'?>>No</option>
                          </select>
                      </div>
                  </div>
              </div>-->
              </div>
              <div class="row">
                <div class="input-group" style="margin-top:3%;">
                  <button type="submit" class="btn btn-outline-success mb-1 buttonsubmit btnsave">Save</button>
                  <a href="<?php echo ADMIN_BASE_URL . 'catagories'; ?>"><button type="button" class="btn btn-outline-primary  mb-1">Cancel</button></a>
                </div>
              </div>
            <?php echo form_close(); ?> 
          </div>
        </div>
      </div>
    </main>

<script>

<?php
if (!empty($update_id)) {
    ?>
        $("#lstLanguage").css("pointer-events", "none");
        $("#lstLanguage").css("cursor", "default");
    <?php
        }
        ?>
    $(document).ready(function() {
        $("#catagories_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });

/*$('#rec_date').datepicker({
format: "<?php echo get_general_date_format();?>"
});

 $('.date-picker').datepicker({
    format: 'dd/mm/yyyy'
  });
*/

$('#txtCatName').keyup(function() {
   $('#txtPageUrl').val( $(this).val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'') );
});

</script>
<script type="text/javascript">
$(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".add_row");
        var add_button      = $(".color_field_button");

        var x = 1;
        var slect_option="";
        $(add_button).click(function(e){
            e.preventDefault();
            var f_val =vehicle ="";
            if(x== 1)
              f_val = $(this).parent().parent().prev().children(":first").children().find('.dropify-wrappe').val();
            else
              f_val = $(this).parent().parent().prev().children(":last").children(":last").children().find('.dropify-wrappe').val();
            if (f_val=='') {
            
                toastr.error("Fill the empty fields first");
                f_val='';
            }
            else {
 
                if(x < max_fields){
                    x++;

                    $(wrapper).append('<div > <div class="col-md-5"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-4">Attibute`Name <span class="red" style="color:red;">*</span></label> <div class="col-md-8"> <input type="text" name="attribute_name[]" value="" id="attribute_name" class="form-control validate[required] text-input dropify-wrappe" required="required"> </div></div></div><div class="col-md-5"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-4">Attibute`type<span class="red" style="color:red;">*</span></label> <div class="col-md-8"> <select name="attribute_type[]" class="form-control dropify-wrappe" required="required"> <option value="">--Select--</option> <option value="Range">Range</option> <option value="General">General</option> </select> </div></div></div><i class="fa fa-times  pull-right remove_img_div" style="margin-top:-11px;margin-right: 160px;" data-org_id="0" data-outlet_id="0"></i><br><br><br></div>');
                }
            }
            
        });

        $(wrapper).on("click",".remove_img_div", function(e){
            e.preventDefault(); $(this).parent().remove(); 
            x--;
        })
        
    });

/////////////////////////////////
  $(document).ready(function() {
        var max_fields      = 100;
        var wrapper         = $(".add_answers");
        var add_button      = $(".color_field_");

        var x = 1;
        var slect_option="";
        $(add_button).click(function(e){
            e.preventDefault();
            var f_val =vehicle ="";
            if(x== 1)
              f_val = $(this).parent().parent().prev().children(":first").children().find('.dropify-wrappe').val();
            else
              f_val = $(this).parent().parent().prev().children(":last").children(":last").children().find('.dropify-wrappe').val();
            if (f_val=='') {
            
                toastr.error("Fill the empty fields first");
                f_val='';
            }
            else {
 
                if(x < max_fields){
                    x++;

                    $(wrapper).append('<div > <div class="col-md-5"> <div class="form-group"> <label for="txtCatName" class="control-label col-md-4">Attibute`Name <span class="red" style="color:red;">*</span></label> <div class="col-md-8"> <input type="text" name="possible_answer[]" value="" id="attribute_name" class="form-control validate[required] text-input " required="required"> </div></div></div><div class="col-md-5"></div><i class="fa fa-times  pull-right remove_img_div" style="margin-top:-11px;margin-right: 160px;" data-org_id="0" data-outlet_id="0"></i><br><br><br></div>');
                }
            }
            
        });

        $(wrapper).on("click",".remove_img_div", function(e){
            e.preventDefault(); $(this).parent().remove(); 
            x--;
        })
        
    });
   
  </script>
  <script type="text/javascript">
       $(document).off('click', '.remove_img_div_click').on('click', '.remove_img_div_click', function(e){
                var org_id = $(this).attr('data-org_id');
                var outlet_id = $(this).attr('data-outlet_id');
                e.preventDefault();
                if((org_id!=0 || org_id!=null || org_id!=undefined) && (outlet_id!=0 || outlet_id!=null || outlet_id!=undefined) ){
              swal({
                title : "Are you sure to delete the selected Restuarant from this Organisation?",
                text : "You will not be able to recover this Restuarant!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },

                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo  ADMIN_BASE_URL?>organisations/delete_org_outlet",
                            data: {'org_id': org_id,'outlet_id':outlet_id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "organisation has been deleted.", "success");
              });
          }
            });


        $('.is_product').change(function(){
      $('.is_ingredients').attr('style','display:none');
      if($('.is_product').val() == 'Yes'){
         $('.is_ingredients').attr('style','display:block');
         $('.select_ingredients').attr('required','required');
         
      }else{
         $('.is_ingredients').attr('style','display:none');
         $('.select_ingredients').removeAttr('required');
      }
     
   })
  </script>

