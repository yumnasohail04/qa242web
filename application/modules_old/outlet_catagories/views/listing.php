<table id="datatable1" class="table table-bordered ">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th  style="width:2%">S.No</th>
                        <th width="300px">Title</th>
                        <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                         <tbody>
                                <?php
                                $i=0;
                                if (isset($query)) {
									$options = array(0 => 'Select')+ $arr_adon;
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                        $active_url = ADMIN_BASE_URL . 'catagories/sub_cat_active/' . $row->parent_id . '/' . $row->id;
                                        $in_active_url = ADMIN_BASE_URL . 'catagories/sub_cat_in_active/' . $row->parent_id .  '/' . $row->id;
                                        $edit_url = ADMIN_BASE_URL . 'catagories/create_sub_catagories/' . $row->parent_id . '/' . $row->id;
                                       $delete_url = ADMIN_BASE_URL . 'catagories/delete_sub_catagories/' . $row->id . '/' .  $row->parent_id;
                                        $set_publish_url = ADMIN_BASE_URL . 'catagories/active/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'catagories/in_active/' . $row->id;
                                        ?>
                                        <tr class="odd gradeX">
                                          <td class="table-checkbox"><?php echo $i; ?></td>
                                            <td><?php echo $row->cat_name; ?></td>
                                         
											
                                            
                                          

                                            <td class="table_action">
                                            <a class="btn yellow c-btn view_sub_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                                 <?php
                                                if ($row->is_active == 1){
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                }
                                                if ($row->is_active != 1) {
                                                    $publish_class = 'table_action_unpublish';
                                                    $publis_title = 'Set Publish';
                                                    $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                    $iconbgclass = ' btn default c-btn';
                                                }
                                                echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id, 'id' => $row->id, 'status' => $row->is_active));
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row->id, 'rel2' => $row->parent_id,'title' => 'Delete Sub Category'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>    
                                <?php } ?>
                            </tbody>
                    </table>

<?php /*?> <thead class="bg-th">
                        <tr class="bg-col">
                        <th  style="width:2%">S.No</th>
                        <th width="400px">Title</th>
                        <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                         <tbody>
                                <?php
                                $i=0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                        $active_url = ADMIN_BASE_URL . 'catagories/sub_cat_active/' . $row->parent_id . '/' . $row->id;
                                        $in_active_url = ADMIN_BASE_URL . 'catagories/sub_cat_in_active/' . $row->parent_id .  '/' . $row->id;
                                        $edit_url = ADMIN_BASE_URL . 'catagories/create_sub_catagories/' . $row->parent_id . '/' . $row->id;
                                       $delete_url = ADMIN_BASE_URL . 'catagories/delete_sub_catagories/' . $row->id . '/' .  $row->parent_id;
                                        $set_publish_url = ADMIN_BASE_URL . 'catagories/active/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'catagories/in_active/' . $row->id;
                                        ?>
                                        <tr class="odd gradeX">
                                          <td class="table-checkbox"><?php echo $i; ?></td>
                                            <td><?php echo $row->cat_name; ?></td>
                                            <td class="table_action">
                                            <a class="btn yellow c-btn view_sub_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                                 <?php
                                                if ($row->is_active == 1){
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                }
                                                if ($row->is_active != 1) {
                                                    $publish_class = 'table_action_unpublish';
                                                    $publis_title = 'Set Publish';
                                                    $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                    $iconbgclass = ' btn default c-btn';
                                                }
                                                echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id, 'id' => $row->id, 'status' => $row->is_active));
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row->id, 'rel2' => $row->parent_id,'title' => 'Delete Sub Category'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>    
                                <?php } ?>
                            </tbody><?php */?>