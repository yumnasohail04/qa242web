<style>
.input-group-prepend {
    width: 25%;
}
.btn{
    width: 100%;
}
</style>
<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Reports</h1>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
               				<div class="row">
                            
                            
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Supplier</button>
                                </div>
                                  <select   class="form-control  restaurant_type  " name="supplier" required="required">
                                      <?php foreach($supplier as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Supplier Type</button>
                                </div>
                                  <select   class="form-control  restaurant_type " name="supplier_type" required="required">
                                  		<option value="primary">Primary</option>
                                  		<option value="secondary">Secondary</option>
                                  </select>
                            	</div>
                            </div>
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Status</button>
                                </div>
                                  <select   class="form-control  restaurant_type " name="supplier_type" required="required">
                                  		<option value="primary">Active</option>
                                  		<option value="secondary">In-active</option>
                                  </select>
                            	</div>
                            </div>
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Ingredient</button>
                                </div>
                                  <select   class="form-control  restaurant_type " name="supplier_type" required="required">
                                     <?php foreach($ingredients as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['item_name']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>
                             <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Ingredient Type</button>
                                </div>
                                  <select   class="form-control  restaurant_type " name="supplier_type" required="required">
                                      <?php foreach($ing_type as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>
                            
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                              <button class="btn btn-outline-primary">Search</button>
                            	</div>
                            </div>
                            
                            
                            <div class="form-body col-sm-12 " >  
<!--                             	<table class="data-table data-table-feature">
                        			<thead class="bg-th">
                        				<tr class="bg-col">
                        					<th>Document Name <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        					<th>Assigned to <i class="fa fa-sort" style="font-size:13px;"></i></th>
                        					<th class=""></th>
                        				</tr>
                        			</thead>
                        			<tbody>
                                        <tr >
                                        	<td></td>
                                       	 	<td></td>
                                   		 </tr>
                           			 </tbody>
                    			</table> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main>
<script type="text/javascript">
		$(document).ready(function(){
            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>document/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                       var test_desc = test_body;
                         $('#myModalLarge').modal('show')
                         $("#myModalLarge .modal-body").html(test_desc);
                          
                         
 
                     }
                    });
            });
		});
</script>
