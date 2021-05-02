<?php

include 'db_manager.php';

$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
if($_POST['table'] == 'Users' && isset($_POST['password'])) {
  $_POST['salt'] = bin2hex(openssl_random_pseudo_bytes(4));
  $_POST['password'] = $_POST['password'] . $_POST['salt'];
}
$result = $man->update($_POST['table'], $_POST);

if($result !== TRUE) {
	echo $man->error();
} else {
	echo "success";
}