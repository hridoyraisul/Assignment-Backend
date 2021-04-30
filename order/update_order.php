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
$order->id = isset($_GET['id']) ? $_GET['id'] : die();
$order->status = $_POST['status'];
if($order->updateOrder()){
    http_response_code(201);
    echo json_encode(array("message" => "Order Status updated."));
} else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update order status."));
}
?>