<div>
    <datamain>
        <?php $i = 0;
        if (isset($product_schedule) && !empty($product_schedule)) {
            $counter = 1;
            foreach ($product_schedule as $keyy=>$produc):?>
                <trr id="Row_<?=$counter?>" class="backgroud-blue ">
                    <tdd class="border_color_blue" style="border-right:none !important;"><?=$produc['day']?>(<?=$produc['date']?>)</tdd>
                    <tdd class="border_color_blue" style="border:none !important;"></tdd>
                    <tdd class="border_color_blue" style="border:none !important;"></tdd>
                    <tdd class="border_color_blue" style="border:none !important;"></tdd>
                    <tdd class="border_color_blue" style="border:none !important;"></tdd>
                    <tdd class="border_color_blue" style="border:none !important;"></tdd>
                </trr>
                <?php if(isset($produc['data']) && !empty($produc['data'])) {
                    foreach ($produc['data'] as $key => $pro): ?>
                        <trr  id="Row_<?=$counter?>" class="odd gradeX " >
                            <tdd class="text-center">
                                <?=$pro['navision_no'];?>
                            </tdd>
                            <tdd class="text-center">
                                <?=$pro['product_title'];?>
                            </tdd>
                            <tdd class="text-center">
                                <?php $get_ppt = Modules::run('api/_get_specific_table_with_pagination',array('ppt_product_id'=>$pro['ps_product']), 'ppt_id desc',DEFAULT_OUTLET.'_product_program_type','ppt_program_id','1','0')->result_array();
                                    $counter = 1;
                                    if(!empty($get_ppt)) {
                                        foreach ($get_ppt as $key => $gppt):
                                            if(!empty($gppt['ppt_program_id'])) {
                                                $key = array_search($gppt['ppt_program_id'], array_column($program_type, 'program_id'));
                                                if (is_numeric($key)) {
                                                    if($counter >1)
                                                        echo ",";
                                                    echo $program_type[$key]['program_name'];
                                                    $counter++;
                                                }
                                            }
                                        endforeach;
                                    }
                                ?>
                            </tdd>
                            <tdd class="text-center">
                                <?=$pro['storage_type'];?>
                            </tdd>
                            <tdd class="text-center"><?php if(!empty($pro['ps_line'])) { 
                                $line_name = Modules::run('api/_get_specific_table_with_pagination',array('line_id'=>$pro['ps_line']), 'line_id asc',DEFAULT_OUTLET.'_lines','line_name','1','1')->result_array(); if(isset($line_name[0]['line_name']) && !empty($line_name[0]['line_name'])) echo $line_name[0]['line_name']; }?>
                            </tdd>
                            <tdd class="text-center">
                                <?php
                                    echo anchor('"javascript:;"', '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'rel' => $pro['ps_id'],'start_date' => $pro['ps_date'],'product' => $pro['ps_product'],'line' => $pro['ps_line'], 'title' => 'Edit Product'));
                                    echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn  c-btn', 'rel' => $pro['ps_id'], 'title' => 'Delete Product'));
                                ?>
                            </tdd>
                        </trr>
                        <?php $counter++;
                    endforeach;
                }
                else {
                    $counter++; ?>
                    <trr  id="Row_<?=$counter?>" class="odd gradeX " >
                        <tdd class="text-center" style="border:none !important;text-align: right">
                        </tdd>
                        <tdd class="text-center red-color" style="border:none !important;text-align: right;font-weight:bold;">No schedules for the day</tdd>
                        <tdd class="text-center" style="border:none !important;"></tdd>
                        <tdd class="text-center" style="border:none !important;"></tdd>
                        <tdd class="text-center" style="border:none !important;"></tdd>
                        <tdd class="text-center" style="border:none !important;"></tdd>
                    </trr>
                <?php }
            endforeach;
        }
        else { ?>
                <trr class="odd">
                    <tdd valign="top" colspan="6" class="dataTables_empty">
                        No data available in table
                    </tdd>
                </trr>
            <?php } ?>
        </datamain> 
        <pagenumber><?php if(isset($page_number) && is_numeric($page_number)) echo $page_number; else echo "0"; ?></pagenumber><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage>
    </div>