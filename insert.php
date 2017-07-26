<?php
	include('connect.php');

	if(isset($_POST["operation"]))
	{
		if($_POST["operation"] == "Add")
		{
			$val = $_POST["item_id"];
			$stm = $db_connect->prepare('SELECT COUNT(*) FROM products WHERE P_ID = :item_id');
			$stm->bindParam(':item_id', $val, PDO::PARAM_STR);
			$stm->execute();
			$res = $stm->fetchColumn();

			if ($res > 0) {
				printf("สินค้ารหัส %s มีอยู่ในระบบอยู่แล้ว", $val);
			}
			else {
				$statement = $db_connect->prepare("
					INSERT INTO products (P_ID, P_Brand, P_Generation, P_Type, P_Quantity, P_Price) 
					VALUES (:item_id, :item_brand, :item_gen, :item_type, :item_qnt, :item_price)
				");
				$result = $statement->execute(
					array(
						':item_id'		=>	$_POST["item_id"],
						':item_brand'	=>	$_POST["item_brand"],
						':item_gen'		=>	$_POST["item_gen"],
						':item_type'	=>	$_POST["item_type"],
						':item_qnt'		=>	$_POST["item_qnt"],
						':item_price'	=>	$_POST["item_price"]
					)
				);
				if(!empty($result))
				{
					echo 'เพิ่มสินค้าเรียบร้อยแล้ว';
				}
			}
		}


		if($_POST["operation"] == "Edit")
		{
			$statement = $db_connect->prepare(
				"UPDATE products 
				SET P_ID = :item_id, P_Brand = :item_brand, P_Generation = :item_gen, P_Type = :item_type, 
					P_Quantity = :item_qnt, P_Price = :item_price
				WHERE P_ID = :id"
			);
			$result = $statement->execute(
				array(
					':item_id'		=>	$_POST["item_id"],
					':item_brand'	=>	$_POST["item_brand"],
					':item_gen'		=>	$_POST["item_gen"],
					':item_type'	=>	$_POST["item_type"],
					':item_qnt'		=>	$_POST["item_qnt"],
					':item_price'	=>	$_POST["item_price"],
					':id'			=>	$_POST["itemID"]
				)
			);
			if(!empty($result))
			{
				echo 'แก้ไขเรียบร้อยแล้ว';
			}
		}
	}



?>