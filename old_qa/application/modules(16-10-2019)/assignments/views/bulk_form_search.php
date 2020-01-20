    <div>
        <datamain>
            <?php
            $i = 0;
            if (isset($inspection)) {
                foreach ($inspection->result() as
                        $new) {
                    $i++;
                    ?>
                <trr  id="Row_<?=$new->bfi_id?>" class="odd gradeX "  >
                    <tdd class="text-center">
                        <?php echo date('m-d-Y',strtotime($new->bfi_datetime)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo date('H:i:s',strtotime($new->bfi_datetime)); ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php 
                            if(isset($new->bfi_initial) && !empty($new->bfi_initial))
                            $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$new->bfi_initial),'id desc','users','first_name,last_name','1','1')->result_array();
                            $fisrt_name=''; 
                            if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                              $fisrt_name=$review_user_detail[0]['first_name']; 
                            $last_name=''; 
                            if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                              $last_name=$review_user_detail[0]['last_name']; 
                            $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name; 
                        ?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo $new->bfi_item;?>
                    </tdd>
                    <tdd class="text-center">
                        <?php echo $new->bfi_status;?>
                    </tdd>
                    <tdd>
                        <a class="btn yellow c-btn view_details" rel="<?=$new->bfi_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                    </tdd>
                </trr>
                <?php } ?>    
            <?php } ?>
        </datamain> 
        <pagenumber><?php if(isset($page_number) && is_numeric($page_number)) echo $page_number; else echo "0"; ?></pagenumber><totalpage><?php if(isset($total_pages) && is_numeric($total_pages)) echo $total_pages; else echo "0"; ?></totalpage>
    </div>