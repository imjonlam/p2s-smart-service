<?php
  include 'db_manager.php';

  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
  $result = $man->select('Orders', $_POST);
  
  if(!$result) {
    echo $man->error();
  } else {
    if ($result->num_rows > 0) {
      $table_rows = '';
      while($row = $result->fetch_assoc()) {
        $table_rows .= <<<EOD
        <tr>
          <td>#{$row['order_number']}</td>
          <td>{$row['issued_date']}</td>
          <td>{$row['payment_code']}</td>
        </tr>
        EOD;
      }
      echo $table_rows;
    }
  }
?>