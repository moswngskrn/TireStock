<?php 
require('connect.php');
require('Date.php');

$selectShow=1;
if($_POST['selectShow']=='สินค้าเข้า'){
	$selectShow = 'orders.Status="เข้า"';
}else if($_POST['selectShow']=='สินค้าออก'){
	$selectShow = 'orders.Status="ออก"';
}

if($_POST['checkAllTime']=='false'){
	$date = new Date;
	$sql = 'SELECT orders.Order_date,orders.O_ID,orders.Status,products.P_ID,products.Brand,products.Generation,products.Type,products.Price,order_details.Quantity 
	FROM orders 
	LEFT JOIN order_details ON order_details.ID_ORDER = orders.O_ID 
	LEFT JOIN products ON products.P_ID = order_details.ID_PRODUCTS 
	WHERE orders.Order_date>="'.$date->converseBEToBC($_POST['from']).'" AND orders.Order_date<="'.$date->converseBEToBC($_POST['to']).'" AND '.$selectShow.' 
	ORDER BY orders.Order_date ASC';
	
	$stmt = $db_connect->prepare($sql);
	$stmt->execute();
	$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
	$json=json_encode($results, JSON_UNESCAPED_UNICODE);
	print_r($json);
}else{
	require('connect.php');
	$sql = 'SELECT orders.Order_date,orders.O_ID,orders.Status,products.P_ID,products.Brand,products.Generation,products.Type,products.Price,order_details.Quantity 
	FROM orders 
	LEFT JOIN order_details ON order_details.ID_ORDER = orders.O_ID 
	LEFT JOIN products ON products.P_ID = order_details.ID_PRODUCTS
	WHERE '.$selectShow.'
	ORDER BY orders.Order_date ASC';
	$stmt = $db_connect->prepare($sql);
	$stmt->execute();
	$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
	$json=json_encode($results, JSON_UNESCAPED_UNICODE);
	$date = new Date;
	print_r($json);
}

?>