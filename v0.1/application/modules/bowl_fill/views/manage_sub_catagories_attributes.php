<!-- Page content-->
<div class="content-wrapper">
    <h3>Bowl Filling Attributes
    <a href= "<?php echo ADMIN_BASE_URL . 'bowl_fill/create/'?>"/>
    <button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button>
    </a>
    
    <a href= "<?php echo ADMIN_BASE_URL . 'wip_profile/'?>"/>
    <button type="button" class="btn btn-primary right"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;Go To Wip Profile</button>
    </a>
    
 
    
   </h3>


    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <h2>Choice Attributes</h2>
                    <table id="datatable1" class="table table-striped table-hover ">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th  style="display:none;width:2%">S.No</th>
                        <th width="400px">Attribute`s Name</th>
                        <th width="400px">Choice Type</th>


                        

                        <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                         <tbody class="courser table-body">
                                <?php
                                $i=0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        if($row->attribute_type=="Choice"){
                                        $i++;
                                     
                                        $edit_url = ADMIN_BASE_URL . 'bowl_fill/create/'. $row->wip_id;
                                        
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo $row->attribute_name; ?></td>
                                            <td><?php echo $row->possible_answers; ?></td>
                                            
                                           
                                           
                                            <td class="table_action">
                                           

                                                 <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row->wip_id,'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }}
                                    ?>    
                                <?php } ?>
                            </tbody>
                    </table>
                    <h2>Fixed Attributes</h2>
                    <table id="datatable2" class="table table-striped table-hover ">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th  style="display:none;width:2%">S.No</th>
                        <th width="400px">Attribute`s Name</th>
                        <th width="400px"></th>

                        

                        <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                         <tbody class="courser table-body">
                                <?php
                                $i=0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                     if($row->attribute_type=="Fixed"){
                                        $edit_url = ADMIN_BASE_URL . 'bowl_fill/create/'. $row->wip_id;
                                        
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo $row->attribute_name; ?></td>
                                            <td>User will provide a text input</td>
                                           
                                           
                                            <td class="table_action">
                                           

                                                 <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row->wip_id,'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }}
                                    ?>    
                                <?php } ?>
                            </tbody>
                    </table>
                     <h2>Range Attributes</h2>
                    <table id="datatable" class="table table-striped table-hover ">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th  style="display:none;width:2%">S.No</th>
                        <th width="400px">Attribute`s Name</th>
                        <th width="400px">Min</th>
                        <th width="400px">Max</th>
                        <th width="400px">Target</th>


                        

                        <th class="" style="width:320px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                         <tbody class="courser table-body">
                                <?php
                                $i=0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                      if($row->attribute_type=="Range"){
                                        $edit_url = ADMIN_BASE_URL . 'bowl_fill/create/'. $row->wip_id;
                                        
                                        ?>
                                        <tr class="odd gradeX" >
                                          <td class="table-checkbox" style="display:none;"><?php echo $i; ?></td>
                                            <td><?php echo $row->attribute_name; ?></td>
                                            <td><?php if($row->attribute_type=="Range")  echo $row->min; ?></td>
                                            <td><?php if($row->attribute_type=="Range")  echo $row->max; ?></td>
                                            <td><?php if($row->attribute_type=="Range") echo $row->target; ?></td>
                                           
                                            <td class="table_action">
                                           

                                                 <?php
                                                
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => ' btn blue c-btn','title' => 'Edit Sub Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_records btn red c-btn', 'rel' => $row->wip_id,'title' => 'Delete Attribute'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }}
                                    ?>    
                                <?php } ?>
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


    /*//////////////////////// code for detail //////////////////////////*/
            $(document).off("click",".action_edit").on("click", ".view_sub_details", function(event){
                
            event.preventDefault();
            var id = $(this).attr('rel');
           
           // alert(id+pid); return false;
              $.ajax({
                        type: 'POST',
                       
                        url: "<?php echo ADMIN_BASE_URL?>bowl_fill/sub_details",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        $('#myModal').modal('show')
                        $("#myModal .modal-body").html(test_desc);
                        }
                    });
            });


    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_records').on('click', '.delete_records', function(e){
                var id = $(this).attr('rel');
                 
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
                            url: "<?php echo ADMIN_BASE_URL?>bowl_fill/delete_sub_catagories_attributes",
                            data: {'id': id , },
                            async: false,
                            success: function(typee) {
                               /*$( "#datatable1" ).load( "<? ADMIN_BASE_URL ?>bowl_fill/load_listing" );*/
                               location.reload();
                            }
                        });
               swal("Deleted!", "Attribute has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>bowl_fill/change_status_sub_category",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-long-arrow-down').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-long-arrow-up').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
                    }
                    $("#listing").load('<?php echo ADMIN_BASE_URL?>bowl_fill/manage');
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 1) {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set Publish');
                $(this).attr('status', '0');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set Un-Publish');
                $(this).attr('status', '1');
            }
           
        });
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/

});

</script>