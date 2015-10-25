@extends('layouts.accounts')
@section('title', 'Password Reset')
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
                Please enter a new password and confirm it.
            </p>
            <form method="put" action="/reset">
                {!! csrf_field() !!}
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="reset_code" value="{{ $reset->code }}">
                <fieldset>
                    <label for="password" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="password" id="password" value="{{ old('password') }}" class="form-control" placeholder="New Password" />
                            <i class="ace-icon fa fa-lock"></i>
                        </span>
                    </label>
                    <label for="password_confirmation" class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" placeholder="Confirm New Password" />
                            <i class="ace-icon fa fa-lock"></i>
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