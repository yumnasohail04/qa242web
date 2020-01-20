//#region Classes
const monthFullNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
];
class ClassScreen{
    is_xs = false;
    is_sm = false;
    is_md = false;
    is_lg = false;
    is_xl = false;
    constructor(){
        (screen.width >= 1200)? (this.is_lg = true):
        (screen.width >= 992)? (this.is_md = true):
        (screen.width >= 768)? (this.is_sm = true): (this.is_xs) = true;
    }
}

class ClassChartPieApex {
    labels = [];
    series = [];
    div_id_or_class = "";
    constructor(p_labels, p_series, p_div_id_or_class) {
        this.labels = p_labels;
        this.series = p_series;
        this.div_id_or_class = p_div_id_or_class;
    }
}

class ClassArray {
    constructor(){}

    get_index = (index_str) => {return arr_associative_index.filter(x=>x.index_associative == index_str)[0].index_int;};

    count = function ( p_group_by_column_name ) {
        let arr_group_by_column = [];
        let arr_count = [];
        let arr_result = [];
        let total = 0;
        let p_group_by_column_index = class_array.get_index(p_group_by_column_name);

        arr_tbl_columns_to_rows_distinct[p_group_by_column_index].forEach(
            (item,index) =>
            {
                total = arr_tbl.filter(x => x[p_group_by_column_index] == item).length;
                arr_group_by_column.push(item);
                arr_count.push(total);
                arr_result.push({group_by:item, count:total});
            });
        //console.log(arr_counter);
        return {
            arr_group_by:arr_group_by_column
            ,   arr_count:arr_count
            ,   arr_result:arr_result
        };
    }

    count_by_custom_filter = function ( p_group_by_column_name, filter_function ) {
        let arr_group_by_column = [];
        let arr_count = [];
        let arr_result = [];
        let total = 0;
        let p_group_by_column_index = class_array.get_index(p_group_by_column_name);

        arr_tbl_columns_to_rows_distinct[p_group_by_column_index].forEach(
            (item,index) =>
            {
                total = arr_tbl.filter(x => x[p_group_by_column_index] == item).filter(filter_function).length;
                arr_group_by_column.push(item);
                arr_count.push(total);
                arr_result.push({group_by:item, count:total});
            });
        //console.log(arr_counter);
        return {
            arr_group_by:arr_group_by_column
            ,   arr_count:arr_count
            ,   arr_result:arr_result
        };
    }

    arr_group_by_custom_filter = function ( p_arr_group_by_column_indexes, filter_function ) {
        // let arr_group_by_column = [];
        // let arr_count = [];
        // let arr_result = [];
        // let total = 0;
        // let filter_result=[];
        //let p_group_by_column_index = class_array.get_index(p_group_by_column_name);
        let arr_filter_result = [[],[]];
        let arr_group_by_column =[];
        let filter_result=[];
        arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[0]].forEach(
            (item, index) =>
            {
                //arr_group_by_column[0].push(item);
                filter_result[0] = arr_tbl.filter(x => x[p_arr_group_by_column_indexes[0]] == item);
                //console.log(filter_result);
                arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[1]].forEach(
                    (item_in,index_in) =>
                    {
                        filter_result[1] = filter_result[0].filter(x=>x[p_arr_group_by_column_indexes[1]] == item_in).filter(filter_function);
                        arr_filter_result[index_in].push(filter_result[1].length);
                        //arr_filter_result[index_in].push({result_count:filter_result.length , result:filter_result});
//arr_group_by_column[1].push(item_in);
                        //arr_filter_result.push(total);
                        //arr_result.push({group_by:item, count:total});
//console.log(filter_result);
                    });
            });
   //     console.log(arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[0]]);
    //    console.log(arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[1]]);
    //    console.log(arr_filter_result);
//arr_group_by_column[0];
//arr_group_by_column[1];

//         arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[0]].forEach(
//             (item, index) =>
//             {
//                 filter_result[0] = arr_tbl.filter(x => x[p_arr_group_by_column_indexes[0]] == item);
//                 arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[1]].forEach(
//                     (item_in,index_in) =>
//                     {});
//                         filter_result[1] = filter_result[0].filter(x => x[p_arr_group_by_column_indexes[1]] == item_in).filter(filter_function);
//                         arr_group_by_column.push(item_in);
//                         arr_count.push(total);
//                         arr_result.push({group_by:item, count:total});
//                     });
//             }
        //console.log(arr_counter);

        return {
            arr_group_by:[arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[0]],arr_tbl_columns_to_rows_distinct[p_arr_group_by_column_indexes[1]]]
            //,   arr_count:arr_count
            ,   arr_result:arr_filter_result
        };
    }
    
    set_arr_date_range = function (p_indexes, dt_from, dt_to) {
        arr_tbl_columns_to_rows_distinct[p_indexes[0]] = [];
        arr_tbl_columns_to_rows_distinct[p_indexes[1]] = [];
        for (let dt = dt_from; dt<=dt_to ; ){
            arr_tbl_columns_to_rows_distinct[p_indexes[0]].push(dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate());
            if ( !arr_tbl_columns_to_rows_distinct[p_indexes[1]].some(x=>x==monthNames[dt.getMonth()]) ) {
                arr_tbl_columns_to_rows_distinct[p_indexes[1]].push(monthNames[dt.getMonth()]);
            }
            dt = new Date(dt.setDate( dt.getDate() + 1 ));
        }
       // e.log(arr_tbl_columns_to_rows_distinct[p_indexes[0]]);
       // console.log(arr_tbl_columns_to_rows_distinct[p_indexes[1]]);
    }
}

