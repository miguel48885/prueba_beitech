<?php
include_once("config.php");
$elegido = $_POST['elegido'];
if (isset($elegido)){
	$query = mysqli_query($mysqli, "SELECT p.product_id,p.product_description,p.price FROM test.product p
										INNER JOIN test.customer_product c ON (p.product_id=c.product_id)
										WHERE c.customer_id=$elegido");
echo '<option value="0">Seleccione:</option>';
	while ($valores = mysqli_fetch_array($query)) {			          				          
			          	echo '<option value="'.$valores['product_id'].'">'.$valores['product_description'].'</option>';	            
			          }
}

?>