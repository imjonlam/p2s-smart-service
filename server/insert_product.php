<?php

include 'db_manager.php';

$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
$result = $man->insert($_POST['table'], $_POST);

if($result !== TRUE) {
	echo $man->error();
} else {
	echo "success";
}
?>