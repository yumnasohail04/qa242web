<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
                <h1><?php if($this->uri->segment(3) == 'active_checks') echo "Active Assignments"; elseif($this->uri->segment(3) == 'overdue_checks') echo "Overdue Assignments"; elseif($this->uri->segment(3) == 'pending_review') echo "Pending Review";  elseif($this->uri->segment(3) == 'pending_approval') echo "Pending Approval";elseif($this->uri->segment(3) == 'completed_checks') echo "Approved"; else echo ""; ?> </h1>
                <div class="separator mb-5"></div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-1">
                                <label>From:</label>
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" id="startdate" />
                                        <span class="input-group-text input-group-append input-group-addon">
                                        <i class="simple-icon-calendar"></i>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-1">
                                 <label>To:</label>
                                    <div class='input-group date'>
                                    <input type='text' class="form-control" id="enddate" />
                                    <span class="input-group-text input-group-append input-group-addon">
                                        <i class="simple-icon-calendar"></i>
                                    </span>
                                 </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top: 33px;">
                                    <button type="button" class="btn btn-primary form-control filter_search">Search</button>
                                 </div>
                            </div>
                        </div>
                        <table class="data-table data-table-feature">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="text-center" style="width:120px;">Approve Date <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:120px;">Approve Time <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:200px;">Check Name <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Approved By <i class="fa fa-sort" style="font-size:13px;"></th>
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
                                    <tr  id="Row_<?=$new->assign_id?>" class="odd gradeX "  >
                                        <td class="text-center"><?php echo date('m-d-Y',strtotime($new->approval_datetime)); ?></td>
                                        <td class="text-center"><?php echo date('H:i:s',strtotime($new->approval_datetime)); ?></td>
                                        <td class="text-center"><?php echo wordwrap( $new->checkname , 50 , "<br>\n");?></td>
                                        <td class="text-center">
                                            <?php
                                            if(isset($new->assign_id) && !empty($new->assign_id)) {
                                                $assignment_answer = Modules::run('api/_get_specific_table_with_pagination',array("assign_id"=>$new->assign_id),'assign_id desc',DEFAULT_OUTLET.'_assignments','approval_user','1','1')->result_array();
                                                if(isset($assignment_answer[0]['approval_user']) && !empty($assignment_answer[0]['approval_user'])) {
                                                    $users = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$assignment_answer[0]['approval_user']),'id desc','users','user_name','1','1')->result_array();
                                                     $name=''; if(isset($users[0]['user_name']) && !empty($users[0]['user_name'])) $name= $users[0]['user_name']; $name=  Modules::run('api/string_length',$name,'8000','',''); echo $name; 
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="table_action text-center">
                                             <?php if($this->uri->segment(3) == 'pending_review'){ ?>
                                            <?php $current_status= "";
                                            $outlet_status=array(""=>"Select Action","Approval"=>"Set To Approval","Check_again"=>'Check again');
                                            echo form_dropdown('order_status', $outlet_status, $current_status, 'class="add_on form-control select_action order_status" style="width:190px;" order_id="'.$new->assign_id.'"');?>
                                            <?}?>
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->assign_id?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                                       
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
            //alert("<?=$this->uri->segment(3);?>"); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/pending_review_detail",
                        data: {'id': id,'function':'<?=$this->uri->segment(3);?>'},
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
    $('.select_action').on('change', function() {
        var option=this.value;
        var assign_id = $(this).attr('order_id');
      if(option=='Check_again'){
             $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/check_again_for_assignment",
                        data: {'assign_id': assign_id},
                        async: false,
                        success: function(test_body) {
                             $('#myModalassignment').modal('show');
                             $("#myModalassignment .modal-body").html(test_body);
                          
                        }
                    });
      }else if(option=='Approval'){
            $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/change_approval_status_for_assignment",
                        data: {'assign_id': assign_id},
                        async: false,
                        success: function(test_body) {
                     
                          toastr.success('Assignment status chnaged to pending approval');
                            location.reload();
                       
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