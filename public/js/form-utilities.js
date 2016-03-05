/* global moment, SGFormatter */

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
    errorMessageDisplayed: false,
    postValidate: false,
    // behavioral attribues
    useFullDetailsData: false,
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
                        .format(SGFormatter.SERVER_DATE_FORMAT);

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
                        .format(SGFormatter.SERVER_TIME_FORMAT);

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

form_utilities.initSwitchery = function (selector, settings) {
    var switches = document.querySelectorAll(selector);
    var switchesIter = Array.prototype.slice.call(switches);
    switchesIter.forEach(function (switcher) {
        new Switchery(switcher, settings);
    });
};

form_utilities.initializeDefaultSelect2 = function () {
    if ($('.select2-input').length === 0) {
        return;
    }

    $('.select2-input').on("select2:open", function () {
        if ($(this).parents("[class*='has-']").length) {
            var classNames = $(this).parents("[class*='has-']")[ 0 ].className.split(/\s+/);

            for (var i = 0; i < classNames.length; ++i) {
                if (classNames[ i ].match("has-")) {
                    $("body > .select2-container").addClass(classNames[ i ]);
                }
            }
        }
    }).select2({
        theme: "bootstrap"
    });
};

form_utilities.initializeDefaultTimePicker = function () {
    $('.timepicker').each(function () {
        var originalValue = $(this).val();

        if (originalValue) {
            var displayValue = moment(originalValue, SGFormatter.SERVER_TIME_FORMAT)
                    .format(SGFormatter.DISPLAY_TIME_FORMAT);
            $(this).val(displayValue);
        }

        $(this).bootstrapMaterialDatePicker({
            format: SGFormatter.DISPLAY_TIME_FORMAT,
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
            var displayValue = moment(originalValue, SGFormatter.SERVER_DATE_FORMAT)
                    .format(SGFormatter.DISPLAY_DATE_FORMAT);
            $(this).val(displayValue);
        }

        $(this).bootstrapMaterialDatePicker({
            format: SGFormatter.DISPLAY_DATE_FORMAT,
            clearButton: true,
            weekStart: 1,
            time: false
        });
    });

};

form_utilities.setFieldsRequiredDisplay = function () {
    $('.form-control').each(function () {
        if ($(this).prop("required")) {
            var id = $(this).attr('id');
            var originalText = $('[for=' + id + ']').html();
            $('[for=' + id + ']').html(originalText + ' <span class="text-danger">*</span>');
        }

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

            if ($detailSGTable && form_utilities.useFullDetailsData) {
                data.details = JSON.stringify($detailSGTable.getFullData());
            } else if ($detailSGTable) {
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
                            if (form_utilities.onSaveMessage) {
                                swal("Success!", form_utilities.onSaveMessage, "success");
                            } else {
                                swal("Success!", "Saved!", "success");
                            }

                            setTimeout(function () {
                                if (type == "action-create-new") {
                                    window.location.reload();
                                } else {
                                    window.location.href = form_utilities.moduleUrl;
                                }
                            }, 1500);
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

            if (!form_utilities.errorMessageDisplayed) {
                swal("Error", "Some of the fields has errors. Please check.", "error");
            }
        }

    });

};

form_utilities.process = function (type, data, callback) {

    var url, method;
    if (type == "action-create-new" || type == "action-create-close") {
        url = form_utilities.moduleUrl;
        method = 'POST';
    } else if (type == "action-update-close") {
        url = form_utilities.moduleUrl + "/" + form_utilities.updateObjectId;
        method = 'PUT';
    } else if (type == "action-update-post" || type == "action-create-post") {
        url = form_utilities.moduleUrl + "/post/" + (form_utilities.updateObjectId ? form_utilities.updateObjectId : false);
        method = 'POST';
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
