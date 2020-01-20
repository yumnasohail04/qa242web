					<?php
					$attributes = array('id' => 'roles_outlet_form', 'class' => 'form-horizontal no-mrg');
					echo form_open_multipart('', $attributes);
					$data = array(
						'name' => 'hdn_roles_outlet_id',
						'class' => 'hdn_roles_outlet_id',
						'id' => 'hdn_roles_outlet_id',
						'value'=> $roles_outlet_id,
						'type' => 'hidden',
					);
					
					echo form_input($data);
					?>
                        <div class="row" id="list_outlet">
                            <div class="col-sm-6">
                                <div class="form-group" >
									<?php
                                    $employees = array('' => '---Select---') + $employees;
                                    $data = 'id="employee" class="select2me form-control" tabindex="1"';
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Employee', 'employee', $attribute); ?>
                                    <div class="col-md-8">
                                        <?php echo form_dropdown('employee', $employees, $roles_outlet->emp_id, $data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php /*?><div class="row" id="list_outlet">
                            <div class="col-sm-6">
                                <div class="form-group" >
									<?php
                                    $outlets = array('' => '---Select---') + $outlets;
                                    $data = 'id="outlet" class="select2me form-control" tabindex="1"';
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Outlet', 'outlet', $attribute); ?>
                                    <div class="col-md-8">
                                        <?php echo form_dropdown('outlet', $outlets, $roles_outlet->outlet_id, $data); ?>
                                    </div>
                                </div>
                            </div>
                        </div><?php */?>
                        <div class="row" id="list_roles">
                            <div class="col-sm-6">
                                <div class="form-group" >
									<?php
                                    $roles = array('' => '---Select---') + $roles;
                                    $data = 'id="role" class="select2me form-control" tabindex="1"';
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Role', 'role', $attribute); ?>
                                    <div class="col-md-8">
                                        <?php echo form_dropdown('lstRoles', $roles, $roles_outlet->role_id, $data); ?>
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