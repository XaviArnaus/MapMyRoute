if ("geolocation" in navigator) {
    // check if geolocation is supported/enabled on current browser
    navigator.geolocation.getCurrentPosition(
        function success(position) {
            // for when getting location is a success
            console.log('latitude', position.coords.latitude,
                'longitude', position.coords.longitude);
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        },
        function error(error_message) {
            // for when getting location results in an error
            console.error('An error has occured while retrieving location', error_message);
        });
} else {
    // geolocation is not supported
    // get your location some other way
    console.log('geolocation is not enabled on this browser')
}