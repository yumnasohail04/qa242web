<link href="<?php echo STATIC_ADMIN_CSS?>ionicons.min.css" rel="stylesheet">
<link href="<?php echo STATIC_ADMIN_CSS?>typicons.css" rel="stylesheet">
<link href="<?php echo STATIC_ADMIN_CSS?>morris.css" rel="stylesheet">
    
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
                 <div>
                <a class="btn_time_period btn-default" data-value="7">&nbsp;&nbsp;Week&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-info" data-value="1">&nbsp;&nbsp;1 Month&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="3">&nbsp;&nbsp;3 Months&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="6">&nbsp;&nbsp;6 Months&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="12">&nbsp;&nbsp;1 Year&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="24">&nbsp;&nbsp;2 Year&nbsp;&nbsp;</a>
            </div>
                 <div class="card-body pb-0">
                    <div class="card text-white white_bg">
                        <div class="row ">
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-4">
                                    <div id="morrisDonut1" class="morris-donut-wrapper-demo" style="height:150px; "></div>
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <div id="morrisBar1" class="morris-wrapper-demo" style="height:150px;"></div>
                                </div>
                             </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-4">
                                    <div id="morrisDonut2" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <div id="morrisBar2" class="morris-wrapper-demo" style="height:150px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-4">
                                    <div id="morrisDonut3" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <div id="morrisBar3" class="morris-wrapper-demo" style="height:150px;"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-4">
                                    <div id="morrisDonut4" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <div id="morrisBar4" class="morris-wrapper-demo" style="height:150px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-sm-12 col-lg-8">
                                <div id="chart"></div>
                            </div>
                            <div class=" col-sm-12 col-lg-4">
                                <div id="morrisLine1" class="morris-wrapper-demo" style="height:330px;" ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="div_tblreport"></div>
                    </div>
                </div>
            
            </div>   
        </section>
    </div>
</div>
<script src="<?php echo STATIC_ADMIN_JS?>jquery.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>ionicons.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>raphael.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>morris.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>chart.morris.js?v=5"></script>
 <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

<script src="<?php echo STATIC_ADMIN_JS?>widgets.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>controller.js"></script>

<script type="text/javascript">
    var var_time_period = 1;
    var today = new Date();
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
            }
         });
         get_graphs_data(date_from_str,date_to_str,var_time_period)
    
    }

    $('.btn_time_period').on('click', function() {
        var_time_period = $(this).attr("data-value");
        $('.btn_time_period').removeClass("btn-info").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-info");
        func_load_dt();
    });

    $(document).ready(function() {
        var_time_period = 1;
        func_load_dt();
       
    });
   
</script>

<script type="text/javascript">
    function get_graphs_data(date_from_str,date_to_str,var_time_period){
        $('#morrisDonut1').html('')
        $('#morrisDonut2').html('')
        $('#morrisDonut3').html('')
        $('#morrisDonut4').html('')
        $('#morrisBar1').html('')
        $('#morrisBar2').html('')
        $('#morrisBar3').html('')
        $('#morrisBar4').html('')
        $('#chart').html('')
         $.ajax({
            type: "POST",
            url: "<?=ADMIN_BASE_URL.'dashboard/get_graphs_data'?>",
            
            data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':var_time_period},
            success: function (response) {
             var obj = JSON.parse(response);
            triiger_pie_charts(obj.ppc_pie_report,obj.ccp_pie_report,obj.atp_swab_pie_report,obj.receivinglog_pie_report)
            trigger_bar_grphs(obj.ppc_bar_report,obj.ccp_bar_report,obj.atp_swab_bar_report,obj.receivinglog_bar_report)
            show_trendline_graph_data(obj.trendline_graph_data)
            }
         });
    }
    function triiger_pie_charts(ppc_pie_report,ccp_pie_report,atp_swab_pie_report,receivinglog_pie_report){
    
  new Morris.Donut({
    element: 'morrisDonut2',
    data: ppc_pie_report,
    colors: ['#4CB581','#757373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==1)
        {
            today = new Date();
            date_to = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(var_time_period == 7? date_from.setDate(date_to.getDate() - var_time_period)
                                                     : date_from.setMonth(date_to.getMonth() -var_time_period));
            date_from = new Date(date_from.setDate(date_to.getDate() + 1))
            date_to_str = date_to.getFullYear() + '-' + (date_to.getMonth() + 1) + '-' + date_to.getDate();
            date_from_str = date_from.getFullYear() + '-' + (date_from.getMonth() + 1) + '-' + date_from.getDate();
            $.ajax({
                type: "POST",
                url: "<?=ADMIN_BASE_URL.'dashboard/get_table_data'?>",
                data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':var_time_period,'row':row},
                success: function (data) {
                    var test_desc = data;
                    $('#myModalLarge').modal('show')
                    $("#myModalLarge .modal-body").html(test_desc);
                }
            });
        }
    });
  new Morris.Donut({
    element: 'morrisDonut1',
    data: ccp_pie_report,
    colors: ['#D14F57','#757373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==1)
        {
            today = new Date();
            date_to = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(var_time_period == 7? date_from.setDate(date_to.getDate() - var_time_period)
                                                     : date_from.setMonth(date_to.getMonth() -var_time_period));
            date_from = new Date(date_from.setDate(date_to.getDate() + 1))
            date_to_str = date_to.getFullYear() + '-' + (date_to.getMonth() + 1) + '-' + date_to.getDate();
            date_from_str = date_from.getFullYear() + '-' + (date_from.getMonth() + 1) + '-' + date_from.getDate();
            $.ajax({
                type: "POST",
                url: "<?=ADMIN_BASE_URL.'dashboard/get_table_data'?>",
                data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':var_time_period,'row':row},
                success: function (data) {
                    var test_desc = data;
                    $('#myModalLarge').modal('show')
                    $("#myModalLarge .modal-body").html(test_desc);
                }
            });
        }
    });
  
    new Morris.Donut({
    element: 'morrisDonut3',
    data:atp_swab_pie_report,
    colors: ['#5D89A8','#757373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==1)
        {
            today = new Date();
            date_to = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(var_time_period == 7? date_from.setDate(date_to.getDate() - var_time_period)
                                                     : date_from.setMonth(date_to.getMonth() -var_time_period));
            date_from = new Date(date_from.setDate(date_to.getDate() + 1))
            date_to_str = date_to.getFullYear() + '-' + (date_to.getMonth() + 1) + '-' + date_to.getDate();
            date_from_str = date_from.getFullYear() + '-' + (date_from.getMonth() + 1) + '-' + date_from.getDate();
            $.ajax({
                type: "POST",
                url: "<?=ADMIN_BASE_URL.'dashboard/get_table_data'?>",
                data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':var_time_period,'row':row},
                success: function (data) {
                    var test_desc = data;
                    $('#myModalLarge').modal('show')
                    $("#myModalLarge .modal-body").html(test_desc);
                }
            });
        }
    });
  
    new Morris.Donut({
    element: 'morrisDonut4',
    data: receivinglog_pie_report,
    colors: ['#EF9738', '#757373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==1)
        {
            today = new Date();
            date_to = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            date_from = new Date(var_time_period == 7? date_from.setDate(date_to.getDate() - var_time_period)
                                                     : date_from.setMonth(date_to.getMonth() -var_time_period));
            date_from = new Date(date_from.setDate(date_to.getDate() + 1))
            date_to_str = date_to.getFullYear() + '-' + (date_to.getMonth() + 1) + '-' + date_to.getDate();
            date_from_str = date_from.getFullYear() + '-' + (date_from.getMonth() + 1) + '-' + date_from.getDate();
            $.ajax({
                type: "POST",
                url: "<?=ADMIN_BASE_URL.'dashboard/get_table_data'?>",
                data:{'start_date':date_from_str,'end_date':date_to_str,'var_time_period':var_time_period,'row':row},
                success: function (data) {
                    var test_desc = data;
                    $('#myModalLarge').modal('show')
                    $("#myModalLarge .modal-body").html(test_desc);
                }
            });
        }
    });
    }
    function trigger_bar_grphs(ppc_pie_report,ccp_pie_report,atp_swab_pie_report,receivinglog_pie_report){
         new Morris.Bar({
    element: 'morrisBar2',
    data:ppc_pie_report,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#4CB581', '#757373'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true,
    barSize: 30,
    gridTextWeight: "bolder",
    gridTextColor: "#4CB581",
  });
 
 new Morris.Bar({
    element: 'morrisBar1',
    data:  ccp_pie_report,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#D14F57', '#757373'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true,
    barSize: 30,
    gridTextWeight: "bolder",
    gridTextColor: "#D14F57",
  });
  
   var morrisBar3data=
    new Morris.Bar({
    element: 'morrisBar3',
    data: atp_swab_pie_report,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#5D89A8', '#757373'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true,
    barSize: 30,
    gridTextWeight: "bolder",
    gridTextColor: "#5D89A8",
  });
    new Morris.Bar({
    element: 'morrisBar4',
    data:  receivinglog_pie_report,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#EF9738', '#757373'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true,
    barSize: 30,
    gridTextWeight: "bolder",
    gridTextColor: "#EF9738",
  });
    }
</script>
<script type="text/javascript">
    new Morris.Line({
    element: 'morrisLine1',
    data: <?php if(!empty(json_decode($sites_report['final']))) echo $sites_report['final'];else echo $morrisData;?>,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['YC', 'BE'],
    lineColors: ['#560bd0', '#007bff'],
    lineWidth: 1,
    ymax: 'auto 100',
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
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
        name: 'Current Month',
        type: 'line',
        data: trendline_graph_data.current_month
      }
      , {
        name: 'Prev Month',
        type: 'line',
        data: trendline_graph_data.current_month
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
         {
          seriesName: 'Prev month',
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
            text: "Last month",
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
</script>





















<script>
    $(document).on("click", ".view_details", function (event) {
        event.preventDefault();
        var id = $(this).attr('rel');
        //alert("<?=$this->uri->segment(3);?>"); return false;
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
    });
    
    

</script>


















