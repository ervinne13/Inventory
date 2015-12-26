<?php $uses = ["form", "datepicker"] ?>

@extends('layouts.skarla')

@section('js')

<script type="text/javascript">
    var code = '{{$numberSeries->code}}';
    var mode = '{{$mode}}';
</script>

<script src="{{url("js/pages/master-files/number-series/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Location <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="input-module-code">Module</label>                    
                        <select name="module_code" id="input-module-code" class="form-control select2-input" required>
                            @foreach($modules AS $module)
                            <option value="{{$module->code}}">{{$module->name}}</option>
                            @endforeach
                        </select>                    
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-effective-date">Effective Date</label>
                        <input name="effective_date" value="{{$numberSeries->effective_date->format('m/d/Y')}}" id="input-effective-date" required type="text" class="form-control datepicker">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-code">Code</label>
                        <input name="code" value="{{$numberSeries->code}}" id="input-code" required placeholder="Ex. IM-2017 - Use the convention <module code>-<year>" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-starting-number">Starting Number</label>
                        <input name="starting_number" value="{{$numberSeries->starting_number}}" id="input-starting-number" required placeholder="Ex. 0" type="number" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-ending-number">Ending Number</label>
                        <input name="ending_number" value="{{$numberSeries->ending_number}}" id="input-ending-number" required placeholder="Ex. 99999 - Recommended: 5 digits" type="number" class="form-control">
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="input-last-number-used">Last Number Used</label>
                        <input name="last_number_used" value="{{$numberSeries->last_number_used}}" id="input-last-number-used" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-last-date-used">Last Date Used</label>
                        <input name="last_date_used" disabled value="{{$numberSeries->last_date_used}}" id="input-last-date-used" type="text" class="form-control">
                    </div>
                </div>

                <div class="clearfix"></div>

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection