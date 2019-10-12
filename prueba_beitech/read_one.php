<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once 'database.php';
include_once 'order.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare Order object
$order = new Order($db);
 
// set ID property of record to read
$order->customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die();

 
// read the orders of customer
$stmt = $order->readOrders();
$num = $stmt->rowCount();


if($num>0){
 
    // orders array
    $orders_arr=array();
   
 
    // retrieve our table contents

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $orders_item=array(
            "creation_date" => $creation_date,
            "order_id" => $order_id,
             "total" => $total,
             "delivery_address"=>$delivery_address,
            "OrderDetails" => arrayDetalle($order_id,$order),
             );        
        array_push($orders_arr, $orders_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show orders data in json format

    echo json_encode($orders_arr);
}
else{
 
    // set response code - 404 Not found
    //http_response_code(404);
 
    // tell the user no orders found
   // echo json_encode(array("message" => "No orders found."));
}

	function arrayDetalle($order_id,$order){
		 $stmt2=$order->readOrderDetails($order_id);
		$num2 = $stmt2->rowCount();

		if($num2>0){
		 
		    // orders array
	
		    $orderDetails_arr=array();
		 
		    // retrieve our table contents
		    
		    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
		        // extract row
		        // this will make $row['name'] to
		        // just $name only
		        extract($row2);
		 
		        $orderDetails_item=array(       
		            "product_description" =>$product_description,
		            "quantity" => $quantity,           
		        );
		 
		        
		        array_push($orderDetails_arr, $orderDetails_item);
		    }
		 
		    // set response code - 200 OK
		    http_response_code(200);
		 	   
	    return $orderDetails_arr;
	}

}
?>