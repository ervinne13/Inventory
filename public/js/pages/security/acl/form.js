
/* global form_utilities, baseUrl, mode, code, roleAccessControl, sg_table_row_utilities */

(function () {

    var $roleAccessTable;

    $(document).ready(function () {
        form_utilities.disableFieldsOnViewMode(mode);
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
            initializeDetailsTable();
            initializeForm();
        }
    });

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/security/roles";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $roleAccessTable);
    }

    function initializeDetailsTable() {
        $roleAccessTable = $('#role-access-table').SGTable({
            dropdownRowTemplate: '#role-access-row-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'module_code',
            displayInlineActions: true,
            autoFocusField: 'number',
            highlighColor: '#F78B3E',
            closeRowActionIcon: '<i class="fa fa-chevron-up"></i>',
            openRowActionIcon: '<i class="fa fa-edit"></i>',
            deleteRowActionIcon: '<i class="fa fa-remove"></i>',
            enableDeleteRows: true,
            autoGenerateHeaderRow: true,
            headerColumnClass: "small text-muted text-uppercase",
            columns: {
                module_code: {label: "Module", hidden: true},
                module_name: {label: "Module", type: "select"},
                access_control_code: {label: "Access Control", type: "select"},
//                access_control_name: {label: "Access Control"}
            }
        });

        for (var i in roleAccessControl) {
            roleAccessControl[i].module_name = roleAccessControl[i].module.name;
        }

        $roleAccessTable.setData(roleAccessControl);
        $roleAccessTable.on('openRow', function (e, moduleCode) {
            initializeDetailForm();
            initializeDetailEvents();
        });
    }

    function initializeDetailForm() {
        form_utilities.initializeDefaultSelect2();
    }

    function initializeDetailEvents() {
        sg_table_row_utilities.initializeDefaultEvents($roleAccessTable, $('#role-access-row-form'), getOpenRowData);
    }

    function getOpenRowData() {
        return {
            module_code: $('[name=module_code]').val(),
            module_name: $('[name=module_code] option:selected').text(),
            access_control_code: $('[name=access_control_code]').val()
        };
    }

})();
