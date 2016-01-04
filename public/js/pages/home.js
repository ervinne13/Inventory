
(function () {

    var inventoryByLocationRowTemplate;

    $(document).ready(function () {

        inventoryByLocationRowTemplate = _.template($('#inventory-by-location-row-template').html());

        initializeEvents();

    });

    function initializeEvents() {
        $('#location-select').change(function () {
            var locationCode = $(this).val();
            loadItems(locationCode);
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

})();
