<?php
include('connect.php');


if(isset($_POST["itm_id"]))
{

	$output = array();
	$statement = $db_connect->prepare(
		"SELECT * FROM products
		WHERE P_ID = '".$_POST["itm_id"]."' 
		LIMIT 1"
	);

	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["item_id"] = $row["P_ID"];
		$output["item_brand"] = $row["P_Brand"];
		$output["item_gen"] = $row["P_Generation"];
		$output["item_type"] = $row["P_Type"];
		$output["item_qnt"] = $row["P_Quantity"];
		$output["item_price"] = $row["P_Price"];

	}
	echo json_encode($output);
}
?>