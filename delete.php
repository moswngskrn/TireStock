<?php

include('connect.php');

if(isset($_POST["item_id"]))
{
	$statement = $db_connect->prepare(
		"DELETE FROM products WHERE item_id = :id"
	);
	$result = $statement->execute(
		array(
			':id'	=>	$_POST["item_id"]
		)
	);
	
	if(!empty($result))
	{
		//echo 'ลบรายการเรียบร้อยแล้ว';	
	}
}

?>