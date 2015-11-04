@foreach (Social::getConnections() as $slug => $c)
    @if (!in_array($slug, ['tumblr','vkontakte']))
        @if ($link = $u->getLinkByProvider($slug))
            <a href="{{ $link->url }}" target="_blank" class="tooltip-info" title="View your {{ $c['driver'] }} profile">
                <i class="middle ace-icon fa fa-{{ $c['icon'] }} fa-2x {{ $link->color }}"></i>
            </a>
        @else
            <a href="/oauth/authorize/{{ $slug }}" class="tooltip-info" title="Link your account to your {{ $c['driver'] }} profile">
                <i class="middle ace-icon fa fa-{{ $c['icon'] }} fa-2x light-grey"></i>
            </a>
        @endif
    @endif
@endforeach
