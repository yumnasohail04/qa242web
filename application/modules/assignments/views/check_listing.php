<link href="<?php echo STATIC_ADMIN_CSS;?>simplePagination.css" rel="stylesheet">
<!-- Page content-->
<div class="old_search" style="display: none;"></div>
<div class="content-wrapper">
    <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
    <h3><?php if($assign_status == 'active_checks') echo "Active"; elseif($assign_status == 'overdue_checks') echo "Overdue";elseif($assign_status == 'today_checks') echo "Overdue"; else echo ""; ?> Assignments</h3>
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
                            <div class="col-md-2">
                                <div class="form-group" style="margin-top: 33px;">
                                    <button type="button" class="btn btn-primary form-control filter_search" style="    max-width:85px;">Search</button>
                                 </div>
                            </div>
                            <div class="col-md-5"  style="float:right; margin-bottom: 1%;">
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
                            </div>
                        </div>
                        <table class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                    <th class="text-center"  style="width:120px;">
                                        Start Time <i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <th class="text-center"  style="width:120px;">
                                        End Time <i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <th class="text-center" style="width:200px;">
                                        Check Name <i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <th class="text-center" style="width:200px;">
                                        Responsible Team <i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                        Plant<i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                        Lines<i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <th class="text-center"style="width:200px;" >
                                        Product<i class="fa fa-sort" style="font-size:13px;">
                                    </th>
                                    <?php if($this->uri->segment(3) == 'today_checks'){ ?>
                                        <th class="text-center"style="width:200px;" >
                                            Status<i class="fa fa-sort" style="font-size:13px;">
                                        </th>
                                    <?php }?>
                                    <th class="text-center" style="width:200px;" >
                                        Program Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody  id="ajax_content_wrapper">
                                <?php $i = 0; $previous_product = array();
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
                                                <?php 
                                                    if(!isset($new->plant_name) && empty($new->plant_name)) 
                                                        echo "-";
                                                    else
                                                        echo $new->plant_name;
                                                ?>
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
                                        	<td class="text-center">
                                                <?php
                                                if(isset($new->product_id) && !empty($new->product_id)) {
                                                    $keying = array_search($new->product_id, array_column($previous_product, 'product_id'));
                                                    if(is_numeric($keying))
                                                        echo $previous_product[$keying]['product_name'];
                                                    else {
                                                        $product_detail = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("id"=>$new->product_id),'id desc','id',DEFAULT_OUTLET.'_product','id,product_title','1','1','','','')->row_array();
                                                        if(isset($product_detail['id']) && !empty($product_detail['id'])) {
                                                            echo $product_detail['product_title'];
                                                            $temparary = array();
                                                            $temparary['product_id'] = $product_detail['id'];
                                                            $temparary['product_name'] = $product_detail['product_title'];
                                                        }
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
                        <br><br>
                        <div class="mg-t-20-f floatright" style="clear: both" id="light-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>
<script type="text/javascript">

    var search = document.getElementById("search");
    search.addEventListener("keyup", function() {
    	$('.old_search').text(search.value);
    	ajax_call('1','','');
    });

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
            $('.old_search').text($('.current_search').val());
            if(startdate == '' || enddate == '') {
                toastr.success('Please Select Date Range');
            }
            else {
                firstclick="fdafdas";
                ajax_call('1',startdate,enddate);
            }  
        });
    });
    function pagination_call(total_number_pages,active) {
        $.getScript("<?php echo STATIC_ADMIN_JS;?>jquery.simplePagination.js").done(function( s, Status ) {
          $('#light-pagination').pagination({
            items: total_number_pages,
            itemsOnPage: <?=$limit?>,
            cssStyle: 'light-theme'
            });
            $('#light-pagination').pagination('selectPage', active);
            $('#light-pagination').off('click').click(function(event) {
                var valuecheck = '';
                if($(this).find('.active').text() == 'Next') {
                    valuecheck = parseInt($('#light-pagination').find('.active').find('.current').text());
                }
                else if($(this).find('.active').text() == 'Prev') {
                    valuecheck = parseInt($('#light-pagination').find('.active').find('.current').text());
                }
                else {
                    valuecheck = $(this).find('.active').text();
                }
                var StartDate=$('#startdate').val();
                var EndDate=$('#enddate').val();
                if(firstclick != "fdafdas") {
                    StartDate = "";
                    EndDate = "";
                }
                ajax_call(valuecheck,StartDate,EndDate);
                
            });
            $('#light-pagination').find('.page-link').each(function(){
                $(this).attr('href','javascript:void(0);');
            });
        });
    }
    var citycurrentRequest=null;
    function ajax_call(page_number,startdate,enddate) {
        var search = $('.old_search').text();
        citycurrentRequest= $.ajax({
            type: "POST",  
            url: '<?= ADMIN_BASE_URL?>assignments/get_check_listing_filter_data',  
            data: {'page_number':page_number,'startdate':startdate,'enddate':enddate,'limit':<?=$limit?>,'assign_status':'<?=$assign_status ?>','like':search},
            dataType: 'html',
            beforeSend : function()    {           
                if(citycurrentRequest != null) {
                    citycurrentRequest.abort();
                }
            },
            success: function(result) {
                var datamain = $(result).find('datamain').html();
                var tablecreat = ''
                var active= $(result).find('pagenumber').text();
                var total_number_pages= $(result).find('totalpage').text();
                $(result).find('datamain').find('trr').each(function(){
                    tablecreat = tablecreat+'<tr>';
                    $(this).find('tdd').each(function(){
                        tablecreat = tablecreat+'<td>'+$(this).html()+'</td>';
                    })
                })
                tablecreat = tablecreat+'<tr  valign="top" colspan="6" class="dataTables_empty">';
                if(total_number_pages == '0')
                        tablecreat = tablecreat+'<td colspan="6">No data available in table</td>';
                    tablecreat = tablecreat+'</tr>';
                $('#ajax_content_wrapper').html(tablecreat);
                if(total_number_pages>1)
                    pagination_call(total_number_pages,active);
                else
                    pagination_call('1','1');
                detail();
            }
        });
    }
    <?php if(isset($page_number) && is_numeric($page_number) && isset($total_pages) && is_numeric($total_pages)) { if($total_pages>1) {?>
        pagination_call('<?=$total_pages;?>','<?=$page_number;?>');
    <?php }}?>
</script>