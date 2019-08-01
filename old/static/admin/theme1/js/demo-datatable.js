// Demo datatables
// ----------------------------------- 


(function(window, document, $, undefined){

  $(function(){

    //
    // Zero configuration
    // 

    $('#datatable1').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        // Text translation options
        // Note the required keywords between underscores (e.g _MENU_)

              // "aoColumnDefs": [
 //     { "bSearchable": false, "aTargets": [ 3 ] }
 //   ],

        oLanguage: {
            sSearch:      'Search:',
            sLengthMenu:  '_MENU_ records per page',
            info:         'Showing page _PAGE_ of _PAGES_',
            zeroRecords:  'Nothing found - sorry',
            infoEmpty:    'No records available',
            infoFiltered: '(filtered from _MAX_ total records)'
        }
    });


    $('#datatable_prod').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        // Text translation options
        // Note the required keywords between underscores (e.g _MENU_)

               "aoColumnDefs": [
      { "bSearchable": false, "aTargets": [ 3 ] }
    ],

        oLanguage: {
            sSearch:      'Search:',
            sLengthMenu:  '_MENU_ records per page',
            info:         'Showing page _PAGE_ of _PAGES_',
            zeroRecords:  'Nothing found - sorry',
            infoEmpty:    'No records available',
            infoFiltered: '(filtered from _MAX_ total records)'
        }
    });


    // 
    // Filtering by Columns
    // 

    var dtInstance2 = $('#datatable2').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        // Text translation options
        // Note the required keywords between underscores (e.g _MENU_)
        oLanguage: {
            sSearch:      'Search all columns:',
            sLengthMenu:  '_MENU_ records per page',
            info:         'Showing page _PAGE_ of _PAGES_',
            zeroRecords:  'Nothing found - sorry',
            infoEmpty:    'No records available',
            infoFiltered: '(filtered from _MAX_ total records)'
        }
    });
    var inputSearchClass = 'datatable_input_col_search';
    var columnInputs = $('tfoot .'+inputSearchClass);

    // On input keyup trigger filtering
    columnInputs
      .keyup(function () {
          dtInstance2.fnFilter(this.value, columnInputs.index(this));
      });


    // 
    // Column Visibilty Extension
    // 

    $('#datatable3').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        // Text translation options
        // Note the required keywords between underscores (e.g _MENU_)
        oLanguage: {
            sSearch:      'Search all columns:',
            sLengthMenu:  '_MENU_ records per page',
            info:         'Showing page _PAGE_ of _PAGES_',
            zeroRecords:  'Nothing found - sorry',
            infoEmpty:    'No records available',
            infoFiltered: '(filtered from _MAX_ total records)'
        },
        // set columns options
        'aoColumns': [
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true},
            {'bVisible':true}
        ],
        sDom:      'C<"clear">lfrtip',
        colVis: {
            order: 'alfa',
            'buttonText': 'Show/Hide Columns'
        }
    });

    // 
    // AJAX
    // 

     // 
    // AJAX
    // 

   /* $('#datatable4').DataTable( {
    ajax: {
        url: 'search_order',
        dataSrc: 'aaData'
    },
    columns:  [
          { mData: 'Order No' },
          { mData: 'Date' },
          { mData: 'Vat' },
          { mData: 'Vat Amount' },
          { mData: 'Delivery' },
          { mData: 'Delivery vat' },
          { mData: 'Deliver vat amount' },
          { mData: 'Discount' },
          { mData: 'Payment method' },
          { mData: 'Sub total' },
          { mData: 'Total Price' }
        ]
} );*/


   /* $('#datatable4').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        sAjaxSource: 'search_order',
        aoColumns: [
          { mData: 'Order No' },
          { mData: 'Date' },
          { mData: 'Vat' },
          { mData: 'Vat Amount' },
          { mData: 'Delivery' },
          { mData: 'Delivery vat' },
          { mData: 'Deliver vat amount' },
          { mData: 'Discount' },
          { mData: 'Payment method' },
          { mData: 'Sub total' },
          { mData: 'Total Price' }
        ]
    });*/ 
    
  });

})(window, document, window.jQuery);
