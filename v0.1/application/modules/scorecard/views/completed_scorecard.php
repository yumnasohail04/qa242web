<!-- Page content-->
<div class="content-wrapper">
    <h3>Completed ScoreCards List</h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">




<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Completed ScoreCards List</h1>
                <div class="separator mb-5"></div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable1" class="table table-body">
                            <thead class="bg-th">
                            <tr class="bg-col">
                            <th>Supplier<i class="fa fa-sort" style="font-size:13px;"></i></th>
                            <th>Completed on <i class="fa fa-sort" style="font-size:13px;"></i></th>
                            <th>Total Points <i class="fa fa-sort" style="font-size:13px;"></i></th>
                            <th class="" style="width:300px;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if (isset($card_list)) {
                                    foreach ($card_list as $key =>
                                            $new) {
                                        $i++;
                                        ?>
                                    <tr id="Row_<?=$new['id']?>" class="odd gradeX " >
                                        <td class="view_supplier" style="cursor:pointer" rel="<?php echo $new['supplier_id']; ?>"><?php echo wordwrap($new['name'] , 50 , "<br>\n")  ?></td>
                                        <td><?php echo wordwrap($new['at_reviewed_date'] , 50 , "<br>\n")  ?></td>
                                        <td><?php echo wordwrap(number_format((float)$new['total_percentage'], 0, '.', '').'%' , 50 , "<br>\n")  ?></td>
                                        <td class="table_action" style="text-align: center;">
                                        <a class="btn yellow c-btn view_details" rel="<?=$new['id']?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                                       <?php  echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new['id'], 'title' => 'Delete')); ?>

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
            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
              $.ajax({
                    type: 'POST',
                    url: "<?php echo ADMIN_BASE_URL?>scorecard/detail",
                    data: {'id': id},
                    async: false,
                    success: function(test_body) {
                    var test_desc = test_body;
                     $('#myModallarge1').modal('show');
                     $("#myModallarge1 .modal-body").html(test_desc);
                    }
                });
            });


     
            $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the ScoreCard?",
                text : "You can't restore this!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>scorecard/delete_scorecard",
                            data: {'id': id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "ScoreCard has been deleted.", "success");
              });

            });

});
  $(document).on("click", ".view_supplier", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>supplier/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                       var test_desc = test_body;
                         $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-body").html(test_desc);
                          
                         
 
                     }
                    });
            });
</script>

