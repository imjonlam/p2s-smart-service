<?php
	include 'db_manager.php';

	$man = new db_manager('localhost', 'root', '', 'cps630_proj_db');

    $pass = $_POST['password'];
    unset($_POST['password']);

	$result = $man->select('Users', $_POST);
    
    if(!$result) {
      echo $man->error();
    } else {
      if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
            $salt = $row['salt'];
        
            $_POST['password'] = $pass . $salt;
            $result = $man->select('Users', $_POST);
        
            if(!$result) {
                echo $man->error();
            } else {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $t = ($_POST['remember'] == 'true') ? 1 : 7;

                    setcookie('user', $row['login_id'], time()+60*60*24*$t, '/');
                    setcookie('user-id', $row['id'], time()+60*60*24*$t, '/');
                    setcookie('name', ($row['name'] == NULL ? 'Unknown' : $row['name']), time()+60*60*24*$t, '/');
                    setcookie('role', $row['role'], time()+60*60*24*$t, '/');
                    echo "success";
                }
            }
		}
      
    }