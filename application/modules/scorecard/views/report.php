
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
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
                                <?php if(!isset($supplier)) $supplier = array();
                                $options = array('' => 'Select')+$supplier ;
                                echo form_label('Supplier', 'supplier_id');?>
                                <div>
                                    <?php echo form_dropdown('supplier_id', $options, '',  'class="form-control select2me required validatefield" id="supplier_id" tabindex ="8"'); ?>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>From:</label>
                                    <div class='input-group datetimepicker2'>
                                        <input type='text' class="form-control" id="startdate" style="padding: 6px;" />
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
                                    <input type='text' class="form-control" id="enddate" style="padding: 6px;"/>
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
                        <div id="div_tblreport"> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    
<script src="<?php echo STATIC_ADMIN_JS?>ionicons.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>raphael.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Chart.bundle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click", ".filter_search", function(event){
            event.preventDefault();
            var supplier_id =$("#supplier_id").val();
            var startdate =$("#startdate").val();
            var enddate =$("#enddate").val();
            if(supplier_id!="" && startdate!="" && enddate!=""){
              $.ajax({
                        type: 'POST',
                        url: "<?=ADMIN_BASE_URL?>scorecard/reporting_list",
                        data: {'supplier_id': supplier_id,'startdate':startdate,'enddate':enddate},
                        async: false,
                        success: function(test_body) {
                            $('#div_tblreport').html(test_body);
                            $('table').dataTable({
                                'bFilter': false,
                                'bInfo': false,
                                'bLengthChange': false,
                                'bPaginate': false
                            });
                        }
                    });
                }
                else{
                    toastr.error("Please Apply all filters");
                }
            });

    });
</script>