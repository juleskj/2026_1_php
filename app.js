
function clearMarkers(data){
    const urlParams = new URLSearchParams(window.location.search)

    // clears the markers
    markers.clearLayers()

    // makes the data in json
    data = JSON.parse(data)
    
    data.url.forEach( prop => {
        let key = Object.keys(prop)[0] // beds | baths  
        let value = prop[key] // 2 | 1
        // makes the value 0 so that it say any instead
        if(value == 0){
            value = "any"
        }
        
        urlParams.set(key, value)
    } )
    window.history.replaceState({}, '', `?${urlParams.toString()}`)
    
    // search zoom and view on #info
    viewSearch(map, data);

    data.items.forEach(item => {
        
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
}


function viewSearch(map,data){
     //set to that item we search  
    const searchInput= document.querySelector('input[name="city_name"]');
    const selectBeds= document.querySelector('select[name="beds"]');
    const selectBaths= document.querySelector('select[name="baths"]');
   

    if(searchInput.value != "" || selectBeds.value  != 0 || selectBaths.value  != 0){
        // got to first item in searched data
        map.flyTo([data.items[0].lat, data.items[0].lon], 9);
        
        // shows the first item in the data in the aside
        fetch(`api-get-map-item?item_pk=${encodeURIComponent(data.items[0].pk)}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('info').innerHTML = html;
            
        })
        .catch(error => {
            console.error('Error:', error);
        });

    }else{
       map.flyTo([55.67960020013266, 12.56464935119663], 7); 
    }
}


function zoomOnMark(item){
    
    item = JSON.parse(item);
    map.flyTo([item.lat, item.lon], 11);
}


function showInfo(button) {
    
    document.getElementById('info').classList.remove('hidden');

    
    const itemPk = button.getAttribute('data-item-pk');

    
    fetch(`api-get-map-item?item_pk=${itemPk}`)
        .then(response => response.text())
        .then(data => {
            // Update the aside's content
            document.getElementById('info').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}


function logout(){
    fetch('api-logout', {
        method: 'POST', 
        credentials: 'same-origin'
    })
    .then(response => {
        if (response.ok) {
            
            window.location.reload();
        } else {
            alert('Logout failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred during logout.');
    });
}

function inputOnChange(input){
    console.log("changing");

    const file = input.files[0];
    if(file) {
    document.getElementById('profile-img').src = window.URL.createObjectURL(file);
    }


}