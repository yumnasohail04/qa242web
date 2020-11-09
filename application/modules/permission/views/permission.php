    <style>
.pull-left
{	
	width:25%;
}
</style>                            
  <main>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <h1> Permissions &nbsp(<?php
      $role_show = $this->uri->segment(6);
      echo urldecode($role_show);
      ?>) </h1>
        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'roles'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
        <div class="separator mb-5"></div>
      </div>
    </div>
<div class="card mb-4">
  <div class="card-body">
    <h5 class="mb-4">
    
      </h5>
            <?php
            $attributes = array('autocomplete' => 'off', 'id' => 'frmUser');
			echo form_open(ADMIN_BASE_URL.'permission/submit/');
			?>
			<!--<div class="form-group">
    <label class="col-xs-5 col-sm-5 col-md-5 padding_up both_p control-label">Select Role:</label>
    <div class="col-xs-7 col-sm-7 col-md-7 both_p">
 <?php
	/*$options = array('0'=> '---select--') + $roles;
	echo form_dropdown('lstRoles', $options, $role_id, 'class = "form-control select2me" data-placeholder="Select Role...", id="lstRoles"');*/
 ?>
    </div>

			</div>-->
			<?php $role = $this->uri->segment(4);   ?>
			<input type="hidden" id="lstRoles" name="lstRoles" value=<?php echo $role ?> />
            <div style="margin-bottom:5px;"></div>
            <div class="clearfix"></div> 
  			<?php $count=1; if($rights != NULL): foreach($rights as $controller):
  			if(!empty($controller['methods'])){
  			?>
			<div class="panel panel-default margin_up" id="<?php echo $controller['id'];?>">
			  <!-- Default panel contents -->
			  <div class="panel-heading p_back badge-primary"> 
              <?php 
				$data = array(
				'name'        => 'chk_all',
				'id'          => 'selectall_'.$controller['id'],
				 'class'	  => 'selectall',	
				'value'       => $controller['id'].'_0',
				'checked'     => $controller['checked'],
				'style'       => 'margin:10px;',
				);
				echo form_checkbox($data);
				$hdn_val = '';
				if($controller['checked'] == 'checked'){$hdn_val = $controller['id'].'_0';}
				echo form_input(array('name' => 'chkRight[]', 'type'=>'hidden', 'value' =>$hdn_val, 'id' => 'ctrl_'.$controller['id'],'class'=>'ctrl'));
			  ?>
              	<span style="font-weight:bold;"><?php if($controller['right'] == 'outlet'){ echo "Station";} else{ echo ucwords(str_replace('_',' ',$controller['right']));};?></span></div>
				<div class="row col-xs-12 col-sm-12 col-md-12">
                <?php
//                echo '<pre>';print_r($controller);echo '</pre>';
				?>
                 <?php if(isset($controller['methods'])): foreach($controller['methods'] as $method):


                 ?>

				<div class="pull-left">
				<?php 
                    $data = array(
                    'name'        => 'chkRight[]',
                    'id'          => 'chkMethod_'.$method['id'],
					'class'		  => 'case',	
                    'value'       => $method['id'].'_'.$controller['id'],
                    'checked'     => $method['checked'],
                    'style'       => 'margin:10px',
                    );
                    echo form_checkbox($data);
                ?>
                <span><?php 
					if($method['right'] == 'index'){
						echo'View All';
					}
					else{
						 echo ucwords(str_replace('_',' ',$method['right'])); 
                        }
                    ?>
                    </span>
                    </div>
                    <?php  endforeach; endif;?>
				</div>

			</div>
            <div class="clearfix"></div>
          
    		<?php }	endforeach; 
			?>
           <div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9" style="margin-left:-15px; margin-top:30px">
            <?php
            $data = array(
				  'name'        => 'btnSubmit',
				  'id'          => 'btnSubmit',
				  'class'   	=> 'btn btn-outline-primary btn-save',
				  'value'       => 'Save',
				);
			echo form_submit($data);
			?>
            </div>
           
            <?php
			endif;

			echo form_close();
			?>
			</div>
		
										<!-- END FORM-->
									</div>
								</div>
							</div>
</main>
<script type="text/javascript">
$(document).ready(function(){
toastr.options = {
"closeButton": true,
"debug": false,
"positionClass": "toast-top-right",
"onclick": null,
"showDuration": "1000",
"hideDuration": "1000",
"timeOut": "5000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
}
});
$(document).ready(function() {
    $('.selectall').click(function(event) {  //on click 
		var parent_id = $(this).parent().parent().attr('id');
		//alert(parent_id );
		if($(this).is(':checked'))
		{
			$('#'+parent_id +' .case').each(function() { //loop through each checkbox
                this.checked = true; //deselect all checkboxes with class "checkbox1"                       
            });
		}
		else
		{
			$('#'+parent_id +' .case').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });
		}
       /* 
	   if($(this).is(':checked'))
		{
			alert('heere 1');
			$('#'+parent_id + ' .case').checked = true;
		}
		else
		{
			alert('heere 2');
			$('#'+parent_id + ' .case').checked = false;	
		}
	   
	   
	   //if(parent_id) { // check select status
            $('#'+parent_id+ ' .case').each(function() { //loop through each checkbox
                
				this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.case').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });  */       
       // }
    });
    
});
/*
  $(document).ready(function(){
        $(document.body).on('click', ".selectall", function(){

            //$(".selectall").live('click',function () {
				var val = $(this).val(); 
				var id = $(this).attr('id');
				var parent_id = $(this).parent().parent().attr('id');
                  $('#'+parent_id).find('.case').attr('checked', this.checked);
				  if($(this).is(":checked")){
				  	$('#'+parent_id).find('.ctrl').val(val);
				  }else{
					 $('#'+parent_id).find('.ctrl').val();
				   }
				  
            });
  			$(document.body).on('click', ".case", function(){
            //$(".case").click(function(){
				var parent_id = $(this).parent().parent().parent().attr('id');
				 var arr = $(this).val().split('_');
				 	$("#"+parent_id).find(".ctrl").val(arr[1]+'_'+0);
                if($("#"+parent_id).find(".case").length == $("#"+parent_id).find(".case:checked").length) {
                    $("#"+parent_id).find(".selectall").attr("checked", "checked");
                } else {
                    $("#"+parent_id).find(".selectall").removeAttr("checked");
                }
           });
        });*/

   /*   $(function(){
            $(".selectall").live('click',function () {
				var val = $(this).val(); 
				var id = $(this).attr('id');
				var parent_id = $(this).parent().parent().attr('id');
                  $('#'+parent_id).find('.case').attr('checked', this.checked);
				  if($(this).is(":checked")){
				  	$('#'+parent_id).find('.ctrl').val(val);
				  }
				  else{
					  $('#'+parent_id).find('.ctrl').val('');
					  }
            });
            $(".case").click(function(){
				var parent_id = $(this).parent().parent().parent().attr('id');
				 var arr = $(this).val().split('_');
				 	$("#"+parent_id).find(".ctrl").val(arr[1]+'_'+0);
                if($("#"+parent_id).find(".case").length == $("#"+parent_id).find(".case:checked").length) {
                    $("#"+parent_id).find(".selectall").attr("checked", "checked");
                } else {
                    $("#"+parent_id).find(".selectall").removeAttr("checked");
                }
           });
        });*/
	$(document).ready(function(){
		$(document).on('change', '#lstRoles', function(){
		//$('#lstRoles').live('change',function(){
			var role_id = $(this).val();
			window.location.href = "<?php echo ADMIN_BASE_URL?>permission/manage/"+role_id;
		});	
	});
	
</script>