
<main>
  <div id="welcome" class="container-fluid text-center">
    <div class="row mt-2">
      <div class="col-md-6">
        <img src="../assets/img/landing/work-from-home.jpg" class="img-fluid" width="500" height="800" alt="background image">
      </div>
      <div class="col-md-6 mt-5">
        <div class="h-100 d-flex flex-column">
          <div class="row flex-grow-1 justify-content-center">
            <div class="align-self-center text-center">
              <h1>Let Us Take Care of <b class="display-1 fw-bold">YOU</b></h1>
              <p>Looking to get a ride? Maybe delivery?</p>
              <p>Check out our services!</p>
              <div>
                <a type="button" class="btn btn-primary" href="#!service_a">Get Me a Ride</a>
                <a type="button" class="btn btn-primary" href="#!service_b">Get My Delivery</a>
                <a type="button" class="btn btn-primary" href="#!service_c">Ride Green</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="mission" class="container-fluid text-center">
    <div id="bg_mission" class="row mt-5 pt-5">
      <div class="col">
        <h1 class="mt-5">Our Mission</h1>
        <div id="our_mission" class="mt-3">
          <span>In this iteration you will design, develop and test a “Plan for Smart Services” (P2S) Web-Application. P2S is an online system that aims to plan for smart green trips inside the city and its neighborhood through sharing vehicles (like Uber). Considering the traffic as a serious threat to the quality of life these years, the world has been looking for various solutions to decrease the stress, frustration, delays and terrible air pollutions being caused through it. P2S attempts to provide a smart green solution on this regard by matching up drivers who live, work, and finally drive in the same neighborhood and would like to provide trip services.
          </span>
        </div>
      </div>
    </div>
  </div>
  <div id="about" class="container-fluid text-center">
    <div class="row mt-5">
      <div class="col">
        <h1>Who Are We?</h1>
        <div class="row justify-content-center">
          <div class="col-auto">
            <table class="table-responsive">
              <thead>
                <tr>
                  <th><img src="../assets/img/about/Payton.png" alt="payton"></th>
                  <th><img src="../assets/img/about/jon.jfif" alt="jonathan"></th>
                  <th><img src="../assets/img/about/thomas.png" alt="thomas"></th>
                </tr>
              </thead>
              <tbody>
                <tr class="fw-bold">
                  <td class="pt-3"><h3>Payton</h3></td>
                  <td class="pt-3"><h3>Jonathan</h3></td>
                  <td class="pt-3"><h3>Thomas</h3></td>
                </tr>
                <tr class="fst-italic">
                  <td>Student</td>
                  <td>Student</td>
                  <td>Student</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="contact" class="container-fluid text-center bg-light">
    <div class="row">
      <div class="row mt-5">
        <h1>Contact Us</h1>
        <h6 class="fst-italic">Didn't find what you were looking for? Shoot us a message!</h6>
      </div>        
      <div class="row text-start mt-2 mb-5">
        <div class="col-md-3"></div>
        <form class="col-md-6" action="mailto:P2S@gmail.com" method="GET" enctype="text/plain">
          <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" name="subject" id="subject">
          </div>
          <div class="mb-3">
            <label for="body" class="form-label">Message:</label>
            <textarea type="text" class="form-control" name="body" id="body"></textarea>
          </div>
          <div class="text-center mb-3">
            <button type="submit" class="btn btn-danger btn-lg">Submit</button>
          </div>
        </form>
        <div class="col-md-3"></div>
      </div>
    </div>
  </div>

  <div id="order_container" class="me-3 text-end">
    <div id="order_history" class="d-none shadow-lg text-center rounded table-responsive">
      <table id="order_table" class="table">
        <thead class="bg-primary text-white">
          <tr>
            <th>Order</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="history_body"></tbody>
      </table>
    </div>
    <button id="show_history" class="btn btn-primary mb-5 mt-2">Show Order History</button>
  </div>
</main>

<script>
  $(function() {
    $('.order-row').click(function() {
      window.location = $(this).data('href');
    });

    $('#show_history').click(function() {
      $('#order_history').toggleClass('d-none');
      $(this).text((i, t) => t == 'Show Order History' ? 'Close Order History' : 'Show Order History');
    });
  });
</script>

<?php if(isset($_COOKIE['user-id'])): ?>
<script id="history_loader" src="./components/landing/get_order_history.js" data-id='<?= $_COOKIE['user-id']; ?>'></script>
<?php endif ?>