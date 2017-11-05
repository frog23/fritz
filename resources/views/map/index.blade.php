@extends('layouts.master')

@section('styles')

@endsection

@section('content')

<div id="full-map" class="map"></div>

@endsection

@section('scripts')

<script>
    var fullMap = L.map('full-map').setView([52.52, 13.40], 7);
    
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoidGhzbmV1bWFubiIsImEiOiJjajBiMGNpbnQwMXo0MzJsM3JrMmVvaW9xIn0._JPXczrSxb1MBYdvpc16WQ'
    }).addTo(fullMap);

    // Get locations data and populate map with markers
    jQuery.getJSON('/api/locations/', function (response) {
        response.forEach(function(location) {
            console.log(location);
            var marker = L.marker([location.latitude, location.longitude]).addTo(fullMap);
            marker.bindPopup('<b>' + location.name + '</b>');
        });
    });

    // Draw connections between points --> refactor later
    var connections = JSON.parse('{!! json_encode($connections) !!}');
    connections.forEach(function (connection) {
        console.log(connection);
        L.polyline(connection).addTo(fullMap);
    });

</script>

@endsection