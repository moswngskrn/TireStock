<?php 
	session_start();
	if(isset($_SESSION['login'])){
		header('Location: index.php');
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="icon" href="images/icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<div class="container">
		<div style="background:#000000;padding:10px;color:#FFF" class="jumbotron">
			<h1>Stock</h1>      
			<p>กรุณาเข้าสู้ระบบ</p>
		</div>
		<div class="col-xs-12 center_div">
			<form class="col-xs-12 col-sm-4  form-margin" action="login.php" method="post">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input id="user" type="text" class="form-control" name="user" placeholder="ชื่อผู้ใช้งาน">
				</div>
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
				</div><br>
				<button type="submit" class="btn btn-default col-xs-12">เข้าสู่ระบบ</button>
				<?php 
					require('connect.php');
					
					$get_id = (isset($_POST['user'])) ? $_POST['user'] : '';
					
					if($get_id && $_POST['password']){
						$sql = 'SELECT * FROM `user` WHERE Username="'.$_POST['user'].'" && Password="'.$_POST['password'].'"';
						$stmt = $db_connect->prepare($sql);
						$stmt->execute();
						$number_of_rows = $stmt->fetchColumn(); 
						if($number_of_rows==0){
							echo '<p>'.'Username หรือ Password ไม่ถูกต้อง'.'</p>';
						}else{
							$_SESSION['login']='login';
							header('Location: index.php');
						}
					}
					//var_dump($_POST);
				?>
			</form>
		</div>
	</div>
</body>
</html>