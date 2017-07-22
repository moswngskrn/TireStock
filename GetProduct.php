<?php 
require('connect.php');
$sql = 'SELECT * FROM `products` WHERE 1';
$stmt = $db_connect->prepare($sql);
$stmt->execute();
$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results, JSON_UNESCAPED_UNICODE);
print_r($json);
?>