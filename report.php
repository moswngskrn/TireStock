<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Report</title>
	<link rel="icon" href="images/icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>

	<link href="dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <script src="dist/js/bootstrap-datepicker-custom.js"></script>
	<script src="dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
	
	<script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',
                thaiyear: true
            }).datepicker("setDate", "0");
        });
    </script>

</head>
<body>
	<div class="container">
		<div style="background:#000000;padding:10px;color:#FFF" class="jumbotron">
			<h1>Report Stock</h1>      
			<p>รายงานและสรุป</p>
		</div>
		
		<form class="form-inline">
			<div class="form-group">
				<label class="col-2 col-form-label" for="inputdatepicker" >ตั้งแต่</label>
				<input  id="inputdatepicker" class="datepicker" data-date-format="mm/dd/yyyy">
			</div>
			<div class="form-group">
				<label class="col-2 col-form-label" for="inputdatepicker2" >ถึง</label>
				<input id="inputdatepicker2" class="datepicker" data-date-format="mm/dd/yyyy">
			</div>
			<div class="form-group">
				<label class="form-check-label">
					<input id="allTime" onClick="checkAllTime()" type="checkbox" class="form-check-input">
					ทุกช่วง
				</label>
			</div>
		</form>
			<div class="form-group">
				<select class="form-control" id="selectShow">
					<option>แสดงรายการทั้งหมด</option>
					<option>สินค้าเข้า</option>
					<option>สินค้าออก</option>
				</select>
			</div>
			<button onClick="show()" class="btn btn-default">แสดง</button>
			
			<table class='table'>
				<thead>
				  <tr>
					<th>วันที่</th>
					<th>เลขที่ใบสั่งซื้อ</th>
					<th>สถานะ</th>
					<th>รหัสสิ้นค้า</th>
					<th>ยี่่ห้อ</th>
					<th>รุ้น</th>
					<th>ชนิด</th>
					<th>ราคา</th>
					<th>จำนวน</th>
				  </tr>
				</thead>
				<tbody id="mytable">
					
				</tbody>
			</table>
		
	</div>
	<script>
		function checkAllTime(){
			var checkAllTime = document.getElementById('allTime').checked;
			if(!checkAllTime){
				document.getElementById('inputdatepicker').disabled =false;
				document.getElementById('inputdatepicker2').disabled =false;
			}else{
				document.getElementById('inputdatepicker').disabled =true;
				document.getElementById('inputdatepicker2').disabled =true;
			}
		}
		function converseBCTOBE(date){
			var res = date.split("-");
			var y = res[0]+543;
			var m = res[1];
			var d = res[2];
			return d+'/'+m+'/'+y;
		}
		function show(){
			var from =	document.getElementById('inputdatepicker').value;
			var to = document.getElementById('inputdatepicker2').value;
			var checkAllTime = document.getElementById('allTime').checked;
			var selectShow = document.getElementById('selectShow').value;
			$.ajax({
				url:'GetDataReport.php',
				type:'POST',
				data:{from:from,to:to,checkAllTime:checkAllTime,selectShow:selectShow},
				dataType :'json',
				success : function(result){
					var tr = '';
					$.each(result, function(index, element) {
						tr = tr+'<tr>';
						tr = tr+'<td>'+converseBCTOBE(element.Order_date)+'</td>';
						tr = tr+'<td>'+element.O_ID+'</td>';
						tr = tr+'<td>'+element.Status+'</td>';
						tr = tr+'<td>'+element.P_ID+'</td>';
						tr = tr+'<td>'+element.Brand+'</td>';
						tr = tr+'<td>'+element.Generation+'</td>';
						tr = tr+'<td>'+element.Type+'</td>';
						tr = tr+'<td>'+element.Price+'</td>';
						tr = tr+'<td>'+element.Quantity +'</td>';
						tr = tr+'</tr>';
					});
					$("#mytable").empty();
					$('#mytable').append(tr);
				}
			});
			
		}
	</script>
</body>
</html>