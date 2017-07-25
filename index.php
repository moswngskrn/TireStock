<!DOCTYPE html>
<html>
<head>
	<title>เพิ่มรายการสินค้า</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

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
		margin-bottom: 100px;
	}
	</style>
	
</head>
<body>
	<div class="container box">
		<div class="jumbotron" align="center">
			<h1>รายการสินค้า</h1>
			<button type="button" id="add_button" data-toggle="modal" data-target="#itemModal" class="btn btn-lg btn-success">เพิ่มสินค้า</button>
		</div>
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
						<th>แก้ไข</th>
						<th>ลบ</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</body>
</html>

<div id="itemModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="item_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">เพิ่มสินค้า</h4>
				</div>
				<div class="modal-body">
					<label>รหัสสินค้า</label>
					<input type="text" name="item_id" id="item_id" class="form-control" />
					<br/>
					<label>ยี่ห้อสินค้า</label>
					<input type="text" name="item_brand" id="item_brand" class="form-control" />
					<br/>
					<label>รุ่นสินค้า</label>
					<input type="text" name="item_gen" id="item_gen" class="form-control" />
					<br/>
					<label>ประเภทสินค้า</label>
					<input type="text" name="item_type" id="item_type" class="form-control" />
					<br/>

					<input type="hidden" name="item_qnt" id="item_qnt" class="form-control" />
					<input type="hidden" name="item_price" id="item_price" class="form-control" />
				</div>
				<div class="modal-footer">
					<input type="hidden" name="itemID" id="itemID" />
					<input type="hidden" name="operation" id="operation" />
					<input type="submit" name="action" id="action" class="btn btn-success" value="บันทึก" />
					<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('#add_button').click(function(){
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
			url:"fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 1, 2, 3, 4, 5, 6, 7],
				"orderable":false,
			},
			{
				"targets":[4, 5],
				"visible": false,
				"searchable": false
			}
		],
	});

	$(document).on('submit', '#item_form', function(event){
		event.preventDefault();

		var id = $('#item_id').val();
		var brand = $('#item_brand').val();
		var gen = $('#item_gen').val();
		var type = $('#item_type').val();
		var qnt = $('item_qnt').val();
		var price = $('item_price').val();

		if(id != '')
		{
			$.ajax({
				url:"insert.php",
				method:'POST',
				data:new FormData(this),
				contentType:false,
				processData:false,
				success:function(data)
				{
					alert(data);
					$('#item_form')[0].reset();
					$('#itemModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			alert("กรุณาใส่ข้อมูล");
		}
	});


	$(document).on('click', '.delete', function(){
		var item_id = $(this).attr("id");
		if(confirm("คุณต้องที่การจะลบ "+item_id+" ใช่หรือไม่ ?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{item_id:item_id},
				success:function(data)
				{
					//alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});


	$(document).on('click', '.update', function(){
		var itm_id = $(this).attr("id");
		//alert(itm_id);
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
				$('#item_qnt').val(data.item_qnt);
				$('#item_price').val(data.item_price);
				$('.modal-title').text("แก้ไขข้อมูล");
				$('#itemID').val(itm_id);
				$('#action').val("แก้ไข");
				$('#operation').val("Edit");
			}
		})
	});
});

</script>