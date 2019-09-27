<div class="checking_previous"></div>
<div class="page-content-wrapper">
    <div class="page-content">
        <section>
            <div class="content-wrapper" style="padding-bottom: 0px !important;">
                <div class="content-heading" style="margin-bottom: 0px !important;">
                   Dashboard
                   <small data-localize="dashboard.WELCOME"></small>
                </div>
            </div>
        </section>
        <section>
            <div class="content-wrapper">
                <form id="search_form" action="javascript:void(0)" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Select Check:</label>
                                    </div>
                                    <div class="col-sm-7" style="padding: 0px !important;">
                                        <select class="form-control" id="myselect" name="selecting">
                                            <option value="">Select Check</option>
                                            <option value="receivinginspectionlog">Receiving Inspection Log</option>
                                            <option value="shippinginspection">Shipping Inspection</option>
                                            <option value="palletizinginspection">Palletizing Inspection</option>
                                            <option value="cleaninginspection">Cleaning Inspection</option>
                                            <option value="bulkpastatemplogeverytub">Bulk Pasta Temp Log Every Tub</option>
                                            <option value="bulkpastatemplogeveryform">Bulk Pasta Temp Log Every Form</option>
                                            <option value="recodeinspection">Recode Inspection</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>From:</label>
                                    </div>
                                    <div class="col-sm-9" style="padding: 0px !important;">
                                        <div class='input-group datetimepicker2'>
                                            <input type='text' class="form-control validatefield" id="startdate" name="startdate" />
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>To:</label>
                                    </div>
                                    <div class="col-md-9" style="padding: 0px !important;">
                                        <div class='input-group datetimepicker2'>
                                            <input type='text' class="form-control validatefield" id="enddate" name="enddate" />
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="margin-top: 7px;">
                                <button type="button" class="btn btn-primary form-control filter_search">Search</button>
                             </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-1">
                            <div class="card-body pb-0">
                               <h4 class="mb-0">
                                    <span class="count" >
                                      <?php $temp='0'; if(isset($products) && !empty($products)) $temp=$products; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?>
                                    </span>
                                </h4>
                                <p class="text-light" >Products</p>

                                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-2">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count">
                                      <?php $temp='0'; if(isset($users) && !empty($users)) $temp=$users; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?>
                                    </span>
                                </h4>
                                <p class="text-light">Users</p>
                                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                    <canvas id="widgetChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-3">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count">
                                      <?php $temp='0'; if(isset($groups) && !empty($groups)) $temp=$groups; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?>
                                    </span>
                                </h4>
                                <p class="text-light">Groups</p>
                            </div>
                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                <canvas id="widgetChart3"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-4">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count"><?php $temp='0'; if(isset($totalchecks) && !empty($totalchecks)) $temp=$totalchecks; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?></span>
                                </h4>
                                <p class="text-light">Total Checks</p>
                                <div class="chart-wrapper px-3" style="height:70px;" height="70">
                                    <canvas id="widgetChart8"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-6">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count" ><?php $temp='0'; if(isset($activechecks) && !empty($activechecks)) $temp=$activechecks; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?></span>
                                </h4>
                                <p class="text-light" >Active Checks</p>

                                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                    <canvas id="widgetChart5"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-7">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count"><?php $temp='0'; if(isset($overduechecks) && !empty($overduechecks)) $temp=$overduechecks; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?></span>
                                </h4>
                                <p class="text-light">OverDue Checks</p>
                                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                    <canvas id="widgetChart6"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-8">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count"><?php $temp='0'; if(isset($pendingreviews) && !empty($pendingreviews)) $temp=$pendingreviews; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?></span>
                                </h4>
                                <p class="text-light">Pending Review</p>
                            </div>
                            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                <canvas id="widgetChart7"></canvas>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-5">
                            <div class="card-body pb-0">
                                <h4 class="mb-0">
                                    <span class="count"><?php $temp='0'; if(isset($pendingapproval) && !empty($pendingapproval)) $temp=$pendingapproval; $temp=  Modules::run('api/string_length',$temp,'100','0'); echo $temp; ?></span>
                                </h4>
                                <p class="text-light">Pending Approval</p>
                                <div class="chart-wrapper px-3" style="height:70px;" height="70">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>	
                
                
                </div>
            </div>
        </section>
	</div>
</div>
<script src="<?php echo STATIC_ADMIN_JS?>jquery.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Chart.bundle.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>widgets.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.filter_search').on('click', function() {
            if(validateForm()) {
                if(!$('.checking_previous').text()) {
                    $('#search_form').attr('action', "<?=ADMIN_BASE_URL?>dashboard/reporting").submit();
                    $('.checking_previous').html('');
                    location.reloadt();
                }
                else
                  showToastr("Please complete the previous update first", false); 
            }
        });
    });
    function validateForm() {
        var isValid = true;
        $('.validatefield').each(function() {
            if ( $(this).val() === '') {
                $(this).css("border", "1px solid red");
                isValid = false;
            }
            else 
                $(this).css("border", "1px solid #dde6e9");
        });
        if($( "#myselect option:selected" ).val() == '' ) {
            $( "#myselect" ).css("border", "1px solid red");
                isValid = false;
        }
        else
            $( "#myselect").css("border", "1px solid #dde6e9");
        return isValid;
    }
    var showToastr = function (msg, type) {
        if(type == true)
            toastr.success(msg);
        else
            toastr.error(msg);
    };
</script>

   