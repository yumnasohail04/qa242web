<!-- Page content-->
<div class="content-wrapper">
    <h3>WIP Product
  <a href="<?=ADMIN_BASE_URL?>product/add_new_wip"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New Wip Product</button></a><a href="<?=ADMIN_BASE_URL?>product/replace_wip_product"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Replace Wip Product</button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <table id="datatable11" class="table table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th>Navision Number(wip) <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th>Product Title(wip) <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th>Navision Number(FG)<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th>Product Title(FG)<i class="fa fa-sort" style="font-size:13px;"></i></th>
                        <th class="" style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new) {
                                        $i++;
                                        $set_publish_url = ADMIN_BASE_URL . 'product/set_publish/' . $new->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'product/set_unpublish/' . $new->id;
                                        $edit_url = ADMIN_BASE_URL . 'product/add_new_wip/' . $new->id ;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td><?php echo wordwrap($new->navision_number , 50 , "<br>\n");  ?></td>
                                        <td><?php echo wordwrap($new->product_name , 50 , "<br>\n"); ?></td>
                                        <td>
                                            <?php
                                            $pro_title = '';
                                            $counter = 1;
                                            if(isset($new->navision_number) && !empty($new->navision_number)) {
                                                $product = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("navision_number"=>$new->navision_number),'id desc','id','wip_attributes','product_id','1','0','','','')->result_array();
                                                if(!empty($product)) {
                                                    foreach ($product as $key => $pro):
                                                        $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$pro['product_id']),'id desc','id',DEFAULT_OUTLET.'_product','navision_no,product_title','1','1','','','')->row_array();
                                                        if(!empty($product_detail)) {
                                                            if($counter != 1) {
                                                                echo '<br>*';
                                                                $pro_title = $pro_title.'<br>*';
                                                            }
                                                            echo $product_detail['navision_no'];
                                                            $pro_title = $pro_title.Modules::run('api/string_length',$product_detail['product_title'],'40','','');
                                                            $counter ++;
                                                        }
                                                    endforeach;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?=$pro_title?>
                                        </td>
                                        <td class="table_action" style="text-align: center;">
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fas fa-arrow-up"></i>';
                                        $iconbgclass = ' btn green greenbtn c-btn';
                                        if ($new->status != 1) {
                                            $publish_class = ' table_action_unpublish';
                                            $publis_title = 'Set Publish';
                                            $icon = '<i class="fas fa-arrow-down"></i>';
                                            $iconbgclass = ' btn default c-btn';
                                        }
                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                                        'title' => $publis_title,'rel' => $new->navision_number,'id' => $new->navision_number, 'status' => $new->status));
                                        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Product'));
                                        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new->navision_number, 'title' => 'Delete WipProduct'));
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

           
    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected WipProduct?",
                text : "You will not be able to recover this WipProduct!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>product/delete_wips",
                            data: {'id': id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "Product has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>product/wip_change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    toastr.success('Status Changed Successfully');
                    location.reload();
                }
            });
        });
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/

});
</script>

