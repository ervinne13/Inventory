
<?php $uses = ["datatables"]; ?>

@extends('layouts.skarla')

@section('js')
@include("module.module-js-info")
<script src="{{url("js/pages/master-files/items/index.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Items</h4>
            </div>
            <div class=" m-t-1 col-md-4  col-sm-4  col-xs-4 col-xs-offset-4 col-sm-offset-4 col-md-offset-4 text-right">
                <a href="{{url("master-files/items/create")}}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Create New
                </a>
            </div>
        </div>

        <div class="panel panel-default b-a-0 p-10 shadow-box">

            @include('module.datatable', [
            "id" => "items-datatable",
            "columns" => ["", "Type", "Code", "Name", "Default Currency", "Default Unit Cost"]
            ])

        </div>
    </div>
</div>

@endsection