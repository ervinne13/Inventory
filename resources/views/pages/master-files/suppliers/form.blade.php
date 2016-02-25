<?php $uses     = ["form", "sg-table"] ?>

@extends('layouts.skarla')

@section('vendor-js')
    <script src="{{url("js/item-set.js")}}"></script>
@endsection

@section('js')

<?php $viewPath = "pages.master-files.suppliers"; ?>

@include("{$viewPath}.form.detail-form-template")

<script type="text/javascript">
    var moduleCode = '{{$moduleCode}}';
    var mode = '{{$mode}}';

    var supplierNumber = '{{$supplier->supplier_number}}';

    var details = {!! $supplier-> prices !!};
</script>

<script src="{{url("js/pages/master-files/suppliers/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Supplier <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">
                
                <h3>Supplier Information</h3>
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="input-supplier-number">Supplier Number</label>
                        <input name="supplier_number" value="{{$supplier->supplier_number}}" id="input-supplier-number" required placeholder="Auto generated supplier number" type="text" class="form-control" readonly>
                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label class="control-label" for="input-display-name">Display Name</label>
                        <input name="display_name" value="{{$supplier->display_name}}" id="input-display-name" required placeholder="The full name of the supplier" type="text" class="form-control">
                    </div>
                </div>

                <h3>Supplier Price List</h3>
                
                @include("{$viewPath}.form.details")

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection