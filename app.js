
function test(data_as_string){
    console.log(data_as_string)
    const data = JSON.parse(data_as_string);
    console.log(data)
    let marker = L.marker([data.lat, data.lon], {
        icon: L.divIcon({
            className: '',
            html: `
                <button class="marker" mix-get="api-get-item?item_pk=${data.item_pk}"></button>
            `,
        }),            
        item_pk: data.item_pk
    }).addTo(map);
    marker.on('click', function (e) {
    }); 

    mix_convert()
}


