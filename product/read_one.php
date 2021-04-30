<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
$product->readOne();
if($product->name!=null){
    $product_arr = [
        "id" =>  $product->id,
        "sku" => $product->sku,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "category" => $product->category,
        "image" => $product->image,
    ];
    http_response_code(200);
    echo json_encode($product_arr);
} else{
    http_response_code(404);
    echo json_encode(array("message" => "Product does not exist."));
}
?>