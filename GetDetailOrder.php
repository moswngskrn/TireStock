<?php 
require('connect.php');
$sql = 'SELECT products.P_ID,products.P_Brand,products.P_Generation,order_details.D_Quantity,order_details.D_Price,orders.Order_date
FROM order_details 
LEFT JOIN products ON products.P_ID=order_details.ID_PRODUCTS 
LEFT JOIN orders ON orders.O_ID=order_details.ID_ORDER
WHERE order_details.ID_ORDER ='.$_POST['id_order'];
$stmt = $db_connect->prepare($sql);
$stmt->execute();
$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results, JSON_UNESCAPED_UNICODE);
print_r($json);
?>