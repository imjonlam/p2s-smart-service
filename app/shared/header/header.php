<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark pt-1">
    <div class="container-fluid">
      <a class="navbar-brand" href="#top">P2S</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav me-auto">
          <a class="nav-link" aria-current="page" href="./">Home</a>
          <a class="nav-link" href="./#about">About</a>
          <a class="nav-link" href="./#contact">Contact Us</a>
          <a class="nav-link" href="#!ratings">Reviews</a>
          <a class="nav-link" href="#!suggestions">Suggestions</a>
          <a class="nav-link" href="#" role="button" data-bs-toggle="modal" data-bs-target="#browser_modal">Browser</a>
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Types of Services</a>
            <div class="dropdown dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#!service_a">Ride to Destination</a>
              <a class="dropdown-item" href="#!service_b">Ride and Deliver</a>
              <a class="dropdown-item" href="#!service_c">Ride Green</a>
            </div>
          </div>
          <?php if(isset($_COOKIE['user']) && $_COOKIE['role'] == 'admin'): ?>
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">DB Maintain</a>
            <div class="dropdown dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#!/maintain/insert">Insert</a>
              <a class="dropdown-item" href="#!/maintain/delete">Delete</a>
              <a class="dropdown-item" href="#!/maintain/select">Select</a>
              <a class="dropdown-item" href="#!/maintain/update">Update</a>
            </div>
          </div>
		      <?php endif ?>
        </div>
        <div class="d-flex navbar-nav">
        <?php if(isset($_COOKIE['user'])):?>
          <span style="color:white;padding:0.5rem">Welcome <?= $_COOKIE['name'] ?></span>
        <?php else: ?>
          <a class="nav-link" href="#!register"><i class="fas fa-sign-in-alt me-1"></i>Register</a>
          <a class="nav-link" href="#!login"><i class="fas fa-user me-1"></i>Login</a>
        <?php endif ?>
        <?php if(isset($_COOKIE['user'])): ?>
        <div id="order_query" class="d-flex">
          <input id="query_order_number" class="d-flex ms-2" onkeyup="filterOrders()" type="search" placeholder="Search Orders" aria-label="Search">
          <button class="btn btn-outline-secondary ms-2" onclick="openHistory()" type="submit">Search</button>
        </div>
        <?php endif ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="modal fade" id="browser_modal" tabindex="-1" aria-labelledby="browser_modal_label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browser_modal_label">Browser Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span>Your current browser is: <span id="browser_info"></span></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</header>

<script>
  $(function() {
    var result = navigator.userAgent;
    var isEdge = result.includes('Edg') || result.includes('Trident') || result.includes('Internet Explorer') || result.includes('IE');
    var isChrome = result.includes('Chrome');
    var isFirefox = result.includes('Firefox');
    
    if (isEdge) {
      document.getElementById('browser_info').innerHTML = 'Internet Explorer';
    } else if (isFirefox) {
      document.getElementById('browser_info').innerHTML = 'Firefox';
    } else if (isChrome) {
      document.getElementById('browser_info').innerHTML = 'Google Chrome';
    } else {
      document.getElementById('browser_info').innerHTML = 'Unknown';
    }
  });

  function openHistory() {
    $('#order_history').removeClass('d-none');
    $('#show_history').text('Close Order History');
  }

  function filterOrders() {
    var order_number = document.getElementById('query_order_number');
    var filter = order_number.value.toUpperCase();
    var order_table = document.getElementById('order_table');
    var row = order_table.getElementsByTagName('tr');

    for (i = 0; i < row.length; i++) {
      col = row[i].getElementsByTagName('td')[0];
      if (col) {
        txtValue = col.textContent || col.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          row[i].style.display = "";
        } else {
          row[i].style.display = "none";
        }
      }
    }
  }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />