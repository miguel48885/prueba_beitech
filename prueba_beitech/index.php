<?php

 include_once("config.php");
					
 if(isset($_POST['filtrar'])){
	
	$customer_id=$_POST['cliente'];	
	$datos=json_decode(file_get_contents("http://localhost:8000/prueba_beitech/read_one.php?customer_id=$customer_id"),true); 
}
 						

?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Homepage</title>	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<style type="text/css">
			.table > tbody > tr > td {vertical-align: middle;}
		</style>
	</head>
	<body>
	<div class="container" style="padding: 3% 0 0;">
		<h1 class="page-header text-center">LISTADO DE ORDENES</h1>
    <br/>
     <div class="row">
     	 <form name="form1" method="post" action="index.php">
     	<select id="cliente" name="cliente">

        <?php
          $query = mysqli_query($mysqli, "SELECT * FROM test.customer");

          while ($valores = mysqli_fetch_array($query)) {
          	if(isset($_POST["cliente"]) && $_POST["cliente"]==$valores['customer_id']){
          		echo '<option value="'.$valores['customer_id'].'" selected>'.$valores['name'].'</option>';
          	}else{
          		echo '<option value="'.$valores['customer_id'].'">'.$valores['name'].'</option>';
          	}
            
          }
        ?>
      </select>
		<input type="submit" name="filtrar" value="Filtrar">
		</form>
     </div>
          <BR><BR>
    <div class="row">


    	<div class="col-sm-12">
			<table class="table table-bordered table-striped table-responsive-sm">
				<thead>
					<tr bgcolor="#b9c9fe" style="color: #039">
			            <th>Creation Date</th>
			            <th>Order ID</th>
			            <th>Total</th>
			            <th>Delivery Address</th>
			            <th>Products</th>
					</tr>
				</thead>
				<tbody>
				<?php
			if(isset($datos)){
				if(!is_null($datos)){
					foreach ($datos as $res){
						 echo "<tr>";
				         echo "<td>".$res['creation_date']."</td>";
				         echo "<td>".$res['order_id']."</td>";
				         echo "<td>".$res['total']."</td>";
				         echo "<td>".$res['delivery_address']."</td>";
				         echo "<td>";
				        $datos2=$res['OrderDetails'];
				        if(!is_null($datos2)){
				         foreach ($datos2 as $res2){
				         	 echo $res2['quantity']." x ".$res2['product_description']."; ";
				         }
				     }
				        echo "</td>";				            					         				         
					}
				}

			}	
				?>
				</tbody>
			</table>			  
		</div>
	</div>
		<br>
	</div>
	</body>
</html>