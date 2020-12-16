<style type="text/css">
    .red_class {
        border: 1px solid red !important;
    }
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    {
        width:100%;
    }
    .btn-group.open .dropdown-toggle {
        background-color: transparent;
    }
    fieldset .form-group {
    margin-bottom: 15px;
}
.section-box {
    box-shadow: none;
}
*, *:before, *:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
.new {
  padding: 50px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.form-group label {
  position: relative;
  cursor: pointer;
      border-radius: 30px;
}

.form-group label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
  width: 50px;
  height: 50px; 
  border-radius: 30px;
}

.form-group input:checked + label:after {
    content: '';
    display: block;
    position: absolute;
    top: 14px;
    left: 23px;
    width: 12px;
    height: 24px;
    border: 23px solid #ffffff;
    border-width: 0 4px 4px 0;
    transform: rotate(45deg);
}
</style>
<div class="page-content-wrapper">
<?php // print_r($post['title']);exit; ?>
        <!-- END PAGE HEADER-->
       
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">

                       
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        
                       <legend> ScoreCard Detail</legend>  
                        <!-- END FORM-->
                        <div class="row ">
                            <div class="form-body">
                                     <table id="datatable1" class="table table-bordered">
                                         <thead class="bg-th">
                                            <tr class="bg-col">
                                              <th >Assigned to Team</th>
                                              <th >Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body">
                                        <?php foreach($team_data as $key => $value){ ?>
                                          <tr class="bg-col">
                                              <td><?php echo $value['group_title']; ?></td>
                                              <td><?php if($value['fill_status']=="0") echo "Pending"; else echo "Completed"; ?></td>
                                          </tr>
                                          <?php } ?>
                                          <?php foreach($approv_team as $key => $value){ ?>
                                          <tr class="bg-col">
                                              <td><?php echo $value['group_title']; ?></td>
                                              <td><?php if($value['status']!="Complete") echo "Pending"; else echo "Completed"; ?></td>
                                          </tr>
                                          <?php } ?>
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!--    </div>-->
</div>
</div>


