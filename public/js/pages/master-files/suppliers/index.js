
/* global datatable_utilities, baseUrl, session */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#suppliers-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/master-files/suppliers/datatable"
            },
            order: [1, "asc"],
            columns: [
                {data: 'supplier_number'},
                {data: 'supplier_number'},
                {data: 'display_name'}
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function (username) {

                        var actions;
                        if (session.hasRole("ADMIN") || username == session.currentUser.username) {
                            actions = datatable_utilities.getAllDefaultActions(username);
                        } else {
                            actions = [datatable_utilities.getDefaultViewAction(username)];
                        }

                        var view = datatable_utilities.getInlineActionsView(actions);
                        return view;
                    }
                }
            ]
        });
    }

})();
