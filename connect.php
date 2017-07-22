<?php 
try{
	$db_connect = new PDO('mysql:host=localhost;dbname=tire_stock','root','12345678');
	$db_connect->exec("set names utf8");
}catch(PDOException $e){
	echo 'Could not connect to database';
}
?>