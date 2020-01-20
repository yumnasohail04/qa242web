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
                        <th class="text-center" style="width:120px;">Start Time <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:120px;">End Time <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center" style="width:200px;">Check Name <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Responsible Team <i class="fa fa-sort" style="font-size:13px;"></th>
                        <?php if($this->uri->segment(3) == 'today_checks'){ ?>
                            <th class="text-center"style="width:200px;" >Status<i class="fa fa-sort" style="font-size:13px;"></th>
                            <th class="text-center"style="width:200px;" >Lines<i class="fa fa-sort" style="font-size:13px;"></th>
                        <?php }
                        if($this->uri->segment(3) == 'pending_review'){ ?>
                        <th class="text-center"style="width:200px;" >Work arround <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Completed By <i class="fa fa-sort" style="font-size:13px;"></th>
                        <th class="text-center"style="width:200px;" >Completed Datetime <i class="fa fa-sort" style="font-size:13px;"></th>
                        <?}?>
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
                                    <tr id="Row_<?=$new->assign_id?>" class="odd gradeX " >
                                        <td class="text-center"><?php echo date('m-d-Y H:i',strtotime($new->start_datetime)); ?></td>
                                        <td class="text-center"><?php echo date('m-d-Y H:i',strtotime($new->end_datetime)); ?></td>
                                        <td class="text-center"><?php echo wordwrap( $new->checkname , 50 , "<br>\n");?></td>
                                       <?php if($this->uri->segment(3) == 'active_checks' || $this->uri->segment(3) == 'today_checks' || $this->uri->segment(3) == 'overdue_checks'){ ?>
                                       <td class="text-center">
                                           <?php $get_inspection_team = Modules::run('api/_get_specific_table_with_pagination',array('sci_check_id'=>$new->checkid,'sci_status'=>'1'), 'sci_id desc',DEFAULT_OUTLET.'_scheduled_checks_inspection','sci_team_id','1','0')->result_array();
                                            $counter = 1;
                                            if(!empty($get_inspection_team)) {
                                                foreach ($get_inspection_team as $key => $git):
                                                    if(!empty($git['sci_team_id'])) {
                                                        $key = array_search($git['sci_team_id'], array_column($groups, 'id'));
                                                        if (is_numeric($key)) {
                                                            if($counter >1)
                                                                echo ",";
                                                            echo $groups[$key]['group_title'];
                                                            $counter++;
                                                        }
                                                    }
                                                endforeach;
                                            }?>
                                        </td>
                                        <?php }
                                        if($this->uri->segment(3) == 'today_checks') { ?>
                                        <td class="text-center">
                                            <?php echo $new->assign_status; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if(isset($new->line_timing) && !empty($new->line_timing)) {
                                                $line_timing = explode(",",$new->line_timing);
                                                if(!empty($line_timing)) {
                                                    $counters = 1;
                                                    foreach($line_timing as $keys => $line):
                                                        $line_name = Modules::run('api/_get_specific_table_with_pagination',array('line_id'=>$line), 'line_id desc',DEFAULT_OUTLET.'_lines','line_name','1','1')->row_array();
                                                        if(!empty($line_name['line_name'])) {
                                                            if($counters > 1)
                                                                echo ",";
                                                            echo $line_name['line_name'];
                                                            $counters++;
                                                        }
                                                    endforeach;
                                                }
                                                
                                            } ?>
                                        </td>
                                       <?php }
                                       if($this->uri->segment(3) == 'pending_review'){ ?>
                                       <td class="text-center"><?php foreach($groups as $value): if($value['id']==$new->review_team) echo $value['group_title'] ; endforeach;?></td>
                                       <?php }?>
                                        <?php if($this->uri->segment(3) == 'pending_approval'){ ?>
                                       <td class="text-center"><?php foreach($groups as $value): if($value['id']==$new->approval_team) echo $value['group_title'] ; endforeach;?></td>
                                       <?}?>
                                        <?php if($this->uri->segment(3) == 'pending_review'){ ?>
                                       <td class="text-center"> <?php if(isset($new->work_arround)) echo $new->work_arround;?></td>
                                        <td class="text-center"> <?php if(isset($new->completed_by)) echo $new->completed_by;?></td>
                                         <td class="text-center"> <?php if(isset($new->completed_datetime)) echo $new->completed_datetime;?></td>
                                         
                                       <?}?>
                                        <td class="table_action text-center">
                                             <?php if($this->uri->segment(3) == 'pending_review'){ ?>
                                            <?php $current_status= "";
                                                $outlet_status=array(""=>"Select Action","Approval"=>"Set To Approval","Check_again"=>'Check again');
                                                echo form_dropdown('order_status', $outlet_status, $current_status, 'class="add_on form-control select_action order_status" style="width:190px;" order_id="'.$new->assign_id.'"');?>
                                                    <?}?>
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->assign_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fa fa-long-arrow-up"></i>';
                                        $iconbgclass = ' btn green c-btn';
                                        if ($new->assign_status != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fa fa-long-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }
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
                        url: "<?= ADMIN_BASE_URL?>assignments/detail",
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