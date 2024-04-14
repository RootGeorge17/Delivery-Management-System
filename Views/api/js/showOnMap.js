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
                const alertDiv = document.querySelector('.alert.alert-danger');
                if (alertDiv) {
                    const li = alertDiv.querySelector('li');
                    if (li) {
                        li.textContent = "Open the map first!";
                        alertDiv.classList.remove('hide');

                        setTimeout(() => {
                            alertDiv.classList.add('hide');
                        }, 5000);
                    }
                }
            }
        });
    });
}

// Call the function after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', addShowOnMapEventListeners);