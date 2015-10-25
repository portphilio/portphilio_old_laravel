<li class="@yield('navbar_dropdown_color','light-blue')">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon fa fa-@yield('navbar_dropdown_icon', 'plus-square')"></i>
        <span class="badge badge-grey">@yield('navbar_item_count')</span>
    </a>
    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
        <li class="dropdown-header">@yield('navbar_dropdown_header')</li>
        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar">
                @yield('navbar_dropdown_content')
            </ul>
        </li>
        <li class="dropdown-footer">@yield('navbar_dropdown_footer')</li>
    </ul>
</li>