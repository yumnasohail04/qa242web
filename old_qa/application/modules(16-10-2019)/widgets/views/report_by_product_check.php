<?php

if(!empty($arr_orignal)) {
    $arr_assignments = array_unique(array_map(function ($i) {return $i['assign_id']; }, $arr_orignal));
    $arr_questions = array_unique(array_map(function ($i) { return $i['question_id']; }, $arr_orignal));

    //print_r($arr_orignal);echo "<br><br><br>";
    //print_r($arr_assignments);echo "<br><br><br>";
    //print_r($arr_questions);echo "<br><br><br>";
}
?>
<!--
<button class="btn btn-info" onclick="exportTableToExcel('tblReportData', 'Assignment Report')">Export </button>-->
<input type="hidden" value="tblReportData">
<button class="btn btn-info" onclick="export_to_CSV('Assignment Report')">Export to CSV </button>
<div class="table-responsive">
    <table class="table" id="tblReportData">
        <thead style="background-color: grey;">
        <tr>
            <th data-htmltoarray="true" data-arrayclassth="assign_id">Assignment ID</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_date">Date</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_time">Time</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_shift">Shift</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_line">Line</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_user">User</th>
            <th data-htmltoarray="true" data-arrayclassth="result_status">Status</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_checkname">Checks</th>
            <th data-htmltoarray="true" data-arrayclassth="assign_product_title">Products</th>

<!--            <th data-htmltoarray="true" data-arrayclassth="assign_given_answer">Given Answer</th>-->
<!--            <th data-htmltoarray="true" data-arrayclassth="assign_comments">Comments</th>-->

            <?php foreach ($arr_questions as $key => $item) { ?>
            <th><?= $arr_orignal[$key]['question'] ?></th>
            <?php } ?>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($arr_assignments as $key_assignment => $item_assignment) { ?>
        <tr>
            <td data-htmltoarray="true" data-arrayclasstd="assign_id"><?= $arr_orignal[$key_assignment]['assign_id'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_date"><?= $arr_orignal[$key_assignment]['Date'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_time"><?= $arr_orignal[$key_assignment]['Time'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_shift"><?= $arr_orignal[$key_assignment]['Shift'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_line"><?= $arr_orignal[$key_assignment]['Line'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_user"><?= $arr_orignal[$key_assignment]['User'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="result_status"><?= $arr_orignal[$key_assignment]['Status'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_checkname"><?= $arr_orignal[$key_assignment]['checkname'] ?></td>
            <td data-htmltoarray="true" data-arrayclasstd="assign_product_title"><?= $arr_orignal[$key_assignment]['product_title'] ?></td>

<!--            <td data-htmltoarray="true" data-arrayclasstd="assign_given_answer">--><?//= $arr_orignal[$key_assignment]['given_answer'] ?><!--</td>-->
<!--            <td data-htmltoarray="true" data-arrayclasstd="assign_comments">--><?//= $arr_orignal[$key_assignment]['comments'] ?><!--</td>-->

        <?php $count_answer = 0;
        foreach ($arr_questions as $key_question => $item_question) { $count_answer++; ?>
            <td data-AssignAnsId="<?= $arr_orignal[$key_question]['assign_ans_id'] ?>"
                data-AssignAnsDate="<?= date_format(date_create($arr_orignal[$key_assignment]['Date']),"l Y/m/d ") ?>"
                data-AssignAnsUser="<?= $arr_orignal[$key_assignment]['User'] ?>"
                data-AssignAnsComments="<?= $arr_orignal[$key_question]['comments'] ?>"
                data-AssignAnsCheck="<?= $arr_orignal[$key_assignment]['checkname'] ?>"
                data-AssignAnsAssignID="<?= $arr_orignal[$key_assignment]['assign_id'] ?>"
                data-AssignAnsGivenAnswer="<?= $arr_orignal[$key_question]['given_answer'] ?>"
            ><?= $arr_orignal[$key_question]['Answer'] ?></td>
        <?php } ?>

        </tr>
        <?php } ?>
        </tbody>
    </table>


</div>

<script>
    tbl_id_name = "tblResultData";
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
                row.push(cols[j].innerText);

            csv.push(row.join(","));
        }

        // Download CSV
        download_csv(csv.join("\n"), filename);
    }

    function export_to_CSV(filename) {
        var html = document.querySelector("#"+tbl_id_name).outerHTML;
        export_table_to_csv(html, filename + ".csv");
    }
</script>