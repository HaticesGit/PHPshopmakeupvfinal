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

    public function save(){
        $conn = Db::getConnection();
        $statement = $conn->prepare('INSERT INTO products (title, price, img, descr, stock, variation) VALUES (:title , :price, :img, :descr, :stock, :variation)');
        $statement->bindValue(":title", $this->title);
        $statement->bindValue(":price", $this->price);
        $statement->bindValue(":img", $this->img);
        $statement->bindValue(":descr", $this->description);
        $statement->bindValue(":stock", $this->stock);
        $statement->bindValue(":variation", $this->variation);
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
        $conn = Db::getConnection();
        $statement = $conn->query('SELECT * FROM products');
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }
}