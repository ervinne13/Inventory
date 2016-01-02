
/* global datatable_utilities, baseUrl, session */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#pro-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/production/production-orders/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'doc_no'},
                {data: 'doc_no'},
                {data: 'doc_date'},
                {data: 'location.name'},
                {data: 'bom_code'},
                {data: 'status'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (docNo, type, rowData) {

                        var actions = datatable_utilities.getAllDefaultActions(docNo);
                        var view = datatable_utilities.getInlineActionsView(actions);
                        return view;
                    }
                },
                {
                    targets: 1,
                    render: datatable_utilities.renderDate
                }
            ]
        });
    }

})();
