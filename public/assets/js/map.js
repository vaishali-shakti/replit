let map;
let marker;

function initMap(lat,long) {
// Initialize the map
var mylatlog = { lat: parseFloat(lat), lng: parseFloat(long) };
map = new google.maps.Map(document.getElementById('map'), {
    // center: mylatlog,
    center: mylatlog,
    zoom: 15
});

// Create a div for the search box
const inputDiv = document.createElement('div');
const input = document.createElement('input');
input.setAttribute('id', 'searchInput');
input.setAttribute('type', 'text');
input.setAttribute('placeholder', 'Search for a location');
inputDiv.appendChild(input);

// Add the search box to the map in the TOP_CENTER position
map.controls[google.maps.ControlPosition.TOP_CENTER].push(inputDiv);

// Initialize the Places Autocomplete service
const autocomplete = new google.maps.places.Autocomplete(input);

// Add a marker to the map
marker = new google.maps.Marker({
    position: mylatlog,
    map: map
});

// Add a listener for the Place changed event
autocomplete.addListener('place_changed', function () {
    // Get the selected place from the Autocomplete service
    const place = autocomplete.getPlace();

    if (place.geometry) {
    // Move the marker to the selected place's location
    moveMarker(place.geometry.location.lat(), place.geometry.location.lng());
    } else {
    console.error("Place details not found for the input.");
    }
});

// Add a click event listener to the map
map.addListener('click', function (event) {
    // Get the clicked location's latitude and longitude
    const newLat = event.latLng.lat();
    const newLng = event.latLng.lng();

    $("#latitude").val(newLat);
    $("#longitude").val(newLng);
    // Move the marker to the new location
    moveMarker(newLat, newLng);
});
}

function moveMarker(newLat, newLng) {
// Set the marker's new position

$("#latitude").val(newLat);
$("#longitude").val(newLng);
marker.setPosition({ lat: newLat, lng: newLng });

// Optionally, you can center the map on the new marker position
map.setCenter({ lat: newLat, lng: newLng });
}
