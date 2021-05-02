<?php
  include 'db_manager.php';

  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
  $result = $man->select('Cars', $_POST);
  
  if(!$result) {
    echo $man->error();
  } else {
    if ($result->num_rows > 0) {
      $outp = '';
      while($row = $result->fetch_assoc()) {
        if ($outp != "") {$outp .= ",";}
        $outp .= '{"Description":"'   . $row['description']    . '",';
        $outp .= '"Price":"'   . $row['price'] . '",';
        $outp .= '"Image":"'   . $row['image']   . '",';
        $outp .= '"Model":"'   . $row['model']   . '",';
        $outp .= '"Id":"'      . $row['id']      . '"}';
      }
      $outp ='{"records":['.$outp.']}';
      echo($outp);
    }
  }
?>