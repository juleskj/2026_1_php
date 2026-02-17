<main>

    <div id="map">
        map
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize the map
        const map = L.map('map').setView([55.67960020013266, 12.56464935119663], 10);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add a marker
        let marker = L.marker([55.67960020013266, 12.56464935119663]).addTo(map);
        marker.bindPopup("20").openPopup();

        marker = L.marker([55.6899549465982, 12.526712188294855]).addTo(map);
        marker.bindPopup("20").openPopup();        
    </script>




    <aside>
        property
    </aside>

</main>



