<!-- Page content-->
<?php error_reporting(1); ?>
<div class="content-wrapper">
    <h3>Sub Category Management- <?php echo $parent_name = preg_replace('/[^a-zA-Z]+/', ' ', $cat_name)?>
    <a href= "<?php echo ADMIN_BASE_URL . 'catagories/create_sub_catagories/' . $ParentCatDetails['id'].'/'.$parent_name; ?>"/>
    <button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button>
    </a>
    
 
    
    <a href= "<?php echo ADMIN_BASE_URL . 'catagories' ?>"/>
    <button type="button" class="btn btn-primary pull-right" style="margin-right: 9px;"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button>
    </a>
    </h3>


    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" id="subcat_listing">
                      <?php  include_once("listing.php");?>
                    <?php /* ?>
					<table id="datatable1" class="table table-striped table-hover ">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th  style="width:2%">S.No</th>
                        <th width="400px">Title</th>
                        <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                         <tbody>
                                <?php
                                $i=0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                        $active_url = ADMIN_BASE_URL . 'catagories/sub_cat_active/' . $row->parent_id . '/' . $row->id;
                                        $in_active_url = ADMIN_BASE_URL . 'catagories/sub_cat_in_active/' . $row->parent_id .  '/' . $row->id;
                                        $edit_url = ADMIN_BASE_URL . 'catagories/create_sub_catagories/' . $row->parent_id . '/' . $row->id;
                                       $delete_url = ADMIN_BASE_URL . 'catagories/delete_sub_catagories/' . $row->id . '/' .  $row->parent_id;
                                        $set_publish_url = ADMIN_BASE_URL . 'catagories/active/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'catagories/in_active/' . $row->id;
                                        ?>
                                        <tr class="odd gradeX">
                                          <td class="table-checkbox"><?php echo $i; ?></td>
                                            <td><?php echo $row->cat_name; ?></td>
                                            <td class="table_action">
                                            <a class="btn yellow c-btn view_sub_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                                 <?php
                                                if ($row->is_active == 1){
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                }
                                                if ($row->is_active != 1) {
                                                    $publish_class = 'table_action_unpublish';
                                                    $publis_title = 'Set Publish';
                                                    $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                    $iconbgclass = ' btn default c-btn';
                                                }
                                                echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id, 'id' => $row->id, 'status' => $row->is_active));
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row->id, 'rel2' => $row->parent_id,'title' => 'Delete Sub Category'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>    
                                <?php } ?>
                            </tbody>
                    </table>
					<?php */ ?>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    
<script type="application/javascript">

$(document).ready(function(){


    /*//////////////////////// code for detail //////////////////////////*/
            $(document).off("click",".action_edit").on("click", ".view_sub_details", function(event){
                
            event.preventDefault();
            var id = $(this).attr('rel');
           
           // alert(id+pid); return false;
              $.ajax({
                        type: 'POST',
                       
                        url: "<?php echo ADMIN_BASE_URL?>catagories/sub_details",
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

          $(document).off('click', '.delete_records').on('click', '.delete_records', function(e){
                var id = $(this).attr('rel');
                 var pid = $(this).attr('rel2');
                 // alert(id+pid); return false;
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Sub Category?",
                text : "You will not be able to recover this Sub Category!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {

                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>catagories/delete_sub_catagories",
                            data: {'id': id , 'pid': pid },
                            async: false,
                            success: function(typee) {
                               /*$( "#datatable1" ).load( "<? ADMIN_BASE_URL ?>catagories/load_listing" );*/
                               location.reload();
                            }
                        });
               swal("Deleted!", "Sub Category has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>catagories/change_status_sub_category",
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
                    $("#listing").load('<?php ADMIN_BASE_URL?>catagories/manage');
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
	
	$(document).on("change", ".add_on", function(event){
		event.preventDefault();
		//alert();
		add_on_id = $(this).val();
		//alert(add_on_id);
		cat_id = $(this).attr('prod_id');

		$.ajax({
			type: "POST",
			url:  "<?= ADMIN_BASE_URL ?>catagories/update_prod_add_on",
			data: { 'add_on_id':add_on_id, 'cat_id':cat_id },
			async: false,
			success: function(){
				toastr.success('Add On updated successfully');return;
			}
		});
	});

});

</script>