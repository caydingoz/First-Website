<?php 
	include '../config.php';
	$movie_name=$_POST['movie_Name'];
	$movie_category=$_POST['movie_Category'];

	if (!preg_match("/^[a-zA-Z0-9\s ığüşöçİĞÜŞÖÇ]*$/", $movie_name)) {
			header("Location: movies.php?movie_name=invalid");
	}
	if (!preg_match("/^[a-zA-Z\s ığüşöçİĞÜŞÖÇ]*$/", $movie_category)) {
			header("Location: movies.php?movie_category=invalid");
	}
	else{
		$SELECT="SELECT movie_name FROM movies WHERE movie_name = ? Limit 1";
		$INSERT="INSERT Into movies (movie_name, movie_category) values(?,?)";
		
		$stmt=$db->prepare($SELECT);
		$stmt->bind_param("s",$movie_name );
		$stmt->execute();
		$stmt->bind_result($movie_name);
		$stmt->store_result();
		$rnum=$stmt->num_rows;
		if ($rnum==0) {
			$stmt->close();
			$stmt=$db->prepare($INSERT);
			$stmt->bind_param("ss",$movie_name ,$movie_category);
			$stmt->execute();
			header("Location:movies.php?success ");
		}else{
			header("Location: movies.php?movie=exist");
		}
		$stmt->close();
		$db->close();
	}
?>