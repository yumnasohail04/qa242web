<!-- Page content-->
<div class="content-wrapper">
    <h3>Document<a href="document/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <table id="datatable1" class="table table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th>Document Name <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th>Type <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th>Assigned to <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="" style="width:300px;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news as $key =>$new) {
                                        $i++;
                                        $set_publish_url = ADMIN_BASE_URL . 'document/set_publish/' . $new['id'];
                                        $set_unpublish_url = ADMIN_BASE_URL . 'document/set_unpublish/' . $new['id'] ;
                                        $edit_url = ADMIN_BASE_URL . 'document/create/' . $new['id'] ;
                                        $delete_url = ADMIN_BASE_URL . 'document/delete/' . $new['id'];
                                        $manage_url = ADMIN_BASE_URL . 'document/manage_wips/' . $new['id'];
                                        ?>
                                    <tr id="Row_<?=$new['id']?>" class="odd gradeX " >
                                        <td><?php echo wordwrap($new['doc_name'] , 50 , "<br>\n")  ?></td>
                                        <td><?php echo $new['type_name'];  ?></td>
                                        <td><?php echo $new['assign_to'];  ?></td>
                                        <td class="table_action" style="text-align: center;">
                                        <a class="btn yellow c-btn view_details" rel="<?=$new['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fas fa-arrow-up"></i>';
                                        $iconbgclass = ' btn green greenbtn c-btn';
                                        if ($new['status'] != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fas fa-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }
                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                                        'title' => $publis_title,'rel' => $new['id'],'id' => $new['id'], 'status' => $new['status']));
                                        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit document'));

                                        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new['id'], 'title' => 'Delete document'));
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
</div>    

<script type="text/javascript">
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>document/detail",
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
                title : "Are you sure to delete the selected document?",
                text : "You will not be able to recover this document!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>document/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {
                                location.reload();
                            }
                        });
                swal("Deleted!", "document has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>document/change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    /*if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-long-arrow-down').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-long-arrow-up').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
                    }
                    $("#listing").load('<?php ADMIN_BASE_URL?>document/manage');*/
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
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/

});
</script>

