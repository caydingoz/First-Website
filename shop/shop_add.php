<?php
	include("../config.php");
	$item_name=$_POST['item_Name'];
	$item_category=$_POST['item_Category'];
	$item_price=$_POST['item_Price'];

	if (!preg_match("/^[a-zA-Z0-9\s ığüşöçİĞÜŞÖÇ]*$/", $item_name)) {
			header("Location: shop.php?item_name=invalid");
	}
	if (!preg_match("/^[a-zA-Z\s ığüşöçİĞÜŞÖÇ]*$/", $item_category)) {
			header("Location: shop.php?item_category=invalid");
	}
	else{
		$SELECT="SELECT item_name FROM items WHERE item_name = ? Limit 1";
		$INSERT="INSERT Into items (item_name, item_category, item_price) values(?,?,?)";
		
		$stmt=$db->prepare($SELECT);
		$stmt->bind_param("s",$item_name );
		$stmt->execute();
		$stmt->bind_result($item_name);
		$stmt->store_result();
		$rnum=$stmt->num_rows;
		if ($rnum==0) {
			$stmt->close();
			$stmt=$db->prepare($INSERT);
			$stmt->bind_param("ssd",$item_name ,$item_category ,$item_price);
			$stmt->execute();
			header("Location:shop.php?success ");
		}else{
			header("Location: shop.php?item=exist");
		}
		$stmt->close();
		$db->close();
	}
?>