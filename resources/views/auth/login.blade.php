@extends('layouts.skarla')

@section('content')
<div class="container-fluid">
    <a class="btn btn-default m-t-2 m-b-1 action-navigate-back" href="{{url("/")}}" role="button">
        <i class="fa fa-angle-left m-r-1"></i> Back
    </a>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default b-a-0 shadow-box">
                <div class="panel-body">
                    <h3 class="text-center m-b-0"> {{config("app.name")}} | Login</h3>
                    <p class="text-center m-b-3">{{config("app.organization_name")}}</p>
                    <form class="form m-t-3" role="form" method="POST" action="{{ route('login') }}">

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            <input name="username" value="{{old("username")}}" class="form-control" placeholder="Enter your username" >

                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif

                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <input name="password" type="password" class="form-control" placeholder="Your Password...">

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif

                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> Remember?

                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 pull-right">
                            Login
                        </button>
                    </form>
                </div>
                <!--<div class="panel-footer b-a-0 b-r-a-0">
                                    <a href="../pages/forgot-password.html">Forgot Password?</a>
                                    <a href="../pages/register.html" class="pull-right">Register</a>
                                </div>-->
            </div>            
        </div>
    </div>
</div>

@endsection
