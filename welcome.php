<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE html>
<html>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="css/welcome.css" rel="stylesheet" type="text/css">
		<link href="css/movie.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
	<div class="bodyContainer" >
		<nav class="navtop" >
			<div>
				<h1>Php Website</h1>
				<a href="welcome.php"><i class="fas fa-home"></i>Ana Sayfa</a>
				<a href="shop/shop.php"><i class="fas fa-shopping-cart"></i>Shop</a>
				<a href="movies/movies.php"><i class="fas fa-images"></i>Movies</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
		</div>
	</div>
	</body>
</html>
