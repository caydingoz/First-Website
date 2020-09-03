<?php
include '../config.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}
?>
<!DOCTYPE html>
<html>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="../css/welcome.css" rel="stylesheet" type="text/css">
		<link href="../css/movie.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
	<div class="bodyContainer">
		<nav class="navtop">
			<div>
				<h1>Diyarbakırlı Mehmet Ustanın Yeri</h1>
				<a href="../welcome.php"><i class="fas fa-home"></i>Ana Sayfa</a>
				<a href="../shop/shop.php"><i class="fas fa-shopping-cart"></i>Shop</a>
				<a href="movies.php"><i class="fas fa-images"></i>Movies</a>
				<a href="../profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
<!-------------------- Movie ADD  ----------------------------------------------->
		<button class="topBtn" onclick="addMovie()";>Add Movie</button>
		<script>
			function addMovie(){
				var modal = document.getElementById("modal");
				modal.style.display="block";
			}
			window.onclick = function(event) {
			  	if (event.target == modal) {
			    	modal.style.display = "none";
			  	}
			}
			function closeTab(){
				var modal = document.getElementById("modal");
				modal.style.display="none";
			}
		</script>

		<div id="modal" class="modal">
			<div id="modal-content" class="modal-content">
				<form action="movie_Add.php" method="POST">
					<i onclick="closeTab();" style="float: right; cursor: pointer;" class="far fa-times-circle fa-2x"></i>
					<h2 style="text-align: center;">Add Movie</h2>
					<label>Movie Name</label>
					<input type="text" name="movie_Name" placeholder="Movie Name" id="movie_Name" required>

					<label>Movie Category</label>
					<input type="text" name="movie_Category" placeholder="Category" id="movie_Category" required>
					<input type="submit" value="Add Movie" style="border-radius: 4px;background: #ADD8E6;cursor:pointer; width:40%;" >
				</form>
			</div>
		</div>
<!-------------------- Movie ADD END  -------------------------------------------------->

<!--------------------  Movies  ----------------------------------------------->
		<a href="movies.php"><button id="favTab"class="topBtn"  >Movies</button></a>
<!-------------------- Movies end  ----------------------------------------------->	

		<div id="favmovies" class="movies">
			<h2>My Favourite Movies</h2>
			
			<table style="width:100%"class="movieTable">
			<tr>
			    <th>ID</th>
			    <th style="width:70px;">Favourite</th>
			    <th>Movie Name</th>
				<th>Category</th> 
			</tr>
			
				<?php $pdo = pdo_connect_mysql();
				$user_id=$_SESSION['id'];
				$stm=$pdo->query("SELECT * from movies inner join favourites on movies.movie_id=favourites.movie_ID where favourites.user_ID=$user_id ");
				$favmovies=$stm->fetchAll(PDO::FETCH_ASSOC);//arraya atıyoruz [associative array = belli nameli array]
				foreach ($favmovies as $favmovie): ?>
			<tr id="<?=$favmovie['movie_id']?>">
				<td ><?=$favmovie['movie_id']?><td><i style="margin-left:25px;cursor: pointer;" class="fas fa-heart fa-lg " onclick="y(<?=$favmovie['movie_id']?>)"></i></td>
			    <td><?=$favmovie['movie_name']?></td>
			    <td><?=$favmovie['movie_category']?></td>
			</tr>
			<?php endforeach; ?>
			</table>
		</div>
<!-------------------- Favourite Movies END  ----------------------------------------------->
		<script>
			function y(a){
				var data=a;
				$.ajax({
					type:'POST',
					url:'remove_Favourite.php',
					data:'data='+data,
				})
				document.getElementById(a).remove();
			}
		</script>
	</div>
	</body>
</html>