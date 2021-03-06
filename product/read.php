<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$stmt = $product->read();
$num = $stmt->rowCount();
if($num>0){
    $products_arr= [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $product_item=[
            "id" => $id,
            "sku" => $sku,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => $price,
            "image"=> $image,
            "category" => $category,
        ];
        array_push($products_arr, $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
}
else{
    http_response_code(404);
    echo json_encode(
        ["message" => "No products found."]
    );
}