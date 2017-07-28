<?php
	include('connect.php');

	$query = '';
	$output = array();
	$query .= "SELECT * FROM products ";

	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE P_ID LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR P_Brand LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR P_Generation LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR P_Type LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR P_Quantity LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR P_Price LIKE "%'.$_POST["search"]["value"].'%" ';
	}

	if($_POST["length"] != -1)
	{
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $db_connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$data = array();
	$filtered_rows = $statement->rowCount();

	foreach($result as $row)
	{
		$sub_array = array();
		$sub_array[] = $row["P_ID"];
		$sub_array[] = $row["P_Brand"].' / '.$row["P_Generation"].' / '.$row["P_Type"];;
		$sub_array[] = $row["P_Generation"];
		$sub_array[] = $row["P_Type"];
		$sub_array[] = $row["P_Quantity"];
		$sub_array[] = $row["P_Price"];
		$sub_array[] = '<button type="button" name="update" id="'.$row["P_ID"].'" class="'.$_POST["btn"].' update">'.$_POST["status"].'</button>';
		$data[] = $sub_array;
	}

	$output = array(
		"draw"				=>	intval($_POST["draw"]),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_total_all_records(),
		"data"				=>	$data
	);
	echo json_encode($output);


	function get_total_all_records()
	{
		include('connect.php');
		$statement = $db_connect->prepare("SELECT * FROM products");
		$statement->execute();
		$result = $statement->fetchAll();
		return $statement->rowCount();
	}

?>