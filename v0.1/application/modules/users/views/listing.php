<thead>
                                    <tr>
                                    <th>User Name </th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Group</th>
                                    <th style="width:350px;text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 0;
                                    if (isset($users_rec)) {
                                        foreach ($users_rec as $row) {
                                            $i++;
                                            $edit_url = ADMIN_BASE_URL . 'users/create/' . $row['id']; 
                                            $delete_url = ADMIN_BASE_URL . 'users/delete/'. $row['id'];
                                        
                                        ?>
                                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                                        <td><?php echo $row['user_name']?></td>
                                        <td><?php echo $row['first_name']." ".$row['last_name']?></td>
                                        <td><?php echo $row['email']?></td>
                                        <td><?php echo $row['phone']?></td>
                                        <td><?php echo $row['group']?></td>
                                

                                    <td class="table_action" style="text-align: center;">
                                            <!-- <a class="fancybox btn yellow c-btn" data-target="#myModal" data-toggle="modal" href="#description_<?= $row['id'] ?>" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a> -->
                                            <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="iconsminds-file"  title="See Detail"></i></a>
                                            <a class="btn black c-btn change_password" rel="<?=$row['id']?>"><i class="iconsminds-key"  title="Change Password"></i></a>
                                            <?php
                                            $publish_class = ' table_action_publish';
                                            $publis_title = 'Set Un-Publish';
                                            $icon = '<i class="simple-icon-arrow-up-circle"></i>';
                                            $iconbgclass = ' btn greenbtn c-btn';
                                            if ($row['status'] != 1) {
                                                $publish_class = ' table_action_unpublish';
                                                $publis_title = 'Set Publish';
                                                $icon = '<i class="simple-icon-arrow-down-circle"></i>';
                                                $iconbgclass = ' btn default c-btn';
                                            }
                                            echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Users'));
                                            echo anchor("javascript:void(0);",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                                            'title' => $publis_title,'rel' => $row['id'],'id' => $row['id'], 'status' => $row['status']));
                                            echo anchor('javascript:void(0);', '<i class="simple-icon-close"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete User'));

                                            ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        }
                                    ?>
                                    <?php } ?>
                                </tbody>