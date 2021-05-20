
// Tables-DataTables.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -



$(document).on('nifty.ready', function() {


    // DATA TABLES
    // =================================================================
    // Require Data Tables
    // -----------------------------------------------------------------
    // http://www.datatables.net/
    // =================================================================

    $.fn.DataTable.ext.pager.numbers_length = 5;


    // Basic Data Tables with responsive plugin
    // -----------------------------------------------------------------
    $('#dt-basic').dataTable( {
        "responsive": true,
        "language": {
            "paginate": {
              "previous": '<i class="psi-arrow-left"></i>',
              "next": '<i class="psi-arrow-right"></i>'
            }
        }
    } );





    // Row selection (single row)
    // -----------------------------------------------------------------
    var rowSelection = $('#dt-selection').DataTable({
        "responsive": true,
        "language": {
            "paginate": {
              "previous": '<i class="psi-arrow-left"></i>',
              "next": '<i class="psi-arrow-right"></i>'
            }
        }
    });

    $('#dt-selection').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            rowSelection.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );






    // Row selection and deletion (multiple rows)
    // -----------------------------------------------------------------
    var rowDeletion = $('#dt-delete').DataTable({
        "responsive": true,
        "language": {
            "paginate": {
              "previous": '<i class="psi-arrow-left"></i>',
              "next": '<i class="psi-arrow-right"></i>'
            }
        },
        "dom": '<"toolbar">frtip'
    });
    $('#custom-toolbar').appendTo($("div.toolbar"));

    $('#dt-delete tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    $('#dt-delete-btn').click( function () {
        rowDeletion.rows('.selected').remove().draw( false );
    } );






    // Add Row
    // -----------------------------------------------------------------
    var t = $('#dt-addrow').DataTable({
        "responsive": true,
        "language": {
            "paginate": {
              "previous": '<i class="psi-arrow-left"></i>',
              "next": '<i class="psi-arrow-right"></i>'
            }
        },
        "dom": '<"newtoolbar">frtip'
    });
    $('#custom-toolbar2').appendTo($("div.newtoolbar"));

    var randomInt = function(min,max){
        return Math.floor(Math.random()*(max-min+1)+min);
    }
    $('#dt-addrow-btn').on( 'click', function () {
        t.row.add( [
            'Adam Doe',
            'New Row',
            'New Row',
            randomInt(1,100),
            '2015/10/15',
            '$' + randomInt(1,100) +',000'
        ] ).draw();
    } );


});
