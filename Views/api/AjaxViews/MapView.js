/**
 * @description MapView class for loading and fetching the map and any data necessary for the user.
 */
class MapView extends Ajax {
    /**
     * Constructor for the MapView class.
     * Extends the Ajax class and initializes an instance of the Leaflet map.
     */
    constructor() {
        super();
        this.map = null;
        this.initMap();
    }

    /**
     * Initializes the Leaflet map and sets up the tile layer.
     * Fetches delivery points and gets the user's location.
     */
    initMap() {
        // Create a new Leaflet map and set the initial view
        this.map = L.map('map').setView([51.505, -0.09], 15);

        // Add a tile layer from OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 15,
            minZoom: 6,
        }).addTo(this.map);

        // Fetch delivery points and get the user's location
        this.fetchDeliveryPoints();
        this.getUserLocation();
    }

    /**
     * Sets the view of the map to the specified latitude, longitude, and zoom level.
     * @param {Array} [lat, lng] - The latitude and longitude coordinates.
     * @param {number} zoom - The zoom level of the map.
     */
    DoSetView([lat, lng], zoom) {
        this.map.flyTo([lat, lng], zoom);
    }

    /**
     * Fetches delivery points from the server and adds markers to the map.
     */
    fetchDeliveryPoints() {
        setTimeout(() => {
            const baseUrl = `/map`;
            const url = this.addTokenToUrl(baseUrl); // Adds the token to the base URL as a query parameter
            console.log(url);

            // Fetch delivery points data from server
            this.get(url, (error, response) => {
                if (error) {
                    this.renderAlert('Error fetching delivery points:', error);
                } else {
                    const data = JSON.parse(response);
                    if (data.error) {
                        this.renderAlert('Error fetching delivery points:', data.error);
                    } else {
                        console.log("Fetched parcels for Markers: \n ", data);
                        data.forEach(point => {
                            // Add markers for each delivery point
                            this.addMarker(point);
                        });
                    }
                }
            });
        }, "100");
    }

    /**
     * Fetches a single delivery point from the server and adds a marker to the map.
     * @param {number} lat - The latitude coordinate of the delivery point.
     * @param {number} lng - The longitude coordinate of the delivery point.
     */
    fetchDeliveryPoint(lat, lng) {
        setTimeout(() => {
            const baseUrl = `/point`;
            const url = `${baseUrl}?lat=${lat}&lng=${lng}`; // query params
            const urlWithToken = this.addTokenToUrl(url); // Adds the token to the base URL as a query parameter

            // Fetch data for a single delivery point
            this.get(urlWithToken, (error, response) => {
                const responseData = JSON.parse(response);

                if (responseData === "Delivery already completed") {
                    this.renderAlert('Completed deliveries are not shown on the map for privacy reasons!');
                } else {
                    if (error) {
                        this.renderAlert('Error fetching delivery point:', error);
                    } else {
                        if (responseData.error) {
                            this.renderAlert('Error fetching delivery point:', responseData.error);
                        } else {
                            // Add marker for delivery point
                            this.addMarker(responseData);
                            this.DoSetView([lat, lng], 15);
                        }
                    }
                }
            });
        }, "50");
    }

    /**
     * Adds a marker to the map for a delivery point.
     * @param {Object} point - The delivery point data.
     */
    addMarker(point) {
        // Add marker to the map
        const marker = L.marker([point.lat, point.lng]).addTo(this.map);
        // Bind popup with delivery point information
        marker.bindPopup(`
            <b>${point.id}</b><br>
            <b>${point.name}</b><br>
            ${point.address_1}<br>
            ${point.address_2}<br>
            ${point.postcode}
            <div id="qrcode_${point.id}"></div>
        `);

        // Generate a QR code when the popup is opened
        marker.on('popupopen', () => {
            const qr = new QRCode(document.getElementById(`qrcode_${point.id}`), {
                text: `https://sgc017.poseidon.salford.ac.uk/?parcel=${point.id}`,
                width: 100,
                height: 100,
            });
            console.log("Fetched parcels for QR Generation \n ", qr);
        });
    }

    /**
     * Adds a marker to the map for the user's geolocation.
     * @param {number} lat - The latitude coordinate of the user's location.
     * @param {number} lng - The longitude coordinate of the user's location.
     */
    geolocationMarker(lat, lng) {
        // Add marker for user's geolocation
        const marker = L.circleMarker([lat, lng], {
            color: 'blue',
            fillColor: '#00008b',
            fillOpacity: 1,
            radius: 10
        }).addTo(this.map);
    }

    /**
     * Removes a marker from the map at the specified latitude and longitude.
     * @param {number} lat - The latitude coordinate of the marker.
     * @param {number} lng - The longitude coordinate of the marker.
     */
    removeMarker(lat, lng) {
        // Iterate through all layers on the map
        Object.values(this.map._layers).forEach(layer => {
            // Check if the layer is a marker and its position matches the lat and lng
            if (layer instanceof L.Marker && layer.getLatLng().lat === lat && layer.getLatLng().lng === lng) {
                // Remove the marker from the map
                this.map.removeLayer(layer);
            }
        });
    }

    /**
     * Checks if a marker is present on the map at the specified latitude and longitude.
     * @param {number} lat - The latitude coordinate to check.
     * @param {number} lng - The longitude coordinate to check.
     * @returns {boolean} - True if a marker is present at the specified coordinates, false otherwise.
     */
    isMarkerPresent(lat, lng) {
        // Retrieve all layers on the map
        const markers = this.map._layers;
        // Check if any marker is present at the specified coordinates
        return Object.values(markers).some(marker => {
            if (marker instanceof L.Marker) {
                const markerPosition = marker.getLatLng(); // Get the marker's position
                return markerPosition.lat === lat && markerPosition.lng === lng; // Compare marker's position with specified coordinates
            }
            return false;
        });
    }

    /**
     * Gets the user's location and adds a marker to the map.
     * If geolocation is not supported or an error occurs, it renders an alert.
     */
    getUserLocation() {
        // Check if geolocation is supported by the browser
        if (navigator.geolocation) {
            // Attempt to get the current position
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    // If successful, set map view to user's location and add marker
                    const { latitude, longitude } = position.coords;
                    this.map.setView([latitude, longitude], 13);
                    this.geolocationMarker(latitude, longitude);
                },
                (error) => {
                    // If there's an error, render an alert with instructions for allowing location sharing
                    this.renderAlert('Error getting user location. Follow this tutorial to allow your location to be shared: https://support.google.com/chrome/answer/142065?hl=en&co=GENIE.Platform%3DDesktop');
                }
            );
        } else {
            // If geolocation is not supported, render an alert informing the user
            this.renderAlert('Geolocation is not supported by this browser.');
        }
    }
}

