<?php
//Login
	require "../config.php";
	
	$loginemail=$_POST['loginemail'];
	$loginpassword=$_POST['loginpass'];
	if(empty($loginemail)||empty($loginpassword)){
    	header("Location: login.php?signin=empty");
	}
	else{
		if ($stmt = $db->prepare('SELECT id, password,username FROM users WHERE email = ?')) {
			$stmt->bind_param('s', $loginemail);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0) {
				$stmt->bind_result($id, $password,$username);
				$stmt->fetch();
				if ( password_verify($_POST["loginpass"],$password)) {
					session_start();
					session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $username;
					$_SESSION['id'] = $id;
					header("Location:../welcome.php ");
				} else {
					header("Location: login.php?password=incorrect");
				}
			} else {
				header("Location: login.php?email=nouser");
			}

			$stmt->close();
		}
	}
?>