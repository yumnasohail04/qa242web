<?php 
function selectbox($id,$selected,$rank,$selected_rank) {
    $text = '<select name="page_rank" class="form-control chosen-select" id="rank" attr_id="'.$id.'">';
        if(!empty($rank)) {
            foreach ($rank as $ranking => $ra):
                if(!empty($ra) && ($selected == $ra || !is_numeric(array_search($ra, array_column($selected_rank, 'page_rank'))))) { 
                    $select_text = '';
                    if($selected == $ra) $select_text = 'selected="selected"';
                    $text .='<option value="'.$ra.'" '.$select_text.'>'.$ra.'</option>';
                } 
            endforeach;
        }
    $text .='</select>';
    return $text;
}
?>                 
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Users</h1>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name; ?>">&nbsp;Add New Attribute&nbsp;</a>
                    <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'static_form';?>">&nbsp;Back&nbsp;</a>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                        <h4>Choice Attributes</h4>

                        <table id="datatable1" class="data-table data-table-feature">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px">Possible Answer</th>
                                <th width="400px">Selection</th>
                                 <th width="400px">Order</th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $choice_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'choice'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,page_rank,sfq_question,sfq_selection_type,sfq_question_selection','1','0','','','')->result_array();
                                if (isset($choice_data) && !empty($choice_data)) {
                                    foreach ($choice_data as $cd):
                                        $i++;
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/choice/'.$cd['sfq_id'];
                                      
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php if(isset($cd['sfq_question']) && !empty($cd['sfq_question'])) echo ucfirst($cd['sfq_question']); ?></td>
                                            <td><?php if(isset($cd['sfq_selection_type']) && !empty($cd['sfq_selection_type'])) echo ucfirst($cd['sfq_selection_type']); ?></td>
                                            <td><?php if(isset($cd['sfq_question_selection']) && !empty($cd['sfq_question_selection']))  echo ucfirst(str_replace("_"," ",$cd['sfq_question_selection'])); ?></td>
                                            <td>
                                                <?php echo selectbox($cd['sfq_id'],$cd['page_rank'],$rank,$selected_rank); ?>
                                            </td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $cd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Range Attributes</h4>
                        <table id="datatable" class="data-table data-table-feature ">
                            <thead class="bg-th">
                            <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px">Ref. Min</th>
                                <th width="400px">Ref. Max</th>
                                <th width="400px">Ref. Target</th>
                                <th width="400px">Frozen Min</th>
                                <th width="400px">Frozen Max</th>
                                <th width="400px">Frozen Target</th>
                                  <th width="400px">Order</th>
                                <th class="" style="width:320px">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $range_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'range'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,page_rank,sfq_question','1','0','','','')->result_array();
                                    if (isset($range_data) && !empty($range_data)) {
                                        $i=0;
                                        foreach ($range_data as $rd): $i++; ?>
                                            <tr class="odd gradeX" >
                                                <td class="table-checkbox" style="display:none;">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td>
                                                    <?php echo ucfirst($rd['sfq_question']); ?>
                                                </td>
                                                <?php  $ref_value = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfa_delete'=>'0','sfa_question_id'=>$rd['sfq_id'],'lower(sfa_answer_acceptance)'=>'refrigerated'), 'sfa_id desc', 'sfa_id',DEFAULT_OUTLET.'_static_form_answer','sfa_id,sfa_min,sfa_max,sfa_target,sfa_answer_acceptance','1','1','','','')->row_array();
                                                ?>
                                                <td>
                                                    <?php $text = '-';
                                                    if(isset($ref_value['sfa_min']) && !empty($ref_value['sfa_min']))
                                                        $text = $ref_value['sfa_min'];
                                                        echo $text;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php $text = '-';
                                                    if(isset($ref_value['sfa_max']) && !empty($ref_value['sfa_max']))
                                                        $text = $ref_value['sfa_max'];
                                                        echo $text;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php $text = '-';
                                                    if(isset($ref_value['sfa_target']) && !empty($ref_value['sfa_target']))
                                                        $text = $ref_value['sfa_target'];
                                                        echo $text;
                                                    ?>
                                                </td>
                                                <?php  $ref_value = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfa_delete'=>'0','sfa_question_id'=>$rd['sfq_id'],'lower(sfa_answer_acceptance)'=>'frozen'), 'sfa_id desc', 'sfa_id',DEFAULT_OUTLET.'_static_form_answer','sfa_id,sfa_min,sfa_max,sfa_target,sfa_answer_acceptance','1','1','','','')->row_array();
                                                ?>
                                                <td>
                                                    <?php $text = '-';
                                                    if(isset($ref_value['sfa_min']) && !empty($ref_value['sfa_min']))
                                                        $text = $ref_value['sfa_min'];
                                                        echo $text;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php $text = '-';
                                                    if(isset($ref_value['sfa_max']) && !empty($ref_value['sfa_max']))
                                                        $text = $ref_value['sfa_max'];
                                                        echo $text;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php $text = '-';
                                                    if(isset($ref_value['sfa_target']) && !empty($ref_value['sfa_target']))
                                                        $text = $ref_value['sfa_target'];
                                                        echo $text;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo selectbox($rd['sfq_id'],$rd['page_rank'],$rank,$selected_rank); ?>
                                                </td>
                                                <td class="table_action">
                                                    <?php
                                                    $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/range/'.$rd['sfq_id'];
                                                    echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                    echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $rd['sfq_id'],'title' => 'Delete Attribute'));
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                        } ?>
                                </tbody>
                        </table>
                        </div>
                </div>
                </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Text Attributes</h4>
                        <table id="datatable1" class="data-table data-table-feature ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                  <th width="400px">Order</th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $text_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'text'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,page_rank,sfq_question','1','0','','','')->result_array();
                                if (isset($text_data) && !empty($text_data)) {
                                    foreach ($text_data as $td):
                                        $i++;
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/text/'.$td['sfq_id'];
                                                ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($td['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td> 
                                                <?php echo selectbox($td['sfq_id'],$td['page_rank'],$rank,$selected_rank); ?>
                                            </td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $td['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        </div>
                </div>
                </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4>DateTime Attributes</h4>
                        <table id="datatable1" class="data-table data-table-feature ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                 <th width="400px">Order</th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $datetime_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'datetime'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,page_rank,sfq_question','1','0','','','')->result_array();
                                if (isset($datetime_data) && !empty($datetime_data)) {
                                    foreach ($datetime_data as $dtd):
                                        $i++; 
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/datetime/'.$dtd['sfq_id'];
                                            ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($dtd['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td> 
                                                <?php echo selectbox($dtd['sfq_id'],$dtd['page_rank'],$rank,$selected_rank); ?>
                                            </td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $dtd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        </div>
                </div>
                </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Date Attributes</h4>
                        <table id="datatable1" class="data-table data-table-feature ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                 <th width="400px">Order</th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $date_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'date'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,page_rank,sfq_question','1','0','','','')->result_array();
                                if (isset($date_data) && !empty($date_data)) {
                                    foreach ($date_data as $dd):
                                        $i++; 
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/date/'.$dd['sfq_id'];
                                        
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($dd['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td> 
                                                <?php echo selectbox($dd['sfq_id'],$dd['page_rank'],$rank,$selected_rank); ?>
                                            </td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $dd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        </div>
                </div>
                </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Time Attributes</h4>
                        <table id="datatable1" class="data-table data-table-feature ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                <th width="400px">Order</th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $time_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'time'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,page_rank,sfq_question','1','0','','','')->result_array();
                                if (isset($time_data) && !empty($time_data)) {
                                    foreach ($time_data as $td):
                                        $i++;
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/time/'.$td['sfq_id'];
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($td['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td>
                                                <?php echo selectbox($td['sfq_id'],$td['page_rank'],$rank,$selected_rank); ?> 
                                            </td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="iconsminds-file-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="simple-icon-close"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $td['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>   
<script type="application/javascript">

$(document).ready(function(){


          $(document).off('click', '.delete_records').on('click', '.delete_records', function(e){
                var id = $(this).attr('rel');
                 var pid = $(this).attr('rel2');
                 
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected attribute?",
                text : "You will not be able to recover this attribute!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {

                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>static_form/delete_sub_catagories_attributes",
                            data: {'id': id , 'pid': pid },
                            async: false,
                            success: function(typee) {
                               /*$( "#datatable1" ).load( "<? ADMIN_BASE_URL ?>catagories/load_listing" );*/
                               location.reload();
                            }
                        });
               swal("Deleted!", "Attribute has been deleted.", "success");
              });

            });

   

});

</script>
<script>
$('.chosen-select').on('change', function() {
    var attr_id=$(this).attr('attr_id');
    var select_val=$(this).val();
    if(attr_id >0 && select_val >0){
        $.ajax({
            type: 'POST',
            url: "<?=ADMIN_BASE_URL?>static_form/update_specific_attribute",
            data: {'page_rank': select_val,'attr_id':attr_id},
            async: false,
            success: function(test_body) {
                location.reload();
            }
        });
    }
});
</script>