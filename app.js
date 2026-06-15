function clearMarkers(data) {
  const urlParams = new URLSearchParams(window.location.search);
  markers.clearLayers();
  data = JSON.parse(data);
  data.url.forEach((prop) => {
    let key = Object.keys(prop)[0];
    let value = prop[key];
    if (value == 0) {
      value = "any";
    }
    urlParams.set(key, value);
  });
  window.history.replaceState({}, "", `?${urlParams.toString()}`);
  viewSearch(map, data);
  data.items.forEach((item) => {
    var marker = L.marker([item.lat, item.lon], {
      icon: L.divIcon({
        className: "",
        html: `
                    <button 
                        class="marker  ${item.type.replaceAll(" ", "_")}"
                        data-item-pk="${item.pk}"
                        onclick="showInfo(this)">
                    </button>
                `,
      }),
      item_pk: item.pk,
    });
    markers.addLayer(marker);
  });
  map.addLayer(markers);
}
function viewSearch(map, data) {
  const searchInput = document.querySelector('input[name="city_name"]');
  const selectBeds = document.querySelector('select[name="beds"]');
  const selectBaths = document.querySelector('select[name="baths"]');
  if (
    searchInput.value != "" ||
    selectBeds.value != 0 ||
    selectBaths.value != 0
  ) {
    map.flyTo([data.items[0].lat, data.items[0].lon], 9);
    fetch(`api-get-map-item?item_pk=${encodeURIComponent(data.items[0].pk)}`)
      .then((response) => response.text())
      .then((html) => {
        document.getElementById("info").innerHTML = html;
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    map.flyTo([55.67960020013266, 12.56464935119663], 7);
  }
}
function zoomOnMark(item) {
  item = JSON.parse(item);
  map.flyTo([item.lat, item.lon], 11);
}
function showInfo(button) {
  document.getElementById("info").classList.remove("hidden");
  const itemPk = button.getAttribute("data-item-pk");
  fetch(`api-get-map-item?item_pk=${itemPk}`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("info").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
function logout() {
  fetch("api-logout", { method: "POST", credentials: "same-origin" })
    .then((response) => {
      if (response.ok) {
        window.location.reload();
      } else {
        alert("Logout failed. Please try again.");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred during logout.");
    });
}
function inputOnChange(input) {
  console.log("changing");
  const file = input.files[0];
  if (file) {
    document.getElementById("profile-img").src =
      window.URL.createObjectURL(file);
  }
}
function showModule(button) {
  console.log(button);
  const module = button.dataset.module;
  console.log(module);
  const closetModule = button.closest(`#${module}-module`);
  const closetForm = closetModule.querySelector(`#${module}-form`);
  closetForm.classList.toggle("hidden");
}
