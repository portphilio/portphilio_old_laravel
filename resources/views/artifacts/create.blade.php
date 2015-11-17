@extends('layouts.master')
@section('title', 'Add Artifact')
@section('plugin-styles')
    <link rel="stylesheet" href="/assets/css/chosen.css">
@endsection
@section('breadcrumb', 'Add New Artifact')
@section('page-header', 'Add New Artifact')
@section('main-content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 ">
            <div class="well">
                <h4 class="blue">Choose Artifact Source</h4>
                <a href="#" id="google-drive-picker" class="btn btn-sm btn-danger"><img src="/assets/images/google-drive-icon.png" width="21" height="21" class="ace-icon" style="vertical-align: -5px;"> Drive</a> 
                <a href="#" id="github-picker" class="btn btn-sm btn-inverse"> 
                    <i class="ace-icon fa fa-github bigger-150"></i> Github
                </a>
                <a href="#" id="youtube-picker" class="btn btn-sm btn-success"> 
                    <i class="ace-icon fa fa-youtube bigger-150"></i> YouTube
                </a>
                <a href="#" id="url-picker" class="btn btn-sm btn-primary"> 
                    <i class="ace-icon fa fa-link bigger-150"></i> URL
                </a>
            </div>
            <h3 class="blue">Fill In Artifact Details</h3>
            <form id="new-artifact-form" class="form-horizontal" action="artifacts" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                <input type="hidden" name="thumbnail" id="thumbnail" value="">
                <input type="hidden" name="type" id="type" value="">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="url">Link</label>
                    <div class="col-sm-10">
                        <input type="text" id="url" name="url" disabled placeholder="Set Automatically" class="col-xs-10 col-sm-5">
                    </div>
                </div>
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
                        <div id="description-editor" class="wysiwyg-editor"></div>
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
    <script src="/assets/js/bootbox.js"></script>
    <script src="/assets/js/chosen.jquery.js"></script>
@endsection
@section('page-scripts')
    <script>
        var key = "{{ env('GOOGLE_DEVELOPER_KEY') }}",
            google_token = "{{ $user->getLinkByProvider('google')->oauth2_access_token }}",
            pickerApiLoaded = false,
            handleApiLoad, onPickerApiLoad, createPicker, pickerCallback, picker, ytpicker;

        handleApiLoad = function() {gapi.load('picker', {'callback': onPickerApiLoad});};
        onPickerApiLoad = function() {pickerApiLoaded = true; createPicker();};
        createPicker = function() {
            if ( pickerApiLoaded && google_token ) {
                var dv = new google.picker.DocsView()
                    .setIncludeFolders(true)
                    .setSelectFolderEnabled(true)
                    .setOwnedByMe(true);
                picker = new google.picker.PickerBuilder()
                    .addView(dv)
                    .setOAuthToken(google_token)
                    .setDeveloperKey(key)
                    .setCallback(pickerCallback)
                    .build();
                ytpicker = new google.picker.PickerBuilder()
                    .addView(google.picker.ViewId.YOUTUBE)
                    .setOAuthToken(google_token)
                    .setDeveloperKey(key)
                    .setCallback(pickerCallback)
                    .build();
            }
        };
        pickerCallback = function(data) {
            if (data[google.picker.Response.ACTION] == google.picker.Action.PICKED) {
                var doc = data[google.picker.Response.DOCUMENTS][0], 
                    url = doc[google.picker.Document.URL],
                    thumb = doc[google.picker.Document.ICON_URL];
                switch (doc[google.picker.Document.TYPE]) {
                    case google.picker.Type.VIDEO:
                        url = doc[google.picker.Document.EMBEDDABLE_URL];
                        thumb = doc[google.picker.Document.THUMBNAILS][0].URL;
                        type = 'video';
                        break;
                    case google.picker.Type.ALBUM:    type = 'album';    break;
                    case google.picker.Type.DOCUMENT: type = 'document'; break;
                    case google.picker.Type.PHOTO:    type = 'photo';    break;
                    case google.picker.Type.URL:      type = 'url';      break;
                    default: return;
                }
                $('#title').val(doc[google.picker.Document.NAME]);
                $('#url').val(url);
                $('#thumbnail').val(thumb);
                $('#type').val(type);
            }
        };
        (function($){
            var github_token = "{{ $user->getLinkByProvider('github')->oauth2_access_token }}",
                github_user  = "{{ $user->getLinkByProvider('github')->username }}",
                githubRepoSelected,
                github_bootbox = {
                    id: "github-modal",
                    title: "Select a Github Repo",
                    callback: githubRepoSelected,
                    onEscape: true,
                    size: 'small',
                    buttons: {
                        "Cancel": function(){},
                        "Select": function() {githubRepoSelected();}
                    }
                };

            $('#google-drive-picker').on('click', function() {
                $('#url').prop('disabled',true).prop('placeholder','Set Automatically');
                picker.setVisible(true);
                return false;
            });
            $('#github-picker').on('click', function() {
                $('#url').prop('disabled',true).prop('placeholder','Set Automatically');
                var bbox = bootbox.dialog(github_bootbox);
                $(bbox).on('shown.bs.modal', function () {
                    if(!ace.vars['touch']) {
                        $(this).find('.chosen-container').each(function(){
                            $(this).find('a:first-child').css('width' , '210px');
                            $(this).find('.chosen-drop').css('width' , '210px');
                            $(this).find('.chosen-search input').css('width' , '200px');
                        });
                    }
                });
                $('.chosen-select').chosen({allow_single_deselect:true}); 
                return false;
            });
            $('#youtube-picker').on('click', function() {
                $('#url').prop('disabled',true).prop('placeholder','Set Automatically');
                ytpicker.setVisible(true);
                return false;
            });
            $('#url-picker').on('click', function() {
                $('#url').prop('disabled',false).prop('placeholder','Please type or paste a URL').focus();
                return false;
            });
            $('#description-editor').css({'height':'200px'}).ace_wysiwyg({
                toolbar: [
                    'bold','italic','strikethrough','underline',null,'foreColor',null,
                    'insertunorderedlist','insertorderedlist','outdent','indent',null,
                    'justifyleft','justifycenter','justifyright','justifyfull',null,
                    'createLink','unlink',null,'undo','redo',null,'viewSource'
                ]
            }).prev().addClass('wysiwyg-style2');
            $('#new-artifact-form').on('submit', function() {
                $('#description').val($('#description-editor').html());
            });
            githubRepoSelected = function() {
                var repo = $('#repo-select').val();
                $.getJSON('https://api.github.com/repos/'+repo+'?per_page=100&access_token='+github_token)
                 .done(function(repo){
                    $('#title').val(repo.full_name);
                    $('#url').val(repo.html_url);
                    $('#type').val('repo');
                    $('#description-editor').html(repo.description);
                 });
            };
            $.getJSON('https://api.github.com/user/repos?per_page=100&access_token='+github_token)
             .done(function(repos){
                var repo_select = $('<select id="repo-select" class="chosen-select form-control" data-placeholder="Choose a repository"></select>');
                $(repos).each(function(i, repo) {
                    $(repo_select).append('<option>'+repo.full_name+'</option>');
                    if ( i+1 == repos.length) {
                        github_bootbox.message = repo_select;
                    }
                });
            });
        })(jQuery);
    </script>
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=handleApiLoad"></script>
@endsection