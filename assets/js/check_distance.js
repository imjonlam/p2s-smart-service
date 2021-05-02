function calcDistance(start, end) {
  return new Promise(resolve => {

    var distance = 0.0;
    const directionsService = new google.maps.DirectionsService();

    var request = {
      origin: start,
      destination: end,
      travelMode: google.maps.TravelMode.DRIVING
    }

    directionsService.route(request, function(result, status) {
      if (status == 'OK') {
        result.routes[0].legs.forEach((i) => {
          distance += i.distance.value / 1000;
        });
        
        resolve(distance);

      } else {
        $('#error').html('directions request failed as a result of ' + status);
        $('#error').css('display', 'flex');
        $('#products').css('display', 'none');
        resolve(-1);
      }
    });
  });
}

async function isTooFar(start, end, fieldID) {
  if (start != '' && end != '') {
    $('#checkout').prop('disabled', true);
    await calcDistance(start, end).then(result => {
      if (result > 50) {
        $('#error').html('Unfortunately we cannot service this destination, it is further than 50 km away from your location.');
        $('#error').css('display', 'flex');
        $('#products').css('display', 'none');
        $('#' + fieldID).val('');
      } else if (result == -1) {
        $('#error').html('Error: directions request failed');
        $('#error').css('display', 'flex');
        $('#products').css('display', 'none');
        $('#' + fieldID).val('');
      } else {
        $('#error').css('display', 'none');
        $('#products').css('display', 'flex');
        $('#checkout').prop('disabled', false);
      }
    });
  }
}

function checkDistance(event, destID) {
  const origin = document.getElementById(event.target.id).value;
  const destination = document.getElementById(destID).value;

  isTooFar(origin, destination, event.target.id);
}  