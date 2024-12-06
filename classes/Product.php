<?php
namespace Hatice\makeupshop;
use Hatice\makeupshop\Db;
use Hatice\makeupshop\Product;
//var_dump(class_exists('Hatice\makeupshop\Db'));
// include_once(__DIR__ . "./Db.php"); 
class Product{
    private $id;
    private $title;
    private $price;
    private $img;
    private $description;
    private $stock;
    private $variation;
    private $category_id;


    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        if(empty($title)){
            throw new Exception("title cannot be empty");
        }
        $this->title = $title;

        return $this;
    }

    

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        if(empty($price)){
            throw new Exception("price cannot be empty");
        }
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of img
     */ 
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */ 
    public function setImg($img)
    {
        if(empty($img)){
            throw new Exception("image cannot be empty");
        }
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        if(empty($description)){
            throw new Exception("description cannot be empty");
        }
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of stock
     */ 
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */ 
    public function setStock($stock)
    {
        if(empty($stock)){
            throw new Exception("stock cannot be empty");
        }
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of variation
     */ 
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * Set the value of variation
     *
     * @return  self
     */ 
    public function setVariation($variation)
    {
        if(empty($variation)){
            throw new Exception("variaton cannot be empty");
        }
        $this->variation = $variation;

        return $this;
    }
    /**
     * Get the value of category_id
     */ 
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function save(){
        $conn = Db::getConnection();
        $statement = $conn->prepare('INSERT INTO products (title, price, img, descr, stock, variation, category_id) VALUES (:title , :price, :img, :descr, :stock, :variation, :category_id)');
        $statement->bindValue(":title", $this->title);
        $statement->bindValue(":price", $this->price);
        $statement->bindValue(":img", $this->img);
        $statement->bindValue(":descr", $this->description);
        $statement->bindValue(":stock", $this->stock);
        $statement->bindValue(":variation", $this->variation);
        $statement->bindValue(":category_id", $this->category_id);
        $result = $statement->execute();
        $successMessage = true;

        if ($result) {
            echo "yippee";
        } else {
            echo "o no";
        }

        return $result;

    }

    public static function getAll(){ //new
        try {
            //$conn = Db::getConnection();
            $pdo = new \PDO('mysql:host=localhost;dbname=makeupshop', 'root', 'root');
            $statement = $pdo->query('SELECT * FROM products');
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function getProductsByCategory($category_id) {
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=makeupshop', 'root', 'root');
            $statement = $pdo->prepare('SELECT * FROM products WHERE category_id = :category_id');
            $statement->bindParam(':category_id', $category_id);
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

        
    }
    public function getNewProducts() {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT * FROM products ORDER BY dateAdded DESC LIMIT 10");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function search($search) {
        $conn = Db::getConnection();
        $query = $conn->prepare("SELECT * FROM products WHERE title LIKE :search OR descr LIKE :search");
        $query->bindValue(":search", "%$search%");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function addToCart($userId, $productId) {
        $conn = Db::getConnection();
    
        // Step 1: Check if there's an existing cart (status = 0)
        $query = $conn->prepare("SELECT id FROM orders WHERE user_id = :user_id AND status = 0");
        $query->bindValue(":user_id", $userId);
        $query->execute();
        $cart = $query->fetch(\PDO::FETCH_ASSOC);
    
        if (empty($cart)) {
            $query = $conn->prepare("INSERT INTO orders (user_id, moment, address, status) VALUES (:user, NOW(), 'TBD', '0')");
            $query->bindValue(":user", $userId);
            $query->execute();
        } 
    
        // Step 3: Add the product to the `orders_products` table
        $query = $conn->prepare("INSERT INTO orders_products (orders_id, products_id) VALUES ((SELECT ID FROM orders WHERE user_id = :user AND status = 0 LIMIT 1), :products_id)");
        $query->bindValue(":user", $userId);
        $query->bindValue(":products_id", $productId);
        $query->execute();
    
        // Step 4: Get the product price and update the cart's total price
        $query = $conn->prepare("SELECT price FROM products WHERE id = :product_id");
        $query->bindValue(":product_id", $productId);
        $query->execute();
        $product = $query->fetch(\PDO::FETCH_ASSOC);

        $query = $conn->prepare("UPDATE orders SET fullPrice = fullPrice + :price WHERE user_id = :user_id AND status = 0");
        $query->bindValue(":price", $product['price']);
        $query->bindValue(":user_id", $userId);
        $query->execute();
    }
    
}