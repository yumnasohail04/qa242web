<div class="page-content-wrapper">
  <div class="page-content">
    <div class="row">
      <div class="col-md-12">
        <div class="content-wrapper">
          <h3>
            <?php echo $outlet_name; ?> - Timing
            <a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
          </h3>
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

                    <div class="portlet-body" style="margin-bottom: 20px" id="timing">
                      <div class="form-body form-inline">

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

  $('.date').datetimepicker({
      format: 'HH:mm'
  });
});

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
</script>