// Instantiate the MapView class
const mapView = new MapView();
map = document.getElementById("map");

// Function to add event listeners to "Show on Map" buttons
function addShowOnMapEventListeners(mapView) {
    // Get all elements with the class 'show-on-map'
    var showOnMapButtons = document.querySelectorAll('.show-on-map');

    // Loop through each button and add a click event listener
    showOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Get the latitude and longitude from the data attributes
            var lat = parseFloat(this.dataset.lat);
            var lng = parseFloat(this.dataset.lng);

            try {
                // Check if a marker is already present at the specified coordinates
                if(mapView.isMarkerPresent(lat, lng))
                {
                    // If a marker is present, scroll the map into view and set the view to the marker coordinates
                    map.scrollIntoView({behavior: 'smooth', block: 'start'});
                    mapView.DoSetView([lat, lng], 15);
                } else {
                    // If no marker is present, fetch and add the delivery point marker
                    mapView.fetchDeliveryPoint(lat, lng);
                }

            } catch (e) {
                // If an error occurs display an error message
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

const deliveredButtons = document.querySelectorAll('.delivered'); // Get all elements with the class 'delivered'
const noAnswerButtons = document.querySelectorAll('.no-answer'); // Get all elements with the class 'no-answer'
const statusDropdownItems = document.querySelectorAll('.status-dropdown'); // Get all elements with the class 'status-dropdown'

// Add a click event listener to each 'delivered' button
deliveredButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Get the latitude and longitude from the closest 'delivery-point' element
        const lat = parseFloat(button.closest('.delivery-point').querySelector('[data-lat]').getAttribute('data-lat'));
        const lng = parseFloat(button.closest('.delivery-point').querySelector('[data-lng]').getAttribute('data-lng'));
        if(mapView.isMarkerPresent(lat, lng))
        {
            // If a marker is present at the specified coordinates, remove it
            mapView.removeMarker(lat, lng);
        }
    });
});

// Add a click event listener to each 'no-answer' button
noAnswerButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Get the latitude and longitude from the closest 'delivery-point' element
        const lat = parseFloat(button.closest('.delivery-point').querySelector('[data-lat]').getAttribute('data-lat'));
        const lng = parseFloat(button.closest('.delivery-point').querySelector('[data-lng]').getAttribute('data-lng'));
        if(!mapView.isMarkerPresent(lat, lng))
        {
            // If no marker is present at the specified coordinates, fetch and add the delivery point marker
            document.getElementById("map").scrollIntoView({behavior: 'smooth'});
            mapView.fetchDeliveryPoint(lat, lng);
        }
    });
});

// Add a click event listener to each 'status-dropdown' item
statusDropdownItems.forEach(item => {
    item.addEventListener('click', () => {
        const lat = parseFloat(item.closest('.delivery-point').querySelector('[data-lat]').getAttribute('data-lat'));
        const lng = parseFloat(item.closest('.delivery-point').querySelector('[data-lng]').getAttribute('data-lng'));
        const newStatus = item.textContent.trim().slice(9); // Get the new status from the item's text content

        // If the new status is "Delivered", remove the marker if present
        if (newStatus === "Delivered") {
            if(mapView.isMarkerPresent(lat, lng))
            {
                mapView.removeMarker(lat, lng);
            }
        } else {
            // If the new status is not "Delivered", fetch and add the delivery point marker if not present, or set the view to the marker if present
            if(!mapView.isMarkerPresent(lat, lng))
            {
                mapView.fetchDeliveryPoint(lat, lng);
            } else {
                mapView.DoSetView([lat, lng], 15);
            }
        }
    });
});


// Call the function to add event listeners to "Show on Map" buttons after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', function() {
    addShowOnMapEventListeners(mapView);
});