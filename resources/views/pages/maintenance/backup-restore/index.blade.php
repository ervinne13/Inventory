
<?php $uses = ["datatables"]; ?>

@extends('layouts.skarla')

@section('js')
@include("module.module-js-info")

<script type="text/html">

</script>

<script src="{{url("js/pages/maintenance/backup-restore/index.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h4 class="m-b-0">Backup And Restore</h4>
            </div>
            <div class="m-t-1 col-md-6  col-sm-6  col-xs-4 text-right">
                <button id="action-backup" class="btn btn-sm btn-success">
                    <i class="fa fa-hdd-o"></i> Backup Now
                </button>
            </div>
        </div>

        <div class="panel panel-default b-a-0 p-10 shadow-box">

            @include('module.datatable', [
            "id" => "backup-datatable",
            "columns" => ["", "Backup Date", "Backup File"]
            ])

        </div>
    </div>
</div>

@endsection