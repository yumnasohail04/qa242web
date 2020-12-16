<style>
.input-group-prepend {
    width: 25%;
}
.btn{
    width: 100%;
}
.select2
{
  width: 84%!important;
}
</style>
<?php include_once("select_box.php");?>
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
                            <form id="report_form" class="row" style="width:100%;">
                            
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Supplier</button>
                                </div>
                                  <select   class="form-control supplier" name="supplier" required="required">
                                        <option value="">All</option>
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
                                  <select   class="form-control supplier_type" name="supplier_type" required="required">
                                        <option value="">All</option>
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
                                  <select   class="form-control status" name="status" required="required">
                                        <option value=""> All</option>
                                  		<option value="active">Active</option>
                                  		<option value="inactive">In-active</option>
                                  </select>
                            	</div>
                            </div>
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Ingredient</button>
                                </div>
                                  <select   class="form-control ingredient" name="ingredient" required="required">
                                  <option value="">All</option>
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
                                  <select   class="form-control ingredient_type" name="ingredient_type" required="required">
                                  <option value="">All</option>
                                      <?php foreach($ing_type as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>
                            
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Product</button>
                                </div>
                                  <select   class="form-control product" name="product" required="required">
                                  <option value="">All</option>
                                      <?php foreach($choice_questions as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['title']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>

                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Country</button>
                                </div>
                                  <select   class="form-control country" name="country" required="required">
                                  <option value="">All</option>
                                      <?php foreach($country as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['option']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>
                            
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">Allergens</button>
                                </div>
                                  <select   class="form-control  allergens" name="allergens" required="required">
                                  <option value="">All</option>
                                      <?php foreach($allergens as $key => $value): ?>
                                  		<option value="<?php echo $value['id']; ?>"><?php echo $value['option']; ?></option>
                                  	  <?php endforeach; ?>
                                  </select>
                            	</div>
                            </div>

                            <!-- <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                                <label style="margin-right:2%">Export options</label>
                                  <select class="select-1 form-control" name="options[]" required="required" multiple="multiple">
                                    <option value="0">All</option> 
                                    <option value="1" >Supplier No</option>
                                    <option value="2" >Supplier Name</option>
                                    <option value="3" >Email</option>
                                    <option value="4" >Phone</option>
                                    <option value="5" >City</option>
                                    <option value="6" >State</option>
                                    <option value="7" >Country</option>
                                    <option value="8" >Role</option>
                                    <option value="9" >Supplier Item Name</option>
                                    <option value="10" >Supplier Item Number</option>
                                    <option value="11" >Ingredient Number</option>
                                    <option value="12" >Ingredient Name</option>
                                    <option value="14" >Ingredient PLM#</option>
                                    <option value="14" >Ingredient Type</option>
                                  </select>
                              </div>
                            </div> -->
                            
                            
                            <div class="form-body col-sm-4 " >                   
                           	  <div class="input-group  mb-3">
                              <button class="btn btn-outline-primary btn-search">Search</button>
                            	</div>
                            </div>
                            </form>
                            
                            <div class="form-body col-sm-12 " >  
                            <div class="tableview card-body">
                            </div>
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


            $(document).on("click", ".btn-search", function(event){
            event.preventDefault();
            $('.tableview').html('');
              $.ajax({
                        type: 'POST',
                        url: "<?php echo ADMIN_BASE_URL?>supplier_reports/search",
                        data: {'form_data': $('#report_form').serialize()},
                        async: false,
                        success: function(test_body) {
                          $('.tableview').append(test_body)
                          datatables();
                     }
                    });
            });

            $('.supplier').on("change",  function(event){
              if($(this).val())
              {
                $('.supplier_type').val('');
                $('.status').val('');
                $('.ingredient').val('');
              }
            });
            $('.ingredient').on("change",  function(event){
              if($(this).val())
                $('.ingredient_type').val('');
                $('.supplier').val('');
                $('.product').val('');
                $('.country').val('');
                $('.allergens').val('');
            });
            $('.ingredient_type').on("change",  function(event){
              if($(this).val())
                $('.ingredient').val('');
                $('.product').val('');
                $('.country').val('');
                $('.allergens').val('');
            });

            $('.supplier_type').on("change",  function(event){
              if($(this).val())
                $('.supplier').val('');
                $('.product').val('');
                $('.country').val('');
                $('.allergens').val('');
            });
            $('.status').on("change",  function(event){
              if($(this).val())
                $('.supplier').val('');
                $('.product').val('');
                $('.country').val('');
                $('.allergens').val('');
            });
            $('.product').on("change",  function(event){
              if($(this).val())
              {
                $('.supplier_type').val('');
                $('.status').val('');
                $('.ingredient_type').val('');
              }
            });
            $('.country').on("change",  function(event){
              if($(this).val())
              {
                $('.supplier_type').val('');
                $('.status').val('');
                $('.ingredient_type').val('');
              }
            });
            $('.allergens').on("change",  function(event){
              if($(this).val())
              {
                $('.supplier_type').val('');
                $('.status').val('');
                $('.ingredient_type').val('');
              }
            });


    });
    function datatables()
    {
      if ($().DataTable) {
      $(".data-table-standard").DataTable({
        bLengthChange: false,
        searching: false,
        destroy: true,
        info: false,
        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        pageLength: 6,
        language: {
          paginate: {
            previous: "<i class='simple-icon-arrow-left'></i>",
            next: "<i class='simple-icon-arrow-right'></i>"
          }
        },
        drawCallback: function () {
          $($(".dataTables_wrapper .pagination li:first-of-type"))
            .find("a")
            .addClass("prev");
          $($(".dataTables_wrapper .pagination li:last-of-type"))
            .find("a")
            .addClass("next");

          $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        }
      });

      $(".data-tables-pagination").DataTable({
        bLengthChange: false,
        searching: false,
        destroy: true,
        info: false,
        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        pageLength: 8,
        language: {
          paginate: {
            previous: "<i class='simple-icon-arrow-left'></i>",
            next: "<i class='simple-icon-arrow-right'></i>"
          }
        },
        drawCallback: function () {
          $($(".dataTables_wrapper .pagination li:first-of-type"))
            .find("a")
            .addClass("prev");
          $($(".dataTables_wrapper .pagination li:last-of-type"))
            .find("a")
            .addClass("next");

          $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        }
      });

      var dataTablePs;
      $(".data-table-scrollable").DataTable({
        searching: false,
        bLengthChange: false,
        destroy: true,
        info: false,
        paging: false,
        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        responsive: !0,
        deferRender: !0,
        scrollY: "calc(100vh - 400px)",
        scrollCollapse: !0,
        "fnInitComplete": function () {
          dataTablePs = new PerfectScrollbar('.dataTables_scrollBody', { suppressScrollX: true });
          dataTablePs.isRtl = false;
        },
        "fnDrawCallback": function (oSettings) {
          dataTablePs = new PerfectScrollbar('.dataTables_scrollBody', { suppressScrollX: true });
          dataTablePs.isRtl = false;
        }
      });
      $(".data-table-feature").DataTable({
        // sDom: '<"row view-filter"<"col-sm-12"<"float-right"l><"float-left"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        // "columns": [
        //   { "data": "name" },
        //   { "data": "position" },
        //   { "data": "office" },
        //   { "data": "age" },
        //   { "data": "start_date" },
        //   { "data": "salary" }
        // ],
        // drawCallback: function () {
        //   $($(".dataTables_wrapper .pagination li:first-of-type"))
        //     .find("a")
        //     .addClass("prev");
        //   $($(".dataTables_wrapper .pagination li:last-of-type"))
        //     .find("a")
        //     .addClass("next");

        //   $(".dataTables_wrapper .pagination").addClass("pagination-sm");
        // },
        // language: {
        //   paginate: {
        //     previous: "<i class='simple-icon-arrow-left'></i>",
        //     next: "<i class='simple-icon-arrow-right'></i>"
        //   },
        //   search: "_INPUT_",
        //   searchPlaceholder: "Search...",
        //   lengthMenu: "Items Per Page _MENU_"
        // },
      });

      // Datatable with rows
      var $dataTableRows = $("#datatableRows").DataTable({
        bLengthChange: false,
        buttons: [
          'copy',
          'excel',
          'csv',
          'pdf'
        ],
        destroy: true,
        info: false,
        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
        pageLength: 10,
        columns: [
          { data: "Name" },
          { data: "Sales" },
          { data: "Stock" },
          { data: "Category" },
          { data: "Check" }
        ],
        language: {
          paginate: {
            previous: "<i class='simple-icon-arrow-left'></i>",
            next: "<i class='simple-icon-arrow-right'></i>"
          }
        },
        drawCallback: function () {
          unCheckAllRows();
          $("#checkAllDataTables").prop("checked", false);
          $("#checkAllDataTables").prop("indeterminate", false).trigger("change");

          $($(".dataTables_wrapper .pagination li:first-of-type"))
            .find("a")
            .addClass("prev");
          $($(".dataTables_wrapper .pagination li:last-of-type"))
            .find("a")
            .addClass("next");
          $(".dataTables_wrapper .pagination").addClass("pagination-sm");
          var api = $(this).dataTable().api();
          $("#pageCountDatatable span").html("Displaying " + parseInt(api.page.info().start + 1) + "-" + api.page.info().end + " of " + api.page.info().recordsTotal + " items");
        }
      });

      $("#dataTablesCopy").on("click", function(event) {
        event.preventDefault();
        $dataTableRows.buttons(0).trigger();
      });

      $("#dataTablesExcel").on("click", function(event) {
        event.preventDefault();
        $dataTableRows.buttons(1).trigger();
      });
      
      $("#dataTablesCsv").on("click", function(event) {
        event.preventDefault();
        $dataTableRows.buttons(2).trigger();
      });
      
      $("#dataTablesPdf").on("click", function(event) {
        event.preventDefault();
        $dataTableRows.buttons(3).trigger();
      });

      $('#datatableRows tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
        var $checkBox = $(this).find(".custom-checkbox input");
        $checkBox.prop("checked", !$checkBox.prop("checked")).trigger("change");
        controlCheckAll();
      });

      function controlCheckAll() {
        var anyChecked = false;
        var allChecked = true;
        $('#datatableRows tbody tr .custom-checkbox input').each(function () {
          if ($(this).prop("checked")) {
            anyChecked = true;
          } else {
            allChecked = false;
          }
        });
        if (anyChecked) {
          $("#checkAllDataTables").prop("indeterminate", anyChecked);
        } else {
          $("#checkAllDataTables").prop("indeterminate", anyChecked);
          $("#checkAllDataTables").prop("checked", anyChecked);
        }
        if (allChecked) {
          $("#checkAllDataTables").prop("indeterminate", false);
          $("#checkAllDataTables").prop("checked", allChecked);
        }
      }

      function unCheckAllRows() {
        $('#datatableRows tbody tr').removeClass('selected');
        $('#datatableRows tbody tr .custom-checkbox input').prop("checked", false).trigger("change");
      }

      function checkAllRows() {
        $('#datatableRows tbody tr').addClass('selected');
        $('#datatableRows tbody tr .custom-checkbox input').prop("checked", true).trigger("change");
      }

      $("#checkAllDataTables").on("click", function (event) {
        var isCheckedAll = $("#checkAllDataTables").prop("checked");
        if (isCheckedAll) {
          checkAllRows();
        } else {
          unCheckAllRows();
        }
      });

      function getSelectedRows() {
        //Getting Selected Ones
        console.log($dataTableRows.rows('.selected').data());
      }

      $("#searchDatatable").on("keyup", function (event) {
        $dataTableRows.search($(this).val()).draw();
      });

      $("#pageCountDatatable .dropdown-menu a").on("click", function (event) {
        var selText = $(this).text();
        $dataTableRows.page.len(parseInt(selText)).draw();
      });

      var $addToDatatableButton = $("#addToDatatable").stateButton();

      // Validation when modal shown
      $('#rightModal').on('shown.bs.modal', function (e) {
        $("#addToDatatableForm").validate(
          {
            rules: {
              Sales: {
                required: true,
                number: true,
                min: 3000
              },
              Stock: {
                required: true,
                number: true,
              },
              Category: {
                required: true
              },
              Name: {
                required: true
              }
            }
          }
        )
      })

      //Adding to datatable from right modal
      $("#addToDatatable").on("click", function (event) {
        if ($("#addToDatatableForm").valid()) {
          $addToDatatableButton.showSpinner();
          var inputs = $("#addToDatatableForm").find(':input');
          var data = {};
          inputs.each(function () {
            data[$(this).attr("name")] = $(this).val();
          });
          data["Check"] = '<label class="custom-control custom-checkbox mb-1 align-self-center data-table-rows-check"><input type="checkbox" class="custom-control-input"><span class="custom-control-label">&nbsp;</span></label>';
          $dataTableRows.row.add(data).draw();
          setTimeout(function () {
            $addToDatatableButton.showSuccess(true, "New row added!");
            setTimeout(function () {
              $("#rightModal").modal("toggle");
              $addToDatatableButton.reset();
              inputs.each(function () {
                $(this).val("");
              });
              if ($("#addToDatatableForm").find('select').data('select2')) {
                $("#addToDatatableForm").find('select').val('').trigger('change');
              }
              $("#addToDatatableForm").validate().resetForm();
            }, 1000);
          }, 1000);
        }
      });
    }
    }
</script>
