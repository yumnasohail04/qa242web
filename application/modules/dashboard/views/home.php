<link href="<?php echo STATIC_ADMIN_CSS?>ionicons.min.css" rel="stylesheet">
<link href="<?php echo STATIC_ADMIN_CSS?>typicons.css" rel="stylesheet">
<link href="<?php echo STATIC_ADMIN_CSS?>morris.css" rel="stylesheet">
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script> -->
    
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
      .btn_time_period {
        cursor: pointer;
    }
    #overlay {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.2);
  z-index: 2;
  cursor: pointer;
}
.badge-primary
{
border-radius:8px;
color: white!important;
padding: 5px;}
</style>
<main>
<div id="overlay" onclick="off()"></div>
<div id="wait" style="display: none;position: absolute;left: 50%;top:10%; padding: 2px;z-index: 9999;"><img src='https://www.bertuccis.com/wp-content/themes/bertuccis-child/assets/images/loading-dots-white.gif'  /></div>
  <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Dashboard</h1>
              <div class="separator mb-5"></div>
          </div>
      </div>
         <div class="row sortable content-wrapper">
                <div class="col-xl-2 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class=""><a class="btn_time_period badge-primary" data-type="week" data-value="7">&nbsp;&nbsp;Week&nbsp;&nbsp;</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class=""><a class="btn_time_period  btn-default" data-type="month" data-value="1">&nbsp;&nbsp;1 Month&nbsp;&nbsp;</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class=""><a class="btn_time_period btn-default" data-type="threemonth" data-value="3">&nbsp;&nbsp;3 Months&nbsp;&nbsp;</a></h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class=""><a class="btn_time_period btn-default" data-type="sixmonth" data-value="6">&nbsp;&nbsp;6 Months&nbsp;&nbsp;</a></h6>
                            
                        </div>
                    </div>
                </div>
         		<div class="col-xl-2 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class=""><a class="btn_time_period btn-default" data-type="oneyear" data-value="12">&nbsp;&nbsp;1 Year&nbsp;&nbsp;</a></h6>
                            
                        </div>
                    </div>
                </div>
         		<div class="col-xl-2 col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                        </div>
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h6 class=""><a class="btn_time_period btn-default" data-type="two" data-value="24">&nbsp;&nbsp;2 Year&nbsp;&nbsp;</a></h6>
                            
                        </div>
                    </div>
                </div>
            </div>
  			<div class="row">
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">Completed / Pending Checks</h5>
                                    <span class="text-muted text-small d-block"></span>
                                </div>
                            </div>
<!--                             <div class="btn-group float-right float-none-xs mt-2">
                                <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Overdue
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 25px, 0px);">
                                    <a class="dropdown-item" href="#">Overdue</a>
                                    <a class="dropdown-item" href="#">Completed</a>
                                </div>
                            </div> -->
                        </div>
                        <div class="chart card-body pt-0 cpchart">
                          <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                              <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                              </div>
                            </div>
                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                              <div style="position:absolute;width:200%;height:200%;left:0; top:0">
                              </div>
                            </div>
                          </div>
                          <canvas id="visitChart1" width="646" height="194" class="chartjs-render-monitor" style="display: block; width: 646px; height: 194px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">Compliant / Non-Compliant Checks</h5>
                                </div>
                            </div>
