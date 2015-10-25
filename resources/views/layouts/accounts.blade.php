<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>@yield('title')::Portphilio::A Web-Based Portfolio Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="/assets/css/accounts.css" />
    </head>
    <body class="login-layout blur-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="white">Portphil</span><span class="red" id="id-text2">io</span>
                                </h1>
                                <h4 class="blue" id="id-company-text">&copy; Morgan C. Benton</h4>
                            </div>
                            @include('helpers.notifications')
                            <div class="space-6"></div>
                            <div class="position-relative">
                                @yield('main')
                            </div><!-- /.position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->
        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='/assets/js/jquery.js'>"+"<"+"/script>");
        </script>
        <!-- <![endif]-->
        <!--[if IE]>
        <script type="text/javascript">
         window.jQuery || document.write("<script src='/assets/js/jquery1x.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='/assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>
        <script src="/assets/js/bootstrap.js"></script>
    </body>
</html>
