<?php
if(!empty($Mode)){
    $Mode = $Mode;
}
if(!empty($arr_orignal)) {
    $arr_assignments = array_unique(array_map(function ($i) {return $i['assign_id']; }, $arr_orignal));
    $arr_questions = array_unique(array_map(function ($i) { return $i['question_id']; }, $arr_orignal));

    //print_r($arr_orignal);echo "<br><br><br>";
    //print_r($arr_assignments);echo "<br><br><br>";
    //print_r($arr_questions);echo "<br><br><br>";
}
$count_row = 0;
?>
<!--
<button class="btn btn-info" onclick="exportTableToExcel('tblReportData', 'Assignment Report')">Export </button>-->
<input type="hidden" value="tblReportData">
<select id="ddl_tbl_show_row_count" onchange="func_set_tbl_rows(this.value)">
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="20">20</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <option value="-1">All</option>
</select>
<button class="btn btn-info" onclick="export_to_CSV('Assignment Report')">Export to CSV </button>
<div class="table-responsive">
    <table class="table" id="tblReportData">
        <thead style="background-color: #7BABED;">
        <tr>
            <th data-htmltoarray="true" data-arrayclassth="assign_id">Record #</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_date">Date</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_time">Time</th>
            <th style="display: none" data-htmltoarray="true" data-arrayclassth="assign_day">Day</th>
            <th style="display: none" data-htmltoarray="true" data-arrayclassth="assign_month">Month</th>
            <th style="display: none" data-htmltoarray="true" data-arrayclassth="assign_year">Year</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_shift">Shift</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_plant">Site</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_line">Line</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_user">User</th>
            <th data-htmltoarray="true" data-arrayclassth="result_status">Status</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_checkname">Checks</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_product_title">Products</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_program_types">Process Groups</th>
            <th style="display: none;" data-htmltoarray="true" data-arrayclassth="assign_inspection_team">Inspection Team</th>
            <th style="display: none;" data-htmltoarray="true" data-arrayclassth="assign_review_team">Review Team</th>
            <th style="display: none;" data-htmltoarray="true" data-arrayclassth="assign_approval_team">Approval Team</th>
            <th style="display: none;" data-htmltoarray="true" data-arrayclassth="assign_dashboard_circle_id">Dashboard circle </th>
