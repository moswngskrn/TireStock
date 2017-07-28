<!DOCTYPE html>
<html>
<head>
	<title>เพิ่มรายการสินค้า</title>

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
            <li  class="active"><a href="manage.php">รายการสินค้า</a></li>
            <li><a href="add_item.php">เพิ่มจำนวนสินค้าและราคา</a></li>
			<li><a href="sell_item.php">ขายสินค้า</a></li>
			<li><a href="cancel_order.php">ยกเลิกรายการ</a></li>
			<li><a href="report.php">รายงานผล</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

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
					
					<label>ยี่ห้อสินค้า</label>
					<input type="text" name="item_brand" id="item_brand" class="form-control" />
					
					<label>รุ่นสินค้า</label>
					<input type="text" name="item_gen" id="item_gen" class="form-control" />
					
					<label>ประเภทสินค้า</label>
					<input type="text" name="item_type" id="item_type" class="form-control" />
					

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

	function modal_alert(title, msg)
	{
		$('#warnModal').modal('show');
		$('.warn-modal-title').text(title);
		$('#md_body_ctn').text(msg);
	}

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
					modal_alert('แจ้งเตือน', data);
					$('#item_form')[0].reset();
					$('#itemModal').modal('hide');
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			modal_alert("แจ้งเตือน", "กรุณาใส่ข้อมูล");
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