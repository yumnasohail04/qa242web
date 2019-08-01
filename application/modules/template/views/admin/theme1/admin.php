<?php 
if($view_file!='chat_listing'){
$this->load->view('admin/theme1/header');
 $this->load->view('admin/theme1/left_panel');
 $this->load->view('admin/theme1/right_panel');
 }?>

<!-- PAGE CONTENT PANEL STARTS HERE-->
<?php if($view_file!='chat_listing'){?>
<section>
<?php }

 	if(!isset($view_file)){
			$view_file = '';
		}
	
 	if(!isset($module)){
			$module = $this->uri->segment(2);
		}
		
	$path = $module.'/'.$view_file;
	
	$this->load->view($path);
 ?>
 <?php if($view_file!='chat_listing'){?>
</section>
<?php }?>
<!-- PAGE CONTENT PANEL ENDS HERE-->
<?php 
if($view_file!='chat_listing')
$this->load->view('admin/theme1/footer');?>
