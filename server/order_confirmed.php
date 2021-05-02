<?php

include 'db_manager.php';

$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');

$trip = $_POST['trip'];
$pay = $_POST['pay'];

unset($_POST['trip']);
unset($_POST['pay']);

if(isset($_COOKIE['user-id']))
  $_POST['user'] = $_COOKIE['user-id'];

$result = $man->insert('Trips', $trip);

if($result !== TRUE) {
  echo $man->error();
} else {
  $_POST['trip'] = $man->getInsertId();
}
$result = $man->insert('Orders', $_POST);

if($result !== TRUE) {
  echo $man->error();
} else {
  echo "order insertion success";
}
?>