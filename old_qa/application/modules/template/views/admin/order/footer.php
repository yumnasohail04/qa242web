<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
	<div class="footer-inner">
		 <?php echo date("Y"); ?> © Copyright Pizza Milni, All rights reserved. Designed and Developed by <a href="http://www.digitalspinners.com" target="_blank">DigitalSpinners</a>.
	</div>
	<div class="footer-tools">
		<span class="go-top">
			<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/respond.min.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/scripts/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script  src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/scripts/app.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/scripts/form-validation.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/scripts/table-ajax.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/scripts/form-components.js"></script>
<script src="<?php echo base_url(); ?>static/admin/theme1/assets/scripts/popup_ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/admin/theme1/assets/plugins/ckeditor/ckeditor.js"></script>  

<script>

jQuery(document).ready(function(e) {
	
	$(".fancybox-effects-a").fancybox({
			helpers: {
				title : {
					type : 'outside'
				},
				overlay : {
					speedOut : 0
				}
			}
		});
	 
		$('ul.page-sidebar-menu li').mouseenter(function(e) {
			var chk = $(this).hasClass('active');
			var chk2 = $(this).hasClass('open');
			if(chk==false || chk2==true)
			{
				var rel= $(this).find('img:first').attr('rel');
				var src= $(this).find('img:first').attr('src');
				$(this).find('img:first').attr('src',rel);
	
				var chk= $(this).find('img:first').attr('rel2');
				if(typeof chk == "undefined")
					$(this).find('img:first').attr('rel2',src);
			}
		});
		$('ul.page-sidebar-menu li').mouseleave(function(e) {
			var chk = $(this).hasClass('active');
			var chk2 = $(this).hasClass('open');
			if(chk==false && chk2==false)
			{
				var rel= $(this).find('img:first').attr('rel2');
				var src= $(this).find('img:first').attr('src');
				$(this).find('img:first').attr('src',rel);
			}
		});
		
		$('ul.page-sidebar-menu li').click(function(e) {
			$( "ul.page-sidebar-menu li" ).each(function() {
				var chk2 = $(this).hasClass('open');
				if(chk2==true)
				{
					var rel= $(this).find('img:first').attr('rel2');
					var src= $(this).find('img:first').attr('src');
					$(this).find('img:first').attr('src',rel);
				}
			});
		});
		
		
		$('.form_datetime').datetimepicker({
			 format: '<?php echo date_time_format();?>'
		}); 
		
		});
		
	$('.page-sidebar-wrapper .page-sidebar .sidebar-toggler-custom').on('click', changeClass);	
	

	function changeClass() {
			var cls = $(this).find('i').attr('class');
			if(cls == 'fa fa-arrow-circle-left hit arrow-custom'){
				$(this).find('i').removeClass('fa fa-arrow-circle-left hit arrow-custom');
				$(this).find('i').addClass('fa fa-arrow-circle-right hit arrow-custom2');
			}
			else{
				$(this).find('i').removeClass('fa fa-arrow-circle-right hit arrow-custom2');
				$(this).find('i').addClass('fa fa-arrow-circle-left hit arrow-custom');
			}
		}
jQuery(document).ready(function() {       
	App.init();
	TableAjax.init();
	FormValidation.init();
	FormComponents.init();
});
</script>
</body>
<!-- END BODY -->
</html>