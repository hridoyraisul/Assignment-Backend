<?php
class User{
    private $conn;
    private $table_name = "users";
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($db){
        $this->conn = $db;
    }

    function loginUser(){
        $query = "SELECT * FROM ". $this->table_name ." WHERE `email` = ? ";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->role = $row['role'];
    }
    function register(){
        $query = "INSERT
                " . $this->table_name . "
            SET
                username = :username,
                email = :email,
                password = :password,
                role = :role";

        $stmt = $this->conn->prepare($query);
        $this->username=htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);
        if($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }
}