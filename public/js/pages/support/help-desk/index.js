
/* global baseURL, datatable_utilities, baseUrl */

(function () {

    var issueReporterColTemplate;
    var issueColTemplate;
    var issueDateColTemplate;

    $(document).ready(function () {
        initializeTemplates();
        initializeTable();
    });

    function initializeTemplates() {
        issueReporterColTemplate = _.template($('#issue-reporter-col-template').html());
        issueColTemplate = _.template($('#issue-col-template').html());
        issueDateColTemplate = _.template($('#issue-date-col-template').html());
    }

    function initializeTable() {
        $('#issue-reports-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/support/help-desk/datatable"
            },
            order: [3, "desc"],
            columns: [
                {data: 'id'},
                {data: 'reported_by'},
                {data: 'subject'},
                {data: 'created_at'}
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id) {
//                        var actions = datatable_utilities.getAllDefaultActions(id);
//                        var view = datatable_utilities.getInlineActionsView(actions);
                        return "";
                    }
                },
                {
                    targets: [1],
                    render: function (reportedBy) {
                        return issueReporterColTemplate(reportedBy);
                    }
                },
                {
                    targets: [2],
                    render: function (subject, display, rowData) {
                        return issueColTemplate(rowData);
                    }
                },
                {
                    targets: [3],
                    render: function (subject, display, rowData) {
                        return issueDateColTemplate(rowData);
                    }
                }
            ]
        });
    }

})();
