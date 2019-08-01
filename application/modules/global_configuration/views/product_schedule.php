<style type="text/css">
	.red {
		border: 1px solid red;
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
                                        <div class="form-group">
                                          <label class="col-sm-4 control-label">Product</label>
                                            <div class="col-sm-8">
                                               	<select  class="validate_form form-control restaurant_type" name="product_name" required="required">
                                               		<option value="">Select</option>
                                                	<?php 
                                                    if(!isset($selected_product))
                                                      $selected_product ='';
                                                    if(isset($products) && !empty($products)) { foreach($products as $key=> $pro): ?>
                                                   	<option  value="<?=$pro['id'];?>" <?php if($selected_product == $pro['id']) echo 'selected="selected"';?>><?=$pro['product_title'];?></option>
                                                   <?php endforeach; } ?>
                                               	</select>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                  	<div class="col-sm-12 selecting_date">
                                    	<div class="form-group">
                                      		<label class="col-sm-4 control-label">Start Date</label>
                                        	<div class="col-sm-8">
                                            <?php if(!isset($start_date))
                                                      $start_date =''; ?>
                                           		<div class='input-group datetimepicker6'>
			                                    	<input type='text' name="scheduledate" class="form-control scheduledate date" id="datetimepicker6"  required="required" value="<?=$start_date;?>" />
			                                    	<span class="input-group-addon">
			                                        	<span class="fa fa-calendar">
			                                        	</span>
			                                    	</span>
			                                	</div>
                                        	</div>
                                    	</div>
                                  	</div>
                                    <br><br>
                                    <div class="group_div" style="clear: both; padding-top: 10px;">
                                        <div class="col-sm-12">
                                          	<div class="form-group">
                                            	<label class="col-sm-4 control-label">Line</label>
                                            	<div class="col-sm-8">
                                              		<select  class="form-control responsible_team validate_form" name="shift" required="required">
                                                		<option  value="">Select</option>
                                                		<?php
                                                    if(!isset($line))
                                                      $line ='';
                                                		if(!isset($shift) || empty($shift))
                                                   		$shift = array('1','2','3');
                                                		foreach ($shift as $value): ?>
                                                  			<option value="<?=$value?>" <?php if($line == $value) echo 'selected="selected"';?>><?=$value?>
                                                  			</option>
                                                		<?php endforeach ?>
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
  /*$('#datetimepicker6').datetimepicker({ 
  	minDate: new Date()
  }); */
</script>

