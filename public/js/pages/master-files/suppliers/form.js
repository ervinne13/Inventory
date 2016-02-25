
/* global form_utilities, baseUrl, username, mode, recomputeTotals */

(function () {

    let $detailsTable;

    $(document).ready(function () {

        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();

            initializeDetailsTable();
            initializeForm();
        } else {
            form_utilities.disableFieldsOnViewMode(mode);
        }
    });

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/master-files/suppliers";
        form_utilities.updateObjectId = supplierNumber;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }

    function initializeDetailsTable() {
        $detailsTable = $('#supplier-prices-table').SGTable({
            dropdownRowTemplate: '#detail-form-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'item_code',
            displayInlineActions: true,
            autoFocusField: 'number',
            highlighColor: '#F78B3E',
            closeRowActionIcon: '<i class="fa fa-chevron-up"></i>',
            openRowActionIcon: '<i class="fa fa-edit"></i>',
            deleteRowActionIcon: '',
            enableDeleteRows: false,
            autoGenerateHeaderRow: true,
            headerColumnClass: "small text-muted text-uppercase",
            columns: {
                supplier_number: {label: "", hidden: true},
                item_type_code: {label: "Item Type Code"},
                item_code: {label: "Item Code"},
                item_name: {label: "Item Name"},
                item_unit_cost: {label: "Unit Cost"}
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
    }

    function initializeDetailEvents() {
        sg_table_row_utilities.initializeDefaultEvents($detailsTable, $('#detail-row-row-form'), getOpenRowData);
    }

    function getOpenRowData() {
        return {
            supplier_number: $('[name=supplier_number]').val(),
            item_type_code: $('[name=item_type_code]').val(),
            item_code: $('[name=item_code]').val(),
            item_name: $('[name=item_name]').val(),
            item_unit_cost: $('[name=item_unit_cost]').val()
        };
    }

})();
