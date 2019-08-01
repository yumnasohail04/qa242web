<style type="text/css">
  
  .backgroud-blue{
    background-color: #f7f7f7 !important;
    color: black;
    width: 120px;
  }
  .backgroud-blue:hover{
    background-color: #7BABED !important;
    color: white;
    width: 120px;
  }

</style>
<?php
function timezone_menu2($default = 'UTC', $class = "form-control select2me timezones", $name = 'timezones')
    {
        $CI =& get_instance();
        $CI->lang->load('date');
        $zones_array = array();
          $timestamp = time();
          foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones_array[$key]['zone'] = $zone;
            $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
          }

        if ($default == 'GMT')
            $default = 'UTC';

        $menu = '<select name="'.$name.'"';

        if ($class != '')
        {
            $menu .= ' class="'.$class.'"';
        }

        $menu .= ' data-placeholder="Select Time Zone ...">\n';

        foreach ($zones_array as $row)
        {
           
     
 
            $selected = ($default == $row['zone']) ? " selected='selected'" : '';
            $menu .= "<option value='{$row['zone']}'{$selected}>".$row['diff_from_GMT'].' '.$row['zone']."</option>\n";
        }

        $menu .= "</select>";

        return $menu;
    }
?>
<?php include_once("select_box.php");?>
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
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
                        <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->

                <div class="content-wrapper">
                    <h3>
                        Global  Configuration .
                    </h3>

                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tabbable tabbable-custom boxless">
                    <div class="tab-content">
                        <div class="panel panel-default" style="margin-top:-30px;">

                            <div class="tab-pane  active" id="tab_2" >
                                <div class="portlet box green ">
                                    <div class="portlet-title ">
                                        <br /><br />

                                        <div class="portlet-body form container" style="margin:0 auto;" id="gen_setting">
                                            <?php
                                            $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal no-mrg');
                                            if (!empty($general_settings))
                                                $update_id = $general_settings['id'];
                                            if (empty($update_id) || $update_id == 0) {
                                                $update_id = 0;
                                                $hidden = array('hdnId' => $update_id); ////edit case
                                            } else {
                                                $hidden = array('hdnId' => $update_id); ////edit case
                                            }
                                            echo form_open_multipart(ADMIN_BASE_URL . 'general_setting/submit/' . $update_id, $attributes, $hidden);
                                            ?>
                                            <!-- BEGIN FORM-->
                                        <div class="form-body container" style="margin: 0 auto;">
                                                  <h3 class="container" style="margin: 0 auto;">Who Should Recieve Overdue Notifications</h3>
                                          <div class="col-sm-12">
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Select Groups </label>
                                                <div class="col-sm-4">
                                                   <select  multiple class="form-control restaurant_type chosen-select " name="groups[]" required="required">
                                                       <option >Select</option>
                                                      <?php
                                                       
                                                         if(!isset($groups) || empty($groups))
                                                             $groups = array();
                                                           
                                                           foreach ($groups as $value): ?>
                                                      <option value="<?=$value['id']?>" 
                                                      <?php foreach($news as $new){ if($value['id']== $new['group_id']) echo 'selected="selected"';}?>><?= $value['group_title']?></option>
                                                      <?php endforeach ?>
                                                   </select>
                                                </div>
                                             </div>
                                             
                                          </div>
                                       <div class="col-sm-7">
                                        </div>
                                          <div class="col-sm-12">
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Ios app  Link</label>
                                                <div class="col-sm-4">
                                                   <input type="text" name="ios_link" class="form-control" value="<?=$ios_link?>" />
                                                </div>
                                             </div>
                                             
                                          </div>
                                          <div class="col-sm-12">
                                             <div class="form-group">
                                                <label class="col-sm-2 control-label">Android app link </label>
                                                <div class="col-sm-4">
                                                   <input type="text" name="android_link" class="form-control"  value="<?=$android_link?>"/>
                                                </div>
                                             </div>
                                             
                                          </div>
                                                <div class="form-actions fluid">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-md-offset-3 col-md-9"  style="margin-bottom:15px;" >
                                                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                             <?php echo form_close(); ?>
                                                <!-- END FORM-->
                                        </div>
                                        <hr>
                                        <!-- BUsinesss opertion -->
                                       
                                         <div class="form-body">
                                             <h3  class="container" style="margin: 0 auto;">
                                             Business operation
                                            </h3>
                                            <div class="container" style="margin-bottom: 10px;">
                                              <div class="form-group">
                                                  <?php
                                                  $this->load->helper('date');
                                                  $attribute = array('class' => 'control-label col-md-2');
                                                  echo form_label('Time Zone', 'timezones', $attribute);
                                                  ?>
                                                  <div class="col-md-4" >
                                                          <?php
                                                          $general_data=Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("outlet_id"=>DEFAULT_OUTLET),'id desc','id','general_setting','timezones','1','1','','','')->result_array();
                                                          $timezone='Asia/Karachi'; if(isset($general_data[0]['timezones']) && !empty($general_data[0]['timezones'])) $timezone=$general_data[0]['timezones']; $timezone=  Modules::run('api/string_length',$timezone,'8000','','');
                                                          echo timezone_menu2($timezone);
                                                          ?>
                                                  </div>
                                              </div>
                                            </div>
                                        <?php foreach ($days as $day => $time): 
                                        $time = $time[0]; ?>
                                    <div class="container" style="margin-bottom: 10px;" id="<?= $day ?>" data-rowid="<?= $time['id'] ?>">
                                     <div class="col-sm-2"><strong><?=$day?></strong></div>
                                    <div class="col-sm-4">
                              From&nbsp;&nbsp;
                              <div class="input-group date">
                                <input type="text" class="form-control" id="<?= $day ?>_from" value="<?= $time['opening'] ?>">
                                <span class="input-group-addon">
                                  <span class="fa fa-clock-o"></span>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              To &nbsp;&nbsp;
                              <div class="input-group date">
                                <input type="text" class="form-control" id="<?= $day ?>_to" value="<?= $time['closing'] ?>">
                                <span class="input-group-addon">
                                  <span class="fa fa-clock-o"></span>
                                </span>
                              </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="checkbox">
                                  <label><input type="checkbox" name="is_closed" id="is_closed" <?= ($time['is_closed'] == 1) ? 'checked' : ''; ?>>&nbsp; &nbsp;Is Closed</label> &nbsp; &nbsp;
                                  <button type="button" name="button" class="btn btn-primary btn-sm time_update" data-id="<?= $day ?>">Update</button>

                                </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                      <!-- End Business Operation -->
                      <hr>
                      <div class="row container" style="margin:0 auto;">
                        <div class="col-md-6">
                          <h3 style="margin-left: 66px;">
                            Shift Detail
                          </h3>
                        </div>
                        <div class="col-md-6">
                          <h3 style="margin-right: 13px;">
                            <button type="button" class="btn btn-primary  btn-lg adding_shift" style="float:right;">Add shift</button>
                          </h3>
                        </div>
                      </div>
                      <div class="row container" style="margin:0 auto;">
                        <div class="col-md-12">
                          <table id="datatable11 " class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                              <tr class="bg-col">
                                <th class="text-center" style="width:120px;">Shift Name</th>
                                <th class="text-center" style="width:120px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              if (isset($shifts) && !empty($shifts)) {
                                $counter = 1;
                                foreach ($shifts as $key=>$lp):?>
                                  <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                    <td class="text-center"><?=ucfirst($lp['shift_name']);?></td>
                                    <td class="text-center">
                                      <?php
                                      echo anchor('"javascript:;"', '<i class="fa fa-edit"></i>', array('class' => 'edit_shift btn blue c-btn', 'rel' => $lp['shift_id'],'shift_name' => $lp['shift_name'], 'title' => 'Edit Shift'));
                                      echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_shift btn red-color c-btn', 'rel' => $lp['shift_id'], 'title' => 'Delete Plant'));
                                      ?>
                                    </td>
                                  </tr>
                              <?php endforeach;
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <hr>
                      <div class="row container" style="margin:0 auto;">
                        <div class="col-md-6">
                          <h3 style="margin-left: 66px;">
                            Shift Timing
                          </h3>
                        </div>
                        <div class="col-md-6">
                          <h3 style="margin-right: 13px;">
                            <button type="button" class="btn btn-primary  btn-lg adding_shift_timing" style="float:right;">Add shift timing</button>
                          </h3>
                        </div>
                      </div>
                      <div  class="row container" style="margin:0 auto;">
                        <div class="col-md-12">
                          <table id="datatable11" class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                              <tr class="bg-col">
                                <th class="text-center" style="width:120px;">Shift</th>
                                <th class="text-center" style="width:120px;">Day</th>
                                <th class="text-center" style="width:120px;">Start Time</th>
                                <th class="text-center" style="width:120px;">End Time</th>
                                <th class="text-center" style="width:120px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              if (isset($shift_timing) && !empty($shift_timing)) {
                                $counter = 1;
                                foreach ($shift_timing as $key=>$st):?>
                                  <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                    <td class="text-center"><?=$st['shift_name'];?></td>
                                    <td class="text-center"><?=$st['st_day'];?></td>
                                    <td class="text-center"><?=$st['st_start'];?></td>
                                    <td class="text-center"><?=$st['st_end'];?></td>
                                    <td class="text-center">
                                      <?php
                                      if(isset($st['shift_status']) && !empty($st['shift_status'])) {
                                        echo anchor('"javascript:;"', '<i class="fa fa-edit"></i>', array('class' => 'edit_shift_timing btn blue c-btn', 'rel' => $st['st_id'],'shift_name' => $st['shift_name'],'st_shift' => $st['st_shift'],'st_day' => $st['st_day'],'st_start' => $st['st_start'],'st_end' => $st['st_end'], 'title' => 'Edit Plant'));
                                      }
                                      echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_shift_timing btn red-color c-btn', 'rel' => $st['st_id'], 'title' => 'Delete Plant'));
                                      ?>
                                    </td>
                                  </tr>
                              <?php endforeach;
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <hr>
                      <div class="row container" style="margin:0 auto;">
                        <div class="col-md-6">
                          <h3 style="margin-left: 66px;">
                            Plants Detail
                          </h3>
                        </div>
                        <div class="col-md-6">
                          <h3 style="margin-right: 13px;">
                            <button type="button" class="btn btn-primary  btn-lg adding_plant" style="float:right;">Add Plant</button>
                          </h3>
                        </div>
                      </div>
                      <div  class="row container" style="margin:0 auto;">
                        <div class="col-md-12">
                          <table id="datatable11" class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                              <tr class="bg-col">
                                <th class="text-center" style="width:33% !important;">Plant Name</th>
                                <th class="text-center" style="width:33% !important;">Lines</th>
                                <th class="text-center" style="width:34% !important;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              if (isset($line_plants) && !empty($line_plants)) {
                                $counter = 1;
                                foreach ($line_plants as $key=>$lp):?>
                                  <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                    <td class="text-center"><?=$lp['plant_name'];?></td>
                                    <td>
                                      <?php 
                                        $lsp=Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("lp_plant"=>$lp['plant_id']),'lp_id desc','lp_id',DEFAULT_OUTLET.'_line_plants','lp_id,lp_line,lp_plant','1','0','','','')->result_array();
                                        $html = $previous_selected = "";
                                        if(!isset($all_lines))
                                          $all_lines = array();
                                        foreach ($all_lines as $key => $value):
                                          $lp_status = $value['line_status'];
                                          if(isset($lsp)) 
                                            $check = array_search($value['line_id'], array_column($lsp, 'lp_line'));
                                          else
                                            $check='===';
                                          if (is_numeric($check))  {
                                            if(!empty($previous_selected))
                                              $previous_selected = $previous_selected.',';
                                            $previous_selected = $previous_selected.$value['line_id'];
                                              $html .= '<option lp_status="<?=$lp_status?>" value="'.$value['line_id'].'" selected= selected >'.$value['line_name'].'</option>';
                                          }
                                          else
                                           $html .= '<option lp_status="<?=$lp_status?>" value="'.$value['line_id'].'">'.$value['line_name'].'</option>';
                                        endforeach;
                                      ?>
                                      <select name="add_on[]"   multiple="multiple" class = "select-1 form-control Item validatefield add_on" previous_selected="<?=$previous_selected?>" plant_number="<?=$lp['plant_id']?>">
                                        <?=$html?>
                                      </select>
                                    </td>
                                    <td class="text-center">
                                      <?php
                                      echo anchor('"javascript:;"', '<i class="fa fa-edit"></i>', array('class' => 'edit_plant btn blue c-btn', 'rel' => $lp['plant_id'],'p_name' => $lp['plant_name'], 'title' => 'Edit Plant'));
                                      echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_plant btn red-color c-btn', 'rel' => $lp['plant_id'], 'title' => 'Delete Plant'));
                                      ?>
                                    </td>
                                  </tr>
                              <?php endforeach;
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <hr>
                      <div class="row container" style="margin:0 auto;">
                        <div class="col-md-6">
                          <h3 style="margin-left: 66px;">
                            Lines Detail
                          </h3>
                        </div>
                        <div class="col-md-6">
                          <h3 style="margin-right: 13px;">
                            <button type="button" class="btn btn-primary  btn-lg adding_line" style="float:right;">Add new Line</button>
                          </h3>
                        </div>
                      </div>
                      <div  class="row container" style="margin:0 auto;">
                        <div class="col-md-12">
                          <table id="datatable11" class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                              <tr class="bg-col">
                                <th class="text-center">Line Name</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              if (isset($lines) && !empty($lines)) {
                                $counter = 1;
                                foreach ($lines as $key=>$li):?>
                                  <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                    <td class="text-center"><?=$li['line_name'];?></td>
                                    <td class="text-center">
                                      <?php
                                      echo anchor('"javascript:;"', '<i class="fa fa-edit"></i>', array('class' => 'edit_line btn blue c-btn', 'rel' => $li['line_id'],'line_name' => $li['line_name'], 'title' => 'Edit Line'));
                                      echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_line btn red-color c-btn', 'rel' => $li['line_id'], 'title' => 'Delete Line'));
                                      ?>
                                    </td>
                                  </tr>
                              <?php endforeach;
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <hr>
                      <div class="row container" style="margin:0 auto;">
                        <div class="col-md-6">
                          <h3 style="margin-left: 66px;">
                            Product Schedule
                          </h3>
                        </div>
                        <div class="col-md-6">
                          <h3 style="margin-left: 66px;">
                            <button type="button" class="btn btn-primary  btn-lg upload_file" style="float:right;">File Upload</button>
                          </h3>
                          <h3 style="margin-left: 66px;">
                            <button type="button" class="btn btn-primary  btn-lg product_schedules" style="float:right;">Add Product Schedule</button>
                          </h3>
                        </div>
                      </div>
                      <div  class="row container" style="margin:0 auto;">
                        <div class="col-md-12">
                          <table id="datatable11" class="table table-striped table-hover table-body table-bordered">
                            <thead class="bg-th">
                              <tr class="bg-col">
                                <th class="text-center" style="width:120px;">Product Code</th>
                                <th class="text-center" style="width:120px;">Product Name</th>
                                <th class="text-center" style="width:120px;">Product Type</th>
                                <th class="text-center" style="width:120px;">Line</th>
                                <th class="text-center" style="width:120px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              if (isset($product_schedule) && !empty($product_schedule)) {
                                $counter = 1;
                                foreach ($product_schedule as $keyy=>$produc):?>
                                  <tr id="Row_<?=$counter?>" class="backgroud-blue ">
                                    <td class="border_color_blue"><?=$produc['day']?>(<?=$produc['date']?>)</td>
                                    <td class="border_color_blue"></td>
                                    <td class="border_color_blue"></td>
                                    <td class="border_color_blue"></td>
                                    <td class="border_color_blue"></td>
                                  </tr>
                                <?php if(isset($produc['data']) && !empty($produc['data'])) {
                                  foreach ($produc['data'] as $key => $pro): ?>
                                  <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                    <td class="text-center"><?=$pro['navision_no'];?></td>
                                    <td class="text-center"><?=$pro['product_title'];?></td>
                                    <td class="text-center"><?=$pro['product_type'];?></td>
                                    <td class="text-center"><?=$pro['ps_line'];?></td>
                                    <td class="text-center">
                                      <?php
                                      echo anchor('"javascript:;"', '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'rel' => $pro['ps_id'],'start_date' => $pro['ps_date'],'product' => $pro['ps_product'],'line' => $pro['ps_line'], 'title' => 'Edit Product'));
                                      echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn  c-btn', 'rel' => $pro['ps_id'], 'title' => 'Delete Product'));
                                      ?>
                                    </td>
                                  </tr>
                                <?php
                                $counter++;
                                  endforeach;
                                  }
                                else {
                                  $counter++; ?>
                                  <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                    <td class="text-center" style="border:none !important;text-align: right"></td>
                                    <td class="text-center red-color" style="border:none !important;text-align: right;font-weight:bold;">No schedules for the day</td>
                                    <td class="text-center" style="border:none !important;"></td>
                                    <td class="text-center" style="border:none !important;"></td>
                                  </tr>
                                <?php }
                              endforeach;
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      
                      <!-- Line Shift Details -->
                      <!-- Line Shift Details -->
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
  $(document).on("click", ".adding_plant", function(event){
  event.preventDefault();
  $('#adding_plant').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?= ADMIN_BASE_URL?>global_configuration/get_plant_html",
      data: {},
      async: false,
      success: function(test_body) {
        $("#adding_plant .modal-body").html(test_body);
        $("#adding_plant .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_plant" style="clear: both; margin-top: 10px;">Submit</button>');
      }
    });
  });
  $(document).on("click", ".product_schedules", function(event){
  event.preventDefault();
  $('#product_schedules').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?= ADMIN_BASE_URL?>global_configuration/get_product_schedules",
      data: {},
      async: false,
      success: function(test_body) {
        $("#product_schedules .modal-body").html(test_body);
        $("#product_schedules .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submit_from" style="clear: both; margin-top: 10px;">Submit</button>');
      }
    });
  });
  $(document).on("click", ".upload_file", function(event){
  event.preventDefault();
  $('#upload_file').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?= ADMIN_BASE_URL?>global_configuration/get_upload_file",
      data: {},
      async: false,
      success: function(test_body) {
        $("#upload_file .modal-body").html(test_body);
        $("#upload_file .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submit_upload_image" style="clear: both; margin-top: 10px;">Submit</button>');
      }
    });
  });
    jQuery(document).ready(function () {

//      $.fn.editable.defaults.mode = 'inline';

        $("#media_file").change(function () {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });

        $('.theme-panel ul li').click(function () {
            var theme = $(this).attr('data-style');
            $('#hdn_theme').val(theme);
            $('ul > li').removeClass("current");
            $("html, body").animate({scrollTop: "0px"});
        });

        $('.theme-panel ul li').removeClass('current');
        $('.theme-panel ul li').each(function () {
            var theme = $(this).attr('data-style');
            var current_theme = $('#hdn_theme').val();
            if (theme == current_theme) {
                $(this).addClass('current');
            }
        });

    });


    $("#outlet_fav_icon").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_image_fav_icon').val(replaced_val);
    });
