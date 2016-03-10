Sales Breakdown

<table class="table">
    <thead>
        <tr>
            <th>Item Type</th>
            <th>Item Name</th>
            <th>Unit</th>
            <th>Total Qty Sold</th>
            <th class="text-right">Total Sales</th>
        </tr>
    </thead>
    <tbody>
        @foreach($soldItems AS $item)
        <tr>
            <td>{{$item->item_type_name}}</td>
            <td>{{$item->item_name}}</td>
            <td>{{$item->uom_name}}</td>
            <td>{{$item->total_qty}}</td>
            <td class="text-right">{{number_format($item->total_sales)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>