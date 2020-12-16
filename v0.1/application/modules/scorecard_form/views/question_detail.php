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
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <div class="form-body">  
                        <!-- END PAGE HEADER-->
                        <table id="datatable1" class="table table-bordered">
                            <tbody class="table-body">
                                <tr class="bg-col">
                                    <th>
                                        Question:
                                    </th>
                                    <td>
                                        <?php if(isset($questions['question']) && !empty($questions['question'])) echo $questions['question']; ?>
                                    </td>
                                </tr>
                                <tr class="bg-col">
                                    <th>
                                        Description:
                                    </th>
                                    <td>
                                        <?php if(isset($questions['description']) && !empty($questions['description'])) echo $questions['description']; ?>
                                    </td>
                                </tr>
                                <tr class="bg-col">
                                    <th>
                                        Page Rank:
                                    </th>
                                    <td>
                                        <?php if(isset($questions['page_rank']) && !empty($questions['page_rank'])) echo $questions['page_rank']; ?>
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
