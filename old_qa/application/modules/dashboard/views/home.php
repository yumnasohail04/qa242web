    <link href="<?php echo STATIC_ADMIN_CSS ?>ionicons.min.css" rel="stylesheet">
    <link href="<?php echo STATIC_ADMIN_CSS ?>typicons.css" rel="stylesheet">
    <link href="<?php echo STATIC_ADMIN_CSS ?>morris.css" rel="stylesheet">
    
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
                <a class="btn_time_period  btn-info " data-value="7">&nbsp;&nbsp;Week&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="1">&nbsp;&nbsp;1 Month&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="3">&nbsp;&nbsp;3 Months&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="6">&nbsp;&nbsp;6 Months&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="12">&nbsp;&nbsp;1 Year&nbsp;&nbsp;</a>
                <a class="btn_time_period btn-default" data-value="24">&nbsp;&nbsp;2 Year&nbsp;&nbsp;</a>
            </div>
                <div class="card-body pb-0">
                    <div class="card text-white white_bg">
                        <div class="row ">
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-3">
                                    <div id="morrisDonut1" class="morris-donut-wrapper-demo" style="height:200px; "></div>
                                </div>
                                <div class="col-sm-12 col-lg-3">
                                    <div id="morrisDonut2" class="morris-donut-wrapper-demo" style="height:200px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-3">
                                    <div id="morrisDonut3" class="morris-donut-wrapper-demo" style="height:200px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-3">
                                    <div id="morrisDonut4" class="morris-donut-wrapper-demo" style="height:200px;"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-6">
                                    <div id="morrisBar1" class="morris-wrapper-demo" style="height:200px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div id="morrisBar2" class="morris-wrapper-demo" style="height:200px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12 col-lg-6">
                                <div class="col-sm-12 col-lg-6">
                                    <div id="morrisBar3" class="morris-wrapper-demo" style="height:200px;"></div>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <div id="morrisBar4" class="morris-wrapper-demo" style="height:200px;"></div>
                                </div>
                            </div>
                            <div class=" col-sm-12 col-sm-6">
                                <div id="morrisLine1" class="morris-wrapper-demo" style="height:200px;" ></div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class=" col-sm-12 col-sm-6">
                                <div id="chart"></div>
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
<script src="<?php echo STATIC_ADMIN_JS?>chart.morris.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

