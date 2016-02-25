<?php $uses = ["form"] ?>

@extends('layouts.skarla')

@section('js')

<script type="text/javascript">
    var mode = '{{$mode}}';
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
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="input-supplier-number">Supplier Number</label>
                        <input name="supplier_number" value="{{$supplier->supplier_number}}" id="input-supplier-number" required placeholder="Something unique to identify yourself" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-display-name">Display Name</label>
                        <input name="display_name" value="{{$supplier->display_name}}" id="input-display-name" required placeholder="How should the system call you?" type="text" class="form-control">
                    </div>

                </div>

                <div class="col-lg-6">

                    TODO: Prices Table Here

                </div>

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection