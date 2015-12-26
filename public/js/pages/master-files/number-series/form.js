
/* global form_utilities, baseUrl, mode, code */

(function () {

    $(document).ready(function () {
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
        } else {
            form_utilities.disableFieldsOnViewMode(mode);
        }

        initializeUI();
        initializeForm();
    });

    function initializeUI() {
        form_utilities.initializeDefaultSelect2();
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true
        }, function (selectedDate, end, label) {
            console.log(selectedDate.format("YYYY-MM-DD"));
        });
    }

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/master-files/number-series";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

})();
