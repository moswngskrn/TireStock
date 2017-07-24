<?php
	include('connect.php');

	$query = '';
	$output = array();
	$query .= "SELECT * FROM products ";

	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE item_id LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR item_brand LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR item_gen LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR item_type LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR item_qnt LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR item_price LIKE "%'.$_POST["search"]["value"].'%" ';
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
		$sub_array[] = $row["item_id"];
		$sub_array[] = $row["item_brand"];
		$sub_array[] = $row["item_gen"];
		$sub_array[] = $row["item_type"];
		$sub_array[] = $row["item_qnt"];
		$sub_array[] = $row["item_price"];
		$sub_array[] = '<button type="button" name="update" id="'.$row["item_id"].'" class="btn btn-warning btn-xs update">แก้ไข</button>';
		$sub_array[] = '<button type="button" name="delete" id="'.$row["item_id"].'" class="btn btn-danger btn-xs delete">ลบ</button>';
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