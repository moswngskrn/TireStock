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
	
	<link rel="stylesheet" href="css/style.css">
	
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
		
		$(document).ready(function(){
			$.ajax({
				url:'GetProduct.php',
				type:'POST',
				dataType :'json',
				success : function(result){
					var tr = '';
					$.each(result, function(index, element) {
						tr = tr+'<tr>';
						tr = tr+'<td>'+element.P_ID+'</td>';
						tr = tr+'<td>'+element.Brand+'</td>';
						tr = tr+'<td>'+element.Generation+'</td>';
						tr = tr+'<td>'+element.Type+'</td>';
						tr = tr+'<td>'+element.Price+'</td>';
						tr = tr+'<td>'+element.Quantity +'</td>';
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

	<div class="jumbotron">
			<h1>Stock</h1>      
			<p>รายงานและสรุป</p>
	</div>
	<div class="tab">
		<button class="tablinks" onclick="openCity(event, 'Stock')" id="defaultOpen">สินค้าใน Stock</button>
		<button class="tablinks" onclick="openCity(event, 'Order')">สินค้าเข้า-ออก</button>
	</div>

	<div id="Stock" class="tabcontent">
		<h3>สินค้าใน Stock</h3>
		<p>เช็คจำนวนสินค้าใน stock</p>
		<hr>
		<div id="reportStock">
			<center><h3>ยอดคงเหลือ</h3></center>
			<table class='table'>
				<thead>
				  <tr>
					<th>รหัสสิ้นค้า</th>
					<th>ยี่่ห้อ</th>
					<th>รุ้น</th>
					<th>ชนิด</th>
					<th>ราคา</th>
					<th>จำนวน</th>
				  </tr>
				</thead>
				<tbody id="StockTable">

				</tbody>
			</table>
		</div>
		<button onClick='printDiv("reportStock")' class="btn btn-default">พิมพ์</button>
	</div>

	<div id="Order" class="tabcontent">
		<h3>สินค้าเข้า-ออก</h3>
		<p>เช็คดูการเข้าออกของสินค้า</p>
		<hr>
		<div class="form-group col-xs-6 col-sm-3">
			<label class="col-sm-4 col-form-label" for="inputdatepicker" >ตั้งแต่</label>
			<input  id="inputdatepicker" class="datepicker col-sm-8" data-date-format="mm/dd/yyyy">
		</div>

		<div class="form-group col-xs-6 col-sm-3">
			<label class="col-sm-4 col-form-label" for="inputdatepicker2" >ถึง</label>
			<input id="inputdatepicker2" class="datepicker col-sm-8" data-date-format="mm/dd/yyyy">
		</div>

		<div class="form-group col-xs-6 col-sm-2">
			<label class="form-check-label">
				<input id="allTime" onClick="checkAllTime()" type="checkbox" class="form-check-input">
				ทุกช่วง
			</label>
		</div>

		<div class="form-group col-xs-6 col-sm-3">
			<select class="form-control" id="selectShow">
				<option>แสดงรายการทั้งหมด</option>
				<option>สินค้าเข้า</option>
				<option>สินค้าออก</option>
			</select>
		</div>

		<div class="col-xs-6 col-sm-1">
			<button onClick="show()" class="btn btn-default">แสดง</button>
		</div>
		<div class="container col-xs-12">
			<hr>
			<div id="report">
				<center><h3>รายงานผล</h3></center>
				<p id="showDate"></p>
				<p id="showIn"></p>
				<p id="showOut"></p>
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
			<button onClick='printDiv("report")' class="btn btn-default">พิมพ์</button>
		</div>
		
		
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
			
			var str = 'ตั้งแต่เริ่ม ถึง ปัจจุบัน';
			if(!checkAllTime){
				str = 'ตั้งแต่ '+from +' ถึง '+to;
			}
			
			$("#showDate").empty();
			$('#showDate').append(str);
			
			var countIn = 0;
			var conntOut = 0;
			
			$.ajax({
				url:'GetDataReport.php',
				type:'POST',
				data:{from:from,to:to,checkAllTime:checkAllTime,selectShow:selectShow},
				dataType :'json',
				success : function(result){
					var tr = '';
					$.each(result, function(index, element) {
						if(element.Status=='เข้า'){
							countIn=countIn+parseInt(element.Quantity);
						}else if(element.Status=='ออก'){
							conntOut=conntOut+parseInt(element.Quantity);
						}
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
					
					$('#showIn').empty();
					$('#showIn').append('สินค้าเข้าจำนวน '+countIn);
					$('#showOut').empty();
					$('#showOut').append('สินค้าออกจำนวน '+conntOut);
				}
			});
			
		}
		
		function printDiv(id){
			var divPrint = document.getElementById(id);
			var newWin=window.open('','Print-Window');
			newWin.document.write('<html><head><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"><script src="js/jquery.min.js"><\/script><script src="bootstrap/js/bootstrap.min.js"><\/script></head><body onload="window.print()">'+divPrint.innerHTML+'</body></html>');
			newWin.document.close();
			setTimeout(function(){
				newWin.close();
			},10);
		}
		
		
		function openCity(evt, cityName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}
		document.getElementById("defaultOpen").click();
		
		
	
	</script>
</body>
</html>