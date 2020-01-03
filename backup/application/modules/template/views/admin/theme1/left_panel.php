<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
<?php
$curr_url = $this->uri->segment(2);
$secon_curr_url = $this->uri->segment(3);
$active="active";

$outlet_id = DEFAULT_OUTLET;
if (defined('DEFAULT_CHILD_OUTLET'))   $outlet_id = DEFAULT_CHILD_OUTLET;
?>
<!-- sidebar-->
<aside class="aside">
    <!-- START Sidebar (left)-->
    <div class="aside-inner">
        <nav data-sidebar-anyclick-close="" class="sidebar">
            <!-- START sidebar nav-->
            <ul class="nav page-sidebar-menu">
                <!-- Iterates over all sidebar items-->
                <?php 
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'dashboard');
                else  
                    $permission = true;
                      
                if ($permission){?>
                    <li class="<?php if($curr_url == 'dashboard'){echo 'active';}   ?>">
                        <a href="<?php $controller='dashboard'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php
                }?>
                 
                <?php $permission = false;
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'users');
                else 
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'users'){echo 'active';}    ?>">
                        <a href="<?php $controller='users'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa fa-user "></i>
                            <span>Users</span>
                        </a>
                    </li>
                <?php }
                
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'groups');
                else 
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'groups'){echo 'active';}    ?>">
                        <a href="<?php $controller='groups'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa fa-users "></i>
                            <span>Groups</span>
                        </a>
                    </li>
                <?php }

                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                else 
                    $permission = true;
                if ($permission){?>
                    <li class="back_shadow">
                        <a href="#products" title="Products" data-toggle="collapse" >
                            <em class="fa fa-tasks "></em>
                            <span>Products</span>
                        </a>
                        <ul id="products" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">Products</li>
                            <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'product/'){echo 'active';}?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='product'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Finished Goods</span>
                                    </a>
                                </li>
                            <?php }
                            $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'product/wip_products'){echo 'active';}?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='product/wip_products'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fas fa-utensils"></em>
                                        <span>Wip Products</span>
                                    </a>
                                </li>
                                 <?php
                            } ?>
                        </ul>
                    </li>
                    <li class="back_shadow">
                        <a href="#layout2" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-clipboard "></em>
                            <span>QA Checks</span>
                        </a>
                      <ul id="layout2" class="nav sidebar-subnav collapse" style="background:#272C32">
                        <li class="back_shadow">
                        <a href="#layout_CheckOptions" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-clipboard "></em>
                            <span>Check Options</span>
                        </a>
                            <ul id="layout_CheckOptions" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">QA Checks</li>
                            <?php $permission = true;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'catagories');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'catagories'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='catagories'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Forms Detail</span>
                                    </a>
                                </li>
                                 <?php
                            }?>
                         
                                 <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'wip_profile');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'wip_profile'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='wip_profile'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-outdent"></em>
                                        <span>WIP Form detail</span>
                                    </a>
                                </li>
                                 <?php
                            } ?>  
                            
                           
                        </ul>
                            
                        </li>
                        <li class="back_shadow">
                        <a href="#layout_Check_Details" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-clipboard "></em>
                            <span>Existing Checks</span>
                        </a>
                            <ul id="layout_Check_Details" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">QA Checks</li>
                            <?php 
                          
                            $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_checks');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'product_checks'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='product_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-clipboard"></em>
                                        <span>Standard Checks</span>
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
                                <li class="<?php if($curr_url == 'product_tests'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='product_tests'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-calendar"></em>
                                        <span>Production Checks</span>
                                    </a>
                                </li>
                                <?}?>
                                
                              <?php
                                  $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'herbspice_checks');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'herbspice_checks' || $curr_url == 'herb_attributes' || $curr_url == 'herb_spice'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='herbspice_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-outdent"></em>
                                        <span>Herb Spice Checks</span>
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
                                <li class="<?php if($curr_url == 'scheduled_checks' || $curr_url == 'scheduled_checks' || $curr_url == 'scheduled_checks'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='scheduled_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-outdent"></em>
                                        <span> Scheduled checks</span>
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
                                <li class="<?php if($curr_url == 'static_form'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='static_form'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-tasks "></em>
                                        <span>Static Form Checks</span>
                                    </a>
                                </li>
                                <?php } ?>
                        </ul>
                            
                        </li>
                        </ul>
                        
                    </li>
                <?php
                }
                $permission = false;
                if ($user_data['role'] != 'Admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'outlet');
                else 
                    $permission = true;
                if ($permission){ ?>
                    <li class="back_shadow">
                        <a href="#layout1" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-tasks "></em>
                            <span>Assignments</span>
                        </a>
                        <ul id="layout1" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">Assignments</li>
                            <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/active_checks'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/active_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Active Checks</span>
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
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/overdue_checks'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/overdue_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-close"></em>
                                        <span>Overdue Checks</span>
                                    </a>
                                </li>
                                 <?php
                            } 
                            /*$permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/today_checks'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/today_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Today Checks</span>
                                    </a>
                                </li>
                                 <?php
                            }*/
                            ?>
                        </ul>
                    </li>
                    <li class="back_shadow">
                        <a href="#layout_Admin" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-address-card"></em>
                            <span>Admin Tasks</span>
                        </a>
                        <ul id="layout_Admin" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">Admin Tasks</li>
                            <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product_checks');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/pending_review'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/pending_review'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Pending Review</span>
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
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/pending_approval'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/pending_approval'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Pending Approval</span>
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
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/completed_checks'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/completed_checks'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Completed<br> Assignments</span>
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
                            <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_forms_pending'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/static_forms_pending'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Pending Forms </span>
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
                            <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_forms_reviewed'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/static_forms_reviewed'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Reviewed Forms </span>
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
                            <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_forms_approved'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/static_forms_approved'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Approved Forms </span>
                                    </a>
                                </li>
                                 <?php
                            }
                            
                            ?>
                            
                        </ul>
                    </li>
                   <!-- <li class="back_shadow">
                        <a href="#inspectioin_admin" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-address-card"></em>
                            <span>Inspection Tasks</span>
                        </a>
                        <ul id="inspectioin_admin" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">Inspection Tasks</li>
                            <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/truck_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/truck_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Receiving Inspection Log</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/shipping_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/shipping_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Shipping Inspection</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/palletizing_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/palletizing_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Palletizing Inspection</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/cleaning_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/cleaning_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>cleaning Inspection</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/bulk_tub_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/bulk_tub_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Bulk Pasta Temp. Log<br>(Every Tub)</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/bulk_form_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/bulk_form_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Bulk Pasta Temp. Log<br>(Every Bulk Form)</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/recode_inspection'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/recode_inspection'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-paper-plane "></em>
                                        <span>Recode Inspection</span>
                                    </a>
                                </li>
                                 <?php
                            }?>
                        </ul>
                        </li>-->
                    <?php $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'static_form');
                    else 
                        $permission = true;
                    if ($permission){?>
                       <!-- <li class="<?php if($curr_url == 'static_form'){echo 'active';}    ?>">
                            <a href="<?php $controller='static_form'; 
                                echo ADMIN_BASE_URL . $controller ?>">
                                <i class="fa fa-user "></i>
                                <span>Static Forms</span>
                            </a>
                        </li>-->
                    <?php }?>
                <?php }?>
             <!--  <li class="back_shadow">
                        <a href="#inspectioin_admin" title="Layouts" data-toggle="collapse" >
                            <em class="fa fa-clipboard "></em>
                            <span>Static Checks</span>
                        </a>
                        <ul id="inspectioin_admin" class="nav sidebar-subnav collapse" style="background:#272C32">
                            <li class="sidebar-subnav-header">Static Checks</li>
                            <?php $permission = false;
                            if ($user_data['role'] != 'Admin')
                                $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'assignments');
                            else 
                                $permission = true;
                            if ($permission){?>
                                <li class="<?php if($curr_url == 'static_form'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='static_form'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-tasks "></em>
                                        <span>Checks Detail</span>
                                    </a>
                                </li>
                                <li class="<?php if($curr_url.'/'.$secon_curr_url == 'assignments/static_assignments_detail'){echo 'active';}    ?>" style="padding-left:15px">
                                    <a class="color_check" href="<?php $controller='assignments/static_assignments_detail'; 
                                        echo ADMIN_BASE_URL . $controller ?>">
                                        <em class="fa fa-check"></em>
                                        <span>Submitted Checks </span>
                                    </a>
                                </li>
                                 <?php
                            }?>
                        </ul>
                    </li>-->
                    <!-- <?php $permission = false;
                    if ($user_data['role'] != 'Admin')
                        $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'reports');
                    else 
                        $permission = true;
                    if ($permission){?>
                        <li class="<?php if($curr_url == 'reports'){echo 'active';}    ?>">
                            <a href="<?php $controller='reports'; 
                                echo ADMIN_BASE_URL . $controller ?>">
                                <i class="fa fa-user "></i>
                                <span>Reports</span>
                            </a>
                        </li>
                    <?php }?> -->
            </ul>
        <!-- END sidebar nav-->
        </nav>
    </div>
<!-- END Sidebar (left)-->
</aside>