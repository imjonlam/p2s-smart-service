<?php
  include 'db_manager.php';

  $man = new db_manager('localhost', 'root', '', 'cps630_proj_db');

  $table = $_POST['table'];
  unset($_POST['table']);
  
  $result = $man->select($table, $_POST);

  if(!$result) {
    echo $man->error();
  } else {
    if ($result->num_rows > 0) {
      $div = '';
      foreach($result as $row) {
        $div .= "<div id='item{$row['id']}' data-type='{$table}'>";
        if ($table !== 'Cars')
          $div .= "<h1 id='info'>{$row['name']}</h1>";
        else
          $div .= "<h1 id='description'>{$row['description']}</h1>";
        $div .= <<<EOD
            <h3 id="price">\${$row['price']}</h3>
            <img id="image" src="{$row['image']}" class="img-fluid w-50 h-50">
          </div>
        EOD;
      }
      echo $div;
    }
  }
?>