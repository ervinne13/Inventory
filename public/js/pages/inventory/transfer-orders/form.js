
/* global form_utilities, baseUrl, mode, code, baseURL, sg_table_row_utilities, details, docNo */

(function () {

    var $detailsTable;

    $(document).ready(function () {

        initializeDetailsTable();

        initializeUI();
        initializeForm();
    });

    function initializeUI() {
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
        } else {
            form_utilities.disableFieldsOnViewMode(mode);
        }

        form_utilities.initializeDefaultSelect2();

        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });

        //  item set
        var itemSet = new ItemSet();
        itemSet.loadSetInContainer($('.fields-container'));
    }

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/inventory/transfer-orders";
        form_utilities.updateObjectId = docNo;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }


    function initializeDetailsTable() {
        $detailsTable = $('#transfer-order-details-table').SGTable({
            dropdownRowTemplate: '#detail-form-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'line_no',
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
                line_no: {label: "", hidden: true},
                doc_no: {label: "", hidden: true},
                item_type_code: {label: "Item Type Code"},
                item_code: {label: "Item Code"},
                item_name: {label: "Item Name"},
                item_uom_code: {label: "UOM"},
                qty: {label: "Qty"}
            }
        });

        $detailsTable.setData(details);
        $detailsTable.on('openRow', function (e) {
            initializeDetailForm();
            initializeDetailEvents();
        });
    }

    function initializeDetailForm() {
        //  item set
        var itemSet = new ItemSet();
        itemSet.loadSetInContainer($('#detail-row-row-form'));
    }

    function initializeDetailEvents() {
        sg_table_row_utilities.initializeDefaultEvents($detailsTable, $('#detail-row-row-form'), getOpenRowData);
    }

    function getOpenRowData() {
        return {
            line_no: $('[name=line_no]').val(),
            doc_no: $('[name=doc_no]').val(),
            item_type_code: $('[name=item_type_code]').val(),
            item_code: $('[name=item_code]').val(),
            item_name: $('[name=item_name]').val(),
            item_uom_code: $('[name=item_uom_code]').val(),
            qty: $('[name=qty]').val()
        };
    }

})();
