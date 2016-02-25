
<script id='detail-form-template' type="text/html">
    <form id="detail-row-row-form" class="row" role="form" class="container">

        <input type="hidden" name="supplier_number" value="{{$supplier->supplier_number}}">       

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-item-type">Item Type</label>                        
                <select name="item_type_code" id="input-item-type" data-source="item_type_code" class="form-control select2-input" required>
                    @foreach($itemTypes AS $itemType)                    
                    <option value="{{$itemType->code}}">{{$itemType->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-name">Item Name</label>                        
                <select name="item_name" id="input-item-name" data-source="item_name" class="form-control select2-input" required>
                </select>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-item-code">Item Code</label>                        
                <input name="item_code" data-source="item_code" readonly id="input-item-code" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-unit-cost">Unit Cost</label>                        
                <input name="item_unit_cost" id="input-item-unit-cost" type="text" class="form-control">
            </div>
        </div>
    </form>
</script>
