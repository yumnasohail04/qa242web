<style>
    .white_bg
    {
        background-color: white;
        box-shadow: 0 0 32px rgba(0,0,0,0.11);
        border-radius: 15px;
    }
    .wrapper>section {
    background-color: #ffffff;
}
.card {
     border: none; 
}
.mb-0
{
    background-color: #5d8abf;
    color: white;
    text-align: center;
    padding: 10px;
}
.font-head
{
        font-size: 20px;
    text-align: center;
}
.cards
{
    text-align:center;
}
.fa_icons , .mb
{
    font-size: 60px;
    width: 100%;
        padding-top: 15px;
}
.fa_icons
{
    color: #5d8abf;
}
.sub_row
{
    padding: 30px;
}
#myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 45%;
    height: 16px;
    background-color: #f38282;
    text-align: center;
    line-height: 30px;
    color: white;
}
.prog
{
    padding-bottom: 5%;
}
.check-content
{
    box-shadow: 0 0 32px rgba(0,0,0,0.11);
    padding: 15px;
    border-radius: 10px;
}
.date_time
{
    text-align: center;
    background-color: #5d8abf;
    padding: 2px;
    margin-top: 15px;
    margin-bottom: 15px;
}
.check-content
{
        margin-bottom: 15px;
}
.overflow_bar
{
    overflow:scroll;
    height:530px;
}
</style>
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
                <div class="row ">
                    <div class="col-lg-8">
                        <div class="row ">
                        <div class="col-sm-6 col-lg-6">
                            <div class="card text-white white_bg">
                                <div class="card-body pb-0">
                                    <h4 class="mb-0">
                                       Totals
                                    </h4>
                                    <div class="row sub_row">
                                        <div class="col-lg-4 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span class="count">86</span>
                                            </h4>
                                           <span class="font-head">Forms</span>
                                           <i class=" fa fa-list-alt fa_icons"></i>
                                        </div>
                                        <div class="col-lg-4 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span class="count">1086</span>
                                            </h4>
                                           <span class="font-head">Records</span>
                                           <i class="fa fa-archive fa_icons"></i>
                                        </div>
                                        <div class="col-lg-4 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span class="count">8</span>
                                            </h4>
                                           <span class="font-head">Users</span>
                                           <i class="fa fa-user fa_icons"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="card text-white white_bg">
                                <div class="card-body pb-0">
                                    <h4 class="mb-0">
                                        Compliants
                                    </h4>
                                     <div class="row sub_row">
                                        <div class="col-lg-6 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span class="count" style="font-size: 50px;color:#81ab62; ">76</span>
                                            %</h4>
                                           <span class="font-head"></span>
                                        </div>
                                        <div class="col-lg-6 cards" style="color:#929292">
                                           <i style="font-size: 90px;color:#81ab62;" class=" fa fa-check-circle fa_icons"></i>
                                        </div>
                                    </div>
                                    <div class="prog">
                                        <div id="myProgress">
                                          <div id="myBar" style="background-color:#81ab62"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="row ">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white white_bg">
                                <div class="card-body pb-0">
                                    <h4 class="mb-0">
                                        Unsigned
                                    </h4>
                                     <div class="row sub_row">
                                        <div class="col-lg-12 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span style="color:#E8BC68;" class="count">96</span>
                                            </h4>
                                           <span class="font-head">Forms</span>
                                           <i style="color:#E8BC68;" class=" fa fa-folder fa_icons"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white white_bg">
                                <div class="card-body pb-0">
                                    <h4 class="mb-0">
                                        Signed
                                    </h4>
                                     <div class="row sub_row">
                                        <div class="col-lg-12 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span style="color:#84BE67;" class="count">990</span>
                                            </h4>
                                           <span class="font-head">Forms</span>
                                           <i style="color:#84BE67;" class=" fa fa-edit fa_icons"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-sm-6 col-lg-6">
                            <div class="card text-white white_bg">
                                <div class="card-body pb-0">
                                    <h4 class="mb-0">
                                        Non-Compliants
                                    </h4>
                                     <div class="row sub_row">
                                        <div class="col-lg-6 cards" style="color:#929292">
                                            <h4 class="mb">
                                            <span class="count" style="font-size: 50px; color: #d26969;">24</span>
                                            %</h4>
                                           <span class="font-head">Forms</span>
                                        </div>
                                        <div class="col-lg-6 cards" style="color:#929292">
                                           <i style="font-size: 90px; color: #d26969;" class=" fa fa-times-circle fa_icons"></i>
                                        </div>
                                    </div>
                                    <div class="prog">
                                        <div id="myProgress">
                                          <div style="background-color: #d26969;" id="myBar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                     <div class="col-sm-6 col-lg-4">
                            <div class="card text-white white_bg">
                                <div class="card-body pb-0">
                                    <h4 class="mb-0">
                                        Corrections
                                    </h4>
                                     <div class="row sub_row overflow_bar">
                                        <div class=" cards" style="color:#929292; margin-bottom: 12px;">
                                           <span class="font-head"><i style="font-size: 30px; color: #5d8abf;" class=" fa fa-close "></i> Unresolved</span>
                                        </div>
                                        <div class="check-content">
                                            <div class="date_time">
                                                <span>Monday Sept 30,2019</span>
                                            </div>               
                                            <div class="contents">
                                                <p>Sanitation Manager</p>
                                                <p style="font-weight: bold; font-size: 25px;">operational sanitation performance standard</p>
                                            </div>
                                        </div>
                                        <div class="check-content">
                                            <div class="date_time">
                                                <span>Monday Sept 30,2019</span>
                                            </div>               
                                            <div class="contents">
                                                <p>QA Tech</p>
                                                <p style="font-weight: bold; font-size: 25px;">Frozen Pasta Packaging Record</p>
                                            </div>
                                        </div>
                                        <div class="check-content">
                                            <div class="date_time">
                                                <span>Monday Sept 30,2019</span>
                                            </div>               
                                            <div class="contents">
                                                <p>Filling Maker</p>
                                                <p style="font-weight: bold; font-size: 25px;">Filling Bowl Seafood CCP Monitoring Record</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
                  <!--  <div class="col-sm-6 col-lg-3">
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
                    </div>-->
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

