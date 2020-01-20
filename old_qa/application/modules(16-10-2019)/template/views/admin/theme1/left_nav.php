<!--<ul class="page-sidebar-menu">-->
   
     <?php 
                if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'dashboard');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'dashboard'){echo 'active';}   ?>">
                        <a href="<?php $controller='dashboard'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/home_colored.png'?>" alt="home.png" src="<?php echo base_url().'static/admin/theme1/images/home.png'?>">
                            </i> <span class="title">Dashboard</span> 
                           
                        </a>
                    </li>
                     <?php
                } 
				
				 if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'webpages');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'webpages'){echo 'active';}   ?>">
                        <a href="<?php $controller='webpages'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/page_hover.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/page.png'?>" alt="page.png" src="<?php echo base_url().'static/admin/theme1/images/page.png'?>">
                            </i> <span class="title">Webpages</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				
				 if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'categories');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'categories'){echo 'active';}   ?>">
                        <a href="<?php $controller='categories'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/categories_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/categories.png'?>" alt="page.png" src="<?php echo base_url().'static/admin/theme1/images/page.png'?>">
                            </i> <span class="title">Categories</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				 if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'products');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'products'){echo 'active';}   ?>">
                        <a href="<?php $controller='products'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/products_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/products.png'?>" alt="products.png" src="<?php echo base_url().'static/admin/theme1/images/products.png'?>">
                            </i> <span class="title">Products</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				 if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'sales');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'sales'){echo 'active';}   ?>">
                        <a href="<?php $controller='sales'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/sale_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/sale.png'?>" alt="sale.png" src="<?php echo base_url().'static/admin/theme1/images/sale.png'?>">
                            </i> <span class="title">Sales</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				 if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'orders');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'orders'){echo 'active';}   ?>">
                        <a href="<?php $controller='orders'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/order_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/order.png'?>" alt="order.png" src="<?php echo base_url().'static/admin/theme1/images/order.png'?>">
                            </i> <span class="title">Orders</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				
				 if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'add_on');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'add_on'){echo 'active';}   ?>">
                        <a href="<?php $controller='add_on'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/addon_icon_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/addon_icon.png'?>" alt="addon_icon.png" src="<?php echo base_url().'static/admin/theme1/images/addon_icon.png'?>">
                            </i> <span class="title">Add On</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'customers');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'customers'){echo 'active';}   ?>">
                        <a href="<?php $controller='customers'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/customer.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/customer.png'?>" alt="customer.png" src="<?php echo base_url().'static/admin/theme1/images/customer.png'?>">
                            </i> <span class="title">Customers</span> 
                           
                        </a>
                    </li>
                     <?php
                }?>
        <?php  
		    $arr_temp_module=array('users','roles');
			$permission_m=false;
		  if ($user_data['role'] != 'portal admin') 
                    $permission_m = Modules:: run('permission/has_control_permission_array',$role_id,$outlet_id=DEFAULT_OUTLET,$arr_temp_module);
		       else  
                    $permission_m = true;
       
	  if ($permission_m==true) {
	  ?>
         <li class=""> <a href="<?php echo ADMIN_BASE_URL.'dashboard'?>"><i class="fa"><img rel="<?php echo base_url() . 'static/admin/theme1/images/hr_colored.png'?>" alt="hr.png" src="<?php echo base_url() . 'static/admin/theme1/images/hr.png'?>" rel2="<?php echo base_url() . 'static/admin/theme1/images/hr.png'?>"></i> <span class="title"> Human Resources </span> <span class="arrow"></span></a>
         <ul class="sub-menu">
           <?php if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'users');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'users'){echo 'active';}   ?>">
                        <a href="<?php $controller='users'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/users_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/users.png'?>" alt="users.png" src="<?php echo base_url().'static/admin/theme1/images/users.png'?>">
                            </i> <span class="title">Employees</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'roles');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'roles'){echo 'active';}   ?>">
                        <a href="<?php $controller='roles'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/roles_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/roles.png'?>" alt="users.png" src="<?php echo base_url().'static/admin/theme1/images/roles.png'?>">
                            </i> <span class="title">Roles</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				 ?>

				 </ul>
    </li>
    <?php }
	
	 $arr_temp_module=array('outlet','general_setting','pos');
			$permission_m=false;
		  if ($user_data['role'] != 'portal admin') 
                    $permission_m = Modules:: run('permission/has_control_permission_array',$role_id,$outlet_id=DEFAULT_OUTLET,$arr_temp_module);
		       else  
                    $permission_m = true;
       
	  if ($permission_m==true) {
	
	 ?>
   
    <li class=""><a href="<?php echo ADMIN_BASE_URL.'dashboard'?>"> <i class="fa"><img rel="<?php echo base_url() . 'static/admin/theme1/images/setup_colored.png'?>" alt="setup.png" src="<?php echo base_url() . 'static/admin/theme1/images/setup.png'?>" rel2="<?php echo base_url() . 'static/admin/theme1/images/setup.png'?>"></i> <span class="title"> Setup </span> <span class="arrow"> </span> </a>                
    	<ul class="sub-menu">

    <?php 
	
	if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'outlet');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'outlet'){echo 'active';}   ?>">
                        <a href="<?php $controller='outlet'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/outlet_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/outlet.png'?>" alt="outlet.png" src="<?php echo base_url().'static/admin/theme1/images/outlet.png'?>">
                            </i> <span class="title">Outlets</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'general_setting');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'general_setting'){echo 'active';}   ?>">
                        <a href="<?php $controller='general_setting'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/setting_colored.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/setting.png'?>" alt="setting.png" src="<?php echo base_url().'static/admin/theme1/images/setting.png'?>">
                            </i> <span class="title">General Setting</span> 
                           
                        </a>
                    </li>
                     <?php
                }
				
				if ($user_data['role'] != 'portal admin')
                    $permission = Modules:: run('permission/has_control_permission',$role_id,$outlet_id=DEFAULT_OUTLET,'pos');
                else  
                    $permission = true;
                if ($permission){?>
                    <li class="<?php if($curr_url == 'pos'){echo 'active';}   ?>">
                        <a href="<?php $controller='pos'; 
                            echo ADMIN_BASE_URL . $controller ?>">
                            <i class="fa">
                            <img rel="<?php echo base_url().'static/admin/theme1/images/customer.png'?>" rel2="<?php echo base_url().'static/admin/theme1/images/customer.png'?>" alt="setting.png" src="<?php echo base_url().'static/admin/theme1/images/customer.png'?>">
                            </i> <span class="title">Pos</span> 
                           
                        </a>
                    </li>
                     <?php
                }
	
				
				 ?>
       
      </ul>
     </li>
<?php } ?>
    
    
    

    <li class="sidebar-toggler-wrapper"><div class="sidebar-toggler hidden-phone"></div></li>

    <!--</ul>-->