@extends('layouts.accounts')
@section('title', 'Reset')
@section('main')
<div id="forgot-box" class="forgot-box visible widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header red lighter bigger">
                <i class="ace-icon fa fa-key"></i>
                Reset Password
            </h4>
            <div class="space-6"></div>
            <p>
                Enter your email or username
            </p>
            <form method="post" action="/reset">
                {!! csrf_field() !!}
                <fieldset>
                    <label for="login" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="login" id="login" value="{{ old('login') }}" class="form-control" placeholder="Username or Email" />
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>
                    <div class="clearfix">
                        <button type="submit" id="submit" class="width-35 pull-right btn btn-sm btn-danger">
                            <i class="ace-icon fa fa-lightbulb-o"></i>
                            <span class="bigger-110">Reset!</span>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div><!-- /.widget-main -->
        <div class="toolbar center">
            <a href="/login" data-target="#login-box" class="back-to-login-link">
                Login
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </div>
    </div><!-- /.widget-body -->
</div><!-- /.forgot-box -->
@endsection