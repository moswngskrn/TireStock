<?php 
require('connect.php');
$sql = 'DELETE FROM `orders` WHERE O_ID='.$_POST['id'];
$stmt = $db_connect->prepare($sql);
$stmt->execute();

$sql2 = 'DELETE FROM `order_details` WHERE ID_ORDER='.$_POST['id'];
$stmt2 = $db_connect->prepare($sql2);
$stmt2->execute();
?>