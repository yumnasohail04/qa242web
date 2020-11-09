<!-- Page content-->
<?php 
function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}
?>



<main>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>Existing Forms</h1>
            <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="static_form/create">&nbsp;Add New&nbsp;</a>
            <div class="separator mb-5"></div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <table class="data-table data-table-feature">
                        <thead class="bg-th">
                            <th class="text-center" style="width:120px;">Start Date</th>
                            <th class="text-center" style="width:120px;">Start Time</th>
                            <th class="text-center" style="width:200px;">Check Name</th>
                            <th class="text-center" style="width:500px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($static_form) && !empty($static_form)) {
                                    foreach ($static_form->result() as
                                            $sf) {
                                        $i++;
                                        $set_publish_url = ADMIN_BASE_URL . 'static_form/set_publish/' . $sf->sf_id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'static_form/set_unpublish/' . $sf->sf_id ;
                                        $edit_url = ADMIN_BASE_URL . 'static_form/create/' . $sf->sf_id ;
                                        $delete_url = ADMIN_BASE_URL . 'static_form/delete/' . $sf->sf_id;
                                        ?>
                                    <tr id="Row_<?=$sf->sf_id?>" class="odd gradeX">
                                        <td>
                                            <?php 
                                            
                                            if($sf->sf_start_datetime=="0000-00-00 00:00:00")
                                            {echo "-";}else{echo date('m-d-Y',strtotime($sf->sf_start_datetime));}
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if($sf->sf_start_datetime=="0000-00-00 00:00:00")
                                            {echo "-";}else{echo date('m-d-Y',strtotime($sf->sf_start_datetime));}?>
                                        </td>
                                        <td>
                                            <?php echo $sf->sf_name; ?>
                                        </td>
                                        <td class="table_action">
                                        <a class="btn yellow c-btn view_details" rel="<?=$sf->sf_id?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                                       <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="simple-icon-arrow-up-circle"></i>';
                                        $iconbgclass = ' btn greenbtn c-btn';
                                        if ($sf->sf_status != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="simple-icon-arrow-down-circle red"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }
                                        echo '<a class="btn yellow  c-btn view_attributes" rel="'.$sf->sf_id.'" naming="'.seoUrl($sf->sf_name).'"><i class="iconsminds-three-arrow-fork"  title="Manage Attributes" ></i></a>';
                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                                        'title' => $publis_title,'rel' => $sf->sf_id,'id' => $sf->sf_id, 'status' => $sf->sf_status));
                                        echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Check'));

                                       // echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $sf->sf_id, 'title' => 'Delete Check'));
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
                        url: "<?php echo ADMIN_BASE_URL?>static_form/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                        $('#myModal').modal('show')
                        //$("#myModal .modal-title").html(test_title);
                        $("#myModal .modal-body").html(test_desc);
                        }
                    });
            });

    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Check?",
                text : "You will not be able to recover this Check!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                   $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>static_form/delete",
                        data: {'id': id},
                        async: false,
                        success: function() {
                        location.reload();
                        }
                    });
                swal("Deleted!", "Post has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>static_form/change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    toastr.success('Status Changed Successfully');
                }
            });
            location.reload();
        });
        $(document).on("click", ".view_attributes", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            if(id=='' || id==undefined ||id==null){
                 toastr.warning('You must select sub category');
                return false;
            }
            
            var url='<?=ADMIN_BASE_URL.'static_form/manage_attributes/'?>'+id+'/'+$(this).attr('naming');
             window.location=url;
        });
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/
});
</script>

