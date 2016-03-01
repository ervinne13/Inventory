
(function () {

    let inventoryByLocationRowTemplate, inventoryStockCountRowTemplate;

    $(document).ready(function () {

        inventoryByLocationRowTemplate = _.template($('#inventory-by-location-row-template').html());
        inventoryStockCountRowTemplate = _.template($('#inventory-stock-count-row-template').html());

        initializeEvents();

    });

    function initializeEvents() {
        $('#location-select').change(function () {
            var locationCode = $(this).val();
            loadItems(locationCode);
        });

        $('#item-low-stock-location-select').change(function () {
            let locationCode = $(this).val();
            loadLowStockItems(locationCode);
        });

        $('#item-over-stock-location-select').change(function () {
            let locationCode = $(this).val();
            loadOverStockItems(locationCode);
        });

    }

    function loadItems(locationCode) {
        var url = baseUrl + "/master-files/items/location/" + locationCode;
        $.get(url, function (items) {
            console.log(items);

            var html = "";
            for (var i in items) {
                if (items[i].stock > 0) {
                    html += inventoryByLocationRowTemplate(items[i]);
                }
            }

            $('#inventory-by-location-table tbody').html(html);

        });
    }

    function loadLowStockItems(locationCode) {
        let url = baseUrl + "/master-files/items/low-stock/" + locationCode;
        $.get(url, function (items) {
            console.log(items);

            var html = "";
            for (var i in items) {
                items[i].requiredStock = items[i].threshold_low;
                html += inventoryStockCountRowTemplate(items[i]);
            }

            $('#low-stock-items-by-location-table tbody').html(html);
        });

    }

    function loadOverStockItems(locationCode) {
        let url = baseUrl + "/master-files/items/over-stock/" + locationCode;
        $.get(url, function (items) {
            console.log(items);

            var html = "";
            for (var i in items) {
                items[i].requiredStock = items[i].threshold_high;
                html += inventoryStockCountRowTemplate(items[i]);
            }

            $('#over-stock-items-by-location-table tbody').html(html);
        });

    }

})();