<!--                             <div class="btn-group float-right mt-2 float-none-xs">
                                <button class="btn btn-outline-secondary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Compliant
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 25px, 0px);">
                                    <a class="dropdown-item" href="#">Compliants</a>
                                    <a class="dropdown-item" href="#">Non Compliants</a>
                                </div>
                            </div> -->
                        </div>
                        <div class="chart card-body pt-0 cnchart"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                            <canvas id="conversionChart1" width="646" height="194" class="chartjs-render-monitor" style="display: block; width: 646px; height: 194px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
  <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Static Checks</h5>
                            <div class="chart-container chart">
                                <canvas id="polarChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4 mb-4">
                    <div class="card dashboard-progress">
                        <div class="position-absolute card-top-buttons">
                            <button class="btn btn-header-light icon-button">
                                <i class="simple-icon-refresh"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Status</h5>
                            <div class="mb-4">
                                <p class="mb-2">Active Users
                                    <span class="float-right text-muted"><?php echo $a_users.'/'.$t_users;?></span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $user_percent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="mb-2">Active Groups
                                    <span class="float-right text-muted"><?php echo $a_groups.'/'.$t_groups;?></span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $group_percent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="mb-2">Active Standard Checks
                                    <span class="float-right text-muted"><?php echo $a_standard.'/'.$t_standard;?></span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $standard_percent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="mb-2">Active Scheduled checks
                                    <span class="float-right text-muted"><?php echo $a_schedule.'/'.$t_schedule;?></span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $schedule_percent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="mb-2">Active Static Checks
                                    <span class="float-right text-muted"><?php echo $a_static.'/'.$t_static;?></span>
                                </p>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $static_percent ?>" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-4">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="lead color-theme-1 mb-1 value"></p>
                                    <p class="mb-0 label text-small badge-primary"></p>
                                    <div class="chart">
                                        <canvas id="smallChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="lead color-theme-1 mb-1 value"></p>
                                    <p class="mb-0 label text-small badge-primary"></p>
                                    <div class="chart">
                                        <canvas id="smallChart2"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="lead color-theme-1 mb-1 value"></p>
                                    <p class="mb-0 label text-small badge-primary"></p>
                                    <div class="chart">
                                        <canvas id="smallChart3"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card dashboard-small-chart-analytics">
                                <div class="card-body">
                                    <p class="lead color-theme-1 mb-1 value"></p>
                                    <p class="mb-0 label text-small badge-primary"></p>
                                    <div class="chart">
                                        <canvas id="smallChart4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

   <div class="row">
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">Pre-op</h5>
                                </div>
                            </div>
                        </div>
                        <div class="chart card-body pt-0 row">
                        <div class="col-sm-12 col-lg-3">
<!--                                     <div id="morrisDonut1" class="morris-donut-wrapper-demo" style="height:150px; "></div> -->
                                  <div class="chart-container chart">
                                        <canvas id="categoryChart1"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-9 mb-5">
                                <div class="chart-container chart pc1">
                                     <canvas id="productChart1"></canvas>
                                 </div>
                             </div>
                        
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">CCP</h5>
                                </div>
                            </div>
                        </div>
                        <div class="chart card-body pt-0 row">
                            <div class="col-sm-12 col-lg-3">
<!--                                     <div id="morrisDonut2" class="morris-donut-wrapper-demo" style="height:150px;"></div> -->
                                <div class="chart-container chart ">
                                        <canvas id="categoryChart2"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-9 mb-5">
                                <div class="chart-container chart pc2">
                                     <canvas id="productChart2"></canvas>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
  
                        
   <div class="row">
                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">ATP Swab</h5>
                                </div>
                            </div>
                        </div>
                        <div class="chart card-body pt-0 row">
                        <div class="col-sm-12 col-lg-3">
<!--                                     <div id="morrisDonut1" class="morris-donut-wrapper-demo" style="height:150px; "></div> -->
                                     <div class="chart-container chart">
                                        <canvas id="categoryChart3"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-9 mb-5">
                                <div class="chart-container chart pc3">
                                     <canvas id="productChart3"></canvas>
                                 </div>
                             </div>
                        
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card dashboard-filled-line-chart">
                        <div class="card-body ">
                            <div class="float-left float-none-xs">
                                <div class="d-inline-block">
                                    <h5 class="d-inline">Receiving Log</h5>
                                </div>
                            </div>
                        </div>
                        <div class="chart card-body pt-0 row">
                            <div class="col-sm-12 col-lg-3">
<!--                                     <div id="morrisDonut2" class="morris-donut-wrapper-demo" style="height:150px;"></div> -->
                                <div class="chart-container chart">
                                        <canvas id="categoryChart4"></canvas>
                                    </div>
                                </div>
                                <div class="col-lg-9 mb-5">
                                <div class="chart-container chart pc4">
                                     <canvas id="productChart4"></canvas>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div> 
  
                        
                        
                        
 <div class="row mb-4">
          <div class="col-12 mb-4">
              <div class="card">
                  <div class="card-body">
                        <div class="row ">
<!--                             <div class=" col-sm-12 col-lg-8">
                                <div id="chart">
                            </div>
                            </div> -->
<!--                             <div class=" col-sm-12 col-lg-4">
                                <div id="morrisLine1" class="morris-wrapper-demo" style="height:330px;" ></div>
                            </div> -->
                                <div class="col-sm-12 col-lg-12">
                                    <div class="chart-container chart ptchart">
                                        <canvas id="salesChart"></canvas>
                                    </div>
                                </div>
                             
       </div>
      </div>
     </div>
 </div>
          </div>                
                        
    
                  
 
        <div class="row mb-4">
          <div class="col-12 mb-4">
              <div class="card">
                  <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="div_tblreport"></div>
                    </div>
                </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
    <script src="<?php echo STATIC_ADMIN_JS?>vendor/Chart.bundle.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>vendor/chartjs-plugin-datalabels.js"></script>
