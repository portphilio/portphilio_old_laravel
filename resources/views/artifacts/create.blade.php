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
            <form id="new-artifact-form" class="form-horizontal" action="artifacts" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                <input type="hidden" name="thumbnail" id="thumbnail" value="">
                <input type="hidden" name="type" id="type" value="">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="title">Title</label>
                    <div class="col-sm-10">
                        <input type="text" id="title" name="title" placeholder="Artifact Title" class="col-xs-10 col-sm-5">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="description">Description</label>
                    <div class="col-sm-10">
                        <input type="hidden" id="description" name="description">
                        <div id="description-editor"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('plugin-scripts')
    <script src="/assets/js/jquery.hotkeys.js"></script>
    <script src="/assets/js/bootstrap-wysiwyg.js"></script>
    <script src="/assets/js/ace/elements.colorpicker.js"></script>
    <script src="/assets/js/ace/elements.wysiwyg.js"></script>
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
        pickerCallback = function(data) {
            var url = 'nothing';
            if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                var doc = data[google.picker.Response.DOCUMENTS][0];
                url = doc[google.picker.Document.URL];
                $('#title').val(doc[google.picker.Document.NAME]);
            }
        };
        (function($){
            $('#google-drive-picker').on('click', function() {picker.setVisible(true);return false;})
            $('#description-editor').ace_wysiwyg();
            $('#new-artifact-form').on('submit', function() {
                $('#description').val($('#description-editor').html());
            });
        })(jQuery);
    </script>
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=handleApiLoad"></script>
@endsection