document.getElementById('loadMapButton').addEventListener('click', function() {
    // Remove the hide class to show the map
    document.getElementById('map').classList.remove('hide');

    // Load map.js dynamically
    var mapScript = document.createElement('script');
    mapScript.src = 'Views/api/ajax/map.js';
    document.body.appendChild(mapScript);

    // Remove the button after loading the map
    this.remove();
});
