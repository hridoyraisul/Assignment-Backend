<?php
class Product{

    private $conn;
    private $table_name = "products";
    public $id;
    public $sku;
    public $name;
    public $description;
    public $price;
    public $image;
    public $category;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }
    function read(){
        $query = "SELECT * FROM ". $this->table_name ." ORDER BY `id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function create(){
        $query = "INSERT
                " . $this->table_name . "
            SET
                name = :name,
                sku = :sku,
                image = :image,
                price = :price,
                description = :description,
                category = :category,
                created = :created ";

        $stmt = $this->conn->prepare($query);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category=htmlspecialchars(strip_tags($this->category));

        $stmt->bindParam(":sku", $this->sku);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":created", $this->created);
        if($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }
    function readOne(){
        $query = "SELECT * FROM ". $this->table_name ." WHERE `id` = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->sku = $row['sku'];
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category = $row['category'];
        $this->image = $row['image'];
    }
    function update(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category = :category
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if($stmt->execute()){
            return true;
        } else{
            return false;
        }
    }
}
?>