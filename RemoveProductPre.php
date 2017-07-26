<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
<input id="id_p" type="text" class="form-control" placeholder="ID">
<input id="quantity_p" type="text" class="form-control" placeholder="Quantity">
<input id="price_p" type="text" class="form-control" placeholder="Price">
<button onClick='add();' class="btn btn-default">add</button>
<div id="showCart">
	<table class='table'>
		<thead>
		  <tr>
			<th>รหัสสิ้นค้า</th>
			<th>จำนวน</th>
			<th>ราคา</th>
		  </tr>
		</thead>
		<tbody id="listCart">
		</tbody>
	</table>
</div>
<button onClick='sendToAdd();' class="btn btn-default">send</button>
<script>
	var cart=[];
	function add(){
		var id = document.getElementById('id_p').value;
		var quantity = document.getElementById('quantity_p').value;
		var price = document.getElementById('price_p').value;
		cart.push([id,quantity,price,]);
		var tr = '';
		for(var i=0;i<cart.length;i++){
			tr=tr+'<tr>';
			for(var j=0;j<cart[i].length;j++){
				tr=tr+'<td>'+cart[i][j]+'</td>';
			}
			tr=tr+'</tr>';
		}
		$("#listCart").empty();
		$('#listCart').append(tr);
	}
	
	function sendToAdd(){
		var status="ออก";
		$.ajax({
			url:'add_order.php',
			type:'POST',
			data:{cart:cart,status:status},
			success: function(result){

			}
		});
	}
</script>
</body>
</html>