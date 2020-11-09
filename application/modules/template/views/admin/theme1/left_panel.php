<?php
$curr_url = $this->uri->segment(2);
$secon_curr_url = $this->uri->segment(3);
$active="active";

$outlet_id = DEFAULT_OUTLET;
if (defined('DEFAULT_CHILD_OUTLET'))   $outlet_id = DEFAULT_CHILD_OUTLET;
?>
<div class="menu">
        <div class="main-menu">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li class="<?php if($curr_url == 'dashboard'){echo 'active';}   ?>" >
                        <a href="#dashboard">
                            <i class="iconsminds-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?php if($curr_url == 'users' || $curr_url == 'groups' ){echo 'active';}   ?>">
                        <a href="#users">
                            <i class="iconsminds-conference"></i> 
                        	<span>User Management</span>
                        </a>
                    </li>
                    <li class="<?php if($curr_url == 'product'  ){echo 'active';}   ?>">
                        <a href="#applications">
                            <i class="iconsminds-shopping-basket"></i> 
                        	<span>Products</span>
                        </a>
                    </li>
                    <li class="<?php if($curr_url == 'catagories' || $curr_url == 'wip_profile'   || $curr_url == 'product_checks' || $curr_url == 'product_tests' || $curr_url == 'scheduled_checks' ||  $curr_url == 'static_form' || $curr_url == 'herbspice_checks'){echo 'active';}   ?>"> 
                        <a href="#ui">
                            <i class="iconsminds-check"></i> 
                        <span>Checks</span>
                        </a>
                    </li>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/active_checks' || $curr_url.'/'.$secon_curr_url == 'assignments/overdue_checks' ){echo 'active';}   ?>">
                        <a href="#menu">
                            <i class="iconsminds-receipt-4"></i> 
                        <span>Assignments</span>
                        </a>
                    </li>
                    <li class="<?php if($secon_curr_url == 'pending_review' || $secon_curr_url == "pending_approval" || $secon_curr_url == "completed_checks" 
                                       || $secon_curr_url == "static_forms_pending"  || $secon_curr_url == "static_forms_reviewed"  || $secon_curr_url == "static_forms_approved"  )
						{echo 'active';}   ?>">
                        <a href="#tasks">
                            <i class="iconsminds-testimonal"></i> 
                        <span>Submitted Forms</span>
                        </a>
                    </li>
                    <li class="<?php if($curr_url == 'ingredients' || $curr_url == 'supplier' || $curr_url == 'document' || $curr_url == 'scorecard_form' || $curr_url == 'scorecard'  ){echo 'active';}   ?>">
                        <a href="#supplier">
                            <i class="iconsminds-network"></i> 
                        <span>Suppliers</span>
                        </a>
                    </li>
                    <li class="<?php if($curr_url == 'carrier' || $curr_url =='document_file'  ){echo 'active';}   ?>">
                        <a href="#carrier">
                            <i class="iconsminds-bus-2"></i> 
                        <span>Carrier & Storage</span>
                        </a>
                    </li>
                 <li class="<?php if($curr_url == 'reports' ){echo 'active';}   ?>">
                        <a href="<?php echo ADMIN_BASE_URL.'reports'; ?>">
                            <i class="iconsminds-statistic"></i> 
                        <span>Reports</span>
                        </a>
                    </li>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
            <?php 
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'dashboard');
                else  
                    $permission = true;
                      
                if ($permission){?>
                <ul class="list-unstyled" data-link="dashboard" class="<?php if($curr_url == 'dashboard'){echo 'active';}   ?>">
                    <li>
                        <a href="<?php $controller='dashboard';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="simple-icon-doc"></i> <span class="d-inline-block">Default</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php $controller='dashboard/supplier';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="simple-icon-pie-chart"></i> <span class="d-inline-block">Suppliers</span>
                        </a>
                    </li>
<!--                     <li>
                        <a href="<?php $controller='dashboard';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="simple-icon-basket-loaded"></i> <span class="d-inline-block">Carrier/storage</span>
                        </a>
                    </li> -->
                </ul>
                <?php
                }?>
                <ul class="list-unstyled " data-link="users" id="users">
                 <?php $permission = false;
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'users');
                else 
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'users'){echo 'active';} ?>">
                        <a href="<?php $controller='users'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-male"></i> <span class="d-inline-block">Users</span>
                        </a>
                    </li>
                    <?php }
                
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'groups');
                else 
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'groups'){echo 'active';}    ?>">
                        <a href="<?php $controller='groups'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-mens"></i> <span class="d-inline-block">Groups</span>
                        </a>
                    </li>
                <?php } ?>
                </ul>
                <?php 
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                else 
                    $permission = true;
                if ($permission){?>
                <ul class="list-unstyled" data-link="applications">
                <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                            else 
                                $permission = true;
                            if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'product/'){echo 'active';}?>">
                        <a href="<?php $controller='product'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-checkout-basket"></i> <span class="d-inline-block">Finished Goods</span>
                        </a>
                    </li>
                    <?php }
                            $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                            else 
                                $permission = true;
                            if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'product/wip_products'){echo 'active';}?>">
                        <a href="<?php $controller='product/wip_products'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="simple-icon-check"></i> <span class="d-inline-block">Wip Products</span>
                        </a>
                    </li>
                    <?php
                            } ?>
                </ul>
                <?php
                            } ?>
                <ul class="list-unstyled" data-link="ui">
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#collapseForms" aria-expanded="true"
                            aria-controls="collapseForms" class="rotate-arrow-icon opacity-50">
                            <i class="simple-icon-arrow-down"></i> <span class="d-inline-block">Check options</span>
                        </a>
                        <div id="collapseForms" class="collapse show">
                            <ul class="list-unstyled inner-level-menu">
                            <?php $permission = true;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'catagories');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li  class="<?php if($curr_url == 'catagories'){echo 'active';}    ?>">
                                    <a href="<?php $controller='catagories';  echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-event"></i> <span class="d-inline-block">Form Detail</span>
                                    </a>
                                </li>
                                <?php
                            }
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'wip_profile');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'wip_profile'){echo 'active';}    ?>" >
                                    <a href="<?php $controller='wip_profile'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-doc"></i> <span class="d-inline-block">Wip Form Detail</span>
                                    </a>
                                </li>
                                <?php
                            } ?>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#collapseDataTables" aria-expanded="true"
                            aria-controls="collapseDataTables" class="rotate-arrow-icon opacity-50">
                            <i class="simple-icon-arrow-down"></i> <span class="d-inline-block">Existing Checks</span>
                        </a>
                        <div id="collapseDataTables" class="collapse show">
                            <ul class="list-unstyled inner-level-menu">
                            <?php 
                          
                          $permission = false;
                          if ($user_data['role'] != 'Admin')
                              $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_checks');
                          else 
                              $permission = true;
                          if ($permission){?>
                                <li class="<?php if($curr_url == 'product_checks'){echo 'active';}    ?>" >
                                    <a href="<?php $controller='product_checks';  echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-notebook"></i> <span class="d-inline-block">Standard checks</span>
                                    </a>
                                </li>
                                <?php
                            }
                            $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_tests');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'product_tests'){echo 'active';}    ?>">
                                    <a href="<?php $controller='product_tests'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-notebook"></i> <span class="d-inline-block">Production Checks</span>
                                    </a>
                                </li>
                                <?php } ?>
                                
                              <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'herbspice_checks');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li <?php if($curr_url == 'herbspice_checks' || $curr_url == 'herb_attributes' || $curr_url == 'herb_spice'){echo 'active';}    ?>>
                                    <a href="<?php $controller='herbspice_checks'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-notebook"></i> <span class="d-inline-block">Herb Spice Checks</span>
                                    </a>
                                </li>
                                <?php
                            } ?>  
                             <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scheduled_checks');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'scheduled_checks' || $curr_url == 'scheduled_checks' || $curr_url == 'scheduled_checks'){echo 'active';}    ?>" >
                                    <a href="<?php $controller='scheduled_checks';  echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-notebook"></i> <span class="d-inline-block">Scheduled Checks</span>
                                    </a>
                                </li>
                                <?php
                            } ?>  
                             <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'static_form'){echo 'active';}    ?>" >
                                    <a href="<?php $controller='static_form';  echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="simple-icon-notebook"></i> <span class="d-inline-block">Static form Checks</span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
                <?php
                $permission = false;
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'outlet');
                else 
                    $permission = true;
                if ($permission){ ?>
                <ul class="list-unstyled" data-link="menu" id="menuTypes">
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuTypes" aria-expanded="true"
                            aria-controls="collapseMenuTypes" class="rotate-arrow-icon">
                            <i class="simple-icon-arrow-down"></i> <span class="d-inline-block">Assignments</span>
                        </a>
                        <div id="collapseMenuTypes" class="collapse show" data-parent="#menuTypes">
                            <ul class="list-unstyled inner-level-menu">
                            <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/active_checks'){echo 'active';}    ?>" >
                                    <a href="<?php $controller='assignments/active_checks'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-recycling-2"></i> <span
                                            class="d-inline-block">Active Checks</span>
                                    </a>
                                </li>
                                <?php
                            }
                            $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_checks');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/overdue_checks'){echo 'active';}    ?>">
                                    <a href="<?php $controller='assignments/overdue_checks'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-delete-file mi-subhidden"></i> <span
                                            class="d-inline-block">Overdue Checks</span>
                                    </a>
                                </li>
                                <?php
                            } 
                            ?>
                            </ul>
                        </div>
                    </li>
                </ul>
                <?php
                }
                ?>
                <ul class="list-unstyled" data-link="tasks" id="tasks">
                <?php $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_checks');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/pending_review'){echo 'active';}    ?>" >
                        <a href="<?php $controller='assignments/pending_review'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-testimonal"></i> <span class="d-inline-block">Pending Review</span>
                        </a>
                    </li>
                    <?php
                    }
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_checks');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li  class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/pending_approval'){echo 'active';}    ?>">
                        <a href="<?php $controller='assignments/pending_approval'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-testimonal"></i> <span class="d-inline-block">Pending Approval</span>
                        </a>
                    </li>
                    <?php
                    }
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/completed_checks'){echo 'active';}    ?>">
                        <a href="<?php $controller='assignments/completed_checks';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-testimonal"></i> <span class="d-inline-block">Approved</span>
                        </a>
                    </li>
                    <?php
                    }
                    
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li  class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_forms_pending'){echo 'active';}    ?>" >
                        <a href="<?php $controller='assignments/static_forms_pending'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-testimonal"></i> <span class="d-inline-block">Static - Pending Review</span>
                        </a>
                    </li>
                    <?php
                    }
                    
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_forms_reviewed'){echo 'active';}    ?>">
                        <a href="<?php $controller='assignments/static_forms_reviewed';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-testimonal"></i> <span class="d-inline-block">Static - Pending Approval</span>
                        </a>
                    </li>
                    <?php
                    }
                    
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li  class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_forms_approved'){echo 'active';}    ?>">
                        <a href="<?php $controller='assignments/static_forms_approved';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-testimonal"></i> <span class="d-inline-block">Static - Approved</span>
                        </a>
                    </li>
                    <?php
                    }
                    
                    ?>
                    
                </ul>
                <ul class="list-unstyled" data-link="supplier" id="supplier">
                   <?php $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'ingredients');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url == 'ingredients/'){echo 'active';}    ?>">
                        <a href="<?php $controller='ingredients'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-add-basket"></i> <span class="d-inline-block">Ingredients</span>
                        </a>
                    </li>
                    <?php
                    }
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'supplier');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url == 'supplier'){echo 'active';}    ?>">
                        <a href="<?php $controller='supplier'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-add-user"></i> <span class="d-inline-block">Supplier</span>
                        </a>
                    </li>
                    <?php
                    }
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'ingredients');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url.'/'.$secon_curr_url== 'ingredients/supplier_item'){echo 'active';}    ?>">
                        <a href="<?php $controller='ingredients/supplier_item'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-box-close"></i> <span class="d-inline-block">Supplier Items</span>
                        </a>
                    </li>
                    <?php
                    }
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'document');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url== 'document'){echo 'active';}    ?>">
                        <a href="<?php $controller='document'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-folder-open"></i> <span class="d-inline-block">Document detail</span>
                        </a>
                    </li>
                    <?php
                    }
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scorecard_form');
                    else 
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url == 'scorecard_form'){echo 'active';}    ?>">
                        <a href="<?php $controller='scorecard_form'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-receipt-4"></i> <span class="d-inline-block">Scorecard detail</span>
                        </a>
                    </li>
                    <?php  } ?>
                    <li>
                        <a href="#" data-toggle="collapse" data-target="#collapseMenuTypes" aria-expanded="true"
                            aria-controls="collapseMenuTypes" class="rotate-arrow-icon">
                            <i class="simple-icon-arrow-down"></i> <span class="d-inline-block">Scorecard</span>
                        </a>
                        <div id="collapseMenuTypes" class="collapse show" data-parent="#menuTypes">
                            <ul class="list-unstyled inner-level-menu">
                            <?php $permission = true;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scorecard');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'scorecard/manage'){echo 'active';}?>">
                                    <a href="<?php $controller='scorecard/manage';  echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-add-file"></i> <span
                                            class="d-inline-block">New Scorecard</span>
                                    </a>
                                </li>
                                <?php
                            }?>
                         
                                 <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scorecard');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li  class="<?php if($curr_url.'/'.$secon_curr_url == 'scorecard/inprogress_scorecard'){echo 'active';}?>">
                                    <a href="<?php $controller='scorecard/inprogress_scorecard'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-testimonal mi-subhidden"></i> <span
                                            class="d-inline-block">In Progress <br>Scorecard</span>
                                    </a>
                                </li>
                                <?php
                            } ?> 
                                 <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scorecard');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url  == 'scorecard/pending_scorecard'){echo 'active';}    ?>" >
                                    <a href="<?php $controller='scorecard/pending_scorecard';  echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-testimonal mi-subhidden"></i> <span
                                            class="d-inline-block">In Progress <br>Pending Reviews</span>
                                    </a>
                                </li>
                                <?php
                            } ?> 
                            
                                 <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scorecard');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url  == 'scorecard/complete_scorecard'){echo 'active';}    ?>">
                                    <a href="<?php $controller='scorecard/complete_scorecard'; echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-testimonal mi-subhidden"></i> <span
                                            class="d-inline-block">Completed <br>scorecards</span>
                                    </a>
                                </li>
                                <?php
                            } ?> 
                                <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'scorecard');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url  == 'scorecard/scorecard_report'){echo 'active';}    ?>">
                                    <a href="<?php $controller='scorecard/scorecard_report';   echo ADMIN_BASE_URL . $controller ?>">
                                        <i class="iconsminds-monitor-analytics mi-subhidden"></i> <span
                                            class="d-inline-block">Scorecard Report</span>
                                    </a>
                                </li>
                                <?php
                            } ?> 
                            </ul>
                        </div>
                    </li>
                </ul>

                <ul class="list-unstyled" data-link="carrier" id="carrier"> 
                    <?php $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'carrier');
                        $permission = true;
                    if ($permission){?>
                    <li class="<?php if($curr_url == 'carrier'){echo 'active';}    ?>">
                        <a href="<?php $controller='carrier';  echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-box-close"></i> <span class="d-inline-block">Carrier and Storage</span>
                        </a>
                    </li> 
                    <?php
                    } ?> 

                    <?php 
                    $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'document_file');
                        $permission = true;
                    if ($permission){?>
                    <li  class="<?php if($curr_url == 'document_file'){echo 'active';}    ?>">
                        <a href="<?php $controller='document_file'; echo ADMIN_BASE_URL . $controller ?>">
                            <i class="iconsminds-folder-open"></i> <span class="d-inline-block">Document Detail</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>

            </div>
        </div>
    </div>