var markers = [];
var routePath;
var map;

function createMarker(marker) {
    markers.push(
        new google.maps.Marker({
            position: {
                lat: marker.lat,
                lng: marker.lng
            },
            map: map,
            title: marker.name
        })
    );
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
        console.log("coordinate " + i);
        console.log(list_coordinates[i]);
        if (list_coordinates[i].hasOwnProperty("name")) {
            console.log("name " + list_coordinates[i].name);
            createMarker(list_coordinates[i]);
        }
    }
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
}