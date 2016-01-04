
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

                        var access = session.getModuleAccess(moduleCode);
                        var actions = [];

                        if (rowData.status == "Produced") {
                            actions = [datatable_utilities.getDefaultViewAction(docNo)];
                        } else if (access == "MANAGER") {
                            actions = datatable_utilities.getAllDefaultActions(docNo);
                        } else if (access == "AUTHOR") {
                            if (session.currentUser.username == rowData.created_by) {
                                actions = datatable_utilities.getAllDefaultActions(docNo);
                            } else {
                                actions = [datatable_utilities.getDefaultViewAction(docNo)];
                            }
                        } else if (access == "VIEWER") {
                            actions = [datatable_utilities.getDefaultViewAction(docNo)];
                        } else {
                            actions = [];
                        }

                        return datatable_utilities.getInlineActionsView(actions);
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