//#endregion

//#region Variables
var url_base =  (window.location.hostname=="http://lantixapp1.lantix.com")?"/admin/":"/";
//var arr_ddl = {};
var class_array = new ClassArray();
var class_screen = new ClassScreen();
var arr_associative_index;
var arr_tbl;
var arr_tbl_columns_to_rows;
var arr_tbl_columns_to_rows_distinct;
var arr_assignments;
var arr_graph_line = [];
var arr_graph_line_is_compliant_with_date = [];
var arr_graph_line_is_not_compliant_with_date = [];
var arr_graph_line_is_compliant = [];
var arr_graph_line_is_not_compliant = [];
var arr_graph_line_compliant_percentage = [];
var arr_graph_line_is_not_compliant_percentage = [];
var arr_graph_line_total = [];
var arr_date = [];
var arr_chart_colors = ['#7BABED','#A4D014', '#F38282', '#F7D16E','#EB5572','#D9E9FF'];
var color_passed = '#A4D014';
var color_failed = '#F38282';
var color_others = '#7BABED';
//#endregion

function gen_save(arr_ddl) {
    $.each(arr_ddl,function (index, arr){
    if (arr.p_data.questions){arr.p_data.questions = arr.p_data.questions.join(',')}
    //console.log(arr);
        $.ajax({
            type: "POST",
            url: url_base + arr.action_name,
            dataType: "JSON",
            data:arr.p_data,
            success: function (data) {
                if (arr.success){
                    arr.success();
                }
                else{
                    alert(data.msg);
                }
            }
        });
    });
}

function load_ddl(arr_ddl) {
    /*console.log(arr_ddl);*/
    //console.log(arr_ddl);
    $.each(arr_ddl,function (index, arr){
        if (arr.p_data == undefined || arr.p_data == null){
            arr.p_data = {};
        }
        $.ajax({
            type: "POST",
            url: url_base + arr.action_name,
            dataType: "JSON",
            data:arr.p_data,
            success: function (data) {
//console.log(data);
                //console.log(arr);
                //$('#' + arr.div_id).html( arr.action_name + ' --- ' + arr.ddl_id_name + ' --- ' + arr.default_text + ' --- ' + arr.div_id + ' --- ' + data);
                /* */
                //if (arr.action_name == "load_questions_by_program_type_or_product_checks")
                //console.log(data);
                // "+(arr.is_multi_select?"multiple":"")+"
                var select = $("<select "+(arr.is_multi_select?"multiple":"")+" ></select>").attr("class", 'form-control').attr("id", arr.ddl_id_name).attr("name", arr.ddl_id_name);
                if (arr.default_text != undefined && arr.default_text != null) {
                    select.append($("<option></option>").attr("value", 0).text(arr.default_text));
                }
                $.each(data, function (index, d) {
                    if (d.selected){
                        //console.log(d.selected);
                        select.append($("<option "+(d.selected=="1"?"selected":"")+" ></option>").attr("value", d.value).text(d.text));
                    }
                    else {
                        select.append($("<option></option>").attr("value", d.value).text(d.text));
                    }
                });
                $('#' + arr.div_id).html(select);

                if (arr.load_events != undefined && arr.load_events != null){
                    arr.load_events();
                }
            }
        });
    });
}

