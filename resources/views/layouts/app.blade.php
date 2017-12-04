<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="layout-pf layout-pf-fixed">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ config('app.name')}}
    </title>
    

    <link rel="icon" href="img/logo.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />

    <!--<link href="/css/app.css" rel="stylesheet" type="text/css">-->
    <link href="/css/patternfly.min.css" rel="stylesheet" type="text/css">
    <link href="/css/patternfly-additions.min.css" rel="stylesheet" type="text/css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <!--<link href="/css/so2platform/styles.css" rel="stylesheet" type="text/css">-->
</head>
<body>
    <nav class="navbar navbar-pf-vertical">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">
                <img class="navbar-brand-icon" src="/img/logo-alt.svg" alt=""/>
                <img class="navbar-brand-name" src="" alt="{{config('app.name')}}" />
            </a>
        </div>
        <nav class="collapse navbar-collapse">
            {{--<ul class="nav navbar-nav">
                <li>
                    <a href="#" target="_blank" class="nav-item-iconic nav-item-iconic-new-window"><span title="Launch" class="fa fa-external-link"></span></a>
                </li>
            </ul>--}}
            <ul class="nav navbar-nav navbar-right navbar-iconic">
                <li class="dropdown">
                    <a class="dropdown-toggle nav-item-iconic" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span title="Help" class="fa pficon-help"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            <a href="/help">
                                <span class="fa fa-question-circle ">
                                    &nbsp;&nbsp;Help
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="/about">
                                <span class="fa fa-info-circle ">
                                    &nbsp;&nbsp;About
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a class="dropdown-toggle nav-item-iconic" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span title="Username" class="fa pficon-user"></span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        @if (Auth::guest())
                            <li>
                                <a href="{{ route('login') }}">
                                    <span class="fa fa-sign-in">
                                        &nbsp;&nbsp;&nbsp;Login
                                    </span>
                                </a>
                            </li>
                        @else
                            <li>
                                &nbsp;&nbsp;&nbsp;
                                <span class="fa fa-user">
                                    &nbsp;&nbsp;{{ Auth::user()->name }}
                                </span>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <span class="fa fa-sign-out">
                                        &nbsp;&nbsp;Logout
                                    </span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
    </nav> <!--/.navbar-->

    <div class="nav-pf-vertical nav-pf-vertical-with-sub-menus">

        <ul class="list-group">


            @if (\Auth::user())
       
                @if(\Auth::user()->isAdmin())
       
                    <li class="list-group-item{{ $current_route_name == "users" ? " active" : ""}}">
                        <a href="{{ route('users') }}">
                            <span class="fa fa-users" data-toggle="tooltip" title="Uživatelé"></span>
                            <span class="list-group-item-value">Uživatelé</span>
                        </a>
                    </li>
       
                @endif
       
            @endif


            @if (\Auth::user())

                @if(\Auth::user()->isAdmin() == false)

                    <li class="list-group-item{{ $current_route_name == "leky-na-pobocce" ? " active" : ""}}">
                        <a href="{{ route('leky-na-pobocce') }}">
                            <span class="fa fa-medkit" data-toggle="tooltip" title="Léky"></span>
                            <span class="list-group-item-value">Léky</span>
                        </a>
                    </li>

                @else

                    <li class="list-group-item{{ $current_route_name == "leky" ? " active" : ""}}">
                        <a href="{{ route('leky') }}">
                            <span class="fa fa-medkit" data-toggle="tooltip" title="Léky"></span>
                            <span class="list-group-item-value">Léky</span>
                        </a>
                     </li>

                @endif

            @else

                <li class="list-group-item{{ $current_route_name == "leky" ? " active" : ""}}">
                    <a href="{{ route('leky') }}">
                        <span class="fa fa-medkit" data-toggle="tooltip" title="Léky"></span>
                        <span class="list-group-item-value">Léky</span>
                    </a>
                </li>

            @endif


            <li class="list-group-item{{ $current_route_name == "pobocky.index" ? " active" : ""}}">
                <a href="{{ route('pobocky.index') }}">
                    <span class="fa fa-hospital-o" data-toggle="tooltip" title="Pobočky"></span>
                    <span class="list-group-item-value">Pobočky</span>
                </a>
            </li>


            <li class="list-group-item{{ $current_route_name == "dodavatele.index" ? " active" : ""}}">
                <a href="{{ route('dodavatele.index') }}">
                    <span class="fa fa-ambulance" data-toggle="tooltip" title="Dodavatelé"></span>
                    <span class="list-group-item-value">Dodavatelé</span>
                </a>
            </li>


            <li class="list-group-item{{ $current_route_name == "predpisy.index" ? " active" : ""}}">
                <a href="{{ route('predpisy.index') }}">
                    <span class="fa fa-files-o" data-toggle="tooltip" title="Predpisy"></span>
                    <span class="list-group-item-value">Předpisy</span>
                </a>
            </li>


            <li class="list-group-item{{ $current_route_name == "rezervace.index" ? " active" : ""}}">
                <a href="{{ route('rezervace.index') }}">
                    <span class="fa fa-clipboard" data-toggle="tooltip" title="Rezervace"></span>
                    <span class="list-group-item-value">Rezervace</span>
                </a>
            </li>

            <li class="list-group-item{{ $current_route_name == "poistovny.index" ? " active" : ""}}">
                <a href="{{ route('poistovny.index') }}">
                    <span class="fa fa-universal-access" data-toggle="tooltip" title="Pojišťovny"></span>
                    <span class="list-group-item-value">Pojišťovny</span>
                </a>
            </li>


        </ul>
    </div>


    <div class="container-fluid container-cards-pf container-pf-nav-pf-vertical" id="app">
        <div class="row row-cards-pf">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        window.Laravel = {
            'csrfToken' : '{{csrf_token()}}'
        };
    </script>
    <!--<script src="/js/manifest.js"></script>-->
    <!--<script src="/js/vendor.js"></script>-->
    <!--<script src="/js/app.js"></script>-->
    <script src="/js/patternfly.js"></script>
    <script>
        var app = new Vue({
            el: '#app'
        });
    </script>
    <script>
        $(document).ready(function() {
            $().setupVerticalNavigation(true);
        });
    </script>
    @section('scripts')
    @show
</body>
</html>

