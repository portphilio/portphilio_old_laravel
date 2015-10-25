@extends('layouts.accounts')
@section('title', 'Register')
@section('main')
<div id="signup-box" class="signup-box visible widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header green lighter bigger">
                <i class="ace-icon fa fa-users blue"></i>
                New User Registration
            </h4>

            <div class="space-6"></div>
            <p> Enter your details to begin: </p>

            <form method="post" action="/register">
	            {!! csrf_field() !!}
                <fieldset>
                    <label for="first_name" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="First Name" />
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>

                    <label for="last_name" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Last Name" />
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>

                    <label for="username" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="username" id="username" value="{{ old('username') }}" class="form-control" placeholder="Username" />
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>

                    <label for="email" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email" />
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>

                    <label for="email_confirmation" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="email" name="email_confirmation" id="email_confirmation" value="{{ old('email_confirmation') }}" class="form-control" placeholder="Confirm Your Email" />
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>


                    <label for="password" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" placeholder="Password" />
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>

                    <label for="password_confirmation" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" placeholder="Confirm Your Password" />
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>
                    <!--
                    <label class="block">
                        <input type="checkbox" class="ace" />
                        <span class="lbl">
                            I accept the
                            <a href="#">User Agreement</a>
                        </span>
                    </label>
                    -->
					{!! Recaptcha::render() !!}

                    <div class="space-12"></div>

                    <div class="clearfix">
                        <button type="submit" id="submit" class="width-65 pull-right btn btn-sm btn-success">
                            <span class="bigger-110">Register</span>

                            <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
            <div class="space-6"></div>
            <div class="social-or-login center">
                <span class="bigger-110">Or Register Using</span>
            </div>
            <div class="space-6"></div>
            <div class="social-login center">
                <a class="btn btn-primary">
                    <i class="ace-icon fa fa-facebook"></i>
                </a>
                <a class="btn btn-info">
                    <i class="ace-icon fa fa-twitter"></i>
                </a>
                <a class="btn btn-danger">
                    <i class="ace-icon fa fa-google-plus"></i>
                </a>
                <a class="btn btn-purple">
                    <i class="ace-icon fa fa-github"></i>
                </a>
            </div>

        </div>

        <div class="toolbar center">
            <a href="/login" class="back-to-login-link">
                <i class="ace-icon fa fa-arrow-left"></i>
                Login
            </a>
        </div>
    </div><!-- /.widget-body -->
</div><!-- /.signup-box -->
@endsection