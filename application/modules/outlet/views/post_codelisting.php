<table id="datatable2" class="table table-striped table-hover">
    <thead class="bg-th">
    <tr>
    <th width='2%'>S.No</th>
    <th width="40%">Post Code </th>
    <th width="40%">Delivery Cost</th>
    <th class="table_action">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i = 0;
    if (isset($arr_postcode)) {
    foreach ($arr_postcode as $row) {
    $i++;
    $edit_url = ADMIN_BASE_URL . 'outlet/create/' . $row['id'];                           
    ?>
    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
    <td width="2%"><?php echo $i;?></td>
    <td width="20%"><?php echo $row['post_code']?></td>
    <td width="20%"> <input type="text" class="txtdelivery_charges form-control" rel ="<?=$row['id']?>" value="<?=$row['delivery_charges']?>" > </td>
    <td class="table_action">
    <?php
	echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_postocde btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete Post Code'));                    
    ?>
    </td>
    </tr>
    <?php 
    }
    ?>
    <?php } ?>
    </tbody>
</table>