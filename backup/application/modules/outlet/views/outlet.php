<div class="content-wrapper">
    <h3>
    Outlet 
    <a href="outlet/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button><span class="pull-right">&nbsp;&nbsp;&nbsp;</span>
    <a href="app_constants/manage_labels/"><button type="button" class="btn btn-primary pull-right">Edit App Labels</button></a>
    </h3>
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" id="listing">
                        <?php include_once('outlet_listing.php'); ?>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT--> 
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {

        /*//////////////////////// code for detail //////////////////////////*/

        $(document).on("click", ".view_details", function (event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL ?>outlet/detail",
                data: {'id': id},
                async: false,
                success: function (test_body) {
                    var test_desc = test_body;
                    $('#myModal').modal('show')
                    $("#myModal .modal-body").html(test_desc);
                }
            });
        });

        /*///////////////////////// end for code detail //////////////////////////////*/
        $(document).off('click', '#add_postcode').on('click', '#add_postcode', function (e) {
            e.preventDefault();
            var postcode = $('#txtpostcode').val();
            var id = $('#hdnpostcode_outlet').val();
            var DeliveryCost = $('#txtDeliveryCost').val();

            if (!$.trim(postcode) || $.trim(postcode) == '0') {
                toastr.error('Please enter postcode.');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL ?>outlet/add_postcode",
                data: {'id': id, 'postcode': postcode, 'DeliveryCost': DeliveryCost},
                async: false,
                success: function (test_body) {
                    var test_desc = test_body;
                    if (test_desc == 'xxx')
                        toastr.error('Post code already exists.');
                    else {
                        toastr.success('Psot code added Successfully');
                        load_postcode_list();
                    }

                    //$('#myModal').modal('show') post_code_listing
                    //$("#myModal .modal-body").html(test_desc);
                }
            });
        });
        $(document).off('click', '.post_code_delivery').on('click', '.post_code_delivery', function (e) {
            e.preventDefault();
            var id = $(this).attr('rel');
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL ?>outlet/get_delivery_postcodes",
                data: {'id': id},
                async: false,
                success: function (test_body) {
                    var test_desc = test_body;
                    $('#myModal').modal('show')
                    $("#myModal .modal-body").html(test_desc);
                }
            });
        });
        $(document).off('click', '.delete_record').on('click', '.delete_record', function (e) {
            var id = $(this).attr('rel');
            e.preventDefault();
            swal({
                title: "Are you sure to delete the selected Outlet?",
                text: "You will not be able to recover this Outlet!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL ?>outlet/delete",
                            data: {'id': id},
                            async: false,
                            success: function () {
                                load_listing();
                            }
                        });
                        swal("Deleted!", "Outlet has been deleted.", "success");
                    });

        });
        $(document).off("click", ".delete_postocde").on("click", ".delete_postocde", function (event) {
            event.preventDefault();

            var idd = $(this).attr('rel');
            // alert(idd); return;    
            swal({
                title: "Are you sure to delete the selected Post Code?",
                text: "You will not be able to recover this  Post Code!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
                    function () {

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL ?>outlet/delete_post_code",
                            data: {'id': idd},
                            async: false,
                            success: function () {
                                load_postcode_list();
                            }
                        });
                        swal("Deleted!", "Post code has been deleted.", "success");
                    });



        });
        $(document).off("blur", ".txtdelivery_charges").on("blur", ".txtdelivery_charges", function (event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var cost = $(this).val();
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL ?>outlet/update_delivery_charges",
                data: {'id': id, 'cost': cost},
                async: false,
                success: function () {
                    toastr.success('Delivery Cost update Successfully');
                }
            });
        });
        
        $(document).off("click", ".action_publish").on("click", ".action_publish", function (event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>outlet/change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function (result) {
                    load_listing();
                    toastr.success('Status Changed Successfully');
                }
            });
        });
        
        $(document).off("click", ".change_live_status").on("click", ".change_live_status", function (event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>outlet/change_live_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function (result) {
                    load_listing();
                    toastr.success('Set to '+(result == 1 ? 'test' : 'live')+' Successfully');
                }
            });
        });

    });

    function load_postcode_list() {
        var id = $('#hdnpostcode_outlet').val();
        $("#postcode_list").load("<?php echo ADMIN_BASE_URL ?>outlet/post_code_listing", {'id': id}, function () {
            //$('#datatable2').dataTable();
        });

    }
    
    function load_listing() {
        $("#listing").load("<?php echo ADMIN_BASE_URL ?>outlet/load_listing", function () {
            $('#datatable1').dataTable();
        });
    }

</script>