<?php
function timezone_menu2($default = 'UTC', $class = "form-control select2me", $name = 'timezones')
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
                        General Setting
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

                                        <div class="portlet-body form" id="gen_setting">
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
                                            <div class="form-body">

                                                <div class="container">
                                                   
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $dine_in = '';
                                                            if (isset($general_settings['take_in_vat'])) {
                                                                $dine_in = $general_settings['take_in_vat'];
                                                            }
                                                            $data = array(
                                                                'name' => 'take_in_vat',
                                                                'id' => 'take_in_vat',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $dine_in,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Spis Her VAT(%)', 'take_in_vat', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                     <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $discount = '';
                                                            if (isset($general_settings['discount'])) {
                                                                $discount = $general_settings['discount'];
                                                            }
                                                            $data = array(
                                                                'name' => 'discount',
                                                                'id' => 'discount',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $discount,
                                                                'type'=>'number',
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Discount (%)', 'Discount (%)', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $take_out_vat = '';
                                                            if (isset($general_settings['take_out_vat'])) {
                                                                $take_out_vat = $general_settings['take_out_vat'];
                                                            }
                                                            $data = array(
                                                                'name' => 'take_out_vat',
                                                                'id' => 'take_out_vat',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $take_out_vat,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Ta Med VAT(%)', 'take_out_vat', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $delivery_charges = '';
                                                            if (isset($general_settings['delivery_charges'])) {
                                                                $delivery_charges = $general_settings['delivery_charges'];
                                                            }
                                                            $data = array(
                                                                'name' => 'delivery_charges',
                                                                'id' => 'delivery_charges',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $delivery_charges,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Delivery Charges', 'delivery_charges', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $dc_per_km = '';
                                                            if (isset($general_settings['dc_per_km'])) {
                                                                $dc_per_km = $general_settings['dc_per_km'];
                                                            }
                                                            $data = array(
                                                                'name' => 'dc_per_km',
                                                                'id' => 'dc_per_km',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $dc_per_km,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Delivery Charges per Kilometer', 'dc_per_km', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $delivery_charges_vat = '';
                                                            if (isset($general_settings['delivery_charges_vat'])) {
                                                                $delivery_charges_vat = $general_settings['delivery_charges_vat'];
                                                            }
                                                            $data = array(
                                                                'name' => 'delivery_charges_vat',
                                                                'id' => 'delivery_charges_vat',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $delivery_charges_vat,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Dellivery Charges VAT(%)', 'delivery_charges_vat', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $outlet_slogan = '';
                                                            if (isset($general_settings['outlet_slogan'])) {
                                                                $outlet_slogan = $general_settings['outlet_slogan'];
                                                            }
                                                            $data = array(
                                                                'name' => 'outlet_slogan',
                                                                'id' => 'outlet_slogan',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $outlet_slogan,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Food Point Slogan ', 'outlet_slogan', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $delivery_time = '';
                                                            if (isset($general_settings['delivery_time'])) {
                                                                $delivery_time = $general_settings['delivery_time'];
                                                            }
                                                            $data = array(
                                                                'name' => 'delivery_time',
                                                                'id' => 'delivery_time',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $delivery_time,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Delivery Time', 'delivery_time', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $delivery_limit = '';
                                                            if (isset($general_settings['delivery_limit'])) {
                                                                $delivery_limit = $general_settings['delivery_limit'];
                                                            }
                                                            $data = array(
                                                                'name' => 'delivery_limit',
                                                                'id' => 'delivery_limit',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $delivery_limit,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Delivery Limit', 'delivery_limit', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $delivery_km_range = '';
                                                            if (isset($general_settings['delivery_km_range'])) {
                                                                $delivery_km_range = $general_settings['delivery_km_range'];
                                                            }
                                                            $data = array(
                                                                'name' => 'delivery_km_range',
                                                                'id' => 'delivery_km_range',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $delivery_km_range,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Delivery in Kilometer', 'delivery_km_range', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $free_delivery_km_range = '';
                                                            if (isset($general_settings['free_delivery_km_range'])) {
                                                                $delivery_km_range = $general_settings['free_delivery_km_range'];
                                                            }
                                                            $data = array(
                                                                'name' => 'free_delivery_km_range',
                                                                'id' => 'free_delivery_km_range',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $delivery_km_range,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Free Delivery in Kilometer', 'delivery_km_range', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $free_delivery_limit = '';
                                                            if (isset($general_settings['free_delivery_limit'])) {
                                                                $free_delivery_limit = $general_settings['free_delivery_limit'];
                                                            }
                                                            $data = array(
                                                                'name' => 'free_delivery_limit',
                                                                'id' => 'free_delivery_limit',
                                                                'class' => 'form-control  text-input',
                                                                'value' => $free_delivery_limit,
                                                            );
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Free Delivery Limit', 'free_delivery_limit', $attribute);
                                                            ?>
                                                            <div class="col-md-4">
                                                                <?php echo form_input($data); ?>
                                                            </div>
                                                        </div>
                                                    </div>   

                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'take_out',
                                                          'id' => 'take_out',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'order_type'
                                                          );

                                                          if($general_settings['take_out'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Take Out', 'take_out', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>

                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'take_in',
                                                          'id' => 'take_in',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'order_type'
                                                          );

                                                          if($general_settings['take_in'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Take In', 'take_in', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>

                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'delivery',
                                                          'id' => 'delivery',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'order_type'
                                                          );

                                                          if($general_settings['delivery'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Delivery', 'delivery', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>

                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'is_cash_on_delivery',
                                                          'id' => 'is_cash_on_delivery',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'order_type'
                                                          );

                                                          if($general_settings['is_cash_on_delivery'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Betal i restaurant', 'is_cash_on_delivery', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>                                             


                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'is_online_cash',
                                                          'id' => 'is_online_cash',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'order_type'
                                                          );

                                                          if($general_settings['is_online_cash'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Online Payment', 'is_online_cash', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>



                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'is_fixed_delivery',
                                                          'id' => 'is_fixed_delivery',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'is_fixed_delivery'
                                                          );

                                                          if($general_settings['is_fixed_delivery'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Fixed Delivery', 'is_fixed_delivery', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>          

                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'is_free_delivery',
                                                          'id' => 'is_free_delivery',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'is_free_delivery'
                                                          );

                                                          if($general_settings['is_free_delivery'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Free Delivery', 'is_free_delivery', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>                                        

                                                    <div class="row">
                                                      <div class="col-sm-9">
                                                          <div class="form-group">
                                                          <?php
                                                          $data = array(
                                                          'name' => 'is_coupon',
                                                          'id' => 'is_coupon',
                                                          'value' => 1,
                                                          'style' => 'margin:10px',
                                                          'class' => 'order_type'
                                                          );

                                                          if($general_settings['is_coupon'] == 1)
                                                              $data['checked'] = TRUE;

                                                          $attribute = array('class' => 'control-label col-md-4');
                                                          ?>
                                                          <?php echo form_label('Coupon Allow', 'is_coupon', $attribute); ?>
                                                          <div class="col-md-8">
                                                          <?php echo form_checkbox($data); ?>
                                                          </div>
                                                          </div>
                                                      </div>
                                                    </div>
                                                    <!-- -------------NEW SECTION END-------------- -->

                                                    <div class="row">
                                                        <div class="form-group">
                                                                <?php
                                                                $this->load->helper('date');
                                                                $attribute = array('class' => 'control-label col-md-3');
                                                                echo form_label('Language', 'language', $attribute);
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <?php
                                                                        $language = strtolower($general_settings['language']);
                                                                        echo form_dropdown('language', $languages, [$language => $language], "class='form-control' id='language'");
                                                                    ?>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    <div class="row">
                                                        <div class="form-group">
                                                            <?php
                                                            $this->load->helper('date');
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Time Zone', 'timezones', $attribute);
                                                            ?>
                        <div class="col-md-4">
                                <?php
                                if (isset($general_settings['timezones']) && !empty($general_settings['timezones']))
                                    $timezone = $general_settings['timezones'];
                                else
                                    $timezone = '';
                                echo timezone_menu2($timezone);
                                ?>
                        </div>

                                                        </div>
                                                    </div>

                                                    <div class="row" >
                                                        <div class="form-group">
                                                            <?php
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Date Format', 'date_format', $attribute);

                                                            $this->config->load('general_constants');
                                                            $arr_date_format = $this->config->item('Date_Format_Type');
                                                            ?>
                                                            <div class="col-md-9"><? foreach ($arr_date_format as $key => $format): ?>
                                                                    <div class="margin-bottom-10">
                                                                        <br>
                                                                        <span>
                                                                            <?php
                                                                            $date_format = '';
                                                                            if (isset($general_settings['date_format'])) {
                                                                                $date_format = $general_settings['date_format'];
                                                                            }
                                                                            $data = array(
                                                                                'name' => 'date_format',
                                                                                'id' => $format,
                                                                                'class' => 'toggle',
                                                                                'value' => $key,
                                                                            );
                                                                            if ($date_format == $key)
                                                                                $data['checked'] = 'checked';
                                                                            $label = $format;

                                                                            $attribute = array('class' => 'control-label col-md-2');
                                                                            echo form_label($label, $label, $attribute);
                                                                            ?>
                                                                        </span>
                                                                        <span>
                                                                            <div class="make-switch radio1 radio-no-uncheck h-30">
                                                                                <?php echo form_radio($data); ?>
                                                                            </div>
                                                                        </span>

                                                                    </div>

                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row" >
                                                        <div class="form-group">
                                                            <?php
                                                            $attribute = array('class' => 'control-label col-md-3');
                                                            echo form_label('Time Format', 'time_format', $attribute);
                                                            $this->config->load('general_constants');
                                                            $time_format = $this->config->item('time_Format_Type');
                                                            ?><div class="col-md-9"><?
                                                            foreach ($time_format as $key => $time):
                                                                ?>
                                                                    <div class="margin-bottom-10">

                                                                        <br>

                                                                        <span>
                                                                            <?php
                                                                            $time_format = '';
                                                                            if (isset($general_settings['time_format'])) {
                                                                                $time_format = $general_settings['time_format'];
                                                                            }
                                                                            $data = array(
                                                                                'name' => 'time_format',
                                                                                'id' => $time,
                                                                                'class' => 'toggle',
                                                                                'value' => $key,
                                                                            );
                                                                            if ($time_format == $key)
                                                                                $data['checked'] = 'checked';
                                                                            $label = $time;

                                                                            $attribute = array('class' => 'control-label col-md-2');
                                                                            echo form_label($label, $label, $attribute);
                                                                            ?>
                                                                        </span>
                                                                        <span>
                                                                            <div class="make-switch radio1 radio-no-uncheck h-30">
                                                                                <?php echo form_radio($data); ?>
                                                                            </div>
                                                                        </span>
                                                                    </div>

                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div> <!-- end container-->
            <div class="row">
        

            <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Discount image</label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?php
                $filename =  FCPATH.ACTUAL_GENERAL_SETTING_IMAGE_PATH.$discount_image->image;
                if (isset($discount_image->image) && !empty($discount_image->image) && file_exists($filename)) {
                ?>
                <img src = "<?php echo BASE_URL.ACTUAL_GENERAL_SETTING_IMAGE_PATH.$discount_image->image ?>" />
                <?php
                } else {
                ?>
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                <?php
                }
                ?>
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                </div>
                <div>
                <span class="btn default btn-file">
                <span class="fileupload-new">
                <i class="fa fa-paper-clip"></i> Select Image
                </span>
                <span class="fileupload-exists">
                <i class="fa fa-undo"></i> Change
                </span>
                <input type="file" name="outlet_fav_icon" id="outlet_fav_icon" class="default" />
                <input type="hidden" id="hdn_image_fav_icon" value="<?= $discount_image->image?>" name="hdn_image_fav_icon" />
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
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
                                                <?php echo form_close(); ?>
                                                <!-- END FORM-->
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
