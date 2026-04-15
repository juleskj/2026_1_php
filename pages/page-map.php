<?php
    ini_set('memory_limit', '512M');
    session_start();
    $title = "Map";
    require_once __DIR__ . '/../session_utils.php';
    require_once __DIR__ . "/../db.php";

    // looks if there is any item_pk sent
    if (isset($_GET["item_pk"])) {
        $item_pk = $_GET["item_pk"];

        $viewed_homes = track_viewed_homes();

    }
    else {
        $item_pk = null;
    }


    $sql = "SELECT * FROM `items`";
    $stmt = $_db->prepare( $sql );
    
    $stmt->execute();

    $items = $stmt->fetchAll();

    $items = json_encode($items);
?>
   
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const item_pk = <?= json_encode($item_pk)?>
        

        if (item_pk) {
            fetch(`api-get-map-item?item_pk=${encodeURIComponent(item_pk)}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('info').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>


<?php

    require_once __DIR__ . "/../micro-components/_header.php"
?>
    <main id="page-map">
        <section class="map-container">

            <form id="map-form" mix-post action="api-search">
                
                <label for="bed-select">beds:</label>

                <select name="beds" id="bed-select">
                <option value="0">any</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                </select>

                <label for="bath-select">baths:</label>

                <select name="baths" id="bath-select">
                <option value="0">any</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                </select>
                
                <input type="text" min="<?= _(city_search_min)?>" max="<?= _(city_search_max)?>" name="city_name">
                
                <button class="filled-btn white">Go</button>
            </form>            
                  

            <div id="map"></div>
    
            <script>

                // Create custom icon
                var house_icon = L.icon({
                    // iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    iconSize: [24, 24],
                    iconAnchor: [16, 16],
                    popupAnchor: [0, -24]
                });
                var apartment_icon = L.icon({
                    // iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                    iconUrl: 'http://127.0.0.1/static/apartment.svg',
                    iconSize: [24, 24],
                    iconAnchor: [16, 16],
                    popupAnchor: [0, -24]
                });
    
                // Initialize the map
                const map = L.map('map').setView([55.67960020013266, 12.56464935119663], 7);
    
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OpenStreetMap &copy; CARTO',
                    subdomains: 'abcd',
                    maxZoom: 18
                }).addTo(map);
    
                // var markers = L.markerClusterGroup();
                var markers = L.markerClusterGroup({
                    disableClusteringAtZoom: 15,  // <- key option
                    spiderfyOnMaxZoom: true,
                    // showCoverageOnHover: false,
                    maxClusterRadius: 100   // default is 100 pixels
                });
                
                
                let items = <?=  $items?>       
                    
                
                
                items.forEach(item => {
                    var marker = L.marker([item.lat, item.lon], {
                        icon: L.divIcon({
                            className: '',
                            html: `
                                <button 
                                    class="marker  ${item.type.replaceAll(" ", "_")}"
                                    data-item-pk="${item.pk}"
                                    onclick="showInfo(this)">
                                </button>
                            `,
                        }),
                        item_pk: item.pk
                    });
                    markers.addLayer(marker)
                });
                map.addLayer(markers)
    
    
            </script>
    
    
            <aside class="hidden" id="info"></aside>
        </section>
    </main>
  


<?php

    require_once __DIR__ . "/../micro-components/_footer.php"

?>