<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

if($product->delete()){
    $file_pointer = fopen(getcwd().DIRECTORY_SEPARATOR.$product->image, 'w+');
    unlink($file_pointer);
    http_response_code(200);
    echo json_encode(array("message" => "Product deleted."));
} else{
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete product."));
}
?>