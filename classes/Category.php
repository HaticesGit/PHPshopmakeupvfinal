<?php
namespace Hatice\makeupshop;

class Category {
    private $type;
    private $product_id;


    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }
    public function addCategory($type) {
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=makeupshop', 'root', 'root');
            $statement = $pdo->prepare('INSERT INTO category (type) VALUES (:type)');
            $statement->bindValue(":type", $this->type);
            $statement->execute();
            return $statement;
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}