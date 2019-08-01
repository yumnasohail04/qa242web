    <!-- Page footer *** -->
    <footer>
      <p class="copy-right">All Rights Reserved by LANTIX<span class="theme-color"></span></p>
    </footer>
    </div><!-- wrapper div ends here -->
    
    <!-- MODERNIZR-->
    <script src="<?php echo STATIC_ADMIN_JS?>modernizr.js"></script>

    <!-- ===================== Toastr ========================= -->
    <script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>

      <!-- MOMENT JS-->
   <script src="<?php echo STATIC_ADMIN_JS?>moment/min/moment-with-locales.min.js"></script>
   
    
    <!-- BOOTSTRAP-->
    <script src="<?php echo STATIC_ADMIN_JS?>bootstrap.js"></script>
    
    <!-- STORAGE API-->
    <script src="<?php echo STATIC_ADMIN_JS?>jquery.storageapi.js"></script>
    
    <!-- JQUERY EASING-->
    <script src="<?php echo STATIC_ADMIN_JS?>jquery.easing.js"></script>
    
    <!-- ANIMO-->
    <script src="<?php echo STATIC_ADMIN_JS?>animo.js"></script>
    
    <!-- SLIMSCROLL-->
    <script src="<?php echo STATIC_ADMIN_JS?>jquery.slimscroll.min.js"></script>
    
    <!-- SCREENFULL-->
    <script src="<?php echo STATIC_ADMIN_JS?>screenfull.js"></script>
    
    <!-- LOCALIZE-->
    <script src="<?php echo STATIC_ADMIN_JS?>jquery.localize.js"></script>

   <!-- CALANDER-->
   <script src="<?php echo STATIC_ADMIN_JS?>bootstrap-datetimepicker.min.js"></script>

    <!-- RTL demo-->
    <script src="<?php echo STATIC_ADMIN_JS?>demo-rtl.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>notify.js"></script>
	<script src="<?php echo STATIC_ADMIN_JS?>notify.min.js"></script>

    <!-- SWEET ALERT-->
    <script src="<?php echo STATIC_ADMIN_JS?>sweetalert.min.js"></script>

    <!-- PARSLEY FORM VALIDATION-->
    <script src="<?php echo STATIC_ADMIN_JS?>parsley.min.js"></script>
   
    <!-- DATATABLES-->
    <script src="<?php echo STATIC_ADMIN_JS?>jquery.dataTables.min.js"></script>   
    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.colVis.js"></script>    
    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.bootstrap.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.bootstrapPagination.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>demo-datatable.js"></script>   
    <!-- FULLCALENDAR-->
    <script src="<?php echo STATIC_ADMIN_JS?>fullcalendar.min.js"></script>
   
    <!-- =============== APP SCRIPTS ===============-->
    <!--<script src="<?php echo STATIC_ADMIN_JS?>app.js"></script>-->
   
   <!---  ************* addition by wasim dated 29-02-2016 for dashboard calendar   **************** -->
   <!-- =============== PAGE VENDOR SCRIPTS ===============-->
   <!-- JQUERY UI-->
   <script src="<?php echo STATIC_ADMIN_JS?>core.js"></script> 
   <script src="<?php echo STATIC_ADMIN_JS?>widget.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>mouse.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>draggable.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>droppable.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>sortable.js"></script>  
   <script src="<?php echo STATIC_ADMIN_JS?>jquery.ui.touch-punch.min.js"></script>  
   <!-- FULLCALENDAR-->
   <!--<script src="<?php echo STATIC_ADMIN_JS?>fullcalendar.min.js"></script>-->
   <script src="<?php echo STATIC_ADMIN_JS?>gcal.js"></script>

      <!-- FLOT CHART-->
   <script src="<?php echo STATIC_ADMIN_JS?>Flot/jquery.flot.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>Flot/jquery.flot.resize.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>Flot/jquery.flot.pie.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>Flot/jquery.flot.time.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>Flot/jquery.flot.categories.js"></script>
   <script src="<?php echo STATIC_ADMIN_JS?>flot-spline/js/jquery.flot.spline.min.js"></script> 


 
   
   <!--- ==============  end added section dated 29-02-2016  ====================================== -->

	<div id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="myModalLabel" class="modal-title"><?php $module = $this->uri->segment(2); 
               if ($module=='catagories') {
                 $modal_title='categories'; echo ucfirst($modal_title); }
                 else{
               $modal_title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $module); echo ucfirst($modal_title); }?>&nbsp;Details</h4>
            </div>
            <div class="modal-body" style="margin-top:0px;"></div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal Large-->
   <div id="myModalLarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
              <h4 id="myModalLabel" class="modal-title"><?php $module = $this->uri->segment(2); 
               if ($module=='outlet') {
                 $modal_title=str_replace($module,"Mosque",$module); echo ucfirst($modal_title); }
                 else{
               $modal_title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $module); echo ucfirst($modal_title); }?>&nbsp;Details</h4>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
         </div>
      </div>
   </div>

   <!-- -==================== PAssword Model =================== -->
   <div id="password_Modal" tabindex="-1" role="dialog" aria-labelledby="Label" aria-hidden="true" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 id="password_Modal_label" class="modal-title">Change Password</h4>
            
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
         </div>
      </div>
   </div>
   <div id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true" class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
              <h4 id="myModalLabel" class="modal-title">Reason</h4>
            </div>
            <div class="modal-body">
              <form action="javascript:void(0)">
          <div class="form-group">
            <label for="exampleFormControlTextarea1">What is the reason?</label>
            <textarea class="form-control reason" id="exampleFormControlTextarea1" rows="3" name="reason"></textarea>
          </div>
          <button type="submit" class="btn btn-primary reason_button">Submit</button>
        </form>
            </div>
            <div class="modal-footer">
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
         </div>
      </div>
   </div>
