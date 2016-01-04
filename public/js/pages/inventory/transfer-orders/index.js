
/* global datatable_utilities, baseUrl, session, moduleCode */

(function () {

    "use strict";

    $(document).ready(function () {        
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#transfer-orders-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/inventory/item-movements/datatable"
            },
            order: [2, "desc"],
            columns: [
                {data: 'doc_no'},
                {data: 'doc_no'},
                {data: 'doc_date'},
                {data: 'status'},
                {data: 'origin_location.name', name: 'originLocation.name'},
                {data: 'destination_location.name', name: 'destinationLocation.name'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData) {
                        var actions = datatable_utilities.getAccessBasedActions(id, rowData, moduleCode);
                        var view = datatable_utilities.getInlineActionsView(actions);
                        return view;
                    }
                },
                {
                    targets: 2,
                    render: datatable_utilities.renderDate
                }
            ]
        });
    }

})();
