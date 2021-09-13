<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="icon" href="{{ asset('/logo/favicon.ico') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/chat.css') }}" rel="stylesheet"> -->
</head>
<body onload="getLocation()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                <img src=" {{ asset('/logo/msimbo.jpg') }} " class="img-fluid rounded" alt="logo" style="width: 40px;">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <!-- @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif -->

                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Auth::check() && Auth::user()->role === 'guard')
                                    <a class="dropdown-item" href="{{ route('scanned_areas') }}">
                                        {{ __('Scanned Areas') }}
                                    </a>
                                    @endif

                                    @if (Auth::check() && Auth::user()->role !== 'admin')
                                    <a class="dropdown-item" href="{{ route('reportIssue') }}">
                                        {{ __('Report An Issue') }}
                                    </a>
                                    @endif

                                    @if (Auth::check() && Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="/shifts-all_scanned_areas">
                                        {{ __('Scanned Areas') }}
                                    </a>
                                    @endif

                                    @if (Auth::check() && Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('all_issues') }}">
                                        {{ __('Reported Issues') }}
                                    </a>
                                    @endif

                                    @if (Auth::check() && Auth::user()->role !== 'admin')
                                    <a class="dropdown-item" href="{{ route('changePassword') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                    @endif

                                    
                                    <a class="dropdown-item" href="{{ route('chats', Auth::user()->id) }}">
                                        {{ __('Chat') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    @if (Auth::check() && Auth::user()->role === 'guard')

                                    <form action="{{ route('panic', Auth::user()->id) }}" method="post">
                                        @csrf
                                        @method("POST")
                                        <input type="text" name="guard_id" value="{{ Auth::user()->id }}" hidden>
                                        <input type="text" name="latitude" id="lat" hidden>
                                        <input type="text" name="longitude" id="lon" hidden>
                                        <input type="text" name="time" id="time" hidden>
                                        <div class="col-md-6">

                                        <input class="btn btn-danger ml-1 mt-2" type="submit" value="Panic Button!"> 
                                        <!-- <a class="btn btn-danger ml-3 mt-2" href="{{ route('panic', Auth::user()->id) }}">
                                            {{ __('Panic Button!') }}
                                        </a> -->
                                    </form>
                                    @endif
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <!-- <div style="position:relative;">
            <footer class="main-footer hidden-print p-2 ml-1" style="position:absolute; bottom:0;">
                <strong>Copyright &copy; 2021 <a href="http://msimboit.net/" target="_blank">Msimbo IT</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
                </div>
            </footer>
        </div> -->
    </div>

<script defer>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else { 
                x.innerHTML = "Geolocation is not supported by this browser.";
            }

        const watchId = navigator.geolocation.watchPosition(position => {
        const { latitude, longitude } = position.coords;
        // Show a map centered at latitude / longitude or run an ajax patch request
        console.log(watchId);
            });

            const current = new Date();
            // By default US English uses 12hr time with AM/PM
            var time = current.toLocaleTimeString("en-US");
            $('#time').val(time);

        }

        function showPosition(position) {
            var lat = position.coords.latitude;
            $('#lat').val(lat);
            console.log(lat);
            var lon = position.coords.longitude;
            $('#lon').val(lon);
            console.log(lon);

            var positionInfo = "Your current position is (" + "Latitude: " + position.coords.latitude + ", " + "Longitude: " + position.coords.longitude + ")";
                        document.getElementById("place").innerHTML = positionInfo;

            const current = new Date();
            // By default US English uses 12hr time with AM/PM
            var time = current.toLocaleTimeString("en-US");
            $('#time').val(time);


            // var latlon = new google.maps.LatLng(lat, lon)
            // var mapholder = document.getElementById('mapholder')
            // mapholder.style.height = '250px';
            // mapholder.style.width = '500px';

            // var myOptions = {
            // center:latlon,zoom:14,
            // mapTypeId:google.maps.MapTypeId.ROADMAP,
            // mapTypeControl:false,
            // navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
            // }
            
            // var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
            // var marker = new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
    </script>
</body>
</html>
