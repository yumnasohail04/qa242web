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
.morris-donut-wrapper-demo
{
cursor:pointer;}
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
<main>
  <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <h1>Dashboard</h1>
              <div class="separator mb-5"></div>
          </div>
      </div>

      <div class="row mb-4">
          <div class="col-12 mb-4">
              <div class="card">
                  <div class="card-body">
        <section>
            <div class="content-wrapper" style="padding-bottom: 0px !important;">
                <div class="content-heading" style="margin-bottom: 0px !important;">
                    <small data-localize="dashboard.WELCOME"></small>
                </div>
            </div>
        </section>
        <section>
            <div class="content-wrapper">
                 <div class="card-body pb-0">
                 		<p style="text-align: center;">Supplier Scorecard</p>
                        <div class="row ">
                            <div class="col-sm-12 col-lg-2">
                                 <div id="morrisDonut1" class="morris-donut-wrapper-demo" style="height:150px; "></div>
                             </div>
                            <div class="col-sm-12 col-lg-2">
                                <div id="morrisDonut2" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div id="morrisDonut3" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                            </div>
                           <div class="col-sm-12 col-lg-2">
                                <div id="morrisDonut4" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div id="morrisDonut5" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div id="morrisDonut6" class="morris-donut-wrapper-demo" style="height:150px;"></div>
                            </div>
                        </div>
                    
            </div>   
        </section>
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
<script src="<?php echo STATIC_ADMIN_JS?>jquery.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>ionicons.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>raphael.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>morris.min.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>chart.morris.js?v=5"></script>
 <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

<script src="<?php echo STATIC_ADMIN_JS?>widgets.js"></script>
<script src="<?php echo STATIC_ADMIN_JS?>controller.js"></script>


<script type="text/javascript">

$(document).ready(function() {
        var  start="";
        var  end="";
        func_load_dt(start,end);
       
    });

    function func_load_dt(start,end){
        $.ajax({
            type: "POST",
            url: "<?=ADMIN_BASE_URL.'dashboard/dashboard_scorecard_list'?>",
            data:{'start':start,'end':end},
            success: function (data) {
              $('#div_tblreport').html(data);
				 $('table').dataTable({
       				 'bFilter': false,
        			 'bInfo': false,
       				 'bLengthChange': false,
       				 'bPaginate': false
    			});
            }
         });
    }
