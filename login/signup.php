<?php
//Register
	include "../config.php";
	
	$username=$_POST['name'];
	$password=$_POST['pass'];
	$passwordConf=$_POST['passConf'];
	$email=$_POST['email'];
	$il=$_POST['il'];

	//Inputların doğruluğuna bakılıyor

		if(empty($username)||empty($password)||empty($email)||empty($passwordConf)){
			header("Location: login.php?signup=empty");
		}
		elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			header("Location: login.php?email=invalid");
		}
		elseif (!preg_match("/^[a-zA-Z\s ığüşöçİĞÜŞÖÇ]*$/", $username)) {
			header("Location: login.php?name=invalid");
		}
		elseif( $_POST['pass'] !== $_POST['passConf'] ){
    		header("Location: login.php?password=nomatch");
		}
	//Inputlar doğru girilmişse buraya giriyor.
		else{ 
			
			$SELECT="SELECT email FROM users WHERE email = ? Limit 1";
			$INSERT="INSERT Into users (username, password,email,il) values(?,?,?,?)";
			
			$stmt=$db->prepare($SELECT);
			$stmt->bind_param("s",$email );
			$stmt->execute();
			$stmt->bind_result($email);
			$stmt->store_result();
			$rnum=$stmt->num_rows;
			if ($rnum==0) {
				$stmt->close();
				$stmt=$db->prepare($INSERT);
				$hashedpass=password_hash($password, PASSWORD_DEFAULT);
				$stmt->bind_param("ssss",$username ,$hashedpass ,$email,$il);
				$stmt->execute();
				//databaseden veri çekme id verisini $id değişkenine atadık.
				$id =$db->prepare("SELECT id FROM users WHERE email = '$email'");
				$id->execute();//bu olmayınca objeyi integera çevirme hatası oluyor.
		        $id->bind_result($id);
				$id->fetch();
				//
				session_start();
				session_regenerate_id();
					$_SESSION['loggedin'] = TRUE;
					$_SESSION['name'] = $username;
					$_SESSION['id'] = $id;
				header("Location:../welcome.php ");
			}else{
				header("Location: login.php?email=used");
			}
			$stmt->close();
			$db->close();
		}


		
?>
