<?php
include_once("config.php");

	if(isset($_POST['Submit']) && isset($_POST['producto1']) &&
	   isset($_POST['producto2']) && isset($_POST['producto3']) &&
	   isset($_POST['producto4']) && isset($_POST['producto5'])) 
	   { 
	
			$customer_id=$_POST['customer_id'];
			$delivery_address=$_POST['delivery_address'];
						
			$producto1 = $_POST['producto1'];
			$producto2 = $_POST['producto2'];
			$producto3 = $_POST['producto3'];
			$producto4 = $_POST['producto4'];
			$producto5 = $_POST['producto5'];

			$cantidad1 = $_POST['cantidad1'];
			$cantidad2 = $_POST['cantidad2'];
			$cantidad3 = $_POST['cantidad3'];
			$cantidad4 = $_POST['cantidad4'];
			$cantidad5 = $_POST['cantidad5'];

			if( (($producto1<>0) &&
			 in_array($producto1, array($producto2,$producto3,$producto4,$producto5)))
			 || (($producto2<>0) &&
			 in_array($producto2, array($producto1,$producto3,$producto4,$producto5)))
			 || (($producto3<>0) &&
			 in_array($producto3, array($producto2,$producto1,$producto4,$producto5)))
			 || (($producto4<>0) &&
			 in_array($producto4, array($producto2,$producto3,$producto1,$producto5)))
			 || (($producto5<>0) && 
			 in_array($producto5, array($producto2,$producto3,$producto4,$producto1)))){
				echo '<script language="javascript">alert("producto repetido");</script>'; 
			}else if($_POST["Submit"] == 'Guardar'){

				$order_Details=array();
				$total=0;
				if ($producto1<>0){				
											
						$query = mysqli_query($mysqli, "SELECT p.product_description,p.price FROM test.product p									
										WHERE p.product_id=$producto1");

			          while ($valores = mysqli_fetch_array($query)) {		
			          $total= $cantidad1*$valores['price'];        				          
				array_push($order_Details, array('product_id'=>$producto1,'product_description'=>$valores['product_description'],'price'=>$valores['price'],'quantity'=>$cantidad1));            
			          
					}
					
				}
				if ($producto2<>0){
					$query = mysqli_query($mysqli, "SELECT p.product_description,p.price FROM test.product p									
										WHERE p.product_id=$producto2");

			          while ($valores = mysqli_fetch_array($query)) {		
			          $total+= $cantidad2*$valores['price'];        				          
			          	array_push($order_Details, array('product_id'=>$producto2,'product_description'=>$valores['product_description'],'price'=>$valores['price'],'quantity'=>$cantidad2));            
			          
					}
				}
				if ($producto3<>0){
					$query = mysqli_query($mysqli, "SELECT p.product_description,p.price FROM test.product p									
										WHERE p.product_id=$producto3");

			          while ($valores = mysqli_fetch_array($query)) {		
			          $total+= $cantidad3*$valores['price'];        				          
			          	array_push($order_Details, array('product_id'=>$producto3,'product_description'=>$valores['product_description'],'price'=>$valores['price'],'quantity'=>$cantidad3));            
			          
					}
				}
				if ($producto4<>0){
					$query = mysqli_query($mysqli, "SELECT p.product_description,p.price FROM test.product p									
										WHERE p.product_id=$producto4");

			          while ($valores = mysqli_fetch_array($query)) {		
			          $total+= $cantidad4*$valores['price'];        				          
			          	array_push($order_Details, array('product_id'=>$producto4,'product_description'=>$valores['product_description'],'price'=>$valores['price'],'quantity'=>$cantidad4));            			          	   
					}
				}
				if ($producto5<>0){
					$query = mysqli_query($mysqli, "SELECT p.product_description,p.price FROM test.product p									
										WHERE p.product_id=$producto5");

			          while ($valores = mysqli_fetch_array($query)) {		
			          $total+= $cantidad5*$valores['price'];        				          
			          	array_push($order_Details, array('product_id'=>$producto5,'product_description'=>$valores['product_description'],'price'=>$valores['price'],'quantity'=>$cantidad5));            			          			          
					}
				}

				 $form_data = array(
			   'customer_id' =>$customer_id,
			   'delivery_address'  => $delivery_address,
			   'total' =>$total,
			   'order_Details'  =>$order_Details

			  );
				 
				   $form_data = json_encode($form_data);
				//echo $form_data;
			  $api_url = "http://localhost:8000/prueba_beitech/create_one.php";

			   $client = curl_init($api_url);
			  curl_setopt($client, CURLOPT_POST, true);
			  curl_setopt($client, CURLOPT_POSTFIELDS, json_encode($form_data ));
			  curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
			   $response = curl_exec($client);

			   $respuesta=json_decode($response);
//var_dump($respuesta);

			   /*
			   if ($respuesta->message=="Order was created."){
			   		echo "<label style='color:green;font-size:20px;'>Factura registrada con exito</label>'";
			   }*/
			   
			  curl_close($client);
			   $result = json_decode($response, true);		

		}
	}
	
?>
<?php
						
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
    	  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

		<script type="text/javascript">

			function cargar_productos_inicial(){

				$("#customer_id").ready(function(){
				

				$("#customer_id option:selected").each(function(){	
				var elegido=$(this).val();
				$.post("productos.php",{elegido:elegido},function(data){
				$("#producto1").html(data);
				$("#producto2").html(data);
				$("#producto3").html(data);
				$("#producto4").html(data);
				$("#producto5").html(data);
								});	
							})	
	
					});
			}

			$("#customer_id").ready(function(){
			$("#customer_id").change(function(){

				$("#customer_id option:selected").each(function(){
				var elegido=$(this).val();
					$.post("productos.php",{elegido:elegido},function(data){
						$("#producto1").html(data);
						$("#producto2").html(data);
						$("#producto3").html(data);
						$("#producto4").html(data);
						$("#producto5").html(data);

					});	
					})	
				});
			});		

		</script>
	</head>
	<body onload="cargar_productos_inicial()">
	<div class="container" style="padding: 3% 0 0;">
		<h1 class="page-header text-center">FACTURA</h1>
    <br/>
	</div>
    <div class="container">
	<form name="form1" method="post" action="factura.php">
    	 <div class="row">
     
     		<label>Nombre: </label>
     		<select id="customer_id" name="customer_id">
	        <?php
	          $query = mysqli_query($mysqli, "SELECT * FROM test.customer");

	          while ($valores = mysqli_fetch_array($query)) {
	          	if(isset($_POST["customer_id"]) && $_POST["customer_id"]==$valores['customer_id']){
	          		echo '<option value="'.$valores['customer_id'].'" selected>'.$valores['name'].'</option>';	          		
	          	}else{
	          		echo '<option value="'.$valores['customer_id'].'">'.$valores['name'].'</option>';
	          	}
	            
	          }
	        ?>
	      </select>			
     	</div>
     	 <br>
    	  <br>
	    <div class="row">
	      	<label>Direccion</label>

			<input type="text" id="delivery_address" name="delivery_address" required
			       minlength="4" maxlength="150" size="50">
		</div>	  
	    <br>
	    <br>
    	<div class="col-sm-12">
			<table class="table table-bordered table-striped table-responsive-sm">
				<thead>
					<tr bgcolor="#b9c9fe" style="color: #039">			            
			            <th>Products</th>
			             <th>Cantidad</th>
					</tr>
				</thead>
				<tbody id="cuerpoTabla">
					<tr>
						<td>
						<select id="producto1" name="producto1">
							<option value="0">Seleccione:</option>
						</select>
						</td>
						<td>
							<input type="text" name="cantidad1">
						</td>
				</tr>
				<tr>
					<td>
					<select id="producto2" name="producto2">
						<option value="0">Seleccione:</option>				   
					</select>
					</td>
					<td>
						<input type="text" name="cantidad2">
					</td>
				</tr>
				<tr>
					<td>
					<select id="producto3" name="producto3">
						<option value="0">Seleccione:</option>				    
					</select>
					</td>
					<td>
						<input type="text" name="cantidad3">
					</td>
				</tr>
				<tr>
					<td>
					<select id="producto4" name="producto4">
						<option value="0">Seleccione:</option>				    
					</select>
					</td>
					<td>
						<input type="text" name="cantidad4">
					</td>
				</tr>
				<tr>
					<td>
					<select id="producto5" name="producto5">
						<option value="0">Seleccione:</option>				    
					</select>
					</td>
					<td>
						<input type="text" name="cantidad5">
					</td>
				</tr>		
				</tbody>
			</table>			
		</div>
		<br>
		<br>
		<div class="col-sm-12" align="center">
			<input type="submit" name="Submit" value="Guardar">	
		</div>	
	</form>	  
	</div>
	
	</body>
</html>