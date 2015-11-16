@foreach($items as $item)
    <li {!! str_replace('opened', 'open', $item->attributes()) !!}>@if($item->link)
            <a @if($item->hasChildren()) class="dropdown-toggle"@endif href="{{ $item->url() }}">
                @if($item->icon)<i class="menu-icon fa fa-{{ $item->icon }}"></i>@endif
                <span class="menu-text">
                    {!! $item->title !!}
                    @if($item->badge)
                        <span class="badge badge-transparent tooltip-{{ $item->badge->status }}" title="{{ $item->badge->title }}">
                            <i class="ace-icon fa fa-{{ $item->badge->icon or 'exclamation-triangle'}} {{ $item->badge->icon or 'blue' }} bigger-130"></i>
                        </span>
                    @endif
                </span>
                @if($item->hasChildren())<b class="arrow fa fa-angle-down"></b>@endif
            </a>
        @else
            {{$item->title}}
        @endif
        <b class="arrow"></b>
        @if($item->hasChildren())
            <ul class="submenu">
                @include('layouts.partials.menu-items', ['items'=> $item->children()])
            </ul>
        @endif
    </li>
@endforeach