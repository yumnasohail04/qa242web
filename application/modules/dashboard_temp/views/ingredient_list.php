<div class="panel panel-default">
<div class="panel-body">
<input type="hidden" value="datatable1">
<select id="ddl_tbl_show_row_count" onchange="func_set_tbl_rows(this.value)">
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <option value="-1">All</option>
</select>

<div class="table-responsive">
    <table class="table table-striped table-hover table-body table-bordered" id="tblReportData1">
        <thead style="background-color: #7BABED;" class="bg-th">
          <tr class="bg-col">
            <th data-htmltoarray="true" data-arrayclassth="name">Ingredient Name<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="number">Ingredient Number<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="role">Role<i class="fa fa-sort" style="font-size:13px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php  $count_row = 0; if(!empty($list)){
                foreach($list as $row){ $count_row++;?>
          <?php if($count_row>10){ ?>
                <tr style="display: none">
            <?php }
            else {?>
                <tr>
            <?php } ?>
            <td data-htmltoarray="true" data-arrayclasstd="name"><?=$row['item_name']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="number"><?=$row['item_no']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="role"><?=$row['role']?></td>
        </tr>
        <?}}else {?>  <tr>
           <td></td>
            <td>
                <h4>No Record Found</h4>
            </td>
            <td></td>
        </tr> <?php }?>

        </tbody>
    </table>
</div>
</div>
<div>
<script>
    tbl_id_name = "tblReportData1";
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
        $("#tblReportData1 tr").each(function (i){
           $(this).css("display",((i<=p_count || p_count==-1)?"":"none"))
        });
    }

</script>