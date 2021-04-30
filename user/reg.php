<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Origin, Content-Type, Access-Control-Allow-Headers, X-Auth-Token, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
if(
    !empty($_POST['username']) &&
    !empty($_POST['email']) &&
    !empty($_POST['password']) &&
    !empty($_POST['confirm_password'])
){
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->password = trim($_POST['password']);
    $user->role = 'customer';
    if (trim($_POST['password']) == trim($_POST['confirm_password'])){
        if($user->register()) {
            http_response_code(201);
            echo json_encode(array("message" => "Customer created."));
        } else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create customer."));
        }
    } else{
        http_response_code(400);
        echo json_encode(array("message" => "Both password does not match."));
    }
} else{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create customer. Data is incomplete."));
}
?>