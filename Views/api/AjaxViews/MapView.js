class MapView extends Ajax {
    constructor() {
        super();
        this.map = null;
        this.initMap();
    }

    initMap() {
        this.map = L.map('map').setView([51.505, -0.09], 15);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 15,
            minZoom: 6,
        }).addTo(this.map);

        this.fetchDeliveryPoints();
        this.getUserLocation();
    }

    DoSetView([lat, lng], zoom) {
        this.map.flyTo([lat, lng], zoom);
    }

    fetchDeliveryPoints() {
        setTimeout(() => {
            const baseUrl = `/map`;
            const url = this.addTokenToUrl(baseUrl);
            console.log(url);

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
                            this.addMarker(point);
                        });
                    }
                }
            });
        }, "100");
    }

    fetchDeliveryPoint(lat, lng) {
        setTimeout(() => {
            const baseUrl = `/point`;
            const url = `${baseUrl}?lat=${lat}&lng=${lng}`;
            const urlWithToken = this.addTokenToUrl(url);

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
                            this.addMarker(responseData);
                            this.DoSetView([lat, lng], 15);
                        }
                    }
                }
            });
        }, "50");
    }

    addMarker(point) {
        const marker = L.marker([point.lat, point.lng]).addTo(this.map);
        marker.bindPopup(`
            <b>${point.id}</b><br>
            <b>${point.name}</b><br>
            ${point.address_1}<br>
            ${point.address_2}<br>
            ${point.postcode}
            <div id="qrcode_${point.id}"></div>
        `);

        marker.on('popupopen', () => {
            const qr = new QRCode(document.getElementById(`qrcode_${point.id}`), {
                text: `https://sgc017.poseidon.salford.ac.uk/?parcel=${point.id}`,
                width: 100,
                height: 100,
            });
            console.log("Fetched parcels for QR Generation \n ", qr);
        });
    }

    geolocationMarker(lat, lng) {
        const marker = L.circleMarker([lat, lng], {
            color: 'blue',
            fillColor: '#00008b',
            fillOpacity: 1,
            radius: 10
        }).addTo(this.map);
    }

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

    isMarkerPresent(lat, lng) {
        const markers = this.map._layers;
        return Object.values(markers).some(marker => {
            if (marker instanceof L.Marker) {
                const markerPosition = marker.getLatLng();
                return markerPosition.lat === lat && markerPosition.lng === lng;
            }
            return false;
        });
    }

    getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    this.map.setView([latitude, longitude], 13);
                    this.geolocationMarker(latitude, longitude);
                },
                (error) => {
                    this.renderAlert('Error getting user location. Follow this tutorial to allow your location to be shared: https://support.google.com/chrome/answer/142065?hl=en&co=GENIE.Platform%3DDesktop');
                }
            );
        } else {
            this.renderAlert('Geolocation is not supported by this browser.');
        }
    }
}

// Instantiate the MapView class
const mapView = new MapView();
map = document.getElementById("map");

// Function to add event listeners to "Show on Map" buttons
function addShowOnMapEventListeners(mapView) {
    var showOnMapButtons = document.querySelectorAll('.show-on-map');

    showOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var lat = parseFloat(this.dataset.lat);
            var lng = parseFloat(this.dataset.lng);

            try {
                if(mapView.isMarkerPresent(lat, lng))
                {
                    map.scrollIntoView({behavior: 'smooth', block: 'start'});
                    mapView.DoSetView([lat, lng], 15);
                } else {
                    mapView.fetchDeliveryPoint(lat, lng);
                }

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

const deliveredButtons = document.querySelectorAll('.delivered');
const noAnswerButtons = document.querySelectorAll('.no-answer');
const statusDropdownItems = document.querySelectorAll('.status-dropdown');

deliveredButtons.forEach(button => {
    button.addEventListener('click', () => {
        const lat = parseFloat(button.closest('.delivery-point').querySelector('[data-lat]').getAttribute('data-lat'));
        const lng = parseFloat(button.closest('.delivery-point').querySelector('[data-lng]').getAttribute('data-lng'));
        if(mapView.isMarkerPresent(lat, lng))
        {
            mapView.removeMarker(lat, lng);
        }
    });
});

noAnswerButtons.forEach(button => {
    button.addEventListener('click', () => {
        const lat = parseFloat(button.closest('.delivery-point').querySelector('[data-lat]').getAttribute('data-lat'));
        const lng = parseFloat(button.closest('.delivery-point').querySelector('[data-lng]').getAttribute('data-lng'));
        if(!mapView.isMarkerPresent(lat, lng))
        {
            document.getElementById("map").scrollIntoView({behavior: 'smooth'});
            mapView.fetchDeliveryPoint(lat, lng);
        }
    });
});

statusDropdownItems.forEach(item => {
    item.addEventListener('click', () => {
        const lat = parseFloat(item.closest('.delivery-point').querySelector('[data-lat]').getAttribute('data-lat'));
        const lng = parseFloat(item.closest('.delivery-point').querySelector('[data-lng]').getAttribute('data-lng'));
        const newStatus = item.textContent.trim().slice(9);

        if (newStatus === "Delivered") {
            if(mapView.isMarkerPresent(lat, lng))
            {
                mapView.removeMarker(lat, lng);
            }
        } else {
            if(!mapView.isMarkerPresent(lat, lng))
            {
                mapView.fetchDeliveryPoint(lat, lng);
            } 
        }
    });
});


// Call the function after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', function() {
    addShowOnMapEventListeners(mapView);
});