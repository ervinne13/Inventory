
<script id='detail-form-template' type="text/html">
    <form id="detail-row-row-form" class="row" role="form" class="container">

        <input type="hidden" name="doc_no" value="{{$productionOrder->doc_no}}">
        <input type="hidden" name="line_no">

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="input-item-type-code">Item Type</label>                        
                <input name="item_type_code" data-source="item_type_code" readonly id="input-item-type-code" type="text" class="form-control">                
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-name">Item Name</label>                                       
                <input name="item_name" data-source="item_code" readonly id="input-item-name" type="text" class="form-control">                
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-code">Item Code</label>                        
                <input name="item_code" data-source="item_code" readonly id="input-item-code" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-uom">Item UOM</label>                        
                <input name="item_uom_code" data-source="item_uom_code" readonly id="input-item-uom" type="text" class="form-control">                
            </div>

        </div>
        <div class="col-md-6">          
            <div class="form-group">
                <label class="control-label" for="input-qty">Item Qty</label>                        
                <input name="qty_consumed" readonly id="input-qty" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label" for="input-item-unit-cost">Unit Cost</label>                        
                <input name="item_unit_cost" readonly id="input-item-unit-cost" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label" for="input-computed-incurred-cost">Computed Cost</label>                        
                <input name="computed_incurred_cost" readonly id="input-computed-incurred-cost" type="text" class="form-control">
            </div>

            <div class="form-group">
                <label class="control-label" for="input-actual-incurred-cost">Actual Incurred Cost</label>                        
                <input name="actual_incurred_cost" required id="input-actual-incurred-cost" type="text" class="form-control" placeholder="How much did the production actually cost regarding this item?">
            </div>
        </div>
    </form>
</script>
