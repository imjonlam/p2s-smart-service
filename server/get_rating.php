<?php
  include 'db_manager.php';
  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
  
  $result = $man->select('Reviews', $_POST);
  if(!$result) {
    echo $man->error();
  } else {
    $count = 0;
    $sum = 0;
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $sum += $row['rating'];
        $count++;
      }
    }
    $avg = round($sum / $count, 1);
    $outp ='{"average":'.$avg.'}';
    echo($outp);
  }
?>