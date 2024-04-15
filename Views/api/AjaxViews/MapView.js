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
        this.map.setView([lat, lng], zoom);
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
                    console.log("Fetched parcels for Markers: \n ", data);
                    data.forEach(point => {
                        this.addMarker(point);
                    });
                }
            });
        }, "1");
    }

    fetchDeliveryPoint(lat, lng) {
        setTimeout(() => {
            const baseUrl = `/point`;
            const url = `${baseUrl}?lat=${lat}&lng=${lng}`;
            const urlWithToken = this.addTokenToUrl(url);
            console.log(urlWithToken);

            this.get(urlWithToken, (error, response) => {
                console.log(response);
                const responseData = JSON.parse(response); // Parse the JSON response
                if (responseData === "Delivery already completed") {
                    this.renderAlert('Completed deliveries are not shown on the map!');
                } else {
                    if (error) {
                        this.renderAlert('Error fetching delivery point:', error);
                    } else {
                        console.log(responseData);
                        if (responseData.error) {
                            this.renderAlert('Error fetching delivery point:', responseData.error);
                        } else {
                            this.addMarker(responseData);
                            this.DoSetView([lat, lng], 15);
                        }
                    }
                }
            });
        }, "1");
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
                text: `/map/${point.id}`,
                width: 100,
                height: 100,
            });
            console.log("Fetched parcels for QR Generation \n ", qr);
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

// Function to add event listeners to "Show on Map" buttons
function addShowOnMapEventListeners(mapView) {
    var showOnMapButtons = document.querySelectorAll('.show-on-map');

    showOnMapButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var lat = parseFloat(this.dataset.lat);
            var lng = parseFloat(this.dataset.lng);
            console.log('Clicked button with lat:', lat, 'lng:', lng);
            console.log(!mapView.isMarkerPresent(lat, lat));

            try {
                if (!mapView.isMarkerPresent(lat, lat)) {
                    mapView.fetchDeliveryPoint(lat, lng);
                } else {
                    console.log("Was on the map");
                    mapView.DoSetView([lat, lng], 15);
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

// Call the function after the HTML content has finished loading
document.addEventListener('DOMContentLoaded', function() {
    addShowOnMapEventListeners(mapView);
});