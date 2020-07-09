<script src="<?php echo STATIC_FRONT_JS ?>pdf.js"></script>
<script src="<?php echo STATIC_FRONT_JS ?>pdf.worker.js"></script>
<script src="<?php echo STATIC_FRONT_JS ?>custom-file-input.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>normalize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>demo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_FRONT_CSS  ?>component.css" />
<style type="text/css">
@media (min-width: 1200px){
  .container {
      width: 1545px;
  }
}

#upload-button {
	width: 210px;
	display: block;
  margin: 22px;
    padding: 8px 30px 8px 35px;
    border: 2px solid #2fc0d1;
    color: black;
    cursor: pointer;
}
td img {
    max-height: 50px;
    width: 50%;
}
#file-to-upload {
	display: none;
}

#pdf-main-container {
	width: 848px;
  max-height: 1200px;
}

#pdf-loader {
	display: none;
	text-align: center;
	color: #999999;
	font-size: 13px;
	line-height: 100px;
	height: 100px;
}

#pdf-contents {
	display: none;
}

#pdf-meta {
	overflow: hidden;
	margin: 0 0 20px 0;
}

#pdf-buttons {
	float: left;
}

#page-count-container {
	float: right;
}

#pdf-current-page {
	display: inline;
}

#pdf-total-pages {
	display: inline;
}

#pdf-canvas {
	border: 1px solid rgba(0,0,0,0.2);
	box-sizing: border-box;
  margin-top: 6px;
  display: inline-block;
    padding: 9% 6% 6% 6%;
    background-color: #505050;
}

#page-loader {
	height: 100px;
	line-height: 100px;
	text-align: center;
	display: none;
	color: #999999;
	font-size: 13px;
}

#download-image {
	width: 150px;
	display: block;
	margin: 20px auto 0 auto;
	font-size: 13px;
	text-align: center;
}

