<style type="text/css">
body{ 
    margin-top:20px; 
}

.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    background-color: #F7D16E;
}

.stepwizard-row:before {
    top: 8px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
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
                    $strTitle = 'QA Checks';
                else 
                     $strTitle = 'QA Checks';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal','role'=>"form");
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit/' . $update_id, $attributes);
                        ?>



<div class="stepwizard">
    <div class="stepwizard-row setup-panel">
        <div class="stepwizard-step">
            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
            <p>QA Checks</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" >2</a>
            <p>Product Attribute</p>
        </div>
         <div class="stepwizard-step">
            <a href="#step-3" type="button" class="btn btn-default btn-circle" >3</a>
            <p>Responsible Team</p>
        </div>
         <div class="stepwizard-step">
            <a href="#step-4" type="button" class="btn btn-default btn-circle" >4</a>
            <p>Scheduling</p>
        </div>
    </div>
</div>
<br>
<form role="form">
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3>QA Checks</h3>
               <div class="col-sm-8">
                        <div class="form-group">
                          <?php  $groups = array('product attribute'=>"Product Atrribute","general qa check"=>"General Qa Check");
                          if(!isset($users['group'])) $users['group'] = ""; ?>
                          <?php $options = array('' => 'Select')+$groups ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Select Check <span style="color:red">*</span>', 'role_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('group', $options, $users['group'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                          </div>
                        </div>
                    </div>
                     <div class="col-sm-8">
                            <div class="form-group">
                                <?php
                                $data = array(
                                    'name' => 'checkname',
                                    'id' => 'checkname',
                                    'class' => 'form-control',
                                    'value' =>'',
                                    'type' => 'text',
                                    'required' => 'required',
                                    'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                                <?php echo form_label('Enter Check Name <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                                <div class="col-md-8">
                                    <?php echo form_input($data); ?>
                                </div>
                            </div>
                        </div>

                    <div class="col-sm-8">
                        <div class="form-group select_box">
                          <?php if(!isset($products)) $products = array();
                          if(!isset($news['group'])) $news['group'] = ""; ?>
                          <?php $options = array('' => 'Select')+$products ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Select Product <span style="color:red">*</span>', 'product_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('group', $options, $news['group'],  'class="form-control select_attributes  required validatefield selectpicker show-tick" data-live-search="true" id="product_id" tabindex ="8"'); ?>
                          </div>
                        </div>
                    </div>
                  
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3>Choose Attributes</h3>
                <div class="section-box">
               
                </div>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-3">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3>Select Responsible Team </h3>
                 <div class="col-sm-5">
                        <div class="form-group">
                          <?php if(!isset($groups)) $groups = array();
                          if(!isset($users['group'])) $users['group'] = ""; ?>
                          <?php $options = array('' => 'Select')+$groups ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Select Team <span style="color:red">*</span>', 'role_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('group', $options, $users['group'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                          </div>
                        </div>
                </div>
               <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
     <div class="row setup-content" id="step-4">
        <div class="col-xs-12">
            <div class="col-md-12">
               
                            <div class="col-sm-5">
                            <div class="form-group">
                               <?php  $frequency = array('Thirty Mins'=>"Thirty Mins",'One Hour'=>"One Hour",'Daily'=>'Daily','Weekly'=>'Weekly');
                                  if(!isset($users['group'])) $users['group'] = ""; ?>
                             <?php $options = array('' => 'Select')+$frequency ;?>
                                <?php echo form_label('Select Frequency <span class="required" style="color:#ff60a3">*</span>', 'txtNewsTitle', $attribute); ?>
                               <div class="col-md-8">
                            <?php echo form_dropdown('group', $options, $users['group'],  'class="form-control select2me required validatefield" id="role_id" tabindex ="8"'); ?>
                          </div>
                            </div>
                        </div>

              
            </div>

                         <div class="col-sm-5">
                             <?php $news_date='';
                                if (isset($news['start_datetime']) && $news['start_datetime'] != "0000-00-00" && !empty($news['start_datetime'])) {
                                    $news_date = date('Y/m/d', strtotime($news['start_datetime']));
                                } else { $news_date = date('Y/m/d');

                                   
                                }
                                ?>
                                <div class="form-group">
                                    <?php
                                    $data = array(
                                        'name' => 'txtNewsDate',
                                        'id' => 'txtNewsDate',
                                        'class' => 'form-control',
                                        'value' => $news_date,
                                        'type' => 'text',
                                        'required' => '1',
                                    );
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Start Datetime <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                    <div class="col-md-8 input-group date datetimepicker2"> <?php echo form_input($data); ?> 
                                    <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-5">
                             <?php $news_date='';
                                if (isset($news['start_time']) && $news['start_time'] != "0000-00-00" && !empty($news['start_time'])) {
                                    $news_date = date('Y/m/d', strtotime($news['start_time']));
                                } else { $news_date = date('Y/m/d');

                                   
                                }
                                ?>
                                <div class="form-group">
                                    <?php
                                    $data = array(
                                        'name' => 'start_time',
                                        'id' => 'start_time',
                                        'class' => 'form-control',
                                        'value' => $news_date,
                                        'type' => 'text',
                                        'required' => '1',
                                    );
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Start time <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                    <div class="col-md-8 input-group date datetimepicker4"> <?php echo form_input($data); ?> 
                                    <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                    </div>
                                </div>
                        </div>
                         <div class="col-sm-5">
                              <?php
                                if (isset($news['end_date']) &&  $news['end_date'] != "0000-00-00" && !empty($news['end_date'])) {
                                    $news_date = date('Y/m/d', strtotime($news['end_date']));
                                } else {
                                    $news_date = date('Y/m/d');
                                }
                                ?>
                                <div class="form-group">
                                    <?php
                                    $data = array(
                                        'name' => 'end_date',
                                        'id' => 'end_date',
                                        'class' => 'form-control',
                                        'value' => $news_date,
                                        'type' => 'text',
                                        'required' => '1',
                                    );
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('End date <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                    <div class="col-md-8 input-group date datetimepicker2"> <?php echo form_input($data); ?> 
                                    <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                    </div>
                                </div>
                        </div>
                           <div class="col-sm-5">
                             <?php $news_date='';
                                if (isset($news['end_time']) && $news['end_time'] != "0000-00-00" && !empty($news['end_time'])) {
                                    $news_date = date('h:i', strtotime($news['start_time']));
                                } else { $news_date = date('h:i');

                                   
                                }
                                ?>
                                <div class="form-group">
                                    <?php
                                    $data = array(
                                        'name' => 'end_time',
                                        'id' => 'end_time',
                                        'class' => 'form-control',
                                        'value' => $news_date,
                                        'type' => 'text',
                                        'required' => '1',
                                    );
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('End time <span class="required" style="color:red">*</span>', 'txtNewsDate', $attribute); ?>
                                    <div class="col-md-8 input-group date datetimepicker4"> <?php echo form_input($data); ?> 
                                    <span class="input-group-addon"> <span class="fa fa-calendar"></span> </span>
                                    </div>
                                </div>
                        </div>
                        
        </div>
     </br>
         <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary btnsave"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div> 
    </div>
</form>



                <br>
                
             <!--    <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary btnsave"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div> -->
                
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


<script type="text/javascript">
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }

        }
         $(".select2me").css("border-color",'');
         if($('.select2me').val()=='' || $('.select2me').val()=='' || $('.select2me').val()==null ){
                $(".select2me").css("border-color","#f05050");
                  isValid = false;
            }
            alert(isValid)
        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});

</script>

<script type="text/javascript">
$(document).ready(function(){


           $('.select_attributes').on('change', function() {
            event.preventDefault();
            var id = $(this).val();
            //alert(id); return false;
            $(".row_add").remove();
            $request=1;
               $.ajax({
                    type: 'POST',
                    url: "<?=ADMIN_BASE_URL?>product_checks/get_product_info",
                    data: {'productid': id},
                    async: false,
                    success: function(test_body) {
                    $('.section-box').append(test_body);
                       $request=2;
                    }
                });
             $('.attribute').remove();
            
                if($request==2){
                 
                      $.ajax({
                        type: 'POST',
                        url: "<?php ADMIN_BASE_URL?>product_checks/get_attibutes_div_ajax",
                        data: {'productid': id},
                        async: false,
                        success: function(test_body) {
                        $('.attribute_form').append(test_body);
                           
       
                     }
                    });
                }
                    

            });
         });
</script>