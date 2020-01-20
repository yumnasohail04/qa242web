<script type="text/javascript">
    $('#sample_2').dataTable(
                {
                    "aLengthMenu": [[5, 10, 25, 50, 100, 200, -1], [5, 10, 25, 50, 100, 200, "All"]],
                    "iDisplayLength": 10,
                    "aoColumns": [
						null,
						null,
						null,
                    ],
                }
        );
    $(document).on('click' ,'.unit_measure', function(){
		var id = $(this).attr('id');
		var field_id = $("#sample_2").attr('lang');
		var title = $(this).find('.title').text();
		$("#hdnUnitMeasurId_"+field_id).val(id);
		$("#txtUnitMeasur_"+field_id).val(title);

		jQuery.fancybox.close();
    })
   
</script>

<div class="page-content-wrapper">
   
       
        <!-- /.modal -->
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE HEADER-->
       
        
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box light-grey">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>Unit of Measure
                        </div>
                        <div class="tools">

                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_2" lang="<?=$id;?>">

                            <thead>
                                <tr>
		                            <th width="2%">Sr. No.</th>
                                    <th>Title</th>
                                    <th>Qty Per Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								$i=0;
                                if (isset($unit_measure)) {foreach ($unit_measure->result() as $row) {
									$i++;
										?>
                                        <tr id="<?=$row->id ?>" class="unit_measure" style="cursor:pointer;">
		                                    <td class="code"><?php echo $i;?></td>
                                            <td class="title"><?php echo $row->code ?></td>
                                            <td class="value"><?php echo $row->qty_per_unit?></td>
                                        </tr> 
									<?php 
									}
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    
</div>
