<button style="    width: 100px;
    margin-bottom: 2%;" type="button" onclick="export_to_CSV('Supplier Report')" class="btn btn-outline-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Export file</button>
<?php 


if(!empty($result)){ ?>
    <input type="hidden" value="tblReportData">
<table class="data-table data-table-feature" id="tblReportData">
    <thead class="bg-th">
        <tr class="bg-col">
            <th>Supplier# </th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>State</th>
            <th>Country</th>
            <th>Role</th>
            <th>Supplier Item Name</th>
            <th>Supplier Item Number</th>
            <th>Ingredient Number</th>
            <th>Ingredient Name</th>
            <th>Ingredient PLM#</th>
            <th>Ingredient Type</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($result as $key => $value): ?>
        <tr>
            <td><?php echo $value['supplier_no']; ?></td>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['email']; ?></td>
            <td><?php echo $value['phone_no']; ?></td>
            <td><?php echo $value['city']; ?></td>
            <td><?php echo $value['state']; ?></td>
            <td><?php echo $value['country']; ?></td>
            <td><?php echo $value['role']; ?></td>
            <td><?php echo $value['s_item_name']; ?></td>
            <td><?php echo $value['s_item_no']; ?></td>
            <td><?php echo $value['item_no']; ?></td>
            <td><?php echo $value['item_name']; ?></td>
            <td><?php echo $value['plm_no']; ?></td>
            <td><?php echo $value['type_name']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php }else{
    echo "No Result Found!";
} ?>

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


    </script>