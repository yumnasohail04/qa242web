    <div>
        <datamain>
             <?php
                                $i = 0;
                                if (isset($result)) {
                                    foreach ($result  as $key => $value) {
                                        $i++;
                                        ?>
                                    <trr  id="Row_<?= $value['assign_id']; ?>" class="odd gradeX "  >
                                        <tdd class="text-center">
                                            <?php echo $value['complete_datetime']; ?>
                                        </tdd>
                                        <tdd class="text-center">
                                            <?php echo $value['check_name']; ?>
                                        </tdd>
                                        <tdd class="text-center">
                                            <?php echo $value['group'];?>
                                        </tdd>
                                        <tdd class="text-center">
                                            <?php echo $value['assign_status'];?>
                                        </tdd>
                                        <tdd>
                                            <a class="btn yellow c-btn view_details" rel="<?=$value['assign_id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
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