</script>
<script>
    $("#form_sample_1").submit(function(event){
       event.preventDefault();
      
        $.ajax({
                        type: 'POST',
                        url: "<?= ADMIN_BASE_URL?>global_configuration/submit",
                        data:  $('#form_sample_1').serialize(),
                        async: false,
                        success: function(test_body) {
                           toastr.success('Global Setting saved succesfully');
                        }
                    });
    });
</script>
<script>

$(document).off("click", ".time_update").on("click", ".time_update", function (event) {
    event.preventDefault();
    var row_id = $(this).attr('data-id');
    var row = $("#"+row_id);
    var id = row.attr('data-rowid');
    var r_id = row.attr('id');
    var from = $('#'+r_id+'_from').val();
    var to =  $('#'+r_id+'_to').val();
    var ch_box = row.find("#is_closed");
    var is_closed = 0;
    if (ch_box.is(":checked"))
    {
      is_closed = 1;
    }

    $.ajax({
        type: 'POST',
        url: "<?= ADMIN_BASE_URL ?>outlet/update_time",
        data: {'id':id, 'from':from, 'to':to, 'is_closed':is_closed, 'day_name':r_id, 'outlet_id': <?=$outlet_id?>},
        async: false,
        success: function (result) {
            if(result)
            {
              if (id < 1 ) row.attr('data-rowid', result);
              toastr.success('Time Updated Successfully!');
            }
        }
    });
});
$(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
  var id = $(this).attr('rel');
  e.preventDefault();
  swal({
    title : "Are you sure to delete the selected Product?",
    text : "You will not be able to recover this Product!",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "#DD6B55",
    confirmButtonText : "Yes, delete it!",
    closeOnConfirm : false
  },
  function () {
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/delete_schedule_product",
      data: {'id': id},
      async: false,
      success: function() {
      location.reload();
      }
    });
    swal("Deleted!", "Product has been deleted.", "success");
  });
});
$(document).off('click', '.adding_line').on('click', '.adding_line', function(e){
  e.preventDefault();
  swal({
    title : "Are you sure to new line?",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "green",
    confirmButtonText : "Yes, add it!",
    closeOnConfirm : false
  },
  function () {
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/adding_line",
      data: {},
      async: false,
      success: function() {
      location.reload();
      }
    });
    swal("Added!", "New line has been added.", "success");
  });
});
$(document).off('click', '.action_edit').on('click', '.action_edit', function(e){
  var id = $(this).attr('rel');
  var start_date = $(this).attr('start_date');
  var end_date = $(this).attr('end_date');
  var product = $(this).attr('product');
  var line = $(this).attr('line');
  e.preventDefault();
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/get_product_schedules",
      data: {'id': id,'start_date':start_date,'product':product,'line':line},
      async: false,
      success: function(test_body) {
        $('#product_schedules').modal('show');
        $("#product_schedules .modal-body").html(test_body);
        $("#product_schedules .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submit_from" style="clear: both; margin-top: 10px;">Submit</button>');
      }
    });
});

