<!DOCTYPE html>
<html lang="EN" ng-app="myApp">
<head>
  <title>630 Webapp</title>
  <link rel="stylesheet" href="../assets/css/landing.css">
  <?php include('./shared/header/head_tags.html') ?>
  <script type="text/javascript" src="../env.js"></script>
  <link rel="stylesheet" ng-bind="extraheader"></link>
</head>

<body class="d-flex flex-column min-vh-100">
  <!-- Nav Bar -->
  <?php include('./shared/header/header.php')?>
  <!-- End Nav Bar -->
  <div ng-view class="h-100">
    
  </div>
  <!-- Footer -->
  <?php include('./shared/footer/footer.html') ?>
  <!-- End Footer -->
  <script src="app.js"></script> 
</body>
</html>