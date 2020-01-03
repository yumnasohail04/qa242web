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
.section-box {
    box-shadow: none;
}
*, *:before, *:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}




.new {
  padding: 50px;
}

.form-group {
  display: block;
  margin-bottom: 15px;
}

.form-group input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.form-group label {
  position: relative;
  cursor: pointer;
      border-radius: 30px;
}

.form-group label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
  width: 50px;
  height: 50px; 
  border-radius: 30px;
}

.form-group input:checked + label:after {
    content: '';
    display: block;
    position: absolute;
    top: 14px;
    left: 23px;
    width: 12px;
    height: 24px;
    border: 23px solid #ffffff;
    border-width: 0 4px 4px 0;
    transform: rotate(45deg);
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
                    $strTitle = 'Fill ScoreCard';
                    echo $strTitle;
                    ?>
                   
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
                            $hidden = array('hdnId' => $update_id); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'scorecard/submit_pending_scorecard/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'scorecard/submit_pending_scorecard/' . $update_id, $attributes);
                        ?>
                  <div class="form-body section-box">
                    
                 <h3 class="form-section"><?php echo $supplier['name'].' Scorecard'; ?></h3>
                   
                <div class="row new">
                    <div class="title_bar">
                        <div class="col-md-5">Questions</div>
                        <div class="col-md-2">Provided Feedback</div>
                        <div class="col-md-5">Give Feedback</div>
                    </div>
                    <?php foreach($questions as $key => $value){ ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-5">
                                <p style="color: #2f69b7;"><span><?php echo $key+1; ?>. </span><?php echo $value['question']; ?></p>
                                <p style="font-size:16px;"><?php echo $value['sfq_description']; ?></p>
                            </div>
                            <div class="col-md-2">
                                <?php 
                                if($value['filled_answers']=="Red")
                                $color="#e84e4e";
                                if($value['filled_answers']=="Green")
                                $color="#69b969";
                                if($value['filled_answers']=="Yellow")
                                $color="#ecec4c";
                                ?>
                                <input  type="checkbox" >
                                <label style="background-color:<?php echo $color; ?>"></label>
                            </div>
                            <div class="col-md-5">
                                <?php foreach($value['answers'] as $keys => $ans) {
                                if($ans['sfa_answer']=="Red")
                                $color="#e84e4e";
                                if($ans['sfa_answer']=="Green")
                                $color="#69b969";
                                if($ans['sfa_answer']=="Yellow")
                                $color="#ecec4c";
                                ?>
                                <input  type="checkbox" id="html<?php echo $keys.$key ?>" data-points="<?php echo $ans['sfa_points']; ?>" data-ans-id="<?php echo $ans['sfa_id'] ?>" data-quest-id="<?php echo $value['sfq_id'] ?>" class="check_color" >
                                <label for="html<?php echo $keys.$key ?>"  style="background-color:<?php echo $color; ?>"></label>
                              <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <hr>
                    </div>
                    <?php } ?>
                </div>
                <div class="row new">
                    <?php foreach($team_data as $key => $value){ ?>
                    <div class="col-md-3">
                        <p>Team : <?php echo $value['group_title']; ?></p>
                        <p>User : <?php echo $value['first_name'].' '.$value['last_name']; ?></p>
                        <p>Reviewed Date : <?php echo $value['reviewed_date']; ?></p>
                        <p>Given Points : <?php echo number_format((float)$value['percentage'], 2, '.', '').'%'; ?></p>
                    </div>
                    <?php } ?>
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row new">
                    <div class="col-md-12">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button class="btn btn-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'scorecard'; ?>">
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
    
    var qa,filled,exist,i, result_arr=[];
    $(document).off('click', '.submited_form').on('click', '.submited_form', function(e){
    e.preventDefault();
        filled=1;qa=0;
        <?php $length=count($questions);?>
        if(<?php echo $length ?>==result_arr.length)
        {
            qa=1;
        }
        if(qa==0){
            toastr.error("Fill all questions in Scorecard");  
            filled=0;
            return false;
        }
    if(filled==1){
    var formdata=JSON.stringify(result_arr);
      var id=<?php echo $update_id?>;
        $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>scorecard/submit_pending_scorecard",
            data: {'id': id,'result_arr':formdata},
            async: false,
            success: function() {
                window.location = "<?php echo ADMIN_BASE_URL.'scorecard/pending_scorecard'; ?>";
            }
        });
    }
    });
      $(".check_color").click(function(){
        $(this).parent().find('.check_color').prop("checked", false);
        $(this).prop("checked", true);
      var quest_id=$(this).attr('data-quest-id'); 
      var ans_id=$(this).attr('data-ans-id');
      var points=$(this).attr('data-points');
      if($(this).is(":checked")) {
        if(result_arr!="")
          {
            exist=0;
            for (i = 0; result_arr.length> i; i += 1) {
        		if (result_arr[i].questId === quest_id) {
        		    exist=1;
        		    result_arr[i].ansId=ans_id;
        		    result_arr[i].points=points;
        		}
            }
            if(exist==0)
            {
                result_arr.push({questId:quest_id,ansId:ans_id,points:points})
            }
        }
        else
        {
            result_arr.push({questId:quest_id,ansId:ans_id,points:points})
        }
      }
    });
</script>
