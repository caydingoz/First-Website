<?php
include '../config.php';
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login.php');
	exit;
}
	$movie_id=$_POST['data'];
	$user_id=$_SESSION['id'];

	$pdo = pdo_connect_mysql();
	$stmt=$pdo->query("DELETE FROM `favourites` WHERE user_ID=$user_id AND movie_ID=$movie_id");
?>