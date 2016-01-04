<div class="col-lg-6">

    <div class="form-group">
        <label class="control-label" for="input-doc-no">Document Number</label>                        
        <input name="doc_no" value="{{$productionOrder->doc_no}}" readonly id="input-doc-no" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-doc-date">Movement Date</label>
        <input name="doc_date" value="{{$productionOrder->doc_date->format('m/d/Y H:i a')}}" id="input-doc-date" readonly type="text" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-company-code">Company</label>
        @if (count($companies) > 1)
        <select name="company_code" id="input-company-code" class="form-control" required>
            @foreach($companies AS $company)
            <option value="{{$company->code}}">{{$company->name}}</option>
            @endforeach
        </select>
        @else
        <input name="company_code" value="{{$companies[0]->code}}" readonly id="input-code" type="text" class="form-control">
        @endif
    </div>


    <div class="form-group">
        <label class="control-label" for="input-location-code">Location</label>                        
        <select name="location_code" id="input-location-code" class="form-control select2-input" required>
            @foreach($locations AS $location)
            <?php $selected = $productionOrder->location_code == $location->code ? "selected" : "" ?>
            <option {{$selected}} value="{{$location->code}}">{{$location->name}}</option>
            @endforeach
        </select>                      
    </div>

    <div class="form-group">
        <label class="control-label" for="input-bom-code">Bill of Materials</label>
        <small>Click on <i class="fa fa-refresh"></i> to recompute production cost.</small>
        <div class="input-group select2-bootstrap-append">
            <select name="bom_code" id="input-bom-code" class="form-control select1-allow-clear select2-input" required>
                @foreach($bomList AS $bom)
                <?php $selected = $productionOrder->bom_code == $bom->code ? "selected" : "" ?>
                <option {{$selected}} value="{{$bom->code}}">{{$bom->code}} ({{$bom->produced_item_name}}: {{$bom->produced_qty}} {{$bom->itemUOM->name}})</option>
                @endforeach
            </select>      
            <span class="input-group-btn">
                <button id="action-refresh-details" class="btn btn-default" type="button" data-select2-open="input-bom-code" style="height: 33px;">
                    <span class="fa fa-refresh"></span>
                </button>
            </span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="input-qty-to-produce">Qty to Produce</label>        
        <input name="qty_to_produce" value="{{$productionOrder->qty_to_produce}}" required id="input-qty-to-produce" type="text" class="form-control autonumeric">
    </div>

</div>

<div class="col-lg-6">

    <div class="form-group">
        <label class="control-label" for="input-total-computed-cost">Total Computed Cost</label>                        
        <input name="total_computed_cost" value="{{$productionOrder->total_computed_cost}}" required readonly id="input-total-computed-cost" type="text" class="form-control autonumeric">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-total-actual-cost">Total Actual Cost</label>                        
        <input name="total_actual_cost" value="{{$productionOrder->total_actual_cost}}" required readonly id="input-total-actual-cost" type="text" class="form-control autonumeric">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-remarks">Remarks</label>
        <textarea name="remarks"  id="input-remarks" type="text" class="form-control">{{$productionOrder->remarks}}</textarea>        
    </div>

    @include('module.status')

</div>