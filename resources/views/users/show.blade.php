@extends('layouts.master')
@section('title', $u->display_name.'\'s Profile')
@section('plugin-styles')
    <link rel="stylesheet" href="/assets/css/bootstrap-editable.css">
@endsection
@section('page-header', 'My Profile')
@section('main-content')
    <div class="user-profile row">
        <div class="col-xs-12 col-sm-4 center">
            <div>
                <span class="profile-picture">
                    <img id="avatar" class="editable img-responsive" alt="{{ $u->display_name }}" src="{{ $u->profile_pic }}">
                </span>
                <div class="space-4"></div>
                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                    <div class="inline position-relative"><span class="white">{{ $u->display_name }}</span></div>
                </div>
                <div class="space-6"></div>
                <div class="profile-social-links align-center action-buttons">@include('layouts.partials.social')</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8">
            <p>Click on any of the values below to edit it.</p>
            <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                    <div class="profile-info-name">Username</div>
                    <div class="profile-info-value"><span class="editable" id="username">{{ $u->username }}</span></div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name">Primary Email</div>
                    <div class="profile-info-value"><span class="editable" id="email">{{ $u->email }}</span></div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name">First Name</div>
                    <div class="profile-info-value"><span class="editable" id="first_name">{{ $u->first_name }}</span></div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name">Last Name</div>
                    <div class="profile-info-value"><span class="editable" id="last_name">{{ $u->last_name }}</span></div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name">Gender</div>
                    <div class="profile-info-value"><span class="editable" id="gender">{{ $u->gender }}</span></div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name">Mobile</div>
                    <div class="profile-info-value"><span class="editable" id="mobile">{{ $u->mobile }}</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('plugin-scripts')
    <script src="/assets/js/x-editable/bootstrap-editable.js"></script>
    <script src="/assets/js/jquery.maskedinput.js"></script>
@endsection
@section('page-scripts')
    <script>
    (function($){
        // setup editable fields
        $.fn.editable.defaults.send = 'always';
        $.fn.editable.defaults.url = "{{route('users.update', $u->id)}}";
        $.fn.editable.defaults.params = { '_method': 'PUT', '_token': '{!! csrf_token() !!}' };
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.error = function(response, newValue) {
            return response.responseJSON.value[0];
        };
        $.fn.editableform.loading = '<div class="editableform-loading"><i class="ace-icon fa fa-spinner fa-spin fa-2x light-blue"></i></div>';
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>'+
                                    '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';
        $('#username').editable({type: 'text', name: 'username'});
        $('#email').editable({type: 'text', name: 'email'});
        $('#first_name').editable({type: 'text', name: 'first_name'});
        $('#last_name').editable({type: 'text', name: 'last_name'});
        $('#gender').editable({type: 'text', name: 'gender'});
        $('#mobile').editable({type: 'text', name: 'mobile'});
        $('#mobile').on('shown',function(){
            $(this).data('editable').input.$input.mask('(999) 999-9999');
        });
    })(jQuery);
    </script>
@endsection