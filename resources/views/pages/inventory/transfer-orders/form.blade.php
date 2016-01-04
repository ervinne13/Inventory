<?php $uses = ["form", "datepicker", "sg-table"] ?>

@extends('layouts.skarla')

@section('vendor-js')
<script src="{{url("js/item-set.js")}}"></script>
@endsection


@section('js')

@include('pages.inventory.transfer-orders.form.detail-form-template')

<script type="text/javascript">
var docNo = '{{$transferOrder->doc_no}}';
var mode = '{{$mode}}';
var details = JSON.parse('{!! $transferOrder->details !!}');
</script>

<script src="{{url("js/pages/inventory/transfer-orders/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Transfer Order <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">

                @include("pages.inventory.transfer-orders.form.header")

                <div class="col-lg-12">
                    <hr>
                </div>

                <div class="col-lg-12">
                    <h3 class="m-t-0 m-b-2">Details / Items to Transfer</h3>
                </div>

                @include('pages.inventory.transfer-orders.form.details')

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection