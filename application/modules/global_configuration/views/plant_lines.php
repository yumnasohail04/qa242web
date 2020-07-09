  <option  value="">Select</option>
  <?php
  if(!isset($line))
    $line = '';
  if(!isset($get_lines) || empty($get_lines))
    $get_lines = array();
  foreach ($get_lines as $value): 
  if($value['line_status'] == '1' || $value['line_id'] ==  $line) { ?>
      <option value="<?=$value['line_id']?>" <?php if($line == $value['line_id']) echo 'selected="selected"';?>><?=$value['line_name']?>
      </option>
  <?php } endforeach; ?>