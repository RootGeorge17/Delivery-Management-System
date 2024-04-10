// Function to add event listeners to "Show on Map" buttons
function addShowOnMapEventListeners() {
    var showOnMapButtons = document.querySelectorAll('.show-on-map');
    showOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var lat = parseFloat(this.dataset.lat);
            var lng = parseFloat(this.dataset.lng);
            try {
                mapView.DoSetView([lat, lng], 15);
            } catch (e) {
                console.log(e + "Open the map!")
            }

        });
    });
}

// Call the function after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', addShowOnMapEventListeners);