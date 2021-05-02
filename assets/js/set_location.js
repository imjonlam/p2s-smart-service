function init() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(setAddress);
  }
}

function setAddress(position) {
  const geocoder = new google.maps.Geocoder();
  const latlng = {lat: position.coords.latitude, lng: position.coords.longitude};

  geocoder.geocode({location: latlng}, (results, status) => {
    if (status === 'OK') {
      if (results[0]) {
        $('.geo_location').val(results[0].formatted_address)
        $('.geo_location').trigger('change');
      }
    }
  });
}