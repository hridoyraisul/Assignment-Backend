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
$order->customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die();
$stmt = $order->customersOrder();
$num = $stmt->rowCount();
if($num>0){
    $orders_arr= [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $items=[
            "id" =>  $id,
            "product_id" => $id,
            "price" => $price,
            "total_price" => $price*$quantity,
            "quantity" => $quantity,
            "customer_id"=> $customer_id,
            "status"=> $status,
        ];
        array_push($orders_arr, $items);
    }
    http_response_code(200);
    echo json_encode($orders_arr);
} else{
    http_response_code(404);
    echo json_encode(
        ["message" => "No products found."]
    );
}
?>