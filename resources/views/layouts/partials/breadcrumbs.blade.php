@if ( isset($crumbs[0]) && 'Dashboard' !== $crumbs[0]->title)
    @foreach ( $crumbs as $crumb )
        <li><a href="{{ $crumb->url() }}">{{ $crumb->title }}</a></li>
    @endforeach
@endif
