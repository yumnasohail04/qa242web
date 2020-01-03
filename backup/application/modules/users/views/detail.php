<style type="text/css">
    th
    {
        color: #6C9CDE;

    }
</style>
<div class="page-content-wrapper">
<?php // print_r($news['title']);exit; ?>
 <div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">

               
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                    <div class="form-body">  
        <!-- END PAGE HEADER-->
       <table id="datatable1" class="table table-bordered">
            <tbody class="table-body">
                <tr class="bg-col">
                    <th>
                        User Name:
                    </th>
                    <td>
                        <?php echo $users_res['user_name']; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        Full Name:
                    </th>
                    <td>
                        <?php echo $users_res['first_name']." ".$users_res['last_name']; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        Email:
                    </th>
                    <td>
                        <?php echo $users_res['email']; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        Cell Phone:
                    </th>
                    <td>
                        <?php echo $users_res['phone']; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        Office Phone:
                    </th>
                    <td>
                        <?php echo $users_res['office_phone']; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        Primary Group:
                    </th>
                    <td>
                        <?php if(isset($groups) && !empty($groups)) {
                        foreach ($groups as $key => $value):
                            if($key == $users_res['group'])
                                echo $value;;
                        endforeach;
                       } else echo "Not Selected"; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        Secondary Group:
                    </th>
                    <td>
                        <?php if(isset($groups) && !empty($groups)) {
                            foreach ($groups as $key => $value):
                                if($key == $users_res['second_group'])
                                    echo $value;;
                            endforeach;
                        } else echo "Not Selected"; ?>
                    </td>
                </tr>
                <tr class="bg-col">
                    <th>
                        User Picture:
                    </th>
                    <td>
                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                            <?php  $image="";
                            if(isset($users_res['user_image']) && !empty($users_res['user_image']))
                                $image = ACTUAL_OUTLET_USER_IMAGE_PATH.$users_res['user_image'];
                            $filename =  $image;
                            if (file_exists($filename)) { ?>
                                <img style="width: 200px; height: 145px;" src = "<?php echo BASE_URL . $image; ?>" />
                            <?php
                            } else { ?>
                                <img style="width: 200px; height: 145px;" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                            <?php } ?>
                        </div> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
</div>
