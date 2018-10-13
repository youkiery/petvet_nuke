$(document).ready(function() {
    initializeGoogleMap();

});

// Call this function when the page has been loaded
function initializeGoogleMap() {
    var myLatlng = new google.maps.LatLng(21.015311,105.833294);
    var myOptions = {
        zoom: 15,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("google-map-location"), myOptions);

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map
    });
}

