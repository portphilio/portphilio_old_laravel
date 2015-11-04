@extends('layouts.accounts')
@section('title', 'Login')
@section('main')
<div id="login-box" class="login-box visible widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header blue lighter bigger">
                <i class="ace-icon fa fa-coffee green"></i>
                Please Enter Your Information
            </h4>
            <div class="space-6"></div>
            <form method="post" action="/login">
                {!! csrf_field() !!}
                <fieldset>
                    <label for="login" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="login" id="login" value="{{ old('login') }}" class="form-control" placeholder="Username or Email" />
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>
                    <label for="password" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" placeholder="Password" />
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>
                    <div class="space"></div>
                    <div class="clearfix">
                        <label for="remember" class="inline">
                            <input type="checkbox" name="remember" id="remember" class="ace" />
                            <span class="lbl"> Remember Me</span>
                        </label>
                        <button type="submit" id="submit" class="width-35 pull-right btn btn-sm btn-primary">
                            <i class="ace-icon fa fa-key"></i>
                            <span class="bigger-110">Login</span>
                        </button>
                    </div>
                    <div class="space-4"></div>
                </fieldset>
            </form>
            <div class="social-or-login center">
                <span class="bigger-110">Or Login Using</span>
            </div>
            <div class="space-6"></div>
            <div class="social-login center">
                <a href="/oauth/authorize/facebook" class="btn btn-primary">
                    <i class="ace-icon fa fa-facebook"></i>
                </a>
                <a href="/oauth/authorize/twitter" class="btn btn-info">
                    <i class="ace-icon fa fa-twitter"></i>
                </a>
                <a href="/oauth/authorize/google" class="btn btn-danger">
                    <i class="ace-icon fa fa-google-plus"></i>
                </a>
                <a href="/oauth/authorize/github" class="btn btn-purple">
                    <i class="ace-icon fa fa-github"></i>
                </a>
                <a href="/oauth/authorize/linkedin" class="btn btn-default">
                    <i class="ace-icon fa fa-linkedin"></i>
                </a>
                <a href="/oauth/authorize/instagram" class="btn btn-pink">
                    <i class="ace-icon fa fa-instagram"></i>
                </a>
                <a href="/oauth/authorize/microsoft" class="btn btn-yellow">
                    <i class="ace-icon fa fa-windows"></i>
                </a>
            </div>
        </div><!-- /.widget-main -->
        <div class="toolbar clearfix">
            <div>
                <a href="/reset" class="forgot-password-link">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    Reset Password
                </a>
            </div>
            <div>
                <a href="/register" class="user-signup-link">
                    Register
                    <i class="ace-icon fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div><!-- /.widget-body -->
</div><!-- /.login-box -->
@endsection