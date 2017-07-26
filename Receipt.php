<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
	<link rel="icon" href="images/icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
		function converseBCTOBE(date){
			var mt = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
			var res = date.split("-");
			var y = parseInt(res[0])+543;
			var m = res[1];
			var d = res[2];
			return d+' '+mt[m-1]+' '+y;
		}
		
		$(document).ready(function(){
			var id = '<?=$_GET['id']?>';
			$.ajax({
				url:'GetDetailOrder.php',
				type:'POST',
				data:{id_order:id},
				dataType :'json',
				success: function(result){
					var tr = '';
					var sum = 0;
					var date;
					$.each(result, function(index, element) {
						tr = tr+'<tr>';
						tr = tr+'<td class="col-md-6">'+element.P_ID+'/'+element.P_Brand+'/'+element.P_Generation+'-'+element.Order_date+'</td>';
						tr = tr+'<td col-md-1 style="text-align: center">'+element.D_Quantity+'</td>';
						tr = tr+'<td col-md-4 style="text-align: right">'+element.D_Price+'</td>';
						tr = tr+'<td col-md-1>'+'</td>';
						tr = tr+'</tr>';
						sum = sum+parseFloat(element.D_Price);
						date = element.Order_date;
					});
					
					var trm = '<tr><td></td><td></td><td class="text-right"><h4><strong>ยอดรวม: </strong></h4></td><td class="text-center text-danger"><h4><strong>'+sum+'</strong></h4></td></tr>'
					tr=tr+trm;
					$("#myOrder").empty();
					$('#myOrder').append(tr);
					
					$('#num').empty();
					$('#num').append('เลขที่: '+id);
					
					
					$('#dates').empty();
					$('#dates').append('วันที่: '+converseBCTOBE(date));
				}
			});
		});
	</script>
</head>
	<div class="container">
    <div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                        <strong>Elf Cafe</strong>
                        <br>
                        2135 Sunset Blvd
                        <br>
                        Los Angeles, CA 90026
                        <br>
                        <abbr title="Phone">P:</abbr> (213) 484-6829
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                       <em id="num">เลขที่: 34522677W</em>
                        
                    </p>
                    <p>
                        <em id="dates">วันที่: 24/07/2560</em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1>ใบเสร็จ</h1>
                </div>
                </span>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>จำนวน</th>
                            <th class="text-center">ราคา</th>
                            <th class="text-center">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody id="myOrder">
                        <tr>
                            <td class="col-md-9"><em>Baked Rodopa Sheep Feta</em></h4></td>
                            <td class="col-md-1" style="text-align: center"> 2 </td>
                            <td class="col-md-1 text-center">$13</td>
                            <td class="col-md-1 text-center"></td>
                        </tr>
                        <tr>
                            <td class="col-md-9"><em>Lebanese Cabbage Salad</em></h4></td>
                            <td class="col-md-1" style="text-align: center"> 1 </td>
                            <td class="col-md-1 text-center">$8</td>
                            <td class="col-md-1 text-center"></td>
                        </tr>
                        <tr>
                            <td class="col-md-9"><em>Baked Tart with Thyme and Garlic</em></h4></td>
                            <td class="col-md-1" style="text-align: center"> 3 </td>
                            <td class="col-md-1 text-center">$16</td>
                            <td class="col-md-1 text-center"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<body>
</body>
</html>
