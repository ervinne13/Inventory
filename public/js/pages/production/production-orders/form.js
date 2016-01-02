
/* global form_utilities, baseUrl, mode, code, details, sg_table_row_utilities, baseURL */

(function () {

    var outOfStockTableTemplate;
    var $detailsTable;

    $(document).ready(function () {
        //  initializeTemplates
        outOfStockTableTemplate = _.template($('#out-of-stock-table-template').html());

        form_utilities.disableFieldsOnViewMode(mode);
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
            initializeDetailsTable();
            initializeUI();
            initializeForm();
            initializeEvents();
        }
    });

    function initializeUI() {
        form_utilities.initializeDefaultSelect2();

        var itemSet = new ItemSet();
        itemSet.loadSetInContainer($('.fields-container'));
    }

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/production/production-orders";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }

    function initializeEvents() {
        $('#action-refresh-details').click(function () {
            refreshProductionCostDetails();
        });
    }

    function initializeDetailsTable() {
        $detailsTable = $('#production-order-details-table').SGTable({
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
                item_unit_cost: {label: "Unit Cost"},
                qty_consumed: {label: "Qty Consumed"},
                computed_incurred_cost: {label: "Computed Cost"},
                actual_incurred_cost: {label: "Actual Cost"},
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

        $('#production-order-details-table tfoot').html("");
    }

    function initializeDetailForm() {
//        form_utilities.initializeDefaultSelect2();
    }

    function initializeDetailEvents() {
        sg_table_row_utilities.initializeDefaultEvents($detailsTable, $('#detail-row-row-form'), getOpenRowData, recomputeTotals);
    }

    function getOpenRowData() {
        return {
            line_no: $('[name=line_no]').val(),
            doc_no: $('[name=doc_no]').val(),
            item_type_code: $('[name=item_type]').val(),
            item_code: $('[name=item_code]').val(),
            item_name: $('[name=item_name]').val(),
            item_uom_code: $('[name=item_uom_code]').val(),
            item_unit_cost: $('[name=item_unit_cost]').val(),
            qty_consumed: $('[name=qty_consumed]').val(),
            computed_incurred_cost: $('[name=computed_incurred_cost]').val(),
            actual_incurred_cost: $('[name=actual_incurred_cost]').val()
        };
    }

    function recomputeTotals() {
        var details = $detailsTable.getFullData();
        var totalCost = 0;
        var totalActualCost = 0;

        for (var i in details) {
            totalCost += details[i].computed_incurred_cost;
            totalActualCost += details[i].actual_incurred_cost;
        }

        $('[name=total_computed_cost]').val(totalCost);
        $('[name=total_actual_cost]').val(totalActualCost);
        
        $('.production-order-details-table-action-delete-row').remove();
    }

    function refreshProductionCostDetails() {

        var BOMCode = $('[name=bom_code]').val();
        var qtyToProduce = $('[name=qty_to_produce]').val();
        var company = $('[name=company_code]').val();
        var location = $('[name=location_code]').val();

        showOutOfStockTable(false);

        if (BOMCode && qtyToProduce) {

            var url = baseURL + "/production/production-orders/production-details";
            var params = {
                BOMCode: BOMCode,
                company_code: company,
                location_code: location,
                qty_to_produce: qtyToProduce
            };

            $.get(url, params, function (details) {
                console.log(details);

                setDetailsTableDataFromProductionDetails(details);
                showOutOfStockTable(details);
            });
        } else {
            swal("Error", "Bill of Materials and Qty to Produce is required", "error");
        }

    }

    function setDetailsTableDataFromProductionDetails(productionCostDetails) {

        if (productionCostDetails && productionCostDetails.production_order_details) {
            $detailsTable.setData(productionCostDetails.production_order_details);

            //  remove delete action
            $('.production-order-details-table-action-delete-row').remove();
        }

    }

    function showOutOfStockTable(productionCostDetails) {

        if (productionCostDetails && productionCostDetails.out_of_stock.length > 0) {
            var html = outOfStockTableTemplate(productionCostDetails);
            $('#out-of-stock-table-container').html(html);
        } else {
            $('#out-of-stock-table-container').html("");
        }
    }

})();
