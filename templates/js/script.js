var markers = [];
var routePath;
var map;
var latitudes = [];
var longitudes = [];

function createMarker(marker) {
    let map_marker = new google.maps.Marker({
        position: {
            lat: marker.lat,
            lng: marker.lng
        },
        map: map,
        title: marker.name
    });
    map_marker.addListener('click', function() {
        makeInfoWinfow(marker).open(map, map_marker);
    });

    markers.push(map_marker);
}

function makeInfoWinfow(marker) {
    return new google.maps.InfoWindow({
        content: "<div id='content'><b>" + marker.name + "</b><br/><i>" + marker.timestamp + "</i>&nbsp;"
    });
}

function createLine(list_coordinates) {
    routePath = new google.maps.Polyline({
        path: list_coordinates,
        geodesic: true,
        strokeColor: '{%-STROKE_COLOR-%}',
        strokeOpacity: {%-STROKE_OPACITY-%},
        strokeWeight: {%-STROKE_WEIGHT-%}
    });

    routePath.setMap(map);
}

function drawMarkers(list_coordinates) {
    for (var i = 0, len = list_coordinates.length; i < len; i++) {
        if (list_coordinates[i].hasOwnProperty("name")) {
            createMarker(list_coordinates[i]);
        }
    }
}

function calculateCenter(list_coordinates) {
    for (var i = 0, len = list_coordinates.length; i < len; i++) {
        latitudes.push(list_coordinates[i].lat);
        longitudes.push(list_coordinates[i].lng);
    }

    var lat_min = arrayMin(latitudes);
    var lat_max = arrayMax(latitudes);
    var lng_min = arrayMin(longitudes);
    var lng_max = arrayMax(longitudes);

    map.setCenter(new google.maps.LatLng(
        ((lat_max + lat_min) / 2.0),
        ((lng_max + lng_min) / 2.0)
    ));
    map.fitBounds(new google.maps.LatLngBounds(
        //bottom left
        new google.maps.LatLng(lat_min, lng_min),
        //top right
        new google.maps.LatLng(lat_max, lng_max)
    ));
}

function arrayMin(arr) {
    return arr.reduce(function (p, v) {
        return ( p < v ? p : v );
    });
}

function arrayMax(arr) {
    return arr.reduce(function (p, v) {
        return ( p > v ? p : v );
    });
}

function initMap() {
    var stackLatLng = {%-ARRAY_MARKERS-%};

    map = new google.maps.Map(document.getElementById('map'), {
            zoom: {%-INITIAL_ZOOM-%},
        center: stackLatLng[0],
        mapTypeId: 'terrain'
});

    drawMarkers(stackLatLng);
    createLine(stackLatLng);

    calculateCenter(stackLatLng);
}