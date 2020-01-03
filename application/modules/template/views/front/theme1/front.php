<?php 
$this->load->view('front/theme1/'.$header_file);?> <!--HEADER + TOPPANEL-->
	

<?php 
if(!isset($view_file)){
	$viiew_file = '';
}
$path = 'front/'.$view_file;
$this->load->view($path);
?>

<?php $this->load->view('front/theme1/footer');?>