</body>

<?php 
$arrDate = $this->config->item('Date_Format_Type_JS');
 ?>

<script type="text/javascript">
  
$(document).ready(function() {

	$(document).on("click", ".change_password", function(event){
		event.preventDefault();
		var id = $(this).attr('rel');
		$.ajax({
			type: 'POST',
			url: "<?= ADMIN_BASE_URL ?>users/change_password",
			data: {'id': id},
			async: false,
			success: function(test_body) {
				var test_desc = test_body;
				$('#password_Modal').modal('show')
				$("#password_Modal .modal-body").html(test_desc);
			}
		});
	});
	
	
	uri = '<?php echo STATIC_ADMIN_CSS?>theme-<?=DEFAULT_THEME?>.css';
	var linkId = 'autoloaded-stylesheet';
	$('head').append($('<link/>').attr({
		'id':   linkId,
		'rel':  'stylesheet',
		'href': uri
	}));
	////////////////////////////////////////////////////////////////

   //     $('.datetimepicker2').datetimepicker({
   //    icons: {
   //        time: 'fa fa-clock-o',
   //        date: 'fa fa-calendar',
   //        up: 'fa fa-chevron-up',
   //        down: 'fa fa-chevron-down',
   //        previous: 'fa fa-chevron-left',
   //        next: 'fa fa-chevron-right',
   //        today: 'fa fa-crosshairs',
   //        clear: 'fa fa-trash'
   //      },
   //      //viewMode: 'years',
   //      format: '<?=$arrDate[DEFAULT_DATE_FORMAT]?>'
   //  });


   //    $('.datetimepicker5').datetimepicker({
   //        viewMode: 'months',
   //        format: 'MM/YYYY'
   //    });
   


	
	$("#outlet_dd .dropdown li a").click(function(){
		var outlet_name = $(this).text();
		var outlet_id = $(this).attr('rel');
		
		$.ajax({
			type: "POST",
			url:  "<?=ADMIN_BASE_URL?>outlet/set_outlet_session",
			data: {outlet_id:outlet_id,'outlet_name':outlet_name},
			success: function(){
				<?php $controller = $this->router->fetch_class();?>
				location.href='<?=ADMIN_BASE_URL.$controller?>';
			} 
		});
	});
	////////////////////////////////////////////////////////////////

});

    $(function(){ $('[data-load-css]').on('click', function (e) {
      var element = $(this);
      if(element.is('a'))
        e.preventDefault();
      var uri = element.data('loadCss'),
          link;
        if(uri) {
        link = createLink(uri);
        if ( !link ) {
          $.error('Error creating stylesheet link element.');
        }
      }
      else {
        $.error('No stylesheet location defined.');
      }
       //alert('uri' + uri);

     var res =  uri.slice(-5, -4);
       //alert('res==>' + res);
        $.ajax({
                    type: 'POST',
                    url: "<?=ADMIN_BASE_URL?>general_setting/update_theme",
                    data: {'uri': res},
                    async: false,
                    success: function(test_body) {

        
                    }
                });
      

    });
  });

      
</script>
   <script src="<?php echo STATIC_ADMIN_JS?>app.js"></script>