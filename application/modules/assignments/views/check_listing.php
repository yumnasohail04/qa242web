<link href="<?php echo STATIC_ADMIN_CSS;?>simplePagination.css" rel="stylesheet">
<!-- Page content-->
<div class="old_search" style="display: none;"></div>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
                <h3><?php if($assign_status == 'active_checks') echo "Active"; elseif($assign_status == 'overdue_checks') echo "Overdue";elseif($assign_status == 'today_checks') echo "Overdue"; else echo ""; ?> Assignments  <?php if($assign_status == 'overdue_checks') { ?>
                    <a href="<?php echo BASE_URL.'assignments/delete_current_date_checks'?>" class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right">&nbsp;&nbsp;&nbsp;Delete Overdue Checks </a><?php } ?></h3>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group  mb-1">
                                    <label>From:</label>
                                    <div class='input-group date'>
                                        <input type='text' class="form-control " id="startdate" />
                                        <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-calendar"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group  mb-1">
                                    <label>To:</label>
                                    <div class="input-group date">
                                            <input type="text" class="form-control" id="enddate">
                                            <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-calendar"></i>
                                            </span>
                                        </div>
                                </div>
                            </div>
                             <div class="col-sm-3">
                                <div class="form-group  mb-1">
                                    <label>Group:</label>
                                    <?php if(!isset($group_list)) $group_list = array();
                                        $options = array('' => 'Select')+$group_list ;
                                    ?>
                                    <?php echo form_dropdown('group', $options,'',  'class="custom-select validatefield" id="group"'); ?>
                                </div>
                            </div> 
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 33px;">
                                    <button type="button" class="btn btn-primary form-control filter_search" style="    max-width:85px;">Search</button>
                                 </div>
                            </div>
                            <!-- <div class="col-md-5"  style="float:right; margin-bottom: 1%;">
                                <div  class="row" style="padding-top:25px;">
                                    <div class="col-md-6" style="text-align: right;">
                                        <label>
                                            Search:
                                        </label>
                                    </div>
                                    <div class="col-md-5">
                                        <input id="search" type="search" class="form-control input-sm current_search" placeholder="" aria-controls="datatable1">
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="table-append">
                        <table class="data-table data-table-feature">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                    <th class="text-center"  style="width:120px;">
                                        Start Time <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center"  style="width:120px;">
                                        End Time <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center" style="width:200px;">
                                        Check Name <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center" style="width:200px;">
                                        Responsible Team <i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                            Lines<i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                            Plant<i class="fa fa-sort" style="font-size:13px;"></i>
                                    </th>
                                    <?php if($this->uri->segment(3) == 'today_checks'){ ?>
                                        <th class="text-center"style="width:200px;" >
                                            Status<i class="fa fa-sort" style="font-size:13px;"></i>
                                        </th>
                                        
                                    <?php }?>
                                    <th class="text-center" style="width:200px;" >
                                        Program Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new):
                                        $i++;
                                        ?>
                                        <tr id="Row_<?=$new->assign_id?>" class="odd gradeX " >
                                            <td class="text-center">
                                                <?php echo date('m-d-Y H:i',strtotime($new->start_datetime)); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo date('m-d-Y H:i',strtotime($new->end_datetime)); ?>
                                            </td>
                                            <td class="text-center">
                                                <?php echo  $new->checkname;?>
                                            </td>
                                            <?php if($assign_status == 'active_checks' || $assign_status == 'today_checks' || $assign_status == 'overdue_checks'){ ?>
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
                                            <?php } ?>
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
                                        <td class="text-center">
                                                <?php if(isset($new->plant_no) && !empty($new->plant_no)) {
                                                            $plant_name = Modules::run('api/_get_specific_table_with_pagination',array('plant_id'=>$new->plant_no), 'plant_id desc',DEFAULT_OUTLET.'_plants','plant_name','1','1')->row_array();
                                                            if(!empty($plant_name['plant_name'])) {
                                                                echo $plant_name['plant_name'];
                                                            }
                                                    
                                                } ?>
                                            </td>
                                        	<td>
                                            	<?php
                                					$key = array_search($new->program_type, array_column($program_type, 'program_id'));
                                                    if (is_numeric($key)) 
                                                    	echo $program_type[$key]['program_name'];
                                      			?>
                                        	</td>
                                            <?php if($assign_status == 'today_checks') { ?>
                                            <td class="text-center">
                                                <?php echo $new->assign_status; ?>
                                            </td>
                                            <?php }?>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>>
<script type="text/javascript">

    var search = document.getElementById("search");
	if(search){
    	search.addEventListener("keyup", function() {
         $('.old_search').text(search.value);
         ajax_call('1','','');
    	});

		}

    detail();


    function detail() {
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
    }
    var PreviousStartDate=$('#startdate').val();
    var PreviousEndDate=$('#enddate').val();
    var firstclick = "one";
    $(document).ready(function() {
        $('.filter_search').on('click', function() {
            var startdate=$('#startdate').val();
            var enddate=$('#enddate').val();
            var group=$('#group').val();
            
            $('.old_search').text($('.current_search').val());
            if(startdate == '' || enddate == '') {
                toastr.success('Please Select Date Range');
            }
            else {
                firstclick="fdafdas";
                ajax_call('1',startdate,enddate,group);
            }  
        });
    });

    function ajax_call(page_number,startdate,enddate,group) {
        var search = $('.old_search').text();
        $.ajax({
            type: "POST",  
            url: '<?= ADMIN_BASE_URL?>assignments/get_check_listing_filter_data',  
            data: {'page_number':page_number,'startdate':startdate,'enddate':enddate,'limit':'<?=$limit?>','assign_status':'<?=$assign_status ?>','like':search,'group':group},
            async: false,
            success: function(result) {   
                if(result!=''){
            		$('.table-append').html(result);
                    datatable();
                }else
                      toastr.success('No result found b/w selected date');
            }
        });
    }

function datatable()
{
	$(".data-table-feature").DataTable({
        sDom: '<"row view-filter"<"col-sm-12"<"float-right"l><"float-left"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        drawCallback: function () {
          $($(".dataTables_wrapper .pagination li:first-of-type"))
            .find("a")
            .addClass("prev");
          $($(".dataTables_wrapper .pagination li:last-of-type"))
            .find("a")
            .addClass("next");

          $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        },
        language: {
          paginate: {
            previous: "<i class='simple-icon-arrow-left'></i>",
            next: "<i class='simple-icon-arrow-right'></i>"
          },
          search: "_INPUT_",
          searchPlaceholder: "Search...",
          lengthMenu: "Items Per Page _MENU_"
        },
      });
}
</script>