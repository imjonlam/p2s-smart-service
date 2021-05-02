<?php
  include 'db_manager.php';

  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
  $result = $man->select('Shops', $_POST);
  
  if(!$result) {
    echo $man->error();
  } else {
    if ($result->num_rows > 0) {
      $response = json_encode($result->fetch_assoc());
      echo $response;
    }
  }
?>