<!--            <th data-htmltoarray="true" data-arrayclassth="assign_given_answer">Given Answer</th>-->
<!--            <th data-htmltoarray="true" data-arrayclassth="assign_comments">Comments</th>-->

            <?php if(!isset($arr_questions) || empty($arr_questions)) $arr_questions = array();
            foreach ($arr_questions as $key => $item) {
                if($Mode == 1) {
                ?><th style="display: none"><?php } else { ?><th><?php }?><?= $arr_orignal[$key]['question'] ?></th>
                <?php }?>

        </tr>
        </thead>
        <tbody>
        <?php 
        if(isset($arr_assignments) && !empty($arr_assignments)) {
        foreach ($arr_assignments as $key_assignment => $item_assignment) { $count_row++; ?>
            <?php if($Mode == 1 && $count_row>10){ ?>
                <tr style="display: none">
            <?php }
            else {?>
                <tr>
            <?php } ?>
            <td data-htmltoarray="true" >
                <a data-arrayclasstd="assign_id" class="btn c-btn view_details" style="color: #A4D014;" unique_url="<?= $arr_orignal[$key_assignment]['unique_url'] ?>" rel="<?= $arr_orignal[$key_assignment]['assign_id'] ?>"><?= $arr_orignal[$key_assignment]['assign_id'] ?></a></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_date"><?= date("Y-m-j", strtotime($arr_orignal[$key_assignment]['Date']))  ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_time"><?= $arr_orignal[$key_assignment]['Time'] ?></td>
            <td style="display: none" data-htmltoarray="true" data-arrayclasstd="assign_day"><?= date_format(date_create($arr_orignal[$key_assignment]['Date']), "l") ?></td>
            <td style="display: none" data-htmltoarray="true" data-arrayclasstd="assign_month"><?= date_format(date_create($arr_orignal[$key_assignment]['Date']), "M") ?></td>
            <td style="display: none" data-htmltoarray="true" data-arrayclasstd="assign_year"><?= date_format(date_create($arr_orignal[$key_assignment]['Date']), "yy") ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_shift"><?= $arr_orignal[$key_assignment]['Shift'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_plant"><?= $arr_orignal[$key_assignment]['Plant'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_line"><?= $arr_orignal[$key_assignment]['Line'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_user"><?= $arr_orignal[$key_assignment]['User'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="result_status"><?= $arr_orignal[$key_assignment]['Status'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_checkname"><?= $arr_orignal[$key_assignment]['checkname'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_product_title"><?= $arr_orignal[$key_assignment]['product_title'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_program_types"><?= $arr_orignal[$key_assignment]['Program Types'] ?></td>
            <td style="display: none;" data-htmltoarray="true" data-arrayclasstd="assign_inspection_team"><?= $arr_orignal[$key_assignment]['inspection_team'] ?></td>
            <td style="display: none;" data-htmltoarray="true" data-arrayclasstd="assign_review_team"><?= $arr_orignal[$key_assignment]['review_team'] ?></td>
            <td style="display: none;" data-htmltoarray="true" data-arrayclasstd="assign_approval_team"><?= $arr_orignal[$key_assignment]['approval_team'] ?></td>
            <td style="display: none;" data-htmltoarray="true" data-arrayclasstd="assign_dashboard_circle_id"><?= $arr_orignal[$key_assignment]['dashboard_circle_id'] ?></td>
<!--            <td data-htmltoarray="true" data-arrayclasstd="assign_given_answer">--><?//= $arr_orignal[$key_assignment]['given_answer'] ?><!--</td>-->
<!--            <td data-htmltoarray="true" data-arrayclasstd="assign_comments">--><?//= $arr_orignal[$key_assignment]['comments'] ?><!--</td>-->

        <?php $count_answer = 0;
            foreach ($arr_questions as $key_question => $item_question) {
                $count_answer++;
                if($Mode == 1) {
                 ?><td data-AssignAnsId="<?= $arr_orignal[$key_question]['assign_ans_id'] ?>"
                          data-AssignAnsDate="<?= $arr_orignal[$key_assignment]['Date'] ?>"
                          data-AssignAnsDay="<?= date_format(date_create($arr_orignal[$key_assignment]['Date']), "l") ?>"
                          data-AssignAnsUser="<?= $arr_orignal[$key_assignment]['User'] ?>"
                          data-AssignAnsComments="<?= $arr_orignal[$key_question]['comments'] ?>"
                          data-AssignAnsCheck="<?= $arr_orignal[$key_assignment]['checkname'] ?>"
                          data-AssignAnsAssignID="<?= $arr_orignal[$key_assignment]['assign_id'] ?>"
                          data-AssignAnsGivenAnswer="<?= $arr_orignal[$key_question]['given_answer'] ?>"
                          style="display: none"
                    ><?php } else { ?>
                <td data-AssignAnsId="<?= $arr_orignal[$key_question]['assign_ans_id'] ?>"
                    data-AssignAnsDate="<?= $arr_orignal[$key_assignment]['Date'] ?>"
                    data-AssignAnsDay="<?= date_format(date_create($arr_orignal[$key_assignment]['Date']), "l") ?>"
                    data-AssignAnsUser="<?= $arr_orignal[$key_assignment]['User'] ?>"
                    data-AssignAnsComments="<?= $arr_orignal[$key_question]['comments'] ?>"
                    data-AssignAnsCheck="<?= $arr_orignal[$key_assignment]['checkname'] ?>"
                    data-AssignAnsAssignID="<?= $arr_orignal[$key_assignment]['assign_id'] ?>"
                    data-AssignAnsGivenAnswer="<?= $arr_orignal[$key_question]['given_answer'] ?>"
                ><?php }?><?= $arr_orignal[$key_question]['Answer'] ?></td>
            <?php }?>

        </tr>
        <?php } } ?>
        </tbody>
    </table>
</div>

<script>
    tbl_id_name = "tblReportData";
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
        $("#tblReportData tr").each(function (i){
           $(this).css("display",((i<=p_count || p_count==-1)?"":"none"))
        });
    }

</script>