<div>
    <datamain>
        <?php $i = 0;
        if (isset($news)  && !empty($news->result_array())) {
            foreach ($news->result() as $new):
                $i++;?>
                <trr id="Row_<?=$new->assign_id?>" class="odd gradeX " >
                    <tdd class="text-center">
                        <?php echo date('m-d-Y H:i',strtotime($new->start_datetime)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo date('m-d-Y H:i',strtotime($new->end_datetime)); ?>
                    </tdd>
                    <tdd class="text-center">
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
                    </tdd>
                    <?php if($assign_status == 'active_checks' || $assign_status == 'today_checks' || $assign_status == 'overdue_checks'){ ?>
                    <tdd class="text-center">
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
                    </tdd>
                    <?php } ?>
                	<tdd class="text-center">
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
                    </tdd>
                    <?php if($assign_status == 'today_checks') { ?>
                    <tdd class="text-center">
                        <?php echo $new->assign_status; ?>
                    </tdd>
                    <?php }?>
                    <tdd>
                    	<?php
                        	$key = array_search($new->program_type, array_column($program_type, 'program_id'));
                            if (is_numeric($key)) 
                            	echo $program_type[$key]['program_name'];
                        ?>
                    </tdd>
                </trr>
            <?php endforeach;
        }
        ?>
        </datamain> 
        <pagenumber><?php if(isset($page_number) && is_numeric($page_number)) echo $page_number; else echo "0"; ?></pagenumber><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage>
    </div>