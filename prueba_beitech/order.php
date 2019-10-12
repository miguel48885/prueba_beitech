<?php

class Order{
 
    // database connection and table name
    private $conn;
 
    // object properties
    public $order_id;
    public $customer_id;
    public $delivery_address;
    public $total;
    
    public $order_detail_id;
    public $product_id;
    public $product_description;
    public $price;
    public $quantity;  
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function readOrders(){
 
    // query to read single record
        $fecha_actual = date("Y-m-d");
        $fecha_inicio= date("Y-m-d",strtotime($fecha_actual."- 1 month")); 

         $query="SELECT o.creation_date,o.order_id,o.total,o.delivery_address FROM test.order o
                WHERE o.customer_id=".$this->customer_id." AND o.creation_date>'$fecha_inicio' AND o.creation_date<='$fecha_actual' ORDER BY o.creation_date,o.order_id";              
 
    // prepare query statement
            $stmt = $this->conn->prepare( $query );
 
            $stmt->execute();
            return $stmt;
    }


    function readOrderDetails($order_id){
 
    // query to read single record

        $query="SELECT od.product_description,od.quantity FROM test.order_detail od 
            WHERE od.order_id=$order_id";        
 
    // prepare query statement
    $stmt2 = $this->conn->prepare( $query );
 
    // execute query
    $stmt2->execute();

    return $stmt2;
 
    }

    function createOrder(){
     
        // query to insert record

         $fecha_actual = date("Y-m-d");
        
        $query="INSERT into test.order (customer_id, creation_date,delivery_address,total) values (" . $this->customer_id.",'$fecha_actual','". $this->delivery_address ."',". $this->total .")";
     echo $query;
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // execute query
        
        if($stmt->execute()){
          
            return true;

        }
     
        return false;
         
    }


    function createrOrderDetails($i){
     
        // query to insert record

        $query="INSERT into test.order_detail (order_id,product_id,product_description,price,quantity) values";
                //$id=$this->ultimaOrder();
        
            $queryaux="(".$this->order_id.",". $this->order_Details[$i]->product_id.",'". $this->order_Details[$i]->product_description."',". $this->order_Details[$i]->price.",". $this->order_Details[$i]->quantity .")";

         $query.=$queryaux;

        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }

     function ultimaOrder(){
     
     
        $query="SELECT MAX(order_id) AS id FROM test.order";
        
     

        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->order_id=$row ['id'];
       
         
        }
    }
?>