</style>  
<!-- Mobile Header -->
      <div class="mobile-header mobile-visible">
        <div class="mobile-logo-container">
          <div class="mobile-site-title"><?php echo $detail['name'] ?></div>
        </div>

        <a class="menu-toggle mobile-visible">
          <i class="fa fa-bars"></i>
        </a>
      </div>
      <!-- /Mobile Header -->

      <!-- Main Content -->
      <div id="main" class="site-main">
        <!-- Page changer wrapper -->
        <div class="pt-wrapper">
          <!-- Subpages -->
          <div class="subpages">

            <!-- Home Subpage -->
            <section class="pt-page pt-page-1 section-with-bg section-paddings-0" style="background-image: url(<?php echo STATIC_FRONT_IMAGE?>closing-deal.jpg);" data-id="home">
              <div class="home-page-block-bg">
                <div class="mask"></div>
              </div>
              <div class="home-page-block">
                <div class="v-align">
                  <h2>Storage and Distribution </h2>
                  <div id="rotate" class="text-rotate">
                  </div>

                  <div class="block end" style="text-align: center">
                    <ul class="info-list">
                       <li><span class="title">Name</span><span class="value"><?php echo $detail['name'] ?></span></span></li>
                      <li><span class="title">E-mail</span><span class="value"><?php echo $detail['email'] ?></span></span></li>
                      <li><span class="title">Phone</span><span class="value"><?php echo $detail['phone'] ?></span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>
            <!-- End of Home Subpage -->
         
            <!-- Resume Subpage -->
            <section class="pt-page pt-page-3" data-id="profile_update">
              <div class="section-title-block">
                <h2 class="section-title">Update Profile Information</h2>
                <h5 class="section-description"></h5>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-6">
                  <div class="block-title">
                  </div>
                  <div class="row">
                <div class="col-sm-12 col-md-12 ">
                  <div class="block-title">
                  </div>
                  <form id="contact-form" class="profile_form">
                    <div class="controls">
                    <fieldset style="margin: 7% 0 7% 0;">
                          <legend>Basic information</legend>
                      <div class="form-group">
                      <label>Name</label>
                          <input id="form_name" type="text" name="name" class="form-control"  required="required" data-error="Name is required." value="<?php echo $detail['name'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Email</label>
                          <input id="form_name" type="text" name="email" class="form-control"  required="required" data-error="Email is required." value="<?php echo $detail['email'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Contact Person</label>
                          <input id="form_name" type="text" name="contact" class="form-control"  required="required" data-error="Contact Person is required." value="<?php echo $detail['contact'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Phone</label>
                          <input id="form_name" type="text" name="phone" class="form-control"  required="required" data-error="Phone# is required." value="<?php echo $detail['phone'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>City</label>
                          <input id="form_name" type="text" name="city" class="form-control"  value="<?php echo $detail['city'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>State</label>
                          <input id="form_name" type="text" name="state" class="form-control"   value="<?php echo $detail['state'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Address</label>
                          <input id="form_name" type="text" name="address" class="form-control"   value="<?php echo $detail['address'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Zipcode</label>
                          <input id="form_name" type="text" name="zipcode" class="form-control"  value="<?php echo $detail['zipcode'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Type</label>
                          <select class="form-control"  name="type" id="type">
                          <?php foreach($carrier_type as $key => $carier){?>
                              <option  value="<?php echo $carier['id'] ?>" <?php  if($detail['type']==$carier['id']) echo "selected"; ?>><?php echo $carier['type'] ?></option>
                          <?php  } ?>
                          </select>
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        </fieldset>
                        <fieldset style="margin: 7% 0 7% 0;">
                          <legend>Food Safety Emergency Contact information</legend>
                        <div class="form-group">
                        <label>Contact Name</label>
                          <input id="form_name" type="text" name="fse_contactname" class="form-control" value="<?php echo $detail['fse_contactname'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Number</label>
                          <input id="form_name" type="text" name="fse_number" class="form-control" value="<?php echo $detail['fse_number'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <label>Email</label>
                          <input id="form_name" type="text" name="fse_email" class="form-control" value="<?php echo $detail['fse_email'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        </fieldset>
                      <input type="submit" class="button btn-send profile_submit" value="Save">
                    </div>
                  </form>
                </div>
              </div>
              </div>
            </section>
            <!-- End Resume Subpage -->

            <section class="pt-page pt-page-6" data-id="letter">
              <div class="section-title-block">
                <h2 class="section-title">Letter of conformance</h2>
                <h5 class="section-description"></h5>
              </div>
              <p>*Please Sign the Letter of conformance and Upload it, if you haven't yet.<a href="<?php echo STATIC_FRONT_IMAGE.'FSMA TRANSPORTATION template.pdf' ?>" download>Download</a></p> 
              <a id="upload-button">Upload Signed PDF</a> 
              <?php
                $file=STATIC_FRONT_IMAGE.'FSMA TRANSPORTATION template.pdf';
                if(!empty($detail['letter_of_conformance'])){
                  if(file_exists(LETTER_OF_CONFORMANCE_PATH.$detail['letter_of_conformance']))
                      $file=BASE_URL.LETTER_OF_CONFORMANCE_PATH.$detail['letter_of_conformance'];
                } 
              ?>
              <iframe src="<?php echo $file; ?>" style="height: 1200px; width: 848px;"></iframe>
              <form action="<?php echo BASE_URL.'carrier_front/submit_letter' ?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" value="<?php echo $detail['id'] ?>" name="id">
                  <input type="file" id="file-to-upload" name="news_file" value="<?php echo $file; ?>" accept="application/pdf" />
              <div id="pdf-main-container">
                <div id="pdf-loader">Loading document ...</div>
                <div id="pdf-contents">
                
                  <canvas id="pdf-canvas" width="750" height="1200"></canvas>
                  <div id="page-loader">Loading page ...</div>
                  <button type="submit"> Save </button>
                </div>
              </div>
              </form >
            </section>

            <section class="pt-page pt-page-2" data-id="carrier_documents">
              <div class="section-title-block">
                <h2 class="section-title">Basic Documents</h2>
                <h5 class="section-description"></h5>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-12 subpage-block">
                <div class="container">
                    <div class="row">
                    <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
                    </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
                        <div >  
                          <form action="<?php echo BASE_URL.'carrier_front/submit_doc' ?>" method="post" class="panel panel-info" enctype="multipart/form-data" style="border: none;">
                            <div class="panel-body" >
                            <div class="row">
                              <input type="hidden" name="id" value="<?php echo $detail['id'] ?>">
                                <div class=" col-md-12 col-lg-12 "> 
                                <div class="supp_type" style="padding: 0% 0% 4% 0%;"> 
                                  <select class="form-control" name="carrier_type" id="carrier_type" style="width: 12%;">
                                    <?php foreach($carrier_type as $key =>$value): ?>
                                      <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$detail['type']) echo "selected"; ?>><?php echo $value['type']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <h2 class="section-title">Upload Documents</h2>
                                <table class="table table-user-information table_doc table-striped">
                                </table>
                                </div>
                              </div>
                              </div>
                              <div class="save_btn">
                              </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
              </div>
            </section>


            <!-- Contact Subpage -->
            <section class="pt-page pt-page-6" data-id="security">
              <div class="section-title-block">
                <h2 class="section-title">Update Password</h2>
                <h5 class="section-description"></h5>
              </div>

              <div class="row">
                <div class="col-sm-6 col-md-6 subpage-block">
                <form id="contact-form" class="security_form">
                    <div class="controls">
                    <div class="form-group">
                        <input id="form_name" type="text" name="old_password" class="form-control" placeholder="Password" required="  " data-error="Old Password is required.">
                        <div class="form-control-border"></div>
                        <i class="form-control-icon fa fa-lock"></i>
                        <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <input id="form_name" type="text" name="password"  class="form-control password" placeholder="New Password" required="required" data-error="New Password is required.">
                        <div class="form-control-border"></div>
                        <i class="form-control-icon fa fa-lock"></i>
                        <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                        <input id="form_name" type="text" name="c_password" class="form-control old_password" placeholder="Confirm Password" required="required" data-error="Confirm Password.">
                        <div class="form-control-border"></div>
                        <i class="form-control-icon fa fa-lock"></i>
                        <div class="help-block with-errors"></div>
                        </div>
                        
                    <input type="submit" class="button btn-send security_submit" value="Save">
                    </div>
                    </form>
                </div>

              </div>
            </section>

            
            <!-- End Contact Subpage -->

          </div>
        </div>
        <!-- /Page changer wrapper -->
      </div>
      <!-- /Main Content -->
    </div>



    <script>
    /**
 * Chosen: Multiple Dropdown
 */
