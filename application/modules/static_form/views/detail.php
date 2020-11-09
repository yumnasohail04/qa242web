<div class="page-content-wrapper">
<?php
$check_id = 0;
if(isset($static_form[0]['sf_id']) && !empty($static_form[0]['sf_id']))
    $check_id = $static_form[0]['sf_id'];
?>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                            <div class="form-body">       
                                  <table id="datatable1" class="table table-bordered">
                                        <tbody class="table-body">
                                          <tr class="bg-col">
                                              <th>
                                                  Check Name:
                                              </th>
                                              <td>
                                                <?php $name=''; if(isset($static_form[0]['sf_name']) && !empty($static_form[0]['sf_name'])) $name=$static_form[0]['sf_name']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name; ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Inspection Team:
                                              </th>
                                              <td>
                                                  <?php 
                                                  $inspection_team = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sci_check_id'=>$check_id),'sci_id desc','sci_id',DEFAULT_OUTLET.'_static_checks_inspection','sci_check_id,sci_team_id','1','0','','','')->result_array();
                                                  if(!empty($inspection_team)) {
                                                    foreach ($inspection_team as $key => $it):
                                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array('id'=>$it['sci_team_id']), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
                                                        $name=''; if(isset($review_user_detail[0]['group_title']) && !empty($review_user_detail[0]['group_title'])) $name=$review_user_detail[0]['group_title']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name.", ";
                                                    endforeach;
                                                  }
                                                  ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Review Team:
                                              </th>
                                              <td>
                                                  <?php 
                                                    $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array('id'=>$static_form[0]['sf_reviewer']), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
                                                    $name=''; if(isset($review_user_detail[0]['group_title']) && !empty($review_user_detail[0]['group_title'])) $name=$review_user_detail[0]['group_title']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name;
                                                  ?>
                                              </td>
                                          </tr>
                                          <tr class="bg-col">
                                              <th>
                                                  Approver Team:
                                              </th>
                                              <td>
                                                  <?php 
                                                    $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array('id'=>$static_form[0]['sf_approver']), 'id desc',DEFAULT_OUTLET.'_groups','id,group_title','1','0')->result_array();
                                                    $name=''; if(isset($review_user_detail[0]['group_title']) && !empty($review_user_detail[0]['group_title'])) $name=$review_user_detail[0]['group_title']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name;
                                                  ?>
                                              </td>
                                          </tr>
                                            <?php if(isset($static_form[0]['is_dates']) && !empty($static_form[0]['is_dates'])) { ?>
                                                <tr class="bg-col">
                                                    <th>
                                                        Start DateTime:
                                                    </th>
                                                    <td>
                                                        <?php if(isset($static_form[0]['sf_start_datetime']) && !empty($static_form[0]['sf_start_datetime'])) {
                                                            echo date('m-d-Y H:i:s',strtotime($static_form[0]['sf_start_datetime'])); 
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr class="bg-col">
                                                <th>
                                                    Status:
                                                </th>
                                                <td>
                                                    <?php if(isset($static_form[0]['sf_start_datetime']) && !empty($static_form[0]['sf_start_datetime'])) 
                                                        echo "Active";
                                                        else
                                                            echo "Un Active"; ?>
                                                </td>
                                            </tr>
                                      </tbody>
                                </table>
                            </div>
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


