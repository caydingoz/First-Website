<?php
include '../config.php';
include '../ChromePhp.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login/login.php');
	exit;
}

	$item_id=$_POST['itemno'];
	$item_miktar=$_POST['miktar'];
	$mode=$_POST['mode'];
	$user_id=$_SESSION['id'];
	$control=true;
	$pdo = pdo_connect_mysql();

	if($mode==3){//sepete ekle
		$stmt=$pdo->query("SELECT itemID from cart inner join users on cart.userID=users.id where 
		users.id=$user_id");
		$cartitems=$stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($cartitems as $item){
			if ($item['itemID']==$item_id) {
				$control=false;
			}
		}
		if($control){
			$stmt=null;
			$sql = "INSERT Into cart (userID, itemID, miktar) values(?,?,?)";
			$stmt = $db->prepare($sql);
			$stmt->bind_param('iii', $_SESSION['id'],$item_id,$item_miktar);
			$stmt->execute();
		}else{
			$stmt=null;
			$sql = "UPDATE cart SET miktar = miktar+$item_miktar WHERE itemID = $item_id AND userID= $user_id";
			$stmt = $db->prepare($sql);
			$stmt->execute();
		}
	}
	elseif ($mode==2) {//arttır
		$stmt=null;
		$sql = "UPDATE cart SET miktar = miktar+1 WHERE itemID = $item_id AND userID= $user_id";
		$stmt = $db->prepare($sql);
		$stmt->execute();
	}
	elseif ($mode==1) {//azalt
		$stmt=null;
		$sql = "UPDATE cart SET miktar = miktar-1 WHERE itemID = $item_id AND userID= $user_id";
		$stmt = $db->prepare($sql);
		$stmt->execute();
	}
	else{//delete
		ChromePhp::log($mode);
		$stmt=null;
		$sql = "DELETE FROM cart WHERE itemID = $item_id AND userID= $user_id";
		$stmt = $db->prepare($sql);
		$stmt->execute();
	}
	

?>