<!--  	<script src="<?php echo STATIC_ADMIN_JS?>dore.script.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>vendor/moment.min.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>scripts.js"></script> -->


<script type="text/javascript">



 var chartTooltip = {
        backgroundColor: foregroundColor,
        titleFontColor: primaryColor,
        borderColor: separatorColor,
        borderWidth: 0.5,
        bodyFontColor: primaryColor,
        bodySpacing: 10,
        xPadding: 15,
        yPadding: 15,
        cornerRadius: 0.15,
        displayColors: false
      };
   var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    /* 03.02. Resize */
    var subHiddenBreakpoint = 1440;
    var searchHiddenBreakpoint = 768;
    var menuHiddenBreakpoint = 768;

    var var_time_period = 1;
    var today = new Date();
    function get_graphs_data(date_from_str,date_to_str,var_time_period){
    
  var gph_data={};



document.getElementById("overlay").style.display = "block";
$("#wait").css("display", "block");
        $.ajax({
            type: "POST",
            url: "<?=ADMIN_BASE_URL.'dashboard/testing'?>",
            
            data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':$('.content-wrapper').find('.badge-primary').attr('data-type')},
            success: function (response) {            
              $('#morrisDonut1').html('');
              $('#morrisDonut2').html('');
              $('#morrisDonut3').html('');
              $('#morrisDonut4').html('');
              $('#morrisBar1').html('');
              $('#morrisBar2').html('');
              $('#morrisBar3').html('');
              $('#morrisBar4').html('');
              $('#morrisLine1').html('');
              $('#chart').html('');
            
              var obj = JSON.parse(response);
              triiger_pie_charts(obj.ppc_pie_report,obj.ccp_pie_report,obj.atp_swab_pie_report,obj.receivinglog_pie_report);
              trigger_bar_grphs(obj.ppc_bar_report,obj.ccp_bar_report,obj.atp_swab_bar_report,obj.receivinglog_bar_report);
           //   show_trendline_graph_data(obj.trendline_graph_data);
             compliant_data(obj.compliant_graph);
             status_data(obj.status_graph);
             morrisline1_data(obj.plants,obj.date,obj.plants_name);
    $("#wait").css("display", "none");
    document.getElementById("overlay").style.display = "none";
            }
         });
    }




    function func_load_dt(){
        today = new Date();
        date_to = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        date_from = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        date_from = new Date(var_time_period == 7? date_from.setDate(date_to.getDate() - var_time_period)
                                                 : date_from.setMonth(date_to.getMonth() -var_time_period));
        date_from = new Date(date_from.setDate(date_to.getDate() + 1))
        date_to_str = date_to.getFullYear() + '-' + (date_to.getMonth() + 1) + '-' + date_to.getDate();
        date_from_str = date_from.getFullYear() + '-' + (date_from.getMonth() + 1) + '-' + date_from.getDate();
        console.log(var_time_period);
        console.log(date_from_str);
        console.log(date_to_str);

        $.ajax({
            type: "POST",
            url: "<?=ADMIN_BASE_URL.'dashboard/get_dashboard_data'?>",
            
            data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':var_time_period},
            success: function (data) {
              $('#div_tblreport').html(data);
              datatable();
            }
         });
         get_graphs_data(date_from_str,date_to_str,var_time_period);
    
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

    $('.btn_time_period').on('click', function() {
        var_time_period = $(this).attr("data-value");
        $('.btn_time_period').removeClass("badge-primary").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("badge-primary");
        func_load_dt();
    });

    $(document).ready(function() {
        var_time_period = 1;
        func_load_dt();
    
       
    });
 

function triiger_pie_charts(ppc_pie_report,ccp_pie_report,atp_swab_pie_report,receivinglog_pie_report){
   var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    /* 03.02. Resize */
    var subHiddenBreakpoint = 1440;
    var searchHiddenBreakpoint = 768;
    var menuHiddenBreakpoint = 768;


 	if (document.getElementById("categoryChart1")) {
        var categoryChart1 = document.getElementById("categoryChart1");
        var myDoughnutChart = new Chart(categoryChart1, {
        //  plugins: [centerTextPlugin],
          type: "DoughnutWithShadow",
          data: {
            labels: ["pass", "fail"],
            datasets: [
              {
                label: "",
                borderColor: [themeColor3, themeColor2, themeColor1],
                backgroundColor: [
                  themeColor3_10,
                  themeColor2_10,
                  themeColor1_10
                ],
                borderWidth: 2,
                data:  [ppc_pie_report.pass,ppc_pie_report.fail]
              }
            ]
          },
          draw: function () { },
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 80,
            title: {
              display: false
            },
            layout: {
              padding: {
                bottom: 20
              }
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          }
        });
      }
  	if (document.getElementById("categoryChart2")) {
        var categoryChart2 = document.getElementById("categoryChart2");
        var myDoughnutChart = new Chart(categoryChart2, {
       //   plugins: [centerTextPlugin],
          type: "DoughnutWithShadow",
          data: {
            labels: ["pass", "fail"],
            datasets: [
              {
                label: "",
                borderColor: [themeColor3, themeColor2, themeColor1],
                backgroundColor: [
                  themeColor3_10,
                  themeColor2_10,
                  themeColor1_10
                ],
                borderWidth: 2,
                data: [ccp_pie_report.pass,ccp_pie_report.fail]
              }
            ]
          },
          draw: function () { },
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 80,
            title: {
              display: false
            },
            layout: {
              padding: {
                bottom: 20
              }
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          }
        });
      }
  	if (document.getElementById("categoryChart3")) {
        var categoryChart3 = document.getElementById("categoryChart3");
        var myDoughnutChart = new Chart(categoryChart3, {
       //   plugins: [centerTextPlugin],
          type: "DoughnutWithShadow",
          data: {
            labels: ["pass", "fail"],
            datasets: [
              {
                label: "",
                borderColor: [themeColor3, themeColor2, themeColor1],
                backgroundColor: [
                  themeColor3_10,
                  themeColor2_10,
                  themeColor1_10
                ],
                borderWidth: 2,
                data: [atp_swab_pie_report.pass,atp_swab_pie_report.fail]
              }
            ]
          },
          draw: function () { },
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 80,
            title: {
              display: false
            },
            layout: {
              padding: {
                bottom: 20
              }
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          }
        });
      }
  	if (document.getElementById("categoryChart4")) {
        var categoryChart4 = document.getElementById("categoryChart4");
        var myDoughnutChart = new Chart(categoryChart4, {
        //  plugins: [centerTextPlugin],
          type: "DoughnutWithShadow",
          data: {
            labels: ["pass","fail"],
            datasets: [
              {
                label: "",
                borderColor: [themeColor3, themeColor2, themeColor1],
                backgroundColor: [
                  themeColor3_10,
                  themeColor2_10,
                  themeColor1_10
                ],
                borderWidth: 2,
                data: [receivinglog_pie_report.pass,receivinglog_pie_report.fail]
              }
            ]
          },
          draw: function () { },
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 80,
            title: {
              display: false
            },
            layout: {
              padding: {
                bottom: 20
              }
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          }
        });
      }
 }

</script>
<script type="text/javascript">
  function morrisline1_data(plants,date,plants_name) {
   var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    /* 03.02. Resize */
    var subHiddenBreakpoint = 1440;
    var searchHiddenBreakpoint = 768;
    var menuHiddenBreakpoint = 768;
    $("canvas#salesChart").remove();
    $(".ptchart").append('<canvas id="salesChart"></canvas>');
  		
      if (document.getElementById("salesChart")) {
        var salesChart = document.getElementById("salesChart").getContext("2d");
        var myChart = new Chart(salesChart, {
          type: "LineWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              display: false
            }
          },
          data: {
            labels: date,
            datasets: [
            	{
                label: plants.name,
                data: plants[0].count,
                borderColor: themeColor1,
                pointBackgroundColor: foregroundColor,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: foregroundColor,
                pointRadius: 6,
                pointBorderWidth: 2,
                pointHoverRadius: 8,fill: true,
               }
            	// {
            	// label: plants[1].name,
            	// data: plants[1].count,
            	// borderColor: themeColor1,
            	// pointBackgroundColor: foregroundColor,
            	// pointBorderColor: themeColor1,
            	// pointHoverBackgroundColor: themeColor1,
            	// pointHoverBorderColor: foregroundColor,
            	// pointRadius: 6,
            	// pointBorderWidth: 2,
            	// pointHoverRadius: 8,fill: true,
            	// },
            ]
          }
        });
      }
  }

      $(document).on("click", ".view_details", function (event) {
        event.preventDefault();
        var id = $(this).attr('rel');
    	var static = $(this).attr('static');
    if(static=="1")
    {
          $.ajax({
            type: 'POST',
            url:"<?= ADMIN_BASE_URL?>static_form/static_form_detail",
            data: {'id':id},
            async: false,
            success: function(test_body) {
                var test_desc = test_body;
                //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                $('#myModalLarge').modal('show')
                //$("#myModal .modal-title").html(test_title);
                $("#myModalLarge .modal-body").html(test_desc);
            }
        });
    }
    else
    {
        $.ajax({
            type: 'POST',
            url:"<?= ADMIN_BASE_URL?>assignments/pending_review_detail",
            data: {'id':id},
            async: false,
            success: function(test_body) {
                var test_desc = test_body;
                //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                $('#myModalLarge').modal('show')
                //$("#myModal .modal-title").html(test_title);
                $("#myModalLarge .modal-body").html(test_desc);
            }
        });
     }
    });
