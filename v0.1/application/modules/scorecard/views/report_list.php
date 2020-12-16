<style>
table.dataTable.no-footer {
     border-bottom: none; 
}
</style>
<div class=" panel-default">
<div class="panel-body">
<input type="hidden" value="datatable1">


<div class="table-responsive">
    <table class="data-table data-table-feature" id="datatable1">
        <thead  class="bg-th">
          <tr class="bg-col">
            <th style="border:none;">Supplier</th>
            <th style="border:none;">Completed on </th>
            <th style="border:none;">Total Points</th>
            <th style="border:none;" class="" style="width:300px;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
          </tr>
        </thead>
        <tbody>
            <?php  $count_row = 0; if(!empty($card_list)){
                foreach($card_list as $row){ $count_row++;?>
          <?php if($count_row>10){ ?>
                <tr style="display: none">
            <?php }
            else {?>
                <tr>
            <?php } ?>
            <td data-htmltoarray="true" data-arrayclasstd="assign_date"><?=$row['name']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_time"><?=$row['at_reviewed_date']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_day"><?= round($row['total_percentage'], 2);?>%</td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_day"><a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="iconsminds-file"  title="See Detail"></i></a></td>
        </tr>
        <?}}else {?>  <tr>
            <td></td>
            <td>
                <h4>No Record Found</h4>
            </td>
            <td></td>
            <td></td>
        </tr> <?php }?>
        </tbody>
    </table>
</div>
<!--<div style="padding: 30px;" class=" col-sm-12 col-md-12 ht-200 ht-lg-250"><canvas id="chartBar1" style="height: 275px;"></canvas></div>-->
<div style="padding: 30px;height:300px;" class=" col-sm-12 col-md-6 ht-200 ht-lg-250"><canvas id="chartLine1"></canvas></div>

</div>
<div>
<script>
   /*     
        $(function(){
        'use strict';
        var date= <?php echo   json_encode($graph_date)?>;
        var points= <?php echo json_encode($graph_points) ?>;
        if(points!=''){
        var ctx1 = document.getElementById('chartBar1').getContext('2d');
        new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: date,
            datasets: [{
              label: 'points%',
              data: points ,
              backgroundColor: '#F7D16E'
            }]
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            barSize: 1,
            legend: {
              display: false,
                labels: {
                  display: false
                }
            },
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  fontSize: 10,
                  max: 100
                }
              }],
              xAxes: [{
                barPercentage: 0.1,
                ticks: {
                  beginAtZero:true,
                  fontSize: 11
                }
              }]
            }
          }
        });
        }
      });
      */
    tbl_id_name = "datatable1";
    function download_csv(csv, filename) {
        let csvFile;
        let downloadLink;

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

    function export_table_to_csv(html, filename) {
        var csv = [];
        var rows = document.querySelectorAll("#"+tbl_id_name+" tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++)
                row.push(cols[j].innerText.replace(',',' '));

            csv.push(row.join(","));
        }

        // Download CSV
        download_csv(csv.join("\n"), filename);
    }

    function export_to_CSV(filename) {
        var html = document.querySelector("#"+tbl_id_name).outerHTML;
        export_table_to_csv(html, filename + ".csv");
    }

    function func_set_tbl_rows(p_count){
        $("#datatable1 tr").each(function (i){
           $(this).css("display",((i<=p_count || p_count==-1)?"":"none"))
        });
    }
    $(document).ready(function(){
            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
              $.ajax({
                    type: 'POST',
                    url: "<?php echo ADMIN_BASE_URL?>scorecard/detail",
                    data: {'id': id},
                    async: false,
                    success: function(test_body) {
                    var test_desc = test_body;
                     $('#myModallarge1').modal('show');
                     $("#myModallarge1 .modal-body").html(test_desc);
                    }
                });
            });


});

var date= <?php echo   json_encode($graph_date)?>;
var points= <?php echo json_encode($graph_points) ?>;
if(points!=''){
  var ctx8 = document.getElementById('chartLine1');
  new Chart(ctx8, {
    type: 'line',
    data: {
      labels: date,
      datasets: [{
        data: points,
        borderColor: '#f10075',
        borderWidth: 1,
        fill: false
      }]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false,
          labels: {
            display: false
          }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 10,
            max: 100
          }
        }],
        xAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 11
          }
        }]
      }
    }
  });
}
</script>
