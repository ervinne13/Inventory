
/* global baseURL */

(function () {

    let inventoryByLocationRowTemplate, inventoryStockCountRowTemplate;

    $(document).ready(function () {

        inventoryByLocationRowTemplate = _.template($('#inventory-by-location-row-template').html());
        inventoryStockCountRowTemplate = _.template($('#inventory-stock-count-row-template').html());

        initializeUI();
        initializeEvents();

    });

    function initializeUI() {
        $('[name=report_date_from],[name=report_date_to]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: false,
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
    }

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

        $('#action-generate-report').click(function () {
            let report = $('#report-select').val();
            if (!report) {
                swal("Error", "Please select a report to generate", "error");
                return;
            }

            let dateFrom = $('[name=report_date_from]').val();
            let dateTo = $('[name=report_date_to]').val();

            generateReport(report, dateFrom, dateTo);

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

    function generateReport(report, from, to) {

        try {
            let url = getReportUrl(report, from, to);
//            window.open(url, "_blank");
            printUrl(url);
        } catch (e) {
            swal("Error", e.message, "error");
        }

    }

    function getReportUrl(report, from, to) {

        let url = baseURL;

        switch (report) {
            case "sales-report":
                url += "/report/sales";
                break;
            case "stocks-available-report":
                url += "/report/stocks-available";
                break;
            default:
                throw new Error("Invalid report " + report);
        }

        let params = {
            date_from: from,
            date_to: to
        };

        return url + "?" + $.param(params);

    }

    function printUrl(url) {

        $("<iframe>")
                .hide()
                .attr("src", url)
                .appendTo("body");

    }

})();
