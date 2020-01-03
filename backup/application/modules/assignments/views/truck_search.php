    <div>
        <datamain>
            <?php
            $i = 0;
            if (isset($inspection)) {
                foreach ($inspection->result() as
                        $new) {
                    $i++;
                    ?>
                <trr  id="Row_<?=$new->ti_id?>" class="odd gradeX "  >
                    <tdd class="text-center">
                        <?php echo date('m-d-Y',strtotime($new->ti_datetime)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo date('H:i:s',strtotime($new->ti_datetime)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo wordwrap( $new->ti_monitor_name , 50 , "<br>\n");?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo $new->ti_item_name;?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo $new->ti_status;?>
                    </tdd>
                    <tdd>
                        <a class="btn yellow c-btn view_details" rel="<?=$new->ti_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                    </tdd>
                </trr>
                <?php } ?>    
            <?php } else { ?>
                <trr class="odd">
                    <tdd valign="top" colspan="6" class="dataTables_empty">
                        No data available in table
                    </tdd>
                </trr>
            <?php } ?>
        </datamain> 
        <pagenumber><?php if(isset($page_number) && is_numeric($page_number)) echo $page_number; else echo "0"; ?></pagenumber><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage>
    </div>