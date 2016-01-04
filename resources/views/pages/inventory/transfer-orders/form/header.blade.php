<div class="col-lg-6">

    <div class="form-group">
        <label class="control-label" for="input-doc-no">Document Number</label>                        
        <input name="doc_no" value="{{$transferOrder->doc_no}}" readonly id="input-doc-no" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-doc-date">Document Date</label>
        <input name="doc_date" value="{{$transferOrder->doc_date->format('m/d/Y H:i a')}}" id="input-doc-date" required type="text" class="form-control datepicker">
    </div>                   

    <div class="form-group">
        <label class="control-label" for="input-status">Status</label>                        
        <input name="status" value="{{$transferOrder->status}}" readonly id="input-status" type="text" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="input-remarks">Remarks</label>
        <textarea name="remarks" id="input-remarks" class="form-control">{{$transferOrder->remarks}}</textarea>                         
    </div>


</div>

<div class="col-lg-6">

    <div class="form-group">
        <label class="control-label" for="input-origin-company-code">Origin Company</label>
        @if (count($companies) > 1)
        <select name="origin_company_code" id="input-origin-company-code" class="form-control" required>
            @foreach($companies AS $company)
            <option value="{{$company->code}}">{{$company->name}}</option>
            @endforeach
        </select>
        @else
        <input name="origin_company_code" value="{{$companies[0]->code}}" readonly id="input-origin-company-code" type="text" class="form-control">
        @endif
    </div>

    <div class="form-group">
        <label class="control-label" for="input-origin-location-code">Origin Location</label>                        
        <select name="origin_location_code" id="input-origin-location-code" class="form-control select2-input" required>
            @foreach($locations AS $location)
            <?php $selected = $transferOrder->origin_location_code == $location->code ? "selected" : "" ?>
            <option {{$selected}} value="{{$location->code}}">{{$location->name}}</option>
            @endforeach
        </select>                      
    </div>

    <div class="form-group">
        <label class="control-label" for="input-destination-company-code">Destination Company</label>
        @if (count($companies) > 1)
        <select name="destination_company_code" id="input-destination-company-code" class="form-control" required>
            @foreach($companies AS $company)
            <option value="{{$company->code}}">{{$company->name}}</option>
            @endforeach
        </select>
        @else
        <input name="destination_company_code" value="{{$companies[0]->code}}" readonly id="input-destination-company-code" type="text" class="form-control">
        @endif
    </div>

    <div class="form-group">
        <label class="control-label" for="input-destination-location-code">Destination Location</label>                        
        <select name="destination_location_code" id="input-destination-location-code" class="form-control select2-input" required>
            @foreach($locations AS $location)
            <?php $selected = $transferOrder->destination_location_code == $location->code ? "selected" : "" ?>
            <option {{$selected}} value="{{$location->code}}">{{$location->name}}</option>
            @endforeach
        </select>                      
    </div>

</div>