<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>QA Checks</h1>
                <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="scheduled_checks/create">&nbsp;Add New&nbsp;</a>
                <div class="separator mb-5"></div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <table class="data-table data-table-feature">
                        <thead class="bg-th">
                        <tr class="bg-col" align="center" class="text-center">
                        <th class="text-center" style="display:none;"><b>S.no </b><i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="text-center"><b>Check Name </b><i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="text-center">Description<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="text-center">Frequency<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="text-center">Responsible Team<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="text-center">Responsible For Review<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="text-center">Approval Team<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="" style="width:198px;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new) {
                                        $i++;
                                        $set_publish_url = ADMIN_BASE_URL . 'scheduled_checks/set_publish/' . $new->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'scheduled_checks/set_unpublish/' . $new->id ;
                                        $edit_url = ADMIN_BASE_URL . 'scheduled_checks/create/' . $new->id ;
                                        $delete_url = ADMIN_BASE_URL . 'scheduled_checks/delete/' . $new->id;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td style="display:none;"><?php echo $i ?></td>
                                        <td style="font-weight: 900;"><?php echo wordwrap($new->checkname , 50 , "<br>\n")  ?></td>
                                        <td><?php echo wordwrap($new->check_desc , 50 , "<br>\n")  ?></td>
                                        <td><?php echo wordwrap($new->frequency , 50 , "<br>\n")  ?></td>
                                        <td>
                                            <?php $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$new->id,'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
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
                                        <td><?php foreach($groups as $value): if($value['id']==$new->review_team) echo $value['group_title'] ; endforeach;?></td>
                                        <td><?php foreach($groups as $value): if($value['id']==$new->approval_team) echo $value['group_title']; endforeach;?></td>
                                        
                                        <td class="table_action" style="text-align: center;">
                                        <!-- <a class="btn yellow c-btn view_details" rel="<?=$new->id?>"><i class="fa fa-list"  title="See Detail"></i></a> -->
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="simple-icon-arrow-up-circle"></i>';
                                        $iconbgclass = ' btn greenbtn c-btn';
                                        if ($new->status != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="simple-icon-arrow-down-circle red"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }
                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                                        'title' => $publis_title,'rel' => $new->id,'id' => $new->id, 'status' => $new->status));
                                        echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit scheduled_checks'));
                                        echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new->id, 'title' => 'Delete scheduled_checks'));
                                        ?>
                                        </td>
                                    </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>
                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script type="text/javascript">
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?=ADMIN_BASE_URL?>scheduled_checks/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                       var test_desc = test_body;
                         $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-body").html(test_desc);
                          
                         
 
                     }
                    });
            });

    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected scheduled_checks?",
                text : "You will not be able to recover this scheduled_checks!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>scheduled_checks/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "scheduled_checks has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>scheduled_checks/change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-long-arrow-down').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-long-arrow-up').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
                    }
                   location.reload();
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 1) {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set Publish');
                $(this).attr('status', '0');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set Un-Publish');
                $(this).attr('status', '1');
            }
           
        });
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/

});
</script>

