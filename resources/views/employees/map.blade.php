@extends('layouts.admin')

@section('content')
  <h1>Guard Map</h1>
  <div class="holder">
    <div id="map"></div>
  </div>
<script>
    var points = @json($points);

    // console.log(points);
    var locations = []

    for(i = 0; i < points.length; i++){
        console.log(points[i]);
        locations.push([points[i].first_name,Number(points[i].latitude),Number(points[i].longitude),Number(points[i].id)])
    }

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(-1.3264314, 36.8433517),
        mapTypeId: google.maps.MapTypeId.ROADMAP
        });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    for (i = 0; i < locations.length; i++) {  
        // console.log(locations[i][1]);
        var indicator = Array.from(locations[i][0]);
        // console.log(indicator[0]);
        // console.log(locations[i][2]);
        map_longitude = parseInt(locations[i][1]);
        map_latitude = parseInt(locations[i][2]);
        // console.log(typeof map_longitude);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(map_latitude, map_longitude),
            map: map,
            // label: indicator[0],
            icon: {
        path: 'M0-48c-9.8 0-17.7 7.8-17.7 17.4 0 15.5 17.7 30.6 17.7 30.6s17.7-15.4 17.7-30.6c0-9.6-7.9-17.4-17.7-17.4z',
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 32),
        fillColor: 'red',
        fillOpacity: 1,
        strokeColor: '#000',
        strokeWeight: 0,
        scale: 1
    },
        });

        // // console.log(locations[i][0]);
        // google.maps.event.addListener(marker, 'click', (function(marker, i) {
        //     return function() {
        //         var content = locations[i][0];
        //         console.log(content);
        //     infowindow.setContent(content);
        //     infowindow.open(map, marker);
        //     }
        // })(marker, i));

    }
</script>
@endsection
