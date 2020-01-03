<script type="text/javascript">
   $(document).ready(function() {
         $('#sample_1').dataTable(
    {
        "aLengthMenu": [[5,10, 25, 50, 100, 200, -1], [5,10, 25, 50, 100, 200, "All"]],
        "iDisplayLength": 10,
        "aoColumns": [
                    {"bSortable":false},
                    {"bSortable":false},
                    {"bSortable":false},
                    {"bSortable":false},
                    
                   
                ]
    } 
    );
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        /*////////////////////////////////////////////////////////////*/
        $('.show_detail').live('click', function() {
            //alert("here");
            var nTr = $(this).parents('tr')[0];
            var id = $(this).attr('id');
            if (oTable.fnIsOpen(nTr))
            {
                $('#'+id).find('i.fa-minus').addClass('fa-plus').removeClass('fa-minus');
                $('#'+id).attr('title','Show Detail');
                /* This row is already open - close it */
                this.src = "../examples_support/details_open.png";
                oTable.fnClose(nTr);
            }
            else
            {
                $('#'+id).find('i.fa-plus').addClass('fa-minus').removeClass('fa-plus');
                $('#'+id).attr('title','Hide Detail');
                /* Open this row */
                this.src = "../examples_support/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }
        });

        /*/////////////////////////////////////////////////////*/
        $(".action_publish").live("click", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>catagories/change_status_category",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-long-arrow-down').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-long-arrow-up').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
                    }
                    toastr.success('Successfully');
                }
            });
            if (status == 1) {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set Publish');
                $(this).attr('status', '0');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set Un-Publish');
                $(this).attr('status', '1');
            }
        });


 /*//////////////////////// code for detail //////////////////////////*/
             $(document).on('mousedown', '.fancybox', function() {
                var id = $(this).attr('rel'); 
                
                  $.fancybox({
                            width: 1000,
                            height: 430,
                            autoSize: false,
                            href: "<?= ADMIN_BASE_URL ?>catagories/detail",
                            type: 'ajax',
                            ajax: {
                                type: 'POST',
                                data: {'id': id},
                            }
                        });

            })
        /*///////////////////////// end for code detail //////////////////////////////*/








        /*/////////////////////////////////////////////////////*/

        $(document).on("click", ".show_detail", function(event) {
            //alert("here");
            event.preventDefault();
            var id = $(this).attr('rel'); 
            $('.detail_div' + id).slideToggle("slow");
        });

        /*/////////////////////////////////////////////////////*/

        $(document).on("click", ".action_home", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>catagories/set_home_category",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if (result == 'done') {


                        if (status == '1') {
                            $('.Record_' + id).removeClass('table_action_set_home');
                            $('.Record_' + id).addClass('table_action_not_set_home');
                            $('.Record_' + id).attr('title', 'Set as home page category');
                            $('.Record_' + id).attr('status', '0');
                        } else {
                            $('.Record_' + id).removeClass('table_action_not_set_home');
                            $('.Record_' + id).addClass('table_action_set_home');
                            $('.Record_' + id).attr('title', 'Unset home page category');
                            $('.Record_' + id).attr('status', '1');
                        }
                        toastr.success('Successfully');
                    } else if (result == 'more') {

                        toastr.error('More than 9 Categories cannot be set for home page.');

                    } else if (result == 'no') {
                        toastr.error('This Category does not have sub-category and cannot be set for home page.');
                    }

                }
            });

        });

        /*/////////////////////////////////////////////////////*/





        $(document).on("click", ".action_delete", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            
            $('#static').modal('show')
            $('#static').find('.modal-footer #confirm').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: "<?= ADMIN_BASE_URL ?>catagories/delete",
                    data: {'id': id},
                    async: false,
                    success: function(result) {
                        toastr.success('Successfully');
                        $('#Row_' + id).hide();

                    }
                });
            });
        });

    });

    /* Formating function for row details */
    function fnFormatDetails(oTable, nTr)
    {       
        var aData = oTable.fnGetData(nTr);
        var sOut = '<table class="table table-striped table-hover" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        sOut += '<tr><td width="15%" rowspan="2">Image:</td><td rowspan="2" width="35%">' + aData[3] + ' </td><td width="15%">URL Slug:</td><td width="35%">' + aData[4] + '</td></tr>';
        sOut += '<tr><td width="15%" nowrap rowspan="2">Meta Description:</td><td rowspan="2"  width="35%">' + aData[5] + '</td></tr>';
        sOut += '<tr><td width="15%">Description:</td><td colspan="3">' + aData[6] + '</td></tr>';
        sOut += '</table>';

        return sOut;
    }
</script>

<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn green"><i class="fa fa-check"></i>&nbsp;Save changes</button>
                        <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

        <!-- BEGIN PAGE HEADER-->
        <?php $message = $this->session->flashdata('message'); ?>


        <?php if (isset($message) && !empty($message)) {
            ?>
            <div id="ok-notice" style="display:none;" > <?= $message ?></div>
            <script>
                $(document).ready(function() {
                    var message = $('#ok-notice').text();
                    window.onload(toastr.success(message))
                });
            </script>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <ul class="page-breadcrumb breadcrumb">
                    <div class="">
                        <div class="btn-group">
                            <a href= "<?php echo ADMIN_BASE_URL . 'catagories/create'; ?>"/>
                            <button id="sample_editable_1_new" class="btn green btn_add">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                            </a>
                        </div>
                    </div>
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Category Manager</a>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr class="bg-col">
                                    <th class="table-checkbox">S.No</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
//print_r($query);
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
                                             <td class="td_set">
                                                <?php
                                                $item_img = base_url() . "static/admin/theme1/images/no_item_image_small.jpg";
                                                if (!empty($row->image) && file_exists(FCPATH . 'uploads/catagories/small_images/' . $row->image))
                                                    $item_img = IMAGE_BASE_URL . 'catagories/small_images/' . $row->image;
                                                ?>
                                                <img src="<?= $item_img ?>" class="img_set_listing"/>                                            
                                            </td>
                                             <td>
                                                <?php echo $row->cat_name; ?>
                                            </td>
                                             <td class="table_action">
                                             


                                                <?php
                                              /*  echo anchor('javascript:;', '<i class="fa fa-plus"></i>', array('class' => 'btn yellow c-btn show_detail detail_' . $row->id, 'rel' => $row->id, 'id' => 'detail-'.$row->id, 'title'=>'Show Detail'));*/
/*                                                $home_class = 'table_action_set_home btn  green  c-btn';
                                                $home_title = 'Unset home page category';
                                                $icon = '<i class="fa fa-home"></i>';
                                                if ($row->is_home != 1) {
                                                    $home_class = 'table_action_not_set_home btn  default  c-btn';
                                                    $home_title = 'Set as home page category';
                                                    $icon = '<i class="fa fa-home"></i>';
                                                }
                                                echo anchor('javascript:;', $icon, array('class' => 'action_home Record_' . $row->id . ' ' . $home_class, 'title' => $home_title, 'rel' => $row->id, 'status' => $row->is_home));*/
                                                echo anchor('javascript:;', '<i class="fa fa-list"></i>', array('class' => 'fancybox btn yellow c-btn', 'rel' => $row->id,'title' => 'View Details'));
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
                                                echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'action_delete btn red c-btn', 'rel' => $row->id,'title' => 'Delete Category'));

                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
                    Would you like to delete selected category?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                <button type="button" data-dismiss="modal" class="btn green" id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>
</div>
