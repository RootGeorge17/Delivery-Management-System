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