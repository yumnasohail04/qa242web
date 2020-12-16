<?php // print_r($query); exit(); ?>
<table id="datatable1" class="table" >
    <thead class="bg-th">
        <tr>
            <th class="table-checkbox" width="5%">S.No</th>
            <th >Title</th>
            <!-- <th width="10%" >Image </th>-->                              
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        if (isset($temp_arr)) {
            
            foreach ($temp_arr as
                $row) {
                $i++;
          
            ?>
            <tr id="Row_<?= $row->id ?>" class="odd gradeX">
                <td class="table-checkbox"><?php echo $i; ?></td>
                <td> <?php echo $row['cat_name']; ?>       </td>

               
                                    </tr>
                                    <?php } ?>    
                                    <?php } ?>
                                </tbody>
                            </table>