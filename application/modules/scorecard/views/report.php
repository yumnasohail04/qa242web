
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>




    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <input type="hidden" id="assign_type" value="<?=$this->uri->segment(3);?>" />
                    <h1>Scorecard Report</h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="users/create">&nbsp;Add New&nbsp;</a>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
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
                                <div class="form-group mb-1">
                                <label>From:</label>
                                    <div class='input-group date'>
                                        <input type='text' class="form-control" id="startdate" style="padding: 6px;" />
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
                                    <input type='text' class="form-control" id="enddate" style="padding: 6px;"/>
                                    <span class="input-group-text input-group-append input-group-addon">
                                        <i class="simple-icon-calendar"></i>
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