var data=<?php echo json_encode($morris_one)?>;
  new Morris.Donut({
    element: 'morrisDonut1',
    data:data,
    colors: ['#D14F57','#717373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==0)
        {
            // $.ajax({
            //     type: "POST",
            //     url: "<?=ADMIN_BASE_URL.'dashboard/get_scorecard_list'?>",
            //     data:{'start_range':'0','end_range':'50'},
            //     success: function (data) {
            //         var test_desc = data;
            //         $('#myModalLarge').modal('show')
            //         $("#myModalLarge .modal-body").html(test_desc);
            //     }
            // });
        func_load_dt('0','50');
        }
    });
var data=<?php echo json_encode($morris_two)?>;
  new Morris.Donut({
    element: 'morrisDonut2',
    data:data,
    colors: ['#EF9738','#717373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==0)
        {
            // $.ajax({
            //     type: "POST",
            //     url: "<?=ADMIN_BASE_URL.'dashboard/get_scorecard_list'?>",
            //     data:{'start_range':'51','end_range':'75'},
            //     success: function (data) {
            //         var test_desc = data;
            //         $('#myModalLarge').modal('show')
            //         $("#myModalLarge .modal-body").html(test_desc);
            //     }
            // });
        func_load_dt('51','75');
        }
    });
  var data=<?php echo json_encode($morris_three)?>;
    new Morris.Donut({
    element: 'morrisDonut3',
    data:data,
    colors: ['#5D89A8','#717373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==0)
        {
            // $.ajax({
            //     type: "POST",
            //     url: "<?=ADMIN_BASE_URL.'dashboard/get_scorecard_list'?>",
            //     data:{'start_range':'76','end_range':'89'},
            //     success: function (data) {
            //         var test_desc = data;
            //         $('#myModalLarge').modal('show')
            //         $("#myModalLarge .modal-body").html(test_desc);
            //     }
            // });
        func_load_dt('76','89');
        }
    });
  var data=<?php echo json_encode($morris_four)?>;
    new Morris.Donut({
    element: 'morrisDonut4',
    data:data,
    colors: ['#4CB581', '#717373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==0)
        {
            // $.ajax({
            //     type: "POST",
            //     url: "<?=ADMIN_BASE_URL.'dashboard/get_scorecard_list'?>",
            //     data:{'start_range':'90','end_range':'99'},
            //     success: function (data) {
            //         var test_desc = data;
            //         $('#myModalLarge').modal('show')
            //         $("#myModalLarge .modal-body").html(test_desc);
            //     }
            // });
        	func_load_dt('90','');
        }
    });
    var data=<?php echo json_encode($morris_five)?>;
    new Morris.Donut({
    element: 'morrisDonut5',
    data:data,
    colors: ['#750000', '#717373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==0)
        {
            $.ajax({
            type: "POST",
            url: "<?=ADMIN_BASE_URL.'dashboard/dashboard_audit_list'?>",
            data:{'audit':'1'},
            success: function (data) {
              $('#div_tblreport').html(data);
				 $('table').dataTable({
       				 'bFilter': false,
        			 'bInfo': false,
       				 'bLengthChange': false,
       				 'bPaginate': false
    			});
            }
         });
        }
    });
    var data=<?php echo json_encode($morris_six)?>;
    new Morris.Donut({
    element: 'morrisDonut6',
    data:data,
    colors: ['#000000', '#717373'],
    resize: true
  }).on('click', function (i, row) {  
        if(i==0)
        {

            $.ajax({
            type: "POST",
            url: "<?=ADMIN_BASE_URL.'dashboard/dashboard_audit_list'?>",
            data:{'audit':'0'},
            success: function (data) {
              $('#div_tblreport').html(data);
				 $('table').dataTable({
       				 'bFilter': false,
        			 'bInfo': false,
       				 'bLengthChange': false,
       				 'bPaginate': false
    			});
            }
         });
        }
    });

//   $("[id^='morrisDonut1'] svg").on('mouseover', function() {
//     var md1_previous = $("[id^='morrisDonut1'] text:last-child").find('tspan').text();
//     var md1_new = md1_previous.replace('%', '');
//     $( "[id^='morrisDonut1'] text:last-child" ).find('tspan').text(md1_new+"%");
//   });

//   $("[id^='morrisDonut2'] svg").on('mouseover', function() {
//     var md2_previous = $("[id^='morrisDonut2'] text:last-child").find('tspan').text();
//     var md2_new = md2_previous.replace('%', '');
//     $( "[id^='morrisDonut2'] text:last-child" ).find('tspan').text(md2_new+"%");
//   });

//   $("[id^='morrisDonut3'] svg").on('mouseover', function() {
//     var md3_previous = $("[id^='morrisDonut3'] text:last-child").find('tspan').text();
//     var md3_new = md3_previous.replace('%', '');
//     $( "[id^='morrisDonut3'] text:last-child" ).find('tspan').text(md3_new+"%");
//   });

//   $("[id^='morrisDonut4'] svg").on('mouseover', function() {
//     var md4_previous = $("[id^='morrisDonut4'] text:last-child").find('tspan').text();
//     var md4_new = md4_previous.replace('%', '');
//     $( "[id^='morrisDonut4'] text:last-child" ).find('tspan').text(md4_new+"%");
//   });

//   var d1_previous = $("[id^='morrisDonut1'] text:last-child").find('tspan').text();
//   var d1_new = d1_previous.replace('%', '');
//   $( "[id^='morrisDonut1'] text:last-child" ).find('tspan').text(d1_new+"%");

//   var d2_previous = $("[id^='morrisDonut2'] text:last-child").find('tspan').text();
//   var d2_new = d2_previous.replace('%', '');
//   $( "[id^='morrisDonut2'] text:last-child" ).find('tspan').text(d2_new+"%");

//   var d3_previous = $("[id^='morrisDonut3'] text:last-child").find('tspan').text();
//   var d3_new = d3_previous.replace('%', '');
//   $( "[id^='morrisDonut3'] text:last-child" ).find('tspan').text(d3_new+"%");

//   var d4_previous = $("[id^='morrisDonut4'] text:last-child").find('tspan').text();
//   var d4_new = d4_previous.replace('%', '');
//   $( "[id^='morrisDonut4'] text:last-child" ).find('tspan').text(d4_new+"%");

    $(document).on("click", ".total_records", function (event) {
        event.preventDefault();
        func_load_dt('','');
    });

</script>

<script>
      $(document).on("click", ".view_details", function (event) {
        event.preventDefault();
        var id = $(this).attr('rel');
        $.ajax({
            type: 'POST',
            url:"<?php echo ADMIN_BASE_URL?>scorecard/detail",
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

      $(document).on("click", ".ingredients_detail", function (event) {
        event.preventDefault();
        var id = $(this).attr('rel');
        $.ajax({
            type: 'POST',
            url:"<?php echo ADMIN_BASE_URL?>dashboard/ingredient_detail",
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