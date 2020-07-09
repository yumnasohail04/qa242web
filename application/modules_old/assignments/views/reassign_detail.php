  <div>
    <datamain>
          <?php if($type !='onlyuser') { ?>
          <trr>
            <tdd>Responsible</tdd>
            <tdd class="selecting_div">
              <select  class="validate_form form-control check_type" name="responsible_type" required="required">
                <option  value="">Select</option>
                <option  value="group" <?php if(isset($selected_type) && !empty($selected_type)) if($selected_type =='group') echo 'selected="selected"'; ?>>Group</option>
                <option  value="user" <?php if(isset($selected_type) && !empty($selected_type)) if($selected_type =='user') echo 'selected="selected"'; ?>>User</option>
              </select>
            </tdd>
          </trr>
          <trr>
            <tdd>Responsible Team</tdd>
            <tdd class="main_div">
              <select  class="form-control responsible_team validate_form" name="responsible_team" required="required">
                <option  value="">Select</option>
                <?php
                if(!isset($groups) || empty($groups))
                   $groups = array();
                if(!isset($assign_group)) 
                  $assign_group = "";
                foreach ($groups as $value): ?>
                  <option value="<?=$value['id']?>" <?php if($value['id']== $assign_group) echo 'selected="selected"';?>><?= $value['group_title']?>
                  </option>
                <?php endforeach ?>
              </select>
            </tdd>
          </trr>
          <trr>
            <tdd>Responsible User</tdd>
            <tdd class="team_div">
              <select  class="validate_form form-control responsible_user" name="responsible_user" required="required">
                <option value="">Select</option>
                <?php
                foreach ($users as $value): ?>
                <option value="<?=$value['id']?>" 
                <?php if(isset($user_id) && $user_id==$value['id']) echo 'selected="selected"'?>><?= $value['first_name'].' '.$value['last_name']?></option>
                <?php endforeach ?>
              </select>
            </tdd>
          </trr>
        <?php } if($type =='onlyuser') {?>
        <trr>
            <tdd>Responsible User</tdd>
            <tdd class="team_div">
              <select  class="validate_form form-control responsible_user" name="responsible_user" required="required">
                <option value="">Select</option>
                <?php
                foreach ($users as $value): ?>
                <option value="<?=$value['id']?>" 
                <?php if(isset($user_id) && $user_id==$value['id']) echo 'selected="selected"'?>><?= $value['first_name'].' '.$value['last_name']?></option>
                <?php endforeach ?>
              </select>
            </tdd>
          </trr>
        <?php } ?>
    </datamain>
  </div>