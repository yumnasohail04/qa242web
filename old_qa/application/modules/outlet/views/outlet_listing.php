<table id="datatable1" class="table table-striped table-hover">
    <thead class="bg-th">
        <tr>
            <th width='2%'>S.No</th>
            <th width="20%"> Name</th>
            <th width="20%">Address</th>
            <th width="5%">City</th>
            <th width="50px">Phone</th>
            <th class="table_action">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        if (isset($outlet)) {
            foreach ($outlet as $row) {
                $i++;
                $edit_url = ADMIN_BASE_URL . 'outlet/create/' . $row['id'];
                ?>
                <tr id="Row_<?= $row['id'] ?>" class="odd gradeX">
                    <td width="2%"><?php echo $i; ?></td>
                    <td width="20%"><?php echo $row['name'] ?></td>
                    <td width="20%"><?php echo $row['address'] ?></td>
                    <td width="5%"><?php echo $row['city'] ?></td>
                    <td width="50px"><?php echo $row['phone'] ?></td>
                    <td class="table_action">
                        <a class="btn yellow c-btn view_details" rel="<?= $row['id'] ?>"><i class="fa fa-list"  title="See Detail"></i></a>
                            <?php
                            echo anchor('"javascript:;"', '<i class="fa fa-plus"></i>', array('class' => 'post_code_delivery btn red c-btn', 'rel' => $row['id'], 'title' => 'Add post code for delivery'));

                            $merchant_class = ' merchant_live_action';
                            $merchant_title = 'Set to test merchant';
                            $m_icon = '<i class="fa fa-arrow-up"></i>';
                            $m_iconbgclass = ' btn green c-btn';
                            if ($row['is_live'] != 1) {
                                $merchant_class = ' merchant_test_action';
                                $merchant_title = 'Set to live merchant';
                                $m_icon = '<i class="fa fa-arrow-down"></i>';
                                $m_iconbgclass = ' btn default c-btn';
                            }
                            echo anchor("javascript:;", $m_icon, array('class' => 'change_live_status' . $merchant_class . $m_iconbgclass,
                                'title' => $merchant_title, 'rel' => $row['id'], 'id' => $row['id'], 'status' => $row['is_live']));

                            $publish_class = ' table_action_publish';
                            $publis_title = 'Set Un-Publish';
                            $icon = '<i class="fa fa-long-arrow-up"></i>';
                            $iconbgclass = ' btn green c-btn';
                            if ($row['status'] != 1) {
                                $publish_class = ' table_action_unpublish';
                                $publis_title = 'Set Publish';
                                $icon = '<i class="fa fa-long-arrow-down"></i>';
                                $iconbgclass = ' btn default c-btn';
                            }
                            echo anchor("javascript:;", $icon, array('class' => 'action_publish' . $publish_class . $iconbgclass,
                                'title' => $publis_title, 'rel' => $row['id'], 'id' => $row['id'], 'status' => $row['status']));

                            echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'title' => 'Edit Outlet'));
                            echo anchor(ADMIN_BASE_URL . 'outlet/edit_css/' . $row['id'], '<i class="fa fa-credit-card"></i>', array('class' => 'edit_css btn red c-btn', 'title' => 'Edit CSS'));
                            echo anchor(ADMIN_BASE_URL . 'outlet/set_timing/' . $row['id'].'/'.$row['name'], '<i class="fa fa-clock-o"></i>', array('class' => 'set_timing btn red c-btn', 'title' => 'Set Timing'));
                            echo anchor(ADMIN_BASE_URL . 'app_constants/manage/' . $row['id'].'/'.$row['name'], '<i class="fa fa-magic"></i>', array('class' => 'set_timing btn red c-btn', 'title' => 'Edit App Constants'));
                            echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete Outlet'));
                            ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
