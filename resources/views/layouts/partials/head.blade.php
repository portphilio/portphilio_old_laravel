        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>@yield('title')::Portphilio::A Web-Based Portfolio Management System</title>

        <meta name="description" content="A web-based app for managing portfolios" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="/assets/css/font-awesome.css" />

        <!-- page specific plugin styles -->
        @yield('plugin-styles')

        <!-- text fonts -->
        <link rel="stylesheet" href="/assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="/assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!-- inline styles related to this page -->
        @yield('page-styles')

        <!-- ace settings handler -->
        <script src="/assets/js/ace-extra.js"></script>
