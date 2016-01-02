
<?php $uses = ["datatables"]; ?>

@extends('layouts.skarla')

@section('js')
<script src="{{url("js/pages/inventory/item-movements/index.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h4 class="m-b-0 ">Item Movement Tracking, Adjustment, & Management</h4>
            </div>
            <div class="m-t-1 col-md-6  col-sm-6  col-xs-4 text-right">
                <a href="{{url("inventory/item-movements/create")}}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Create New
                </a>
            </div>
        </div>

        <div class="panel panel-default b-a-0 p-10 shadow-box">

            @include('module.datatable', [
            "id" => "item-movements-datatable",
            "columns" => ["", "Status", "Movement Date", "Ref. Doc. Type", "Ref. Doc. No.", "Location", "Item", "Qty", "Unit Cost"]
            ])

        </div>
    </div>
</div>

@endsection