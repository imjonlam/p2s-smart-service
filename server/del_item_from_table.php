<?php
	include 'db_manager.php';

	$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');
	$result = $man->delete($_POST['table'], $_POST);
	if(!$result) {
		echo $man->error();
	} else {
		echo "success";
	}
?>