window.WDS_Chosen_Multiple_Dropdown = {};
( function( window, $, that ) {

	// Constructor.
	that.init = function() {
		that.cache();

		if ( that.meetsRequirements ) {
			that.bindEvents();
		}
	};

	// Cache all the things.
	that.cache = function() {
		that.$c = {
			window: $(window),
			theDropdown: $( '.dropdown' ),
		};
	};

	// Combine all events.
	that.bindEvents = function() {
		that.$c.window.on( 'load', that.applyChosen );
	};

	// Do we meet the requirements?
	that.meetsRequirements = function() {
		return that.$c.theDropdown.length;
	};

	// Apply the Chosen.js library to a dropdown.
	// https://harvesthq.github.io/chosen/options.html
	that.applyChosen = function() {
		that.$c.theDropdown.chosen({
			inherit_select_classes: true,
			width: '100%',
		});
	};

	// Engage!
	$( that.init );

})( window, jQuery, window.WDS_Chosen_Multiple_Dropdown );
    </script>
    <script>
     $(document).on("click", ".security_submit", function(event){
            event.preventDefault();
            var pass=$('.password').val();
            var old_pass=$('.old_password').val();
            if(pass==old_pass){
              $.ajax({
                type: 'POST',
                url: "<?php echo BASE_URL?>carrier_front/update_password",
                data: $(".security_form").serialize(),
                async: false,
                success: function(result) {
                    var status= $(result).find('status').text();
                    var message= $(result).find('message').text();
                    if(status==true)
                    {
                        toastr.success(message);
                        $('.security_form')[0].reset();
                    }
                    else{
                        toastr.error(message);
                    }
                }
            });
        }
        else
        {
            toastr.error("Password doesn't Match");
        }
    });
    $(document).on("click", ".profile_submit", function(event){
            event.preventDefault();
            $.ajax({
            type: 'POST',
            url: "<?php echo BASE_URL?>carrier_front/profile_update",
            data: $(".profile_form").serialize(),
            async: false,
            success: function(result) {
                var status= $(result).find('status').text();
                var message= $(result).find('message').text();
                if(status==true)
                {
                    toastr.success(message);
                }
                else{
                    toastr.error(message);
                }
            }
        });
    });

    
    $(document).on("change", "#carrier_type", function(event){
            event.preventDefault();
            carrier_data();
    });

    $(document).ready(function(){
      carrier_data();
    });
    function  carrier_data()
      {
        var carrier_type=$('#carrier_type').val();
            $('.table_doc').html('');
            $('.save_btn').html('');
            if(carrier_type!="0"){
              $.ajax({
              type: 'POST',
              url: "<?php echo BASE_URL?>carrier_front/get_carrier_documents",
              data: {'carrier_type':carrier_type},
              async: false,
              success: function(result) {
                  $('.table_doc').html(result);
                  $('.save_btn').html('<button id="submited_form" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i> Save</button>');
              }
          });
        }
        file_image_change();
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
  }

file_image_change();
function file_image_change(){
  $(document).off('change', '.file_load').on('change', '.file_load', function(e){
      e.preventDefault();
      // var name=$(this).attr("data-doc-name");
      // str=str.split("\\"); 
      // str = str[str.length - 1];
      // str = str.substring( 0, str.indexOf("."));
      // var lowerCaseName = name.toLowerCase();
      // if(str!=name && str!=lowerCaseName)
      // {
      //     toastr.error("Document and title name must be same");
      //     $(this).val('')
      // }else{
        $(this).parent().parent().parent().find('td').find('img').attr("src","<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>");
      // }
  });
}


</script>


<script>

var __PDF_DOC,
	__CURRENT_PAGE,
	__TOTAL_PAGES,
	__PAGE_RENDERING_IN_PROGRESS = 0,
	__CANVAS = $('#pdf-canvas').get(0),
	__CANVAS_CTX = __CANVAS.getContext('2d');

function showPDF(pdf_url) {
  $("#pdf-loader").show();
  $("iframe").hide();

	PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
		__PDF_DOC = pdf_doc;
		__TOTAL_PAGES = __PDF_DOC.numPages;
		
		// Hide the pdf loader and show pdf container in HTML
    $("#pdf-loader").hide();
    $("iframe").hide();
		$("#pdf-contents").show();
		$("#pdf-total-pages").text(__TOTAL_PAGES);

		// Show the first page
		showPage(1);
	}).catch(function(error) {
		// If error re-show the upload button
		$("#upload-button").show();
		
		alert(error.message);
	});;
}

function showPage(page_no) {
	__PAGE_RENDERING_IN_PROGRESS = 1;
	__CURRENT_PAGE = page_no;

	// Disable Prev & Next buttons while page is being loaded
	$("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

	// While page is being rendered hide the canvas and show a loading message
	$("#pdf-canvas").hide();
	$("#page-loader").show();
  $("#download-image").hide();
  $("iframe").hide();

	// Update current page in HTML
	$("#pdf-current-page").text(page_no);
	
	// Fetch the page
	__PDF_DOC.getPage(page_no).then(function(page) {
		// As the canvas is of a fixed width we need to set the scale of the viewport accordingly
		var scale_required = __CANVAS.width / page.getViewport(1).width;

		// Get viewport of the page at required scale
		var viewport = page.getViewport(scale_required);

		// Set canvas height
		__CANVAS.height = viewport.height;

		var renderContext = {
			canvasContext: __CANVAS_CTX,
			viewport: viewport
		};
		
		// Render the page contents in the canvas
		page.render(renderContext).then(function() {
			__PAGE_RENDERING_IN_PROGRESS = 0;

			// Re-enable Prev & Next buttons
			$("#pdf-next, #pdf-prev").removeAttr('disabled');

			// Show the canvas and hide the page loader
			$("#pdf-canvas").show();
			$("#page-loader").hide();
      $("#download-image").show();  
      $("iframe").hide();
		});
	});
}

// Upon click this should should trigger click on the #file-to-upload file input element
// This is better than showing the not-good-looking file input element
$("#upload-button").on('click', function() {
	$("#file-to-upload").trigger('click');
});

// When user chooses a PDF file
$("#file-to-upload").on('change', function() {
  alert();
	// Validate whether PDF
    if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
        alert('Error : Not a PDF');
        return;
    }

	// Send the object url of the pdf
	showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
});

// Previous page of the PDF
$("#pdf-prev").on('click', function() {
	if(__CURRENT_PAGE != 1)
		showPage(--__CURRENT_PAGE);
});

// Next page of the PDF
$("#pdf-next").on('click', function() {
	if(__CURRENT_PAGE != __TOTAL_PAGES)
		showPage(++__CURRENT_PAGE);
});

// Download button


</script>