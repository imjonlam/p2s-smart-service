<main class="h-100">
<div class="container-fluid h-100 d-flex flex-column">
  <div class="row h-100">
    <div class="col-md-2"></div>
    <div class="col-md-8 text-center mt-5">
      <div class="h-100 d-flex flex-column">
        <h1>Reviews</h1>
        <form class="row gy-2 gx-3 mt-5 mb-3">
          <div class="row align-items-center justify-content-center">
            <label for="order_filter" class="col-sm-2 col-form-label p-0 bg-secondary rounded text-light">Filter by Order:</label>
            <div class="col-sm-4 px-0">
              <input id="order_filter" class="form-control p-0" onkeyup="filterOrders()" type="search" placeholder="Search Orders" aria-label="Search">
            </div>
          </div>
        </form>
        <table id="order_table" class="table table-responsive table-sm">
          <thead class="table-dark">
            <tr>
              <th>Order Number</th>
              <th class="w-50">Description</th>
              <th>Rating</th>
              <th>Submit</th>
            </tr>
          </thead>
          <tbody id="history_body"></tbody>
        </table>
      </div>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>
</main>

<?php if(isset($_COOKIE['user-id'])): ?>
  <script id="history_loader" src="./components/ratings/post_rating.js" data-id='<?= $_COOKIE['user-id']; ?>'></script>
<?php endif ?>

<script>
    function filterOrders() {
    var order_number = document.getElementById('order_filter');
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