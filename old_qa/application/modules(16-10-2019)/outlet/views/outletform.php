<div class="content-wrapper">

    <h3>
    <?php
    if (empty($update_id))
    $strTitle = 'Add Outlet';
    else
    $strTitle = 'Edit Outlet';
    echo $strTitle;
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    </h3>

    <div class="panel panel-default">
        <div class="panel-body">
        <?php
        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
        if (empty($update_id)) {
            $update_id = 0;
        } else {
            $hidden = array('hdnId' => $update_id);
        }
        if (isset($hidden) && !empty($hidden))
            echo form_open_multipart(ADMIN_BASE_URL . 'outlet/submit/' . $update_id , $attributes, $hidden);
        else
            echo form_open_multipart(ADMIN_BASE_URL . 'outlet/submit/' . $update_id , $attributes);
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtBuildingName',
                'id' => 'txtBuildingName',
                'class' => 'form-control',
                'type' => 'text',
                'required' => 'required',
                'value' => $outlet['name']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Name <span class="required" style="color:red">*</span>', 'txtBuildingName', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
             <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'point_slogan',
                'id' => 'point_slogan',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['point_slogan']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Food Point Slugan Text <span class="required" style="color:red"></span>', 'txtBuildingName', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtUrl',
                'id' => 'txtUrl',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['url']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Url   ', 'txtUrl', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name'        => 'url_slug',
                'id'          => 'url_slug',
                'maxlength'   => '60',
                'class'     => 'form-control form-control1',
                'value'       => $outlet['url_slug'],
                'type' => 'text',
                'readonly' => 'readonly',
                );
                $attribute = array('class' => 'control-label form-control1 col-md-4');
                echo form_label('URL Slug ','url_slug', $attribute);
                echo '<div class="col-md-8" style="margin-bottom:15px;">'.form_input($data).'</div>';
                ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                   <label class="col-sm-4 control-label">Restaurant Types</label>
                   <div class="col-sm-8">
                      <select multiple class="chosen-select form-control restaurant_type" name="restaurant_type[]">
                         <?php
                        $i=0;
                        if(!isset($outlet_types) || empty($outlet_types))
                            $outlet_types = array();
                          foreach ($restaurant_type as $value): ?>
                             <option value="<?=$value['id']?>"  <?php foreach ($outlet_types as $types): ?> <?php  if($value['id']==$types['outlet_catagory']) echo 'selected="selected"'; ?><?php endforeach ?>><?= $value['cat_name']?></option>
                         <?php $i=$i+1;endforeach ?>
                      </select>
                   </div>
                </div>
            </div>
        </div>
         <div class="row" style="display:none;">
             <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name'        => 'percentage',
                'id'          => 'percentage',
                'maxlength'   => '2',
                'class'     => 'form-control form-control1',
                'value'       => $outlet['percentage'],
                'type' => 'hidden',
                
                );
                $attribute = array('class' => 'control-label form-control1 col-md-4');
                echo form_label('Disount(%)','Disount(%)', $attribute);
                echo '<div class="col-md-8" style="margin-bottom:15px;">'.form_input($data).'</div>';
                ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtPhone',
                'id' => 'txtPhone',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['phone']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Phone   ', 'txtPhone', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtEmail',
                'id' => 'txtEmail',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['email']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Email   ', 'txtEmail', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtOrgination',
                'id' => 'txtOrgination',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['orgination_no']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Orgaination No.   ', 'txtOrgination', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>
        <div class="row append-mainn" >
            <div class="col-sm-6 country_div">
                  <div class="form-group">
                <?php
                if(!isset($outlet['country']) || empty($outlet['country']))
                  $outlet['country']="";
                $options = array('0' => 'Select') + $country_option;
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Country <span class="required" style="color:red">*</span>', 'country', $attribute);?>
                <div class="col-md-8"><?php echo form_dropdown('country', $options,$outlet['country'], 'class="form-control country_id validatefield" id="country_id" required="required" '); ?></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtState',
                'id' => 'txtState',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['state']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('State   ', 'txtState', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtPost_Code',
                'id' => 'txtPost_Code',
                'class' => 'form-control',
                'type' => 'number',
                'pattern' => '[0-9]*',
                'maxlength' => '5',
                'value' => $outlet['post_code']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Post Code   ', 'txtPost', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtAddress',
                'id' => 'txtAddress',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['address']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Address   ', 'txtAddress', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtGoogglemap',
                'id' => 'txtGoogglemap',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['google_map']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Google Map   ', 'txtGoogglemap', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'fax',
                'id' => 'fax',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['fax']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Fax', 'fax', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'web_title',
                'id' => 'web_title',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['web_title']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Web Title', 'web_title', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Meta Description', 'meta_description', $attribute);
                ?>
                <div class="col-md-8"><textarea class="form-control" name="meta_description" rows="6"><?php echo $outlet['meta_description']?></textarea></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('About Us', 'about_us', $attribute);
                ?>
                <div class="col-md-8"><textarea class="form-control" name="about_us" rows="6"><?php echo $outlet['about_us']?></textarea></div>
                </div>
            </div>
        </div>
 <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adafs" class="control-label  col-md-4">Dietary <span class="required" style="color:red">*</span></label>
                    <div class="col-md-8">
                        <select name="dietary[]"   multiple="multiple" class = "select-1 chosen-select form-control validatefield dietaries">
                          <?php
                            $sub_categories=Modules::run('slider/_get_where_cols',array("od_outlet_id" =>$update_id),'od_id desc','outlet_dietary','od_dietary_id')->result_array();
                            $html= "";
                            if(!isset($dietary))
                              $dietary = array();
                            foreach ($dietary as $key => $value) {
                              if(isset($sub_categories))
                                $check = array_search($key, array_column($sub_categories, 'od_dietary_id'));
                              else
                                $check='===';
                              if (is_numeric($check)) 
                                  $html .= '<option value="'.$key.'" selected= selected >'.$value.'</option>';
                              else
                               $html .= '<option value="'.$key.'">'.$value.'</option>';
                            }
                            echo $html; ?>
                          </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adafs" class="control-label  col-md-4">Services <span class="required" style="color:red">*</span></label>
                    <div class="col-md-8">
                        <select name="services[]"   multiple="multiple" class = "select-1 chosen-select form-control validatefield dietaries">
                          <?php
                            $sub_categories=Modules::run('slider/_get_where_cols',array("outlet_id" =>$update_id),'id desc','outlet_facilities','feature_id')->result_array();
                            $html= "";
                            if(!isset($service_data))
                              $service_data = array();
                            foreach ($service_data as $key => $value) {
                              if(isset($sub_categories))
                                $check = array_search($key, array_column($sub_categories, 'feature_id'));
                              else
                                $check='===';
                              if (is_numeric($check)) 
                                  $html .= '<option value="'.$key.'" selected= selected >'.$value.'</option>';
                              else
                               $html .= '<option value="'.$key.'">'.$value.'</option>';
                            }
                            echo $html; ?>
                          </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Logo (front)</label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?
                $filename =  './uploads/outlet/actual_images/' . $outlet['image'];
                if (isset($outlet['image']) && !empty($outlet['image']) && file_exists($filename)) {
                ?>
                <img src = "<?php echo BASE_URL . 'uploads/outlet/actual_images/' . $outlet['image'] ?>" />
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
                <input type="file" name="outlet_file" id="outlet_file" class="default" />
                <input type="hidden" id="hdn_image" value="<?= $outlet['image'] ?>" name="hdn_image" />
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Fav Icon</label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?php
                $filename =  FCPATH.'/uploads/outlet/actual_images/'.$outlet['fav_icon'];
                if (isset($outlet['fav_icon']) && !empty($outlet['fav_icon']) && file_exists($filename)) {
                ?>
                <img src = "<?php echo BASE_URL.'uploads/outlet/actual_images/'.$outlet['fav_icon'] ?>" />
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
                <input type="hidden" id="hdn_image_fav_icon" value="<?= $outlet['fav_icon'] ?>" name="hdn_image_fav_icon" />
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>


<div class="row">
            <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Logo (Admin)</label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?
                $filename =  FCPATH.'/uploads/outlet/actual_images/' . $outlet['adminlogo'];
                if (isset($outlet['adminlogo']) && !empty($outlet['adminlogo']) && file_exists($filename)) {
                ?>
                <img src = "<?php echo BASE_URL . 'uploads/outlet/actual_images/' . $outlet['adminlogo'] ?>" />
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
                <input type="file" name="outlet_adminlogo" id="outlet_adminlogo" class="default" />
                <input type="hidden" id="hdn_adminlogo" value="<?= $outlet['adminlogo'] ?>" name="hdn_adminlogo" />
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Small Logo (Admin)</label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?php
                $filename =  FCPATH.'/uploads/outlet/actual_images/'.$outlet['adminlogo_small'];
                if (isset($outlet['adminlogo_small']) && !empty($outlet['adminlogo_small']) && file_exists($filename)) {
                ?>
                <img src = "<?php echo BASE_URL.'uploads/outlet/actual_images/'.$outlet['adminlogo_small'] ?>" />
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
                <input type="file" name="outlet_adminlogo_small" id="outlet_adminlogo_small" class="default" />
                <input type="hidden" id="hdn_adminlogo_small" value="<?= $outlet['adminlogo_small'] ?>" name="hdn_adminlogo_small" />
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
                </div>
            </div>
             <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Cover Image</label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?php
                if(!isset($outlet['outlet_cover_image']))
                    $outlet['outlet_cover_image'] = "";
                $filename =  FCPATH.'/'.ACTUAL_OUTLET_TYPE_IMAGE_PATH.$outlet['outlet_cover_image'];
                if (isset($outlet['adminlogo_small']) && !empty($outlet['outlet_cover_image']) && file_exists($filename)) {
                ?>
                <img src = "<?php echo BASE_URL.ACTUAL_OUTLET_TYPE_IMAGE_PATH.$outlet['outlet_cover_image'] ?>" />
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
                <input type="file" name="outlet_cover_image" id="outlet_cover_image" class="default" />
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group"  >
                <?php
                $options = array(0 => 'Select') + $arr_templates;
                $attribute = array('class' => 'control-label  col-md-4');
                $data_id = "data-id='".$update_id."'";
                echo form_label('Template <span class="required" style="color:red">*</span>','lstRank', $attribute);
                echo '<div class="col-md-8" >'.form_dropdown('template_name', $options, $outlet['template_name'], ' class = "form-control  form-control1 select2me "  id="template" '.$data_id).'</div>';
                ?>
                </div>
            </div>

             <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'facebook_appId',
                'id' => 'facebook_appId',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['facebook_appId']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Facebook App ID:', 'facebook_appId', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'merchant_live',
                'id' => 'merchant_live',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['merchant_live']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Merchant Live:', 'merchant_live', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'merchant_test',
                'id' => 'merchant_test',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['merchant_test']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Merchant Test:', 'merchant_test', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>
        <fieldset>
                <legend align="left">Social Media</legend>
                <!-- //////////////////// Socical Links ///////////////////// -->

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'facebook_link',
                'id' => 'facebook_link',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['facebook_link']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Facebook', 'facebook_link', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'twitter_link',
                'id' => 'twitter_link',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['twitter_link']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Twitter', 'twitter_link', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>
<div class="col-md-12" style="margin-top: 10px;"></div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'googleplus_link',
                'id' => 'googleplus_link',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['googleplus_link']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Google Plus', 'googleplus_link', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'linkedin_link',
                'id' => 'linkedin_link',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['linkedin_link']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('LinkedIn', 'linkedin_link', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>
<div class="col-md-12" style="margin-top: 10px;"></div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'google_store',
                'id' => 'google_store',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['google_store']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Google Play Link', 'google_store', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'ios_store',
                'id' => 'ios_store',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['ios_store']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('iTunes Link', ' ios_store', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

<!-- ///////////////////// End Socail Links -->
        </fieldset>


            <fieldset>
                <legend align="left">SMTP Info</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'smtp_username',
                        'id' => 'smtp_username',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['smtp_username']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Username:', 'smtp_username', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'smtp_password',
                        'id' => 'smtp_password',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['smtp_password']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Password:', 'smtp_password', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 10px;"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'smtp_host',
                        'id' => 'smtp_host',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['smtp_host']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Host:', 'smtp_host', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'smtp_port',
                        'id' => 'smtp_port',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['smtp_port']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Port:', 'smtp_port', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend align="left">Smart Phone Settings</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'android_version_code',
                        'id' => 'android_version_code',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['android_version_code']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Android Version Code:', 'android_version_code', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'iPhone_version_code',
                        'id' => 'iPhone_version_code',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['iPhone_version_code']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('iPhone Version Code:', 'iPhone_version_code', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 10px;"></div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'version_alert',
                        'id' => 'version_alert',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['version_alert']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Version Alert:', 'version_alert', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'is_android_update',
                'id' => 'is_android_update',
                'value' => 1,
                'style' => 'margin:10px',
                'class' => 'is_android_update'
                );
                if($outlet['is_android_update'] == 1){
                    $data['checked'] = TRUE;
                }
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Is Android Update', 'is_android_update', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_checkbox($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'is_iPhone_update',
                'id' => 'is_iPhone_update',
                'value' => 1,
                'style' => 'margin:10px',
                'class' => 'is_iPhone_update'
                );
                if($outlet['is_iPhone_update'] == 1){
                    $data['checked'] = TRUE;
                }
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Is iPhone Update', 'is_iPhone_update', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_checkbox($data); ?>
                </div>
                </div>
            </div>
         </div>

            </fieldset>
  
           <fieldset>
    <legend align="left" style="width: 94%;float: right;">
        Seo Info:
    </legend>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <?php
                                $data = array(
                                    'name' => 'seo_link',
                                    'id' => 'seo_link',
                                    'class' => 'form-control ',
                                    'value' => $new['seo_link'],
                                    'type' => 'text',
                                    'required' => 'required',
                                   
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                    <?php echo form_label('Link <span class="required" style="color:red">*</span>', 'txtNewsTitle', $attribute); ?>
                    <div class="col-md-8">
                        <?php echo form_input($data); ?>
                    </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <?php
                                $data = array(
                                    'name' => 'seo_meta_keyword',
                                    'id' => 'txtNewsTitle',
                                    'class' => 'form-control',
                                    'value' => $new['seo_meta_keyword'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                    <?php echo form_label('Meta Keyword <span class="required" style="color:red">*</span>', 'txtNewsTitle', $attribute); ?>
                    <div class="col-md-8">
                        <?php echo form_input($data); ?>
                    </div>
            </div>
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col-sm-5">
            <div class="form-group">
                <?php
                                $data = array(
                                    'name' => 'seo_meta_description',
                                    'id' => 'txtNewsTitle',
                                    'class' => 'form-control',
                                    'value' => $new['seo_meta_description'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                    <?php echo form_label('Meta Description<span class="required" style="color:red">*</span>', 'txtNewsTitle', $attribute); ?>
                    <div class="col-md-8">
                        <?php echo form_input($data); ?>
                    </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <?php
                                $data = array(
                                    'name' => 'seo_meta_title',
                                    'id' => 'txtNewsTitle',
                                    'class' => 'form-control',
                                    'value' => $new['seo_meta_title'],
                                    'type' => 'text',
                                    'required' => 'required',
                                    
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                    <?php echo form_label('Meta Title <span class="required" style="color:red">*</span>', 'txtNewsTitle', $attribute); ?>
                    <div class="col-md-8">
                        <?php echo form_input($data); ?>
                    </div>
            </div>
        </div>

    </div>
    <br>
    <div class="row">
        

        <div class="col-sm-5">
            <div class="form-group">
                <?php
                if(empty( $new['seo_function_name']))
                {
                   $new['seo_function_name']= "restaurant_detail";
                }
                                $data = array(
                                    'name' => 'seo_function_name',
                                    'id' => 'txtNewsTitle',
                                    'class' => 'form-control',
                                    'value' => $new['seo_function_name'],
                                    'type' => 'hidden',
                                    'required' => 'required',
                                   
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                    <?php echo form_label(' <span class="required" style="color:red"></span>', 'txtNewsTitle', $attribute); ?>
                    <div class="col-md-8">
                        <?php echo form_input($data); ?>
                    </div>
            </div>
        </div>
         <div class="col-sm-5">
            <div class="form-group">
                <?php
                                $data = array(
                                    'name' => 'seo_link_id',
                                    'id' => 'seo_link_id',
                                    'class' => 'form-control',
                                    'value' => $new['seo_link_id'],
                                    'type' => 'hidden',
                                    'required' => 'required',
                                   
                                );
                                $attribute = array('class' => 'control-label col-md-4');
                                ?>
                    <?php echo form_label(' <span class="required" style="color:red"></span>', 'txtNewsTitle', $attribute); ?>
                    <div class="col-md-8">
                        <?php echo form_input($data); ?>
                    </div>
            </div>
        </div>

    </div>


</fieldset>


 <fieldset>
                <legend align="left">Google/Facebook insights Code</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'google_js',
                        'id' => 'google_js',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['google_js']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Google Code:', 'smtp_username', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <?php
                        $data = array(
                        'name' => 'facebook_js',
                        'id' => 'facebook_js',
                        'class' => 'form-control',
                        'type' => 'text',
                        'value' => $outlet['facebook_js']
                        );
                        $attribute = array('class' => 'control-label col-md-4');
                        ?>
                        <?php echo form_label('Facebook Code:', 'smtp_password', $attribute); ?>
                        <div class="col-md-8">
                        <?php echo form_input($data); ?>
                        </div>
                        </div>
                    </div>
                </div>
               
            </fieldset>
                <input type="hidden" id="confirm_replace" name="confirm_replace" value="no">

        <div class="row">
            <div class="col-md-6">
            <div class="col-md-offset-4 col-md-10">
                <button type="button" class="btn btn-primary" class="outlet_save" id='save_btn' data-id="<?= $update_id ?>"><i class="fa fa-check"></i>&nbsp;Save</button>
            <a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>">
            <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
            </a>
            </div>
            </div>
        </div>

        <?php echo form_close(); ?>
        </div>
    </div>

</div>

<script>
    $('.country_id').on('change', function() {
      var id = this.value;
      $this=$(this);
      $parent = $this.parent().parent().parent().parent();
      $parent.find('.city_select').parent().parent().parent().remove();
      get_city_record(id,'',$this,0);
    });
    function get_city_record(id,selected,this_refrence,condition) {
        $this=this_refrence;
        $.ajax({
          type: 'POST',
          url: "<?php echo ADMIN_BASE_URL?>outlet/country_cities",
          data: {'id': id,'selected':selected},
          async: false,
          success: function(result) {
            var datamain = $(result).find('datamain').html();
            if(condition === 0)
                $this.parent().parent().parent().after(datamain);
            else
                $('.append-mainn').find('.country_div').after(datamain);
            $('.city_div').attr('class','col-sm-6 city_div');
          }
        });
    }
$(document).ready(function() {
    $("#outlet_file").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_image').val(replaced_val);
    });

    $("#outlet_fav_icon").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_image_fav_icon').val(replaced_val);
    });


    $("#outlet_adminlogo").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_adminlogo').val(replaced_val);
    });

    $("#outlet_adminlogo_small").change(function() {
        var img = $(this).val();
        var replaced_val = img.replace("C:\\fakepath\\", '');
        $('#hdn_adminlogo_small').val(replaced_val);
    });


    $(function(){
        $('.order_type:input:checkbox').change(function() {
            var isChecked = $('.order_type:input:checkbox').is(':checked');
            if(!isChecked){
                $(this).prop('checked', true);
            }

        });
    });

});

    $(document).off("keyup", "#txtBuildingName").on("keyup", "#txtBuildingName", function(event) {
        var page_title = $(this).val();
        $("#url_slug").val(page_title.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''));
    }); 

$(function(){
    $('#save_btn').click( function (event) {
        var id = $(this).attr('data-id');
        var template = $("#template").val();
        if(validateForm()) {
            $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL ?>outlet/check_template",
                data: {'id': id, 'template': template},
                async: false,
                success: function (data) {
                if(data.response){
                swal({
                    title: "Some files with the same name already exists in the theme diractory?",
                    text: "You will not be able to recover these files!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, replace it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: true,
                    closeOnCancel: true 
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $("#confirm_replace").val('yes');
                        } else{
                            $("#confirm_replace").val('no');
                        }
                        $('#form_sample_1').submit();
                    });
                } else {
                     $("#confirm_replace").val('other');
                     $('#form_sample_1').submit();
                }
            }});
        }
    });
});
<?php if($update_id > 0) {
if(isset($outlet['country']) && !empty($outlet['country']) && isset($outlet['city']) && !empty($outlet['city'])) { ?>
get_city_record("<?=$outlet['country']?>","<?=$outlet['city']?>",'',"1");
<?php } } ?>
function validateForm() {
  var isValid = true;
  $('.validatefield').each(function() {
    if ( $(this).val() === '') {
       $(this).css("border", "1px solid red");
      isValid = false;
    }
    else 
        $(this).css("border", "1px solid #dde6e9");
  });

  if($('.dietaries').val() ) {
    $('.dietaries').parent().find('.select2-selection ').attr('style','border:none;');
  }
  else {
    $('.dietaries').parent().find('.select2-selection ').attr('style','border:1px solid red');
    isValid = false;
  }
  if($('.restaurant_type').val() ) {
    $('.restaurant_type').parent().find('.chosen-container-multi').attr('style','border:none;border-radius:none;');
  }
  else {
    $('.restaurant_type').parent().find('.chosen-container-multi').attr('style','border:1px solid red;border-radius:6px;');
    isValid = false;
  }
  if($('.country_id').find(":selected").val() != '' && $('.country_id').find(":selected").val() != '0') {
    $('.country_id').attr('style','border:1px solid #dde6e9;');
  }
  else {
    $('.country_id').attr('style','border:1px solid red !important;');
    isValid = false;
  }
  if($('.city_select').find(":selected").val() != '' && $('.city_select').find(":selected").val() != '0') {
    $('.city_select').attr('style','border:1px solid #dde6e9;');
  }
  else {
    $('.city_select').attr('style','border:1px solid red !important;');
    isValid = false;
  }

  return isValid;
}
    $(document).off('click', '#product_save').on('click', '#product_save', function(e){
         e.preventDefault();
              var link =$("#seo_link").val();
              var id =$("#seo_link_id").val();
              alert(id);

              var valid="false";
             $.ajax({
                type: 'POST',
                url: "<?=ADMIN_BASE_URL ?>seo/check_unique_url",
                data: { 'link': link,'id':id},
            
                success: function(result) {
                    if (result==0) {
                         $('#form_sample_1').submit();
                    }
                    else{

                        alert("URL not unique");
                        
                    }
                }
            });
           
           
        });
</script>
