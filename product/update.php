<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
$product->name = $_POST['name'];
$product->price = $_POST['price'];
$product->description = $_POST['description'];
$product->category = $_POST['category'];

if($product->update()){
    http_response_code(201);
    echo json_encode(array("message" => "Product updated."));
} else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update product."));
}
?>