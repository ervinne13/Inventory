
/* global datatable_utilities, baseUrl, session, moduleCode */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#items-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/master-files/items/datatable"
            },
            order: [2, "asc"],
            columns: [
                {data: 'code'},
                {data: 'item_type.name', name: "itemType.name"},
                {data: 'code'},
                {data: 'name'},
                {data: 'default_currency_code'},
                {data: 'default_unit_cost'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (code, type, rowData) {

                        var access = session.getModuleAccess(moduleCode);
                        var actions = [];

                        if (access == "MANAGER") {
                            actions = datatable_utilities.getAllDefaultActions(code);
                        } else if (access == "AUTHOR") {
                            if (session.currentUser.username == rowData.created_by) {
                                actions = datatable_utilities.getAllDefaultActions(code);
                            } else {
                                actions = [datatable_utilities.getDefaultViewAction(code)];
                            }
                        } else if (access == "VIEWER") {
                            actions = [datatable_utilities.getDefaultViewAction(code)];
                        } else {
                            actions = [];
                        }

                        return datatable_utilities.getInlineActionsView(actions);
                    }
                }
            ]
        });
    }

})();
