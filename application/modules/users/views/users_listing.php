<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Users</h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="users/create">&nbsp;Add New&nbsp;</a>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="data-table data-table-feature">
                                <thead>
                                    <tr>
                                    <th>User Name </th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Group</th>
                                    <th style="width:350px;text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 0;
                                    if (isset($users_rec)) {
                                        foreach ($users_rec as $row) {
                                            $i++;
                                            $edit_url = ADMIN_BASE_URL . 'users/create/' . $row['id']; 
                                            $delete_url = ADMIN_BASE_URL . 'users/delete/'. $row['id'];
                                        
                                        ?>
                                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                                        <td><?php echo $row['user_name']?></td>
                                        <td><?php echo $row['first_name']." ".$row['last_name']?></td>
                                        <td><?php echo $row['email']?></td>
                                        <td><?php echo $row['phone']?></td>
                                        <td><?php echo $row['group']?></td>
                                

                                    <td class="table_action" style="text-align: center;">
                                            <!-- <a class="fancybox btn yellow c-btn" data-target="#myModal" data-toggle="modal" href="#description_<?= $row['id'] ?>" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a> -->
                                            <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                                            <a class="btn black c-btn change_password" rel="<?=$row['id']?>"><i class="iconsminds-key"  title="Change Password"></i></a>
                                            <?php
                                            $publish_class = ' table_action_publish';
                                            $publis_title = 'Set Un-Publish';
                                            $icon = '<i class="simple-icon-arrow-up-circle"></i>';
                                            $iconbgclass = ' btn greenbtn c-btn';
                                            if ($row['status'] != 1) {
                                                $publish_class = ' table_action_unpublish';
                                                $publis_title = 'Set Publish';
                                                $icon = '<i class="simple-icon-arrow-down-circle"></i>';
                                                $iconbgclass = ' btn default c-btn';
                                            }
                                            echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Users'));
                                            echo anchor("javascript:void(0);",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                                            'title' => $publis_title,'rel' => $row['id'],'id' => $row['id'], 'status' => $row['status']));
                                            echo anchor('javascript:void(0);', '<i class="simple-icon-close"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete User'));

                                            ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                    ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script type="application/javascript">
$(document).ready(function(){
  $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected User?",
                text : "You will not be able to recover this User!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php ADMIN_BASE_URL?>users/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {

                               /*$( "#datatable1" ).load( "<? ADMIN_BASE_URL ?>catagories/load_listing" );*/
                               location.reload();
                            }
                        });
                swal("Deleted!", "User has been deleted.", "success");
              });

            });

    
    $(document).on("click", ".view_details", function(event){
        event.preventDefault();
        var id = $(this).attr('rel');
        //alert(id); return false;
          $.ajax({
                    type: 'POST',
                    url: "<?= ADMIN_BASE_URL ?>users/detail",
                    data: {'id': id},
                    async: false,
                    success: function(test_body) {
                    var test_desc = test_body;
                    //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                    $('#myModalLarge').modal('show')
                    //$("#myModal .modal-title").html(test_title);
                    $("#myModalLarge .modal-body").html(test_desc);
                    }
                });
    
    });

            /*/////////////////////////////////////////////////////*/
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>users/change_status_event",
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
                    $("#listing").load('<?php ADMIN_BASE_URL?>thought_of_day/manage_record');
                    toastr.success('Status Changed Successfully');
                    location.reload();
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
                
});
</script>