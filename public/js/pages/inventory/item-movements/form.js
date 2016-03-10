
/* global form_utilities, baseUrl, mode, code, baseURL, sg_table_row_utilities, id, itemMovement */

(function () {

    let textfieldItemSourceTmpl, selectItemSourceTmpl;
    let ignoreFirstSupplierLoad = false;

    $(document).ready(function () {

        initializeTemplates();

        initializeUI();
        initializeForm();
        initializeEvents();

        //  ignore first supplier change if this is in edit mode
        ignoreFirstSupplierLoad = mode == 'edit';
        setItemSourceField();
    });

    function initializeTemplates() {
        textfieldItemSourceTmpl = _.template($('#textfield-item-source-template').html());
        selectItemSourceTmpl = _.template($('#select-item-source-template').html());
    }

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
        form_utilities.moduleUrl = baseUrl + "/inventory/item-movements";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeEvents() {
        $('[name=item_source_type]').change(function () {
            setItemSourceField();
        });

        $('[name=item_name]').change(function () {
            loadUnitCost();
        });

        $(document).on('change', 'select[name="item_source"],[name=item_source_type]', function () {
            if (!ignoreFirstSupplierLoad) {
                loadUnitCost();
            } else {
                console.log('ignored first supplier load');
                return;
            }

            ignoreFirstSupplierLoad = false;
        });
    }

    function setItemSourceField() {

        let sourceType = $('[name=item_source_type]').val();
        let tmpl = sourceType == "Supplier" ? selectItemSourceTmpl : textfieldItemSourceTmpl;

        $('#source-field-container').html(tmpl({value: itemMovement.item_source}));

        if (mode === 'view') {
            $('[name=item_source]').prop('disabled', true);
        }

    }

    function loadUnitCost() {
        let supplierNumber = $('select[name="item_source"]').val();
        let itemCode = $('[name=item_code]').val();

        if (supplierNumber && itemCode) {
            loadUnitCostRequest(supplierNumber, itemCode)
                    .done(unitCost => {
                        if (unitCost > 0) {
                            $('[name=unit_cost]').val(unitCost);
                        }
                    });
        }
    }

    function loadUnitCostRequest(supplierNumber, itemCode) {
        let url = baseUrl + '/master-files/suppliers/' + supplierNumber + '/item/' + itemCode + '/price';
        return $.get(url);
    }

})();
