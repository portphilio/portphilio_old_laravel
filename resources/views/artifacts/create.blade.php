@extends('layouts.master')
@section('title', 'Add Artifact')
@section('plugin-styles')
@endsection
@section('breadcrumb', 'Add New Artifact')
@section('page-header', 'Add New Artifact')
@section('main-content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 ">
            <a href="#" id="google-drive-picker" class="btn btn-danger no-radius center"><img src="/assets/images/google-drive-icon.png" width="16" height="16"> Drive</a>
            <form class="form-horizontal" action="artifacts" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right" for="title">Title</label>
                <div class="col-sm-10">
                    <input type="text" id="title" name="title" placeholder="Artifact Title" class="col-xs-10 col-sm-5">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('plugin-scripts')
@endsection
@section('page-scripts')
    <script>
        var key = "{{ env('GOOGLE_DEVELOPER_KEY') }}",
            token = "{{ $user->getLinkByProvider('google')->oauth2_access_token }}",
            pickerApiLoaded = false,
            handleApiLoad, onPickerApiLoad, createPicker, pickerCallback, picker;

        handleApiLoad = function() {gapi.load('picker', {'callback': onPickerApiLoad});};
        onPickerApiLoad = function() {pickerApiLoaded = true; createPicker();};
        createPicker = function() {
            if ( pickerApiLoaded && token ) {
                picker = new google.picker.PickerBuilder()
                    .addView(google.picker.ViewId.FOLDERS)
                    .setOAuthToken(token)
                    .setDeveloperKey(key)
                    .setCallback(pickerCallback)
                    .setOrigin(window.location.protocol+'//'+window.location.host)
                    .build();
            }
        };
        $('#google-drive-picker').on('click', function() {picker.setVisible(true);return false;})
        pickerCallback = function(data) {
            var url = 'nothing';
            if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                var doc = data[google.picker.Response.DOCUMENTS][0];
                url = doc[google.picker.Document.URL];
                $('#title').val(doc[google.picker.Document.NAME]);
            }
        };
    </script>
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=handleApiLoad"></script>
@endsection