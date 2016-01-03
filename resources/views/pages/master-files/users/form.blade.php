<?php $uses     = ["form"] ?>

@extends('layouts.skarla')

@section('js')

@include('pages.master-files.users.update-password-template')

<script type="text/javascript">
    var username = '{{$user->username}}';
    var mode = '{{$mode}}';
</script>

<script src="{{url("js/pages/master-files/users/form.js")}}"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="row m-b-2">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <h4 class="m-b-0 ">User <small>{{$mode}}</small></h4>
            </div>           
        </div>        
        <div class="panel panel-default b-a-0 p-10 shadow-box">            
            <form class="fields-container">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="input-username">Username</label>
                        <input name="username" value="{{$user->username}}" id="input-username" required placeholder="Something unique to identify yourself" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="input-display-name">Display Name</label>
                        <input name="display_name" value="{{$user->display_name}}" id="input-display-name" required placeholder="How should the system call you?" type="text" class="form-control">
                    </div>

                    @if($mode === "create")
                    <div class="form-group">
                        <label for="input-password" class="control-label">Password</label>
                        <input name="password" type="password" id="input-password" required class="form-control" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label for="input-password-repeat" class="control-label">Repeat Password</label>
                        <input name="password_repeat" type="password" id="input-password-repeat" required class="form-control" placeholder="Make sure your passwords match">
                    </div>
                    @elseif($mode === "edit")            

                    <div id="change-password-container">
                        <button type="button" id="action-change-password" class="btn btn-link" >Change Password</button>
                    </div>                   

                    @endif

                </div>

                <div class="col-lg-6">

                    <div class="form-group">
                        <label for="input-roles" class="control-label">Role(s)</label>
                        <select name="roles" multiple id="input-roles" required class="form-control h-130">
                            @foreach($roles AS $role)
                            <?php $selected = $user->hasRole($role->code) ? "selected" : "" ?>
                            <option {{$selected}} value="{{$role->code}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-locations" class="control-label">Location(s)</label>
                        <select name="locations" multiple id="input-locations" required class="form-control h-130">
                            @foreach($locations AS $location)
                            <?php $selected = $user->hasLocation($location->code) ? "selected" : "" ?>
                            <option {{$selected}} value="{{$location->code}}">{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                @include('module.form-actions')

                <div class="clearfix"></div>

            </form>
        </div>
    </div>
</div>

@endsection