</script>

<script>

 function trigger_bar_grphs(ppc_pie_report,ccp_pie_report,atp_swab_pie_report,receivinglog_pie_report){
      var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    /* 03.02. Resize */
    var subHiddenBreakpoint = 1440;
    var searchHiddenBreakpoint = 768;
    var menuHiddenBreakpoint = 768;
    $("canvas#productChart1").remove();
    $(".pc1").append('<canvas id="productChart1"></canvas>');
       if (document.getElementById("productChart1")) {
        var productChart1 = document
          .getElementById("productChart1")
          .getContext("2d");
        var myChart = new Chart(productChart1, {
          type: "BarWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
      
          data: {
            labels: ppc_pie_report[0].title,
            datasets: [
              {
                label: "Pass",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: ppc_pie_report[0].pass,
                borderWidth: 2
              },
              {
                label: "Fail",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: ppc_pie_report[0].fail,
                borderWidth: 2
              }
            ]
          }
        });
      }
      $("canvas#productChart2").remove();
    $(".pc2").append('<canvas id="productChart2"></canvas>');
 	   if (document.getElementById("productChart2")) {
        var productChart2 = document
          .getElementById("productChart2")
          .getContext("2d");
        var myChart = new Chart(productChart2, {
          type: "BarWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: ccp_pie_report[0].title,
            datasets: [
              {
                label: "Pass",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [0, 0, 9],
                borderWidth: 2
              },
              {
                label: "Fail",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [0, 0, 9],
                borderWidth: 2
              }
            ]
          }
        });
      }
      $("canvas#productChart3").remove();
    $(".pc3").append('<canvas id="productChart3"></canvas>');
       if (document.getElementById("productChart3")) {
        var productChart3 = document
          .getElementById("productChart3")
          .getContext("2d");
        var myChart = new Chart(productChart3, {
          type: "BarWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: atp_swab_pie_report[0].title,
            datasets: [
              {
                label: "Pass",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: atp_swab_pie_report[0].pass,
                borderWidth: 2
              },
              {
                label: "Fail",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: atp_swab_pie_report[0].fail,
                borderWidth: 2
              }
            ]
          }
        });
      }
      $("canvas#productChart4").remove();
    $(".pc4").append('<canvas id="productChart4"></canvas>');

       if (document.getElementById("productChart4")) {
        var productChart4 = document
          .getElementById("productChart4")
          .getContext("2d");
        var myChart = new Chart(productChart4, {
          type: "BarWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 20
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            labels: receivinglog_pie_report[0].title,
            datasets: [
              {
                label: "Pass",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: receivinglog_pie_report[0].pass,
                borderWidth: 2
              },
              {
                label: "Fail",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: receivinglog_pie_report[0].fail,
                borderWidth: 2
              }
            ]
          }
        });
      }
 
 

 	}





</script>

<script type="text/javascript">
  function show_trendline_graph_data(trendline_graph_data){
    var options = {
      chart: {
        height: 350,
        type: 'line',
        stacked: false,
      toolbar: {
          show: false
        }
      },
      dataLabels: {
        enabled: false
      },
      series: [{
        name: 'Passed',
        type: 'column',
        data:trendline_graph_data.passed_array
      }, {
        name: 'Failed',
        type: 'column',
        data: trendline_graph_data.failed_array
      }, {
        name: 'Trending Line',
        type: 'line',
        data: trendline_graph_data.passed_array
      }],
      stroke: {
        width: [1, 1, 4]
      },
      title: {
        text: '',
        align: 'left',
        offsetX: 110
      },
      xaxis: {
        categories: trendline_graph_data.arr_month_dates,
      },
      yaxis: [
        {
          axisTicks: {
            show: true,
          },
          axisBorder: {
            show: true,
            color: '#008FFB'
          },
          labels: {
            style: {
              color: '#008FFB',
            }
          },
          title: {
            text: "Passed",
            style: {
              color: '#008FFB',
            }
          },
          tooltip: {
            enabled: true
          }
        },

        {
          seriesName: 'Failed',
          opposite: true,
          axisTicks: {
            show: true,
          },
          axisBorder: {
            show: true,
            color: '#00E396'
          },
          labels: {
            style: {
              color: '#00E396',
            }
          },
          title: {
            text: "Failed",
            style: {
              color: '#00E396',
            }
          },
        },
        {
          seriesName: 'Current month',
          opposite: true,
          axisTicks: {
            show: true,
          },
          axisBorder: {
            show: true,
            color: '#FEB019'
          },
          labels: {
            style: {
              color: '#FEB019',
            },
          },
          title: {
            text: "Current month",
            style: {
              color: '#FEB019',
            }
          }
        },
      ],
      tooltip: {
        fixed: {
          enabled: true,
          position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
          offsetY: 30,
          offsetX: 60
        },
      },
      legend: {
        horizontalAlign: 'left',
        offsetX: 40
      }
    }

    var chart = new ApexCharts(
      document.querySelector("#chart"),
      options
    );


    chart.render();
  }
     Chart.defaults.LineWithShadow = Chart.defaults.line;
      Chart.controllers.LineWithShadow = Chart.controllers.line.extend({
        draw: function (ease) {
          Chart.controllers.line.prototype.draw.call(this, ease);
          var ctx = this.chart.ctx;
          ctx.save();
          ctx.shadowColor = "rgba(0,0,0,0.15)";
          ctx.shadowBlur = 10;
          ctx.shadowOffsetX = 0;
          ctx.shadowOffsetY = 10;
          ctx.responsive = true;
          ctx.stroke();
          Chart.controllers.line.prototype.draw.apply(this, arguments);
          ctx.restore();
        }
      });

$.fn.addCommas = function (nStr) {
  nStr += "";
  var x = nStr.split(".");
  var x1 = x[0];
  var x2 = x.length > 1 ? "." + x[1] : "";
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, "$1" + "," + "$2");
  }
  return x1 + x2;
};


      
  function status_data(status_graph){
    var myChart;
      var chartTooltip = {
        backgroundColor: foregroundColor,
        titleFontColor: primaryColor,
        borderColor: separatorColor,
        borderWidth: 0.5,
        bodyFontColor: primaryColor,
        bodySpacing: 10,
        xPadding: 15,
        yPadding: 15,
        cornerRadius: 0.15,
        displayColors: false
      };
      var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    /* 03.02. Resize */
    var subHiddenBreakpoint = 1440;
    var searchHiddenBreakpoint = 768;
    var menuHiddenBreakpoint = 768;
    $("canvas#visitChart1").remove();
    $(".cpchart").append('<canvas id="visitChart1" width="646" height="194" class="chartjs-render-monitor" style="display: block; width: 646px; height: 194px;"></canvas>');

      if (document.getElementById("visitChart1")) {
       var visitChart1 = document.getElementById("visitChart1").getContext("2d");
       myChart = new Chart(visitChart1, {
          type: "LineWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 0
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false,
                  }
                }
              ]
            },
            legend: {
              display: false,
            }
          },
          data: {
            labels: status_graph.date,
            datasets: [
              {
                label: "Pending",
                data: status_graph.pending,
                borderColor: themeColor1,
                pointBackgroundColor: foregroundColor,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: foregroundColor,
                pointRadius: 4,
                pointBorderWidth: 2,
                pointHoverRadius: 5,
                fill: true,
                borderWidth: 2,
                backgroundColor: themeColor1_10
              }
            ,{
                label: "Completed",
                data: status_graph.completed,
                borderColor: themeColor2,
                pointBackgroundColor: foregroundColor,
                pointBorderColor: themeColor2,
                pointHoverBackgroundColor: themeColor2,
                pointHoverBorderColor: foregroundColor,
                pointRadius: 4,
                pointBorderWidth: 2,
                pointHoverRadius: 5,
                fill: true,
                borderWidth: 2,
                backgroundColor: themeColor2_10
              }
            ]
          }
        });
      }
    }
    function compliant_data(compliant_graph){
      var chartTooltip = {
        backgroundColor: foregroundColor,
        titleFontColor: primaryColor,
        borderColor: separatorColor,
        borderWidth: 0.5,
        bodyFontColor: primaryColor,
        bodySpacing: 10,
        xPadding: 15,
        yPadding: 15,
        cornerRadius: 0.15,
        displayColors: false
      };
      var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    var themeColor3 = rootStyle.getPropertyValue("--theme-color-3").trim();
    var themeColor4 = rootStyle.getPropertyValue("--theme-color-4").trim();
    var themeColor5 = rootStyle.getPropertyValue("--theme-color-5").trim();
    var themeColor6 = rootStyle.getPropertyValue("--theme-color-6").trim();
    var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    /* 03.02. Resize */
    var subHiddenBreakpoint = 1440;
    var searchHiddenBreakpoint = 768;
    var menuHiddenBreakpoint = 768;
    
    $("canvas#conversionChart1").remove();
    $(".cnchart").append('<canvas id="conversionChart1" width="646" height="194" class="chartjs-render-monitor" style="display: block; width: 646px; height: 194px;"></canvas>');

      if (document.getElementById("conversionChart1")) {
        var conversionChart1 = document
          .getElementById("conversionChart1")
          .getContext("2d");
        var myChart = new Chart(conversionChart1, {
          type: "LineWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    padding: 0
                  }
                }
              ],
              xAxes: [
                {
                  gridLines: {
                    display: false
                  }
                }
              ]
            },
            legend: {
              display: false
            }
          },
          data: {
            labels:compliant_graph.date,
            datasets: [
              {
                label: "Compliant",
                data: compliant_graph.compliant,
                borderColor: themeColor2,
                pointBackgroundColor: foregroundColor,
                pointBorderColor: themeColor2,
                pointHoverBackgroundColor: themeColor2,
                pointHoverBorderColor: foregroundColor,
                pointRadius: 4,
                pointBorderWidth: 2,
                pointHoverRadius: 5,
                fill: true,
                borderWidth: 2,
                backgroundColor: themeColor2_10
              },
             {
                label: "Non- Compliant",
                data:compliant_graph.non_compliant,
                borderColor: themeColor1,
                pointBackgroundColor: foregroundColor,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: foregroundColor,
                pointRadius: 4,
                pointBorderWidth: 2,
                pointHoverRadius: 5,
                fill: true,
                borderWidth: 2,
                backgroundColor: themeColor1_10
              }
            ]
          }
        });
      }
      
     Chart.defaults.LineWithLine = Chart.defaults.line;
      Chart.controllers.LineWithLine = Chart.controllers.line.extend({
        draw: function (ease) {
          Chart.controllers.line.prototype.draw.call(this, ease);
          if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
            var activePoint = this.chart.tooltip._active[0];
            var ctx = this.chart.ctx;
            var x = activePoint.tooltipPosition().x;
            var topY = this.chart.scales["y-axis-0"].top;
            var bottomY = this.chart.scales["y-axis-0"].bottom;
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x, topY);
            ctx.lineTo(x, bottomY);
            ctx.lineWidth = 1;
            ctx.strokeStyle = "rgba(0,0,0,0.1)";
            ctx.stroke();
            ctx.restore();
          }
        }
      });
    var smallChartOptions = {
        layout: {
          padding: {
            left: 5,
            right: 5,
            top: 10,
            bottom: 10
          }
        },
        plugins: {
          datalabels: {
            display: false
          }
        },
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        tooltips: {
          intersect: false,
          enabled: false,
          custom: function (tooltipModel) {
            if (tooltipModel && tooltipModel.dataPoints) {
              var $textContainer = $(this._chart.canvas.offsetParent);
              var yLabel = tooltipModel.dataPoints[0].yLabel;
              var xLabel = tooltipModel.dataPoints[0].xLabel;
              var label = tooltipModel.body[0].lines[0].split(":")[0];
              $textContainer.find(".value").html("" + $.fn.addCommas(yLabel));
              $textContainer.find(".label").html(label + "-" + xLabel);
            }
          }
        },
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              },
              display: false
            }
          ],
          xAxes: [
            {
              display: false
            }
          ]
        }
      };
    var smallChartInit = {
        afterInit: function (chart, options) {
          var $textContainer = $(chart.canvas.offsetParent);
          var yLabel = chart.data.datasets[0].data[0];
          var xLabel = chart.data.labels[0];
          var label = chart.data.datasets[0].label;
          $textContainer.find(".value").html("" + $.fn.addCommas(yLabel));
          $textContainer.find(".label").html(label + "-" + xLabel);
        }
      };



	var checks= '<?php echo $checks; ?>';
    var checks=JSON.parse(checks);
      if (document.getElementById("smallChart1")) {
        var smallChart1 = document
          .getElementById("smallChart1")
          .getContext("2d");
        var myChart = new Chart(smallChart1, {
          type: "LineWithLine",
          plugins: [smallChartInit],
          data: {
            labels:checks.day,
            datasets: [
              {
                label: "Total Checks",
                borderColor: themeColor1,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: themeColor1,
                pointRadius: 2,
                pointBorderWidth: 3,
                pointHoverRadius: 2,
                fill: false,
                borderWidth: 2,
                data: checks.total_checks,
                datalabels: {
                  align: "end",
                  anchor: "end"
                }
              }
            ]
          },
          options: smallChartOptions
        });
      }

      if (document.getElementById("smallChart2")) {
        var smallChart2 = document
          .getElementById("smallChart2")
          .getContext("2d");
        var myChart = new Chart(smallChart2, {
          type: "LineWithLine",
          plugins: [smallChartInit],
          data: {
            labels: checks.day,
            datasets: [
              {
                label: "Pending Review",
                borderColor: themeColor1,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: themeColor1,
                pointRadius: 2,
                pointBorderWidth: 3,
                pointHoverRadius: 2,
                fill: false,
                borderWidth: 2,
                data: checks.pending_reviews,
                datalabels: {
                  align: "end",
                  anchor: "end"
                }
              }
            ]
          },
          options: smallChartOptions
        });
      }

      if (document.getElementById("smallChart3")) {
        var smallChart3 = document
          .getElementById("smallChart3")
          .getContext("2d");
        var myChart = new Chart(smallChart3, {
          type: "LineWithLine",
          plugins: [smallChartInit],
          data: {
            labels:checks.day,
            datasets: [
              {
                label: "Pending Approval",
                borderColor: themeColor1,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: themeColor1,
                pointRadius: 2,
                pointBorderWidth: 3,
                pointHoverRadius: 2,
                fill: false,
                borderWidth: 2,
                data: checks.pending_approval,
                datalabels: {
                  align: "end",
                  anchor: "end"
                }
              }
            ]
          },
          options: smallChartOptions
        });
      }

      if (document.getElementById("smallChart4")) {
        var smallChart4 = document
          .getElementById("smallChart4")
          .getContext("2d");
        var myChart = new Chart(smallChart4, {
          type: "LineWithLine",
          plugins: [smallChartInit],
          data: {
            labels: checks.day,
            datasets: [
              {
                label: "Completed",
                borderColor: themeColor1,
                pointBorderColor: themeColor1,
                pointHoverBackgroundColor: themeColor1,
                pointHoverBorderColor: themeColor1,
                pointRadius: 2,
                pointBorderWidth: 3,
                pointHoverRadius: 2,
                fill: false,
                borderWidth: 2,
                data: checks.completed_checks,
                datalabels: {
                  align: "end",
                  anchor: "end"
                }
              }
            ]
          },
          options: smallChartOptions
        });
      }
     var static=''; 
     static= '<?php echo $static; ?>';
     var static=JSON.parse(static);
         if (document.getElementById("polarChart1")) {

        var polarChart1 = document.getElementById("polarChart1").getContext("2d");
        var myChart = new Chart(polarChart1, {
          type: "PolarWithShadow",
          options: {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scale: {
              ticks: {
                display: false
              }
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12
              }
            }
          },
          data: {
            datasets: [
              {
                label: "Static Checks",
                borderWidth: 2,
                pointBackgroundColor: themeColor1,
                borderColor: [themeColor1, themeColor2, themeColor3],
                backgroundColor: [
                  themeColor1_10,
                  themeColor2_10,
                  themeColor3_10
                ],
                data: [static.pass,static.fail]
              }
            ],
            labels: ["Pass", "Fail"]
          }
        });
      }
	}




   
</script>
















