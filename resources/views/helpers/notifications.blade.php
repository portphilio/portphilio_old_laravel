@if (count($errors) > 0)
    <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4><i class="fa fa-bolt"></i> Oops!</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4><i class="fa fa-thumbs-o-up"></i> Success</h4>
            <p>{!! session( 'success' ) !!}</p>
    </div>
@endif
@if (session('info'))
     <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Warning</h4>
            <p>{!! session('info') !!}</p>
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Warning</h4>
            <p>{!! session('warning') !!}</p>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Error</h4>
            <p>{!! session('error') !!}</p>
    </div>
@endif
