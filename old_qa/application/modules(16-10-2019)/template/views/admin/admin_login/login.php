<?php $this->load->view('admin/admin_login/header');?>
<?php 
 	if(!isset($view_file)){
			$viiew_file = '';
		}
	$module = 'login';
 	if(!isset($module)){
			$module = $this->uri->segment(2);
		}
		
	$path = $module.'/'.$view_file;
	$this->load->view($path);

 ?>
<?php $this->load->view('admin/admin_login/footer');?>
