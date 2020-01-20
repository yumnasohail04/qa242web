<style type="text/css">
.wrapclone  {
    border: 1px dotted;
    float: left;
    width: 100%;
    padding: 20px 0px 10px 0px;
    position: relative;
    margin-bottom:5px; 
  }
.clone-remover {
    position: absolute;
    top: 0;
    padding: 3px 5px 4px 5px;
    border: 1px solid #ddd;
    border-radius: 50%;
    box-shadow: 0px 0px 6px 0px #ddd;
  }
  .redborder {
    border:1px solid red;
  }
  .append-cat-data {
    border: 1px dashed #23b7e5;
    float: left;
    padding: 20px;
    margin-bottom: 20px;
    width: 100%;
    position: relative;
  }
  .removedealsitem {
    font-size: 15px;
    position: absolute;
    right: -10px;
    top: -10px;
    padding-left: 8px;
    padding-right: 7px;
    border-radius: 50%;
    background-color: white;
    cursor: pointer;
    box-shadow: 1px 2px 2px 1px rgba(128, 128, 128, 0.9);
  }
</style><div class="page-content-wrapper">
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
                    $strTitle = 'Add Post';
                else 
                    $strTitle = 'Edit Post';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'test'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
       </h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
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
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'test/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'test/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                    

                        
                    <div class="row">
                      <div class="col-sm-5" style="margin-left: 15px;">
                        <div class="form-group">
                          <?php
                          $data = array(
                          'name' => 'test_name',
                          'id' => 'test_name',
                          'class' => 'form-control validatefield',
                          'type' => 'text',
                          'value' => $news['test_name']
                          );
                          $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Test   ', 'txtPhone', $attribute); ?>
                          <div class="col-md-8">
                          <?php echo form_input($data); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <fieldset class="append-mainn">
                    <span class="append-cat-data">
                    <span class="removedealsitem">x</span>
                        <div class="col-sm-5">
                          <div class="form-group">
                            <?php
                            $data = array(
                            'name' => 'question[]',
                            'id' => 'question',
                            'class' => 'form-control question validatefield',
                            'type' => 'text',
                            'value' => ""
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                            <?php echo form_label('question   ', 'txtPhone', $attribute); ?>
                            <div class="col-md-8">
                            <?php echo form_input($data); ?>
                            </div>
                          </div>
                          <input type="hidden" name="updated_value[]" value="">
                        </div>
                        <div class="col-sm-5">
                          <div class="form-group">
                            <?php
                            $data = array(
                            'name' => 'answer[]',
                            'id' => 'answer',
                            'class' => 'form-control answer validatefield',
                            'type' => 'text',
                            'value' => ""
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                            <?php echo form_label('answer   ', 'txtPhone', $attribute); ?>
                            <div class="col-md-8">
                            <?php echo form_input($data); ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="lstRank" class="control-label  col-md-6">
                                    <button class="btn btn-info savecat">Save</button>
                                </label>
                            </div>
                        </div>
                    </span>
                    
                    </fieldset>
                    <fieldset>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label for="lstRank" class="control-label  col-md-4">
                                <button class="btn btn-info clone-cat">More</button>
                            </label>
                        </div>
                    </div>
                    </fieldset>



                     
                   

                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'test'; ?>">
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
    savecat();
    function savecat(){
      $('.savecat').off('click').click(function(e){
        e.preventDefault();
        var check = true;
        $parent = $(this).parent().parent().parent().parent();
        $question= $parent.find('.question');
        var question = $question.val();
        if(question){
            $question.css("border", "1px solid #dde6e9");
            $answer= $parent.find('.answer');
            $vehicle_body= $parent.find('.vehicle_body');
            var answer = $answer.val();
            var vehicle_body = $vehicle_body.val();
            if(answer){
                $answer.css("border", "1px solid #dde6e9");
                console.log("answer ha");
            } else {
                $answer.addClass('redborder');
                toastr.warning('Please fill all select boxes');
                check = false;
                return;
            }
        } else {
            alert('Please fill the question');
            $question.addClass('redborder');
            toastr.warning('Please fill all select boxes');
            check = false;
            return;
        }
        if(check){
          var questioncheck = true;
          var currentquestion = $parent.find('.question').val();
          var length = $(".savecat").index(this);
          $('input[name="question[]"]').map(function(idx, elem){
              if($(elem).val() == currentquestion && idx != length){
                  questioncheck = false;
              }
          })
          if(!questioncheck){
              toastr.warning('Cannt add same question');
          } else {
              $('.redborder').removeClass('redborder');
              $parent.attr('check','true');
              $parent.find('.question').attr('readonly','readonly');
              $parent.find('.answer').attr('readonly','readonly');
              $parent.find('.savecat').attr('disabled','disabled');
          }
        }
      })
    }

    $('.clone-cat').off('click').click(function(e){
        e.preventDefault();
        var check = true;
        $('.append-cat-data').each(function(){
            if(!$(this).attr('check')){
                check = false;
            }
        })
        if(check){
            appenddivcat();
        } else {
            toastr.warning('Please correctly fill previous fileds first ');
        }
    })

  

      function appenddivcat(){
        var data = '<span class="append-cat-data"> <span class="removedealsitem">x</span><div class="col-sm-5"><div class="form-group"> <label for="txtPhone" class="control-label col-md-4">question </label><div class="col-md-8"> <input type="text" name="question[]" value="" id="question" class="form-control question validatefield"></div></div><input type="hidden" name="updated_value[]" value=""></div><div class="col-sm-5"><div class="form-group"> <label for="txtPhone" class="control-label col-md-4">answer </label><div class="col-md-8"> <input type="text" name="answer[]" value="" id="answer" class="form-control answer validatefield"></div></div></div><div class="col-sm-2"><div class="form-group"> <label for="lstRank" class="control-label col-md-6"> <button class="btn btn-info savecat">Save</button> </label></div></div></span>';
         $('.append-mainn').append(data);
        removedealsitem();
        savecat();
      }
      function removedealsitem() {
        $('.removedealsitem').off('click').click(function(){
            if($('.append-cat-data').length > 1){
                $(this).parent().remove();
            }
        })
      }
      removedealsitem();

      var datasubmit=null;   
      $('.form-horizontal').submit(function(e){
        e.preventDefault();
        if(validateForm()){
          var self = this;
          if($('.append-cat-data').length >= 1){
            var checking = true;
            $('.append-cat-data').each(function(){
                if(!$(this).attr('check')){
                  checking = false;
                } 
            });
            if(checking == true)
              self.submit();
            else
                toastr.warning('Please correctly fill all fields first');
          } else {
              toastr.warning('Form can not be submit');
          }
        }
      })
      function validateForm() {
        var isValid = true;
        $('.validatefield').each(function() {
          if ( $(this).val() === '') {
             $(this).css("border", "1px solid red");
            isValid = false;
          }
          else 
              $(this).css("border", "1px solid #dde6e9");
        });
        return isValid;
      }
</script>

