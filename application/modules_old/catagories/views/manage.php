<?php
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
<!-- Page content-->
<div class="content-wrapper">
    <h3>Categories<a href="catagories/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                     <table class="table table-striped table-bordered table-hover" id="datatable1">
                            <thead class="bg-th">
                                <tr>
                                    <th class="table-checkbox" style="display:none;">S.No</th>
                                    <th style="width:550px;!important">Catagory</th>
                                    <th style="width:550px ;!important">Sub catagories</th>
                                    <th class="" style="width:600px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>                              
                                </tr>
                            </thead>
                            <tbody class="courser table-body">
                                <?php
                                $i = 0;
                                if (isset($query)) {
                                    foreach ($query->result() as
                                            $row) {
                                        $i++;
                                        $manage_sub_page_url = ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $row->id ."/". $row->cat_name;
                                        $set_default_url = ADMIN_BASE_URL . 'catagories/set_default/' . $row->id;

                                        $set_home_url = ADMIN_BASE_URL . 'catagories/set_home_category/' . $row->id;
                                        $set_not_home_url = ADMIN_BASE_URL . 'catagories/set_not_home_category/' . $row->id;

                                        $set_publish_url = ADMIN_BASE_URL . 'catagories/active/' . $row->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'catagories/in_active/' . $row->id;

                                        $edit_url = ADMIN_BASE_URL . 'catagories/create/' . $row->id;
                                        $add_url=ADMIN_BASE_URL . 'catagories/create_sub_catagories/' . $row->id.'/'.clean($row->cat_name);
                                        ?>
                                        <tr id="Row_<?= $row->id ?>" class="odd">
                                            <td class="table-checkbox"  style="display:none;"><?php echo $i; ?></td>
                                             <td>
                                                <?php echo $row->cat_name; ?>
                                            </td>
                                            <td>
                                            <select name="subcat" class="subcat form-control" style="width: 70%" >
                                            <option value="">--Choose--</option>
                                                <?php

                                                    $where['parent_id'] = $row->id;
                                                 $arr_sub=Modules::run('catagories/_get_sub_catagories',$where, 'id desc')->result_array(); 
                                                 foreach ($arr_sub as $key => $value) {
                                                    echo '<option value="'.$value['id'].'" dataurl="'.clean($value['cat_name']).'">'.$value['cat_name'].'</option>';
                                                 }

                                                 ?>
                                                 </select>
                                            </td>
                                             <td class="table_action">
                                                 <?php echo anchor($add_url, '<i class="fa fa-tags" style="color: #B7E031;"></i>', array('class' => ' btn blue c-btn','title' => 'Add sub Category'));?>
                                             <a class="btn yellow  c-btn view_attributes" rel="<?=$row->id?>"><i class="fa fa-sitemap"  title="Manage Attributes"></i></a>
                                            <a class="btn green c-btn editbtn" rel="<?=$row->id?>" dataurl="<?=clean($row->cat_name)?>"><i class="fa fa-edit"  title="Edit detail"></i></a>
                                            <a  class="btn blue c-btn delete_record" rel="<?=$row->id?>" dataurl="<?=clean($row->cat_name)?>"><i class="fa fa-times "  title="Delete category/sub category" style="color: #ffc735;"></i></a>
                                           
                                            

                                                <?php
                                             // echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Category'));
                                                if ($row->is_default != 1) {
                                                    $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fas fa-arrow-up"></i>';
                                        $iconbgclass = ' btn green greenbtn c-btn';
                                        if ($row->is_active != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fas fa-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                                    }
                                                    //echo anchor('javascript:;', $icon, array('class' => 'action_publish ' . $publish_class . $iconbgclass, 'title' => $publis_title, 'rel' => $row->id, 'id' => $row->id, 'status' => $row->is_active));
//                                                    echo anchor($set_default_url, '<img src="' . base_url() . 'static/admin/theme1/images/category_not_default.png" title="Set Default" />');
                                                    } else {
                                                           $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fas fa-arrow-up"></i>';
                                        $iconbgclass = ' btn green greenbtn c-btn';
                                        if ($row->is_active != 1) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fas fa-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                    }
                                                   
                                                       
                                                    }
                                                    
                                                
                                                /*echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Category'));
                                                echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row->id, 'title' => 'Delete Category'));*/

                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>    
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

<input type="hidden"  value="" id="selectsubcat"/>
<input type="hidden"  value="" id="selectsubcaturl"/>
<script type="text/javascript">

$(document).ready(function(){
$('.subcat').on('change', function() {
     $('#selectsubcaturl').val($('option:selected', this).attr('dataurl'));
  $('#selectsubcat').val( this.value);
});
    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_attributes", function(event){
            event.preventDefault();
            var id = $('#selectsubcat').val();
            var catname= $('#selectsubcaturl').val();
            if(id=='' || id==undefined ||id==null){
                 toastr.warning('You must select sub category');
                return false;
            }
            
            var url='<?=ADMIN_BASE_URL.'catagories/manage_attributes/'?>'+id+'/'+catname;
             window.location=url;
            });

            $(document).on("click", ".editbtn", function(event){
            event.preventDefault();
              var subcatid = $('#selectsubcat').val();
           
            var catid = $(this).attr('rel');
            var catname = $(this).attr('dataurl');
            //var catname=$('option:selected', '.subcat').attr('dataurl');
            if(subcatid=='' || subcatid==undefined ||subcatid==null){
              
               var url='<?=ADMIN_BASE_URL.'catagories/create/'?>'+catid+'/';
               window.location=url;
            }
            else{
              var url='<?=ADMIN_BASE_URL.'catagories/create_sub_catagories/'?>'+catid+'/'+subcatid;
               window.location=url;
            }
            
            });

    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                  var subcatid = $('#selectsubcat').val();
                var catid = $(this).attr('rel');
                var catname = $(this).attr('dataurl');
                e.preventDefault();
                 if(subcatid=='' || subcatid==undefined ||subcatid==null){
              
                swal({
                title : "Are you sure to delete the selected category?",
                text : "You will not be able to recover this category!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                        url: "<?=ADMIN_BASE_URL?>catagories/delete",
                            data: {'id': catid},
                            async: false,
                            success: function() {
                                location.reload();
                                //$("#datatable1").load("<?=ADMIN_BASE_URL?>catagories/load_listing");
                            }
                        });
                swal("Deleted!", "Category has been deleted.", "success");
              });
            }
            else{
               swal({
                title : "Are you sure to delete the selected sub category?",
                text : "You will not be able to recover this sub category!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                        url: "<?=ADMIN_BASE_URL?>catagories/delete_sub_catagories",
                            data: {'id': subcatid,'pid':catid},
                            async: false,
                            success: function() {
                                location.reload();
                                //$("#datatable1").load("<?=ADMIN_BASE_URL?>catagories/load_listing");
                            }
                        });
                swal("Deleted!", "Category has been deleted.", "success");
              });
            }
            

            });

    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>catagories/change_status_category",
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
                    $("#listing").load('<?php ADMIN_BASE_URL?>catagories/manage');
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
$(document).on("click", ".action_footer_page", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var ID = $(this).attr('id');
            var status = $(this).attr('status');
            $.ajax({
                type: 'POST',
                url: "<?=ADMIN_BASE_URL ?>catagories/change_footer_panel_pages",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if (result != false) {
                        if (status == '1') {
                           
                            $('#' + ID).removeClass('green').addClass('default');
                            $('#'+ID).find('i.fa-chain').removeClass('fa-chain').addClass('fa-chain-broken');
                            $('#' + ID).attr('status','0');
                        } else {
                           
                            $('#' + ID).removeClass('default').addClass('green');
                            $('#'+ID).find('i.fa-chain-broken').removeClass('fa-chain-broken').addClass('fa-chain');
                            $('#' + ID).attr('status','1');
                        }
                        toastr.success(' Successfully Done ');
                    } 
                    else
                    {
                        toastr.error('More than 5 pages cannot be showed for footer-panel.');
                    }

                }
            });

        });

$(document).ready(function() {
        $("#catagories_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });
</script>