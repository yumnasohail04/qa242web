<option value="" selected="selected">Select</option>
<?php foreach($query->result() as $row){?>
	<option value="<?php echo $row->id;?>"><?php echo $row->cat_name;?></option>
<?php ;} ?>
