<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="../themes/material2/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../themes/material2/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>@yield('pagetitle') - Dribly</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="../themes/material2/css/material-dashboard.css?v=2.1.0" rel="stylesheet"/>
    <link href="../themes/material2/css/app.css" rel="stylesheet"/>
    <meta name="description" content="@yield('htmlmetadescription','Dribly automates your watering')" />
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M79SC8L');</script>
    <!-- End Google Tag Manager -->
{{--    <script src="{{ asset('js/app.js') }}"></script>--}}

</head>

<body class="">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M79SC8L"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div class="wrapper ">
    <div class="sidebar" data-color="@yield('pageColour', 'purple')" data-background-color="white"
         data-image="../themes/material2/img/sidebar-1.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
            <a href="/" class="simple-text logo-normal">
                {{--<img stc="/themes/material2/img/apple-icon.png" alt="Dribly Logo"/>--}}
                Dribly
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                @if (Auth::guest())
                    <li class="nav-item @yield('registerNavHighlight', '')  ">
                        <a class="nav-link" href="{{route('register')}}">
                            <i class="material-icons">assignment</i>
                            <p>Register</p>
                        </a>
                    </li>
                    <li class="nav-item @yield('loginNavHighlight', '') ">
                        <a class="nav-link" href="{{route('login')}}">
                            <i class="material-icons">person_outline</i>
                            <p>Log in</p>
                        </a>
                    </li>

                @else
                    <li class="nav-item @yield('dashboardNavHighlight', '') ">
                        <a class="nav-link" href="{{route('users.dashboard')}}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <div class="mdl-layout-spacer"></div>
                    <li class="nav-item @yield('profileNavHighlight', '') ">
                        <a class="nav-link" href="{{route('users.profile')}}">
                            <i class="material-icons">person</i>
                            <p>{{ Auth::user()->firstname }}'s Profile</p>
                        </a>
                    </li>
                    <li class="nav-item @yield('gardensNavHighlight', '') ">
                        <a class="nav-link " href="{{route('gardens.index')}}">
                            <i class="material-icons">local_florist</i>
                            <p>Garden</p>
                        </a>
                    </li>
                    <li class="nav-item @yield('sensorsNavHighlight', '') ">
                        <a class="nav-link " href="{{route('sensors.index')}}">
                            <i class="material-icons">brightness_medium</i>
                            <p>Sensors</p>
                        </a>
                    </li>
                    <li class="nav-item @yield('tapsNavHighlight', '')">
                        <a class="nav-link" href="{{route('taps.index')}}">
                            <i class="material-icons">opacity</i>
                            <p>Taps</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}"
                           onclick="event.preventDefault(); document.getElementById('frm-logout').submit();return false">
                            <i class="material-icons" >directions_run</i>
                            <p>Log out</p>
                        </a>
                    </li>
            @endif
            <!-- <li class="nav-item active-pro ">
                      <a class="nav-link" href="./upgrade.html">
                          <i class="material-icons">unarchive</i>
                          <p>Upgrade to PRO</p>
                      </a>
                  </li> -->
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#pablo">@yield('headertitle','Simply Watering Your Stuff')</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    @if (!Auth::guest())
                        <form class="navbar-form">
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                    <i class="material-icons">search</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </div>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('users.dashboard')}}">
                                    <i class="material-icons">dashboard</i>
                                    <p class="d-lg-none d-md-block">
                                        Stats
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Mike John responded to your email</a>
                                    <a class="dropdown-item" href="#">You have 5 new tasks</a>
                                    <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                                    <a class="dropdown-item" href="#">Another Notification</a>
                                    <a class="dropdown-item" href="#">Another One</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                {{--<nav class="float-left">--}}
                {{--<ul>--}}
                {{--<li>--}}
                {{--<a href="https://www.creative-tim.com">--}}
                {{--Creative Tim--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<a href="https://creative-tim.com/presentation">--}}
                {{--About Us--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<a href="http://blog.creative-tim.com">--}}
                {{--Blog--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<a href="https://www.creative-tim.com/license">--}}
                {{--Licenses--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</nav>--}}
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    ,
                    <a href="https://www.dribly.com" target="_blank">Dribly</a>.
                </div>
            </div>
        </footer>
    </div>
</div>
<form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

<!--   Core JS Files   -->
<script src="{{ mix('/js/app.js') }}"></script>
<script src="../themes/material2/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<script src="../themes/material2/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
{{--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>--}}
<!-- Chartist JS -->
{{--<script src="../themes/material2/js/plugins/chartist.min.js"></script>--}}
<!--  Notifications Plugin    -->
<script src="../themes/material2/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../themes/material2/js/material-dashboard.min.js?v=2.1.0" type="text/javascript"></script>
{{--<!-- Material Dashboard DEMO methods, don't include it in your project! -->--}}
{{--<script src="../themes/material2/demo/demo.js"></script>--}}
<script>
    $(document).ready(function () {
        // Javascript method's body can be found in assets/js/demos.js
        md.initDashboardPageCharts();

    });
</script>
@yield('footer_js')
</body>

</html>