$(document).off('click', '.edit_plant').on('click', '.edit_plant', function(e){
  var id = $(this).attr('rel');
  var p_name = $(this).attr('p_name');
  e.preventDefault();
  $('#adding_plant').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/get_plant_html",
      data: {'id': id,'p_name':p_name},
      async: false,
      success: function(test_body) {
        $("#adding_plant .modal-body").html(test_body);
        $("#adding_plant .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_plant" style="clear: both; margin-top: 10px;">Submit</button>');
      }
    });
});
$(document).off('click', '.delete_plant').on('click', '.delete_plant', function(e){
  var id = $(this).attr('rel');
  e.preventDefault();
  swal({
    title : "Are you sure to delete the Plant?",
    text : "You will not be able to recover this Plant!",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "#DD6B55",
    confirmButtonText : "Yes, delete it!",
    closeOnConfirm : false
  },
  function () {
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/delete_plant",
      data: {'id': id},
      async: false,
      success: function() {
      location.reload();
      }
    });
    swal("Deleted!", "Plant has been deleted.", "success");
  });
});
$(document).off('click', '.delete_shift').on('click', '.delete_shift', function(e){
  var id = $(this).attr('rel');
  e.preventDefault();
  swal({
    title : "Are you sure to delete the shift?",
    text : "You will not be able to recover this shift!",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "#DD6B55",
    confirmButtonText : "Yes, delete it!",
    closeOnConfirm : false
  },
  function () {
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/delete_shift",
      data: {'id': id},
      async: false,
      success: function() {
      location.reload();
      }
    });
    swal("Deleted!", "Shift has been deleted.", "success");
  });
});
$(document).off('click', '.delete_shift_timing').on('click', '.delete_shift_timing', function(e){
  var id = $(this).attr('rel');
  e.preventDefault();
  swal({
    title : "Are you sure to delete the shift timing?",
    text : "You will not be able to recover this shift timing!",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "#DD6B55",
    confirmButtonText : "Yes, delete it!",
    closeOnConfirm : false
  },
  function () {
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/delete_shift_timing",
      data: {'id': id},
      async: false,
      success: function() {
      location.reload();
      }
    });
    swal("Deleted!", "Shift timing has been deleted.", "success");
  });
});
$(document).off('click', '.edit_line').on('click', '.edit_line', function(e){
  var id = $(this).attr('rel');
  var line_name = $(this).attr('line_name');
  e.preventDefault();
  $('#adding_line').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/get_line_html",
      data: {'id': id,'line_name':line_name},
      async: false,
      success: function(test_body) {
        $("#adding_line .modal-body").html(test_body);
        $("#adding_line .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_line" style="clear: both; margin-top: 10px;">Submit</button>');
      }
    });
});
$(document).off('click', '.delete_line').on('click', '.delete_line', function(e){
  var id = $(this).attr('rel');
  e.preventDefault();
  swal({
    title : "Are you sure to delete the Line?",
    text : "You will not be able to recover this Line!",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "#DD6B55",
    confirmButtonText : "Yes, delete it!",
    closeOnConfirm : false
  },
  function () {
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/delete_line",
      data: {'id': id},
      async: false,
      success: function() {
      location.reload();
      }
    });
    swal("Deleted!", "Product has been deleted.", "success");
  });
});
$('.line_product').on('change', function() {
  alert( this.value );
  $(".line_product option[value='"+this.value+"']").remove();
});
  $(document).on("change", ".add_on", function(event){
    event.preventDefault();
    //alert();
    var hello = $(this);
    var line_id = hello.val();
    var plant_number = hello.attr('plant_number');
    var previous_selected = hello.attr('previous_selected');
    $.ajax({
      type: "POST",
      url:  "<?= ADMIN_BASE_URL ?>global_configuration/update_line_plants",
      data: { 'line_id':line_id, 'previous_selected':previous_selected,'plant_number':plant_number},
      async: false,
      success: function(result){
        var status = result.status;
        hello.attr("previous_selected",result.return_previous_selected);
        if(status === 'success')
          toastr.success(result.message);
        else
          toastr.warning(result.message);
      }
    });
  });
  $(window).on('load', function() {
    $(".select2-container").attr("style",'width:100% !important;');
  });
  $(document).on("click", ".adding_shift", function(event){
  event.preventDefault();
  $('#adding_shift').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?= ADMIN_BASE_URL?>global_configuration/get_shift_html",
      data: {},
      async: false,
      success: function(test_body) {
        $("#adding_shift .modal-body").html(test_body);
        $("#adding_shift .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_shift" style="clear: both; margin-top: 10px;">Submit</button>');
        date();
      }
    });
  });
  $(document).off('click', '.edit_shift').on('click', '.edit_shift', function(e){
    var id = $(this).attr('rel');
    var shift_name = $(this).attr('shift_name');
    e.preventDefault();
    $('#adding_shift').modal('show');
      $.ajax({
        type: 'POST',
        url: "<?php ADMIN_BASE_URL?>global_configuration/get_shift_html",
        data: {'id': id,'shift_name':shift_name},
        async: false,
        success: function(test_body) {
          $("#adding_shift .modal-body").html(test_body);
          $("#adding_shift .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_shift" style="clear: both; margin-top: 10px;">Submit</button>');
        }
      });
  });
  $(document).on("click", ".adding_shift_timing", function(event){
  event.preventDefault();
  $('#adding_shift_timing').modal('show');
    $.ajax({
      type: 'POST',
      url: "<?= ADMIN_BASE_URL?>global_configuration/get_shift_timing_html",
      data: {'from':"add"},
      async: false,
      success: function(test_body) {
        $("#adding_shift_timing .modal-body").html(test_body);
        $("#adding_shift_timing .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_shift_timing" style="clear: both; margin-top: 10px;">Submit</button>');
        date();
      }
    });
  });
  $(document).off('click', '.edit_shift_timing').on('click', '.edit_shift_timing', function(e){
    var id = $(this).attr('rel');
    var shift_name = $(this).attr('shift_name');
    var st_shift = $(this).attr('st_shift');
    var st_day = $(this).attr('st_day');
    var st_start = $(this).attr('st_start');
    var st_end = $(this).attr('st_end');
    e.preventDefault();
    $('#adding_shift_timing').modal('show');
      $.ajax({
        type: 'POST',
        url: "<?php ADMIN_BASE_URL?>global_configuration/get_shift_timing_html",
        data: {'id': id,'shift_name':shift_name,'st_shift':st_shift,'st_day':st_day,'st_start':st_start,'st_end':st_end},
        async: false,
        success: function(test_body) {
          $("#adding_shift_timing .modal-body").html(test_body);
          $("#adding_shift_timing .modal-footer").html('<button type="submit" class="btn-primary btn pull-right submited_shift_timing" style="clear: both; margin-top: 10px;">Submit</button>');
          date();
        }
      });
  });
  $(document).off("change", ".timezones").on("change", ".timezones", function (event) {
    event.preventDefault();
    var abc = $(this);
    var timezone = abc.val();
    if(!$('.checking_previous').text()) {
      $.ajax({
        type: 'POST',
        url: "<?php ADMIN_BASE_URL?>global_configuration/set_outlet_timezone",
        data: {'timezone': timezone},
        async: false,
        success: function(data) {
          showToastr(data.message, data.status);
        }
      });
    }
    else
      showToastr("Please select the timezone", false);
  });
  var showToastr = function (msg, type) {
    if(type == true)
      toastr.success(msg);
    else
      toastr.error(msg);
  };
</script>