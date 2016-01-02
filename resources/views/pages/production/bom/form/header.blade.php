<div class="col-lg-6">

    <div class="form-group">
        <label class="control-label" for="input-code">Bill of Materials Code</label>                        
        <input name="code" value="{{$bom->code}}" readonly id="input-code" type="text" class="form-control" placeholder="A unique identifier for this bill of materials.">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-item-type">Produced Item Type</label>                        
        <select name="produced_item_type" id="input-item-type" data-source="item_type_code" class="form-control select2-input" required>
            @foreach($itemTypes AS $itemType)
            <?php $selected = $bom->produced_item_type == $itemType->code ? "selected" : "" ?>
            <option {{$selected}} value="{{$itemType->code}}">{{$itemType->name}}</option>
            @endforeach
        </select>                      
    </div>

    <div class="form-group">
        <label class="control-label" for="input-item-name">Produced Item Name</label>                        
        <select name="produced_item_name" id="input-item-name" data-source="item_name" class="form-control select2-input" required>
            @if ($bom->produced_item_name)
            <option selected value="{{$bom->produced_item_name}}">{{$bom->produced_item_name}}</option>
            @endif
        </select>
    </div>


</div>

<div class="col-lg-6">
    <div class="form-group">
        <label class="control-label" for="input-item-code">Produced Item Code</label>                        
        <input name="produced_item_code" value="{{$bom->produced_item_code}}" data-source="item_code" readonly id="input-item-code" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-item-uom">Produced Item UOM</label>                        
        <select name="produced_item_uom_code" id="input-item-uom" data-source="item_uom_code" class="form-control select2-input" required>
            @if ($bom->itemUOM)
            <option selected value="{{$bom->itemUOM->code}}">{{$bom->itemUOM->name}}</option>
            @endif
        </select>
    </div>

    <div class="form-group">
        <label class="control-label" for="input-qty">Produced Item Qty</label>                        
        <input name="produced_qty" value="{{$bom->produced_qty}}" required id="input-qty" type="text" class="form-control" placeholder="How many items will be produced when this runs on production?">
    </div>
</div>