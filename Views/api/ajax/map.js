var map = L.map('map').setView([51.505, -0.09], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Fetch delivery points data from the server
const url = '/map';
ajax.get(url, (error, response) => {
    if (error) {
        console.error('Error fetching delivery points:', error);
    } else {
        const data = JSON.parse(response);
        console.log("Fetched parcels for Markers: \n ", data);
        // Loop through the delivery points and add markers
        data.forEach(point => {
            var marker = L.marker([point.lat, point.lng]).addTo(map);
            marker.bindPopup(`
                <b>${point.id}</b><br>
                <b>${point.name}</b><br>
                ${point.address_1}<br>
                ${point.address_2}<br>
                ${point.postcode}
                <div id="qrcode_${point.id}"></div>
            `);

            // Add event listener to open popup
            marker.on('popupopen', function () {
                // Generate QR code for the delivery record
                var qr = new QRCode(document.getElementById(`qrcode_${point.id}`), {
                    text: `/map/${point.id}`,
                    width: 100,
                    height: 100
                });
                console.log("Fetched parcels for QR Generation \n ", qr);
            });
        });
    }
});

if (navigator.geolocation) {
    // Get the user's current position
    navigator.geolocation.getCurrentPosition(function(position) {
        // Get latitude and longitude from the position object
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;

        // Set the map view to the user's geolocation
        map.setView([lat, lon], 13);
    }, function(error) {
        console.error('Error getting user location:', error);
    });
} else {
    // If geolocation is not supported by the browser
    console.error('Geolocation is not supported by this browser.');
}