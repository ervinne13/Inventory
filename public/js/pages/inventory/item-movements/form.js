
/* global form_utilities, baseUrl, mode, code, baseURL, sg_table_row_utilities */

(function () {

    $(document).ready(function () {
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
        form_utilities.moduleUrl = baseUrl + "/inventory/item-movements";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }
})();
