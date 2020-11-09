<style type="text/css">
  .red {
    border: 1px solid red !important;
  }
  .displayclass {
    display: none;
  }
</style>
<div class="review_text displayclass">
    <?php if(!isset($review_text)) $review_text = ''; echo $review_text;?>
</div>
<div class="review_status displayclass">
    <?php if(!isset($review_status)) $review_status = false; echo $review_status;?>
</div>
<div class="permission displayclass">
    <?php if(!isset($permission)) $permission = ''; echo $permission;?>
</div>
<div class="page-content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <div class="portlet box blue">
        <div class="portlet-body form">
          <div class="form-body">

            <h3>
              <?php $name=''; if(isset($assign_detail[0]['sf_name']) && !empty($assign_detail[0]['sf_name'])) $name=$assign_detail[0]['sf_name']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name; ?>
            </h3>        
            <table id="datatable1" class="table table-bordered">
              <tbody class="table-body">
                <?php 
                $answered_user = "";
                if(isset($questions[0]['user_id']) && !empty($questions[0]['user_id']))
                  $answered_user = $questions[0]['user_id'];
                $user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$answered_user),'id desc','users','user_name','1','1')->result_array();
                $line_na = '';
                if(isset($questions[0]['line_no']) && !empty($questions[0]['line_no']))
                  $line_na = $questions[0]['line_no'];
                ?>
                <tr class="bg-col">
                    <th>
                        User name:
                    </th>
                    <td>
                      <?php $name=''; if(isset($user_detail[0]['user_name']) && !empty($user_detail[0]['user_name'])) $name=$user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name; ?>
                    </td>
                </tr>
                <?php if(!empty($line_na)) { ?>
                <tr class="bg-col">
                    <th>
                        Line number:
                    </th>
                    <td>
                        <?php
                        if(isset($questions[0]['line_no']) && !empty($questions[0]['line_no'])) {
                          $line_timing = explode(",",$questions[0]['line_no']);
                          if(!empty($line_timing)) {
                              $counters = 1;
                              foreach($line_timing as $keys => $line):
                                  $line_name = Modules::run('api/_get_specific_table_with_pagination',array('line_id'=>$line), 'line_id desc',DEFAULT_OUTLET.'_lines','line_name','1','1')->row_array();
                                  if(!empty($line_name['line_name'])) {
                                      if($counters > 1)
                                          echo ",";
                                      echo $line_name['line_name'];
                                      $counters++;
                                  }
                              endforeach;
                          }
                        }
                         ?>
                    </td>
                </tr>
                <?php }?>
                <tr class="bg-col">
                    <th>
                      Date & time:
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
                </tr>
              </thead>
              <tbody>
                <?php if(isset($questions) && !empty($questions)){
                  foreach($questions as $qa){?>
                <tr>
                  <td><?php echo $qa['question']; ?></td>
                  <td>
                    <?php echo $qa['given_answer']; ?>
                  </td>
                <td>
                    <?php if(!empty($qa['comments'])){ echo $qa['comments']; }else{ echo "-";} ?>
                  </td>
                </tr>
                <?}}?>
              </tbody>
            </table>
          
          
          	<?php $media_check = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$assign_detail[0]['assign_id'],'outlet_id'=>DEFAULT_OUTLET),'media_id desc',DEFAULT_OUTLET.'_static_media','media_id,media_name,media_type,media_status','1','0')->result_array();
          if(!empty($media_check)) { ?>
                                    <script src="<?php echo STATIC_ADMIN_JS?>html5gallery.js"></script>
                                    <h3>Media Files</h3>
                                    <div style="display:none;margin:0 auto;" class="html5gallery" data-skin="gallery" data-width="480" data-height="272" data-resizemode="fill">
                                    <?php  foreach ($media_check as $key => $mc):
                                      if(isset($mc['media_type']) && !empty($mc['media_type'])) {
                                        if($mc['media_type'] == 'image') {?>
                                      <!-- Add images to Gallery -->
                                          <a href="<?php $path=STATIC_ADMIN_IMAGE.'no-image-available.jpg'; if(isset($mc['media_name']) && !empty($mc['media_name'])) $path=Modules::run('api/image_path_with_default',ACTUAL_STATIC_ASSIGNMENT_ANSWER_IMAGE_PATH,$mc['media_name'],STATIC_ADMIN_IMAGE,'no-image-available.jpg'); echo $path; ?>">
                                            <img src="<?=$path?>" alt="Image">
                                          </a>
                                        <?php } elseif($mc['media_type'] == 'video') {?>
                                          <a href="<?php $path=STATIC_ADMIN_IMAGE.'no-image-available.jpg'; if(isset($mc['media_name']) && !empty($mc['media_name'])) $path=Modules::run('api/image_path_with_default',ACTUAL_STATIC_ASSIGNMENT_ANSWER_IMAGE_PATH,$mc['media_name'],STATIC_ADMIN_IMAGE,'no-image-available.jpg'); echo $path; ?>" data-webm="<?=STATIC_ADMIN_IMAGE.'no-image-available.jpg'?>"><img src="<?=STATIC_ADMIN_IMAGE.'no-image-available.jpg'?>" alt="Video"></a>
                                        <?php } else echo "";
                                      }
                                    endforeach;?>
                                    </div>
                                    <?php } ?>
            <?php if($function == 'static_forms_reviewed' || $function=="static_forms_approved") { ?>
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
                      $name=''; if(isset($review_user_detail[0]['user_name']) && !empty($review_user_detail[0]['user_name'])) $name=$review_user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name; 
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
            <?php }
            if($function=="completed_checks") { ?>
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
                      $name=''; if(isset($review_user_detail[0]['user_name']) && !empty($review_user_detail[0]['user_name'])) $name=$review_user_detail[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name; 
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
                <?php if(isset($assign_detail[0]['approval_comments']) && !empty($assign_detail[0]['approval_comments'])) { ?>
                <tr class="bg-col">
                    <th>
                       Review Comment:
                    </th>
                    <td>
                        <?php if(isset($assign_detail[0]['approval_comments']) && !empty($assign_detail[0]['approval_comments'])) {
                          echo wordwrap( $assign_detail[0]['approval_comments'], 100 , "<br>\n");
                        } ?>
                    </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php }
            if(($function == "static_forms_pending" || $function == "static_forms_approved") &&  $review_status == TRUE){?>
            <form id="comment_form_submit" action="<?= ADMIN_BASE_URL?>static_form/change_static_form_permission" method="post">
                <div class="">
                  <textarea class="form-control" placeholder="Comment here" name="review_comments"></textarea>
                  <input type="hidden" name="update_id" value="<?=$update_id?>">
                  <input type="hidden" name="permission" value="<?=$permission?>">
                  <input type="hidden" name="url" value="<?=$url?>">
                </div>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).off("click",".submit_check").on("click",".submit_check", function(event) {
    event.preventDefault();
    $('#comment_form_submit').submit();
  });
</script>