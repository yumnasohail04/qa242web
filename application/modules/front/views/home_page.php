<?php
$supplier=$this->session->userdata('supplier');
if(!isset($supplier) && empty($supplier))
redirect(BASE_URL.'login/'.$this->session->userdata['supplier']['supplier_id']);

?>
<style>
.panel-info
{
        border-color: #a7a7a7;
    box-shadow: 0 0 32px rgb(160, 160, 160);
}
.panel-title {
    font-size: 20px;
    text-align: center;
}
    .user-row {
    margin-bottom: 14px;
}
.panel-info>.panel-heading {
    color: #ffffff;
    background-color: #7BABED;
    border-color: #7BABED;
}

.user-row:last-child {
    margin-bottom: 0;
}

.dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
}

.dropdown-user:hover {
    cursor: pointer;
}

.table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
    border-top: 0;
}


.table-user-information > tbody > tr > td {
    border-top: 0;
}
.toppad
{margin-top:20px;
}
.panel-footer {
    padding: 10px 15px;
    background-color: #7babed;
    height: 52px;
}

</style>
<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
        
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
  
          <div >
             <form action="<?php echo BASE_URL.'front/submit_doc' ?>" method="post" class="panel panel-info" enctype="multipart/form-data">
            <div class="panel-heading">
                 <?php foreach($detail as $key => $value){ ?>
              <h3 class="panel-title"><?php echo $value['name']; ?></h3>
                          <?php 
                          } ?>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-12 col-lg-12 "> 
                  <table class="table table-user-information">
                    <tbody>
                         <?php foreach($detail as $key => $value){ ?>
                      <tr>
                        <td>Email:</td>
                        <td><?php echo $value['email']; ?></td>
                      </tr>
                      <tr>
                        <td>Phone no# :</td>
                        <td><?php echo $value['phone_no']; ?></td>
                      </tr>
                      <tr>
                        <td>City</td>
                        <td><?php echo $value['city']; ?></td>
                      </tr>
                      <tr>
                        <td>State</td>
                        <td><?php echo $value['state']; ?></td>
                      </tr>
                        <tr>
                        <td>Country</td>
                        <td><?php echo $value['country']; ?></td>
                      </tr>
                      <input type="hidden" value="<?php echo $value['id']; ?>" name="id" >
                          <?php 
                          } ?>
                          <?php foreach($doc as $keys => $values){ ?>
                        <tr>
                        <td><?php echo $values['doc_name']; ?></td>
                        <td><input type="file" name="news_main_page_file_<?php echo $keys; ?>" id="news_d_file" ></td>
                      </tr>
                          <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
             <div class="panel-footer">
                <span class="pull-right">
                    <button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-ok"></i></button>
                </span>
             </div>
            </form>
          </div>
        </div>
      </div>
    </div>