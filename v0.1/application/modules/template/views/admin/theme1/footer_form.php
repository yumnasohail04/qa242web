    <!-- Page footer form-->
    <footer></footer>
    </div><!-- wrapper div ends here -->
    
   <!-- MODERNIZR-->
   <script src="<?php echo STATIC_ADMIN_JS?>modernizr.js"></script>

       <!-- ===================== Toastr ========================= -->
    <script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>

      <!-- MOMENT JS-->
   <script src="<?php echo STATIC_ADMIN_JS?>moment/min/moment-with-locales.min.js"></script>

   <!-- BOOTSTRAP-->
   <script src="<?php echo STATIC_ADMIN_JS?>bootstrap.js"></script>

   <!-- BOOTSTRAP FILEUPLOAD-->
   <script src="<?php echo STATIC_ADMIN_JS?>bootstrap-fileupload.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>bs-filestyle.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>dropify.min.js"></script>
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

   <!-- PARSLEY FORM VALIDATION-->
   <script src="<?php echo STATIC_ADMIN_JS?>parsley.min.js"></script>
   
   <!-- SWEET ALERT-->
    <script src="<?php echo STATIC_ADMIN_JS?>sweetalert.min.js"></script>

  <script src="<?php echo STATIC_ADMIN_JS?>tinymce/tinymce.min.js"></script> 

   <!-- Demo-->
   <script src="<?php echo STATIC_ADMIN_JS?>demo-forms.js"></script>

  <!-- chosen multi select -->
  <script src="<?php echo STATIC_ADMIN_JS?>jquery.dataTables.min.js"></script>   
    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.colVis.js"></script>    
    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.bootstrap.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>dataTables.bootstrapPagination.js"></script>
    <script src="<?php echo STATIC_ADMIN_JS?>demo-datatable.js"></script>   

  <script src="<?php echo STATIC_ADMIN_JS?>bootstrap-select.js"></script>

   <!-- =============== APP SCRIPTS ===============-->
   <script src="<?php echo STATIC_ADMIN_JS?>app.js"></script>
   <script src="https://unpkg.com/feather-icons"></script>
   <script>
      feather.replace()
    </script>
	<div id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
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
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="myModallarge1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ScoreCard Detail</h4>
        </div>
        <div class="modal-body">
          <p>This is a large modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>
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
<script type="text/javascript">
  
<?php 
$arrDate = $this->config->item('Date_Format_Type_JS');
$arrTime = $this->config->item('time_Format_Type_JS');
 ?>

    $('#datetimepicker1').datetimepicker({
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
        format: 'DD/MM/YYYY'
    });

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

     $('.datetimepicker3').datetimepicker({
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
       format: 'DD/MM/YYYY'
    });

       // only time
    $('.datetimepicker4').datetimepicker({
        format: 'HH:mm',
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

    function createLink(uri) {
    var linkId = 'autoloaded-stylesheet',
        oldLink = $('#'+linkId).attr('id', linkId + '-old');

    $('head').append($('<link/>').attr({
      'id':   linkId,
      'rel':  'stylesheet',
      'href': uri
    }));

    if( oldLink.length ) {
      oldLink.remove();
    }

    return $('#'+linkId);
  }

$('.chosen-select').chosen();
 
       
</script>
