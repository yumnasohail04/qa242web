<?php foreach($doc as $key => $value){  ?>
<div class="row" style="width: 100%;">
        <div class="col-md-1 tick">
            <div class="addtick <?php if(!empty($value['document'])) echo "gif"; ?>">
            </div>
        </div>
            <label class="control-label col-md-3"><?php echo $value['doc_name']; ?></label>
            <div class="col-md-4">
                <input type="file" data-doc-name="<?php echo $value['doc_name']; ?>" name="news_main_page_file_<?php echo $key; ?>" id="news_d_file" expiry_date() >
            </div>
<!--             <div class="col-md-4">
                <div class="form-group">
                <label class="control-label col-md-3">Expiry Date</label>
                    <div class='input-group datetimepicker2'>
                    <input type='text' class="form-control" name="expiry_date_<?php echo $key; ?>"  value="<?php echo $value['expiry_date']; ?>"/>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
                </div>
            </div> -->



							<div class="col-md-4">
                                <div class="form-group  mb-1 row">
                                <div class="col-md-4">
                                    <label>Expiry Date</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group date">
                                            <input type="text" class="form-control" id="enddate" name="expiry_date_<?php echo $key; ?>"  value="<?php echo $value['expiry_date']; ?>">
                                            <span class="input-group-text input-group-append input-group-addon">
                                                <i class="simple-icon-calendar"></i>
                                            </span>
                                        </div>
                                	</div>
                                </div>
                            </div>
</div>
<?php } ?>