// Function to add event listeners to "Show on Map" buttons
function addShowOnMapEventListeners() {
    // Get all elements with the class 'show-on-map'
    var showOnMapButtons = document.querySelectorAll('.show-on-map');
    showOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Check if the mapView variable is undefined or null
            if (typeof mapView === 'undefined' || mapView === null) {
                // If mapView is not defined or null, display an error message
                const alertDiv = document.querySelector('.alert.alert-danger');
                if (alertDiv) {
                    const li = alertDiv.querySelector('li');
                    if (li) {
                        // Set the text content of the list item to show the error message
                        li.textContent = "Open the map first!";
                        alertDiv.classList.remove('hide');
                        // Scroll the alert div into view
                        alertDiv.scrollIntoView({behavior: 'smooth', block: 'start'});

                        // Add close icon dynamically
                        const closeIcon = document.createElement('span');
                        closeIcon.className = 'bi bi-x';
                        li.appendChild(closeIcon); // Append the close icon to the list item

                        // Add event listener to close icon
                        closeIcon.addEventListener('click', function() {
                            // When the close icon is clicked, add the 'hide' class to the alert div to hide it
                            alertDiv.classList.add('hide');
                        });
                    }
                }
            }
        });
    });
}

// Call the addShowOnMapEventListeners function after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', addShowOnMapEventListeners);
