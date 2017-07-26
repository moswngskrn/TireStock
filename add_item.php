<!DOCTYPE html>
<html>
<head>
	<title>เพิ่มจำนวนและราคา</title>

	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
	<script src="bootstrap/js/bootstrap.min.js"></script>

	<script src="data_table/jquery.dataTables.min.js"></script>
	<script src="data_table/dataTables.bootstrap.min.js"></script>		
	<link rel="stylesheet" href="data_table/dataTables.bootstrap.min.css" />

	<link href="dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="dist/js/bootstrap-datepicker-custom.js"></script>
	<script src="dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>

	<style>
	body
	{
		margin:0;
		padding:0;
		background-color:#f1f1f1;
	}
	.box
	{
		width:85%;
		padding:30px;
		background-color:#fff;
		border:1px solid #ccc;
		border-radius:10px;
		margin-top:30px;
		margin-bottom:100px;
	}
	</style>
	
</head>
<body>
	
	<div class="container box">
		<div class="jumbotron" align="center">
			<h1>เพิ่มจำนวนและราคา</h1>
		</div>
		<div class="table-responsive">
			<table id="item_data" class="table table-striped">
				<thead>
					<tr>
						<th width="10%">รหัสสินค้า</th>
						<th width="10%">ยี่ห้อสินค้า</th>
						<th width="10%">รุ่นสินค้า</th>
						<th width="10%">ชนิดสินค้า</th>
						<th width="10%">จำนวน</th>
						<th width="10%">ราคา</th>
						<th width="10%">ราคา / จำนวน</th>
					</tr>
				</thead>
			</table>
		</div>	
		<br/>
		<br/>
		
		<div class="jumbotron">
			<h1>สินค้าที่ถูกเลือก</h1>
			<h3>เมื่อทำการเลือกเสร็จสิ้นกรุณาใส่วันที่และกดตกลง</h3>
			
			<div id="showCart">
			<table class='table table-bordered table-striped'>
				<thead>
				  <tr>
					<th width="30%">รหัสสินค้า</th>
					<th width="30%">จำนวน</th>
					<th width="30%">ราคา</th>
					<th width="10%">ลบ</th>
				  </tr>
				</thead>
				<tbody id="listCart">
				</tbody>
			</table>
			</div>
		</div>
		
		
	<div align="right">
	
		<font size="3">กรุณาใส่วันที่: </font>
		<input  id="inputdatepicker" class="datepicker" data-date-format="mm/dd/yyyy">
		<br/><br/>
		<button type="button" name="send_btn" onClick='send_data();' id="send_btn" class="btn btn-primary">ตกลง</button>
		<button type="button" name="cancel_btn" id="cancel_btn" class="btn btn-danger">ยกเลิก</button>
	</div>
	
	</div>
	

