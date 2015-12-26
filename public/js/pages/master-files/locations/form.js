
/* global form_utilities, baseUrl, mode, code */

(function () {

    $(document).ready(function () {
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
        } else {
            form_utilities.disableFieldsOnViewMode(mode);
        }

        initializeForm();
    });

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/master-files/locations";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

})();
