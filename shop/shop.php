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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="../css/shop.css" rel="stylesheet" type="text/css">
	</head>
	<body >
		<div class="bodyContainer">
			<nav class="navtop" > 
				<div>
					<h1>Diyarbakırlı Mehmet Ustanın Yeri</h1>
					<a href="../welcome.php"><i class="fas fa-home"></i>Ana Sayfa</a>
					<a href="shop.php"><i class="fas fa-shopping-cart"></i>Shop</a>
					<a href="../movies/movies.php"><i class="fas fa-images"></i>Movies</a>
					<a href="../profile.php"><i class="fas fa-user-circle"></i>Profile</a>
					<a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
				</div>
			</nav>
	<!-------------------- Cart ADD  ----------------------------------------------->
			<button class="topBtn" onclick="addShop()";>Add Item</button>
			<script>
				function addShop(){
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
					<form action="shop_add.php" method="POST">
						<i onclick="closeTab();" style="float: right; cursor: pointer;" class="far fa-times-circle fa-2x"></i>
						<h2 style="text-align: center;">Add Item</h2>
						<label>Name</label>
						<input type="text" name="item_Name" placeholder="Name" id="item_Name" required>

						<label>Category</label>
						<input type="text" name="item_Category" placeholder="Category" id="item_Category" required>

						<label>Price</label>
						<input type="text" name="item_Price" placeholder="Price" id="item_Price" required>
						
						<input type="submit" value="Add Item" style="border-radius: 4px;background: #ADD8E6;cursor:pointer; width:40%;" >
					</form>
				</div>
			</div>
<!-------------------- Shop ADD END  ----------------------------------------------->

<!-------------------- Cart   ----------------------------------------------->
		<a href="cart.php"><button id="favTab"class="topBtn" ><i class="fas fa-shopping-basket " style="margin-right: 5px;"></i>Cart</button></a>
<!-------------------- Cart END  ----------------------------------------------->
		
			<div id="shop" class="shop" style="height:100%;">
				<h2 style="margin-top:2%;margin-left:10%;">Shop</h2>
	<!-------------------- Shop Menü Başlangıç ----------------------------------------------->
				<div class="menu">
				  <a href="shop.php" class="active">Category</a>
				  <a onclick="window.location.href = 'http://localhost/login/shop/category_shop.php?link=Telefon';">Telefon</a>
				  <a href="#">Link 1</a>
				  <a href="#">Link 2</a>
				  <a href="#">Link 3</a>
				  <a href="#">Link 4</a>
				</div>
	<!-------------------- Shop Menü Bitiş ----------------------------------------------->

	<!-------------------- Sorting  ----------------------------------------------->
				<div style="width: 90%;height: 5%">
					<form style="float:right;" method="POST" action="sortingby_shop.php">
						<i class="fas fa-sort-numeric-up" style="margin-right:5px;"></i>
						<select style="margin-right: 5px;" name='sortingMenu'>
						    <option value="">Sort By</option>
						    <option value="item_id ASC">Id ASC</option>
						    <option value="item_id DESC">Id DESC</option>
						    <option value="item_name ASC">Name ASC</option>
						    <option value="item_name DESC">Name DESC</option>
						</select>
						<input  type="submit" value="Sort" style="cursor: pointer;">
					</form>
				</div>	
	<!-------------------- Sorting  END ----------------------------------------------->

	
	<!--------------------------- Shop Başlangıç ---------------------------------------------->			
				<div class="items" >
					<?php $pdo = pdo_connect_mysql();
					$stmt=$pdo->query("SELECT * FROM items");
					$items=$stmt->fetchAll(PDO::FETCH_ASSOC);//arraya atıyoruz
					foreach ($items as $item): ?>
					<div class="card" >
					  <button class="itemImg"></button>
					  <h4><?=$item['item_name']?></h4>
					  <p class="price" style="width: 100%">$<?=$item['item_price']?></p>
					  <div class="cartmiktar">
					  	<button style="border:none;" onclick="miktarazalt(<?=$item['item_id']?>);"><i class=" fa fa-chevron-circle-down" aria-hidden="true" style="color:darkred;"></i></button>
					  	<p id="<?=$item['item_id']?>" style="margin-top: 10px;"> 1 </p>
					  	<button style="border:none;" onclick="miktarartir(<?=$item['item_id']?>);"><i class=" fa fa-chevron-circle-up" aria-hidden="true" style="color:darkblue;"></i></button>
					  </div>
					  <button class="addCart" style="margin-top: 10px; border-radius: 30px;" onclick="addtoCart(<?=$item['item_id']?>,3)"><i class="fas fa-shopping-basket fa-2x"></i></button>
					</div>
					<?php endforeach; ?>
				</div>
				<script >
					function miktarartir(itemno){
						var miktar=Number(document.getElementById(itemno).textContent);
						miktar++;
						document.getElementById(itemno).textContent=miktar;
					}
					function miktarazalt(itemno){
						var miktar=Number(document.getElementById(itemno).textContent);
						if (miktar>1)
							miktar--;
						document.getElementById(itemno).textContent=miktar;
					}
					function addtoCart(itemno,mode){
						var miktar=Number(document.getElementById(itemno).textContent);
						if (miktar>=1){
							$.ajax({
								type:'POST',
								url:'cartFunc.php',
								data:'itemno='+itemno + '&miktar='+miktar + '&mode='+mode,//miktarda gonder
							})
						}
					}
				</script>
			</div>
		</div>
	</body>
</html>