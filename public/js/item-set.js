
/* global baseURL */

/**
 * TODO:
 *  Centralize pagination size
 *  Make ajax based select initialization funtions shorter
 * @returns {ItemSet}
 */
function ItemSet() {
    this.requiredFields = {
        item_type_code: null,
        item_name: null,
        item_code: null
    };

    this.autoUpdatingFields = [
        {field: "code", alias: "item_code"},
    ];

    //  special fields
    this.itemUOMFieldSource = 'item_uom_code';
    this.$itemUOM;

    this.$container;

}

(function (proto) {

    proto.loadSetInContainer = function ($container) {
        this.$container = $container;

        for (var key in this.requiredFields) {
            var $field = $($container).find('[data-source=' + key + ']');
            if (!$field) {
                console.error(key + " field is required to activate item set.");
                return;
            } else {
                this.requiredFields[key] = $field;
            }
        }

        this.initializeEvents();
        this.initializeItemNameField();

        //  special fields
        if ($($container).find('[data-source=' + this.itemUOMFieldSource + ']').length > 0) {
            this.$itemUOM = this.initializeItemUOMField($($container).find('[data-source=' + this.itemUOMFieldSource + ']'));
        }

    };

    proto.initializeEvents = function () {

        var _this = this;
        var $itemTypeCode = this.requiredFields["item_type_code"];
        var $itemName = this.requiredFields["item_name"];

        //  Item Type Code
        $itemTypeCode.on("change", function () {
            $itemName.val('').trigger("change");
        });

        //  Item Name

        var fields = this.autoUpdatingFields;
        $itemName.on("change", function () {
//            console.log($itemName.select2('data'));

            if ($itemName.select2('data').length <= 0) {
                return;
            }

            var selectedItem = $itemName.select2('data')[0];

            //  process auto update fields
            for (var i in fields) {
//                $('[data-source=' + fields[i].alias + ']').val(selectedItem[fields[i].field]);
                _this.$container.find('[data-source=' + fields[i].alias + ']').val(selectedItem[fields[i].field]);
            }

            //  process special fields
            if (_this.$itemUOM) {
                _this.$itemUOM.val('').trigger('change');
            }

        });
    };

    proto.initializeItemNameField = function () {
        var _this = this;
        this.requiredFields["item_name"].select2({
            theme: "bootstrap",
            ajax: {
                url: baseURL + "/api/master-files/items",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        itemType: _this.requiredFields["item_type_code"].val(),
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    var select2Data = [];
                    for (var i in data.data) {
                        data.data[i].id = data.data[i].name;
                        data.data[i].text = data.data[i].name;
                        select2Data.push(data.data[i]);
                    }

                    return {
                        results: select2Data,
                        pagination: {
                            more: (params.page * 15) < data.total
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work            
//            templateResult: formatRepo, // omitted for brevity, see the source of this page
//            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
    };

    proto.initializeItemUOMField = function ($itemUOMField) {
        var _this = this;
        return $itemUOMField.select2({
            theme: "bootstrap",
            ajax: {
                url: baseURL + "/api/master-files/itemUOMList",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        itemCode: _this.requiredFields["item_code"].val(),
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    var select2Data = [];
                    for (var i in data.data) {
                        data.data[i].id = data.data[i].uom.code;
                        data.data[i].text = data.data[i].uom.name;
                        select2Data.push(data.data[i]);
                    }

//                    console.log(select2Data);

                    return {
                        results: select2Data,
                        pagination: {
                            more: (params.page * 15) < data.total
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    };

})(ItemSet.prototype);

