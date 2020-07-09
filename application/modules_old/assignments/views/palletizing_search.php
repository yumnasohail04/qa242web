    <div>
        <datamain>
            <?php
            $i = 0;
            if (isset($inspection)) {
                foreach ($inspection->result() as
                        $new) {
                    $i++;
                    ?>
                <trr  id="Row_<?=$new->pi_id?>" class="odd gradeX "  >
                    <tdd class="text-center">
                        <?php echo date('m-d-Y',strtotime($new->pi_time)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo date('H:i:s',strtotime($new->pi_time)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo wordwrap( $new->pi_item_number , 50 , "<br>\n");?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo $new->pi_cases;?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo $new->pi_status;?>
                    </tdd>
                    <tdd>
                        <a class="btn yellow c-btn view_details" rel="<?=$new->pi_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                    </tdd>
                </trr>
                <?php } ?>    
            <?php } ?>
        </datamain> 
        <pagenumber><?php if(isset($page_number) && is_numeric($page_number)) echo $page_number; else echo "0"; ?></pagenumber><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage>
    </div>