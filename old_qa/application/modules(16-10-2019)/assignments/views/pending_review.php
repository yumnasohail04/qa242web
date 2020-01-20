<!-- Page content-->
<div class="content-wrapper">
    <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
    <h3><?php if($this->uri->segment(3) == 'active_checks') echo "Active"; elseif($this->uri->segment(3) == 'overdue_checks') echo "Overdue"; elseif($this->uri->segment(3) == 'pending_review') echo "Pending";  elseif($this->uri->segment(3) == 'pending_approval') echo "Pending Approval"; else echo ""; ?> Assignments</h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                           <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>From:</label>
                                    <div class='input-group datetimepicker2'>
                                        <input type='text' class="form-control" id="startdate" />
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                 <label>To:</label>
                                    <div class='input-group datetimepicker2'>
                                    <input type='text' class="form-control" id="enddate" />
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                 </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" style="margin-top: 33px;">
                                    <button type="button" class="btn btn-primary form-control filter_search">Search</button>
                                 </div>
                            </div>
                        </div>
                      <table id="datatable1" class="table table-striped table-hover table-body table-bordered">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="text-center" style="width:120px;">Check Date <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:120px;">Check Time <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:200px;">Check Name <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Responsible Team <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:500px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new) {
                                        $i++;
                                        ?>
                                    <tr <?php $any_comments = Modules::run('api/_get_specific_table_with_pagination',array("assignment_id"=>$new->assign_id,"comments !="=>""),'assign_ans_id desc',DEFAULT_OUTLET.'_assignment_answer','comments','1','1')->result_array(); if(!empty($any_comments)) echo 'style="background-color:#f7d16e;"'; ?> id="Row_<?=$new->assign_id?>" class="odd gradeX " >
                                        <td class="text-center"><?php echo date('m-d-Y',strtotime($new->complete_datetime)); ?></td>
                                        <td class="text-center"><?php echo date('H:i:s',strtotime($new->complete_datetime)); ?></td>
                                        <td class="text-center"><?php echo wordwrap( $new->checkname , 50 , "<br>\n");?></td>
                                        <td class="text-center">
                                            <?php $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$new->checkid,'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                            $counter = 1;
                                            if(!empty($get_inspection_team)) {
                                                foreach ($get_inspection_team as $key => $git):
                                                    if(!empty($git['sci_team_id'])) {
                                                        $key = array_search($git['sci_team_id'], array_column($groups, 'id'));
                                                        if (is_numeric($key)) {
                                                            if($counter > 1)
                                                                echo ",";
                                                            echo $groups[$key]['group_title'];
                                                            $counter++;
                                                        }
                                                    }
                                                endforeach;
                                            }?>
                                        </td>
                                        <td class="table_action text-center">
                                             <?php if($this->uri->segment(3) == 'pending_review'){ 
                                                $reassign_detail = Modules::run('api/_get_specific_table_with_pagination',array("reassign_id"=>$new->assign_id), 'assign_id desc',DEFAULT_OUTLET.'_assignments','assign_id','1','0')->result_array();
                                                $reassing_id = "";
                                                if(isset($reassign_detail[0]['assign_id']) && !empty($reassign_detail[0]['assign_id']))
                                                    $reassing_id = $reassign_detail[0]['assign_id'];
                                                ?>
                                            <?php $current_status= ""; if(isset($new->assign_id) && !empty($new->assign_id)) { $reassing = Modules::run('api/_get_specific_table_with_pagination',array("reassign_id"=>$new->assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','assign_id','1','1')->result_array(); if(!empty($reassing)) $current_status= "Check_again"; } 
                                            if($review_approval == true)
                                                $outlet_status=array(""=>"Select Action","Approval"=>"Approve");
                                            else
                                                $outlet_status=array(""=>"Select Action","Approval"=>"Approve","Check_again"=>'Check again');
                                            echo form_dropdown('order_status', $outlet_status, $current_status, 'class="add_on form-control select_action order_status" style="width:190px;" order_id="'.$new->assign_id.'" check_id="'.$new->checkid.'" reassign_id="'.$reassing_id.'"');?>
                                            <?}?>
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->assign_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                      
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
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    

<script type="text/javascript">
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert("<?=$this->uri->segment(3);?>"); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/pending_review_detail",
                        data: {'id': id,'function':'<?=$this->uri->segment(3);?>','review_approval':'<?=$review_approval?>'},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                        $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-footer").html('<button type="button" data-dismiss="modal" class="btn btn-primary  pull-right">Cancel</button>');
                        $("#myModalLarge .modal-body").html(test_desc);
                        }
                    });
            });

    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Post?",
                text : "You will not be able to recover this Post!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php ADMIN_BASE_URL?>post/delete",
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
                url: "<?= ADMIN_BASE_URL ?>post/change_status",
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
                    $("#listing").load('<?php ADMIN_BASE_URL?>post/manage');
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

