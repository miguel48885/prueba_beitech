<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once 'database.php';
 
// instantiate order object
include_once 'order.php';

$database = new Database();
$db = $database->getConnection();

// create the order
$order = new Order($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
//$data=json_decode($data);
// make sure data is not empty
if(
    !empty($data->customer_id) &&
    !empty($data->delivery_address) &&
    !empty($data->total) &&    
    !empty($data->order_Details) ){

    // set order property values
    $order->customer_id = $data->customer_id;
    $order->delivery_address = $data->delivery_address;
    $order->total = $data->total;
    $order->order_Details = $data->order_Details;
        
    $tamano=count($order->order_Details);
     
    if($order->createOrder()){
       
        $order->ultimaOrder();

        for ($i=0;$i<$tamano;$i++){                        
            $order->createrOrderDetails($i);
        }

        http_response_code(201);

         // tell the user
        echo json_encode(array("message" => "Order was created."));
    }
    // if unable to create the order, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Order."));      
        }      
}
    // tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Order. Data is incomplete."));
}
?>