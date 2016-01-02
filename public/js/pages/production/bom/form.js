
/* global form_utilities, baseUrl, mode, code, details, sg_table_row_utilities */

(function () {

    var $detailsTable;

    $(document).ready(function () {
        form_utilities.disableFieldsOnViewMode(mode);
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
            initializeDetailsTable();
            initializeUI();
            initializeForm();
        }
    });

    function initializeUI() {
        form_utilities.initializeDefaultSelect2();

        var itemSet = new ItemSet();
        itemSet.loadSetInContainer($('.fields-container'));
    }

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/production/bom";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }

    function initializeDetailsTable() {
        $detailsTable = $('#bom-details-table').SGTable({
            dropdownRowTemplate: '#detail-form-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'item_code',
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
                bom_code: {label: "", hidden: true},
                item_type_code: {label: "Item Type", },
                item_code: {label: "Raw Material Code"},
                item_name: {label: "Raw Material Name"},
                item_uom_code: {label: "UOM", type: "select"},
                qty: {label: "Required Qty"},
            }
        });

//        for (var i in roleAccessControl) {
//            roleAccessControl[i].module_name = roleAccessControl[i].module.name;
//        }

        $detailsTable.setData(details);
        $detailsTable.on('openRow', function (e, moduleCode) {
            initializeDetailForm();
            initializeDetailEvents();
        });
    }

    function initializeDetailForm() {

        form_utilities.initializeDefaultSelect2();

        var itemSet = new ItemSet();
        itemSet.loadSetInContainer($('#detail-row-row-form'));
//        form_utilities.initializeDefaultSelect2();
    }

    function initializeDetailEvents() {
        sg_table_row_utilities.initializeDefaultEvents($detailsTable, $('#detail-row-row-form'), getOpenRowData);
    }

    function getOpenRowData() {
        return {
            bom_code: $('[name=code]').val(),
            item_type_code: $('[name=item_type]').val(),
            item_code: $('[name=item_code]').val(),
            item_name: $('[name=item_name]').val(),
            item_uom_code: $('[name=item_uom_code]').val(),
            qty: $('[name=qty]').val()
        };
    }

})();
