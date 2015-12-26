
/* global form_utilities, baseUrl, mode, code */

(function () {

    $(document).ready(function () {
        form_utilities.disableFieldsOnViewMode(mode);
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
        }

        initializeForm();
    });

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/security/roles";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

})();
