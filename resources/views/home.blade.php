<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <link rel="shortcut icon" href="/images/dilg-logo.png" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>Region 8,{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    
</head>
<style type="text/css">
    .clicked-nav {
        font-weight: bolder;
        font-size: 15px;
        color: #a94442;
    }
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top hide-on-print">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><router-link :to="{ name: 'officers' }">Officer</router-link></li>
                        <li><router-link :to="{ name: 'rescues' }">Rescue Teams</router-link></li>
                        <li><router-link :to="{ name: 'evacuation' }">Evacuations</router-link></li>
                        <li><router-link :to="{ name: 'facility' }">Facilities</router-link></li>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Report <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><router-link :to="{ name: 'manage-province' }">Province</router-link></li>
                            <li><router-link :to="{ name: 'manage-city-municipality' }">City/Municipality</router-link></li>
                          </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

       <router-view></router-view>
        <!-- @yield('content') -->
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"><link href="/css/app.css" rel="stylesheet">
    <link href="/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    
</body>
</html>