<div id="itemModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="item_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">เพิ่มจำนวน / ราคา</h4>
				</div>
				<div class="modal-body">
					<label>รหัสสินค้า</label>
					<input type="text" name="item_id" id="item_id" class="form-control" disabled/>
					<br/>
					<label>ยี่ห้อสินค้า</label>
					<input type="text" name="item_brand" id="item_brand" class="form-control" disabled/>
					<br/>
					<label>รุ่นสินค้า</label>
					<input type="text" name="item_gen" id="item_gen" class="form-control" disabled/>
					<br/>
					<label>ประเภทสินค้า</label>
					<input type="text" name="item_type" id="item_type" class="form-control" disabled/>
					<br/>
					<label>จำนวนสินค้าที่ต้องการเพิ่ม</label>
					<input type="number" name="item_qnt" id="item_qnt" class="form-control" />
					<br/>
					<label>ราคาสินค้ารวม</label>
					<input type="number" name="item_price" id="item_price_sum" class="form-control" />
					<br/>
					<label>ราคาสินค้าต่อชิ้น(ต้องการขาย)</label>
					<input type="number" name="item_price" id="item_price" class="form-control" />
					<br/>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="itemID" id="itemID" />
					<input type="hidden" name="operation" id="operation" />
					<input type="button" name="action" onClick='add_helper();' id="action" class="btn btn-success" value="บันทึก" />
					<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
		$('#add_button').click(function(){
			alert('add');
			$('#item_form')[0].reset();
			$('.modal-title').text("เพิ่มสินค้า");
			$('#action').val("บันทึก");
			$('#operation').val("Add");
		});
			
		var dataTable = $('#item_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch_for_additem.php",
				type:"POST",
				data:{status:"เพิ่มจำนวน / ราคา"},
			},
			"columnDefs":[
				{
					"targets":[0, 1, 2, 3, 4, 5, 6],
					"orderable":false,
				},
			],
		});
		
	});

	function add_helper() {
		var id = document.getElementById('item_id').value;
		var can_add = true;

		//alert(cart.length);
		for (var i = 0; i < cart.length; i++) {
			if (cart[i][0] == id) {
				alert('คุณได้ทำการเลือกสินค้าชนิดนี้เพื่อทำการเพิ่มจำนวนและราคาไปแล้ว ถ้าต้องการแก้ไขกรุณากดลบที่สินค้าชิ้นนี้ด้านล่างและดำเนินการใหม่อีกครั้ง');
				can_add = false;
				$('#itemModal').modal('toggle');
			}
		}

		if (can_add == true) {
			add();
		}
	}


	var cart=[];
	var new_cart = [];
	var temp = "";
	function add(){
		$('#itemModal').modal('toggle');
		
		var id = document.getElementById('item_id').value;
		var quantity = document.getElementById('item_qnt').value;
		var price = document.getElementById('item_price_sum').value;
		var price_pp = document.getElementById('item_price').value;
		
		//alert(id)
		//alert(quantity)
		//alert(price)
		
		cart.push([id,quantity,price,price_pp]);
		var tr = '';
		for(var i=0;i<cart.length;i++){
			tr=tr+'<tr>';
			for(var j=0;j<cart[i].length;j++){
				tr=tr+'<td>'+cart[i][j]+'</td>';
			}
			tr=tr+'<td><button type="button" name="del_btn" id="'+cart[i][0]+'" onClick="del(this.id)" class="btn btn-xs btn-danger">ลบ</button></td>';
			tr=tr+'</tr>';
		}
		$("#listCart").empty();
		$('#listCart').append(tr);
		
		//alert(tr);
	}
	
	function del(val) {
		//alert(val);

		new_cart = [];
		for (var i = 0; i < cart.length; i++) {
			if (cart[i][0] != val) {
				new_cart.push(cart[i]);
			}
		}

		var tr = '';
		for(var i=0;i< new_cart.length;i++){
			tr=tr+'<tr>';
			for(var j=0;j<new_cart[i].length;j++){
				tr=tr+'<td>'+new_cart[i][j]+'</td>';
			}
			tr=tr+'<td><button type="button" name="del_btn" id="'+new_cart[i][0]+'" onClick="del(this.id)" class="btn btn-xs btn-danger">ลบ</button></td>';
			tr=tr+'</tr>';
		}

		cart = new_cart;

		$("#listCart").empty();
		$('#listCart').append(tr);


	}
	
	$(document).on('click', '.update', function(){
		var itm_id = $(this).attr("id");
		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{itm_id:itm_id},
			dataType:"json",
			success:function(data)
			{
				$('#itemModal').modal('show');
				$('#item_id').val(data.item_id);
				$('#item_brand').val(data.item_brand);
				$('#item_gen').val(data.item_gen);
				$('#item_type').val(data.item_type);
				$('#item_qnt').val("");
				$('#item_price').val(data.item_price);
				$('.modal-title').text("เพิ่มจำนวน / ราคา");
				$('#itemID').val(itm_id);
				$('#action').val("เพิ่ม");
				$('#operation').val("Edit");
			}
		})
	});

	function send_data() {

		var date = $('#inputdatepicker').val();

		$.ajax({
			url:"add_order.php",
			method:'POST',
			data:{cart:cart, date:date, status:"เข้า"},
			success:function(msg)
			{
				alert(msg);
				location.reload();
			}
		});

	}
	
	$(document).ready(function () {
		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			todayBtn: true,
			language: 'th',
			thaiyear: true
		}).datepicker("setDate", "0");
	});

</script>

</body>
</html>