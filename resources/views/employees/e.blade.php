@extends('layouts.admin')

@section('content')
  <h1>Guard Map</h1>
  <div class="holder">
    <div id="map"></div>
  </div>
<script>
    // var points = JSON.parse("{{ json_encode($points) }}");
    // var points = {!! json_encode($points) !!};
    var points = @json($points);
    console.log(points);

    var locations = []

    for(i = 0; i < points.length; i++){
        locations.push([points[i].first_name,Number(points[i].latitude),Number(points[i].longitude),Number(points[i].id)])
        console.log(points[i].latitude);
    }

    console.log(locations);

    // var locations = [
    //             ['Bondi Beach', -33.890542, 151.274856, 4],
    //             ['Coogee Beach', -33.923036, 151.259052, 5],
    //             ['Cronulla Beach', -34.028249, 151.157507, 3],
    //             ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
    //             ['Maroubra Beach', -33.950198, 151.259302, 1]
    //         ];

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(-1.3264314, 36.8433517),
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    for (i = 0; i < locations.length; i++) {  
        // console.log(locations[i]);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
            }
        })(marker, i));

    }

</script>
@endsection
