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

.check_color
{
  background-color: #6d9cde;
    color: white;
}
.form-group
{
  min-height: 70px;
}

.new {
  padding: 50px;
}

.form-group {
  display: flex;
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
    border-radius: 5px;
}

.form-group label:before {
    content: '';
    -webkit-appearance: none;
    background-color: transparent;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
    padding: 10px;
    display: inline-block;
    position: relative;
    vertical-align: middle;
    cursor: pointer;
    margin-right: 5px;
    width: 40px;
    height: 40px;
    /* border-radius: 30px; */
}

.form-group input:checked + label:after {
    content: '';
    display: block;
    position: absolute;
    top: 9px;
    left: 19px;
    width: 10px;
    height: 19px;
    border: 0px solid #ffffff;
    border-width: 0px 2px 2px 0;
    transform: rotate(45deg);
}
.containerz
{
    width: 55%; 
    margin: 0 auto;
}

</style>
        <main>
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <h1> 
                  <?php 
                    $strTitle = 'Fill ScoreCard';
                    echo $strTitle;
                    ?></h1>
                <div class="separator mb-5"></div>
              </div>
            </div>
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="mb-4">
                  </h5>
                  
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
                    
                 <h3 class="form-section view_supplier" style="cursor:pointer;text-transform: capitalize;" rel="<?php echo $supplier['supplier_id']; ?>"><?php echo $supplier['name'].' Scorecard'; ?></h3>
                
                <div class="row new">
                <?php
                  $count=0;
                  $type="";
                  $ingredient="";
                  $divider=round(count($questions)/2);
                  foreach($questions as $key => $value){ 

                  $file="";
                  $count++;
                  if($value['type']!=$type)
                  { 
                  $type=$value['type'];
                  ?>
                  <legend><?php echo $value['type']." Section"?></legend>
                  <?php if($value['type']=="Ingredient"){?>
                  <legend>Average Ingredient score = <?php echo number_format((float)$ing_percent, 0, '.', '').'%';?></legend>
                  <?php 
                  }
                }
                  ?>
                  <?php if($value['type']=="Ingredient"){?>
                  <?php
                      if($value['ingredient']!=$ingredient)
                              { $ingredient=$value['ingredient'];
                          ?>
                            <legend><span class="view_details" style="cursor:pointer" rel="<?php echo $value['ingredient_id']?>"><?php echo $value['ingredient'];?></span></legend>
                        <?php
                              }
                      }
                      ?>
                      <div class="col-md-12">
                          <div class="form-group">
                              <div class="col-md-10">
                              <?php
                                  if($value['type']=="Document")
                                      if(!empty($value['doc']) && isset($value['doc']))
                                            if(file_exists(SUPPLIER_DOCUMENTS_PATH.$value['doc']))
                                                $file=BASE_URL.SUPPLIER_DOCUMENTS_PATH.$value['doc'];
                                  if($file!=""){?>
                                    <p title="Download" style="color: #2f69b7;"><span><?php echo $count;?>. </span><a href="<?php echo $file; ?>" download ><?php echo $value['question']; ?></a></p>
                                <?php }else{ ?>
                                    <p title="No document uploaded" style="color: #2f69b7;"><span><?php echo $count;?>. </span><?php echo $value['question']; ?></p>
                                <?php }?>
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
                          </div>
                      </div>
                      <?php } ?>
                      <h3 style="margin:2% 0% 2% 0%;"> Average Teams Result </h3>
                      <div class="col-md-12">
                        <div class="form-group">
                            <table id="" class="table table-bordered">
                                <thead class="bg-th">
                                  <tr class="bg-col">
                                    <th >Team</th>
                                    <th >User</th>
                                    <th >Reviewed Date</th>
                                    <th >Score</th>
                                    <th>Percent compliance</th>
                                  </tr>
                              </thead>
                              <tbody class="table-body">
                              <?php foreach($team_data as $key => $value){ ?>
                                <tr class="bg-col">
                                    <td><?php echo $value['group_title']; ?></td>
                                    <td><?php echo $value['first_name'].' '.$value['last_name']; ?></td>
                                    <td><?php echo $value['reviewed_date']; ?></td>
                                    <td><?php echo round(number_format((float)$value['percentage'], 1, '.', ''),2).'/'.round(number_format((float)$value['points'], 1, '.', ''),2); ?></td>
                                    <td><?php   $score=($value['percentage']/$value['points'])*100; echo round(number_format((float)$score, 1, '.', ''),2).'%'; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                    </div>
                  </div>
                  <div style="margin:0 auto; width:70%;">
                  <div class="col-md-12"><h3 > Provide your Feedback </h3></div>
                    
                      <?php foreach($questions_approv as $key => $value){ ?>
                                <div class="form-group col-sm-12">
                                    <div class="col-md-8">
                                        <p><?php echo $value['question']; ?></p>
                                        <p style="font-size:16px;"><?php echo $value['detail']; ?></p>
                                    </div>
                                    <div class="col-md-4" >
                                        <input  type="checkbox" id="html1<?php echo $key ?>" data-ans-id="2" data-quest-id="<?php echo $value['id'] ?>" class="check_color" >
                                        <label for="html1<?php echo $key ?>"  style="background-color:#69b969"></label>
                                        <input  type="checkbox" id="html2<?php echo $key ?>" data-ans-id="1" data-quest-id="<?php echo $value['id'] ?>" class="check_color" >
                                        <label for="html2<?php echo $key ?>"  style="background-color:#ecec4c"></label> 
                                        <input  type="checkbox" id="html3<?php echo $key ?>" data-ans-id="0" data-quest-id="<?php echo $value['id'] ?>" class="check_color" >
                                        <label for="html3<?php echo $key ?>"  style="background-color:#e84e4e"></label> 
                                    </div>
                                </div>
                            <?php } ?>
                          <div class="col-md-12">
                              <div class="form-group">
                               
                                      <textarea class="form-control" placeholder="Comment here" name="comments" id="approv_comments"></textarea>    
                              </div>
                          </div>
                  </div>
                </div> 
              </div> 
            </div>
                <div class="form-actions fluid no-mrg containerz">
                  <div class="row new">
                    <div class="col-md-12">
                      <div style="text-align: center;">
                       <span ></span> <button class="btn btn-outline-primary submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'scorecard'; ?>">
                        <button type="button" class="btn green btn-outline-primary" ><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
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
    
      var qa,filled,exist,i, result_arr=[];
      $(document).off('click', '.submited_form').on('click', '.submited_form', function(e){
      e.preventDefault();
        filled=1;qa=0;
        <?php $length=count($questions_approv);?>
        if(<?php echo $length ?>==result_arr.length)
        {
            qa=1;
        }
        if(qa==0){
            toastr.error("Fill all questions in Scorecard");  
            filled=0;
            return false;
        }
        var comments=$('#approv_comments').val();
        if(filled==1 ){
          if(comments!=''){
        var formdata=JSON.stringify(result_arr);
          var id=<?php echo $update_id?>;
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>scorecard/submit_pending_scorecard",
                data: {'id': id,'result_arr':formdata,'comments':comments},
                async: false,
                success: function() {
                    window.location = "<?php echo ADMIN_BASE_URL.'scorecard/pending_scorecard'; ?>";
                }
            });
          }
          else
          toastr.error("Please provide some comments");
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
      $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>ingredients/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                       var test_desc = test_body;
                         $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-body").html(test_desc);
                          
                         
 
                     }
                    });
            });
  $(document).on("click", ".view_supplier", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>supplier/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                       var test_desc = test_body;
                         $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-body").html(test_desc);
                          
                         
 
                     }
                    });
            });
</script>
