<!DOCTYPE html>
<html>
<head>
	<title>ขายสินค้า</title>

	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/bootstrap.min.js"></script>

	<script src="data_table/jquery.dataTables.min.js"></script>
	<script src="data_table/dataTables.bootstrap.min.js"></script>		
	<link rel="stylesheet" href="data_table/dataTables.bootstrap.min.css" />

	<link href="dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="dist/js/bootstrap-datepicker-custom.js"></script>
	<script src="dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>

	<script src="sweetalert/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="sweetalert/sweetalert.css">

	<style>
	body
	{
		margin:0;
		padding:0;
		background-color:#f1f1f1;
	}
	.box
	{
		width:90%;
		padding:30px;
		background-color:#fff;
		border:1px solid #ccc;
		border-radius:10px;
		margin-top:30px;
		margin-bottom:100px;
	}

	leftside 
	{
		padding: 15px;
		border: 1px solid #ccc;
		border-radius: 7px;
		float: left;
		width: 49%;
	}
	rightside
	{
		padding: 15px;
		border: 1px solid #ccc;
		border-radius: 7px;
		float: right;
		width: 49%;
		background-color: #f5f5f5;
	}
	</style>
	<script>
		$(document).ready(function(){
			$.ajax({
				url:'GetOrder.php',
				type:'POST',
				dataType :'json',
				success : function(result){
					var tr = '';
					$.each(result, function(index, element) {
						tr = tr+'<tr>';
						tr = tr+'<td>'+element.O_ID+'</td>';
						tr = tr+'<td>'+element.Order_date+'</td>';
						tr = tr+'<td>'+element.Status+'</td>';
						tr = tr+'<td>'+'<button onClick=\'cancelOrder("'+element.O_ID+'")\' class="btn btn-default">ยกเลิก</button>'+'</td>';
						tr = tr+'</tr>';
					});
					$("#StockTable").empty();
					$('#StockTable').append(tr);
				}
			});
		});
	</script>
</head>
<body>


    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">หน้าหลัก</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="manage.php">รายการสินค้า</a></li>
            <li><a href="add_item.php">เพิ่มจำนวนสินค้าและราคา</a></li>
			<li><a href="sell_item.php">ขายสินค้า</a></li>
			<li  class="active"><a href="cancel_order.php">ยกเลิกรายการ</a></li>
			<li><a href="report.php">รายงานผล</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
	<div class="container box">
		<div class="jumbotron" align="center">
			<h1>ยกเลิกรายการ</h1>
		</div>
		<center><h3>ยอดคงเหลือ</h3></center>
			<table class='table'>
				<thead>
				  <tr>
					<th>รหัสใบสั่งซื้อ</th>
					<th>วันที่</th>
					<th>สถานะ</th>
					<th></th>
				  </tr>
				</thead>
				<tbody id="StockTable">

				</tbody>
			</table>
	</div>
	
	<script>
		function cancelOrder(id){
			swal({
				title: 'Are you sure?',
				text: "คุณต้องการยกเลิกรายการ "+id+" ใช้ไม่!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				confirmButtonText:'ยกเลิก',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ใช่',
				closeOnConfirm: false
			},
			function(){
				$.ajax({
					url:"DeleteOrder.php",
					method:'POST',
					data:{id:id},
					success:function(msg){
						swal({
							title: "แจ้งเตือน",
							text: "ระบบดำเนินการขายเรียบร้อยแล้ว",
						},function(isOk){
							if(isOk){
								window.location.reload();
							}
						});
					}
				});
					
			})
		}
		
	</script>

</body>
</html>