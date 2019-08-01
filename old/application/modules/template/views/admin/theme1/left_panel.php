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
                if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'dashboard');
                else  
                    $permission = true;
                      
                if ($permission){?>
                    <li class="<?php if($curr_url == 'dashboard'){echo 'active';}   ?>">
                        <a href="<?php $controller='dashboard'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <?php
                }?>
                <?php $permission = false;
                if ($user_data['role'] != 'portal admin')
					$permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'users');
                else 
					$permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'users'){echo 'active';}    ?>">
                        <a href="<?php $controller='users'; 
							echo ADMIN_BASE_URL . $controller ?>">
							<i class="fa fa-users "></i>
							<span>Users</span>
                        </a>
                    </li>
                <?php }
                
                if ($user_data['role'] != 'portal admin')
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

                if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id,'product');
                else 
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'product'){echo 'active';}    ?>">
                        <a href="<?php $controller='product'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa fa-tasks "></i>
                            <span>Products</span>
                        </a>
                    </li>
              
                <?php
                }?>
            </ul>
        <!-- END sidebar nav-->
        </nav>
    </div>
<!-- END Sidebar (left)-->
</aside>