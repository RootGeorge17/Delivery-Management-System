// Function to add event listeners to "Show on Map" buttons
function addShowOnMapEventListeners() {
    var showOnMapButtons = document.querySelectorAll('.show-on-map');
    showOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // if DOMContent not Loaded from Views/api/AjaxViews/MapView.js, give error
            if (typeof mapView === 'undefined' || mapView === null) {
                // Display an error message
                const alertDiv = document.querySelector('.alert.alert-danger');
                if (alertDiv) {
                    const li = alertDiv.querySelector('li');
                    if (li) {
                        li.textContent = "Open the map first!";
                        alertDiv.classList.remove('hide');
                        alertDiv.scrollIntoView({behavior: 'smooth', block: 'start'});

                        // Add close icon dynamically
                        const closeIcon = document.createElement('span');
                        closeIcon.className = 'bi bi-x';
                        li.appendChild(closeIcon);

                        // Add event listener to close icon
                        closeIcon.addEventListener('click', function() {
                            alertDiv.classList.add('hide');
                        });
                    }
                }
            }
        });
    });
}

// Call the function after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', addShowOnMapEventListeners);
