
/* global datatable_utilities, baseUrl, session */

(function () {

    "use strict";

    $(document).ready(function () {
        initializeDatatable();
        datatable_utilities.initializeDeleteAction();
    });

    function initializeDatatable() {
        $('#users-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/master-files/users/datatable"
            },
            order: [1, "asc"],
            columns: [
                {data: 'username'},
                {data: 'username'},
                {data: 'display_name'},
                {data: 'roles'},
                {data: 'roles'}
            ],
            columnDefs: [
                {searchable: false, targets: [0, 3, 4]},
                {orderable: false, targets: [0, 3, 4]},
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
                },
                {
                    targets: [3],
                    render: function (roles) {
                        var roleNames = [];
                        for (var i in roles) {
                            roleNames.push(roles[i].name);
                        }

                        return roleNames.join();
                    }
                },
                {
                    targets: [4],
                    render: function (locations) {
                        console.log(locations);
                        return "locations will be displayed here";
                    }
                }
            ]
        });
    }

})();
