function dateToDatetime() {
  var date = new Date();
  date = date.getUTCFullYear() + '-' +
      ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
      ('00' + date.getUTCDate()).slice(-2) + ' ' + 
      ('00' + date.getUTCHours()).slice(-2) + ':' + 
      ('00' + date.getUTCMinutes()).slice(-2) + ':' + 
      ('00' + date.getUTCSeconds()).slice(-2);
  return date;
}

function init() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(initMap);
  }
}

function initMap() {
  const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer();
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 10,
    center: { lat: 43.658298, lng: -79.380783 },
  });
  directionsRenderer.setMap(map);
setTimeout(function(){
    calculateAndDisplayRoute(directionsService, directionsRenderer);
    //make alert if distance is too great
    if (document.getElementById('dist').value > 50) {
      window.alert("We cannot process this order, the distance between the origin and destination of the trip is of " + document.getElementById('dist').value + " kilometers, which exceeds our limit of 50km.")
    }
}, 2000);
  
}

function calculateAndDisplayRoute(directionsService, directionsRenderer) {
  var start = document.getElementById("start").textContent;
  var end = document.getElementById("end").textContent;
  console.log(start);
  console.log(end);
  directionsService.route(
    {
      origin: {
        query: start,
      },
      destination: {
        query: end,
      },
      travelMode: google.maps.TravelMode.DRIVING
    },
    (response, status) => {
      if (status === "OK") {
        directionsRenderer.setDirections(response);
        var tot_dist = 0.0;
        response.routes[0].legs.forEach((i) => {
          tot_dist += i.distance.value/1000;
        });
        $('#dist').val(tot_dist);
      } else {
        window.alert("Directions request failed due to " + status);
      }
    }
  );
}

function afterOrderSuccess() {
  document.getElementById('first_name').readOnly = true;
  document.getElementById('last_name').readOnly = true;
  document.getElementById('email').readOnly = true;
  document.getElementById('card_number').readOnly = true;
  document.getElementById('card_expiry').readOnly = true;
  document.getElementById('card_cvv').readOnly = true;
  document.getElementById('return').style.visibility = "visible";
}

function afterOrderFailure() {
  document.getElementById('failure').style.visibility = "visible";
}
