
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
                  <h2><?php echo $detail['name'] ?></h2>
                  <div id="rotate" class="text-rotate">
                    <div>
                      <p class="home-page-description">Supplier</p>
                    </div>
                    <div>
                      <p class="home-page-description">Supplier Number : <?php echo $detail['supplier_no'] ?></p>
                    </div>
                  </div>

                  <div class="block end" style="text-align: center">
                    <ul class="info-list">
                      <li><span class="title">e-mail</span><span class="value"><?php echo $detail['email'] ?></span></span></li>
                      <li><span class="title">Phone</span><span class="value"><?php echo $detail['phone_no'] ?></span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>
            <!-- End of Home Subpage -->
            
            <!-- About Me Subpage -->
            <section class="pt-page pt-page-2" data-id="supplier_documents">
              <div class="section-title-block">
                <h2 class="section-title">Basic Documents</h2>
                <h5 class="section-description"></h5>
              </div>

              <div class="row">
                <div class="col-sm-6 col-md-6 subpage-block">
                <div class="container">
                    <div class="row">
                    <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
                    </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
                        <div >  
                          <form action="<?php echo BASE_URL.'front/submit_doc' ?>" method="post" class="panel panel-info" enctype="multipart/form-data" style="border: none;">
                            <div class="panel-body" >
                            <div class="row">
                              <input type="hidden" name="id" value="<?php echo $detail['id'] ?>">
                                <div class=" col-md-12 col-lg-12 "> 
                                <div class="supp_type"> 
                                  <select class="form-control" name="supplier_type" id="supplier_type">
                                      <option value="0">Select Supplier Type</option>
                                    <?php foreach($supplier_types as $key =>$value): ?>
                                      <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$detail['supplier_type']) echo "selected"; ?>><?php echo $value['name']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <table class="table table-user-information table_doc">
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
            <!-- End of About Me Subpage -->
            <section class="pt-page pt-page-3" data-id="ingredient_location">
              <div class="section-title-block">
                <h2 class="section-title">Ingredients</h2>
                <h5 class="section-description"></h5>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-12 subpage-block">
                <?php if($detail['supplier_type']=="2"){?>
                  <div class="block-title">
                    <h2 class="section-title">Manufacturer Location</h2>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-12 subpage-block">
                      <div class="block-title">
                      </div>
                        <form id="contact-form" class="ingredient_location_form">
                          <div class="controls">
                            <div class="col-sm-8 col-md-8 subpage-block">
                            <div class="rap_clone">
                              <?php
                              if(isset($parameters) && !empty($parameters)){
                                foreach($parameters as $key => $value){ ?>
                                  <?php 
                                    if(!empty($ingredients)){?>
                                    <div class="row">
                                      <div class="col-sm-5 col-md-5 subpage-block">
                                        <select class="form-control">
                                          <?php 
                                          foreach($ingredients as  $key => $value){ ?> 
                                            <option value="<?php echo $value['ingredient_id'] ?>"><?php echo $value['s_item_name'] ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-sm-5 col-md-5 subpage-block">
                                        <div class="form-group">
                                            <div class='input-group'>
                                              <input type='text' class="form-control" name="loc[]" value=""/>
                                              <span class="input-group-addon">
                                                  <span class="fa fa-map-marker"></span>
                                              </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php 
                                    } ?>
                                    <i class="fa fa-times delete_record cross-icon" rel="<?php echo $value['id'];?>" rel_api="<?php echo $value['api_id'];?>" style="float:left;"></i>
                                  <?php }
                                  }else{ ?>
                                    <?php 
                                      if(!empty($ingredients)){?>
                                      <div class="row">
                                       <div class="col-sm-5 col-md-5 subpage-block">
                                          <select class="form-control">
                                            <?php 
                                            foreach($ingredients as  $key => $value){ ?> 
                                              <option value="<?php echo $value['ingredient_id'] ?>"><?php echo $value['s_item_name'] ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                        <div class="col-sm-5 col-md-5 subpage-block">
                                          <div class="form-group">
                                              <div class='input-group'>
                                                <input type='text' class="form-control" name="loc[]" value=""/>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-map-marker"></span>
                                                </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <?php 
                                      } ?>
                                  <?php  } ?>
                              </div>
                              <div class="form-group m-form__group row">
                                <button class="add_field_button btn btn-primary" style="float:right;margin-right: 30px;">Add Location</button>
							                </div>
                              <div class="col-sm-12 col-md-12 subpage-block">
                                <input type="submit" class="button btn-send ingredient_submit" value="Save locations">
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                  <h2 class="section-title">Upload Documents</h2>
                  <div class="col-sm-12 col-md-12 subpage-block">
                    <table class="table table-user-information">
                      <tbody>
                        <?php
                        $ing_name=$ing_loc="";
                        if(!empty($ingredients_doc)){?>
                            <?php foreach($ingredients_doc as $key => $value){
                                if($value['ing_name']!=$ing_name){?>
                                <tr><td ><h3>Ingredient(<?php echo $value['ing_name']; ?>)</h3></td><tr>
                                <?php } ?>
                                <tr>
                                <td><?php echo $value['doc_name']; ?></td>
                                <td>
                                    <input type="file" name="main_file_<?php echo $key; ?>" id="news_d_files" data-ing-id="<?php echo $value['ing_id']; ?>" data-doc-name="<?php echo $value['doc_name']; ?>" class="file_load">
                                    </td>
                                    <td>
                                    <?php if(!empty($value['document'])){ ?>
                                        <a href="<?php echo BASE_URL.INGREDIENT_DOCUMENTS_PATH.$value['document'];?>" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a>
                                    <?php }else{ ?>
                                        <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>">
                                        
                                    <?php } ?>
                                </td>
                                </tr>
                        <?php
                        $ing_name=$value['ing_name'];
                            }
                        } ?> 
                        </tbody>
                      </table>
                    </div>
                  </div>
            </section>
            <!-- Resume Subpage -->
            <section class="pt-page pt-page-4" data-id="profile_update">
              <div class="section-title-block">
                <h2 class="section-title">Update Profile Information</h2>
                <h5 class="section-description"></h5>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-4 subpage-block">
                  <div class="block-title">
                    <h3>Basic Information</h3>
                  </div>
                  <div class="row">
                <div class="col-sm-12 col-md-12 subpage-block">
                  <div class="block-title">
                  </div>
                  <form id="contact-form" class="profile_form">
                    <div class="controls">
                      <div class="form-group">
                          <input id="form_name" type="text" name="name" class="form-control" placeholder="Full Name" required="required" data-error="Name is required." value="<?php echo $detail['name'] ?>">
                          <div class="form-control-border"></div>
                          <i class="form-control-icon fa fa-user"></i>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                          <input id="form_name" type="text" name="email" class="form-control" placeholder="Email" required="required" data-error="Email is required." value="<?php echo $detail['email'] ?>">
                          <div class="form-control-border"></div>
                          <i class="form-control-icon fa fa-envelope"></i>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                          <input id="form_name" type="text" name="phone" class="form-control" placeholder="Phone#" required="required" data-error="Phone# is required." value="<?php echo $detail['phone_no'] ?>">
                          <div class="form-control-border"></div>
                          <i class="form-control-icon fa fa-phone"></i>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                          <input id="form_name" type="text" name="address" class="form-control" placeholder="Address"  value="<?php echo $detail['address'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                          <input id="form_name" type="text" name="city" class="form-control" placeholder="City" value="<?php echo $detail['city'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                          <input id="form_name" type="text" name="state" class="form-control" placeholder="State"  value="<?php echo $detail['state'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                          <input id="form_name" type="text" name="country" class="form-control" placeholder="Country"  value="<?php echo $detail['country'] ?>">
                          <div class="form-control-border"></div>
                          <div class="help-block with-errors"></div>
                        </div>
                      <input type="submit" class="button btn-send profile_submit" value="Send message">
                    </div>
                  </form>
                </div>
              </div>
              </div>
            </section>
            <!-- End Resume Subpage -->




            <!-- Contact Subpage -->
            <section class="pt-page pt-page-5" data-id="security">
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
                url: "<?php echo BASE_URL?>front/update_password",
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
            url: "<?php echo BASE_URL?>front/profile_update",
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


    $(document).on("change", "#supplier_type", function(event){
            event.preventDefault();
            supplier_data();
    });

    $(document).ready(function(){
      supplier_data();
    });
    function  supplier_data()
      {
        var supplier_type=$('#supplier_type').val();
            $('.table_doc').html('');
            $('.save_btn').html('');
            if(supplier_type!="0"){
              $.ajax({
              type: 'POST',
              url: "<?php echo BASE_URL?>front/get_supplier_documents",
              data: {'supplier_type':supplier_type},
              async: false,
              success: function(result) {
                  $('.table_doc').html(result);
                  $('.save_btn').html('<button id="submited_form" class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i> Save</button>');
              }
          });
        }
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


      $(document).off('change', '.file_load').on('change', '.file_load', function(e){
                e.preventDefault();
                var str=$(this).val();
                var name=$(this).attr("data-doc-name");
                str=str.split("\\"); 
                str = str[str.length - 1];
                str = str.substring( 0, str.indexOf("."));
                var lowerCaseName = name.toLowerCase();
                if(str!=name && str!=lowerCaseName)
                {
                    toastr.error("Document and title name must be same");
                    $(this).val('')
                }else{
                  $(this).parent().parent().find('td').find('img').attr("src","<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>");
                }
            });


  $(document).off("change", "#example39").on("change", "#example39",function(event){
      var type_id=$('#example39').val();
            $('.ing').nextAll('tr').remove();
        $.ajax({
          type: "POST",
          url: "<?php echo BASE_URL?>front/get_doc_name",
          data: {'type_id': type_id},
          success: function(data){
            var html="";
            var ingdt_name="";
            if(data.doc !=""){
            for(var i = 0; i < data.doc.length; i++) {
                    var obj = data.doc[i];
                    if(obj.ing_name!=ingdt_name)
                      html += '<tr><td class="heading">Ingredient('+obj.ing_name+')</td><td><td><td></td><tr>';
                    if(obj.document==null)
                      html += '<tr><td>'+obj.doc_name+'</td><td><input type="file" data-ing_id="'+obj.ing_id+'" data-doc-name="'+obj.doc_name+'" name="main_file_'+i+'" id="news_d_files" class="file_load"></td><td ><img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>"></td></tr>';
                    else
                       html += '<tr><td>'+obj.doc_name+'</td><td><input data-ing_id="'+obj.ing_id+'" data-doc-name="'+obj.doc_name+'" type="file" name="main_file_'+i+'" id="news_d_files" class="file_load"></td><td ><a href="<?php echo BASE_URL.INGREDIENT_DOCUMENTS_PATH?>'+obj.document+'" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a></td></tr>';
                       ingdt_name=obj.ing_name;
                }
            }else
            {
                html += '<tr><td>No Documents to be Uploaded</td></tr>';
            }
            $('.ing').after(html);
            
          }
       });
    });
    $(document).on("click", ".ingredient_submit", function(event){
            event.preventDefault();
            $.ajax({
            type: 'POST',
            url: "<?php echo BASE_URL?>front/ingredient_location",
            data: $(".ingredient_location_form").serialize(),
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
    $(document).ready(function() {
            var max_fields      = 5;
            var wrapper         = $(".input_fields_wrap");
            var add_button      = $(".add_field_button");
            
            var x = 1;
            hyTy = '';
            $(add_button).click(function(e){
                e.preventDefault();
                     $('.rap_clone').append(hyTy);
                     if($('.input_fields_wrap').length == 1){ 
                        
                        $('.wrapclone').find('.chosen-container').remove();
                       
                     } else {
                        $(".wrapclone:last-child").find('.chosen-container').remove();
                     }
                    
                     //$('.chosen-select').chosen();
                     $('.clone-remover').on("click", function(e){
                        $(this).parent().remove();
                    })
            });
            
            $('.clone-remover').on("click", function(e){
        
                e.preventDefault();  $(this).parent().remove();
                 x--;
            })
        });
    </script>