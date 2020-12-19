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
  display: flex;
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
    border-radius: 5px;
}

.form-group label:before {
    content: '';
    -webkit-appearance: none;
    background-color: transparent;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
    padding: 10px;
    display: inline-block;
    position: relative;
    vertical-align: middle;
    cursor: pointer;
    margin-right: 5px;
    width: 40px;
    height: 40px;
    /* border-radius: 30px; */
}

.form-group input:checked + label:after {
    content: '';
    display: block;
    position: absolute;
    top: 9px;
    left: 19px;
    width: 10px;
    height: 19px;
    border: 0px solid #ffffff;
    border-width: 0px 2px 2px 0;
    transform: rotate(45deg);
}
.containerz
{
    width: 50%; 
    margin: 0 auto;
}
.modal .modal-body
{
    height: 74vh;
    overflow: auto;
}

</style>

            <!-- BEGIN FORM-->
               
            <div class="form-body section-box ">
            
            
        <div class="row new">
            <?php
            foreach($card as $cd => $dtl):
        $count=0;
        $type="";
        $ingredient="";?>
        <h3 class="form-section view_supplier bg-theme-1" style="cursor:pointer;text-transform: capitalize;padding: 2%;width:100%" rel="<?php echo $dtl['supplier']['supplier_id']; ?>"><?php echo $dtl['supplier']['name'].' Scorecard'; ?></h3>
        <?php
        foreach($dtl['questions'] as $key => $value){ 
        $file="";
        $count++;
        if($value['type']!=$type)
        { 
        $type=$value['type'];
        ?>
            <legend><?php echo $value['type']." Section"?></legend>
            <?php }
        ?>
        <?php if($value['type']=="Ingredient"){
                    if($value['ingredient']!=$ingredient)
                    { $ingredient=$value['ingredient'];
                        ?>
                            <legend><span class="view_details" style="cursor:pointer" rel="<?php echo $value['ingredient_id']?>"><?php echo $value['ingredient'];?></span></legend>
                        <?php
                        }
                }?>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-8">
                    <?php
                        if($value['type']=="Document")
                                if(!empty($value['doc']) && isset($value['doc']))
                                    if(file_exists(SUPPLIER_DOCUMENTS_PATH.$value['doc']))
                                        $file=BASE_URL.SUPPLIER_DOCUMENTS_PATH.$value['doc'];
                            if($file!=""){?>
                                <p title="Download" style="color: #2f69b7;"><span><?php echo $count;?>. </span><a href="<?php echo $file; ?>" download ><?php echo $value['question']; ?></a></p>
                        <?php }else{ ?>
                                <p title="No document uploaded" style="color: #2f69b7;"><span><?php echo $count;?>. </span><?php echo $value['question']; ?></p>
                        <?php }?>
                        <p style="font-size:16px;"><?php echo $value['sfq_description']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <?php foreach($value['answers'] as $keys => $ans) {
                        if($ans['sfa_answer']=="Red")
                            $color="#e84e4e";
                        if($ans['sfa_answer']=="Green")
                            $color="#69b969";
                        if($ans['sfa_answer']=="Yellow")
                            $color="#ecec4c";
                        ?>
                        <input <?php if(isset($value['doc_stat']) && $value['doc_stat']=="0" && $ans['sfa_answer']=="Red") echo "checked"; ?> type="checkbox" id="html<?php echo $cd.$keys.$key ?>" data-points="<?php echo $ans['sfa_points']; ?>" data-ans-id="<?php echo $ans['sfa_id'] ?>" data-card-id="<?php echo $dtl['supplier']['id']; ?>" data-quest-id="<?php echo $value['id'] ?>" class="check_color" >
                        <label for="html<?php echo $cd.$keys.$key ?>"  style="background-color:<?php echo $color; ?>"></label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <?php }
            endforeach; ?>
        </div>
        <div class="form-actions fluid no-mrg">
            <div class="row ">
            <div class="col-md-12">
                <div style="text-align:center;" >
                <span ></span> <button class="btn btn-outline-primary  submited_form"><i class="fa fa-check"></i>&nbsp;Save</button>
                <a href="<?php echo ADMIN_BASE_URL . 'scorecard'; ?>">
                <button type="button" class="btn green btn-outline-primary " ><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                </a> </div>
            </div>
            </div>
        </div>
        
<script>

    $(document).ready(function() {
      
        $('input[type=checkbox]').each(function () {
          var quest_id=$(this).attr('data-quest-id'); 
          var card_id=$(this).attr('data-card-id');
          var ans_id=$(this).attr('data-ans-id');
          var points=$(this).attr('data-points');
          if($(this).is(":checked")) {
            if(result_arr!="")
            {
                exist=0;
                for (i = 0; result_arr.length> i; i += 1) {
                    if (result_arr[i].questId === quest_id  &&  result_arr[i].cardId === card_id) {
                        exist=1;
                        result_arr[i].ansId=ans_id;
                        result_arr[i].points=points;
                    }
                }
                if(exist==0)
                {
                    result_arr.push({questId:quest_id,ansId:ans_id,points:points,cardId:card_id})
                }
            }
            else
            {
                result_arr.push({questId:quest_id,ansId:ans_id,points:points,cardId:card_id})
            }
          }
       });
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });
    
    var qa,filled,exist,i, result_arr=[];
    $(document).off('click', '.submited_form').on('click', '.submited_form', function(e){
    e.preventDefault();
        filled=1;
        qa=0;
        if(<?php echo $tot ?>==result_arr.length)
        {
            qa=1;
        }
        if(qa==0){
            toastr.error("Fill all questions in Scorecard");  
            filled=0;
            return false;
        }
    if(filled==1){
    var formdata=JSON.stringify(result_arr);
        $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>scorecard/submit_bulk",
            data: {'result_arr':formdata},
            async: false,
            success: function() {
                return false;
                window.location = "<?php echo ADMIN_BASE_URL.'scorecard/inprogress_scorecard'; ?>";
            }
        });
    }
    });
    $(".check_color").click(function(){
        $(this).parent().find('.check_color').prop("checked", false);
        $(this).prop("checked", true);
          var quest_id=$(this).attr('data-quest-id'); 
          var card_id=$(this).attr('data-card-id');
      var ans_id=$(this).attr('data-ans-id');
      var points=$(this).attr('data-points');
      if($(this).is(":checked")) {
        if(result_arr!="")
          {
            exist=0;
            for (i = 0; result_arr.length> i; i += 1) {
        		if (result_arr[i].questId === quest_id &&  result_arr[i].cardId === card_id) {
        		    exist=1;
        		    result_arr[i].ansId=ans_id;
        		    result_arr[i].points=points;
        		}
            }
            if(exist==0)
            {
                result_arr.push({questId:quest_id,ansId:ans_id,points:points,cardId:card_id})
            }
        }
        else
        {
            result_arr.push({questId:quest_id,ansId:ans_id,points:points,cardId:card_id})
        }
      }
    });

      $(document).on("click", ".view_details", function(event){
        event.preventDefault();
        var id = $(this).attr('rel');
        //alert(id); return false;
            $.ajax({
                    type: 'POST',
                    url: "<?php echo ADMIN_BASE_URL?>ingredients/detail",
                    data: {'id': id},
                    async: false,
                    success: function(test_body) {
                    var test_desc = test_body;
                        $('#myModalLarge').modal('show')
                        $("#myModalLarge .modal-body").html(test_desc);
                    }
                });
        });
  $(document).on("click", ".view_supplier", function(event){
    event.preventDefault();
    var id = $(this).attr('rel');
    //alert(id); return false;
        $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>supplier/detail",
                data: {'id': id},
                async: false,
                success: function(test_body) {
                var test_desc = test_body;
                    $('#myModalLarge').modal('show')
                    $("#myModalLarge .modal-body").html(test_desc);
                    
                    

                }
            });
    });
</script>
