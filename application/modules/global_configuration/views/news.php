<!-- <link href="<?php echo STATIC_ADMIN_CSS;?>simplePagination.css" rel="stylesheet"> -->
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
  .selectbox-class, .selectbox-class:hover {
    background-color: white;
    color: #3a3f51;
    width: 147% !important;
  }
  
h3
{
    color: #6ba4ed;
    padding: 14px;
    margin-bottom: 25px!important;
    border-bottom-right-radius: 32px;
    border-top-right-radius: 26px;
    font-size: 14px;
}
.row
{
    margin-bottom: 13px!important; 
}
.red
{
	color:#e03737;
}
.greens
{
	color:green;
}
.datepicker-dropdown
{
z-index:9999!important;
}
</style>
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  background-color: #272c32;
    border-radius: 6px;
    padding: 10px;
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
    overflow-y: hidden;
    display: flex;
}
/* .active {
    color: #c2c1ce !important;
} */
/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 14px;
  font-weight: bold;
  border-bottom: 5px solid #272c32;
  color: #c2c1ce;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: rgba(93, 156, 236, 0.2);
    border-bottom: 5px solid #636363;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #272c32;
  border-bottom: 3px solid #c2c1ce;
  color: #c2c1ce!important;
}

/* Style the tab content */
.tabcontent {
  display: none;
  border-top: none;
}

/* Style the close button */
.topright {
  float: right;
  cursor: pointer;
  font-size: 28px;
}

