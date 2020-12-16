  
     
             <?php
                                $i = 0;
                                if (isset($result)) {?>
                                   <table class="data-table data-table-feature">
                            <thead class="bg-th">
                                <tr class="bg-col">    
                                <?php if(strtolower($assign_status) == 'reviewed'){ ?>
                                	<th class="text-center" style="width:120px;">Review Datetime <i class="fa fa-sort" style="font-size:13px;"></th>
                                <?php } ?>
                                     <?php if(strtolower($assign_status) == 'approved'){ ?>
                                	<th class="text-center" style="width:120px;">Approval Datetime <i class="fa fa-sort" style="font-size:13px;"></th>
                                <?php } ?>
                                    <th class="text-center" style="width:120px;">Inspection Datetime <i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center"style="width:200px;" >Check Name<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:200px;">Inspection Group<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <?php
                                    if(isset($assign_status) && !empty($assign_status)) {
                                        if(strtolower($assign_status)  == 'approved' || strtolower($assign_status)  == 'reviewed') { ?>
                                            <th class="text-center" style="width:200px;">Reviewer<i class="fa fa-sort" style="font-size:13px;"></th>
                                        <?php }
                                        if(strtolower($assign_status)  == 'approved') { ?>
                                            <th class="text-center" style="width:200px;">Approver<i class="fa fa-sort" style="font-size:13px;"></th>
                                        <?php }
                                    }
                                    ?>
                                    <th class="text-center"style="width:200px;" >Status<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:500px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody >
                                  <?php foreach ($result  as $key => $value) {
                                        $i++;
                                        ?>
                                    <tr  id="Row_<?= $value['assign_id']; ?>" class="odd gradeX "  >
                                    <?php if(strtolower($assign_status) == 'reviewed'){ ?>
                                	<td class="text-center">
                                            <?php echo $value['review_datetime']; ?>
                                        </td>
                                <?php } ?>
                                     <?php if(strtolower($assign_status) == 'approved'){ ?>
                                	<td class="text-center">
                                            <?php echo $value['approval_datetime']; ?>
                                        </td>
                                <?php } ?>
                                        <td class="text-center">
                                            <?php echo $value['complete_datetime']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $value['check_name']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $value['group'];?>
                                        </td>
                                        <?php
                                        if(isset($assign_status) && !empty($assign_status)) {
                                            if(strtolower($assign_status)  == 'approved' || strtolower($assign_status)  == 'reviewed') { ?>
                                                <td class="text-center">
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
                                                </td>
                                            <?php }
                                            if(strtolower($assign_status)  == 'approved') { ?>
                                                <td class="text-center">
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
                                                </td>
                                            <?php }
                                        }
                                        ?>
                                        <td class="text-center">
                                            <?php echo $value['assign_status'];?>
                                        </td>
                                        <td>
                                            <a class="btn yellow c-btn view_details" rel="<?=$value['assign_id']?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>  
                            
                            </tbody>
                        </table>
                                <?php } else { ?>
                <tr class="odd">
                    <td valign="top" colspan="6" class="dataTables_empty">
                        No data available in table
                    </td>
                </tr>
            <?php } ?>
                            
  