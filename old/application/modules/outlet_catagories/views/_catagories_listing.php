
                  <?php /*?><table class="table table-striped table-bordered table-hover" id="datatable1">
                            <thead class="bg-th">
                                <tr>
                                    <th class="table-checkbox">S.No</th>
                                    <th style="width:620px">Title</th>
                                    <th class="" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>                              
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                        $manage_sub_page_url = ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $row->id ."/". $row->cat_name;
                                        $set_default_url = ADMIN_BASE_URL . 'catagories/set_default/' . $row->id;

                                        $set_home_url = ADMIN_BASE_URL . 'catagories/set_home_category/' . $row->id;
                                        $set_not_home_url = ADMIN_BASE_URL . 'catagories/set_not_home_category/' . $row->id;

                                        $set_publish_url = ADMIN_BASE_URL . 'catagories/active/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'catagories/in_active/' . $row->id;

                                        $edit_url = ADMIN_BASE_URL . 'catagories/create/' . $row->id;
                                        $delete_url = ADMIN_BASE_URL . 'catagories/delete/' . $row->id;
                                        ?>
                                        <tr id="Row_<?= $row->id ?>" class="odd">
                                            <td class="table-checkbox"><?php echo $i; ?></td>
                                             <td>
                                                <?php echo $row->cat_name; ?>
                                            </td>
                                             <td class="table_action">
                                             
                                             <a class="btn yellow c-btn view_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>

                                                <?php
                                                echo anchor($manage_sub_page_url, '<i class="fa fa-sitemap" title="Manage Sub categories" ></i>','class="btn purple c-btn"');
                                                if ($row->is_default != 1) {
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                    if ($row->is_active != 1) {
                                                        $publish_class = 'table_action_unpublish';
                                                        $publis_title = 'Set Publish';
                                                        $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                        $iconbgclass = ' btn default c-btn';
                                                    }
                                                    echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id, 'id' => $row->id, 'status' => $row->is_active));
//                                                    echo anchor($set_default_url, '<img src="' . base_url() . 'static/admin/theme1/images/category_not_default.png" title="Set Default" />');
                                                    } else {
                                                        $publish_class = 'table_action_publish';
                                                        $publis_title = 'Set Un-Publish';
                                                        $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                        $iconbgclass = ' btn green c-btn';

                                                        if ($row->is_active != 1) {
                                                            $publish_class = 'table_action_unpublish';
                                                            $publis_title = 'Set Publish';
                                                            $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                            $iconbgclass = ' btn default c-btn';
                                                        }
                                                        $attr = array('class' => 'disable_link');
                                                        echo anchor('', '<img src="' . base_url() . 'static/admin/theme1/images/publish.png" title="Published" />', 'class="disable_link"');
                                                    }
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Category'));

                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>
                        </table><?php */?>
                    



<?php // print_r($query); exit();  ?>

<thead class="bg-th">
                                <tr>
                                    <th class="table-checkbox">S.No----------</th>
                                    <th style="width:620px">Title</th>
                                    <th class="" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>                              
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                        $manage_sub_page_url = ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $row->id;
                                        $set_default_url = ADMIN_BASE_URL . 'catagories/set_default/' . $row->id;

                                        $set_home_url = ADMIN_BASE_URL . 'catagories/set_home_category/' . $row->id;
                                        $set_not_home_url = ADMIN_BASE_URL . 'catagories/set_not_home_category/' . $row->id;

                                        $set_publish_url = ADMIN_BASE_URL . 'catagories/active/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'catagories/in_active/' . $row->id;

                                        $edit_url = ADMIN_BASE_URL . 'catagories/create/' . $row->id;
                                        $delete_url = ADMIN_BASE_URL . 'catagories/delete/' . $row->id;
                                        ?>
                                        <tr id="Row_<?= $row->id ?>" class="odd">
                                            <td class="table-checkbox"><?php echo $i; ?></td>
                                             <td>
                                                <?php echo $row->cat_name; ?>
                                            </td>
                                             <td class="table_action">
                                             
                                             <a class="btn yellow c-btn view_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>

                                                <?php
                                                echo anchor($manage_sub_page_url, '<i class="fa fa-sitemap" title="Manage Sub categories" ></i>','class="btn purple c-btn"');
                                                if ($row->is_default != 1) {
                                                    $publish_class = 'table_action_publish';
                                                    $publis_title = 'Set Un-Publish';
                                                    $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                    $iconbgclass = ' btn green c-btn';
                                                    if ($row->is_active != 1) {
                                                        $publish_class = 'table_action_unpublish';
                                                        $publis_title = 'Set Publish';
                                                        $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                        $iconbgclass = ' btn default c-btn';
                                                    }
                                                    echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id, 'id' => $row->id, 'status' => $row->is_active));
//                                                    echo anchor($set_default_url, '<img src="' . base_url() . 'static/admin/theme1/images/category_not_default.png" title="Set Default" />');
                                                    } else {
                                                        $publish_class = 'table_action_publish';
                                                        $publis_title = 'Set Un-Publish';
                                                        $icon = '<i class="fa fa-long-arrow-up"></i>';
                                                        $iconbgclass = ' btn green c-btn';

                                                        if ($row->is_active != 1) {
                                                            $publish_class = 'table_action_unpublish';
                                                            $publis_title = 'Set Publish';
                                                            $icon = '<i class="fa fa-long-arrow-down"></i>';
                                                            $iconbgclass = ' btn default c-btn';
                                                        }
                                                        $attr = array('class' => 'disable_link');
                                                        echo anchor('', '<img src="' . base_url() . 'static/admin/theme1/images/publish.png" title="Published" />', 'class="disable_link"');
                                                    }
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Category'));

                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>