$(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });
</script>
<script>
$(document).ready(function() {
    // $('.select_action').on('click', function() {
    //     $(this).find('option').removeAttr('selected')
    // })
    $('.select_action').on('change', function(event) {
        event.stopPropagation();
        var option=this.value;
        var assign_id = $(this).attr('order_id');
        var check_id = $(this).attr('check_id');
        var reassign_id = $(this).attr('reassign_id');
        $(this).removeAttr('style');
      if(option=='Check_again'){
             $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/check_again_for_assignment",
                        data: {'assign_id': assign_id,'check_id':check_id,'reassign_id':reassign_id},
                        async: false,
                        success: function(test_body) {
                             $('#myModalassignment').modal('show');
                             $("#myModalassignment .modal-body").html(test_body);
                             $('.chosen-select').chosen();
                             (function () {

                                var previous;
                                $(".restaurant_type").on('focus', function () {
                                    $(this).removeAttr('style');
                                    // Store the current value on focus and on change
                                    previous = this.value;
                                }).change(function() {
                                    event.preventDefault();
                                    var abc=$(this);
                                    var order_status = $(this).val();
                                    if(order_status == "") {
                                        abc.val(previous);
                                        showToastr("Please select Type", "info");
                                    }
                                    else if (order_status == 'group' || order_status == 'user') {
                                        $('.group_div').remove();
                                        $('.team_div').remove();
                                        $.ajax({
                                            type: 'POST',
                                            url: "<?= ADMIN_BASE_URL?>assignments/get_all_groups",
                                            data: {},
                                            async: false,
                                            success: function(test_body) {
                                                $(test_body).insertAfter('.selecting_div');
                                            }
                                        });
                                    }
                                    else
                                        console.log('');
                                    (function () {
                                        var previous_group;
                                $(".responsible_team").on('focus', function () {
                                    // Store the current value on focus and on change
                                    previous_group = this.value;
                                }).change(function() {
                                    $(this).removeAttr('style');
                                    event.preventDefault();
                                    var abc_group=$(this);
                                    var group_status = $(this).val();
                                    if(group_status == "") {
                                        abc_group.val(previous);
                                        showToastr("Please select another group", "info");
                                    }
                                    else if (group_status != '' && order_status == 'user') {
                                        $('.team_div').remove();
                                        $.ajax({
                                            type: 'POST',
                                            url: "<?= ADMIN_BASE_URL?>assignments/get_all_group_users",
                                            data: {'group_id':group_status},
                                            async: false,
                                            success: function(test_body) {
                                                $(test_body).insertAfter('.group_div');
                                            }
                                        });
                                    }
                                    else
                                        console.log('');
                                    // Make sure the previous value is updated
                                    previous_group = this.value;
                                });
                                })();
                                    previous = this.value;
                                });
                            })();
                        }
                    });
// $(this).find('option').removeAttr('selected')
// $(this).find('option[value=Approval]').attr('selected','selected');
      }else if(option=='Approval'){
                $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/pending_review_detail",
                        data: {'id': assign_id,'function':'<?=$this->uri->segment(3);?>',"datacomment":"ok",'review_approval':'<?=$review_approval?>'},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                       
                        $('#myModalLarge').modal('show')
                        <?php if($review_approval == true) {?>
                            $("#myModalLarge .modal-footer").html('<button type="button" data-dismiss="modal" class="btn btn-primary  pull-right">Cancel</button> <button type="button" class="btn btn-primary pull-right submit_check" > Review & Approved</button> <button type="button" class="btn btn-primary pull-right reassign_check" > Reassign Check</button>');
                        <?php } else {?>
                            $("#myModalLarge .modal-footer").html('<button type="button" data-dismiss="modal" class="btn btn-primary  pull-right">Cancel</button> <button type="button" class="btn btn-primary pull-right submit_check" > Reviewed</button>');
                        <?php }?>
                        $("#myModalLarge .modal-body").html(test_desc);
                        var review_approval = $("#myModalLarge").find(".review_approval").text();
                        var reviewable = $("#myModalLarge").find(".reviewable").text();
                        var is_reasigned = $("#myModalLarge").find(".is_reasigned").text();
                        if(review_approval == 1 && ((reviewable != 1 && is_reasigned == 1)|| (reviewable == 1 && is_reasigned != 1)))
                            console.log('');
                        else
                            $('.reassign_check').remove();
                        }
                    });
      }
});
});
</script>

<script>
    $(document).ready(function() {
    $('.filter_search').on('click', function() {
        var startdate=$('#startdate').val();
        var enddate=$('#enddate').val();
        var assign_type = $('#assign_type').val();
        if(startdate=='' && enddate==''){
            toastr.success('Please Select Date Range');
           }else{
             $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/get_filter_result",
                        data: {'startdate': startdate,'enddate':enddate,'assign_type':assign_type},
                        async: false,
                        success: function(test_body) {
                            if(test_body!='')
                             $('#datatable1').html(test_body);
                             else
                              toastr.success('No result found b/w selected date');
                          
                        }
            });
           }    
});
});

   $(document).ready(function() {
    $('#checkagain').on('click', function() {
        var startdate=$('#startdate').val();
        var enddate=$('#enddate').val();
        var assign_type = $('#assign_type').val();
        if(startdate=='' && enddate==''){
            toastr.success('Please Select Date Range');
           }else{
             $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/get_filter_result",
                        data: {'startdate': startdate,'enddate':enddate,'assign_type':assign_type},
                        async: false,
                        success: function(test_body) {
                            if(test_body!='')
                             $('#datatable1').html(test_body);
                             else
                              toastr.success('No result found b/w selected date');
                          
                        }
            });
           }    
});
});
</script>