<div class="panel panel-default">
<div class="panel-body">
<input type="hidden" value="">


<div class="table-responsive">
    <table class="data-table data-table-feature" >
        <thead  class="bg-th">
          <tr class="bg-col">
            <th data-htmltoarray="true" data-arrayclassth="assign_id">Check<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="assign_date">Date<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="assign_time">Time<i class="fa fa-sort" style="font-size:13px;"></th>
            <th style="display: none" data-htmltoarray="true" data-arrayclassth="assign_day">Day<i class="fa fa-sort" style="font-size:13px;"></th>
            <th style="display: none" data-htmltoarray="true" data-arrayclassth="assign_month">Month<i class="fa fa-sort" style="font-size:13px;"></th>
            <th style="display: none" data-htmltoarray="true" data-arrayclassth="assign_year">Year<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="assign_shift">Shift<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="assign_plant">Site<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="assign_line">Line<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="result_status">Status<i class="fa fa-sort" style="font-size:13px;"></th>
            <th data-htmltoarray="true" data-arrayclassth="assign_product_title">Products<i class="fa fa-sort" style="font-size:13px;"></th>
          </tr>
        </thead>
        <tbody>
            <?php  $count_row = 0; if(!empty($final_array)){
                foreach($final_array as $row){ $count_row++;?>
          <?php if($count_row>10){ ?>
                <tr style="display: none">
            <?php }
            else {?>
                <tr>
            <?php } ?>
            <td data-htmltoarray="true" >
                <a data-arrayclasstd="assign_id" class="btn c-btn view_details"  rel="<?= $row['assign_id'] ?>"  static="<?= $row['is_static'] ?>" ><?= $row['checkname'] ?></a>
                </td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_date"><?=date('m-d-Y',strtotime($row['approval_datetime']))?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_time"><?=date('h:i',strtotime($row['approval_datetime']))?></td>
            <td style="display: none" data-htmltoarray="true" data-arrayclasstd="assign_day"><?= date_format(date_create($row['approval_datetime']), "l") ?></td>
            <td style="display: none" data-htmltoarray="true" data-arrayclasstd="assign_month"><?= date_format(date_create($row['approval_datetime']), "M") ?></td>
            <td style="display: none" data-htmltoarray="true" data-arrayclasstd="assign_year"><?= date_format(date_create($row['approval_datetime']), "yy") ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_shift"><?=$row['shift_no']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_plant"><?=$row['plant_name']?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_line">
                <?php   $line = Modules::run('api/_get_specific_table_with_pagination',array("line_id"=>$row['line_no']),'line_id desc',DEFAULT_OUTLET."_lines",'line_name','1','1')->row_array();
                        echo $line['line_name']; ?> </td>
            <td data-htmltoarray="true" data-arrayclasstd="result_status"><?= $row['Status'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_product_title"><?php if(isset($row['product_title']) && !empty($row['product_title'])) echo $row['product_title']; ?></td>
        </tr>
        <?}}else {?>  <tr>
           <td></td>
            <td></td>
            <td></td>
        	<td style="display: none"></td>
        	<td style="display: none"></td>
            <td>
                <h4>No Record Found</h4>
            </td>
        	<td style="display: none"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr> <?php }?>

        </tbody>
    </table>
</div>
</div>
<div>
<script>
    // tbl_id_name = "datatable1";
    // function download_csv(csv, filename) {
    //     let csvFile;
    //     let downloadLink;

    //     // CSV FILE
    //     csvFile = new Blob([csv], {type: "text/csv"});

    //     // Download link
    //     downloadLink = document.createElement("a");

    //     // File name
    //     downloadLink.download = filename;

    //     // We have to create a link to the file
    //     downloadLink.href = window.URL.createObjectURL(csvFile);

    //     // Make sure that the link is not displayed
    //     downloadLink.style.display = "none";

    //     // Add the link to your DOM
    //     document.body.appendChild(downloadLink);

    //     // Lanzamos
    //     downloadLink.click();
    // }

    // function export_table_to_csv(html, filename) {
    //     var csv = [];
    //     var rows = document.querySelectorAll("#"+tbl_id_name+" tr");

    //     for (var i = 0; i < rows.length; i++) {
    //         var row = [], cols = rows[i].querySelectorAll("td, th");

    //         for (var j = 0; j < cols.length; j++)
    //             row.push(cols[j].innerText.replace(',',' '));

    //         csv.push(row.join(","));
    //     }

    //     // Download CSV
    //     download_csv(csv.join("\n"), filename);
    // }

    // function export_to_CSV(filename) {
    //     var html = document.querySelector("#"+tbl_id_name).outerHTML;
    //     export_table_to_csv(html, filename + ".csv");
    // }

    // function func_set_tbl_rows(p_count){
    //     $("#datatable1 tr").each(function (i){
    //        $(this).css("display",((i<=p_count || p_count==-1)?"":"none"))
    //     });
    // }

</script>