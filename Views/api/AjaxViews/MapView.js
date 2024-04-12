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
        const url = '/map';
        this.get(url, (error, response) => {
            if (error) {
                console.error('Error fetching delivery points:', error);
            } else {
                const data = JSON.parse(response);
                console.log("Fetched parcels for Markers: \n ", data);
                data.forEach(point => {
                    this.addMarker(point);
                });
            }
        });
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
                    console.error('Error getting user location:', error);
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }
}

// Instantiate the MapView class
const mapView = new MapView();