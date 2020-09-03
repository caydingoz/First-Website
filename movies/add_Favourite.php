<?php

include '../config.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login/login.php');
	exit;
}
	$control=true;
	$movie_id=$_POST['data'];
	$user_id=$_SESSION['id'];

	$pdo = pdo_connect_mysql();
	$stmt=$pdo->query("SELECT movie_ID from favourites inner join users on favourites.user_ID=users.id where
	 users.id=$user_id");
	$favouritemovies=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($favouritemovies as $movie){
		if ($movie['movie_ID']==$movie_id) {
			$control=false;
		}
	}
	if($control){
		$stmt=null;
		$sql = "INSERT Into favourites (user_ID, movie_ID) values(?,?)";
		$stmt = $db->prepare($sql);
		$stmt->bind_param('ii', $_SESSION['id'],$movie_id);
		$stmt->execute();

	}

?>