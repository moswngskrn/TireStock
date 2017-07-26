<?php 
require('connect.php');

$dataCart = $_POST['cart'];
$d = $_POST['date'];
$status = $_POST['status'];

$date = converseBEToBC($d);

$sql_order = 'INSERT INTO `orders`(`Order_date`, `Status`) VALUES ("'.$date.'","'.$status.'")';
$stmt_order = $db_connect->prepare($sql_order);
$stmt_order->execute();
$id_order = $db_connect->lastInsertId();


if($status=='เข้า'){
	for($i=0;$i<count($dataCart);$i++){
		//Get Quantity Old
		$sql_product = 'SELECT P_Quantity FROM products WHERE P_ID="'.$dataCart[$i][0].'"';
		$stmt_product = $db_connect->prepare($sql_product);
		$stmt_product->execute();
		$row = $stmt_product->fetch();
		$Quantity = $row['P_Quantity'];
		
		$Quantity = $Quantity + $dataCart[$i][1];
		
		//Update new Quantity
		$sql_product_update = 'UPDATE `products` SET `P_Quantity`='.$Quantity.',`P_Price`='.$dataCart[$i][3].' WHERE P_ID="'.$dataCart[$i][0].'"';
		$stmt_product_update = $db_connect->prepare($sql_product_update);
		$stmt_product_update->execute();
		
		//Inser new order detail
		$sql_detail_detail = 'INSERT INTO `order_details`(`ID_ORDER`, `ID_PRODUCTS`, `D_Quantity`, `D_Price`) VALUES ("'.$id_order.'","'.$dataCart[$i][0].'",'.$dataCart[$i][1].','.$dataCart[$i][2].')';
		$stmt_detail_detail=$db_connect->prepare($sql_detail_detail);
		$stmt_detail_detail->execute();
	}
	
	echo "ระบบดำเนินการเพิ่มจำนวนสินค้าและราคาเรียบร้อยแล้ว";
}

if($status=='ออก'){
	$can_sell = true;
	for($i=0;$i<count($dataCart);$i++){
		//Get Quantity Old
		$sql_product = 'SELECT P_Quantity FROM products WHERE P_ID="'.$dataCart[$i][0].'"';
		$stmt_product = $db_connect->prepare($sql_product);
		$stmt_product->execute();
		$row = $stmt_product->fetch();
		$Quantity = $row['P_Quantity'];
		
		$Quantity = $Quantity - $dataCart[$i][1];

		if ($Quantity < 0) {
			$can_sell = false;
		}
		else {
			$okResult = $Quantity;
			//Update new Quantity
			$sql_product_update = 'UPDATE `products` SET `P_Quantity`='.$Quantity.' WHERE P_ID="'.$dataCart[$i][0].'"';
			$stmt_product_update = $db_connect->prepare($sql_product_update);
			$stmt_product_update->execute();
			
			//Inser new order detail
			$sql_detail_detail = 'INSERT INTO `order_details`(`ID_ORDER`, `ID_PRODUCTS`, `D_Quantity`, `D_Price`) VALUES ("'.$id_order.'","'.$dataCart[$i][0].'",'.$dataCart[$i][1].','.$dataCart[$i][2].')';
			$stmt_detail_detail=$db_connect->prepare($sql_detail_detail);
			$stmt_detail_detail->execute();
		}
	}

	if ($can_sell == true) {
		echo "ดำเนินการขายเรียบร้อยแล้ว";
	}
	else {
		echo "ระบบไม่สามารถดำเนินการขายได้เนื่องจากจำนวนสินค้าไม่เพียงพอ กรุณาทำรายการใหม่";
	}

}






	function converseBEToBC($date){
		$dt = explode("/",$date);
		$d = $dt[0];
		$m = $dt[1];
		$y = $dt[2]-543;
		return $y.'-'.$m.'-'.$d;
	}
?>