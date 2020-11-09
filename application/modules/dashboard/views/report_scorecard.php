<style>
.table-responsive{
	overflow-x: hidden;
}
.total_records
{
	cursor:pointer;
}
</style>
<input type="hidden" value="tblReportData">

<select id="ddl_tbl_show_row_count" onchange="set_tbl_rows(this.value)">
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <option value="-1">All</option>
</select>
<span class="total_records">Total</span>
<div class="table-responsive">
    <table class="" id="tblReportData1" >
        <thead>
        <tr>
            <th data-htmltoarray="true" data-arrayclassth="supplier"><i class="fa fa-sort" style="font-size:13px;"></i>Supplier</th>
            <th data-htmltoarray="true" data-arrayclassth="completed_on"><i class="fa fa-sort" style="font-size:13px;"></i>Completed on</th>
            <th data-htmltoarray="true" data-arrayclassth="total_points"><i class="fa fa-sort" style="font-size:13px;"></i>Total Points</th>
        	<th data-htmltoarray="true" >Ingredients</th>
        
        </tr>
        </thead>
        <tbody>
            <?php  $count_row = 0; if(!empty($card_list)){
                foreach($card_list as $row){ $count_row++;?>
          <?php if($count_row>5){ ?>
                <tr style="display: none;">
            <?php }
            else {?>
                <tr>
            <?php } ?>
            <td data-htmltoarray="true" style="cursor:pointer;" class="view_details color-theme-2 " rel="<?= $row['id'] ?>"  data-arrayclasstd="supplier"><?=$row['name']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="completed_on"><?=$row['at_reviewed_date']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="total_points"><?=number_format((float)$row['total_percentage'], 2, '.', '').'%'?></td>
            <td><a class="btn yellow c-btn ingredients_detail" rel="<?=$row['supplier_id']?>"><i class="iconsminds-file"  title="See ingredients"></i></a></td>
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

    function set_tbl_rows(p_count){
        $("#tblReportData1 tr").each(function (i){
           $(this).css("display",((i<=p_count || p_count==-1)?"":"none"))
        });
    }

</script>