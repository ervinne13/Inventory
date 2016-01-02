
<?php $uses = ["datatables"]; ?>

@extends('layouts.skarla')

@section('js')
<script src="{{url("js/pages/production/bom/index.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h4 class="m-b-0 ">Table of Bill of Materials</h4>
            </div>
            <div class="m-t-1 col-md-6  col-sm-6  col-xs-4 text-right">
                <a href="{{url("production/bom/create")}}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Create New
                </a>
            </div>
        </div>

        <div class="panel panel-default b-a-0 p-10 shadow-box">

            @include('module.datatable', [
            "id" => "bom-datatable",
            "columns" => ["", "Code", "Type", "Item", "UOM", "Qty"]
            ])

        </div>
    </div>
</div>

@endsection