<link href="<?php echo STATIC_ADMIN_CSS;?>simplePagination.css" rel="stylesheet">
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
                <h1>
                <?php if($this->uri->segment(3)=="static_forms_pending")
                		echo "Static - Pending Review";
                	  else if($this->uri->segment(3)=="static_forms_reviewed")
                      	echo "Static - Pending Approval";
                      else if($this->uri->segment(3)=="static_forms_approved")
                      	echo "Static - Approved";
                ?></h1>
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
                                    <th class="text-center" style="width:120px;">Inspection Datetime <i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center"style="width:200px;" >Check Name<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:200px;">Inspection Group<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <?php
                                    if(isset($assign_status) && !empty($assign_status)) {
                                        if(strtolower($assign_status)  == 'approved' || strtolower($assign_status)  == 'reviewed') { ?>
                                            <th class="text-center" style="width:200px;">Reviewer<i class="fa fa-sort" style="font-size:13px;"></th>
                                        <?php }
                                        if(strtolower($assign_status)  == 'approved') { ?>
                                            <th class="text-center" style="width:200px;">Approver<i class="fa fa-sort" style="font-size:13px;"></th>
                                        <?php }
                                    }
                                    ?>
                                    <th class="text-center"style="width:200px;" >Status<i class="fa fa-sort" style="font-size:13px;"></th>
                                    <th class="text-center" style="width:500px;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ajax_content_wrapper">
                                <?php
                                $i = 0;
                                if (isset($result)) {
                                    foreach ($result  as $key => $value) {
                                        $i++;
                                        ?>
                                    <tr  id="Row_<?= $value['assign_id']; ?>" class="odd gradeX "  >
                                        <td class="text-center">
                                            <?php echo $value['complete_datetime']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $value['check_name']; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $value['group'];?>
                                        </td>
                                        <?php
                                        if(isset($assign_status) && !empty($assign_status)) {
                                            if(strtolower($assign_status)  == 'approved' || strtolower($assign_status)  == 'reviewed') { ?>
                                                <td class="text-center">
                                                    <?php 
                                                    if(isset($value['review_user']) && !empty($value['review_user'])) {
                                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$value['review_user']),'id desc','users','first_name,last_name','1','1')->result_array();
                                                        $fisrt_name=''; 
                                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                                        $last_name=''; 
                                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                                          $last_name=$review_user_detail[0]['last_name']; 
                                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name;   
                                                    }
                                                    ?>
                                                </td>
                                            <?php }
                                            if(strtolower($assign_status)  == 'approved') { ?>
                                                <td class="text-center">
                                                    <?php 
                                                    if(isset($value['approval_user']) && !empty($value['approval_user'])) {
                                                        $review_user_detail = Modules::run('api/_get_specific_table_with_pagination',array("id"=>$value['approval_user']),'id desc','users','first_name,last_name','1','1')->result_array();
                                                        $fisrt_name=''; 
                                                        if(isset($review_user_detail[0]['first_name']) && !empty($review_user_detail[0]['first_name'])) 
                                                          $fisrt_name=$review_user_detail[0]['first_name']; 
                                                        $last_name=''; 
                                                        if(isset($review_user_detail[0]['last_name']) && !empty($review_user_detail[0]['last_name'])) 
                                                          $last_name=$review_user_detail[0]['last_name']; 
                                                        $name=  Modules::run('api/string_length',$fisrt_name,'8000','',$last_name); echo $name;   
                                                    }
                                                    ?>
                                                </td>
                                            <?php }
                                        }
                                        ?>
                                        <td class="text-center">
                                            <?php echo $value['assign_status'];?>
                                        </td>
                                        <td>
                                            <a class="btn yellow c-btn view_details" rel="<?= $value['assign_id']; ?>"><i class="iconsminds-file"  title="See Detail"></i></a>
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
        </div>
    </main>
<script type="text/javascript">
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
              $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>static_form/static_form_detail",
                        data: {'id': id,'function':'<?=$this->uri->segment(3);?>'},
                        async: false,
                        success: function(test_body) {
                            var test_desc = test_body;
                            $('#truct_inspection').modal('show');
                            $("#truct_inspection .modal-body").html(test_desc);
                            var review_status = $("#truct_inspection").find(".review_status").text();
                            if(review_status == true) {
                                var review_text = $("#truct_inspection").find(".review_text").text();
                                $("#truct_inspection .modal-footer").html('<button type="button" data-dismiss="modal" class="btn btn-primary  pull-right">Cancel</button> <button type="button" class="btn btn-primary pull-right submit_check" >'+review_text+'</button>');
                            }
                            submit_status();
                        }
                    });
            });
            function submit_status() {
                $('.status_button').off('click').click(function(event){
                    event.preventDefault();
                    var id = $(this).attr('rel');
                    var txt =  $(this).attr('status');
                    $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>assignments/static_checks_status",
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
            url: '<?= ADMIN_BASE_URL?>assignments/static_assignment_search',  
            data: {'page_number':page_number,'startdate':startdate,'enddate':enddate,'limit':<?=$limit?>,'assign_status':'<?=$assign_status ?>'},
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
            }
        });
    }
    <?php if(isset($page_number) && is_numeric($page_number) && isset($total_pages) && is_numeric($total_pages)) { if($total_pages>1) {?>
        pagination_call('<?=$total_pages;?>','<?=$page_number;?>');
    <?php }}?>
</script>