//#region Model for detail
function load_model_detail_events(p_url,p_data) {

    $(document).on("click", ".view_details", function (event) {
        event.preventDefault();
        var id = $(this).attr('rel');
        p_data.id = id;
        //alert("<?=$this->uri->segment(3);?>"); return false;
        $.ajax({
            type: 'POST',
            url: p_url,
            data: p_data,
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

}
//#endregion

//#region HTML table

function load_dt(arr_dt) {

    $.each(arr_dt,function (index, arr) {
        if (arr.p_data.questions){arr.p_data.questions = arr.p_data.questions.join(',')}
   //     console.log(arr.p_data);
        if (arr.p_data == undefined || arr.p_data == null) {
            arr.p_data = {};
        }
        $.ajax({
            type: "POST",
            url: url_base + arr.action_name,
            dataType: "html",
            data: arr.p_data,
            success: function (data) {
             /*
                console.log(data);
                console.log(arr);
            */
                $('#' + arr.div_id).html(data);
                if (arr.p_data.tbl_id_or_class)
                {

                }
                if (arr.load_events != undefined && arr.load_events != null) {
                    arr.load_events();
                }
            }
        });
    });
}

function download_csv(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV FILE
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // We have to create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Make sure that the link is not displayed
    downloadLink.style.display = "none";

    // Add the link to your DOM
    document.body.appendChild(downloadLink);

    // Lanzamos
    downloadLink.click();
}

function export_table_to_csv(tbl_id,html, filename) {
    var csv = [];
    var rows = document.querySelectorAll(tbl_id + " tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");

        for (var j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(","));
    }

    // Download CSV
    download_csv(csv.join("\n"), filename);
}

function export_to_CSV(tbl_id,filename) {
    var html = document.querySelector(tbl_id).outerHTML;
    export_table_to_csv(tbl_id,html, filename + ".csv");
}

//#endregion

//#region Chart
function load_charts(arr_chart) {

    $.each(arr_chart,function (index, arr) {
      //  console.log(arr.p_data);
        if (arr.p_data == undefined || arr.p_data == null) {
            arr.p_data = {};
        }
        $.ajax({
            type: "POST",
            url: url_base + arr.action_name,
            dataType: "html",
            data: arr.p_data,
            success: function (data) {
                $('#' + arr.div_id).html(data);
                if (arr.load_events != undefined && arr.load_events != null) {
                    arr.load_events();
                }
            }
        });
    });
}

function load_chart_for_totals(div_id_or_class,total_1,total_2,total_3,bootstrap_cols) {
    $(div_id_or_class).append('<div class="'+bootstrap_cols+'"> <div class="card text-white white_bg" style="height: 350px"> <div class="card-body pb-0"> <h4 class="mb-0" style="background: '+color_others+'">Totals </h4> <div class="row sub_row"> <div class="col-lg-4 cards" style="color:#929292"> <h4 class="mb"> <span class="count">'+total_1+'</span> </h4> <span class="font-head">Forms</span> <i class=" fa fa-list-alt fa_icons"></i> </div><div class="col-lg-4 cards" style="color:#929292"> <h4 class="mb"> <span class="count">'+total_2+'</span> </h4> <span class="font-head">Records</span> <i class="fa fa-archive fa_icons"></i> </div><div class="col-lg-4 cards" style="color:#929292"> <h4 class="mb"> <span class="count">'+total_3+'</span> </h4> <span class="font-head">Users</span> <i class="fa fa-user fa_icons"></i> </div></div></div></div></div>');
}

function load_chart_for_compliants(div_id_or_class,p_percentage,is_compliants,bootstrap_cols) {
    $(div_id_or_class).append('<div class="'+bootstrap_cols+'"> <div class="card text-white white_bg" style="height: 350px"> <div class="card-body pb-0"> <h4 class="mb-0" style="background: '+color_others+'">'+(is_compliants?" ":" Non-")+'Compliants </h4> <div class="row sub_row"> <div class="col-lg-6 cards" style="color:#929292"> <h4 class="mb"> <span class="count" style="font-size: 40px;color:'+(is_compliants?color_passed:color_failed)+'; ">'+p_percentage.toFixed(2)+'</span> %</h4> <span class="font-head">Forms</span> </div><div class="col-lg-6 cards" style="color:#929292"> <i style="font-size: 90px;color:'+(is_compliants?color_passed:color_failed)+';" class=" fa '+(is_compliants?"fa-check-circle":"fa-times-circle" )+' fa_icons"></i> </div></div><div class="prog"> <div id="myProgress"> <div id="myBar" style="background-color:'+(is_compliants?"green":"red")+'; width: '+p_percentage+'% !important;"></div></div></div></div></div></div>');
}

function load_chart_for_corrections(div_id_or_class,arr_non_compliants) {
    let str_html = '';
    str_html = '<div class="col-sm-12"> <div class="card text-white white_bg"> <div class="card-body pb-0"> <h4 class="mb-0" style="background: '+color_others+'"> Corrections </h4> <div class="row sub_row overflow_bar"> <div class=" cards" style="color:#929292; margin-bottom: 12px;"> <span class="font-head"><i style="font-size: 30px; color: #5d8abf;" class=" fa fa-close "></i> Unresolved</span> </div>';
    //for (let i = 0; i<=10; i++){
    arr_non_compliants.forEach(function (item, index) {
    str_html = str_html + '<div class="col-md-4 col-lg-3 check-content" style="height: 250px; " > <div class="date_time" style="background: '+arr_chart_colors[(index % 6)]+'"> <span>'+item.date+'</span> </div><div class="contents"> <p>'+item.user+'</p><p style="font-weight: bold; font-size: 20px;">'+item.check+'</p></div></div>';
    });
    str_html = str_html + '</div></div></div></div>';
    $(div_id_or_class).append(str_html);
}

function arrr_load_chart_mixed_multi_y_axis() {
    arr_graph_line_is_compliant = [];
    arr_graph_line_is_not_compliant = [];
    arr_graph_line_compliant_percentage = [];
    arr_graph_line_is_not_compliant_percentage = [];
    arr_graph_line_total = [];
    arr_date = [];
    arr_tbl_columns_to_rows_distinct[arr_associative_index.findIndex(x=>x.index_associative == "assign_date")].forEach(
        (item,index) =>
        {
            total = arr_assignments.filter(x=>x.date_simple == item).length;
            compliant = arr_assignments.filter(x=>x.date_simple == item && x.is_compliants).length;
            non_compliant = (total-compliant);
            total = isNaN(total)?0:total;
            compliant = isNaN(compliant)?0:compliant;
            non_compliant = isNaN(non_compliant)?0:non_compliant;

            arr_graph_line_is_compliant.push(compliant);
            arr_graph_line_compliant_percentage.push((compliant / total) * 100);
            arr_graph_line_is_not_compliant.push(non_compliant);
            arr_graph_line_is_not_compliant_percentage.push((non_compliant / total) * 100);
            arr_graph_line_total.push(total);
            arr_date.push(item);
        });
   // console.log(arr_graph_line_is_compliant);
   // console.log(arr_graph_line_compliant_percentage);
   // console.log(arr_graph_line_is_not_compliant);
   // console.log(arr_graph_line_is_not_compliant_percentage);
   // console.log(arr_graph_line_total);
   // console.log(arr_date);
}

function arrr_load_chart_line(){

    arr_graph_line = [];
    arr_graph_line_is_compliant_with_date = [];
    arr_graph_line_is_not_compliant_with_date = [];
    arr_tbl_columns_to_rows_distinct[arr_associative_index.findIndex(x=>x.index_associative == "assign_date")].forEach(
        (item,index) =>
        {
            arr_graph_line_is_compliant_with_date.push([ item, arr_assignments.filter(x=>x.date_simple == item && x.is_compliants).length]);

            arr_graph_line_is_not_compliant_with_date.push([ item, arr_assignments.filter(x=>x.date_simple == item && !x.is_compliants).length]);
        });

  //  console.log(arr_graph_line_is_compliant_with_date);
 //   console.log(arr_graph_line_is_not_compliant_with_date);
    arr_graph_line.push({
        "label": "Passed",
        "color": 'green',
        "data":
            arr_graph_line_is_compliant_with_date

    });

    arr_graph_line.push({
        "label": "Failed",
        "color": 'red',
        "data":
            arr_graph_line_is_not_compliant_with_date

    });
  //  console.log(arr_graph_line);
    return arr_graph_line;
}

function load_chart_mixed_multy_y_axis_apex(arr_info){
    //arrr_load_chart_mixed_multi_y_axis();
    let color1 = arr_chart_colors[0];
    let color2 = arr_chart_colors[1];
    let color3 = arr_chart_colors[2];
    var options;
    if(arr_info.is_dasboard) {
        options = {
            chart: {
                height: 350,
                type: 'line',
                stacked: false
                //,colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800']
            },
            colors: arr_chart_colors,
            fill: {
                colors: arr_chart_colors
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: arr_info.parameter_y_left.name,
                type: arr_info.parameter_y_left.type,
                data: arr_info.parameter_y_left.data//[14, 2, 25, 15, 25, 28, 38, 46]
                , color: color1
            }, {
                name: arr_info.parameter_y_right_1.name,
                type: arr_info.parameter_y_right_1.type,
                data: arr_info.parameter_y_right_1.data//[11, 3, 31, 4, 41, 49, 65, 85]
                , color: color2
            }, {
                name: arr_info.parameter_y_right_2.name,
                type: arr_info.parameter_y_right_2.type,
                data: arr_info.parameter_y_right_2.data//[20, 29, 37, 36, 44, 45, 50, 58]
                , color: color3
            }],
            stroke: {
                width: [1, 1, 4]
            },
            title: {
                text: '[' + arr_info.check_name + '] analysis from (' + arr_info.date_from + ') to (' + arr_info.date_to + ')',
                align: 'left',
                offsetX: 0,
                offsetY: 20,
                style: {
                    fontSize: '16px',
                    color: color_passed
                }
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    show: true,
                    rotate: -45,
                    rotateAlways: false,
                    hideOverlappingLabels: true,
                    showDuplicates: false,
                    trim: true,
                    minHeight: undefined,
                    maxHeight: 120,
                    style: {
                        colors: [],
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        cssClass: 'apexcharts-xaxis-label',
                    },
                    offsetX: 0,
                    offsetY: 0,
                    format: undefined,
                    formatter: undefined,
                    datetimeFormatter: {
                        year: 'yyyy',
                        month: "MMM 'yy",
                        day: 'dd MMM',
                        hour: 'HH:mm',
                    },
                },
                categories: arr_info.parameter_x//["Jan, 7 2019", "Jan, 8 2019", "Jan, 9 2019", "Jan, 10 2019", "Jan, 11 2019", "Jan, 12 2019", "Jan, 13 2019", "Jan, 14 2019"],
            },
            yaxis: [
                {
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: color1
                    },
                    labels: {
                        style: {
                            color: color1,
                        }
                    },
                    decimalsInFloat: 1,
                    // min: 0,
                    // max: 500,
                    title: {
                        text: arr_info.parameter_y_left.text,
                        style: {
                            color: color1,
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },

                {
                    seriesName: arr_info.parameter_y_right_1.name,
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: color2
                    },
                    labels: {
                        style: {
                            color: color2,
                        }
                    },
                    decimalsInFloat: 1,
                    min: 0,
                    max: 100,
                    title: {
                        text: "Percentage Count",//arr_info.parameter_y_right_1.text,
                        style: {
                            color: color3,
                        }
                    },
                },
                {
                    seriesName: arr_info.parameter_y_right_2.name,
                    show: false,
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: color3
                    },
                    labels: {
                        style: {
                            color: color3,
                        },
                    },
                    decimalsInFloat: 1,
                    min: 0,
                    max: 100,
                    title: {
                        text: arr_info.parameter_y_right_2.text,
                        style: {
                            color: color3,
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
    }
    else {
        options = {
            chart: {
                height: 350,
                type: 'line',
                stacked: false
                //,colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800']
            },
            colors:arr_chart_colors,
            fill: {
                colors: arr_chart_colors
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: arr_info.parameter_y_left.name,
                type: arr_info.parameter_y_left.type,
                data: arr_info.parameter_y_left.data//[14, 2, 25, 15, 25, 28, 38, 46]
                ,color:color1
            }, {
                name: arr_info.parameter_y_right_1.name,
                type: arr_info.parameter_y_right_1.type,
                data: arr_info.parameter_y_right_1.data//[11, 3, 31, 4, 41, 49, 65, 85]
                ,color:color2
            }, {
                name: arr_info.parameter_y_right_2.name,
                type: arr_info.parameter_y_right_2.type,
                data: arr_info.parameter_y_right_2.data//[20, 29, 37, 36, 44, 45, 50, 58]
                ,color:color3
            }],
            stroke: {
                width: [1, 1, 4]
            },
            title: {
                text: '['+arr_info.check_name+'] analysis from ('+arr_info.date_from+') to ('+arr_info.date_to+')',
                align: 'left',
                offsetX: 0,
                offsetY: 20,
                style: {
                    fontSize:  '16px',
                    color:  color_passed
                }
            },
            xaxis: {
                    type: 'datetime',
                    labels: {
                        show: true,
                        rotate: -45,
                        rotateAlways: false,
                        hideOverlappingLabels: true,
                        showDuplicates: false,
                        trim: true,
                        minHeight: undefined,
                        maxHeight: 120,
                        style: {
                            colors: [],
                            fontSize: '12px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            cssClass: 'apexcharts-xaxis-label',
                        },
                        offsetX: 0,
                        offsetY: 0,
                        format: undefined,
                        formatter: undefined,
                        datetimeFormatter: {
                            year: 'yyyy',
                            month: "MMM 'yy",
                            day: 'dd MMM',
                            hour: 'HH:mm',
                        },
                    },
                categories: arr_info.parameter_x//["Jan, 7 2019", "Jan, 8 2019", "Jan, 9 2019", "Jan, 10 2019", "Jan, 11 2019", "Jan, 12 2019", "Jan, 13 2019", "Jan, 14 2019"],
            },
            yaxis: [
                {
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: color1
                    },
                    labels: {
                        style: {
                            color: color1,
                        }
                    },
                    decimalsInFloat: 0,
                    min: 0,
                    max: (arr_info.max_scale + 10),
                    title: {
                        text: arr_info.parameter_y_left.text,
                        style: {
                            color: color1,
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },

                {
                    seriesName: arr_info.parameter_y_right_1.name,
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: color2
                    },
                    labels: {
                        style: {
                            color: color2,
                        }
                    },
                    decimalsInFloat: 0,
                    min: 0,
                    max: ( arr_info.max_scale + 10 ),
                    title: {
                        text: arr_info.parameter_y_right_1.text,
                        style: {
                            color: color2,
                        }
                    },
                },
                {
                    seriesName: arr_info.parameter_y_right_2.name,
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: color3
                    },
                    labels: {
                        style: {
                            color: color3,
                        },
                    },
                    decimalsInFloat: 1,
                    min: 0,
                    max: 100,
                    title: {
                        text: arr_info.parameter_y_right_2.text,
                        style: {
                            color: color3,
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
    }
    var chart = new ApexCharts(
        document.querySelector("#"+arr_info.div_id),
        options
    );


    chart.render();
    //$('.apexcharts-title-text').attr('x',0);
}

function load_chart_column_stacked_morrisBar1(p_obj) {
  
   var morrisData = [
    { y: '2006', a: 100, b: 90 },
    { y: '2007', a: 75,  b: 65 },
    { y: '2008', a: 50,  b: 40 },
    { y: '2009', a: 75,  b: 65 },
    
  ];
  console.log(p_obj.series) ;
 p_obj.xaxis.forEach(myFunction);
 var i=0;
function myFunction(item, index) {
    
        morrisData[index]['y']=item
        morrisData[index]['a']=p_obj.series[0]['data'][index] //////////passed data 
        morrisData[index]['b']=p_obj.series[1]['data'][index] //////////failed data
       
}

  new Morris.Bar({
    element: 'morrisBar1',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#D14F57', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
}
function load_chart_column_stacked_morrisBar2(p_obj) {
  
   var morrisData = [
    { y: '2006', a: 100, b: 90 },
    { y: '2007', a: 75,  b: 65 },
    { y: '2008', a: 50,  b: 40 },
    { y: '2009', a: 75,  b: 65 },
    
  ];
  var morrisData;
 p_obj.xaxis.forEach(myFunction);
 var i=0;
function myFunction(item, index) {
    
        morrisData[index]['y']=item
        morrisData[index]['a']=p_obj.series[0]['data'][index] //////////passed data 
        morrisData[index]['b']=p_obj.series[1]['data'][index] //////////failed data
       
}

  new Morris.Bar({
    element: 'morrisBar2',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#D14F57', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
}
function load_chart_column_stacked_morrisBar3(p_obj) {
  
   var morrisData = [
    { y: '2006', a: 100, b: 90 },
    { y: '2007', a: 75,  b: 65 },
    { y: '2008', a: 50,  b: 40 },
    { y: '2009', a: 75,  b: 65 },
    
  ];
  var morrisData;
 p_obj.xaxis.forEach(myFunction);
 var i=0;
function myFunction(item, index) {
    
        morrisData[index]['y']=item
        morrisData[index]['a']=p_obj.series[0]['data'][index] //////////passed data 
        morrisData[index]['b']=p_obj.series[1]['data'][index] //////////failed data
       
}

  new Morris.Bar({
    element: 'morrisBar3',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#D14F57', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
}
function load_chart_column_stacked_morrisBar4(p_obj) {
  
   var morrisData = [
    { y: '2006', a: 100, b: 90 },
    { y: '2007', a: 75,  b: 65 },
    { y: '2008', a: 50,  b: 40 },
    { y: '2009', a: 75,  b: 65 },
    
  ];
  var morrisData;
 p_obj.xaxis.forEach(myFunction);
 var i=0;
function myFunction(item, index) {
    
        morrisData[index]['y']=item
        morrisData[index]['a']=p_obj.series[0]['data'][index] //////////passed data 
        morrisData[index]['b']=p_obj.series[1]['data'][index] //////////failed data
       
}

  new Morris.Bar({
    element: 'morrisBar4',
    data: morrisData,
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Passed', 'Failed'],
    barColors: ['#D14F57', '#DFDFDF'],
    stacked: true,
    gridTextSize: 11,
    hideHover: 'auto',
    resize: true
  });
}


function load_chart_pie_apex_arr(arr_chart_info, div_parent_id_or_class, div_child_id){
    $(div_parent_id_or_class).html('');
    arr_chart_info.forEach(function (item, index) {
        //console.log(item.data.arr_group_by);
        //console.log(item.data.arr_count);
        //console.log(item.div_id);
      //  $(div_parent_id_or_class).append("<div class='col-sm-6 col-md-3' ><p style='color:white;font-size: 15px; text-align: center; background-color: "+arr_chart_colors[((index) % 6)]+";' >"+item.chart_title+"</p><div id='"+item.div_id+"' style='"+(class_screen.is_lg? 'float:left':' ')+"'></div><div id='"+item.div_id+"_column_chart"+"' style='"+(class_screen.is_lg? 'float:left':' ')+"'></div></div>");
       
       if(item.div_id=="morrisDonut1") {
        load_chart_pie_apex_morrisDonut1(new ClassChartPieApex(
            item.data.arr_group_by
            , item.data.arr_count
            , "#"+item.div_id
        ));
          obj_column_stacked = class_array.arr_group_by_custom_filter([class_array.get_index('assign_month'),class_array.get_index('result_status')],item.expression);
      //  console.log(obj_column_stacked);
        load_chart_column_stacked_morrisBar1(
            {
                div_id_or_class:"#"+item.div_id+"_column_chart"
                , series:[{
                        name: obj_column_stacked.arr_group_by[1][0],
                        data: item.div_id=="div_chart_assign_Stauts"?[10,12,22]:obj_column_stacked.arr_result[0]//[44, 55, 41, 67, 22, 43]
                    }
                    ,{
                        name: obj_column_stacked.arr_group_by[1][1],
                        data: item.div_id=="div_chart_assign_Stauts"?[0,1,5]:obj_column_stacked.arr_result[1]//[13, 23, 20, 8, 13, 27]
                    }
                ]
                ,
                xaxis: obj_column_stacked.arr_group_by[0]
            });
   }else if(item.div_id=="morrisDonut2"){
        load_chart_pie_apex_morrisDonut2(new ClassChartPieApex(
            item.data.arr_group_by
            , item.data.arr_count
            , "#"+item.div_id
        ));
          obj_column_stacked = class_array.arr_group_by_custom_filter([class_array.get_index('assign_month'),class_array.get_index('result_status')],item.expression);
      //  console.log(obj_column_stacked);
        load_chart_column_stacked_morrisBar2(
            {
                div_id_or_class:"#"+item.div_id+"_column_chart"
                , series:[{
                        name: obj_column_stacked.arr_group_by[1][0],
                        data: item.div_id=="div_chart_assign_Stauts"?[10,12,22]:obj_column_stacked.arr_result[0]//[44, 55, 41, 67, 22, 43]
                    }
                    ,{
                        name: obj_column_stacked.arr_group_by[1][1],
                        data: item.div_id=="div_chart_assign_Stauts"?[0,1,5]:obj_column_stacked.arr_result[1]//[13, 23, 20, 8, 13, 27]
                    }
                ]
                ,
                xaxis: obj_column_stacked.arr_group_by[0]
            });
   }
   else if(item.div_id=="morrisDonut3"){
        load_chart_pie_apex_morrisDonut3(new ClassChartPieApex(
            item.data.arr_group_by
            , item.data.arr_count
            , "#"+item.div_id
        ));
          obj_column_stacked = class_array.arr_group_by_custom_filter([class_array.get_index('assign_month'),class_array.get_index('result_status')],item.expression);
      //  console.log(obj_column_stacked);
       load_chart_column_stacked_morrisBar3(
            {
                div_id_or_class:"#"+item.div_id+"_column_chart"
                , series:[{
                        name: obj_column_stacked.arr_group_by[1][0],
                        data: item.div_id=="div_chart_assign_Stauts"?[10,12,22]:obj_column_stacked.arr_result[0]//[44, 55, 41, 67, 22, 43]
                    }
                    ,{
                        name: obj_column_stacked.arr_group_by[1][1],
                        data: item.div_id=="div_chart_assign_Stauts"?[0,1,5]:obj_column_stacked.arr_result[1]//[13, 23, 20, 8, 13, 27]
                    }
                ]
                ,
                xaxis: obj_column_stacked.arr_group_by[0]
            });
       
   }
   else if(item.div_id=="morrisDonut4"){
        load_chart_pie_apex_morrisDonut4(new ClassChartPieApex(
            item.data.arr_group_by
            , item.data.arr_count
            , "#"+item.div_id,
        ));
          obj_column_stacked = class_array.arr_group_by_custom_filter([class_array.get_index('assign_month'),class_array.get_index('result_status')],item.expression);
      //  console.log(obj_column_stacked);
        load_chart_column_stacked_morrisBar4(
            {
                div_id_or_class:"#"+item.div_id+"_column_chart"
                , series:[{
                        name: obj_column_stacked.arr_group_by[1][0],
                        data: item.div_id=="div_chart_assign_Stauts"?[10,12,22]:obj_column_stacked.arr_result[0]//[44, 55, 41, 67, 22, 43]
                    }
                    ,{
                        name: obj_column_stacked.arr_group_by[1][1],
                        data: item.div_id=="div_chart_assign_Stauts"?[0,1,5]:obj_column_stacked.arr_result[1]//[13, 23, 20, 8, 13, 27]
                    }
                ]
                ,
                xaxis: obj_column_stacked.arr_group_by[0]
            });
   }
       
    });
}

function load_chart_pie_apex_morrisDonut1(chart_info){

 new Morris.Donut({
    element: 'morrisDonut1',
    data: [
      {label: chart_info.labels[0], value: chart_info.series[0]},
      {label: chart_info.labels[1], value: chart_info.series[1]}
    ],
    colors: [ '#D14F57','#DFDFDF'],
    resize: true
  });
}
function load_chart_pie_apex_morrisDonut2(chart_info){

    
new Morris.Donut({
    element: 'morrisDonut2',
    data: [
      {label: 'Pre Op', value: 25},
      {label: 'Pre Op', value: 75}
    ],
    colors: ['#DFDFDF','#4CB581'],
    resize: true
  });
}
function load_chart_pie_apex_morrisDonut3(chart_info){

    
 new Morris.Donut({
    element: 'morrisDonut3',
    data: [
      {label: chart_info.labels[0], value: chart_info.series[0]},
      {label: chart_info.labels[1], value: chart_info.series[1]}
    ],
   colors: ['#DFDFDF','#5D89A8'],
    resize: true
  });
}
function load_chart_pie_apex_morrisDonut4(chart_info){

    
 new Morris.Donut({
    element: 'morrisDonut4',
    data: [
      {label: chart_info.labels[0], value: chart_info.series[0]},
      {label: chart_info.labels[1], value: chart_info.series[1]}
    ],
    colors: [ '#DFDFDF','#EF9738'],
    resize: true
  });
}

//#endregion

//#region Array Extend Methods


function arrr_html_table_to_array_objects(table_id_or_class) {
    arr_tbl=[];
    arr_associative_index = [];
    counter = 0;
    table_selector = table_id_or_class;
    // fill arr_associative_index
    $(table_selector+" tr th").each(function (){
        //if ($(this).hasClass("html_to_arr ")){
        if (this.dataset.htmltoarray == "true"){
            arr_associative_index.push({index_associative : this.dataset.arrayclassth, index_int : counter++});
        };
    });     //console.log(arr_associative_index);

    //fill data in array
    $(table_selector+" tr").each(function (){
        arr2=[]; row = $(this);
        arr_associative_index.forEach(function (item, index) {
            arr2.push(row.find("[data-arrayclasstd='" + item.index_associative + "']").html());
        });     //console.log(arr2);
        if (arr2 && arr2[0]){ arr_tbl.push(arr2); }
    });

    //console.log(arr_tbl);
    arrr_convert_array_colums_to_rows();
    convert_array_colums_to_rows_distinct();

}


function arrr_convert_array_colums_to_rows() {
    arr_tbl_columns_to_rows = [];//
    arr_associative_index.forEach(function (item, index) {
        arr_in=[];
        arr_tbl.forEach(function (item_in, index_in) {
            arr_in.push(item_in[index]);
        });
        arr_tbl_columns_to_rows.push(arr_in);
    });
}

function convert_array_colums_to_rows_distinct() {
    arr_tbl_columns_to_rows_distinct = [];
    arr_associative_index.forEach(function (item, index) {
        arr_in=[];
        //arr_tbl.forEach(function (item_in, index_in) {
            arr_in = arr_tbl_columns_to_rows[index].filter(unique);
        //});
        arr_tbl_columns_to_rows_distinct.push(arr_in);
    });
}

function get_array_by_associative_index(associative_index){
    return  arr_tbl_columns_to_rows[ arr_associative_index.filter(x=>x.index_associative == associative_index)[0].index_int ]
}

function get_array_by_associative_index_distinct(associative_index){
    return  arr_tbl_columns_to_rows_distinct[ arr_associative_index.filter(x=>x.index_associative == associative_index)[0].index_int ]
}
const unique = (value, index, self) => {
    return self.indexOf(value) === index
}

function arrr_get_assignment_compliants(){
    arr_assignments=[];
    is_compliants = true;
    arr_tbl.forEach(function (item,index){
        //console.log(item)
            is_compliants = item[class_array.get_index("result_status")] == "Passed"?true:false;
            arr_assignments.push(
                {     assign_id : item[class_array.get_index("assign_id")]
                    , date:(item[class_array.get_index("assign_day")] + ' ' + item[class_array.get_index("assign_date")])
                    , date_simple: item[class_array.get_index("assign_date")]
                    , user:item[class_array.get_index("assign_user")]
                    , check:item[class_array.get_index("assign_checkname")]
                    , is_compliants : is_compliants
                });
    });

    //arr_assignments.shift();
    //console.log(arr_assignments);
    return arr_assignments;
}

// function arrr_get_assignment_compliants(){
//     //arr_test=[];
//     arr_assignments=[];
//     is_compliants = true;
//     $("#tblReportData"+" tr td").each(function (){
//         //if(arr_assignments == undefined){}
//         if(!arr_assignments.some(x=> x.assign_id == $(this).attr("data-AssignAnsAssignID"))){
//
//             is_compliants = true;
//             arr_assignments.push(
//                 {     assign_id : $(this).attr("data-AssignAnsAssignID")
//                     , date:($(this).attr("data-AssignAnsDay") + ' ' + $(this).attr("data-AssignAnsDate"))
//                     , date_simple: $(this).attr("data-AssignAnsDate")
//                     , user:$(this).attr("data-AssignAnsUser")
//                     , check:$(this).attr("data-AssignAnsCheck")
//                     , is_compliants : is_compliants
//                 });
//
//         }
//
//         if(is_compliants & arr_assignments.some(x=> x.assign_id == $(this).attr("data-AssignAnsAssignID"))){
//             if(is_compliants){
//                 if($(this).attr("data-AssignAnsId")){
//                     arr_assignments.filter(x=> x.assign_id == $(this).attr("data-AssignAnsAssignID"))[0].is_compliants = is_compliants = ($(this).attr("data-AssignAnsComments")?true:false);
//                 }
//             }
//         }
//     });
//     arr_assignments.shift();
//     console.log(arr_assignments);
//     return arr_assignments;
// }


//#endregion