<div>
        <datamain>
          <?php if($check == 'city') { ?>
          <div class="col-sm-5 city_div">
            <div class="form-group">
              <?php
              if(!isset($selected) || empty($selected))
                $selected="";
              $options = array('0' => 'Select') + $country_option;
              $attribute = array('class' => 'control-label col-md-4');
              echo form_label('City <span class="required" style="color:red">*</span>', 'city', $attribute);?>
              <div class="col-md-8"><?php echo form_dropdown('city', $options, strtolower($selected), 'class="form-control city_select" id="city_select" required="required" '); ?>
              </div>
            </div>
          </div>
          <?php  }
          elseif($check == 'town') {?>
            <div class="col-sm-5 town_div">
              <div class="form-group">
                <?php
                if(!isset($selected) || empty($selected))
                  $selected="";
                $options = array('' => 'Select') + $town_option;
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Town <span class="required" style="color:red">*</span>', 'city', $attribute);?>
                <div class="col-md-8"><?php echo form_dropdown('driver_town', $options, $selected, 'class="form-control town_select" id="city_select" required="required" '); ?>
                </div>
              </div>
            </div>
          <?php  }
          elseif($check == 'post_code') {?>
            <div class="col-sm-5">
              <div class="form-group post_div">
                <?php
                if(!isset($selected) || empty($selected))
                  $selected="";
                $options = array('' => 'Select') + $post_option;
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Post Code <span class="required" style="color:red">*</span>', 'post_code', $attribute);?>
                <div class="col-md-8"><?php echo form_dropdown('driver_post_code', $options, $selected, 'class="form-control post_select" id="post_select" required="required" '); ?>
                </div>
              </div>
            </div>
          <?php }?>
        </datamain>
    </div>