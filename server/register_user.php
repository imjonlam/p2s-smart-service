<?php

include 'db_manager.php';

$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');

$_POST['salt'] = bin2hex(openssl_random_pseudo_bytes(4));
$_POST['password'] = $_POST['password'] . $_POST['salt'];
$result = $man->insert('Users', $_POST);

if($result !== TRUE) {
	echo $man->error();
} else {
	echo "success";
}