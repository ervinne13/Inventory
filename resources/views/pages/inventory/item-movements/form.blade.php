<?php $uses     = ["form", "datepicker"] ?>

@extends('layouts.skarla')

@section('vendor-js')
<script src="{{url("js/item-set.js")}}"></script>
@endsection


@section('js')

<script type="text/javascript">
var id = '{{$itemMovement->id}}';
var mode = '{{$mode}}';
</script>

<script src="{{url("js/pages/inventory/item-movements/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Item Movement <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">

                <div class="col-lg-6">

                    <div class="form-group">
                        <label class="control-label" for="input-movement-date">Movement Date</label>
                        <input name="movement_date" value="{{$itemMovement->movement_date->format('m/d/Y H:i a')}}" id="input-movement-date" required type="text" class="form-control datepicker">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-ref-doc-type">Reference/Source Document Type</label>
                        <select name="ref_doc_type" id="input-ref-doc-type" required class="form-control select2-input">
                            @foreach($itemMovementSources AS $itemMovementSource)
                            <?php $selected = $itemMovement->ref_doc_type == $itemMovementSource->code ? "selected" : "" ?>
                            <option {{$selected}} value="{{$itemMovementSource->code}}">{{$itemMovementSource->name}}</option>
                            @endforeach
                        </select>
                    </div>                

                    <div class="form-group">
                        <label class="control-label" for="input-ref-doc-no">Reference/Source Document Number</label>
                        <input name="ref_doc_no" value="{{$itemMovement->ref_doc_no}}" id="input-ref-doc-no" required placeholder="(Ex. SI-00001) The document number of this movement's cause/source" type="text" class="form-control">
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
                            <?php $selected = $itemMovement->location_code == $location->code ? "selected" : "" ?>
                            <option {{$selected}} value="{{$location->code}}">{{$location->name}}</option>
                            @endforeach
                        </select>                      
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-status">Status</label>                        
                        <input name="status" value="{{$itemMovement->status}}" readonly id="input-status" type="text" class="form-control">
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="input-item-type">Item Type</label>                        
                        <select name="item_type" id="input-item-type"  data-source="item_type_code" class="form-control select2-input" required>
                            @foreach($itemTypes AS $itemType)
                            <?php $selected = $itemMovement->item_type_code == $itemType->code ? "selected" : "" ?>
                            <option {{$selected}} value="{{$itemType->code}}">{{$itemType->name}}</option>
                            @endforeach
                        </select>                      
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-item-name">Item Name</label>                        
                        <select name="item_name" id="input-item-name" data-source="item_name" class="form-control select2-input" required>
                            @if ($itemMovement->item_name)
                            <option selected value="{{$itemMovement->item_name}}">{{$itemMovement->item_name}}</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-item-code">Item Code</label>                        
                        <input name="item_code" value="{{$itemMovement->item_code}}"  data-source="item_code" readonly id="input-item-code" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-item-uom">Item UOM</label>                        
                        <select name="item_uom_code" id="input-item-uom" data-source="item_uom_code" class="form-control select2-input" required>
                            @if ($itemMovement->item_uom_code)
                            <option selected value="{{$itemMovement->itemUOM->code}}">{{$itemMovement->itemUOM->name}}</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6 p-l-0">
                        <div class="form-group">
                            <label class="control-label" for="input-qty">Item Qty</label>                        
                            <input name="qty" value="{{$itemMovement->qty}}" required id="input-qty" type="text" class="form-control" placeholder="How many items?">
                        </div>
                    </div>

                    <div class="col-md-6 p-r-0">
                        <div class="form-group">
                            <label class="control-label" for="input-unit-cost">Unit Cost</label>                        
                            <input name="unit_cost" value="{{$itemMovement->unit_cost}}" required id="input-unit-cost" type="text" class="form-control" placeholder="How much did each item cost?">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-remarks">Remarks</label>
                        <textarea name="remarks" id="input-remarks" class="form-control">{{$itemMovement->remarks}}</textarea>                         
                    </div>

                </div>

                <div class="col-lg-12">
                    <hr>
                </div>

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection