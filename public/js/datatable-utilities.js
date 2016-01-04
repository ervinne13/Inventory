
/* global _, data, moment, form_utilities, globals */

var datatable_utilities = {};

//<editor-fold defaultstate="collapsed" desc="Renderers">

datatable_utilities.renderDate = function (date, type) {

    // if display or filter data is requested, format the date
    if (date && (type === 'display' || type === 'filter')) {
        return (moment(date).format(SGFormatter.DISPLAY_DATE_FORMAT));
    }

    // Otherwise the data type requested (`type`) is type detection or
    // sorting data, for which we want to use the raw date value, so just return
    // that, unaltered
    return date;

};

datatable_utilities.renderTime = function (time, type) {

    // if display or filter data is requested, format the time
    if (type === 'display' || type === 'filter') {
        return (moment(time, SGFormatter.SERVER_TIME_FORMAT).format(SGFormatter.DISPLAY_TIME_FORMAT));
    }

    // Otherwise the data type requested (`type`) is type detection or
    // sorting data, for which we want to use the raw date value, so just return
    // that, unaltered
    return time;

};

datatable_utilities.renderTimeFromDateTime = function (time, type) {

    // if display or filter data is requested, format the time
    if (type === 'display' || type === 'filter') {
        return (moment(time, SGFormatter.SERVER_DATETIME_FORMAT).format(SGFormatter.DISPLAY_TIME_FORMAT));
    }

    // Otherwise the data type requested (`type`) is type detection or
    // sorting data, for which we want to use the raw date value, so just return
    // that, unaltered
    return time;

};

//</editor-fold>


/**
 * Requires #template-table-inline-actions
 * @param {type} actions
 * @returns {undefined}
 */
datatable_utilities.getInlineActionsView = function (actions) {

    if (!$('#template-table-inline-actions').length) {
        console.error("#template-table-inline-actions not found");
        return "";
    }

    var template = _.template($('#template-table-inline-actions').html());

    return template({actions: actions});

};

datatable_utilities.getAllDefaultActions = function (id) {
    return [
        datatable_utilities.getDefaultViewAction(id),
        datatable_utilities.getDefaultEditAction(id),
        datatable_utilities.getDefaultDeleteAction(id)
    ];
};

datatable_utilities.getDefaultViewAction = function (id) {
    return {
        id: id,
        href: window.location.href + "/" + id,
        name: "view",
        displayName: "View",
        icon: "fa-search"
    };
};

datatable_utilities.getDefaultEditAction = function (id) {
    return {
        id: id,
        href: window.location.href + "/" + id + "/edit",
        name: "edit",
        displayName: "Edit",
        icon: "fa-pencil"
    };
};


datatable_utilities.getDefaultDeleteAction = function (id) {
    return {
        id: id,
        href: window.location.href + "/" + id,
        name: "delete",
        displayName: "Delete",
        icon: "fa-times"
    };
};

datatable_utilities.getAccessBasedActions = function (id, rowData, moduleCode) {
    var access = session.getModuleAccess(moduleCode);
    var actions = [];

    if (access == "MANAGER") {
        actions = datatable_utilities.getAllDefaultActions(id);
    } else if (access == "AUTHOR") {
        if (session.currentUser.username == rowData.created_by) {
            actions = datatable_utilities.getAllDefaultActions(id);
        } else {
            actions = [datatable_utilities.getDefaultViewAction(id)];
        }
    } else if (access == "VIEWER") {
        actions = [datatable_utilities.getDefaultViewAction(id)];
    } else {
        actions = [];
    }

    return actions;
};

//<editor-fold defaultstate="collapsed" desc="Actions">
datatable_utilities.initializeDeleteAction = function () {

    $(document).on('click', '.action-delete', function (e) {
        e.preventDefault();

        var id = $(this).data('id');
        var url = window.location.href + "/" + id;

        swal({
            title: "Are you sure?",
            text: "This record will be permanently deleted!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function () {
            $.ajax({
                url: url,
                type: "DELETE",
                success: function (response) {
                    console.log(response);
                    swal("Success", "Record deleted", "success");

                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                },
                error: function (response) {
                    console.error(response);
                    swal("Error", response.responseText, "error");
                }
            });
        });
    });


};
//</editor-fold>
