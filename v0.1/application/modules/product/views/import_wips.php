<style>
    .files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
</style>

                <main>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-12">
                        <h1>  <?php 
                        if (empty($update_id)) 
                                    $strTitle = 'Import File';
                                
                                    echo $strTitle;
                                    ?></h1>
                        <a class="btn btn-sm btn-outline-primary ml-3 d-none d-md-inline-block btn-right" href="<?php echo ADMIN_BASE_URL . 'product'; ?>">&nbsp;&nbsp;&nbsp;Back</a> 
                        <div class="separator mb-5"></div>
                      </div>
                    </div>
                <div class="card mb-4">
                  <div class="card-body">
                    <h5 class="mb-4">
                    
                      </h5>
                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit_wips_csv/' .$product_id.'/'.  $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'product/submit_wips_csv/' .$product_id.'/'. $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
                    <!-- <h3 class="form-section">Post Information</h3>-->
                 

                     <div class="row">
                         <div class="col-md-12">
                                <div class="form-group files color">
                    <label class="text-center"><h3>Upload Your File </h3></label>
                <input type="file" class="form-control" name="csvfile" >
              </div>
                         </div>
                     </div>

                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'product'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>
                
                <?php echo form_close(); ?> 
                
                
              </div>
            </div>
          </div>
        </main>


