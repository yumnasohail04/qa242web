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
</style>
<div class="page-content-wrapper">
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
                        <?php foreach($card as $key => $post){ ?>
                       <legend> ScoreCard Detail</legend>
                            <div class="form-body">
                                     <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Supplier name:
                                              </th>
                                              <td>
                                                  <?php echo $post['name']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                 Completed at:
                                              </th>
                                              <td>
                                                  <?php echo $post['at_reviewed_date']; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Points:
                                              </th>
                                              <td><?php echo number_format((float)$post['total_percentage'], 0, '.', '').'%'; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Status:
                                              </th>
                                              <td> <?php if($post['audit']=="1"){  echo "Facility Visit Needed"; }else if($post['audit']=="0"){ echo "Not Approved for 3 Years"; } else { echo "Approved";} ?>
                                              </td>
                                          </tr>
                                          <?php if($post['audit']=="1"){ ?>
                                          <tr class="bg-col">
                                              <th style="color: #6c9cde!important;">
                                                  Comments:
                                              </th>
                                              <td> <?php echo $post['comments']; ?>
                                              </td>
                                          </tr>
                                          <?php  } ?>
                                      </tbody>
                                    </table>
                                </div>
                            <legend>Questions</legend>
                            <div class="form-body">
                                     <table id="datatable1" class="table table-bordered">
                                         <thead class="bg-th">
                                            <tr class="bg-col">
                                              <th >Question</th>
                                              <th >Description</th>
                                              <th >Review Team</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body">
                                            <?php             
                								$type="";
                                                $ingredient="";
                                               foreach($post['questions'] as $keys => $ques){
                                               $file="";
                								if($ques['type']!=$type)
                									{ 
                										$type=$ques['type']; ?>
                                        			<tr class="bg-col">
                                                    	<td></td>
                 										<td><legend><?php echo $ques['type']." Section"?></legend></td>
                                                    	<td></td>
                                        			</tr>
                									<?php }
                                               if($ques['ingredient']!=$ingredient)
                									{ 
                										$ingredient=$ques['ingredient']; ?>
                                        			<tr class="bg-col">
                                                    	<td><legend style="border:none;"><?php echo $ques['ingredient']?></legend></td>
                 										<td></td>
                                                    	<td></td>
                                        			</tr>
                									<?php } ?>
                                              <tr class="bg-col">
                                          		<?php
                                                    if($ques['type']=="Document")
                                                        if(!empty($ques['doc']) && isset($ques['doc']))
                                                            if(file_exists(SUPPLIER_DOCUMENTS_PATH.$ques['doc']))
                                                                $file=BASE_URL.SUPPLIER_DOCUMENTS_PATH.$ques['doc'];
                                               if($file!=""){?>
                                                    <td title="Download"><a  href="<?php echo $file ?>" download ><?php echo $ques['question']; ?></a></td>
                                          	  <?php } else{ ?>
                                                   <td title="No document Uploaded"><?php echo $ques['question']; ?></td>
                                              <?php } ?>
                                              <td><?php echo $ques['sfq_description']; ?></td>
                                              <?php 
                                                 if($ques['answers_review']['sfa_answer']=="Red")
                                                    $color="#e84e4e";
                                                    if($ques['answers_review']['sfa_answer']=="Green")
                                                    $color="#69b969";
                                                    if($ques['answers_review']['sfa_answer']=="Yellow")
                                                    $color="#ecec4c";
                                                    ?>
                                                    <td class="form-group">
                                                        <input  type="checkbox" id="html"  class="check_color" disabled>
                                                        <label for="html"  style="background-color:<?php echo $color; ?>"></label>
                                                    </td>
                                          </tr>
                                        <?php } ?>
                                      </tbody>
                                    </table>
                                </div>
                        <?php } 
                        ?>
                        <!-- END FORM-->
                        <div class="row ">
                            <legend></legend>
                                     <table id="datatable1" class="table table-bordered">
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
                                              <td><?php echo round(number_format($value['percentage'], 1, '.', ''),2).'/'.round(number_format($value['points'], 1, '.', ''),2); ?></td>
                                              <td><?php   $score=($value['percentage']/$value['points'])*100; echo round(number_format($score, 1, '.', ''),2).'%'; ?></td>
                                          </tr>
                                          <?php } ?>
                                      </tbody>
                                    </table>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!--    </div>-->
</div>
</div>


