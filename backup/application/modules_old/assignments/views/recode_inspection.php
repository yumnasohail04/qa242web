<link href="<?php echo STATIC_ADMIN_CSS;?>simplePagination.css" rel="stylesheet">
<!-- Page content-->
<div class="content-wrapper">
    <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
    <h3><?php if($this->uri->segment(3) == 'truck_inspection') echo "Truck"; elseif($this->uri->segment(3) == 'shipping_inspection') echo "Shipping"; elseif($this->uri->segment(3) == 'pending_review') echo "Pending";  elseif($this->uri->segment(3) == 'pending_approval') echo "Pending Approval"; else echo ""; ?> Inspection</h3>
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
                        <table class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                    <th class="text-center" style="width:120px;">Inspection Date <i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:120px;">Inspection Time <i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:200px;">Monitor Name<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center"style="width:200px;" >Source Item No.<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center"style="width:200px;" >Status<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:500px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody  id="ajax_content_wrapper">
                                <?php
                                $i = 0;
                                if (isset($inspection)) {
                                    foreach ($inspection->result() as
                                            $new) {
                                        $i++;
                                        ?>
                                    <tr  id="Row_<?=$new->ri_id?>" class="odd gradeX "  >
                                        <td class="text-center">
                                            <?php echo date('m-d-Y',strtotime($new->ri_datetime)); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo date('H:i:s',strtotime($new->ri_datetime)); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                if(isset($new->ri_initial) && !empty($new->ri_initial))
                                                $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$new->ri_initial),'id desc','users','first_name,last_name','1','1')->result_array();
                                                $fisrt_name=''; 
                                                if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                                  $fisrt_name=$review_user_detail[0]['first_name']; 
                                                $last_name=''; 
                                                if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                                  $last_name=$review_user_detail[0]['last_name']; 
                                                $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name; 
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $new->ri_source_item_no;?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $new->ri_status;?>
                                        </td>
                                        <td>
                                            <a class="btn yellow c-btn view_details" rel="<?=$new->ri_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        </td>
                                    </tr>
                                    <?php } ?>    
                                <?php } ?>
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
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
              $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/recode_inspection_detail",
                        data: {'id': id,'review_approval':"<?=$review_approval?>"},
                        async: false,
                        success: function(test_body) {
                            var test_desc = test_body;
                            $('#truct_inspection').modal('show');
                            $("#truct_inspection .modal-body").html(test_desc);
                            if($('.form-body').find('.status_value').text()) {
                                $("#truct_inspection .modal-footer").find('.status_button').remove();
                                $("#truct_inspection .modal-footer").append('<button type="button" data-dismiss="modal" class="btn btn-primary  pull-right status_button" rel="'+id+'" >'+$('.form-body').find('.status_value').text()+'</button>');
                            }
                            $('.form-body').find('.status_value').remove();
                            submit_status();
                        }
                    });
            });
            function submit_status() {
                $('.status_button').off('click').click(function(event){
                    event.preventDefault();
                    var id = $(this).attr('rel');
                    var txt = $(this).text();
                    $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/recode_inspection_status",
                        data: {'id': id,'txt':txt},
                        async: false,
                        success: function(test_body) {
                        	location.reload();
                        }
                    });
                });
            }
            submit_status();

    /*///////////////////////// end for code detail //////////////////////////////*/


});
</script>

<script>
    var PreviousStartDate=$('#startdate').val();
    var PreviousEndDate=$('#enddate').val();
    var firstclick = "one";
    $(document).ready(function() {
        $('.filter_search').on('click', function() {
            var startdate=$('#startdate').val();
            var enddate=$('#enddate').val();
            if(startdate == '' || enddate == '') {
                toastr.success('Please Select Date Range');
            }
            else{
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
        citycurrentRequest= $.ajax({
            type: "POST",  
            url: '<?= ADMIN_BASE_URL?>assignments/get_recode_search',  
            data: {'page_number':page_number,'startdate':startdate,'enddate':enddate,'limit':<?=$limit?>},
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
                tablecreat = tablecreat+'<tr>';
                if(total_number_pages == '0')
                        tablecreat = tablecreat+'<td colspan="6">No data available in table</td>';
                    tablecreat = tablecreat+'</tr>';
                $('#ajax_content_wrapper').html(tablecreat);
                if(total_number_pages>1)
                    pagination_call(total_number_pages,active);
                else
                    pagination_call('1','1');
                submit_status();
            }
        });
    }
    <?php if(isset($page_number) && is_numeric($page_number) && isset($total_pages) && is_numeric($total_pages)) { if($total_pages>1) {?>
        pagination_call('<?=$total_pages;?>','<?=$page_number;?>');
    <?php }}?>
</script>
