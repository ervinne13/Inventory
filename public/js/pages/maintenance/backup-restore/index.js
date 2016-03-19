
/* global datatable_utilities, baseUrl, session, moduleCode, SGFormatter, moment, baseURL, swal */

(function () {

    "use strict";

    $(document).ready(function () {

        initializeEvents();
        initializeDatatable();

    });

    function initializeEvents() {
        $('#action-backup').click(backup);

        $(document).on('click', '.action-restore', function () {
            let id = $(this).data('id');
            promptRestore(id);
        });

    }

    function initializeDatatable() {
        $('#backup-datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: baseUrl + "/maintenance/backup-restore/datatable"
            },
            order: [2, "asc"],
            columns: [
                {data: 'id'},
                {data: 'backup_datetime'},
                {data: 'file_path'},
            ],
            columnDefs: [
                {searchable: false, targets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id) {
                        return datatable_utilities.getInlineActionsView([
                            {
                                id: id,
                                href: "#",
                                name: "restore",
                                displayName: "Restore",
                                icon: "fa-refresh"
                            }
                        ]);
                    }
                },
                {
                    targets: 1,
                    render: function (dateString) {
                        return moment(dateString).format(SGFormatter.DISPLAY_DATE_TIME_FORMAT);
                    }
                }
            ]
        });
    }

    function backup() {
        let url = baseURL + "/maintenance/backup-restore/backup";

        $('#action-backup').prop('disabled', true);

        $.get(url)
                .done(response => {
                    console.log(response);
                    swal("Success", "Backup created", "success");

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);

                })
                .fail(xhr => {
                    swal("Error", xhr.responseText, "error");
                })
                .always(() => {
                    $('#action-backup').prop('disabled', false);
                });

    }

    function promptRestore(id) {
        swal({
            title: 'Are you sure?',
            text: "Your database will be restored and rolled back to the date of this backup!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore backup!'
        }, () => {
            restore(id);
        });
    }

    function restore(id) {

        let url = baseURL + "/maintenance/backup-restore/" + id + "/restore";

        $.get(url)
                .done(response => {
                    console.log(response);
                    swal('Restored', 'Your database has been restored.', 'success');

                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);

                })
                .fail(xhr => {
                    swal("Error", xhr.responseText, "error");
                })
                .always(() => {
                    $('#action-backup').prop('disabled', false);
                });

        setTimeout(function () {
            swal('Please wait', 'This may take a long while.');
        }, 20);

    }

})();
