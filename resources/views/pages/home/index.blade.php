@extends('layouts.skarla')

@section('js')
<script id="inventory-by-location-row-template" type="text/html">
    <tr class="inventory-by-location-row">
        <td><%= item.name %></td>
        <td><%= item_uom_code %></td>
        <td><%= stock %></td>
    </tr>
</script>

<script id="inventory-stock-count-row-template" type="text/html">
    <tr class="inventory-by-location-row">
        <td><%= name %></td>
        <td><%= requiredStock %></td>
        <td>
            <b class="text-danger"><%= stock %></b>
        </td>
    </tr>
</script>

<script src="{{url("vendor/underscore/underscore.js")}}"></script>
<script src="{{url("js/pages/home.js")}}"></script>
@endsection

@section('content')


<h4>Reports</h4>

<div class="row">

    <div class="col-md-6 col-sm-6">
        @include("pages.home.widgets.low-stock-items")
    </div>

    <div class="col-md-6 col-sm-6">
        @include("pages.home.widgets.over-stock-items")
    </div>

    <div class="col-md-6 col-sm-6">
        @include("pages.home.widgets.inventory-locations")
    </div>

</div>

@endsection
