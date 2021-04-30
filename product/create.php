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
if(
    !empty($_POST['name']) &&
    !empty($_POST['price']) &&
    !empty($_POST['description']) &&
    !empty($_POST['category'])
){
    $product->name = $_POST['name'];
    $product->sku = date('mdyhis').uniqid();
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category = $_POST['category'];
    $product->created = date('Y-m-d H:i:s');
    if(isset($_FILES['image'])){
        $file_name = date('dmyhis').uniqid().'.'.strtolower(end(explode('.',$_FILES['image']['name'])));
        move_uploaded_file($_FILES['image']['tmp_name'], getcwd().DIRECTORY_SEPARATOR.$file_name);
        $product->image = $file_name;
    }
    if($product->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Product created."));
    } else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create product."));
    }
} else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>