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
        <tr class="fst-italic">
          <td class="order_number">{$row['order_number']}</td>
          <td class="description">{$row['description']}</td>
          <td>
            <select class="form-select rating" aria-label="ratings">
              <option value=1>1</option>
              <option value=2>2</option>
              <option value=3>3</option>
              <option value=4>4</option>
              <option value=5>5</option>
            </select>
          </td>
         <td><button class="btn btn-sm btn-primary">Submit</td>
        </tr>
        EOD;
      }
      echo $table_rows;
    }
  }
?>