<?php
include('connect.php');


if(isset($_POST["itm_id"]))
{
	$output = array();
	$statement = $db_connect->prepare(
		"SELECT * FROM products
		WHERE item_id = '".$_POST["itm_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["item_id"] = $row["item_id"];
		$output["item_brand"] = $row["item_brand"];
		$output["item_gen"] = $row["item_gen"];
		$output["item_type"] = $row["item_type"];
		$output["item_qnt"] = $row["item_qnt"];
		$output["item_price"] = $row["item_price"];

	}
	echo json_encode($output);
}
?>