
/* global datatable_utilities, baseUrl, session */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#number-series-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/master-files/number-series/datatable"
            },
            order: [2, "asc"],
            columns: [
                {data: 'code'},
                {data: 'code'},
                {data: 'module.name', namge: 'module.name'},
                {data: 'effective_date'},
                {data: 'starting_number'},
                {data: 'ending_number'},
                {data: 'last_number_used'},
                {data: 'last_date_used'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (code) {

                        var actions = datatable_utilities.getAllDefaultActions(code);
                        var view = datatable_utilities.getInlineActionsView(actions);
                        return view;
                    }
                },
                {
                    targets: 7,
                    render: datatable_utilities.renderDate
                }
            ]
        });
    }

})();
