<div class="col-lg-12">
    <div class="table-responsive">
        <table id="supplier-prices-table" class="table table-hover">
            @if ($mode == "view")
            <thead>
                <tr>                    
                    <th class="small text-muted text-uppercase"><strong>Item Type</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Item Code</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Item Name</strong></th>
                    <th class="small text-muted text-uppercase"><strong>Unit Cost</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplier->prices AS $detail)
                <tr>
                    <td>{{$detail->item_type_code}}</td>
                    <td>{{$detail->item_code}}</td>
                    <td>{{$detail->item_name}}</td>
                    <td>{{$detail->item_unit_cost}}</td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
    </div>
</div>