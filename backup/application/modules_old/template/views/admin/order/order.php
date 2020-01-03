<?php $this->load->view('admin/order/header');?>
<?php //$this->load->view('admin/order/left_panel');?>
<!-- PAGE CONTENT PANEL STARTS HERE-->
<?php 
 	if(!isset($view_file)){
			$viiew_file = '';
		}

 	if(!isset($module)){
			$module = $this->uri->segment(2);
		}
		
	$path = $module.'/'.$view_file;
	
	$this->load->view($path);

 ?>
<!-- PAGE CONTENT PANEL ENDS HERE-->
<?php $this->load->view('admin/order/footer');?>
