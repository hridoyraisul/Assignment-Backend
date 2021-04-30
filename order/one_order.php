<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/order.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$order->id = isset($_GET['id']) ? $_GET['id'] : die();
$order->readOneOrder();
if($order->status!=null){
    $product = new Product($db);
    $product->id = $order->product_id;
    $product->readOne();
    if($product->name!=null){
        $order_arr = [
            "id" =>  $order->id,
            "product_id" => $order->product_id,
            "price" => $order->price,
            "total_price" => $order->price*$order->quantity,
            "quantity" => $order->quantity,
            "customer_id"=> $order->customer_id,
            "status"=> $order->status,
            "product_name" => $product->name,
            "description" => $product->description,
            "category" => $product->category,
            "image" => $product->image,
        ];
        http_response_code(200);
        echo json_encode($order_arr);
    }
} else{
    http_response_code(404);
    echo json_encode(array("message" => "Product does not exist."));
}
?>