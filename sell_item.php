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
			<li  class="active"><a href="sell_item.php">ขายสินค้า</a></li>
			<li><a href="cancel_order.php">ยกเลิกรายการ</a></li>
			<li><a href="report.php">รายงานผล</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
	<div class="container box">
		<div class="jumbotron" align="center">
			<h1>ขายสินค้า</h1>
		</div>

		<leftside>
			<div class="table-responsive">
				<table id="item_data" class="table table-striped">
					<thead>
						<tr>
							<th>รหัสสินค้า</th>
							<th>ยี่ห้อสินค้า</th>
							<th>รุ่นสินค้า</th>
							<th>ชนิดสินค้า</th>
							<th>จำนวน</th>
							<th>ราคา</th>
							<th>ขายสินค้า</th>
						</tr>
					</thead>
				</table>
			</div>	
			<br/>
			<br/>
		</leftside>
		
	<rightside>
		<font size="6"><span class="label label-info">สินค้าที่ถูกเลือก</span></font>
		<h4>เมื่อทำการเลือกเสร็จสิ้นกรุณาใส่วันที่และกดตกลง</h4>
		<br/>
		
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
		
		
		<div align="right">
		
			<font size="3">กรุณาใส่วันที่: </font>
			<input  id="inputdatepicker" class="datepicker" data-date-format="mm/dd/yyyy">
			<br/><br/>
			<button type="button" name="send_btn" onClick='send_data();' id="send_btn" class="btn btn-primary">ตกลง</button>
			<button type="button" name="cancel_btn" onClick="window.location.reload()" id="cancel_btn" class="btn btn-danger">ยกเลิก</button>
		</div>
	</rightside>
	
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
						
						<label>ยี่ห้อสินค้า</label>
						<input type="text" name="item_brand" id="item_brand" class="form-control" disabled/>
						
						<label>รุ่นสินค้า</label>
						<input type="text" name="item_gen" id="item_gen" class="form-control" disabled/>
						
						<label>ประเภทสินค้า</label>
						<input type="text" name="item_type" id="item_type" class="form-control" disabled/>
						
						<label>จำนวนสินค้าที่ต้องการขาย</label>
						<input type="number" name="item_qnt" id="item_qnt" class="form-control" />
						
						<label>ราคารวมสินค้า</label>
						<input type="number" name="item_price" id="item_price" class="form-control" />
						
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

	<div class="modal fade" tabindex="-1" role="dialog" id="warnModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="warn-modal-title">Modal title</h4>
		</div>
		<div class="modal-body">
			<div id="md_body_ctn">
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
		</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

<script type="text/javascript" language="javascript" >
	$(document).ready(function(){
			
		var dataTable = $('#item_data').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"fetch_for_additem.php",
				type:"POST",
				data:{status:"ขาย", btn:"btn btn-warning btn-xs"},
			},
			"columnDefs":[
				{
					"targets":[0, 1, 2, 3, 4, 5, 6],
					"orderable":false,
				},
				{
					"targets":[2, 3],
					"visible":false,
				},
			],
		});
		
	});

	function modal_alert(title, msg)
	{
		$('#warnModal').modal('show');
		$('.warn-modal-title').text(title);
		$('#md_body_ctn').text(msg);
	}

	function add_helper() {
		var id = document.getElementById('item_id').value;

	
		var quantity = document.getElementById('item_qnt').value;
		var price_pp = document.getElementById('item_price').value;

		if (quantity == 0 || price_pp == 0) {
			modal_alert('คำเตือน !!', "กรุณากรอกข้อมูลให้ครบถ้วน");
			//alert("กรุณากรอกข้อมูลให้ครบ");
			return;
		} else if (parseInt(quantity) < 0 || parseInt(price_pp) < 0) {
			modal_alert('คำเตือน !!', "ค่าที่คุณกรอกเป็นไปไม่ได้");
			return;
		}
		add();
	}


	var cart=[];
	var new_cart = [];
	var temp = "";
	function add(){
		$('#itemModal').modal('toggle');
		
		var id = document.getElementById('item_id').value;
		var quantity = document.getElementById('item_qnt').value;
		var price = document.getElementById('item_price').value;
		
		//alert(id)
		//alert(quantity)
		//alert(price)
		
		cart.push([id,quantity,price]);
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
	var price_pp = 0;
	var qnt=0;
	$(document).on('click', '.update', function(){
		var itm_id = $(this).attr("id");

		for (var i = 0; i < cart.length; i++) {
			if (cart[i][0] == itm_id) {
				modal_alert('คำเตือน !!', "คุณได้ทำการเลือกสินค้าชนิดนี้เพื่อทำการขายไปแล้ว ถ้าต้องการแก้ไขกรุณากดลบที่สินค้าชิ้นนี้และดำเนินการใหม่อีกครั้ง");
				return;
			}
		}

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
				$('#item_price').val('0');
				$('.modal-title').text("ขายสินค้า");
				$('#itemID').val(itm_id);
				$('#action').val("ขาย");
				$('#operation').val("Edit");
				price_pp = data.item_price;
				qnt = data.item_qnt;
			}
		})
	});

	//data.item_price
	
	$('#item_qnt').change(function(){
		
		var num = document.getElementById('item_qnt').value;

		if(parseInt(num) > parseInt(qnt)){
			//alert("qnt: "+qnt+ ", num: "+num);
			modal_alert('คำเตือน !!', 'ระบบไม่สามารถดำเนินการขายได้เนื่องจากจำนวนสินค้าไม่เพียงพอ กรุณาทำรายการใหม่');
			$('#item_qnt').val("");
		}else{
			num = parseFloat(num);
			var p = parseFloat(price_pp);
			$('#item_price').val(parseFloat(p*num));
		}
		
		//document.getElementById('item_price').innerHTML = num;
	});
	function send_data() {

		if (cart.length == 0) modal_alert('คำเตือน !!', "คุณยังไม่ได้เลือกสินค้า");

		else {
			var date = $('#inputdatepicker').val();
			$.ajax({
				url:"add_order.php",
				method:'POST',
				data:{cart:cart, date:date, status:"ออก"},
				success:function(msg)
				{
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
		}

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