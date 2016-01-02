
<script id='detail-form-template' type="text/html">
    <form id="detail-row-row-form" class="row" role="form" class="container">

        <input type="hidden" name="bom_code">

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-item-type">Item Type</label>                        
                <select name="item_type" id="input-item-type"  data-source="item_type_code" class="form-control select2-input" required>
                    @foreach($itemTypes AS $itemType)
                    <?php $selected = $bom->item_type_code == $itemType->code ? "selected" : "" ?>
                    <option {{$selected}} value="{{$itemType->code}}">{{$itemType->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-name">Item Name</label>                        
                <select name="item_name" id="input-item-name" data-source="item_name" class="form-control select2-input" required>
                    @if ($bom->item_name)
                    <option selected value="{{$bom->item_name}}">{{$bom->item_name}}</option>
                    @endif
                </select>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-item-code">Item Code</label>                        
                <input name="item_code" value="{{$bom->item_code}}"  data-source="item_code" readonly id="input-item-code" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-uom">Item UOM</label>                        
                <select name="item_uom_code" id="input-item-uom" data-source="item_uom_code" class="form-control select2-input" required>
                    @if ($bom->item_uom_code)
                    <option selected value="{{$bom->itemUOM->code}}">{{$bom->itemUOM->name}}</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label class="control-label" for="input-qty">Item Qty</label>                        
                <input name="qty" value="{{$bom->qty}}" required id="input-qty" type="text" class="form-control" placeholder="How many items?">
            </div>
        </div>
    </form>
</script>
