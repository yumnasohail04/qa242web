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
                        <button type="button" class="btn blue"><i class="fa fa-check"></i>&nbsp;Save changes</button>
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
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php
                        $strunit = "Employee Outlet Base Roles";
                 
                    ?>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                        Human Resources
                        <i class="fa fa-angle-right"></i>
                        <a href="<?php echo ADMIN_BASE_URL . 'employee'; ?>">Employee</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li><?php
                     echo $strunit;
                        ?>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable tabbable-custom boxless">
                    <div class="tab-content">
                        <div class="tab-pane  active" id="tab_2">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-reorder"></i><?php  echo $strunit;?>
                                    </div>
                                </div>
                              </div>
                   <div class="tab-pane" id="roles_outlet">
                    <div id="roles_outlet_div">
					<?php
					$attributes = array('id' => 'roles_outlet_form', 'class' => 'form-horizontal no-mrg');
					echo form_open_multipart('', $attributes);
					$data = array(
						'name' => 'hdn_roles_outlet_id',
						'class' => 'hdn_roles_outlet_id',
						'id' => 'hdn_roles_outlet_id',
						'type' => 'hidden',
						'value'=>$role_outlet_id,
					);
					
					echo form_input($data);
					?>
                        <div class="row" id="list_employee">
                            <div class="col-sm-6">
                                <div class="form-group" >
									<?php
                                    $employees = array('' => '---Select---') + $employees;
                                    $data = 'id="employee" class="select2me form-control" tabindex="1"';
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Employee<span class="required">*</span>', 'employee', $attribute); ?>
                                    <div class="col-md-8">
                                        <?php echo form_dropdown('employee', $employees,$emp_id, $data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 roles_div">
                                <div class="form-group">
									<?php
                                    $roles = array('' => '---Select---') + $roles;
                                    $data = 'id="role" class="select2me form-control" tabindex="1" required=1';
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Role<span class="required">*</span>', 'role', $attribute); ?>
                                    <div class="col-md-8">
                                        <?php echo form_dropdown('lstRoles', $roles, $role_outlet_id, $data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-offset-4 col-md-8">
                                         <span id="spinners" style="color:#F60; display:none;"><i class="fa fa-spinner fa-spin" style="font-size:40px;"></i></span>
                                            <button type="submit" class="btn green" tabindex="16"><i class="fa fa-check"></i>&nbsp;Submit</button>
                                            <a href="<?php echo ADMIN_BASE_URL . 'roles_outlet'; ?>">
                                                <button type="button" class="btn default" tabindex="17"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php echo form_close(); ?>
                        </div> 
                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>

	$(document).on("submit","form#roles_outlet_form", function(event){
		event.preventDefault();
		$("#spinners").show();
		$.ajax({
			type: "POST",
			url:  "<?=ADMIN_BASE_URL ?>roles_outlet/submit",
			data: $("#roles_outlet_form").serialize(),
			success: function(result){
					if(result == 'update')
						toastr.success('Employee Outlet Role Updated Successfully.');
					else if(result == 'exist')
						toastr.error('Employee has already a role in this outlet.');
					else {
						toastr.success('Employee Outlet Role Saved Successfully.');
						$('#hdn_roles_outlet_id').val(result);
					}
					$("#spinners").hide();
					
				
			}
		});
	});

</script>>