<script src="<?php echo STATIC_ADMIN_JS?>widgets.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>controller.js"></script>
  <script>

    
    var options = {
      chart: {
        height: 350,
        type: 'line',
        stacked: false
      },
      dataLabels: {
        enabled: false
      },
      series: [{
        name: 'Income',
        type: 'column',
        data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
      }, {
        name: 'Cashflow',
        type: 'column',
        data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5]
      }, {
        name: 'Revenue',
        type: 'line',
        data: [20, 29, 37, 36, 44, 45, 50, 58]
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
        categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
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
            text: "Income (thousand crores)",
            style: {
              color: '#008FFB',
            }
          },
          tooltip: {
            enabled: true
          }
        },

        {
          seriesName: 'Income',
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
            text: "Operating Cashflow (thousand crores)",
            style: {
              color: '#00E396',
            }
          },
        },
        {
          seriesName: 'Revenue',
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
            text: "Revenue (thousand crores)",
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
  </script>
<script type="text/javascript">
    var var_time_period = 1;
    var today = new Date();
    function func_load_dt(){
        today = new Date();
        date_to = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        date_from = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        date_from = new Date(var_time_period == 7? date_from.setDate(date_to.getDate() - var_time_period)
                                                 : date_from.setMonth(date_to.getMonth() - (var_time_period == 1?3:var_time_period)));
        date_from = new Date(date_from.setDate(date_to.getDate() + 1))
        date_to_str = date_to.getFullYear() + '-' + (date_to.getMonth() + 1) + '-' + date_to.getDate();
        date_from_str = date_from.getFullYear() + '-' + (date_from.getMonth() + 1) + '-' + date_from.getDate();
        console.log(var_time_period);
        console.log(date_from_str);
        console.log(date_to_str);
        //alert(date_from)
        load_dt([{
            action_name : 'widgets/load_report_by_check'
            ,   div_id : 'div_tblreport'
            ,   p_data :
                {
                    product_checks:0,
                    plants:0,
                    lines:0,
                    productid:0,
                    status:0,
                    start_date: date_from_str,
                    end_date: date_to_str,
                    program_types:0,
                    questions:'',
                    view_request:"dashboard_home"
                }
            ,   load_events : function () {
                load_model_detail_events(
                    "<?= ADMIN_BASE_URL?>assignments/pending_review_detail"
                    ,{'id': 0,'function':'<?=$this->uri->segment(3);?>'}
                )
                arrr_html_table_to_array_objects('#tblReportData');
                class_array.set_arr_date_range([class_array.get_index('assign_date'),class_array.get_index('assign_month')],date_from,date_to);
                let arr_compliants = arrr_get_assignment_compliants();
                let arr_non_compliants = arr_compliants.filter(x=>!x.is_compliants);
                $('.div_chart').html('');
                // load_chart_for_totals('#div_chart_totals'
                //     ,get_array_by_associative_index_distinct("assign_checkname").length
                //     ,get_array_by_associative_index_distinct("assign_id").length
                //     ,get_array_by_associative_index_distinct("assign_user").length
                //     ,"col-md-12");
                let non_compliants_percentage = (arr_non_compliants.length/arr_compliants.length) * 100;
                // load_chart_for_compliants('#div_chart_compliants',100-non_compliants_percentage,true,"col-lg-6");
                // load_chart_for_compliants('#div_chart_compliants',non_compliants_percentage,false,"col-lg-6");
                // load_chart_for_corrections('#div_chart_corrections', arr_non_compliants);
                arrr_load_chart_mixed_multi_y_axis();
                /*load_chart_mixed_multy_y_axis_apex(
                    {     div_id : "div_chart_mixed_multi_axis_day_status_percentage"
                        , check_name : 'All Checks'
                        , date_from : date_from_str
                        , date_to : date_to_str
                        , parameter_y_left : { name:"Record" , type:"line"
                            , data : arr_graph_line_total
                            , text : "Record Count"
                        }
                        , parameter_y_right_1 :{ name:"Passed Percentage" , type:"column"
                            , data : arr_graph_line_compliant_percentage
                            , text : "Passed Percentage Count"
                        }
                        , parameter_y_right_2 :{ name:"Failed Percentage" , type:"column"
                            , data : arr_graph_line_is_not_compliant_percentage
                            , text : "Failed Percentage Count"
                        }
                        , parameter_x : arr_date
                        , is_dasboard : true
                        , max_scale : Math.max.apply(null,arr_graph_line_is_compliant) >= Math.max.apply(null,arr_graph_line_is_not_compliant)?
                            Math.max.apply(null,arr_graph_line_is_compliant): Math.max.apply(null,arr_graph_line_is_not_compliant)
                    });*/

                let circle_index = class_array.get_index('assign_dashboard_circle_id');
                load_chart_pie_apex_arr([   // Pie Charts for Team
                                        // {div_id:"div_chart_assign_inspection_team", chart_title: "By Inspection Team", data : class_array.count("assign_inspection_team")}
                                            // Pie Charts for Program
                                        // ,{div_id:"div_chart_assign_program_types", chart_title: "By Program Types", data : class_array.count("assign_program_types")}
                                            // Pie Charts for Plants
                                        // ,{div_id:"div_chart_assign_plant", chart_title: "By Site", data : class_array.count("assign_plant")}
                                            // Pie Charts for Failed/Passed
                                            // Pie Charts for CCP
                           


                                        {div_id:"div_chart_assign_ccp", chart_title: "Critical Control Points", data : {arr_group_by:["Passed","Failed"]
                                            , arr_count:[arr_graph_line_is_compliant.reduce((a, b) => a + b, 0),arr_graph_line_is_not_compliant.reduce((a, b) => a + b, 0)]
                                            , arr_result:[] },expression:(x)=>x[circle_index] == 14}
                                        ,{div_id:"div_chart_assign_preop", chart_title: "Pre-Op Sanitation", data : {arr_group_by:["Passed","Failed"]
                                            , arr_count:[arr_graph_line_is_compliant.reduce((a, b) => a + b, 0),arr_graph_line_is_not_compliant.reduce((a, b) => a + b, 0)]
                                            , arr_result:[] },expression:(x)=>x[circle_index] == 2}
                                        ,{div_id:"div_chart_assign_atpswab", chart_title: "Enviromental Monitoring", data : {arr_group_by:["Passed","Failed"]
                                            , arr_count:[arr_graph_line_is_compliant.reduce((a, b) => a + b, 0),arr_graph_line_is_not_compliant.reduce((a, b) => a + b, 0)]
                                            , arr_result:[] },expression:(x)=>x[circle_index] == 3}    
                                            // Pie Charts for Failed/Passed
                                        ,{div_id:"div_chart_assign_Stauts", chart_title: "Recieving Compliance", data : {arr_group_by:["Passed","Failed"]
                                            , arr_count:[arr_graph_line_is_compliant.reduce((a, b) => a + b, 0),arr_graph_line_is_not_compliant.reduce((a, b) => a + b, 0)]
                                            , arr_result:[] },expression:(x)=>x[circle_index] == 1}
                                        ]
                                        , "#div_chart_pie"
                                    );
                //load_chart_mixed_multy_y_axis_apex_static("div_chart_day_status_percentage")
                //chart_maker_line(arrr_load_chart_line(), 'chart-line-by-check','wrapper-chart-line','Herb Cheese Pouch Leak Test');
                $("#div_tblreport button").css("display","none");// hides export button
            }
        }]);
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























