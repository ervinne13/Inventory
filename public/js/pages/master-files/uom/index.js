
/* global datatable_utilities, baseUrl, session */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#uom-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/master-files/uom/datatable"
            },
            order: [2, "asc"],
            columns: [
                {data: 'code'},
                {data: 'code'},
                {data: 'name'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (code) {

                        var access = session.getModuleAccess(moduleCode);
                        var actions = [];

                        if (access == "MANAGER") {
                            actions = datatable_utilities.getAllDefaultActions(code);
                        } else if (access == "AUTHOR" && session.currentUser.username == rowData.created_by) {
                            actions = datatable_utilities.getAllDefaultActions(code);
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
