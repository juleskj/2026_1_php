<main>

    <div id="map">
        map
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize the map
        const map = L.map('map').setView([55.67960020013266, 12.56464935119663], 12);

L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; OpenStreetMap &copy; CARTO',
    subdomains: 'abcd',
    maxZoom: 20
}).addTo(map);

        // Add OpenStreetMap tiles
        /*
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        */
        // Add a marker
    
        let marker = L.marker([55.67960020013266, 12.56464935119663], {
            icon: L.divIcon({
                className: '', // removes default marker styles
                html: `
                    <button class="marker" mix-get="api-get-item?item_pk=1"></button>
                `,
                //iconSize: [20, 20],      // size of button
                //iconAnchor: [20, 20]      // center it properly
            }),            
            item_pk: "1"
        }).addTo(map);
        marker.on('click', function (e) {
            // alert("Marker ID: " + this.options.item_pk);
        }); 
        
        
        marker = L.marker([55.6899549465982, 12.526712188294855], {
            icon: L.divIcon({
                className: '', // removes default marker styles
                html: `
                    <button class="marker" mix-get="api-get-item?item_pk=2"></button>
                `,
                //iconSize: [20, 20],      // size of button
                //iconAnchor: [20, 20]      // center it properly
            }),             
            item_pk: "2"
        }).addTo(map);
        marker.on('click', function (e) {
            // alert("Marker ID: " + this.options.item_pk);
        });           

    </script>




    <aside>
        property
    </aside>

</main>



