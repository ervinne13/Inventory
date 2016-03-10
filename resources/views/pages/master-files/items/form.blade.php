<?php $uses     = ["form", "sg-table"] ?>

@extends('layouts.skarla')

@section('vendor-css')
<link href="{{ asset("/vendor/dropzone/dropzone.css")}}" rel="stylesheet" type="text/css" />
@endsection

@section('vendor-js')
<script src="{{ asset ("/vendor/dropzone/dropzone.js") }}" type="text/javascript"></script>
@endsection

@section('js')

@include("pages.master-files.items.item-uom-row-template")

<script type="text/javascript">
var code = '{{$item->code}}';
var mode = '{{$mode}}';
var details = JSON.parse('{!! $item->UOMList !!}');
</script>

<script src="{{url("js/pages/master-files/items/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Item <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            

            <h4>Item Header Data</h4>

            <div class="col-lg-6">
                <form class="fields-container">
                    <div class="form-group">
                        <label class="control-label" for="input-item-type-code">Item Type</label>
                        <select name="item_type_code" id="input-item-type-code" required class="form-control select2-input">
                            @foreach($itemTypes AS $itemType)
                            <?php $selected = $item->item_type_code == $itemType->code ? "selected" : "" ?>
                            <option {{$selected}} value="{{$itemType->code}}">{{$itemType->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="input-code">Code</label>
                        <input name="code" value="{{$item->code}}" id="input-code" required placeholder="Ex. PROD_ZGUN (Product - Z-GUN) - Something unique to identify the item" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-name">Name</label>
                        <input name="name" value="{{$item->name}}" id="input-name" required placeholder="How should the system display this?" type="text" class="form-control">
                    </div>

                    <!--                    <div class="form-group">
                                            <label class="control-label" for="input-currency">Default currency</label>
                                            <select name="default_currency_code" id="input-currency" class="form-control select2-input">
                                                <option disabled selected>-- Select Currency --</option>
                                                @foreach($currencies AS $currency)
                    <?php $selected = $item->default_currency_code == $currency->code ? "selected" : "" ?>
                                                <option {{$selected}} value="{{$currency->code}}">{{$currency->name}}</option>
                                                @endforeach
                                            </select>                        
                                        </div>-->

                    <div class="form-group">
                        <label class="control-label" for="input-currency">Default currency</label>
                        <input name="default_currency_code" value="PHP" id="input-currency" readonly class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-unit-cost">Default Unit Cost</label>
                        <input name="default_unit_cost" required value="{{$item->default_unit_cost}}" id="input-unit-cost" placeholder="Usually used for services, and other non inventoriables." type="number" class="form-control">
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="input-threshold-low">Low Threshold (Maintaining Stock)</label>
                        <input name="threshold_low" required value="{{$item->threshold_low}}" id="input-threshold-low" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-threshold-high">High Threshold (Over Stock)</label>
                        <input name="threshold_high" required value="{{$item->threshold_high}}" id="input-threshold-high" class="form-control">
                    </div>


                </form>
            </div>

            <div class="col-lg-6">
                <form id="dropzone" action="{{url("files/upload")}}" class="dropzone">
                </form>
            </div>

            <div class="col-lg-12">
                <hr>
            </div>

            <div class="col-lg-12">
                <h4>Item Units Of Measurement and Conversion</h4>
                <div class="table-responsive">
                    <table id="table-item-uom-conversion" class="table table-hover"></table>
                </div>
            </div>

            <div class="clearfix"></div>

            @include('module.form-actions')

            <div class="clearfix"></div>

        </div>
    </div>
</div>

@endsection