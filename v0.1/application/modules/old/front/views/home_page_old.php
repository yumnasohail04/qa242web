
<?php
$supplier=$this->session->userdata('supplier');
if(!isset($supplier) && empty($supplier))
redirect(BASE_URL.'login/'.$this->session->userdata['supplier']['supplier_id']);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.panel-info
{
        border-color: #a7a7a7;
    box-shadow: 0 0 32px rgb(160, 160, 160);
}
.panel-title {
    font-size: 30px; 
    text-align: center;
    text-transform: capitalize;
    padding: 10px;
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
h3 {
    background-color: #7babed;
    color: white;
    padding: 10px 10px 10px 26px;
    border-radius: 23px;
}
.multiselect-optgroup-item
{
  height:30px;
}
td img
{
  max-height: 36px;
}
.heading{
  font-size: 22px;
    font-weight: 600;
}
.gif {
    background: url(https://clipartix.com/wp-content/uploads/2018/09/green-clipart-2018-24.png);
    width: 30px;
    height: 34px;
    background-size: contain;
}
</style>
<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
        
      </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad" >
   
  
          <div >
             <form action="<?php echo BASE_URL.'front/submit_doc' ?>" method="post" class="panel panel-info" enctype="multipart/form-data">
            <div class="panel-heading">
                 <?php foreach($detail as $key => $value){ ?>
              <h2 class="panel-title"><?php echo $value['name']; ?></h2>
                          <?php 
                          } ?>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class=" col-md-12 col-lg-12 "> 
                  <table class="table table-user-information">
                    <tbody>
                    <tr><td><h3>Basic Information</h3></td></tr>
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
                            <tr><td><h3>Documents Section:</h3></td></tr>
                          <?php foreach($doc as $keys => $values){ ?>
                              <tr>
                              <td><?php echo $values['doc_name']; ?></td>
                              <td>
                                <input type="file" name="news_main_page_file_<?php echo $keys; ?>" id="news_d_file" data-doc-name="<?php echo $values['doc_name']; ?>" class="file_load">
                              </td>
                              <td>
                                <div class="form-group">
                                  <label class="control-label col-md-3">Expiry Date</label>
                                    <div class='input-group datetimepicker2'>
                                    <input type='text' class="form-control" name="expiry_date_<?php echo $keys; ?>" value="<?php echo $values['expiry_date']; ?>"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                  </div>
                                </div>
                              </td>
                              <td>
                              <?php if(!empty($values['document'])){ ?>
                                <a href="<?php echo BASE_URL.SUPPLIER_DOCUMENTS_PATH.$values['document'];?>" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a>
                              <?php }else{ ?>
                                <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>">
                                
                              <?php } ?>
                              </td>
                              </tr>
                          <?php } ?>
                          <tr><td><h3>Ingredients Section:</h3></td></tr>
                          <!-- <tr class="ing"><td>
                            <label>Ingredient Type</label>
                            <select id="example39" name="type[]" multiple="multiple" style="display: none;" class="form-control"  >
                              <optgroup label="Ingredient Types">
                                <?php foreach($ingdt_types as $key => $value){?>
                                  <?php foreach($type_selected as $tp => $ts){?>
                                    <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$ts['type_id']) echo "selected"; ?>><?php echo $value['name']; ?></option>  
                                <?php } } ?> 
                              </optgroup>
                            </select>
                          </td></tr> -->
                          

                           <?php
                           $ing_name="";
                           if(!empty($ingredients_doc)){?>
                              <?php foreach($ingredients_doc as $key => $value){
                                if($value['ing_name']!=$ing_name){?>
                                <tr><td class="heading">Ingredient(<?php echo $value['ing_name']; ?>)</td><td></td><td></td><tr>
                                <?php } ?>
                                  <tr>
                                  <td><?php echo $value['doc_name']; ?></td>
                                  <td>
                                    <input type="file" name="main_file_<?php echo $key; ?>" id="news_d_files" data-ing-id="<?php echo $value['ing_id']; ?>" data-doc-name="<?php echo $value['doc_name']; ?>" class="file_load">
                                    </td>
                                    <td>
                                    <?php if(!empty($value['document'])){ ?>
                                        <a href="<?php echo BASE_URL.INGREDIENT_DOCUMENTS_PATH.$value['document'];?>" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a>
                                      <?php }else{ ?>
                                        <img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>">
                                        
                                      <?php } ?>
                                  </td>
                                </tr>
                          <?php
                          $ing_name=$value['ing_name'];
                            }
                          } ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
             <div class="panel-footer">
                <span class="pull-right">
                    <button  id="submited_form"  class="btn btn-sm btn-success"><i class="glyphicon glyphicon-ok"></i></button>
                </span>
             </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<link rel="stylesheet" href="<?php echo STATIC_ADMIN_CSS?>toastr.css"> 
<script src="<?php echo STATIC_ADMIN_JS?>toastr.js"></script>
<script>
   $(document).ready(function() {
   $('.mdb-select').materialSelect();
   });
      $(document).off('change', '.file_load').on('change', '.file_load', function(e){
                e.preventDefault();
                var str=$(this).val();
                var name=$(this).attr("data-doc-name");
                str=str.split("\\"); 
                str = str[str.length - 1];
                str = str.substring( 0, str.indexOf("."));
                var lowerCaseName = name.toLowerCase();
                if(str!=name && str!=lowerCaseName)
                {
                    toastr.error("Document and title name must be same");
                    $(this).val('')
                }else{
                  $(this).parent().parent().find('td').find('img').attr("src","<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>");
                }
            });


  $(document).off("change", "#example39").on("change", "#example39",function(event){
      var type_id=$('#example39').val();
            $('.ing').nextAll('tr').remove();
        $.ajax({
          type: "POST",
          url: "<?php echo BASE_URL?>front/get_doc_name",
          data: {'type_id': type_id},
          success: function(data){
            var html="";
            var ingdt_name="";
            if(data.doc !=""){
            for(var i = 0; i < data.doc.length; i++) {
                    var obj = data.doc[i];
                    if(obj.ing_name!=ingdt_name)
                      html += '<tr><td class="heading">Ingredient('+obj.ing_name+')</td><td><td><td></td><tr>';
                    if(obj.document==null)
                      html += '<tr><td>'+obj.doc_name+'</td><td><input type="file" data-ing_id="'+obj.ing_id+'" data-doc-name="'+obj.doc_name+'" name="main_file_'+i+'" id="news_d_files" class="file_load"></td><td ><img src="<?php echo STATIC_FRONT_IMAGE.'Delete-file-icon.png' ?>"></td></tr>';
                    else
                       html += '<tr><td>'+obj.doc_name+'</td><td><input data-ing_id="'+obj.ing_id+'" data-doc-name="'+obj.doc_name+'" type="file" name="main_file_'+i+'" id="news_d_files" class="file_load"></td><td ><a href="<?php echo BASE_URL.INGREDIENT_DOCUMENTS_PATH?>'+obj.document+'" download><img src="<?php echo STATIC_FRONT_IMAGE.'doc.png' ?>"></a></td></tr>';
                       ingdt_name=obj.ing_name;
                }
            }else
            {
                html += '<tr><td>No Documents to be Uploaded</td></tr>';
            }
            $('.ing').after(html);
            
          }
       });
    });

    $(document).off('click', '.#submited_form').on('click', '#submited_form', function(e){
                e.preventDefault();
                var valid="1";
                <?php foreach($doc as $key => $value){ ?>
                var vul=$("input[name=news_main_page_file_<?php echo $key?>]").val();
                var exp=$("input[name=expiry_date_<?php echo $key?>]").val();
                if(vul!=="")
                {
                  if(exp=="")
                  {
                      valid=="0";
                      toastr.error("Please Provide Expiration date of the uploaded documents");
                      return false;
                  }
                }
                <?php } ?>
                if(valid="1")
                {
                    $( ".panel-info" ).submit();
                }
            });

</script>                              