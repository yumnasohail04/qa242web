<?php  if(isset($news) && !empty($news->result_array())){?> 
<thead class="bg-th">
                        <tr class="bg-col">
                        <th class="text-center" style="width:120px;">Start Time <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:120px;">End Time <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:200px;">Check Name <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" ><?php if(strtolower($assign_type) == 'completed_checks') echo 'Approved by'; else echo "Responsible Team"; ?> <i class="fa fa-sort" style="font-size:13px;"></th>
                         <?php if($assign_type == 'pending_review'){ ?>
                        <th class="text-center"style="width:200px;" >Work arround <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Completed By <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Completed Datetime <i class="fa fa-sort" style="font-size:13px;"></th>
                        <?}?>
                        <th class="text-center" style="width:500px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new) {
                                        $i++;
                                        ?>
                                    <tr id="Row_<?=$new->assign_id?>" class="odd gradeX " >
                                        <td class="text-center"><?php echo date('m-d-Y H:i',strtotime($new->start_datetime)); ?></td>
                                        <td class="text-center"><?php echo date('m-d-Y H:i',strtotime($new->end_datetime)); ?></td>
                                        <td class="text-center"><?php echo wordwrap( $new->checkname , 50 , "<br>\n");?></td>
                                       <?php if($assign_type == 'active_checks'){ ?>
                                       <td class="text-center">
                                           <?php $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$new->checkid,'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                            $counter = 1;
                                            if(!empty($get_inspection_team)) {
                                                foreach ($get_inspection_team as $key => $git):
                                                    if(!empty($git['sci_team_id'])) {
                                                        $key = array_search($git['sci_team_id'], array_column($groups, 'id'));
                                                        if (is_numeric($key)) {
                                                            if($counter > 1)
                                                                echo ",";
                                                            echo $groups[$key]['group_title'];
                                                            $counter++;
                                                        }
                                                    }
                                                endforeach;
                                            }?>
                                       </td>
                                       <?}?>
                                        <?php if($assign_type == 'overdue_checks'){ ?>
                                       <td class="text-center"><?php foreach($groups as $value): if($value['id']==$new->inspection_team) echo $value['group_title'] ; endforeach;?></td>
                                       <?}?>
                                        <?php if($assign_type == 'pending_review'){ ?>
                                       <td class="text-center"><?php foreach($groups as $value): if($value['id']==$new->review_team) echo $value['group_title'] ; endforeach;?></td>
                                       <?}?>
                                        <?php if($assign_type == 'pending_approval'){ ?>
                                       <td class="text-center"><?php foreach($groups as $value): if($value['id']==$new->approval_team) echo $value['group_title'] ; endforeach;?></td>
                                       <?}?>
                                        <?php if($assign_type == 'pending_review'){ ?>
                                       <td class="text-center"> <?php if(isset($new->work_arround)) echo $new->work_arround;?></td>
                                        <td class="text-center"> <?php if(isset($new->completed_by)) echo $new->completed_by;?></td>
                                         <td class="text-center"> <?php if(isset($new->completed_datetime)) echo $new->completed_datetime;?></td>
                                         
                                       <?}?>
                                       <?php if(strtolower($assign_type) == 'completed_checks'){ ?>
                                        <td class="text-center">
                                            <?php
                                            if(isset($new->assign_id) && !empty($new->assign_id)) {
                                                $assignment_answer = Modules::run('api/_get_specific_table_with_pagination',array("assign_id"=>$new->assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','approval_user','1','1')->result_array();
                                                if(isset($assignment_answer[0]['approval_user']) && !empty($assignment_answer[0]['approval_user'])) {
                                                    $users = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assignment_answer[0]['approval_user']),'id desc','users','user_name','1','1')->result_array();
                                                     $name=''; if(isset($users[0]['user_name']) && !empty($users[0]['user_name'])) $name= $users[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000',''); echo $name; 
                                                }
                                            }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <td class="table_action text-center">
                                             <?php if($assign_type == 'pending_review'){ ?>
                                            <?php $current_status= "";
            $outlet_status=array(""=>"Select Action","Approval"=>"Set To Approval","Check_again"=>'Check again');
            echo form_dropdown('order_status', $outlet_status, $current_status, 'class="add_on form-control select_action order_status" style="width:190px;" order_id="'.$new->assign_id.'"');?>
                <?}?>
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->assign_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fa fa-long-arrow-up"></i>';
                                        $iconbgclass = ' btn green c-btn';
                                        if ($new->assign_status != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fa fa-long-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>
                            <?php } ?>