.topright:hover {color: red;}
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
<!--     <link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>bootstrap-select.min.css" />
    <script src="<?php echo STATIC_ADMIN_JS?>bootstrap-select.min.js"></script> -->


    <main>
      <div class="container-fluid">
          <div class="row">
              <div class="col-12">
                  <h1>Global Configuration</h1>
                  <div class="separator mb-5"></div>

              </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs " role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first"
                                    role="tab" aria-controls="first" aria-selected="true">Notification Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="second-tab" data-toggle="tab" href="#second"
                                    role="tab" aria-controls="second" aria-selected="false">Scorecard Approval team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="third-tab" data-toggle="tab" href="#third"
                                    role="tab" aria-controls="third" aria-selected="false">Business operation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth"
                                    role="tab" aria-controls="fourth" aria-selected="false">Shift Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth"
                                    role="tab" aria-controls="fifth" aria-selected="false">Shift Timing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="sixth-tab" data-toggle="tab" href="#sixth"
                                    role="tab" aria-controls="sixth" aria-selected="false">Plant Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="seventh-tab" data-toggle="tab" href="#seventh"
                                    role="tab" aria-controls="seventh" aria-selected="false">Line Detail</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="eigth-tab" data-toggle="tab" href="#eigth"
                                    role="tab" aria-controls="eigth" aria-selected="false">Product Schedule </a>
                            </li>
                            

                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                        <!-- ----------tab1-------- -->
                            <div class="tab-pane fade show active" id="first" role="tabpanel"
                                aria-labelledby="first-tab">
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
                             <div class="form-body container" >
                                  <div class="row">
                                      <div class="col-lg-5 col-md-12 col-sm-12">
                                        <h3 class="bg-primary" style="margin: 0 auto;">Who Should Receive Overdue Notifications</h3>
                                      </div>
                                  </div>
                                  <div class="row container" style="margin-top:1%">
                                        
                                        
                                          <div class="col-sm-6">
                                            <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary" type="button">IOS App Link<span style="color:red">*</span></button>
                                              </div>
                                                  <input type="text" name="ios_link" class="form-control" value="<?=$ios_link?>" />
                                            </div>
                                          </div>
                                          <div class="col-sm-6">
                                            <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary" type="button">Android App Link<span style="color:red">*</span></button>
                                              </div>
                                                <input type="text" name="android_link" class="form-control"  value="<?=$android_link?>"/>
                                            </div>
                                          </div>
                                          <div class="col-sm-6">
                                            <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary" type="button">Firebase Documents Name<span style="color:red">*</span></button>
                                              </div>
                                                  <input type="text" name="fb_document_name" class="form-control"  value="<?=$fb_document_name?>"/>
                                            </div>
                                          </div>
                                          <div class="col-sm-6">
                                        <div class=" input-group mb-3">
                                          <div class="col-md-2  input-group-prepend">
                                            <button class="btn btn-outline-secondary" type="button">Select Groups<span style="color:red">*</span></button>
                                          </div>
                                        <div class="col-sm-10">
                                            <select  multiple class=" restaurant_type select-1 " name="groups[]" required="required">
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
                                              <div class="col-md-3">
                                                  <div class="form-group"   >
                                                      <button  type="submit" class="btn btn-outline-primary "><i class="fa fa-check"></i>&nbsp;Save</button>
                                                  </div>
                                              </div>  
                                   </div>
                            </div>
                                <?php echo form_close(); ?>
                            </div>
                             <!-- ----------tab2-------- -->
                            <div class="tab-pane fade" id="second" role="tabpanel"
                                aria-labelledby="second-tab">
                                <div class="form-body container" >
                                  <div class="row">
                                    <div class="col-lg-5 col-md-12 col-sm-12">
                                        <h3  class="bg-primary" style="margin: 0 auto;">
                                        ScoreCard Approval Team
                                        </h3>
                                    </div>
                                  </div>
                                      <form action="<?php echo BASE_URL.'global_configuration/save_group' ?>" method="POST">
                                      <div class="row">
                                      <div class="col-sm-6">
                                          <div class="input-group mb-3">
                                              <div class="input-group-prepend">
                                                <button class="btn btn-outline-secondary" type="button">Approval Team<span style="color:red">*</span></button>
                                              </div>
                                              <?php if(!isset($approve_groups)) $approve_groups = array();
                                              $app_gp = Modules::run('api/_get_specific_table_with_pagination',array("outlet_id"=>DEFAULT_OUTLET), 'id desc','general_setting','scorecard_approv','1','0')->row_array();
                                              if(!isset($app_gp['scorecard_approv'])) $app_gp['scorecard_approv'] = ""; 
                                              $options = $approve_groups ;
                                              $attribute = array('class' => 'control-label col-md-2');?>
                                                <?php echo form_dropdown('group_id', $options, $app_gp['scorecard_approv'],  'class="form-control select2me required" id="group_id" tabindex ="8"'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div  >
                                              <button type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                                          </div>
                                      </div> 
                                                    </div>     
                                      </form>  
                                    </div>
                            </div>
                            <!-- ----------tab3-------- -->
                            <div class="tab-pane fade" id="third" role="tabpanel"
                                aria-labelledby="third-tab">
                                <div class="form-body container" >
                                <div class="row">
                                  <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h3  class="bg-primary " style="margin: 0 auto;">
                                    Business operation
                                    </h3>
                                </div>
                                                    </div>
                                <div class="row">
                                <div class="col-sm-6">
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <button class="btn btn-outline-secondary" type="button">Time Zone<span style="color:red">*</span></button>
                                    </div>
                                      <?php
                                      $this->load->helper('date');
                                      $attribute = array('class' => 'control-label col-md-2');
                                      ?>
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
                                <div class="row" style="margin-bottom: 10px;" id="<?= $day ?>" data-rowid="<?= $time['id'] ?>">
                                  <div class="col-sm-2"><strong><?=$day?></strong></div>
                                	<div class="col-sm-4">
                                    	<div class="input-group  mb-3  datetimepicker1">
                                        	<div class="input-group-prepend">
                                        		<button class="btn btn-outline-secondary" type="button">To</button>
                                      		</div>
                                            <input type="text" class="form-control" id="<?= $day ?>_from" value="<?= $time['opening'] ?>" >
                                            <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-clock"></i>
                                            </span>
                                        </div>
                                 	</div>
                                      <div class="col-sm-4">
                                    	<div class="input-group  mb-3 datetimepicker1">
                                        	<div class="input-group-prepend">
                                        		<button class="btn btn-outline-secondary" type="button">To</button>
                                      		</div>
                                            <input type="text" class="form-control" id="<?= $day ?>_to" value="<?= $time['closing'] ?>" >
                                            <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-clock"></i>
                                            </span>
                                        </div>
                                 	</div>
                                      <div class="col-sm-2">
                                          <div class="checkbox" style="float:right;">
                                            <label><input type="checkbox" name="is_closed" id="is_closed" <?= ($time['is_closed'] == 1) ? 'checked' : ''; ?>>&nbsp; &nbsp;Is Closed</label> &nbsp; &nbsp;
                                            <button type="button" name="button" class="btn btn-outline-primary btn-sm time_update" data-id="<?= $day ?>">Update</button>

                                          </div>
                                      </div>
                                    </div>
                                  <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- ----------tab4-------- -->
                            <div class="tab-pane fade" id="fourth" role="tabpanel"
                                aria-labelledby="fourth-tab">
                                <div class="row container" style="margin:0 auto;">
                                  <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h3 class="bg-primary">
                                      Shift Detail
                                    </h3>
                                  </div>
                                  <div class="col-md-12">
                                      <button type="button" class="btn btn-outline-primary  btn-lg adding_shift" style="float:right;">Add shift</button>
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
                                                echo anchor('"javascript:;"', '<i class="iconsminds-file-edit"></i>', array('class' => 'edit_shift btn blue c-btn', 'rel' => $lp['shift_id'],'shift_name' => $lp['shift_name'], 'title' => 'Edit Shift'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_shift btn red-color c-btn', 'rel' => $lp['shift_id'], 'title' => 'Delete Plant'));
                                                ?>
                                              </td>
                                            </tr>
                                        <?php endforeach;
                                        } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                             <!-- ----------tab5-------- -->
                             <div class="tab-pane fade" id="fifth" role="tabpanel"
                                aria-labelledby="fifth-tab">
                                <div class="row container" style="margin:0 auto;">
                                  <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h3 class="bg-primary" >
                                      Shift Timing
                                    </h3>
                                  </div>
                                  <div class="col-md-12">
                                      <button type="button" class="btn btn-outline-primary  btn-lg adding_shift_timing" style="float:right;">Add shift timing</button>
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
                                                  echo anchor('"javascript:;"', '<i class="iconsminds-file-edit"></i>', array('class' => 'edit_shift_timing btn blue c-btn', 'rel' => $st['st_id'],'shift_name' => $st['shift_name'],'st_shift' => $st['st_shift'],'st_day' => $st['st_day'],'st_start' => $st['st_start'],'st_end' => $st['st_end'], 'title' => 'Edit Plant'));
                                                }
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_shift_timing btn red-color c-btn', 'rel' => $st['st_id'], 'title' => 'Delete Plant'));
                                                ?>
                                              </td>
                                            </tr>
                                        <?php endforeach;
                                        } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <!-- ----------tab6-------- -->
                            <div class="tab-pane fade" id="sixth" role="tabpanel"
                                aria-labelledby="sixth-tab">
                                <div class="row container" style="margin:0 auto;">
                                  <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h3 class="bg-primary" >
                                      Plants Detail
                                    </h3>
                                  </div>
                                  <div class="col-md-12">
                                      <button type="button" class="btn btn-outline-primary  btn-lg adding_plant" style="float:right;">Add Plant</button>
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
                                          foreach ($line_plants as $key=>$lp):
                                          if($lp['plant_status']=="1")
                                                  $color_class="greens";
                                          else
                                            $color_class="red"; ?>
                                            <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                              <td class="text-center <?php echo $color_class ?>"><?=$lp['plant_name'];?></td>
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
                                                  echo anchor('"javascript:;"', '<i class="iconsminds-file-edit"></i>', array('class' => 'edit_plant btn blue c-btn', 'rel' => $lp['plant_id'],'p_name' => $lp['plant_name'], 'title' => 'Edit Plant'));
                                                  //echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_plant btn red-color c-btn', 'rel' => $lp['plant_id'], 'title' => 'Delete Plant'));
                                                  $status_class="simple-icon-arrow-up-circle";
                                                  if($lp['plant_status']=="0")
                                                  $status_class="simple-icon-arrow-down-circle";
                                                  echo anchor('"javascript:;"', '<i class="fa '.$status_class.' "></i>', array('class' => 'plant_status btn red-color c-btn', 'rel' => $lp['plant_id'], 'rel_status' => $lp['plant_status'], 'title' => 'Active'));
                                                  ?>
                                              </td>
                                            </tr>
                                        <?php endforeach;
                                        } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <!-- ----------tab7-------- -->
                            <div class="tab-pane fade" id="seventh" role="tabpanel"
                                aria-labelledby="seventh-tab">
                                <div class="row container" style="margin:0 auto;">
                                  <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h3 class="bg-primary" >
                                      Lines Detail
                                    </h3>
                                  </div>
                                  <div class="col-md-12">
                                      <button type="button" class="btn btn-outline-primary  btn-lg adding_line" style="float:right;">Add new Line</button>
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
                                                echo anchor('"javascript:;"', '<i class="iconsminds-file-edit"></i>', array('class' => 'edit_line btn blue c-btn', 'rel' => $li['line_id'],'line_name' => $li['line_name'], 'title' => 'Edit Line'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_line btn red-color c-btn', 'rel' => $li['line_id'], 'title' => 'Delete Line'));
                                                ?>
                                              </td>
                                            </tr>
                                        <?php endforeach;
                                        } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                            <!-- ----------tab8-------- -->
                            <div class="tab-pane fade" id="eigth" role="tabpanel"
                                aria-labelledby="eigth-tab">
                                <div class="row container" style="margin:0 auto;">
                                  <div class="col-lg-5 col-md-12 col-sm-12">
                                    <h3 class="bg-primary"  >
                                      Product Schedule
                                    </h3>
                                  </div>
                                  <div class="col-md-12">
                                  <div class="row" style="width: 100%">
                                    <div class="col-md-3" >
                                    <div class="form-group  mb-1">
                                      <label>From:</label>
                                      <div class='input-group date'>
                                          <input type='text' class="form-control " id="startdate" />
                                          <span class="input-group-text input-group-append input-group-addon">
                                                  <i class="simple-icon-calendar"></i>
                                              </span>
                                      </div>
                                  </div>
                                  </div>
                                    <div class="col-md-3" >
                                    <div class="form-group  mb-1">
                                      <label>To:</label>
                                      <div class='input-group date'>
                                          <input type='text' class="form-control " id="enddate" />
                                          <span class="input-group-text input-group-append input-group-addon">
                                                  <i class="simple-icon-calendar"></i>
                                              </span>
                                      </div>
                                  </div>
                                  </div>
                                    <div class="col-md-2" >
                                      <div class="form-group" style="margin-top: 33px;">
                                        <button type="button" class="btn btn-primary form-control filter_search">Search</button>
                                      </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group" style="margin-top: 33px;">
                                      <button type="button" class="btn btn-primary form-control btn-lg upload_file" style="float:right;">File Upload</button>
                                  </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group" style="margin-top: 33px;">
                                      <button type="button" class="btn btn-primary  form-control btn-lg product_schedules" style="float:right;">Add Product Schedule</button>
                                    </div>
                                  </div>
                                  </div>
                              </div>
                              <div  class="row " style="margin:0 auto; width:100%;">
                                <div class="col-md-12">
                                  <table id="datatable11" class="table table-striped table-hover table-body table-bordered">
                                    <thead class="bg-th">
                                      <tr class="bg-col">
                                        <th class="text-center">Product Code</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Program Type</th>
                                        <th class="text-center">Storage Type</th>
                                        <th class="text-center">Plant</th>
                                        <th class="text-center">Line</th>
                                        <th class="text-center">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody id="ajax_content_wrapper">
                                      <?php $i = 0;
                                      if (isset($product_schedule) && !empty($product_schedule)) {
                                        $counter = 1;
                                        foreach ($product_schedule as $keyy=>$produc):?>
                                          <tr id="Row_<?=$counter?>" class="backgroud-blue ">
                                            <td  colspan="7" class="border_color_blue"><?=$produc['day']?>(<?=$produc['date']?>)</td>
                                          </tr>
                                        <?php if(isset($produc['data']) && !empty($produc['data'])) {
                                          foreach ($produc['data'] as $key => $pro): ?>
                                          <tr  id="Row_<?=$counter?>" class="odd gradeX " >
                                            <td class="text-center"><?=$pro['navision_no'];?></td>
                                            <td class="text-center"><?=$pro['product_title'];?></td>
                                            <td class="text-center">
                                              <?php $get_ppt = Modules::run('api/_get_specific_table_with_pagination',array('ppt_product_id'=>$pro['ps_product']), 'ppt_id desc',DEFAULT_OUTLET.'_product_program_type','ppt_program_id','1','0')->result_array();
                                                $counter = 1;
                                                if(!empty($get_ppt)) {
                                                      foreach ($get_ppt as $key => $gppt):
                                                          if(!empty($gppt['ppt_program_id'])) {
                                                              $key = array_search($gppt['ppt_program_id'], array_column($program_type, 'program_id'));
                                                              if (is_numeric($key)) {
                                                                  if($counter >1)
                                                                      echo ",";
                                                                  echo $program_type[$key]['program_name'];
                                                                  $counter++;
                                                              }
                                                          }
                                                      endforeach;
                                                }
                                            ?>
                                            </td>
                                            <td class="text-center"><?=$pro['storage_type'];?></td>
                                            <td class="text-center"><?=$pro['plant_name'];?></td>
                                            <td class="text-center"><?php if(!empty($pro['ps_line'])) { 
                                              $line_name = Modules::run('api/_get_specific_table_with_pagination',array('line_id'=>$pro['ps_line']), 'line_id asc',DEFAULT_OUTLET.'_lines','line_name','1','1')->result_array(); if(isset($line_name[0]['line_name']) && !empty($line_name[0]['line_name'])) echo $line_name[0]['line_name']; }?></td>
                                            <td class="text-center">
                                              <?php
                                              echo anchor('"javascript:;"', '<i class="iconsminds-file-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'rel' => $pro['ps_id'],'start_date' => $pro['ps_date'],'product' => $pro['ps_product'],'plant_id' => $pro['plant_id'],'line' => $pro['ps_line'], 'title' => 'Edit Product'));
                                              echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_record btn  c-btn', 'rel' => $pro['ps_id'], 'title' => 'Delete Product'));
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
                                            <td  colspan="7" class="text-center red-color" style="border:none !important;text-align: center;font-weight:bold;width: 100%">No schedules for the day</td>
                                          </tr>
                                        <?php }
                                      endforeach;
                                      } ?>
                                    </tbody>
                                  </table>
                                  <br><br>
                                  <div class="mg-t-20-f floatright" style="clear: both" id="light-pagination"></div>
                              </div>
                            </div>
                            </div>
                            </div>
                            <!-- ----------end-------- -->
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </main>



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
        $("#adding_plant .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_plant" style="clear: both; margin-top: 10px;">Submit</button>');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
        $("#product_schedules .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submit_from" style="clear: both; margin-top: 10px;">Submit</button>');
      	 //'.selectpicker').selectpicker('refresh');
        $( ".selectpicker" ).addClass('selectbox-class');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
        $(".input-group.date").datepicker({
        autoclose: true,
        rtl: false,
        templates: {
          leftArrow: '<i class="simple-icon-arrow-left"></i>',
          rightArrow: '<i class="simple-icon-arrow-right"></i>'
        }
      });
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
        $("#upload_file .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submit_upload_image" style="clear: both; margin-top: 10px;">Submit</button>');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
         $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
  var plant_id = $(this).attr('plant_id');
  var line = $(this).attr('line');
  e.preventDefault();
    $.ajax({
      type: 'POST',
      url: "<?php ADMIN_BASE_URL?>global_configuration/get_product_schedules",
      data: {'id': id,'start_date':start_date,'product':product,'plant':plant_id,'line':line},
      async: false,
      success: function(test_body) {
        $('#product_schedules').modal('show');
        $("#product_schedules .modal-body").html(test_body);
        $("#product_schedules .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submit_from" style="clear: both; margin-top: 10px;">Submit</button>');

        $('.selectpicker').selectpicker('refresh');
        $( ".selectpicker" ).addClass('selectbox-class');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
        $("#adding_plant .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_plant" style="clear: both; margin-top: 10px;">Submit</button>');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
        $("#adding_line .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_line" style="clear: both; margin-top: 10px;">Submit</button>');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
        $("#adding_shift .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_shift" style="clear: both; margin-top: 10px;">Submit</button>');
       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
          $("#adding_shift .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_shift" style="clear: both; margin-top: 10px;">Submit</button>');
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
        $("#adding_shift_timing .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_shift_timing" style="clear: both; margin-top: 10px;">Submit</button>');

       $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
          $("#adding_shift_timing .modal-footer").html('<button type="submit" class="btn-outline-primary btn pull-right submited_shift_timing" style="clear: both; margin-top: 10px;">Submit</button>');
         $('.datetimepicker1').datetimepicker({
    	defaultDate: new Date(),
    	format: ' H:mm:ss',
    	sideBySide: true
	});
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
  var firstclick = "one";
  $(document).ready(function() {
      $('.filter_search').on('click', function() {
          var startdate=$('#startdate').val();
          var enddate=$('#enddate').val();
          if(startdate == '' || enddate == '') {
              toastr.success('Please Select Date Range');
          }
          else {
              firstclick="fdafdas";
              ajax_call('1',startdate,enddate);
          }    
      });
  });
  function pagination_call(total_number_pages,active) {
    $.getScript("<?php echo STATIC_ADMIN_JS;?>jquery.simplePagination.js").done(function( s, Status ) {
      $('#light-pagination').pagination({
        items: total_number_pages,
        itemsOnPage: <?=$limit?>,
        cssStyle: 'light-theme'
        });
        $('#light-pagination').pagination('selectPage', active);
        $('#light-pagination').off('click').click(function(event) {
            var valuecheck = '';
            if($(this).find('.active').text() == 'Next') {
                valuecheck = parseInt($('#light-pagination').find('.active').find('.current').text());
            }
            else if($(this).find('.active').text() == 'Prev') {
                valuecheck = parseInt($('#light-pagination').find('.active').find('.current').text());
            }
            else {
                valuecheck = $(this).find('.active').text();
            }
            var StartDate=$('#startdate').val();
            var EndDate=$('#enddate').val();
            if(firstclick != "fdafdas") {
                StartDate = "";
                EndDate = "";
            }
            ajax_call(valuecheck,StartDate,EndDate);
            
        });
        $('#light-pagination').find('.page-link').each(function(){
            $(this).attr('href','javascript:void(0);');
        });
    });
  }
  var citycurrentRequest=null;
  function ajax_call(page_number,startdate,enddate) {
      citycurrentRequest= $.ajax({
          type: "POST",  
          url: '<?= ADMIN_BASE_URL?>global_configuration/product_schedule_filter_search',  
          data: {'page_number':page_number,'startdate':startdate,'enddate':enddate,'limit':'7'},
          dataType: 'html',
          beforeSend : function()    {           
            if(citycurrentRequest != null) {
              citycurrentRequest.abort();
            }
          },
          success: function(result) {
              var datamain = $(result).find('datamain').html();
              var tablecreat = ''
              var active= $(result).find('pagenumber').text();
              var total_number_pages= $(result).find('totalpage').text();
              $(result).find('datamain').find('trr').each(function(){
                  tablecreat = tablecreat+'<tr id="'+$(this).attr('id')+'" class="'+$(this).attr('class')+'" style="'+$(this).attr('style')+'">';
                  $(this).find('tdd').each(function(){
                      tablecreat = tablecreat+'<td id="'+$(this).attr('id')+'" class="'+$(this).attr('class')+'" style="'+$(this).attr('style')+'">'+$(this).html()+'</td>';
                  })
              })
              tablecreat = tablecreat+'<tr>';
              if(total_number_pages == '0')
                      tablecreat = tablecreat+'<td colspan="6">No data available in table</td>';
                  tablecreat = tablecreat+'</tr>';
              $('#ajax_content_wrapper').html(tablecreat);
              if(total_number_pages > 1)
                  pagination_call(total_number_pages,active);
              else
                  pagination_call('1','1');
          }
      });
  }
  <?php if(isset($page_number) && is_numeric($page_number) && isset($total_pages) && is_numeric($total_pages)) { if($total_pages>1) {?>
        pagination_call('<?=$total_pages;?>','<?=$page_number;?>');
    <?php }}?>

    $(document).off("click",".plant_status").on("click",".plant_status", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('rel_status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>global_configuration/change_status",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 0) {
                $(this).find("i").removeClass('fa-arrow-down');
                $(this).find("i").addClass('fa-arrow-up');
                $(this).attr('plant_status', '0');
            	$(this).attr('title', 'Inactive');
            } else {
                $(this).find("i").removeClass('fa-arrow-up');
                $(this).find("i").addClass('fa-arrow-down');
                $(this).attr('plant_status', '1');
            	$(this).attr('title', 'Active');
            }
    location.reload();
        });
</script>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
// document.getElementById("defaultOpen").click();
</script>