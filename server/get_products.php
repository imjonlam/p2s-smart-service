<?php
  include 'db_manager.php';

  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');

  // echo '<pre>';
  // print_r($_POST); // for viewing it as an array
  // var_dump($_POST); // for viewing all info of the array
  // echo '</pre>';
  // die();


  $category = $_POST['category'];
  unset($_POST['category']);
  
  if ($category == 'coffeeshop') {
    $result = $man->select('Coffees', $_POST);
  } elseif ($category =='flowershop') {
    $result = $man->select('Flowers', $_POST);
  }

  if(!$result) {
    echo $man->error();
  } else {
    if ($result->num_rows > 0) {
      $outp = '';
      while($row = $result->fetch_assoc()) {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"Name":"'   . $row['name']    . '",';
        $outp .= '"Price":"'   . $row['price'] . '",';
        $outp .= '"Image":"'   . $row['image']   . '",';
        $outp .= '"Id":"'      . $row['id']      . '"}';
      }
      $outp ='{"records":['.$outp.']}';
      echo($outp);
    }
  }
?>