<style type="text/css">
    .description{
        margin-top: 50px;
        text-align:left;
        font-family: calibri;
        font-size: 16px;
        color: gray;
    }
    a:link, a:visited, a:active{color: #4F81BC;}
    .white_bg{
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
                    <div style="float: left">
                        <a onclick="toggle_tab(true)" style="cursor: pointer"> Reports </a>
                            <small data-localize="reports.WELCOME"></small>
                    </div>
                    <div style="float: left; width:10px"> | </div>
                    <div>
                        <a onclick="toggle_tab(false)" style="cursor: pointer"> Dashboard </a>
                            <small data-localize="reports.WELCOME"></small>
                    </div>
                </div>
            </div>
        </section>

        <section id="tab_reports">

            <div class="content-wrapper">
                <form id="search_form" action="javascript:void(0)" method="post">
                    <div class="row">
                        <div class="form-group">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="col-sm-12" style="padding: 0px !important;">
                                        <div id="div_program_types"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="col-sm-12" style="padding: 0px !important;">
                                        <div id="div_product_checks"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="col-sm-12" style="padding: 0px !important;">
                                        <div id="div_questions"></div>
                                        <a class="fa fa-save " id="btnSaveDefaultReport" style="float: right"></a>
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
                                            <div class='input-group datetimepicker2' >
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
                        </div>
                    </div>

                    <div class="row" >
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12" style="padding: 0px !important;">
                                    <div id="div_plants"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12" style="padding: 0px !important;">
                                    <div id="div_lines"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12" style="padding: 0px !important;">
                                    <div id="div_products"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12" style="padding: 0px !important;">
                                    <select class="form-control" id="status" name="status">
                                        <option value="0"> Select Status </option>
                                        <option value="1">Pass</option>
                                        <option value="2">Fail</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                    <div class="col-md-2">
                        <div class="form-group" style="margin-top: 7px;">
                            <button type="button" id="btnSearch" class="btn btn-primary form-control filter_search">Search</button>
                        </div>
                    </div>

<!--                    <div class="col-md-2">-->
<!--                        <div class="form-group" style="margin-top: 7px;">-->
<!--                            <button type="button" id="" class="btn btn-info form-control filter_search">Save Default Report</button>-->
<!--                        </div>-->
<!--                    </div>-->
                    </div>
                    <br>
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <div id="div_tblreport"></div>
                    </div>
                </div>
            </div>

        </section>

        <section id="tab_charts">

            <div class="content-wrapper">

                <div id="div_chart_day_status_percentage"></div>
                <div id="div_chart_mixed_multi_axis_day_status_percentage"></div>
                <!---------------------------------Totals(start)------------------------------ -->
                <div class="div_chart" id="div_chart_totals"></div>
                <!---------------------------------Totals(end)------------------------------ -->

                <!---------------------------------Compliants(start)------------------------------ -->
                <div class="div_chart" id="div_chart_compliants"></div>
                <!---------------------------------Compliants(end)------------------------------ -->

                <!---------------------------------Corrections(start)------------------------------ -->
                <div class="div_chart" id="div_chart_corrections"></div>
                <!---------------------------------Corrections(end)------------------------------ -->

                <!---------------------------------Unsigned(start)------------------------------ -->
                <div class="div_chart" id="div_chart_signed"></div>
                <!---------------------------------Unsigned(end)------------------------------ -->


                <div class="wrapper-chart-line"></div>

                <div class="wrapper-chart-bar-stacked"></div>

            </div>

        </section>
    </div>
</div>
<script src="<?php echo STATIC_ADMIN_JS?>jquery.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Chart.bundle.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>widgets.js"></script>

<script src="<?php echo STATIC_ADMIN_JS?>controller.js"></script>

<script src="<?php echo STATIC_ADMIN_JS?>Flot\jquery.flot.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>flot.tooltip\js\jquery.flot.tooltip.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Flot\jquery.flot.resize.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Flot\jquery.flot.pie.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Flot\jquery.flot.time.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>Flot\jquery.flot.categories.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>flot-spline\js\jquery.flot.spline.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>demo-flot.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js" ></script>
<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript">
    function toggle_tab(is_report_tab){
        if (is_report_tab)
        {
            $('#tab_reports').show();
            $('#tab_charts').hide();
        }
        else
        {
            $('#tab_reports').hide();
            $('#tab_charts').show();
        }
    }

    $(document).ready(function() {
        toggle_tab(true);

        //load_chart_mixed_multy_y_axis_apex_static("div_chart_day_status_percentage")

//#region Graph Designer Code


        /*
                chart_maker_line([{
                    "label": "Passed",
                    "color": 'green',
                    "data": [
                        ["Jan, 1 2019", 188],
                        ["Jan, 2 2019", 183],
                        ["Jan, 3 2019", 185],
                        ["Jan, 4 2019", 199],
                        ["Jan, 5 2019", 190],
                        ["Jan, 6 2019", 194],
                        ["Jan, 7 2019", 194],
                        ["Jan, 8 2019", 184],
                        ["Jan, 9 2019", 74]
                    ]
                }, {
                    "label": "Failed",
                    "color": 'red' ,
                    "data": [
                        ["Jan, 1 2019", 153],
                        ["Jan, 2 2019", 116],
                        ["Jan, 3 2019", 136],
                        ["Jan, 4 2019", 119],
                        ["Jan, 5 2019", 148],
                        ["Jan, 6 2019", 133],
                        ["Jan, 7 2019", 118],
                        ["Jan, 8 2019", 161],
                        ["Jan, 9 2019", 59]
                    ]
                }], 'chart-line-by-product','wrapper-chart-line','Product 1');

                chart_maker_bar_stacked([{
                    "label": "Open",
                    "color": "grey",
                    "data": [
                        ["Jan", 56],
                        ["Feb", 81],
                        ["Mar", 97],
                        ["Apr", 44],
                        ["May", 24],
                        ["Jun", 85],
                        ["Jul", 94],
                        ["Aug", 78],
                        ["Sep", 52],
                        ["Oct", 17],
                        ["Nov", 90],
                        ["Dec", 62]
                    ]
                }, {
                    "label": "Overdue",
                    "color": "red",
                    "data": [
                        ["Jan", 69],
                        ["Feb", 135],
                        ["Mar", 14],
                        ["Apr", 100],
                        ["May", 100],
                        ["Jun", 62],
                        ["Jul", 115],
                        ["Aug", 22],
                        ["Sep", 104],
                        ["Oct", 132],
                        ["Nov", 72],
                        ["Dec", 61]
                    ]
                }, {
                    "label": "completed",
                    "color": "green",
                    "data": [
                        ["Jan", 29],
                        ["Feb", 36],
                        ["Mar", 47],
                        ["Apr", 21],
                        ["May", 5],
                        ["Jun", 49],
                        ["Jul", 37],
                        ["Aug", 44],
                        ["Sep", 28],
                        ["Oct", 9],
                        ["Nov", 12],
                        ["Dec", 35]
                    ]
                }]
                ,'chart_linek6_by_check','wrapper-chart-bar-stacked','check 1234');

                chart_maker_bar_stacked([{
                        "label": "passed",
                        "color": "green",
                        "data": [
                            ["Jan", 56],
                            ["Feb", 81],
                            ["Mar", 97],
                            ["Apr", 44],
                            ["May", 24],
                            ["Jun", 85],
                            ["Jul", 94],
                            ["Aug", 78],
                            ["Sep", 52],
                            ["Oct", 17],
                            ["Nov", 90],
                            ["Dec", 62]
                        ]
                    }, {
                        "label": "failed",
                        "color": "red",
                        "data": [
                            ["Jan", 69],
                            ["Feb", 135],
                            ["Mar", 14],
                            ["Apr", 100],
                            ["May", 100],
                            ["Jun", 62],
                            ["Jul", 115],
                            ["Aug", 22],
                            ["Sep", 104],
                            ["Oct", 132],
                            ["Nov", 72],
                            ["Dec", 61]
                        ]
                    }, {
                        "label": "+1",
                        "color": "#f0693a",
                        "data": [
                            ["Jan", 29],
                            ["Feb", 36],
                            ["Mar", 47],
                            ["Apr", 21],
                            ["May", 5],
                            ["Jun", 49],
                            ["Jul", 37],
                            ["Aug", 44],
                            ["Sep", 28],
                            ["Oct", 9],
                            ["Nov", 12],
                            ["Dec", 35]
                        ]
                    }]
                    ,'chart_line_by_product','wrapper-chart-bar-stacked','product 1234');
        */
//#endregion

        load_ddl([ { action_name : 'widgets/load_program_types' ,   div_id : 'div_program_types' ,   ddl_id_name : 'program_types', default_text : ' Select Program '}
            ,{ action_name : 'widgets/load_product_checks' ,   div_id : 'div_product_checks' ,   ddl_id_name : 'product_checks', default_text : ' Select Check '}
            , { action_name : 'widgets/load_plants' ,   div_id : 'div_plants' ,   ddl_id_name : 'plants'
                ,   default_text : ' Select Plant '
                ,load_events : function () {
                    $("#plants").change(function () {
                        load_ddl( [{ action_name : 'widgets/load_lines_by_plant_id' ,   div_id : 'div_lines' ,   ddl_id_name : 'lines'
                            ,   default_text : ' Select line ' , p_data : {plant_id:this.value} }]);
                    });
                }
            }
            , { action_name : 'widgets/load_lines_by_plant_id' ,   div_id : 'div_lines' ,   ddl_id_name : 'lines'
                ,   default_text : ' Select line ' , p_data : {plant_id:0} }
            ,{ action_name : 'widgets/load_questions_by_program_type_or_product_checks' ,   div_id : 'div_questions' ,   ddl_id_name : 'questions'
                , is_multi_select : "true"
                ,   p_data :
                    {
                        product_checks:0,
                        // plants:$('#plants').val(),
                        // lines:$('#lines').val(),
                        // productid:$('#productid').val(),
                        // status:$('#status').val(),
                        // start_date:$('#startdate').val(),
                        // end_date:$('#enddate').val(),
                        program_types:0
                    }
                ,
                load_events : function () {
                    $("#questions").multiselect({
                        includeSelectAllOption: true
                    });
                    //$(".checkbox").css("color","black");
                }
            }
            , { action_name : 'widgets/load_products' ,   div_id : 'div_products' ,   ddl_id_name : 'productid'
                ,   default_text : ' Select Product '
                ,load_events : function () {
                    $("#program_types").change(function () {
                        if($('#product_checks').val() > 0 && $('#program_types').val() > 0){
                            $("#product_checks").prop('selectedIndex', 0);
                        }
                    });
                    $("#product_checks").change(function () {
                        if($('#product_checks').val() > 0 && $('#program_types').val() > 0){
                            $("#program_types").prop('selectedIndex', 0);
                        }
                        load_ddl([{ action_name : 'widgets/load_questions_by_program_type_or_product_checks' ,   div_id : 'div_questions' ,   ddl_id_name : 'questions'
                            , is_multi_select : "true"
                            ,   p_data :
                                {
                                    product_checks:$('#product_checks').val(),
                                    program_types:$('#program_types').val()
                                }
                        ,
                            load_events : function () {
                                $("#questions").multiselect({
                                    includeSelectAllOption: true
                                });
                                //$(".checkbox").css("color","black");
                            }
                        }]);
                    });
                }}
            /**/
        ]);
        $('#btnSaveDefaultReport').click(function(){
            //alert("btnSaveDefaultReport");
            gen_save([{
                            action_name : 'reports/save_report_default_questions'
                        ,   p_data :
                            {
                                product_checks:$('#product_checks').val(),
                                program_types:$('#program_types').val(),
                                questions:$('#questions').val()
                            }
            }]);
        });
        $('#btnSearch').click(function(){

            load_dt([{
                action_name : 'widgets/load_report_by_check'
                ,   div_id : 'div_tblreport'
                ,   p_data :
                    {
                        product_checks:$('#product_checks').val(),
                        plants:$('#plants').val(),
                        lines:$('#lines').val(),
                        productid:$('#productid').val(),
                        status:$('#status').val(),
                        start_date:$('#startdate').val(),
                        end_date:$('#enddate').val(),
                        program_types:$('#program_types').val(),
                        questions:$('#questions').val()
                    }
                ,   load_events : function () {
                    load_model_detail_events(
                                        "<?= ADMIN_BASE_URL?>assignments/pending_review_detail"
                                       ,{'id': 0,'function':'<?=$this->uri->segment(3);?>'}
                                    )
                    arrr_html_table_to_array_objects('#tblReportData');
                    let arr_compliants = arrr_get_assignment_compliants();
                    let arr_non_compliants = arr_compliants.filter(x=>!x.is_compliants);
                    $('.div_chart').html('');
                    load_chart_for_totals('#div_chart_totals'
                        ,get_array_by_associative_index_distinct("assign_checkname").length
                        ,get_array_by_associative_index_distinct("assign_id").length
                        ,get_array_by_associative_index_distinct("assign_user").length);
                    let non_compliants_percentage = (arr_non_compliants.length/arr_compliants.length) * 100;
                    load_chart_for_compliants('#div_chart_compliants',100-non_compliants_percentage,true);
                    load_chart_for_compliants('#div_chart_compliants',non_compliants_percentage,false);
                    load_chart_for_corrections('#div_chart_corrections', arr_non_compliants);
                    arrr_load_chart_mixed_multi_y_axis();
                    load_chart_mixed_multy_y_axis_apex({div_id : "div_chart_mixed_multi_axis_day_status_percentage",check_name : $("#product_checks option:selected").text()});
                    //load_chart_mixed_multy_y_axis_apex_static("div_chart_day_status_percentage")
                    //chart_maker_line(arrr_load_chart_line(), 'chart-line-by-check','wrapper-chart-line','Herb Cheese Pouch Leak Test');
                }
            }]);

        });

       /* $('.filter_search').on('click', function() {
            if(validateForm()) {
                if(!$('.checking_previous').text()) {
                    $('#search_form').attr('action', "dashboard/reporting").submit();
                    $('.checking_previous').html('');
                    location.reloadt();
                }
                else
                    showToastr("Please complete the previous update first", false);
            }
        });*/
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

