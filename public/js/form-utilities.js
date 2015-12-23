/* global globals, moment */

var form_utilities = {
    // constants
    SERVER_DATETIME_FORMAT: "YYYY-MM-DD HH:mm:ss",
    SERVER_DATE_FORMAT: "YYYY-MM-DD",
    SERVER_TIME_FORMAT: "HH:mm",
    DISPLAY_DATE_FORMAT: "dddd, MMMM DD YYYY",
    DISPLAY_TIME_FORMAT: "hh:mm a",
    // variables
    moduleUrl: "/",
    updateObjectId: 0,
    postValidate: false,
    // behavioral attribues
    validate: null,
    useIntegerForBooleanValues: false,
    // overridables
    errorHandler: null,
    successHandler: null,
    appendDataOnSave: null
};

form_utilities.disableFieldsOnViewMode = function (mode) {
    $('.form-control').prop('disabled', mode === "view");
    $('[type=checkbox]').prop('disabled', mode === "view");
};

form_utilities.formToJSON = function ($form) {

    var json = {};

    $($form.selector + ' :input').each(function () {
        var name = $(this).attr('name');
        var type = $(this).attr('type');
        var value = $(this).val();

        if (type == "checkbox") {
            value = $(this).is(':checked');

            if (form_utilities.useIntegerForBooleanValues) {
                value = value ? 1 : 0;
                console.log(name, value);
            }
        }

        if ($(this).data('autoNumeric')) {
            value = $(this).autoNumeric('get');
        }

        if ($(this).data('date-format')) {
            //  auto date processing requires momentjs
            if (moment) {
                value = moment(value, $(this).data('date-format'))
                        .format(form_utilities.SERVER_DATE_FORMAT);

                if (value == 'Invalid date') {
                    value = null;
                }
            } else {
                console.warn("Date formatting detected but momentjs is not included in the scripts!");
            }
        }

        if ($(this).data('time-format')) {
            //  auto date processing requires momentjs
            if (moment) {
                value = moment(value, $(this).data('time-format'))
                        .format(form_utilities.SERVER_TIME_FORMAT);

                if (value == 'Invalid date') {
                    value = null;
                }
            } else {
                console.warn("Date formatting detected but momentjs is not included in the scripts!");
            }
        }

        if (name && value !== undefined && value !== null) {
            json[name] = value;
        }
    });

    return json;
};

form_utilities.initializeDefaultTimePicker = function () {
    $('.timepicker').each(function () {
        var originalValue = $(this).val();

        if (originalValue) {
            var displayValue = moment(originalValue, form_utilities.SERVER_TIME_FORMAT)
                    .format(form_utilities.DISPLAY_TIME_FORMAT);
            $(this).val(displayValue);
        }

        $(this).bootstrapMaterialDatePicker({
            format: form_utilities.DISPLAY_TIME_FORMAT,
            clearButton: true,
            weekStart: 1,
            date: false,
            time: true
        });
    });
};

form_utilities.initializeDefaultDatePicker = function () {
    $('.datepicker').each(function () {

        var originalValue = $(this).val();

        if (originalValue) {
            var displayValue = moment(originalValue, form_utilities.SERVER_DATE_FORMAT)
                    .format(form_utilities.DISPLAY_DATE_FORMAT);
            $(this).val(displayValue);
        }

        $(this).bootstrapMaterialDatePicker({
            format: form_utilities.DISPLAY_DATE_FORMAT,
            clearButton: true,
            weekStart: 1,
            time: false
        });
    });

};

form_utilities.setFieldError = function (fieldName, errorMessage) {
    var errorLabelHtml = '<label id="' + fieldName + '-error" class="error" for="' + fieldName + '">' + errorMessage + '</label>';

    //  clear previous error
    $('#' + fieldName + '-error').remove();

    //  insert new error
    $('[name=' + fieldName + ']').parent().append(errorLabelHtml);
};

form_utilities.enableActionButtons = function (enable) {
    $('.action-button').prop('disabled', !enable);
};

form_utilities.initializeDefaultProcessing = function ($form, $detailSGTable) {

    if (!$form) {
        console.error("Form not defined");
        return;
    }

    $('.action-button').click(function () {

        var type = $(this).attr('id');

        if (type == "action-close") {
            window.location.href = form_utilities.moduleUrl;
            return;
        }

        var valid = true;
        //  validation 1
        if (form_utilities.validate) {
            valid = $form.valid();
        }

        //  validation 2
        if (valid && form_utilities.postValidate) {
            valid = form_utilities.postValidate();
        }

        if (valid) {
            var data = form_utilities.formToJSON($form);

            if ($detailSGTable) {
                data.details = JSON.stringify($detailSGTable.getModifiedData());
            }

            if (form_utilities.appendDataOnSave) {
                var newData = form_utilities.appendDataOnSave(data);

                for (var key in newData) {
                    data[key] = newData[key];
                }
            }

            console.log(data);

            try {
                form_utilities.process(type, data, function (success, message) {
                    //  process done, re enable buttons regardless of result
                    form_utilities.enableActionButtons(true);
                    if (success) {

                        if (form_utilities.successHandler) {
                            form_utilities.successHandler(message);
                        } else {
                            setTimeout(function () {
                                if (type == "action-create-new") {
                                    window.location.reload();
                                } else if (type == "action-create-close" || type == "action-update-close") {
                                    window.location.href = form_utilities.moduleUrl;
                                }
                            }, globals.reloadRedirectWaitTime);

                            if (form_utilities.onSaveMessage) {
                                swal("Success!", form_utilities.onSaveMessage, "success");
                            } else {
                                swal("Success!", "Saved!", "success");
                            }
                        }
                    } else {
                        console.error(message);

                        if (form_utilities.errorHandler) {
                            form_utilities.errorHandler(message);
                        } else {
                            swal("Error!", message, "error");
                        }
                    }
                });

                //  to avoid double processing, disable the buttons then re enable later
                form_utilities.enableActionButtons(false);

            } catch (e) {
                console.error(e);

                if (form_utilities.errorHandler) {
                    form_utilities.errorHandler(e);
                } else {
                    swal("Error!", e, "error");
                }

//                if (e.statusText) {
//                    swal("Error!", e.statusText, "error");
//                }
            }
        } else {
            console.error("Validation failed");

            swal("Error", "Some of the fields has errors. Please check.", "error");
        }

    });

};

form_utilities.process = function (type, data, callback) {

    console.log("Processing Data:", data);

    var url, method;
    if (type == "action-create-new" || type == "action-create-close") {
        url = form_utilities.moduleUrl;
        method = 'POST';
    } else if (type == "action-update-close") {
        url = form_utilities.moduleUrl + "/" + form_utilities.updateObjectId;
        method = 'PUT';
    }

    $.ajax({
        url: url,
        type: method,
        data: data,
//        dataType: 'json',
        success: function (response) {
            console.log(response);
            callback(true, response);
        },
        error: function (response) {
            callback(false, response.responseText);
        }
    });

};
