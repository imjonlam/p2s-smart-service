$(function() {
  var script = document.createElement('script');
  script.src = 'https://maps.googleapis.com/maps/api/js?key=' + API_KEY + "&libraries=places&callback=init";
  script.async = true;
  document.head.appendChild(script);
});