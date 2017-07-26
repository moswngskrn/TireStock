<?php 
	session_start();
	if(!isset($_SESSION['login'])){
		header('Location: login.php');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Strock</title>
<link rel="icon" href="images/icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<div style="background:#000000;padding:10px;color:#FFF" class="jumbotron">
			<h1>Stock</h1>      
			<p>..............</p>
		</div>
		
		<a href="report.php" target="_blank"><button type="button" class="btn btn-default col-xs-3">Report</button></a>  
		<a href="manage.php" target="_blank"><button type="button" class="btn btn-default col-xs-3">เพิ่มรายการสินค้า</button></a> 
		<a href="add_item.php" target="_blank"><button type="button" class="btn btn-default col-xs-3">เพิ่มจำนวนและราคาสินค้า</button></a> 
		<a href="sell_item.php" target="_blank"><button type="button" class="btn btn-default col-xs-3">ขายสินค้า</button></a> 
		<a href="logout.php"><button type="button" class="btn btn-default col-xs-3">Logout</button></a>
	</div>
</body>
<script>
	function gotoPage(page){
		window.open(page,"name","menubar=no,channelmode=no,location=no,directories=no,toolbar=no,status=no,resizable=no,scrollbars=no,menubar=no,height=600,width=900");
		window.close();
							
	}
</script>
</html>