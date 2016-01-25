
/* global form_utilities, baseUrl, username, mode */

(function () {

    var updatePasswordTemplate;

    $(document).ready(function () {
        updatePasswordTemplate = _.template($('#update-password-template').html());
        
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
        } else {
            form_utilities.disableFieldsOnViewMode(mode);
        }

        initializeForm();
        initializeEvents();
    });

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/master-files/users";
        form_utilities.updateObjectId = username;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeEvents() {
        $('#action-change-password').click(function () {
            $('#change-password-container').html(updatePasswordTemplate());
        });
    }

})();
