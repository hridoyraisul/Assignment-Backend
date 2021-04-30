<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
if(
    !empty($_POST['product_id']) &&
    !empty($_POST['price']) &&
    !empty($_POST['quantity']) &&
    !empty($_POST['customer_id'])
){
    $order->product_id = $_POST['product_id'];
    $order->price = $_POST['price'];
    $order->quantity = $_POST['quantity'];
    $order->customer_id = $_POST['customer_id'];
    $order->status = 'Processing';
    if($order->createOrder()) {
        http_response_code(201);
        echo json_encode(array("message" => "Order added."));
    } else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create order."));
    }
} else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create order. Data is incomplete."));
}
?>