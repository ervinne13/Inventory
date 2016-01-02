
/* global datatable_utilities, baseUrl, session */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#item-movements-datatable').DataTable({
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
                {data: 'id'},
                {data: 'status'},
                {data: 'movement_date'},
                {data: 'ref_doc_type'},
                {data: 'ref_doc_no'},
                {data: 'location_code'},
                {data: 'item_name'},
                {data: 'qty'},
                {data: 'unit_cost'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData) {

                        var actions;
                        if (rowData.status === "Open") {
                            actions = datatable_utilities.getAllDefaultActions(id);
                        } else {
                            actions = [datatable_utilities.getDefaultViewAction(id)];
                        }

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
