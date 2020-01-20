<?php if(!isset($function)) $function=""; 
$assign_id = "";
if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid']))
  $assign_id = $assign_detail[0]['checkid'];
$original_assign_id = "";
if(isset($assign_detail[0]['assign_id']) && !empty($assign_detail[0]['assign_id']))
  $original_assign_id = $assign_detail[0]['assign_id'];
$line_na = "";
if(isset($assignmet_answers[0]['line_no']) && !empty($assignmet_answers[0]['line_no'])) {
  if(strtolower($assignmet_answers[0]['line_no']) == 'n/a')
    $line_na='N/A';
}
$shift_na = "";
if(isset($assignmet_answers[0]['shift_no']) && !empty($assignmet_answers[0]['shift_no'])) {
  if(strtolower($assignmet_answers[0]['shift_no']) == 'n/a')
    $shift_na='N/A';
}
$checkid = "";
if(isset($assign_detail[0]['checkid']) && !empty($assign_detail[0]['checkid'])) {
    $checkid=$assign_detail[0]['checkid'];
}
 ?>
<style type="text/css">
  .red {
    border: 1px solid red !important;
  }
  .displayclass {
    display: none;
  }
</style>
<div class="page-content-wrapper">
    <div class="review_approval displayclass">
        <?=$review_approval?>
    </div>
    <div class="reviewable displayclass">
        <?=$reviewable?>
    </div>
    <div class="is_reasigned displayclass">
        <?=$is_reasigned?>
    </div>
<?php // print_r($post['title']);exit; ?>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                            <div class="form-body">
                                  <?php if(isset($update_id) && !empty($update_id) && !empty($assign_id) && ( $function == "pending_review" || $function == "pending_approval"  || $function="completed_checks")) {
									$product_heading = "Product name";                                    
									$product_check = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_id),'id desc',DEFAULT_OUTLET.'_product_checks','productid,check_subcat_id','1','1')->result_array();
                                    $product_id = ""; 
                                    if(isset($assign_detail[0]['product_id']) && !empty($assign_detail[0]['product_id'])) {
                                      $product_id = $assign_detail[0]['product_id'];
                                      $prodct_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$product_id),'id desc',DEFAULT_OUTLET.'_product','product_title','1','1')->result_array();
                                    }
                                    elseif(isset($product_check[0]['check_subcat_id']) && !empty($product_check[0]['check_subcat_id'])) {
                                    	$product_heading = "Process Check Type";  
                                    	$prodct_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$product_check[0]['check_subcat_id']),"id desc","id desc",'catagories','cat_name as product_title','1','1','','','')->result_array();
                                    }
                                    else
                                      $prodct_detail[0]['product_title'] = 'N/A';
                                    $assignmet_answers = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$update_id),'assign_ans_id desc',DEFAULT_OUTLET.'_assignment_answer','question_id,answer_id,user_id,comments,line_no,shift_no,answer_type,range','1','1')->result_array();
                                    $answered_user = "";
                                    if(isset($assignmet_answers[0]['user_id']) && !empty($assignmet_answers[0]['user_id']))
                                      $answered_user = $assignmet_answers[0]['user_id'];
                                    $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$answered_user),'id desc','users','user_name','1','1')->result_array();

                                   ?>                    
                                  <h3><?php if(isset($checkname)) echo $checkname;?></h3>        
                                  <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th>
                                                 <?=$product_heading?>:
                                              </th>
                                              <td>
                                                <?php $name=''; if(isset($prodct_detail[0]['product_title']) && !empty($prodct_detail[0]['product_title'])) $name=$prodct_detail[0]['product_title']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  User name:
                                              </th>
                                              <td>
                                                  <?php $name=''; if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name'])) $name=$user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <?php if(empty($line_na)) { ?>
                                          <tr class="bg-col">
                                              <th>
                                                  Line number:
                                              </th>
                                              <td>
                                                  <?php $name=''; if(isset($assignmet_answers[0]['line_no']) && !empty($assignmet_answers[0]['line_no'])) $name=$assignmet_answers[0]['line_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                        <?php } if(empty($shift_na)) { ?>
                                          <tr class="bg-col">
                                              <th>
                                                  Shift detail:
                                              </th>
                                              <td>
                                                  <?php $name=''; if(isset($assignmet_answers[0]['shift_no']) && !empty($assignmet_answers[0]['shift_no'])) $name=$assignmet_answers[0]['shift_no']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; ?>
                                              </td>
                                          </tr>
                                        <?php }?>
                                          <tr class="bg-col">
                                              <th>
                                                 <?php if($function == 'pending_approval') echo "Complete "; ?> Date & time:
                                              </th>
                                              <td>
                                                  <?php if(isset($assign_detail[0]['complete_datetime']) && !empty($assign_detail[0]['complete_datetime'])) {
                                                    echo date('m-d-Y H:i:s',strtotime($assign_detail[0]['complete_datetime'])); 
                                                  } ?>
                                              </td>
                                          </tr>
                                         
                                      </tbody>
                                </table>
                                <h3>Check Detail</h3>
                                 <table class="table table-bordered check_detail" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6c9cde !important;">Attributes</th>
                                        <th style="color: #6c9cde !important;">Provided Values</th>
                                        <th style="color: #6c9cde !important;">Corrective Action</th>
                                        <?php if($review_approval == true && (($reviewable == false && $is_reasigned == true)OR ($reviewable == true && $is_reasigned == false))) { ?>
                                          <th  style="color: #6c9cde !important;">Recheck</th>
                                        <?php } ?>
                                      </tr>
                                    </thead>
                                    
                                    <tbody>

                                         <?php if(isset($questions) && !empty($questions)){
                                        foreach($questions as $qa){?>
                                      <tr>
                                        <td><?php echo $qa['question']; ?></td>
                                        <td>
                                                <?php
                                          if($qa['answer_type'] == 'Range')
                                            echo $qa['range'];
                                          elseif(strtolower($qa['answer_type']) == 'choice' || strtolower($qa['answer_type']) == 'fixed')
                                            echo $qa['given_answer'];
                                          elseif(isset($qa['answer_id']) && !empty($qa['answer_id'])) {
                                            $question_anwer = Modules::run('api/_get_specific_table_with_pagination',array("question_id"=>$qa['question_id'],"answer_id"=>$qa['answer_id']),'answer_id desc',DEFAULT_OUTLET.'_checks_answers','possible_answer','1','1')->result_array();
                                            $name=''; if(isset($question_anwer[0]['possible_answer']) && !empty($question_anwer[0]['possible_answer'])) $name=$question_anwer[0]['possible_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name;
                                          }else 
                                          echo "";?></td>
                                          <td>
                                          <?php 
                                          if(isset($qa['comments'] ) && !empty($qa['comments']))  
                                            echo $qa['comments'];
                                            else
                                            echo "-";
                                            ?>
                                            </td>
                                          <?php $checked=""; if($review_approval == true && (($reviewable == false && $is_reasigned == true)OR ($reviewable == true && $is_reasigned == false))) {
                                            if(isset($again_question) && !empty($again_question)) {
                                              $key = array_search($qa['question_id'], array_column($again_question, 'rq_question_id'));
                                              if(is_numeric($key))
                                                $checked = 'checked';
                                            }
                                           ?>
                                          <td>
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                              <input name="question_id[]" type="checkbox" class="custom-control-input chk" value="<?php echo $qa['question_id']; ?>" <?=$checked?> >
                                              <label class="custom-control-label" for="defaultChecked2"></label>
                                            </div>
                                          </td>
                                          <?php } ?>
                                      </tr>
                                      <?}}?>
                                    </tbody>
                                  </table>
                                  <div class="reassign_checks">
                                  </div>
                                  <?php if(isset($is_reasigned) && $is_reasigned==TRUE && $reviewable==TRUE && isset($reassign_questions) && !empty($reassign_questions)){
                                  ?>
                               
                                  <h3>Re Check Detail</h3>
                                 <table class="table table-bordered" style="color: black !important">
                                    <thead>
                                      <tr>
                                        <th  style="color: #6c9cde !important;">Attributes</th>
                                        <th style="color: #6c9cde !important;">Provided Values</th>
                                        <th style="color: #6c9cde !important;">Corrective Action</th>
                                      </tr>
                                    </thead>
                                    
                                    <tbody>

                                         <?php if(isset($reassign_questions) && !empty($reassign_questions)){
                                        foreach($reassign_questions as $rqa){?>
                                      <tr>
                                        <td><?php echo $rqa['question']; ?></td>
                                        <td>
                                          <?php if($rqa['answer_type'] == 'Range')
                                            echo $rqa['range'];
                                          elseif(isset($rqa['answer_id']) && !empty($rqa['answer_id'])) {
                                            $question_anwer = Modules::run('api/_get_specific_table_with_pagination',array("question_id"=>$rqa['question_id'],"answer_id"=>$rqa['answer_id']),'answer_id desc',DEFAULT_OUTLET.'_checks_answers','possible_answer','1','1')->result_array();
                                            $name=''; if(isset($question_anwer[0]['possible_answer']) && !empty($question_anwer[0]['possible_answer'])) $name=$question_anwer[0]['possible_answer']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name;
                                          }else echo "";?></td>
                                           <td>
                                          <?php 
                                          if(isset($qa['comments'] ) && !empty($qa['comments']))  
                                            echo $qa['comments'];
                                            else
                                            echo "-";
                                            ?>
                                            </td>
                                      </tr>
                                      <?}}?>
                                    </tbody>
                                  </table>
                                   <?}?>
                                <?php if($function == 'pending_approval' || $function=="completed_checks") { ?>
                                <h3>Review Detail</h3>
                                 <table class="table table-bordered" style="color: black !important">
                                  <tbody>

                                            <tr class="bg-col">
                                              <th>
                                                 Reviewed By
                                              </th>
                                              <td>
                                                  <?php 
                                                  $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_detail[0]['review_user']),'id desc','users','user_name','1','1')->result_array();
                                                  $name=''; if(isset($review_user_detail[0]['user_name']) && !empty($review_user_detail[0]['user_name'])) $name=$review_user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; 
                                                   ?>
                                              </td>
                                          </tr>

                                          <tr class="bg-col">
                                              <th>
                                                 Reviewed Date & time:
                                              </th>
                                              <td>
                                                  <?php if(isset($assign_detail[0]['review_datetime']) && !empty($assign_detail[0]['review_datetime'])) {
                                                    echo date('m-d-Y H:i:s',strtotime($assign_detail[0]['review_datetime'])); 
                                                  } ?>
                                              </td>
                                          </tr>
                                          <?php if(isset($assign_detail[0]['review_comments']) && !empty($assign_detail[0]['review_comments'])) {?>
                                          <tr class="bg-col">
                                              <th>
                                                 Review Comment:
                                              </th>
                                              <td>
                                                  <?php if(isset($assign_detail[0]['review_comments']) && !empty($assign_detail[0]['review_comments'])) {
                                                    echo wordwrap( $assign_detail[0]['review_comments'], 100 , "<br>\n");
                                                  } ?>
                                              </td>
                                          </tr>
                                         <?php } ?>
                                  </tbody>
                                </table>
                                 <?php } ?>
                                  <?php if($function=="completed_checks") { ?>
                                <h3>Approval Detail</h3>
                                 <table class="table table-bordered" style="color: black !important">
                                  <tbody>

                                            <tr class="bg-col">
                                              <th>
                                                 Approved By
                                              </th>
                                              <td>
                                                  <?php 
                                                  $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assign_detail[0]['approval_user']),'id desc','users','user_name','1','1')->result_array();
                                                  $name=''; if(isset($review_user_detail[0]['user_name']) && !empty($review_user_detail[0]['user_name'])) $name=$review_user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; 
                                                   ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                 Approved Date & time:
                                              </th>
                                              <td>
                                                  <?php if(isset($assign_detail[0]['approval_datetime']) && !empty($assign_detail[0]['approval_datetime'])) {
                                                    echo date('m-d-Y H:i:s',strtotime($assign_detail[0]['approval_datetime'])); 
                                                  } ?>
                                              </td>
                                          </tr>
                                         
                                  </tbody>
                                </table>
                                 <?php } ?>
                                <?php }
                                if($function == "pending_review" && isset($datacomment) && $datacomment=="ok"  && $reviewable==TRUE){?>
                                <form id="pending_review" action="<?= ADMIN_BASE_URL?>assignments/change_approval_status_for_assignment" method="post">
                                    <div class="">
                                    <textarea class="form-control" placeholder="Comment here" name="review_comments"></textarea>
                                    <input type="hidden" name="assign_id" value="<?=$assignment_detailid?>">
                                    <input type="hidden" name="both_permission" value="<?=$both_permission?>">
                                    </div>
                                    <br>
                                </form>
                                <?}elseif($function == "pending_approval" && isset($datacomment) && $datacomment=="ok"){?>
                                    <form action="<?= ADMIN_BASE_URL?>assignments/change_completed_status_for_assignment" method="post" id="pending_approval">
                                        <div class="">
                                            <input type="hidden" name="assign_id" value="<?=$assignment_detailid?>">
                                        </div>
                                        <br>
                                    </form>
                                <?}?>
                                <div class="message" style="color:red"></div>
                                <form  action="<?= ADMIN_BASE_URL?>assignments/submit_recheck" method="post" id="reassign_submit" style="opacity: 0px;" enctype="multipart/form-data">
                                </form>
                                <?php $media_check = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$update_id,'outlet_id'=>DEFAULT_OUTLET),'media_id desc',DEFAULT_OUTLET.'_media','media_id,media_name,media_type,media_status','1','0')->result_array();
                                  if(!empty($media_check)) { ?>
                                    <script src="<?php echo STATIC_ADMIN_JS?>html5gallery.js"></script>
                                    <h3>Media Files</h3>
                                    <div style="display:none;margin:0 auto;" class="html5gallery" data-skin="gallery" data-width="480" data-height="272" data-resizemode="fill">
                                    <?php  foreach ($media_check as $key => $mc):
                                      if(isset($mc['media_type']) && !empty($mc['media_type'])) {
                                        if($mc['media_type'] == 'image') {?>
                                      <!-- Add images to Gallery -->
                                          <a href="<?php $path=STATIC_ADMIN_IMAGE.'no-image-available.jpg'; if(isset($mc['media_name']) && !empty($mc['media_name'])) $path=Modules::run('api/image_path_with_default',ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH,$mc['media_name'],STATIC_ADMIN_IMAGE,'no-image-available.jpg'); echo $path; ?>">
                                            <img src="<?=$path?>" alt="Image">
                                          </a>
                                        <?php } elseif($mc['media_type'] == 'video') {?>
                                          <a href="<?php $path=STATIC_ADMIN_IMAGE.'no-image-available.jpg'; if(isset($mc['media_name']) && !empty($mc['media_name'])) $path=Modules::run('api/image_path_with_default',ACTUAL_ASSIGNMENT_ANSWER_IMAGE_PATH,$mc['media_name'],STATIC_ADMIN_IMAGE,'no-image-available.jpg'); echo $path; ?>" data-webm="<?=STATIC_ADMIN_IMAGE.'no-image-available.jpg'?>"><img src="<?=STATIC_ADMIN_IMAGE.'no-image-available.jpg'?>" alt="Video"></a>
                                        <?php } else echo "";
                                      }
                                    endforeach;?>
                                    </div>
                                    <?php } ?>
                            </div>
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!-- </div>-->
</div>
</div>
<?php if(!isset($answered_user) || empty($answered_user)) $answered_user=0; ?>
<script type="text/javascript">
    $(document).off("click",".submit_check").on("click",".submit_check", function(event) {
            event.preventDefault();
            var functions='<?=$function;?>';
             if(functions=="pending_review"){
                $('#pending_review').submit();
            }else if(functions=="pending_approval"){
                $('#pending_approval').submit();
            }
    });
    <?php if($is_reasigned == false) { ?>
    $(document).ready(function(){
        $('input[name="question_id[]"]').click(function(){
            reassign_changing();
            var numberOfChecked = $('input[name="question_id[]"]:checked').length;
            var totalCheckboxes = $('input[name="question_id[]"]').length;
            var numberNotChecked = totalCheckboxes - numberOfChecked;
            if($(this).prop("checked") == true){
                /*alert("Checkbox is checked."+totalCheckboxes+"======="+numberOfChecked);*/
                if(numberOfChecked == 1) {
                  $.ajax({
                    type: 'POST',
                    url: "<?= ADMIN_BASE_URL?>assignments/get_reassignment_detail",
                    data: {'assign': <?=$original_assign_id?>,'user_id':'<?=$answered_user?>'},
                    async: false,
                    success: function(result) {
                      var datamain = $(result).find('datamain').html();
                        var tablecreat = '<h3>Select Responsible Team</h3><table class="table table-bordered recheck_detail" style="color: black !important"><tbody>';
                        $(result).find('datamain').find('trr').each(function(){
                          tablecreat = tablecreat+'<tr>'
                          $(this).find('tdd').each(function(){
                            tablecreat = tablecreat+'<td>'+$(this).html()+'</td>'
                          })
                          tablecreat = tablecreat+'</tr>'
                        })
                        tablecreat = tablecreat+'</tbody></table>';
                        $('.reassign_checks').html(tablecreat);
                    }
                  });

                }
            }
            else if($(this).prop("checked") == false){
              if(numberNotChecked == 4)
                $('.reassign_checks').html('');
                /*alert("Checkbox is unchecked."+totalCheckboxes+"======="+numberNotChecked);*/
            }
        });
    });
    <?php } else {?>
    $('.check_type').attr("disabled", true); 
    $('.responsible_team').attr("disabled", true); 
    $('.responsible_user').attr("disabled", true); 
    <?php } ?>
    function reassign_changing() {
      $(document).off('change', '.check_type').on('change', '.check_type', function(e){
        e.preventDefault();
        var abc = $(this);
        abc.removeClass("red");
        if(abc.val() != 'group' && $(this).val() != 'user') {
          abc.addClass("red");
        }
        else if($(this).val() == 'group') {
          $(".recheck_detail tr:nth-child(3)").remove();
        }
        else if($(this).val() == 'user') {
          var responsible_team = $('.responsible_team').val();
          if(responsible_team == '')
            $('.responsible_team').addClass("red");
          else{
            $(".recheck_detail tr:nth-child(3)").remove();
            $.ajax({
              type: 'POST',
              url: "<?= ADMIN_BASE_URL?>assignments/get_group_users",
              data: {'group': responsible_team},
              async: false,
              success: function(result) {
                var datamain = $(result).find('datamain').html();
                  var tablecreat = '';
                  $(result).find('datamain').find('trr').each(function(){
                    tablecreat = tablecreat+'<tr>'
                    $(this).find('tdd').each(function(){
                      tablecreat = tablecreat+'<td>'+$(this).html()+'</td>'
                    })
                    tablecreat = tablecreat+'</tr>'
                  })
                  tablecreat = tablecreat;
                  $('.recheck_detail').append(tablecreat);
              }
            });
          }
        }
      });
      $(document).off('change', '.responsible_team').on('change', '.responsible_team', function(e){
        e.preventDefault();
        var hello = $(this);
        hello.removeClass("red");
        var check_type = $('.check_type').val();
        if(hello.val()== '') {
          hello.addClass("red");
        }
        else if(check_type !='') {
          if($('.check_type').val() == 'group') {
            $(".recheck_detail tr:nth-child(3)").remove();
          }
          else if($('.check_type').val() == 'user') {
            $(".recheck_detail tr:nth-child(3)").remove();
            $.ajax({
              type: 'POST',
              url: "<?= ADMIN_BASE_URL?>assignments/get_group_users",
              data: {'group': hello.val()},
              async: false,
              success: function(result) {
                var datamain = $(result).find('datamain').html();
                  var tablecreat = '';
                  $(result).find('datamain').find('trr').each(function(){
                    tablecreat = tablecreat+'<tr>'
                    $(this).find('tdd').each(function(){
                      tablecreat = tablecreat+'<td>'+$(this).html()+'</td>'
                    })
                    tablecreat = tablecreat+'</tr>'
                  })
                  tablecreat = tablecreat;
                  $('.recheck_detail').append(tablecreat);
              }
            });
          }
        }
        else
          $('.check_type').addClass("red");
      });
    }
    $(document).off('click', '.reassign_check').on('click', '.reassign_check', function(e){
      e.preventDefault();
      $('#reassign_submit').trigger("reset");
      var his  = $(this);
      var checkedIds = $(".chk:checked").map(function() {
        if(this.value !='')
          $('<input name="groups[]" type="checkbox" value="'+this.value+'" checked />').appendTo('#reassign_submit');
        return this.value;
      }).toArray();
      if(checkedIds !='') {
        $('.message').text('');
        if($('.check_type').val() !="") {
          $('<input type="text" name="responsible_type" value="'+$('.check_type').val()+'" />').appendTo('#reassign_submit');
          if($('.responsible_team').val() !='') {
            $('<input type="text" name="responsible_team" value="'+$('.responsible_team').val()+'" />').appendTo('#reassign_submit');
            $('<input type="text" name="assign_id" value="<?=$original_assign_id?>" />').appendTo('#reassign_submit');
            $('<input type="text" name="check_id" value="<?=$checkid?>" />').appendTo('#reassign_submit');
            if($('.check_type').val() == 'user'){
              $('<input type="text" name="responsible_user" value="'+$('.responsible_user').val()+'" />').appendTo('#reassign_submit');
              $('#reassign_submit').submit();
            }
            else{
              $('#reassign_submit').submit();
            }
          }
          else
            $('.message').text('Please select responsible Team');
        }
        else
          $('.message').text('Please select responsible type');
      }
      else
        $('.message').text('Please select question first');
    });
    <?php if($is_reasigned == true   && $reviewable == false) { ?>
      $('.reassign_check').remove();
      $.ajax({
        type: 'POST',
        url: "<?= ADMIN_BASE_URL?>assignments/get_reassignment_detail",
        data: {'assign': <?=$original_assign_id?>,'user_id':'<?=$reassign_data[0]["reassign_user"]?>','group':'<?=$reassign_data[0]["inspection_team"]?>','type':'edit'},
        async: false,
        success: function(result) {
          var datamain = $(result).find('datamain').html();
            var tablecreat = '<h3>Select Responsible Team</h3><table class="table table-bordered recheck_detail" style="color: black !important"><tbody>';
            $(result).find('datamain').find('trr').each(function(){
              tablecreat = tablecreat+'<tr>'
              $(this).find('tdd').each(function(){
                tablecreat = tablecreat+'<td>'+$(this).html()+'</td>'
              })
              tablecreat = tablecreat+'</tr>'
            })
            tablecreat = tablecreat+'</tbody></table>';
            $('.reassign_checks').html(tablecreat);
        }
      });
    <?php } ?>
</script>
