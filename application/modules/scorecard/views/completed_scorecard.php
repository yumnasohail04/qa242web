<!-- Page content-->
<div class="content-wrapper">
    <h3>Completed ScoreCards List</h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
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
                                        <td><?php echo wordwrap($new['name'] , 50 , "<br>\n")  ?></td>
                                        <td><?php echo wordwrap($new['at_reviewed_date'] , 50 , "<br>\n")  ?></td>
                                        <td><?php echo wordwrap(number_format((float)$new['total_percentage'], 2, '.', '').'%' , 50 , "<br>\n")  ?></td>
                                        <td class="table_action" style="text-align: center;">
                                        <a class="btn yellow c-btn view_details" rel="<?=$new['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
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


});
</script>

