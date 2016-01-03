
/* global form_utilities, baseUrl, mode, code, baseURL, sg_table_row_utilities, details */

(function () {

    var fileList = [];
    var $UOMTable;

    $(document).ready(function () {
        initializeUI();
        initializeUOMTable();
        initializeForm();

        initializeDropzone();
    });

    function initializeUI() {
        if (mode !== "view") {
            form_utilities.setFieldsRequiredDisplay();
        } else {
            form_utilities.disableFieldsOnViewMode(mode);
        }

        form_utilities.initializeDefaultSelect2();

    }

    function initializeUOMTable() {
        $UOMTable = $('#table-item-uom-conversion').SGTable({
            dropdownRowTemplate: '#item-uom-row-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'uom_code',
            displayInlineActions: true,
            autoFocusField: 'number',
            highlighColor: '#F78B3E',
            closeRowActionIcon: '<i class="fa fa-chevron-up"></i>',
            openRowActionIcon: '<i class="fa fa-edit"></i>',
            deleteRowActionIcon: '<i class="fa fa-remove"></i>',
            enableDeleteRows: true,
            autoGenerateHeaderRow: true,
            headerColumnClass: "small text-muted text-uppercase",
            columns: {
                item_code: {label: "", hiddne: true},
                uom_code: {label: "UOM Code"},
                is_base_uom: {label: "Is Base UOM?", displayFormat: "boolean-yes-no"},
                base_uom_code: {label: "Base UOM Code"},
                base_uom_conv_multiplier: {label: "Multiplier", displayFormat: "integer"},
                base_uom_conv_divider: {label: "Divider", displayFormat: "integer"}
            }
        });

        $UOMTable.setData(details);
        $UOMTable.on('openRow', function (e, moduleCode) {
            initializeUOMForm();
            initializeUOMEvents();
        });
    }

    function initializeForm() {
        form_utilities.moduleUrl = baseUrl + "/master-files/items";
        form_utilities.updateObjectId = code;
        form_utilities.validate = true;
        form_utilities.appendDataOnSave = appendDataOnSave;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $UOMTable);
    }

    function initializeUOMForm() {
        form_utilities.initSwitchery('#input-is-base-uom', {color: '#2D99DC', jackColor: '#fff', secondaryColor: '#fff', jackSecondaryColor: '#fff'});

        enableBaseUOMFields(true);
    }

    function initializeUOMEvents() {
        $('[name=is_base_uom]').change(function () {
            var baseUOM = $(this).prop('checked');
            enableBaseUOMFields(!baseUOM);
        });

        sg_table_row_utilities.initializeDefaultEvents($UOMTable, $('#item-uom-row-form'), getOpenRowData);
    }

    function enableBaseUOMFields(enable) {

        $('[name=base_uom_code]').prop('disabled', !enable);
        $('[name=base_uom_conv_multiplier]').prop('disabled', !enable);
        $('[name=base_uom_conv_divider]').prop('disabled', !enable);

        if (enable) {
            $('[name=base_uom_conv_multiplier]').val(1);
            $('[name=base_uom_conv_divider]').val(1);
        } else {
            $('[name=base_uom_conv_multiplier]').val('');
            $('[name=base_uom_conv_divider]').val('');
        }

    }

    function getOpenRowData() {
        return {
            item_code: $('[name=code]').val(),
            uom_code: $('[name=uom_code]').val(),
            is_base_uom: $('[name=is_base_uom]').prop("checked") ? true : false,
            base_uom_code: $('[name=base_uom_code]').val(),
            base_uom_conv_multiplier: $('[name=base_uom_conv_multiplier]').val(),
            base_uom_conv_divider: $('[name=base_uom_conv_divider]').val()
        };
    }

    function appendDataOnSave(data) {

        data.images = fileList;

        return data;
    }

    function initializeDropzone() {

        Dropzone.autoDiscover = false;

        $("#dropzone").dropzone({
            url: "/files/upload",
            addRemoveLinks: true,
            maxFilesize: 5,
            dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
            dictResponseError: 'Error uploading file!',
            headers: {
                'X-CSRFToken': $('meta[name="_token"]').attr('content')
            },
            init: function () {

                var dropzone = this;
                if (code) {
                    //  if an item code is available (edit/view mode), query the image files of this item.
                    var url = baseURL + "/master-files/items/" + code + "/files";
                    $.get(url, function (files) {

                        for (var i in files) {

                            var fileName = files[i].name;
                            console.log(files[i]);
                            if (files[i].image_url.indexOf("uploads/") >= 0) {
                                fileName = files[i].image_url.substring(9);
                                console.log(fileName);
                            }

                            fileList.push({
                                server_filename: fileName,
                                filename: files[i].item_code
                            });

                            dropzone.options.addedfile.call(dropzone, files[i]);
                            dropzone.options.thumbnail.call(dropzone, files[i], "/" + files[i].image_url);
                        }

                    });
                }
            },
            success: function (image, response) {
                console.log(image);
                console.log(response);

                fileList.push({
                    server_filename: response,
                    filename: image.name
                });

            },
            removedfile: function (file) {
                var removedFile = null;

                for (var i in fileList) {
                    if (fileList[i].filename == file.name) {
                        removedFile = fileList[i].server_filename;
                        delete fileList[i];
                        break;
                    }
                }

                if (removedFile) {
                    var url = baseURL + "/files/remove";
                    var data = {file: removedFile};
                    $.post(url, data, function (response) {
                        console.log(response);
                    });
                }

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });

    }

})();
