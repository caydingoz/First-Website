<?php
include '../config.php';
include '../ChromePhp.php';
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

			<div id="shop" class="shop" style="height:100%;">
				<h2 style="margin-top:2%;margin-left:10%;">My Cart</h2>

				<div class="cartContainer" style="border:1px solid;width:100%;height:100%;">

					<div class="cartPaymentmenu">
						<?php 
						$user_id=$_SESSION['id']; $pdo = pdo_connect_mysql();
						$stmt=$pdo->query("SELECT item_id,item_name,item_price,miktar from cart inner join items on items.item_id=cart.itemID where cart.userID=$user_id");
						$items=$stmt->fetchAll(PDO::FETCH_ASSOC);//arraya atıyoruz
						$sum=0;
						foreach ($items as $item):
							$sum+=$item['item_price']*$item['miktar'];
						endforeach;
						?>
						<form method="POST" action="payment.php">
							<h2>Order Summary</h2>
							<p id="subTotal">$<?=number_format($sum,2,".",",")?></p>
							<h3>Subtotal</h3>
							<p id="ShippingPrice">$9.00</p>
							<h3>Shipping Price</h3>
							<p id="total">$<?=number_format($sum+9,2,".",",")?></p>
							<h3>Total</h3>
							<input class="buyButton" type="submit" style="cursor: pointer;border-radius: 30px;font-weight: bold;" value="Buy">
						</form>
					</div>
					<?php 
					$user_id=$_SESSION['id']; $pdo = pdo_connect_mysql();
					$stmt=$pdo->query("SELECT item_id,item_name,item_price,miktar from cart inner join items on items.item_id=cart.itemID where cart.userID=$user_id");
					if(!$stmt->rowCount()){
						echo "<div class='warningCart'>
						<i class='fa-2x fas fa-exclamation' style='color:red;float:left;margin-left: 24%;margin-top: 4%;'></i>
						<h4 style='float: left; margin-top: 5%;margin-left: 7%;'>Sepetinizde Ürün Bulunmamaktadır.</h4><i class='fa-2x fas fa-exclamation' style='color:red;float:left;margin-left: 5%;margin-top: 4%;'></i>
						</div>";
					}
					else{
					$items=$stmt->fetchAll(PDO::FETCH_ASSOC);//arraya atıyoruz
					foreach ($items as $item): ?>
					<div class="cartItem" id="<?=$item['item_id']?>">
						<div class="cartItemImage">
						</div>
						<h3><?=$item['item_name']?></h3>
						<button style="border:none; border-radius:10px;float:right;position: absolute;margin-left:56%;margin-top:8px;" onclick="amountBtn(<?=$item['item_id']?>,0)"><i class="fa-lg fas fa-trash-alt" aria-hidden="true"></i></button>
						<p id="Price<?=$item['item_id']?>" style="margin-top: 20px;">Price : $<?=number_format($item['miktar']*$item['item_price'],2,".",",")?></p>
						<h5 style="margin-top: 0;">&nbsp;&nbsp;&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</h5>
						<p id="Amount<?=$item['item_id']?>">Amount : <?=$item['miktar']?></p>
						<button style="border-radius: 50%;border:none;float: right;" onclick="amountBtn(<?=$item['item_id']?>,2)"><i class="fa-2x fa fa-chevron-circle-up" style="color:darkblue;" aria-hidden="true"></i></button>
						<button style="border-radius: 50%;border:none;float: right;" onclick="amountBtn(<?=$item['item_id']?>,1)"><i class="fa-2x fa fa-chevron-circle-down" style="color:darkred;"aria-hidden="true"></i></button>
					</div>
					<?php endforeach; }?>
					<script type="text/javascript">
						var formatter = new Intl.NumberFormat('en-US', {
						  style: 'currency',
						  currency: 'USD',
						});//number formatter

						function amountBtn(itemno,mode) {
							var miktar=Number(document.getElementById("Amount"+itemno).textContent.replace("Amount : ",""));//miktarı numberladık
							if(miktar>=1){
								var price=document.getElementById("Price"+itemno).textContent.replace("Price : $","");
								price=parseFloat(price.replace(",",""));
								var birimprice=price/miktar;
								var subTotal=document.getElementById("subTotal").textContent.replace("$","");
								subTotal=parseFloat(subTotal.replace(",",""));
								if(mode==2){//arttir JS
									miktar++;
									subTotal=subTotal+birimprice;
									document.getElementById("subTotal").textContent=formatter.format(subTotal);
									price=(Math.round(birimprice*miktar * 100) / 100).toFixed(2);//2 basamak alma
									document.getElementById("Price"+itemno).textContent="Price : "+formatter.format(price);
									document.getElementById("Amount"+itemno).textContent="Amount : "+miktar;
								}
								if(mode==1){//azalt JS
									miktar--;
									subTotal=subTotal-birimprice;
									document.getElementById("subTotal").textContent=formatter.format(subTotal);
									price=(Math.round(birimprice*miktar * 100) / 100).toFixed(2);//2 basamak alma
									document.getElementById("Price"+itemno).textContent="Price : "+formatter.format(price);
									document.getElementById("Amount"+itemno).textContent="Amount : "+miktar;
								}
								if(miktar==0 || mode==0){//delete SQL JS
									var element = document.getElementById(itemno);
									element.parentNode.removeChild(element);
									subTotal-=price;
									document.getElementById("subTotal").textContent=formatter.format(subTotal);
									$.ajax({
										type:'POST',
										url:'cartFunc.php',
										data:'itemno='+itemno + '&mode='+0,//input boxlu miktar da gonderilcek
									})
								}else{//arttir azalt SQL
									$.ajax({
										type:'POST',
										url:'cartFunc.php',
										data:'itemno='+itemno + '&mode='+mode,//input boxlu miktar da gonderilcek
									})
								}
								document.getElementById("total").textContent=formatter.format(subTotal+9);//total
							}
						}
					</script>
				</div>
			</div>
			

		</div>
	</body>
</html>