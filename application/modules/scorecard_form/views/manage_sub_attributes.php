<?php 
function selectbox($id,$selected,$rank,$selected_rank) {
    $text = '<select name="page_rank" class="form-control chosen-select" id="rank" attr_id="'.$id.'">';
        if(!empty($rank)) {
            foreach ($rank as $ranking => $ra):
                if(!empty($ra) && ($selected == $ra || !is_numeric(array_search($ra, array_column($selected_rank, 'page_rank'))))) { 
                    $select_text = '';
                    if($selected == $ra) $select_text = 'selected="selected"';
                    $text .='<option value="'.$ra.'" '.$select_text.'>'.$ra.'</option>';
                } 
            endforeach;
        }
    $text .='</select>';
    return $text;
}
?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Questions of  <?php echo $parent_name; ?></h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'scorecard_form/create_questions/' . $ParentId.'/'.$parent_name; ?>">&nbsp;Add New Attribute&nbsp;</a>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'scorecard_form';?>">&nbsp;Back&nbsp;</a>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                    <table id="datatable1" class="data-table data-table-feature">
                        <thead class="bg-th">
                            <tr class="bg-col">
                                <th>Question<i class="fa fa-sort" style="font-size:13px;"></i></th>
                                <th>Description<i class="fa fa-sort" style="font-size:13px;"></i></th>
                                <th>Page Rank<i class="fa fa-sort" style="font-size:13px;"></i></th>
                                <th style="width:350px;text-align: center;">Actions</th>
                          </tr>
                    </thead>
                    <tbody class="table-body">
                             <?php
                    $i = 0;
                    if (isset($questions)) {
                        foreach ($questions as $row) {
                            $i++;
                            $edit_url=ADMIN_BASE_URL . 'scorecard_form/create_questions/' . $ParentId.'/'.$parent_name.'/'.$row['id'];
                        ?>
                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                        <td><?php echo $row['question'];?></td>
                        <td><?php echo $row['description'];?></td>
                        <td><?php echo selectbox($row['id'],$row['page_rank'],$rank,$questions); ?></td>
                        <td class="table_action" style="text-align: center;">
                            <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                            <?php
                            echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Users'));
                            echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row['id'],'title' => 'Delete question'));

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
$('.chosen-select').on('change', function() {
    var attr_id=$(this).attr('attr_id');
    var select_val=$(this).val();
    if(attr_id >0 && select_val >0){
        $.ajax({
            type: 'POST',
            url: "<?=ADMIN_BASE_URL?>scorecard_form/update_specific_question_rank",
            data: {'page_rank': select_val,'attr_id':attr_id},
            async: false,
            success: function(test_body) {
                location.reload();
            }
        });
    }
});
$(document).ready(function(){
    $(document).off('click', '.delete_records').on('click', '.delete_records', function(e){
        var id = $(this).attr('rel');
        e.preventDefault();
        swal({
            title : "Are you sure to delete the selected Question?",
            text : "You will not be able to recover this Question!",
            type : "warning",
            showCancelButton : true,
            confirmButtonColor : "#DD6B55",
            confirmButtonText : "Yes, delete it!",
            closeOnConfirm : false
        },
        function () {
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>scorecard_form/delete_question",
                data: {'id': id},
                async: false,
                success: function(typee) {
                   location.reload();
                }
            });
            swal("Deleted!", "Question has been deleted.", "success");
        });
    });
    $(document).on("click", ".view_details", function(event){
        event.preventDefault();
        var id = $(this).attr('rel');
        $.ajax({
            type: 'POST',
            url: "<?= ADMIN_BASE_URL ?>scorecard_form/question_detail",
            data: {'id': id},
            async: false,
            success: function(test_body) {
                var test_desc = test_body;
                $('#myModalLarge').modal('show')
                $("#myModalLarge .modal-body").html(test_desc);
            }
        });
    });
});
</script>