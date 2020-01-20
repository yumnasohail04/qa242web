<?php $this->load->view('front/theme1/'.$header_file);?> <!--HEADER + TOPPANEL-->

<?php if($is_home==1){$this->load->view('front/theme1/header_banner');}?> <!--HEADER BANNER FOR HOME PAGE ONLY-->	

<?php 
if(!isset($view_file)){
	$viiew_file = '';
}
$path = 'front/'.$view_file;
$this->load->view($path);
?>

<?php $this->load->view('front/theme1/footer');?>
