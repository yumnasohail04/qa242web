<!-- Page content-->
<div class="content-wrapper">
    <h3>Categories</h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" id="cat_listing">

                     <!-- <table class="table table-striped table-bordered table-hover" id="datatable1">-->
                     <?php  include_once("catagories_listing.php");?>

                     <!-- </table>-->
                 </div>
             </div>
         </div>
     </div>
     <!-- END DATATABLE 1 -->

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
                url: "<?php ADMIN_BASE_URL?>catagories/detail",
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
            var smsid=0;
            e.preventDefault();
            swal({
                title : "Are you sure to delete the selected Catagories?",
                text : "You will not be able to recover this Catagories!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
            },
            function () {
                 $.ajax({
                    type: 'POST',
                    url: "<?php ADMIN_BASE_URL?>catagories/delete",
                    data: {'id': id},
                    async: false,
                    success: function(sms) {
                         smsid = parseInt(sms);
                        if (smsid == 1){
                            load_listing();
                        }
                    }
                });
                if (smsid==1){
                   swal("Deleted!", "Catagories has been deleted.", "success");
                }
                else if (smsid==2){
                    swal("Cancelled", "Please first delete products of this category ", "error");
                }
                else if (smsid==3){
                    swal("Cancelled", "Please first delete orders of this category ", "error");
                }
        });

    });


        /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>catagories/change_status_category",
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


        $(document).on("change", ".essentials", function(event){
          event.preventDefault();
          essentials_id = $(this).val();
          cat_id = $(this).attr('cat_id');
          $.ajax({
             type: "POST",
             url:  "<?= ADMIN_BASE_URL ?>catagories/update_cat_essentials",
             data: { 'essentials_id':essentials_id, 'cat_id':cat_id },
             async: false,
             success: function(){
                toastr.success('Add On updated successfully');return;
            }
        });
      });

        $(document).on("change", ".add_on", function(event){
          event.preventDefault();
          add_on_id = $(this).val();
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


$(document).ready(function() {
    $("#catagories_file").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_image').val(replaced_val);
    });
});

function load_listing(){
	$("#cat_listing").load("<?php echo ADMIN_BASE_URL ?>catagories/load_listing", function(){
		$('#datatable1').dataTable();
	});
}
</script>