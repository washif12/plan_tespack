/*
 Template Name: Fonik - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Datatable js
 */

$(document).ready(function() {
    $('#datatable').DataTable({
        initComplete: function() {
            $(this.api().table().container()).find('input').parent().wrap('<form>').parent().attr('autocomplete', 'off');
        },
        "columnDefs": [
            { "orderable": false, "targets": 'no-sort' },
            { 'visible': false, 'targets': [] },
            /*{
                orderable: false,
                className: 'select-checkbox',
                targets:   [0]
            }*/
        ],
        /*select: {
            style:    'os',
            selector: 'td:first-child'
        },
        order: [
            [1, 'asc']
        ],*/
        language : {
            oPaginate: {
                sNext: '<i class="fa fa-greater-than"></i>',
                sPrevious: '<i class="fa fa-less-than"></i>'
            }
        }
    });

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );