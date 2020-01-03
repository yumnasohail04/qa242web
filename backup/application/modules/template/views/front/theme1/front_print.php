<?php $this->load->view('front/theme1/header_print');?> <!--HEADER-->

<?php 
    if(!isset($view_file)){$viiew_file = '';}
    $path = 'front/'.$view_file;
    $this->load->view($path);
?> <!--PAGE CONTENT PANEL ENDS HERE-->

<?php $this->load->view('front/theme1/footer_print');?> <!--FOOTER CONTENTS-->
