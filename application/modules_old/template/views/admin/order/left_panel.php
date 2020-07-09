<?php
$user_data = $this->session->userdata('user_data');
$role_id = $user_data['outlets_n_roles'][DEFAULT_OUTLET];
if ($user_data['role'] != 'portal admin')
$navigation = Modules:: run('permission/get_navigation', $role_id, DEFAULT_OUTLET);
else
$navigation = Modules:: run('permission/get_navigation', $role_id, 1);

$module_icons = $this->config->item('module_icons');
$module_icons_hover = $this->config->item('module_icons_hover');
$sub_modules = $this->config->item('sub_modules');
$curr_url = $this->uri->segment(2);
$module_name = $this->uri->segment(3);

$arrMain = array('dashboard','webpages','categories','products');
$arrHr = array('users','roles');
$arrSetup = array('outlet', 'general_setting');
?>

<div class="clearfix"></div>
<div class="page-container">
<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <div class="user_area hidden" id="user_area">
      <div class="clearfix"></div>
      <div class="user_name">
        <?php $user_data = $this->session->userdata('user_data');echo "Welcome, ".$user_data['name'];?>
      </div>
    </div>
    <ul class="page-sidebar-menu">
   		 <?php
            if(isset($navigation) && !empty($navigation)){ foreach ($navigation as $controller => $method):
            if (in_array($controller, $arrMain)):
            ?>
          <li class="<?php if($curr_url == $controller){echo 'active';}    ?>"> <a href="<?php echo ADMIN_BASE_URL . $controller ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons[$controller] ?>" alt="<?php echo $module_icons[$controller]; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover[$controller] ?>" /></i>
            <?php echo ucwords(substr(str_replace('_', ' ', $controller), 0, 20));?>
            </a> </li>
          <?php endif; ?>
          <?php endforeach; 
            } ?>
      <li class="<?php if(in_array($curr_url, $arrHr)){echo 'active';}    ?>">
        <?php if(in_array($curr_url, $arrHr))
            {
            ?>
        <a href="<?php echo ADMIN_BASE_URL . "dashboard" ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons['hr'] ?>" alt="<?php echo $module_icons['hr']; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover['hr'] ?>" /></i> <span class="title"> Human Resources </span> <span class="arrow"> </span> </a>
        <? } 
            else
            {
            ?>
        <a href="<?php echo ADMIN_BASE_URL . "dashboard" ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons['hr'] ?>" alt="<?php echo $module_icons['hr']; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover['hr'] ?>" /></i> <span class="title"> Human Resources </span> <span class="arrow"> </span> </a>
        <? } ?>
        <ul class="sub-menu">
          <?php
            if(isset($navigation) && !empty($navigation)){ foreach ($navigation as $controller => $method):
            if (in_array($controller, $arrHr)):
            ?>
          <li class="<?php if($curr_url == $controller){echo 'active';}    ?>"> <a href="<?php echo ADMIN_BASE_URL . $controller ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons[$controller] ?>" alt="<?php echo $module_icons[$controller]; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover[$controller] ?>" /></i>
            <?php if($controller=='users'){echo 'Employees';} elseif($controller=='leave'){echo 'Absence Registration';} else{echo ucwords(substr(str_replace('_', ' ', $controller), 0, 20));}?>
            </a> </li>
          <?php endif; ?>
          <?php endforeach; 
            } ?>
        </ul>
      </li>
      <li class="<?php if(in_array($curr_url, $arrSetup)){echo 'active';}    ?>">
        <?php if(in_array($curr_url, $arrSetup))
            {
            ?>
        <a href="<?php echo ADMIN_BASE_URL . "dashboard" ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons['setup'] ?>" alt="<?php echo $module_icons['setup']; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover['setup'] ?>" /></i> <span class="title"> Setup </span> <span class="arrow"> </span> </a>
        <? } 
            else
            {
            ?>
        <a href="<?php echo ADMIN_BASE_URL . "dashboard" ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons['setup'] ?>" alt="<?php echo $module_icons['setup']; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover['setup'] ?>" /></i> <span class="title"> Setup </span> <span class="arrow"> </span> </a>
        <? } ?>
        <ul class="sub-menu">
          <?php
            if(isset($navigation) && !empty($navigation)){
            foreach ($navigation as  $controller => $method):
            if (in_array($controller, $arrSetup)):
            ?>
          <li class="<?php if($curr_url == $controller){echo 'active';}    ?>"> <a href="<?php echo ADMIN_BASE_URL . $controller ?>"> <i class="fa"><img src="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons[$controller] ?>" alt="<?php echo $module_icons[$controller]; ?>"  rel="<?php echo base_url() . 'static/admin/theme1/images/' . $module_icons_hover[$controller] ?>" /></i>
            <?php if($controller=='outlet'){echo 'Outlets';} else{ echo ucwords(substr(str_replace('_', ' ', $controller), 0, 20));}?>
            </a> </li>
          <?php endif; ?>
          <?php endforeach; 
            }
            ?>
        </ul>
      </li>
    </ul>
    </li>
    
    <!-- END SIDEBAR MENU -->
    <div class="sidebar-toggler sidebar-toggler-custom  hidden-phone"> <i class="fa fa-arrow-circle-left hit arrow-custom"></i> </div>
  </div>
</div>
