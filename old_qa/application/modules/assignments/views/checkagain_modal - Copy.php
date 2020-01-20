<?php if(!isset($shows) || empty($shows)) $shows = ""; ?>
<?php if($shows == 'heading') { ?>
<div class="page-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                            <h4 class="form-section">Select Responsible Team</h4>
                       
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       <form method="post" id="submited_form" action="<?= ADMIN_BASE_URL.'assignments/submint_recheck/';?>">
                            <div class="form-body"> 
                                    <div class="row main_div">
                                      <div class="col-sm-12 selecting_div">
                                        <div class="form-group">
                                          <label class="col-sm-4 control-label">Responsible</label>
                                            <div class="col-sm-8">
                                               <select  class="validate_form form-control restaurant_type" name="responsible_type" required="required">
                                                   <option  value="">Select</option>
                                                   <option  value="group" <?php if($selected=="group") echo 'selected="selected"'?>>Group</option>
                                                   <option  value="user" <?php if($selected=="user") echo 'selected="selected"'?>>User</option>
                                               </select>
                                            </div>
                                        </div>
                                      </div>
                                      <br><br>
                                      <?php } elseif($shows == 'group') { ?>
                                      <div class="group_div" style="clear: both; padding-top: 10px;">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label class="col-sm-4 control-label">Responsible Team </label>
                                            <div class="col-sm-8">
                                              <select  class="form-control responsible_team validate_form" name="responsible_team" required="required">
                                                <option  value="">Select</option>
                                                <?php
                                                if(!isset($groups) || empty($groups))
                                                   $groups = array();
                                                if(!isset($assign_group)) 
                                                  $assign_group = "";
                                                foreach ($groups as $value): ?>
                                                  <option value="<?=$value['id']?>" <?php if($value['id']== $assign_group) echo 'selected="selected"';?>><?= $value['group_title']?>
                                                  </option>
                                                <?php endforeach ?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <?php } elseif($shows == 'user') { ?>
                                      <div class="team_div" style="clear: both; padding-top: 10px;">
                                        <div class="col-sm-12">
                                           <div class="form-group">
                                              <label class="col-sm-4 control-label">Responsible User </label>
                                              <div class="col-sm-8">
                                                 <select  class="validate_form form-control responsible_user" name="responsible_user" required="required">
                                                     <option value="">Select</option>
                                                    <?php
                                                          if(!isset($news['inspection_team'])) $news['inspection_team'] = "";
                                                         foreach ($assign_group_users as $value): ?>
                                                    <option value="<?=$value['id']?>" 
                                                   ><?= $value['first_name'].' '.$value['last_name']?></option>
                                                    <?php endforeach ?>
                                                 </select>
                                              </div>
                                           </div>
                                           
                                        </div>
                                      </div>
                                    <?php } else echo ""; 
                                    if($shows == 'heading') { ?>
                                    <div class="question_div" style="clear: both; padding-top: 10px;">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                          <label class="col-sm-4 control-label">Select Attributes</label>
                                          <div class="col-sm-8">
                                             <select multiple="" class="validate_form form-control question_type chosen-select " name="groups[]" required="required">
                                                <?php
                                                   if(!isset($question) || empty($question))
                                                       $question = array();
                                                     
                                                     foreach ($question as $qa): ?>
                                                <option value="<?=$qa['question_id']?>">
                                                  <?=$qa['question']?>
                                                </option>
                                                <?php endforeach ?>
                                             </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <input type="hidden" name ="assign_id" value="<?=$assign_id?>">
                                    <input type="hidden" name ="check_id" value="<?=$check_id?>">
                                    <?php if(empty($reassign_id)) {?>
                                    <button type="submit" class="btn-primary btn pull-right submit_from" style="clear: both; margin-top: 10px;">Submit</button>
                                            <br><br>
                                    <?php } ?>
                                    </div>
                                    <?php } ?>

                             
                           
                        
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
      $('#submited_form').attr('action', "<?= ADMIN_BASE_URL.'assignments/submit_recheck/';?>").submit();
    } else {
      //return
    }

  });
  function validateForm() {
    var isValid = true;
    $('.validate_form').each(function(){
      if($(this).val() == '' || $(this).val() == null){
        $(this).attr('style','border:1px solid red;');
        if($(this).hasClass('question_type')) {
          $(this).hide()
        }
        $(this).siblings('.chosen-container').attr('style','border:1px solid red;')
        isValid = false;
      } else {
        $(this).removeAttr('style');
        if($(this).siblings('.chosen-container')){
          $(this).siblings('.chosen-container').removeAttr('style');
        }
        if($(this).hasClass('question_type')) {
          $(this).hide()
        }
      }
    })
    return isValid;
  }
  $('.question_type').change(function(){
    $(this).siblings('.chosen-container').removeAttr('style');
  })
</script>

