// Add a click event listener to the button with the ID 'loadMapButton' to display map on user request
document.getElementById('loadMapButton').addEventListener('click', function() {
    // Remove the hide class to show the map
    document.getElementById('map').classList.remove('hide');

    // Load map.js dynamically
    var mapScript = document.createElement('script');
    mapScript.src = 'Views/api/AjaxViews/MapView.js';

    // Add an onload event listener to the script
    mapScript.onload = function() {
        // When the script is loaded, call the addShowOnMapEventListeners function with the mapView instance
        addShowOnMapEventListeners(mapView);
    };
    // Append the script element to the document's body
    document.body.appendChild(mapScript);

    // Remove the button after loading the map
    this.remove();
});