<?php $uses = ["form", "sg-table"] ?>

@extends('layouts.skarla')

@section('js')

@include('pages.security.acl.detail-table-templates')

<script type="text/javascript">
    var roleAccessControl = JSON.parse('{!! $role->accessControlList()->with("module")->with("accessControl")->get() !!}');
    var code = '{{$role->code}}';
    var mode = '{{$mode}}';
</script>

<script src="{{url("js/pages/security/acl/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">Access Control List <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">
                <div class="col-lg-6">

                    <h5>Role Information</h5>

                    <div class="form-group">
                        <label class="control-label" for="input-code">Code</label>
                        <input name="code" value="{{$role->code}}" id="input-code" required placeholder="Something unique to identify the role" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-name">Display Name</label>
                        <input name="name" value="{{$role->name}}" id="input-name" required placeholder="How should the system display this?" type="text" class="form-control">
                    </div>
                </div>

                <div class="col-lg-6">

                    <h5>Role Access Control</h5>                                       
                    <table id="role-access-table" class="table table-hover">
                        @if ($mode == "view")
                        <thead>
                            <tr>
                                <th class="small text-muted text-uppercase"><strong>Module</strong></th>
                                <th class="small text-muted text-uppercase"><strong>Access Control</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($role->accessControlList AS $access)
                            <tr>
                                <td>{{$access->module->name}}</td>
                                <td>{{$access->access_control_code}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>

                <div class="clearfix"></div>

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection