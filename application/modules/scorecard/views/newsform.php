<style type="text/css">
    .red_class {
        border: 1px solid red !important;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    {
        width:100%;
    }
    .btn-group.open .dropdown-toggle {
        background-color: transparent;
    }
    fieldset .form-group {
    margin-bottom: 15px;
}
.section-box {
    box-shadow: none;
}
*, *:before, *:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

</style>
<div class="page-content-wrapper">
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body"> Widget settings form goes here </div>
          <div class="modal-footer">
            <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
            <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
          </div>
        </div>
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
    <!-- /.modal --> 
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM--> 
    <!-- BEGIN PAGE HEADER-->
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
                    $strTitle = 'Fill ScoreCard';
                    echo $strTitle;
                    ?>
                   
       </h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="border-radius:10px;">
         
            <div class="tab-pane  active" id="tab_2" >
              <div class="portlet box green ">
                <div class="portlet-title ">
                 
                </div>
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'scorecard/submit_supplier/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'scorecard/submit_supplier/' . $update_id, $attributes);
                        ?>
                  <div class="form-body section-box">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                   
                <div class="row new">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php if(!isset($supplier)) $supplier = array();
                           $options = $supplier ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Supplier <span style="color:red">*</span>', 'supplier_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('supplier_id', $options, '',  'class="form-control select2me required validatefield" id="supplier_id" tabindex ="8"'); ?>
                          </div>
                        </div>
                     </div>
                     <!-- <div class="col-sm-5">
                        <div class="form-group">
                          <?php if(!isset($groups)) $groups = array();
                           $options = $groups ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Approval Team <span style="color:red">*</span>', 'group_id', $attribute);?>
                          <div class="col-md-8">
                            <?php echo form_dropdown('group_id', $options, '',  'class="form-control select2me required validatefield" id="group_id" tabindex ="8"'); ?>
                          </div>
                        </div>
                     </div> -->
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary submited_form"><i class="fa fa-check"></i>&nbsp;Create</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'scorecard'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
                <!-- END FORM--> 
                
               </div>
              </div>
            </div>
          </div>
        </div>
        <div class="">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <h3>Recently Created ScoreCards</h3>
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <table id="datatable1" class="table table-body  table-bordered">
                                <thead class="bg-th">
                                <tr class="bg-col" align="center" class="text-center">
                                <th class="text-center" style="display:none;"><b>S.no </b><i class="fa fa-sort" style="font-size:13px;"></i></th>
                                <th class="text-center"><b>Supplier </b><i class="fa fa-sort" style="font-size:13px;"></i></th>
                                <th class="text-center">Created Date<i class="fa fa-sort" style="font-size:13px;"></i></th>
                                <th class="" style="width:198px;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <?php
                                        $i = 0;
                                        if (isset($news)) {
                                            foreach ($scorecards as $key => $new) {
                                                $i++;
                                                $delete_url = ADMIN_BASE_URL . 'scorecard/delete/' . $new['id'];
                                                ?>
                                                <tr id="Row_<?=$new['id']?>" class="odd gradeX " >
                                                <td style="display:none;"><?php echo $i ?></td>
                                                <td><?php echo $new['name'] ?></td>
                                                <td><?php echo $new['create_date'] ?></td>
                                                
                                                <td class="table_action" style="text-align: center;">
                                                <a class="btn yellow c-btn view_details" rel="<?=$new['id']?>"><i class="fa fa-list"  title="See Detail"></i></a> 
                                                <?php
                                                $publish_class = ' table_action_publish';
                                                $publis_title = 'Set Un-Publish';
                                                $icon = '<i class="fas fa-arrow-up"></i>';
                                                $iconbgclass = ' btn greenbtn c-btn';
                                                if ($new['status'] != 1) {
                                                $publish_class = ' table_action_unpublish';
                                                $publis_title = 'Set Publish';
                                                $icon = '<i class="fas fa-arrow-down red"></i>';
                                                $iconbgclass = ' btn default c-btn';
                                                }
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new['id'], 'title' => 'Delete product_checks'));
                                                ?>
                                                </td>
                                            </tr>
                                            <?php } ?>    
                                        <?php } ?>
                                    </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
      </div>
    </div>
  </div>
</div>
</div>
</div>


<script>


    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });


        $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?=ADMIN_BASE_URL?>scorecard/detail_view",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                         $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-body").html(test_desc);
                     }
                    });
            });
            $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected ScoreCard?",
                text : "You will not be able to recover this ScoreCard!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?=ADMIN_BASE_URL?>scorecard/delete_scorecard",
                            data: {'id': id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "ScoreCard has been deleted.", "success");
              });

            });
    });



</script>
