<main>

    <div id="map">
        map
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize the map
        const map = L.map('map').setView([51.505, -0.09], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add a marker
        const marker = L.marker([51.505, -0.09]).addTo(map);
        marker.bindPopup("<b>Hello!</b><br>This is a Leaflet map.").openPopup();
    </script>




    <aside>
        property
    </aside>

</main>



