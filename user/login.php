<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->email = isset($_POST['email']) ? $_POST['email'] : die();
$user->loginUser();
if($user->username!=null){
    if ($user->password == trim($_POST['password'])){
        $user_arr = [
            "id" =>  $user->id,
            "username" => $user->username,
            "email" => $user->email,
            "role" => $user->role,
            "token" => md5(rand()),
        ];
        http_response_code(200);
        echo json_encode($user_arr);
    } else{
        http_response_code(404);
        echo json_encode(array("message" => "User's password is not correct."));
    }
} else{
    http_response_code(404);
    echo json_encode(array("message" => "User does not exist."));
}
?>