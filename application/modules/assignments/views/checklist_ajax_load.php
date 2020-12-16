
        <?php $i = 0;
        if (isset($news)  && !empty($news->result_array())) {
        ?>
 <table class="data-table data-table-feature">
                              <thead class="bg-th">
                                <tr class="bg-col">
                                    <th class="text-center"  style="width:120px;">
                                        Start Time <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center"  style="width:120px;">
                                        End Time <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center" style="width:200px;">
                                        Check Name <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center" style="width:200px;">
                                        Responsible Team <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                            Lines<i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                            Plant<i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <?php if($this->uri->segment(3) == 'today_checks'){ ?>
                                        <th class="text-center"style="width:200px;" >
                                            Status<i class="fa fa-sort" style="font-size:13px;"></i>
                                        </th>
                                        
                                    <?php }?>
                                    <th class="text-center" style="width:200px;" >
                                        Program Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody ><?php
            foreach ($news->result() as $new):
                $i++;?>
                <tr id="Row_<?=$new->assign_id?>" class="odd gradeX " >
                    <td class="text-center">
                        <?php echo date('m-d-Y H:i',strtotime($new->start_datetime)); ?>
                    </td>
                    <td class="text-center">
                        <?php echo date('m-d-Y H:i',strtotime($new->end_datetime)); ?>
                    </td>
                    <td class="text-center">
                        <?php 
                        $final_text = "";
                        if(isset($new->checkname) && !empty($new->checkname)) {
                            if(isset($like_search) && !empty($like_search)) {
                                $final_text = str_replace($like_search, '<span style="color:#daa732;">'.$like_search.'</span>', $new->checkname);
                            }
                            else
                                $final_text = $new->checkname;
                        }
                        echo $final_text;
                        ?>
                    </td>
                    <?php if($assign_status == 'active_checks' || $assign_status == 'today_checks' || $assign_status == 'overdue_checks'){ ?>
                    <td class="text-center">
                        <?php $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$new->checkid,'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                        $counter = 1;
                        if(!empty($get_inspection_team)) {
                            foreach ($get_inspection_team as $key => $git):
                                if(!empty($git['sci_team_id'])) {
                                    $key = array_search($git['sci_team_id'], array_column($groups, 'id'));
                                    if (is_numeric($key)) {
                                        if($counter >1)
                                            echo ",";
                                        echo $groups[$key]['group_title'];
                                        $counter++;
                                    }
                                }
                            endforeach;
                        }?>
                    </td>
                    <?php } ?>
                	<td class="text-center">
                        <?php if(isset($new->line_timing) && !empty($new->line_timing)) {
                            $line_timing = explode(",",$new->line_timing);
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
                            
                        } ?>
                    </td>
                   <td class="text-center">
                                                <?php if(isset($new->plant_no) && !empty($new->plant_no)) {
                                                            $plant_name = Modules::run('api/_get_specific_table_with_pagination',array('plant_id'=>$new->plant_no), 'plant_id desc',DEFAULT_OUTLET.'_plants','plant_name','1','1')->row_array();
                                                            if(!empty($plant_name['plant_name'])) {
                                                                echo $plant_name['plant_name'];
                                                            }

                                                } ?>
                                            </td>
                    <?php if($assign_status == 'today_checks') { ?>
                    <td class="text-center">
                        <?php echo $new->assign_status; ?>
                    </td>
                    <?php }?>
                    <td>
                    	<?php
                        	$key = array_search($new->program_type, array_column($program_type, 'program_id'));
                            if (is_numeric($key)) 
                            	echo $program_type[$key]['program_name'];
                        ?>
                    </td>
                </tr>
            <?php endforeach;
        ?>

                            </tbody>
                        </table>
<?php
        }
        ?>