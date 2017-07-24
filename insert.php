<?php
	include('connect.php');

	if(isset($_POST["operation"]))
	{
		if($_POST["operation"] == "Add")
		{
			$val = $_POST["item_id"];
			$stm = $db_connect->prepare('SELECT COUNT(*) FROM products WHERE item_id = :item_id');
			$stm->bindParam(':item_id', $val, PDO::PARAM_STR);
			$stm->execute();
			$res = $stm->fetchColumn();

			if ($res > 0) {
				printf("สินค้ารหัส %s มีอยู่ในระบบอยู่แล้ว", $val);
			}
			else {
				$statement = $db_connect->prepare("
					INSERT INTO products (item_id, item_brand, item_gen, item_type, item_qnt, item_price) 
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
				SET item_id = :item_id, item_brand = :item_brand, item_gen = :item_gen, item_type = :item_type, 
					item_qnt = :item_qnt, item_price = :item_price
				WHERE item_id = :id"
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