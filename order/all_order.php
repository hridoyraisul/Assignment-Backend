<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../objects/order.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$porder = new Order($db);
$stmt = $porder->readAllOrder();
$num = $stmt->rowCount();
if($num>0){
    $orders_arr= [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product = new Product($db);
        $product->id = $product_id;
        $product->readOne();
        $customer = new User($db);
        $customer->id = $customer_id;
        $customer->customerInfo();
        if($product->name!=null){
            $items = [
                "id" =>  $id,
                "product_id" => $product_id,
                "price" => $price,
                "total_price" => $price*$quantity,
                "quantity" => $quantity,
                "customer_id"=> $customer_id,
                "customer_name" => $customer->username,
                "status"=> $status,
                "product_name" => $product->name,
                "description" => $product->description,
                "category" => $product->category,
                "image" => $product->image,
            ];
        }
        array_push($orders_arr, $items);
    }
    http_response_code(200);
    echo json_encode($orders_arr);
}
else{
    http_response_code(404);
    echo json_encode(
        ["message" => "No products found."]
    );
}