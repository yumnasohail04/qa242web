<table id="datatable1" class="table table-striped table-hover">
    <thead class="bg-th">
    <tr class="bg-col">
    <th class="sr" width="2%">S.No</th>
    <th>Title</th>
    <th>Type</th>
    <th class="" style="width:350px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
    </tr>
    </thead>
    <tbody class="courser table-body">
    <?php
    $i=0;
    if (isset($query)) {
    foreach ($query->result() as $row) {
    $i++;   
    if (!isset($return_page))
        $return_page = 0;
//                      $manage_sub_page_url = ADMIN_BASE_URL . 'webpages/manage_sub_pages/' . $row->id ;
    $edit_url = ADMIN_BASE_URL . 'webpages/create/' . $row->id ;
    ?>
    <tr id="Row_<?= $row->id ?>" class="odd gradeX">
    <td class="table-checkbox"><?php echo $i; ?><!--<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>--></td>
    <td><?php echo $row->page_title; ?></td>
    <td><?php echo $row->type; ?></td>
    <td class="table_action">
    <a class="btn yellow c-btn view_details" rel="<?=$row->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
    <?php
    if ($row->is_home == 1)
        echo '<span class="action_home btn blue c-btn homebtn" title="Unset Home Page"><i class="fa fa-home"></i></span>';
    else
        echo anchor('javascript:;', '<i class="fa fa-home"></i>', array('class' => 'action_home btn default c-btn', 'rel' => $row->id, 'title' => 'Set Home page'));
    $top_page_class = 'table_action_publish top_border';
    $top_page_title = 'Remove form top panel';
    $icon = '<i class="fa fa-chain"></i>';
    $prefixID = 'asc';
    $iconbgclass = ' btn green c-btn';
    if ($row->show_in_toppanel != 1) {
        $top_page_class = 'table_action_unpublish top_border';
        $top_page_title = 'Show in top panel';
        $icon = '<i class="fa fa-chain-broken"></i>';
        $prefixID = 'desc';
        $iconbgclass = ' btn default c-btn';
    }               
    echo anchor('javascript:;', $icon, array('class' => 'action_top_page ' . $top_page_class . $iconbgclass, 'title' => $top_page_title, 'rel' => $row->id, 'id' => $prefixID.'-'.$row->id, 'status' => $row->show_in_toppanel));
    $footer_page_class = 'table_action_publish bottom_border';
    $footer_page_title = 'Remove form footer panel';
    $icon = '<i class="fa fa-chain bottom_border"></i>';
    $prefixID = 'footer_on';
    $iconbgclass = ' btn green c-btn';
    if ($row->show_in_footer != 1) {
        $footer_page_class = 'table_action_unpublish bottom_border';
        $footer_page_title = 'Show in footer panel';
        $icon = '<i class="fa fa-chain-broken"></i>';
        $prefixID = 'footer_off';
        $iconbgclass = ' btn default c-btn';
    }
    echo anchor('javascript:;', $icon, array('class' => 'action_footer_page ' . $footer_page_class . $iconbgclass, 'title' => $footer_page_title, 'rel' => $row->id,'id' => $prefixID.'-'.$row->id, 'status' => $row->show_in_footer));
//                        echo anchor($manage_sub_page_url, '<i class="fa fa-sitemap" title="Manage Sub Pages" ></i>','class="btn purple c-btn"');
    if ($row->is_static == 0) {
        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Page'));
        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Webpage'));
    }
	
                           
    
                         
    ?>
    
    </td>
    </tr>  
    <?php } } ?>
    </tbody>
</table>    