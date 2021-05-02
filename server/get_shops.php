<?php

  include 'db_manager.php';
  header('Content-type: application/json');

  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
  $result = $man->select('Shops', $_POST);
  
  if(!$result) {
    echo $man->error();
  } else {
    if ($result->num_rows > 0) {
      $outp = '';
      while($row = $result->fetch_assoc()) {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"Name":"'   . $row['name']    . '",';
        $outp .= '"Address":"' . $row['address'] . '",';
        $outp .= '"Category":"'. $row['category']. '",';
        $outp .= '"Image":"'   . $row['image']   . '",';
        $outp .= '"Id":"'      . $row['id']      . '"}';
      }
      $outp ='{"records":['.$outp.']}';
      echo($outp);
    }
  }
?>
