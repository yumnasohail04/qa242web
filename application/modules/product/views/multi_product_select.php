    <div class="col-sm-5" style="clear: both !important;">
        <div class="form-group">
            <label class="col-sm-4 control-label">Select Finish Product<span class="required" style="color:#ff60a3">*</span></label>
            <div class="col-sm-8">
                <select  multiple="multiple" class="form-control product_select  chosen-select " name="product_select[]">
                    <?php
                        if(!isset($selected) || empty($selected))
                            $selected = array();
                        if(!isset($products) || empty($products))
                            $products = array();
                        foreach ($products as $pro): ?>
                            <?php $checking = array_search($pro['id'], array_column($selected, 'product_id'));
                            if(is_numeric($checking) || $pro['status'] == '1') {
                             ?>
                            <option <?php if(is_numeric($checking)) echo 'selected="selected"'; ?> value="<?=$pro['id']?>">
                                <?= $pro['product_title']?>
                            </option>
                        <?php }
                        endforeach ?>
                </select>
            </div>
        </div>
    </div>