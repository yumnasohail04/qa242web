<!-- Page content-->
<div class="content-wrapper">
    <h3>Attributes of  <?php echo $parent_name; ?>
        <a href= "<?php echo ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name; ?>"/>
            <button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New Attribute</button>
        </a>
        <a href= "<?php echo ADMIN_BASE_URL . 'static_form';?>"/>
            <button type="button" class="btn btn-primary pull-right" style="margin-right: 9px;"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button>
        </a>
    </h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Choice Attributes</h4>
                        <table id="datatable1" class="table table-striped table-hover ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px">Possible Answer</th>
                                <th width="400px">Selection</th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $choice_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'choice'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question,sfq_selection_type,sfq_question_selection','1','0','','','')->result_array();
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
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $cd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        <h4>Range Attributes</h4>
                        <table id="datatable" class="table table-striped table-hover ">
                            <thead class="bg-th">
                            <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px">Type</th>
                                <th width="400px">Min</th>
                                <th width="400px">Max</th>
                                <th width="400px">Target</th>
                                <th class="" style="width:320px">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $range_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'range'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question','1','0','','','')->result_array();
                                    if (isset($range_data) && !empty($range_data)) {
                                        foreach ($range_data as $rd):
                                            $data_values = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array('sfa_delete'=>'0','sfa_question_id'=>$rd['sfq_id']), 'sfa_id desc', 'sfa_id',DEFAULT_OUTLET.'_static_form_answer','sfa_id,sfa_min,sfa_max,sfa_target,sfa_answer_acceptance','1','0','','','')->result_array();
                                            if(!empty($data_values)) {
                                                foreach ($data_values as $key => $dv):
                                                $i++; 
                                                $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/range/'.$rd['sfq_id'].'/'.$dv['sfa_id'];
                                                ?>
                                                <tr class="odd gradeX" >
                                                  <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                                    <td><?php echo ucfirst($rd['sfq_question']); ?></td>
                                                    <td><?php echo ucfirst($dv['sfa_answer_acceptance']); ?></td>
                                                    <td><?php echo $dv['sfa_min']; ?></td>
                                                    <td><?php echo $dv['sfa_max']; ?></td>
                                                    <td><?php echo $dv['sfa_target']; ?></td>
                                                    <td class="table_action">
                                                          <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $rd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach;
                                            } 
                                        endforeach;
                                    } ?>
                                </tbody>
                        </table>
                        <h4>Text Attributes</h4>
                        <table id="datatable1" class="table table-striped table-hover ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $text_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'text'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question','1','0','','','')->result_array();
                                if (isset($text_data) && !empty($text_data)) {
                                    foreach ($text_data as $td):
                                        $i++;
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/text/'.$td['sfq_id'];
                                                ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($td['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $td['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        <h4>DateTime Attributes</h4>
                        <table id="datatable1" class="table table-striped table-hover ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $datetime_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'datetime'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question','1','0','','','')->result_array();
                                if (isset($datetime_data) && !empty($datetime_data)) {
                                    foreach ($datetime_data as $dtd):
                                        $i++; 
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/datetime/'.$dtd['sfq_id'];
                                            ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($dtd['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $dtd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        <h4>Date Attributes</h4>
                        <table id="datatable1" class="table table-striped table-hover ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $date_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'date'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question','1','0','','','')->result_array();
                                if (isset($date_data) && !empty($date_data)) {
                                    foreach ($date_data as $dd):
                                        $i++; 
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/date/'.$dd['sfq_id'];
                                        
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($dd['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $dd['sfq_id'],'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                } ?>
                            </tbody>
                        </table>
                        <h4>Time Attributes</h4>
                        <table id="datatable1" class="table table-striped table-hover ">
                            <thead class="bg-th">
                                <tr class="bg-col">
                                <th  style="display:none;width:2%">S.No</th>
                                <th width="400px">Attribute`s Name</th>
                                <th width="400px"></th>
                                <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php $i=0;
                                $time_data = Modules::run('api/_get_specific_table_with_pagination_where_groupby',array("sfq_check_id" =>$ParentId,'sfq_delete'=>'0','LOWER(sfq_question_type)'=>'time'), 'sfq_id desc', 'sfq_id',DEFAULT_OUTLET.'_static_form_question','sfq_id,sfq_question','1','0','','','')->result_array();
                                if (isset($time_data) && !empty($time_data)) {
                                    foreach ($time_data as $td):
                                        $i++;
                                        $edit_url=ADMIN_BASE_URL . 'static_form/create_attributes/' . $ParentId.'/'.$parent_name.'/time/'.$td['sfq_id'];
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo ucfirst($td['sfq_question']); ?></td>
                                            <td>User will provide a text input</td>
                                            <td class="table_action">
                                                  <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $td['sfq_id'],'title' => 'Delete Attribute'));
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
    <!-- END DATATABLE 1 -->
    </div>
</div>    
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