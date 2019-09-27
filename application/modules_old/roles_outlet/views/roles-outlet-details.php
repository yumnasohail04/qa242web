            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-reorder"></i>Details
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Role</th>
                                    <th>Outlet</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($roles_outlet)) {
									$i=0;
                                    foreach ($roles_outlet as $row) {
										$i++;
                                        ?>
                                        <tr class="odd gradeX" id="Row_<?=$row['id']; ?>">
                                            <td><?php echo $i;?></td>        
                                            <td><?php echo $row['role']?></td>
                                            <td><?php echo $row['outlet']?></td>
                                            <td>
                                            <?php

												echo anchor('javascript:;', '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'id' => 'roles_outlet_edit', 'rel' => $row['id'], 'title' => 'Edit'));echo '&nbsp;&nbsp;'; 
                                                echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'action_delete btn red c-btn', 'id' => 'roles_outlet_delete', 'rel' => $row['id'], 'title' => 'Delete'));	;echo '&nbsp;&nbsp;'; ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>    
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        
 <script>
 $(document).ready(function() {
	$('#sample_1').dataTable(
	{
		"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
		"iDisplayLength": 10,
		"aoColumns": [
		null,
		null,
		null,
		{"bSortable": false},
		]
	}
	);

	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
});
 </script>