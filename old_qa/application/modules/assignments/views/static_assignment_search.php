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
                                        <?php
                                        if(isset($assign_status) && !empty($assign_status)) {
                                            if(strtolower($assign_status)  == 'approved' || strtolower($assign_status)  == 'reviewed') { ?>
                                                <tdd class="text-center">
                                                    <?php 
                                                    if(isset($value['review_user']) && !empty($value['review_user'])) {
                                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$value['review_user']),'id desc','users','first_name,last_name','1','1')->result_array();
                                                        $fisrt_name=''; 
                                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                                        $last_name=''; 
                                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                                          $last_name=$review_user_detail[0]['last_name']; 
                                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name;   
                                                    }
                                                    ?>
                                                </tdd>
                                            <?php }
                                            if(strtolower($assign_status)  == 'approved') { ?>
                                                <tdd class="text-center">
                                                    <?php 
                                                    if(isset($value['approval_user']) && !empty($value['approval_user'])) {
                                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$value['approval_user']),'id desc','users','first_name,last_name','1','1')->result_array();
                                                        $fisrt_name=''; 
                                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                                        $last_name=''; 
                                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                                          $last_name=$review_user_detail[0]['last_name']; 
                                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name;   
                                                    }
                                                    ?>
                                                </tdd>
                                            <?php }
                                        }
                                        ?>
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