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
<!-------------------- Movie ADD END  ----------------------------------------------->

<!-------------------- Favourite Movies  ----------------------------------------------->
		<a href="favourite.php"><button id="favTab"class="topBtn" >Favourite Movies</button></a>
<!-------------------- Favourite Movies END  ----------------------------------------------->
		

		<div id="movies" class="movies">
			<h2>Movies</h2>
<!-------------------- Sorting denemesi  ----------------------------------------------->			
			<table style="width:100%"class="movieTable">
		
			<form  style="float:left;"  method="POST" action="sortingby_movies.php">
				<i class="fas fa-sort-numeric-up" style="margin-right:7px;"></i>
				<select style="margin-right: 7px;" name='sortingMenu'>
				    <option value="">Sort By</option>
				    <option value="movie_id ASC">Id ASC</option>
				    <option value="movie_id DESC">Id DESC</option>
				    <option value="movie_name ASC">Name ASC</option>
				    <option value="movie_name DESC">Name DESC</option>
				</select>
				<input type="submit" value="Sort" style="cursor: pointer;">
			</form>
<!-------------------- Sorting denemesi END ----------------------------------------------->
			<tr>
			    <th>ID</th>
			    <th style="width:70px;">Favourite</th>
			    <th>Movie Name</th>
				<th>Category</th> 
			</tr>
			<tr>
				<?php $pdo = pdo_connect_mysql();
				$stmt=$pdo->query('SELECT * FROM movies');
				$movies=$stmt->fetchAll(PDO::FETCH_ASSOC);//arraya atıyoruz [associative array = belli nameli array]
				foreach ($movies as $movie): ?>
				<td ><?=$movie['movie_id']?><td><i id="<?=$movie['movie_id']?>" style="margin-left:25px;cursor: pointer;" class="<?php $b=true;$movie_id=$movie['movie_id'];$user_id=$_SESSION['id'];
					$stmts=$pdo->query("SELECT movie_ID from favourites inner join users on favourites.user_ID=users.id where users.id=$user_id");
					$favouritemovies=$stmts->fetchAll(PDO::FETCH_ASSOC);
					foreach ($favouritemovies as $moviea){
						if ($moviea['movie_ID']==$movie_id) { $b=false;echo ' fas fa-heart fa-lg';}
						
					}if ($b) { $b=false;echo ' far fa-heart fa-lg';}?>" onclick="x(<?=$movie['movie_id']?>)"></i></td>
				<!--FAVLARI KALP YAPMAK İÇİN  -->
				<script>
					function x(a){
						//deneme başlangıç
						var unfavcontrol =document.getElementById(a).classList.contains("far");
						var favcontrol =document.getElementById(a).classList.contains("fas");
						if(unfavcontrol){
							var data=a;
							$.ajax({
								type:'POST',
								url:'add_Favourite.php',
								data:'data='+data,
							})
							document.getElementById(a).className = "fas fa-heart fa-lg";
						}
						if(favcontrol){
							var data=a;
							$.ajax({
								type:'POST',
								url:'remove_Favourite.php',
								data:'data='+data,
							})
							document.getElementById(a).className = "far fa-heart fa-lg";
						}
					}
				</script></td>
			    <td><?=$movie['movie_name']?></td>
			    <td><?=$movie['movie_category']?></td>
			</tr>
			<?php endforeach; ?>
			</table>
		</div>
	</div>
	</body>
</html>