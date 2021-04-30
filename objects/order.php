<?php
class Order{
    private $conn;
    private $table_name = "orders";
    public $id;
    public $product_id;
    public $price;
    public $quantity;
    public $customer_id;
    public $status;

    public function __construct($db){
        $this->conn = $db;
    }

    function createOrder(){
        $query = "INSERT
                " . $this->table_name . "
            SET
                product_id = :product_id,
                quantity = :quantity,
                price = :price,
                customer_id = :customer_id,
                status = :status";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":status", $this->status);
        if($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }
    function updateOrder(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                status = :status
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }
    function readOneOrder(){
        $query = "SELECT * FROM ". $this->table_name ." WHERE `id` = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->product_id = $row['product_id'];
        $this->price = $row['price'];
        $this->quantity = $row['quantity'];
        $this->customer_id = $row['customer_id'];
        $this->status = $row['status'];
    }
    function customersOrder(){
        $query = "SELECT * FROM ". $this->table_name ." WHERE `customer_id` = ?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->customer_id);
        $stmt->execute();
        return $stmt;
    }
    function readAllOrder(){
        $query = "SELECT * FROM ". $this->table_name ." ORDER BY `id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}