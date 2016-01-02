<script id="out-of-stock-table-template" type="text/html">

    <h4 class="text-danger">Required Items Out of Stock / Not Enough Stocks</h4>

    <table id="out-of-stock-table" class="table table-hover">
        <thead>
            <tr>
                <th class="small text-muted text-uppercase">
                    <strong>Item Code</strong>
                </th>
                <th class="small text-muted text-uppercase">
                    <strong>Item Name</strong>
                </th>
                <th class="small text-muted text-uppercase">
                    <strong>Remaining Qty</strong>
                </th>
                <th class="small text-muted text-uppercase">
                    <strong>Required Qty</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <% _.each(out_of_stock, function(item) { %>
            <tr>
                <td><%= item.item_code %></td>
                <td><%= item.item_name %></td>
                <td><%= item.stocks_remaining %></td>
                <td><%= item.stocks_required %></td>
            </tr>
            <% });%>
        </tbody>
    </table>

</script>