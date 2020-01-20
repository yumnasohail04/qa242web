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
    <script src="<?php echo STATIC_ADMIN_JS?>demo-flot.js"></script>
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

   <script src="https://unpkg.com/feather-icons"></script>
 
   <script>
      feather.replace()
    </script>
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
   
	<div id="myModalassignment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
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
      <div class="modal-dialog modal-lg" >
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
              <h4 id="myModalLabel" class="modal-title">
              <?php $module = $this->uri->segment(2); 
               if ($module=='outlet') {
                 $modal_title=str_replace($module,"Mosque",$module); echo ucfirst($modal_title); }
                 else{
               $modal_title = preg_replace('/[^a-zA-Z0-9]+/', ' ', $module); echo ucfirst($modal_title); }?>&nbsp;Details</h4>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
              
            </div>
         </div>
      </div>
   </div>
   
   <div id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true" class="modal fade">
      <div class="modal-dialog modal-lg" style="    bottom: 0px;position: absolute;right: 0;    margin-bottom: 0px;">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
              <h4 id="myModalLabel" class="modal-title">Chat</h4>
            </div>
            <div class="modal-body" style="padding: 0px;">...</div>
            <div class="modal-footer">
              
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
             
            </div>
         </div>
      </div>
   </div>
    <div id="product_schedules" tabindex="-1" role="dialog" aria-labelledby="product_schedules" aria-hidden="true" class="modal fade">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 id="password_Modal_label" class="modal-title">Product Schedules</h4>
                  </div>
                  <div class="modal-body"></div>
                  <div class="modal-footer">
                  </div>
              </div>
          </div>
      </div>
    <div id="adding_plant" tabindex="-1" role="dialog" aria-labelledby="adding_plant" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="password_Modal_label" class="modal-title">Adding Plant</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>
    <div id="adding_shift" tabindex="-1" role="dialog" aria-labelledby="adding_shift" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="password_Modal_label" class="modal-title">Adding Shift</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>
  <div id="adding_shift_timing" tabindex="-1" role="dialog" aria-labelledby="adding_shift_timing" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="password_Modal_label" class="modal-title">Adding Shift</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>
  <div id="adding_line" tabindex="-1" role="dialog" aria-labelledby="adding_line" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="password_Modal_label" class="modal-title">Adding Lines</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
  </div>
      <div id="upload_file" tabindex="-1" role="dialog" aria-labelledby="upload_file" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="password_Modal_label" class="modal-title">Product Schedules</h4>
                </div>
                <div class="modal-body">
                  
                </div>
                <div class="modal-footer">
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
    <div id="truct_inspection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
        <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                 </button>
                 <h4 id="myModalLabel" class="modal-title">Details</h4>
              </div>
              <div class="modal-body">
                  <ul class="list-group">
                      <li class="list-group-item"><b>Description:</b> John Doe</li>
                     
                  </ul>
              </div>
              <div class="modal-footer">
                 <button type="button" data-dismiss="modal" class="btn btn-default  pull-right">Close</button>
              </div>
           </div>
        </div>
    </div>
</body>
<?php 
$arrDate = $this->config->item('Date_Format_Type_JS');
$arrTime = $this->config->item('time_Format_Type_JS');
 ?>
<?php if(!isset($chat_only)) { ?>
  <script src="https://www.gstatic.com/firebasejs/5.11.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/5.11.1/firebase-firestore.js"></script>
  <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
  <script>
    var firebaseConfig = <?=DEFAULT_FCM_CONFIGURATION?>;
    firebase.initializeApp(firebaseConfig);
  </script>
<?php } ?>
<script type="text/javascript">
$(document).on("click", ".view_chat", function(event){
    event.preventDefault();
    $.ajax({
      type: 'POST',
      url: "<?= ADMIN_BASE_URL ?>chat/show_chat",
      data: {},
      async: false,
      success: function(test_body) {
        var test_desc = test_body;
        $('#chat_modal').modal('show')
        $("#chat_modal .modal-body").html(test_desc);
      }
    });
  });
$(document).ready(function() {
    <?php if(!isset($dashboard_file)) { ?>
        $('.chosen-select').chosen();
    <?php } ?>
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
	
/*	
	uri = '<?php echo STATIC_ADMIN_CSS?>theme-<?=DEFAULT_THEME?>.css';
	var linkId = 'autoloaded-stylesheet';
	$('head').append($('<link/>').attr({
		'id':   linkId,
		'rel':  'stylesheet',
		'href': uri
	}));*/
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
   //      format: ''
   //  });


   //    $('.datetimepicker5').datetimepicker({
   //        viewMode: 'months',
   //        format: 'MM/YYYY'
   //    });
   

     $('.datetimepicker2').datetimepicker({
      icons: {
          time: 'fa fa-clock-o',
          date: 'fa fa-calendar',
          up: 'fa fa-chevron-up',
          down: 'fa fa-chevron-down',
          previous: 'fa fa-chevron-left',
          next: 'fa fa-chevron-right',
          today: 'fa fa-crosshairs',
          clear: 'fa fa-trash'
        },
        //viewMode: 'years',
        format:'MM/DD/YYYY'
    });


	
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
      function date() {
        $('.date').datetimepicker({
            format: 'HH:mm'
        });
      }
      date();
	<?php if(!isset($chat_only)) {
      if(!isset($total_counter) || empty($total_counter))
        $total_counter = 0;
      if(!isset($tracker_list) || empty($tracker_list))
        $tracker_list = array();
    ?>
      var notificationlist = {'counter':<?=$total_counter?>,data:[
        <?php $counter = 0; foreach($tracker_list as $key=>$tl):
          if($counter != 0)
            echo ",";
          echo "{'tracking':'".$tl["trackig_id"]."','lastcheater':".$tl["last_chat"]."}";
          $counter++;
        endforeach;
        ?>
      ]}
      notificationlist.data.forEach(function(item){
        getRealtimeUpdatess(item.tracking)
      })
      function findIndexInData(data, property, value) {
        var result = -1;
        data.some(function (item, i) {
          if (item[property] === value) {
            result = i;
            return true;
          }
        });
        return result;
      }
      function getRealtimeUpdatess(tracking){
        var user = '<?=$this->session->userdata['user_data']['user_id']?>';
        var index = findIndexInData(notificationlist.data, 'tracking', tracking)
        if(index != -1) {
          var chat_id = notificationlist.data[index].lastcheater;
          var chatRef = firebase.firestore().collection('/<?=DEFAULT_FCM_PROJECT?>/<?=DEFAULT_DOCUMENT_NAME?>/'+tracking).where("chat_id",">",chat_id).limit(1);
          chatRef.onSnapshot(function(querySnapshot){
            querySnapshot.forEach(function(doc) {
              if(doc.data().chat_id > chat_id){
                console.log(notificationlist.counter +'=='+doc.data().chat_id +'=='+ chat_id)
                  counter = parseInt(notificationlist.counter)+1;
                  notificationlist.counter = counter
                  notificationlist.data[index].lastcheater = doc.data().chat_id
                  messagecounter()

              }
              getRealtimeUpdatess(tracking);
            });
          });
        }
      }
      function messagecounter(){
        if(!$('.message-counter').find('.badge').length){
          $('.message-counter').append('<span class="badge">'+notificationlist.counter+'</span>')
        }
        else {
          $('.message-counter').find('.badge').text(notificationlist.counter)
        }
      }
      messagecounter()
    <?php }?>
      
</script>
   <script src="<?php echo STATIC_ADMIN_JS?>app.js"></script>