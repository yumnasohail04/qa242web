<style type="text/css">
	.red {
		border: 1px solid red !important;
	}
  .selectbox-class {
    background-color: white;
    color: #3a3f51;
  }
  .disable_class {
    display: none;
  }
</style>
<div class="page-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       <form method="post" id="submited_form" action="<?= ADMIN_BASE_URL.'global_configuration/submit_product_reschedule/';?>">
                            <div class="form-body"> 
                                <div class="row main_div">
                                   	<div class="col-sm-12 selecting_div">
                                        <div class="form-group row">
                                          <label class="col-sm-4 control-label">Product</label>
                                            <div class="col-sm-8">
                                               	<select   style="width: 100%!important;" id="selectboxing" class="selectpicker form-control"  data-show-subtext="true" data-live-search="true" name="product_name" required="required">
                                                  <option value="">Select</option>
                                                  <?php 
                                                    if(!isset($selected_product))
                                                      $selected_product ='';
                                                    if(isset($products) && !empty($products)) { foreach($products as $key=> $pro): ?>
                                                    <option  value="<?=$pro['id'];?>" <?php if($selected_product == $pro['id']) echo 'selected="selected"';?>  data-subtext="<?php if(isset($pro['navision_no']) && !empty($pro['navision_no'])) echo $pro['navision_no'];?>"><?=$pro['product_title'];?></option>
                                                   <?php endforeach; } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                  	<div class="col-sm-12 selecting_date">
                                    	<div class="form-group row">
                                      		<label class="col-sm-4 control-label">Start Date</label>
                                        	<div class="col-sm-8">
                                            <?php if(!isset($start_date))
                                                      $start_date =''; ?>
                                           		<div class='input-group date'>
			                                    	<input type='text' name="scheduledate" class="form-control scheduledate" id="startdate"  required="required" value="<?=$start_date;?>" />
			                                    	<span class="input-group-text input-group-append input-group-addon">
                                                  <i class="simple-icon-calendar"></i>
                                              </span>
			                                	</div>
                                          </div>
                                    	</div>
                                  	</div>
                                    <br><br>
                                    <div class="group_div" style="clear: both; padding-top: 10px; width:100%">
                                      <div class="col-sm-12">
                                          <div class="form-group row">
                                            <label class="col-sm-4 control-label">Plant</label>
                                            <div class="col-sm-8">
                                                <select  class="form-control plants_team validate_form" name="plants" required="required">
                                                  <option  value="">Select</option>
                                                  <?php
                                                  if(!isset($plant))
                                                    $plant = '';
                                                  if(!isset($get_plants) || empty($get_plants))
                                                    $get_plants = array();
                                                  foreach ($get_plants as $value): 
                                                  if($value['plant_status'] == '1' || $value['plant_id'] ==  $plant) { ?>
                                                      <option value="<?=$value['plant_id']?>" <?php if($plant == $value['plant_id']) echo 'selected="selected"';?>><?=$value['plant_name']?>
                                                      </option>
                                                  <?php } endforeach ?>
                                                </select>
                                            </div>
                                          </div>
                                      </div>
                                    </div>
                                    <br><br>
                                    <div class="group_line_div <?php if(!isset($line) || empty($line)) echo 'disable_class';?>" style="clear: both; padding-top: 10px; width:100%">
                                      <div class="col-sm-12">
                                      	<div class="form-group row">
                                        	<label class="col-sm-4 control-label">Line</label>
                                        	<div class="col-sm-8">
                                          		<select  class="form-control responsible_team validate_form" name="shift" required="required">
                                                <?php 
                                                  if(!empty($line) && !empty($get_lines)) {
                                                    foreach ($get_lines as $value): 
                                                      if($value['line_status'] == '1' || $value['line_id'] ==  $line) { ?>
                                                          <option value="<?=$value['line_id']?>" <?php if($line == $value['line_id']) echo 'selected="selected"';?>><?=$value['line_name']?>
                                                          </option>
                                                      <?php }
                                                    endforeach;
                                                  }
                                                ?>
                                          		</select>
                                        	</div>
                                      	</div>
                                      </div>
                                    </div>
                                    <input type="hidden" name="update_id" value="<?=$update_id;?>">
                                    <br><br>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!--    </div>-->
</div>
</div>
<script type="text/javascript">
  $(document).off('click', '.submit_from').on('click', '.submit_from', function(e){
    e.preventDefault();
    if(validateForm()) {
      $('#submited_form').attr('action', "<?= ADMIN_BASE_URL.'global_configuration/submit_product_reschedule/';?>").submit();
    } else {
      //return
    }
  });
  function validateForm() {
    var isValid = true;
    $('.validate_form').each(function(){
      if($(this).val() == '' || $(this).val() == null){
        $(this).attr('style','border:1px solid red;');
        $(this).siblings('.chosen-container').attr('style','border:1px solid red;')
        isValid = false;
      } else {
        $(this).removeAttr('style');
        if($(this).siblings('.chosen-container')){
          $(this).siblings('.chosen-container').removeAttr('style');
        }
      }
    });
  	if($('#selectboxing').find(":selected").val() == '' || $('#selectboxing').find(":selected").val() == null || $('#selectboxing').find(":selected").val() == 'undefined')
      $('.btn.dropdown-toggle.selectpicker.btn-default.selectbox-class').addClass('red');
    else
      $('.btn.dropdown-toggle.selectpicker.btn-default.selectbox-class').removeClass('red');
    if($('.scheduledate').val() == '' || $('.scheduledate').val() == null || $('.scheduledate').val()== 'undefined')
  		$('.scheduledate').addClass('red');
  	else
  		$('.scheduledate').removeClass('red');
    if($('.enddate').val() == '' || $('.enddate').val() == null || $('.enddate').val()== 'undefined')
      $('.enddate').addClass('red');
    else
      $('.enddate').removeClass('red');
    return isValid;
  }
  var dateToday = new Date();
  $('.datetimepicker6').datetimepicker({
      icons: {
          date: 'fa fa-calendar',
          up: 'fa fa-chevron-up',
          down: 'fa fa-chevron-down',
          previous: 'fa fa-chevron-left',
          next: 'fa fa-chevron-right',
          today: 'fa fa-crosshairs',
          clear: 'fa fa-trash',
          minDate: dateToday
        },
        //viewMode: 'years',
        format:'MM/DD/YYYY'
    });
  $(document).off("change", ".plants_team").on("change", ".plants_team", function (event) {
    event.preventDefault();
    var abc = $(this);
    var plant = abc.val();
    $('.group_line_div').addClass('disable_class');
    if(plant == '' || plant == null || plant == 'undefined' || plant.toLowerCase() == 'select' ) {
      $(".responsible_team").html('<option  value="">Select</option>');
      showToastr("Please select the plant", false);
    }
    else {
      $.ajax({
        type: 'POST',
        url: "<?php ADMIN_BASE_URL?>global_configuration/get_plant_lines",
        data: {'plant': plant,'line':'<?=$line?>'},
        async: false,
        success: function(data) {
          $('.group_line_div').removeClass('disable_class');
          $(".responsible_team").html(data);
        }
      });
    }
  });
</script>

