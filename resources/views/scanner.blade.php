<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

</head>
<body onload="getLocation()">
<div id="app" class="py-4">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
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
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('scanned_areas') }}">
                                        {{ __('Scanned Areas') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between"><span>{{ __('Scanner') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>
                    <video id="preview" playsinline></video>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <!-- <div id="mapholder"></div> -->

                        <div id="place" class="m-auto" hidden>
                            <!--Position information will be inserted here-->
                        </div>

                        <div id="time" class="m-2" hidden>
                            <!--Time information will be inserted here-->
                        </div>
                        <p>Scanning The Code For:</p>
                        <div id="content" class="m-2">
                            <!--Content information will be inserted here-->
                        </div>

                        <form action="{{ route('scanned') }}" method="post">
                            @csrf
                            <input type="text" name="guard" value="{{ $user->id_number }}" hidden>
                            <input type="text" name="latitude" id="lat" hidden>
                            <input type="text" name="longitude" id="lon" hidden>
                            <input type="text" name="sector" id="con" hidden>
                            <input type="text" name="sector_name" id="con_name" hidden>
                            <input type="text" name="scan_time" id="scan_time" hidden>

                            <input class="btn btn-success m-auto" type="submit" value="CONFIRM SCAN"> 
                        </form>

                        <small class="my-3">
                            <button class="btn btn-secondary">
                                <a href="{{ route('home') }} " style="text-decoration:none; color:#fff">Go Back</a>
                            </button>
                        </small>
                    </div> 
                </div>
            </div>
        </div>
    </div>

<!--https://developers.google.com/maps/documentation/javascript/get-api-key-->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCnGwWFUlm1QJuI8WDZeBVxHzS6Bhzknmo"></script>

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
    const time = current.toLocaleTimeString("en-US");
    document.getElementById("time").innerHTML = time;
    $('#scan_time').val(time);


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


let scanner = new Instascan.Scanner({ video: document.getElementById('preview') , mirror: false });
          scanner.addListener('scan', function (content) {
            console.log(content);
            //Conditional Statements for Langata Codes
            if (content == 'TCS000201') {
                alert('Clocking In');
                document.getElementById("content").innerHTML = 'Clocking In';
                $('#con').val(content);
                $('#con_name').val('Clocking In');
            }
            if (content == 'TCS000202') {
                alert('Scanned Site Office');
                document.getElementById("content").innerHTML = 'Site Office';
                $('#con').val(content);
                $('#con_name').val('Site Office')
            }
            if (content == 'TCS000203') {
                alert('Scanned Block A');
                document.getElementById("content").innerHTML = 'Block A';
                $('#con').val(content);
                $('#con_name').val('Block A')
            }
            if (content == 'TCS000204') {
                alert('Scanned Block A Top');
                document.getElementById("content").innerHTML = 'Block A Top';
                $('#con').val(content);
                $('#con_name').val('Block A Top')
            }
            if (content == 'TCS000205') {
                alert('Scanned Block A Front');
                document.getElementById("content").innerHTML = 'Block A Front';
                $('#con').val(content);
                $('#con_name').val('Block A Front')
            }
            if (content == 'TCS000206') {
                alert('Scanned Block A Back');
                document.getElementById("content").innerHTML = 'Block A Back';
                $('#con').val(content);
                $('#con_name').val('Site Office')
            }
            if (content == 'TCS000207') {
                alert('Scanned Block B');
                document.getElementById("content").innerHTML = 'Block B';
                $('#con').val(content);
                $('#con_name').val('Block B')
            }
            if (content == 'TCS000208') {
                alert('Scanned Block B Top');
                document.getElementById("content").innerHTML = 'Block B Top';
                $('#con').val(content);
                $('#con_name').val('Block B Top')
            }
            if (content == 'TCS000209') {
                alert('Scanned Block B Front');
                document.getElementById("content").innerHTML = 'Block B Front';
                $('#con').val(content);
                $('#con_name').val('Block B Front')
            }
            if (content == 'TCS000210') {
                alert('Scanned Block B Back');
                document.getElementById("content").innerHTML = 'Block B Back';
                $('#con').val(content);
                $('#con_name').val('Block B Back')
            }
            if (content == 'TCS000211') {
                alert('Scanned Block C');
                document.getElementById("content").innerHTML = 'Block C';
                $('#con').val(content);
                $('#con_name').val('Block C')
            }
            if (content == 'TCS000212') {
                alert('Scanned Block C-Top');
                document.getElementById("content").innerHTML = 'Block C-Top';
                $('#con').val(content);
                $('#con_name').val('Block C-Top')
            }
            if (content == 'TCS000213') {
                alert('Scanned Block C Front');
                document.getElementById("content").innerHTML = 'Block C Front';
                $('#con').val(content);
                $('#con_name').val('Block C Front')
            }
            if (content == 'TCS000214') {
                alert('Scanned Block C Back');
                document.getElementById("content").innerHTML = 'Blcok C Back';
                $('#con').val(content);
                $('#con_name').val('Block C Back')
            }
            if (content == 'TCS000215') {
                alert('Scanned Left');
                document.getElementById("content").innerHTML = 'Left';
                $('#con').val(content);
                $('#con_name').val('Left')
            }
            if (content == 'TCS000216') {
                alert('Scanned Right');
                document.getElementById("content").innerHTML = 'Right';
                $('#con').val(content);
                $('#con_name').val('Right')
            }
            if (content == 'TCS000217') {
                alert('Scanned Back');
                document.getElementById("content").innerHTML = 'Back';
                $('#con').val(content);
                $('#con_name').val('Back')
            }
            if (content == 'TCS000218') {
                alert('Clocking Out');
                document.getElementById("content").innerHTML = 'Clocking Out';
                $('#con').val(content);
                $('#con_name').val('Clocking Out')
            }
            if (content == 'TCS000219') {
                alert('Security Office');
                document.getElementById("content").innerHTML = 'Security Office';
                $('#con').val(content);
                $('#con_name').val('Security Office')
            }

            // Conditional Statements for Baraka Codes
            if (content == 'TCS00101') {
                alert('Clocking In');
                document.getElementById("content").innerHTML = 'Clocking In';
                $('#con').val(content);
                $('#con_name').val('Clocking In')
            }
            if (content == 'TCS00102') {
                alert('Scanned Security Office');
                document.getElementById("content").innerHTML = 'Security Office';
                $('#con').val(content);
                $('#con_name').val('Security Office')
            }
            if (content == 'TCS00103') {
                alert('Scanned Block 1');
                document.getElementById("content").innerHTML = 'Block 1';
                $('#con').val(content);
                $('#con_name').val('Block 1')
            }
            if (content == 'TCS00104') {
                alert('Scanned Block 2');
                document.getElementById("content").innerHTML = 'Block 2';
                $('#con').val(content);
                $('#con_name').val('Block 2')
            }
            if (content == 'TCS00105') {
                alert('Scanned Open Area');
                document.getElementById("content").innerHTML = 'Open Area';
                $('#con').val(content);
                $('#con_name').val('Open Area')
            }
            if (content == 'TCS00106') {
                alert('Clocking Out');
                document.getElementById("content").innerHTML = 'Clocking Out';
                $('#con').val(content);
                $('#con_name').val('Clocking Out')
            }
            
          });
          Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
              scanner.start(cameras[0]);
            } else {
              console.error('No cameras found.');
            }
          }).catch(function (e) {
            console.error(e);
          });


</script>

</body>
</html>