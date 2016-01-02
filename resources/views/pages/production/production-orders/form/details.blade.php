<div class="col-lg-12">
    <div class="table-responsive">
        <table id="production-order-details-table" class="table table-hover">
            @if ($mode == "view")
            <thead>
                <tr>
                    <th class="small text-muted text-uppercase"><strong>Item Type</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Item Code</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Item Name</strong></th>
                    <th class="small text-muted text-uppercase"><strong>UOM</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Required QTY</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($bom->details AS $detail)
                <tr>
                    <td>{{$detail->itemType->name}}</td>
                    <td>{{$detail->item_code}}</td>
                    <td>{{$detail->item_name}}</td>
                    <td>{{$detail->itemUOM->name}}</td>
                    <td>{{$detail->qty}}</td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
    </div>
</div>