<?php $uses = ["form", "sg-table"] ?>

@extends('layouts.skarla')

@section('vendor-js')
<script src="{{url("js/item-set.js")}}"></script>
@endsection


@section('js')

@include('pages.production.production-orders.form.detail-form-template')
@include('pages.production.production-orders.form.out-of-stock-table-template')

<script type="text/javascript">
var docNo = '{{$productionOrder->doc_no}}';
var mode = '{{$mode}}';
var status = '{{$productionOrder->status}}';
var details = JSON.parse('{!! $productionOrder->details !!}');
</script>

<script src="{{url("js/pages/production/production-orders/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Production Order <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">

                <div class="col-lg-12">
                    <h3 class="m-t-0 m-b-2">Header</h3>
                </div>

                @include('pages.production.production-orders.form.header')

                <div class="col-lg-12"><hr></div>

                <div class="col-lg-12">
                    <h3 class="m-t-0 m-b-2">Details / Production Cost</h3>
                </div>

                @include('pages.production.production-orders.form.details')

                <div id="out-of-stock-table-container" class="col-lg-12">

                </div>

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection